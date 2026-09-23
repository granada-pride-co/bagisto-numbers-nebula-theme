<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;

class PatchTestSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_patch_test';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.patch_test.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-checkbox';

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
                'key' => 'steps',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.patch_test.steps'),
                'add_label' => trans('nc::app.sections.patch_test.add_step'),
                'fields' => [
                    [
                        'key' => 'step_number',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.patch_test.step_number'),
                    ],
                    [
                        'key' => 'step_title',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.patch_test.step_title'),
                    ],
                    [
                        'key' => 'step_desc',
                        'type' => SectionSchema::TEXTAREA,
                        'label' => trans('nc::app.sections.patch_test.step_desc'),
                    ],
                ],
            ],
            [
                'key' => 'pregnancy_advice_title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.patch_test.pregnancy_advice_title'),
            ],
            [
                'key' => 'pregnancy_advice_text',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.patch_test.pregnancy_advice_text'),
            ],
            [
                'key' => 'doctor_contact_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.patch_test.doctor_contact_text'),
            ],
            [
                'key' => 'doctor_contact_link',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.patch_test.doctor_contact_link'),
            ],
        ];
    }
}
