<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use NumbersNebula\NebulaCosmetics\Sections\SectionSchema;

class RoutineSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_routine';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.routine.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-cms';

    /**
     * Fields the editor draws for this section.
     */
    public function getFields(): array
    {
        return [
            [
                'key' => 'bg_color',
                'type' => SectionSchema::COLOR,
                'label' => trans('nc::app.sections.routine.bg_color'),
            ],
            [
                'key' => 'text_color',
                'type' => SectionSchema::COLOR,
                'label' => trans('nc::app.sections.common.text_color'),
            ],
            [
                'key' => 'image',
                'type' => SectionSchema::IMAGE,
                'label' => trans('nc::app.sections.routine.image'),
            ],
            [
                'key' => 'eyebrow',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.routine.eyebrow'),
            ],
            [
                'key' => 'title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.routine.title_field'),
            ],
            [
                'key' => 'description',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.routine.description'),
            ],
            [
                'key' => 'steps',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.routine.steps'),
                'add_label' => trans('nc::app.sections.routine.add_step'),
                'fields' => [
                    [
                        'key' => 'number',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.routine.step_number'),
                    ],
                    [
                        'key' => 'title',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.routine.step_title'),
                    ],
                    [
                        'key' => 'copy',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.routine.step_copy'),
                    ],
                ],
            ],
            [
                'key' => 'btn_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.routine.btn_text'),
            ],
            [
                'key' => 'btn_link',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.routine.btn_link'),
            ],
        ];
    }
}
