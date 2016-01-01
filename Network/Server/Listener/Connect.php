<?php

namespace MTP\Network\Server\Listener;

use MTP\Network\Server\Event\AEvent;
use MTP\Network\Server\Response\Ok;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Connect extends AListener {

    public function receive(AEvent $event) {
        return new Ok();
    }
}