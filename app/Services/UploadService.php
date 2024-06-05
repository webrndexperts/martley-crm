<?php

namespace App\Services;

use GuzzleHttp\Client;
use Facebook\Facebook;

class UploadService
{
    public function upload($file, $path = '/images') {
    	$fileName = time().'-'.$file->getClientOriginalName();
        $file->move(public_path($path), $fileName);

        return 'public'.$path.'/'.$fileName;
    }
}