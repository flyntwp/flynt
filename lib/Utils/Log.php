<?php

namespace Flynt\Utils;

class Log
{
    /**
     * Outputs a message to the Web Console.
     *
     * Outputs a JavaScript `console.log`.
     *
     * @since 0.1.0
     *
     * @param mixed    $data     Data to be logged.
     * @param boolean  $postpone Postpone logging to the wp_footer action.
     */
    public static function console($data, $postpone = true)
    {
        self::consoleDebug($data, $postpone);
    }

    /**
     * Outputs an error message to the Web Console.
     *
     * Outputs a JavaScript `console.error`.
     *
     * @since 0.1.0
     *
     * @param mixed    $data     Data to be logged.
     * @param boolean  $postpone Postpone logging to the wp_footer action.
     */
    public static function error($data, $postpone = true)
    {
        self::consoleDebug($data, $postpone, 'PHP', 'error');
    }

    /**
     * Pretty prints a variable.
     *
     * Prints human-readable information about a variable.
     *
     * @since 0.1.0
     *
     * @param mixed    $data     Data to be printed.
     * @param boolean  $postpone Postpone printing to the wp_footer action.
     */
    public static function pp($data, $postpone = true)
    {
        self::printDebug($data, $postpone);
    }

    /**
     * Outputs a message to the Web Console.
     *
     * Outputs a JavaScript log.
     * Accepts log, error and trace. Can specify a title.
     * Will also output the data type, the filename and line number.
     *
     * @since 0.1.0
     *
     * @param mixed    $data     Data to be logged.
     * @param boolean  $postpone Postpone logging to the wp_footer action.
     * @param string   $title    A title.
     * @param string   $logType  The type of log (accepts log|error|trace).
     */
    public static function consoleDebug($data, $postpone = true, $title = 'PHP', $logType = 'log')
    {
        if (in_array($logType, ['log', 'error', 'trace'])) {
            $title .= '(' . self::getCallerFile(2) . '):';
            $type = gettype($data);
            $output = json_encode($data);
            $result =  "<script>console.{$logType}('{$title}', '({$type})', {$output});</script>\n";
            self::echoDebug($result, $postpone);
        }
    }

    /**
     * Pretty prints a variable.
     *
     * Prints human-readable information about a variable.
     * Print will be wrapped between <pre> tags.
     * Will also output the data type, the filename and line number.
     *
     * @since 0.2.0
     *
     * @param mixed    $data     Data to be printed.
     * @param boolean  $postpone Postpone printing to the wp_footer action.
     */
    public static function printDebug($data, $postpone = true)
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

    /**
     * Echoes a variable.
     *
     * @since 0.2.0
     *
     * @param mixed    $data     Data to be printed.
     * @param boolean  $postpone Postpone printing to the wp_footer action.
     */
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

    /**
     * Returns a filename and line number by performing a debug_backtrace.
     *
     * @since 0.1.0
     *
     * @param integer  $depth  Depth to return.
     *
     * @return string  The filename and line number.
     */
    protected static function getCallerFile($depth = 1)
    {
        $debug = debug_backtrace();
        $fileName = $debug[$depth]['file'];
        $templateDir = get_template_directory() . '/';
        return str_replace($templateDir, '', $fileName) . '#' . $debug[$depth]['line'];
    }
}
