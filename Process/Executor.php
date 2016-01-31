<?php

namespace MTP\Process;

use MTP\Memory;

/**
 * This file defines class for executor of process.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Executor {

    /**
     * Identifier
     *
     * @var string
     */
    private $_id;

    /**
     * Instance of memory client.
     *
     * @var Memory\Client
     */
    private $_memory;

    /**
     * Construct method for initiate memory client and identifier.
     *
     * @param string        $id     Identifier
     * @param Memory\Client $memory Instance of memory client
     *
     * @return void
     */
    public function __construct($id, Memory\Client $memory) {
        $this->_id     = $id;
        $this->_memory = $memory;
    }

    /**
     * Starts execution of callback.
     *
     * @return Executor
     */
    public function start() {
        $this->_memory->set(Utils::getStatusKey($this->_id), Enum\Status::START);

        try {
            $callback = unserialize($this->_memory->get(Utils::getCallbackKey($this->_id)));
            /* @var $callback Callback */
            $this->_memory->set(Utils::getStatusKey($this->_id), Enum\Status::RUN);

            $result = $callback->invoke();

            $this->_memory->set(Utils::getResultKey($this->_id), $result);
            $this->_memory->set(Utils::getStatusKey($this->_id), Enum\Status::DONE);
        } catch (\Exception $exp) {
            $this->_memory->set(Utils::getResultKey($this->_id), $exp->getMessage()."\n".$exp->getTraceAsString());
            $this->_memory->set(Utils::getStatusKey($this->_id), Enum\Status::ERROR);
        }

        return $this;
    }
}
