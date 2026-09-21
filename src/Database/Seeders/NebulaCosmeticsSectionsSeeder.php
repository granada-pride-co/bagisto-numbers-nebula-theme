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
    public function run(): void
    {
        $channel = $this->channelRepository->first();

        if (! $channel) {
            return;
        }

        $locales = ['ar', 'en'];

        $sections = [
            [
                'name' => 'القسم الأول: شريط الإعلانات الترويجي',
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
                'name' => 'القسم الثاني: الواجهة الرئيسية',
                'type' => 'nc_hero',
                'sort_order' => 2,
                'status' => 1,
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
                'name' => 'القسم الثالث: بيان النص والاقتباس',
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
                'name' => 'القسم الرابع: شبكة البطاقات والمميزات',
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
                'name' => 'القسم الخامس: البانر الإعلاني العريض',
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
                'name' => 'القسم السادس: شبكة المنتجات',
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
                'name' => 'القسم السابع: خطوات الروتين والخدمات',
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
                'name' => 'القسم الثامن: المجموعات والتصنيفات',
                'type' => 'nc_collections',
                'sort_order' => 8,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'kicker' => 'تسوقي حسب المجموعة',
                        'items' => [
                            ['name' => 'المقشرات', 'format' => 'jar', 'tone' => '#ef88b4', 'link' => '#shop'],
                            ['name' => 'المرطبات', 'format' => 'jar', 'tone' => '#a6e7d5', 'link' => '#shop'],
                            ['name' => 'السيروم', 'format' => 'bottle', 'tone' => '#f7a7be', 'link' => '#shop'],
                            ['name' => 'العين والشفاه', 'format' => 'tube', 'tone' => '#d9c7ff', 'link' => '#shop'],
                            ['name' => 'الأقنعة', 'format' => 'pouch', 'tone' => '#f2c7a7', 'link' => '#shop'],
                        ],
                    ],
                    'en' => [
                        'kicker' => 'SHOP BY COLLECTION',
                        'items' => [
                            ['name' => 'Exfoliants', 'format' => 'jar', 'tone' => '#ef88b4', 'link' => '#shop'],
                            ['name' => 'Moisturisers', 'format' => 'jar', 'tone' => '#a6e7d5', 'link' => '#shop'],
                            ['name' => 'Serums', 'format' => 'bottle', 'tone' => '#f7a7be', 'link' => '#shop'],
                            ['name' => 'Eye + Lip', 'format' => 'tube', 'tone' => '#d9c7ff', 'link' => '#shop'],
                            ['name' => 'Masks', 'format' => 'pouch', 'tone' => '#f2c7a7', 'link' => '#shop'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'القسم التاسع: بانر العرض والمكافآت',
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
                'name' => 'القسم العاشر: شريط التواصل الاجتماعي',
                'type' => 'nc_social_line',
                'sort_order' => 10,
                'status' => 1,
                'channel_id' => $channel->id,
                'theme_code' => 'nebula-cosmetics',
                'options' => [
                    'ar' => [
                        'text' => 'شاهدي تركيباتنا على أرض الواقع',
                        'handle' => '@NEBULA.COSMETICS',
                        'link' => '#top',
                    ],
                    'en' => [
                        'text' => 'SEE THE LAB IN REAL LIFE',
                        'handle' => '@NEBULA.COSMETICS',
                        'link' => '#top',
                    ],
                ],
            ],
            [
                'name' => 'القسم الحادي عشر: شريط المزايا الأربعة',
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
                'name' => 'القسم الثاني عشر: صندوق النشرة البريدية',
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

            foreach ($locales as $locale) {
                if (isset($translations[$locale])) {
                    $section->translateOrNew($locale)->options = $translations[$locale];
                }
            }

            $section->save();
        }
    }
}
