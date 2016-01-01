<?php

namespace MTP\Network\Server\Listener;

use MTP\Network\Server\Event\AEvent;
use MTP\Network\Server\Response\Quit;
/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Disconnect extends AListener {

    public function receive(AEvent $event) {
        return new Quit();
    }
}
