<?php
// Get Category Information
$cat_id_array = get_the_category($post->ID);
$cat_id = $cat_id_array[0]->cat_ID;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="" itemtype="http://schema.org/BlogPosting">
<div class="row">
        <?php global $post, $virtue; 
            $postsummery  = get_post_meta( $post->ID, '_kad_post_summery', true );
            $height       = get_post_meta( $post->ID, '_kad_posthead_height', true );
            $swidth       = get_post_meta( $post->ID, '_kad_posthead_width', true );
            if (!empty($height)){
                $slideheight = $height;
            } else {
                $slideheight = apply_filters('kt_post_excerpt_image_height', 400);
            }
            if (!empty($swidth)){
                $slidewidth = $swidth;
            } else {
                $slidewidth = $slidewidth = apply_filters('kt_post_excerpt_image_width', 846);
            }
            if(empty($postsummery) || $postsummery == 'default') {
                if(!empty($virtue['post_summery_default'])) {
                    $postsummery = $virtue['post_summery_default'];
                } else {
                    $postsummery = 'img_portrait';
                }
            }
            $portraitwidth = apply_filters('kt_post_excerpt_image_width_portrait', 365);
            $portraitheight = apply_filters('kt_post_excerpt_image_height_portrait', 365);
                        
            if($postsummery == 'img_landscape') { 
                $textsize = 'col-md-12'; 
                if (has_post_thumbnail( $post->ID ) ) {
                    $image_id = get_post_thumbnail_id( $post->ID );
                    $image_src = wp_get_attachment_image_src( $image_id, 'full' ); 
                    $image = aq_resize($image_src[0], $slidewidth, $slideheight, true, false, false, $image_id);
                    if(empty($image[0])) { $image = $image_src; }
                    ?>
                    <div class="col-md-12">
                        <div class="imghoverclass img-margin-center" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                            <a href="<?php the_permalink()  ?>" title="<?php the_title_attribute(); ?>">
                                <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" itemprop="contentUrl"  class="iconhover" <?php echo kt_get_srcset_output($image[1], $image[2], $image_src[0], $image_id);?>>
                                    <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                            </a> 
                        </div>
                    </div>
                    <?php $image = null; $thumbnailURL = null; 
                } else {
                        $thumbnailURL = virtue_post_default_placeholder();
                        $image = aq_resize($thumbnailURL, $slidewidth, $slideheight, true, false, false);
                        if(empty($image[0])) { $image = array($thumbnailURL, null, null); } ?>
                        <div class="col-md-12">
                        <div class="imghoverclass img-margin-center" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                          <a href="<?php the_permalink()  ?>" title="<?php the_title_attribute(); ?>">
                                    <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" itemprop="contentUrl"  class="iconhover" >
                                    <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                              </a> 
                           </div>
                       </div>
                      <?php $image = null; $thumbnailURL = null; 
                } 
            } elseif($postsummery == 'img_portrait') { 
                $textsize = 'col-md-7'; 
                if (has_post_thumbnail( $post->ID ) ) {
                    $image_id = get_post_thumbnail_id( $post->ID );
                    $image_src = wp_get_attachment_image_src( $image_id, 'full' ); 
                    $image = aq_resize($image_src[0], $portraitwidth, $portraitheight, true, false, false, $image_id);
                    if(empty($image[0])) { $image = $image_src; } ?>
                    <div class="col-md-5 post-image-container">
                        <div class="imghoverclass img-margin-center" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                            <a href="<?php the_permalink()  ?>" title="<?php the_title_attribute(); ?>">
                                <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" itemprop="contentUrl"  class="iconhover" <?php echo kt_get_srcset_output($image[1], $image[2], $image_src[0], $image_id);?>>
                                <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                                <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                                <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                            </a> 
                         </div>
                     </div>
                    <?php $image = null; $thumbnailURL = null; 
                } else {
                  $thumbnailURL = virtue_post_default_placeholder();
                  $image = aq_resize($thumbnailURL, $portraitwidth, $portraitheight, true, false, false);
                  if(empty($image[0])) { $image = array($thumbnailURL, null, null); } ?>
                  <div class="col-md-5 post-image-container">
                    <div class="imghoverclass img-margin-center" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        <a href="<?php the_permalink()  ?>" title="<?php the_title_attribute(); ?>">
                            <img src="<?php echo esc_url($image[0]); ?>" alt="<?php the_title_attribute(); ?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" itemprop="contentUrl"  class="iconhover">
                            <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                            <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                            <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                        </a> 
                     </div>
                 </div>
                <?php $image = null; $thumbnailURL = null; 
                } 
            } elseif($postsummery == 'slider_landscape') {
                $textsize = 'col-md-12'; ?>
                <div class="col-md-12">
                    <div class="flexslider kt-flexslider loading" style="max-width:<?php echo esc_attr($slidewidth);?>px;" data-flex-speed="7000" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                        <ul class="slides">
                            <?php
                            $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                            if(!empty($image_gallery)) {
                                $attachments = array_filter( explode( ',', $image_gallery ) );
                                if ($attachments) {
                                    foreach ($attachments as $attachment) {
                                        $attachment_src = wp_get_attachment_image_src($attachment , 'full');
                                        $image = aq_resize($attachment_url, $slidewidth, $slideheight, true, false, false, $attachment);
                                        $alt = get_post_meta($attachment, '_wp_attachment_image_alt', true);
                                         if(empty($image[0])) {$image = $attachment_src;}  ?>
                                            <li>
                                                <a href="<?php the_permalink() ?>" alt="<?php the_title_attribute(); ?>" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                                    <img src="<?php echo esc_attr($image[0]); ?>" itemprop="contentUrl" alt="<?php echo esc_attr($alt);?>" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output($image[1], $image[2], $attachment_src[0], $attachment);?> />
                                                    <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                                                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                                                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                                            </a>
                                        </li>
                                    <?php 
                                    }
                                  }
                                } ?>                                   
                        </ul>
                    </div> <!--Flex Slides-->
                </div>
            <?php 
            } elseif($postsummery == 'slider_portrait') { ?>
                <?php $textsize = 'col-md-7'; ?>
                <div class="col-md-5 post-image-container">
                    <div class="flexslider kt-flexslider loading" data-flex-speed="7000" data-flex-anim-speed="400" data-flex-animation="fade" data-flex-auto="true">
                        <ul class="slides">
                            <?php global $post;
                            $image_gallery = get_post_meta( $post->ID, '_kad_image_gallery', true );
                                if(!empty($image_gallery)) {
                                    $attachments = array_filter( explode( ',', $image_gallery ) );
                                    if ($attachments) {
                                        foreach ($attachments as $attachment) {
                                            $attachment_src = wp_get_attachment_image_src($attachment , 'full');
                                            $image = aq_resize($attachment_src[0], $portraitwidth, $portraitheight, true, false, false, $attachment);
                                            $alt = get_post_meta($attachment, '_wp_attachment_image_alt', true);
                                            if(empty($image[0])) {$image = $attachment_src;} ?>
                                            <li>
                                                <a href="<?php the_permalink() ?>" alt="<?php the_title_attribute(); ?>" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                                    <img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr($alt);?>" itemprop="contentUrl" width="<?php echo esc_attr($image[1]);?>" height="<?php echo esc_attr($image[2]);?>" <?php echo kt_get_srcset_output($image[1], $image[2], $attachment_src[0], $attachment);?> />
                                                    <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                                                    <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                                                    <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                                                </a>
                                            </li>
                                        <?php 
                                        }
                                    }
                                } ?>           
                        </ul>
                    </div> <!--Flex Slides-->
                </div>
            <?php 
            } elseif($postsummery == 'video') {
                    $textsize = 'col-md-12'; ?>
                    <div class="col-md-12">
                        <div class="videofit">
                            <?php global $post; echo get_post_meta( $post->ID, '_kad_post_video', true ); ?>
                        </div>
                    </div>
                    <?php if (has_post_thumbnail( $post->ID ) ) { 
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        <meta itemprop="url" content="<?php echo esc_url($image[0]); ?>">
                        <meta itemprop="width" content="<?php echo esc_attr($image[1])?>">
                        <meta itemprop="height" content="<?php echo esc_attr($image[2])?>">
                    </div>
                    <?php } ?>

            <?php 
            } else { 
                $textsize = 'col-md-12 kttextpost'; 
            } ?>

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

	
            <div class="<?php echo esc_attr($textsize);?> post-text-container postcontent">
                <?php get_template_part('templates/post', 'date'); ?> 
                <header>
                    <a href="<?php the_permalink() ?>">
                        <h2 class="entry-title" itemprop="name headline">
                            <?php the_title(); ?> 
                        </h2>
                    </a>
                    <?php get_template_part('templates/entry', 'meta-subhead'); ?>    
                </header>
                <div class="entry-content" itemprop="description">
                    <?php 
                        do_action( 'kadence_post_excerpt_content_before' );
                        
                        the_excerpt(); 
                        
                        do_action( 'kadence_post_excerpt_content_after' );
                    ?>
                </div>
                <footer>
                <?php do_action( 'kadence_post_excerpt_footer' );
                    $tags = get_the_tags(); if ($tags) { ?>
                        <span class="posttags color_gray"><i class="icon-tag"></i> <?php the_tags('', ', ', ''); ?></span>
                    <?php } ?>
                </footer>
            </div><!-- Text size -->
        </div><!-- row-->
    
<?php 
} //EDG API END
?>
    </article> <!-- Article -->
