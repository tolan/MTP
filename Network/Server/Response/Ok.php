<?php

namespace MTP\Network\Server\Response;

use MTP\Network\Utils;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Ok implements IResponse {

    public function send($socket) {
        Utils::sendMessage($socket, 'OK'."\n");

        return $this;
    }
}
