# Google Analytics

Enable the Google Analytics tracking configuration in the WordPress back end.

If a valid Google Analytics ID is provided, the tracking code will automatically be added to all pages. If the ID is invalid, a notice is triggered in the WordPress back end.

The following options are provided under the **"Global Options"** menu:

- Google Analytics ID: This must be either a valid Google Analytics ID, or the string "debug" (to enable debug mode which will log to the console only and overwrite all other settings)
- Anonymize IP: Check to enable the Google Analytics `_anonymizeIp` function and anonymize the last digits of the user's IP.
- Skip specific user roles
- Skip specific IP addresses. These must be comma separated.
