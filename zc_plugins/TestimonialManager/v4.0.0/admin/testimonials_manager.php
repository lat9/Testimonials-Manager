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

            $db->Execute(
                "UPDATE " . TABLE_TESTIMONIALS_MANAGER . "
                    SET status = $status,
                        last_update = now()
                  WHERE testimonials_id = $testimonials_id
                  LIMIT 1"
            );
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
        $feedback = !empty($_POST['tm_feedback']) ? zen_db_prepare_input(zen_sanitize_string($_POST['tm_feedback'])) : '';
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

        $upimg = new upload('testimonials_upimg');
        $upimg->set_extensions(['jpg', 'jpeg', 'png']);
        $upimg->set_destination(DIR_FS_CATALOG_IMAGES . $_POST['img_dir']);
        if ($upimg->parse() && $upimg->save()) {
            $upimg_name = zen_db_input($_POST['img_dir'] . $upimg->filename);
        }
        if ($upimg->filename !== 'none' && $upimg->filename !== '') {
            // save filename when not set to none and not blank
            $db_filename = zen_limit_image_filename($upimg_name, TABLE_TESTIMONIALS_MANAGER, 'testimonials_upimg');
            $sql_data_array['testimonials_upimg'] = $db_filename;
        }

        if ($action === 'insert') {
            $date_added_raw = zen_db_prepare_input($_POST['date_added']);
            if ($date_scheduled_raw === '') {
                $date_added = 'now()';
            } else {
                if (DATE_FORMAT_DATE_PICKER !== 'yy-mm-dd' && !empty($date_added_raw)) {
                    $local_fmt = zen_datepicker_format_fordate();
                    $dt = DateTime::createFromFormat($local_fmt, $date_added_raw);
                    $date_added_raw = 'null';
                    if (!empty($dt)) {
                        $date_added_raw = $dt->format('Y-m-d');
                    }
                }
                if (zcDate::validateDate($date_added_raw) === true) {
                    $date_added = $date_added_raw;
                } else {
                    $page_error = true;
                    $messageStack->add(ERROR_INVALID_DATE, 'error');
                }
            }

            $sql_data_array['date_added'] = $date_added;

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

    case 'delete':
        if (!isset($_POST['delcust']) || !is_array($_POST['delcust']) || count($_POST['delcust']) === 0) {
            $messageStack->add_session(ERROR_NO_SELECTIONS_FOR_DELETE);
            zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param));
        }
        break;

    case 'deleteconfirm':
        $to_delete = $_POST['delcust'] ?? [];
        if (!is_array($to_delete)) {
            $to_delete = [];
        }
        foreach ($to_delete as $testimonial_id) {
            $db->Execute("DELETE FROM " . TABLE_TESTIMONIALS_MANAGER . " WHERE testimonials_id = " . (int)$testimonial_id . " LIMIT 1");
        }

        $messageStack->add_session(sprintf(SUCCESS_PAGE_REMOVED, count($to_delete)), 'success');
        zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param));
        break;

    case 'imagedelete':  
        $testimonials_id = (int)($_GET['bID'] ?? 0);
        if ($testimonials_id > 0) {
            $upimg = $db->Execute("SELECT testimonials_upimg FROM " . TABLE_TESTIMONIALS_MANAGER . " WHERE testimonials_id = $testimonials_id LIMIT 1");
            if (!$upimg->EOF && is_file(DIR_FS_CATALOG_IMAGES . $upimg->fields['testimonials_upimg'])) {
                @unlink(DIR_FS_CATALOG_IMAGES . $upimg->fields['testimonials_upimg']);
            }
            $db->Execute("UPDATE " . TABLE_TESTIMONIALS_MANAGER . " SET testimonials_upimg = '' WHERE testimonials_id = $testimonials_id LIMIT 1");
        }
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
    <style>
        #status-legend {justify-content: center;column-gap:.5rem;}
    </style>
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
        <div id="spiffycalendar" class="text"></div>
        <?= zen_draw_form('new_page', FILENAME_TESTIMONIALS_MANAGER, $page_param . '&action=' . $form_action, 'post', 'enctype="multipart/form-data" class="form-horizontal"') ?>
