<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use Webkul\Theme\SectionSchema;

class HtmlSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_html';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.html.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-code';

    /**
     * Fields the editor draws for this section.
     */
    public function getFields(): array
    {
        return [
            [
                'key' => 'title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.html.section_title'),
            ],
            [
                'key' => 'html',
                'type' => SectionSchema::CODE,
                'label' => trans('nc::app.sections.html.html_content'),
            ],
            [
                'key' => 'css',
                'type' => SectionSchema::CODE,
                'label' => trans('nc::app.sections.html.css_content'),
            ],
        ];
    }
}
