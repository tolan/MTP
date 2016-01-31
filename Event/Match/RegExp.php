<?php

namespace MTP\Event\Match;

use MTP\Event;

/**
 * This file defines class for matching event name to regular expression.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class RegExp extends AMatch {

    /**
     * It returns that trigger name match to listener.
     *
     * @param Event\Trigger $trigger Instance of trigger
     *
     * @return boolean
     */
    public function match(Event\Trigger $trigger) {
        return (boolean)preg_match($this->getMatchString(), $trigger->getName());
    }
}
