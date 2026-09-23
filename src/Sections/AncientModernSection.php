<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;

class AncientModernSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_ancient_modern';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.ancient_modern.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-product';

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
                'key' => 'description',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.common.description'),
            ],
            [
                'key' => 'cards',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.ancient_modern.cards'),
                'add_label' => trans('nc::app.sections.ancient_modern.add_card'),
                'fields' => [
                    [
                        'key' => 'ancient_name',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.ancient_modern.ancient_name'),
                    ],
                    [
                        'key' => 'ancient_origin',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.ancient_modern.ancient_origin'),
                    ],
                    [
                        'key' => 'ancient_desc',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.ancient_modern.ancient_desc'),
                    ],
                    [
                        'key' => 'modern_active',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.ancient_modern.modern_active'),
                    ],
                    [
                        'key' => 'modern_function',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.ancient_modern.modern_function'),
                    ],
                    [
                        'key' => 'badge',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.ancient_modern.badge'),
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
