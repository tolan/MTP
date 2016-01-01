<?php

namespace MTP\Network\Server\Response;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
interface IResponse {

    public function send($socket);
}
