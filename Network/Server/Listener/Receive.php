<?php

namespace MTP\Network\Server\Listener;

use MTP\Network\Server\Event\AEvent;
use Closure;
use MTP\Network\Server\Response\Quit;
use MTP\Network\Server\Response\Data;

/**
 * This file defines class for listener of network communication on receive data event.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Receive extends AListener {

    /**
     * Closure function.
     *
     * @var Closure;
     */
    private $_closure;

    /**
     * Receive and process event of network communication.
     *
     * @param AEvent $event Event of network communication
     *
     * @return IResponse
     */
    public function receive(AEvent $event) {
        $result = new Quit();
        if ($this->_closure instanceof Closure) {
            $closure = $this->_closure;
            $output  = $closure($event->getData());

            if ($output) {
                $result = new Data();
                $result->setData($this->_adaptOutput($event, $output));
            }
        }

        return $result;
    }

    /**
     * Sets closue function which is executed in receive method.
     *
     * @param Closure $closure Closure function
     *
     * @return Receive
     */
    public function setClosure(Closure $closure) {
        $this->_closure = $closure;

        return $this;
    }

    /**
     * It converts output into event message (if message is set).
     *
     * @param AEvent $event  Event
     * @param mixed  $output Output data
     *
     * @return mixed
     */
    private function _adaptOutput(AEvent $event, $output) {
        $result = $output;
        if ($event->getMessage()) {
            $result = $event->getMessage();
            $result->setData($output);
        }

        return $result;
    }
}
