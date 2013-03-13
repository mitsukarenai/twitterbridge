<?php
// original: https://github.com/stormuk/storm-twitter + stevelacey patch
if(!isset($_GET['u'])) { header("HTTP/1.0 403 Forbidden"); die('no username provided');}
$screenName = $_GET['u'];

require('StormTwitter.class.php');

$config = array(
  'directory' => '', //The path used to store the .tweetcache cache file.
// sign up a new app:  https://dev.twitter.com/apps/new
  'key' => '',
  'secret' => '',
  'token' => '',
  'token_secret' => '',
  'cache_expire' => 3600 //The duration of the cache  
);

$twitter = new StormTwitter($config);

// getTweets is the only public method. For legacy reasons, it takes between 0 and 3 parameters.
// getTweets(twitter_screenname, number_of_tweets, custom_parameters_to_go_twitter); 

$twitter_data = $twitter->getTweets($screenName, 100, array('include_rts'=>true,'exclude_replies'=>true));

// $rss is the HTML output string
$rss = '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">';
$rss .= '<channel><title>Twitter / '.$screenName.'</title><link>http://twitter.com/'.$screenName.'</link><description>Twitter updates from '.$screenName.'.</description>';
 
for ($i = 0; $i < 20; $i++) {
// Tweet Text
$desc = $twitter_data[$i]['text'];
// Build link back
$link = $twitter_data[$i]['id_str'];
// Date tweet posted
$date = $twitter_data[$i]['created_at'];
$date = strtotime($date);
 
 
// Build final output
if(!empty($link))
	{ 
	$rss .=	'
	<item>
	<title>'.$desc.'</title>
	<description>'.$desc.'</description>
	<pubDate>'.date(DATE_RSS, $date).'</pubDate>
	<guid>http://twitter.com/'.$screenName.'/statuses/'.$link.'</guid>
	<link>http://twitter.com/'.$screenName.'/statuses/'.$link.'</link>
	</item>';
	}
 
}

// Final touch
$rss .= '
</channel>
</rss>';

// Send the stuff
header('Content-Type: application/rss+xml; charset=utf-8');
echo $rss;
?>
