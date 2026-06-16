<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface FileStorageInterface
{
    public function upload(
        UploadedFile $file,
        string $folder
    ): string;

    public function delete(
        string $path
    ): bool;

    public function url(
        string $path
    ): string;
}
