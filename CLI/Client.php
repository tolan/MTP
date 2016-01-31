<?php

namespace MTP\CLI;

/**
 * This file defines class for provide command line client.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Client {

    /**
     * Set of listeners.
     *
     * @var Client\Listener[]
     */
    private $_listeners = array();

    /**
     * Adds listener.
     *
     * @param Client\Listener $listener Listener instance
     *
     * @return Client
     */
    public function addListener(Client\Listener $listener) {
        $this->_listeners[] = $listener;

        return $this;
    }

    /**
     * Removes listener from listeners.
     *
     * @param Client\Listener $listener Listener instance
     *
     * @return Client
     */
    public function removeListener(Client\Listener $listener) {
        $key = array_search($listener, $this->_listeners);
        if ($key !== false) {
            array_splice($this->_listeners, $key, 1);
        }

        return $this;
    }

    /**
     * Run client in cycle.
     *
     * @return Client
     */
    public function run() {
        while($this->_readInput());

        return $this;
    }

    /**
     * Reads standard input and trigger message.
     *
     * @return boolean
     */
    private function _readInput() {
        $input = fopen('php://stdin', 'r');

        $message = fgets($input);
        return $this->_trigerMessage($message);
    }

    /**
     * Processes triggered message.
     *
     * @param string $message Message from standard input
     *
     * @return boolean
     */
    private function _trigerMessage($message) {
        $result = true;
        foreach ($this->_listeners as $listener) {
            $response = $listener->trigger($message);

            if ($response) {
                $response->flush();
            }

            if ($response instanceof Client\Response\Quit) {
                $result = false;
                break;
            }
        }

        return $result;
    }
}
