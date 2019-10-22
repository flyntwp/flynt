<?php

namespace Flynt\Components\GoogleAnalyticsOptIn;

function isTrackingEnabled($gaId, $skippedUserRoles, $skippedIps)
{
    $skippedIps = explode(',', $skippedIps);
    $skippedIps = array_map('trim', $skippedIps);
    if ($gaId && isValidId($gaId)) {
        $user = wp_get_current_user();
        $trackingEnabled = !($gaId === 'debug' // debug mode enabled
            || is_array($skippedUserRoles) && array_intersect($skippedUserRoles, $user->roles) // current user role should be skipped
            || is_array($skippedIps) && in_array($_SERVER['REMOTE_ADDR'], $skippedIps) // current ip should be skipped
        );
        return $trackingEnabled;
    }
}

function isValidId($gaId)
{
    if ($gaId === 'debug') {
        return true;
    } else {
        return preg_match('/^ua-\d{4,9}-\d{1,4}$/i', (string) $gaId);
    }
}
