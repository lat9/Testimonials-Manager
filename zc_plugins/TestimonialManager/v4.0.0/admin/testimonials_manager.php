<?php
/**
 * Testimonials Manager
 *
 * Last updated: v4.0.0
 *
 * @package Template System
 * @copyright 2007 Clyde Jones
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Testimonials Manager v3.0 13 9-19-2022 davewest $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

require 'includes/application_top.php';
  
//is working? or not z157
$testimonials_sanitizer = AdminRequestSanitizer::getInstance();
$testimonials_group = ['testimonials_html_text'];
$testimonials_sanitizer->addSimpleSanitization('WORDS_AND_SYMBOLS_REGEX', $testimonials_group);

$testimonials_group = ['testimonials_html_text'];
$testimonials_sanitizer->addSimpleSanitization('PRODUCT_DESC_REGEX', $testimonials_group);

$action = $_GET['action'] ?? '';

$pagenum = (int)($_GET['page'] ?? 1);
if ($pagenum < 1) {
    $pagenum = 1;
}
$page_param = ($pagenum === 1) ? '' : "page=$pagenum";

$testimonialsID = [];  //checkboxes for deleting testimonials

switch ($action) {
    case 'setflag':
        $testimonials_id = (int)($_GET['bID'] ?? 0);
        if (!in_array(($_GET['flag'] ?? 'not-set'), ['0', '1', '2'])) {
            $messageStack->add_session(ERROR_UNKNOWN_STATUS_FLAG, 'error');
        } else {
            $status = (int)$_GET['flag'];

            $db->Execute("UPDATE " . TABLE_TESTIMONIALS_MANAGER . " SET status = $status WHERE testimonials_id = $testimonials_id");
            $messageStack->add_session(SUCCESS_PAGE_STATUS_UPDATED, 'success');
        } 
        zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $_GET['bID']));
        break;

    case 'set_editor':
        // Reset will be done by init_html_editor.php. Now we simply redirect to refresh page properly.
        zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . (!empty($_GET['bID'])) ? '&bID=' . $_GET['bID'] : ''));
        break;

    case 'insert':
    case 'update':
        if (!isset($_POST['testimonials_title'], $_POST['testimonials_name'], $_POST['testimonials_mail'],
            $_POST['tm_contact_user'], $_POST['tm_make_public'], $_POST['testimonials_html_text'])) {
            zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER));
        }

        $testimonials_title = zen_db_prepare_input(zen_sanitize_string($_POST['testimonials_title']));
        $testimonials_name = zen_db_prepare_input(zen_sanitize_string($_POST['testimonials_name']));
        $testimonials_mail = zen_db_prepare_input($_POST['testimonials_mail']);
        $feedback =   !empty($_POST['tm_feedback']) ? zen_db_prepare_input(zen_sanitize_string($_POST['tm_feedback'])) : '';
        $contact_user = zen_db_prepare_input($_POST['tm_contact_user']);
        $contact_phone = !empty($_POST['tm_contact_phone']) ? zen_db_prepare_input($_POST['tm_contact_phone']) : '';
        $make_public = zen_db_prepare_input($_POST['tm_make_public']);
        $testimonials_date = (empty($_POST['date_added']) ? date('Y-m-d h:i:s', time()) : zen_db_prepare_input($_POST['date_added']));
        $testimonials_html_text = zen_db_prepare_input($_POST['testimonials_html_text']);

        $page_error = false;
        if (empty($testimonials_name)) {
            $messageStack->add(ERROR_PAGE_AUTHOR_REQUIRED, 'error');
            $page_error = true;
        }
        if (empty($testimonials_mail)) {
            $messageStack->add(ERROR_PAGE_EMAIL_REQUIRED, 'error');
            $page_error = true;
        }
        if (empty($testimonials_title)) {
            $messageStack->add(ERROR_PAGE_TITLE_REQUIRED, 'error');
            $page_error = true;
        }
        if (empty($testimonials_html_text)) {
            $messageStack->add(ERROR_PAGE_TEXT_REQUIRED, 'error');
            $page_error = true;
        }
        if ($page_error === true) {
            $action = ($action === 'insert') ? 'new' : 'edit';
            break;
        }

        $language_id = (int)$_SESSION['languages_id'];

        $sql_data_array = [
            'language_id' => (int)$language_id, 
            'testimonials_title' => $testimonials_title,
            'testimonials_name' => $testimonials_name,
            'testimonials_html_text' => $testimonials_html_text,
            'testimonials_mail' => $testimonials_mail,
            'status' => (int)$_POST['tm_status'],
            'tm_rating' => (int)$_POST['tm_rating'],
            'tm_feedback' => $feedback,
            'tm_contact_user' => $contact_user,
            'tm_contact_phone' => $contact_phone,
            'tm_privacy_conditions' => (int)$_POST['tm_privacy_conditions'], 
            'helpful_yes' => (int)$_POST['helpful_yes'],
            'helpful_no' => (int)$_POST['helpful_no'],
            'tm_make_public' => $make_public,
            'testimonials_upimg' => ''
        ];
        $imageIMAGE = !empty($_POST['avatar_image']) ? $_POST['avatar_image'] : '';
        $imageOLD = zen_db_prepare_input($_POST['old_avatar']);
        if ($imageIMAGE !== $imageOLD) {
            // add image manually
            $sql_data_array['testimonials_image'] = $imageIMAGE;
        }

        if ($action === 'insert') {
            if (empty($_POST['date_added'])) {
                $testimonials_date = 'now()';
            } else  {
                $testimonials_date = zen_db_prepare_input($_POST['date_added']);
                if (DATE_FORMAT_DATE_PICKER != 'yy-mm-dd') {
                    $local_fmt = zen_datepicker_format_fordate();
                    $dt = DateTime::createFromFormat($local_fmt, $testimonials_date);
                    $testimonials_date = $dt->format('Y-m-d');
                }
                $testimonials_date = (date('Y-m-d') < $testimonials_date) ? $testimonials_date : 'null';
            }

            $sql_data_array['date_added'] = $testimonials_date;

            zen_db_perform(TABLE_TESTIMONIALS_MANAGER, $sql_data_array);
            $testimonials_id = zen_db_insert_id();
            $messageStack->add_session(SUCCESS_PAGE_INSERTED, 'success');
        } else {
            $sql_data_array['last_update'] = 'now()';

            $testimonials_id = (int)($_POST['testimonials_id'] ?? -1);
            zen_db_perform(TABLE_TESTIMONIALS_MANAGER, $sql_data_array, 'update', "testimonials_id = $testimonials_id");

            $messageStack->add_session(SUCCESS_PAGE_UPDATED, 'success');
        }

        zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonials_id));
        break;

    case 'deleteconfirm':
        $testimonialsID = $_SESSION['deleteTest'] ?? [];
        $howmany = (is_array($testimonialsID)) ? count($testimonialsID) : 0;  //number of testimonials to delete
        for ($i = 0, $n = $howmany; $i <$ n; $i++) {  // Loop to get the values of individual checked checkboxes.
            $db->Execute("DELETE FROM " . TABLE_TESTIMONIALS_MANAGER . " WHERE testimonials_id = " . (int)$testimonialsID[$i] . " LIMIT 1");
        }

        $messageStack->add_session(SUCCESS_PAGE_REMOVED, 'success');
        zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param));
        break;

    case 'imagedelete':  
        $testimonials_id = (int)zen_db_prepare_input($_GET['bID'] ?? 0);
        $db->Execute("UPDATE " . TABLE_TESTIMONIALS_MANAGER . " SET testimonials_upimg = '' WHERE testimonials_id = $testimonials_id LIMIT 1");
        zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param));
        break;

    default:
        break;
}
?>
<!doctype html>
<html <?= HTML_PARAMS ?>>
  <head>
<?php
require DIR_WS_INCLUDES . 'admin_html_head.php';
if ($editor_handler != '') {
    include $editor_handler;
} 
?>
  </head>
  <body>
    <!-- header //-->
    <?php require DIR_WS_INCLUDES . 'header.php'; ?>
    <!-- header_eof //-->

 <!-- body //-->
    <div class="container-fluid">
        <!-- body_text //-->
        <h1><?= HEADING_TITLE ?></h1> 
<?php
if ($action === 'new') {
    $form_action = 'insert';

    $parameters = [
        'testimonials_title' => '',
        'language_id' => '',  
        'tm_rating' => '0',  
        'tm_feedback' => '',  
        'testimonials_name' => '',
        'testimonials_mail' => '',
        'testimonials_image' => '',
        'testimonials_title' => '',  
        'testimonials_html_text' => '',
        'tm_contact_user' => 'no',
        'tm_contact_phone' => '',
        'tm_make_public' => 'yes',
        'tm_privacy_conditions' => '0',
        'helpful_yes' => '0',
        'helpful_no' => '0',
        'testimonials_upimg' => '',
        'date_added' => '',
        'status' => '0',
    ];

    $bInfo = new objectInfo($parameters);

    if (isset($_GET['bID'])) {
        $form_action = 'update';

        $bID = (int)$_GET['bID'];

        $page_query = "SELECT * FROM " . TABLE_TESTIMONIALS_MANAGER . " WHERE testimonials_id = $bID LIMIT 1";
        $page = $db->Execute($page_query);
        if (!$page->EOF) {
            $bInfo->objectInfo($page->fields);
        }
    } elseif (!empty($_POST)) {
        $bInfo->objectInfo($_POST);
        $testimonials_name = $_POST['testimonials_name'] ?? '';
        $testimonials_title = $_POST['testimonials_title'] ?? '';
        $testimonials_html_text = $_POST['testimonials_html_text'] ?? '';
    }
?>
        <?= zen_draw_form('new_page', FILENAME_TESTIMONIALS_MANAGER, $page_param . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"') ?>
<?php
        if ($form_action == 'update') {
            echo zen_draw_hidden_field('testimonials_id', $bID);
        }
        echo zen_hide_session_id();

        $tm_status_array = [
            ['id' => '0', 'text' => TEXT_TM_STATUS_0], // Pending Review
            ['id' => '1', 'text' => TEXT_TM_STATUS_1], // Approved
            ['id' => '2', 'text' => TEXT_TM_STATUS_2], // Banned - Not allowed to create
        ];
?>
        <div id="dogicon"></div>
        <div class="form-group">
            <?= zen_draw_label(TEXT_FEEDBACK, 'tm_status', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_pull_down_menu('tm_status', $tm_status_array, $bInfo->status, 'class="form-control"') ?>
            </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_RATING, 'tm_rating', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_input_field('tm_rating', $bInfo->tm_rating, 'min="0" max="5" class="form-control"', true, 'number') ?>
            </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_TESTIMONIALS_NAME, 'testimonials_name', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_input_field('testimonials_name', $bInfo->testimonials_name, zen_set_field_length(TABLE_TESTIMONIALS_MANAGER, 'testimonials_name') . ' class="form-control"', true ) ?>
            </div>
        </div>
 
        <div class="form-group">
            <?= zen_draw_label(TEXT_TESTIMONIALS_MAIL, 'testimonials_mail', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_input_field('testimonials_mail', $bInfo->testimonials_mail, ' class="form-control"', true) ?>
            </div>
        </div>
<?php
    if ($form_action === 'insert') {
?>
        <div class="form-group">
            <?= zen_draw_label(TEXT_TESTIMONIALS_DATE, 'date_added', 'class="col-sm-3 control-label"') . TEXT_TESTIMONIALS_DATE_INFO ?>
            <div class="col-sm-9 col-md-6">
                <div class="date input-group" id="datepicker">
                    <span class="input-group-addon datepicker_icon"><?= CALENDER_ALT ?></span>
                    <?= zen_draw_input_field('date_added', $bInfo->date_added, 'class="form-control" id="date_added" autocomplete="off"') ?>
                </div>
                <span class="help-block errorText">(<?= zen_datepicker_format_full() ?>)</span>
            </div>
        </div>
 <?php
    }
?>
        <div class="form-group">
            <?= zen_draw_label(TEXT_CONTACT_USER, 'tm_contact_user', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <label class="radio-inline"><?= zen_draw_radio_field('tm_contact_user', TEXT_NO, ($bInfo->tm_contact_user == TEXT_NO ? true : false)) . TEXT_NO ?></label>
                <label class="radio-inline"><?= zen_draw_radio_field('tm_contact_user', TEXT_EMAIL, ($bInfo->tm_contact_user == TEXT_EMAIL ? true : false)) . TEXT_EMAIL ?></label>
                <label class="radio-inline"><?= zen_draw_radio_field('tm_contact_user', TEXT_PHONE, ($bInfo->tm_contact_user == TEXT_PHONE ? true : false)) . TEXT_PHONE ?></label>
           </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_USER_PHONE, 'tm_contact_phone', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_input_field('tm_contact_phone', $bInfo->tm_contact_phone, ' class="form-control"', false) . TEXT_TESTIMONIALS_OPTIONAL ?>
            </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_PUBLIC, 'tm_make_public', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <label class="radio-inline"><?= zen_draw_radio_field('tm_make_public', TEXT_YES, ($bInfo->tm_make_public == TEXT_YES ? true : false)) . TEXT_YES ?></label>
                <label class="radio-inline"><?= zen_draw_radio_field('tm_make_public', TEXT_NO, ($bInfo->tm_make_public == TEXT_NO ? true : false)) . TEXT_NO ?></label>
                <span><?= TEXT_FIELD_REQUIRED ?> </span>
            </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_PRIVACY, 'tm_privacy_conditions', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <label class="radio-inline"><?= zen_draw_radio_field('tm_privacy_conditions', 1, ($bInfo->tm_privacy_conditions == 1 ? true : false),'id="email_format_left"') . 'Yes' ?></label>
                <label class="radio-inline"><?= zen_draw_radio_field('tm_privacy_conditions', 0, ($bInfo->tm_privacy_conditions == 0 ? true : false), 'id="email_format_right"') . 'No' ?></label>
           </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_TESTIMONIALS_TITLE, 'testimonials_title', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">      
                <?= zen_draw_input_field('testimonials_title', $bInfo->testimonials_title, zen_set_field_length(TABLE_TESTIMONIALS_MANAGER, 'testimonials_title') . 'class="editorHook form-control"', true) ?>
            </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_TESTIMONIALS_HTML_TEXT, 'testimonials_html_text', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_textarea_field('testimonials_html_text', 'soft', '100', '10', $bInfo->testimonials_html_text, 'class="editorHook form-control"', false) ?>
            </div>
        </div>

        <div class="form-group"> 
            <?= zen_draw_label(TEXT_AVATAR_CURRENT_IMAGE, 'testimonials_image', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
<?php  
    if (!empty($bInfo->testimonials_image)) {
        $avatar_image = $bInfo->testimonials_image;
        echo zen_image(DIR_WS_CATALOG_IMAGES . $bInfo->testimonials_image, $bInfo->testimonials_title, TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT) . '&nbsp;&nbsp;' . $bInfo->testimonials_image;
    } else {
        $avatar_image = 'avatars/at_00.png';
        echo TEXT_AVATAR_NO_IMAGE;
    }
?>
            </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_AVATAR_IMAGE_MANUAL, 'avatar_image', 'class="col-sm-3 col-form-label"') ?> 
            <div class="col-sm-9 col-md-6">
                <select class="vodiapicker">
<?php

    $d = DIR_FS_CATALOG_IMAGES . TESTIMONIAL_IMAGE_DIRECTORY;
    $i = 0;
    foreach (glob($d.'*.{jpg,JPG,jpeg,JPEG,png,PNG}',GLOB_BRACE) as $file) {
        if ($i === 0) {
            echo '<option value="' . $avatar_image . '" data-thumbnail="' . DIR_WS_CATALOG_IMAGES . $avatar_image . '">' . $avatar_image . '</option>' . "\n";
        } else {
            echo '<option value="' . TESTIMONIAL_IMAGE_DIRECTORY . basename($file) . '" data-thumbnail="' . DIR_WS_CATALOG_IMAGES . TESTIMONIAL_IMAGE_DIRECTORY . basename($file) . '">' . TESTIMONIAL_IMAGE_DIRECTORY . basename($file) . '</option>' . "\n";
        }
        $i++;
    }
?>
                </select>
                <?= zen_draw_hidden_field('old_avatar', $bInfo->testimonials_image) ?>
                <?= zen_draw_hidden_field('avatar_image', $bInfo->testimonials_image) ?>

                <div class="lang-select">
                    <span class="btn-select" value=""></span> 
                    <div class="b">
                        <ul id="a"></ul>
                    </div>
                </div>
            </div>
        </div>

<script id="rendered-js" >
//test for getting url value from attr
// var img1 = $('.test').attr("data-thumbnail");

    $(document).ready(function() {
//test for iterating over child elements
var langArray = [];
$('.vodiapicker option').each(function () {
  var img = $(this).attr("data-thumbnail");
  var text = this.innerText;
  var value = $(this).val();
  var item = '<li><img src="' + img + '" alt="" value="' + value + '"/><span>' + text + '</span></li>';
  langArray.push(item);
});

$('#a').html(langArray);

//Set the button value to the first el of the array
$('.btn-select').html(langArray[0]);
$('.btn-select').attr('value', '<?= $bInfo->testimonials_image ?>');  //en

//change button stuff on click
$('#a li').click(function () {
  var img = $(this).find('img').attr("src");
  var value = $(this).find('img').attr('value');
  var text = this.innerText;
  var item = '<li><img src="' + img + '" alt="" /><span>' + text + '</span><input type="hidden" name="avatar_image" value="' + value + '" /></li>';
  $('.btn-select').html(item);
  $('.btn-select').attr('value', value);
  $(".b").toggle();
  //console.log(value);
  
});

$(".btn-select").click(function () {
  $(".b").toggle();
});

//check local storage for the lang
var sessionLang = localStorage.getItem('lang');
if (sessionLang) {
  //find an item with value of sessionLang
  var langIndex = langArray.indexOf(sessionLang);
  $('.btn-select').html(langArray[langIndex]);
  $('.btn-select').attr('value', sessionLang);
} else {
  var langIndex = langArray.indexOf('ch');
  console.log(langIndex);
  $('.btn-select').html(langArray[langIndex]);
  //$('.btn-select').attr('value', 'en');
}
 });
</script>

        <div class="form-group">
            <?= zen_draw_label(TEXT_YES_VOTING, 'helpful_yes', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_input_field('helpful_yes', $bInfo->helpful_yes, ' class="form-control"', false, 'number') . TEXT_TESTIMONIALS_OPTIONAL ?>
            </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_NO_VOTING, 'helpful_no', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_input_field('helpful_no', $bInfo->helpful_no, ' class="form-control"', false, 'number') . TEXT_TESTIMONIALS_OPTIONAL ?>
            </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_INFO_CURRENT_IMAGE, 'testimonials_upimg', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
<?php
    if (empty($bInfo->testimonials_upimg)) {
?>
                <?= TEXT_IMAGES_TESTMONIALS ?>
<?php
    } else {
?>
                <div>
                    <?= zen_image(DIR_WS_CATALOG_IMAGES . $bInfo->testimonials_upimg, $bInfo->testimonials_title, 150, 150) ?>
                </div>
                <br>'
                <?= TEXT_FILENAME . $bInfo->testimonials_upimg ?>
                <br>

                <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $bInfo->testimonials_id . '&action=imagedelete') ?>" onclick=\'confirm("Delete image, are you sure?") && document.imagedelete.submit(); return false\' class="btn btn-warning" role="button">
                    <?= IMAGE_DELETE ?>
                </a>
<?php
    }
?>
            </div>
        </div>

        <span class="floatButton text-right">
            <?= ($form_action === 'insert') ? '<button type="submit" class="btn btn-primary">' . IMAGE_INSERT . '</button>' : '<button type="submit" class="btn btn-primary">' . IMAGE_UPDATE . '</button>' ?>
            <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . (isset($_GET['bID']) ? '&bID=' . $_GET['bID'] : '')) ?>" class="btn btn-default ms-2" role="button">
                <?= IMAGE_CANCEL ?>
            </a>
        </span>
        <?= '</form>' ?>
<?php
} else {    // table for admin main
?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 configurationColumnLeft">    
                <div class="col-md-4">
                    <?= STATUS_GREEN . '&nbsp;' . CIRCLE_GREEN . USER_CIRCLE . '&nbsp;&nbsp' . STATUS_BLUE . '&nbsp;' . CIRCLE_BLUE . USER_CIRCLE . '&nbsp;&nbsp;' . STATUS_RED . '&nbsp;' . CIRCLE_RED . USER_CIRCLE ?>
                </div>

                <div class="col-md-5">
                    <?= zen_draw_form('set_editor_form', FILENAME_TESTIMONIALS_MANAGER, '', 'get', 'class="form-horizontal"') ?>
                    <div class="form-group">
                        <?= zen_draw_label(TEXT_EDITOR_INFO, 'reset_editor', 'class="col-sm-6 col-md-4 control-label"') ?>
                        <div class="col-sm-6 col-md-8">
                            <?= zen_draw_pull_down_menu('reset_editor', $editors_pulldown, $current_editor_key, 'onchange="this.form.submit();" class="form-control" id="reset_editor"') ?>
                        </div>
                        <?= zen_hide_session_id() ?>
                        <?= zen_draw_hidden_field('action', 'set_editor') ?>
                        <?= (isset($_GET['bID']) ? zen_draw_hidden_field('bID', (int)$_GET['bID']) : '') ?>
                        <?= ($pagenum > 1) ? zen_draw_hidden_field('page', $pagenum) : '') ?>
                    </div>
                    <?= '</form>' ?>
                </div>

                <?= zen_draw_form('delform', FILENAME_TESTIMONIALS_MANAGER, 'action=confirm', 'post', '', true) ?>
                <table class="table table-hover">
                    <thead>
                        <tr class="dataTableHeadingRow">
                            <th class="dataTableHeadingContent"><?= TABLE_HEADING_ID ?></th>
                            <th class="dataTableHeadingContent">
                                <input type="checkbox" name="select-all" id="select-all">
                                <label class="checkboxLabel" for="quote_file">
                                    <?= TABLE_HEADING_DELETE ?>
                                </label>
                            </th>
                            <th class="dataTableHeadingContent"><?= TABLE_HEADING_TESTIMONIALS ?></th>
                            <th class="dataTableHeadingContent hidden-sm hidden-xs"><?= TABLE_HEADING_NAME ?></th>
                            <th class="dataTableHeadingContent hidden-sm hidden-xs"><?= TABLE_HEADING_MAIL ?></th>
                            <th class="dataTableHeadingContent hidden-sm hidden-xs"><?= TABLE_HEADING_RATING ?></th>
                            <th class="dataTableHeadingContent hidden-sm hidden-xs"><?= TABLE_HEADING_DATE_ADDED ?></th>
                            <th class="dataTableHeadingContent" align="center"><?= TABLE_HEADING_STATUS ?></th>
                            <th class="dataTableHeadingContent"></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
    $testimonials_query_raw = "SELECT * FROM " . TABLE_TESTIMONIALS_MANAGER . " ORDER BY date_added DESC, testimonials_title";
    $testimonials_split = new splitPageResults($pagenum, MAX_DISPLAY_SEARCH_RESULTS, $testimonials_query_raw, $testimonials_query_numrows);
    $testimonials = $db->Execute($testimonials_query_raw);

    foreach ($testimonials as $testimonial) {
        if ((!isset($_GET['bID']) || $_GET['bID'] === $testimonial['testimonials_id']) && !isset($bInfo) && $action !== 'new') {
            $bInfo_array = array_merge($testimonial);
            $bInfo = new objectInfo($bInfo_array);
        }
 
        /*** Cowboygeek delete customer re-write get id's from delcust[] *********/      
        $howmany = count($_POST['delcust'] ?? 0);  //number of links to delete
        if ($howmany !== 0) {  
            foreach ($_POST['delcust'] as $next_id) {
                $testimonialsID[] = $next_id;  //feed any ID's into an array
            }
        }
