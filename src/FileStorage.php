<?php

namespace MHIbrahim\Storage;
use MHIbrahim\Storage\Contract\StorageInterface;

class FileStorage implements StorageInterface
{

    /**
     * @var null
     */
    private $fileStorage ='files';
    /**
     * @var string
     */
    private $path;

    public function __construct($fileStorage = null)
    {
        if ($fileStorage){
            $this->fileStorage = $fileStorage;
        }
        $this->path="storage/{$this->fileStorage}";
        if (!file_exists($this->path)){
            mkdir($this->path,'0777');
        }
    }

    public function set($key, $value)
    {
      file_put_contents("{$this->path}/{$key}",$value);
    }

    public function get($key)
    {
        if ($filePath =$this->getFile_exists($key)){
            return file_get_contents($filePath);
        }
        return null;
    }

    public function delete($key)
    {
        if ($filePath =$this->getFile_exists($key)){
           unlink($filePath);
         }
    }

    public function destroy()
    {
       $dir = opendir($this->path);

       while (false !==($item = readdir($dir))){
          if (!in_array($item,['.','..'])){
              unlink("$this->path/{$item}");
          }
       }
    }

    public function all()
    {
        $items = [];
        $dir = opendir($this->path);

        while (false !==($item = readdir($dir))){
            if (!in_array($item,['.','..'])){
              $items[$item] = file_get_contents("$this->path/{$item}");
            }
        }
        return $items;

    }

    public function getFile_exists($key)
    {
     if (file_exists($filePath = "$this->path/{$key}")){
      return $filePath;
     }
     return null;
    }
}
