<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;

class ManifestoSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_manifesto';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.manifesto.title';

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
                'key' => 'quote',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.manifesto.quote'),
            ],
            [
                'key' => 'author',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.manifesto.author'),
            ],
        ];
    }
}
