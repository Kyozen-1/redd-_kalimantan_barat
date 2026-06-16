<?php

namespace App\Services\Storage;

use App\Contracts\FileStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class FileStorageService implements FileStorageInterface
{
    protected string $disk;

    public function __construct()
    {
        $this->disk = config(
            'filesystems.default'
        );
    }

    public function upload(
        UploadedFile $file,
        string $folder
    ): string {

        $extension = strtolower(
            $file->getClientOriginalExtension()
        );

        $imageExtensions = [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'webp'
        ];

        if (in_array(
            $extension,
            $imageExtensions
        )) {

            return $this->uploadImage(
                $file,
                $folder
            );
        }

        return $this->uploadFile(
            $file,
            $folder
        );
    }

    protected function uploadImage(
        UploadedFile $file,
        string $folder
    ): string {

        $filename = time()
            .'_'
            .Str::random(10)
            .'.jpg';

        $path = $folder.'/'.$filename;

        $image = Image::read(
            $file->getRealPath()
        );

        $encoded = $image
            ->toJpeg(60);

        Storage::disk($this->disk)
            ->put(
                $path,
                $encoded
            );

        return $path;
    }

    protected function uploadFile(
        UploadedFile $file,
        string $folder
    ): string {

        $extension = $file
            ->getClientOriginalExtension();

        $filename = time()
            .'_'
            .Str::random(10)
            .'.'
            .$extension;

        Storage::disk($this->disk)
            ->putFileAs(
                $folder,
                $file,
                $filename
            );

        return $folder.'/'.$filename;
    }

    public function delete(
        string $path
    ): bool {

        return Storage::disk($this->disk)
            ->delete($path);
    }

    public function url(
        string $path
    ): string {

        return Storage::disk($this->disk)
            ->url($path);
    }
}