?>
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableContent"><?= $testimonial['testimonials_id'] ?></td>
                            <td class="dataTableContent">
<?php
        // Create the delete checkbox and manage the checks
        $tof = (is_array($testimonialsID) && in_array($testimonial['testimonials_id'], $testimonialsID));
?>
                                <?= zen_draw_checkbox_field('delcust[]', $testimonial['testimonials_id'], $tof) ?>
                            </td>
                            <td class="dataTableContent"><?= zen_output_string_protected($testimonial['testimonials_title']) ?></td>
                            <td class="dataTableContent hidden-sm hidden-xs"><?= zen_output_string_protected($testimonial['testimonials_name']) ?></td>
                            <td class="dataTableContent hidden-sm hidden-xs"><?= zen_output_string_protected($testimonial['testimonials_mail']) ?></td>
                            <td class="dataTableContent hidden-sm hidden-xs">
                                <?= str_repeat(zen_icon('star-shadow', size: 'lg'), (int)$testimonial['tm_rating']) ?>
                            </td>
                            <td class="dataTableContent hidden-sm hidden-xs"><?= $testimonial['date_added'] ?></td>
                            <td class="dataTableContent" align="center">
<?php
/*  coded for FontAwesome 4 not 5...  */
      if ($testimonial['status'] == 0) { //status pending blue  CIRCLE_BLUE . USER_CIRCLE  rgba(17,59,217,1)      
        echo '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial['testimonials_id'] . '&action=setflag&flag=1') . '" title="Approved"><svg xmlns="http://www.w3.org/2000/svg" fill="rgba(6,130,15,0.5)" width="15px" height="auto" viewBox="0 0 496 512">' . USER_CIRCLE . '</a>&nbsp;&nbsp;<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(17,59,217,1)" width="15px" height="auto" title="Pending" viewBox="0 0 496 512">' . USER_CIRCLE . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial['testimonials_id'] . '&action=setflag&flag=2') . '" title="Baned"><svg xmlns="http://www.w3.org/2000/svg" fill="rgba(255,0,0,0.5)" width="15px" height="auto" viewBox="0 0 496 512">' . USER_CIRCLE . '</a>';
      } elseif ($testimonial['status'] == 1) {  //status approved green  CIRCLE_GREEN . USER_CIRCLE  rgba(6,130,15,1)   
      echo '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(6,130,15,1)" width="15px" height="auto" viewBox="0 0 496 512" title="Approved">' . USER_CIRCLE . '&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial['testimonials_id'] . '&action=setflag&flag=0') . '" title="Pending"><svg xmlns="http://www.w3.org/2000/svg" fill="rgba(17,59,217,0.5)" width="15px" height="auto" viewBox="0 0 496 512">' . USER_CIRCLE . '</a>&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial['testimonials_id'] . '&action=setflag&flag=2') . '" title="Baned"><svg xmlns="http://www.w3.org/2000/svg" fill="rgba(255,0,0,0.5)" width="15px" height="auto" viewBox="0 0 496 512">' . USER_CIRCLE . '</a>';
      }else{ //status baned red  CIRCLE_RED . USER_CIRCLE  rgba(255,0,0,1)     
       echo '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial['testimonials_id'] . '&action=setflag&flag=1') . '" title="Approved"><svg xmlns="http://www.w3.org/2000/svg" fill="rgba(6,130,15,0.5)" width="15px" height="auto" viewBox="0 0 496 512">' . USER_CIRCLE . '</a>&nbsp;&nbsp;<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial['testimonials_id'] . '&action=setflag&flag=0') . '" title="Pending"><svg xmlns="http://www.w3.org/2000/svg" fill="rgba(17,59,217,0.5)" width="15px" height="auto" viewBox="0 0 496 512">' . USER_CIRCLE . '</a>&nbsp;&nbsp;<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(255,0,0,1)" title="Baned" width="15px" height="auto" viewBox="0 0 496 512">' . USER_CIRCLE;
      }
