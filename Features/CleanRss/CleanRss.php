<?php

namespace Flynt\Features;

use Flynt\Utils\Feature;

class CleanRss extends Feature {
  public function setup() {
    /**
     * Remove the WordPress version from RSS feeds
     */
    add_filter('the_generator', '__return_false');

    /**
     * removeDefaultDescription
     *
     * Don't return the default description in the RSS feed if it hasn't been changed
     */
    add_filter('get_bloginfo_rss', function ($bloginfo) {
      $defaultTagline = 'Just another WordPress site';
      return ($bloginfo === $defaultTagline) ? '' : $bloginfo;
    });
  }
}
