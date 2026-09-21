<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use Webkul\Theme\SectionSchema;

class CampaignSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_campaign';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.campaign.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-image';

    /**
     * Fields the editor draws for this section.
     */
    public function getFields(): array
    {
        return [
            [
                'key' => 'bg_image',
                'type' => SectionSchema::IMAGE,
                'label' => trans('nc::app.sections.campaign.bg_image'),
            ],
            [
                'key' => 'eyebrow',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.campaign.eyebrow'),
            ],
            [
                'key' => 'title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.campaign.title_field'),
            ],
            [
                'key' => 'description',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.campaign.description'),
            ],
            [
                'key' => 'btn_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.campaign.btn_text'),
            ],
            [
                'key' => 'btn_link',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.campaign.btn_link'),
            ],
        ];
    }
}
