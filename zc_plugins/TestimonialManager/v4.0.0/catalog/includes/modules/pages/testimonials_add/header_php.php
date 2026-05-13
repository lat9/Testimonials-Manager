<?php
/**
 * Testimonials Manager
 *
 * Last updated: v4.0.0
 *
 * @package Template System
 * @copyright 2007 Clyde Jones
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: DrByte  Sun Oct 18 23:02:01 2015 -0400 Modified in v155 and 156 $
 * @version $Id: Testimonials Manager v2.5 3 01-19-2021 davewest $
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_ADD_TESTIMONIALS');
 
require DIR_WS_MODULES . zen_get_module_directory('require_languages.php');

// if the customer is not logged on, redirect them to the time out page
if (REGISTERED_TESTIMONIAL === 'true' && (!zen_is_logged_in() || zen_in_guest_checkout())) {
    $_SESSION['navigation']->set_snapshot(['mode' => 'SSL', 'page' => FILENAME_TESTIMONIALS_ADD]);
    $messageStack->add_session('login', TEXT_TESTIMONIAL_LOGIN_PROMPT, 'warning');
    zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

$antiSpamFieldName = $_SESSION['antispam_fieldname'] ?? 'should_be_empty';
$mobile_device_name = '';
$screen_size = '';
$make_public = '';
$contact_user = '';
$user_phone = ''; 
$rating = 5;
$feedback = '';
$testimonials_name = '';
$testimonials_mail = '';
$testimonials_title = '';
$testimonials_html_text = '';

$ordered = '';
$action = $_GET['action'] ?? '';
$error = false; //- No errors, initially

if ($action === 'send') {
    //saved in database table
    $rating = (int)($_POST['rating'] ?? ''); //stars 0-5
    $feedback = zen_db_prepare_input($_POST['feedback'] ?? ''); //label of selected group
    $testimonials_name = zen_db_prepare_input($_POST['testimonials_name'] ?? ''); //customer name
    $testimonials_mail = zen_db_prepare_input($_POST['testimonials_mail'] ?? ''); //email address 
    $testimonials_title = zen_db_prepare_input($_POST['testimonials_title'] ?? ''); //title default or user
    $testimonials_html_text = zen_db_prepare_input(strip_tags($_POST['testimonials_html_text'] ?? ''));

    $make_public = zen_db_prepare_input($_POST['make_public'] ?? ''); //yes, no
    //footer lines
    $contact_user = zen_db_prepare_input($_POST['contact_3'] ?? '');    //email, no, phone 
    $user_phone = !empty($_POST['telephone']) ? zen_db_prepare_input($_POST['telephone']) : '';   //123-123-1234
    $privacy_conditions = !empty($_POST['privacy_conditions']) ? (int)$_POST['privacy_conditions'] : 0;    //1=checked 0=unchecked
    $tm_zero = 0;  //Items that need for form without zero.
    $antiSpam = !empty($_POST[$antiSpamFieldName]) ? 'spam' : '';
    if (!empty($testimonials_name) && preg_match('~https?://?~', $testimonials_name)) {
        $antiSpam = 'spam';
    }

    //used in admin only
    $testimonials_wanted = !empty($_POST['find-1']) ? zen_db_prepare_input($_POST['find-1']) : '';   //yes, no 
    $ordered = !empty($_POST['order1']) ? zen_db_prepare_input($_POST['order1']) : '';   //yes, no  
    $mobile_device = zen_db_prepare_input($_POST['mobile_device'] ?? '');
    $mobile_device_name = zen_db_prepare_input($_POST['mobile_device_name'] ?? '');
    $screen_size = zen_db_prepare_input($_POST['screen_size'] ?? '');
    $feedback_about = !empty($_POST['feedback_about']) ? zen_db_prepare_input($_POST['feedback_about']) : ''; //Associate feedback, In-Store experience, Associate feedback

    $gen_info = 
        "Find what you wanted: $testimonials_wanted\n" .
        "Already placed an order: $ordered\n" .
        "Mobile device used:  $mobile_device\n" .
        "Mobile device name: $mobile_device_name\n" .
        "Screen info: $screen_size\n" .
        "In store feedback $feedback_about";

    if (zen_validate_email($testimonials_mail) === false) {
        $error = true;
        $messageStack->add('new_testimonial', ENTRY_EMAIL_ADDRESS_CHECK_ERROR, 'error');
    }

    //check for banned email
    $check_banned = $db->Execute("SELECT status, testimonials_mail FROM " . TABLE_TESTIMONIALS_MANAGER . " WHERE testimonials_mail = '" . $testimonials_mail . "' AND status = 2");

    if (!$check_banned->EOF) {
        $error = true;
        $messageStack->add('new_testimonial', 'Sorry, you was Banned for Spam!', 'error');
    }

   if (DISPLAY_PRIVACY_CONDITIONS === 'true' && $privacy_conditions !== 1) {
        $error = true;
        $messageStack->add('new_testimonial', ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED, 'error');
    }
    
    if (strlen($testimonials_name) < 3) {
        $error = true;
        $messageStack->add('new_testimonial', ERROR_TESTIMONIALS_NAME_REQUIRED, 'error');
    }

    if (strlen($testimonials_html_text) < (int)ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH) {
        $error = true;
        $messageStack->add('new_testimonial', ERROR_TESTIMONIALS_TEXT_MIN_LENGTH, 'error');
    }
  
    if (strlen($testimonials_html_text) > (int)ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH) {
        $error = true;
        $entry_description_big_error = true;
        $messageStack->add('new_testimonial', ERROR_TESTIMONIALS_TEXT_MAX_LENGTH, 'error');  
    }
  
    if ($contact_user === 'phone' && strlen($user_phone) < (int)ENTRY_TELEPHONE_MIN_LENGTH) {
        $error = true;
        $messageStack->add('new_testimonial', ENTRY_TELEPHONE_NUMBER_ERROR, 'error');
    }

    if ($rating < 0 || $rating > 5) {
        $error = true;
        $messageStack->add('new_testimonial', TESTIMONIAL_RATING, 'error');
    }
  
    if (!in_array($contact_user, ['no', 'email', 'phone'], true)) {
        $error = true;
        $messageStack->add('new_testimonial', ERROR_CONTACT_USER, 'error');
    }
  
    if ($testimonials_title === '') {
        $error = true;
        $messageStack->add('new_testimonial', ERROR_TESTIMONIALS_TITLE_REQUIRED, 'error');
    }
  
    if ($make_public === '') {
        $error = true;
        $messageStack->add('new_testimonial', ERROR_TESTIMONIALS_TITLE_REQUIRED, 'error');
    }

    if ($error === false) {
        // if anti-spam is not triggered, prepare and send email:
        if ($antiSpam !== '') {
            $zco_notifier->notify('NOTIFY_SPAM_DETECTED_USING_CONTACT_US');
        } else {
            $language_id = (int)$_SESSION['languages_id'];

            // Upload when form field is filled in by user TM_UPLOAD_DIRECTORY
            $file = '';
            if (DISPLAY_ADD_IMAGE === 'on' && isset($_POST['tm_img'], $_FILES['tm_img']['tmp_name']) && $_FILES['tm_img']['tmp_name'] !== 'none') {
                $upimg = new upload('tm_img');
                $upimg->set_extensions(['jpg', 'jpeg', 'png']);
                $tm_upload_directory = trim(TM_UPLOAD_DIRECTORY, '/') . '/';
                $upimg->set_destination(DIR_FS_CATALOG . DIR_WS_IMAGES . $tm_upload_directory);
                $upimg->set_output_messages('direct');
                if ($upimg->parse() && $upimg->save()) {
                    $upimg_name = $tm_upload_directory . $upimg->filename;
                }
                if ($upimg->filename !== 'none' && $upimg->filename !== '') {
                    // save filename when not set to none and not blank
                    $file = zen_limit_image_filename($upimg_name, TABLE_TESTIMONIALS_MANAGER, 'testimonials_upimg');
                }
            }

            $sql_data_array = [
                'language_id' => (int)$language_id,
                'testimonials_title' => $testimonials_title,
                'testimonials_name' => $testimonials_name,
                'testimonials_html_text' => $testimonials_html_text,
                'testimonials_upimg' => $file,
                'testimonials_mail' => $testimonials_mail,
                'tm_rating' => (int)$rating,
                'tm_feedback' => $feedback, 
                'tm_make_public' => $make_public,
                'tm_contact_user' => $contact_user,
                'tm_contact_phone' => $user_phone,
                'tm_privacy_conditions' => (int)$privacy_conditions,
                'status' => (int)$tm_zero,
                'date_added' => 'now()',
                'tm_gen_info' => $gen_info,
                'helpful_yes' => (int)$tm_zero,
                'helpful_no' => (int)$tm_zero,
            ];
            zen_db_perform(TABLE_TESTIMONIALS_MANAGER, $sql_data_array);

            $testimonials_id = $db->Insert_ID(); 

            // auto complete when logged in
            if (zen_is_logged_in() && !zen_in_guest_checkout()) {
                $sql =
                    "SELECT customers_id, customers_firstname, customers_lastname, customers_password, customers_email_address, customers_default_address_id, customers_telephone
                       FROM " . TABLE_CUSTOMERS . "
                      WHERE customers_id = :customersID";
                $sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
                $check_customer = $db->Execute($sql, 1);
                $customer_email = $check_customer->fields['customers_email_address'];
                $customer_name  = $check_customer->fields['customers_firstname'] . ' ' . $check_customer->fields['customers_lastname'];
                $customer_telephone = $check_customer->fields['customers_telephone'];
            } else {
                $customer_email = NOT_LOGGED_IN_TEXT;
                $customer_name = NOT_LOGGED_IN_TEXT;
                $customer_telephone = NOT_LOGGED_IN_TEXT;
            }

            // build the message content
            $send_to_email = trim(EMAIL_FROM); // default to EMAIL_FROM
            $send_to_name  = trim(STORE_OWNER);  // default to STORE_NAME
 
            // Prepare extra-info details
            $extra_info = email_collect_extra_info($testimonials_name, $testimonials_mail, $customer_name, $customer_email, $customer_telephone);
     
            // Prepare Text-only portion of message
            $text_message = OFFICE_FROM . "\t" . $testimonials_name . "\n" . OFFICE_EMAIL . "\t" . $testimonials_mail . "\n";
            
            if (!empty($user_phone)) {
                $text_message .= OFFICE_LOGIN_PHONE . "\t" . $user_phone . "\n";
            }

            $text_message .=
                "\n" .
                EMAIL_TEXT . "\n" .
                EMAIL_SEPARATOR . "\n" .
                $testimonials_html_text .  "\n" .
                EMAIL_SEPARATOR . "\n\n" .
                $extra_info['TEXT'];
      
            // Prepare HTML-portion of message
            $html_msg['EMAIL_MESSAGE_HTML'] = $testimonials_html_text;
            $html_msg['EXTRA_INFO'] = $extra_info['HTML'];
            // Send message

            //send email to message to admin or not  
            zen_mail($send_to_name, $send_to_email, EMAIL_SUBJECT, $text_message, $testimonials_name, $testimonials_mail, $html_msg, 'default');

            zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_ADD, 'action=success'));      
        }
    }
} // eof form submit

if (!$error && zen_is_logged_in() && !zen_in_guest_checkout()) {
    $sql = "SELECT * FROM " . TABLE_CUSTOMERS . " WHERE customers_id = :customersID ";
    $sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
    $check_customer = $db->Execute($sql, 1);

    $testimonials_mail = $check_customer->fields['customers_email_address'];
    $testimonials_name = $check_customer->fields['customers_firstname'];
    $user_phone = $check_customer->fields['customers_telephone'];
}

$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_TESTIMONIALS_ADD, 'false');

$breadcrumb->add(NAVBAR_TITLE);

// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_ADD_TESTIMONIALS');
