<?php

namespace MTP\Network\Server\Response;

use MTP\Network\Utils;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Quit implements IResponse {

    public function send($socket) {
        Utils::sendMessage($socket, 'EXIT!'."\n");

        return $this;
    }
}
