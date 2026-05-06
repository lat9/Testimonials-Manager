<?php
/**
 * Testimonials Manager
 *
 * @package Template System
 * @copyright 2007 Clyde Jones
  * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Testimonials Manager v3.0 5 02-20-2023 davewest $
 * Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. 
 */
$content = '';


  $content .= '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent">';
  for ($i=1; $i<=sizeof($page_query_list); $i++) {
  
 $star1 = '';
  for ($s=1; $s<=$page_query_list[$i]['rating']; $s++) {
 $star1 .= '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(239,41,41,1)" width="12px" height="auto" viewBox="0 0 512 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
 }
 $star2 = '';
  for ($r=$page_query_list[$i]['rating']; $r<=4; $r++) {
  $star2 .= '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(0,0,0,.5)" width="12px" height="auto" viewBox="0 0 512 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
}
  
  $content .= '<b><a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $page_query_list[$i]['id']) . '">' . $page_query_list[$i]['name'] . '</a></b><div class="testimonial">';

  $content .= '<div class="buttonRow ">' . $star1 . $star2 . '</div>';
  
if ($page_query_list[$i]['image'] != '') {  
$content .= '<p class="testimonialImage">' . zen_image(DIR_WS_IMAGES . $page_query_list[$i]['image'], $page_query_list[$i]['name'], TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT) . '</p>';  
  }
  if (DISPLAY_TESTIMONIALS_MANAGER_TRUNCATED_TEXT == 'true') {
    $content .= '<p>' . zen_trunc_string($page_query_list[$i]['story'],TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH) . '<br /><span><strong><a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $page_query_list[$i]['id']) . '">' .TESTIMONIALS_MANAGER_READ_MORE .'</a></strong></span></p></div>';
	$content .= '<hr class="catBoxDivider" />';
  }
  }
  if (DISPLAY_ALL_TESTIMONIALS_TESTIMONIALS_MANAGER_LINK == 'true') {
  $content .= '<div class="bettertestimonial"><a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER_ALL) . '">' . TESTIMONIALS_MANAGER_DISPLAY_ALL_TESTIMONIALS . '</a></div>';
 }
  if (DISPLAY_ADD_TESTIMONIAL_LINK == 'true') {
  $content .= '<div class="bettertestimonial"><a href="' . zen_href_link(FILENAME_TESTIMONIALS_ADD, '', 'SSL') . '">' . TESTIMONIALS_MANAGER_ADD_TESTIMONIALS . '</a></div>';
 }
$content .= '</div>';
