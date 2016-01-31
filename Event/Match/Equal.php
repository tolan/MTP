<?php

namespace MTP\Event\Match;

use MTP\Event;

/**
 * This file defines class for matching event name to equal.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Equal extends AMatch {

    /**
     * It returns that trigger name match to listener.
     *
     * @param Event\Trigger $trigger Instance of trigger
     *
     * @return boolean
     */
    public function match(Event\Trigger $trigger) {
        return $this->getMatchString() === $trigger->getName();
    }
}
