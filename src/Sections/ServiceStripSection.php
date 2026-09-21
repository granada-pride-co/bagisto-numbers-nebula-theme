<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use Webkul\Theme\SectionSchema;

class ServiceStripSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_service_strip';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.service_strip.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-heart';

    /**
     * Fields the editor draws for this section.
     */
    public function getFields(): array
    {
        return [
            [
                'key' => 'items',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.service_strip.items'),
                'add_label' => trans('nc::app.sections.service_strip.add_item'),
                'fields' => [
                    [
                        'key' => 'title',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.service_strip.item_title'),
                    ],
                    [
                        'key' => 'description',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.service_strip.item_desc'),
                    ],
                ],
            ],
        ];
    }
}
