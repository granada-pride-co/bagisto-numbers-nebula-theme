@props(['options' => []])

@php
    $isAr = app()->getLocale() === 'ar';

    $bgColor = data_get($options, 'bg_color') ?: '#fbf8f1';
    $textColor = data_get($options, 'text_color') ?: '#2e2224';
    $accentColor = data_get($options, 'accent_color') ?: '#bd1765';
    $discColor = data_get($options, 'disc_color') ?: '#f089a8';

    $eyebrow = data_get($options, 'eyebrow') ?: trans('nc::app.sections.interactive_hero.default_eyebrow');
    $title1 = data_get($options, 'title_line_1') ?: trans('nc::app.sections.interactive_hero.default_title_line_1');
    $title2 = data_get($options, 'title_line_2') ?: trans('nc::app.sections.interactive_hero.default_title_line_2');
    $titleAccent = data_get($options, 'title_accent') ?: trans('nc::app.sections.interactive_hero.default_title_accent');

    $subtitle = data_get($options, 'subtitle') ?: trans('nc::app.sections.interactive_hero.default_subtitle');

    $btnPrimaryText = data_get($options, 'btn_primary_text') ?: trans('nc::app.sections.interactive_hero.default_btn_primary');
    $btnPrimaryLink = data_get($options, 'btn_primary_link') ?: '#consultation';

    $btnGhostText = data_get($options, 'btn_ghost_text') ?: 'care@nebula-cosmetics.com';
    $btnGhostLink = data_get($options, 'btn_ghost_link') ?: 'mailto:care@nebula-cosmetics.com?subject=Skincare%20Consultation';

    $hintText = data_get($options, 'hint_text') ?: trans('nc::app.sections.interactive_hero.default_hint_text');
    $hintSub = data_get($options, 'hint_sub') ?: trans('nc::app.sections.interactive_hero.default_hint_sub');

    $modalTitle = data_get($options, 'modal_title') ?: trans('nc::app.sections.interactive_hero.default_modal_title');
    $modalSubtitle = data_get($options, 'modal_subtitle') ?: trans('nc::app.sections.interactive_hero.default_modal_subtitle');
@endphp

<section
    class="nc-interactive-hero relative overflow-hidden select-none"
    dir="{{ $isAr ? 'rtl' : 'ltr' }}"
    style="--bg-paper: {{ $bgColor }}; --ink-main: {{ $textColor }}; --accent-magenta: {{ $accentColor }}; --disc-accent: {{ $discColor }}; background-color: var(--bg-paper);"
    data-nc-interactive-hero
