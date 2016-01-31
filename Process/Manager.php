<?php

namespace MTP\Process;

/**
 * This file defines class for manager of process.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Manager {

    /**
     * Set of process clients.
     *
     * @var Client[]
     */
    private $_clients = array();

    /**
     * Register client for execution.
     *
     * @param Client $client Process client
     *
     * @return Manager
     */
    public function register(Client $client) {
        $this->_clients[] = $client;

        return $this;
    }

    /**
     * Starts execution for all clients.
     *
     * @return Manager
     */
    public function start() {
        foreach ($this->_clients as $client) {
            $client->start();
        }

        return $this;
    }

    /**
     * Returns summary status of clients.
     *
     * @return string
     */
    public function status() {
        $result   = Enum\Status::NONE;
        $statuses = array();
        foreach ($this->_clients as $client) {
            $status            = $client->getStatus();
            $statuses[$status] = array_key_exists($status, $statuses) ? $statuses[$status] + 1 : 1;
        }

        if (array_key_exists(Enum\Status::ERROR, $statuses) && array_key_exists(Enum\Status::DONE, $statuses) && count(array_keys($statuses) === 2)) {
            $result = Enum\Status::PARTIAL;
        } elseif (count($statuses) === 1) {
            $result = current(array_keys($statuses));
        } elseif (array_key_exists(Enum\Status::ERROR, $statuses) && $statuses[Enum\Status::ERROR] === count($this->_clients)) {
            $result = Enum\Status::ERROR;
        }

        return $result;
    }

    /**
     * Wait for all clients until these are runing.
     *
     * @return Manager
     */
    public function wait() {
        $endStatuses = array(
            Enum\Status::ERROR,
            Enum\Status::DONE,
            Enum\Status::PARTIAL
        );

        while (!in_array($this->status(), $endStatuses)) {
            usleep(1000);
        }

        return $this;
    }

    /**
     * It cleans each registred clients.
     *
     * @return Manager
     */
    public function clean() {
        foreach ($this->_clients as $client) {
            $client->clean();
        }

        return $this;
    }
}
