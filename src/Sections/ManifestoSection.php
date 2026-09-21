<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use Webkul\Theme\SectionSchema;

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
