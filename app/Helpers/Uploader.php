<?php


namespace App\Helpers;


class Uploader
{
    public static function uploadFile(string $key, string $path): string {
        $fileName = self::generateFileName($key);
        request()->file($key)->storeAs($path, $fileName);
        return $fileName;
    }

    public static function removeFile(string $path, string $fileName) {
        \Storage::delete(sprintf('%s/%s', $path, $fileName));
    }

    /** protected, only works in this namespace */
    protected static function generateFileName(string $key): string {
        $extension = request()->file($key)->getClientOriginalExtension();
        return sprintf('%s-%s.%s', auth()->id(), now()->timestamp, $extension);
    }
}