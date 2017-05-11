<?php
namespace Flynt\Features\GoogleAnalytics;

use Flynt\Features\AdminNotices\AdminNoticeManager;
use Timber\Timber;

class GoogleAnalytics
{
    private $gaId;
    private $anonymizeIp;
    private $skippedUserRoles;
    private $skippedIps;

    public function __construct($options)
    {
        $this->gaId = $options['gaId'];
        $this->anonymizeIp = $options['anonymizeIp'];
        $this->skippedUserRoles = $options['skippedUserRoles'];
        $this->skippedIps = $options['skippedIps'];

        if ($this->skippedIps) {
            $skippedIps = explode(',', $this->skippedIps);
            $this->skippedIps = array_map('trim', $skippedIps);
        }

        if ($this->gaId && $this->isValidId($this->gaId)) {
            add_action('wp_footer', [$this, 'addScript'], 20, 1);
        } else if ($this->gaId != '' && !isset($_POST['acf'])) {
            $manager = AdminNoticeManager::getInstance();
            $message = ["Invalid Google Analytics Id: {$this->gaId}"];
            $options = [
                'type' => 'error',
                'title' => 'Google Analytics Error',
                'dismissible' => true,
                'filenames' => 'functions.php'
            ];
            $manager->addNotice($message, $options);
        }
    }

    public function addScript()
    {
        $user = wp_get_current_user();
        $trackingEnabled = !(
            $this->gaId === 'debug' // debug mode enabled
            || $this->skippedUserRoles && array_intersect($this->skippedUserRoles, $user->roles) // current user role should be skipped
            || is_array($this->skippedIps) && in_array($_SERVER['REMOTE_ADDR'], $this->skippedIps) // current ip should be skipped
        );
        Timber::render('script.twig', [
            'gaId' => $this->gaId,
            'trackingEnabled' => $trackingEnabled,
            'anonymizeIp' => $this->anonymizeIp
        ]);
    }

    private function isValidId($gaId)
    {
        if ($gaId === 'debug') {
            return true;
        } else {
            return preg_match('/^ua-\d{4,10}-\d{1,4}$/i', (string) $gaId);
        }
    }
}
