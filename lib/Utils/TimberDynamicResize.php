<?php

namespace Flynt\Utils;

use Twig\TwigFilter;
use Timber\ImageHelper;
use Timber\Image\Operation\Resize;
use Timber\URLHelper;
use WP;
use WP_Rewrite;

/**
 * Provides a set of methods that are used to dynamically resize images inside Twig files.
 */
class TimberDynamicResize
{
    private const DB_VERSION = '2.0';
    private const TABLE_NAME = 'resized_images';
    private const IMAGE_QUERY_VAR = 'resized-images';
    private const IMAGE_PATH_SEPARATOR = 'resized';

    /**
     * The internal list (array) of resized images.
     *
     * @var array
     */
    public $flyntResizedImages = [];

    /**
     * The internal value of the dynamic image generation setting.
     *
     * @var boolean
     */
    protected $enabled = false;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->enabled = get_field('field_global_TimberDynamicResize_dynamicImageGeneration', 'option');
        if ($this->enabled) {
            $this->createTable();
            $this->addDynamicHooks();
        }
        $this->addHooks();
    }

    /**
     * Create database table for resized images.
     *
     * @return void
     */
    protected function createTable()
    {
        $optionName = static::TABLE_NAME . '_db_version';

        $installedVersion = get_option($optionName);

        if ($installedVersion !== static::DB_VERSION) {
            global $wpdb;
            $tableName = self::getTableName();

            $charsetCollate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $tableName (
                width int(11) NOT NULL,
                height int(11) NOT NULL,
                crop varchar(32) NOT NULL
            ) $charsetCollate;";

            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);

            if (version_compare($installedVersion, '2.0', '<=')) {
                $wpdb->query("ALTER TABLE {$tableName} ADD PRIMARY KEY(`width`, `height`, `crop`);");
            }

            update_option($optionName, static::DB_VERSION);
        }
    }

    /**
     * Add dynamic hooks.
     *
     * @return void
     */
    protected function addDynamicHooks()
    {
        add_action('init', [$this, 'addRewriteTag']);
        add_action('generate_rewrite_rules', [$this, 'registerRewriteRule']);
        add_action('parse_request', [$this, 'parseRequest']);
    }

    /**
     * Parse the request.
     *
     * @param WP $wp Current WordPress environment instance (passed by reference).
     *
     * @return void
     */
    public function parseRequest(WP $wp)
    {
        if (isset($wp->query_vars[static::IMAGE_QUERY_VAR])) {
            $this->checkAndGenerateImage($wp->query_vars[static::IMAGE_QUERY_VAR]);
        }
    }

    /**
     * Add Hooks.
     *
     * @return void
     */
    protected function addHooks()
    {
        add_action('timber/twig', function ($twig) {
            $twig->addFilter(
                new TwigFilter('resizeDynamic', [$this, 'resizeDynamic'])
            );
            return $twig;
        });
        if ($this->enabled) {
            add_action('after_switch_theme', function () {
                add_action('shutdown', 'flush_rewrite_rules');
            });
            add_action('switch_theme', function () {
                flush_rewrite_rules(true);
            });
        }
    }

    /**
     * Get the table name.
     *
     * @return string
     */
    public function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . static::TABLE_NAME;
    }

    /**
     * Get default relative upload dir.
     *
     * @return string
     */
    public static function getDefaultRelativeUploadDir()
    {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploadDir = wp_upload_dir();
        $homePath = get_home_path();
        if (!empty($homePath) && $homePath !== '/') {
            $baseDir = str_replace('\\', '/', $uploadDir['basedir']);
            $relativeUploadDir = str_replace($homePath, '', $baseDir);
        } else {
            $relativeUploadDir = $uploadDir['relative'];
        }
        return $relativeUploadDir;
    }

    /**
     * Get relative upload dir.
     *
     * @return string
     */
    public function getRelativeUploadDir()
    {
        $relativeUploadPath = get_field('field_global_TimberDynamicResize_relativeUploadPath', 'option');
        if (empty($relativeUploadPath)) {
            return static::getDefaultRelativeUploadDir();
        } else {
            return $relativeUploadPath;
        }
    }

    /**
     * Get uploads baseurl.
     *
     * @return string
     */
    public function getUploadsBaseurl()
    {
        $uploadDir = wp_upload_dir();
        return $uploadDir['baseurl'];
    }

    /**
     * Get uploads basedir.
     *
     * @return string
     */
    public function getUploadsBasedir()
    {
        $uploadDir = wp_upload_dir();
        return $uploadDir['basedir'];
    }

    /**
     * Resize an image dynamically using Timbers Resize class.
     * This function is a wrapper for the Resize class.
     *
     * @param string|null $src The image source.
     * @param float $w The width of the image.
     * @param float $h The height of the image.
     * @param string $crop The crop mode.
     * @param boolean $force Force the image to be generated.
     *
     * @return string|null The resized image url.
     */
    public function resizeDynamic(mixed $src, float $w, float $h = 0, string $crop = 'default', bool $force = false)
    {
        if (empty($src)) {
            return '';
        }

        $w = (int) round($w);
        $h = (int) round($h);

        if ($this->enabled) {
            $resizeOp = new Resize($w, $h, $crop);
            if (URLHelper::is_external_content($src)) {
                $src = ImageHelper::sideload_image($src);
            }
            $fileinfo = pathinfo($src);
            $resizedUrl = $resizeOp->filename(
                $fileinfo['dirname'] . '/' . $fileinfo['filename'],
                $fileinfo['extension'] ?? ''
            );

            if (empty($this->flyntResizedImages)) {
                add_action('shutdown', [$this, 'storeResizedUrls'], -1);
            }
            $this->flyntResizedImages[$w . '-' . $h . '-' . $crop] = [$w, $h, $crop];

            return $this->addImageSeparatorToUploadUrl($resizedUrl);
        } else {
            return $this->generateImage($src, $w, $h, $crop, $force);
        }
    }

    /**
     * Register rewrite rule.
     *
     * @param WP_Rewrite $wpRewrite The WordPress rewrite class.
     *
     * @return void
     */
    public function registerRewriteRule(WP_Rewrite $wpRewrite)
    {
        $routeName = static::IMAGE_QUERY_VAR;
        $relativeUploadDir = $this->getRelativeUploadDir();
        $relativeUploadDir = trailingslashit($relativeUploadDir) . static::IMAGE_PATH_SEPARATOR;
        $wpRewrite->rules = array_merge(
            ["^{$relativeUploadDir}/?(.*?)/?$" => "index.php?{$routeName}=\$matches[1]"],
            $wpRewrite->rules
        );
    }

    /**
     * Add rewrite tag.
     * This is needed to make the rewrite rule work.
     *
     * @return void
     */
    public function addRewriteTag()
    {
        $routeName = static::IMAGE_QUERY_VAR;
        add_rewrite_tag("%{$routeName}%", "([^&]+)");
    }

    /**
     * Remove rewrite tag.
     *
     * @return void
     */
    public function removeRewriteTag()
    {
        $routeName = static::IMAGE_QUERY_VAR;
        remove_rewrite_tag("%{$routeName}%");
    }

    /**
     * Check and generate image.
     *
     * @param string $relativePath The relative path to the image.
     *
     * @return void
     */
    public function checkAndGenerateImage(string $relativePath)
    {
        $matched = preg_match('/(.+)-(\d+)x(\d+)-c-(.+)(\..*)$/', $relativePath, $matchedSrc);
        $exists = false;
        if ($matched) {
            $originalRelativePath = $matchedSrc[1] . $matchedSrc[5];
            $originalPath = trailingslashit($this->getUploadsBasedir()) . $originalRelativePath;
            $originalUrl = trailingslashit($this->getUploadsBaseurl()) . $originalRelativePath;
            $exists = file_exists($originalPath);
            $w = (int) $matchedSrc[2];
            $h = (int) $matchedSrc[3];
            $crop = $matchedSrc[4];
        }

        if ($exists) {
            global $wpdb;
            $tableName = $this->getTableName();
            $resizedImage = $wpdb->get_row(
                $wpdb->prepare("SELECT * FROM {$tableName} WHERE width = %d AND height = %d AND crop = %s", [
                    $w,
                    $h,
                    $crop,
                ])
            );
        }

        if (empty($resizedImage)) {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
            nocache_headers();
            include get_404_template();
            exit();
        } else {
            $resizedUrl = $this->generateImage($originalUrl, $w, $h, $crop);

            wp_redirect($resizedUrl);
            exit();
        }
    }

    /**
     * Generate image.
     *
     * @param string $url The image url.
     * @param integer $w The width of the image.
     * @param integer $h The height of the image.
     * @param string $crop The crop mode.
     * @param boolean $force Force the image to be generated.
     *
     * @return string The resized image url.
     */
    protected function generateImage(string $url, int $w, int $h, string $crop, bool $force = false)
    {
        add_filter('timber/image/new_url', [$this, 'addImageSeparatorToUploadUrl']);
        add_filter('timber/image/new_path', [$this, 'addImageSeparatorToUploadPath']);

        $resizedUrl = ImageHelper::resize(
            $url,
            $w,
            $h,
            $crop,
            $force
        );

        remove_filter('timber/image/new_url', [$this, 'addImageSeparatorToUploadUrl']);
        remove_filter('timber/image/new_path', [$this, 'addImageSeparatorToUploadPath']);

        return $resizedUrl;
    }

    /**
     * Add image separator to upload url.
     *
     * @param string $url The url.
     *
     * @return string The url with the image separator.
     */
    public function addImageSeparatorToUploadUrl(string $url)
    {
        $baseurl = $this->getUploadsBaseurl();
        return str_replace(
            $baseurl,
            trailingslashit($baseurl) . static::IMAGE_PATH_SEPARATOR,
            $url
        );
    }

    /**
     * Add image separator to upload path.
     *
     * @param string $path The path.
     *
     * @return string The path with the image separator.
     */
    public function addImageSeparatorToUploadPath(string $path = '')
    {
        $basepath = $this->getUploadsBasedir();
        return str_replace(
            $basepath,
            trailingslashit($basepath) . static::IMAGE_PATH_SEPARATOR,
            empty($path) ? $basepath : $path
        );
    }

    /**
     *  Store resized urls.
     *
     * @return void
     */
    public function storeResizedUrls()
    {
        global $wpdb;
        $tableName = $this->getTableName();
        $values = array_values($this->flyntResizedImages);
        $placeholders = array_fill(0, count($values), '(%d, %d, %s)');
        $placeholdersString = implode(', ', $placeholders);
        $wpdb->query(
            $wpdb->prepare(
                "INSERT IGNORE INTO {$tableName} (width, height, crop) VALUES {$placeholdersString}",
                call_user_func_array('array_merge', $values)
            )
        );
    }

    /**
     * Toggle dynamic image generation.
     *
     * @param boolean $enable Enable or disable dynamic image generation.
     *
     * @return void
     */
    public function toggleDynamic(bool $enable)
    {
        if ($enable) {
            $this->addRewriteTag();
            add_action('generate_rewrite_rules', [$this, 'registerRewriteRule']);
            add_action('parse_request', [$this, 'parseRequest']);
        } else {
            $this->removeRewriteTag();
            remove_action('generate_rewrite_rules', [$this, 'registerRewriteRule']);
            remove_action('parse_request', [$this, 'parseRequest']);
        }
        add_action('shutdown', function () {
            flush_rewrite_rules(false);
        });
    }

    /**
     * Change relative upload path.
     *
     * @param string $relativeUploadPath The relative upload path.
     *
     * @return void
     */
    public function changeRelativeUploadPath(string $relativeUploadPath)
    {
        add_action('shutdown', function () {
            flush_rewrite_rules(false);
        });
    }
}
