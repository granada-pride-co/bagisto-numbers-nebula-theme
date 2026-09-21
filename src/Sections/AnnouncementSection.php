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
