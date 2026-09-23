<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use NumbersNebula\NebulaCosmetics\Sections\SectionSchema;

class ResultsTimelineSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_results_timeline';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.results_timeline.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-history';

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
                'key' => 'milestones',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.results_timeline.milestones'),
                'add_label' => trans('nc::app.sections.results_timeline.add_milestone'),
                'fields' => [
                    [
                        'key' => 'day',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.results_timeline.day'),
                    ],
                    [
                        'key' => 'phase',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.results_timeline.phase'),
                    ],
                    [
                        'key' => 'what_happens',
                        'type' => SectionSchema::TEXTAREA,
                        'label' => trans('nc::app.sections.results_timeline.what_happens'),
                    ],
                    [
                        'key' => 'recommended_ritual',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.results_timeline.recommended_ritual'),
                    ],
                ],
            ],
            [
                'key' => 'doctor_note',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.results_timeline.doctor_note'),
            ],
        ];
    }
}
