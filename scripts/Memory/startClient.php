<?php

include __DIR__.'/../../Autoloader.php';
MTP\Autoloader::register();

$config = new \MTP\Memory\Config();
$cli    = new \MTP\CLI\Client();
$cli->addListener(new MTP\scripts\Memory\Client\Listener($config))
    ->run();
