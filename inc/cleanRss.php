<?php

/**
 * - Remove the WordPress version from RSS feeds
 * - Don't return the default description in the RSS feed if it hasn't been changed
 */

namespace Flynt\CleanRss;

/*
 * Remove the WordPress version from RSS feeds
 */
add_filter('the_generator', '__return_false');
