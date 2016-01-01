<?php

namespace MTP\Memory\Storage;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Memory implements IStorage {

    private $_data = array();

    private $_recovered = false;

    public function backup($namespace) {
        file_put_contents($this->_getBackupFile($namespace), serialize($this->_data));

        return $this;
    }

    public function recovery($namespace) {
        if (!$this->_recovered) {
            if (file_exists($this->_getBackupFile($namespace))) {
                $this->_data = unserialize(file_get_contents($this->_getBackupFile($namespace)));
            }

            $this->_recovered = true;
        }

        return $this;
    }

    public function get($name) {
        $data = null;
        if ($this->has($name)) {
            $data = $this->_data[$name];
        }

        return $data;
    }

    public function set($name, $value) {
        $this->_data[$name] = $value;

        return true;
    }

    public function has($name) {
        return array_key_exists($name, $this->_data);
    }

    public function delete($name) {
        if ($this->has($name)) {
            unset($this->_data[$name]);
        }

        return true;
    }

    private function _getBackupFile($name) {
        return __DIR__.'/tmp/'.md5($name);
    }
}
