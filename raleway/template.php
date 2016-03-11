<?php

/**
 * @file
 * template.php
 */
function raleway_process_page(&$variables) {
  if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
    $variables['content_column_class'] = ' class="col-sm-6"';
  }
  elseif (!empty($variables['page']['sidebar_first']) || !empty($variables['page']['sidebar_second'])) {
    $variables['content_column_class'] = ' class="col-sm-9"';
  }
  else {
    $variables['content_column_class'] = ' class="col-sm-12"';
  }
  
  // Primary nav.
  $variables['primary_nav'] = FALSE;
  if ($variables['main_menu']) {
    // Build links.
    $variables['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function.
    $variables['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }

  // Secondary nav.
  $variables['secondary_nav'] = FALSE;
  if ($variables['secondary_menu']) {
    // Build links.
    $variables['secondary_nav'] = menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
    // Provide default theme wrapper function.
    $variables['secondary_nav']['#theme_wrappers'] = array('menu_tree__secondary');
  }
 
  $variables['navbar_classes'] = 'navbar navbar-default';
}


/**
 * Assign theme hook suggestions for custom templates and pass color theme setting
 * to skin.less file.
 */  
function raleway_preprocess_page(&$vars, $hook) {
   
  if (isset($vars['node'])) {
    $suggest = "page__node__{$vars['node']->type}";
    $vars['theme_hook_suggestions'][] = $suggest;
  }
 
  if (theme_get_setting('gradient') == "1") {
	  //Pass the color value from theme settings to @styleColor variable in skin.less
	  drupal_add_css(drupal_get_path('theme', 'raleway') .'/css/less/skin-gradient.less', array(
	  
	    'group' => CSS_THEME,
	    'preprocess' => false,
	    'less' => array(
	      'variables' => array(
	        '@styleColor' => '#'.theme_get_setting('style_color').'',
	      ),
	    ),
	
	  )); 
	} 
	
	if (theme_get_setting('gradient') == "0") {
	  //Pass the color value from theme settings to @styleColor variable in skin.less
	  drupal_add_css(drupal_get_path('theme', 'raleway') .'/css/less/skin.less', array(
	  
	    'group' => CSS_THEME,
	    'preprocess' => false,
	    'less' => array(
	      'variables' => array(
	        '@styleColor' => '#'.theme_get_setting('style_color').'',
	      ),
	    ),
	
	  )); 
	}
	 
}

function raleway_menu_local_tasks(&$variables) {
  $output = '';
 
  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs--primary nav nav-tabs">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }

  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs--secondary pagination pagination-sm">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }

  return $output;
}

function raleway_menu_tree(&$vars) {
  return '<ul class="menu nav">' . $vars['tree'] . '</ul>';
}

/**
 * raleway theme wrapper function for the primary menu links.
 */
function raleway_menu_tree__primary(&$vars) {
  return '<ul id="nav" class="menu nav navbar-nav">' . $vars['tree'] . '</ul>';
}

/**
 * raleway theme wrapper function for the secondary menu links.
 */
function raleway_menu_tree__secondary(&$vars) {
  return '<ul class="menu nav navbar-nav">' . $vars['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_link().
 */
function raleway_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      $element['#title'] .= ' <span class="caret"></span>';
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  // On primary navigation menu, class 'active' is not set on active menu item.
  // @see https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

function raleway_preprocess_button(&$vars) {
  $vars['element']['#attributes']['class'][] = 'btn btn-primary';
}
 
function raleway_preprocess_views_view_table(&$vars) {
  $vars['classes_array'][] = 'table table-striped';
}

function raleway_css_alter(&$css) {
    $theme_path = drupal_get_path('theme', 'raleway');
    $bootstrap_cdn = '3.3.4';
    $cdn = '//netdna.bootstrapcdn.com/bootstrap/' . $bootstrap_cdn  . '/css/bootstrap.min.css';
    
    $css[$cdn] = array(
      'data' => $cdn,
      'type' => 'external',
      'every_page' => TRUE,
      'media' => 'all',
      'preprocess' => FALSE,
      'group' => CSS_THEME,
      'browsers' => array('IE' => TRUE, '!IE' => TRUE),
      'weight' => -2,
    );
    // Add overrides.
    $override = $theme_path . '/css/overrides.css';
    $css[$override] = array(
      'data' => $override,
      'type' => 'file',
      'every_page' => TRUE,
      'media' => 'all',
      'preprocess' => TRUE,
      'group' => CSS_THEME,
      'browsers' => array('IE' => TRUE, '!IE' => TRUE),
      'weight' => -1,
    );

}

/**
 * Implements hook_element_info_alter().
 */
function raleway_element_info_alter(&$elements) {
  foreach ($elements as &$element) {
    // Process all elements.
    $element['#process'][] = '_raleway_process_element';
 
  }
}

/**
 * Process all elements.
 */
function _raleway_process_element(&$element, &$form_state) {
  //Boostrap style
  if (!empty($element['#attributes']['class']) && is_array($element['#attributes']['class'])) {
    if (in_array('container-inline', $element['#attributes']['class'])) {
      $element['#attributes']['class'][] = 'form-inline';
    }
    if (in_array('form-wrapper', $element['#attributes']['class'])) {
      $element['#attributes']['class'][] = 'form-group';
    }
  }
  //TextField process
  if (theme_get_setting('placeholder') == "1") {
  if ( !empty($element['#type']) && ($element['#type'] == 'textfield' || $element['#type'] == 'password' ) ) {
    if(isset($element['#title'])){
      $element['#attributes']['placeholder'] = $element['#title'];
      $element['#title_display'] = 'none';
    }
    
    if ( !empty($element['#required']) && $element['#required'] == 1 ) { 
      $prefix = '<div class="field-relative">';
      $suffix = '<span class="form-required suffix-required" title="This field is required.">*</span>';
      $suffix .= '</div>';
      $element['#field_prefix'] = isset($element['#field_prefix']) ? $element['#field_prefix'] . $prefix : $prefix;
      $element['#field_suffix'] = isset($element['#field_suffix']) ? $element['#field_suffix'] . $suffix : $suffix;
  
    }   
  }
  }
  //HTML 5 
  if ( !empty($element['#required']) && $element['#required'] == 1 ) {
    $element['#attributes']['required'] = '';
  }
  
  $types = array(
    // Core.
    'password',
    'password_confirm',
    'select',
    'textarea',
    'textfield',
    // Elements module.
    'emailfield',
    'numberfield',
    'rangefield',
    'searchfield',
    'telfield',
    'urlfield',
  );
  if (!empty($element['#type']) && (in_array($element['#type'], $types) || ($element['#type'] === 'file' && empty($element['#managed_file'])))) {
    $element['#attributes']['class'][] = 'form-control';
  }
   
  return $element;
}
/**
 * Implements hook_js_alter().
 */
function raleway_js_alter(&$js) { 
   /* $cdn = '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js';
    $js[$cdn] = drupal_js_defaults();
    $js[$cdn]['data'] = $cdn;
    $js[$cdn]['type'] = 'external';
    $js[$cdn]['every_page'] = TRUE;
    $js[$cdn]['weight'] = -100;*/
   
}

/**
 * Implements hook_form_alter().
 */
function raleway_form_alter(array &$form, array &$form_state = array(), $form_id = NULL) {
  if ($form_id) {
    // IDs of forms that should be ignored. Make this configurable?
    // @todo is this still needed?
    $form_ids = array(
      'node_form',
      'user_profile_form',
      'node_delete_confirm',
    );
    // Only wrap in container for certain form.
    if (!in_array($form_id, $form_ids) && !isset($form['#node_edit_form']) && isset($form['actions']) && isset($form['actions']['#type']) && ($form['actions']['#type'] == 'actions')) {
      $form['actions']['#theme_wrappers'] = array();
    }

    switch ($form_id) {
 

      case 'search_form':
        // Add a clearfix class so the results don't overflow onto the form.
        $form['#attributes']['class'][] = 'clearfix';

        // Remove container-inline from the container classes.
        $form['basic']['#attributes']['class'] = array();

        // Hide the default button from display.
        $form['basic']['submit']['#attributes']['class'][] = 'element-invisible';

        // Implement a theme wrapper to add a submit button containing a search
        // icon directly after the input element.
        $form['basic']['keys']['#theme_wrappers'] = array('raleway_search_form_wrapper');
        $form['basic']['keys']['#title'] = '';
        $form['basic']['keys']['#attributes']['placeholder'] = t('Search');
        break;

      case 'search_block_form':
        
                $form['#attributes']['class'][] = 'form-search';

        $form['search_block_form']['#title'] = '';
        $form['search_block_form']['#attributes']['placeholder'] = t('Search');

        // Hide the default button from display and implement a theme wrapper
        // to add a submit button containing a search icon directly after the
        // input element.
        $form['actions']['submit']['#attributes']['class'][] = 'element-invisible';
        $form['search_block_form']['#theme_wrappers'] = array('raleway_search_form_wrapper');

        // Apply a clearfix so the results don't overflow onto the form.
        $form['#attributes']['class'][] = 'content-search';
        break;
      }

  }
}

/**
 * Overrides theme_form_element_label().
 */
function raleway_form_element_label(&$variables) {
  $element = $variables['element'];

  // This is also used in the installer, pre-database setup.
  $t = get_t();

  // Determine if certain things should skip for checkbox or radio elements.
  $skip = (isset($element['#type']) && ('checkbox' === $element['#type'] || 'radio' === $element['#type']));

  // If title and required marker are both empty, output no label.
  if ((!isset($element['#title']) || $element['#title'] === '' && !$skip) && empty($element['#required'])) {
    return '';
  }

  // If the element is required, a required marker is appended to the label.
  $required = !empty($element['#required']) ? theme('form_required_marker', array('element' => $element)) : '';

  $title = filter_xss_admin($element['#title']);

  $attributes = array();

  // Style the label as class option to display inline with the element.
  if ($element['#title_display'] == 'after' && !$skip) {
    $attributes['class'][] = $element['#type'];
  }
  // Show label only to screen readers to avoid disruption in visual flows.
  elseif ($element['#title_display'] == 'invisible') {
    $attributes['class'][] = 'element-invisible';
  }

  if (!empty($element['#id'])) {
    $attributes['for'] = $element['#id'];
  }

  // Insert radio and checkboxes inside label elements.
  $output = '';
  if (isset($variables['#children'])) {
    $output .= $variables['#children'];
  }

  // Append label.
  $output .= $t('!title !required', array('!title' => $title, '!required' => $required));

  // The leading whitespace helps visually separate fields from inline labels.
  return ' <label' . drupal_attributes($attributes) . '>' . $output . "</label>\n";
}

 
        
function raleway_raleway_search_form_wrapper($variables) {

  $output = '<div class="input-group">';
  $output .= $variables['element']['#children'];
  $output .= '<span class="input-group-btn">';
  $output .= '<button type="submit" class="btn btn-default">';
 
  //$output .= t('Search');
  $output .= '<i aria-hidden="true" class="icon glyphicon glyphicon-search"></i>';
  $output .= '</button>';
  $output .= '</span>';
  $output .= '</div>';
  return $output;
}

/**
 * Stub implementation for hook_theme().
 *
 * @see hook_theme()
 */
function raleway_theme(&$existing, $type, $theme, $path) {
  // Custom theme hooks:
  // Do not define the `path` or `template`.
  $hook_theme = array(
    'raleway_search_form_wrapper' => array(
      'render element' => 'element',
    ),
  );

  return $hook_theme;
}

/**
 * Put Breadcrumbs in a ul li structure and add descending z-index style to each <a href> tag.
 */
function raleway_breadcrumb($variables) {
 $breadcrumb = $variables['breadcrumb'];
 $title = drupal_get_title();
 $crumbs = '';
 
 if (!empty($breadcrumb)) {
   $crumbs = '<ul class="breadcrumb">';
   foreach($breadcrumb as $value) {
     $crumbs .= '<li>'.$value.'</li> ';
   }
   
   $crumbs .= '</ul>';
    
 }
 return $crumbs;
}
/**
 * Impelements theme_status_messages()
 */
function raleway_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  foreach (drupal_get_messages($display) as $type => $messages) {
    switch ($type) {
	    case 'status':
	      $output .= "<div class=\"alert alert-success\">\n";
	    break;
	    case 'warning':
	      $output .= "<div class=\"alert alert-warning\">\n";
	    break;
	    case 'error':
	      $output .= "<div class=\"alert alert-danger\">\n";
	    break;
	    default: 
	      $output .= "<div class=\"messages $type\">\n";
	    break;
    }
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "</div>\n";
  }
  return $output;
}