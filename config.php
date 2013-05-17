<?php

$config = array(
  'directory' => 'cache/', //The path used to store the "cache.json" cache file.

/* BEGIN Twitter credentials */
// 		sign up a new app:  https://dev.twitter.com/apps/new  (with access token) and enter the values:
  'key' => '',
  'secret' => '',
  'token' => '',
  'token_secret' => '',
//  - END Twitter API credentials

  'cache_expire' => 300, //The duration of the cache
  'whitelist' => 'whitelist.json', 
  'unwhitelisted_header_message' => 'To ask username whitelisting, please contact the twitterbridge owner' 
);

$tweetcount = 200;  // retrieve up to 200 tweets per request, not more
$maxusernames = 20; // allow up to 20 usernames  (keep it low or Twitter may ban your API key)
$admin_contact_url = 'mywebsite.com / @_my_twitter'; // link to twitterbridge admin contact page

?>
