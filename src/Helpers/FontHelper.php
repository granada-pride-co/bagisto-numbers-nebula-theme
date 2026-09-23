<?php

namespace NumbersNebula\NebulaCosmetics\Helpers;

class FontHelper
{
    /**
     * Map of known Google Fonts to their Google Fonts API v2 weight specs.
     */
    protected static array $fontSpecs = [
        'Tajawal' => ':wght@300;400;500;700;800;900',
        'Cairo' => ':wght@300;400;500;600;700;800;900',
        'Alexandria' => ':wght@300;400;500;600;700;800',
        'IBM Plex Sans Arabic' => ':wght@300;400;500;600;700',
        'Readex Pro' => ':wght@300;400;500;600;700',
        'El Messiri' => ':wght@400;500;600;700',
        'Amiri' => ':ital,wght@0,400;0,700;1,400;1,700',
        'Almarai' => ':wght@300;400;700;800',
        'Noto Sans Arabic' => ':wght@300;400;500;600;700;800',
        'Marhey' => ':wght@300;400;500;600;700',
        'Changa' => ':wght@300;400;500;600;700;800',
        'Aref Ruqaa' => ':wght@400;700',
        'Reem Kufi' => ':wght@400;500;600;700',
        'Rubik' => ':ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400',
        'Mada' => ':wght@300;400;500;600;700;800;900',
        'Lemonada' => ':wght@300;400;500;600;700',
        'Scheherazade New' => ':wght@400;500;600;700',
        'Cormorant Garamond' => ':ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,700',
        'Plus Jakarta Sans' => ':ital,wght@0,400;0,500;0,600;0,700;0,800;1,400',
        'DM Sans' => ':ital,wght@0,400;0,500;0,700;1,400;1,700',
        'Playfair Display' => ':ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,700',
        'Inter' => ':wght@300;400;500;600;700;800',
        'Courier Prime' => ':ital,wght@0,400;0,700;1,400;1,700',
        'Montserrat' => ':ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400',
        'Poppins' => ':ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400',
        'Lato' => ':ital,wght@0,300;0,400;0,700;1,400',
        'Roboto' => ':ital,wght@0,300;0,400;0,500;0,700;1,400',
        'Raleway' => ':ital,wght@0,300;0,400;0,500;0,600;0,700;1,400',
        'Bodoni Moda' => ':ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400',
        'Cinzel' => ':wght@400;500;600;700;800;900',
        'Prata' => ':wght@400',
        'Oswald' => ':wght@300;400;500;600;700',
    ];

    /**
     * Build Google Fonts stylesheet link query for given font families.
     */
    public static function getGoogleFontsUrl(array $fonts): string
    {
        $uniqueFonts = array_filter(array_unique(array_map('trim', $fonts)));

        if (empty($uniqueFonts)) {
            $uniqueFonts = ['Tajawal', 'Cormorant Garamond'];
        }

        $families = [];

        foreach ($uniqueFonts as $font) {
            $cleanFont = trim($font, " '\"");

            if (empty($cleanFont)) {
                continue;
            }

            $encoded = str_replace(' ', '+', $cleanFont);
            $spec = self::$fontSpecs[$cleanFont] ?? ':wght@400;600;700';

            $families[] = 'family='.$encoded.$spec;
        }

        return 'https://fonts.googleapis.com/css2?'.implode('&', $families).'&display=swap';
    }
}
