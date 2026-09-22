<?php

namespace Flynt\Utils;

use Twig\TwigFilter;
use Timber\Timber;
use Timber\ImageHelper;
use Timber\Image\Operation\Resize;
use Timber\URLHelper;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Provides a set of methods that are used to dynamically resize images inside Twig files.
 */
class TimberDynamicResize
{
    public const RESIZED_DIR_NAME = 'resized';

    public const TOKEN_QUERY_VAR = 'resizeDynamicToken';

    private const SOURCE_QUERY_VAR = 'src';

    private const WIDTH_QUERY_VAR = 'w';

    private const HEIGHT_QUERY_VAR = 'h';

    private const CROP_QUERY_VAR = 'crop';

    public const REST_NAMESPACE = 'flynt/v1';

    public const REST_ROUTE = '/timber-dynamic-resize/generate';

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
    protected function addDynamicHooks(): void
    {
        add_action('rest_api_init', [$this, 'registerRestRoute']);
    }

    /**
     * Register the public, signed image generation endpoint.
     */
    public function registerRestRoute(): void
    {
        register_rest_route(self::REST_NAMESPACE, self::REST_ROUTE, [
            'methods' => 'GET',
            'callback' => [$this, 'handleResizeRequest'],
            'permission_callback' => '__return_true',
            'args' => [
                'path' => [
                    'required' => true,
                    'type' => 'string',
                ],
                self::SOURCE_QUERY_VAR => [
                    'required' => true,
                    'type' => 'string',
                ],
                self::WIDTH_QUERY_VAR => [
                    'required' => true,
                    'type' => 'integer',
                ],
                self::HEIGHT_QUERY_VAR => [
                    'required' => true,
                    'type' => 'integer',
                ],
                self::CROP_QUERY_VAR => [
                    'required' => true,
                    'type' => 'string',
                ],
                self::TOKEN_QUERY_VAR => [
                    'required' => true,
                    'type' => 'string',
                    'validate_callback' => static function ($value): bool {
                        return is_string($value)
                            && strlen($value) === 16
                            && ctype_xdigit($value)
                            && strtolower($value) === $value;
                    },
                ],
            ],
        ]);
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

        add_action('delete_attachment', [$this, 'deleteAttachment']);
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

            if (empty($src)) {
                return '';
            }

            $resizedImageUrl = $this->getResizedImageUrl($src, $w, $h, $crop);
            $destination = ImageHelper::get_server_location($resizedImageUrl);

            if (file_exists($destination)) {
                return $resizedImageUrl;
            }

            $sourcePath = $this->getRelativeUploadsPath($src);
            if ($sourcePath === null) {
                return $this->generateImage($src, $w, $h, $crop, $force);
            }

            return add_query_arg([
                self::SOURCE_QUERY_VAR => $sourcePath,
                self::WIDTH_QUERY_VAR => $w,
                self::HEIGHT_QUERY_VAR => $h,
                self::CROP_QUERY_VAR => $crop,
                self::TOKEN_QUERY_VAR => $this->generateToken($resizedImageUrl, $sourcePath, $w, $h, $crop),
            ], $resizedImageUrl);
        }

