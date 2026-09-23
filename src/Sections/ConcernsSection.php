<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use NumbersNebula\NebulaCosmetics\Sections\SectionSchema;

class ConcernsSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_concerns';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.concerns.title';

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
                'label' => trans('nc::app.sections.concerns.kicker'),
            ],
            [
                'key' => 'items',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.concerns.items'),
                'add_label' => trans('nc::app.sections.concerns.add_concern'),
                'fields' => [
                    [
                        'key' => 'category_id',
                        'type' => SectionSchema::SELECT,
                        'label' => trans('nc::app.sections.concerns.select_category'),
                        'options' => array_merge(
                            [['id' => '', 'value' => '', 'label' => trans('nc::app.sections.concerns.custom_or_none')]],
                            $this->categoryOptions()
                        ),
                    ],
                    [
                        'key' => 'name',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.concerns.concern_name'),
                    ],
                    [
                        'key' => 'copy',
                        'type' => SectionSchema::TEXTAREA,
                        'label' => trans('nc::app.sections.concerns.concern_copy'),
                    ],
                    [
                        'key' => 'image',
                        'type' => SectionSchema::IMAGE,
                        'label' => trans('nc::app.sections.concerns.concern_image'),
                    ],
                    [
                        'key' => 'btn_text',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.concerns.btn_text'),
                    ],
                    [
                        'key' => 'btn_link',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.concerns.btn_link'),
                    ],
                ],
            ],
        ];
    }
}
