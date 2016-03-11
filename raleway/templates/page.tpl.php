<header id="navbar" role="banner" class="<?php print $navbar_classes; ?>">
  <div class="container">
  
    <div class="navbar-header">
      <?php if ($logo): ?>
      <a class="logo navbar-btn pull-left" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" height="<?php print theme_get_setting('logo_height'); ?>" data-sticky-height="<?php print theme_get_setting('sticky_logo_height'); ?>" />
      </a>
      <?php endif; ?>

      <?php if (!empty($site_name)): ?>
      <a class="name navbar-brand" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>"><?php print $site_name; ?></a>
      <?php endif; ?>

      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
      <?php if (isset($page['header_search'])) : ?>
	    <div class="search">
	      <?php print render($page['header_search']); ?>
	    </div>
	    <?php endif; ?>
      <div id="header-top">
        <?php print render($page['header_top']); ?>
      </div>
    <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($page['header_menu'])): ?>
      <div class="navbar-collapse collapse">
        <nav role="navigation" class="nav-main">
          <?php if (!empty($primary_nav)): ?>
            <?php print render($primary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($secondary_nav)): ?>
            <?php print render($secondary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($page['header_menu'])): ?>
            <?php print render($page['header_menu']); ?>
          <?php endif; ?>
        </nav>
      </div>
    <?php endif; ?>
  </div>
</header>


<div class="main-container container">
  <div class="row">

    <?php if (!empty($page['sidebar_first'])): ?>
      <aside class="col-sm-3" role="complementary">
        <?php print render($page['sidebar_first']); ?>
      </aside>  <!-- /#sidebar-first -->
    <?php endif; ?>

    <section<?php print $content_column_class; ?>>
      <?php if (!empty($page['highlighted'])): ?>
        <div class="highlighted"><?php print render($page['highlighted']); ?></div>
      <?php endif; ?>
        <?php if (theme_get_setting('breadcrumbs') == '1'): ?>
				<div class="row">
					<div class="col-md-12">
						<div id="breadcrumbs"><?php print $breadcrumb; ?> </div>	
					</div>
				</div>
				<?php endif; ?>
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if (!empty($title)): ?>
        <h1 class="page-header"><?php print $title; ?></h1>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print $messages; ?>
     	<?php if ($tabs = render($tabs)): ?>		 
       <?php print render($tabs); ?>		 
		  <?php endif; ?>
      <?php if (!empty($page['help'])): ?>
        <?php print render($page['help']); ?>
      <?php endif; ?>
      <?php if (!empty($action_links)): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($page['before_content']); ?>
      <?php print render($page['content']); ?>
      <?php print render($page['after_content']); ?>
    </section>

    <?php if (!empty($page['sidebar_second'])): ?>
      <aside class="col-sm-3" role="complementary">
        <?php print render($page['sidebar_second']); ?>
      </aside>  <!-- /#sidebar-second -->
    <?php endif; ?>

  </div>
</div>
<footer id="footer">
    <?php if (render($page['footer_one']) || render($page['footer_two']) || render($page['footer_three']) || render($page['footer_four'])) : ?>
	  <div class="container main-footer">
	    <div class="row">
	    
	      <?php if (theme_get_setting('ribbon') == '1'): ?>
				<div class="footer-ribbon">
					<span><?php echo t("%string", array('%string' => theme_get_setting('ribbon_text')) );?></span>
				</div>
	      <?php endif; ?>
			  
			  <?php if (render($page['footer_one'])) : ?>
		    <div class="col-md-3">
				  <?php print render($page['footer_one']); ?>
		    </div>
		    <?php endif; ?>
		    
		    <?php if (render($page['footer_two'])) : ?>
		    <div class="col-md-3">   
				  <?php print render($page['footer_two']); ?>
		    </div>
		    <?php endif; ?>
		    
		    <?php if (render($page['footer_three'])) : ?>
		    <div class="col-md-4">
				  <?php print render($page['footer_three']); ?>
		    </div>
		    <?php endif; ?>
		    
		    <?php if (render($page['footer_four'])) : ?>
		    <div class="col-md-2">
				  <?php print render($page['footer_four']); ?>
		    </div>
		    <?php endif; ?>
			    
			</div>  
	  </div>	
	  <?php endif; ?>
	  
	  <div class="footer-copyright">  
	    <div class="container">
	      <div class="row">
			    <div class="col-md-6">
			    
					  <?php if (isset($page['bottom_left'])) : ?>
					    <?php print render($page['bottom_left']); ?>
					  <?php endif; ?>
			  
			    </div>
			    <div class="col-md-6">
			    
					  <?php if (isset($page['bottom_right'])) : ?>
					    <?php print render($page['bottom_right']); ?>
					  <?php endif; ?>
			  
			    </div>
	      </div>  
	    </div>
	  </div>  
	</footer>
