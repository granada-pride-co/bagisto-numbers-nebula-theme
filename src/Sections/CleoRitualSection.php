<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use NumbersNebula\NebulaCosmetics\Sections\SectionSchema;

class CleoRitualSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_cleo_ritual';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.cleo_ritual.title';

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
                'label' => trans('nc::app.sections.cleo_ritual.steps'),
                'add_label' => trans('nc::app.sections.cleo_ritual.add_step'),
                'fields' => [
                    [
                        'key' => 'step_number',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.cleo_ritual.step_number'),
                    ],
                    [
                        'key' => 'step_title',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.cleo_ritual.step_title'),
                    ],
                    [
                        'key' => 'product_name',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.cleo_ritual.product_name'),
                    ],
                    [
                        'key' => 'timing',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.cleo_ritual.timing'),
                    ],
                    [
                        'key' => 'key_actives',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.cleo_ritual.key_actives'),
                    ],
                    [
                        'key' => 'instructions',
                        'type' => SectionSchema::TEXTAREA,
                        'label' => trans('nc::app.sections.cleo_ritual.instructions'),
                    ],
                    [
                        'key' => 'product_link',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.cleo_ritual.product_link'),
                    ],
                ],
            ],
            [
                'key' => 'bundle_badge',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.cleo_ritual.bundle_badge'),
            ],
            [
                'key' => 'bundle_btn_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.cleo_ritual.bundle_btn_text'),
            ],
            [
                'key' => 'bundle_btn_link',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.cleo_ritual.bundle_btn_link'),
            ],
        ];
    }
}
