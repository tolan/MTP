<?php

include 'Autoloader.php';
MTP\Autoloader::register();

$client = \MTP\Memory\Factory::getClient(new MTP\Memory\Config());
//error_log(date("Y-m-d H:i:s")."#".__FILE__.":".__LINE__."\r\n".print_r(__LINE__,TRUE)."\r\n\n\n", 3, "/home/tolan/my.log");

$actual = $client->get('test');
$client->set('test', ++$actual);
echo $client->get('test');

//function aaa() {
//    $config = new MTP\Network\Config();
//    $client = new MTP\Network\Client($config);
//
//    $string = str_repeat('10 chars. ', 100 * 1000 * 0.001);
//    $start = microtime(true);
//
//    $answer = $client->send($string);
//    $end = ((microtime(true) - $start)*1000);
//    $client->send('exit');
//
////    echo $answer;
//    error_log(date("Y-m-d H:i:s")."#".__FILE__.":".__LINE__."\r\n".print_r([$end, number_format(strlen($answer))],TRUE)."\r\n\n\n", 3, "/home/tolan/my.log");
//}
//
//aaa();