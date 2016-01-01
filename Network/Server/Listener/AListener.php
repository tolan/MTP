<?php

namespace MTP\Network\Server\Listener;

use MTP\Network\Server\Event\AEvent;

abstract class AListener {

    abstract public function receive(AEvent $event);
}