?>
                            </td>
                            <td class="dataTableContent text-right">
<?php
    if (isset($bInfo) && is_object($bInfo) && ((int)$testimonial['testimonials_id'] === (int)$bInfo->testimonials_id)) {
?>
                                <?= echo zen_icon('caret-right', '', '2x', true) ?>
<?php
    } else {
?>
                            <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, zen_get_all_get_params(['bID']) . 'bID=' . $testimonial['testimonials_id']) ?>">
                                    <?= zen_icon('circle-info', '', '2x', true, true) ?>
                                </a>
                            </td>
<?php
    }
?>
                        </tr>
<?php


    }
?>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-6 text-center smallText">
                        <?= $testimonials_split->display_count($testimonials_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $pagenum, TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS) ?>
                    </div>
                    <div class="col-md-6 text-center smallText">
                        <?= $testimonials_split->display_links($testimonials_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $pagenum, zen_get_all_get_params(['page', 'info', 'x', 'y', 'lID'])) ?>
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-danger me-2">Delete Testimonials</button>
                    <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'action=new') ?>" class="btn btn-primary" role="button">
                        <?= IMAGE_NEW_PAGE ?>
                    </a>
                </div>
                <?= '</form>' ?>
            </div>
<?php
    $test_status = ($bInfo->status == 0) ? 'Pending' : 'Approved';