>
    <div class="nc-hero-inner min-h-[92svh] lg:min-h-screen relative flex flex-col justify-center px-6 lg:px-16 py-20 z-10 {{ $isAr ? 'items-start text-right' : 'items-start text-left' }}">
        <div class="nc-hero-copy w-full lg:w-[54%] max-w-2xl z-20 flex flex-col justify-center relative {{ $isAr ? 'ms-0 me-auto text-right' : 'ms-0 me-auto text-left' }}">
            <div class="nc-hero-eyebrow flex items-center gap-3 text-xs uppercase {{ $isAr ? 'tracking-normal' : 'tracking-[0.2em]' }} font-medium mb-6">
                <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: var(--accent-magenta);"></span>
                <span style="color: var(--ink-main);">{{ $eyebrow }}</span>
            </div>

            <h1 class="nc-hero-title font-serif text-5xl sm:text-6xl md:text-7xl lg:text-8xl {{ $isAr ? 'leading-[1.25] sm:leading-[1.22] tracking-normal' : 'leading-[0.98] tracking-tight' }} mb-8 {{ $isAr ? 'text-right' : 'text-left' }}" style="color: var(--ink-main);">
                <span class="block overflow-hidden {{ $isAr ? 'py-1' : '' }}"><span class="block transform nc-rise-1">{{ $title1 }}</span></span>
                <span class="block overflow-hidden {{ $isAr ? 'py-1' : '' }}"><span class="block transform nc-rise-2">{{ $title2 }}</span></span>
                <span class="block overflow-hidden {{ $isAr ? 'py-1' : '' }}">
                    <span class="block transform nc-rise-3">
                        <em class="italic font-normal" style="color: var(--accent-magenta);">{{ $titleAccent }}</em>
                    </span>
                </span>
            </h1>

            <p class="nc-hero-sub text-base sm:text-lg leading-relaxed text-[#2e2224]/80 max-w-xl mb-10 {{ $isAr ? 'text-right' : 'text-left' }}">
                {{ $subtitle }}
            </p>

            <div class="nc-hero-ctas flex items-center gap-6 flex-wrap">
                <button
                    type="button"
                    class="nc-btn-hero-primary group inline-flex items-center gap-3 text-xs sm:text-sm uppercase tracking-widest px-8 py-4 rounded-full transition-all duration-300 font-semibold cursor-pointer shadow-sm hover:shadow-md"
                    style="background-color: var(--ink-main); color: #ffffff;"
                    data-hero-consult-btn
                >
                    <span>{{ $btnPrimaryText }}</span>
                    <svg class="w-4 h-4 {{ $isAr ? 'rotate-180 group-hover:-translate-x-1' : 'group-hover:translate-x-1' }} transition-transform duration-300" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 8h11M9 3.5 13.5 8 9 12.5"/>
                    </svg>
                </button>

                <a
                    href="{{ $btnGhostLink }}"
                    class="nc-btn-hero-ghost inline-flex items-center gap-2 text-xs sm:text-sm border-b pb-1 transition-colors duration-300"
                    style="border-color: var(--ink-main); color: var(--ink-main);"
                >
                    <span>{{ $btnGhostText }}</span>
                    <svg class="w-3.5 h-3.5 {{ $isAr ? 'rotate-180' : '' }}" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <path d="M2 10 10 2M4 2h6v6"/>
                    </svg>
                </a>
            </div>
        </div>

        <div
            class="nc-hero-figure absolute bottom-0 z-10 w-[95%] sm:w-[75%] md:w-[60%] lg:w-[46%] max-w-[620px] h-[55svh] md:h-[75svh] lg:h-[92svh] pointer-events-none overflow-hidden {{ $isAr ? 'left-0 lg:left-6' : 'right-0 lg:right-6' }}"
            style="{{ $isAr ? 'left: 0; right: auto;' : 'right: 0; left: auto;' }} bottom: 0;"
        >
            <div
                class="nc-hero-hint absolute top-[14%] z-20 font-serif italic text-sm md:text-base pointer-events-auto transition-opacity duration-1000 {{ $isAr ? 'right-[4%] rotate-6 text-right' : 'left-[4%] -rotate-6 text-left' }}"
                style="{{ $isAr ? 'right: 4%; left: auto;' : 'left: 4%; right: auto;' }}"
                id="ncHint"
            >
                <span class="block">{{ $hintText }}</span>
                <svg class="w-12 h-8 my-1 {{ $isAr ? 'mr-6 scale-x-[-1]' : 'ml-6' }}" viewBox="0 0 56 44" fill="none" stroke="#2e2224" stroke-width="1.6" stroke-linecap="round">
                    <path d="M3 5 C 20 -1 40 8 48 30"/><path d="M48 30 l-9 -2.2 M48 30 l1.5 -8.8"/>
                </svg>
                <span class="block text-xs text-[#2e2224]/65">{{ $hintSub }}</span>
            </div>

                                    <svg
                id="ncGirl"
                class="w-full h-full block"
                viewBox="0 0 640 780"
                preserveAspectRatio="xMidYMax meet"
                role="img"
                aria-label="{{ $eyebrow }}"
            >
                <defs>
                    <clipPath id="ncCeL"><path d="M232 319 Q262 297 292 319 Q262 339 232 319 Z"/></clipPath>
                    <clipPath id="ncCeR"><path d="M348 319 Q378 297 408 319 Q378 339 348 319 Z"/></clipPath>
                </defs>

                <!-- Backdrop Decorative Disc + Pharaonic Golden Aura -->
                <g id="ncDisc">
                    <circle cx="320" cy="295" r="250" fill="{{ $discColor }}" opacity="0.93" />
                    <circle cx="320" cy="295" r="258" fill="none" stroke="#d4af37" stroke-width="3" stroke-dasharray="10 5" opacity="0.9" />
                    <circle cx="320" cy="295" r="271" fill="none" stroke="#fae17d" stroke-width="1.5" stroke-dasharray="2 11" opacity="0.55" />
                </g>

                <!-- Back Hair: Full sleek pharaonic bob behind shoulders -->
                <g id="ncHairBack">
                    <path fill="#181016" d="M320 58 C202 58 134 142 132 252 C130 344 132 436 130 520 C128 572 156 594 206 594 C238 594 252 572 256 538 C260 460 276 438 320 438 C364 438 380 460 384 538 C388 572 402 594 434 594 C484 594 512 572 510 520 C508 436 510 344 508 252 C506 142 438 58 320 58 Z"/>
                    <path fill="none" stroke="#332030" stroke-width="5" stroke-linecap="round" opacity="0.8" d="M182 172 C168 268 170 374 172 506"/>
                    <path fill="none" stroke="#332030" stroke-width="5" stroke-linecap="round" opacity="0.8" d="M458 172 C472 268 470 374 468 506"/>
                    <path fill="none" stroke="#3f2d3a" stroke-width="3" stroke-linecap="round" opacity="0.5" d="M158 222 C146 315 148 415 150 524"/>
                    <path fill="none" stroke="#3f2d3a" stroke-width="3" stroke-linecap="round" opacity="0.5" d="M482 222 C494 315 492 415 490 524"/>
                </g>

                <!-- Torso + Royal Garments -->
                <g id="ncBody">
                    <!-- Skin base warm copper-olive -->
                    <path fill="#d9936a" d="M96 780 C104 704 154 660 222 638 C262 624 282 606 286 580 L286 478 L354 478 L354 580 C358 606 378 624 418 638 C486 660 536 704 544 780 Z"/>
                    <!-- Neck highlight center -->
                    <path fill="#ebb28a" d="M304 478 L304 580 C306 600 312 614 320 618 C328 614 334 600 336 580 L336 478 Z"/>
                    <path stroke="#a06040" stroke-width="2" fill="none" stroke-linecap="round" d="M292 494 C291 530 293 558 298 580" opacity="0.3"/>
                    <path stroke="#a06040" stroke-width="2" fill="none" stroke-linecap="round" d="M348 494 C349 530 347 558 342 580" opacity="0.3"/>
                    <!-- Ivory Linen Sheath Gown -->
                    <path fill="#fdfbf5" stroke="#d0c8b4" stroke-width="1.5" d="M60 780 C70 712 126 670 196 650 C236 638 255 628 268 620 C280 635 298 646 320 646 C342 646 360 635 372 620 C385 628 404 638 444 650 C514 670 570 712 580 780 Z"/>
                    <path fill="#e8dfd0" stroke="none" d="M308 780 C306 740 304 710 302 680 L338 680 C336 710 334 740 332 780 Z"/>
                    <path stroke="#c0b89a" stroke-width="1.5" fill="none" d="M118 780 C132 746 158 708 194 676"/>
                    <path stroke="#c0b89a" stroke-width="1.5" fill="none" d="M178 780 C192 740 220 698 256 664"/>
                    <path stroke="#c0b89a" stroke-width="1.5" fill="none" d="M462 780 C448 740 420 698 384 664"/>
                    <path stroke="#c0b89a" stroke-width="1.5" fill="none" d="M522 780 C508 746 482 708 446 676"/>
                    <!-- Grand Usekh Broad Collar Draped From Shoulders -->
                    <g id="ncShoulderClasps">
                        <!-- Left shoulder clasp -->
                        <g transform="translate(205.0, 630.0) rotate(-26)">
                            <rect x="-30" y="-8" width="60" height="16" rx="4" fill="#d4af37" stroke="#9e7e17" stroke-width="1.2"/>
                            <rect x="-24" y="-5" width="48" height="10" rx="2" fill="#163969"/>
                            <circle cx="-12" cy="0" r="3.5" fill="#1ea69c"/>
                            <circle cx="0" cy="0" r="4" fill="{{ $accentColor }}"/>
                            <circle cx="12" cy="0" r="3.5" fill="#fae17d"/>
                        </g>
                        <!-- Right shoulder clasp -->
                        <g transform="translate(435.0, 630.0) rotate(26)">
                            <rect x="-30" y="-8" width="60" height="16" rx="4" fill="#d4af37" stroke="#9e7e17" stroke-width="1.2"/>
                            <rect x="-24" y="-5" width="48" height="10" rx="2" fill="#163969"/>
                            <circle cx="-12" cy="0" r="3.5" fill="#fae17d"/>
                            <circle cx="0" cy="0" r="4" fill="{{ $accentColor }}"/>
                            <circle cx="12" cy="0" r="3.5" fill="#1ea69c"/>
                        </g>
                    </g>
                    <!-- Outermost Gold Tier -->
                    <path fill="#c9a224" stroke="#9e7e17" stroke-width="1" d="M155.0 655.0 C212.8 717.2 278.8 738.0 320 738.0 C361.2 738.0 427.2 717.2 485.0 655.0 L469.8 647.4 C414.9 704.9 355.2 724.0 320 724.0 C284.8 724.0 225.1 704.9 170.2 647.4 Z"/>
                    <!-- Lotus Droplet Pendants -->
                    <g fill="#d4af37" stroke="#9e7e17" stroke-width="0.8">
                        <path d="M172.9 669.9 C168.9 679.9 167.9 689.9 172.9 693.9 C177.9 689.9 176.9 679.9 172.9 669.9 Z"/>
                        <path d="M190.6 688.0 C186.6 698.0 185.6 708.0 190.6 712.0 C195.6 708.0 194.6 698.0 190.6 688.0 Z"/>
                        <path d="M210.3 703.1 C206.3 713.1 205.3 723.1 210.3 727.1 C215.3 723.1 214.3 713.1 210.3 703.1 Z"/>
                        <path d="M231.8 715.4 C227.8 725.4 226.8 735.4 231.8 739.4 C236.8 735.4 235.8 725.4 231.8 715.4 Z"/>
                        <path d="M255.0 725.0 C251.0 735.0 250.0 745.0 255.0 749.0 C260.0 745.0 259.0 735.0 255.0 725.0 Z"/>
                        <path d="M279.7 732.1 C275.7 742.1 274.7 752.1 279.7 756.1 C284.7 752.1 283.7 742.1 279.7 732.1 Z"/>
                        <path d="M305.6 736.6 C301.6 746.6 300.6 756.6 305.6 760.6 C310.6 756.6 309.6 746.6 305.6 736.6 Z"/>
                        <path d="M332.2 738.4 C328.2 748.4 327.2 758.4 332.2 762.4 C337.2 758.4 336.2 748.4 332.2 738.4 Z"/>
                        <path d="M358.4 737.5 C354.4 747.5 353.4 757.5 358.4 761.5 C363.4 757.5 362.4 747.5 358.4 737.5 Z"/>
                        <path d="M383.5 733.6 C379.5 743.6 378.5 753.6 383.5 757.6 C388.5 753.6 387.5 743.6 383.5 733.6 Z"/>
                        <path d="M407.4 726.7 C403.4 736.7 402.4 746.7 407.4 750.7 C412.4 746.7 411.4 736.7 407.4 726.7 Z"/>
                        <path d="M429.7 716.8 C425.7 726.8 424.7 736.8 429.7 740.8 C434.7 736.8 433.7 726.8 429.7 716.8 Z"/>
                        <path d="M450.4 703.7 C446.4 713.7 445.4 723.7 450.4 727.7 C455.4 723.7 454.4 713.7 450.4 703.7 Z"/>
                    </g>
                    <!-- Lapis Navy Tier -->
                    <path fill="#163969" stroke="#0e2444" stroke-width="0.8" d="M170.2 647.4 C225.1 704.9 284.8 724.0 320 724.0 C355.2 724.0 414.9 704.9 469.8 647.4 L448.0 636.5 C397.4 687.4 345.5 704.0 320 704.0 C294.5 704.0 242.6 687.4 192.0 636.5 Z"/>
                    <!-- Turquoise Tier -->
                    <path fill="#1ea69c" stroke="#147c74" stroke-width="0.8" d="M192.0 636.5 C242.6 687.4 294.5 704.0 320 704.0 C345.5 704.0 397.4 687.4 448.0 636.5 L426.3 625.7 C379.9 669.9 335.8 684.0 320 684.0 C304.2 684.0 260.1 669.9 213.7 625.7 Z"/>
                    <!-- Royal Magenta Tier -->
                    <path fill="{{ $accentColor }}" stroke="#8a0f49" stroke-width="0.8" d="M213.7 625.7 C260.1 669.9 304.2 684.0 320 684.0 C335.8 684.0 379.9 669.9 426.3 625.7 L404.6 614.8 C362.4 652.4 326.1 664.0 320 664.0 C313.9 664.0 277.6 652.4 235.4 614.8 Z"/>
                    <!-- Inner Gold Tier -->
                    <path fill="#f5ce4a" stroke="#c9a224" stroke-width="0.8" d="M235.4 614.8 C277.6 652.4 313.9 664.0 320 664.0 C326.1 664.0 362.4 652.4 404.6 614.8 L385.0 605.0 C346.7 636.6 317.4 646.0 320 646.0 C322.6 646.0 293.3 636.6 255.0 605.0 Z"/>
                    <!-- Central Sun Medallion -->
                    <circle cx="320" cy="654" r="14" fill="#c9a224" stroke="#9e7e17" stroke-width="1.5"/>
                    <circle cx="320" cy="654" r="9" fill="{{ $accentColor }}"/>
                    <circle cx="320" cy="654" r="4.5" fill="#fae17d"/>
                    <circle cx="320" cy="654" r="2" fill="#c9a224"/>
                    <!-- Golden Choker Neck Band -->
                    <path fill="#d4af37" stroke="#9e7e17" stroke-width="1.2" d="M274 520 L366 520 C368 536 364 548 360 550 L280 550 C276 548 272 536 274 520 Z"/>
                    <rect x="284" y="526" width="72" height="13" rx="3" fill="#163969"/>
                    <circle cx="300" cy="533" r="4" fill="#1ea69c"/>
                    <circle cx="320" cy="533" r="5" fill="{{ $accentColor }}" stroke="#fae17d" stroke-width="1"/>
                    <circle cx="340" cy="533" r="4" fill="#1ea69c"/>
                </g>

                <!-- Head, Face, Makeup, Crown -->
                <g id="ncHead">
                    <!-- Multi-Tier Drop Earrings Left -->
                    <g transform="translate(178, 376)">
                        <circle cx="0" cy="0" r="9" fill="#d4af37" stroke="#9e7e17" stroke-width="1.2"/>
                        <circle cx="0" cy="0" r="5" fill="#163969"/>
                        <circle cx="0" cy="-1.5" r="2" fill="#1ea69c"/>
                        <line x1="0" y1="9" x2="0" y2="22" stroke="#d4af37" stroke-width="2.5"/>
                        <circle cx="0" cy="24" r="5" fill="#d4af37" stroke="#9e7e17" stroke-width="1"/>
                        <circle cx="0" cy="24" r="2.5" fill="#1ea69c"/>
                        <line x1="0" y1="29" x2="0" y2="44" stroke="#d4af37" stroke-width="2.5"/>
                        <circle cx="0" cy="46" r="4.5" fill="#d4af37" stroke="#9e7e17" stroke-width="1"/>
                        <circle cx="0" cy="46" r="2" fill="{{ $accentColor }}"/>
                        <line x1="0" y1="50" x2="0" y2="62" stroke="#d4af37" stroke-width="2"/>
                        <polygon points="-7,62 7,62 4,78 0,82 -4,78" fill="#d4af37" stroke="#9e7e17" stroke-width="0.8"/>
                        <circle cx="0" cy="72" r="3" fill="{{ $accentColor }}"/>
                    </g>
                    <!-- Multi-Tier Drop Earrings Right -->
                    <g transform="translate(462, 376)">
                        <circle cx="0" cy="0" r="9" fill="#d4af37" stroke="#9e7e17" stroke-width="1.2"/>
                        <circle cx="0" cy="0" r="5" fill="#163969"/>
                        <circle cx="0" cy="-1.5" r="2" fill="#1ea69c"/>
                        <line x1="0" y1="9" x2="0" y2="22" stroke="#d4af37" stroke-width="2.5"/>
                        <circle cx="0" cy="24" r="5" fill="#d4af37" stroke="#9e7e17" stroke-width="1"/>
                        <circle cx="0" cy="24" r="2.5" fill="#1ea69c"/>
                        <line x1="0" y1="29" x2="0" y2="44" stroke="#d4af37" stroke-width="2.5"/>
                        <circle cx="0" cy="46" r="4.5" fill="#d4af37" stroke="#9e7e17" stroke-width="1"/>
                        <circle cx="0" cy="46" r="2" fill="{{ $accentColor }}"/>
                        <line x1="0" y1="50" x2="0" y2="62" stroke="#d4af37" stroke-width="2"/>
                        <polygon points="-7,62 7,62 4,78 0,82 -4,78" fill="#d4af37" stroke="#9e7e17" stroke-width="0.8"/>
                        <circle cx="0" cy="72" r="3" fill="{{ $accentColor }}"/>
                    </g>

                    <!-- Face: warm olive-copper skin, refined oval -->
                    <path fill="#dfa07a" d="M320 172 C402 172 430 230 431 300 C432 360 410 420 380 464 C362 490 348 506 336 509 C328 511 312 511 304 509 C292 506 278 490 260 464 C230 420 208 360 209 300 C210 230 238 172 320 172 Z"/>
                    <!-- Center face lighter highlight -->
                    <ellipse fill="#ebb492" cx="320" cy="330" rx="78" ry="128" opacity="0.36"/>
                    <!-- Cheekbone warmth -->
                    <ellipse fill="#e8a070" cx="266" cy="318" rx="22" ry="28" opacity="0.2"/>
                    <ellipse fill="#e8a070" cx="374" cy="318" rx="22" ry="28" opacity="0.2"/>
                    <!-- Jawline shadow depth -->
                    <path fill="#b07050" opacity="0.18" d="M213 300 C210 362 228 418 262 462 C270 473 282 490 304 509 C290 501 274 484 256 458 C228 416 208 356 208 300 Z"/>
                    <path fill="#b07050" opacity="0.18" d="M427 300 C430 362 412 418 378 462 C370 473 358 490 336 509 C350 501 366 484 384 458 C412 416 432 356 432 300 Z"/>
                    <ellipse fill="#b07050" cx="320" cy="507" rx="28" ry="11" opacity="0.22"/>

                    <!-- Cheek blush -->
                    <ellipse id="ncBlushL" fill="{{ $discColor }}" cx="250" cy="396" rx="32" ry="18" opacity="0.28"/>
                    <ellipse id="ncBlushR" fill="{{ $discColor }}" cx="390" cy="396" rx="32" ry="18" opacity="0.28"/>

                    <!-- Royal Kohl Eyebrows — thick bold arched pharaonic brows -->
                    <g id="ncBrows">
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="9" d="M224 285 C245 266 272 261 296 275"/>
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="5" d="M212 294 C216 290 220 287 224 284"/>
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="9" d="M344 275 C368 261 395 266 416 285"/>
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="5" d="M428 294 C424 290 420 287 416 284"/>
                    </g>

                    <!-- LEFT EYE: Cleopatra almond kohl + Eye of Horus -->
                    <g id="ncEyeL">
                        <!-- Turquoise eyeshadow sweep -->
                        <path fill="#1a8e86" opacity="0.82" d="M224 316 Q262 278 300 316 Q262 292 224 316 Z"/>
                        <!-- Gold shimmer crease -->
                        <path stroke="#f0c030" stroke-width="3" fill="none" opacity="0.9" d="M232 304 Q262 289 292 304"/>
                        <!-- Under-lid shadow depth -->
                        <path fill="#0e0a0c" opacity="0.3" d="M232 322 Q262 338 292 322 Q262 330 232 322 Z"/>
                        <!-- Sclera -->
                        <path fill="#fefcf8" d="M232 319 Q262 297 292 319 Q262 339 232 319 Z"/>
                        <g clip-path="url(#ncCeL)">
                            <g id="ncPupilL">
                                <circle fill="#5c3a1e" cx="262" cy="320" r="12"/>
                                <circle fill="#0e0a0c" cx="262" cy="320" r="6.5"/>
                                <circle fill="#ffffff" cx="265" cy="315.5" r="3.5"/>
                                <circle fill="#ffffff" cx="258.5" cy="323.5" r="1.5" opacity="0.55"/>
                                <circle fill="none" stroke="#c9a224" stroke-width="1.5" cx="262" cy="320" r="9.5" opacity="0.5"/>
                            </g>
                        </g>
                        <!-- Bold upper kohl lid -->
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="8" d="M232 319 Q262 296 292 319"/>
                        <!-- Long dramatic Cleopatra wing LEFT -->
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="8" d="M172 303 Q186 312 232 319"/>
                        <!-- Inner right corner tick -->
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="5.5" d="M292 319 L304 327"/>
                        <!-- Bold lower kohl lid -->
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="5.5" d="M232 319 Q262 338 292 319"/>
                        <!-- Eye of Horus horizontal lower extension -->
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="6" d="M232 322 L178 322"/>
                        <!-- Eye of Horus vertical drop accent -->
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="4" d="M200 322 L197 336"/>
                        <!-- Under-eye smudge -->
                        <path stroke="#1e1418" fill="none" stroke-linecap="round" stroke-width="3" opacity="0.42" d="M236 329 Q262 338 288 329"/>
                    </g>

                    <!-- RIGHT EYE: Cleopatra almond kohl + Eye of Horus -->
                    <g id="ncEyeR">
                        <path fill="#1a8e86" opacity="0.82" d="M340 316 Q378 278 416 316 Q378 292 340 316 Z"/>
                        <path stroke="#f0c030" stroke-width="3" fill="none" opacity="0.9" d="M348 304 Q378 289 408 304"/>
                        <path fill="#0e0a0c" opacity="0.3" d="M348 322 Q378 338 408 322 Q378 330 348 322 Z"/>
                        <path fill="#fefcf8" d="M348 319 Q378 297 408 319 Q378 339 348 319 Z"/>
                        <g clip-path="url(#ncCeR)">
                            <g id="ncPupilR">
                                <circle fill="#5c3a1e" cx="378" cy="320" r="12"/>
                                <circle fill="#0e0a0c" cx="378" cy="320" r="6.5"/>
                                <circle fill="#ffffff" cx="381" cy="315.5" r="3.5"/>
                                <circle fill="#ffffff" cx="374.5" cy="323.5" r="1.5" opacity="0.55"/>
                                <circle fill="none" stroke="#c9a224" stroke-width="1.5" cx="378" cy="320" r="9.5" opacity="0.5"/>
                            </g>
                        </g>
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="8" d="M348 319 Q378 296 408 319"/>
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="8" d="M468 303 Q454 312 408 319"/>
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="5.5" d="M348 319 L336 327"/>
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="5.5" d="M348 319 Q378 338 408 319"/>
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="6" d="M408 322 L462 322"/>
                        <path stroke="#0e0a0c" fill="none" stroke-linecap="round" stroke-width="4" d="M440 322 L443 336"/>
                        <path stroke="#1e1418" fill="none" stroke-linecap="round" stroke-width="3" opacity="0.42" d="M352 329 Q378 338 404 329"/>
                    </g>

                    <!-- Sculpted straight Egyptian nose -->
                    <path stroke="#9a5030" fill="none" stroke-linecap="round" stroke-width="2.5" d="M320 346 C320 360 319 372 318 382" opacity="0.52"/>
                    <path stroke="#9a5030" fill="none" stroke-linecap="round" stroke-width="3.5" d="M307 384 C303 389 306 394 313 395" opacity="0.62"/>
                    <path stroke="#9a5030" fill="none" stroke-linecap="round" stroke-width="3.5" d="M333 384 C337 389 334 394 327 395" opacity="0.62"/>
                    <ellipse fill="#9a5030" cx="320" cy="393" rx="8" ry="4" opacity="0.1"/>
                    <path stroke="#b07050" stroke-width="2" fill="none" stroke-linecap="round" d="M316 413 C318 419 320 421 322 419 C324 417 326 413 328 413" opacity="0.3"/>

                    <!-- Royal Lips: full Cupid bow lush -->
                    <path id="ncLips" fill="{{ $accentColor }}" d="M280 447 C292 436 308 436 320 442 C332 436 348 436 360 447 C352 460 340 468 320 470 C300 468 288 460 280 447 Z"/>
                    <path fill="#ffffff" opacity="0.22" d="M297 440 C305 435 315 436 320 441 C315 437 307 436 297 440 Z"/>
                    <path fill="#ffffff" opacity="0.18" d="M303 458 C311 465 330 465 337 458 C330 467 311 467 303 458 Z"/>
                    <path stroke="#7a0038" fill="none" stroke-linecap="round" stroke-width="1.5" d="M280 447 C292 436 308 436 320 442 C332 436 348 436 360 447" opacity="0.62"/>

                    <!-- Beauty mark -->
                    <circle cx="386" cy="428" r="3.2" fill="#18100e" opacity="0.88"/>

                    <!-- Front Hair: Pharaonic Bob with Silk Sheen -->
                    <g id="ncHairFront">
                        <path fill="#181016" d="M208 266 C208 178 238 86 320 86 C402 86 432 178 432 266 L320 269 Z"/>
                        <path stroke="#0a0608" stroke-width="4" fill="none" d="M208 266 Q320 272 432 266"/>
                        <!-- Silk sheen center glow -->
                        <path stroke="#3a2a34" stroke-width="7" fill="none" stroke-linecap="round" d="M268 102 C294 89 346 89 372 102" opacity="0.58"/>
                        <path stroke="#4a3844" stroke-width="3.5" fill="none" stroke-linecap="round" d="M298 89 L320 85 L342 89" opacity="0.42"/>
                        <!-- Left framing tress -->
                        <path fill="#181016" d="M206 252 C200 324 198 406 200 466 C202 497 212 509 224 509 C236 509 237 497 234 466 C232 406 230 324 226 252 Z"/>
                        <path stroke="#30202a" stroke-width="4" fill="none" stroke-linecap="round" d="M218 262 C214 338 214 420 216 502"/>
                        <!-- Right framing tress -->
                        <path fill="#181016" d="M434 252 C440 324 442 406 440 466 C438 497 428 509 416 509 C404 509 403 497 406 466 C408 406 410 324 414 252 Z"/>
                        <path stroke="#30202a" stroke-width="4" fill="none" stroke-linecap="round" d="M422 262 C426 338 426 420 424 502"/>
                        <!-- Golden Hair Rings (3 per side) -->
                        <g fill="#d4af37" stroke="#9e7e17" stroke-width="0.9">
                            <rect x="200" y="336" width="32" height="12" rx="4"/>
                            <rect x="202" y="339" width="14" height="6" rx="2" fill="#163969" stroke="none"/>
                            <circle cx="221" cy="342" r="3.2" fill="#1ea69c" stroke="none"/>
                            <rect x="200" y="416" width="32" height="12" rx="4"/>
                            <rect x="202" y="419" width="14" height="6" rx="2" fill="#163969" stroke="none"/>
                            <circle cx="221" cy="422" r="3.2" fill="{{ $accentColor }}" stroke="none"/>
                            <rect x="201" y="484" width="30" height="12" rx="4"/>
                            <rect x="203" y="487" width="13" height="6" rx="2" fill="#163969" stroke="none"/>
                            <circle cx="219" cy="490" r="3.2" fill="#1ea69c" stroke="none"/>
                            <rect x="408" y="336" width="32" height="12" rx="4"/>
                            <rect x="410" y="339" width="14" height="6" rx="2" fill="#163969" stroke="none"/>
                            <circle cx="419" cy="342" r="3.2" fill="#1ea69c" stroke="none"/>
                            <rect x="408" y="416" width="32" height="12" rx="4"/>
                            <rect x="410" y="419" width="14" height="6" rx="2" fill="#163969" stroke="none"/>
                            <circle cx="419" cy="422" r="3.2" fill="{{ $accentColor }}" stroke="none"/>
                            <rect x="409" y="484" width="30" height="12" rx="4"/>
                            <rect x="411" y="487" width="13" height="6" rx="2" fill="#163969" stroke="none"/>
                            <circle cx="421" cy="490" r="3.2" fill="#1ea69c" stroke="none"/>
                        </g>
                    </g>

                    <!-- Royal Golden Diadem + Sacred Uraeus Cobra Crown -->
                    <g id="ncCrown">
                        <!-- Diadem band -->
                        <path fill="#c9a224" stroke="#9e7e17" stroke-width="1.5" d="M205 230 Q320 243 435 230 L433 250 Q320 263 207 250 Z"/>
                        <path fill="#f5ce4a" stroke="none" d="M207 230 Q320 238 433 230 Q320 233 207 230 Z"/>
                        <g fill="#163969">
                            <rect x="224" y="236" width="10" height="8" rx="2"/>
                            <rect x="262" y="240" width="10" height="8" rx="2"/>
                            <rect x="368" y="240" width="10" height="8" rx="2"/>
                            <rect x="406" y="236" width="10" height="8" rx="2"/>
                        </g>
                        <g fill="#1ea69c">
                            <circle cx="246" cy="242" r="4.5"/>
                            <circle cx="284" cy="246" r="4.5"/>
                            <circle cx="356" cy="246" r="4.5"/>
                            <circle cx="394" cy="242" r="4.5"/>
                        </g>
                        <!-- Center diadem medallion -->
                        <circle cx="320" cy="248" r="14" fill="#c9a224" stroke="#9e7e17" stroke-width="1.5"/>
                        <circle cx="320" cy="248" r="9" fill="{{ $accentColor }}"/>
                        <circle cx="320" cy="248" r="4.5" fill="#fae17d"/>
                        <circle cx="320" cy="248" r="2" fill="#c9a224"/>
                        <!-- Royal Sacred Lotus Diadem Ornament -->
                        <g id="ncLotusOrnament" transform="translate(263.9, 136) scale(0.145)">
                            <path d="M0 0 C20.558 11.55 32.434 36.499 43.188 56.312 C43.65 57.152 44.112 57.992 44.588 58.856 C53.764 75.546 61.456 92.923 69.188 110.312 C69.59 111.218 69.993 112.123 70.408 113.056 C75.076 123.556 79.729 134.063 84.363 144.578 C84.721 145.388 85.079 146.198 85.447 147.033 C87.092 150.769 88.706 154.507 90.188 158.312 C95.069 155.61 99.319 152.193 103.688 148.75 C105.312 147.478 106.937 146.205 108.562 144.934 C109.355 144.312 110.148 143.691 110.965 143.05 C113.859 140.787 116.771 138.548 119.688 136.312 C124.871 132.334 130.032 128.327 135.188 124.312 C141.37 119.498 147.567 114.705 153.785 109.938 C156.367 107.952 158.933 105.948 161.496 103.938 C168.612 98.36 175.739 92.804 183.062 87.5 C183.345 87.293 183.345 87.293 184.773 86.244 C191.931 81.131 199.689 81.705 208.188 82.312 C214.646 83.741 218.261 86.863 221.996 92.215 C224.655 96.897 225.482 100.836 225.748 106.216 C225.784 106.899 225.82 107.582 225.857 108.286 C225.974 110.571 226.079 112.856 226.184 115.141 C226.265 116.781 226.347 118.422 226.429 120.063 C226.697 125.479 226.944 130.895 227.188 136.312 C227.23 137.25 227.272 138.187 227.316 139.152 C228.084 156.22 228.8 173.29 229.513 190.359 C229.727 195.473 229.943 200.586 230.162 205.699 C230.282 208.537 230.399 211.376 230.516 214.215 C230.59 215.954 230.664 217.693 230.739 219.433 C230.769 220.202 230.8 220.972 230.831 221.765 C231.06 226.983 231.567 232.126 232.188 237.312 C233.009 237.001 233.831 236.69 234.677 236.37 C338.672 197.212 338.672 197.212 371.461 210.441 C375.668 212.564 377.73 214.476 380 218.625 C382.291 225.74 380.828 231.823 378.938 238.812 C378.678 239.785 378.418 240.757 378.151 241.758 C357.285 318.29 327.467 396.204 274.188 456.312 C273.353 457.257 272.519 458.202 271.66 459.176 C260.379 471.713 248.613 484.064 235.188 494.312 C233.88 495.336 232.572 496.361 231.266 497.387 C183.873 534.364 129.431 553.796 71.188 566.312 C71.575 566.519 71.575 566.519 73.536 567.562 C80.973 571.525 88.401 575.504 95.82 579.501 C97.787 580.559 99.755 581.614 101.727 582.663 C114.207 589.306 124.542 596.833 129.992 610.301 C134.629 625.64 128.536 640.908 121.383 654.363 C115.16 665.703 107.887 675.746 99.188 685.312 C98.409 686.175 97.63 687.037 96.828 687.926 C72.871 713.129 37.466 728.559 2.762 729.516 C-37.274 730.048 -74.824 718.004 -104.523 690.391 C-106.101 688.958 -107.733 687.582 -109.402 686.258 C-125.955 672.897 -137.526 650.021 -141.562 629.5 C-142.376 619.126 -141.618 608.72 -134.812 600.312 C-134.111 599.343 -133.41 598.374 -132.688 597.375 C-124.976 588.465 -113.303 583.908 -102.875 579 C-100.618 577.929 -98.362 576.855 -96.108 575.779 C-94.716 575.116 -93.322 574.456 -91.927 573.799 C-89.07 572.445 -86.449 571.07 -83.812 569.312 C-84.086 569.225 -84.086 569.225 -85.473 568.784 C-91.185 566.965 -96.895 565.137 -102.603 563.302 C-106.224 562.14 -109.846 560.983 -113.471 559.835 C-204.971 530.834 -272.922 487.561 -340.605 374.145 C-361.022 334.646 -376.159 292.873 -388.812 250.312 C-389.191 249.053 -389.569 247.794 -389.958 246.496 C-390.322 245.264 -390.685 244.031 -391.059 242.762 C-391.384 241.662 -391.709 240.562 -392.045 239.428 C-393.897 231.91 -393.63 225.179 -390.059 218.246 C-385.765 211.583 -379.166 209.374 -371.812 207.312 C-367.938 206.76 -364.159 206.692 -360.25 206.75 C-359.711 206.755 -359.711 206.755 -356.986 206.783 C-318.26 207.792 -279.439 224.436 -243.812 238.312 C-243.827 238.025 -243.827 238.025 -243.9 236.571 C-244.741 219.462 -245.053 202.378 -245.062 185.25 C-245.064 183.957 -245.065 182.663 -245.066 181.331 C-245.025 103.855 -245.025 103.855 -227.289 84.664 C-223.881 81.379 -220.879 79.333 -215.957 79.084 C-207.173 80.02 -200.221 85.611 -193.562 90.938 C-191.704 92.39 -189.845 93.84 -187.984 95.289 C-187.093 95.987 -186.202 96.684 -185.283 97.403 C-182.184 99.798 -179.02 102.064 -175.812 104.312 C-168.91 109.156 -162.242 114.3 -155.551 119.43 C-150.695 123.143 -145.816 126.8 -140.812 130.312 C-133.897 135.179 -127.205 140.324 -120.533 145.518 C-114.511 150.162 -108.29 154.33 -101.812 158.312 C-101.601 157.12 -101.39 155.928 -101.172 154.699 C-99.643 147.863 -96.806 141.545 -94.062 135.125 C-93.779 134.455 -93.495 133.784 -93.202 133.093 C-86.801 117.981 -79.925 103.101 -72.812 88.312 C-72.325 87.298 -71.838 86.284 -71.336 85.239 C-64.862 71.837 -57.781 58.83 -50.332 45.946 C-48.939 43.531 -47.561 41.109 -46.188 38.684 C-19.392 -8.243 -19.392 -8.243 0 0 Z " fill="{{ $accentColor }}" transform="translate(392.8125,1.6875)"/>
                            <path d="M0 0 C4.021 1.34 4.819 3.779 6.668 7.34 C7.02 8 7.371 8.661 7.734 9.341 C8.897 11.534 10.043 13.735 11.188 15.938 C11.585 16.696 11.982 17.454 12.391 18.236 C51.232 92.437 80.703 171.635 66 304 C65.796 304.819 65.593 305.638 65.383 306.481 C54.458 350.352 33.956 391.807 10.438 430.188 C10.088 430.76 9.738 431.332 9.378 431.922 C8.381 433.549 7.376 435.171 6.371 436.793 C5.793 437.726 5.215 438.66 4.619 439.622 C3.214 441.686 1.838 443.326 0 445 C-4.134 438.958 -7.958 432.808 -11.562 426.438 C-11.819 425.985 -11.819 425.985 -13.115 423.695 C-14.749 420.8 -16.375 417.9 -18 415 C-18.531 414.062 -19.062 413.123 -19.608 412.157 C-35.923 383.241 -48.415 352.959 -58.375 321.312 C-58.587 320.643 -58.798 319.973 -59.016 319.282 C-64.536 301.721 -67.519 284.203 -70 266 C-70.123 265.151 -70.246 264.302 -70.373 263.428 C-75.793 225.479 -71.61 186.06 -63 149 C-62.786 148.059 -62.572 147.119 -62.351 146.15 C-58.727 130.346 -54.203 114.644 -48.07 99.622 C-46.92 96.803 -45.807 93.971 -44.695 91.137 C-35.76 68.601 -25.154 46.973 -14.062 25.438 C-13.46 24.267 -12.858 23.097 -12.237 21.891 C-8.373 14.456 -4.29 7.198 0 0 Z " fill="#f075a7" transform="translate(386,68)"/>
                            <path d="M0 0 C1.746 1.107 3.491 2.214 5.236 3.322 C6.207 3.938 7.179 4.555 8.181 5.19 C20.092 12.836 31.296 21.368 42.142 30.45 C43.851 31.876 45.575 33.28 47.305 34.68 C50.967 37.681 54.5 40.811 58 44 C58.946 44.86 59.892 45.721 60.866 46.607 C63.554 49.07 66.202 51.572 68.832 54.096 C69.894 55.108 70.966 56.11 72.047 57.102 C80.55 64.934 80.55 64.934 81.518 69.376 C81.289 72.036 80.686 74.42 80 77 C79.704 78.853 79.409 80.707 79.139 82.564 C78.84 84.618 78.516 86.667 78.184 88.717 C78.071 89.412 77.959 90.106 77.843 90.822 C77.615 92.231 77.386 93.639 77.157 95.048 C76.82 97.124 76.488 99.2 76.156 101.277 C75.958 102.497 75.761 103.716 75.557 104.972 C74.285 113.635 73.831 122.288 73.762 131.035 C73.752 132.06 73.742 133.086 73.733 134.142 C73.708 137.449 73.695 140.756 73.688 144.062 C73.686 144.627 73.686 144.627 73.678 147.482 C73.652 174.743 76.499 200.733 82.875 227.25 C83.119 228.28 83.362 229.31 83.613 230.371 C86.675 243.14 90.418 255.668 94.562 268.125 C94.774 268.76 94.985 269.394 95.202 270.048 C98.465 279.82 101.986 289.472 105.75 299.062 C106.185 300.172 106.62 301.281 107.069 302.424 C109.783 309.23 112.754 315.833 115.97 322.416 C116.31 323.269 116.65 324.121 117 325 C116.67 325.66 116.34 326.32 116 327 C80.881 297.093 80.881 297.093 67 279 C65.975 277.702 64.949 276.406 63.922 275.109 C56.594 265.783 50.001 256.227 44 246 C43.796 245.657 43.796 245.657 42.763 243.921 C30.5 223.184 21.974 201.012 15 178 C14.799 177.339 14.598 176.679 14.392 175.998 C11.043 164.856 8.633 153.699 6.742 142.224 C6.314 139.631 5.868 137.042 5.42 134.453 C3.971 125.94 2.731 117.428 1.855 108.836 C1.781 108.113 1.707 107.389 1.63 106.644 C0.209 91.614 -0.145 76.609 -0.098 61.523 C-0.096 59.733 -0.094 57.943 -0.093 56.152 C-0.09 51.507 -0.08 46.861 -0.069 42.216 C-0.058 37.448 -0.054 32.681 -0.049 27.914 C-0.038 18.609 -0.021 9.305 0 0 Z " fill="#f077ab" transform="translate(195,146)"/>
                            <path d="M0 0 C16.211 0.7 31.724 5.91 47 11 C47.432 11.142 47.432 11.142 49.615 11.858 C55.349 13.748 61.025 15.764 66.693 17.844 C69.697 18.894 72.72 19.838 75.766 20.757 C96.518 27.123 96.518 27.123 100.601 33.5 C102.622 39.15 102.724 44.68 102.784 50.618 C103.623 63.734 108.2 76.674 112.5 89 C112.759 89.749 113.018 90.499 113.285 91.271 C123.283 120.058 136.961 147.382 155 172 C155.494 172.676 155.988 173.353 156.497 174.05 C164.946 185.574 173.742 196.695 183.445 207.199 C184.782 208.665 186.114 210.135 187.399 211.646 C193.28 218.554 199.754 224.864 206.188 231.25 C207.375 232.432 208.561 233.614 209.748 234.797 C211.921 236.961 214.095 239.125 216.27 241.286 C218.517 243.52 220.761 245.758 223 248 C189.252 245.546 157.033 228.258 130 209 C129.244 208.462 128.488 207.923 127.709 207.369 C118.948 201.075 110.87 194.38 103 187 C101.631 185.806 100.256 184.618 98.875 183.438 C97.579 182.296 96.288 181.15 95 180 C94.67 179.709 94.67 179.709 93 178.238 C47.864 136.006 21.682 65.626 2.457 8.461 C2.208 7.721 1.958 6.98 1.701 6.217 C0 1.122 0 1.122 0 0 Z " fill="#f077ab" transform="translate(58,261)"/>
                            <path d="M0 0 C-0.334 4.515 -0.967 8.255 -2.727 12.434 C-4.373 16.435 -5.937 20.456 -7.445 24.512 C-28.552 81.116 -56.561 150.239 -104 190 C-105.006 190.888 -106.01 191.779 -107.012 192.672 C-137.184 219.371 -179.279 243.539 -220 248 C-220.66 247.67 -221.32 247.34 -222 247 C-218.179 243.088 -214.35 239.238 -210.188 235.688 C-202.912 229.415 -196.152 222.514 -189.926 215.203 C-187.935 212.926 -185.873 210.725 -183.799 208.524 C-177.61 201.935 -171.934 195.08 -166.454 187.895 C-164.92 185.896 -163.366 183.914 -161.809 181.934 C-145.454 161.027 -131.771 138.266 -121 114 C-120.469 112.835 -119.938 111.669 -119.391 110.469 C-113.617 97.492 -109.402 84.118 -105.875 70.375 C-105.746 69.875 -105.746 69.875 -105.092 67.342 C-103.785 62.039 -102.8 56.849 -102.227 51.414 C-100.401 34.618 -100.401 34.618 -96.133 30.965 C-93.234 29.075 -90.166 27.837 -86.907 26.704 C-83.808 25.56 -80.97 23.933 -78.062 22.375 C-70.858 18.845 -63.536 15.741 -56 13 C-55.341 12.759 -54.681 12.519 -54.002 12.271 C-42.927 8.317 -31.593 5.644 -20.125 3.125 C-19.413 2.968 -18.702 2.81 -17.968 2.648 C-15.92 2.198 -13.871 1.758 -11.82 1.32 C-10.627 1.065 -9.433 0.81 -8.204 0.547 C-5.382 0.065 -2.852 -0.113 0 0 Z " fill="#f079ad" transform="translate(715,261)"/>
                            <path d="M0 0 C1.907 17.693 2.325 35.213 2.25 53 C2.246 54.363 2.242 55.727 2.239 57.09 C2 135.805 -11.211 216.268 -64 278 C-64.959 279.144 -65.917 280.289 -66.875 281.434 C-79.807 296.81 -94.41 309.426 -110 322 C-110.66 321.67 -111.32 321.34 -112 321 C-111.694 320.339 -111.388 319.678 -111.073 318.998 C-102.768 300.953 -95.531 282.754 -89 264 C-88.847 263.568 -88.847 263.568 -88.072 261.381 C-80.08 238.663 -74.344 213.961 -72 190 C-71.9 189.006 -71.8 188.012 -71.697 186.988 C-69.957 168.992 -69.653 151.069 -70 133 C-70.014 132.147 -70.028 131.294 -70.042 130.415 C-70.26 120.079 -71.549 109.868 -72.875 99.625 C-72.956 98.995 -72.956 98.995 -73.364 95.805 C-74.161 89.937 -75.117 84.251 -76.633 78.523 C-78.768 70.205 -78.768 70.205 -78 66 C-75.996 63.746 -74.297 62.169 -71.938 60.375 C-70.642 59.33 -69.348 58.285 -68.055 57.238 C-67.383 56.705 -66.711 56.173 -66.019 55.624 C-62.789 53.026 -59.681 50.292 -56.562 47.562 C-55.305 46.471 -54.047 45.38 -52.789 44.289 C-51.526 43.193 -50.263 42.096 -49 41 C-41.117 34.156 -33.226 27.323 -25.291 20.539 C-22.16 17.86 -19.039 15.169 -15.93 12.465 C-15.253 11.876 -14.576 11.288 -13.879 10.682 C-12.576 9.547 -11.274 8.412 -9.973 7.275 C-1.614 0 -1.614 0 0 0 Z " fill="#f073a8" transform="translate(576,148)"/>
                        </g>
                    </g>
                </g>
            </svg>
        </div>
    </div>

    <!-- Consultation Modal -->
    <div
        id="ncHeroModal"
        dir="{{ $isAr ? 'rtl' : 'ltr' }}"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-[#2e2224]/40 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300"
        aria-hidden="true"
    >
        <div class="nc-modal-card w-full max-w-lg bg-[#fbf8f1] border border-[#2e2224]/30 rounded-2xl p-8 sm:p-10 relative transform translate-y-8 transition-transform duration-400 shadow-2xl {{ $isAr ? 'text-right' : 'text-left' }}">
            <button
                type="button"
                id="ncHeroModalClose"
                class="absolute top-5 w-10 h-10 rounded-full border border-[#2e2224]/30 flex items-center justify-center hover:bg-[#2e2224] hover:text-[#fbf8f1] transition-all cursor-pointer {{ $isAr ? 'left-5' : 'right-5' }}"
                style="{{ $isAr ? 'left: 1.25rem; right: auto;' : 'right: 1.25rem; left: auto;' }}"
                aria-label="{{ trans('nc::app.header.close') }}"
            >
                <svg class="w-4 h-4" viewBox="0 0 14 14" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M2 2l10 10M12 2 2 12"/>
                </svg>
            </button>

            <div id="ncFormWrap">
                <h3 class="font-serif text-3xl font-bold leading-tight mb-3 text-[#2e2224]">{!! nl2br(e($modalTitle)) !!}</h3>
                <p class="text-sm text-[#2e2224]/75 mb-6 leading-relaxed">{{ $modalSubtitle }}</p>

                <form id="ncHeroEnquiryForm" class="space-y-5" novalidate>
                    <div>
                        <label class="block text-xs uppercase tracking-wider text-[#2e2224]/70 mb-1.5 font-medium">
                            {{ trans('nc::app.sections.interactive_hero.modal_name_label') }}
                        </label>
                        <input
                            type="text"
                            id="ncEnquiryName"
                            required
                            class="w-full bg-transparent border-b border-[#2e2224]/40 focus:border-[#bd1765] py-2 text-base text-[#2e2224] outline-none transition-colors"
                        />
                        <span class="text-xs text-red-600 hidden mt-1" id="ncNameErr">
                            {{ trans('nc::app.sections.interactive_hero.modal_name_error') }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider text-[#2e2224]/70 mb-1.5 font-medium">
                            {{ trans('nc::app.sections.interactive_hero.modal_contact_label') }}
                        </label>
                        <input
                            type="text"
                            id="ncEnquiryContact"
                            required
                            class="w-full bg-transparent border-b border-[#2e2224]/40 focus:border-[#bd1765] py-2 text-base text-[#2e2224] outline-none transition-colors"
                        />
                        <span class="text-xs text-red-600 hidden mt-1" id="ncContactErr">
                            {{ trans('nc::app.sections.interactive_hero.modal_contact_error') }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider text-[#2e2224]/70 mb-1.5 font-medium">
                            {{ trans('nc::app.sections.interactive_hero.modal_msg_label') }}
                        </label>
                        <textarea
                            id="ncEnquiryMsg"
                            rows="3"
                            class="w-full bg-transparent border-b border-[#2e2224]/40 focus:border-[#bd1765] py-2 text-base text-[#2e2224] outline-none transition-colors resize-none"
                        ></textarea>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-4 rounded-full uppercase tracking-widest text-xs font-semibold cursor-pointer transition-all duration-300 mt-4"
                        style="background-color: var(--accent-magenta); color: #ffffff;"
                    >
                        {{ trans('nc::app.sections.interactive_hero.modal_submit') }}
                    </button>
                </form>
            </div>

            <div id="ncSuccessWrap" class="hidden text-center py-8">
                <div class="w-14 h-14 rounded-full mx-auto mb-4 flex items-center justify-center border-2" style="border-color: var(--accent-magenta); color: var(--accent-magenta);">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h4 class="font-serif text-2xl font-bold text-[#2e2224] mb-2">
                    {{ trans('nc::app.sections.interactive_hero.modal_success_title') }}
                </h4>
                <p class="text-sm text-[#2e2224]/75">
                    {{ trans('nc::app.sections.interactive_hero.modal_success_desc') }}
                </p>
            </div>
        </div>
    </div>
</section>

@pushOnce('styles')
<style>
    .nc-interactive-hero[dir="ltr"] .nc-hero-inner,
    [dir="ltr"] .nc-interactive-hero .nc-hero-inner {
        text-align: left;
    }
    .nc-interactive-hero[dir="ltr"] .nc-hero-copy,
    [dir="ltr"] .nc-interactive-hero .nc-hero-copy {
        text-align: left;
        margin-right: auto !important;
        margin-left: 0 !important;
        align-self: flex-start !important;
    }
    .nc-interactive-hero[dir="ltr"] .nc-hero-figure,
    [dir="ltr"] .nc-interactive-hero .nc-hero-figure {
        position: absolute;
        left: auto !important;
        right: 0 !important;
        bottom: 0 !important;
    }
    @media (min-width: 1024px) {
        .nc-interactive-hero[dir="ltr"] .nc-hero-figure,
        [dir="ltr"] .nc-interactive-hero .nc-hero-figure {
            right: 1.5rem !important;
            left: auto !important;
        }
    }
    .nc-interactive-hero[dir="ltr"] .nc-hero-hint,
    [dir="ltr"] .nc-interactive-hero .nc-hero-hint {
        left: 4% !important;
        right: auto !important;
        text-align: left;
    }

    .nc-interactive-hero[dir="rtl"] .nc-hero-inner,
    [dir="rtl"] .nc-interactive-hero .nc-hero-inner {
        text-align: right;
    }
    .nc-interactive-hero[dir="rtl"] .nc-hero-copy,
    [dir="rtl"] .nc-interactive-hero .nc-hero-copy {
        text-align: right;
        margin-left: auto !important;
        margin-right: 0 !important;
        align-self: flex-start !important;
    }
    .nc-interactive-hero[dir="rtl"] .nc-hero-figure,
    [dir="rtl"] .nc-interactive-hero .nc-hero-figure {
        position: absolute;
        left: 0 !important;
        right: auto !important;
        bottom: 0 !important;
    }
    @media (min-width: 1024px) {
        .nc-interactive-hero[dir="rtl"] .nc-hero-figure,
        [dir="rtl"] .nc-interactive-hero .nc-hero-figure {
            left: 1.5rem !important;
            right: auto !important;
        }
    }
    .nc-interactive-hero[dir="rtl"] .nc-hero-hint,
    [dir="rtl"] .nc-interactive-hero .nc-hero-hint {
        left: auto !important;
        right: 4% !important;
        text-align: right;
    }

    .nc-interactive-hero[dir="rtl"] .nc-hero-title,
    [dir="rtl"] .nc-interactive-hero .nc-hero-title {
        line-height: 1.25 !important;
        letter-spacing: normal !important;
    }
    .nc-interactive-hero[dir="rtl"] .nc-hero-title > span,
    [dir="rtl"] .nc-interactive-hero .nc-hero-title > span {
        padding-top: 0.12em !important;
        padding-bottom: 0.15em !important;
    }
    .nc-interactive-hero[dir="rtl"] .nc-hero-eyebrow,
    [dir="rtl"] .nc-interactive-hero .nc-hero-eyebrow {
        letter-spacing: normal !important;
    }

    .nc-interactive-hero[dir="ltr"] #ncHeroModalClose,
    [dir="ltr"] #ncHeroModalClose {
        right: 1.25rem !important;
        left: auto !important;
    }
    .nc-interactive-hero[dir="rtl"] #ncHeroModalClose,
    [dir="rtl"] #ncHeroModalClose {
        left: 1.25rem !important;
        right: auto !important;
    }

    @keyframes ncHeroFadeUp {
        0% {
            opacity: 0;
            transform: translateY(1.5rem);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes ncHeroTitleRise {
        0% {
            opacity: 0;
            transform: translateY(100%);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .nc-interactive-hero .nc-hero-eyebrow {
        animation: ncHeroFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .nc-interactive-hero .nc-rise-1 {
        animation: ncHeroTitleRise 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.05s both;
    }

    .nc-interactive-hero .nc-rise-2 {
        animation: ncHeroTitleRise 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.18s both;
    }

    .nc-interactive-hero .nc-rise-3 {
        animation: ncHeroTitleRise 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.30s both;
    }

    .nc-interactive-hero .nc-hero-sub {
        animation: ncHeroFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.40s both;
    }

    .nc-interactive-hero .nc-hero-ctas {
        animation: ncHeroFadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.50s both;
    }

    .nc-interactive-hero .nc-hero-figure {
        animation: ncHeroFadeUp 1s cubic-bezier(0.16, 1, 0.3, 1) 0.25s both;
    }

    @media (prefers-reduced-motion: reduce) {
        .nc-interactive-hero .nc-hero-eyebrow,
        .nc-interactive-hero .nc-rise-1,
        .nc-interactive-hero .nc-rise-2,
        .nc-interactive-hero .nc-rise-3,
        .nc-interactive-hero .nc-hero-sub,
        .nc-interactive-hero .nc-hero-ctas,
        .nc-interactive-hero .nc-hero-figure {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }
    }
</style>
@endPushOnce

@pushOnce('scripts')
<script>
(function() {
    let initialized = false;
    let svg, head, bodyG, disc, hairBack, hairFront, pupilL, pupilR, brows, eyeL, eyeR, lips, hint;
    let blushes = [];
    const EYE_L = { el: null, cx: 262, cy: 319 };
    const EYE_R = { el: null, cx: 378, cy: 319 };

    function queryElements() {
        svg = document.getElementById('ncGirl');
        head = document.getElementById('ncHead');
        bodyG = document.getElementById('ncBody');
        disc = document.getElementById('ncDisc');
        hairBack = document.getElementById('ncHairBack');
        hairFront = document.getElementById('ncHairFront');
        pupilL = document.getElementById('ncPupilL');
        pupilR = document.getElementById('ncPupilR');
        brows = document.getElementById('ncBrows');
        eyeL = document.getElementById('ncEyeL');
        eyeR = document.getElementById('ncEyeR');
        lips = document.getElementById('ncLips');
        blushes = [document.getElementById('ncBlushL'), document.getElementById('ncBlushR')];
        hint = document.getElementById('ncHint');
        if (eyeL) EYE_L.el = eyeL;
        if (eyeR) EYE_R.el = eyeR;
    }

    const LIPS_A = "M282 449 C296 439 312 440 320 444 C328 440 344 439 358 449 C347 463 333 468 320 468 C307 468 293 463 282 449 Z";
    const LIPS_B = "M275 443 C291 431 312 436 320 441 C328 436 349 431 365 443 C352 464 334 471 320 471 C306 471 288 464 275 443 Z";

    function mixPaths(a, b, t) {
        const na = a.match(/-?\d*\.?\d+/g) || [];
        let i = 0;
        return b.replace(/-?\d*\.?\d+/g, m => {
            const A = parseFloat(na[i++]);
            return (A + (parseFloat(m) - A) * t).toFixed(2);
        });
    }

    const clamp = (v, a, b) => Math.min(Math.max(v, a), b);
    const smooth = t => t * t * (3 - 2 * t);
    const spring = (k, d) => ({ x: 0, v: 0, k, d });
    const hx = spring(0.09, 0.8), hy = spring(0.09, 0.8), hr = spring(0.065, 0.8), hairS = spring(0.03, 0.9);

    function stepSpring(s, target, f) {
        s.v += (target - s.x) * s.k * f;
        s.v *= Math.pow(s.d, f);
        s.x += s.v * f;
    }

    let mx = window.innerWidth / 2, my = window.innerHeight * 0.4;
    let lastMove = performance.now(), docOut = false, movedDist = 0, pmx = null, pmy = null;
    let smileBoost = 0, tiltBoost = 0, browPop = 0, smileT = 0, winking = false;
    const sacc = { x: 0, y: 0 };
    let gxS = 0, gyS = 0, lastT = performance.now();

    const wanderX = t => 0.62 * Math.sin(t * 0.00043) + 0.2 * Math.sin(t * 0.0011 + 2);
    const wanderY = t => 0.38 * Math.sin(t * 0.0006 + 1) + 0.14 * Math.cos(t * 0.0013);

    function setClosed(o) {
        if (!o.el) return;
        o.el.setAttribute('transform', `translate(${o.cx} ${o.cy}) scale(1 .06) translate(${-o.cx} ${-o.cy})`);
    }

    function setOpen(o) {
        if (!o.el) return;
        o.el.removeAttribute('transform');
    }

    function blinkBoth(hold) {
        setClosed(EYE_L); setClosed(EYE_R);
        setTimeout(() => { setOpen(EYE_L); setOpen(EYE_R); }, hold);
    }

    function scheduleBlink() {
        setTimeout(() => {
            if (!winking) blinkBoth(110);
            if (Math.random() < 0.15) setTimeout(() => { if (!winking) blinkBoth(90); }, 230);
            scheduleBlink();
        }, 2500 + Math.random() * 3500);
    }

    function scheduleSaccade() {
        setTimeout(() => {
            sacc.x = (Math.random() * 2 - 1) * 1.5;
            sacc.y = (Math.random() * 2 - 1) * 1;
            setTimeout(() => { sacc.x = 0; sacc.y = 0; scheduleSaccade(); }, 260);
        }, 2800 + Math.random() * 3400);
    }

    function handlePointerMove(cx, cy) {
        if (pmx !== null) movedDist += Math.hypot(cx - pmx, cy - pmy);
        pmx = cx;
        pmy = cy;
        mx = cx;
        my = cy;
        lastMove = performance.now();
        docOut = false;
        if (hint && movedDist > 400) hint.classList.add('opacity-30');
    }

    window.addEventListener('pointermove', e => handlePointerMove(e.clientX, e.clientY), { passive: true });
    window.addEventListener('mousemove', e => handlePointerMove(e.clientX, e.clientY), { passive: true });
    window.addEventListener('touchmove', e => {
        if (e.touches && e.touches[0]) handlePointerMove(e.touches[0].clientX, e.touches[0].clientY);
    }, { passive: true });

    document.documentElement.addEventListener('mouseleave', () => docOut = true);

    /* Click anywhere on hero to wink */
    document.addEventListener('pointerdown', e => {
        if (!e.target.closest('[data-nc-interactive-hero]')) return;
        const modal = document.getElementById('ncHeroModal');
        if (modal && modal.classList.contains('pointer-events-auto')) return;
        if (winking) return;
        winking = true;
        setClosed(EYE_R);
        setTimeout(() => { setOpen(EYE_R); winking = false; }, 420);
        smileBoost = 1;
        tiltBoost = 1;
    });

    function loop(now) {
        requestAnimationFrame(loop);

        if (!head || !head.isConnected) {
            queryElements();
            if (!head || !head.isConnected) return;
        }

        const RM = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const f = clamp((now - lastT) / 16.7, 0.4, 2.2);
        lastT = now;

        let gxT = 0, gyT = 0, dist = 1e9;
        const idle = docOut || (now - lastMove > 4000);
        if (idle) {
            if (!RM) {
                gxT = wanderX(now);
                gyT = wanderY(now);
            }
        } else {
            const r = svg ? svg.getBoundingClientRect() : { left: 0, top: 0, width: 640, height: 780 };
            const s = Math.min((r.width || 640) / 640, (r.height || 780) / 780);
            const ox = r.left + (r.width - 640 * s) / 2;
            const oy = r.top + (r.height - 780 * s);
            const fx = ox + 320 * s, fy = oy + 300 * s;
            dist = Math.hypot(mx - fx, my - fy);
            gxT = (mx - fx) / 520;
            gyT = (my - fy) / 420;
            const L = Math.hypot(gxT, gyT);
            if (L > 1) { gxT /= L; gyT /= L; }
        }

        gxS += (gxT - gxS) * 0.22 * f;
        gyS += (gyT - gyS) * 0.22 * f;
        stepSpring(hx, gxT * 16, f);
        stepSpring(hy, gyT * 10, f);
        stepSpring(hr, gxT * 4.6 - tiltBoost * 5.5, f);
        stepSpring(hairS, gxT * 4.6, f);

        smileBoost *= Math.pow(0.955, f);
        tiltBoost *= Math.pow(0.94, f);
        browPop *= Math.pow(0.95, f);

        let sT = idle ? 0.3 : 0.18 + 0.72 * clamp(1 - dist / 460, 0, 1);
        sT = clamp(sT + smileBoost * 0.8, 0, 1);
        smileT += (sT - smileT) * 0.12 * f;

        if (lips) lips.setAttribute('d', mixPaths(LIPS_A, LIPS_B, smooth(smileT)));
        const bl = (0.15 + smileT * 0.3).toFixed(2);
        blushes.forEach(b => { if (b) b.setAttribute('opacity', bl); });

        const ptx = (gxS * 7 + sacc.x).toFixed(2);
        const pty = (gyS * 4.5 + sacc.y).toFixed(2);
        if (pupilL) pupilL.setAttribute('transform', `translate(${ptx} ${pty})`);
        if (pupilR) pupilR.setAttribute('transform', `translate(${ptx} ${pty})`);

        if (head) head.setAttribute('transform', `translate(${hx.x.toFixed(2)} ${hy.x.toFixed(2)}) rotate(${hr.x.toFixed(2)} 320 520)`);
        if (bodyG) bodyG.setAttribute('transform', `translate(${(hx.x * 0.3).toFixed(2)} ${(hy.x * 0.15).toFixed(2)})`);
        if (hairBack) hairBack.setAttribute('transform', `rotate(${(hairS.x * 1.8).toFixed(2)} 320 100)`);
        if (hairFront) hairFront.setAttribute('transform', `rotate(${(hairS.x * 1.1).toFixed(2)} 320 140)`);
        if (brows) brows.setAttribute('transform', `translate(${(gxS * 1.5).toFixed(2)} ${(-gyS * 3 - browPop * 3).toFixed(2)})`);
        if (disc) disc.setAttribute('transform', `translate(${(-gxS * 18).toFixed(2)} ${(-gyS * 10).toFixed(2)})`);
    }

    function openModal() {
        const modal = document.getElementById('ncHeroModal');
        if (!modal) return;
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
        const card = modal.querySelector('.nc-modal-card');
        if (card) card.classList.remove('translate-y-8');
        const nameInput = document.getElementById('ncEnquiryName');
        if (nameInput) setTimeout(() => nameInput.focus(), 300);
    }

    function closeModal() {
        const modal = document.getElementById('ncHeroModal');
        if (!modal) return;
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100', 'pointer-events-auto');
        const card = modal.querySelector('.nc-modal-card');
        if (card) card.classList.add('translate-y-8');
    }

    document.addEventListener('click', e => {
        if (e.target.closest('[data-hero-consult-btn]')) {
            e.preventDefault();
            openModal();
            return;
        }
        if (e.target.closest('#ncHeroModalClose')) {
            e.preventDefault();
            closeModal();
            return;
        }
        const modal = document.getElementById('ncHeroModal');
        if (modal && e.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', e => {
        const modal = document.getElementById('ncHeroModal');
        if (e.key === 'Escape' && modal && modal.classList.contains('pointer-events-auto')) closeModal();
    });

    document.addEventListener('submit', e => {
        const form = e.target.closest('#ncHeroEnquiryForm');
        if (!form) return;
        e.preventDefault();
        const nameEl = document.getElementById('ncEnquiryName');
        const contactEl = document.getElementById('ncEnquiryContact');
        const nameErr = document.getElementById('ncNameErr');
        const contactErr = document.getElementById('ncContactErr');
        const formWrap = document.getElementById('ncFormWrap');
        const successWrap = document.getElementById('ncSuccessWrap');

        const hasName = !!(nameEl && nameEl.value.trim());
        const hasContact = !!(contactEl && contactEl.value.trim());

        if (nameErr) nameErr.classList.toggle('hidden', hasName);
        if (contactErr) contactErr.classList.toggle('hidden', hasContact);

        if (!hasName || !hasContact) return;

        if (formWrap) formWrap.classList.add('hidden');
        if (successWrap) successWrap.classList.remove('hidden');

        smileBoost = 1.2;
        winking = true;
        setClosed(EYE_R);
        setTimeout(() => { setOpen(EYE_R); winking = false; }, 450);
    });

    function startHero() {
        queryElements();
        if (!initialized) {
            initialized = true;
            setTimeout(scheduleBlink, 1800);
            scheduleSaccade();
            requestAnimationFrame(loop);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', startHero);
    } else {
        startHero();
    }
    window.addEventListener('load', startHero);
    setTimeout(startHero, 300);
    setTimeout(startHero, 800);
    setTimeout(startHero, 1500);

    window.initNcHero = startHero;
})();
</script>
@endPushOnce
