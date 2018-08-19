<?php

include 'phpMQTT.php';
require "vendor/autoload.php";

$server = "broker.hivemq.com";
$port = 1883;
$username = "";
$password = "";
$client_id = "piggy-farm-line-bot";
$mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);
if (!$mqtt->connect(true, null, $username, $password)) {
    exit(1);
}
$topics['chanatip/piggybkkfarm/outputs'] = array("qos" => 0, "function" => "procmsg");
$mqtt->subscribe($topics, 0);
while ($mqtt->proc()) {

}
$mqtt->close();
function procmsg($topic, $msg)
{
    echo "Msg Recieved: " . date("r") . "\n";
    echo "Topic: {$topic}\n\n";
    echo "\t$msg\n\n";
    $access_token = 'W7uUjdWdAR5rlMAhTCHZ11ESL1m/amYYEaMsvoFpy6Y8KcqL19qJp7sb/pGWiLqtSlgd+udUui8LBYAvaeds+YnHozApjfeoTH9kDhbdA3Y+vwaabNcbIhAKv/aR8EbuDe5JqkiYk+at/grNx9ERHgdB04t89/1O/w1cDnyilFU=';
    $channelSecret = '06e34e972681b7ad4b6431475c81f9c6';
    $pushID = 'U2169edceae217410b46368e5eb96297e';

    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($msg);
    $response = $bot->pushMessage($pushID, $textMessageBuilder);

    echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
}
