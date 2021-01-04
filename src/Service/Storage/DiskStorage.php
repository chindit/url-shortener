<?php


namespace App\Service\Storage;


use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DiskStorage implements StorageInterface
{

    public function upload(UploadedFile $file): Image
    {
        // TODO: Implement upload() method.
    }
}