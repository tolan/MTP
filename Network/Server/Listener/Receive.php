<?php

namespace MTP\Network\Server\Listener;

use MTP\Network\Server\Event\AEvent;
use Closure;
use MTP\Network\Server\Response\Quit;
use MTP\Network\Server\Response\Data;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Receive extends AListener {

    /**
     *
     * @var Closure;
     */
    private $_closure;

    public function receive(AEvent $event) {
        $result = new Quit();
        if ($this->_closure instanceof Closure) {
            $closure = $this->_closure;
            $output  = $closure($event->getData());

            if ($output) {
                $result = new Data();
                $result->setData($this->_getData($event, $output));
            }
        }

        return $result;
    }

    public function setClosure(Closure $closure) {
        $this->_closure = $closure;

        return $this;
    }

    private function _getData(AEvent $event, $output) {
        $result = $output;
        if ($event->getMessage()) {
            $result = $event->getMessage();
            $result->setData($output);
        }

        return $result;
    }
}
