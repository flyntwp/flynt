<?php

namespace Flynt\Utils;

use Twig\TwigFilter;
use Timber\ImageHelper;
use Timber\Image\Operation\Resize;

class TimberDynamicResize
{
    const DB_VERSION = '2.0';
    const TABLE_NAME = 'resized_images';
    const IMAGE_QUERY_VAR = 'dynamic-images';
    const IMAGE_PATH_SEPARATOR = 'dynamic';

    public $flyntResizedImages = [];

    public function __construct()
    {
        $this->createTable();
        $this->addHooks();
    }

    private function createTable()
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

    private function addHooks()
    {
        add_filter('init', [$this, 'addRewriteTag']);
        add_action('generate_rewrite_rules', [$this, 'registerRewriteRule']);
        add_action('parse_request', function ($wp) {
            if (isset($wp->query_vars[static::IMAGE_QUERY_VAR])) {
                $this->generateImage($wp->query_vars[static::IMAGE_QUERY_VAR]);
            }
        });
        if (!apply_filters('Flynt/TimberDynamicResize/disableHtaccess', false)) {
            add_filter('mod_rewrite_rules', [$this, 'addRewriteRule']);
        }

        add_action('after_switch_theme', function () {
            add_action('shutdown', 'flush_rewrite_rules');
        });
        add_action('switch_theme', function () {
            remove_filter('mod_rewrite_rules', [$this, 'addRewriteRule']);
            flush_rewrite_rules();
        });
        add_action('timber/twig/filters', function ($twig) {
            $twig->addFilter(
                new TwigFilter('resizeDynamic', [$this, 'resizeDynamic'])
            );
            return $twig;
        });
    }

    public function getTableName()
    {
        global $wpdb;
        return $wpdb->prefix . static::TABLE_NAME;
    }

    public function getRelativeUploadDir()
    {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploadDir = wp_upload_dir();
        $homePath = get_home_path();
        if (!empty($homePath) && $homePath !== '/') {
            $relativeUploadDir = str_replace($homePath, '', $uploadDir['basedir']);
        } else {
            $relativeUploadDir = $uploadDir['relative'];
        }
        return apply_filters('Flynt/TimberDynamicResize/relativeUploadDir', $relativeUploadDir);
    }

    public function getUploadsBaseurl()
    {
        $uploadDir = wp_upload_dir();
        return $uploadDir['baseurl'];
    }

    public function getUploadsBasedir()
    {
        $uploadDir = wp_upload_dir();
        return $uploadDir['basedir'];
    }

    public function resizeDynamic(
        $src,
        $w,
        $h = 0,
        $crop = 'default',
        $force = false
    ) {
        $resizeOp = new Resize($w, $h, $crop);
        $fileinfo = pathinfo($src);
        $resizedUrl = $resizeOp->filename(
            $fileinfo['dirname'] . '/' . $fileinfo['filename'],
            $fileinfo['extension']
        );

        if (empty($this->flyntResizedImages)) {
            add_action('shutdown', [$this, 'storeResizedUrls'], -1);
        }
        $this->flyntResizedImages[$w . '-' . $h . '-' . $crop] = [$w, $h, $crop];

        return $this->addImageSeparatorToUploadUrl($resizedUrl);
    }

    public function registerRewriteRule($wpRewrite)
    {
        $routeName = static::IMAGE_QUERY_VAR;
        $relativeUploadDir = $this->getRelativeUploadDir();
        $relativeUploadDir = trailingslashit($relativeUploadDir) . static::IMAGE_PATH_SEPARATOR;
        $wpRewrite->rules = array_merge(
            ["^{$relativeUploadDir}/?(.*?)/?$" => "index.php?{$routeName}=\$matches[1]"],
            $wpRewrite->rules
        );
    }

    public function addRewriteTag()
    {
        $routeName = static::IMAGE_QUERY_VAR;
        add_rewrite_tag("%{$routeName}%", "([^&]+)");
    }

    public function generateImage($relativePath)
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
            header("HTTP/1.0 404 Not Found");
            exit();
        }

        add_filter('timber/image/new_url', [$this, 'addImageSeparatorToUploadUrl']);
        add_filter('timber/image/new_path', [$this, 'addImageSeparatorToUploadPath']);

        $resizedUrl = ImageHelper::resize(
            $originalUrl,
            $w,
            $h,
            $crop,
            false
        );

        remove_filter('timber/image/new_url', [$this, 'addImageSeparatorToUploadUrl']);
        remove_filter('timber/image/new_path', [$this, 'addImageSeparatorToUploadPath']);

        if (!apply_filters('Flynt/TimberDynamicResize/disableWebP', false)) {
            ImageHelper::img_to_webp($resizedUrl);
        }

        header("Location: {$resizedUrl}", true, 302);
        exit();
    }

    public function addImageSeparatorToUploadUrl($url)
    {
        $baseurl = $this->getUploadsBaseurl();
        return str_replace(
            $baseurl,
            trailingslashit($baseurl) . static::IMAGE_PATH_SEPARATOR,
            $url
        );
    }

    public function addImageSeparatorToUploadPath($path)
    {
        $basepath = $this->getUploadsBasedir();
        return str_replace(
            $basepath,
            trailingslashit($basepath) . static::IMAGE_PATH_SEPARATOR,
            $path
        );
    }

    public function addRewriteRule($rules)
    {
        if (!apply_filters('Flynt/TimberDynamicResize/disableWebP', false)) {
            $dynamicImageRule = <<<EOD
\n# BEGIN Flynt dynamic images
<IfModule mod_setenvif.c>
# Vary: Accept for all the requests to jpeg and png
SetEnvIf Request_URI "\.(jpe?g|png)$" REQUEST_image
</IfModule>

<IfModule mod_rewrite.c>
RewriteEngine On

# Check if browser supports WebP images
RewriteCond %{HTTP_ACCEPT} image/webp

# Check if WebP replacement image exists
RewriteCond %{DOCUMENT_ROOT}/$1.webp -f

# Serve WebP image instead
RewriteRule (.+)\.(jpe?g|png)$ $1.webp [T=image/webp]
</IfModule>

<IfModule mod_headers.c>
Header append Vary Accept env=REQUEST_image
</IfModule>

<IfModule mod_mime.c>
AddType image/webp .webp
</IfModule>\n
# END Flynt dynamic images\n\n
EOD;
        } else {
            $dynamicImageRule = '';
        }
        return $dynamicImageRule . $rules;
    }

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
}
