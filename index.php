<?php

require('config.php');
$whitelist = json_decode(file_get_contents($config['whitelist']), TRUE);

if(isset($_GET['status']))
	{
	/* status check */
	header('Content-Type: application/json');
	$json['usernames'] = count($whitelist);
	$json['max_usernames'] = $maxusernames;
	$json['whitelist_request'] = $admin_contact_url;
	$json['whitelist'] = $whitelist;
	echo json_encode($json);
	die;
	}


// original: https://github.com/stormuk/storm-twitter + stevelacey patch
if(!isset($_GET['u'])) { header("HTTP/1.1 404 Not Found"); die('no username provided. <a href="./?status">Here the allowed usernames</a>');}
$screenName = $_GET['u'];

require('StormTwitter.class.php');


// configuration control
if($config['key'] == '' or $config['secret'] == '' or $config['token'] == '' or $config['token_secret'] == '') { header("HTTP/1.1 404 Not Found"); die('missing API credentials in config.php'); }

// whitelist control
if (!in_array($screenName, $whitelist))
	{
	header("HTTP/1.1 403 Forbidden");
	if (count($whitelist) >= $maxusernames)
		{
		header('X-twitterbridge: This twitterbridge is full ('.count($whitelist).' out of '.$maxusernames.'), no more usernames will be whitelisted.');
		}
	else { header('X-twitterbridge: '.$config['unwhitelisted_header_message']); }
	die('username is not whitelisted');
	}

/*  START PROCESSING */
$twitter = new StormTwitter($config);

// getTweets is the only public method. For legacy reasons, it takes between 0 and 3 parameters.
// getTweets(twitter_screenname, number_of_tweets, custom_parameters_to_go_twitter); 

// check
$headers = get_headers("https://twitter.com/$screenName", 1);
if (strpos($headers[0], '302') === FALSE) 
{
	$twitter_data = $twitter->getTweets($screenName, $tweetcount, array('include_rts'=>true,'exclude_replies'=>true));

	if($_GET['format'] == 'json')
		{
		/* JSON OUTPUT */
		header('Content-Type: application/json');
		if(!empty($twitter_data['error'])) { header("HTTP/1.1 404 Not Found"); header('X-twitterbridge: Something went wrong. Please check for error messages.'); }
		echo json_encode($twitter_data);
		die;
		}

	else
		{
		/*  RSS OUTPUT */
		// $rss is the HTML output string
		if(!empty($twitter_data['error'])) { header("HTTP/1.1 404 Not Found"); header('X-twitterbridge: Something went wrong. Please check for error messages.'); }
		$rss = '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">';
		$rss .= '<channel><title>Twitter / '.$screenName.'</title><link>http://twitter.com/'.$screenName.'</link><description>Twitter updates from '.$screenName.'.</description>';
 
		for ($i = 0; $i < $tweetcount; $i++)
		{
		if(isset($twitter_data[$i]['id_str'])) // because Twitter doesn't return the exact count
			{
			// Tweet Text
			$desc = htmlspecialchars($twitter_data[$i]['text']);
			// Build link back
			$link = $twitter_data[$i]['id_str'];
			// Date tweet posted
			$date = $twitter_data[$i]['created_at'];
			$date = strtotime($date);

			// Build final output
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
		die;
		} /* END RSS OUTPUT */
}
else  // Twitter sent a redirect (= account suspended)
{
header("HTTP/1.1 410 Account Suspended"); die('username gone: rejected by Twitter (account suspended)');
}

?>