?>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 configurationColumnRight">
<?php
    $heading = [];
    $contents = [];
    switch ($action) {
        case 'confirm':
            $heading[] = ['text' => '<h4>' . TEXT_INFO_HEADING_DELETE_TESTIMONIALS . '</h4>'];

            $_SESSION['deleteTest'] = $testimonialsID;

            if ($howmany === 0) {
                $contents[] = ['align' => 'text-center', 'text' => '<br><a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER) . '" class="btn btn-default" role="button">' . IMAGE_CANCEL . '</a>'];
                break;
            }

            $contents = ['form' => zen_draw_form('testimonials', FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $bInfo->testimonials_id . '&action=deleteconfirm', 'post', '', true)];
            foreach ($testimonialsID as $testimonial) {
                $tm_query = "SELECT testimonials_name, testimonials_mail FROM " . TABLE_TESTIMONIALS_MANAGER . " WHERE testimonials_id = " . (int)$testimonial;
                $tm_info = $db->Execute($tm_query, 1);
                if ($tm_info->EOF) {
                    continue;
                }
                $contents[] = ['text' => TEXT_INFO_DELETE_INTRO . '<br><b>ID# ' . $testimonialsID[$i] . ' ' . $tm_info->fields['testimonials_name'] . ' ' . $tm_info->fields['testimonials_mail'] . '</b>'];
            }
            $contents[] = ['align' => 'center', 'text' => '<button type="submit" class="btn btn-danger">' . IMAGE_DELETE . '</button> <a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER) . '" class="btn btn-default" role="button">' . IMAGE_CANCEL . '</a>'];
            break;

        default:
            if (!is_object($bInfo)) {
                break;
            }

            $heading[] = ['text' => '<b>' . $bInfo->testimonials_title . '</b>'];

            $contents[] = [
                'align' => 'center',
                'text' => '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $bInfo->testimonials_id . '&action=new') . '" class="btn btn-primary" role="button">' . IMAGE_EDIT . '</a>'
            ];

            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_STATUS . ' '  . $teststatus];

            if (!empty($bInfo->testimonials_image)) {
                $contents[] = ['text' => '<br>' . zen_image(DIR_WS_CATALOG_IMAGES . $bInfo->testimonials_image, $bInfo->testimonials_title, TESTIMONIAL_IMAGE_WIDTH, TESTIMONIAL_IMAGE_HEIGHT) . '<br><br>' . $bInfo->testimonials_title];
            } else {
                $contents[] = ['text' => '<br>' . TEXT_IMAGE_NONEXISTENT];
            }
            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_RATING . ' '  . str_repeat(zen_icon('star-shadow', size: 'lg'), (int)$bInfo->tm_rating))];
            $contents[] = ['text' => '<br><b>' . TEXT_INFO_TESTIMONIALS_PUBLIC  . ' '  . $bInfo->tm_make_public . '</b>'];
            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_FEEDBACK . ' '  . $bInfo->tm_feedback];
            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_CONTACT_NAME . ' '  . $bInfo->testimonials_name];
            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_CONTACT_EMAIL . ' ' . $bInfo->testimonials_mail];
            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_TITLE . ' ' . $bInfo->testimonials_title];
            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_DESCRIPTION . '<br> ' . zen_clean_html($bInfo->testimonials_html_text)];
            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_CONTACT . ' '  . $bInfo->tm_contact_user];
            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_CONTACT_PHONE . ' '  . $bInfo->tm_contact_phone];
            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_PRIVACY . ' '  . $bInfo->tm_privacy_conditions];
            $contents[] = ['text' => '<br>' . TEXT_YES_VOTING . ' '  . $bInfo->helpful_yes];
            $contents[] = ['text' => '<br>' . TEXT_NO_VOTING . ' '  . $bInfo->helpful_no];
            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_GEN_INFO . '<br>'  . $bInfo->tm_gen_info];
            $contents[] = ['text' => '<br>' . TEXT_INFO_TESTIMONIALS_SUBMIT_IMAGE . '<br>'  . $bInfo->testimonials_upimg];
            if (!empty($bInfo->testimonials_upimg)) {
                $contents[] = ['text' => zen_image(DIR_WS_CATALOG_IMAGES . $bInfo->testimonials_upimg, $bInfo->testimonials_title, 150)];
            } else {
                $contents[] = ['text' => '<br>' . TEXT_IMAGE_NONEXISTENT);
            }

            $contents[] = ['text' => '<br>' . TEXT_DATE_TESTIMONIALS_CREATED . ' ' . zen_date_short($bInfo->date_added)];

            if (!empty($bInfo->last_update)) {
                $contents[] = ['text' => TEXT_DATE_TESTIMONIALS_LAST_MODIFIED . ' ' . zen_date_short($bInfo->last_update)];
            } else {
                $contents[] = ['text' => TEXT_DATE_TESTIMONIALS_LAST_MODIFIED);
            }

            if ($bInfo->date_scheduled) {
                $contents[] = ['text' => '<br>' . sprintf(TEXT_TESTIMONIALS_SCHEDULED_AT_DATE, zen_date_short($bInfo->date_scheduled))];
            }

            if ($bInfo->expires_date) {
              $contents[] = ['text' => '<br>' . sprintf(TEXT_TESTIMONIALS_EXPIRES_AT_DATE, zen_date_short($bInfo->expires_date))];
            } elseif ($bInfo->expires_impressions) {
              $contents[] = ['text' => '<br>' . sprintf(TEXT_TESTIMONIALS_EXPIRES_AT_IMPRESSIONS, $bInfo->expires_impressions)];
            }

            if ($bInfo->date_status_change) {
                $contents[] = ['text' => '<br>' . sprintf(TEXT_TESTIMONIALS_STATUS_CHANGE, zen_date_short($bInfo->date_status_change))];
            }
            break;
    }

    if (!empty($heading) && !empty($contents)) {
        $box = new box();
        echo $box->infoBox($heading, $contents);
    }
}
?>
            </div>
        </div>
    </div>
<!-- body_eof //-->
    <script>
      $(function(){
        $('input[name="date_added"]').datepicker();
      })

      $('#select-all').click(function(event) {
        if (this.checked) {
          // Iterate each checkbox
          $(':checkbox').each(function() {
            this.checked = true;
          });
        } else {
          $(':checkbox').each(function() {
            this.checked = false;
          });
        }
      });
    </script>
<!-- footer //-->
<?php require DIR_WS_INCLUDES . 'footer.php'; ?>
<!-- footer_eof //-->
</body>
</html>
<?php require DIR_WS_INCLUDES . 'application_bottom.php'); ?>
