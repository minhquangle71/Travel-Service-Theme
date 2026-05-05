<?php get_header();  ?>


<!-- Author Note Section  -->
<section class="text-center py-20 text-white relative">
    <div class="bg-author-note-pattern bg-cover bg-center h-80 w-full">
        <img src="https://pub-1bec69406442434db848f91e6cb4489d.r2.dev/uploads/IMG_0554-1.jpg" alt="author note background" class="w-full h-full object-cover opacity-75">
    </div>
    <!-- Author note text center image hero -->
    <div class="absolute inset-0 flex flex-col items-center justify-center">
        <h2 class="text-3xl font-bold">Hi, I'm Quang</h2>
        <p class="mt-4 text-lg text-shadow max-w-xl">A software engineer with a passion for travel. I document my journeys and projects here.</p>
    </div>
</section>

<?php
function get_street_svg(string $variant): string
{
    if ($variant === 'building') {
        return '<svg viewBox="0 0 48 54" fill="none" xmlns="http://www.w3.org/2000/svg" width="48" height="54"><polygon points="24,3 45,22 3,22" fill="#d97706"/><rect x="8" y="21" width="32" height="29" rx="2" fill="#fef3c7" stroke="#d97706" stroke-width="2"/><rect x="18" y="36" width="12" height="14" rx="2" fill="#92400e"/><rect x="9" y="25" width="11" height="9" rx="1" fill="#bae6fd" stroke="#38bdf8" stroke-width="1.2"/><rect x="28" y="25" width="11" height="9" rx="1" fill="#bae6fd" stroke="#38bdf8" stroke-width="1.2"/></svg>';
    }
    if ($variant === 'tree') {
        return '<svg viewBox="0 0 48 64" fill="none" xmlns="http://www.w3.org/2000/svg" width="48" height="64"><path d="M22 62 C20 46 22 30 24 18" stroke="#a16207" stroke-width="5" stroke-linecap="round"/><path d="M24 18 C14 8 4 14 8 24" stroke="#15803d" stroke-width="4" fill="none" stroke-linecap="round"/><path d="M24 18 C18 6 26 2 30 10" stroke="#15803d" stroke-width="4" fill="none" stroke-linecap="round"/><path d="M24 18 C34 8 44 14 40 24" stroke="#15803d" stroke-width="4" fill="none" stroke-linecap="round"/><path d="M24 18 C12 20 8 30 14 36" stroke="#16a34a" stroke-width="3.5" fill="none" stroke-linecap="round"/><path d="M24 18 C36 20 40 30 34 36" stroke="#16a34a" stroke-width="3.5" fill="none" stroke-linecap="round"/></svg>';
    }
    return '<svg viewBox="0 0 28 64" fill="none" xmlns="http://www.w3.org/2000/svg" width="28" height="64"><rect x="11" y="38" width="6" height="26" rx="3" fill="#475569"/><rect x="3" y="2" width="22" height="38" rx="5" fill="#1e293b" stroke="#334155" stroke-width="1.5"/><circle cx="14" cy="11" r="6" fill="#ef4444"/><circle cx="14" cy="22" r="6" fill="#f59e0b" opacity="0.45"/><circle cx="14" cy="33" r="6" fill="#22c55e" opacity="0.45"/></svg>';
}
$bike_stops = [
    [
        'label' => 'Hai Van Store',
        'caption' => 'Travel gear',
        'variant' => 'building',
        'position' => '14%',
        'side' => 'north',
    ],
    [
        'label' => 'Hoi An Market',
        'caption' => 'Lantern street',
        'variant' => 'tree',
        'position' => '31%',
        'side' => 'south',
    ],
    [
        'label' => 'Da Nang Cafe',
        'caption' => 'Coffee break',
        'variant' => 'light',
        'position' => '50%',
        'side' => 'north',
    ],
    [
        'label' => 'Beach Hotel',
        'caption' => 'Night stay',
        'variant' => 'building',
        'position' => '69%',
        'side' => 'south',
    ],
    [
        'label' => 'Sunset Shop',
        'caption' => 'Snacks and maps',
        'variant' => 'tree',
        'position' => '86%',
        'side' => 'south',
    ],
];

?>

