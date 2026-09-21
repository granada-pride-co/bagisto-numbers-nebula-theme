<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Sections\SectionType;
use Webkul\Theme\SectionSchema;

class FeaturedProductsSection extends SectionType
{
    /**
     * Code the section is stored under.
     */
    protected string $code = 'nc_featured_products';

    /**
     * Translation key or title of the section.
     */
    protected ?string $title = 'nc::app.sections.featured_products.title';

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
                'key' => 'eyebrow',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.featured_products.eyebrow'),
            ],
            [
                'key' => 'title',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.featured_products.title_field'),
            ],
            [
                'key' => 'badge_text',
                'type' => SectionSchema::TEXT,
                'label' => trans('nc::app.sections.featured_products.badge_text'),
            ],
            [
                'key' => 'filters',
                'type' => SectionSchema::FILTERS,
                'label' => trans('nc::app.sections.featured_products.filters'),
                'add_label' => trans('nc::app.sections.featured_products.add_filter_btn'),
                'keys' => $this->filterKeys(),
            ],
        ];
    }

    /**
     * Filter keys available for picking products.
     */
    protected function filterKeys(): array
    {
        return [
            [
                'value' => 'category_id',
                'label' => trans('nc::app.sections.featured_products.select_category'),
                'options' => $this->categoryOptions(),
            ],
            [
                'value' => 'limit',
                'label' => trans('nc::app.sections.featured_products.limit'),
                'options' => [
                    ['value' => '4', 'label' => '4'],
                    ['value' => '6', 'label' => '6'],
                    ['value' => '8', 'label' => '8'],
                    ['value' => '10', 'label' => '10'],
                    ['value' => '12', 'label' => '12'],
                ],
            ],
            [
                'value' => 'sort',
                'label' => trans('nc::app.sections.featured_products.sort'),
                'options' => [
                    ['value' => 'desc', 'label' => trans('nc::app.sections.featured_products.newest')],
                    ['value' => 'asc', 'label' => trans('nc::app.sections.featured_products.oldest')],
                ],
            ],
        ];
    }
}
