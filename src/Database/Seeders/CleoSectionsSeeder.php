<?php

namespace NumbersNebula\NebulaCosmetics\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Theme\Repositories\SectionRepository;

class CleoSectionsSeeder extends Seeder
{
    /**
     * Create a new seeder instance.
     */
    public function __construct(
        protected SectionRepository $sectionRepository,
        protected ChannelRepository $channelRepository
    ) {}

    /**
     * Run the database seeds.
     */
    public function run($channel = null): void
    {
        $channel = $channel ?: $this->channelRepository->first();

        if (! $channel) {
            return;
        }

        $this->ensureLocalesConfigured($channel);

        $this->seedSections($channel);
    }

    /**
     * Ensure French locale exists and is linked to the channel.
     */
    protected function ensureLocalesConfigured($channel): void
    {
        $now = now();

        $frLocale = DB::table('locales')->where('code', 'fr')->first();

        if (! $frLocale) {
            $frId = DB::table('locales')->insertGetId([
                'code' => 'fr',
                'name' => 'French',
                'direction' => 'ltr',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $frId = $frLocale->id;
        }

        $linked = DB::table('channel_locales')
            ->where('channel_id', $channel->id)
            ->where('locale_id', $frId)
            ->exists();

        if (! $linked) {
            DB::table('channel_locales')->insert([
                'channel_id' => $channel->id,
                'locale_id' => $frId,
            ]);
        }
    }

    /**
     * Seed all 10 Cleo's Lab sections with English, French and Arabic translations.
     */
    protected function seedSections($channel): void
    {
        $locales = ['en', 'fr', 'ar'];

        $sections = $this->getSectionsPayload($channel->id);

        foreach ($sections as $sectionData) {
            $translations = $sectionData['options'];
            unset($sectionData['options']);

            $existing = $this->sectionRepository->findOneWhere([
                'type' => $sectionData['type'],
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
            ]);

            $section = $existing ?: $this->sectionRepository->create($sectionData);

            $section->status = 1;
            $section->draft_status = 1;
            $section->sort_order = $sectionData['sort_order'];
            $section->draft_sort_order = $sectionData['sort_order'];

            foreach ($locales as $locale) {
                if (isset($translations[$locale])) {
                    $translation = $section->translateOrNew($locale);
                    $translation->options = $translations[$locale];
                    $translation->draft_options = $translations[$locale];
                }
            }

            $section->save();
        }
    }

    /**
     * Get the complete data payload for the 10 Cleo's Lab sections.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function getSectionsPayload(int $channelId): array
    {
        return [
            [
                'name' => 'المنتجات حسب التصنيف (تابات تفاعلية)',
                'type' => 'nc_category_tabs_products',
                'sort_order' => 4,
                'status' => 1,
                'channel_id' => $channelId,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'en' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'TARGETED PHARMACEUTICAL CARE',
                        'title' => "Explore Formulas by Category:\nAncient Actives for Every Need.",
                        'description' => 'Switch between collections to find small-batch formulas developed by Dr. Albadry — from targeted daytime serums to nocturnal barrier repair.',
                        'badge_text' => 'CLINICAL ACTIVE',
                        'show_all_tab' => '1',
                        'filters' => [
                            'category_ids' => [43, 44, 45, 46, 48, 49],
                            'limit' => 8,
                            'sort' => 'created_at-desc',
                            'featured' => 0,
                            'new' => 0,
                        ],
                        'btn_text' => 'VIEW ALL FORMULAS',
                        'btn_link' => '#shop',
                    ],
                    'fr' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'SOINS CIBLÉS PHARMACEUTIQUES',
                        'title' => "Explorez Nos Formules par Catégorie :\nDes Actifs Pour Chaque Besoin.",
                        'description' => 'Naviguez entre nos collections formulées en petits lots à Vancouver — des sérums de jour antioxydants aux soins barrières de nuit.',
                        'badge_text' => 'ACTIF CLINIQUE',
                        'show_all_tab' => '1',
                        'filters' => [
                            'category_ids' => [43, 44, 45, 46, 48, 49],
                            'limit' => 8,
                            'sort' => 'created_at-desc',
                            'featured' => 0,
                            'new' => 0,
                        ],
                        'btn_text' => 'VOIR TOUS LES SOINS',
                        'btn_link' => '#shop',
                    ],
                    'ar' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'عناية صيدلانية موجهة',
                        'title' => "استكشفي المستحضرات حسب التصنيف:\nتركيبات نقية لكل احتياج.",
                        'description' => 'تنقلي بين فئات العناية لاكتشاف تركيبات د. البدري المصنوعة يدوياً في فانكوفر — من سيرومات النضارة الصباحية إلى كريمات ترميم حاجز البشرة الليلي.',
                        'badge_text' => 'تركيز صيدلاني',
                        'show_all_tab' => '1',
                        'filters' => [
                            'category_ids' => [43, 44, 45, 46, 48, 49],
                            'limit' => 8,
                            'sort' => 'created_at-desc',
                            'featured' => 0,
                            'new' => 0,
                        ],
                        'btn_text' => 'عرض جميع المنتجات',
                        'btn_link' => '#shop',
                    ],
                ],
            ],
            [
                'name' => 'الحكمة القديمة × الصيدلة الحديثة (مقارنة المكونات)',
                'type' => 'nc_ancient_modern',
                'sort_order' => 5,
                'status' => 1,
                'channel_id' => $channelId,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'en' => [
                        'bg_color' => '#f7f4ea',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'ANCIENT INSTINCT × MODERN CHEMISTRY',
                        'title' => "Ancient Egyptian Instinct,\nModern Pharmaceutical Precision.",
                        'description' => 'Every formula pairs an ingredient trusted in the Nile valley for thousands of years with the active that does the same job today — no gap between ancient instinct and laboratory science.',
                        'cards' => [
                            [
                                'ancient_name' => 'Cleopatra\'s Milk Baths',
                                'ancient_origin' => 'Documented Egyptian beauty ritual',
                                'ancient_desc' => 'Sour milk was applied across dynasties for its natural, gentle smoothing and clarifying effects.',
                                'modern_active' => 'Lactic Acid (5% AHA)',
                                'modern_function' => 'The gentle alpha hydroxy acid that dissolves dead cellular debris without barrier damage.',
                                'badge' => 'PROVEN AHA',
                            ],
                            [
                                'ancient_name' => 'Turmeric & Licorice Root',
                                'ancient_origin' => 'Traditional radiant skin unguents',
                                'ancient_desc' => 'Applied to even discoloration, brighten dullness, and calm reactive desert skin.',
                                'modern_active' => 'Niacinamide (Vitamin B3)',
                                'modern_function' => 'Clinical-grade active strengthening ceramides, fading dark spots, and reducing redness.',
                                'badge' => 'CLINICAL GRADE',
                            ],
                            [
                                'ancient_name' => 'Sacred Botanical Oils',
                                'ancient_origin' => 'Castor, moringa & botanical infusions',
                                'ancient_desc' => 'Daily cellular protection against harsh winds and extreme climate conditions.',
                                'modern_active' => 'Bakuchiol (Phyto-Retinol)',
                                'modern_function' => 'Stimulates cellular turnover and collagen synthesis without retinol peeling or sun-sensitivity.',
                                'badge' => 'ZERO IRRITATION',
                            ],
                            [
                                'ancient_name' => 'Natural Silk Fibers',
                                'ancient_origin' => 'Luxury royal balms & textures',
                                'ancient_desc' => 'Imparted a velvet, breathable sheen to skin and hair without pore clogging.',
                                'modern_active' => 'Silk Amino Acids',
                                'modern_function' => 'Replaces synthetic silicones, creating a protective weightless moisture-binding film.',
                                'badge' => 'CLEAN ALTERNATIVE',
                            ],
                        ],
                        'btn_text' => 'EXPLORE OUR FORMULAS',
                        'btn_link' => '#shop',
                    ],
                    'fr' => [
                        'bg_color' => '#f7f4ea',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'INSTINCT ANCIEN × CHIMIE MODERNE',
                        'title' => "L'Instinct Égyptien Ancien,\nLa Précision Pharmaceutique Moderne.",
                        'description' => 'Chaque formule associe un ingrédient éprouvé au bord du Nil depuis des millénaires à l\'actif de pointe qui accomplit la même mission aujourd\'hui — sans compromis entre tradition et rigueur scientifique.',
                        'cards' => [
                            [
                                'ancient_name' => 'Bains de Lait de Cléopâtre',
                                'ancient_origin' => 'Rituel documenté de la royauté égyptienne',
                                'ancient_desc' => 'Le lait aigre était utilisé pour son action lissante et purifiante douce et naturelle.',
                                'modern_active' => 'Acide Lactique (5% AHA)',
                                'modern_function' => 'L\'acide alpha-hydroxylé doux qui élimine les cellules mortes sans agresser la barrière cutanée.',
                                'badge' => 'AHA ÉPROUVÉ',
                            ],
                            [
                                'ancient_name' => 'Curcuma & Racine de Réglisse',
                                'ancient_origin' => 'Baumes traditionnels pour le teint',
                                'ancient_desc' => 'Appliqués pour estomper les taches, raviver l\'éclat et apaiser la peau agressée par le désert.',
                                'modern_active' => 'Niacinamide (Vitamine B3)',
                                'modern_function' => 'Actif clinique renforçant les céramides, unifiant le teint et estompant les rougeurs.',
                                'badge' => 'GRADE CLINIQUE',
                            ],
                            [
                                'ancient_name' => 'Huiles Végétales Sacrées',
                                'ancient_origin' => 'Macérats de ricin et de moringa',
                                'ancient_desc' => 'Protection cellulaire quotidienne contre les tempêtes de sable et les brûlures solaires.',
                                'modern_active' => 'Bakuchiol (Phyto-Rétinol)',
                                'modern_function' => 'Stimule le renouvellement cellulaire et le collagène sans irritation ni desquamation.',
                                'badge' => 'ZÉRO IRRITATION',
                            ],
                            [
                                'ancient_name' => 'Fibres de Soie Naturelle',
                                'ancient_origin' => 'Onguents royaux texturés',
                                'ancient_desc' => 'Offrait un fini velouté et respirant à la peau et aux cheveux sans obstruer les pores.',
                                'modern_active' => 'Acides Aminés de Soie',
                                'modern_function' => 'Remplace les silicones synthétiques en formant un film soyeux qui retient l\'eau.',
                                'badge' => 'ALTERNATIVE PROPRE',
                            ],
                        ],
                        'btn_text' => 'DÉCOUVRIR NOS FORMULES',
                        'btn_link' => '#shop',
                    ],
                    'ar' => [
                        'bg_color' => '#f7f4ea',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'أسرار الفراعنة × الصيدلة الحديثة',
                        'title' => "الحكمة الفرعونية القديمة،\nبدقة صيدلانية معاصرة.",
                        'description' => 'كل تركيبة في Cleo\'s Lab تجمع بين مكوّن عرفته الحضارة المصرية القديمة لآلاف السنين، والمركب الفعال الصيدلاني الذي يؤدي نفس الدور اليوم بدقة مثبتة مخبرياً — نجمع بين أصالة التاريخ وبحوث المختبر.',
                        'cards' => [
                            [
                                'ancient_name' => 'حمامات حليب كليوباترا',
                                'ancient_origin' => 'طقس جمالي موثق تاريخياً',
                                'ancient_desc' => 'استُخدم الحليب المتخمر لتنعيم البشرة وتنقيتها بفضل أحماض اللاكتيك الطبيعية.',
                                'modern_active' => 'حمض اللاكتيك (5% AHA)',
                                'modern_function' => 'حمض التقشير اللطيف الذي يزيل خلايا الجلد الميتة دون إتلاف حاجز البشرة.',
                                'badge' => 'حمض AHA مثبت',
                            ],
                            [
                                'ancient_name' => 'الكركم وجذور عرق السوس',
                                'ancient_origin' => 'دهانات النضارة وتوحيد اللون',
                                'ancient_desc' => 'اعتمدها القدماء لتفتيح التصبغات، تهدئة البشرة الصحراوية، ومكافحة الالتهابات.',
                                'modern_active' => 'النياسيناميد (فيتامين B3)',
                                'modern_function' => 'مركب صيدلاني نقي يجدد السيراميدات، يخفف الاحمرار، ويوحد لون البشرة.',
                                'badge' => 'تركيز صيدلاني',
                            ],
                            [
                                'ancient_name' => 'الزيوت النباتية المقدسة',
                                'ancient_origin' => 'المورينجا والخروع واللوز',
                                'ancient_desc' => 'حماية يومية ضد الشمس والرياح الجافة لترميم خلايا الجلد المعرضة للعوامل القاسية.',
                                'modern_active' => 'الباكوتشيول (بديل الريتينول)',
                                'modern_function' => 'يحفز الكولاجين وتجدد الخلايا دون تهيج، جفاف، أو حساسية للشمس كالريتينول.',
                                'badge' => 'بدون أي تهيج',
                            ],
                            [
                                'ancient_name' => 'بروتينات الحرير الطبيعي',
                                'ancient_origin' => 'مستخلصات الملمس المخملي الملكي',
                                'ancient_desc' => 'تمنح البشرة ملمساً ناعماً يسمح للجلد بالتنفس دون انسداد المسام.',
                                'modern_active' => 'أحماض الحرير الأمينية',
                                'modern_function' => 'البديل النظيف للسيليكون، يشكل طبقة واقية تحبس الرطوبة وتمنح نعومة فورية.',
                                'badge' => 'بديل نظيف وآمن',
                            ],
                        ],
                        'btn_text' => 'استكشفي تركيباتنا',
                        'btn_link' => '#shop',
                    ],
                ],
            ],
            [
                'name' => 'طقس العناية في 4 خطوات (Cleo Ritual)',
                'type' => 'nc_cleo_ritual',
                'sort_order' => 6,
                'status' => 1,
                'channel_id' => $channelId,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'en' => [
                        'bg_color' => '#fbf8f1',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'DAILY TREATMENT RITUAL',
                        'title' => "Simple Steps to Calm, Clear,\nand Beautiful Skin.",
                        'subtitle' => 'Framed as an active treatment ritual — what to layer on clean skin in precise order for maximum cellular absorption and barrier resilience.',
                        'steps' => [
                            [
                                'step_number' => '01',
                                'step_title' => 'Wake It Up',
                                'product_name' => 'Morning Glow Serum',
                                'timing' => 'AM Routine',
                                'key_actives' => 'Hyaluronic Acid + Guava Extract + Green Tea EGCG',
                                'instructions' => 'Apply 3-4 drops to clean, damp skin. Hyaluronic acid pulls in hydration while potent antioxidants wake up tired skin in 5 minutes.',
                                'product_link' => '#shop',
                            ],
                            [
                                'step_number' => '02',
                                'step_title' => 'Target It',
                                'product_name' => 'Moonlight Serum / 5% AHA',
                                'timing' => 'PM (Alternate Nights)',
                                'key_actives' => 'Bakuchiol & Licorice Root OR 5% Lactic Acid',
                                'instructions' => 'Alternate between Moonlight (for collagen & tone) and 5% AHA (for gentle resurfacing 2-3 nights a week). Never run both the same night.',
                                'product_link' => '#shop',
                            ],
                            [
                                'step_number' => '03',
                                'step_title' => 'Don\'t Forget the Eyes',
                                'product_name' => 'Nour Eye Cream',
                                'timing' => 'AM & PM',
                                'key_actives' => 'Niacinamide + Botanical Caffeine',
                                'instructions' => 'Gently pat under eyes. Niacinamide and caffeine work synergistically to brighten dark circles and temporarily de-puff tired eyes.',
                                'product_link' => '#shop',
                            ],
                            [
                                'step_number' => '04',
                                'step_title' => 'Seal It In',
                                'product_name' => 'HydraButter / Soothing Lotion',
                                'timing' => 'Lock-In Step',
                                'key_actives' => 'Pure Shea Butter + Hydrolyzed Oat Protein',
                                'instructions' => 'Massage over damp skin to seal in moisture. Oat protein holds water inside the barrier rather than adding heavy surface grease.',
                                'product_link' => '#shop',
                            ],
                        ],
                        'bundle_badge' => 'COMPLETE RITUAL • SAVE 15%',
                        'bundle_btn_text' => 'SHOP THE 4-STEP RITUAL',
                        'bundle_btn_link' => '#shop',
                    ],
                    'fr' => [
                        'bg_color' => '#fbf8f1',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'RITUEL DE SOIN QUOTIDIEN',
                        'title' => "Des Étapes Simples Pour Une Peau Apaisée,\nNette et Éclatante.",
                        'subtitle' => 'Un rituel de traitement ciblé — l\'art de superposer les actifs sur une peau propre dans un ordre précis pour une efficacité cutanée optimale.',
                        'steps' => [
                            [
                                'step_number' => '01',
                                'step_title' => 'Éveiller la Peau',
                                'product_name' => 'Sérum Morning Glow',
                                'timing' => 'Matin',
                                'key_actives' => 'Acide Hyaluronique + Goyave + Thé Vert EGCG',
                                'instructions' => 'Appliquez 3 à 4 gouttes sur peau humide. L\'acide hyaluronique capte l\'eau tandis que les antioxydants illuminent le teint en 5 minutes.',
                                'product_link' => '#shop',
                            ],
                            [
                                'step_number' => '02',
                                'step_title' => 'Cibler & Renouveler',
                                'product_name' => 'Sérum Moonlight / 5% AHA',
                                'timing' => 'Soir (En Alternance)',
                                'key_actives' => 'Bakuchiol & Réglisse OU Acide Lactique 5%',
                                'instructions' => 'Alternez entre Moonlight (fermeté et éclat) et l\'AHA 5% (lissage 2 à 3 soirs par semaine). Ne les superposez jamais le même soir.',
                                'product_link' => '#shop',
                            ],
                            [
                                'step_number' => '03',
                                'step_title' => 'Prendre Soin du Regard',
                                'product_name' => 'Crème Regard Nour',
                                'timing' => 'Matin & Soir',
                                'key_actives' => 'Niacinamide + Caféine Botanique',
                                'instructions' => 'Tapotez doucement sous les yeux. La niacinamide et la caféine illuminent les cernes et décongestionnent visiblement le regard.',
                                'product_link' => '#shop',
                            ],
                            [
                                'step_number' => '04',
                                'step_title' => 'Sceller l\'Hydratation',
                                'product_name' => 'HydraButter / Lotion Apaisante',
                                'timing' => 'Étape Finale',
                                'key_actives' => 'Beurre de Karité + Protéine d\'Avoine',
                                'instructions' => 'Massez sur peau humide pour sceller les actifs. Les protéines d\'avoine emprisonnent l\'eau pour une peau confortable jusqu\'à 15h.',
                                'product_link' => '#shop',
                            ],
                        ],
                        'bundle_badge' => 'RITUEL COMPLET • -15% D\'ÉCONOMIE',
                        'bundle_btn_text' => 'COMMANDER LE RITUEL COMPLET',
                        'bundle_btn_link' => '#shop',
                    ],
                    'ar' => [
                        'bg_color' => '#fbf8f1',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'طقس العناية اليومي المتكامل',
                        'title' => "خطوات بسيطة لبشرة هادئة،\nنقية ومتألقة.",
                        'subtitle' => 'طقس علاجي مدروس لبناء طبقات العناية على بشرة نظيفة بالترتيب الصيدلاني الصحيح، لتغذية خلايا الجلد وترميم الحاجز الواقي.',
                        'steps' => [
                            [
                                'step_number' => '01',
                                'step_title' => 'إيقاظ النضارة الصباحية',
                                'product_name' => 'Morning Glow Serum',
                                'timing' => 'صباحاً على بشرة رطبة',
                                'key_actives' => 'حمض الهيالورونيك + مستخلص الجوافة + الشاي الأخضر',
                                'instructions' => 'ضعي 3-4 قطرات صباحاً. يجذب الهيالورونيك الرطوبة بينما تعمل مضادات الأكسدة على إعطاء إشراقة كأنك نلتِ قسطاً وافراً من النوم في 5 دقائق.',
                                'product_link' => '#shop',
                            ],
                            [
                                'step_number' => '02',
                                'step_title' => 'الاستهداف والتجديد الليلي',
                                'product_name' => 'Moonlight Serum أو مقشر 5% AHA',
                                'timing' => 'مساءً (بالتناوب)',
                                'key_actives' => 'الباكوتشيول وعرق السوس أو حمض اللاكتيك 5%',
                                'instructions' => 'بدّلي في المساء بين سيروم Moonlight (لتحفيز الكولاجين وتوحيد اللون) ومقشر AHA (لتنعيم الملمس 2-3 ليالٍ أسبوعياً). لا تجمعي بينهما في نفس الليلة.',
                                'product_link' => '#shop',
                            ],
                            [
                                'step_number' => '03',
                                'step_title' => 'العناية المركزة بمحيط العينين',
                                'product_name' => 'Nour Eye Cream',
                                'timing' => 'صباحاً ومساءً',
                                'key_actives' => 'النياسيناميد + الكافيين الطبيعي',
                                'instructions' => 'طبطبي برفق تحت العينين. يعمل النياسيناميد والكافيين معاً على تفتيح الهالات الداكنة وإزالة الانتفاخ الصباحي بفاعلية حقيقية.',
                                'product_link' => '#shop',
                            ],
                            [
                                'step_number' => '04',
                                'step_title' => 'ختم وترميم الرطوبة',
                                'product_name' => 'HydraButter أو Soothing Lotion',
                                'timing' => 'الخطوة الختامية',
                                'key_actives' => 'زبدة الشيا النقية + بروتين الشوفان المتحلل',
                                'instructions' => 'دلكي كمية مناسبة على بشرة رطبة. زبدة الشيا والشوفان تحبس الماء داخل الأنسجة وتمنحك ترطيباً ملموساً يستمر حتى الثالثة عصراً.',
                                'product_link' => '#shop',
                            ],
                        ],
                        'bundle_badge' => 'الروتين كاملاً • وفر 15%',
                        'bundle_btn_text' => 'تسوقي الروتين المتكامل الآن',
                        'bundle_btn_link' => '#shop',
                    ],
                ],
            ],
            [
                'name' => 'جدول التجديد الليلي وتناوب الأحماض (Night Cycling)',
                'type' => 'nc_night_cycling',
                'sort_order' => 7,
                'status' => 1,
                'channel_id' => $channelId,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'en' => [
                        'bg_color' => '#2e2224',
                        'text_color' => '#fbf8f1',
                        'eyebrow' => 'PHARMACEUTICAL NIGHT CYCLING',
                        'title' => "Night Skin Cycling:\nLet Skin Actually Use What You Put on It.",
                        'subtitle' => 'Formulating with potent actives means knowing when to pause. Alternating nights prevents skin fatigue and delivers visible cellular renewal without redness.',
                        'warning_note' => 'Clinical Directive: Do not apply Moonlight Serum and 5% AHA Exfoliant on the exact same night. Alternating them preserves the lipid barrier.',
                        'schedule_items' => [
                            [
                                'days' => 'Mon, Wed, Fri',
                                'treatment_name' => 'Cellular Renewal Protocol',
                                'product_name' => 'Moonlight Serum (Bakuchiol)',
                                'action_type' => 'Renewal',
                                'instructions' => 'Smooth 3-4 drops across clean skin. Bakuchiol stimulates deep collagen and refines skin texture without irritation.',
                            ],
                            [
                                'days' => 'Tue & Thu',
                                'treatment_name' => 'Gentle Resurfacing Nights',
                                'product_name' => '5% AHA Exfoliant (Lactic Acid)',
                                'action_type' => 'Exfoliation',
                                'instructions' => 'Sweep gently across face to dissolve dull dead cells. Refines pores and clears texture while you sleep.',
                            ],
                            [
                                'days' => 'Sat & Sun',
                                'treatment_name' => 'Barrier Recovery & Nourish',
                                'product_name' => 'HydraButter / Nour Eye Cream',
                                'action_type' => 'Recovery',
                                'instructions' => 'Rest the actives. Apply HydraButter and Nour Eye Cream generously to rebuild lipids and replenish moisture.',
                            ],
                        ],
                        'btn_text' => 'EXPLORE NIGHT PROTOCOLS',
                        'btn_link' => '#shop',
                    ],
                    'fr' => [
                        'bg_color' => '#2e2224',
                        'text_color' => '#fbf8f1',
                        'eyebrow' => 'CYCLE NOCTURNE PHARMACEUTIQUE',
                        'title' => "Le Cycle de Soin Nocturne :\nLaissez Votre Peau Assimiler les Actifs.",
                        'subtitle' => 'L\'efficacité réside dans la modération intelligente. Alterner les nuits permet à la peau de se renouveler sans jamais saturer la barrière protectrice.',
                        'warning_note' => 'Directive Clinique : N\'appliquez pas le Sérum Moonlight et l\'AHA 5% le même soir. L\'alternance protège le film hydrolipidique.',
                        'schedule_items' => [
                            [
                                'days' => 'Lun, Mer, Ven',
                                'treatment_name' => 'Protocole Renouvellement',
                                'product_name' => 'Sérum Moonlight (Bakuchiol)',
                                'action_type' => 'Renouvellement',
                                'instructions' => 'Appliquez 3 à 4 gouttes sur peau propre. Le bakuchiol stimule le collagène et unifie le grain sans irriter.',
                            ],
                            [
                                'days' => 'Mar & Jeu',
                                'treatment_name' => 'Nuits Exfoliation Douce',
                                'product_name' => 'Exfoliant 5% AHA (Acide Lactique)',
                                'action_type' => 'Exfoliation',
                                'instructions' => 'Passez délicatement sur le visage pour dissoudre les cellules ternes et affiner les pores pendant la nuit.',
                            ],
                            [
                                'days' => 'Sam & Dim',
                                'treatment_name' => 'Récupération & Barrière',
                                'product_name' => 'HydraButter & Crème Nour',
                                'action_type' => 'Récupération',
                                'instructions' => 'Mettez les acides en pause. Appliquez généreusement HydraButter pour nourrir et réparer les lipides en profondeur.',
                            ],
                        ],
                        'btn_text' => 'VOIR LES PROTOCOLES DU SOIR',
                        'btn_link' => '#shop',
                    ],
                    'ar' => [
                        'bg_color' => '#2e2224',
                        'text_color' => '#fbf8f1',
                        'eyebrow' => 'الجدول الصيدلاني للتجديد الليلي',
                        'title' => "دورة التجديد الليلي:\nدعي بشرتك تستفيد حقاً مما تضعينه عليها.",
                        'subtitle' => 'الفاعلية الحقيقية للمركبات النشطة تعتمد على التوقيت الذكي وليس كثرة الطبقات. التناوب بين الباكوتشيول وحمض اللاكتيك يمنحك تجديداً مبهراً دون إجهاد حاجز البشرة.',
                        'warning_note' => 'توجيه صيدلاني صارم: لا تستخدمي سيروم Moonlight ومقشر 5% AHA في نفس الليلة مطلقاً. التناوب يحافظ على توازن الدهون الطبيعية للبشرة.',
                        'schedule_items' => [
                            [
                                'days' => 'الإثنين، الأربعاء، الجمعة',
                                'treatment_name' => 'بروتوكول التجديد والامتلاء',
                                'product_name' => 'Moonlight Serum (الباكوتشيول)',
                                'action_type' => 'تجديد خلوي',
                                'instructions' => 'وزعي 3-4 قطرات على بشرة نظيفة. يعمل الباكوتشيول على تحفيز الكولاجين وتحسين المرونة دون أي تقشير عنيف.',
                            ],
                            [
                                'days' => 'الثلاثاء والخميس',
                                'treatment_name' => 'ليالي التقشير اللطيف',
                                'product_name' => '5% AHA Exfoliant (حمض اللاكتيك)',
                                'action_type' => 'تقشير ناعم',
                                'instructions' => 'امسحي برفق لتفكيك الخلايا الميتة المتراكمة، تنقية المسام، وتوحيد الملمس أثناء نومك.',
                            ],
                            [
                                'days' => 'السبت والأحد',
                                'treatment_name' => 'استشفاء وترميم حاجز البشرة',
                                'product_name' => 'HydraButter وكريم Nour',
                                'action_type' => 'ترميم مكثف',
                                'instructions' => 'دعي البشرة ترتاح من الأحماض. ضعي زبدة HydraButter وكريم Nour لإعادة بناء دهون البشرة وحبس الترطيب.',
                            ],
                        ],
                        'btn_text' => 'استكشفي بروتوكول المساء',
                        'btn_link' => '#shop',
                    ],
                ],
            ],
            [
                'name' => 'درع المناخ (من شمس النيل إلى شتاء كندا)',
                'type' => 'nc_climate_defense',
                'sort_order' => 8,
                'status' => 1,
                'channel_id' => $channelId,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'en' => [
                        'bg_color' => '#f4ede2',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'EXTREME CLIMATE BARRIER DEFENSE',
                        'title' => "From the Nile Sun\nto the Canadian Winter.",
                        'story_paragraph_1' => "Ancient Egypt's climate is brutally drying. Castor, moringa, sesame, and almond oils weren't luxuries — they were survival tools against scorching desert sun, dust, and windburn used across all walks of life. If an ingredient didn't work, it didn't last thousands of years.",
                        'story_paragraph_2' => 'We took those proven natural lipids and brought them to Vancouver, British Columbia. Here, facing freezing Canadian winds and parching indoor radiators, we formulated with shea butter and hydrolyzed oat proteins to lock water inside the skin barrier. That is the difference between skin that feels soft for an hour and skin that is glowing at 3 pm.',
                        'stats' => [
                            [
                                'figure' => '3:00 PM',
                                'label' => 'All-Day Moisture Lock',
                                'desc' => 'Oat proteins and shea hold water in rather than adding temporary surface grease.',
                            ],
                            [
                                'figure' => '0%',
                                'label' => 'Harsh Additives',
                                'desc' => 'Zero parabens, sulfates, silicones, or added artificial dyes across the line.',
                            ],
                            [
                                'figure' => '100%',
                                'label' => 'Health Canada Notified',
                                'desc' => 'Formally registered under Canada Cosmetic Regulations prior to release.',
                            ],
                            [
                                'figure' => 'PhD',
                                'label' => 'Pharmaceutical Formulated',
                                'desc' => 'Dosed by Dr. Albadry (PhD in Natural Pharmaceutical Sciences).',
                            ],
                        ],
                        'btn_text' => 'READ OUR FORMULATION STORY',
                        'btn_link' => '#story',
                    ],
                    'fr' => [
                        'bg_color' => '#f4ede2',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'DÉFENSE CLIMATIQUE EXTRÊME',
                        'title' => "Du Soleil du Nil\nÀ l'Hiver Canadien.",
                        'story_paragraph_1' => "Le climat de l'Égypte antique était d'une sécheresse redoutable. Les huiles de ricin, de sésame et de moringa n'étaient pas des caprices — c'étaient des outils de survie indispensables contre le vent et le soleil brûlant. Si un ingrédient ne fonctionnait pas, il ne traversait pas les siècles.",
                        'story_paragraph_2' => "Nous avons adapté cette sagesse ancestrale à Vancouver, en Colombie-Britannique. Face aux vents glaciaux et au chauffage déshydratant, nous avons enrichi nos formules en beurre de karité et protéines d'avoine. C'est la différence entre une peau confortable une heure et une peau hydratée jusqu'à 15h.",
                        'stats' => [
                            [
                                'figure' => '15h00',
                                'label' => 'Hydratation Durable',
                                'desc' => 'L\'avoine et le karité retiennent l\'eau au cœur des cellules au lieu de graisser.',
                            ],
                            [
                                'figure' => '0%',
                                'label' => 'Substances Agressives',
                                'desc' => 'Sans parabènes, sans sulfates, sans silicones et sans colorants artificiels.',
                            ],
                            [
                                'figure' => '100%',
                                'label' => 'Notifié Santé Canada',
                                'desc' => 'Dûment déclaré auprès du système réglementaire des cosmétiques au Canada.',
                            ],
                            [
                                'figure' => 'PhD',
                                'label' => 'Formulé par un Docteur',
                                'desc' => 'Dosé scientifiquement par le Dr. Albadry (PhD en Sciences Pharmaceutiques).',
                            ],
                        ],
                        'btn_text' => 'NOTRE HISTOIRE DE FORMULATION',
                        'btn_link' => '#story',
                    ],
                    'ar' => [
                        'bg_color' => '#f4ede2',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'درع حماية حاجز البشرة من تقلبات المناخ',
                        'title' => "من شمس النيل الحارقة\nإلى شتاء كندا الجاف.",
                        'story_paragraph_1' => 'مناخ مصر القديمة كان قاسياً وجافاً للغاية، لذا لم تكن الزيوت الطبيعية والمستخلصات رفاهية تجميلية — بل أدوات بقاء يومية لحماية الجلد من الحروق والرياح العاتية. إن لم تكن فعالة ومثبتة بالتجربة، لما استمرت لآلاف السنين.',
                        'story_paragraph_2' => 'أخذنا هذه الأسرار وأعدنا صياغتها في فانكوفر، كندا. لتواجه الصقيع القارس والتدفئة المنزلية الجافة، دمجنا زبدة الشيا وبروتين الشوفان لحبس الماء داخل خلايا البشرة — الفرق الحقيقي بين بشرة ترتوي لساعة واحدة وبشرة تحتفظ بنضارتها حتى الثالثة عصراً.',
                        'stats' => [
                            [
                                'figure' => '3:00 PM',
                                'label' => 'حبس الرطوبة طوال اليوم',
                                'desc' => 'بروتين الشوفان وزبدة الشيا يحبسان الماء بدلاً من مجرد وضع طبقة دهنية مؤقتة.',
                            ],
                            [
                                'figure' => '0%',
                                'label' => 'مواد كيميائية ضارة',
                                'desc' => 'خالٍ تماماً من البارابين، السلفات، والصبغات الصناعية في جميع المنتجات.',
                            ],
                            [
                                'figure' => '100%',
                                'label' => 'مسجل لدى Health Canada',
                                'desc' => 'مسجل رسمياً في نظام الإشعارات لمستحضرات التجميل الكندية قبل طرحه.',
                            ],
                            [
                                'figure' => 'PhD',
                                'label' => 'صياغة صيدلانية أكاديمية',
                                'desc' => 'طُوّرت التركيبات بواسطة د. البدري (دكتوراة العلوم الصيدلانية الطبيعية).',
                            ],
                        ],
                        'btn_text' => 'اقرأي قصة مختبرنا',
                        'btn_link' => '#story',
                    ],
                ],
            ],
            [
                'name' => 'خرافات الجمال وحقائق الصيدلة (Beauty Myths)',
                'type' => 'nc_beauty_myths',
                'sort_order' => 9,
                'status' => 1,
                'channel_id' => $channelId,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'en' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'BEAUTY MYTHS VS. PHARMACEUTICAL TRUTH',
                        'title' => "Skincare Myths vs. Truth:\nWhat Research Actually Proves.",
                        'subtitle' => 'Our laboratory is built on peer-reviewed research, not marketing slogans. Here is the honest truth about what you put on your skin.',
                        'myths' => [
                            [
                                'myth_text' => '"Natural" always means gentle, harmless, and safe.',
                                'truth_text' => 'Poison ivy is natural. So is snake venom. "Natural" describes where an ingredient came from, not how it behaves on skin — which is why we measure exact percentages and clinical safety data.',
                                'tag' => 'The "Natural" Fallacy',
                            ],
                            [
                                'myth_text' => 'If a formula doesn\'t sting or tingle, it isn\'t working.',
                                'truth_text' => 'A burning tingle is your skin barrier signalling distress and micro-damage. Modern actives like niacinamide and bakuchiol deliver superior results without triggering inflammatory burning.',
                                'tag' => 'Skin Barrier Health',
                            ],
                            [
                                'myth_text' => 'Pores open and close with warm and cold water.',
                                'truth_text' => 'Pores have no muscles — they cannot physically open or close. What changes their appearance is clearing oxidation and sebum inside them with gentle exfoliating acids like lactic acid.',
                                'tag' => 'Pore Physiology',
                            ],
                            [
                                'myth_text' => 'The higher the price tag, the better the formula.',
                                'truth_text' => 'Price tags often fund extravagant glass packaging and influencer campaigns. The true worth of a formula lies solely in the grade, dosage, and stability of its active ingredients.',
                                'tag' => 'Pricing Transparency',
                            ],
                            [
                                'myth_text' => 'You need an exhausting 10-step routine to see results.',
                                'truth_text' => 'A handful of well-chosen actives used consistently will easily outperform ten mediocre steps abandoned after two weeks. Consistency beats complexity every time.',
                                'tag' => 'Routine Simplicity',
                            ],
                        ],
                        'footer_note' => '"Real skincare is pharmaceutical precision and consistency, not guesswork and overwhelming steps." — Dr. Albadry',
                    ],
                    'fr' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'MYTHES DE LA BEAUTÉ VS. VÉRITÉ PHARMACEUTIQUE',
                        'title' => "Mythes vs. Vérités Scientifiques :\nCe Que la Recherche Démontre.",
                        'subtitle' => 'Notre laboratoire s\'appuie sur la science et non sur le marketing. Voici la vérité sur vos soins quotidiens.',
                        'myths' => [
                            [
                                'myth_text' => 'Le terme « naturel » signifie toujours doux et sans danger.',
                                'truth_text' => 'Le lierre vénéneux est naturel, le venin de serpent aussi. « Naturel » indique l\'origine, pas l\'innocuité — c\'est pourquoi nous dosons des pourcentages précis et testés.',
                                'tag' => 'Le Mythe du Naturel',
                            ],
                            [
                                'myth_text' => 'Si le produit ne picote pas, c\'est qu\'il n\'agit pas.',
                                'truth_text' => 'Le picotement est souvent le signe d\'une barrière cutanée agressée. De vrais actifs comme la niacinamide et le bakuchiol agissent efficacement sans brûler.',
                                'tag' => 'Santé de la Barrière',
                            ],
                            [
                                'myth_text' => 'Les pores s\'ouvrent et se ferment avec l\'eau chaude et froide.',
                                'truth_text' => 'Les pores n\'ont pas de muscles. Ce qui modifie leur aspect, c\'est le nettoyage du sébum et des débris par des acides doux comme l\'acide lactique.',
                                'tag' => 'Physiologie Cutanée',
                            ],
                            [
                                'myth_text' => 'Plus un soin est cher, plus sa formule est performante.',
                                'truth_text' => 'Le prix reflète souvent les dépenses marketing et les emballages luxueux plutôt que la concentration réelle en principes actifs.',
                                'tag' => 'Transparence des Prix',
                            ],
                            [
                                'myth_text' => 'Il faut une routine complexe en 10 étapes pour voir des résultats.',
                                'truth_text' => 'Quelques actifs ciblés utilisés régulièrement surpasseront toujours dix étapes superflues vite abandonnées. La régularité prime sur la complexité.',
                                'tag' => 'Simplicité du Rituel',
                            ],
                        ],
                        'footer_note' => '« La véritable efficacité repose sur la précision pharmaceutique et la constance, pas sur des étapes superflues. » — Dr. Albadry',
                    ],
                    'ar' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'حقائق علمية ومفاهيم خاطئة',
                        'title' => "دحض خرافات الجمال:\nما يثبته العلم الصيدلاني بالأدلة.",
                        'subtitle' => 'بصفتنا صيادلة وباحثين، نؤمن بأن الشفافية هي أسمى درجات العناية. إليك الحقيقة وراء أشهر أساطير العناية بالبشرة.',
                        'myths' => [
                            [
                                'myth_text' => 'كلمة "طبيعي" تعني دائماً أن المنتج لطيف وآمن تماماً.',
                                'truth_text' => 'اللبلاب السام طبيعي، وسم الأفاعي طبيعي! كلمة "طبيعي" تخبرك من أين أتى المكون، وليس ماذا يفعل لبشرتك — ولهذا نذكر النسب المئوية الدقيقة والوظائف البيولوجية.',
                                'tag' => 'مغالطة "طبيعي"',
                            ],
                            [
                                'myth_text' => 'إذا لم تشعري بوخز أو حرقان، فالمنتج لا يعمل.',
                                'truth_text' => 'الشعور بالحرقة هو استغاثة من حاجز بشرتك بأنه يتعرض للالتهاب والتمزق الدقيق. المواد الفعالة الحقيقية مثل النياسيناميد والباكوتشيول تعمل بكفاءة تامة دون أي إحساس بالحرق.',
                                'tag' => 'صحة حاجز البشرة',
                            ],
                            [
                                'myth_text' => 'المسام تفتح بالماء الساخن وتغلق بالماء البارد.',
                                'truth_text' => 'المسام لا تملك عضلات لتفتح وتغلق بإرادتها. ما يغير مظهرها وحجمها هو تنظيف الزيوت والخلايا الميتة المتراكمة بداخلها بواسطة أحماض التقشير اللطيفة كحمض اللاكتيك.',
                                'tag' => 'تشريح المسام',
                            ],
                            [
                                'myth_text' => 'السعر الباهظ يعني حتماً تركيبة أفضل وأقوى فاعلية.',
                                'truth_text' => 'السعر يعكس في أغلب الأحيان تكلفة التغليف البراق، وحملات المؤثرين الإعلانية، وليس نسبة المادة الفعالة داخل الزجاجة. القيمة الحقيقية في جودة التركيز.',
                                'tag' => 'شفافية التسعير',
                            ],
                            [
                                'myth_text' => 'تحتاجين لروتين معقد من 10 خطوات للحصول على بشرة مثالية.',
                                'truth_text' => 'بضع مواد فعالة مختارة بدقة ومستخدمة بانتظام تتفوق بمراحل على عشر خطوات يمل منها معظم الناس بعد أسبوعين. الاستمرارية تتفوق على التعقيد.',
                                'tag' => 'بساطة الروتين',
                            ],
                        ],
                        'footer_note' => '«العناية الحقيقية بالبشرة هي دقة صيدلانية واستمرارية يومية، وليست تخميناً وخطوات معقدة مرهقة.» — د. البدري',
                    ],
                ],
            ],
            [
                'name' => 'المختبر والعائلة الصيدلانية (Founders Lab)',
                'type' => 'nc_founders_lab',
                'sort_order' => 10,
                'status' => 1,
                'channel_id' => $channelId,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'en' => [
                        'bg_color' => '#fbf8f1',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'THE PEOPLE BEHIND THE BEAKER',
                        'title' => "Our Cleo's Lab:\nFormulated by Real Scientists, Not Marketers.",
                        'quote' => 'Cleo\'s Lab isn\'t a factory. It is a family-run lab in Vancouver where every formula gets mixed and tested by pharmaceutical researchers. We are trying to be the one you trust enough to hand to your daughter, your mother, your own tired-eyed self at 6 am.',
                        'badge_text' => 'Hand-Filled Small Batches in Vancouver, BC 🍁',
                        'founders' => [
                            [
                                'name' => 'Dr. Rania',
                                'role' => 'Brand Direction, Story & Formulation Ethics',
                                'bio' => 'Oversees our brand integrity, cultural heritage, and product safety — ensuring nothing ever leaves our laboratory that we wouldn\'t proudly give to our own family.',
                            ],
                            [
                                'name' => 'Dr. Albadry (PhD)',
                                'role' => 'Lead Pharmaceutical Scientist & Formulator',
                                'bio' => 'Holds a PhD in Natural Pharmaceutical Sciences from the University of Mississippi and conducts research at a Vancouver institute. Doses every active with clinical rigor.',
                            ],
                        ],
                        'btn_text' => 'OUR FORMULATION STANDARD',
                        'btn_link' => '#story',
                    ],
                    'fr' => [
                        'bg_color' => '#fbf8f1',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'LES FORMULATEURS DU LABORATOIRE',
                        'title' => "Notre Laboratoire Cleo's Lab :\nFormulé par des Scientifiques, Pas des Marketeurs.",
                        'quote' => 'Cleo\'s Lab n\'est pas une usine. C\'est un laboratoire familial à Vancouver où chaque formule est conçue et testée avec rigueur. Nous voulons être la marque que vous offrez en toute confiance à votre fille, à votre mère ou à vous-même à 6 heures du matin.',
                        'badge_text' => 'Préparé à la main en petits lots à Vancouver, BC 🍁',
                        'founders' => [
                            [
                                'name' => 'Dr. Rania',
                                'role' => 'Direction de Marque, Récit & Éthique',
                                'bio' => 'Garante de l\'intégrité de la marque et de l\'héritage culturel. Elle veille à ce qu\'aucun flacon ne soit expédié sans correspondre aux normes les plus strictes.',
                            ],
                            [
                                'name' => 'Dr. Albadry (PhD)',
                                'role' => 'Docteur en Sciences Pharmaceutiques Naturelles',
                                'bio' => 'Titulaire d\'un doctorat de l\'Université du Mississippi et chercheur dans un institut à Vancouver. Il calibre chaque actif avec une rigueur clinique sans compromis.',
                            ],
                        ],
                        'btn_text' => 'NOS NORMES SCIENTIFIQUES',
                        'btn_link' => '#story',
                    ],
                    'ar' => [
                        'bg_color' => '#fbf8f1',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'خلف الكواليس الصيدلانية',
                        'title' => "مختبر Cleo's Lab:\nبأيدي باحثين وصيادلة، لا خبراء تسويق.",
                        'quote' => '«Cleo\'s Lab ليس مصنعاً ضخماً، بل مختبر تديره عائلتنا في فانكوفر، حيث يتم تركيب واختبار كل تركيبة بعناية صيدلانية قبل أن تطبع عليها أي علامة. لسنا هنا لنكون أضخم علامة في كندا، بل العلامة التي تأتمنها لتهديها لابنتك، لأمك، ولنفسك المتعبة في السادسة صباحاً.»',
                        'badge_text' => 'صُنعت يدوياً بدفعات صغيرة في فانكوفر، كندا 🍁',
                        'founders' => [
                            [
                                'name' => 'د. رانيا',
                                'role' => 'إدارة العلامة، الرؤية التراثية ومعايير الأمان',
                                'bio' => 'تشرف على قصة العلامة وسلامة المستحضرات، وتضمن ألا يخرج أي مستحضر من مختبرنا ما لم نكن مستعدين لتقديمه لأفراد عائلتنا بكل طمأنينة.',
                            ],
                            [
                                'name' => 'د. البدري (دكتوراة)',
                                'role' => 'كبير الباحثين الصيدلانيين ومطور التركيبات',
                                'bio' => 'يحمل درجة الدكتوراة في العلوم الصيدلانية الطبيعية من جامعة ميسيسيبي ويعمل باحثاً في أحد معاهد فانكوفر الكندية، يدير المختبر ويعاير كل نسبة بدقة متناهية.',
                            ],
                        ],
                        'btn_text' => 'تعرفي على معاييرنا الصيدلانية',
                        'btn_link' => '#story',
                    ],
                ],
            ],
            [
                'name' => 'موسوعة المكونات الفعالة والشفافية (Actives Index)',
                'type' => 'nc_actives_index',
                'sort_order' => 11,
                'status' => 1,
                'channel_id' => $channelId,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'en' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'ACTIVE INGREDIENTS TRANSPARENCY INDEX',
                        'title' => "Active Transparency Index:\nConcentrations, Functions, No Guesswork.",
                        'subtitle' => 'Every active is chosen and dosed with pharmaceutical intent. Health Canada Notified, ethically sourced, and free from sulfates, parabens, and artificial dyes.',
                        'actives' => [
                            [
                                'name' => 'Bakuchiol',
                                'percentage' => 'Clinical Phyto-Retinol Dose',
                                'ancient_counterpart' => 'Sacred Babchi Botanical Oil',
                                'clinical_function' => 'Stimulates cellular turnover and firming without retinol\'s dryness, flaking, or UV vulnerability.',
                                'clean_promise' => 'Non-irritating & Pregnancy-friendly',
                            ],
                            [
                                'name' => 'Lactic Acid (AHA)',
                                'percentage' => '5% Measured Clinical Strength',
                                'ancient_counterpart' => 'Ancient Egyptian Fermented Milk',
                                'clinical_function' => 'Loosens dead superficial cells, boosts ceramides, and enhances moisture retention.',
                                'clean_promise' => 'Gentle Chemical Exfoliant',
                            ],
                            [
                                'name' => 'Niacinamide (Vitamin B3)',
                                'percentage' => 'High-Purity Active Grade',
                                'ancient_counterpart' => 'Licorice & Turmeric Extracts',
                                'clinical_function' => 'Strengthens epidermal barrier, restores lipid balance, and diminishes stubborn dark circles.',
                                'clean_promise' => 'Sulfate & Paraben Free',
                            ],
                            [
                                'name' => 'Silk Amino Acids',
                                'percentage' => 'Concentrated Natural Peptides',
                                'ancient_counterpart' => 'Raw Silk Cocoon Extracts',
                                'clinical_function' => 'Forms a velvety, breathable moisture-binding matrix that replaces synthetic silicones.',
                                'clean_promise' => 'Zero Pore-Clogging Silicones',
                            ],
                            [
                                'name' => 'Multi-Molecular Hyaluronic Acid',
                                'percentage' => 'Triple Weight Complex',
                                'ancient_counterpart' => 'Desert Aloe & Botanical Mallow',
                                'clinical_function' => 'Draws 1000x its weight in atmospheric water deep into epidermal layers.',
                                'clean_promise' => 'Instantly Plumping & Non-sticky',
                            ],
                            [
                                'name' => 'Botanical Caffeine & EGCG',
                                'percentage' => 'Standardized Green Tea Extract',
                                'ancient_counterpart' => 'Medicinal Eye Unguents',
                                'clinical_function' => 'Constricts micro-capillaries to visibly reduce under-eye puffiness in 5 minutes.',
                                'clean_promise' => 'Antioxidant & Free-Radical Shield',
                            ],
                        ],
                    ],
                    'fr' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'INDEX DE TRANSPARENCE DES ACTIFS',
                        'title' => "Index de Transparence des Actifs :\nDosages Précis, Sans Artifice.",
                        'subtitle' => 'Chaque actif est sélectionné selon les critères de la science pharmaceutique. Notifié auprès de Santé Canada, sans sulfates, sans parabènes ni colorants.',
                        'actives' => [
                            [
                                'name' => 'Bakuchiol',
                                'percentage' => 'Dosage Phyto-Rétinol Clinique',
                                'ancient_counterpart' => 'Huile sacrée de Babchi',
                                'clinical_function' => 'Stimule le renouvellement cellulaire et la fermeté sans les rougeurs ou la sécheresse du rétinol.',
                                'clean_promise' => 'Non irritant & adapté aux peaux sensibles',
                            ],
                            [
                                'name' => 'Acide Lactique (AHA)',
                                'percentage' => 'Concentration Clinique 5%',
                                'ancient_counterpart' => 'Lait aigre de l\'Égypte ancienne',
                                'clinical_function' => 'Élimine les cellules mortes en surface, booste les céramides et optimise l\'hydratation.',
                                'clean_promise' => 'Exfoliation chimique très douce',
                            ],
                            [
                                'name' => 'Niacinamide (Vitamine B3)',
                                'percentage' => 'Actif Pur Haute Qualité',
                                'ancient_counterpart' => 'Extraits de réglisse et curcuma',
                                'clinical_function' => 'Renforce la barrière lipidique, réduit les taches pigmentaires et apaise les rougeurs.',
                                'clean_promise' => 'Sans sulfates ni parabènes',
                            ],
                            [
                                'name' => 'Acides Aminés de Soie',
                                'percentage' => 'Peptides Naturels Concentrés',
                                'ancient_counterpart' => 'Extraits de cocon de soie',
                                'clinical_function' => 'Forme un film soyeux et respirant qui retient l\'hydratation en remplaçant les silicones.',
                                'clean_promise' => 'Zéro silicone occlusif',
                            ],
                            [
                                'name' => 'Acide Hyaluronique Multi-Poids',
                                'percentage' => 'Complexe Triple Poids',
                                'ancient_counterpart' => 'Aloès du désert et mauve',
                                'clinical_function' => 'Capte 1000 fois son poids en eau pour repulper l\'épiderme en profondeur.',
                                'clean_promise' => 'Repulpant immédiat, non collant',
                            ],
                            [
                                'name' => 'Caféine Botanique & EGCG',
                                'percentage' => 'Extrait Standardisé de Thé Vert',
                                'ancient_counterpart' => 'Baumes oculaires médicinaux',
                                'clinical_function' => 'Décongestionne les poches et illumine les cernes sous les yeux en 5 minutes.',
                                'clean_promise' => 'Bouclier puissant contre les radicaux libres',
                            ],
                        ],
                    ],
                    'ar' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'الشفافية الصيدلانية المطلقة',
                        'title' => "دليل المواد الفعالة:\nالنسب والوظائف، بدون غموض.",
                        'subtitle' => 'نختار كل مادة بناءً على ما تؤديه فعلياً لبشرتك وليس على تكلفة استبعادها. خالية تماماً من البارابين، السلفات، والصبغات، ومسجلة في نظام Health Canada.',
                        'actives' => [
                            [
                                'name' => 'الباكوتشيول (Bakuchiol)',
                                'percentage' => 'تركيز سريري صيدلاني',
                                'ancient_counterpart' => 'زيت البابشي النباتي المقدس',
                                'clinical_function' => 'يحفز تجدد الخلايا وإنتاج الكولاجين دون تقشير أو احمرار أو حساسية من أشعة الشمس كالريتينول.',
                                'clean_promise' => 'غير مهيج وآمن مع البشرة الحساسة',
                            ],
                            [
                                'name' => 'حمض اللاكتيك (5% AHA)',
                                'percentage' => 'تركيز دقيق 5%',
                                'ancient_counterpart' => 'حليب الفراعنة المتخمر الطبيعي',
                                'clinical_function' => 'يقشر السطح بلطف، يعزز إنتاج السيراميدات الطبيعية، ويحتفظ بالرطوبة داخل خلايا الجلد.',
                                'clean_promise' => 'تقشير ناعم يحمي حاجز البشرة',
                            ],
                            [
                                'name' => 'النياسيناميد (فيتامين B3)',
                                'percentage' => 'نقاء صيدلاني عالي التركيز',
                                'ancient_counterpart' => 'خلاصة عرق السوس والكركم',
                                'clinical_function' => 'يعزز الحاجز الواقي، يقلل من ظهور المسام، ويفتح الهالات الداكنة والتصبغات باقتدار.',
                                'clean_promise' => 'خالٍ تماماً من السلفات والبارابين',
                            ],
                            [
                                'name' => 'أحماض الحرير الأمينية',
                                'percentage' => 'ببتيدات طبيعية مركزة',
                                'ancient_counterpart' => 'شاش وخيوط الحرير الخام',
                                'clinical_function' => 'تمنح البشرة ملمساً مخملياً ناعماً يسمح للمسام بالتنفس وتغني تماماً عن السيليكون الصناعي.',
                                'clean_promise' => 'بديل نظيف خالٍ من السيليكونات المسدة للمسام',
                            ],
                            [
                                'name' => 'حمض الهيالورونيك متعدد الجزيئات',
                                'percentage' => 'مجمع ثلاثي الأوزان الجزيئية',
                                'ancient_counterpart' => 'صبار ونباتات الصحراء المائية',
                                'clinical_function' => 'يمتص ما يصل إلى 1000 ضعف وزنه من الماء ويوزعه في الطبقات السطحية والعميقة للجلد.',
                                'clean_promise' => 'امتلاء فوري بدون أي ملمس لزج',
                            ],
                            [
                                'name' => 'الكافيين النباتي و EGCG',
                                'percentage' => 'مستخلص الشاي الأخضر المعياري',
                                'ancient_counterpart' => 'مستحضرات دهان محيط العين الطبية',
                                'clinical_function' => 'يحسن الدورة الدموية الدقيقة حول العينين ويزيل الانتفاخ الصباحي في غضون 5 دقائق.',
                                'clean_promise' => 'درع مضاد للأكسدة والإجهاد البيئي',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'الجدول الزمني للنتائج الواقعية (Results Timeline)',
                'type' => 'nc_results_timeline',
                'sort_order' => 12,
                'status' => 1,
                'channel_id' => $channelId,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'en' => [
                        'bg_color' => '#f7f4ea',
                        'text_color' => '#2e2224',
                        'eyebrow' => '28-DAY CELLULAR TURNOVER TIMELINE',
                        'title' => "What to Expect:\nReal Skin Results, Day by Day.",
                        'subtitle' => 'Skin cells take approximately 28 days to complete a natural renewal cycle. Here is the clinical timeline of how your skin transforms.',
                        'milestones' => [
                            [
                                'day' => 'Day 01',
                                'phase' => 'Instant Hydration & Quench',
                                'what_happens' => 'Hyaluronic acid and oat proteins bind moisture immediately. Skin feels comfortable, calm, and visibly de-puffed within minutes of morning application.',
                                'recommended_ritual' => 'Morning Glow Serum + Nour Eye Cream',
                            ],
                            [
                                'day' => 'Day 14',
                                'phase' => 'Gentle Resurfacing & Texture',
                                'what_happens' => 'Lactic acid has cleared dead surface build-up. Roughness diminishes, makeup glides on smoothly, and early morning dullness is replaced with steady radiance.',
                                'recommended_ritual' => '5% AHA (2 nights) + Moonlight Serum',
                            ],
                            [
                                'day' => 'Day 28',
                                'phase' => 'Cellular Turnover & Barrier Strength',
                                'what_happens' => 'Full cellular cycle completed. Bakuchiol and niacinamide have stimulated deeper renewal. Uneven tone fades, redness calms, and the lipid barrier resists climate shifts.',
                                'recommended_ritual' => 'Complete 4-Step Cleo Ritual',
                            ],
                        ],
                        'doctor_note' => '"Real, lasting beauty is biological consistency — giving skin exactly what it needs to rebuild its own defensive barrier." — Dr. Albadry',
                    ],
                    'fr' => [
                        'bg_color' => '#f7f4ea',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'CHRONOLOGIE DU RENOUVELLEMENT CUTANÉ',
                        'title' => "À Quoi Vous Attendre :\nDes Résultats Réalistes, Jour Après Jour.",
                        'subtitle' => 'Le cycle cellulaire de la peau dure environ 28 jours. Voici la chronologie de transformation de votre barrière cutanée.',
                        'milestones' => [
                            [
                                'day' => 'Jour 01',
                                'phase' => 'Hydratation Immédiate & Éclat',
                                'what_happens' => 'L\'acide hyaluronique et l\'avoine captent l\'eau dès l\'application. La peau est apaisée, douce et le regard visiblement défatigué en 5 minutes.',
                                'recommended_ritual' => 'Sérum Morning Glow + Crème Regard Nour',
                            ],
                            [
                                'day' => 'Jour 14',
                                'phase' => 'Lissage du Grain & Clarté',
                                'what_happens' => 'L\'acide lactique a dissous les cellules mortes superficielles. Le teint est plus net, le grain affiné et les pores visiblement resserrés.',
                                'recommended_ritual' => 'AHA 5% (2 soirs) + Sérum Moonlight',
                            ],
                            [
                                'day' => 'Jour 28',
                                'phase' => 'Renouvellement Cellulaire & Barrière',
                                'what_happens' => 'Cycle complet achevé. Le bakuchiol et la niacinamide ont consolidé le collagène et uniformisé le teint. La peau résiste aux variations de température.',
                                'recommended_ritual' => 'Rituel Cleo complet en 4 étapes',
                            ],
                        ],
                        'doctor_note' => '« La véritable beauté résulte de la régularité biologique — nourrir la peau pour qu\'elle répare elle-même sa barrière. » — Dr. Albadry',
                    ],
                    'ar' => [
                        'bg_color' => '#f7f4ea',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'الجدول الزمني للنتائج الواقعية',
                        'title' => "ماذا تتوقعين من بشرتك؟\nنتائج حقيقية، خطوة بخطوة.",
                        'subtitle' => 'تستغرق خلايا البشرة قرابة 28 يوماً لإكمال دورة تجددها الطبيعية. لا نعدك بتغيير سحري خيالي بين ليلة وضحاها، بل بصحة متماسكة وإشراقة تبنينها يوماً بعد يوم.',
                        'milestones' => [
                            [
                                'day' => 'اليوم 01',
                                'phase' => 'ارتواء فوري وانتعاش الصباح',
                                'what_happens' => 'يحبس حمض الهيالورونيك وبروتين الشوفان الماء في الحال. تشعرين بالراحة والهدوء ويزول الانتفاخ الصباحي حول العينين في غضون 5 دقائق.',
                                'recommended_ritual' => 'Morning Glow Serum + Nour Eye Cream',
                            ],
                            [
                                'day' => 'اليوم 14',
                                'phase' => 'تنعيم الملمس وتصفية المسام',
                                'what_happens' => 'قام حمض اللاكتيك بتفكيك طبقات الجلد الميتة السطحية. يصبح ملمس البشرة حريراً ناعماً، ويختفي الشحوب ليعوضه إشراق طبيعي متزن.',
                                'recommended_ritual' => 'مقشر 5% AHA (ليلتين) + سيروم Moonlight',
                            ],
                            [
                                'day' => 'اليوم 28',
                                'phase' => 'اكتمال الدورة وتقوية الحاجز الواقي',
                                'what_happens' => 'اكتملت دورة التجدد الخلوي. عمل الباكوتشيول والنياسيناميد على شد الأنسجة وتوحيد التصبغات، وأصبح حاجز البشرة قادراً على صد تقلبات المناخ.',
                                'recommended_ritual' => 'طقس Cleo المتكامل ذو الـ 4 خطوات',
                            ],
                        ],
                        'doctor_note' => '«النتائج المستقرة تأتي من احترام الدورة الحيوية للبشرة، وليس بإجهادها بتركيزات غير محسوبة.» — د. البدري',
                    ],
                ],
            ],
            [
                'name' => 'بروتوكول اختبار الحساسية وإرشادات الأمان (Patch Test)',
                'type' => 'nc_patch_test',
                'sort_order' => 13,
                'status' => 1,
                'channel_id' => $channelId,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'en' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'SAFETY PROTOCOL & CONSCIOUS USE',
                        'title' => "Patch Test Protocol &\nSafety Guidelines.",
                        'subtitle' => 'Because every skin barrier has unique sensitivities, our pharmaceutical team always recommends patch testing new active formulas 24 to 48 hours prior to full facial use.',
                        'steps' => [
                            [
                                'step_number' => '01',
                                'step_title' => 'Apply a Drop',
                                'step_desc' => 'Place a small drop of serum or cream behind the ear or on the clean, inner surface of your wrist.',
                            ],
                            [
                                'step_number' => '02',
                                'step_title' => 'Wait 24–48 Hours',
                                'step_desc' => 'Leave the area dry and undisturbed for 24 to 48 hours. Observe for any redness, itchiness, or unexpected burning.',
                            ],
                            [
                                'step_number' => '03',
                                'step_title' => 'Introduce Confidently',
                                'step_desc' => 'If skin remains calm and clear, introduce the formula into your treatment routine as directed on the label.',
                            ],
                        ],
                        'pregnancy_advice_title' => 'Pregnancy & Breastfeeding Guidance',
                        'pregnancy_advice_text' => 'We always advise checking with your personal healthcare provider before introducing any new active ingredients — including bakuchiol and AHA — during pregnancy or breastfeeding, as individual medical guidance always supersedes general cosmetic labels.',
                        'doctor_contact_text' => 'CONTACT OUR PHARMACEUTICAL TEAM',
                        'doctor_contact_link' => '#contact',
                    ],
                    'fr' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'PROTOCOLE DE SÉCURITÉ & UTILISATION CONSCIENTE',
                        'title' => "Protocole de Test Cutané &\nRecommandations de Sécurité.",
                        'subtitle' => 'Chaque épiderme étant unique, notre équipe pharmaceutique recommande systématiquement un test cutané préalable de 24 à 48 heures avant l\'application intégrale.',
                        'steps' => [
                            [
                                'step_number' => '01',
                                'step_title' => 'Déposer une Goutte',
                                'step_desc' => 'Appliquez une petite goutte de sérum ou de crème derrière l\'oreille ou à l\'intérieur du poignet propre.',
                            ],
                            [
                                'step_number' => '02',
                                'step_title' => 'Patienter 24 à 48 Heures',
                                'step_desc' => 'Laissez la zone propre sans frotter pendant 24 à 48 heures afin d\'observer l\'absence de rougeur ou de réaction.',
                            ],
                            [
                                'step_number' => '03',
                                'step_title' => 'Adopter en Sérénité',
                                'step_desc' => 'Si votre peau reste parfaitement apaisée, intégrez la formule à votre rituel quotidien en toute confiance.',
                            ],
                        ],
                        'pregnancy_advice_title' => 'Conseils Grossesse & Allaitement',
                        'pregnancy_advice_text' => 'Nous conseillons de consulter votre médecin ou sage-femme avant d\'introduire de nouveaux actifs (notamment le bakuchiol et les AHA) pendant la grossesse ou l\'allaitement, l\'avis médical personnalisé prévalant toujours.',
                        'doctor_contact_text' => 'CONTACTER NOTRE ÉQUIPE SCIENTIFIQUE',
                        'doctor_contact_link' => '#contact',
                    ],
                    'ar' => [
                        'bg_color' => '#ffffff',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'بروتوكول السلامة الصيدلانية',
                        'title' => "دليل اختبار الحساسية\nوإرشادات الاستخدام الآمن.",
                        'subtitle' => 'لأن كل بشرة فريدة ولها استجابتها الخاصة للمركبات النشطة، يوصي فريقنا الصيدلاني دائماً بإجراء اختبار الحساسية لمدة 24 إلى 48 ساعة قبل التطبيق الكامل على الوجه.',
                        'steps' => [
                            [
                                'step_number' => '01',
                                'step_title' => 'ضعي قطرة صغيرة',
                                'step_desc' => 'ضعي قطرة واحدة من السيروم أو الكريم خلف الأذن أو على المعصم الداخلي النظيف والجاف.',
                            ],
                            [
                                'step_number' => '02',
                                'step_title' => 'انتظري 24 إلى 48 ساعة',
                                'step_desc' => 'اتركي المنطقة دون غسلها أو تغطيتها وراقبي أي احمرار، حكة، أو تحسس غير معتاد.',
                            ],
                            [
                                'step_number' => '03',
                                'step_title' => 'ابدأي استخدامك باطمئنان',
                                'step_desc' => 'إذا ظلت البشرة هادئة وطبيعية، يمكنك إدخال المستحضر إلى روتينك اليومي وفق الإرشادات.',
                            ],
                        ],
                        'pregnancy_advice_title' => 'إرشادات خاصة بفترة الحمل والرضاعة الطبيعية',
                        'pregnancy_advice_text' => 'نوصي دائماً باستشارة طبيبكِ المختص قبل إدخال أي مادة فعالة جديدة (بما في ذلك الباكوتشيول وأحماض AHA) أثناء الحمل أو الرضاعة الطبيعية، لأن التوجيه الطبي الفردي أهم من أي ملصق عام.',
                        'doctor_contact_text' => 'تواصلي مع فريقنا الصيدلاني للاستشارة',
                        'doctor_contact_link' => '#contact',
                    ],
                ],
            ],
            [
                'name' => 'مصر القديمة، في الواقع (التراث والجالية)',
                'type' => 'nc_ancient_heritage',
                'sort_order' => 14,
                'status' => 1,
                'channel_id' => $channelId,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'en' => [
                        'bg_color' => '#f4ede2',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'ANCIENT EGYPT, ACTUALLY',
                        'title' => "Ancient Egypt, Actually:\nDocumented Truths Behind the Legends.",
                        'subtitle' => 'They did not invent vanity — they invented skincare as daily protection. Here are historical facts confirmed by modern science.',
                        'stories' => [
                            [
                                'title' => 'Oils Were Paid as Literal Currency',
                                'tag' => 'Historical Economy',
                                'story' => 'In ancient Egypt, fine unguents and fragrant botanical oils were so valuable and vital for bodily health that workers and builders were routinely paid portions of their wages in oils.',
                                'modern_takeaway' => 'We treat pure botanicals with the same reverence — selecting unadulterated oils for proven dermal function.',
                            ],
                            [
                                'title' => 'Kohl Was Formulated as Medicine',
                                'tag' => 'Ocular Health',
                                'story' => 'Worn by men, women, and children alike, kohl was not merely cosmetic. It was carefully formulated to deflect desert glare and protect eyes against bacterial infections.',
                                'modern_takeaway' => 'Our Nour Eye Cream honors this protective spirit with caffeine and niacinamide to defend delicate skin.',
                            ],
                            [
                                'title' => 'Honey Was a Clinical Wound Remedy',
                                'tag' => 'Antimicrobial Science',
                                'story' => 'Egyptians applied raw honey to accelerate skin healing and diminish scarring. Modern pharmacology has since confirmed honey’s potent natural antibacterial properties.',
                                'modern_takeaway' => 'Ancient remedies weren\'t folklore guesswork — they were thousands of years of trial and error waiting for lab proof.',
                            ],
                        ],
                        'community_title' => 'Our Egyptian-Canadian Community Roots 🍁',
                        'community_text' => 'There are over 105,000 Canadians of Egyptian ancestry today. Born from Montreal\'s historic community hubs and thriving across Greater Vancouver, Cleo\'s Lab handcrafts small-batch formulas in Vancouver, BC — carrying forward thousands of years of ancestral wisdom directly into Canadian homes.',
                    ],
                    'fr' => [
                        'bg_color' => '#f4ede2',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'L\'ÉGYPTE ANCIENNE, EN RÉALITÉ',
                        'title' => "L'Égypte Ancienne, en Réalité :\nDes Vérités Historiques Documentées.",
                        'subtitle' => 'Ils n\'ont pas inventé la vanité — ils ont créé le soin comme un bouclier quotidien. Voici des faits historiques vérifiés par la science contemporaine.',
                        'stories' => [
                            [
                                'title' => 'Les Huiles Servaient de Monnaie',
                                'tag' => 'Économie Antique',
                                'story' => 'Dans l\'Égypte ancienne, les huiles botaniques étaient si précieuses pour la santé de la peau que les artisans et bâtisseurs recevaient une partie de leur salaire en onguents.',
                                'modern_takeaway' => 'Nous traitons les huiles avec le même respect — en sélectionnant des extraits purs pour leur efficacité cutanée.',
                            ],
                            [
                                'title' => 'Le Khôl Était un Remède Médical',
                                'tag' => 'Santé Oculaire',
                                'story' => 'Porté par tous sans distinction, le khôl n\'était pas un simple ornement. Il protégeait les yeux du soleil éblouissant et des infections bactériennes.',
                                'modern_takeaway' => 'Notre Crème Nour perpétue cette protection avec la caféine et la niacinamide pour le contour des yeux.',
                            ],
                            [
                                'title' => 'Le Miel Était un Cicatrisant Reconnu',
                                'tag' => 'Science Antimicrobienne',
                                'story' => 'Les Égyptiens appliquaient du miel pour refermer les plaies et estomper les cicatrices. La pharmacologie moderne a confirmé ses puissantes vertus antibactériennes.',
                                'modern_takeaway' => 'Ces remèdes n\'étaient pas des superstitions, mais des millénaires d\'observations que la science confirme aujourd\'hui.',
                            ],
                        ],
                        'community_title' => 'Nos Racines dans la Communauté Égypto-Canadienne 🍁',
                        'community_text' => 'Le Canada compte plus de 105 000 citoyens d\'origine égyptienne. De Montréal à Vancouver, Cleo\'s Lab est né au cœur de cette communauté pour fabriquer à la main des soins en petits lots à Vancouver, BC, reliant tradition millénaire et rigueur canadienne.',
                    ],
                    'ar' => [
                        'bg_color' => '#f4ede2',
                        'text_color' => '#2e2224',
                        'eyebrow' => 'أسرار التاريخ الموثق',
                        'title' => "مصر القديمة، في الواقع:\nتاريخ الجمال كما لم تسمعيه من قبل.",
                        'subtitle' => 'الفراعنة لم يبتكروا العناية بالبشرة كنوع من الترف والتباهي، بل ابتكروها كعلم وقائي للبقاء في بيئة قاسية. إليك حقائق تاريخية مثبتة علمياً.',
                        'stories' => [
                            [
                                'title' => 'الزيوت كانت تُدفع كعملة رسمية',
                                'tag' => 'اقتصاد تاريخي',
                                'story' => 'في مصر القديمة، كانت الزيوت النباتية العطرية والمستخلصات ثمينة للغاية لدرجة أن العمال والبنائين كانوا يتلقون جزءاً من رواتبهم وأجورهم زيوتاً ودهانات علاجية.',
                                'modern_takeaway' => 'نتعامل مع الزيوت بنفس التقدير — نختار خلاصات نقية من موردين معتمدين لأداء وظيفتها الحيوية.',
                            ],
                            [
                                'title' => 'الكحل كان علاجاً وحماية طبية',
                                'tag' => 'صحة العين',
                                'story' => 'كان يضعه الرجال والنساء والأطفال على حد سواء، ولم يكن غرضه الزينة فقط بل كان مركباً لحماية العينين من وهج شمس الصحراء والوقاية من عدوى والتهابات العين.',
                                'modern_takeaway' => 'كريم Nour للعينين يستلهم روح الحماية باستخدام الكافيين والنياسيناميد لدعم هذه المنطقة الرقيقة.',
                            ],
                            [
                                'title' => 'العسل كان أول مضاد حيوي موثق',
                                'tag' => 'علم البكتيريا',
                                'story' => 'استخدم المصريون القدماء العسل الخام لعلاج الجروح وتسريع التئام الندبات، وأثبت الطب الحديث لاحقاً الخصائص المضادة للبكتيريا والمطهرة للعسل.',
                                'modern_takeaway' => 'لم تكن وصفات الأجداد مجرد تجارب عشوائية، بل كانت آلاف السنين من الملاحظة في انتظار إثبات المختبرات.',
                            ],
                        ],
                        'community_title' => 'جذور مصرية في قلب كندا 🍁',
                        'community_text' => 'أكثر من 105,000 كندي من أصول مصرية يعيشون اليوم في كندا، وتعد فانكوفر ومونتريال وتورونتو من أكبر الحواضن المجتمعية. بدأت Cleo\'s Lab من مجتمع فانكوفر المحلي ومن أسواق الـ Pop-ups في Lower Mainland، لتصل إلى كل أنحاء كندا بجذور أصيلة وصناعة يدوية نقية.',
                    ],
                ],
            ],
        ];
    }
}
