<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;

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
                'key' => 'bg_color',
                'type' => SectionSchema::COLOR,
                'label' => trans('nc::app.sections.common.bg_color'),
            ],
            [
                'key' => 'text_color',
                'type' => SectionSchema::COLOR,
                'label' => trans('nc::app.sections.common.text_color'),
            ],
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
                        'key' => 'category_id',
                        'type' => SectionSchema::SELECT,
                        'label' => trans('nc::app.sections.collections.select_category'),
                        'options' => array_merge(
                            [['id' => '', 'value' => '', 'label' => trans('nc::app.sections.collections.custom_or_none')]],
                            $this->categoryOptions()
                        ),
                    ],
                    [
                        'key' => 'image',
                        'type' => SectionSchema::IMAGE,
                        'label' => trans('nc::app.sections.collections.image_override'),
                    ],
                    [
                        'key' => 'tone',
                        'type' => SectionSchema::COLOR,
                        'label' => trans('nc::app.sections.collections.tone_color'),
                    ],
                    [
                        'key' => 'name',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.collections.collection_name_override'),
                    ],
                    [
                        'key' => 'link',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.collections.link_override'),
                    ],
                ],
            ],
        ];
    }
}
