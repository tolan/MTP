<?php

include __DIR__.'/Autoloader.php';
MTP\Autoloader::register();

use MTP\Event;

$manager = new Event\Manager();

$manager->listen('test /testa/', function($a, $b) {
    echo $a * $b."\n";
});

$manager->trigger('test', array(4, 6));