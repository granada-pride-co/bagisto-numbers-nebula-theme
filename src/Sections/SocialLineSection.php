<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;

class SocialLineSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_social_line';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.social_line.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-share';

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
                'key' => 'text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.social_line.text'),
            ],
            [
                'key' => 'handle',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.social_line.handle'),
            ],
            [
                'key' => 'link',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.social_line.link'),
            ],
            [
                'key' => 'items',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.social_line.items'),
                'add_label' => trans('nc::app.sections.social_line.add_item'),
                'fields' => [
                    [
                        'key' => 'image',
                        'type' => SectionSchema::IMAGE,
                        'label' => trans('nc::app.sections.social_line.image'),
                    ],
                    [
                        'key' => 'link',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.social_line.post_link'),
                    ],
                ],
            ],
        ];
    }
}
