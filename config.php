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

  'cache_expire' => 900, //The duration of the cache
  'whitelist' => 'whitelist.json' 
);

$tweetcount = 200;  // retrieve up to 200 tweets per request, not more

?>
