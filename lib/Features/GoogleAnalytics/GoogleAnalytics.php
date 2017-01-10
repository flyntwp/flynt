<?php

namespace Flynt\Features\GoogleAnalytics;

class GoogleAnalytics {
  private $googleAnalyticsId;

  public function __construct($gaId = '') {
    $this->googleAnalyticsId = $gaId;

    if ($this->googleAnalyticsId && (WP_ENV !== 'production' || !current_user_can('manage_options'))) {
      add_action('wp_footer', [$this, 'addScript'], 20, 1);
    }
  }

  public function addScript() { // @codingStandardsIgnoreLine ?>
    <script>
      <?php if (WP_ENV === 'production') : ?>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      <?php else : ?>
        function ga() {
          console.log('GoogleAnalytics: ' + [].slice.call(arguments));
        }
      <?php endif; ?>
      ga('create','<?php echo $this->googleAnalyticsId; ?>','auto');ga('send','pageview');
    </script>
    <?
  }
}
