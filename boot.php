<?php

include __DIR__.'/Autoloader.php';
MTP\Autoloader::register();

use MTP\Memory;

$memory  = Memory\Factory::getClient(new MTP\Memory\Config());
$options = getopt('', array('id:'));
$id      = $options['id'];

while(true) {
    $memory->set($id, $memory->get($id) + 1);
}