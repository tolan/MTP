<?php

include __DIR__.'/../../Autoloader.php';
MTP\Autoloader::register();

$options = getopt('', array('id:'));
$id      = $options['id'];

$memory   = MTP\Memory\Factory::getClient(new MTP\Memory\Config(), 'Process');
$executor = new MTP\Process\Executor($id, $memory);
$executor->start();


