<?php

namespace MTP\Network;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Utils {

    const FRAME = 8192;

    public static function sendMessage(&$socket, $message) {
        @fwrite($socket, $message);

        return true;
    }

    public static function receiveMessage(&$socket) {
        do {
            $metadata = stream_get_meta_data($socket);
        } while($metadata['eof'] || $metadata['unread_bytes'] > 0);

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
