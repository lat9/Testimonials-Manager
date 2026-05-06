<?php
/**
 * Testimonials Manager
 *
 * @package Template System
 * @copyright 2007 Clyde Jones
  * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Testimonials Manager  v3.0 5 02-20-2023 davewest $
 */
 
?>
<div class="centerColumn" id="testimonialDefault">

<?php echo HEADING_TITLE; ?>
<div class="center">
<?php
/** display shop total reviews */
 include($template->get_template_dir('/tpl_tm_total_reviews.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_tm_total_reviews.php'); ?>
</div>
<?php

if($layoutType == 'mobile') {
  if (($testimonials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
  <div id="allProductsListingTopNumber" class="navSplitPagesResult back"><?php echo $testimonials_split->display_count(TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS_MANAGER_ITEMS); ?></div>
  <div id="allProductsListingTopLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . $testimonials_split->display_mobile_links($max_display_page_links, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></div>
<?php
  }
}else{

  if (($testimonials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

  <div id="allProductsListingTopNumber" class="navSplitPagesResult back"><?php echo $testimonials_split->display_count(TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS_MANAGER_ITEMS); ?></div>
  <div id="allProductsListingTopLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . $testimonials_split->display_links($max_display_page_links, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></div>

<?php
  }else{
  echo '<h2 class="center">' . TEXT_REVIEW_SITE . '</h2>';
  }
}
?>
<br class="clearBoth" />

<br class="clearBoth" />
<br class="clearBoth" />

<?php
    $testimonials = $db->Execute($testimonials_split->sql_query);
    
    while (!$testimonials->EOF) {
	$date_published = $testimonials->fields['date_added'];
?> 


<fieldset class="coms_mid" style="width:90%;margin:1.2em;">

<h3><a href="<?php echo zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $testimonials->fields['testimonials_id']);?>"><?php echo $testimonials->fields['testimonials_title'];?></a></h3>

<?php echo ($testimonials->fields['tm_feedback'] != '') ? '<b>' . $testimonials->fields['tm_feedback'] . '</b><br /><br />' : ''; ?>

<div class="buttonRow ">&nbsp;&nbsp;&nbsp;
<?php 
 $star1 = '';
  for ($s=1; $s<=$testimonials->fields['tm_rating']; $s++) {
 $star1 .= '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(239,41,41,1)" width="18px" height="auto" viewBox="0 0 512 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
 }
 $star2 = '';
  for ($r=$testimonials->fields['tm_rating']; $r<=4; $r++) {
  $star2 .= '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(239,41,41,0.5)" width="18px" height="auto" viewBox="0 0 512 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
}
  echo $star1 . $star2; 
?>
<?php if (DISPLAY_TESTIMONIALS_DATE_PUBLISHED == 'true') { echo '<span class="forward">' . zen_date_long($date_published) . '</span>'; } ?>
</div>
<section class="coms_text">
<?php
   if (($testimonials->fields['testimonials_image']) != ('')) {
     echo zen_image(DIR_WS_IMAGES . $testimonials->fields['testimonials_image'], $testimonials->fields['testimonials_title'], TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT);
 }
?>
<?php echo '<p>' . zen_trunc_string(zen_decode_specialchars($testimonials->fields['testimonials_html_text']),TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH) . '<br /><span><strong><a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $testimonials->fields['testimonials_id']) . '">' .TESTIMONIALS_MANAGER_READ_MORE .'</a></strong></span></p>'; ?>
</section>
<br class="clearBoth" />
<div class="coms_extra back"><b><?php echo TESTIMONIALS_BY; ?> <?php echo $testimonials->fields['testimonials_name']; ?></b></div>

</fieldset> 
<br class="clearBoth" />




<?php
      $testimonials->MoveNext();
      }
?>


<?php
if($layoutType == 'mobile') {
  if (($testimonials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>
  <div id="allProductsListingTopNumber" class="navSplitPagesResult back"><?php echo $testimonials_split->display_count(TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS_MANAGER_ITEMS); ?></div>
  <div id="allProductsListingTopLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . $testimonials_split->display_mobile_links($max_display_page_links, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></div>
<?php
  }
}else{

  if (($testimonials_split->number_of_rows > 0) && ((PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3'))) {
?>

  <div id="allProductsListingTopNumber" class="navSplitPagesResult back"><?php echo $testimonials_split->display_count(TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS_MANAGER_ITEMS); ?></div>
  <div id="allProductsListingTopLinks" class="navSplitPagesLinks forward"><?php echo TEXT_RESULT_PAGE . $testimonials_split->display_links($max_display_page_links, zen_get_all_get_params(array('page', 'info', 'x', 'y', 'main_page')), $paginateAsUL); ?></div>

<?php
  }
}
?>
<br class="clearBoth" />
<br class="clearBoth" />
<div class="buttonRow back"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>
<div class="buttonRow forward"><a href="<?php echo zen_href_link(FILENAME_TESTIMONIALS_ADD, '', 'SSL'); ?>"><?php echo zen_image_button(BUTTON_IMAGE_TESTIMONIALS, BUTTON_TESTIMONIALS_ADD_ALT); ?></a></div>

<br class="clearBoth" />
</div>
