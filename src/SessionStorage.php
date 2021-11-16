<?php

namespace MHIbrahim\Storage;
use MHIbrahim\Storage\Contract\StorageInterface;

class SessionStorage implements StorageInterface
{
    protected $storageKey ='items';
    public function __construct($sessionKey = null)
    {
        if ($sessionKey){
            $this->storageKey = $sessionKey;
        }

        if (!isset($_SESSION[$this->storageKey])){
            $_SESSION[$this->storageKey] = [];
        }
    }

    public function set($key, $value)
    {
       $_SESSION[$this->storageKey][$key] = serialize($value);
    }

    public function get($key)
    {
       if (!isset($_SESSION[$this->storageKey][$key])){
           return null;
       }
       return unserialize($_SESSION[$this->storageKey][$key]);
    }

    public function delete($key)
    {
       unset($_SESSION[$this->storageKey][$key]);
    }

    public function destroy()
    {
        unset($_SESSION[$this->storageKey]);
    }

    public function all()
    {
      $items =[];
      foreach ($_SESSION[$this->storageKey] as $item){
          $items[] = unserialize($item);
      }
      return $items;
    }

}
