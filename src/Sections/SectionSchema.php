<?php

namespace NumbersNebula\NebulaCosmetics\Sections;

use Webkul\Theme\Enums\SectionTypeEnum;
use Webkul\Theme\Sections\SectionType;
use Webkul\Theme\SectionSchema as BaseSectionSchema;

class SectionSchema extends BaseSectionSchema
{
    /**
     * A single choice from a list of options.
     */
    public const SELECT = 'select';

    /**
     * Multiple choices from a list of options.
     */
    public const MULTISELECT = 'multiselect';

    /**
     * A visual color picker value stored as a hex string.
     */
    public const COLOR = 'color';

    /**
     * Look up the handler for one section type in a theme, falling back to core.
     */
    public function type(?string $themeCode, ?string $code): ?SectionType
    {
        if ($themeCode && $type = $this->types($themeCode)->get($code)) {
            return $type;
        }

        $core = SectionTypeEnum::tryFrom($code);

        if ($core) {
            return $this->resolve($core);
        }

        if (! $themeCode) {
            foreach (array_keys(config('themes.shop', [])) as $shopThemeCode) {
                if ($type = $this->types($shopThemeCode)->get($code)) {
                    return $type;
                }
            }
        }

        return null;
    }
}
