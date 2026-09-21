<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use Webkul\Theme\SectionSchema;

class CollectionsSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_collections';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.collections.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-category';

    /**
     * Fields the editor draws for this section.
     */
    public function getFields(): array
    {
        return [
            [
                'key' => 'kicker',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.collections.kicker'),
            ],
            [
                'key' => 'items',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.collections.items'),
                'add_label' => trans('nc::app.sections.collections.add_collection'),
                'fields' => [
                    [
                        'key' => 'name',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.collections.collection_name'),
                    ],
                    [
                        'key' => 'format',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.collections.format'),
                    ],
                    [
                        'key' => 'tone',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.collections.tone_color'),
                    ],
                    [
                        'key' => 'link',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.collections.link'),
                    ],
                ],
            ],
        ];
    }
}
