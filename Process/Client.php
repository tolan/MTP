<?php

namespace MTP\Process;

use MTP\Memory;

/**
 * This file defines class for client of process.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Client {

    /**
     * Identifier
     *
     * @var string
     */
    private $_id = null;

    /**
     * Instance of memory client.
     *
     * @var Memory\Client
     */
    private $_meomry;

    /**
     * Instance of callback.
     *
     * @var Callback
     */
    private $_callback;

    /**
     * Construct method for init memory cliend and identifier.
     *
     * @param Memory\Client $memory
     *
     * @return void
     */
    public function __construct(Memory\Client $memory) {
        $this->_id     = uniqid();
        $this->_meomry = $memory;
    }

    /**
     * Sets callback for executor.
     *
     * @param Callback $callback Callback
     *
     * @return Client
     */
    public function setCallback(Callback $callback) {
        $this->_callback = $callback;

        return $this;
    }

    /**
     * It starts callback in parallel process.
     *
     * @return Client
     */
    public function start() {
        $this->_meomry->set(Utils::getStatusKey($this->_id), Enum\Status::NONE);
        $this->_meomry->set(Utils::getResultKey($this->_id), null);
        $this->_meomry->set(Utils::getCallbackKey($this->_id), serialize($this->_callback));

        $root    = dirname(__DIR__);
        $command = 'php '.$root.'/scripts/Process/startExecutor.php --id '.$this->_id;
        exec($command.' >> /dev/null 2>&1 &');

        return $this;
    }

    /**
     * Returns current status of execution.
     *
     * @return string
     */
    public function getStatus() {
        return $this->_meomry->get(Utils::getStatusKey($this->_id));
    }

    /**
     * Returns current result from execution. It is null until the execution is runing.
     *
     * @return mixed
     */
    public function getResult() {
        return $this->_meomry->get(Utils::getResultKey($this->_id));
    }

    /**
     * It cleans metadata after execution.
     *
     * @return Client
     */
    public function clean() {
        $this->_meomry->delete(Utils::getStatusKey($this->_id));
        $this->_meomry->delete(Utils::getResultKey($this->_id));
        $this->_meomry->delete(Utils::getCallbackKey($this->_id));

        return $this;
    }
}
