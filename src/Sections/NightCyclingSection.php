<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;

class NightCyclingSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_night_cycling';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.night_cycling.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-calendar';

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
                'key' => 'warning_note',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.night_cycling.warning_note'),
            ],
            [
                'key' => 'schedule_items',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.night_cycling.schedule_items'),
                'add_label' => trans('nc::app.sections.night_cycling.add_item'),
                'fields' => [
                    [
                        'key' => 'days',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.night_cycling.days'),
                    ],
                    [
                        'key' => 'treatment_name',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.night_cycling.treatment_name'),
                    ],
                    [
                        'key' => 'product_name',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.night_cycling.product_name'),
                    ],
                    [
                        'key' => 'action_type',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.night_cycling.action_type'),
                    ],
                    [
                        'key' => 'instructions',
                        'type' => SectionSchema::TEXTAREA,
                        'label' => trans('nc::app.sections.night_cycling.instructions'),
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
