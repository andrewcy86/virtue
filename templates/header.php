<?php global $virtue; ?>
<header class="banner headerclass" itemscope itemtype="http://schema.org/WPHeader">
<?php 
    if (kadence_display_topbar()) :
      get_template_part('templates/header', 'topbar'); 
    endif; 
  
    if(isset($virtue['logo_layout'])) {
      if($virtue['logo_layout'] == 'logocenter') {
        $logocclass = 'col-md-12';
        $menulclass = 'col-md-12';
      } else if($virtue['logo_layout'] == 'logohalf') {
        $logocclass = 'col-md-6'; 
        $menulclass = 'col-md-6';
      } else {
        $logocclass = 'col-md-4'; 
        $menulclass = 'col-md-8';
      } 
    } else {
      $logocclass = 'col-md-4';
      $menulclass = 'col-md-8'; 
    }?>
<div class="container">
       <?php if (has_nav_menu('primary_navigation')) : ?>
         <div class="<?php echo esc_attr($menulclass); ?> kad-header-right">
           <nav id="nav-main" class="clearfix" itemscope itemtype="http://schema.org/SiteNavigationElement">
              <?php wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'sf-menu')); ?>
           </nav> 
          </div> <!-- Close menuclass-->
        <?php endif; ?>       
    </div> <!-- Close Row -->
    <?php if (has_nav_menu('mobile_navigation')) : ?>
           <div id="mobile-nav-trigger" class="nav-trigger">
              <button class="nav-trigger-case mobileclass collapsed" data-toggle="collapse" data-target=".kad-nav-collapse">
                <span class="kad-navbtn"><i class="icon-reorder"></i></span>
                <span class="kad-menu-name"><?php echo __('Menu', 'virtue'); ?></span>
              </button>
            </div>
            <div id="kad-mobile-nav" class="kad-mobile-nav">
              <div class="kad-nav-inner mobileclass">
                <div class="kad-nav-collapse">
                <?php if(isset($virtue['mobile_submenu_collapse']) && $virtue['mobile_submenu_collapse'] == '1') {
                    wp_nav_menu( array('theme_location' => 'mobile_navigation','items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'menu_class' => 'kad-mnav', 'walker' => new kadence_mobile_walker()));
                  } else {
                    wp_nav_menu( array('theme_location' => 'mobile_navigation','items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'menu_class' => 'kad-mnav')); 
                  } ?>
               </div>
            </div>
          </div>   
  <?php  endif; ?> 
</div> <!-- Close Container -->
  <?php do_action('kt_before_secondary_navigation'); 
    
  if (has_nav_menu('secondary_navigation')) : ?>
  <section id="cat_nav" class="navclass">
    <div class="container">
      <nav id="nav-second" class="clearfix" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <?php wp_nav_menu(array('theme_location' => 'secondary_navigation', 'menu_class' => 'sf-menu')); ?>
      </nav>
    </div><!--close container-->
  </section>
  <?php endif;
  if (!empty($virtue['virtue_banner_upload']['url'])) { 
    $banner_image = apply_filters('kt_banner_image', $virtue['virtue_banner_upload']['url']); ?>

     <div class="container">
        <div class="virtue_banner">
          <img alt="" src="<?php echo esc_url($banner_image); ?>" />
        </div>
      </div>
  <?php } ?>
</header>
