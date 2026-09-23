<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;

class AncientHeritageSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_ancient_heritage';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.ancient_heritage.title';

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
                'key' => 'stories',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.ancient_heritage.stories'),
                'add_label' => trans('nc::app.sections.ancient_heritage.add_story'),
                'fields' => [
                    [
                        'key' => 'title',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.ancient_heritage.story_title'),
                    ],
                    [
                        'key' => 'tag',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.ancient_heritage.story_tag'),
                    ],
                    [
                        'key' => 'story',
                        'type' => SectionSchema::TEXTAREA,
                        'label' => trans('nc::app.sections.ancient_heritage.story_content'),
                    ],
                    [
                        'key' => 'modern_takeaway',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.ancient_heritage.modern_takeaway'),
                    ],
                ],
            ],
            [
                'key' => 'community_title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.ancient_heritage.community_title'),
            ],
            [
                'key' => 'community_text',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.ancient_heritage.community_text'),
            ],
        ];
    }
}
