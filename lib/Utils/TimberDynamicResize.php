<?php

namespace Flynt\Utils;

use Composer\Platform\Version;
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
    private const IMAGE_QUERY_VAR = 'resized-images';

    private const IMAGE_PATH_SEPARATOR = 'resized';

    private const VERSION = '1.0';

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
            $this->addDynamicHooks();
        }

        $this->addHooks();
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
     */
    public function parseRequest(WP $wp): void
    {
        if (isset($wp->query_vars[self::IMAGE_QUERY_VAR])) {
            $this->checkAndServeImage($wp->query_vars[self::IMAGE_QUERY_VAR]);
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
            add_action('after_switch_theme', function (): void {
                add_action('shutdown', 'flush_rewrite_rules');
            });
            add_action('switch_theme', function (): void {
                flush_rewrite_rules(true);
            });
        }
    }

    /**
     * Get default relative upload dir.
     *
     * @return string
     */
    private function getDefaultRelativeUploadDir()
    {
        require_once(ABSPATH . 'wp-admin/includes/file.php');

        $uploadDir = wp_upload_dir();
        return $uploadDir['relative'] ?? '/wp-content/uploads';
    }

    /**
     * Get relative upload dir.
     *
     * @param boolean $useDefaultUploadDir Use the default upload dir.
     *
     * @return string
     */
    public function getRelativeUploadDir(bool $useDefaultUploadDir = false)
    {
        $relativeUploadPath = $useDefaultUploadDir
            ? $this->getDefaultRelativeUploadDir()
            : get_field('field_global_TimberDynamicResize_relativeUploadPath', 'option');

        if (empty($relativeUploadPath)) {
            $relativeUploadPath = $this->getDefaultRelativeUploadDir();
        }

        return apply_filters('Flynt/TimberDynamicResize/relativeUploadDir', $relativeUploadPath);
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
    public function resizeDynamic($src, float $w, float $h = 0, string $crop = 'default', bool $force = false)
    {
        if (empty($src)) {
            return '';
        }

        $w = (int) round($w);
        $h = (int) round($h);

        if ($this->enabled) {
            if (URLHelper::is_external_content($src)) {
                $src = ImageHelper::sideload_image($src);
            }

            $resizedImageUrl = $this->getResizedImageUrl($src, $w, $h, $crop);
            $destination = ImageHelper::get_server_location($resizedImageUrl);

            if (file_exists($destination)) {
                return $resizedImageUrl;
            }

            $token = $this->generateToken($resizedImageUrl);
            return add_query_arg('ref', $token, $resizedImageUrl);
        }

        return $this->generateImage($src, $w, $h, $crop, $force);
    }

    /**
     * Generate token.
     *
     * @param string $resizedImageUrl The resized image url.
     *
     * @return string
     */
    private function generateToken(string $resizedImageUrl): string
    {
        $fullHash = hash_hmac('sha256', $resizedImageUrl, $this->getSalt());
        return substr($fullHash, 0, 16);
    }

    /**
     * Validate token.
     *
     * @param string $resizedImageUrl The resized image url.
     * @param string $token The token.
     *
     * @return boolean
     */
    private function validateToken(string $resizedImageUrl, string $token): bool
    {
        $expectedToken = $this->generateToken($resizedImageUrl);
        return hash_equals($expectedToken, $token);
    }

    /**
     * Get salt.
     *
     * @return string
     */
    private function getSalt(): string
    {
        $salt = defined('AUTH_SALT') ? AUTH_SALT : __DIR__;
        return hash('sha256', $salt . self::VERSION);
    }

    /**
     * Register rewrite rule.
     *
     * @param WP_Rewrite $wpRewrite The WordPress rewrite class.
     */
    public function registerRewriteRule(WP_Rewrite $wpRewrite): void
    {
        $routeName = self::IMAGE_QUERY_VAR;
        $relativeUploadDir = $this->getRelativeUploadDir();
        $relativeUploadDir = ltrim(untrailingslashit($relativeUploadDir), '/');
        $relativeUploadDir = trailingslashit($relativeUploadDir) . self::IMAGE_PATH_SEPARATOR;

        $wpRewrite->rules = array_merge(
            ["^{$relativeUploadDir}/?(.*?)/?$" => "index.php?{$routeName}=\$matches[1]"],
            $wpRewrite->rules
        );
    }

    /**
     * Add rewrite tag.
     * This is needed to make the rewrite rule work.
     */
    public function addRewriteTag(): void
    {
        $routeName = self::IMAGE_QUERY_VAR;
        add_rewrite_tag("%{$routeName}%", "([^&]+)");
    }

    /**
     * Remove rewrite tag.
     */
    public function removeRewriteTag(): void
    {
        $routeName = self::IMAGE_QUERY_VAR;
        remove_rewrite_tag("%{$routeName}%");
    }

    /**
     * Check and serve image.
     *
     * @param string $relativePath The relative path to the image.
     */
    public function checkAndServeImage(string $relativePath): void
    {
        $relativePath = urldecode($relativePath);

        $urlMatched = preg_match('/(.+)-(\d+)x(\d+)-c-(.+)(\..*)$/', $relativePath, $matches);
        if (!$urlMatched) {
            $this->serve404();
        }

        $originalImageRelativePath = $matches[1] . $matches[5];
        $originalImageUrl = trailingslashit($this->getUploadsBaseurl()) . $originalImageRelativePath;
        $w = (int) $matches[2];
        $h = (int) $matches[3];
        $crop = $matches[4];

        $resizedImageUrl = $this->getResizedImageUrl($originalImageUrl, $w, $h, $crop);
        $resizedImageLocation = ImageHelper::get_server_location($resizedImageUrl);

        if (file_exists($resizedImageLocation)) {
            status_header(301);
            header('Location: ' . $resizedImageUrl);
            exit();
        }

        $token = isset($_GET['ref']) ? sanitize_key($_GET['ref']) : '';
        if (!$this->validateToken($resizedImageUrl, $token)) {
            $this->serve403();
        }

        $originalImageLocation = ImageHelper::get_server_location($originalImageUrl);
        $mime = mime_content_type($originalImageLocation);
        if (false === $mime) {
            $this->serve404();
        }

        if (!in_array($mime, get_allowed_mime_types())) {
            $this->serve403();
        }

        try {
            $resizedImageUrl = $this->generateImage($originalImageUrl, $w, $h, $crop);
            header("Content-type: $mime");
            header("X-Dynamic-Resize: Image Processed; Width=$w; Height=$h; Crop=$crop");
            $destination = ImageHelper::get_server_location($resizedImageUrl);
            echo file_get_contents($destination);
            exit();
        } catch (\Exception $e) {
            status_header(500);
            error_log($e->getMessage());
            exit();
        }
    }

    /**
     * Serve 403 Forbidden.
     */
    private function serve403(): void
    {
        global $wp_query;
        $wp_query->set_404();
        status_header(403);
        nocache_headers();
        include get_404_template();
        exit();
    }

    /**
     * Serve 404 Not Found.
     */
    private function serve404(): void
    {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        include get_404_template();
        exit();
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

        $resizedImageUrl = ImageHelper::resize($url, $w, $h, $crop, $force);

        remove_filter('timber/image/new_url', [$this, 'addImageSeparatorToUploadUrl']);
        remove_filter('timber/image/new_path', [$this, 'addImageSeparatorToUploadPath']);

        return $resizedImageUrl;
    }

    /**
     * Get resized url.
     *
     * @param string $url The image url.
     * @param integer $w The width of the image.
     * @param integer $h The height of the image.
     * @param string $crop The crop mode.
     *
     * @return string The resized image url.
     */
    protected function getResizedImageUrl(string $url, int $w, int $h, string $crop): string
    {
        $resize = new Resize($w, $h, $crop);
        $fileinfo = pathinfo($url);
        $resizedImageUrl = $resize->filename(
            $fileinfo['dirname'] . '/' . $fileinfo['filename'],
            $fileinfo['extension'] ?? ''
        );

        return $this->addImageSeparatorToUploadUrl($resizedImageUrl);
    }

    /**
     * Add image separator to upload url.
     *
     * @param string $url The url.
     *
     * @return string The url with the image separator.
     */
    public function addImageSeparatorToUploadUrl(string $url): string
    {
        $baseurl = $this->getUploadsBaseurl();
        return str_replace(
            $baseurl,
            trailingslashit($baseurl) . self::IMAGE_PATH_SEPARATOR,
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
    public function addImageSeparatorToUploadPath(string $path = ''): string
    {
        $basepath = $this->getUploadsBasedir();
        return str_replace(
            $basepath,
            trailingslashit($basepath) . self::IMAGE_PATH_SEPARATOR,
            $path === '' || $path === '0' ? $basepath : $path
        );
    }

    /**
     * Toggle dynamic image generation.
     *
     * @param boolean $enable Enable or disable dynamic image generation.
     */
    public function toggleDynamic(bool $enable): void
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

        add_action('shutdown', function (): void {
            flush_rewrite_rules(false);
        });
    }

    /**
     * Change relative upload path.
     *
     */
    public function changeRelativeUploadPath(): void
    {
        add_action('shutdown', function (): void {
            flush_rewrite_rules(false);
        });
    }
}