<section class="bike-road relative py-10 h-[220px] w-full" data-bike-road>

    <!-- Road -->
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t-[3px] border-dashed border-[#f59e0b]"></div>
    </div>

    <?php foreach ($bike_stops as $index => $bike_stop) : ?>
        <button
            type="button"
            class="bike-stop-zone bike-stop-zone--<?php echo esc_attr($bike_stop['side']); ?> absolute -translate-x-1/2"
            data-bike-stop-zone
            data-stop-index="<?php echo esc_attr((string) $index); ?>"
            data-stop-label="<?php echo esc_attr($bike_stop['label']); ?>"
            data-stop-position="<?php echo esc_attr($bike_stop['position']); ?>"
            data-stop-side="<?php echo esc_attr($bike_stop['side']); ?>"
            style="left: <?php echo esc_attr($bike_stop['position']); ?>; <?php echo $bike_stop['side'] === 'north' ? 'top: -1.75rem;' : 'bottom: 1.75rem;'; ?>"
            aria-label="Move the bike to the <?php echo esc_attr($bike_stop['label']); ?> stop">
            <span class="bike-stop-zone__icon-art" aria-hidden="true">
                <?php echo get_street_svg($bike_stop['variant']); // phpcs:ignore WordPress.Security.EscapeOutput 
                ?>
            </span>
            <span class="bike-stop-zone__tooltip" role="tooltip">
                <span class="bike-stop-zone__tooltip-label"><?php echo esc_html($bike_stop['label']); ?></span>
                <span class="bike-stop-zone__tooltip-caption"><?php echo esc_html($bike_stop['caption']); ?></span>
            </span>
        </button>
    <?php endforeach; ?>

    <!-- Bike -->
    <div
        class="bike-container absolute top-1/2 h-[85px]"
        data-bike
        role="button"
        tabindex="0"
        aria-label="Move the bike to the next stop zone">

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 500" width="100%" height="100%" class="bike-graphic">
            <defs>
                <!-- Gold gradient for front forks -->
                <linearGradient id="gold" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#D4AF37" />
                    <stop offset="100%" stop-color="#AA8000" />
                </linearGradient>
            </defs>

            <!-- Rear Wheel -->
            <g class="wheel wheel-rear">
                <circle cx="600" cy="350" r="75" fill="#222" />
                <circle cx="600" cy="350" r="50" fill="none" stroke="#444" stroke-width="12" stroke-dasharray="15 15" />
                <circle cx="600" cy="350" r="30" fill="none" stroke="#111" stroke-width="5" />
            </g>

            <!-- Front Wheel -->
            <g class="wheel wheel-front">
                <circle cx="200" cy="350" r="75" fill="#222" />
                <circle cx="200" cy="350" r="50" fill="none" stroke="#444" stroke-width="12" stroke-dasharray="15 15" />
                <circle cx="200" cy="350" r="30" fill="none" stroke="#111" stroke-width="5" />
            </g>

            <g transform="translate(0, -10)">
                <!-- Exhaust -->
                <path d="M 450 360 L 650 280 L 670 250 L 460 330 Z" fill="#333" />
                <path d="M 640 280 L 680 240 L 670 230 L 630 270 Z" fill="#666" /> <!-- Exhaust tip -->

                <!-- Swingarm & Lower Engine -->
                <path d="M 600 360 L 450 360 L 400 300 L 500 280 Z" fill="#111" />
                <path d="M 380 360 L 460 360 L 430 300 L 350 300 Z" fill="#222" />
                <circle cx="430" cy="330" r="25" fill="#333" />

                <!-- Tail & Rear Fender -->
                <path d="M 500 250 L 680 180 L 730 220 L 750 260 L 720 260 L 680 210 Z" fill="#111" />
                <path d="M 680 180 L 740 180 L 710 200 Z" fill="#C0C0C0" />

                <!-- Seat -->
                <path d="M 400 230 L 460 190 L 580 180 L 680 160 L 700 170 L 500 230 Z" fill="#1a1a1a" />

                <!-- Main Silver Fairing -->
                <path d="M 320 220 L 440 260 L 410 350 L 260 350 L 210 280 L 270 180 Z" fill="#D3D3D3" />
                <path d="M 320 220 L 270 180 L 290 230 Z" fill="#A9A9A9" />

                <!-- Black Side Panels -->
                <path d="M 340 220 L 480 240 L 540 280 L 430 350 L 400 280 Z" fill="#111" />

                <!-- Front Fairing / Headlight -->
                <path d="M 270 180 L 320 120 L 360 140 L 320 220 Z" fill="#D3D3D3" />
                <path d="M 210 280 L 270 180 L 230 220 Z" fill="#A9A9A9" />
                <path d="M 210 240 L 260 190 L 240 230 Z" fill="#111" />

                <!-- Front Forks (Gold) -->
                <path d="M 300 140 L 200 360 L 180 350 L 280 130 Z" fill="url(#gold)" />

                <!-- Front Mudguard -->
                <path d="M 160 280 L 240 260 L 260 300 L 150 330 Z" fill="#D3D3D3" />

                <!-- Handlebars -->
                <path d="M 320 120 L 290 70" stroke="#111" stroke-width="8" stroke-linecap="round" fill="none" />
                <path d="M 290 70 L 260 80" stroke="#111" stroke-width="6" stroke-linecap="round" fill="none" />

                <!-- Mirrors -->
                <path d="M 305 95 L 280 40" stroke="#333" stroke-width="4" fill="none" />
                <polygon points="270,30 290,25 295,45 275,50" fill="#111" />
            </g>
        </svg>

        <!-- Smoke -->
        <div class="smoke"></div>
    </div>
</section>



<!-- Section blog about Trips -->
<section class="container mx-auto py-16 w-[75%]">
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-bold">Trips</h2>
        <p class="text-gray-500 mt-2">Some places I've been and stories behind them</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        <div class="group rounded-2xl overflow-hidden shadow-md bg-white">
            <div class="overflow-hidden">
                <img src="https://pub-1bec69406442434db848f91e6cb4489d.r2.dev/uploads/IMG_0225-1.jpg"
                    class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">
            </div>
            <div class="p-5">
                <h3 class="text-xl font-semibold mb-2">Da Lat Trip</h3>
                <p class="text-gray-500 text-sm">A peaceful journey to the mountains and coffee vibes.</p>
            </div>
        </div>

        <div class="group rounded-2xl overflow-hidden shadow-md bg-white">
            <div class="overflow-hidden">
                <img src="https://pub-1bec69406442434db848f91e6cb4489d.r2.dev/uploads/IMG_0225-1.jpg"
                    class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">
            </div>
            <div class="p-5">
                <h3 class="text-xl font-semibold mb-2">Phu Quoc</h3>
                <p class="text-gray-500 text-sm">Sunset, beach, and seafood nights.</p>
            </div>
        </div>

        <div class="group rounded-2xl overflow-hidden shadow-md bg-white">
            <div class="overflow-hidden">
                <img src="https://pub-1bec69406442434db848f91e6cb4489d.r2.dev/uploads/IMG_0225-1.jpg"
                    class="w-full h-56 object-cover group-hover:scale-105 transition duration-300">
            </div>
            <div class="p-5">
                <h3 class="text-xl font-semibold mb-2">Ha Giang Loop</h3>
                <p class="text-gray-500 text-sm">The most unforgettable road trip experience.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-24 flex items-center justify-center text-center">
    <div class="max-w-2xl">
        <p class="text-sm uppercase tracking-widest text-gray-400 mb-4">
            My Story
        </p>

        <h2 class="text-3xl md:text-4xl font-semibold leading-relaxed">
            Building systems by day,<br>
            exploring the world by heart.
        </h2>
    </div>
</section>


<!-- Section blog about IT Projects -->
<section class="container mx-auto py-16 w-[75%]">
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-bold">IT Projects</h2>
        <p class="text-gray-500 mt-2">Some things I've built and worked on</p>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
        <div class="p-6 rounded-2xl border bg-white hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-2">Novel Management System</h3>
            <p class="text-gray-500 text-sm mb-4">
                Built with Go (Gin + GORM) and Next.js. Supports scalable chapter system.
            </p>
            <span class="text-xs bg-gray-100 px-2 py-1 rounded">Go</span>
            <span class="text-xs bg-gray-100 px-2 py-1 rounded">Next.js</span>
        </div>

        <div class="p-6 rounded-2xl border bg-white hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-2">CI/CD Pipeline</h3>
            <p class="text-gray-500 text-sm mb-4">
                Jenkins pipeline with Docker integration for automated deployment.
            </p>
            <span class="text-xs bg-gray-100 px-2 py-1 rounded">Jenkins</span>
            <span class="text-xs bg-gray-100 px-2 py-1 rounded">Docker</span>
        </div>

        <div class="p-6 rounded-2xl border bg-white hover:shadow-lg transition">
            <h3 class="text-xl font-semibold mb-2">Realtime CMS</h3>
            <p class="text-gray-500 text-sm mb-4">
                Laravel + Redis + WebSocket for collaborative editing system.
            </p>
            <span class="text-xs bg-gray-100 px-2 py-1 rounded">Laravel</span>
            <span class="text-xs bg-gray-100 px-2 py-1 rounded">Redis</span>
        </div>
    </div>
</section>

<?php get_footer(); ?>