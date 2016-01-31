<?php

namespace MTP\Memory\Storage;

/**
 * This file defines class for memory storage.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Memory implements IStorage {

    /**
     * Actual data.
     *
     * @var array
     */
    private $_data = array();

    /**
     * Flag for prevent repetly call of recovery process.
     *
     * @var boolean
     */
    private $_recovered = false;

    /**
     * It creates backup of actual data.
     *
     * @param string $namespace Namespace of the data
     *
     * @return Memory
     */
    public function backup($namespace) {
        file_put_contents($this->_getBackupFile($namespace), serialize($this->_data));

        return $this;
    }

    /**
     * It loads data from backup.
     *
     * @param string $namespace Namespace of the data
     *
     * @return Memory
     */
    public function recovery($namespace) {
        if (!$this->_recovered) {
            if (file_exists($this->_getBackupFile($namespace))) {
                $this->_data = unserialize(file_get_contents($this->_getBackupFile($namespace)));
            }

            $this->_recovered = true;
        }

        return $this;
    }

    /**
     * Gets data by given name.
     *
     * @param string $name Name
     *
     * @return mixed
     */
    public function get($name) {
        $data = null;
        if ($this->has($name)) {
            $data = $this->_data[$name];
        }

        return $data;
    }

    /**
     * Sets data to storage under given name.
     *
     * @param string $name  Name
     * @param mixed  $value Some value
     *
     * @return boolean
     */
    public function set($name, $value) {
        $this->_data[$name] = $value;

        return true;
    }

    /**
     * Returns that the value is existed by given name.
     *
     * @param string $name Name
     *
     * @return boolean
     */
    public function has($name) {
        return array_key_exists($name, $this->_data);
    }

    /**
     * Deletes value by given name.
     *
     * @param string $name Name
     *
     * @return boolean
     */
    public function delete($name) {
        $result = false;
        if ($this->has($name)) {
            unset($this->_data[$name]);
            $result = true;
        } elseif ($name === '*') {
            foreach ($this->keys() as $name) {
                $this->delete($name);
            }

            $result = true;
        }

        return $result;
    }

    /**
     * Gets all keys in current namespace.
     *
     * @return array
     */
    public function keys() {
        return array_keys($this->_data);
    }

    /**
     * Returns namo of file for backup and recovery proces.
     *
     * @param string $name Namespace
     *
     * @return string
     */
    private function _getBackupFile($name) {
        return '/tmp/MTP_MEMORY_'.md5($name);
    }
}
