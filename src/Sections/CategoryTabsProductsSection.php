<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use NumbersNebula\NebulaCosmetics\Sections\SectionSchema;

class CategoryTabsProductsSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_category_tabs_products';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.category_tabs_products.title';

    /**
     * Icon class drawn on the type's tile.
     */
    protected string $icon = 'icon-product';

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
                'key' => 'eyebrow',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.common.eyebrow'),
            ],
            [
                'key' => 'title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.common.title'),
            ],
            [
                'key' => 'description',
                'type' => SectionSchema::TEXTAREA,
                'label' => trans('nc::app.sections.common.description'),
            ],
            [
                'key' => 'badge_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.category_tabs_products.badge_text'),
            ],
            [
                'key' => 'show_all_tab',
                'type' => SectionSchema::SELECT,
                'label' => trans('nc::app.sections.category_tabs_products.show_all_tab'),
                'options' => $this->yesNo(),
            ],
            [
                'key' => 'filters',
                'type' => SectionSchema::FILTERS,
                'label' => trans('nc::app.sections.category_tabs_products.filters'),
                'add_label' => trans('nc::app.sections.category_tabs_products.add_filter_btn'),
                'keys' => $this->filterKeys(),
            ],
            [
                'key' => 'btn_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.common.btn_text'),
            ],
            [
                'key' => 'btn_link',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.common.btn_link'),
            ],
        ];
    }

    /**
     * Filter keys available for querying category products.
     */
    protected function filterKeys(): array
    {
        return [
            [
                'value' => 'category_ids',
                'label' => trans('nc::app.sections.category_tabs_products.select_categories'),
                'multiple' => true,
                'options' => $this->categoryOptions(),
            ],
            [
                'value' => 'limit',
                'label' => trans('nc::app.sections.category_tabs_products.limit'),
                'options' => [
                    ['value' => '4', 'label' => '4'],
                    ['value' => '6', 'label' => '6'],
                    ['value' => '8', 'label' => '8'],
                    ['value' => '10', 'label' => '10'],
                    ['value' => '12', 'label' => '12'],
                    ['value' => '16', 'label' => '16'],
                    ['value' => '20', 'label' => '20'],
                ],
            ],
            [
                'value' => 'sort',
                'label' => trans('nc::app.sections.category_tabs_products.sort'),
                'options' => [
                    ['value' => 'created_at-desc', 'label' => trans('nc::app.sections.category_tabs_products.sort_newest')],
                    ['value' => 'created_at-asc', 'label' => trans('nc::app.sections.category_tabs_products.sort_oldest')],
                    ['value' => 'price-asc', 'label' => trans('nc::app.sections.category_tabs_products.sort_price_low')],
                    ['value' => 'price-desc', 'label' => trans('nc::app.sections.category_tabs_products.sort_price_high')],
                    ['value' => 'name-asc', 'label' => trans('nc::app.sections.category_tabs_products.sort_name_asc')],
                    ['value' => 'name-desc', 'label' => trans('nc::app.sections.category_tabs_products.sort_name_desc')],
                ],
            ],
            [
                'value' => 'featured',
                'label' => trans('nc::app.sections.category_tabs_products.featured'),
                'options' => $this->yesNo(),
            ],
            [
                'value' => 'new',
                'label' => trans('nc::app.sections.category_tabs_products.new'),
                'options' => $this->yesNo(),
            ],
        ];
    }
}
