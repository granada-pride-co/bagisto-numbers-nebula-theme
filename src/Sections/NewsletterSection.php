<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;

class NewsletterSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_newsletter';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.newsletter.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-mail';

    /**
     * Fields the editor draws for this section.
     */
    public function getFields(): array
    {
        return [
            [
                'key' => 'eyebrow',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.newsletter.eyebrow'),
            ],
            [
                'key' => 'title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.newsletter.title_field'),
            ],
            [
                'key' => 'description',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.newsletter.description'),
            ],
            [
                'key' => 'placeholder',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.newsletter.placeholder'),
            ],
            [
                'key' => 'bg_color',
                'type' => SectionSchema::COLOR,
                'label' => trans('nc::app.sections.newsletter.bg_color'),
            ],
            [
                'key' => 'text_color',
                'type' => SectionSchema::COLOR,
                'label' => trans('nc::app.sections.newsletter.text_color'),
            ],
            [
                'key' => 'btn_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.newsletter.btn_text'),
            ],
        ];
    }
}
