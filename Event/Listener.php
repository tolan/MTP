<?php

namespace MTP\Event;

use Closure;

/**
 * This file defines class for listening event.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Listener {

    /**
     * Set of matchers.
     *
     * @var Match\IMatch[]
     */
    private $_matchers = array();

    /**
     * Callable closure.
     *
     * @var Closure
     */
    private $_closure;

    /**
     * It adds matching string into matchers.
     *
     * @param string $string Matching string
     *
     * @return Listener
     */
    public function addMatch($string) {
        if (@preg_match($string, null) === false){
            $strings = array_filter(explode(' ', $string));
            if (count($strings) < 2) {
                $this->_matchers[] = new Match\Equal($string);
            } else {
                foreach ($strings as $part) {
                    $this->addMatch($part);
                }
            }
        } else {
            $this->_matchers[] = new Match\RegExp($string);
        }

        return $this;
    }

    /**
     * Sets callable closure.
     *
     * @param Closure $closure Closure
     *
     * @return Listener
     */
    public function setClosure(Closure $closure) {
        $this->_closure = $closure;

        return $this;
    }

    /**
     * It returns that trigger name match to listener.
     *
     * @param Trigger $trigger Instance of trigger
     *
     * @return boolean
     */
    public function match(Trigger $trigger) {
        $match = false;
        foreach ($this->_matchers as $matcher) {
            if ($matcher->match($trigger)) {
                $match = true;
                break;
            }
        }

        return $match;
    }

    /**
     * Executes assigned closure with given data in trigger.
     *
     * @param Trigger $trigger Instance of trigger
     *
     * @return mixed
     */
    public function run(Trigger $trigger) {
        return call_user_func_array($this->_closure, (array)$trigger->getData());
    }
}
