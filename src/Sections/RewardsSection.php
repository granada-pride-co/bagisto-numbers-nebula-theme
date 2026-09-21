<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use Webkul\Theme\SectionSchema;

class RewardsSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_rewards';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.rewards.title';

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
                'key' => 'image',
                'type' => SectionSchema::IMAGE,
                'label' => trans('nc::app.sections.rewards.image'),
            ],
            [
                'key' => 'eyebrow',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.rewards.eyebrow'),
            ],
            [
                'key' => 'title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.rewards.title_field'),
            ],
            [
                'key' => 'description',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.rewards.description'),
            ],
            [
                'key' => 'link_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.rewards.link_text'),
            ],
            [
                'key' => 'link_url',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.rewards.link_url'),
            ],
        ];
    }
}