        return $this->generateImage($src, $w, $h, $crop, $force);
    }

    /**
     * Generate token.
     *
     * @param string $resizedImageUrl The resized image URL.
     * @param string $sourcePath The source path relative to the uploads directory.
     * @param integer $width The requested width.
     * @param integer $height The requested height.
     * @param string $crop The requested crop mode.
     */
    private function generateToken(
        string $resizedImageUrl,
        string $sourcePath,
        int $width,
        int $height,
        string $crop
    ): string {
        $payload = wp_json_encode([
            'url' => $resizedImageUrl,
            'src' => $sourcePath,
            'width' => $width,
            'height' => $height,
            'crop' => $crop,
        ]);
        $fullHash = hash_hmac('sha256', $payload, $this->getSalt());
        return substr($fullHash, 0, 16);
    }

    /**
     * Validate token.
     *
     * @param string $resizedImageUrl The resized image URL.
     * @param string $sourcePath The source path relative to the uploads directory.
     * @param integer $width The requested width.
     * @param integer $height The requested height.
     * @param string $crop The requested crop mode.
     * @param string $token The token.
     */
    private function validateToken(
        string $resizedImageUrl,
        string $sourcePath,
        int $width,
        int $height,
        string $crop,
        string $token
    ): bool {
        $expectedToken = $this->generateToken($resizedImageUrl, $sourcePath, $width, $height, $crop);
        return hash_equals($expectedToken, $token);
    }

    /**
     * Get salt.
     *
     * @return string
     */
    private function getSalt(): string
    {
        $salt = defined('NONCE_SALT') ? NONCE_SALT : __DIR__;
        return hash('sha256', $salt . self::VERSION);
    }

    /**
     * Get a URL path relative to the uploads directory.
     *
     * @param string $url The uploads URL.
     */
    private function getRelativeUploadsPath(string $url): ?string
    {
        $urlComponents = ImageHelper::analyze_url($url);
        if ($urlComponents['base'] !== ImageHelper::BASE_UPLOADS) {
            return null;
        }

        $subdirectory = trim((string) $urlComponents['subdir'], '/');
        $relativePath = $subdirectory === ''
            ? $urlComponents['basename']
            : $subdirectory . '/' . $urlComponents['basename'];

        return rawurldecode($relativePath);
    }

    /**
     * Check whether a relative uploads path is safe to resolve.
     *
     * @param string $path The relative uploads path.
     */
    private function isValidRelativePath(string $path): bool
    {
        $pathSegments = explode('/', $path);
        return $path !== ''
            && !str_contains($path, "\0")
            && !in_array('.', $pathSegments, true)
            && !in_array('..', $pathSegments, true);
    }

    /**
     * Generate a requested image and redirect to its static URL.
     *
     * @param WP_REST_Request $request The REST API request.
     *
     * @return WP_REST_Response|WP_Error
     */
    public function handleResizeRequest(WP_REST_Request $request)
    {
        $relativePath = rawurldecode((string) $request->get_param('path'));
        $relativePath = ltrim(wp_normalize_path($relativePath), '/');
        $sourcePath = rawurldecode((string) $request->get_param(self::SOURCE_QUERY_VAR));
        $sourcePath = ltrim(wp_normalize_path($sourcePath), '/');
        $width = (int) $request->get_param(self::WIDTH_QUERY_VAR);
        $height = (int) $request->get_param(self::HEIGHT_QUERY_VAR);
        $crop = (string) $request->get_param(self::CROP_QUERY_VAR);
        $token = (string) $request->get_param(self::TOKEN_QUERY_VAR);

        if (!$this->isValidRelativePath($relativePath) || !$this->isValidRelativePath($sourcePath)) {
            return new WP_Error(
                'flynt_dynamic_resize_invalid_path',
                __('The requested image path is invalid.', 'flynt'),
                ['status' => 400]
            );
        }

        if ($width < 1 || $height < 0 || $crop === '') {
            return new WP_Error(
                'flynt_dynamic_resize_invalid_arguments',
                __('The requested resize arguments are invalid.', 'flynt'),
                ['status' => 400]
            );
        }

        $uploadsBaseUrl = trailingslashit($this->getUploadsBaseurl());
        $originalImageUrl = $uploadsBaseUrl . $sourcePath;
        $resizedImageUrl = $this->getResizedImageUrl($originalImageUrl, $width, $height, $crop);
        $expectedPath = $this->getRelativeUploadsPath($resizedImageUrl);
        if ($expectedPath === null || !str_starts_with($expectedPath, self::RESIZED_DIR_NAME . '/')) {
            return new WP_Error(
                'flynt_dynamic_resize_invalid_destination',
                __('The resized image destination is invalid.', 'flynt'),
                ['status' => 400]
            );
        }

        $expectedPath = substr($expectedPath, strlen(self::RESIZED_DIR_NAME) + 1);
        if (
            !hash_equals($expectedPath, $relativePath)
            || !$this->validateToken($resizedImageUrl, $sourcePath, $width, $height, $crop, $token)
        ) {
            return new WP_Error(
                'flynt_dynamic_resize_invalid_signature',
                __('The image resize signature is invalid.', 'flynt'),
                ['status' => 403]
            );
        }

        $resizedImageLocation = ImageHelper::get_server_location($resizedImageUrl);
        if (file_exists($resizedImageLocation)) {
            return $this->getRedirectResponse($resizedImageUrl);
        }

        $originalImageLocation = ImageHelper::get_server_location($originalImageUrl);
        $uploadsBaseLocation = realpath($this->getUploadsBasedir());
        $originalImageLocation = realpath($originalImageLocation);

        if ($uploadsBaseLocation === false || $originalImageLocation === false) {
            return new WP_Error(
                'flynt_dynamic_resize_source_not_found',
                __('The source image could not be found.', 'flynt'),
                ['status' => 404]
            );
        }

        $uploadsBaseLocation = trailingslashit(wp_normalize_path($uploadsBaseLocation));
        $originalImageLocation = wp_normalize_path($originalImageLocation);
        if (!str_starts_with($originalImageLocation, $uploadsBaseLocation)) {
            return new WP_Error(
                'flynt_dynamic_resize_source_forbidden',
                __('The source image is outside the uploads directory.', 'flynt'),
                ['status' => 403]
            );
        }

        $mime = wp_get_image_mime($originalImageLocation);
        if (
            !is_string($mime)
            || !str_starts_with($mime, 'image/')
            || !in_array($mime, get_allowed_mime_types(), true)
        ) {
            return new WP_Error(
                'flynt_dynamic_resize_invalid_mime_type',
                __('The source file is not an allowed image type.', 'flynt'),
                ['status' => 403]
            );
        }

        $resizedImageDir = dirname($resizedImageLocation);
        if (!is_dir($resizedImageDir) && !wp_mkdir_p($resizedImageDir)) {
            error_log(sprintf('TimberDynamicResize: Could not create directory: %s', $resizedImageDir));
            return new WP_Error(
                'flynt_dynamic_resize_directory_error',
                __('The resized image directory could not be created.', 'flynt'),
                ['status' => 500]
            );
        }

        $lockFile = $resizedImageLocation . '.lock';
        $lockHandle = @fopen($lockFile, 'c');
        if ($lockHandle === false) {
            error_log(sprintf('TimberDynamicResize: Could not open lock file: %s', $lockFile));
            return new WP_Error(
                'flynt_dynamic_resize_lock_error',
                __('The image generation lock could not be created.', 'flynt'),
                ['status' => 500]
            );
        }

        if (!flock($lockHandle, LOCK_EX | LOCK_NB)) {
            fclose($lockHandle);
            $response = new WP_REST_Response([
                'code' => 'flynt_dynamic_resize_locked',
                'message' => __('The image is currently being generated.', 'flynt'),
            ], 503);
            $response->header('Retry-After', '1');
            return $response;
        }

        try {
            ftruncate($lockHandle, 0);
            fwrite($lockHandle, (string) time());
            $this->generateImage($originalImageUrl, $width, $height, $crop);

            if (!file_exists($resizedImageLocation)) {
                error_log(sprintf('TimberDynamicResize: Failed generating image: %s', $resizedImageLocation));
                return new WP_Error(
                    'flynt_dynamic_resize_generation_error',
                    __('The resized image could not be generated.', 'flynt'),
                    ['status' => 500]
                );
            }

            return $this->getRedirectResponse($resizedImageUrl);
        } catch (\Throwable $exception) {
            error_log($exception->getMessage());
            return new WP_Error(
                'flynt_dynamic_resize_generation_error',
                __('The resized image could not be generated.', 'flynt'),
                ['status' => 500]
            );
        } finally {
            $lockFileRemoved = @unlink($lockFile);
            flock($lockHandle, LOCK_UN);
            fclose($lockHandle);
            if (!$lockFileRemoved) {
                @unlink($lockFile);
            }
        }
    }

    /**
     * Create a permanent redirect to a generated image.
     *
     * @param string $resizedImageUrl The generated image URL.
     */
    private function getRedirectResponse(string $resizedImageUrl): WP_REST_Response
    {
        $response = new WP_REST_Response(null, 301);
        $response->header('Location', esc_url_raw($resizedImageUrl));
        return $response;
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
            trailingslashit($baseurl) . self::RESIZED_DIR_NAME,
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
            trailingslashit($basepath) . self::RESIZED_DIR_NAME,
            $path === '' || $path === '0' ? $basepath : $path
        );
    }

    /**
     * Deletes the auto-generated files for resized images.
     *
     * @param integer $postId The attachment id.
     */
    public function deleteAttachment(int $postId): void
    {
        if (wp_attachment_is_image($postId)) {
            $attachment = Timber::get_post($postId);
            if ($fileLoc = $attachment->file_loc()) {
                $fileLoc = $this->addImageSeparatorToUploadPath($fileLoc);
                ImageHelper::delete_generated_files($fileLoc);
            }
        }
    }
}
