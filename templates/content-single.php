<?php
// Get Category Information
$cat_id_array = get_the_category($post->ID);
$cat_id = $cat_id_array[0]->cat_ID;
?>

<?php if(kadence_display_sidebar()) {
        $slide_sidebar = 848;
      } else {
        $slide_sidebar = 1140;
      }
      global $post, $virtue;
      $headcontent = get_post_meta( $post->ID, '_kad_blog_head', true );
      $height      = get_post_meta( $post->ID, '_kad_posthead_height', true );
      $swidth      = get_post_meta( $post->ID, '_kad_posthead_width', true );
      if(empty($headcontent) || $headcontent == 'default') {
          if(!empty($virtue['post_head_default'])) {
              $headcontent = $virtue['post_head_default'];
          } else {
              $headcontent = 'none';
          }
      }
      if (!empty($height)) {
        $slideheight = $height; 
      } else {
        $slideheight = 400;
      }
      if (!empty($swidth)) {
        $slidewidth = $swidth; 
      } else {
        $slidewidth = $slide_sidebar;
      } 

    /**
    * 
    */
    do_action( 'kadence_single_post_begin' ); 
    ?>
<div id="content" class="container">
    <div class="row single-article" itemscope itemtype="http://schema.org/BlogPosting">
        <div class="main <?php echo esc_attr( kadence_main_class() ); ?>" role="main">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?>>    
            <?php
             do_action( 'kadence_single_post_before' ); 

            if ($headcontent == 'flex') { ?>
                <section class="postfeat">
                    <div class="flexslider kad-light-wp-gallery loading kt-flexslider" style="max-width:<?php echo esc_attr($slidewidth);?>px;" data-flex-speed="7000" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                        <ul class="slides">
                        <?php 
                        $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                        if(!empty($image_gallery)) {
                            $attachments = array_filter( explode( ',', $image_gallery ) );
                            if ($attachments) {
                                foreach ($attachments as $attachment) {
                                $attachment_src = wp_get_attachment_image_src($attachment , 'full');
                                $caption = get_post($attachment)->post_excerpt;
                                $image = aq_resize($attachment_src[0], $slidewidth, $slideheight, true, false, false, $attachment);
                                if(empty($image[0])) { $image = array($attachment_src[0], $attachment_src[1], $attachment_src[2]); }

                                    echo '<li>';
                                        echo '<a href="'.esc_url($attachment_src[0]).'" data-rel="lightbox" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';
                                            echo '<img src="'.esc_url($image[0]).'" width="'.esc_attr($image[1]).'" height="'.esc_attr($image[2]).'" alt="'.esc_attr($caption).'" '.kt_get_srcset_output($image[1], $image[2], $attachment_src[0], $attachment).' itemprop="contentUrl"/>';
                                                echo '<meta itemprop="url" content="'.esc_url($image[0]).'">';
                                                echo '<meta itemprop="width" content="'.esc_attr($image[1]).'">';
                                                echo '<meta itemprop="height" content="'.esc_attr($image[2]).'">';
                                        echo '</a>';
                                    echo '</li>';
                                }
                            }
                        }
                        ?>                            
                        </ul>
                    </div> <!--Flex Slides-->
                </section>
            <?php } else if ($headcontent == 'video') { ?>
                <section class="postfeat">
                    <div class="videofit">
                        <?php echo do_shortcode( get_post_meta( $post->ID, '_kad_post_video', true ) ); ?>
                    </div>
                    <?php if (has_post_thumbnail( $post->ID ) ) { 
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                        <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                        <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                    </div>
                    <?php } ?>
                </section>
            <?php } else if ($headcontent == 'image') {
                    if (has_post_thumbnail( $post->ID ) ) {        
                        $image_id = get_post_thumbnail_id();
                        $image_src = wp_get_attachment_image_src( $image_id, 'full' );
                        $image = aq_resize( $image_src[0], $slidewidth, $slideheight, true, false, false, $image_id); //resize & crop the image
                        if(empty($image[0])) { $image = array($image_src[0], $image_src[1], $image_src[2]); }
                        ?>
                            <div class="imghoverclass postfeat post-single-img" itemscope itemtype="https://schema.org/ImageObject">
                                <a href="<?php echo esc_url($image_src[0]); ?>" data-rel="lightbox" class="lightboxhover">
                                    <img src="<?php echo esc_url($image[0]); ?>"  width="<?php echo esc_attr($image[1]); ?>" height="<?php echo esc_attr($image[2]); ?>" <?php echo kt_get_srcset_output($image[1], $image[2], $image[0], $image_id);?> itemprop="contentUrl" alt="<?php the_title_attribute(); ?>" />
                                    <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                                </a>
                            </div>
                        <?php
                    } 
            } else {
            	if(has_post_thumbnail()) {
				    $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); 
				    echo '<div class="meta_post_image" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">';
				        echo '<meta itemprop="url" content="'.esc_url($image[0]).'">';
				        echo '<meta itemprop="width" content="'.esc_attr($image[1]).'">';
				        echo '<meta itemprop="height" content="'.esc_attr($image[2]).'">';
				    echo '</div>';
				}
           	} ?>

                <?php
                  /**
                  * @hooked virtue_single_post_meta_date - 20
                  */
                  do_action( 'kadence_single_post_before_header' );
                  ?>
                <header>
                    <?php 
                    /**
                    * @hooked virtue_post_header_title - 20
                    * @hooked virtue_post_header_meta - 30
                    */
                    do_action( 'kadence_single_post_header' );
                    ?>
                </header>
 <?php 
