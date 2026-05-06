<?php
/**
 * Testimonials Manager
 *
 * @package Template System
 * @copyright 2007 Clyde Jones
  * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Testimonials Manager v3.0 13 9-19-2022 davewest $
 */
?>


<div class="centerColumn" id="testimonialDefault">
<?php echo HEADING_ADD_TITLE; ?>

<div class="center">
<?php
/** display shop total reviews */
 include($template->get_template_dir('/tpl_tm_total_reviews.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_tm_total_reviews.php'); ?>
</div>
<br class="clearBoth" />

<?php echo zen_draw_form('new_testimonial', zen_href_link(FILENAME_TESTIMONIALS_ADD, 'action=send', $request_type),'post','enctype="multipart/form-data" '); ?>

<?php if (TESTIMONIAL_STORE_NAME_ADDRESS == 'true') { ?>
<address><?php echo nl2br(STORE_NAME_ADDRESS); ?></address>
<br class="clearBoth" />
<?php } ?>

<?php
  if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
?>

<br class="clearBoth" />
<div class="mainContent success"><?php echo TESTIMONIAL_SUCCESS; ?></div>
<div class="buttonRow back"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) .'</a>'; ?></div>

<?php
  } else {
?>

<?php if (DEFINE_TESTIMONIAL_STATUS >= '1' and DEFINE_TESTIMONIAL_STATUS <= '2') { ?>
<div id="pageThreeMainContent">
<?php
require($define_page);
?>
</div>
<?php } ?>
<br class="clearBoth" />

<?php if ($messageStack->size('new_testimonial') > 0) echo $messageStack->output('new_testimonial'); ?>
<div class="pseudolink back"><?php echo FORM_REQUIRED_INFORMATION . ' ' . EXCLAMATION_TRIANGLE; ?></div>
<br class="clearBoth" />

<div class="tm-wrapper"> 

<div class="main_box">
<div class="logo2">
<h2><?php echo TEXT_TESTIMONIALS_HEADER; ?></h2>
</div>
<p class="questionarea"><?php echo TEXT_TESTIMONIALS_FEEDBACK; ?></p>

<?php if($tmStatus === 'on') {  ?>  

<div class="boxcontainer">
<div id="reviewsWriteReviewsRate"><?php echo TESTIMONIAL_GIVE_RATING; ?></div>
 <div class="masterdog">
    <div class="starspace">
        <input name="rating" value="1" id="startip-1" type="radio" class="angry"><label for="startip-1"></label>
        <input name="rating" value="2" id="startip-2" type="radio" class="okok"><label for="starip-2"></label>
        <input name="rating" value="3" id="startip-3" type="radio" class="good"><label for="starip-3"></label>
        <input name="rating" value="4" id="startip-4" type="radio" class="better"><label for="startip-4"></label>
        <input name="rating" value="5" id="startip-5" type="radio" class="awesome"> <label for="startip-5"></label>
     <span id="showme-5"><?php echo TEXT_RATING_5; ?></span><span id="showme-4"><?php echo TEXT_RATING_4; ?></span><span id="showme-3"><?php echo TEXT_RATING_3; ?></span><span id="showme-2"><?php echo TEXT_RATING_2; ?></span><span id="showme-1"><?php echo TEXT_RATING_1; ?></span><span id="removeme"></span> 
    </div>       
 </div>
</div>

<!-- INPUT LAYOUT START -->
<div class="answersection">

    <div class="switch-field">
    
<!-- online shopping experience switch_1 //-->      
      <div>
      <?php echo zen_draw_radio_field('feedback', LABEL_FEEDBACK_1, '', 'id="switch_1"') . '<label for="switch_1">' . LABEL_FEEDBACK_1 . '</label>'; ?>
       <div class="reveal-if-active go-up"> 
                 
       <div>
       <?php echo zen_draw_input_field('testimonials_name', $testimonials_name, ' id="testimonials_name_1" pattern="^([- \w\d\u00c0-\u024f]+)$" title="' . ALT_FIELD_NAME . '" class="require-if-active resizeField" data-require-pair="#switch_1"'); ?>
       <div class="label"><?php echo TEXT_TESTIMONIALS_NAME; ?> </div>
       </div>
 <?php if (empty($_SESSION['customer_id'])) { ?>
      <?php echo '<i title="' . TITLE_EMAIL . '">' . EXCLAMATION_CIRCLE . '</i>'; ?>
      <div >
      <?php echo zen_draw_input_field('testimonials_mail', $testimonials_mail, ' id="testimonials_mail" spellcheck="false" title="' . ALT_FIELD_EMAIL . '" pattern="^(([-\w\d]+)(\.[-\w\d]+)*@([-\w\d]+)(\.[-\w\d]+)*(\.([a-zA-Z]{2,5}|[\d]{1,3})){1,2})$" class="require-if-active resizeField" data-require-pair="#switch_1"', 'email') ; ?>
      <div class="label"><?php echo TEXT_TESTIMONIALS_MAIL; ?> </div>
      </div>
    <?php }else{ ?>   
    <?php echo zen_draw_hidden_field('testimonials_mail', $testimonials_mail); 
     } ?>     
    
      <div>
      <input type="text" name="testimonials_title" value="<?php echo TEXT_FIELD_1_TITLE; ?>" id="testimonials_title" pattern="^([- \w\d\u00c0-\u024f]+)$" title="<?php echo ALT_FIELD_TITLE; ?>" class="require-if-active resizeField" data-require-pair="#switch_1" required="">      <div class="label"><?php echo TEXT_TESTIMONIALS_TITLE; ?></div>
      </div>
      
      <div>
      <div><?php echo TEXT_FIELD_1_QUESTION1; ?><br />
      <?php echo zen_draw_radio_field('find-1', TEXT_YES, '', 'id="find_yes"') . '<label for="find_yes" class="inputLabel">' . TEXT_YES . '</label>' . zen_draw_radio_field('find-1', TEXT_NO, '', 'id="find_no"') . '<label for="find_no" class="inputLabel">' . TEXT_NO . '</label>'; ?>
      </div></div>
      
      <p><?php echo TEXT_FIELD_1_QUESTION2; ?></p>
     <div >
     <?php echo zen_draw_textarea_field('testimonials_html_text', '70', '4', $testimonials_html_text, 'id="testimonials_html_text" pattern="^([- \w\d\u00c0-\u024f]+)$" class="require-if-active resizeField" data-require-pair="#switch_1"');  ?>
     <div class="label"><?php echo TEXT_TESTIMONIALS_DESCRIPTION; ?></div>
     </div>
      
       </div>
       </div>
       
<!-- online order experience switch_2 //-->       
      <div>       
      <?php echo zen_draw_radio_field('feedback', LABEL_FEEDBACK_2, '', 'id="switch_2"') . '<label for="switch_2">' . LABEL_FEEDBACK_2 . '</label>'; ?>
      <div class="reveal-if-active go-up"> 
                 
       <div>
       <?php echo zen_draw_input_field('testimonials_name', $testimonials_name, ' id="testimonials_name_2" pattern="^([- \w\d\u00c0-\u024f]+)$" title="' . ALT_FIELD_NAME . '" class="require-if-active resizeField" data-require-pair="#switch_2"'); ?>
       <div class="label"><?php echo TEXT_TESTIMONIALS_NAME; ?> </div>
       </div>
 <?php if (empty($_SESSION['customer_id'])) { ?>
      <?php echo '<i title="' . TITLE_EMAIL . '">' . EXCLAMATION_CIRCLE . '</i>'; ?>
      <div >
      <?php echo zen_draw_input_field('testimonials_mail', $testimonials_mail, ' id="testimonials_mail" spellcheck="false" title="' . ALT_FIELD_EMAIL . '" pattern="^(([-\w\d]+)(\.[-\w\d]+)*@([-\w\d]+)(\.[-\w\d]+)*(\.([a-zA-Z]{2,5}|[\d]{1,3})){1,2})$" class="require-if-active resizeField" data-require-pair="#switch_2"', 'email') ; ?>
      <div class="label"><?php echo TEXT_TESTIMONIALS_MAIL; ?> </div>
      </div>
    <?php }else{ ?>   
    <?php echo zen_draw_hidden_field('testimonials_mail', $testimonials_mail); 
     } ?>  
      <div>
      <input type="text" name="testimonials_title" value="<?php echo TEXT_FIELD_2_TITLE; ?>" id="testimonials_title" pattern="^([- \w\d\u00c0-\u024f]+)$" title="<?php echo ALT_FIELD_TITLE; ?>" class="require-if-active resizeField" data-require-pair="#switch_2" required="">      <div class="label"><?php echo TEXT_TESTIMONIALS_TITLE; ?></div>
      </div>
      <div>
      <div><?php echo TEXT_FIELD_2_QUESTION1; ?><br />
      <?php echo zen_draw_radio_field('order1', TEXT_YES, '', 'id="order_yes"') . '<label for="order_yes" class="inputLabel">' . TEXT_YES . '</label>' . zen_draw_radio_field('order1', TEXT_NO, '', 'id="order_no"') . '<label for="order_no" class="inputLabel">' . TEXT_NO . '</label>'; ?>
      </div></div>        
        
      <p><?php echo TEXT_FIELD_1_QUESTION2; ?></p>
      <div >
     <?php echo zen_draw_textarea_field('testimonials_html_text', '70', '4', $testimonials_html_text, 'id="testimonials_html_text" pattern="^([- \w\d\u00c0-\u024f]+)$" class="require-if-active resizeField" data-require-pair="#switch_2"');  ?>
     <div class="label"><?php echo TEXT_TESTIMONIALS_DESCRIPTION; ?></div>
     </div>
           
       </div>
       </div>
<!-- Mobile shopping experience switch_3 //-->       
      <div>       
      <?php echo zen_draw_radio_field('feedback', LABEL_FEEDBACK_3, '', 'id="switch_3"') . '<label for="switch_3">' . LABEL_FEEDBACK_3 . '</label>'; ?>
       <div class="reveal-if-active go-up"> 
                 
       <div>
       <?php echo zen_draw_input_field('testimonials_name', $testimonials_name, ' id="testimonials_name_3" pattern="^([- \w\d\u00c0-\u024f]+)$" title="' . ALT_FIELD_NAME . '" class="require-if-active resizeField" data-require-pair="#switch_3"'); ?>
       <div class="label"><?php echo TEXT_TESTIMONIALS_NAME; ?> </div>
       </div>
 <?php if (empty($_SESSION['customer_id'])) { ?>
      <?php echo '<i title="' . TITLE_EMAIL . '">' . EXCLAMATION_CIRCLE . '</i>'; ?> 
      <div >
      <?php echo zen_draw_input_field('testimonials_mail', $testimonials_mail, ' id="testimonials_mail" spellcheck="false" title="' . ALT_FIELD_EMAIL . '" pattern="^(([-\w\d]+)(\.[-\w\d]+)*@([-\w\d]+)(\.[-\w\d]+)*(\.([a-zA-Z]{2,5}|[\d]{1,3})){1,2})$" class="require-if-active resizeField" data-require-pair="#switch_3"', 'email') ; ?>
      <div class="label"><?php echo TEXT_TESTIMONIALS_MAIL; ?> </div>
      </div>
    <?php }else{ ?>   
    <?php echo zen_draw_hidden_field('testimonials_mail', $testimonials_mail); 
     } ?>  
      <div>
      <input type="text" name="testimonials_title" value="<?php echo TEXT_FIELD_3_TITLE; ?>" id="testimonials_title" pattern="^([- \w\d\u00c0-\u024f]+)$" title="<?php echo ALT_FIELD_TITLE; ?>" class="require-if-active resizeField" data-require-pair="#switch_3" required="">      <div class="label"><?php echo TEXT_TESTIMONIALS_TITLE; ?></div>
      </div>      
      <div>
      <?php echo zen_draw_hidden_field('mobile_device', 'none'); ?>
      <?php echo zen_draw_checkbox_field('mobile_device', TEXT_YES, false, ' id="mobile_device" ') . '<label for="mobile_device" >' . TEXT_FIELD_3_QUESTION1 . '</label>'; ?>
      <div class="reveal-if-active">
       <div for="mobile_device_name"><?php echo TEXT_FIELD_3_QUESTION2; ?></div>
       <?php echo zen_draw_input_field('mobile_device_name', $mobile_device_name, ' id="mobile_device_name" class="resizeField" placeholder="iPhone x" title="' . TEXT_FIELD_3_QUESTION3 . '" data-require-pair="#mobile_device"'); ?>    
      <br />  
       <div for="papermap_qa"><?php echo TEXT_FIELD_3_QUESTION4; ?></div>
       <?php echo zen_draw_input_field('screen_size', $screen_size, ' id="screen_size" class="resizeField" placeholder="1 x 3 inch" title="' . ALT_FIELD_3_QUESTION4 . '" data-require-pair="#mobile_device"'); ?>
      </div></div>      
      
      <p><?php echo TEXT_FIELD_3_QUESTION5; ?></p>
      <div >
     <?php echo zen_draw_textarea_field('testimonials_html_text', '70', '4', $testimonials_html_text, 'id="testimonials_html_text" pattern="^([- \w\d\u00c0-\u024f]+)$" class="require-if-active resizeField" data-require-pair="#switch_3"');  ?>
     <div class="label"><?php echo TEXT_TESTIMONIALS_DESCRIPTION; ?></div>
     </div>
              
       </div>
       </div>
<!-- Store Experience switch_4 //-->       
      <div>      
      <?php echo zen_draw_radio_field('feedback', LABEL_FEEDBACK_4, '', 'id="switch_4"') . '<label for="switch_4">' . LABEL_FEEDBACK_4 . '</label>'; ?>
       <div class="reveal-if-active go-up"> 
                 
       <div>
       <?php echo zen_draw_input_field('testimonials_name', $testimonials_name, ' id="testimonials_name_4" pattern="^([- \w\d\u00c0-\u024f]+)$" title="' . ALT_FIELD_NAME . '" class="require-if-active resizeField" data-require-pair="#switch_4"'); ?>
       <div class="label"><?php echo TEXT_TESTIMONIALS_NAME; ?> </div>
       </div>
 <?php if (empty($_SESSION['customer_id'])) { ?>
      <?php echo '<i title="' . TITLE_EMAIL . '">' . EXCLAMATION_CIRCLE . '</i>'; ?>  
      <div >
      <?php echo zen_draw_input_field('testimonials_mail', $testimonials_mail, ' id="testimonials_mail" spellcheck="false" title="' . ALT_FIELD_EMAIL . '" pattern="^(([-\w\d]+)(\.[-\w\d]+)*@([-\w\d]+)(\.[-\w\d]+)*(\.([a-zA-Z]{2,5}|[\d]{1,3})){1,2})$" class="require-if-active resizeField" data-require-pair="#switch_4"', 'email') ; ?>
      <div class="label"><?php echo TEXT_TESTIMONIALS_MAIL; ?> </div>
      </div>
    <?php }else{ ?>   
    <?php echo zen_draw_hidden_field('testimonials_mail', $testimonials_mail); 
     } ?> 
      <div>
      <input type="text" name="testimonials_title" value="<?php echo TEXT_FIELD_4_TITLE; ?>" id="testimonials_title" pattern="^([- \w\d\u00c0-\u024f]+)$" title="<?php echo ALT_FIELD_TITLE; ?>" class="require-if-active resizeField" data-require-pair="#switch_4" required="">      <div class="label"><?php echo TEXT_TESTIMONIALS_TITLE; ?></div>
      </div>      
      <div>
      <div class="switch-title"><?php echo TEXT_FIELD_4_QUESTION1; ?></div>
      <?php echo zen_draw_radio_field('feedback_about', TEXT_FIELD_4_QUESTION2, '', 'id="store_feedback_1"') . '<label for="store_feedback_1" class="feedbackLabel" title="' . TEXT_FIELD_4_QUESTION2 . '">' . TEXT_OPTION_1 . '</label> <div>' . TEXT_FIELD_4_QUESTION2 . '</div>';  ?>
<br class="clearBoth" />       
       <?php echo zen_draw_radio_field('feedback_about', TEXT_FIELD_4_QUESTION3, '', 'id="store_feedback_2"') . '<label for="store_feedback_2" class="feedbackLabel" title="' . TEXT_FIELD_4_QUESTION3 . '">' . TEXT_OPTION_2 . '</label> <div>' . TEXT_FIELD_4_QUESTION3 . '</div>'; ?>
<br class="clearBoth" />       
       <?php  echo zen_draw_radio_field('feedback_about', TEXT_FIELD_4_QUESTION4, '', 'id="store_feedback_3"') . '<label for="store_feedback_3" class="feedbackLabel" title="' . TEXT_FIELD_4_QUESTION4 . '">' . TEXT_OPTION_3 . '</label> <div>' . TEXT_FIELD_4_QUESTION4 . '</div>'; ?>
      </div>
      
      <p><?php echo TEXT_FIELD_4_QUESTION5; ?></p>
      <div >
     <?php echo zen_draw_textarea_field('testimonials_html_text', '70', '4', $testimonials_html_text, 'id="testimonials_html_text" pattern="^([- \w\d\u00c0-\u024f]+)$" class="require-if-active resizeField" data-require-pair="#switch_4"');  ?>
     <div class="label"><?php echo TEXT_TESTIMONIALS_DESCRIPTION; ?></div>
     </div>
              
       </div>
       </div>
 <!-- Other feedback switch_5 //-->      
      <div>      
      <?php echo zen_draw_radio_field('feedback', LABEL_FEEDBACK_6, '', 'id="switch_5"') . '<label for="switch_5">' . LABEL_FEEDBACK_6 . '</label>'; ?>
      <div class="reveal-if-active go-up"> 
                 
       <div>
       <?php echo zen_draw_input_field('testimonials_name', $testimonials_name, ' id="testimonials_name_6" pattern="^([- \w\d\u00c0-\u024f]+)$" title="' . ALT_FIELD_NAME . '" class="require-if-active resizeField" data-require-pair="#switch_5"'); ?>
       <div class="label"><?php echo TEXT_TESTIMONIALS_NAME; ?> </div>
       </div>
 <?php if (empty($_SESSION['customer_id'])) { ?>
      <?php echo '<i title="' . TITLE_EMAIL . '">' . EXCLAMATION_CIRCLE . '</i>'; ?> 
      <div >
      <?php echo zen_draw_input_field('testimonials_mail', $testimonials_mail, ' id="testimonials_mail" spellcheck="false" title="' . ALT_FIELD_EMAIL . '" pattern="^(([-\w\d]+)(\.[-\w\d]+)*@([-\w\d]+)(\.[-\w\d]+)*(\.([a-zA-Z]{2,5}|[\d]{1,3})){1,2})$" class="require-if-active resizeField" data-require-pair="#switch_5"', 'email') ; ?>
      <div class="label"><?php echo TEXT_TESTIMONIALS_MAIL; ?> </div>
      </div>
    <?php }else{ ?>   
    <?php echo zen_draw_hidden_field('testimonials_mail', $testimonials_mail); 
     } ?>            
      <div>
      <input type="text" name="testimonials_title" value="<?php echo TEXT_FIELD_6_TITLE; ?>" id="testimonials_title" pattern="^([- \w\d\u00c0-\u024f]+)$" title="<?php echo ALT_FIELD_TITLE; ?>" class="require-if-active resizeField" data-require-pair="#switch_5" required="">      <div class="label"><?php echo TEXT_TESTIMONIALS_TITLE; ?></div>
      </div>  
      <p><?php echo TEXT_FIELD_6_QUESTION1; ?></p>
      <div >
     <?php echo zen_draw_textarea_field('testimonials_html_text', '70', '4', $testimonials_html_text, 'id="testimonials_html_text" pattern="^([- \w\d\u00c0-\u024f]+)$" class="require-if-active resizeField" data-require-pair="#switch_5"');  ?>
     <div class="label"><?php echo TEXT_TESTIMONIALS_DESCRIPTION; ?></div>
     </div>
     
       </div>
       </div>
      
<div class="reveal">

    <div class="switch-footer">
      <div class="switch-title"><?php echo TEXT_FIELD_CONTACT; ?></div>
      <input type="radio" id="switch_email" name="contact_3" value="<?php echo TEXT_FIELD_CONTACT_EMAIL; ?>" /><label for="switch_email" class="inputLabel"><?php echo TEXT_FIELD_CONTACT_EMAIL; ?></label> 
      <input type="radio" id="switch_no" name="contact_3" value="<?php echo TEXT_NO; ?>" checked /><label for="switch_no" class="inputLabel"><?php echo TEXT_NO; ?></label>
      <br class="clearBoth" />
      <div>
      <input type="radio" id="switch_phone" name="contact_3" value="<?php echo TEXT_FIELD_CONTACT_PHONE; ?>" /><label for="switch_phone" class="inputLabel"><?php echo TEXT_FIELD_CONTACT_PHONE; ?></label>
      <div class="reveal-if-active">
       <div for="testimonials_title"><?php echo TEXT_FIELD_PHONE_NUMBER; ?></div>
      <input type="tel" name="telephone" id="telephone" class="require-if-active resizeField" placeholder="123-123-1234" title="<?php echo ALT_FIELD_PHONE_NUMBER; ?>" pattern="^\d{3}-\d{3}-\d{4}$" data-require-pair="#switch_phone" >
      </div></div>
     
    </div>
<br class="clearBoth" /> 
<br />
      <div class="switch-footer">
      <div class="switch-title"><?php echo TEXT_FIELD_PERMISSION; ?></div>
      <?php echo zen_draw_radio_field('make_public', TEXT_YES, '', 'id="make_public_yes" checked ') . '<label for="make_public_yes" class="inputLabel">' . TEXT_YES . '</label> ' . zen_draw_radio_field('make_public', TEXT_NO, '', 'id="make_public_no"') . '<label for="make_public_no" class="inputLabel">' . TEXT_NO . '</label>'; ?>
      </div> 
<br class="clearBoth" /> 
<br />   
<?php  if (!zen_is_logged_in()) {  ?>
  <p class="guidelines"><?php echo TEXT_FIELD_AVATARS; ?></p>
 <div class="avatars">

  <div><?php echo TEXT_FIELD_AVATARS_CLICK; ?></div><br/>
<div class="avatarList">
<div class="mainImg"><?php echo zen_image(DIR_WS_IMAGES . TESTIMONIAL_IMAGE_DIRECTORY . 'user-male-icon.png'); ?></div>  

<div id="divCircle">
     <div id="middleBubble"></div>


     <?php 
    echo $at_avatars;
     ?>
          
</div>
  
</div>

 <input type="hidden" name="avatar_register" value="<?php echo DIR_WS_IMAGES . TESTIMONIAL_IMAGE_DIRECTORY . 'user-male-icon.png'; ?>" id="gadget_url">
</div>
<?php }else{ ?>
 <div class="avatars">
<div class="center"><h2><?php echo TEXT_FIELD_CURRENT_AVATAR; ?></h2>
<img src="<?php echo DIR_WS_IMAGES . $tm_avatar; ?>" alt="Me" class="rounded" /></div>
</div>
<?php echo zen_draw_hidden_field('avatar_register', $tm_avatar); 
 } ?>
<br class="clearBoth" /> 
<?php if (DISPLAY_ADD_IMAGE == 'on') { ?>

<div class="box" id="clear-box">
<p class="guidelines"><?php echo TEXT_FIELD_FEEDBACK_IMAGE; ?></p>
<input type="file" name="file" id="inp_file" class="upfile upfile-1" />
<label for="inp_file"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span class="btn-file"><?php echo TEXT_FIELD_PICK_IMAGE; ?></span></label>
 
<div class="box-preview">
<img class="north" id="upload-Preview" />
    
  <input id="inp_img" name="tm_img" type="hidden" value="">
 </div>
</div>
<br />
<div class="buttonRow center"><?php echo zen_image_button(BUTTON_IMAGE_DELETE, BUTTON_DELETE_ALT, ' id="file-reset" '); ?></div> 
<script>
 
  function fileChange(e) { 
     document.getElementById('inp_img').value = '';
     
     var file = e.target.files[0];
 
     if (file.type == "image/jpeg" || file.type == "image/png") {
 
        var reader = new FileReader();  
        reader.onload = function(readerEvent) {
   
           var image = new Image();
           image.onload = function(imageEvent) {    
              var max_size = 600;
              var w = image.width;
              var h = image.height;
             
              if (w > h) {  if (w > max_size) { h*=max_size/w; w=max_size; }
              } else     {  if (h > max_size) { w*=max_size/h; h=max_size; } }
             
              var canvas = document.createElement('canvas');
              canvas.width = w;
              canvas.height = h;
              canvas.getContext('2d').drawImage(image, 0, 0, w, h);
                 
              if (file.type == "image/jpeg") {
                 var dataURL = canvas.toDataURL("image/jpeg", 1.0);
              } else {
                 var dataURL = canvas.toDataURL("image/png");   
              }
              document.getElementById('inp_img').value = dataURL;   
              document.getElementById("upload-Preview").src = canvas.toDataURL();
           }
           image.src = readerEvent.target.result;
        }
        reader.readAsDataURL(file);
     } else {
        document.getElementById('inp_file').value = ''; 
        alert('<?php echo ERROR_FIELD_IMAGE; ?>');  
     }
  }
 
  document.getElementById('inp_file').addEventListener('change', fileChange, false);    
  
 $('#file-reset').on('click', function(e){
   var $el = $('#clear-box');
   document.getElementById("upload-Preview").src = '';
   $el.wrap('<form>').closest('form').get(0).reset();
   $el.unwrap();
});
        
</script>
<br class="clearBoth" />
<?php } ?>    
<br class="clearBoth" />     

<?php echo zen_draw_input_field($antiSpamFieldName, '', ' size="40" id="CUAS" style="visibility:hidden; display:none;" autocomplete="off"'); ?>

<br /><br />
<?php
  if (DISPLAY_PRIVACY_CONDITIONS == 'true') {
?>
<div class="switch-footer">
<div class="switch-title"><?php echo TEXT_PRIVACY_CONFIRM;?></div>
<?php echo zen_draw_checkbox_field('privacy_conditions', '1',  $privacy, ' class="checky" id="privacy_left" ') . '<label for="privacy_left" class="inputLabel">Agree</label>'; ?> 
</div>
<br class="clearBoth" /> 
<br />  
<?php
  $postme = 'postme';
  }else{
  $postme = '';
  }
?>
   
</div>
 </div>

<br class="clearBoth" />
<div class="buttonRow back"><?php echo zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) .'</a>'; ?></div>
<div class="buttonRow forward">
<button class="cssButton submit_button button  button_submit_testimonials" onmouseover="this.className='cssButtonHover  button_submit_testimonials button_submit_testimonialsHover'" onmouseout="this.className='cssButton submit_button button  button_submit_testimonials'" type="submit" id="<?php echo $postme; ?>"><?php echo BUTTON_TESTIMONIALS_SUBMIT_ALT; ?></button>
</div>
<br /><br />

</div>
</div>
<script >
$(document).ready(function () {
	//Center the "info" bubble in the  "circle" div
	var divTop = ($("#divCircle").height() - $("#middleBubble").height()) / 2;
	var divLeft = ($("#divCircle").width() - $("#middleBubble").width()) / 2;
	$("#middleBubble").css("top", divTop + "px");
	$("#middleBubble").css("left", divLeft + "px");

	//Arrange the icons in a circle centered in the div
	numItems = $("#divCircle img").length; //How many items are in the circle?
	start = 0.0; //the angle to put the first image at. a number between 0 and 2pi
	step = 4 * Math.PI / numItems; //calculate the amount of space to put between the items.

	//Now loop through the buttons and position them in a circle
	$("#divCircle img").each(function (index) {
		radius = ($("#divCircle").width() - $(this).width()) / 2.3; 
		/*The radius is the distance from the center of the div to the middle of an icon
		* the following lines are a standard formula for calculating points on a circle. x = cx + r * cos(a); y = cy + r * sin(a)
		* We have made adjustments because the center of the circle is not at (0,0), but rather the top/left coordinates for the center of the div
		* We also adjust for the fact that we need to know the coordinates for the top-left corner of the image, not for the center of the image.
		*/
		tmpTop = $("#divCircle").height() / 2 + radius * Math.sin(start) - $(this).height() / 2;
		tmpLeft = $("#divCircle").width() / 2 + radius * Math.cos(start) - $(this).width() / 2;
		start += step; //add the "step" number of radians to jump to the next icon

		//set the top/left settings for the image
		$(this).css("top", tmpTop);
		$(this).css("left", tmpLeft);
	});

});

$('.avatarList').click(function () {
	$(this).toggleClass('expand');
	$('#divCircle').toggleClass('expand');
});

$('#divCircle img').click(function () {
	var theSrc = $(this).attr('src');
	// alert(theSrc);
	$('.mainImg img').attr('src', theSrc);
	$("#gadget_url").val(theSrc);
});
        
var FormStuff = {

  init: function () {
  // kick it off once, in case the radio is already checked when the page loads
    this.applyConditionalRequired();
    this.bindUIActions();
    $("#postme").attr("disabled","disabled");
    $("#postme").css({opacity:0.3,cursor:'default'});
  },

  bindUIActions: function () {
  // when a radio or checkbox changes value, click or otherwise
    $("input[type='radio'], input[type='checkbox']").on("change", this.applyConditionalRequired);
  },

  applyConditionalRequired: function () {
     // find each input that may be hidden or not
    $(".require-if-active").each(function () {
      var el = $(this);
      // find the pairing radio or checkbox
      if ($(el.data("require-pair")).is(":checked")) {
         // if its checked, the field should be required
        el.prop("required", true);
        el.prop("disabled", false);
      } else {
        // otherwise it should not
        el.prop("required", false);
        el.prop("disabled", true);
      }
    });

  } };

FormStuff.init();    

$(".checky").click(function(){
                        if($(".checky").is(":checked")){
                         $("#postme").removeAttr("disabled"); 
                         $("#postme").css({opacity:1,cursor:'pointer'}); 
                         }
                        else{
                            $("#postme").attr("disabled","disabled");
                            $("#postme").css({opacity:0.3,cursor:'default'});
                            }
                    }); 

</script>
<script>
'use strict';

;( function( $, window, document, undefined )
{
	$( '.inputfile' ).each( function()
	{
		var $input	 = $( this ),
			$label	 = $input.next( 'label' ),
			labelVal = $label.html();

		$input.on( 'change', function( e )
		{
			var fileName = '';

			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else if( e.target.value )
				fileName = e.target.value.split( '\\' ).pop();  

			if( fileName )
				$label.find( 'span' ).html( fileName );
			else
				$label.html( labelVal );
		});

		// Firefox bug fix
		$input
		.on( 'focus', function(){ $input.addClass( 'has-focus' ); })
		.on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
	});
})( jQuery, window, document );

</script>

<?php
  } else {
  echo '<h2 class="box">' . TEXT_CLOSED . '</h2></div>';
  }
?>
</div>
<?php } ?>

</form> 
</div>

