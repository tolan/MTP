<?php

namespace MTP\Network;

/**
 * This file defines class for server of network communication.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Server {

    /**
     * Server socket stream
     *
     * @var resource
     */
    private $_stream;

    /**
     * Set of connected clients.
     *
     * @var resource[]
     */
    private $_clients = array();

    /**
     * Set of assigned listeners.
     *
     * @var Server\Listener\AListener[]
     */
    private $_listeners = array();

    /**
     * Construct method for create server socket by given configuration.
     *
     * @param Config $config Network configuration
     *
     * @throws Exception Throws when socket was not binded
     *
     * @return void
     */
    public function __construct(Config $config) {
        set_time_limit(0);
        $this->_stream = stream_socket_server('tcp://'.$config->getIp().':'.$config->getPort());

        if ($this->_stream === false) {
            throw new Exception('Could not bind to socket: '.$config->getIp().':'.$config->getPort());
        }
    }

    /**
     * Destruct method for close server socket stream.
     *
     * @return void
     */
    public function __destruct() {
        @fclose($this->_stream);
    }

    /**
     * Adds listener to network events.
     *
     * @param Server\Listener\AListener $listener Event listener
     *
     * @return Server
     */
    public function addListener(Server\Listener\AListener $listener) {
        $this->_listeners[] = $listener;

        return $this;
    }

    /**
     * Removes listener from networks events.
     *
     * @param Server\Listener\AListener $listener Event listener
     *
     * @return Server
     */
    public function removeListener(Server\Listener\AListener $listner) {
        $key = array_search($listner, $this->_listeners);
        if ($key !== false) {
            array_splice($this->_listeners, $key, 1);
        }

        return $this;
    }

    /**
     * Run server in loop.
     *
     * @return void
     */
    public function run() {
        while($this->_checkState()) {
            usleep(500);
        }
    }

    /**
     * It checks state of connected clients.
     *
     * @return boolean
     */
    private function _checkState() {
        //prepare readable sockets
        $read   = $this->_clients;
        $read[] = $this->_stream;

        //start reading
        $write  = array();
        $except = array();
        if (@stream_select($read, $write, $except, 0)) {
            //new client
            if (in_array($this->_stream, $read)) {
                $client = stream_socket_accept($this->_stream);

                if ($client) {
                    $this->_clients[] = $client;
                    $this->_triggerEvent(new Server\Event\Connect(), $client);
                    $read[] = $client;
                }
            }

            //message from existing client
            foreach ($read as $socket) {
                if ($socket === $this->_stream) {
                    continue;
                }

                $data  = Utils::receiveMessage($socket);
                $event = new Server\Event\Receive();
                $this->_prepareEvent($event, $data);
                $this->_triggerEvent($event, $socket);
            }
        }

        return true;
    }

    /**
     * Triggers and process event from socket
     *
     * @param Server\Event\AEvent $event  Connection event
     * @param resource            $socket Resource socket
     *
     * @return Server
     */
    private function _triggerEvent(Server\Event\AEvent $event, $socket) {
        $className = str_replace('Event', 'Listener', get_class($event));
        foreach ($this->_listeners as $listener) {
            if ($listener instanceof $className) {
                $response = $listener->receive($event, $socket);

                if ($response instanceof Server\Response\Quit && !($event instanceof Server\Event\Disconnect)) {
                    $this->_triggerEvent(new Server\Event\Disconnect(), $socket);
                    $this->_disconnectClient($socket);
                    break;
                } else {
                    $response->send($socket);
                }
            }
        }

        return $this;
    }

    /**
     * It removes socket from clients and close the connection.
     *
     * @param resource $socket Resource socket
     *
     * @return Server
     */
    private function _disconnectClient($socket) {
        $key = array_search($socket, $this->_clients);
        array_splice($this->_clients, $key, 1);
        @fclose($socket);

        return $this;
    }

    /**
     * It prepares event data, optionaly with message.
     *
     * @param Server\Event\AEvent $event  Connection event
     * @param string              $data   Serialized data
     *
     * @return Server\Event\AEvent
     */
    private function _prepareEvent(Server\Event\AEvent $event, $data) {
        $message = @unserialize($data);

        $event->setData($data);

        if ($message instanceof Message) {
            $event->setMessage($message);
        }

        return $event;
    }
}