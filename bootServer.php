<?php

include 'Autoloader.php';
MTP\Autoloader::register();

$server = new MTP\Memory\Server(new MTP\Memory\Config());

function shutdown() {
    global $server;
    $server->__destruct();
    exit;
}

declare(ticks = 1); // enable signal handling
pcntl_signal(SIGINT, 'shutdown');
pcntl_signal(SIGTERM, 'shutdown');

$server->run();