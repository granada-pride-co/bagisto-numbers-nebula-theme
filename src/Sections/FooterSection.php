<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use Webkul\Theme\SectionSchema;

class FooterSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_footer';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.footer.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-layout';

    /**
     * Whether a channel may hold only one section of this type.
     */
    protected bool $singleton = true;

    /**
     * Whether the section is fixed to the bottom of the page.
     */
    protected bool $pinned = true;

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
                'key' => 'brand_description',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.footer.brand_description'),
            ],
            [
                'key' => 'location',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.location'),
            ],
            [
                'key' => 'copyright',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.copyright'),
            ],
            [
                'key' => 'social_links',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.social_links'),
            ],
        ];
    }
}
