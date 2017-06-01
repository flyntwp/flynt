<?php

namespace Flynt\Utils;

class Log
{
    public static function console($data, $postpone = true)
    {
        self::consoleDebug($data, $postpone);
    }

    public static function error($data, $postpone = true)
    {
        self::consoleDebug($data, $postpone, 'PHP', 'error');
    }

    public static function pp($data, $postpone = true)
    {
        self::printDebug($data, $postpone);
    }

    public static function consoleDebug($data, $postpone, $title = 'PHP', $logType = 'log')
    {
        $title .= '(' . self::getCallerFile(2) .'):';
        $type = gettype($data);
        if (is_array($data) || is_object($data)) {
            $output = json_encode($data);
            $result =  "<script>console.{$logType}('{$title}', '({$type})', {$output});</script>\n";
        } else {
            $result = "<script>console.{$logType}('{$title}', '({$type})', '{$data}');</script>\n";
        }
        self::echoDebug($result, $postpone);
    }

    public static function printDebug($data, $postpone)
    {
        $type = gettype($data);
        $output = '<pre>';
        $output .= '(' . $type . ') ';
        ob_start();
        print_r($data);
        $output .= ob_get_clean();
        $output .= '<br />File: <strong>' . self::getCallerFile(2) . '</strong>';
        $output .= "</pre>\n";
        self::echoDebug($output, $postpone);
    }

    protected static function echoDebug($data, $postpone)
    {
        if ($postpone) {
            add_action('wp_footer', function () use ($data) {
                echo $data;
            }, 30);
        } else {
            echo $data;
        }
    }

    protected static function getCallerFile($depth = 1)
    {
        $debug = debug_backtrace();
        $fileName = $debug[$depth]['file'];
        $templateDir = get_template_directory() . '/';
        return str_replace($templateDir, '', $fileName) . '#' . $debug[$depth]['line'];
    }
}
