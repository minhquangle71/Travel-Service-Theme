 <section class="py-12">
     <div class="max-w-6xl mx-auto px-4">

         <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

             <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                     <article class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition overflow-hidden">

                         <!-- Thumbnail -->
                         <?php if (has_post_thumbnail()) : ?>
                             <a href="<?php the_permalink(); ?>">
                                 <?php the_post_thumbnail('large', ['class' => 'w-full h-48 object-cover']); ?>
                             </a>
                         <?php endif; ?>

                         <!-- Content -->
                         <div class="p-6">

                             <!-- Category -->
                             <div class="text-sm text-indigo-600 font-semibold mb-2">
                                 <?php the_category(', '); ?>
                             </div>

                             <!-- Title -->
                             <h2 class="text-xl font-bold text-gray-900 mb-2">
                                 <a href="<?php the_permalink(); ?>" class="hover:text-indigo-600">
                                     <?php the_title(); ?>
                                 </a>
                             </h2>

                             <!-- Excerpt -->
                             <p class="text-gray-600 text-sm mb-4">
                                 <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                             </p>

                             <!-- Meta -->
                             <div class="flex items-center justify-between text-xs text-gray-500">
                                 <span><?php echo get_the_date(); ?></span>
                                 <a href="<?php the_permalink(); ?>" class="text-indigo-600 font-medium hover:underline">
                                     Read more →
                                 </a>
                             </div>

                         </div>
                     </article>

             <?php endwhile;
                endif; ?>

         </div>

         <!-- Pagination -->
         <div class="mt-12 flex justify-center">
             <?php
                the_posts_pagination([
                    'mid_size' => 2,
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                ]);
                ?>
         </div>

     </div>
 </section>