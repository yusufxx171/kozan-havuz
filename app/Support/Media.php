<?php

namespace App\Support;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

/**
 * The disk that holds uploaded media (local "public" disk in development, Cloudflare R2 in production).
 */
class Media
{
    public static function diskName(): string
    {
        return config('filesystems.media_disk', 'public');
    }

    public static function disk(): Filesystem
    {
        return Storage::disk(self::diskName());
    }

    public static function url(?string $path): string
    {
        return $path ? self::disk()->url($path) : '';
    }
}