<?php
        if ($form_action === 'update') {
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
                <?= zen_draw_input_field('testimonials_name', $bInfo->testimonials_name, zen_set_field_length(TABLE_TESTIMONIALS_MANAGER, 'testimonials_name') . ' class="form-control"', true) ?>
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
            <?= zen_draw_label(TEXT_TESTIMONIALS_DATE, 'date_added', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <div class="date input-group" id="datepicker">
                    <span class="input-group-addon datepicker_icon">
                        <?= zen_icon('calendar-days', size: 'lg') ?>
                    </span>
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
                <label class="radio-inline"><?= zen_draw_radio_field('tm_contact_user', 'no', $bInfo->tm_contact_user === 'no') . TEXT_NO ?></label>
                <label class="radio-inline"><?= zen_draw_radio_field('tm_contact_user', 'email', $bInfo->tm_contact_user === 'email') . TEXT_EMAIL ?></label>
                <label class="radio-inline"><?= zen_draw_radio_field('tm_contact_user', 'phone', $bInfo->tm_contact_user === 'phone') . TEXT_PHONE ?></label>
           </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_USER_PHONE, 'tm_contact_phone', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_input_field('tm_contact_phone', $bInfo->tm_contact_phone, ' class="form-control"', false) ?>
            </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_PUBLIC, 'tm_make_public', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <label class="radio-inline"><?= zen_draw_radio_field('tm_make_public', 'yes', $bInfo->tm_make_public === 'yes') . TEXT_YES ?></label>
                <label class="radio-inline"><?= zen_draw_radio_field('tm_make_public', 'no', $bInfo->tm_make_public !== 'yes') . TEXT_NO ?></label>
            </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_PRIVACY, 'tm_privacy_conditions', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <label class="radio-inline"><?= zen_draw_radio_field('tm_privacy_conditions', 1, (int)$bInfo->tm_privacy_conditions === 1,'id="email_format_left"') . TEXT_YES ?></label>
                <label class="radio-inline"><?= zen_draw_radio_field('tm_privacy_conditions', 0, (int)$bInfo->tm_privacy_conditions !== 1, 'id="email_format_right"') . TEXT_NO ?></label>
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
            <?= zen_draw_label(TEXT_HELPFUL_YES, 'helpful_yes', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_input_field('helpful_yes', $bInfo->helpful_yes, 'min="0" class="form-control"', false, 'number') ?>
            </div>
        </div>

        <div class="form-group">
            <?= zen_draw_label(TEXT_HELPFUL_NO, 'helpful_no', 'class="col-sm-3 col-form-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_input_field('helpful_no', $bInfo->helpful_no, 'min="0" class="form-control"', false, 'number') ?>
            </div>
        </div>
<?php
    if (!empty($bInfo->testimonials_upimg)) {
?>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9 col-md-6">
                <div><?= zen_info_image($bInfo->testimonials_upimg, $bInfo->testimonials_title, '', '', 'class="table-bordered img-responsive"') ?></div>
                <br>
<?php
        if (is_file(DIR_FS_CATALOG_IMAGES . $bInfo->testimonials_upimg)) {
            [$width, $height] = getimagesize(DIR_FS_CATALOG_IMAGES . $bInfo->testimonials_upimg);
            $kb = filesize(DIR_FS_CATALOG_IMAGES . $bInfo->testimonials_upimg) / 1024;
        }
        echo sprintf(TEXT_FILENAME, '/' . DIR_WS_IMAGES . $bInfo->testimonials_upimg, $width ?? 0, $height ?? 0, $kb ?? 0);
?>
            </div>
        </div>
        <div class="form-group">
            <p class="col-sm-3 control-label"><?= TEXT_IMAGES_DELETE ?></p>
            <div class="col-sm-9 col-md-6">
                <label class="radio-inline"><?= zen_draw_radio_field('image_delete', '0', true) . TABLE_HEADING_NO ?></label>
                <label class="radio-inline"><?= zen_draw_radio_field('image_delete', '1', false) . TABLE_HEADING_YES ?></label>
            </div>
        </div>
<?php
    }
?>
        <div class="form-group">
            <p class="col-sm-3 control-label"><strong><?= TEXT_EDIT_IMAGE ?></strong></p>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_file_field('testimonials_upimg', '', 'class="form-control"') ?>
            </div>
        </div>
<?php
    $dir_info = zen_build_subdirectories_array(DIR_FS_CATALOG_IMAGES);
    if (empty($bInfo->testimonials_upimg)) {
        $default_directory = '';
    } else {
        $default_directory = pathinfo($bInfo->testimonials_upimg, PATHINFO_DIRNAME);
    }
?>
        <div class="form-group">
            <?= zen_draw_label(TEXT_IMAGE_DIR, 'image-dir', 'class="col-sm-3 control-label"') ?>
            <div class="col-sm-9 col-md-6">
                <?= zen_draw_pull_down_menu('img_dir', $dir_info, $default_directory, 'class="form-control" id="img-dir"') ?>
            </div>
        </div>

        <div class="floatButton text-right">
            <?= ($form_action === 'insert') ? '<button type="submit" class="btn btn-primary">' . IMAGE_INSERT . '</button>' : '<button type="submit" class="btn btn-primary">' . IMAGE_UPDATE . '</button>' ?>
            <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . (isset($_GET['bID']) ? '&bID=' . $_GET['bID'] : '')) ?>" class="btn btn-default ms-2" role="button">
                <?= IMAGE_CANCEL ?>
            </a>
        </div>
        <?= '</form>' ?>
    <script>
      $(function () {
        $('input[name="date_added"]').datepicker({
        });
      })
    </script>
<?php
} else {    // table for admin main
    $color_approved = 'rgba(6,130,15,1)';   //- green
    $color_pending = 'rgba(17,59,217,1)';   //- blue
    $color_banned = 'rgba(255,0,0,1)';      //- red
?>
        <div class="row">
            <div id="status-legend" class="col-md-4 d-flex">
                <span><?= STATUS_APPROVED . '&nbsp;' . sprintf(CIRCLE_FORMAT, $color_approved, '18px') . USER_CIRCLE ?></span>
                <span><?= STATUS_PENDING . '&nbsp;' . sprintf(CIRCLE_FORMAT, $color_pending, '18px') . USER_CIRCLE ?></span>
                <span><?= STATUS_BANNED . '&nbsp;' . sprintf(CIRCLE_FORMAT, $color_banned, '18px') . USER_CIRCLE ?></span>
            </div>

            <div class="col-md-4"></div>

            <div class="col-md-4">
                <?= zen_draw_form('set_editor_form', FILENAME_TESTIMONIALS_MANAGER, '', 'get', 'class="form-horizontal"') ?>
                <div class="form-group">
                    <?= zen_draw_label(TEXT_EDITOR_INFO, 'reset_editor', 'class="col-sm-6 col-md-4 control-label"') ?>
                    <div class="col-sm-6 col-md-8">
                        <?= zen_draw_pull_down_menu('reset_editor', $editors_pulldown, $current_editor_key, 'onchange="this.form.submit();" class="form-control" id="reset_editor"') ?>
                    </div>
                    <?= zen_hide_session_id() ?>
                    <?= zen_draw_hidden_field('action', 'set_editor') ?>
                    <?= (isset($_GET['bID']) ? zen_draw_hidden_field('bID', (int)$_GET['bID']) : '') ?>
                    <?= ($pagenum > 1) ? zen_draw_hidden_field('page', $pagenum) : '' ?>
                </div>
                <?= '</form>' ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 configurationColumnLeft">
                <?= zen_draw_form('delform', FILENAME_TESTIMONIALS_MANAGER, 'action=delete', 'post', '', true) ?>
                <table class="table table-hover">
                    <thead>
                        <tr class="dataTableHeadingRow">
                            <th class="dataTableHeadingContent text-center"><?= TABLE_HEADING_ID ?></th>
                            <th class="dataTableHeadingContent text-center">
<?php
    if ($action !== 'delete') {
?>
                                <label class="checkboxLabel" for="select-all">
                                    <?= TABLE_HEADING_DELETE ?>
                                </label>
                                <br>
                                <input type="checkbox" name="select-all" id="select-all">
<?php
    }
?>
                            </th>
                            <th class="dataTableHeadingContent"><?= TABLE_HEADING_TESTIMONIALS ?></th>
                            <th class="dataTableHeadingContent hidden-sm hidden-xs"><?= TABLE_HEADING_NAME ?></th>
                            <th class="dataTableHeadingContent hidden-sm hidden-xs"><?= TABLE_HEADING_MAIL ?></th>
                            <th class="dataTableHeadingContent hidden-sm hidden-xs text-center"><?= TABLE_HEADING_RATING ?></th>
                            <th class="dataTableHeadingContent hidden-sm hidden-xs"><?= TABLE_HEADING_DATE_ADDED ?></th>
                            <th class="dataTableHeadingContent text-center"><?= TABLE_HEADING_STATUS ?></th>
                            <th class="dataTableHeadingContent"></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
    $testimonials_query_raw = "SELECT * FROM " . TABLE_TESTIMONIALS_MANAGER . " ORDER BY date_added DESC, testimonials_title";
    $testimonials_split = new splitPageResults($pagenum, MAX_DISPLAY_SEARCH_RESULTS, $testimonials_query_raw, $testimonials_query_numrows);
    $testimonials = $db->Execute($testimonials_query_raw);

    $delete_disabled = ($action === 'delete') ? 'disabled' : '';
    $delete_list = (isset($_POST['delcust']) && is_array($_POST['delcust'])) ? $_POST['delcust'] : [];
    foreach ($testimonials as $testimonial) {
        $testimonial_id = (int)$testimonial['testimonials_id'];
        if ((!isset($_GET['bID']) || (int)$_GET['bID'] === $testimonial_id) && !isset($bInfo) && $action !== 'new') {
            $bInfo_array = array_merge($testimonial);
            $bInfo = new objectInfo($bInfo_array);
        }
?>
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableContent text-center"><?= $testimonial_id ?></td>
                            <td class="dataTableContent text-center">
<?php
        // Create the delete checkbox and manage the checks
        $tof = in_array($testimonial_id, $delete_list);
?>
                                <?= zen_draw_checkbox_field('delcust[]', $testimonial_id, $tof, '', $delete_disabled) ?>
                            </td>
                            <td class="dataTableContent"><?= zen_output_string_protected($testimonial['testimonials_title']) ?></td>
                            <td class="dataTableContent hidden-sm hidden-xs"><?= zen_output_string_protected($testimonial['testimonials_name']) ?></td>
                            <td class="dataTableContent hidden-sm hidden-xs"><?= zen_output_string_protected($testimonial['testimonials_mail']) ?></td>
                            <td class="dataTableContent hidden-sm hidden-xs text-center">
                                <?= str_repeat(zen_icon('star-shadow', size: 'lg'), (int)$testimonial['tm_rating']) ?>
                            </td>
                            <td class="dataTableContent hidden-sm hidden-xs"><?= $testimonial['date_added'] ?></td>
                            <td class="dataTableContent text-center">
<?php
        $change_to_approved = sprintf(STATUS_TITLE_CHANGE, STATUS_APPROVED);
        $change_to_banned = sprintf(STATUS_TITLE_CHANGE, STATUS_BANNED);
        $change_to_pending = sprintf(STATUS_TITLE_CHANGE, STATUS_PENDING);
        if ((int)$testimonial['status'] === 0) { //status pending blue  CIRCLE_BLUE . USER_CIRCLE  rgba(17,59,217,1)
?>
                                <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial_id . '&action=setflag&flag=1')?>" title="<?= $change_to_approved ?>">
                                    <?= sprintf(CIRCLE_FORMAT, $color_approved, '15px'); ?>
                                    <?= USER_CIRCLE ?>
                                </a>
                                <a href="javascript:void(0);" title="<?= sprintf(STATUS_TITLE_CURRENT, STATUS_PENDING) ?>">
                                    <?= sprintf(CIRCLE_FORMAT, $color_pending, '18px'); ?>
                                    <?= USER_CIRCLE ?>
                                </a>
                                <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial_id . '&action=setflag&flag=2') ?>" title="<?= $change_to_banned ?>">
                                    <?= sprintf(CIRCLE_FORMAT, $color_banned, '15px'); ?>
                                    <?= USER_CIRCLE ?>
                                </a>
<?php
        } elseif ((int)$testimonial['status'] === 1) {  //status approved green  CIRCLE_GREEN . USER_CIRCLE  rgba(6,130,15,1)
?>
                                    <a href="javascript:void(0);" title="<?= sprintf(STATUS_TITLE_CURRENT, STATUS_APPROVED) ?>">
                                        <?= sprintf(CIRCLE_FORMAT, $color_approved, '18px'); ?>
                                        <?= USER_CIRCLE ?>
                                    </a>
                                    <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial_id . '&action=setflag&flag=0') ?>" title="<?= $change_to_pending ?>">
                                        <?= sprintf(CIRCLE_FORMAT, $color_pending, '15px'); ?>
                                        <?= USER_CIRCLE ?>
                                    </a>
                                    <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial_id . '&action=setflag&flag=2') ?>" title="<?= $change_to_banned ?>">
                                        <?= sprintf(CIRCLE_FORMAT, $color_banned, '15px'); ?>
                                        <?= USER_CIRCLE ?>
                                    </a>
<?php
        } else { //status banned red  CIRCLE_RED . USER_CIRCLE  rgba(255,0,0,1)
?>
                                    <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial_id . '&action=setflag&flag=1') ?>" title="<?= $change_to_approved ?>">
                                        <?= sprintf(CIRCLE_FORMAT, $color_approved, '15px'); ?>
                                        <?= USER_CIRCLE ?>
                                    </a>
                                    <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $testimonial_id . '&action=setflag&flag=0') ?>" title="<?= $change_to_pending ?>">
                                        <?= sprintf(CIRCLE_FORMAT, $color_pending, '15px'); ?>
                                        <?= USER_CIRCLE ?>
                                    </a>
                                    <a href="javascript:void(0);" title="<?= sprintf(STATUS_TITLE_CURRENT, STATUS_BANNED) ?>">
                                        <?= sprintf(CIRCLE_FORMAT, $color_banned, '18px'); ?>
                                        <?= USER_CIRCLE ?>
                                    </a>
