<?php

include __DIR__.'/../../Autoloader.php';
MTP\Autoloader::register();

use MTP\Process;
use MTP\Memory;

$memory  = Memory\Factory::getClient(new MTP\Memory\Config(), 'Process');
$manager = new Process\Manager();

$clientA   = new Process\Client($memory);
$callbackA = new Process\Callback();
$callbackA->setClass(new \MTP\scripts\Process\Test())
    ->setMethod('multi')
    ->setParams(array('a' => 2, 'b' => 4));
$clientA->setCallback($callbackA);

$clientB  = new Process\Client($memory);
$callbackB = new Process\Callback();
$callbackB->setClass(new \MTP\scripts\Process\Test())
    ->setMethod('multi')
    ->setParams(array('a' => 9, 'b' => 3));
$clientB->setCallback($callbackB);

$clientC  = new Process\Client($memory);
$callbackC = new Process\Callback();
$callbackC->setClass(new \MTP\scripts\Process\Test())
    ->setMethod('multi')
    ->setParams(array('a' => 10, 'b' => 10));
$clientC->setCallback($callbackC);

$start = microtime(true);
$manager
    ->register($clientA)
    ->register($clientB)
    ->register($clientC)
    ->start()
    ->wait()
        ;

$end = ((microtime(true) - $start)*1000);

var_dump($clientA->getResult());
var_dump($clientB->getResult());
var_dump($clientC->getResult());
var_dump($end);

$manager->clean();

