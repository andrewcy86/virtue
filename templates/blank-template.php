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
    #nav-main {
        display: none;
    }
    #containerfooter {
        display: none;
    }
</style>

    <?php while (have_posts()) : the_post(); ?>
<div class="page-header">
	<h1 class="entry-title" itemprop="name">
		<?php echo apply_filters('kadence_page_title', kadence_title() ); ?>
	</h1>
   	<?php global $post; 
  	if(is_page()) {
  		$bsub = get_post_meta( $post->ID, '_kad_subtitle', true );
  		if(!empty($bsub)){
  			echo '<p class="subtitle"> '.$bsub.' </p>';
  		} 
	} else if(is_category()) { 
   		echo '<p class="subtitle">'.category_description().' </p>';
   	} ?>
</div>
    <?php the_content(); ?>
    <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>

<?php
endif;
