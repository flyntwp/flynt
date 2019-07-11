<?php

namespace Flynt\TimberDynamicResize;

use Twig_SimpleFilter;
use Timber;
use Routes;

const DB_VERSION = '1.1';
const TABLE_NAME = 'resized_images';
const IMAGE_ROUTE = 'dynamic-images';
const IMAGE_PATH_SEPARATOR = 'dynamic';

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

add_action('timber/twig/filters', function ($twig) {
    $twig->addFilter(
        new Twig_SimpleFilter('resizeDynamic', function (
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

            global $wpdb;
            $tableName = getTableName();
            $wpdb->query(
                $wpdb->prepare("REPLACE INTO {$tableName} VALUES (%s, %s)", [
                    $resizedUrl,
                    json_encode($arguments)
                ])
            );

            return str_replace(
                '/app/uploads/',
                '/app/uploads/' . IMAGE_PATH_SEPARATOR . '/',
                $resizedUrl
            );
        })
    );

    return $twig;
});

Routes::map(IMAGE_ROUTE, function () {
    $src = str_replace(
        '/app/uploads/' . IMAGE_PATH_SEPARATOR . '/',
        '/app/uploads/',
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
    $urlParts = wp_parse_url($src);
    $homeUrl = home_url();
    $localDev = parse_url($homeUrl)['host'] !== $urlParts['host'];
    if ($localDev) {
        $src = http_build_url($homeUrl, ['path' => $urlParts['path']]);
    }
    $moveImageFunction = function ($location) {
        return str_replace(
            '/app/uploads/',
            '/app/uploads/' . IMAGE_PATH_SEPARATOR . '/',
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

    if ($localDev) {
        unset($urlParts['path']);
        $url = http_build_url($url, $urlParts);
    }
    header("Location: {$url}", true, 301);
    exit();
});
