<?php

namespace MTP\Event;

use Closure;

/**
 * This file defines class for managing of events.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Manager {

    /**
     * Set of assigned listeners
     *
     * @var Listener[]
     */
    private $_listeners = array();

    /**
     * Assigns listener into scope. The listener match trigger and execute closure.
     *
     * @param string|Listener $nameOrListener Matching string or instance of Listener
     * @param Closure         $closure        Closure, it must be set when first argument is not listener
     *
     * @return Manager
     */
    public function listen($nameOrListener, Closure $closure=null) {
        if (!($nameOrListener instanceof Listener)) {
            $nameOrListener = Builder::buildListener($nameOrListener, $closure);
        }

        $this->_listeners[] = $nameOrListener;

        return $this;
    }

    /**
     * It triggers event to listeners.
     *
     * @param string|Trigger $nameOrTrigger Name of event or instance of Trigger
     * @param mixed          $data          Data for listener closure
     *
     * @return Manager
     */
    public function trigger($nameOrTrigger, $data=null) {
        if (!($nameOrTrigger instanceof Trigger)) {
            $nameOrTrigger = Builder::buildTrigger($nameOrTrigger, $data);
        }

        foreach ($this->_listeners as $listener) {
            if ($listener->match($nameOrTrigger)) {
                $listener->run($nameOrTrigger);
            }
        }

        return $this;
    }
}
