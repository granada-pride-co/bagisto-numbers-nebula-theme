<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use Webkul\Theme\SectionSchema;

class AnnouncementSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_announcement';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.announcement.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-notification';

    /**
     * Whether a channel may hold only one section of this type.
     */
    protected bool $singleton = true;

    /**
     * Whether the layout draws the section on every page.
     */
    protected bool $layout = true;

    /**
     * Fields the editor draws for this section.
     */
    public function getFields(): array
    {
        return [
            [
                'key' => 'speed',
                'type' => SectionSchema::SELECT,
                'label' => trans('nc::app.sections.announcement.speed'),
                'options' => [
                    ['value' => '3000', 'label' => '3s'],
                    ['value' => '4000', 'label' => '4s'],
                    ['value' => '5000', 'label' => '5s'],
                    ['value' => '7000', 'label' => '7s'],
                ],
            ],
            [
                'key' => 'bg_color',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.announcement.bg_color'),
            ],
            [
                'key' => 'text_color',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.announcement.text_color'),
            ],
            [
                'key' => 'messages',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.announcement.messages'),
                'add_label' => trans('nc::app.sections.announcement.add_message'),
                'fields' => [
                    [
                        'key' => 'text',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.announcement.text'),
                    ],
                    [
                        'key' => 'link',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.announcement.link'),
                    ],
                    [
                        'key' => 'btn_text',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.announcement.btn_text'),
                    ],
                ],
            ],
            [
                'key' => 'text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.announcement.text'),
            ],
            [
                'key' => 'link',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.announcement.link'),
            ],
            [
                'key' => 'btn_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.announcement.btn_text'),
            ],
        ];
    }
}
