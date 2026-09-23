<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use NumbersNebula\NebulaCosmetics\Sections\SectionSchema;

class ClimateDefenseSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_climate_defense';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.climate_defense.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-shield';

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
                'key' => 'eyebrow',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.common.eyebrow'),
            ],
            [
                'key' => 'title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.common.title'),
            ],
            [
                'key' => 'story_paragraph_1',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.climate_defense.story_paragraph_1'),
            ],
            [
                'key' => 'story_paragraph_2',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.climate_defense.story_paragraph_2'),
            ],
            [
                'key' => 'image',
                'type' => SectionSchema::IMAGE,
                'label' => trans('nc::app.sections.common.image'),
            ],
            [
                'key' => 'stats',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.climate_defense.stats'),
                'add_label' => trans('nc::app.sections.climate_defense.add_stat'),
                'fields' => [
                    [
                        'key' => 'figure',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.climate_defense.figure'),
                    ],
                    [
                        'key' => 'label',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.climate_defense.label'),
                    ],
                    [
                        'key' => 'desc',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.climate_defense.desc'),
                    ],
                ],
            ],
            [
                'key' => 'btn_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.common.btn_text'),
            ],
            [
                'key' => 'btn_link',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.common.btn_link'),
            ],
        ];
    }
}
