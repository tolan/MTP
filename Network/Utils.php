<?php

namespace MTP\Network;

/**
 * This file defines class for utils with helper methods.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Utils {

    const FRAME = 8192;

    /**
     * Sends message to socket.
     *
     * @param resource $socket  Resource socket
     * @param string   $message Message to send
     *
     * @return boolean
     */
    public static function sendMessage(&$socket, $message) {
        @fwrite($socket, $message);

        return true;
    }

    /**
     * Receive message from socket.
     *
     * @param resource $socket Resource socket
     *
     * @return string
     *
     * @throws Exception Throws when socket is empty
     */
    public static function receiveMessage(&$socket) {
        if (empty($socket)) {
            throw new Exception('Socket is empty.');
        }

        $message = null;
        while(($out = @fread($socket, self::FRAME))) {
            $message .= $out;
            if (empty($out) || strlen($out) < self::FRAME) {
                break;
            }
        }

        return $message;
    }
}
