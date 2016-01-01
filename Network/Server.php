<?php

namespace MTP\Network;

class Server {

    private $_stream;

    private $_clients = array();

    /**
     *
     * @var Server\Listener\AListener[]
     */
    private $_listeners = array();

    public function __construct(Config $config) {
        set_time_limit(0);
        $this->_stream = stream_socket_server('tcp://'.$config->getIp().':'.$config->getPort());

        if ($this->_stream === false) {
            throw new Exception('Could not bind to socket: '.$config->getIp().':'.$config->getPort());
        }
    }

    public function __destruct() {
        @fclose($this->_stream);
    }

    public function addListener(Server\Listener\AListener $listener) {
        $this->_listeners[] = $listener;

        return $this;
    }

    public function removeListener(Server\Listener\AListener $listner) {
        $key = array_search($listner, $this->_listeners);
        if ($key !== false) {
            array_splice($this->_listeners, $key, 1);
        }

        return $this;
    }

    public function run() {
        while($this->_checkState()) {
            usleep(500);
        }
    }

    private function _checkState() {
        //prepare readable sockets
        $read   = $this->_clients;
        $read[] = $this->_stream;

        //start reading and use a large timeout
        $write  = array();
        $except = array();
        if (!@stream_select($read, $write, $except, 0)) {
            return true;
        }

        //new client
        if (in_array($this->_stream, $read)) {
            $client = stream_socket_accept($this->_stream);

            if ($client) {
                $this->_clients[] = $client;
                $this->_triggerEvent(new Server\Event\Connect(), $client);
            }

            $key = array_search($this->_stream, $read);
            array_splice($read, $key, 1);
        }

        //message from existing client
        foreach ($read as $socket) {
            $data  = Utils::receiveMessage($socket);
            $event = new Server\Event\Receive();
            $this->_prepareEvent($event, $data);
            $this->_triggerEvent($event, $socket);
        }

        return true;
    }

    private function _triggerEvent(Server\Event\AEvent $event, $socket) {
        $className = str_replace('Event', 'Listener', get_class($event));
        foreach ($this->_listeners as $listener) {
            if ($listener instanceof $className) {
                $response = $listener->receive($event, $socket);

                if ($response instanceof Server\Response\Quit && !($event instanceof Server\Event\Disconnect)) {
                    $this->_triggerEvent(new Server\Event\Disconnect(), $socket);
                    $this->_disconnectSocket($socket);
                    break;
                } else {
                    $response->send($socket);
                }
            }
        }

        return $this;
    }

    private function _disconnectSocket($socket) {
        $key = array_search($socket, $this->_clients);
        array_splice($this->_clients, $key, 1);
        @fclose($socket);

        return $this;
    }

    private function _prepareEvent(Server\Event\AEvent $event, $data) {
        $message = @unserialize($data);

        $event->setData($data);

        if ($message instanceof Message) {
            $event->setMessage($message);
        }

        return $event;
    }
}