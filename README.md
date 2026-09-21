# Numbers Nebula — Nebula Cosmetics (سديم كوزمتكس) Luxury Storefront Theme for Bagisto 2.4.x / 2.5.x

A luxury, editorial beauty and skincare storefront theme built for **Bagisto 2.4.x / 2.5.x**, crafted following the **Numbers Nebula for Digital Solutions (سديم الأرقام للحلول الرقمية)** methodology.

## Key Features

- **Luxury Cosmetics Editorial Aesthetics**:
  - Warm cream background (`#fbf8f1`), paper surfaces (`#fffefd`), vivid signature magenta (`#bd1765`), soft blush pink (`#f089a8`), botanical mint (`#91e4d9`), and Numbers Nebula warm gold (`#c29958`).
  - High-end serif typography (`Cormorant Garamond` / `Amiri` / `El Messiri`), modern clean sans (`DM Sans` / `IBM Plex Sans Arabic`), and typewriter monospace accents (`Courier Prime`).
- **100% Dynamic & Database-Driven**:
  - Navigation menus automatically mirror Bagisto visible category trees (`CategoryRepository::getVisibleCategoryTree()`) with optional builder link overrides.
  - Featured products pull directly from `ProductRepository` with live currency pricing (`core()->currency()`) and instant AJAX quick-add to bag.
  - Interactive slide-out cart drawer connected to Bagisto cart sessions.
  - Interactive search modal with live category hints.
  - Customer account session integration (sign in, sign up, profile, orders, logout).
- **15 Modular Builder Sections (`Webkul\Theme\Sections\SectionType`)**:
  - `nc_announcement`: Customizable top announcement bar.
  - `nc_header_nav`: Custom header navigation and brand identity.
  - `nc_hero`: Split-screen hero banner with skin & product showcases.
  - `nc_manifesto`: Editorial brand manifesto quotation banner.
  - `nc_concerns`: Shop by skin concern grid (Texture, Barrier, Brightness, Firmness, Calm).
  - `nc_campaign`: Cinematic ritual story banner with CTA.
  - `nc_featured_products`: Product rail with category filter and quick-add.
  - `nc_routine`: Nebula Mixology 3-step routine builder (Cleanse, Treat, Seal).
  - `nc_collections`: Shop by collection cards with cosmetic bottle/jar styling.
  - `nc_rewards`: Loyalty and rewards callout card.
  - `nc_social_line`: Instagram & community handle strip.
  - `nc_service_strip`: 4-pillar store benefits and guarantees.
  - `nc_newsletter`: Newsletter subscription with toast notification feedback.
  - `nc_footer`: Multi-column footer with social links and copyright.
  - `nc_html`: Custom free-form HTML and CSS block for arbitrary page builder layouts.
- **Bilingual & Bidirectional (RTL / LTR)**:
  - Full Arabic (`ar`) and English (`en`) localization with dedicated typography adjustments.
- **Independent Vite 6 & Tailwind CSS 3 Pipeline**:
  - Self-contained asset bundling.

---

## Installation & Setup

### 1. Register in `composer.json`
Add the PSR-4 namespace in the root `composer.json`:
```json
"autoload": {
    "psr-4": {
        "NumbersNebula\\NebulaCosmetics\\": "packages/numbers-nebula/nebula-cosmetics/src"
    }
}
```
Then run:
```bash
composer dump-autoload
```

### 2. Register Service Provider in `bootstrap/providers.php`
```php
NumbersNebula\NebulaCosmetics\Providers\NebulaCosmeticsServiceProvider::class,
```

### 3. Register Theme in `config/themes.php`
```php
'shop' => [
    'nebula-cosmetics' => [
        'name' => 'سديم كوزمتكس (Nebula Cosmetics)',
        'author' => 'سديم الأرقام للحلول الرقمية (Numbers Nebula)',
        'preview_image' => '/themes/shop/nebula-cosmetics/images/preview.png',
        'assets_path' => 'public/themes/shop/nebula-cosmetics',
        'views_path' => 'packages/numbers-nebula/nebula-cosmetics/src/Resources/views',
        'parent' => 'default',

        'vite' => [
            'hot_file' => 'shop-nebula-cosmetics-vite.hot',
            'build_directory' => 'themes/shop/nebula-cosmetics/build',
            'package_assets_directory' => 'src/Resources/assets',
        ],

        'customize' => [
            'sections' => [
                \NumbersNebula\NebulaCosmetics\Sections\HeroSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\ManifestoSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\ConcernsSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\CampaignSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\FeaturedProductsSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\RoutineSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\CollectionsSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\RewardsSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\SocialLineSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\ServiceStripSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\NewsletterSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\AnnouncementSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\HeaderNavSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\FooterSection::class,
                \NumbersNebula\NebulaCosmetics\Sections\HtmlSection::class,
            ],
        ],
    ],
],
```

### 4. Build Assets
```bash
cd packages/numbers-nebula/nebula-cosmetics
npm install
npm run build
```

### 5. Seed Showcase Sections
```bash
php artisan db:seed --class="NumbersNebula\NebulaCosmetics\Database\Seeders\NebulaCosmeticsSectionsSeeder"
php artisan optimize:clear
```

---

## License
MIT License. Developed with pride by [Numbers Nebula for Digital Solutions](https://numbersnebula.com) for Granada Pride.
