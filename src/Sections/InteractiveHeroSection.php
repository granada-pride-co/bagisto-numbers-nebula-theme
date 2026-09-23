<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;

class InteractiveHeroSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_interactive_hero';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.interactive_hero.title';

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
                'label' => trans('nc::app.sections.interactive_hero.bg_color'),
            ],
            [
                'key' => 'text_color',
                'type' => SectionSchema::COLOR,
                'label' => trans('nc::app.sections.common.text_color'),
            ],
            [
                'key' => 'accent_color',
                'type' => SectionSchema::COLOR,
                'label' => trans('nc::app.sections.interactive_hero.accent_color'),
            ],
            [
                'key' => 'disc_color',
                'type' => SectionSchema::COLOR,
                'label' => trans('nc::app.sections.interactive_hero.disc_color'),
            ],
            [
                'key' => 'eyebrow',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.interactive_hero.eyebrow'),
            ],
            [
                'key' => 'title_line_1',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.interactive_hero.title_line_1'),
            ],
            [
                'key' => 'title_line_2',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.interactive_hero.title_line_2'),
            ],
            [
                'key' => 'title_accent',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.interactive_hero.title_accent'),
            ],
            [
                'key' => 'subtitle',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.interactive_hero.subtitle'),
            ],
            [
                'key' => 'btn_primary_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.interactive_hero.btn_primary_text'),
            ],
            [
                'key' => 'btn_primary_link',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.interactive_hero.btn_primary_link'),
            ],
            [
                'key' => 'btn_ghost_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.interactive_hero.btn_ghost_text'),
            ],
            [
                'key' => 'btn_ghost_link',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.interactive_hero.btn_ghost_link'),
            ],
            [
                'key' => 'hint_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.interactive_hero.hint_text'),
            ],
            [
                'key' => 'hint_sub',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.interactive_hero.hint_sub'),
            ],
            [
                'key' => 'modal_title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.interactive_hero.modal_title'),
            ],
            [
                'key' => 'modal_subtitle',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.interactive_hero.modal_subtitle'),
            ],
        ];
    }
}
