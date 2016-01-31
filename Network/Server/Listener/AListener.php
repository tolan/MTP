<?php

namespace MTP\Network\Server\Listener;

use MTP\Network\Server\Event\AEvent;

/**
 * This file defines abstract class for listener of network communication.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
abstract class AListener {

    /**
     * Receive and process event of network communication.
     *
     * @param AEvent $event Event of network communication
     *
     * @return IResponse
     */
    abstract public function receive(AEvent $event);
}
