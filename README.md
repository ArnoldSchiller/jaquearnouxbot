# jaquearnouxbot
Total stupid retweetbot for twitter in php

Ok Englisch mag ich jetzt nicht. Für Access des Accounts habe ich ich
https://github.com/abraham/twitteroauth  
verwendet. Wenn der Bot die Challenge absolviert hat tweeten zu dürfen, dann läuft er einfach über Cron auf dem Server.

$oauth = new OAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);

if (!(TWITTER_TOKEN && TWITTER_TOKEN_SECRET)){
  $request_token = $oauth->getRequestToken('https://api.twitter.com/oauth/request_token');
  $oauth->setToken($request_token['oauth_token'], $request_token['oauth_token_secret']);

  $url = 'https://api.twitter.com/oauth/authorize?' . http_build_query(array('oauth_token' => $request_token['oauth_token']));
  //system('open ' . escapeshellarg($url)); 
  print "Authorize:\n$url\nEnter the PIN: ";
  $access_token = $oauth->getAccessToken('https://api.twitter.com/oauth/access_token', NULL, trim(fgets(STDIN)));

  printf("define('TWITTER_TOKEN', '%s');\ndefine('TWITTER_TOKEN_SECRET', '%s');\n", $access_token['oauth_token'], $access_token['oauth_token_secret']);
  exit();
}

$oauth->setToken(TWITTER_TOKEN, TWITTER_TOKEN_SECRET);
$oauth->fetch('https://api.twitter.com/1.1/account/verify_credentials.json');
print_r(json_decode($oauth->getLastResponse()));
