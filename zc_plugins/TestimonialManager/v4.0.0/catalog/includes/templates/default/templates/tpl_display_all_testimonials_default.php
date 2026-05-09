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
    <fieldset class="tm-info">
        <div class="h3">
            <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $next_item['testimonials_id']) ?>">
                <?= zen_output_string_protected($next_item['testimonials_title']) ?>
            </a>
        </div>

        <?= ($next_item['tm_feedback'] != '') ? '<b>' . $next_item['tm_feedback'] . '</b><br><br>' : '' ?>

        <div id="tm-stars-date">
            <div><b><?= TESTIMONIALS_BY . zen_output_string_protected($next_item['testimonials_name']) ?></b></div>
<?php
    $star1 = '';
    for ($s = 1; $s <= $next_item['tm_rating']; $s++) {
        $star1 .= TM_STAR_SM_FULL;
    }
    $star2 = '';
    for ($r = $next_item['tm_rating']; $r <= 4; $r++) {
        $star2 .= TM_STAR_SM_EMPTY;
    }
?>
            <div><?= $star1 . $star2 ?></div>
<?php
    if (DISPLAY_TESTIMONIALS_DATE_PUBLISHED === 'true') {
?>
            <div><?= zen_date_long($date_published) ?></div>
<?php
    }
?>
        </div>
        <section class="coms_text">
            <p>
                <?= zen_trunc_string(zen_decode_specialchars($next_item['testimonials_html_text']), TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH) ?>
            </p>
            <div class="textRight text-right">
                <strong>
                    <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $next_item['testimonials_id']) ?>">
                        <?= TESTIMONIALS_MANAGER_READ_MORE ?>
                    </a>
                </strong>
            </p>
        </section>
    </fieldset> 
<?php
}

if (($layoutType ?? '') === 'mobile') {
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
    <div id="button-row">
        <div class="buttonRow"><?= zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>' ?></div>
        <div class="buttonRow"><a href="<?= zen_href_link(FILENAME_TESTIMONIALS_ADD, '', 'SSL') ?>"><?= zen_image_button(BUTTON_IMAGE_TESTIMONIALS, BUTTON_TESTIMONIALS_ADD_ALT) ?></a></div>
    </div>
</div>
