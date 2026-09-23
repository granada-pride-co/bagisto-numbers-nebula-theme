<?php

namespace NumbersNebula\NebulaCosmetics\Models;

use Webkul\Theme\Contracts\Section as SectionContract;
use Webkul\Theme\Models\Section as BaseSection;
use Webkul\Theme\SectionSchema;
use Webkul\Theme\Sections\SectionType;

class Section extends BaseSection implements SectionContract
{
    /**
     * Translation model class.
     *
     * @var string
     */
    protected $translationModel = \Webkul\Theme\Models\SectionTranslation::class;

    /**
     * Map of legacy hardcoded section names to their translation keys.
     *
     * @var array<string, string>
     */
    protected const LEGACY_NAME_TRANSLATIONS = [
        'شريط الإعلانات الترويجي' => 'nc::app.sections.announcement.title',
        'الواجهة الرئيسية (بنر مزدوج)' => 'nc::app.sections.hero.title',
        'بيان النص والاقتباس' => 'nc::app.sections.manifesto.title',
        'شبكة البطاقات والمميزات' => 'nc::app.sections.concerns.title',
        'بنر تسويقي' => 'nc::app.sections.campaign.title',
        'شبكة المنتجات' => 'nc::app.sections.featured_products.title',
        'خطوات العمل والمميزات' => 'nc::app.sections.routine.title',
        'المجموعات والتصنيفات' => 'nc::app.sections.collections.title',
        'بنر العرض والمكافآت' => 'nc::app.sections.rewards.title',
        'شريط التواصل الاجتماعي' => 'nc::app.sections.social_line.title',
        'شريط المزايا الأربعة' => 'nc::app.sections.service_strip.title',
        'صندوق النشرة البريدية' => 'nc::app.sections.newsletter.title',
        'الواجهة الرئيسية التفاعلية (تتبع المؤشر)' => 'nc::app.sections.interactive_hero.title',
        'معلومات وروابط التذييل (الفوتر)' => 'nc::app.sections.footer.title',
        'محتوى مخصص HTML و CSS' => 'nc::app.sections.html.title',
        'الحكمة القديمة × الصيدلة الحديثة (مقارنة المكونات)' => 'nc::app.sections.ancient_modern.title',
        'طقس العناية في 4 خطوات (Cleo Ritual)' => 'nc::app.sections.cleo_ritual.title',
        'جدول التجديد الليلي وتناوب الأحماض (Night Cycling)' => 'nc::app.sections.night_cycling.title',
        'درع المناخ (من شمس النيل إلى شتاء كندا)' => 'nc::app.sections.climate_defense.title',
        'خرافات الجمال وحقائق الصيدلة (Beauty Myths)' => 'nc::app.sections.beauty_myths.title',
        'المختبر والعائلة الصيدلانية (Founders Lab)' => 'nc::app.sections.founders_lab.title',
        'موسوعة المكونات الفعالة والشفافية (Actives Index)' => 'nc::app.sections.actives_index.title',
        'الجدول الزمني للنتائج الواقعية (Results Timeline)' => 'nc::app.sections.results_timeline.title',
        'بروتوكول اختبار الحساسية وإرشادات الأمان (Patch Test)' => 'nc::app.sections.patch_test.title',
        'مصر القديمة، في الواقع (التراث والجالية)' => 'nc::app.sections.ancient_heritage.title',
        'Image Carousel' => 'admin::app.appearance.sections.create.type.image-carousel',
        'Offer Information' => 'installer::app.seeders.shop.theme-customizations.offer-information.name',
        'Categories Collections' => 'installer::app.seeders.shop.theme-customizations.categories-collections.name',
        'Mens Collection' => 'installer::app.seeders.shop.theme-customizations.mens-collection.name',
        'Top Collections' => 'installer::app.seeders.shop.theme-customizations.top-collections.name',
        'Bold Collections' => 'installer::app.seeders.shop.theme-customizations.bold-collections.name',
        'Womens Collection' => 'installer::app.seeders.shop.theme-customizations.womens-collection.name',
        'Game Container' => 'installer::app.seeders.shop.theme-customizations.game-container.name',
        'Kids Collection' => 'installer::app.seeders.shop.theme-customizations.kids-collection.name',
        'Book Tickets' => 'installer::app.seeders.shop.theme-customizations.book-tickets.name',
        'Services Content' => 'installer::app.seeders.shop.theme-customizations.services-content.name',
        'Footer Links' => 'installer::app.seeders.shop.theme-customizations.footer-links.name',
    ];

    /**
     * Get the translated section name.
     */
    public function getNameAttribute(?string $value): ?string
    {
        if (! $value) {
            return $value;
        }

        if (isset(self::LEGACY_NAME_TRANSLATIONS[$value])) {
            return trans(self::LEGACY_NAME_TRANSLATIONS[$value]);
        }

        return trans()->has($value) ? trans($value) : $value;
    }

    /**
     * Get the section type the section's theme handles it with.
     */
    public function getTypeInstance(): ?SectionType
    {
        return app(SectionSchema::class)->type($this->theme_code, $this->type);
    }
}
