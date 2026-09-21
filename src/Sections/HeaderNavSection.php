<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use Webkul\Theme\SectionSchema;

class HeaderNavSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_header_nav';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.header_nav.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-menu';

    /**
     * Whether a channel may hold only one section of this type.
     */
    protected bool $singleton = true;

    /**
     * Whether the layout draws the section on every page.
     */
    protected bool $layout = true;

    /**
     * Fields the editor draws for this section.
     */
    public function getFields(): array
    {
        return [
            [
                'key' => 'brand_title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.header_nav.brand_title'),
            ],
            [
                'key' => 'brand_subtitle',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.header_nav.brand_subtitle'),
            ],
            [
                'key' => 'font_arabic',
                'type' => SectionSchema::SELECT,
                'label' => trans('nc::app.sections.header_nav.font_arabic'),
                'options' => [
                    ['value' => 'Tajawal', 'label' => 'Tajawal (تجوال)'],
                    ['value' => 'IBM Plex Sans Arabic', 'label' => 'IBM Plex Sans Arabic'],
                    ['value' => 'Amiri', 'label' => 'Amiri (أميري)'],
                    ['value' => 'El Messiri', 'label' => 'El Messiri (المسيري)'],
                    ['value' => 'Cairo', 'label' => 'Cairo (القاهرة)'],
                ],
            ],
            [
                'key' => 'font_english',
                'type' => SectionSchema::SELECT,
                'label' => trans('nc::app.sections.header_nav.font_english'),
                'options' => [
                    ['value' => 'Cormorant Garamond', 'label' => 'Cormorant Garamond (Editorial Serif)'],
                    ['value' => 'DM Sans', 'label' => 'DM Sans (Clean Sans)'],
                    ['value' => 'Plus Jakarta Sans', 'label' => 'Plus Jakarta Sans'],
                    ['value' => 'Playfair Display', 'label' => 'Playfair Display'],
                    ['value' => 'Inter', 'label' => 'Inter'],
                ],
            ],
            [
                'key' => 'links',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.header_nav.navigation_links'),
                'add_label' => trans('nc::app.sections.header_nav.add_link'),
                'fields' => [
                    [
                        'key' => 'label',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.header_nav.link_label'),
                    ],
                    [
                        'key' => 'url',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.header_nav.link_url'),
                    ],
                ],
            ],
        ];
    }
}
