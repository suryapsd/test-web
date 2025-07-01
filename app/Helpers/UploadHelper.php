<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UploadHelper
{
    /**
     * Upload and compress an image using Intervention Image.
     *
     * @param  UploadedFile $file           The image file to be uploaded.
     * @param  string       $name           Desired filename without extension.
     * @param  string       $targetLocation The directory where the file will be stored.
     * @param  int          $maxWidth       The maximum width for resizing (default: 1200px).
     * @param  int          $quality        The compression quality (default: 80).
     * @return string|null                  The stored file path or null if upload fails.
     */
    public static function upload(UploadedFile $file, string $name, string $targetLocation, int $maxWidth = 1000, int $quality = 70): ?string
    {
        if (!$file->isValid()) {    
            return null;
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = $name . '.' . $extension;
        $filePath = $targetLocation . '/' . $filename;

        // Pastikan folder target ada
        if (!File::exists($targetLocation)) {
            File::makeDirectory($targetLocation, 0755, true, true);
        }

        $file->move($targetLocation, $filename);

        return $filePath;
    }

    /**
     * Update file lama dengan yang baru.
     *
     * @param  UploadedFile $file           File baru.
     * @param  string       $name           Nama file yang diinginkan (tanpa ekstensi).
     * @param  string       $targetLocation Direktori penyimpanan.
     * @param  string|null  $oldFilePath    Path file lama yang akan dihapus.
     * @return string                       Path file baru.
     */
    public static function update(UploadedFile $file, string $name, string $targetLocation, ?string $oldFilePath = null): string
    {
        // Hapus file lama jika ada
        if ($oldFilePath && File::exists($oldFilePath)) {
            File::delete($oldFilePath);
        }

        return self::upload($file, $name, $targetLocation) ?? '';
    }

    /**
     * Hapus file dari penyimpanan.
     *
     * @param  string $filePath Path file yang akan dihapus.
     * @return bool             True jika berhasil, false jika gagal.
     */
    public static function deleteFile(string $filePath): bool
    {
        if (File::exists($filePath)) {
            return File::delete($filePath);
        }

        return false;
    }
}
