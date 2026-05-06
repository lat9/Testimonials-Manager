<?php
/**
 * Testimonials Manager
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
 
require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

// if the customer is not logged on, redirect them to the time out page
if (REGISTERED_TESTIMONIAL == 'true'){
  if (!zen_is_logged_in()) {
    $_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_SHIPPING));
      $messageStack->add_session('login', TEXT_TESTIMONIAL_LOGIN_PROMPT, 'warning');
      zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
  }
}

 $tm_plugin = $db->Execute("SELECT status FROM " . TABLE_PLUGIN_CONTROL . " WHERE unique_key = 'TestimonialManager'");
 $tmStatus = ($tm_plugin->fields['status'] == 2) ? 'off' : TM_DISPLAY_SUBMIT;

$antiSpamFieldName = $_SESSION['antispam_fieldname'] ?? 'should_be_empty';
$mobile_device_name  = $screen_size  = $make_public = $contact_user = $user_phone = ''; 
$rating = $feedback = $testimonials_name = $testimonials_mail = $testimonials_title = $testimonials_html_text = '';
 
  if (isset($_GET['action']) && ($_GET['action'] == 'send')) {

    //saved in database table
        $rating = zen_db_prepare_input($_POST['rating'] ?? ''); //stars 1-5
        $feedback = zen_db_prepare_input($_POST['feedback'] ?? ''); //label of selected group
        $testimonials_name = zen_db_prepare_input($_POST['testimonials_name'] ?? ''); //customer name
        $testimonials_mail = zen_db_prepare_input($_POST['testimonials_mail'] ?? ''); //email address 
        $testimonials_title = zen_db_prepare_input($_POST['testimonials_title'] ?? ''); //title default or user
        $testimonials_html_text = zen_db_prepare_input(strip_tags($_POST['testimonials_html_text'] ?? '')); //message        
        $testimonials_avatar = zen_db_prepare_input($_POST['avatar_register'] ?? '');
        $make_public = zen_db_prepare_input($_POST['make_public'] ?? ''); //yes, no
        //footer lines
        $contact_user = zen_db_prepare_input($_POST['contact_3'] ?? '');    //email, no, phone 
        $user_phone = !empty($_POST['telephone']) ? zen_db_prepare_input($_POST['telephone']) : '';   //123-123-1234         
        $privacy_conditions = !empty($_POST['privacy_conditions']) ? zen_db_prepare_input($_POST['privacy_conditions']) : '';    //1=checked 0=unchecked
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

//format image for storage/use helps to prevent image hacks
$base_image = substr($testimonials_avatar, strrpos($testimonials_avatar, '/') + 1); //remove all folders from name
$testimonials_avatar = TESTIMONIAL_IMAGE_DIRECTORY . $base_image; //reformat with image base folder and name


            // Upload when form field is filled in by user 
            
         $file = '';
        if (DISPLAY_ADD_IMAGE == 'on') {  //on off turns on/off uploads
           if (strpos($_POST['tm_img'], 'data:image') === 0) {
                $img = $_POST['tm_img'];
   
                if (strpos($img, 'data:image/jpeg;base64,') === 0) {
                $img = str_replace('data:image/jpeg;base64,', '', $img);  
                $ext = '.jpg';
                }
                if (strpos($img, 'data:image/png;base64,') === 0) {
                $img = str_replace('data:image/png;base64,', '', $img); 
                $ext = '.png';
                }
   
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file = TM_UPLOAD_DIRECTORY . 'img'.date("YmdHis").$ext;
     if (file_put_contents(DIR_WS_IMAGES . $file, $data)) {
      $messageStack->add('new_testimonial', 'The image was saved');
  } else {
      $messageStack->add('new_testimonial', 'The image could not be saved' , 'error');
  } 
             
            } 
        }
   
                
        $gen_info = 
"Find what you wanted:" . ". . . " . $testimonials_wanted . "<br />" . 
"Already placed an order:" . " . " . $ordered . "<br />" .
"Mobile divice used:" . ". . . . " . $mobile_device . "<br />" .
"Mobile divice name:" . ". . . . " . $mobile_device_name . "<br />" .
"Screen info:" . ". . . . . . . " . $screen_size . "<br />" .
"In store feedback:" . ". . . . " . $feedback_about;

  //  if (!empty($_POST['testimonials_name']) && preg_match('~https?://?~', $_POST['testimonials_name'])) $antiSpam = 'spam';
    if ($tmStatus == 'off') $antiSpam = 'killsend';  //if tm status off, same as spam... 

   // $zco_notifier->notify('NOTIFY_CONTACT_US_CAPTCHA_CHECK', $_POST);
     
//begin testing for errors
  $error = false;
 
  $zc_validate_email = zen_validate_email($testimonials_mail);

if ($zc_validate_email == false) {
    $error = true;
    $messageStack->add('new_testimonial', ENTRY_EMAIL_ADDRESS_CHECK_ERROR, 'error');
  }

//check for banned email
  $check_banned = $db->Execute("SELECT status, testimonials_mail FROM " . TABLE_TESTIMONIALS_MANAGER . " WHERE testimonials_mail = '" . $testimonials_mail . "' and status = 2");

if (!empty($check_banned->fields['status'])) {
  if($check_banned->fields['status'] == 2) {  // status problem
    $error = true;
    $messageStack->add('new_testimonial', 'Sorry, you was Banned for Spam!', 'error');
  }
}

   if (DISPLAY_PRIVACY_CONDITIONS == 'true') {
    if ($privacy_conditions != '1') {
      $error = true;
      $messageStack->add('new_testimonial', ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED, 'error');
    }
  }  
    
  if (strlen($testimonials_name) < 3) {
    $error = true;
    $messageStack->add('new_testimonial', ERROR_TESTIMONIALS_NAME_REQUIRED, 'error');
  } 
  
  if (empty($testimonials_html_text) or strlen($testimonials_html_text) < ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH) {
    $error = true;
    $messageStack->add('new_testimonial', ERROR_TESTIMONIALS_TEXT_MIN_LENGTH, 'error');
  }
  
  if (strlen($testimonials_html_text) > ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH) {
    $error = true;
    $entry_description_big_error = true;
    $messageStack->add('new_testimonial', ERROR_TESTIMONIALS_TEXT_MAX_LENGTH, 'error');  
  }
  
if ($contact_user == TEXT_FIELD_CONTACT_PHONE) {
  if (strlen($user_phone) < ENTRY_TELEPHONE_MIN_LENGTH) {
    $error = true;
    $messageStack->add('new_testimonial', ENTRY_TELEPHONE_NUMBER_ERROR, 'error');
  }
}

  if (($rating < 1) || ($rating > 5)) {
    $error = true;
    $messageStack->add('new_testimonial', TESTIMONIAL_RATING, 'error');
  }
  
  if (($contact_user != TEXT_NO) && ($contact_user != TEXT_FIELD_CONTACT_EMAIL) && ($contact_user != TEXT_FIELD_CONTACT_PHONE)) {
    $error = true;
    $messageStack->add('new_testimonial', ERROR_CONTACT_USER, 'error');
  }
  
  if ($testimonials_title == '') {
    $error = true;
    $messageStack->add('new_testimonial', ERROR_TESTIMONIALS_TITLE_REQUIRED, 'error');
  }
  
  if ($make_public == '') {
    $error = true;
    $messageStack->add('new_testimonial', ERROR_TESTIMONIALS_TITLE_REQUIRED, 'error');
  }
        
    if ($error == false) {
 // if anti-spam is not triggered, prepare and send email:
   if ($antiSpam != '') {
      $zco_notifier->notify('NOTIFY_SPAM_DETECTED_USING_CONTACT_US');
   } elseif ($antiSpam == '')  {

      $language_id = (int)$_SESSION['languages_id'];

	$sql_data_array = array(
	  'language_id' => (int)$language_id, 
	  'testimonials_title' => $testimonials_title, 
          'testimonials_name' => $testimonials_name, 
          'testimonials_html_text' => $testimonials_html_text,       
          'testimonials_image' => $testimonials_avatar, 
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
          'helpful_no' => (int)$tm_zero
        );
     zen_db_perform(TABLE_TESTIMONIALS_MANAGER, $sql_data_array);

   $testimonials_id = $db->Insert_ID(); 

 // auto complete when logged in
            if (zen_is_logged_in() && !zen_in_guest_checkout()) {
                $sql = "SELECT customers_id, customers_firstname, customers_lastname, customers_password, customers_email_address, customers_default_address_id, customers_telephone 
                      FROM " . TABLE_CUSTOMERS . "
                      WHERE customers_id = :customersID";

                $sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
                $check_customer = $db->Execute($sql);
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
            $text_message .= "\n" . EMAIL_TEXT . "\n" .
            EMAIL_SEPARATOR . "\n" .
            $testimonials_html_text .  "\n" .
            EMAIL_SEPARATOR . "\n\n" .
            $extra_info['TEXT'];
      
            // Prepare HTML-portion of message
            $html_msg['EMAIL_NAME'] = EMAIL_GREET . $testimonials_name;
            $html_msg['EMAIL_MESSAGE_HTML'] = $testimonials_html_text;
            //$html_msg['CONTACT_US_OFFICE_FROM'] = OFFICE_FROM . ' ' . $testimonials_name . '<br>' . OFFICE_EMAIL . '(' . $testimonials_mail . ')';
            $html_msg['EXTRA_INFO'] = $extra_info['HTML'];
            // Send message
            
                  
   //send email to massage to admin or not  
         zen_mail($send_to_name, $send_to_email, EMAIL_SUBJECT, $text_message, $testimonials_name, $testimonials_mail, $html_msg,'testimonial_add');
                  
       zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_ADD, 'action=success'));      
  }
     

}

  } // eof form submit
     
if (!empty($_SESSION['customer_id'])) {  //!zen_is_logged_in())
  $sql = "SELECT * FROM " . TABLE_CUSTOMERS . " WHERE customers_id = :customersID ";
  
  $sql = $db->bindVars($sql, ':customersID', $_SESSION['customer_id'], 'integer');
  $check_customer = $db->Execute($sql);
  
      $testimonials_mail = $check_customer->fields['customers_email_address'];
      $testimonials_name = $check_customer->fields['customers_firstname'];
      $user_phone = $check_customer->fields['customers_telephone'];
      $tm_avatar = $check_customer->fields['tm_avatar'];  //only works with user avatar installed

}

//images/avatars/at_1.png
//get all avatars with at_ .png ONLY 
//any avatars not name as above is not used
//randaum selection of 7 to display. Spinner button would be nice.
$dir = DIR_WS_IMAGES . TESTIMONIAL_IMAGE_DIRECTORY;  //updated to play nice
$at_avatars = '';
$loop = GLOB($dir. '{at_}*{jpg,png}', GLOB_BRACE); // look for only jpg and png *{.jpg, .png}

$catchme = array_rand($loop, 7);

 $at_avatars .= '<img src="' . $loop[$catchme[0]] . '"><img src="' . $loop[$catchme[1]] . '"><img src="' . $loop[$catchme[2]] . '"><img src="' . $loop[$catchme[3]] . '"><img src="' . $loop[$catchme[4]] . '"><img src="' . $loop[$catchme[5]] . '"><img src="' . $loop[$catchme[6]] . '"> ';

  // include template specific file name defines

$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_TESTIMONIALS_ADD, 'false');

    $breadcrumb->add(NAVBAR_TITLE);

  // This should be last line of the script:
  $zco_notifier->notify('NOTIFY_HEADER_END_ADD_TESTIMONIALS');