$edgID = get_post_meta($post->ID, 'EDG_ID', true);
if ($edgID && $cat_id == 2 && is_single()) {
 $curl = curl_init();
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_URL, 'https://edg.epa.gov/metadata/rest/find/document?f=dcat&uuid='. $edgID);
      $content = curl_exec($curl);
	  curl_close($curl);
$json = json_decode(utf8_encode($content));
// BEGIN JSON ERROR CHECK
if ($json === null
    || json_last_error() !== JSON_ERROR_NONE) {
    echo "<span class='warning'>Error retrieving information. Please check back later.</span>";
} else { 
?>
<?php
//$i=0;
//foreach($json->dataset as $item) {
//	     if($i!=0)  
//        break;
//    echo '<header class="entry-header"><h2 class="entry-title">' . $item->title . '</h2></header>';
//	$i++;
//}
?>
	
<?php 
echo '<div class="entry-content">';
$i_link=0;
foreach($json->dataset as $item) { 
if($i_link!=0) 
	break;
   $arr = $item->distribution;
   $result = count($arr);
   //echo $result;
   $default = '<div class="post-format"><div class="format-container pad"><p><a href="https://edg.epa.gov/metadata/catalog/search/resource/details.page?uuid='. $edgID .'" class="post-format-link" target="_blank"><i class="fa fa-link fa-2x"></i> Additional Information &rarr;</a></p></div></div>';
   if ($result == 0) {
    echo  $default;
} else if ($result == 1) {
    echo  $default;
	echo '<div class="post-format"><i class="fa fa-link fa-2x"></i><div class="format-container pad"><p><a href="'. $arr[0]->downloadURL .'" class="post-format-link" target="_blank">Download Data &rarr;</a></p></div></div>';
} else if ($result == 2) {
	
	if ($arr[0]->accessURL != null && $arr[1]->accessURL != null ) {
    echo '<div class="post-format"><div class="format-container pad"><p><a href="'. $arr[0]->accessURL .'" class="post-format-link" target="_blank"><i class="fa fa-link fa-2x"></i> Access Data &rarr;</a></p></div></div>';
	echo '<div class="post-format"><div class="format-container pad"><p><a href="'. $arr[1]->accessURL .'" class="post-format-link" target="_blank"><i class="fa fa-link fa-2x"></i> Access Data &rarr;</a></p></div></div>';
	} else if ($arr[0]->downloadURL != null && $arr[1]->downloadURL != null) {
	echo '<div class="post-format"><div class="format-container pad"><p><a href="'. $arr[0]->downloadURL .'" class="post-format-link" target="_blank"><i class="fa fa-link fa-2x"></i> Download Data &rarr;</a></p></div></div>';
	echo '<div class="post-format"><div class="format-container pad"><p><a href="'. $arr[1]->downloadURL .'" class="post-format-link" target="_blank"><i class="fa fa-link fa-2x"></i> Download Data &rarr;</a></p></div></div>';
	} else if ($arr[0]->accessURL != null && $arr[1]->downloadURL != nulll) {
	echo '<div class="post-format"><div class="format-container pad"><p><a href="'. $arr[0]->accessURL .'" class="post-format-link" target="_blank"><i class="fa fa-link fa-2x"></i> Access Data &rarr;</a></p></div></div>';
	echo '<div class="post-format"><div class="format-container pad"><p><a href="'. $arr[1]->downloadURL .'" class="post-format-link" target="_blank"><i class="fa fa-link fa-2x"></i> Download Data &rarr;</a></p></div></div>';
	} else {
	echo  $default;	
	}
} else {
	echo  $default;	
	}
	$i_link++;
}
?>


						
						
<?php 
$i_contact=0;
foreach($json->dataset as $item) {
if($i_contact!=0) 
	break;	   
    echo $item->description;
	echo '<br /><br /><strong>Organization Name</strong>: ' . $item->publisher->name;
	echo '<br /><br /><strong>Contact</strong>: <a href="mailto:'.str_replace("mailto:", "", $item->contactPoint->hasEmail).'">' . $item->contactPoint->fn .'</a> ('. str_replace("mailto:", "", $item->contactPoint->hasEmail) .')<br /><br />';
	echo '</div><!-- .entry-content -->';
$i_contact++;
}
?>

<?php
} // END JSON ERROR CHECK
?>

						
<?php 
} else {
?>
                <div class="entry-content" itemprop="articleBody">
                    <?php
                    do_action( 'kadence_single_post_content_before' );
                        
                        the_content(); 
                      
                    do_action( 'kadence_single_post_content_after' );
                    ?>
                </div>
<?php 
} //EDG API END
?>
                <footer class="single-footer">
                <?php 
                  /**
                  * @hooked virtue_post_footer_pagination - 10
                  * @hooked virtue_post_footer_tags - 20
                  * @hooked virtue_post_footer_meta - 30
                  * @hooked virtue_post_nav - 40
                  */
                  do_action( 'kadence_single_post_footer' );
                  ?>
                </footer>
            </article>
            <?php
            /**
            * @hooked virtue_post_authorbox - 20
            * @hooked virtue_post_bottom_carousel - 30
            * @hooked virtue_post_comments - 40
            */
            do_action( 'kadence_single_post_after' );
            
            endwhile; ?>
        </div>
        <?php 
        do_action( 'kadence_single_post_end' ); 
