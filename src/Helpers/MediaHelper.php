<?php

namespace NumbersNebula\NebulaCosmetics\Helpers;

use Illuminate\Support\Facades\Storage;

class MediaHelper
{
    /**
     * Resolve image/media path reliably for theme sections.
     * Handles full URLs, paths starting with 'storage/', public paths, and storage disk paths.
     */
    public static function url(?string $path, string $fallback = ''): string
    {
        if (empty($path)) {
            return $fallback;
        }

        if (
            str_starts_with($path, 'http://')
            || str_starts_with($path, 'https://')
        ) {
            return $path;
        }

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        if (file_exists(public_path($path))) {
            return asset($path);
        }

        return Storage::url($path);
    }
}
