<?php
// TODO: remove phpcs ignore once script tag issue is fixed on jenkins
// @codingStandardsIgnoreFile

namespace Flynt\Features\GoogleAnalytics;

class GoogleAnalytics {

  public function __construct($id) {
    $this->googleAnalyticsId = $id;

    if ($this->isValidId($this->googleAnalyticsId)) {
      // cases:
      // - if you are on production, add the action
      // - if you are not an admin, add the action
      if (WP_ENV !== 'production' || !current_user_can('manage_options')) {
        add_action('wp_footer', [$this, 'addScript'], 20, 1);
      }
    } else if ($this->googleAnalyticsId != 1 && !isset($_POST['acf'])) {
      trigger_error('Invalid Google Analytics Id: ' . $this->googleAnalyticsId, E_USER_WARNING);
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

  private function isValidId($gaId) {
    return preg_match('/^ua-\d{4,10}-\d{1,4}$/i', strval($gaId));
  }
}
