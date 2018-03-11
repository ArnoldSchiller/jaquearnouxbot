#!/usr/bin/php
<?php 

// Register an app: http://dev.twitter.com/apps
// Consumer Key (API Key) DeinKey 
// Consumer Secret (API Secret) DeinSecret


define('CONSUMER_KEY', 'DeinKey');
define('CONSUMER_SECRET', 'DeinSecretHiereintragen');

//
//Access Token
//Access Token Secret Sn404OvjlmXwkzdcL21oL3HOSqmrmt4DZgFDfHOD9Do1i


define('TWITTER_TOKEN', 'ACCESS');
define('TWITTER_TOKEN_SECRET', 'ACCESSECRET');
$myuserid = "";

$oauth = new OAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);

if (!(TWITTER_TOKEN && TWITTER_TOKEN_SECRET)){
  $request_token = $oauth->getRequestToken('https://api.twitter.com/oauth/request_token');
  $oauth->setToken($request_token['oauth_token'], $request_token['oauth_token_secret']);

  $url = 'https://api.twitter.com/oauth/authorize?' . http_build_query(array('oauth_token' => $request_token['oauth_token']));
  //system('open ' . escapeshellarg($url)); 
  #print "Authorize:\n$url\nEnter the PIN: ";
  $access_token = $oauth->getAccessToken('https://api.twitter.com/oauth/access_token', NULL, trim(fgets(STDIN)));

  #printf("define('TWITTER_TOKEN', '%s');\ndefine('TWITTER_TOKEN_SECRET', '%s');\n", $access_token['oauth_token'], $access_token['oauth_token_secret']);
  exit();
}

$oauth->setToken(TWITTER_TOKEN, TWITTER_TOKEN_SECRET);
$oauth->fetch('https://api.twitter.com/1.1/account/verify_credentials.json');
$oauth->fetch('https://api.twitter.com/1.1/statuses/user_timeline.json?user_id='.$myuserid.'&count=1');




$response = json_decode($oauth->getLastResponse());
if ($response[0] )                                                               
{                                                                                
  $lastId = $response[0]->id;                                  
  $lastIdText = $response[0]->text;
}     

# #print_r(json_decode($oauth->getLastResponse()));
#print "Last retweeted ID: " . $lastId . "\n";                                    
#print $lastIdText." \n";

#print "Retweeting the following tweets:\n\n";

$oauth->fetch('https://api.twitter.com/1.1/search/tweets.json?q=DeinSuchwort1%20OR%20%23Suchwortmithash%20OR%20Suchwort2%20-gratismailer%20&since_id='.$lastId.'&result_type=mixed&lang=de&count=100');

$response = (array) json_decode($oauth->getLastResponse());


# #print_r ($response["statuses"]); 
foreach ( array_reverse($response["statuses"]) as $tweet)
{
	if ($tweet->id > $lastId){
 		$ID = $tweet->id;
 		$Text = $tweet->text;
		# #print_r ($tweet);
		#print "$ID $Text\n";
#  https://api.twitter.com/1.1/statuses/retweet/$ID.json
$url = 'https://api.twitter.com/1.1/statuses/retweet/'.$ID.'.json';

	try {
		$oauth->fetch("$url",null, OAUTH_HTTP_METHOD_POST,array('Content-Type' => 'application/json'));
         	$response_info = $oauth->getLastResponseInfo();
         	# #print_r ($oauth->getLastResponse());
                # #print_r ($response_info);
		} catch(OAuthException $E) {

               		#echo "Exception caught!\n";
    			#echo "Response: ". $E->lastResponse . "\n";
		}


 	}
}

#print "Done.\n";

?>
