<?php

namespace NumbersNebula\NebulaCosmetics\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Webkul\Category\Models\Category;

class CleoLabDataSeeder extends Seeder
{
    /**
     * Attribute type → value column mapping.
     *
     * @var array<string,string>
     */
    protected array $typeFields = [
        'text' => 'text_value',
        'textarea' => 'text_value',
        'price' => 'float_value',
        'boolean' => 'boolean_value',
        'select' => 'integer_value',
        'multiselect' => 'text_value',
        'datetime' => 'datetime_value',
        'date' => 'date_value',
        'file' => 'text_value',
        'image' => 'text_value',
        'checkbox' => 'text_value',
    ];

    /**
     * Run all Cleo's Lab demo data seeds.
     */
    public function run(): string
    {
        $results = [];

        $results[] = $this->seedAttributes();
        $results[] = $this->seedAttributeFamily();
        $results[] = $this->seedCategories();
        $results[] = $this->seedProducts();

        try {
            app(CleoSectionsSeeder::class)->run();
            $results[] = '10 Custom Theme Sections (EN, FR, AR)';
        } catch (\Throwable $e) {
        }

        try {
            Artisan::call('indexer:index');
        } catch (\Throwable $e) {
        }

        return implode(' | ', $results);
    }

    /**
     * Get active supported locales from the system.
     *
     * @return array<string>
     */
    protected function getActiveLocales(): array
    {
        $allLocales = DB::table('locales')->pluck('code')->toArray();
        $supported = ['en', 'ar'];

        if (in_array('fr', $allLocales)) {
            $supported[] = 'fr';
        }

        return array_values(array_intersect($supported, $allLocales));
    }

    // =========================================================================
    // Attributes
    // =========================================================================

