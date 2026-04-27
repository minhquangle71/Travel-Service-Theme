<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class("bg-gray-50"); ?>>

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">

                <!-- Logo -->
                <div class="text-xl font-bold text-gray-900">
                    <a href="<?php echo home_url(); ?>">
                        QuangDev 🚀
                    </a>
                </div>

                <nav class="hidden md:flex items-center">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_id' => 'primary-menu',
                    ]);
                    ?>
                </nav>

                <!-- Mobile Button -->
                <button id="menu-toggle" class="md:hidden text-gray-700 focus:outline-none">
                    ☰
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
            <div class="px-4 py-4 space-y-3">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'flex flex-col space-y-3 text-gray-700 font-medium',
                ]);
                ?>
            </div>
        </div>
    </header>

    <script>
        const toggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('mobile-menu');

        toggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>