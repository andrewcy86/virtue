<?php
/*
Template Name: Blank Template

This is a copy of the standard "page" template, but exists to allow some
deviations to standard pages

*/


if( !$hide_content ):
?>
<style>
    #logo {
        display: none;
    }
    .contentclass {
        padding-top: 0px;
    }
    .page-header {
        border-top: 0px;
    }
    #mobile-nav-trigger {
        display: none;
    }
</style>

    <?php while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
    <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>

<?php
endif;