    /**
     * Seed custom Cleo's Lab attributes.
     */
    protected function seedAttributes(): string
    {
        $now = now();

        $attributes = [
            [
                'code' => 'cl_skin_type',
                'admin_name' => 'Skin Type',
                'type' => 'multiselect',
                'validation' => null,
                'position' => 30,
                'is_required' => 0,
                'is_unique' => 0,
                'value_per_channel' => 0,
                'value_per_locale' => 0,
                'is_filterable' => 1,
                'is_configurable' => 0,
                'is_user_defined' => 1,
                'is_visible_on_front' => 1,
                'swatch_type' => null,
                'is_comparable' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'cl_key_ingredients',
                'admin_name' => 'Key Ingredients',
                'type' => 'textarea',
                'validation' => null,
                'position' => 31,
                'is_required' => 0,
                'is_unique' => 0,
                'value_per_channel' => 0,
                'value_per_locale' => 1,
                'is_filterable' => 0,
                'is_configurable' => 0,
                'is_user_defined' => 1,
                'is_visible_on_front' => 1,
                'swatch_type' => null,
                'is_comparable' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'cl_usage_ritual',
                'admin_name' => 'Usage / Ritual Instructions',
                'type' => 'textarea',
                'validation' => null,
                'position' => 32,
                'is_required' => 0,
                'is_unique' => 0,
                'value_per_channel' => 0,
                'value_per_locale' => 1,
                'is_filterable' => 0,
                'is_configurable' => 0,
                'is_user_defined' => 1,
                'is_visible_on_front' => 1,
                'swatch_type' => null,
                'is_comparable' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'cl_net_weight',
                'admin_name' => 'Net Weight / Volume',
                'type' => 'text',
                'validation' => null,
                'position' => 33,
                'is_required' => 0,
                'is_unique' => 0,
                'value_per_channel' => 0,
                'value_per_locale' => 0,
                'is_filterable' => 0,
                'is_configurable' => 0,
                'is_user_defined' => 1,
                'is_visible_on_front' => 1,
                'swatch_type' => null,
                'is_comparable' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'cl_scent_profile',
                'admin_name' => 'Scent Profile',
                'type' => 'text',
                'validation' => null,
                'position' => 34,
                'is_required' => 0,
                'is_unique' => 0,
                'value_per_channel' => 0,
                'value_per_locale' => 1,
                'is_filterable' => 0,
                'is_configurable' => 0,
                'is_user_defined' => 1,
                'is_visible_on_front' => 1,
                'swatch_type' => null,
                'is_comparable' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'cl_vegan',
                'admin_name' => 'Vegan Formula',
                'type' => 'boolean',
                'validation' => null,
                'position' => 35,
                'is_required' => 0,
                'is_unique' => 0,
                'value_per_channel' => 0,
                'value_per_locale' => 0,
                'is_filterable' => 1,
                'is_configurable' => 0,
                'is_user_defined' => 1,
                'is_visible_on_front' => 1,
                'swatch_type' => null,
                'is_comparable' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $created = 0;

        foreach ($attributes as $attr) {
            if (! DB::table('attributes')->where('code', $attr['code'])->exists()) {
                DB::table('attributes')->insert($attr);
                $created++;
            }
        }

        $this->seedSkinTypeOptions();
        $this->seedAttributeTranslations();

        return "Attributes: {$created} created";
    }

    /**
     * Seed multiselect options for the cl_skin_type attribute.
     */
    protected function seedSkinTypeOptions(): void
    {
        $attributeId = DB::table('attributes')->where('code', 'cl_skin_type')->value('id');

        if (! $attributeId) {
            return;
        }

        $options = [
            [
                'admin_name' => 'All Skin Types',
                'sort_order' => 1,
                'labels' => [
                    'en' => 'All Skin Types',
                    'ar' => 'جميع أنواع البشرة',
                    'fr' => 'Tous types de peau',
                ],
            ],
            [
                'admin_name' => 'Dry',
                'sort_order' => 2,
                'labels' => [
                    'en' => 'Dry',
                    'ar' => 'بشرة جافة',
                    'fr' => 'Peau sèche',
                ],
            ],
            [
                'admin_name' => 'Oily',
                'sort_order' => 3,
                'labels' => [
                    'en' => 'Oily',
                    'ar' => 'بشرة دهنية',
                    'fr' => 'Peau grasse',
                ],
            ],
            [
                'admin_name' => 'Combination',
                'sort_order' => 4,
                'labels' => [
                    'en' => 'Combination',
                    'ar' => 'بشرة مختلطة',
                    'fr' => 'Peau mixte',
                ],
            ],
            [
                'admin_name' => 'Sensitive',
                'sort_order' => 5,
                'labels' => [
                    'en' => 'Sensitive',
                    'ar' => 'بشرة حساسة',
                    'fr' => 'Peau sensible',
                ],
            ],
            [
                'admin_name' => 'Normal',
                'sort_order' => 6,
                'labels' => [
                    'en' => 'Normal',
                    'ar' => 'بشرة عادية',
                    'fr' => 'Peau normale',
                ],
            ],
        ];

        $activeLocales = $this->getActiveLocales();

        foreach ($options as $opt) {
            $optionId = DB::table('attribute_options')
                ->where('attribute_id', $attributeId)
                ->where('admin_name', $opt['admin_name'])
                ->value('id');

            if (! $optionId) {
                $optionId = DB::table('attribute_options')->insertGetId([
                    'admin_name' => $opt['admin_name'],
                    'attribute_id' => $attributeId,
                    'sort_order' => $opt['sort_order'],
                    'swatch_value' => null,
                ]);
            }

            foreach ($activeLocales as $locale) {
                $exists = DB::table('attribute_option_translations')
                    ->where('attribute_option_id', $optionId)
                    ->where('locale', $locale)
                    ->exists();

                $targetLabel = $opt['labels'][$locale] ?? $opt['labels']['en'];

                if (! $exists) {
                    DB::table('attribute_option_translations')->insert([
                        'attribute_option_id' => $optionId,
                        'locale' => $locale,
                        'label' => $targetLabel,
                    ]);
                } elseif ($locale === 'ar') {
                    $current = DB::table('attribute_option_translations')
                        ->where('attribute_option_id', $optionId)
                        ->where('locale', 'ar')
                        ->value('label');

                    if ($current === $opt['admin_name']) {
                        DB::table('attribute_option_translations')
                            ->where('attribute_option_id', $optionId)
                            ->where('locale', 'ar')
                            ->update(['label' => $targetLabel]);
                    }
                }
            }
        }
    }

    /**
     * Seed human-readable attribute name translations.
     */
    protected function seedAttributeTranslations(): void
    {
        $translations = [
            'cl_skin_type' => [
                'en' => 'Skin Type',
                'ar' => 'نوع البشرة',
                'fr' => 'Type de peau',
            ],
            'cl_key_ingredients' => [
                'en' => 'Key Ingredients',
                'ar' => 'المكونات الرئيسية',
                'fr' => 'Ingrédients clés',
            ],
            'cl_usage_ritual' => [
                'en' => 'Usage / Ritual Instructions',
                'ar' => 'طريقة الاستخدام والطقوس',
                'fr' => "Rituel d'utilisation",
            ],
            'cl_net_weight' => [
                'en' => 'Net Weight / Volume',
                'ar' => 'الوزن / الحجم الصافي',
                'fr' => 'Poids net / Volume',
            ],
            'cl_scent_profile' => [
                'en' => 'Scent Profile',
                'ar' => 'ملف الرائحة والعطر',
                'fr' => 'Profil olfactif',
            ],
            'cl_vegan' => [
                'en' => 'Vegan Formula',
                'ar' => 'تركيبة نباتية',
                'fr' => 'Formule végane',
            ],
        ];

        $activeLocales = $this->getActiveLocales();

        foreach ($translations as $code => $localeNames) {
            $attributeId = DB::table('attributes')->where('code', $code)->value('id');

            if (! $attributeId) {
                continue;
            }

            foreach ($activeLocales as $locale) {
                $targetName = $localeNames[$locale] ?? $localeNames['en'];

                if (
                    ! DB::table('attribute_translations')
                        ->where('attribute_id', $attributeId)
                        ->where('locale', $locale)
                        ->exists()
                ) {
                    DB::table('attribute_translations')->insert([
                        'attribute_id' => $attributeId,
                        'locale' => $locale,
                        'name' => $targetName,
                    ]);
                }
            }
        }
    }

    // =========================================================================
    // Attribute Family
    // =========================================================================

    /**
     * Seed the Cleo's Lab attribute family and wire all attributes into it.
     */
    protected function seedAttributeFamily(): string
    {
        $familyCode = 'cleos-lab';

        $familyId = DB::table('attribute_families')
            ->where('code', $familyCode)
            ->value('id');

        if (! $familyId) {
            $familyId = DB::table('attribute_families')->insertGetId([
                'code' => $familyCode,
                'name' => "Cleo's Lab — Skincare & Haircare",
                'status' => 1,
                'is_user_defined' => 1,
            ]);
        }

        $groups = [
            [
                'code' => 'general',
                'name' => 'General',
                'column' => 1,
                'position' => 1,
                'attributes' => ['sku', 'name', 'url_key', 'tax_category_id', 'color', 'size', 'brand', 'product_number'],
            ],
            [
                'code' => 'description',
                'name' => 'Description',
                'column' => 1,
                'position' => 2,
                'attributes' => ['short_description', 'description'],
            ],
            [
                'code' => 'skincare_details',
                'name' => 'Skincare Details',
                'column' => 1,
                'position' => 3,
                'attributes' => ['cl_skin_type', 'cl_key_ingredients', 'cl_usage_ritual', 'cl_net_weight', 'cl_scent_profile', 'cl_vegan'],
            ],
            [
                'code' => 'meta_description',
                'name' => 'Meta Description',
                'column' => 1,
                'position' => 4,
                'attributes' => ['meta_title', 'meta_keywords', 'meta_description'],
            ],
            [
                'code' => 'price',
                'name' => 'Price',
                'column' => 2,
                'position' => 1,
                'attributes' => ['price', 'cost', 'special_price', 'special_price_from', 'special_price_to'],
            ],
            [
                'code' => 'shipping',
                'name' => 'Shipping',
                'column' => 2,
                'position' => 2,
                'attributes' => ['length', 'width', 'height', 'weight'],
            ],
            [
                'code' => 'settings',
                'name' => 'Settings',
                'column' => 2,
                'position' => 3,
                'attributes' => ['new', 'featured', 'visible_individually', 'status', 'guest_checkout'],
            ],
            [
                'code' => 'inventories',
                'name' => 'Inventories',
                'column' => 2,
                'position' => 4,
                'attributes' => ['manage_stock'],
            ],
            [
                'code' => 'rma',
                'name' => 'RMA',
                'column' => 2,
                'position' => 5,
                'attributes' => ['allow_rma', 'rma_rule_id'],
            ],
        ];

        $existingGroupIds = DB::table('attribute_groups')
            ->where('attribute_family_id', $familyId)
            ->pluck('id');

        DB::table('attribute_group_mappings')
            ->whereIn('attribute_group_id', $existingGroupIds)
            ->delete();

        DB::table('attribute_groups')
            ->where('attribute_family_id', $familyId)
            ->delete();

        foreach ($groups as $g) {
            $groupId = DB::table('attribute_groups')->insertGetId([
                'code' => $g['code'],
                'name' => $g['name'],
                'column' => $g['column'],
                'position' => $g['position'],
                'is_user_defined' => 1,
                'attribute_family_id' => $familyId,
            ]);

            $pos = 1;

            foreach ($g['attributes'] as $attrCode) {
                $attrId = DB::table('attributes')->where('code', $attrCode)->value('id');

                if ($attrId) {
                    DB::table('attribute_group_mappings')->insert([
                        'attribute_id' => $attrId,
                        'attribute_group_id' => $groupId,
                        'position' => $pos++,
                    ]);
                }
            }
        }

        return "Attribute family: cleos-lab (id={$familyId})";
    }

    // =========================================================================
    // Categories
    // =========================================================================

    /**
     * Seed Cleo's Lab category tree under the root category.
     */
    protected function seedCategories(): string
    {
        $root = DB::table('categories')->whereNull('parent_id')->first();

        if (! $root) {
            return 'Categories: skipped — no root category found';
        }

        $tree = [
            [
                'slug' => 'skincare',
                'name' => [
                    'en' => 'Skincare',
                    'ar' => 'العناية بالبشرة',
                    'fr' => 'Soins de la peau',
                ],
                'description' => [
                    'en' => 'Cleo\'s Lab skincare formulas — small-batch made in Canada, Health Canada Notified, and built around actives with actual research behind them.',
                    'ar' => 'تركيبات كليوز لاب للعناية بالبشرة — مصنوعة بكميات محدودة في كندا، معتمدة من هيلث كندا، ومصممة حول مكونات فعالة مثبتة علمياً.',
                    'fr' => 'Formules de soins de la peau Cleo\'s Lab — fabriquées en petits lots au Canada, notifiées Santé Canada et formulées autour d\'actifs soutenus par la recherche.',
                ],
                'meta_keywords' => [
                    'en' => 'skincare, natural skincare, cleansers, serums, moisturisers, canadian skincare, cleos lab',
                    'ar' => 'العناية بالبشرة, سيروم, مرطبات, عناية طبيعية, مستحضرات تجميل كندية, كليوز لاب',
                    'fr' => 'soins de la peau, cosmetiques naturels, serums, hydratants, soins canadiens, cleos lab',
                ],
                'children' => [
                    [
                        'slug' => 'serums',
                        'name' => [
                            'en' => 'Serums',
                            'ar' => 'السيروم',
                            'fr' => 'Sérums',
                        ],
                        'description' => [
                            'en' => 'Targeted serums for every skin goal.',
                            'ar' => 'سيروم موجه لكل هدف للبشرة.',
                            'fr' => 'Sérums ciblés pour chaque besoin de la peau.',
                        ],
                        'meta_keywords' => [
                            'en' => 'face serums, hyaluronic serum, bakuchiol serum, antioxidant serums, anti aging, cleos lab',
                            'ar' => 'سيروم للوجه, سيروم هيالورونيك, سيروم باكوتشيول, مضادات اكسدة, مكافحة الشيخوخة, كليوز لاب',
                            'fr' => 'serums visage, serum acide hyaluronique, serum bakuchiol, antioxydants, anti age, cleos lab',
                        ],
                    ],
                    [
                        'slug' => 'moisturisers',
                        'name' => [
                            'en' => 'Moisturisers',
                            'ar' => 'المرطبات',
                            'fr' => 'Hydratants',
                        ],
                        'description' => [
                            'en' => 'Barrier-sealing butters and lotions.',
                            'ar' => 'زبدة وغسول يعزز ويحمي حاجز البشرة.',
                            'fr' => 'Beurres et lotions renforçant la barrière cutanée.',
                        ],
                        'meta_keywords' => [
                            'en' => 'moisturisers, body butter, shea butter, soothing body lotion, hydration, cleos lab',
                            'ar' => 'المرطبات, زبدة الجسم, زبدة الشيا, لوشن مهدئ للجسم, ترطيب عميق, كليوز لاب',
                            'fr' => 'hydratants, beurre corporel, beurre de karite, lotion apaisante, hydratation, cleos lab',
                        ],
                    ],
                    [
                        'slug' => 'eye-care',
                        'name' => [
                            'en' => 'Eye Care',
                            'ar' => 'العناية بالعينين',
                            'fr' => 'Soins des yeux',
                        ],
                        'description' => [
                            'en' => 'Gentle, effective eye area treatments.',
                            'ar' => 'علاجات لطيفة وفعّالة لمنطقة محيط العين.',
                            'fr' => 'Soins délicats et efficaces pour le contour des yeux.',
                        ],
                        'meta_keywords' => [
                            'en' => 'eye care, eye cream, dark circle treatment, depuffing eye cream, niacinamide caffeine, cleos lab',
                            'ar' => 'العناية بالعينين, كريم العينين, علاج الهالات السوداء, تخفيف الانتفاخات, كليوز لاب',
                            'fr' => 'soins des yeux, contour des yeux, anti cernes, anti poches, niacinamide cafeine, cleos lab',
                        ],
                    ],
                    [
                        'slug' => 'exfoliants',
                        'name' => [
                            'en' => 'Exfoliants',
                            'ar' => 'المقشرات',
                            'fr' => 'Exfoliants',
                        ],
                        'description' => [
                            'en' => 'AHA exfoliants that renew and resurface gently.',
                            'ar' => 'مقشرات AHA تجدد البشرة بلطف وتوحد ملمسها.',
                            'fr' => 'Exfoliants aux AHA qui renouvellent et lissent la peau en douceur.',
                        ],
                        'meta_keywords' => [
                            'en' => 'exfoliants, aha exfoliant, lactic acid peel, gentle resurfacing, skin smoothing, cleos lab',
                            'ar' => 'المقشرات, مقشر احماض الفواكه, حمض اللاكتيك, تنعيم البشرة, تقشير لطيف, كليوز لاب',
                            'fr' => 'exfoliants, peeling aha, acide lactique, lissage de la peau, exfoliation douce, cleos lab',
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'haircare',
                'name' => [
                    'en' => 'Haircare',
                    'ar' => 'العناية بالشعر',
                    'fr' => 'Soins des cheveux',
                ],
                'description' => [
                    'en' => 'Cleo\'s Lab haircare line — botanically rooted formulas for healthy, beautiful hair.',
                    'ar' => 'خط كليوز لاب للشعر — تركيبات نباتية لشعر صحي وجميل ولامع.',
                    'fr' => 'Gamme capillaire Cleo\'s Lab — formules d\'origine botanique pour des cheveux sains et éclatants.',
                ],
                'meta_keywords' => [
                    'en' => 'haircare, hair care products, hair serum, hair mask, castor oil for hair, cleos lab',
                    'ar' => 'العناية بالشعر, سيروم الشعر, ماسك الشعر, زيت الخروع, ترميم الشعر التالف, كليوز لاب',
                    'fr' => 'soins des cheveux, gamme capillaire, serum cheveux, masque capillaire, huile de ricin, cleos lab',
                ],
                'children' => [
                    [
                        'slug' => 'hair-serums',
                        'name' => [
                            'en' => 'Hair Serums',
                            'ar' => 'سيروم الشعر',
                            'fr' => 'Sérums capillaires',
                        ],
                        'description' => [
                            'en' => 'Lightweight repair serums for every hair type.',
                            'ar' => 'سيروم خفيف الوزن لإصلاح وتغذية كل أنواع الشعر.',
                            'fr' => 'Sérums réparateurs légers pour tous types de cheveux.',
                        ],
                        'meta_keywords' => [
                            'en' => 'hair serums, repair hair serum, split ends, hair shine, moringa oil, silk amino acids, cleos lab',
                            'ar' => 'سيروم الشعر, سيروم اصلاح الشعر, علاج التقصف, لمعان الشعر, زيت المورينجا, كليوز لاب',
                            'fr' => 'serums capillaires, serum reparateur, pointes fourchues, brillance cheveux, huile de moringa, cleos lab',
                        ],
                    ],
                    [
                        'slug' => 'hair-masks',
                        'name' => [
                            'en' => 'Hair Masks',
                            'ar' => 'أقنعة الشعر',
                            'fr' => 'Masques capillaires',
                        ],
                        'description' => [
                            'en' => 'Deep-restore masks for intense hair treatment.',
                            'ar' => 'أقنعة ترميم عميق لعلاج وتغذية الشعر المكثّفة.',
                            'fr' => 'Masques réparateurs intenses pour un soin capillaire profond.',
                        ],
                        'meta_keywords' => [
                            'en' => 'hair masks, deep restore hair mask, honey hair mask, damaged hair treatment, intensive conditioning, cleos lab',
                            'ar' => 'اقنعة الشعر, ماسك الترميم العميق, ماسك العسل للشعر, علاج الشعر الجاف, ترطيب مكثف, كليوز لاب',
                            'fr' => 'masques capillaires, masque reparateur intense, masque cheveux au miel, soin cheveux abimes, cleos lab',
                        ],
                    ],
                ],
            ],
        ];

        $created = 0;

        foreach ($tree as $parentData) {
            $parentId = $this->upsertCategory($parentData, $root->id);
            $created++;

            foreach ($parentData['children'] as $childData) {
                $this->upsertCategory($childData, $parentId);
                $created++;
            }
        }

        try {
            Category::fixTree();
        } catch (\Throwable $e) {
        }

        return "Categories: {$created} processed";
    }

    /**
     * Create or skip a category, returning its id.
     */
    protected function upsertCategory(array $data, int $parentId): int
    {
        $existing = DB::table('category_translations')
            ->where('slug', $data['slug'])
            ->first();

        if ($existing) {
            $categoryId = DB::table('categories')->where('id', $existing->category_id)->value('id');
        } else {
            $categoryId = DB::table('categories')->insertGetId([
                'parent_id' => $parentId,
                'position' => 1,
                'status' => 1,
                '_lft' => 0,
                '_rgt' => 0,
            ]);
        }

        $activeLocales = $this->getActiveLocales();

        foreach ($activeLocales as $locale) {
            $localeRecord = DB::table('locales')->where('code', $locale)->first();

            if (! $localeRecord) {
                continue;
            }

            $name = $data['name'][$locale] ?? $data['name']['en'];
            $desc = $data['description'][$locale] ?? $data['description']['en'] ?? '';
            $keywords = $data['meta_keywords'][$locale] ?? $data['meta_keywords']['en'] ?? '';

            $existingTrans = DB::table('category_translations')
                ->where('category_id', $categoryId)
                ->where('locale', $locale)
                ->first();

            if (! $existingTrans) {
                DB::table('category_translations')->insert([
                    'category_id' => $categoryId,
                    'locale' => $locale,
                    'locale_id' => $localeRecord->id,
                    'name' => $name,
                    'slug' => $data['slug'],
                    'url_path' => $data['slug'],
                    'description' => $desc,
                    'meta_title' => $name,
                    'meta_description' => $desc,
                    'meta_keywords' => $keywords,
                ]);
            } else {
                DB::table('category_translations')
                    ->where('id', $existingTrans->id)
                    ->update([
                        'meta_title' => $name,
                        'meta_description' => $desc,
                        'meta_keywords' => $keywords,
                    ]);
            }
        }

        return $categoryId;
    }

    // =========================================================================
    // Products
    // =========================================================================

    /**
     * Seed all 14 Cleo's Lab products.
     */
    protected function seedProducts(): string
    {
        $familyId = DB::table('attribute_families')->where('code', 'cleos-lab')->value('id');

        if (! $familyId) {
            return 'Products: skipped — attribute family not found';
        }

        $channelId = DB::table('channels')->value('id') ?? 1;

        $categoryMap = [
            'serums' => DB::table('category_translations')->where('slug', 'serums')->value('category_id'),
            'moisturisers' => DB::table('category_translations')->where('slug', 'moisturisers')->value('category_id'),
            'eye-care' => DB::table('category_translations')->where('slug', 'eye-care')->value('category_id'),
            'exfoliants' => DB::table('category_translations')->where('slug', 'exfoliants')->value('category_id'),
            'hair-serums' => DB::table('category_translations')->where('slug', 'hair-serums')->value('category_id'),
            'hair-masks' => DB::table('category_translations')->where('slug', 'hair-masks')->value('category_id'),
        ];

        $products = $this->productDefinitions($familyId, $categoryMap);

        $created = 0;

        foreach ($products as $product) {
            $existingProduct = DB::table('products')->where('sku', $product['sku'])->first();

            if (! $existingProduct) {
                $productId = DB::table('products')->insertGetId([
                    'type' => 'simple',
                    'attribute_family_id' => $product['family_id'],
                    'sku' => $product['sku'],
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($product['category_id']) {
                    DB::table('product_categories')->insert([
                        'product_id' => $productId,
                        'category_id' => $product['category_id'],
                    ]);
                }

                DB::table('product_channels')->insert([
                    'product_id' => $productId,
                    'channel_id' => $channelId,
                ]);

                $inventorySourceId = DB::table('inventory_sources')->value('id');

                if ($inventorySourceId) {
                    DB::table('product_inventories')->insert([
                        'product_id' => $productId,
                        'inventory_source_id' => $inventorySourceId,
                        'qty' => 50,
                    ]);
                }

                $created++;
            } else {
                $productId = $existingProduct->id;
            }

            $this->insertProductAttributeValues($productId, $product, $channelId);
        }

        return "Products: {$created} created (14 processed)";
    }

    /**
     * Insert attribute values for a product.
     */
    protected function insertProductAttributeValues(int $productId, array $product, int $channelId): void
    {
        $channelCode = DB::table('channels')->where('id', $channelId)->value('code') ?? 'default';
        $activeLocales = $this->getActiveLocales();

        $systemAttributes = [
            'name' => ['type' => 'text', 'value' => $product['name'], 'per_channel' => 0, 'per_locale' => 1],
            'url_key' => ['type' => 'text', 'value' => $product['url_key'], 'per_channel' => 0, 'per_locale' => 1],
            'short_description' => ['type' => 'textarea', 'value' => $product['short_description'], 'per_channel' => 0, 'per_locale' => 1],
            'description' => ['type' => 'textarea', 'value' => $product['description'], 'per_channel' => 0, 'per_locale' => 1],
            'price' => ['type' => 'price', 'value' => $product['price'], 'per_channel' => 0, 'per_locale' => 0],
            'weight' => ['type' => 'text', 'value' => $product['weight'], 'per_channel' => 0, 'per_locale' => 0],
            'status' => ['type' => 'boolean', 'value' => 1, 'per_channel' => 1, 'per_locale' => 0],
            'new' => ['type' => 'boolean', 'value' => 1, 'per_channel' => 0, 'per_locale' => 0],
            'featured' => ['type' => 'boolean', 'value' => 1, 'per_channel' => 0, 'per_locale' => 0],
            'visible_individually' => ['type' => 'boolean', 'value' => 1, 'per_channel' => 0, 'per_locale' => 0],
            'meta_title' => ['type' => 'text', 'value' => $product['name'], 'per_channel' => 0, 'per_locale' => 1],
            'meta_description' => ['type' => 'textarea', 'value' => $product['short_description'], 'per_channel' => 0, 'per_locale' => 1],
            'meta_keywords' => ['type' => 'text', 'value' => $product['meta_keywords'] ?? ['en' => 'skincare, cleos lab', 'ar' => 'عناية بالبشرة، كليوز لاب', 'fr' => 'soins de la peau, cleos lab'], 'per_channel' => 0, 'per_locale' => 1],
        ];

        $skinTypeOptionIds = [];
        if (! empty($product['skin_types'])) {
            $skinTypeAttrId = DB::table('attributes')->where('code', 'cl_skin_type')->value('id');
            if ($skinTypeAttrId) {
                $skinTypeOptionIds = DB::table('attribute_options')
                    ->where('attribute_id', $skinTypeAttrId)
                    ->whereIn('admin_name', $product['skin_types'])
                    ->pluck('id')
                    ->toArray();
            }
        }

        $customAttributes = [
            'cl_skin_type' => ['type' => 'multiselect', 'value' => implode(',', $skinTypeOptionIds), 'per_channel' => 0, 'per_locale' => 0],
            'cl_key_ingredients' => ['type' => 'textarea', 'value' => $product['key_ingredients'] ?? '', 'per_channel' => 0, 'per_locale' => 1],
            'cl_usage_ritual' => ['type' => 'textarea', 'value' => $product['usage_ritual'] ?? '', 'per_channel' => 0, 'per_locale' => 1],
            'cl_net_weight' => ['type' => 'text', 'value' => $product['net_weight'] ?? '', 'per_channel' => 0, 'per_locale' => 0],
            'cl_scent_profile' => ['type' => 'text', 'value' => $product['scent_profile'] ?? '', 'per_channel' => 0, 'per_locale' => 1],
            'cl_vegan' => ['type' => 'boolean', 'value' => $product['vegan'] ?? 0, 'per_channel' => 0, 'per_locale' => 0],
        ];

        $allAttrs = array_merge($systemAttributes, $customAttributes);

        foreach ($allAttrs as $code => $meta) {
            $attributeId = DB::table('attributes')->where('code', $code)->value('id');

            if (! $attributeId) {
                continue;
            }

            $valueColumn = $this->typeFields[$meta['type']] ?? 'text_value';
            $nullColumns = collect($this->typeFields)->values()->unique()->mapWithKeys(fn ($f) => [$f => null])->all();

            if ($meta['per_channel'] && $meta['per_locale']) {
                foreach ($activeLocales as $locale) {
                    $val = is_array($meta['value'])
                        ? ($meta['value'][$locale] ?? $meta['value']['en'] ?? '')
                        : $meta['value'];

                    $existingRow = DB::table('product_attribute_values')
                        ->where('product_id', $productId)
                        ->where('attribute_id', $attributeId)
                        ->where('channel', $channelCode)
                        ->where('locale', $locale)
                        ->first();

                    if (! $existingRow) {
                        $uniqueId = implode('|', [$channelCode, $locale, $productId, $attributeId]);
                        DB::table('product_attribute_values')->insert(array_merge($nullColumns, [
                            'product_id' => $productId,
                            'attribute_id' => $attributeId,
                            'channel' => $channelCode,
                            'locale' => $locale,
                            'unique_id' => $uniqueId,
                            'json_value' => null,
                            $valueColumn => $val,
                        ]));
                    } elseif (
                        $locale === 'ar'
                        && is_array($meta['value'])
                        && (
                            (isset($meta['value']['en']) && $existingRow->{$valueColumn} === $meta['value']['en'])
                            || $existingRow->{$valueColumn} === "skincare, cleo's lab"
                        )
                    ) {
                        DB::table('product_attribute_values')
                            ->where('id', $existingRow->id)
                            ->update([$valueColumn => $val]);
                    }
                }
            } elseif ($meta['per_channel']) {
                $existingRow = DB::table('product_attribute_values')
                    ->where('product_id', $productId)
                    ->where('attribute_id', $attributeId)
                    ->where('channel', $channelCode)
                    ->whereNull('locale')
                    ->first();

                if (! $existingRow) {
                    $uniqueId = implode('|', [$channelCode, $productId, $attributeId]);
                    DB::table('product_attribute_values')->insert(array_merge($nullColumns, [
                        'product_id' => $productId,
                        'attribute_id' => $attributeId,
                        'channel' => $channelCode,
                        'locale' => null,
                        'unique_id' => $uniqueId,
                        'json_value' => null,
                        $valueColumn => $meta['value'],
                    ]));
                }
            } elseif ($meta['per_locale']) {
                foreach ($activeLocales as $locale) {
                    $val = is_array($meta['value'])
                        ? ($meta['value'][$locale] ?? $meta['value']['en'] ?? '')
                        : $meta['value'];

                    $existingRow = DB::table('product_attribute_values')
                        ->where('product_id', $productId)
                        ->where('attribute_id', $attributeId)
                        ->whereNull('channel')
                        ->where('locale', $locale)
                        ->first();

                    if (! $existingRow) {
                        $uniqueId = implode('|', [$locale, $productId, $attributeId]);
                        DB::table('product_attribute_values')->insert(array_merge($nullColumns, [
                            'product_id' => $productId,
                            'attribute_id' => $attributeId,
                            'channel' => null,
                            'locale' => $locale,
                            'unique_id' => $uniqueId,
                            'json_value' => null,
                            $valueColumn => $val,
                        ]));
                    } elseif (
                        $locale === 'ar'
                        && is_array($meta['value'])
                        && (
                            (isset($meta['value']['en']) && $existingRow->{$valueColumn} === $meta['value']['en'])
                            || $existingRow->{$valueColumn} === "skincare, cleo's lab"
                        )
                    ) {
                        DB::table('product_attribute_values')
                            ->where('id', $existingRow->id)
                            ->update([$valueColumn => $val]);
                    }
                }
            } else {
                $existingRow = DB::table('product_attribute_values')
                    ->where('product_id', $productId)
                    ->where('attribute_id', $attributeId)
                    ->whereNull('channel')
                    ->whereNull('locale')
                    ->first();

                if (! $existingRow) {
                    $uniqueId = implode('|', [$productId, $attributeId]);
                    DB::table('product_attribute_values')->insert(array_merge($nullColumns, [
                        'product_id' => $productId,
                        'attribute_id' => $attributeId,
                        'channel' => null,
                        'locale' => null,
                        'unique_id' => $uniqueId,
                        'json_value' => null,
                        $valueColumn => $meta['value'],
                    ]));
                }
            }
        }

        $skuAttributeId = DB::table('attributes')->where('code', 'sku')->value('id');

        if ($skuAttributeId) {
            $existingSku = DB::table('product_attribute_values')
                ->where('product_id', $productId)
                ->where('attribute_id', $skuAttributeId)
                ->whereNull('channel')
                ->whereNull('locale')
                ->exists();

            if (! $existingSku) {
                $uniqueId = implode('|', [$productId, $skuAttributeId]);
                $nullColumns = collect($this->typeFields)->values()->unique()->mapWithKeys(fn ($f) => [$f => null])->all();
                DB::table('product_attribute_values')->insert(array_merge($nullColumns, [
                    'product_id' => $productId,
                    'attribute_id' => $skuAttributeId,
                    'channel' => null,
                    'locale' => null,
                    'unique_id' => $uniqueId,
                    'json_value' => null,
                    'text_value' => $product['sku'],
                ]));
            }
        }
    }

    /**
     * Return the full product definitions for all 14 Cleo's Lab SKUs.
     *
     * @param  array<string, int|null>  $categoryMap
     * @return array<int, array<string, mixed>>
     */
    protected function productDefinitions(int $familyId, array $categoryMap): array
    {
        return [
            [
                'sku' => 'CL-MS-001',
                'name' => [
                    'en' => 'Morning Glow Serum',
                    'ar' => 'سيروم نضارة الصباح (مورنينغ غلو)',
                    'fr' => 'Sérum Éclat du Matin',
                ],
                'url_key' => [
                    'en' => 'morning-glow-serum',
                    'ar' => 'morning-glow-serum-ar',
                    'fr' => 'serum-eclat-du-matin',
                ],
                'short_description' => [
                    'en' => 'Hyaluronic acid serum with guava and green tea antioxidants for morning radiance.',
                    'ar' => 'سيروم حمض الهيالورونيك مع مضادات أكسدة الجوافة والشاي الأخضر لإشراقة ونضارة الصباح.',
                    'fr' => 'Sérum à l\'acide hyaluronique aux antioxydants de goyave et de thé vert pour l\'éclat du matin.',
                ],
                'description' => [
                    'en' => 'Start mornings with Morning Glow Serum on clean, damp skin. Hyaluronic acid pulls in moisture while guava and green tea go to work as antioxidants — real vitamin C and EGCG content, not just pretty ingredient names. Five minutes, and skin looks like it\'s had more sleep than it did. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'ابدأي صباحك مع سيروم نضارة الصباح على بشرة نظيفة ورطبة. يجذب حمض الهيالورونيك الترطيب للعمق بينما تعمل الجوافة والشاي الأخضر كمضادات أكسدة قوية — فيتامين C حقيقي ومركب EGCG الفعّال، وليس مجرد مسميات على العبوة. خمس دقائق وتبدو البشرة وكأنها نالت قسطاً وفيراً من النوم والراحة. معتمد ومسجل لدى هيلث كندا. صُنع يدوياً بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'Commencez la journée avec le Sérum Éclat du Matin sur une peau propre et humide. L\'acide hyaluronique retient l\'hydratation tandis que la goyave et le thé vert agissent comme de puissants antioxydants — véritable vitamine C et EGCG, pas seulement des noms attrayants. En cinq minutes, la peau paraît reposée et éclatante. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 38.00,
                'weight' => 0.05,
                'family_id' => $familyId,
                'category_id' => $categoryMap['serums'],
                'skin_types' => ['All Skin Types', 'Dry', 'Combination', 'Normal'],
                'key_ingredients' => [
                    'en' => 'Hyaluronic Acid (three molecular weights), Guava Extract (natural Vitamin C), Green Tea Extract (EGCG), Niacinamide 5%, Allantoin',
                    'ar' => 'حمض الهيالورونيك (بثلاثة أوزان جزيئية)، مستخلص الجوافة (فيتامين C طبيعي)، مستخلص الشاي الأخضر (EGCG)، نياسيناميد 5%، ألانتوين',
                    'fr' => 'Acide hyaluronique (trois poids moléculaires), extrait de goyave (vitamine C naturelle), extrait de thé vert (EGCG), niacinamide 5 %, allantoïne',
                ],
                'usage_ritual' => [
                    'en' => 'Apply 3–4 drops to clean, damp skin every morning. Pat gently to absorb. Follow with your moisturiser or SPF.',
                    'ar' => 'ضعي 3-4 قطرات على بشرة نظيفة ورطبة كل صباح. ربتي بلطف حتى يمتص بالكامل. اتبعيه بالمرطب أو واقي الشمس.',
                    'fr' => 'Appliquer 3 à 4 gouttes sur une peau propre et humide chaque matin. Tapoter délicatement pour faire pénétrer. Poursuivre avec votre crème hydratante ou votre protection solaire.',
                ],
                'net_weight' => '30 ml / 1 fl oz',
                'scent_profile' => [
                    'en' => 'Unscented',
                    'ar' => 'بدون عطر',
                    'fr' => 'Sans parfum',
                ],
                'vegan' => 1,
                'meta_keywords' => [
                    'en' => 'morning glow serum, hyaluronic acid, vitamin c, green tea egcg, hydrating serum, antioxidant serum, canadian skincare, cleos lab',
                    'ar' => 'سيروم نضارة الصباح, حمض الهيالورونيك, فيتامين سي, الشاي الاخضر, سيروم ترطيب, مضادات اكسدة, كليوز لاب, عناية بالبشرة',
                    'fr' => 'serum eclat du matin, acide hyaluronique, vitamine c, the vert egcg, serum hydratant, antioxydant, soins canadiens, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-MS-002',
                'name' => [
                    'en' => 'Moonlight Serum',
                    'ar' => 'سيروم ضوء القمر الليلي (مون لايت)',
                    'fr' => 'Sérum Clair de Lune',
                ],
                'url_key' => [
                    'en' => 'moonlight-serum',
                    'ar' => 'moonlight-serum-ar',
                    'fr' => 'serum-clair-de-lune',
                ],
                'short_description' => [
                    'en' => 'Bakuchiol and licorice root night serum for tone and renewal without retinol irritation.',
                    'ar' => 'سيروم ليلي بالباكوتشيول وعرق السوس لتوحيد اللون وتجديد الخلايا دون تهيج الريتينول.',
                    'fr' => 'Sérum de nuit au bakuchiol et racine de réglisse pour unifier le teint et renouveler la peau sans irritation.',
                ],
                'description' => [
                    'en' => 'At night, Moonlight Serum leans on bakuchiol and licorice root for tone and renewal without retinol\'s irritation. Bakuchiol is a plant-derived alternative with similar retinol-like benefits — cell turnover, firmness support, even tone — without the peeling and sensitivity. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'في المساء، يعتمد سيروم ضوء القمر على الباكوتشيول وجذور عرق السوس لتوحيد لون البشرة وتجديدها دون تهيج الريتينول المعتاد. الباكوتشيول بديل نباتي يقدم فوائد مماثلة للريتينول — تسريع تجدد الخلايا، دعم مرونة البشرة وتماسكها، وتوحيد اللون — دون تقشير أو تحسس. معتمد ومسجل لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'Le soir, le Sérum Clair de Lune mise sur le bakuchiol et la racine de réglisse pour unifier le teint sans les irritations du rétinol. Le bakuchiol offre des bienfaits comparables — renouvellement cellulaire, fermeté, éclat homogène — sans desquamation ni sensibilité. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 42.00,
                'weight' => 0.05,
                'family_id' => $familyId,
                'category_id' => $categoryMap['serums'],
                'skin_types' => ['All Skin Types', 'Sensitive', 'Normal', 'Combination'],
                'key_ingredients' => [
                    'en' => 'Bakuchiol 1%, Licorice Root Extract, Squalane, Peptide Complex, Vitamin E',
                    'ar' => 'باكوتشيول 1%، مستخلص جذر عرق السوس، سكوالين، مركب الببتيدات، فيتامين E',
                    'fr' => 'Bakuchiol 1 %, extrait de racine de réglisse, squalane, complexe peptidique, vitamine E',
                ],
                'usage_ritual' => [
                    'en' => 'Apply 3–4 drops to clean skin at night. Do not combine with the 5% AHA Exfoliant on the same evening — alternate nights.',
                    'ar' => 'ضعي 3-4 قطرات على بشرة نظيفة ليلاً. تجنبي دمجه مع مقشر 5% AHA في نفس الليلة — استخدمي كل منهما بالتناوب في ليالٍ مختلفة.',
                    'fr' => 'Appliquer 3 à 4 gouttes sur une peau propre le soir. Ne pas combiner avec l\'Exfoliant AHA 5 % le même soir — alterner les soirs.',
                ],
                'net_weight' => '30 ml / 1 fl oz',
                'scent_profile' => [
                    'en' => 'Unscented',
                    'ar' => 'بدون عطر',
                    'fr' => 'Sans parfum',
                ],
                'vegan' => 1,
                'meta_keywords' => [
                    'en' => 'moonlight serum, bakuchiol, retinol alternative, licorice root, squalane, night serum, gentle renewal, cleos lab',
                    'ar' => 'سيروم ضوء القمر, باكوتشيول, بديل الريتينول, عرق السوس, سكوالين, سيروم ليلي, تجديد البشرة, كليوز لاب',
                    'fr' => 'serum clair de lune, bakuchiol, alternative retinol, racine de reglisse, squalane, serum de nuit, anti-age doux, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-AHA-001',
                'name' => [
                    'en' => '5% AHA Exfoliant',
                    'ar' => 'مقشر 5% أحماض الفواكه (AHA)',
                    'fr' => 'Exfoliant AHA 5 %',
                ],
                'url_key' => [
                    'en' => '5-percent-aha-exfoliant',
                    'ar' => '5-percent-aha-exfoliant-ar',
                    'fr' => 'exfoliant-aha-5-pourcent',
                ],
                'short_description' => [
                    'en' => 'Lactic acid exfoliant that resurfaces texture 2–3 nights per week.',
                    'ar' => 'مقشر حمض اللاكتيك لتنعيم ملمس البشرة وتجديدها بمعدل 2-3 ليالٍ في الأسبوع.',
                    'fr' => 'Exfoliant à l\'acide lactique lissant le grain de peau 2 à 3 soirs par semaine.',
                ],
                'description' => [
                    'en' => 'Cleopatra\'s "secret" wasn\'t really a secret — milk baths were a documented part of Egyptian beauty ritual, with lactic acid in sour milk acting as a genuine mild exfoliant. Our 5% AHA Exfoliant does the same job with a measured, research-backed dose of lactic acid. Use 2–3 nights per week to resurface texture, unclog pores, and improve skin clarity. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'لم يكن "سر كليوباترا" سراً غامضاً — فقد كانت حمامات الحليب طقساً جمالياً مصرياً موثقاً، حيث يعمل حمض اللاكتيك في الحليب كمقشر لطيف وحقيقي. يقدم مقشرنا بنسبة 5% AHA نفس الفعالية بجرعة دقيقة ومدروسة علمياً. يُستخدم 2-3 ليالٍ في الأسبوع لتنعيم الملمس، تنقية المسام، وتحسين صفاء البشرة. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'Le « secret » de Cléopâtre n\'en était pas un : les bains de lait faisaient partie des rituels égyptiens, l\'acide lactique agissant comme un exfoliant doux. Notre Exfoliant AHA 5 % reproduit cette action avec une formule moderne et équilibrée. Utiliser 2 à 3 soirs par semaine pour lisser la peau, désincruster les pores et clarifier le teint. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 34.00,
                'weight' => 0.10,
                'family_id' => $familyId,
                'category_id' => $categoryMap['exfoliants'],
                'skin_types' => ['Oily', 'Combination', 'Normal'],
                'key_ingredients' => [
                    'en' => 'Lactic Acid 5%, Glycerin, Allantoin, Panthenol (B5), Sodium PCA',
                    'ar' => 'حمض اللاكتيك 5%، جلسرين، ألانتوين، بانثينول (فيتامين B5)، صوديوم PCA',
                    'fr' => 'Acide lactique 5 %, glycérine, allantoïne, panthénol (B5), sodium PCA',
                ],
                'usage_ritual' => [
                    'en' => 'Apply a thin layer to clean, dry skin 2–3 evenings per week. Leave on overnight — do not rinse. Follow with your moisturiser. Do not use with Moonlight Serum on the same night. Always patch test. SPF is essential the following morning.',
                    'ar' => 'ضعي طبقة رقيقة على بشرة نظيفة وجافة بمعدل 2-3 أمسيات أسبوعياً. اتركيه طوال الليل دون شطف. اتبعيه بالمرطب. لا تدمجيه مع سيروم مون لايت في الليلة نفسها. ينصح بإجراء اختبار تحسس مسبق. واقي الشمس ضروري في صباح اليوم التالي.',
                    'fr' => 'Appliquer une fine couche sur une peau propre et sèche 2 à 3 soirs par semaine. Laisser poser toute la nuit sans rincer. Poursuivre avec votre hydratant. Ne pas combiner avec le Sérum Clair de Lune le même soir. Protection solaire indispensable le lendemain matin.',
                ],
                'net_weight' => '100 ml / 3.4 fl oz',
                'scent_profile' => [
                    'en' => 'Unscented',
                    'ar' => 'بدون عطر',
                    'fr' => 'Sans parfum',
                ],
                'vegan' => 1,
                'meta_keywords' => [
                    'en' => '5 aha exfoliant, lactic acid exfoliant, chemical peeling, skin texture renewal, pore clearing, gentle aha, cleos lab',
                    'ar' => 'مقشر احماض الفواكه 5, حمض اللاكتيك, تقشير كيميائي لطيف, تجديد ملمس البشرة, تنقية المسام, كليوز لاب',
                    'fr' => 'exfoliant aha 5, acide lactique, peeling doux, grain de peau lisse, pores resserres, soin exfoliant, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-EC-001',
                'name' => [
                    'en' => 'Nour Eye Cream',
                    'ar' => 'كريم نور لمحيط العينين',
                    'fr' => 'Crème Contour des Yeux Nour',
                ],
                'url_key' => [
                    'en' => 'nour-eye-cream',
                    'ar' => 'nour-eye-cream-ar',
                    'fr' => 'creme-yeux-nour',
                ],
                'short_description' => [
                    'en' => 'Niacinamide and caffeine eye cream for brightening and de-puffing.',
                    'ar' => 'كريم العيون بالنياسيناميد والكافيين لتفتيح الهالات وتقليل انتفاخ محيط العين.',
                    'fr' => 'Crème pour les yeux à la niacinamide et caféine illuminatrice et anti-poches.',
                ],
                'description' => [
                    'en' => 'Nour Eye Cream goes on last, patted gently under the eyes. Niacinamide and caffeine are doing the real work here — brightening and temporarily de-puffing — so this step earns its place instead of just being a habit. Silk amino acids replace traditional silicones for a smooth, non-greasy finish. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'يُوضع كريم نور للعينين كخطوة أخيرة، بالتربيت اللطيف تحت العينين. يقوم النياسيناميد والكافيين بالدور الفعلي — تفتيح الهالات وتخفيف الانتفاخات مؤقتاً — لتستحق هذه الخطوة مكانها في روتينك اليومي. تحل الأحماض الأمينية الحريرية محل السيليكونات لتمنح لمسة ناعمة غير دهنية إطلاقاً. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'La Crème Contour des Yeux Nour s\'applique par légers tapotements sous les yeux. La niacinamide et la caféine illuminent le regard et atténuent visiblement les poches. Les acides aminés de soie remplacent avantageusement les silicones conventionnels pour un fini soyeux et non gras. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 36.00,
                'weight' => 0.01,
                'family_id' => $familyId,
                'category_id' => $categoryMap['eye-care'],
                'skin_types' => ['All Skin Types', 'Sensitive', 'Dry', 'Normal'],
                'key_ingredients' => [
                    'en' => 'Niacinamide 5%, Caffeine 1%, Silk Amino Acids, Hyaluronic Acid, Peptides',
                    'ar' => 'نياسيناميد 5%، كافيين 1%، أحماض أمينية حريرية، حمض الهيالورونيك، ببتيدات',
                    'fr' => 'Niacinamide 5 %, caféine 1 %, acides aminés de soie, acide hyaluronique, peptides',
                ],
                'usage_ritual' => [
                    'en' => 'Using your ring finger, pat a small amount gently around the orbital bone under the eye. Apply morning and/or night as the last step before SPF or moisturiser.',
                    'ar' => 'باستخدام إصبع البنصر، ربتي بكمية صغيرة بلطف حول عظمة محيط العين. يطبق صباحاً و/أو مساءً كخطوة أخيرة قبل واقي الشمس أو المرطب.',
                    'fr' => 'À l\'aide de l\'annulaire, tapoter délicatement une noisette autour de l\'arcade orbitale sous l\'œil. Appliquer matin et/ou soir avant la crème ou la protection solaire.',
                ],
                'net_weight' => '15 ml / 0.5 fl oz',
                'scent_profile' => [
                    'en' => 'Unscented',
                    'ar' => 'بدون عطر',
                    'fr' => 'Sans parfum',
                ],
                'vegan' => 0,
                'meta_keywords' => [
                    'en' => 'nour eye cream, niacinamide eye cream, caffeine eye cream, dark circles, eye depuffing, silk peptides, cleos lab',
                    'ar' => 'كريم نور للعين, كريم نياسيناميد للعيون, كافيين للانتفاخات, تفتيح الهالات السوداء, ببتيدات الحرير, كليوز لاب',
                    'fr' => 'creme contour des yeux nour, niacinamide yeux, cafeine anti poches, anti cernes, peptides de soie, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-HB-001',
                'name' => [
                    'en' => 'HydraButter — Unscented',
                    'ar' => 'زبدة هايدرابتر المرطبة — بدون عطر',
                    'fr' => 'HydraButter — Sans parfum',
                ],
                'url_key' => [
                    'en' => 'hydrabutter-unscented',
                    'ar' => 'hydrabutter-unscented-ar',
                    'fr' => 'hydrabutter-sans-parfum',
                ],
                'short_description' => [
                    'en' => 'Shea butter and oat protein body butter that holds moisture in without adding oil.',
                    'ar' => 'زبدة للجسم بخلاصة الشيا وبروتين الشوفان تحبس الرطوبة بعمق دون ترك ملمس زيتي.',
                    'fr' => 'Beurre corporel au karité et protéines d\'avoine qui scelle l\'hydratation sans effet gras.',
                ],
                'description' => [
                    'en' => 'Finish your ritual with HydraButter over damp skin. Shea butter and oat protein hold water in rather than adding more oil on top — the difference between skin that feels hydrated for an hour and skin that feels hydrated by 3pm. The unscented version is ideal for sensitive skin or those who prefer their skincare fragrance-free. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'اختتمي طقوسك الجمالية مع زبدة هايدرابتر على بشرة رطبة. زبدة الشيا وبروتين الشوفان يحبسان جزيئات الماء داخل الجلد بدلاً من زيادة الزيوت السطحية — وهو الفرق بين بشرة تشعر بالترطيب لساعة فقط وأخرى تظل نضرة طوال اليوم. النسخة الخالية من العطر مثالية للبشرة الحساسة وعشاق المنتجات الطبيعية النقية. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'Terminez votre rituel avec HydraButter sur peau humide. Le beurre de karité et les protéines d\'avoine retiennent l\'eau au cœur de l\'épiderme sans sensation lourde. Cette version sans parfum est idéale pour les peaux sensibles ou réactives. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 28.00,
                'weight' => 0.20,
                'family_id' => $familyId,
                'category_id' => $categoryMap['moisturisers'],
                'skin_types' => ['All Skin Types', 'Sensitive', 'Dry'],
                'key_ingredients' => [
                    'en' => 'Shea Butter, Oat Protein, Glycerin, Squalane, Sodium PCA',
                    'ar' => 'زبدة الشيا، بروتين الشوفان، جلسرين، سكوالين، صوديوم PCA',
                    'fr' => 'Beurre de karité, protéines d\'avoine, glycérine, squalane, sodium PCA',
                ],
                'usage_ritual' => [
                    'en' => 'Apply generously to damp skin after showering or bathing. Massage in until absorbed. Can be used daily, morning or evening.',
                    'ar' => 'ضعي كمية وفيرة على بشرة رطبة بعد الاستحمام. دلكي بلطف حتى تمتص تماماً. يمكن استخدامها يومياً، صباحاً أو مساءً.',
                    'fr' => 'Appliquer généreusement sur peau humide après la douche ou le bain. Masser jusqu\'à absorption complète. Usage quotidien, matin ou soir.',
                ],
                'net_weight' => '200 ml / 6.8 fl oz',
                'scent_profile' => [
                    'en' => 'Unscented',
                    'ar' => 'بدون عطر',
                    'fr' => 'Sans parfum',
                ],
                'vegan' => 1,
                'meta_keywords' => [
                    'en' => 'hydrabutter unscented, shea body butter, colloidal oat protein, barrier sealing, fragrance free moisturizer, sensitive skin body butter, cleos lab',
                    'ar' => 'زبدة هايدرابتر بدون عطر, زبدة الشيا للجسم, بروتين الشوفان, ترميم حاجز البشرة, ترطيب عميق بدون رائحة, بشرة حساسة, كليوز لاب',
                    'fr' => 'hydrabutter sans parfum, beurre corporel karite, avoine colloidale, barriere cutanee, peau sensible, hydratation intense, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-HB-002',
                'name' => [
                    'en' => 'HydraButter — Rose',
                    'ar' => 'زبدة هايدرابتر المرطبة — بالورد',
                    'fr' => 'HydraButter — Rose',
                ],
                'url_key' => [
                    'en' => 'hydrabutter-rose',
                    'ar' => 'hydrabutter-rose-ar',
                    'fr' => 'hydrabutter-rose',
                ],
                'short_description' => [
                    'en' => 'Shea and oat protein body butter with a delicate rose fragrance.',
                    'ar' => 'زبدة الجسم بالشيا وبروتين الشوفان مع عبير الورد الدمشقي الرقيق.',
                    'fr' => 'Beurre corporel au karité et avoine parfumé à la rose délicate.',
                ],
                'description' => [
                    'en' => 'HydraButter in Rose — the same barrier-sealing formula of shea butter and oat protein, with a delicate rose scent. Applies over damp skin, holds moisture through the day, and leaves skin feeling soft without greasiness. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'هايدرابتر بنفحات الورد — نفس التركيبة الغنية الداعمة لحاجز البشرة من زبدة الشيا وبروتين الشوفان، بعبير الورد الناعم والفاخر. تمنحك ترطيباً ممتداً طوال النهار وملمساً مخملياً دون أي دهون. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'HydraButter à la Rose — la même formule protectrice au beurre de karité et protéines d\'avoine, sublimée par un parfum délicat de rose. Pénètre rapidement et laisse la peau soyeuse. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 28.00,
                'weight' => 0.20,
                'family_id' => $familyId,
                'category_id' => $categoryMap['moisturisers'],
                'skin_types' => ['All Skin Types', 'Dry', 'Normal'],
                'key_ingredients' => [
                    'en' => 'Shea Butter, Oat Protein, Glycerin, Squalane, Rose Absolute',
                    'ar' => 'زبدة الشيا، بروتين الشوفان، جلسرين، سكوالين، خلاصة الورد الطبيعي',
                    'fr' => 'Beurre de karité, protéines d\'avoine, glycérine, squalane, absolue de rose',
                ],
                'usage_ritual' => [
                    'en' => 'Apply generously to damp skin after showering or bathing. Massage in until absorbed. Can be used daily, morning or evening.',
                    'ar' => 'ضعي كمية وفيرة على بشرة رطبة بعد الاستحمام. دلكي بلطف حتى تمتص تماماً. مناسب للاستخدام اليومي، صباحاً أو مساءً.',
                    'fr' => 'Appliquer généreusement sur peau humide après la douche. Masser délicatement jusqu\'à absorption. Idéal pour un usage quotidien.',
                ],
                'net_weight' => '200 ml / 6.8 fl oz',
                'scent_profile' => [
                    'en' => 'Rose',
                    'ar' => 'عبير الورد',
                    'fr' => 'Rose',
                ],
                'vegan' => 1,
                'meta_keywords' => [
                    'en' => 'hydrabutter rose, rose body butter, shea butter, oat protein, rose absolute, hydrating body cream, cleos lab',
                    'ar' => 'زبدة هايدرابتر بالورد, زبدة جسم برائحة الورد, زبدة الشيا, بروتين الشوفان, خلاصة الورد الطبيعي, ترطيب الجسم, كليوز لاب',
                    'fr' => 'hydrabutter rose, beurre corporel a la rose, beurre de karite, avoine, absolue de rose, creme corps hydratante, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-HB-003',
                'name' => [
                    'en' => 'HydraButter — Lavender',
                    'ar' => 'زبدة هايدرابتر المرطبة — باللافندر',
                    'fr' => 'HydraButter — Lavande',
                ],
                'url_key' => [
                    'en' => 'hydrabutter-lavender',
                    'ar' => 'hydrabutter-lavender-ar',
                    'fr' => 'hydrabutter-lavande',
                ],
                'short_description' => [
                    'en' => 'Shea and oat protein body butter with a calming lavender fragrance.',
                    'ar' => 'زبدة الجسم بالشيا وبروتين الشوفان مع عطر اللافندر المهدئ والمريح.',
                    'fr' => 'Beurre corporel au karité et avoine aux notes apaisantes de lavande.',
                ],
                'description' => [
                    'en' => 'HydraButter in Lavender — barrier-sealing shea butter and oat protein with a calming lavender scent for an evening ritual. Applies over damp skin and holds moisture without a greasy residue. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'هايدرابتر باللافندر — زبدة الشيا وبروتين الشوفان مع رائحة اللافندر المهدئة المخصصة لطقوس المساء والاسترخاء. توضع على بشرة رطبة وتحافظ على النضارة والترطيب دون أدنى أثر زيتي. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'HydraButter à la Lavande — beurre de karité et avoine réconfortants alliés à la douceur de la lavande pour votre rituel du soir. Nourrit en profondeur sans coller. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 28.00,
                'weight' => 0.20,
                'family_id' => $familyId,
                'category_id' => $categoryMap['moisturisers'],
                'skin_types' => ['All Skin Types', 'Dry', 'Normal'],
                'key_ingredients' => [
                    'en' => 'Shea Butter, Oat Protein, Glycerin, Squalane, Lavender Essential Oil',
                    'ar' => 'زبدة الشيا، بروتين الشوفان، جلسرين، سكوالين، زيت اللافندر العطري النقي',
                    'fr' => 'Beurre de karité, protéines d\'avoine, glycérine, squalane, huile essentielle de lavande',
                ],
                'usage_ritual' => [
                    'en' => 'Apply generously to damp skin after showering or bathing. Massage in until absorbed. Especially ideal as part of an evening wind-down ritual.',
                    'ar' => 'توضع بسخاء على بشرة رطبة بعد الاستحمام. تدلك حتى تمام الامتصاص. مثالية جداً كجزء من روتين الاسترخاء المسائي قبل النوم.',
                    'fr' => 'Appliquer généreusement sur peau humide après la douche. Masser pour faire pénétrer. Recommandé en soirée pour favoriser la détente.',
                ],
                'net_weight' => '200 ml / 6.8 fl oz',
                'scent_profile' => [
                    'en' => 'Lavender',
                    'ar' => 'اللافندر المهدئ',
                    'fr' => 'Lavande',
                ],
                'vegan' => 1,
                'meta_keywords' => [
                    'en' => 'hydrabutter lavender, lavender body butter, relaxing night ritual, shea and oat, calming moisturizer, cleos lab',
                    'ar' => 'زبدة هايدرابتر باللافندر, زبدة جسم بالخزامى, روتين مسائي مهدئ, زبدة الشيا والشوفان, ترطيب واسترخاء, كليوز لاب',
                    'fr' => 'hydrabutter lavande, beurre corporel lavande, rituel du soir relaxant, karite et avoine, hydratant apaisant, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-HB-004',
                'name' => [
                    'en' => 'HydraButter — Citrus',
                    'ar' => 'زبدة هايدرابتر المرطبة — بالحمضيات',
                    'fr' => 'HydraButter — Agrumes',
                ],
                'url_key' => [
                    'en' => 'hydrabutter-citrus',
                    'ar' => 'hydrabutter-citrus-ar',
                    'fr' => 'hydrabutter-agrumes',
                ],
                'short_description' => [
                    'en' => 'Shea and oat protein body butter with a fresh citrus fragrance.',
                    'ar' => 'زبدة الجسم بالشيا وبروتين الشوفان مع عبير الحمضيات المنعش والحيوي.',
                    'fr' => 'Beurre corporel au karité et avoine aux notes fraîches et tonifiantes d\'agrumes.',
                ],
                'description' => [
                    'en' => 'HydraButter in Citrus — the same proven formula of shea butter and oat protein with a bright, energising citrus scent. Ideal for a morning ritual. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'هايدرابتر بالحمضيات — نفس التركيبة المثبتة من زبدة الشيا وبروتين الشوفان بنفحات حمضية مبهجة ومفعمة بالطاقة والانتعاش. الخيار الأمثل لروتين الصباح الحيوي. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'HydraButter aux Agrumes — la formule éprouvée de karité et d\'avoine enrichie d\'un parfum pétillant d\'agrumes. Parfait pour dynamiser votre rituel matinal. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 28.00,
                'weight' => 0.20,
                'family_id' => $familyId,
                'category_id' => $categoryMap['moisturisers'],
                'skin_types' => ['All Skin Types', 'Dry', 'Normal'],
                'key_ingredients' => [
                    'en' => 'Shea Butter, Oat Protein, Glycerin, Squalane, Citrus Blend (Bergamot, Sweet Orange)',
                    'ar' => 'زبدة الشيا، بروتين الشوفان، جلسرين، سكوالين، مزيج الحمضيات (برغموت، برتقال حلو)',
                    'fr' => 'Beurre de karité, protéines d\'avoine, glycérine, squalane, complexe d\'agrumes (bergamote, orange douce)',
                ],
                'usage_ritual' => [
                    'en' => 'Apply generously to damp skin after showering or bathing. Massage in until absorbed. Perfect for a morning energising routine.',
                    'ar' => 'توضع بسخاء على بشرة رطبة بعد الاستحمام. تدلك حتى تمتص تماماً. رائعة ومثالية لروتين الصباح المنعش.',
                    'fr' => 'Appliquer généreusement sur peau humide après le bain ou la douche. Masser pour faire pénétrer. Idéal pour commencer la journée avec tonus.',
                ],
                'net_weight' => '200 ml / 6.8 fl oz',
                'scent_profile' => [
                    'en' => 'Citrus Blend',
                    'ar' => 'مزيج الحمضيات المنعش',
                    'fr' => 'Mélange d\'agrumes',
                ],
                'vegan' => 1,
                'meta_keywords' => [
                    'en' => 'hydrabutter citrus, citrus body butter, bergamot sweet orange, energizing morning moisturizer, shea oat cream, cleos lab',
                    'ar' => 'زبدة هايدرابتر بالحمضيات, زبدة جسم منعشة, برغموت وبرتقال, روتين صباحي منشط, ترطيب الشيا والشوفان, كليوز لاب',
                    'fr' => 'hydrabutter agrumes, beurre corporel agrumes, bergamote orange douce, creme corps tonifiante, karite avoine, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-SL-001',
                'name' => [
                    'en' => 'Soothing Lotion — Unscented',
                    'ar' => 'لوشن الترطيب المهدئ — بدون عطر',
                    'fr' => 'Lotion Apaisante — Sans parfum',
                ],
                'url_key' => [
                    'en' => 'soothing-lotion-unscented',
                    'ar' => 'soothing-lotion-unscented-ar',
                    'fr' => 'lotion-apaisante-sans-parfum',
                ],
                'short_description' => [
                    'en' => 'Lightweight oat and shea lotion for daily all-over hydration.',
                    'ar' => 'لوشن خفيف القوام بالشوفان والشيا لترطيب كامل الجسم يومياً.',
                    'fr' => 'Lotion légère à l\'avoine et au karité pour une hydratation quotidienne complète.',
                ],
                'description' => [
                    'en' => 'Soothing Lotion is the lighter sibling to HydraButter — a daily-use lotion that absorbs quickly and keeps skin hydrated without heaviness. Built on the same oat protein and shea foundation, fragrance-free for sensitive skin. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'اللوشن المهدئ هو الرفيق الخفيف لزبدة هايدرابتر — لوشن يومي سريع الامتصاص يحافظ على رطوبة الجلد دون أي ثقل. مبني على نفس أساس بروتين الشوفان والشيا، وخالٍ تماماً من العطور ليناسب أكثر أنواع البشرة تحسساً. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'La Lotion Apaisante offre une alternative légère à l\'HydraButter — pénétration instantanée, hydratation continue sans effet gras. Formulée sur la même base d\'avoine et de karité, sans parfum pour respecter les peaux délicates. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 24.00,
                'weight' => 0.25,
                'family_id' => $familyId,
                'category_id' => $categoryMap['moisturisers'],
                'skin_types' => ['All Skin Types', 'Sensitive', 'Normal', 'Oily'],
                'key_ingredients' => [
                    'en' => 'Colloidal Oat, Shea Butter, Glycerin, Allantoin, Panthenol',
                    'ar' => 'شوفان غروي، زبدة الشيا، جلسرين، ألانتوين، بانثينول',
                    'fr' => 'Avoine colloïdale, beurre de karité, glycérine, allantoïne, panthénol',
                ],
                'usage_ritual' => [
                    'en' => 'Apply a generous amount to clean skin as needed. Absorbs quickly and can be worn under clothing immediately.',
                    'ar' => 'ضعي كمية سخية على بشرة نظيفة عند الحاجة. سريع الامتصاص ويمكن ارتداء الملابس مباشرة بعده.',
                    'fr' => 'Appliquer généreusement sur une peau propre selon les besoins. Sèche rapidement et permet de s\'habiller aussitôt.',
                ],
                'net_weight' => '250 ml / 8.5 fl oz',
                'scent_profile' => [
                    'en' => 'Unscented',
                    'ar' => 'بدون عطر',
                    'fr' => 'Sans parfum',
                ],
                'vegan' => 1,
                'meta_keywords' => [
                    'en' => 'soothing lotion unscented, lightweight oat lotion, daily body lotion, fragrance free, fast absorbing, sensitive skin, cleos lab',
                    'ar' => 'لوشن الترطيب بدون عطر, لوشن الشوفان الخفيف, ترطيب يومي للجسم, بدون رائحة, سريع الامتصاص, بشرة حساسة, كليوز لاب',
                    'fr' => 'lotion apaisante sans parfum, lotion fluide a l avoine, lait corporel quotidien, sans parfum, absorption rapide, peau sensible, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-SL-002',
                'name' => [
                    'en' => 'Soothing Lotion — Rose',
                    'ar' => 'لوشن الترطيب المهدئ — بالورد',
                    'fr' => 'Lotion Apaisante — Rose',
                ],
                'url_key' => [
                    'en' => 'soothing-lotion-rose',
                    'ar' => 'soothing-lotion-rose-ar',
                    'fr' => 'lotion-apaisante-rose',
                ],
                'short_description' => [
                    'en' => 'Lightweight daily lotion with a delicate rose fragrance.',
                    'ar' => 'لوشن يومي خفيف وناعم بعبير الورد الرقيق والمنعش.',
                    'fr' => 'Lotion quotidienne légère au parfum délicat de rose.',
                ],
                'description' => [
                    'en' => 'Soothing Lotion in Rose — quick-absorbing, daily-use hydration with a delicate rose scent. Built on colloidal oat, shea, and glycerin for lasting comfort. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'اللوشن المهدئ بنفحات الورد — ترطيب يومي سريع الامتصاص مع عبير الورد الدمشقي الفواح برقة. يرتكز على الشوفان الغروي وزبدة الشيا والجلسرين لراحة وانتعاش يدومان طويلاً. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'Lotion Apaisante à la Rose — soin quotidien léger qui hydrate instantanément et laisse un sillage floral raffiné. À base d\'avoine colloïdale et de karité pour un confort durable. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 24.00,
                'weight' => 0.25,
                'family_id' => $familyId,
                'category_id' => $categoryMap['moisturisers'],
                'skin_types' => ['All Skin Types', 'Normal', 'Dry'],
                'key_ingredients' => [
                    'en' => 'Colloidal Oat, Shea Butter, Glycerin, Allantoin, Rose Absolute',
                    'ar' => 'شوفان غروي، زبدة الشيا، جلسرين، ألانتوين، خلاصة الورد الطبيعي',
                    'fr' => 'Avoine colloïdale, beurre de karité, glycérine, allantoïne, absolue de rose',
                ],
                'usage_ritual' => [
                    'en' => 'Apply a generous amount to clean skin as needed. Absorbs quickly and can be worn under clothing immediately.',
                    'ar' => 'توضع كمية سخية على بشرة نظيفة عند الرغبة. يمتص سريعاً دون ترك بقايا ويمكن ارتداء الملابس بعده مباشرة.',
                    'fr' => 'Appliquer généreusement sur une peau propre. Absorption rapide permettant l\'habillage immédiat.',
                ],
                'net_weight' => '250 ml / 8.5 fl oz',
                'scent_profile' => [
                    'en' => 'Rose',
                    'ar' => 'عبير الورد',
                    'fr' => 'Rose',
                ],
                'vegan' => 1,
                'meta_keywords' => [
                    'en' => 'soothing lotion rose, rose body lotion, lightweight moisturizer, daily hydrating lotion, rose scent, cleos lab',
                    'ar' => 'لوشن الترطيب بالورد, لوشن الجسم بعبير الورد, ترطيب يومي خفيف, سريع الامتصاص, كليوز لاب',
                    'fr' => 'lotion apaisante rose, lait corps a la rose, hydratant quotidien leger, fluide corps parfume, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-SL-003',
                'name' => [
                    'en' => 'Soothing Lotion — Lavender',
                    'ar' => 'لوشن الترطيب المهدئ — باللافندر',
                    'fr' => 'Lotion Apaisante — Lavande',
                ],
                'url_key' => [
                    'en' => 'soothing-lotion-lavender',
                    'ar' => 'soothing-lotion-lavender-ar',
                    'fr' => 'lotion-apaisante-lavande',
                ],
                'short_description' => [
                    'en' => 'Lightweight daily lotion with a calming lavender fragrance.',
                    'ar' => 'لوشن يومي خفيف وسريع الامتصاص برائحة اللافندر المهدئة.',
                    'fr' => 'Lotion quotidienne légère et apaisante à la lavande relaxante.',
                ],
                'description' => [
                    'en' => 'Soothing Lotion in Lavender — lightweight daily-use hydration with a calming lavender scent for evening routines. Built on colloidal oat, shea, and glycerin. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'اللوشن المهدئ باللافندر — ترطيب يومي خفيف برائحة اللافندر المهدئة للأعصاب، مثالي لروتين العناية والراحة المسائية. غني بالشوفان الغروي وزبدة الشيا. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'Lotion Apaisante à la Lavande — hydratation fluide enrichie d\'un parfum relaxant de lavande, idéale pour apaiser la peau avant le coucher. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 24.00,
                'weight' => 0.25,
                'family_id' => $familyId,
                'category_id' => $categoryMap['moisturisers'],
                'skin_types' => ['All Skin Types', 'Normal', 'Dry'],
                'key_ingredients' => [
                    'en' => 'Colloidal Oat, Shea Butter, Glycerin, Allantoin, Lavender Essential Oil',
                    'ar' => 'شوفان غروي، زبدة الشيا، جلسرين، ألانتوين، زيت اللافندر العطري النقي',
                    'fr' => 'Avoine colloïdale, beurre de karité, glycérine, allantoïne, huile essentielle de lavande',
                ],
                'usage_ritual' => [
                    'en' => 'Apply a generous amount to clean skin as needed. Particularly suitable as part of an evening ritual.',
                    'ar' => 'توضع كمية وفيرة على بشرة نظيفة عند الحاجة. ملائم وموصى به بشكل خاص كطقس مسائي مهدئ.',
                    'fr' => 'Appliquer généreusement sur le corps. Recommandé dans votre routine de fin de journée pour un moment de bien-être.',
                ],
                'net_weight' => '250 ml / 8.5 fl oz',
                'scent_profile' => [
                    'en' => 'Lavender',
                    'ar' => 'اللافندر المهدئ',
                    'fr' => 'Lavande',
                ],
                'vegan' => 1,
                'meta_keywords' => [
                    'en' => 'soothing lotion lavender, lavender body lotion, evening calming body lotion, oat shea lotion, cleos lab',
                    'ar' => 'لوشن الترطيب باللافندر, لوشن الجسم بالخزامى, لوشن مسائي مهدئ, شوفان وشيا, ترطيب خفيف, كليوز لاب',
                    'fr' => 'lotion apaisante lavande, lait corps a la lavande, soin corporel relaxant soir, avoine et karite, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-SL-004',
                'name' => [
                    'en' => 'Soothing Lotion — Citrus',
                    'ar' => 'لوشن الترطيب المهدئ — بالحمضيات',
                    'fr' => 'Lotion Apaisante — Agrumes',
                ],
                'url_key' => [
                    'en' => 'soothing-lotion-citrus',
                    'ar' => 'soothing-lotion-citrus-ar',
                    'fr' => 'lotion-apaisante-agrumes',
                ],
                'short_description' => [
                    'en' => 'Lightweight daily lotion with a fresh citrus fragrance.',
                    'ar' => 'لوشن يومي خفيف ومنعش للجسم بنفحات الحمضيات الحيوية.',
                    'fr' => 'Lotion quotidienne légère et tonique aux accents d\'agrumes.',
                ],
                'description' => [
                    'en' => 'Soothing Lotion in Citrus — lightweight daily hydration with an energising citrus scent. Absorbs quickly on damp or dry skin. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'اللوشن المهدئ بالحمضيات — عناية يومية خفيفة وسريعة الامتصاص بنفحات البرغموت والبرتقال المبهجة. يتغلغل سريعاً على البشرة الجافة أو الرطبة. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'Lotion Apaisante aux Agrumes — formule légère revitalisante au parfum frais d\'agrumes. Pénètre rapidement sans coller. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 24.00,
                'weight' => 0.25,
                'family_id' => $familyId,
                'category_id' => $categoryMap['moisturisers'],
                'skin_types' => ['All Skin Types', 'Normal', 'Dry'],
                'key_ingredients' => [
                    'en' => 'Colloidal Oat, Shea Butter, Glycerin, Allantoin, Citrus Blend (Bergamot, Sweet Orange)',
                    'ar' => 'شوفان غروي، زبدة الشيا، جلسرين، ألانتوين، مزيج الحمضيات (برغموت، برتقال حلو)',
                    'fr' => 'Avoine colloïdale, beurre de karité, glycérine, allantoïne, mélange d\'agrumes (bergamote, orange douce)',
                ],
                'usage_ritual' => [
                    'en' => 'Apply a generous amount to clean skin as needed. Works well as a morning energiser applied to damp skin.',
                    'ar' => 'توضع كمية كافية على بشرة نظيفة عند الحاجة. ممتاز كخطوة صباحية منشطة عند وضعه على بشرة ندية.',
                    'fr' => 'Appliquer généreusement sur peau propre. Idéal le matin sur peau encore humide pour démarrer la journée du bon pied.',
                ],
                'net_weight' => '250 ml / 8.5 fl oz',
                'scent_profile' => [
                    'en' => 'Citrus Blend',
                    'ar' => 'مزيج الحمضيات المنعش',
                    'fr' => 'Mélange d\'agrumes',
                ],
                'vegan' => 1,
                'meta_keywords' => [
                    'en' => 'soothing lotion citrus, citrus daily body lotion, energizing morning lotion, bergamot orange, fast absorbing, cleos lab',
                    'ar' => 'لوشن الترطيب بالحمضيات, لوشن يومي بالحمضيات المنعشة, برغموت وبرتقال حلو, ترطيب سريع الامتصاص, كليوز لاب',
                    'fr' => 'lotion apaisante agrumes, lait corps aux agrumes, lotion tonique matin, bergamote orange, absorption rapide, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-HS-001',
                'name' => [
                    'en' => 'Repair Hair Serum',
                    'ar' => 'سيروم إصلاح وتغذية الشعر',
                    'fr' => 'Sérum Capillaire Réparateur',
                ],
                'url_key' => [
                    'en' => 'repair-hair-serum',
                    'ar' => 'repair-hair-serum-ar',
                    'fr' => 'serum-capillaire-reparateur',
                ],
                'short_description' => [
                    'en' => 'Lightweight hair serum with silk proteins and castor oil for repair and shine.',
                    'ar' => 'سيروم خفيف للشعر ببروتينات الحرير وزيت الخروع للإصلاح واللمعان الفائق.',
                    'fr' => 'Sérum capillaire léger aux protéines de soie et huile de ricin pour brillance et réparation.',
                ],
                'description' => [
                    'en' => 'Castor oil wasn\'t a luxury in ancient Egypt — it was daily maintenance. Our Repair Hair Serum pairs it with silk amino acids and moringa oil for modern-lab precision: lightweight enough to use daily, concentrated enough to make a visible difference in texture and shine. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'لم يكن زيت الخروع مجرد رفاهية في مصر القديمة — بل كان أساس العناية اليومية. يجمع سيروم ترميم الشعر لدينا بين الخروع والأحماض الأمينية الحريرية وزيت المورينجا بدقة علمية: خفيف بما يكفي للاستخدام اليومي، ومركز بما يكفي لإحداث فرق فوري وملموس في لمعان الشعر ونعومته وحمايته من التقصف. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'L\'huile de ricin était un incontournable de la beauté en Égypte antique. Notre Sérum Réparateur l\'associe aux acides aminés de soie et à l\'huile de moringa : suffisamment léger pour un usage quotidien, assez concentré pour transformer la matière et offrir une brillance éclatante. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 32.00,
                'weight' => 0.05,
                'family_id' => $familyId,
                'category_id' => $categoryMap['hair-serums'],
                'skin_types' => ['All Skin Types'],
                'key_ingredients' => [
                    'en' => 'Castor Oil (cold-pressed), Moringa Oil, Silk Amino Acids, Argan Oil, Vitamin E',
                    'ar' => 'زيت الخروع (معصور على البارد)، زيت المورينجا، أحماض أمينية حريرية، زيت الأرجان، فيتامين E',
                    'fr' => 'Huile de ricin (pressée à froid), huile de moringa, acides aminés de soie, huile d\'argan, vitamine E',
                ],
                'usage_ritual' => [
                    'en' => 'Apply 2–4 drops to damp or dry hair, focusing on mid-lengths to ends. Can be used daily as a leave-in treatment or applied before heat styling. Avoid the scalp if hair is fine or oily.',
                    'ar' => 'ضعي 2-4 قطرات على الشعر الرطب أو الجاف، مع التركيز على منتصف الخصلات حتى الأطراف. يمكن استخدامه يومياً كعلاج يترك على الشعر أو قبل التصفيف بالحرارة. تجنبي الجذور وفروة الرأس إذا كان الشعر خفيفاً أو دهنياً.',
                    'fr' => 'Appliquer 2 à 4 gouttes sur cheveux humides ou secs en insistant sur les longueurs et pointes. S\'utilise au quotidien en soin sans rinçage ou avant le coiffage thermique. Éviter le cuir chevelu en cas de cheveux fins ou gras.',
                ],
                'net_weight' => '50 ml / 1.7 fl oz',
                'scent_profile' => [
                    'en' => 'Lightly herbal (natural from moringa)',
                    'ar' => 'عشبي خفيف (طبيعي من المورينجا)',
                    'fr' => 'Légèrement herbacé (naturel de la moringa)',
                ],
                'vegan' => 0,
                'meta_keywords' => [
                    'en' => 'repair hair serum, castor oil hair serum, moringa oil, silk amino acids, split end repair, hair shine, heat protectant, cleos lab',
                    'ar' => 'سيروم اصلاح الشعر, زيت الخروع للشعر, زيت المورينجا, احماض الحرير, علاج التقصف, لمعان الشعر, حماية من الحرارة, كليوز لاب',
                    'fr' => 'serum capillaire reparateur, huile de ricin cheveux, huile de moringa, acides amines de soie, anti pointes fourchues, brillance cheveux, cleos lab',
                ],
            ],
            [
                'sku' => 'CL-HM-001',
                'name' => [
                    'en' => 'Deep Restore Hair Mask',
                    'ar' => 'ماسك الترميم العميق للشعر',
                    'fr' => 'Masque Capillaire Réparateur Intense',
                ],
                'url_key' => [
                    'en' => 'deep-restore-hair-mask',
                    'ar' => 'deep-restore-hair-mask-ar',
                    'fr' => 'masque-capillaire-reparateur-intense',
                ],
                'short_description' => [
                    'en' => 'Intensive honey and shea butter hair mask for deep repair and moisture.',
                    'ar' => 'قناع مكثف بالعسل وزبدة الشيا لترميم الشعر الجاف والتالف وترطيبه بعمق.',
                    'fr' => 'Masque capillaire nourrissant au miel et beurre de karité pour une réparation profonde.',
                ],
                'description' => [
                    'en' => 'Honey was a real wound treatment in ancient Egypt — modern research has confirmed its genuine antibacterial and healing properties, so it earned its place here. Our Deep Restore Hair Mask combines it with shea butter and oat protein for intensive repair that doesn\'t leave hair weighed down. Use weekly for visibly healthier, more resilient hair. Health Canada Notified. Small-batch made in Vancouver, BC.',
                    'ar' => 'كان العسل علاجاً رئيسياً في الطب المصري القديم — وقد أثبتت الأبحاث الحديثة خصائصه الشفائية والترطيبية الفائقة، لذا استحق مكانه هنا. يجمع قناع الترميم العميق لدينا بين العسل النقي وزبدة الشيا وبروتين الشوفان لمنح شعرك عناية وترميماً مكثفاً دون أن يثقل الخصلات. استخدميه أسبوعياً للحصول على شعر قوي وصحي وأكثر حيوية. معتمد لدى هيلث كندا. صُنع بدفعات صغيرة في فانكوفر، كندا.',
                    'fr' => 'Le miel était reconnu pour ses propriétés réparatrices exceptionnelles dès l\'Égypte antique. Notre Masque Capillaire Réparateur Intense l\'associe au beurre de karité et aux protéines d\'avoine pour restaurer la fibre capillaire sans l\'alourdir. À utiliser chaque semaine pour une chevelure visiblement fortifiée et soyeuse. Notifié Santé Canada. Fabriqué en petits lots à Vancouver, C.-B.',
                ],
                'price' => 30.00,
                'weight' => 0.30,
                'family_id' => $familyId,
                'category_id' => $categoryMap['hair-masks'],
                'skin_types' => ['All Skin Types'],
                'key_ingredients' => [
                    'en' => 'Honey (natural humectant), Shea Butter, Oat Protein, Castor Oil, Panthenol (B5)',
                    'ar' => 'عسل نقي طبيعي، زبدة الشيا، بروتين الشوفان، زيت الخروع، بانثينول (B5)',
                    'fr' => 'Miel (humectant naturel), beurre de karité, protéines d\'avoine, huile de ricin, panthénol (B5)',
                ],
                'usage_ritual' => [
                    'en' => 'After shampooing, apply generously from roots to ends on wet hair. Leave on for 10–20 minutes (longer for very dry or damaged hair). Rinse thoroughly with cool water. Use once or twice weekly.',
                    'ar' => 'بعد غسل الشعر بالشامبو، يوضع بسخاء من الجذور حتى الأطراف على شعر مبلل. يترك لمدة 10-20 دقيقة (أو أكثر للشعر شديد الجفاف أو التالف). يشطف جيداً بالماء الفاتر أو البارد. يستخدم مرة إلى مرتين أسبوعياً.',
                    'fr' => 'Après le shampooing, appliquer généreusement des racines aux pointes sur cheveux essorés. Laisser poser 10 à 20 minutes (plus longtemps pour les cheveux très abîmés). Rincer abondamment à l\'eau fraîche. Utiliser 1 à 2 fois par semaine.',
                ],
                'net_weight' => '300 ml / 10.1 fl oz',
                'scent_profile' => [
                    'en' => 'Warm honey and botanicals',
                    'ar' => 'العسل الدافئ والمستخلصات النباتية',
                    'fr' => 'Miel chaleureux et notes végétales',
                ],
                'vegan' => 0,
                'meta_keywords' => [
                    'en' => 'deep restore hair mask, honey hair mask, shea butter hair treatment, oat protein, damaged hair repair, weekly hair mask, cleos lab',
                    'ar' => 'ماسك الترميم العميق للشعر, ماسك العسل للشعر, علاج الشعر بزبدة الشيا, بروتين الشوفان, اصلاح الشعر التالف, ماسك اسبوعي, كليوز لاب',
                    'fr' => 'masque capillaire reparateur intense, masque cheveux au miel, soin karite cheveux, proteines d avoine, reparation cheveux abimes, cleos lab',
                ],
            ],
        ];
    }
}
