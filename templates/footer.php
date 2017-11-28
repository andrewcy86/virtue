    </div>
	</section>

<div id="containerfooter" class="footerclass" itemscope itemtype="http://schema.org/WPFooter">
  <div class="container">
  	<div class="row">
  		<?php global $virtue; if(isset($virtue['footer_layout'])) { $footer_layout = $virtue['footer_layout']; } else { $footer_layout = 'fourc'; }
  			if ($footer_layout == "fourc") {
  				if (is_active_sidebar('footer_1') ) { ?> 
					<div class="col-md-3 col-sm-6 footercol1">
					<?php dynamic_sidebar('footer_1'); ?>
					</div> 
            	<?php }; ?>
				<?php if (is_active_sidebar('footer_2') ) { ?> 
					<div class="col-md-3  col-sm-6 footercol2">
					<?php dynamic_sidebar('footer_2'); ?>
					</div> 
		        <?php }; ?>
		        <?php if (is_active_sidebar('footer_3') ) { ?> 
					<div class="col-md-3 col-sm-6 footercol3">
					<?php dynamic_sidebar('footer_3'); ?>
					</div> 
	            <?php }; ?>
				<?php if (is_active_sidebar('footer_4') ) { ?> 
					<div class="col-md-3 col-sm-6 footercol4">
					<?php dynamic_sidebar('footer_4'); ?>
					</div> 
		        <?php }; ?>
		    <?php } else if($footer_layout == "threec") {
		    	if (is_active_sidebar('footer_third_1') ) { ?> 
					<div class="col-md-4 footercol1">
					<?php dynamic_sidebar('footer_third_1'); ?>
					</div> 
            	<?php }; ?>
				<?php if (is_active_sidebar('footer_third_2') ) { ?> 
					<div class="col-md-4 footercol2">
					<?php dynamic_sidebar('footer_third_2'); ?>
					</div> 
		        <?php }; ?>
		        <?php if (is_active_sidebar('footer_third_3') ) { ?> 
					<div class="col-md-4 footercol3">
					<?php dynamic_sidebar('footer_third_3'); ?>
					</div> 
	            <?php }; ?>
			<?php } else {
					if (is_active_sidebar('footer_double_1') ) { ?>
					<div class="col-md-6 footercol1">
					<?php dynamic_sidebar('footer_double_1'); ?> 
					</div> 
		            <?php }; ?>
		        <?php if (is_active_sidebar('footer_double_2') ) { ?>
					<div class="col-md-6 footercol2">
					<?php dynamic_sidebar('footer_double_2'); ?> 
					</div> 
		            <?php }; ?>
		        <?php } ?>
        </div>

  </div>

</div>
</div><!--Wrapper-->

	<footer class="main-footer clearfix" role="contentinfo">
		<div class="main-footer__inner">
			<div class="region-footer">
				<div class="block-pane-epa-global-footer" id="block-pane-epa-global-footer">
					<div class="row cols-3">
						<div class="col size-1of3">
							<div class="col__title">
								Discover.
							</div>
							<ul class="menu">
								<li><a href="https://www.epa.gov/accessibility">Accessibility</a></li>
								<li><a href="https://www.epa.gov/aboutepa/epas-administrator">EPA Administrator</a></li>
								<li><a href="https://www.epa.gov/planandbudget">Budget &amp; Performance</a></li>
								<li><a href="https://www.epa.gov/contracts">Contracting</a></li>
								<li><a href="https://www.epa.gov/home/grants-and-other-funding-opportunities">Grants</a></li>
								<li><a href="https://19january2017snapshot.epa.gov">January 19, 2017 Web Snapshot</a></li>
								<li><a href="https://www.epa.gov/ocr/whistleblower-protections-epa-and-how-they-relate-non-disclosure-agreements-signed-epa-employees">No FEAR Act Data</a></li>
								<li><a href="https://www.epa.gov/privacy">Privacy</a></li>
							</ul>
						</div>
						<div class="col size-1of3">
							<div class="col__title">
								Connect.
							</div>
							<ul class="menu">
								<li><a href="https://www.data.gov/">Data.gov</a></li>
								<li><a href="https://www.epa.gov/office-inspector-general/about-epas-office-inspector-general">Inspector General</a></li>
								<li><a href="https://www.epa.gov/careers">Jobs</a></li>
								<li><a href="https://www.epa.gov/newsroom">Newsroom</a></li>
								<li><a href="https://www.epa.gov/open">Open Government</a></li>
								<li><a href="https://www.regulations.gov/">Regulations.gov</a></li>
								<li><a href="https://www.epa.gov/newsroom/email-subscriptions">Subscribe</a></li>
								<li><a href="https://www.usa.gov/">USA.gov</a></li>
								<li><a href="https://www.whitehouse.gov/">White House</a></li>
							</ul>
						</div>
						<div class="col size-1of3">
							<div class="col__title">
								Ask.
							</div>
							<ul class="menu">
								<li><a href="https://www.epa.gov/home/forms/contact-us">Contact Us</a></li>
								<li><a href="https://www.epa.gov/home/epa-hotlines">Hotlines</a></li>
								<li><a href="https://www.epa.gov/foia">FOIA Requests</a></li>
								<li><a href="https://www.epa.gov/home/frequent-questions-specific-epa-programstopics">Frequent Questions</a></li>
							</ul>
							<div class="col__title">
								Follow.
							</div>
							<ul class="social-menu">
								<li><a class="menu-link social-facebook" href="https://www.facebook.com/EPA">Facebook</a></li>
								<li><a class="menu-link social-twitter" href="https://twitter.com/epa">Twitter</a></li>
								<li><a class="menu-link social-youtube" href="https://www.youtube.com/user/USEPAgov">YouTube</a></li>
								<li><a class="menu-link social-flickr" href="https://www.flickr.com/photos/usepagov">Flickr</a></li>
								<li><a class="menu-link social-instagram" href="https://www.instagram.com/epagov">Instagram</a></li>
							</ul>
							<p class="last-updated">Last updated on <?php the_modified_date(); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
  <script src="https://www.epa.gov/sites/all/modules/custom/epa_core/js/alert.js"></script>
<?php wp_footer(); ?>
