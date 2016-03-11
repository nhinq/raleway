<?php
/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 */
$html_attributes = "lang=\"{$language->language}\" dir=\"{$language->dir}\"";
?>
 
<?php global $base_url;  ?>

<!--[if IE 8 ]><html <?php print $html_attributes; ?> class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html <?php print $html_attributes; ?> class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php print $html_attributes; ?> class="no-js"><!--<![endif]-->


<head >

  <?php print $head; ?>
  <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
  <!--  Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width; initial-scale=0.9; maximum-scale=0.9; minimum-scale=0.9;" />
 
  
  <title><?php print $head_title; ?></title>
  
  
  <!--[if LT IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <?php print $styles; ?>
  <?php print $scripts; ?>
   
</head>
<body id="body" class="<?php print $classes; ?>" <?php print $attributes;?>>
   
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
 <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>   
</body>

</html>