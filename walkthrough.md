# توثيق إنجاز ثيم «سديم كوزمتكس (Nebula Cosmetics)» كحزمة مخصصة لـ Bagisto 2.4.x / 2.5.x

تم بنجاح بناء وتطوير ثيم **«سديم كوزمتكس (Nebula Cosmetics)»** كحزمة لارافيل وباجيستو مستقلة تحت المجلد `packages/numbers-nebula/nebula-cosmetics`، مستوحاة بالكامل من تصميم الكوزمتكس الفاخر مع جعل كافة أجزاء المتجر ديناميكية وقابلة للتخصيص بنسبة 100% عبر نظام الأقسام التفاعلية (Dynamic Sections Builder).

---

## 1. الأجزاء الديناميكية المطورة

1. **الشعار والعلامة التجارية (Dynamic Logo & Wordmark)**:
   - قراءة الشعار تلقائياً من إعدادات القناة في لوحة التحكم (`Channels > Logo`).
   - قفل طباعي فاخر (`nc-brand-lockup`) مع زهرة اللوتس / السديم واسم المتجر ديناميكياً.
2. **شريط الإعلانات الترويجي (Announcement Bar)**:
   - قابل للتخصيص بالكامل من البيلدر (`nc_announcement`) بنص الخصم والرابط وزر التسجيل.
3. **القوائم وشجرة الفئات (Navigation & Categories)**:
   - جلب الفئات الحية مباشرة من قاعدة البيانات مع الروابط والصور عبر `CategoryRepository::getVisibleCategoryTree()`.
   - إمكانية تجاوز الروابط بروابط مخصصة من لوحة الإدارة عبر قسم `nc_header_nav`.
   - قائمة منسدلة سريعة للأجهزة الذكية (Mobile Nav Drawer).
4. **حساب العميل والبحث الفوري (Account & Instant Search)**:
   - ربط كامل بحالة تسجيل الدخول للعميل (عرض الاسم وقائمة الطلبات والملف الشخصي وزر تسجيل الخروج).
   - نافذة بحث منبثقة تفاعلية (`nc-search-layer`) مع اقتراحات سريعة للفئات.
5. **حقيبة التسوق المنزلقة (Slide-out Cart Drawer)**:
   - درج سلة جانبي فاخر متصل بـ Bagisto Cart Session مع حساب المجموع الفرعي وزر إتمام الطلب وزر الإضافة السريعة بالـ AJAX (`data-nc-quick-add`).
6. **عرض المنتجات الحي (Dynamic Products Rail)**:
   - سحب المنتجات الفعلية بأسعار العملة المختارة (`core()->currency()`) وصورها وروابطها من قاعدة البيانات.

---

## 2. أقسام البيلدر المتوفرة للثيم

| رمز القسم | الفئة البرمجية | الوظيفة |
|---|---|---|
| `nc_announcement` | `AnnouncementSection` | شريط الإعلانات الترويجي أعلى المتجر |
| `nc_header_nav` | `HeaderNavSection` | تخصيص روابط القائمة العلوية والشعار |
| `nc_hero` | `HeroSection` | واجهة المتجر الرئيسية المنقسمة (Hero Split Panel) |
| `nc_manifesto` | `ManifestoSection` | بيان الرؤية والاقتباس التحريري الفاخر |
| `nc_concerns` | `ConcernsSection` | شبكة العناية حسب نوع واحتياج البشرة |
| `nc_campaign` | `CampaignSection` | بانر الحملة الترويجية والطقوس الجمالية |
| `nc_featured_products` | `FeaturedProductsSection` | شريط استعراض المنتجات المميزة وقائمة الأكثر طلباً |
| `nc_routine` | `RoutineSection` | دليل خطوات بناء الروتين اليومي (Nebula Mixology) |
| `nc_collections` | `CollectionsSection` | بطاقات التسوق حسب نوع العبوة والمجموعة |
| `nc_rewards` | `RewardsSection` | بانر برنامج الولاء والمكافآت |
| `nc_social_line` | `SocialLineSection` | شريط حسابات ومجتمع سديم على وسائل التواصل |
| `nc_service_strip` | `ServiceStripSection` | شريط مزايا وثقة المتجر الأربعة |
| `nc_newsletter` | `NewsletterSection` | نموذج الانضمام للنشرة البريدية مع إشعار فوري |
| `nc_footer` | `FooterSection` | ذيل الصفحة الديناميكي مع روابط الفئات ومعلومات المتجر |
| `nc_html` | `HtmlSection` | قسم مخصص لحقن شفرات HTML و CSS حرة |

---

## 3. الأصول وبناء الواجهة

- دعم كامل للغتين العربية (`ar`) والإنجليزية (`en`) واتجاهات الخط (`RTL` و `LTR`).
- خطوط طباعية فاخرة: Cormorant Garamond، DM Sans، IBM Plex Sans Arabic، Tajawal، Courier Prime.
- بناء الأصول مستقلاً عبر Vite 6 و Tailwind CSS 3.
