<?php get_header(); ?>

<main class="bg-gray-50 min-h-screen">

    <!-- Hero Section -->
    <?php get_template_part('template-parts/blog/hero'); ?>

    <!-- Blog Grid -->
    <?php get_template_part('template-parts/blog/list'); ?>

    <!-- Gallery Slider -->
    <?php get_template_part('template-parts/gallery/slider'); ?>
</main>

<?php get_footer(); ?>