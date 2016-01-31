<?php

namespace MTP\CLI\Client\Response;

/**
 * This file defines abstract class for response of CLI client.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
abstract class AResponse {

    /**
     * Response data
     *
     * @var mixed
     */
    protected $_data = null;

    /**
     * Method for flushing data to output.
     *
     * @return void
     */
    abstract public function flush();

    /**
     * Sets response data.
     *
     * @param mixed $data Response data
     *
     * @return AResponse
     */
    public function setData($data) {
        $this->_data = $data;

        return $this;
    }

    /**
     * Gets response data for flush.
     *
     * @return mixed
     */
    protected function getData() {
        return $this->_data;
    }
}
