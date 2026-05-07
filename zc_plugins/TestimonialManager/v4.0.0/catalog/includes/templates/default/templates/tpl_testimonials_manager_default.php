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
    <h1><?php echo HEADING_TITLE;  ?></h1>

    <div class="center">
<?php
/** display shop total reviews */
include $template->get_template_dir('/tpl_tm_total_reviews.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_tm_total_reviews.php';
?>
    </div>

    <fieldset class="coms_mid" style="width:90%;margin:1.2em;">
        <h3><?php echo 'Customer Review'; ?></h3>

        <div style="border:2px solid rgba(0,0,0,0);">
            <div style="float:left;margin:1em;"><?php echo zen_image(DIR_WS_IMAGES . $page_check->fields['testimonials_image'], $page_check->fields['testimonials_title'], TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT); // display avatar ?></div>
            <div style="margin-top:2em;"><b >by: <?php echo $page_check->fields['testimonials_name']; ?></b></div>
        </div>
        <br class="clearBoth">
        <div>
<?php 
$star1 = '';
for ($s = 1; $s <= $page_check->fields['tm_rating']; $s++) {
    $star1 .= '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(239,41,41,1)" width="24px" height="auto" viewBox="0 0 576 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';
}
$star2 = '';
 for ($r = $page_check->fields['tm_rating']; $r <= 4; $r++) {
    $star2 .= '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(239,41,41,1)" width="24px" height="auto" viewBox="0 0 576 512"><path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"/></svg>';
}
echo $star1 . $star2; 
echo ($page_check->fields['tm_feedback'] !== '') ? '&nbsp;&nbsp;&nbsp;<b>' . $page_check->fields['testimonials_title'] . ', ' . $page_check->fields['tm_feedback'] . '</b>' : '';
?>
        </div>
<?php
if (DISPLAY_TESTIMONIALS_DATE_PUBLISHED === 'true') {
    echo '<p>' . zen_date_long($date_published) . '</p>';
}
?>
        <section class="coms_text">
            <p>
<?php
if ($page_check->fields['testimonials_upimg'] !== '') { 
    if (function_exists('zen_colorbox') && defined('ZEN_COLORBOX_STATUS') && ZEN_COLORBOX_STATUS === 'true') {
        echo '<a href="' . DIR_WS_IMAGES . $page_check->fields['testimonials_upimg'] . '" rel="tm-1" class="nofollow cboxElement" title="' . addslashes($page_check->fields['testimonials_title']) . '">' . zen_image(DIR_WS_IMAGES . $page_check->fields['testimonials_upimg'], $page_check->fields['testimonials_title'], 100) . '</a>';
    } else {
        echo '<a href="javascript:popupWindow(\'' . DIR_WS_IMAGES . $page_check->fields['testimonials_upimg'] . '\')">' . zen_image(DIR_WS_IMAGES . $page_check->fields['testimonials_upimg'], $page_check->fields['testimonials_title'], 100) . '</a>';
    }
}
echo zen_decode_specialchars($page_check->fields['testimonials_html_text']); //feedback
?>
            </p>
        </section>
        <br class="clearBoth">

        <div class="forward">
            <b>Was this site feedback helpful to you? </b> &nbsp;&nbsp;
            <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'action=helpyes&testimonials_id=' . $page_check->fields['testimonials_id'], $request_type) ?>">
                <span class="btnreview"><?= BUTTON_YES_ALT ?></span>
            </a>&nbsp;
            <?= (string)$page_check->fields['helpful_yes'] ?>
            &nbsp;
            <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'action=helpno&testimonials_id=' . $page_check->fields['testimonials_id'], $request_type) ?>">
                <span class="btnreview"><?= BUTTON_NO_ALT ?></span>
            </a>&nbsp;
            <?= (string)$page_check->fields['helpful_no'] ?>
    </fieldset> 
    <br class="clearBoth">

    <div class="buttonRow back"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>
    <div class="buttonRow forward">
        <a href="<?php echo zen_href_link(FILENAME_TESTIMONIALS_MANAGER_ALL); ?>"><?php echo zen_image_button(BUTTON_IMAGE_VIEW_TESTIMONIALS, BUTTON_VIEW_TESTIMONIALS_ALT); ?></a>
    </div>
    <br class="clearBoth">
    <br>
    <div class="buttonRow forward">
        <a href="<?php echo zen_href_link(FILENAME_TESTIMONIALS_ADD, '', 'SSL'); ?>"><?php echo zen_image_button(BUTTON_IMAGE_TESTIMONIALS, BUTTON_TESTIMONIALS_ADD_ALT); ?></a>
    </div>
    <br class="clearBoth">
</div>