<?php
        }
?>
                            </td>
                            <td class="dataTableContent text-right">
<?php
        if (isset($bInfo) && is_object($bInfo) && $testimonial_id === (int)$bInfo->testimonials_id) {
?>
                                <?= zen_icon('caret-right', '', '2x', true) ?>
<?php
        } else {
?>
                                <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, zen_get_all_get_params(['bID']) . 'bID=' . $testimonial_id) ?>">
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
                    <div class="col-md-6 text-center">
                        <?= $testimonials_split->display_count($testimonials_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, $pagenum, TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS) ?>
                    </div>
                    <div class="col-md-6 text-center">
                        <?= $testimonials_split->display_links($testimonials_query_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $pagenum, zen_get_all_get_params(['page', 'info', 'x', 'y', 'lID'])) ?>
                    </div>
                </div>
<?php
    if ($action !== 'delete') {
?>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-danger me-2"><?= BUTTON_DELETE_SELECTED ?></button>
                    <a href="<?= zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'action=new') ?>" class="btn btn-primary" role="button">
                        <?= IMAGE_NEW_PAGE ?>
                    </a>
                </div>
<?php
    }
?>
                <?= '</form>' ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 configurationColumnRight">
<?php
    $heading = [];
    $contents = [];
    switch ($action) {
        case 'delete':
            $heading[] = ['text' => '<b>' . TEXT_INFO_HEADING_DELETE_TESTIMONIALS . '</b>'];

            $contents = ['form' => zen_draw_form('testimonials', FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $bInfo->testimonials_id . '&action=deleteconfirm', 'post', '', true)];
            $contents[] = ['text' => TEXT_INFO_DELETE_INTRO];

            $index = 0;
            $to_delete_list = '';
            foreach ($delete_list as $testimonial_id) {
                $tm_query = "SELECT testimonials_name, testimonials_mail FROM " . TABLE_TESTIMONIALS_MANAGER . " WHERE testimonials_id = " . (int)$testimonial_id;
                $tm_info = $db->Execute($tm_query, 1);
                if ($tm_info->EOF) {
                    continue;
                }
                $to_delete_list .=
                    '<li class="mb-1"><b>ID# ' . $testimonial_id . ' ' .
                    zen_output_string_protected($tm_info->fields['testimonials_name']) . ' ' .
                    zen_output_string_protected($tm_info->fields['testimonials_mail']) .
                    '</b>' . zen_draw_hidden_field("delcust[$index]", $testimonial_id) . '</li>';
                $index++;
            }
            $contents[] = ['text' => '<ul>' . $to_delete_list . '</ul>'];

            $contents[] = ['align' => 'center', 'text' => '<button type="submit" class="btn btn-danger">' . IMAGE_DELETE . '</button> <a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER) . '" class="btn btn-default" role="button">' . IMAGE_CANCEL . '</a>'];
            break;

        default:
            if (!isset($bInfo) || !is_object($bInfo)) {
                break;
            }

            $bInfo->testimonials_title = zen_output_string_protected($bInfo->testimonials_title);
            $heading[] = ['text' => '<h4>' . $bInfo->testimonials_title . '</h4>'];

            $contents[] = [
                'align' => 'center',
                'text' => '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER, $page_param . '&bID=' . $bInfo->testimonials_id . '&action=new') . '" class="btn btn-primary" role="button">' . IMAGE_EDIT . '</a>'
            ];

            $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_STATUS . '</b> '  . ((int)$bInfo->status === 0 ? TEXT_TM_STATUS_0 : TEXT_TM_STATUS_1)];
            $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_RATING . '</b> ' . str_repeat(zen_icon('star-shadow', size: 'lg'), (int)$bInfo->tm_rating)];
            $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_PUBLIC  . '</b> ' . ($bInfo->tm_make_public === 'yes' ? TEXT_YES : TEXT_NO)];

            if (!empty($bInfo->tm_feedback)) {
                $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_FEEDBACK . '</b> ' . zen_output_string_protected($bInfo->tm_feedback)];
            }

            $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_CONTACT_NAME . '</b> ' . zen_output_string_protected($bInfo->testimonials_name)];
            $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_CONTACT_EMAIL . '</b> ' . zen_output_string_protected($bInfo->testimonials_mail)];
            $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_TITLE . '</b> ' . zen_output_string_protected($bInfo->testimonials_title)];
            $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_DESCRIPTION . '</b><br> ' . zen_clean_html($bInfo->testimonials_html_text)];
            $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_CONTACT . '</b> '  . zen_output_string_protected($bInfo->tm_contact_user)];

            if (!empty($bInfo->tm_contact_phone)) {
                $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_CONTACT_PHONE . '</b> ' . zen_output_string_protected($bInfo->tm_contact_phone)];
            }

            $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_PRIVACY . '</b> ' . ((int)$bInfo->tm_privacy_conditions === 1 ? TEXT_YES : TEXT_NO)];
            $contents[] = ['text' => '<b>' . TEXT_HELPFUL . '</b>' . ' ' . sprintf(TEXT_HELPFUL_YES_NO, $bInfo->helpful_yes, $bInfo->helpful_no)];
            $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_GEN_INFO . '</b><br>' . nl2br(zen_output_string_protected($bInfo->tm_gen_info), false)];
            $contents[] = ['text' => '<b>' . TEXT_INFO_TESTIMONIALS_SUBMIT_IMAGE . '</b> ' . (!empty($bInfo->testimonials_upimg) ? $bInfo->testimonials_upimg : TEXT_INFO_NO_IMAGE)];
            if (!empty($bInfo->testimonials_upimg)) {
                $contents[] = ['text' => zen_image(DIR_WS_CATALOG_IMAGES . $bInfo->testimonials_upimg, $bInfo->testimonials_title, 150)];
            }

            $contents[] = ['text' => '<b>' . TEXT_DATE_TESTIMONIALS_CREATED . '</b> ' . zen_date_short($bInfo->date_added)];

            if (!empty($bInfo->last_update)) {
                $contents[] = ['text' => '<b>' . TEXT_DATE_TESTIMONIALS_LAST_MODIFIED . '</b> ' . zen_date_short($bInfo->last_update)];
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
<?php require DIR_WS_INCLUDES . 'application_bottom.php'; ?>
