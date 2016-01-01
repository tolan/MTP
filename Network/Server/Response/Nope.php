<?php

namespace MTP\Network\Server\Response;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Nope implements IResponse {

    public function send($socket) {
        return $this;
    }
}