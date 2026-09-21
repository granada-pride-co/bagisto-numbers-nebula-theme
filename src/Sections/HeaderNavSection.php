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
