<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;

class BeautyMythsSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_beauty_myths';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.beauty_myths.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-information';

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
                'key' => 'subtitle',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.common.subtitle'),
            ],
            [
                'key' => 'myths',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.beauty_myths.myths'),
                'add_label' => trans('nc::app.sections.beauty_myths.add_myth'),
                'fields' => [
                    [
                        'key' => 'myth_text',
                        'type' => SectionSchema::TEXTAREA,
                        'label' => trans('nc::app.sections.beauty_myths.myth_text'),
                    ],
                    [
                        'key' => 'truth_text',
                        'type' => SectionSchema::TEXTAREA,
                        'label' => trans('nc::app.sections.beauty_myths.truth_text'),
                    ],
                    [
                        'key' => 'tag',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.beauty_myths.tag'),
                    ],
                ],
            ],
            [
                'key' => 'footer_note',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.beauty_myths.footer_note'),
            ],
        ];
    }
}
