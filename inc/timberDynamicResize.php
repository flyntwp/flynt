<?php

namespace Flynt\TimberDynamicResize;

use Twig\TwigFilter;
use Timber;

const DB_VERSION = '1.1';
const TABLE_NAME = 'resized_images';
const IMAGE_ROUTE = 'dynamic-images';
const IMAGE_PATH_SEPARATOR = 'dynamic';

add_filter('init', 'Flynt\TimberDynamicResize\registerRewriteRule');

function getTableName()
{
    global $wpdb;
    return $wpdb->prefix . TABLE_NAME;
}

call_user_func(function () {
    $optionName = TABLE_NAME . '_db_version';

    $installedVersion = get_option($optionName);

    if ($installedVersion !== DB_VERSION) {
        global $wpdb;
        $tableName = getTableName();

        $charsetCollate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $tableName (
            url varchar(511),
            arguments text
        ) $charsetCollate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        update_option($optionName, DB_VERSION);
    }
});

function getRelativeUploadDir()
{
    $uploadDir = wp_upload_dir();
    return $uploadDir['relative'];
}

add_action('timber/twig/filters', function ($twig) {
    $twig->addFilter(
        new TwigFilter('resizeDynamic', function (
            $src,
            $w,
            $h = 0,
            $crop = 'default',
            $force = false
        ) {
            $resizeOp = new Timber\Image\Operation\Resize($w, $h, $crop);
            $fileinfo = pathinfo($src);
            $resizedUrl = $resizeOp->filename(
                $fileinfo['dirname'] . '/' . $fileinfo['filename'],
                $fileinfo['extension']
            );

            $arguments = [
                'src' => $src,
                'w' => $w,
                'h' => $h,
                'crop' => $crop,
                'force' => $force
            ];

            global $flyntResizedImages;
            if (empty($flyntResizedImages)) {
                add_action('shutdown', function () {
                    storeResizedUrls();
                }, -1);
            }
            $flyntResizedImages[$resizedUrl] = json_encode($arguments);

            $uploadDirRelative = getRelativeUploadDir();

            return str_replace(
                $uploadDirRelative,
                trailingslashit($uploadDirRelative) . IMAGE_PATH_SEPARATOR,
                $resizedUrl
            );
        })
    );

    return $twig;
});

function registerRewriteRule()
{
    $routeName = IMAGE_ROUTE;

    add_rewrite_rule("{$routeName}/?(.*?)/?$", "index.php?{$routeName}=\$matches[1]", "top");
    add_rewrite_tag("%{$routeName}%", "([^&]+)");
}

add_action('parse_request', function ($wp) {
    if (isset($wp->query_vars[IMAGE_ROUTE])) {
        generateImage();
    }
});

function generateImage()
{
    $uploadDirRelative = getRelativeUploadDir();
    $src = str_replace(
        trailingslashit($uploadDirRelative) . IMAGE_PATH_SEPARATOR,
        $uploadDirRelative,
        home_url($_GET['src'] ?? '')
    );

    global $wpdb;
    $tableName = getTableName();
    $resizedImage = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM {$tableName} WHERE url = %s", $src)
    );

    if (empty($resizedImage)) {
        header("HTTP/1.0 404 Not Found");
        exit();
    }
    $moveImageFunction = function ($location) use ($uploadDirRelative) {
        return str_replace(
            $uploadDirRelative,
            trailingslashit($uploadDirRelative) . IMAGE_PATH_SEPARATOR,
            $location
        );
    };
    add_filter('timber/image/new_url', $moveImageFunction);
    add_filter('timber/image/new_path', $moveImageFunction);
    $arguments = json_decode($resizedImage->arguments, true);
    $url = Timber\ImageHelper::resize(
        $arguments['src'],
        (int) $arguments['w'],
        (int) $arguments['h'],
        $arguments['crop'],
        false
    );

    remove_filter('timber/image/new_url', $moveImageFunction);
    remove_filter('timber/image/new_path', $moveImageFunction);

    Timber\ImageHelper::img_to_webp($url);

    header("Location: {$url}", true, 302);
    exit();
}

function addRewriteRule($rules)
{
    $imageRoute = IMAGE_ROUTE;
    $uploadDirRelative = trailingslashit(getRelativeUploadDir());
    $dynamicImageDir = trailingslashit($uploadDirRelative . IMAGE_PATH_SEPARATOR);
    $dynamicImageRule = <<<EOD
\n# BEGIN Flynt dynamic images
RewriteEngine On
RewriteCond %{REQUEST_URI} ^{$dynamicImageDir}
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /{$imageRoute}?src=$1 [L,R]

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
</IfModule>
# END Flynt dynamic images\n\n
EOD;
    return $dynamicImageRule . $rules;
}

add_filter('mod_rewrite_rules', 'Flynt\\TimberDynamicResize\\addRewriteRule');

add_action('after_switch_theme', function () {
    add_action('shutdown', 'flush_rewrite_rules');
});

add_action('switch_theme', function () {
    remove_filter('mod_rewrite_rules', 'Flynt\\TimberDynamicResize\\addRewriteRule');
    flush_rewrite_rules();
});

global $flyntResizedImages;
$flyntResizedImages = [];

function storeResizedUrls()
{
    global $wpdb, $flyntResizedImages;
    $tableName = getTableName();
    $urls = array_keys($flyntResizedImages);
    $deletePlaceholders = array_fill(0, count($urls), '%s');
    $deletePlaceholdersString = '(' . implode(', ', $deletePlaceholders) . ')';
    $wpdb->query(
        $wpdb->prepare(
            "DELETE FROM {$tableName} WHERE url IN {$deletePlaceholdersString}",
            $urls
        )
    );
    $insertPlaceholders = array_fill(0, count($urls), '(%s, %s)');
    $insertPlaceholdersString = implode(', ', $insertPlaceholders);
    $insertValues = [];
    foreach ($urls as $url) {
        $insertValues[] = $url;
        $insertValues[] = $flyntResizedImages[$url];
    }
    $wpdb->query(
        $wpdb->prepare(
            "INSERT INTO {$tableName} (url, arguments) VALUES {$insertPlaceholdersString}",
            $insertValues
        )
    );
}
