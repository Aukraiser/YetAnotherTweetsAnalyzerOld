<?php

require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/

function display_result($string)
{
  foreach($string as $items)
  {
      echo "Time and Date of Tweet: ".$items['created_at']."<br />";
      echo "Tweet: ". $items['text']."<br />";
      echo "Tweeted by: ". $items['user']['name']."<br />";
      echo "Screen name: ". $items['user']['screen_name']."<br />";
      echo "Followers: ". $items['user']['followers_count']."<br />";
      echo "Friends: ". $items['user']['friends_count']."<br />";
      echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
  }
}

function check_error($string)
{
  if($string["errors"][0]["message"] != "")
  {
      echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";
      return (1);
  }
  return (0);
}

$settings = array(
    'oauth_access_token' => "1460769499-A0JKXMVFJ8HBopZRLCgPZqY4xisUmxv4XPHucAV",
    'oauth_access_token_secret' => "LDNfYScunuCjgtfDqAsDJjjYqnv8IGty5zdtjvWMCKwpC",
    'consumer_key' => "orVdAPiraBVOtgkSYCcUJQDjG",
    'consumer_secret' => "5Fio3wBlIQ3zwR6aqckxWjlTNnwXjHaOw3LOxOugrPjcQVhjCA"
);

/*TODO: change depending on the data to retrieve*/
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

/*TODO: check methode de recupération*/
$requestMethod = "GET";

if (isset($_GET['user']))
{
    $user = $_GET['user'];
}
else
{
    $user = "lilbowsc";
}

/*TODO: Remove */
if (isset($_GET['count']))
{
    $count = $_GET['count'];
}
else
{
    $count = 20;
}

/*TODO: change depending on the data to retrieve*/
$getfield = "?screen_name=$user&count=$count";
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
                      ->buildOauth($url, $requestMethod)
                      ->performRequest(),$assoc = TRUE);

if (check_error($string))
{
  exit();
}

display_result($string);

?>
