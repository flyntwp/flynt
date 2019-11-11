<?php

namespace Flynt\Components\FeatureGoogleAnalytics;

function isTrackingEnabled($gaId)
{
    if ($gaId) {
        $user = wp_get_current_user();
        $trackingEnabled = !in_array('administator', $user->roles);
        return $trackingEnabled;
    }
    return false;
}
