<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use NumbersNebula\NebulaCosmetics\Sections\SectionSchema;

class FooterSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_footer';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.footer.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-layout';

    /**
     * Whether a channel may hold only one section of this type.
     */
    protected bool $singleton = true;

    /**
     * Whether the section is fixed to the bottom of the page.
     */
    protected bool $pinned = true;

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
                'key' => 'brand_title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.brand_title'),
            ],
            [
                'key' => 'brand_subtitle',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.brand_subtitle'),
            ],
            [
                'key' => 'brand_description',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.footer.brand_description'),
            ],
            [
                'key' => 'column_1_title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.column_1_title'),
            ],
            [
                'key' => 'column_1_links',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.footer.column_1_links'),
                'add_label' => trans('nc::app.sections.footer.add_link'),
                'fields' => [
                    [
                        'key' => 'title',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.footer.link_title'),
                    ],
                    [
                        'key' => 'url',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.footer.link_url'),
                    ],
                ],
            ],
            [
                'key' => 'column_2_title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.column_2_title'),
            ],
            [
                'key' => 'column_2_links',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.footer.column_2_links'),
                'add_label' => trans('nc::app.sections.footer.add_link'),
                'fields' => [
                    [
                        'key' => 'title',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.footer.link_title'),
                    ],
                    [
                        'key' => 'url',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.footer.link_url'),
                    ],
                ],
            ],
            [
                'key' => 'column_3_title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.column_3_title'),
            ],
            [
                'key' => 'column_3_links',
                'type' => SectionSchema::REPEATER,
                'label' => trans('nc::app.sections.footer.column_3_links'),
                'add_label' => trans('nc::app.sections.footer.add_link'),
                'fields' => [
                    [
                        'key' => 'title',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.footer.link_title'),
                    ],
                    [
                        'key' => 'url',
                        'type' => SectionSchema::TEXT,
                        'label' => trans('nc::app.sections.footer.link_url'),
                    ],
                ],
            ],
            [
                'key' => 'location',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.location'),
            ],
            [
                'key' => 'social_links',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.social_links'),
            ],
            [
                'key' => 'copyright',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.copyright'),
            ],
            [
                'key' => 'show_developer_credit',
                'type' => SectionSchema::SELECT,
                'label' => trans('nc::app.sections.footer.show_developer_credit'),
                'options' => [
                    ['value' => '1', 'label' => trans('nc::app.sections.footer.status_show')],
                    ['value' => '0', 'label' => trans('nc::app.sections.footer.status_hide')],
                ],
            ],
            [
                'key' => 'developer_credit_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.developer_credit_text'),
            ],
            [
                'key' => 'developer_credit_url',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.footer.developer_credit_url'),
            ],
        ];
    }

    /**
     * Clean the options before they are stored or rendered.
     */
    public function sanitize(array $options): array
    {
        foreach (['column_1_links', 'column_2_links', 'column_3_links'] as $columnKey) {
            if (
                isset($options[$columnKey])
                && is_array($options[$columnKey])
            ) {
                foreach ($options[$columnKey] as $index => $link) {
                    if (
                        is_array($link)
                        && isset($link['url'])
                    ) {
                        $options[$columnKey][$index]['url'] = $this->sanitizeUrl($link['url']);
                    }
                }
            }
        }

        if (isset($options['developer_credit_url'])) {
            $options['developer_credit_url'] = $this->sanitizeUrl($options['developer_credit_url']);
        }

        return $options;
    }
}
