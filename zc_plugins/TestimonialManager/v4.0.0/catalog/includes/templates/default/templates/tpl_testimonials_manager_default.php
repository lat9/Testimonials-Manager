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
 * @version $Id: Testimonials_Manager.php  v3.0 5 02-20-2023 davewest $
 */
?>
<div class="centerColumn" id="testimonialDefault">
    <h1><?= HEADING_TITLE;  ?></h1>

    <div class="center">
<?php
/** display shop total reviews */
include $template->get_template_dir('/tpl_tm_total_reviews.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_tm_total_reviews.php';
?>
    </div>
<?php
$testimonial = $page_check->fields;
?>
    <fieldset class="coms_mid m-2">
        <p class="h3"><?= TEXT_CUSTOMER_REVIEW ?></h3>

        <div id="tm-name-stars-date">
            <div id="tm-name"><b><?= TESTIMONIALS_BY . zen_output_string_protected($testimonial['testimonials_name']) ?></b></div>

            <div id="tm-stars">
<?php 
$star1 = '';
for ($s = 1; $s <= $testimonial['tm_rating']; $s++) {
    $star1 .= TM_STAR_MD_FULL;
}
$star2 = '';
 for ($r = $testimonial['tm_rating']; $r <= 4; $r++) {
    $star2 .= TM_STAR_MD_EMPTY;
}
echo $star1 . $star2;
echo ($testimonial['tm_feedback'] !== '') ? '<b>' . zen_output_string_protected($testimonial['testimonials_title']) . ', ' . zen_output_string_protected($testimonial['tm_feedback']) . '</b>' : '';
?>
            </div>
<?php
if (DISPLAY_TESTIMONIALS_DATE_PUBLISHED === 'true') {
?>
            <div id="tm-dp"><?= zen_date_long($date_published) ?></div>
<?php
}
?>
        </div>
        <section class="coms_text">
            <p>
<?php
if ($testimonial['testimonials_upimg'] !== '') { 
    if (function_exists('zen_colorbox') && defined('ZEN_COLORBOX_STATUS') && ZEN_COLORBOX_STATUS === 'true') {
        echo '<a href="' . DIR_WS_IMAGES . $testimonial['testimonials_upimg'] . '" rel="tm-1" class="nofollow cboxElement" title="' . addslashes($testimonial['testimonials_title']) . '">' . zen_image(DIR_WS_IMAGES . $testimonial['testimonials_upimg'], $testimonial['testimonials_title'], 100) . '</a>';
    } else {
        echo '<a href="javascript:popupWindow(\'' . DIR_WS_IMAGES . $testimonial['testimonials_upimg'] . '\')">' . zen_image(DIR_WS_IMAGES . $testimonial['testimonials_upimg'], $testimonial['testimonials_title'], 100) . '</a>';
    }
}
echo zen_decode_specialchars($testimonial['testimonials_html_text']); //feedback
?>
            </p>
        </section>
        <br class="clearBoth">

        <div id="tm-helpful" class="alignRight text-right">
            <b class="pe-2"><?= TEXT_FEEDBACK_HELPFUL ?></b>
            <a class="tm-helpful" href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'action=helpyes&testimonials_id=' . $testimonial['testimonials_id'], $request_type) ?>">
                <?= BUTTON_YES_ALT ?>
            </a>
            <span id="tm-helpful-yes" class="px-2"><?= (string)$testimonial['helpful_yes'] ?></span>
            <a class="tm-helpful" href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'action=helpno&testimonials_id=' . $testimonial['testimonials_id'], $request_type) ?>">
                <?= BUTTON_NO_ALT ?>
            </a>
            <span id="tm-helpful-no" class="ps-2"><?= (string)$testimonial['helpful_no'] ?></span>
        </div>
    </fieldset> 
    <br class="clearBoth">

    <div class="buttonRow back"><?= zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>' ?></div>
    <div class="buttonRow forward">
        <a class="pe-2" href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER_ALL) ?>"><?= zen_image_button(BUTTON_IMAGE_VIEW_TESTIMONIALS, BUTTON_VIEW_TESTIMONIALS_ALT) ?></a>
        <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_ADD, '', 'SSL') ?>"><?= zen_image_button(BUTTON_IMAGE_TESTIMONIALS, BUTTON_TESTIMONIALS_ADD_ALT) ?></a>
    </div>
    <br class="clearBoth">
</div>
