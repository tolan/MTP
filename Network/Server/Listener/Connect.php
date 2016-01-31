<?php

namespace MTP\Network\Server\Listener;

use MTP\Network\Server\Event\AEvent;
use MTP\Network\Server\Response\Ok;

/**
 * This file defines class for listener of network communication on connect event.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Connect extends AListener {

    /**
     * Receive and process event of network communication.
     *
     * @param AEvent $event Event of network communication
     *
     * @return IResponse
     */
    public function receive(AEvent $event) {
        return new Ok();
    }
}