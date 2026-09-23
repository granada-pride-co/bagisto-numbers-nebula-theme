<?php

namespace NumbersNebula\NebulaCosmetics\Helpers;

use Illuminate\Support\Facades\Storage;
use Webkul\Category\Repositories\CategoryRepository;

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

        $cleanPath = ltrim($path, '/');

        if (file_exists(public_path('themes/shop/nebula-cosmetics/'.$cleanPath))) {
            return asset('themes/shop/nebula-cosmetics/'.$cleanPath);
        }

        $baseName = basename($path);

        if (file_exists(public_path('themes/shop/nebula-cosmetics/images/'.$baseName))) {
            return asset('themes/shop/nebula-cosmetics/images/'.$baseName);
        }

        if (Storage::disk('public')->exists($cleanPath)) {
            return Storage::url($cleanPath);
        }

        return $fallback ?: Storage::url($path);
    }

    /**
     * Resolve the image URL for a category with ancestor and product fallback.
     */
    public static function categoryImage(mixed $category, string $fallback = ''): string
    {
        if (is_numeric($category)) {
            $category = app(CategoryRepository::class)->find($category);
        }

        if (! $category) {
            return $fallback;
        }

        if (! empty($category->logo_url)) {
            return $category->logo_url;
        }

        if (! empty($category->banner_url)) {
            return $category->banner_url;
        }

        $parent = $category->parent;

        while ($parent) {
            if (! empty($parent->logo_url)) {
                return $parent->logo_url;
            }

            if (! empty($parent->banner_url)) {
                return $parent->banner_url;
            }

            $parent = $parent->parent;
        }

        $product = $category->products()->first();

        if (! empty($product?->base_image_url)) {
            return $product->base_image_url;
        }

        return $fallback;
    }
}
