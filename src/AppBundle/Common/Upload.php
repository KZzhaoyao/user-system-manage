<?php

namespace AppBundle\Common;

use Symfony\Component\Filesystem\Filesystem;

class Upload
{
    protected $file;

    public function __construct($file)
    {   
        $this->file = $file;
    }

    public function moveToDirectory($userId, $oldPath = null, $type)
    {   
        $fileSystem = new Filesystem();

        if (!$fileSystem->exists(__DIR__.'/../../../web/images/')) {
            $fileSystem->mkdir(__DIR__.'/../../../web/images/');
        }

        if (!empty($oldPath)) {
            $array = explode('/', $oldPath);
            $name = array_pop($array);
            $fileSystem->remove(__DIR__.'/../../../web/images/'.$type.'/'.$userId.'/'.$name);
        }
        
        $imgExtension = $this->file->getClientOriginalExtension();
        $imgName = time().'.'.$imgExtension;
        $newDirectory = __DIR__.'/../../../web/images/'.$type.'/'.$userId;
        $this->file->move($newDirectory,$imgName);

        return 'images/'.$type.'/'.$userId.'/'.$imgName;
    }
}