<?php

namespace MTP\Event\Match;

use MTP\Event;

/**
 * This file defines abstract class for event matching.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
abstract class AMatch {

    /**
     * Matching string
     *
     * @var string
     */
    private $_string;

    /**
     * Construct method for set match string.
     *
     * @param string $string Match string
     *
     * @return void
     */
    public function __construct($string) {
        $this->_string = $string;
    }

    /**
     * It returns that trigger name match to listener.
     *
     * @param Event\Trigger $trigger Instance of trigger
     *
     * @return boolean
     */
    abstract public function match(Event\Trigger $trigger);

    /**
     * Returns matching string.
     *
     * @return string
     */
    protected function getMatchString() {
        return $this->_string;
    }
}
