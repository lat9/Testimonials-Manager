<?php
/**
 * Testimonials Manager
 *
 * Last updated: v4.0.0
 *
 * @package Template System
 * @copyright 2007 Clyde Jones
  * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Testimonials_Manager.php v2.0 11-14-2018 davewest $
 */
$page_query = $db->Execute(
    "SELECT testimonials_id, tm_rating, testimonials_image, testimonials_title, testimonials_html_text, date_added
       FROM " . TABLE_TESTIMONIALS_MANAGER . "
      WHERE status = 1
        AND tm_make_public = 'yes'
        AND language_id = " . (int)$_SESSION['languages_id'] . "
      ORDER BY RAND(), testimonials_title
      LIMIT " . (int)MAX_DISPLAY_TESTIMONIALS_MANAGER_TITLES
);
if ($page_query->EOF) {
    return;
}

$page_query_list = [];
foreach ($page_query as $next_item) {
    $page_query_list[] = [
        'id' => (int)$next_item['testimonials_id'],
        'name' => zen_output_string_protected($next_item['testimonials_title']),
        'story' => zen_clean_html($next_item['testimonials_html_text']),
        'rating' => (int)$next_item['tm_rating'],
    ];
}

$title_link = false;
$title =  BOX_HEADING_TESTIMONIALS_MANAGER;
require $template->get_template_dir('tpl_testimonials_manager.php', DIR_WS_TEMPLATE, $current_page_base, 'sideboxes') . '/tpl_testimonials_manager.php';
require $template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base, 'common') . '/' . $column_box_default;
