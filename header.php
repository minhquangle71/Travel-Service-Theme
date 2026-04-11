<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php wp_head(); ?>
</head>

<body class="bg-gray-100">

    <header class="bg-white shadow">
        <nav class="container mx-auto p-4 flex justify-between">
            <div>Logo</div>
            <?php wp_nav_menu(['theme_location' => 'primary']); ?>
        </nav>
    </header>