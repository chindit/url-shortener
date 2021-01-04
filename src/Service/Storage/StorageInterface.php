<?php


namespace App\Service\Storage;


use App\Entity\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface StorageInterface
{
    public function upload(UploadedFile $file): Image;
}