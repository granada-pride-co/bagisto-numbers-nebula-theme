<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use NumbersNebula\NebulaCosmetics\Sections\SectionSchema;

class HeroSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_hero';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.hero.title';

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
                'key' => 'skin_image',
                'type' => SectionSchema::IMAGE,
                'label' => trans('nc::app.sections.hero.skin_image'),
            ],
            [
                'key' => 'eyebrow',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.hero.eyebrow'),
            ],
            [
                'key' => 'headline',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.hero.headline'),
            ],
            [
                'key' => 'subtitle',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.hero.subtitle'),
            ],
            [
                'key' => 'btn_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.hero.btn_text'),
            ],
            [
                'key' => 'btn_link',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.hero.btn_link'),
            ],
            [
                'key' => 'product_image',
                'type' => SectionSchema::IMAGE,
                'label' => trans('nc::app.sections.hero.product_image'),
            ],
            [
                'key' => 'brand_mark_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.hero.brand_mark_text'),
            ],
        ];
    }
}
