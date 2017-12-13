  <!-- Google Tag Manager -->
  <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-L8ZB" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager -->  

  <!-- REMOVE WHEN IN PRODUCTION -->
<style type="text/css">
    #topbanner{position: fixed; z-index: 99999; width:100%; height: 50px; margin:0 auto;padding:0px 5px;text-align:center;background:linear-gradient(to bottom,#520001 0%,#6c0810 100%)}
    #topbannerinner{margin:0 auto;width:100%}
    #topbanner h3,#topbanner p{color:#FC0}
    #topbanner a:link,#topbanner a:visited,#topbanner a:hover{color:#fff}
    header.masthead {padding-top: 50px;}
 </style>
<div id="topbanner"><p>EPA Sandbox Environment: The content on this page is not production data and this site is being used for <strong>testing</strong> purposes only.</p></div>

	<header class="masthead clearfix" role="banner">
		<img alt="" class="site-logo" src="https://www.epa.gov/sites/all/themes/epa/logo.png">
		<div class="site-name-and-slogan">
			<h1 class="site-name"><a href="https://www.epa.gov/" rel="home" title="Go to the home page"><span>US EPA</span></a></h1>
			<div class="site-slogan">United States Environmental Protection Agency</div>
		</div>
		<div class="region-header">
			<div class="block-epa-core-gsa-epa-search" id="block-epa-core-gsa-epa-search">
				<form action="https://search.epa.gov/epasearch/epasearch" class="epa-search" method="get">
					<label class="element-hidden" for="search-box">Search</label>
          <input class="form-text" id="search-box" name="querytext" placeholder="Search EPA.gov" value="">
          <button class="epa-search-button" id="search-button" title="Search" type="submit">Search</button>
          <input name="areaname" type="hidden" value="">
          <input name="areacontacts" type="hidden" value="">
          <input name="areasearchurl" type="hidden" value="">
          <input name="typeofsearch" type="hidden" value="epa">
          <input name="result_template" type="hidden" value="2col.ftl">
				</form>
			</div>
		</div>
	</header>

<?php global $virtue; ?>
<div class="banner headerclass" itemscope itemtype="http://schema.org/WPHeader">
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
  <div class="row">
      <div class="<?php echo esc_attr($logocclass); ?> clearfix kad-header-left">
            <div id="logo" class="logocase">
              <a class="brand logofont" href="<?php echo home_url(); ?>/">
                <?php 
                    echo get_bloginfo('name'); 
               ?>
              </a>
              <?php if (isset($virtue['logo_below_text']) && !empty($virtue['logo_below_text'])) { ?>
                <p class="kad_tagline belowlogo-text"><?php echo $virtue['logo_below_text']; ?></p>
              <?php }?>
           </div> <!-- Close #logo -->
       </div><!-- close logo span -->
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
</div>
