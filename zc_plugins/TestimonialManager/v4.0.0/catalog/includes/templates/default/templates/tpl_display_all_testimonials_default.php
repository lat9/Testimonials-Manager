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
 * @version $Id: Testimonials Manager  v3.0 5 02-20-2023 davewest $
 */
?>
<div class="centerColumn" id="testimonialDefault">
    <h1><?= HEADING_TITLE ?></h1>
    <div class="center">
<?php
/** display shop total reviews */
include $template->get_template_dir('/tpl_tm_total_reviews.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_tm_total_reviews.php';
?>
    </div>
<?php
$all_get_params = zen_get_all_get_params(['page', 'info', 'x', 'y', 'main_page']);
if (($layoutType ?? '') === 'mobile') {
    if ($testimonials_split->number_of_rows > 0 && (PREV_NEXT_BAR_LOCATION === '1' || PREV_NEXT_BAR_LOCATION === '3')) {
?>
    <div id="allProductsListingTopNumber" class="navSplitPagesResult back">
        <?= $testimonials_split->display_count(TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS_MANAGER_ITEMS) ?>
    </div>
    <div id="allProductsListingTopLinks" class="navSplitPagesLinks forward">
        <?= TEXT_RESULT_PAGE . $testimonials_split->display_mobile_links($max_display_page_links, $all_get_params, $paginateAsUL) ?>
    </div>
<?php
    }
} elseif ($testimonials_split->number_of_rows > 0 && (PREV_NEXT_BAR_LOCATION === '1' || PREV_NEXT_BAR_LOCATION === '3')) {
?>
    <div id="allProductsListingTopNumber" class="navSplitPagesResult back"><?= $testimonials_split->display_count(TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS_MANAGER_ITEMS) ?></div>
    <div id="allProductsListingTopLinks" class="navSplitPagesLinks forward">
        <?= TEXT_RESULT_PAGE . $testimonials_split->display_links($max_display_page_links, $all_get_params, $paginateAsUL) ?>
    </div>
<?php
} else {
?>
    <h2 class="center"><?= TEXT_REVIEW_SITE ?></h2>
<?php
}

$testimonials = $db->Execute($testimonials_split->sql_query);
foreach ($testimonials as $next_item) {
    $date_published = $next_item['date_added'];
?>
    <fieldset class="coms_mid" style="width:90%;margin:1.2em;">
        <h3><a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $next_item['testimonials_id']) ?>"><?= $next_item['testimonials_title'] ?></a></h3>

        <?= ($next_item['tm_feedback'] != '') ? '<b>' . $next_item['tm_feedback'] . '</b><br><br>' : '' ?>

        <div class="buttonRow ">&nbsp;&nbsp;&nbsp;
<?php 
    $star1 = '';
    for ($s = 1; $s <= $next_item['tm_rating']; $s++) {
        $star1 .= '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(239,41,41,1)" width="18px" height="auto" viewBox="0 0 512 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
    }
    $star2 = '';
    for ($r = $next_item['tm_rating']; $r <=4 ; $r++) {
        $star2 .= '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(239,41,41,0.5)" width="18px" height="auto" viewBox="0 0 512 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
    }
    echo $star1 . $star2; 
    if (DISPLAY_TESTIMONIALS_DATE_PUBLISHED === 'true') {
?>
            <span class="forward"><?= zen_date_long($date_published) ?></span>
<?php
    }
?>
        </div>
        <section class="coms_text">
<?php
    if ($next_item['testimonials_image'] !== '') {
        echo zen_image(DIR_WS_IMAGES . $next_item['testimonials_image'], $next_item['testimonials_title'], TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT);
    }
?>
            <p>
                <?= zen_trunc_string(zen_decode_specialchars($next_item['testimonials_html_text']), TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH) ?>
                <br>
                <span><strong>
                    <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $next_item['testimonials_id']) ?>">
                        <?= TESTIMONIALS_MANAGER_READ_MORE ?>
                    </a>
                </strong></span>
            </p>
        </section>
        <br class="clearBoth">
        <div class="coms_extra back"><b><?= TESTIMONIALS_BY ?> <?= zen_output_string_protected($next_item['testimonials_name']) ?></b></div>
    </fieldset> 
    <br class="clearBoth">
<?php
}

if ($layoutType === 'mobile') {
    if ($testimonials_split->number_of_rows > 0 && (PREV_NEXT_BAR_LOCATION === '1' || PREV_NEXT_BAR_LOCATION === '3')) {
?>
    <div id="allProductsListingTopNumber" class="navSplitPagesResult back"><?= $testimonials_split->display_count(TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS_MANAGER_ITEMS) ?></div>
    <div id="allProductsListingTopLinks" class="navSplitPagesLinks forward">
        <?= TEXT_RESULT_PAGE . $testimonials_split->display_mobile_links($max_display_page_links, $all_get_params, $paginateAsUL) ?>
    </div>
<?php
    }
} elseif ($testimonials_split->number_of_rows > 0 && (PREV_NEXT_BAR_LOCATION === '1' || PREV_NEXT_BAR_LOCATION === '3')) {
?>
    <div id="allProductsListingTopNumber" class="navSplitPagesResult back"><?= $testimonials_split->display_count(TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS_MANAGER_ITEMS) ?></div>
    <div id="allProductsListingTopLinks" class="navSplitPagesLinks forward">
        <?= TEXT_RESULT_PAGE . $testimonials_split->display_links($max_display_page_links, $all_get_params, $paginateAsUL) ?>
    </div>
<?php
}
?>
    <br class="clearBoth">
    <br>
    <div class="buttonRow back"><?= zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>' ?></div>
    <div class="buttonRow forward"><a href="<?= zen_href_link(FILENAME_TESTIMONIALS_ADD, '', 'SSL') ?>"><?= zen_image_button(BUTTON_IMAGE_TESTIMONIALS, BUTTON_TESTIMONIALS_ADD_ALT) ?></a></div>

    <br class="clearBoth">
</div>
