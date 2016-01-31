<?php

namespace MTP\Event;

use Closure;

/**
 * This file defines class for build of event components.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Builder {

    /**
     * It builds listener by given name and closure.
     *
     * @param string  $string  Matching string
     * @param Closure $closure Closure which will be called
     *
     * @return Listener
     */
    public static function buildListener($string, Closure $closure) {
        $listener = new Listener();
        $listener
            ->addMatch($string)
            ->setClosure($closure);

        return $listener;
    }

    /**
     * It builds trigger by given name and data.
     *
     * @param string $name Name of trigger
     * @param mixed  $data Data for closure
     *
     * @return Trigger
     */
    public static function buildTrigger($name, $data) {
        $trigger = new Trigger($name);
        $trigger->setData($data);

        return $trigger;
    }
}
