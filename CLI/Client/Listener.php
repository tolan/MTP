<?php

namespace MTP\CLI\Client;

use Closure;

/**
 * This file defines class for listening message from CLI client.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Listener {

    /**
     * Closure method with message at first argument.
     *
     * @var Closure
     */
    private $_closure;

    /**
     * Process triggered message.
     *
     * @param string $message Message from CLI client
     *
     * @return Response\AResponse|null
     */
    public function trigger($message) {
        $response = null;
        if ($this->_closure) {
            $closure = $this->_closure;
            $response  = $closure($message);
        }

        return $response;
    }

    /**
     * Sets closure function with message at first argument.
     *
     * @param Closure $closure Closure function
     *
     * @return Listener
     */
    public function setClosure(Closure $closure) {
        $this->_closure = $closure;

        return $this;
    }
}
