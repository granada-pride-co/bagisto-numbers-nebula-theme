<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use NumbersNebula\NebulaCosmetics\Sections\SectionSchema;

class ActivesIndexSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_actives_index';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.actives_index.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-attribute';

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
                'key' => 'actives',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.actives_index.actives'),
                'add_label' => trans('nc::app.sections.actives_index.add_active'),
                'fields' => [
                    [
                        'key' => 'name',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.actives_index.active_name'),
                    ],
                    [
                        'key' => 'percentage',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.actives_index.percentage'),
                    ],
                    [
                        'key' => 'ancient_counterpart',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.actives_index.ancient_counterpart'),
                    ],
                    [
                        'key' => 'clinical_function',
                        'type' => SectionSchema::TEXTAREA,
                        'label' => trans('nc::app.sections.actives_index.clinical_function'),
                    ],
                    [
                        'key' => 'clean_promise',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.actives_index.clean_promise'),
                    ],
                ],
            ],
        ];
    }
}
