<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;

class FoundersLabSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_founders_lab';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.founders_lab.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-customer';

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
                'key' => 'quote',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.founders_lab.quote'),
            ],
            [
                'key' => 'badge_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.founders_lab.badge_text'),
            ],
            [
                'key' => 'founders',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.founders_lab.founders'),
                'add_label' => trans('nc::app.sections.founders_lab.add_founder'),
                'fields' => [
                    [
                        'key' => 'name',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.founders_lab.founder_name'),
                    ],
                    [
                        'key' => 'role',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.founders_lab.founder_role'),
                    ],
                    [
                        'key' => 'bio',
                        'type' => SectionSchema::TEXTAREA,
                        'label' => trans('nc::app.sections.founders_lab.founder_bio'),
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
