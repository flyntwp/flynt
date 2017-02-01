<?php
// TODO: remove phpcs ignore once script tag issue is fixed on jenkins
// @codingStandardsIgnoreFile

namespace Flynt\Features\GoogleAnalytics;

class GoogleAnalytics {

  public function __construct($id, $anonymizeIp, $nonTrackedUsers) {
    $this->googleAnalyticsId = $id;
    $this->anonymizeIp = $anonymizeIp;
    $this->nonTrackedUsers = $nonTrackedUsers;

    if ($this->isValidId($this->googleAnalyticsId)) {
      // cases:
      // - if you are on production and not listed as non tracked (on the options), add the action
      // - if you are not on production, add the action
      $user = wp_get_current_user();
      if (WP_ENV !== 'production' || (!$this->nonTrackedUsers || !array_intersect($this->nonTrackedUsers, $user->roles))) {
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
      <?php if($this->anonymizeIp == 1) : ?>
      ga('set', 'anonymizeIp', true);
      <?php endif; ?>
    </script>
    <?
  }

  private function isValidId($gaId) {
    return preg_match('/^ua-\d{4,10}-\d{1,4}$/i', strval($gaId));
  }
}
