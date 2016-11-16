<?php

namespace WPStarterTheme\Helpers;

class Log {
  public static function console($data) {
    self::console_debug($data);
  }

  public static function error($data) {
    self::console_debug($data, 'PHP', 'error');
  }

  public static function console_debug($data, $title = 'PHP', $log_type = 'log') {
    $title .= '(' . self::get_caller_file(2) .'):';
    if(is_array($data) || is_object($data))
    {
      $output = json_encode($data);
      echo "<script>console.$log_type('$title', $output);</script>\n";
    } else {
      echo "<script>console.$log_type('$title', '$data');</script>\n";
    }
  }

  public static function pp($data) {
    echo "<pre>";
    print_r($data);
    echo "<br />File: <strong>" . self::get_caller_file() . "</strong>";
    echo "</pre>\n";
  }

  protected static function get_caller_file($depth = 1) {
    $debug = debug_backtrace();
    $file_name = $debug[$depth]['file'];
    $template_dir = get_template_directory() . '/';
    return str_replace($template_dir, '', $file_name) . '#' . $debug[$depth]['line'];
  }
}
