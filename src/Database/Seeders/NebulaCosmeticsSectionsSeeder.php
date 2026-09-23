<?php

namespace NumbersNebula\NebulaCosmetics\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Theme\Repositories\SectionRepository;

class NebulaCosmeticsSectionsSeeder extends Seeder
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

        $this->seedForChannel($channel);
    }

    /**
     * Seed sections for a given channel.
     */
    public function seedForChannel($channel): void
    {
        if (! $channel) {
            return;
        }

        $locales = ['ar', 'en', 'fr'];

        $sections = [
            [
                'name' => 'nc::app.sections.announcement.title',
                'type' => 'nc_announcement',
                'sort_order' => 1,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'text' => 'احصلي على خصم 15% على أول طلب لكِ عند التسجيل',
                        'link' => '#newsletter',
                        'btn_text' => 'سجلي الآن',
                    ],
                    'en' => [
                        'text' => 'GET 15% OFF YOUR FIRST ORDER. SIGN UP',
                        'link' => '#newsletter',
                        'btn_text' => 'SIGN UP',
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.interactive_hero.title',
                'type' => 'nc_interactive_hero',
                'sort_order' => 2,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'bg_color' => '#fbf8f1',
                        'accent_color' => '#bd1765',
                        'disc_color' => '#f089a8',
                        'eyebrow' => 'سديم كوزمتكس — استوديو العناية الفائقة',
                        'title_line_1' => 'تصاميم وتركيبات',
                        'title_line_2' => 'تنظر في أعماق',
                        'title_accent' => 'عينيك.',
                        'subtitle' => 'نبتكر حلولاً متقدمة للعناية بالبشرة وقصصاً حقيقية ذات بصمة متفردة — تسع سنوات من الأبحاث الدقيقة، ونظرة ثاقبة لما تستحقه بشرتك.',
                        'btn_primary_text' => 'ابدئي استشارتك الخاصة',
                        'btn_primary_link' => '#consultation',
                        'btn_ghost_text' => 'care@nebula-cosmetics.com',
                        'btn_ghost_link' => 'mailto:care@nebula-cosmetics.com?subject=Skincare%20Consultation',
                        'hint_text' => 'همسة — إنها تتبع حركة مؤشرك',
                        'hint_sub' => 'انقري في أي مكان لتغمز لكِ',
                        'modal_title' => "أخبرينا عن روتينك\nواحتياجات بشرتك.",
                        'modal_subtitle' => 'بضعة تفاصيل كافية — خبيراتنا يقرأن كل كلمة بعناية فائقة لتقديم التركيبة الأمثل لكِ.',
                    ],
                    'en' => [
                        'bg_color' => '#fbf8f1',
                        'accent_color' => '#bd1765',
                        'disc_color' => '#f089a8',
                        'eyebrow' => 'Nebula — Modern High-Performance Skincare',
                        'title_line_1' => 'Formulas that',
                        'title_line_2' => 'look you in',
                        'title_accent' => 'the eye.',
                        'subtitle' => "We craft high-performance skincare formulas and stories with a point of view — rooted in clinical precision, and she's already sizing up yours.",
                        'btn_primary_text' => 'Start a consultation',
                        'btn_primary_link' => '#consultation',
                        'btn_ghost_text' => 'care@nebula-cosmetics.com',
                        'btn_ghost_link' => 'mailto:care@nebula-cosmetics.com?subject=Skincare%20Consultation',
                        'hint_text' => 'psst — she follows your cursor',
                        'hint_sub' => 'click anywhere — she winks',
                        'modal_title' => "Tell her about\nyour skin goals.",
                        'modal_subtitle' => "A line or two is plenty — she reads everything, she just doesn't always blink while doing it.",
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.hero.title',
                'type' => 'nc_hero',
                'sort_order' => 3,
                'status' => 0,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'eyebrow' => 'سديم كوزمتكس / العناية بالبشرة والجسم',
                        'headline' => "العناية بالبشرة،\nبرؤية عصرية.",
                        'subtitle' => 'تركيبات عالية الأداء مستوحاة من أنقى المكونات الطبيعية ومثبتة بالعلوم الجلدية الحديثة.',
                        'btn_text' => 'تسوقي التركيبات',
                        'btn_link' => '#shop',
                        'brand_mark_text' => 'سديم كوزمتكس',
                    ],
                    'en' => [
                        'eyebrow' => "NEBULA'S LAB / BODY + SKIN",
                        'headline' => "Skin, made\nmodern.",
                        'subtitle' => 'High-performance formulas rooted in botanical science and real skin health.',
                        'btn_text' => 'SHOP THE FORMULAS',
                        'btn_link' => '#shop',
                        'brand_mark_text' => 'NEBULA COSMETICS',
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.manifesto.title',
                'type' => 'nc_manifesto',
                'sort_order' => 3,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'quote' => '«تركيبات تعتني بصحة البشرة أولاً، مكونات فعالة، ونتائج ملموسة تدوم.»',
                        'author' => 'سديم كوزمتكس',
                    ],
                    'en' => [
                        'quote' => '"Skin-first formulas, active ingredients, visible results."',
                        'author' => 'NEBULA COSMETICS',
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.concerns.title',
                'type' => 'nc_concerns',
                'sort_order' => 4,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'kicker' => 'تسوقي حسب احتياج البشرة',
                        'items' => [
                            ['name' => 'المسام والملمس', 'copy' => 'لتجديد خلايا البشرة وتنعيم ملمسها وتنقية المسام طوال الليل.', 'btn_text' => 'تسوقي الآن', 'btn_link' => '#shop'],
                            ['name' => 'ترميم حاجز البشرة', 'copy' => 'للبشرة الجافة والحساسة التي تحتاج إلى حماية فائقة وترطيب عميق.', 'btn_text' => 'تسوقي الآن', 'btn_link' => '#shop'],
                            ['name' => 'نضارة وتوحيد اللون', 'copy' => 'للتخلص من البهتان والتصبغات وإضفاء إشراقة حيوية متجددة.', 'btn_text' => 'تسوقي الآن', 'btn_link' => '#shop'],
                            ['name' => 'شد ومرونة البشرة', 'copy' => 'لاستعادة حيوية وامتلاء البشرة ومحاربة علامات الإجهاد والتقدم في السن.', 'btn_text' => 'تسوقي الآن', 'btn_link' => '#shop'],
                            ['name' => 'تهدئة وراحة', 'copy' => 'تركيبات فائقة اللطف لتهدئة تهيج البشرة ومنحها شعوراً فورياً بالارتياح.', 'btn_text' => 'تسوقي الآن', 'btn_link' => '#shop'],
                        ],
                    ],
                    'en' => [
                        'kicker' => 'SHOP BY SKIN CONCERN',
                        'items' => [
                            ['name' => 'Texture + Pores', 'copy' => 'For rough texture, visible pores and overnight renewal.', 'btn_text' => 'SHOP NOW', 'btn_link' => '#shop'],
                            ['name' => 'Barrier Repair', 'copy' => 'For dry, reactive skin that needs comfort and strength.', 'btn_text' => 'SHOP NOW', 'btn_link' => '#shop'],
                            ['name' => 'Bright + Even', 'copy' => 'For dullness, uneven tone and a more rested look.', 'btn_text' => 'SHOP NOW', 'btn_link' => '#shop'],
                            ['name' => 'Firm + Restore', 'copy' => 'For skin marked by change, dryness and loss of bounce.', 'btn_text' => 'SHOP NOW', 'btn_link' => '#shop'],
                            ['name' => 'Calm + Comfort', 'copy' => 'For easily stressed skin that wants a gentler routine.', 'btn_text' => 'SHOP NOW', 'btn_link' => '#shop'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.campaign.title',
                'type' => 'nc_campaign',
                'sort_order' => 5,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'eyebrow' => 'مصنوعة لبشرة حقيقية',
                        'title' => 'تناقلي الطقوس جيلاً بعد جيل.',
                        'description' => 'حكمة توارثتها الأجيال، مواد فعالة حديثة، ورف تجميل متكامل يفيض بالجمال.',
                        'btn_text' => 'ابني روتينكِ الخاص',
                        'btn_link' => '#routine',
                    ],
                    'en' => [
                        'eyebrow' => 'MADE FOR REAL SKIN',
                        'title' => 'Pass the ritual on.',
                        'description' => 'Generational wisdom. Modern actives. One very good shelf.',
                        'btn_text' => 'BUILD YOUR ROUTINE',
                        'btn_link' => '#routine',
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.featured_products.title',
                'type' => 'nc_featured_products',
                'sort_order' => 6,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'eyebrow' => 'نتائج مثبتة',
                        'title' => 'عناية فائقة لبشرة متألقة.',
                        'badge_text' => 'الأكثر مبيعاً',
                        'filters' => ['limit' => '8', 'sort' => 'desc'],
                    ],
                    'en' => [
                        'eyebrow' => "WHAT'S WORKING",
                        'title' => 'Hard-working skin care.',
                        'badge_text' => 'BESTSELLER',
                        'filters' => ['limit' => '8', 'sort' => 'desc'],
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.routine.title',
                'type' => 'nc_routine',
                'sort_order' => 7,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'eyebrow' => 'فن دمج المستحضرات',
                        'title' => "روتين واحد متكامل.\nدون أي تعقيد.",
                        'description' => 'اختاري قاعدة تنظيف نقية، أضيفي مادة فعالة موجهة لهدفك، ثم احبسي الترطيب. تركيباتنا متوافقة لتمنحكِ أقصى فائدة دون إرهاق بشرتكِ.',
                        'btn_text' => 'اعثري على تركيبتكِ',
                        'btn_link' => '#shop',
                        'steps' => [
                            ['number' => '01', 'title' => 'التنظيف', 'copy' => 'إعادة التوازن والنقاء دون تجريد الزيوت الطبيعية.'],
                            ['number' => '02', 'title' => 'العلاج', 'copy' => 'استهداف احتياج بشرتكِ بمواد فعالة مركزة.'],
                            ['number' => '03', 'title' => 'الحماية والترطيب', 'copy' => 'حبس المغذيات والترطيب طوال اليوم.'],
                        ],
                    ],
                    'en' => [
                        'eyebrow' => 'NEBULA MIXOLOGY',
                        'title' => "One routine.\nZero confusion.",
                        'description' => 'Choose a clean base, add one targeted active, then seal in moisture. Our formulas are made to work together without overworking your skin.',
                        'btn_text' => 'FIND MY FORMULAS',
                        'btn_link' => '#shop',
                        'steps' => [
                            ['number' => '01', 'title' => 'CLEANSE', 'copy' => 'Reset without stripping.'],
                            ['number' => '02', 'title' => 'TREAT', 'copy' => 'Target one concern at a time.'],
                            ['number' => '03', 'title' => 'SEAL', 'copy' => 'Keep the good stuff in.'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.collections.title',
                'type' => 'nc_collections',
                'sort_order' => 8,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'kicker' => 'تسوقي حسب المجموعة',
                        'items' => [
                            ['name' => 'المقشرات', 'tone' => '#ef88b4', 'link' => '#shop'],
                            ['name' => 'المرطبات', 'tone' => '#a6e7d5', 'link' => '#shop'],
                            ['name' => 'السيروم', 'tone' => '#f7a7be', 'link' => '#shop'],
                            ['name' => 'العين والشفاه', 'tone' => '#d9c7ff', 'link' => '#shop'],
                            ['name' => 'الأقنعة', 'tone' => '#f2c7a7', 'link' => '#shop'],
                        ],
                    ],
                    'en' => [
                        'kicker' => 'SHOP BY COLLECTION',
                        'items' => [
                            ['name' => 'Exfoliants', 'tone' => '#ef88b4', 'link' => '#shop'],
                            ['name' => 'Moisturisers', 'tone' => '#a6e7d5', 'link' => '#shop'],
                            ['name' => 'Serums', 'tone' => '#f7a7be', 'link' => '#shop'],
                            ['name' => 'Eye + Lip', 'tone' => '#d9c7ff', 'link' => '#shop'],
                            ['name' => 'Masks', 'tone' => '#f2c7a7', 'link' => '#shop'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.rewards.title',
                'type' => 'nc_rewards',
                'sort_order' => 9,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'eyebrow' => 'مزايا فريدة في كل خطوة',
                        'title' => 'انضمي إلى مكافآت سديم.',
                        'description' => 'اجمعي النقاط مع كل تركيبة تقتنينها، وافتحي هدايا أعياد الميلاد وتجربة المنتجات الحصرية أولاً بأول. البشرة الجميلة تستحق مزايا إضافية.',
                        'link_text' => 'اكتشفي المزيد',
                        'link_url' => '#newsletter',
                    ],
                    'en' => [
                        'eyebrow' => 'PERKS BEHIND EVERY PETAL',
                        'title' => 'Join Nebula Rewards.',
                        'description' => 'Earn points on every formula, unlock birthday treats and get first access to new drops. Good skin should come with benefits.',
                        'link_text' => 'LEARN MORE',
                        'link_url' => '#newsletter',
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.social_line.title',
                'type' => 'nc_social_line',
                'sort_order' => 10,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'text' => 'شاهدي تركيباتنا على أرض الواقع',
                        'handle' => '@NEBULA.COSMETICS',
                        'link' => 'https://instagram.com',
                        'items' => [
                            ['image' => 'images/cleo-concern-portrait.jpg', 'link' => 'https://instagram.com'],
                            ['image' => 'images/cleo-concern-application.jpg', 'link' => 'https://instagram.com'],
                            ['image' => 'images/cleo-hero-product.jpg', 'link' => 'https://instagram.com'],
                            ['image' => 'images/cleo-concern-texture.jpg', 'link' => 'https://instagram.com'],
                            ['image' => 'images/cleo-hero-skin.jpg', 'link' => 'https://instagram.com'],
                            ['image' => 'images/cleo-ritual-wide.jpg', 'link' => 'https://instagram.com'],
                        ],
                    ],
                    'en' => [
                        'text' => 'SEE THE LAB IN REAL LIFE',
                        'handle' => '@NEBULA.COSMETICS',
                        'link' => 'https://instagram.com',
                        'items' => [
                            ['image' => 'images/cleo-concern-portrait.jpg', 'link' => 'https://instagram.com'],
                            ['image' => 'images/cleo-concern-application.jpg', 'link' => 'https://instagram.com'],
                            ['image' => 'images/cleo-hero-product.jpg', 'link' => 'https://instagram.com'],
                            ['image' => 'images/cleo-concern-texture.jpg', 'link' => 'https://instagram.com'],
                            ['image' => 'images/cleo-hero-skin.jpg', 'link' => 'https://instagram.com'],
                            ['image' => 'images/cleo-ritual-wide.jpg', 'link' => 'https://instagram.com'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.service_strip.title',
                'type' => 'nc_service_strip',
                'sort_order' => 11,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'items' => [
                            ['title' => 'شحن مجاني', 'description' => 'للطلبات المؤهلة في كافة المناطق'],
                            ['title' => 'تركيبات ذكية', 'description' => 'مصنوعة لروتين عناية حقيقي وفعّال'],
                            ['title' => 'مكونات طبيعية', 'description' => 'مستوحاة من أنقى المستخلصات النباتية'],
                            ['title' => 'مكافآت سديم', 'description' => 'نقاط، مزايا، وتجارب استثنائية'],
                        ],
                    ],
                    'en' => [
                        'items' => [
                            ['title' => 'FREE SHIPPING', 'description' => 'On orders over qualifying amounts'],
                            ['title' => 'SKIN-SMART FORMULAS', 'description' => 'Made for real daily routines'],
                            ['title' => 'NATURAL ROOTS', 'description' => 'Rooted in botanical science'],
                            ['title' => 'NEBULA REWARDS', 'description' => 'Points, perks and previews'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.newsletter.title',
                'type' => 'nc_newsletter',
                'sort_order' => 12,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'eyebrow' => 'انضمي إلى مجتمعنا',
                        'title' => 'احصلي على خصم 15%.',
                        'description' => 'تركيبات جديدة، نصائح للبشرة، ووصول حصري قبل الجميع. محتوى قيّم وهادئ.',
                        'placeholder' => 'البريد الإلكتروني',
                        'btn_text' => 'سجليني الآن',
                    ],
                    'en' => [
                        'eyebrow' => "LET'S MAKE THIS OFFICIAL",
                        'title' => 'Take 15% off.',
                        'description' => 'New formulas, useful skin notes and first access. Nothing noisy.',
                        'placeholder' => 'EMAIL ADDRESS',
                        'btn_text' => 'SIGN ME UP',
                    ],
                ],
            ],
            [
                'name' => 'nc::app.sections.footer.title',
                'type' => 'nc_footer',
                'sort_order' => 13,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'brand_title' => 'سديم كوزمتكس',
                        'brand_subtitle' => 'مختبرات العناية والجمال',
                        'brand_description' => 'مستحضرات تجميل فاخرة وعناية متطورة بالبشرة مستوحاة من أسرار الطبيعة وأحدث ما توصلت إليه علوم الجمال.',
                        'column_1_title' => 'المساعدة والدعم',
                        'column_1_links' => [
                            ['title' => 'الأسئلة الشائعة', 'url' => '#top'],
                            ['title' => 'اتصلي بنا', 'url' => '#top'],
                            ['title' => 'الشحن والتوصيل', 'url' => '#top'],
                            ['title' => 'الاستبدال والاسترجاع', 'url' => '#top'],
                        ],
                        'column_2_title' => 'المزيد عن سديم',
                        'column_2_links' => [
                            ['title' => 'بناء الروتين', 'url' => '#routine'],
                            ['title' => 'مكافآت سديم', 'url' => '#rewards'],
                            ['title' => 'معاييرنا ومكوناتنا', 'url' => '#top'],
                            ['title' => 'المجلة والمدونة', 'url' => '#top'],
                        ],
                        'column_3_title' => 'تسوقي حسب الفئة',
                        'column_3_links' => [],
                        'location' => 'القاهرة / دبي / الرياض',
                        'social_links' => 'إنستغرام   تيك توك   بينترست',
                        'copyright' => '© 2026 سديم كوزمتكس. جميع الحقوق محفوظة.',
                        'show_developer_credit' => '1',
                        'developer_credit_text' => 'صمم بواسطة سديم الأرقام للحلول الرقمية',
                        'developer_credit_url' => 'https://numbers-nebula.com',
                    ],
                    'en' => [
                        'brand_title' => 'NEBULA COSMETICS',
                        'brand_subtitle' => 'LABORATOIRES',
                        'brand_description' => 'Luxury cosmetic formulations and advanced skincare rituals crafted with nature\'s rarest botanicals and clinical efficacy.',
                        'column_1_title' => 'HELP & SUPPORT',
                        'column_1_links' => [
                            ['title' => 'FAQ', 'url' => '#top'],
                            ['title' => 'Contact Us', 'url' => '#top'],
                            ['title' => 'Shipping & Delivery', 'url' => '#top'],
                            ['title' => 'Returns & Exchanges', 'url' => '#top'],
                        ],
                        'column_2_title' => 'ABOUT NEBULA',
                        'column_2_links' => [
                            ['title' => 'Build Routine', 'url' => '#routine'],
                            ['title' => 'Rewards Program', 'url' => '#rewards'],
                            ['title' => 'Our Standards', 'url' => '#top'],
                            ['title' => 'Journal', 'url' => '#top'],
                        ],
                        'column_3_title' => 'SHOP BY CATEGORY',
                        'column_3_links' => [],
                        'location' => 'Cairo / Dubai / Riyadh',
                        'social_links' => 'Instagram   TikTok   Pinterest',
                        'copyright' => '© 2026 Nebula Cosmetics. All Rights Reserved.',
                        'show_developer_credit' => '1',
                        'developer_credit_text' => 'Designed by Numbers Nebula',
                        'developer_credit_url' => 'https://numbers-nebula.com',
                    ],
                ],
            ],
        ];

        foreach ($sections as $sectionData) {
            $translations = $sectionData['options'];
            unset($sectionData['options']);

            $existing = $this->sectionRepository->findOneWhere([
                'type' => $sectionData['type'],
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
            ]);

            $section = $existing ?: $this->sectionRepository->create($sectionData);

            $section->status = $sectionData['status'] ?? 1;
            $section->sort_order = $sectionData['sort_order'];
            $section->draft_status = null;
            $section->draft_sort_order = null;

            foreach ($locales as $locale) {
                if (isset($translations[$locale])) {
                    $translation = $section->translateOrNew($locale);
                    $translation->options = $translations[$locale];
                    $translation->draft_options = null;
                }
            }

            $section->save();
        }

        app(CleoSectionsSeeder::class)->run($channel);
    }
}
