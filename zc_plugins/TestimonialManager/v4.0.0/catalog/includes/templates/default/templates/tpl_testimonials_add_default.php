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
 * @version $Id: Testimonials Manager v3.0 13 9-19-2022 davewest $
 */
?>
<div class="centerColumn" id="testimonialDefault">
    <h1><?= HEADING_ADD_TITLE ?></h1>

    <div class="center">
<?php
/** display shop total reviews */
include $template->get_template_dir('/tpl_tm_total_reviews.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_tm_total_reviews.php';
?>
    </div>

    <?= zen_draw_form('new_testimonial', zen_href_link(FILENAME_TESTIMONIALS_ADD, 'action=send', $request_type), 'post', 'enctype="multipart/form-data" ') ?>
<?php
if (TESTIMONIAL_STORE_NAME_ADDRESS === 'true') {
?>
    <address><?= nl2br(STORE_NAME_ADDRESS, true) ?></address>
    <br class="clearBoth">
<?php
}

if (($_GET['action'] ?? '') === 'success') {
?>
    <div class="mainContent success"><?= TESTIMONIAL_SUCCESS ?></div>
    <div class="buttonRow back"><?= zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) .'</a>' ?></div>
<?php
} elseif (in_array(DEFINE_TESTIMONIAL_STATUS, ['1', '2'])) {
?>
    <div id="pageThreeMainContent">
        <?php require $define_page; ?>
    </div>
<?php
}
?>
<br class="clearBoth">
<?php
if ($messageStack->size('new_testimonial') > 0) {
    echo $messageStack->output('new_testimonial');
}
?>
    <div class="tm-wrapper"> 
        <div class="main_box">
            <div class="logo2">
                <h2><?= TEXT_TESTIMONIALS_HEADER ?></h2>
            </div>
            <p class="questionarea"><?= TEXT_TESTIMONIALS_FEEDBACK ?></p>

            <div class="boxcontainer">
                <div id="reviewsWriteReviewsRate"><?= TESTIMONIAL_GIVE_RATING ?></div>
<?php
$stars = [];
for ($i = 0; $i <= 5; $i++) {
    $star1 = '';
    for ($s = 1; $s <= $i; $s++) {
        $star1 .= TM_STAR_SM_FULL;
    }
    $star2 = '';
    for ($r = $i; $r <= 4; $r++) {
        $star2 .= TM_STAR_SM_EMPTY;
    }
    $stars[] = $star1 . $star2;
}
?>
                <div id="star-rating">
<?php
foreach ($stars as $rating_value => $star) {
?>
                <div class="custom-control custom-radio custom-control-inline">
                    <?php echo zen_draw_radio_field('rating', (string)$rating_value, $rating, 'id="rating-' . $rating_value . '" class="custom-control-input"'); ?>
                    <label class="custom-control-label rating" for="rating-<?= $rating_value ?>"><?= $star ?></label>
                </div>
<?php
}
?>
                </div>
            </div>

<!-- INPUT LAYOUT START -->
            <div class="answersection">
                <div class="switch-field">
<!-- online shopping experience switch_1 //-->      
                    <div class="switch-wrap">
                        <?= zen_draw_radio_field('feedback', LABEL_FEEDBACK_1, '', 'id="switch-1"') .
                            '<label for="switch-1">' . LABEL_FEEDBACK_1 . '</label>' ?>
                        <div class="reveal-if-active go-up"> 
                            <div>
                                <?= zen_draw_input_field('testimonials_name', $testimonials_name, 'id="tm-name1" title="' . ALT_FIELD_NAME . '" class="require-if-active resizeField" data-require-pair="#switch_1"') ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_NAME ?></div>
                            </div>
<?php
if (!zen_is_logged_in() || zen_in_guest_checkout()) {
?>
                            <i title="<?= TITLE_EMAIL ?>"><?= EXCLAMATION_CIRCLE ?></i>
                            <div>
                                <?= zen_draw_input_field('testimonials_mail', $testimonials_mail, 'id="tm-email1" title="' . ALT_FIELD_EMAIL . '" class="require-if-active resizeField" data-require-pair="#switch_1"', 'email')  ?>
                                <div class="label" for="tm-email1"><?= TEXT_TESTIMONIALS_MAIL ?> </div>
                            </div>
<?php
} else {
?>
                            <?= zen_draw_hidden_field('testimonials_mail', $testimonials_mail); 
}
?>
                            <div>
                                <?= zen_draw_input_field('testimonials_title', $testimonials_title, 'id="tm-title1" title="' . ALT_FIELD_TITLE . '" class="require-if-active resizeField" data-require-pair="#switch_1"') ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_TITLE ?></div>
                            </div>

                            <div>
                                <div>
                                    <?= TEXT_FIELD_1_QUESTION1 ?>
                                    <br>
                                    <?= zen_draw_radio_field('find-1', 'yes', '', 'id="find-yes-1"') .
                                    '<label for="find-yes-1" class="inputLabel">' . TEXT_YES . '</label>' .
                                    zen_draw_radio_field('find-1', 'no', '', 'id="find-no-1"') .
                                    '<label for="find-no-1" class="inputLabel">' . TEXT_NO . '</label>' ?>
                                </div>
                            </div>

                            <p><?= TEXT_FIELD_1_QUESTION2 ?></p>
                            <div>
                                <?= zen_draw_textarea_field('testimonials_html_text', '70', '4', $testimonials_html_text, 'id="tm-html1" class="require-if-active resizeField" data-require-pair="#switch_1"');  ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_DESCRIPTION ?></div>
                            </div>
                        </div>
                    </div>
       
<!-- online order experience switch_2 //-->
                    <div class="switch-wrap">
                        <?= zen_draw_radio_field('feedback', LABEL_FEEDBACK_2, '', 'id="switch_2"') .
                            '<label for="switch_2">' . LABEL_FEEDBACK_2 . '</label>' ?>
                        <div class="reveal-if-active go-up"> 
                            <div>
                                <?= zen_draw_input_field('testimonials_name', $testimonials_name, 'id="tm-name2" title="' . ALT_FIELD_NAME . '" class="require-if-active resizeField" data-require-pair="#switch_2"') ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_NAME ?></div>
                            </div>
<?php
if (!zen_is_logged_in() || zen_in_guest_checkout()) {
?>
                            <i title="<?= TITLE_EMAIL ?>"><?= EXCLAMATION_CIRCLE ?></i>
                            <div>
                                <?= zen_draw_input_field('testimonials_mail', $testimonials_mail, 'id="tm-add-mail2" spellcheck="false" title="' . ALT_FIELD_EMAIL . '" class="require-if-active resizeField" data-require-pair="#switch_2"', 'email')  ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_MAIL ?> </div>
                            </div>
<?php
} else {
?>
                            <?= zen_draw_hidden_field('testimonials_mail', $testimonials_mail) ?>
<?php
}
?>
                            <div>
                                <?= zen_draw_input_field('testimonials_title', $testimonials_title, 'id="tm-title2" title="' . ALT_FIELD_TITLE . '" class="require-if-active resizeField" data-require-pair="#switch_2"') ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_TITLE ?></div>
                            </div>
                            <div>
                                <div>
                                    <?= TEXT_FIELD_2_QUESTION1 ?>
                                    <br>
                                    <?= zen_draw_radio_field('order1', 'yes', $ordered, 'id="order_yes"') .
                                        '<label for="order_yes" class="inputLabel">' . TEXT_YES . '</label>' .
                                        zen_draw_radio_field('order1', 'no', $ordered, 'id="order_no"') .
                                        '<label for="order_no" class="inputLabel">' . TEXT_NO . '</label>' ?>
                                </div>
                            </div>

                            <p><?= TEXT_FIELD_1_QUESTION2 ?></p>
                            <div>
                                <?= zen_draw_textarea_field('testimonials_html_text', '70', '4', $testimonials_html_text, 'id="tm-html2" class="require-if-active resizeField" data-require-pair="#switch_2"');  ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_DESCRIPTION ?></div>
                            </div>

                        </div>
                    </div>
<!-- Mobile shopping experience switch_3 //-->
                    <div class="switch-wrap">
                        <?= zen_draw_radio_field('feedback', LABEL_FEEDBACK_3, '', 'id="switch_3"') .
                            '<label for="switch_3">' . LABEL_FEEDBACK_3 . '</label>' ?>
                        <div class="reveal-if-active go-up"> 
                            <div>
                                <?= zen_draw_input_field('testimonials_name', $testimonials_name, ' id="tm-name3" title="' . ALT_FIELD_NAME . '" class="require-if-active resizeField" data-require-pair="#switch_3"') ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_NAME ?></div>
                            </div>
 <?php
if (!zen_is_logged_in() || zen_in_guest_checkout()) {
?>
                            <i title="<?= TITLE_EMAIL ?>"><?= EXCLAMATION_CIRCLE ?></i>
                            <div>
                                <?= zen_draw_input_field('testimonials_mail', $testimonials_mail, ' id="tm-email3" spellcheck="false" title="' . ALT_FIELD_EMAIL . '" class="require-if-active resizeField" data-require-pair="#switch_3"', 'email')  ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_MAIL ?></div>
                            </div>
<?php
} else {
?>
                            <?= zen_draw_hidden_field('testimonials_mail', $testimonials_mail) ?>
<?php
}
?>
                            <div>
                                <?= zen_draw_input_field('testimonials_title', $testimonials_title, 'id="tm-title3" title="' . ALT_FIELD_TITLE . '" class="require-if-active resizeField" data-require-pair="#switch_3"') ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_TITLE ?></div>
                            </div>
                            <div>
                                <?= zen_draw_hidden_field('mobile_device', 'none') ?>
                                <?= zen_draw_checkbox_field('mobile_device', TEXT_YES, false, ' id="mobile_device" ') . '<label for="mobile_device" >' . TEXT_FIELD_3_QUESTION1 . '</label>' ?>
                                <div>
                                    <div><?= TEXT_FIELD_3_QUESTION2 ?></div>
                                    <?= zen_draw_input_field('mobile_device_name', $mobile_device_name, ' id="mobile_device_name" class="resizeField" placeholder="iPhone x" title="' . TEXT_FIELD_3_QUESTION3 . '" data-require-pair="#mobile_device"') ?>    
                                    <br>
                                    <div><?= TEXT_FIELD_3_QUESTION4 ?></div>
                                    <?= zen_draw_input_field('screen_size', $screen_size, ' id="screen_size" class="resizeField" placeholder="1 x 3 inch" title="' . ALT_FIELD_3_QUESTION4 . '" data-require-pair="#mobile_device"') ?>
                                </div>
                            </div>

                            <p><?= TEXT_FIELD_3_QUESTION5 ?></p>
                            <div>
                                <?= zen_draw_textarea_field('testimonials_html_text', '70', '4', $testimonials_html_text, 'id="tm-html3" class="require-if-active resizeField" data-require-pair="#switch_3"');  ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_DESCRIPTION ?></div>
                            </div>
                        </div>
                    </div>
<!-- Store Experience switch_4 //-->
                    <div class="switch-wrap">
                        <?= zen_draw_radio_field('feedback', LABEL_FEEDBACK_4, '', 'id="switch_4"') .
                            '<label for="switch_4">' . LABEL_FEEDBACK_4 . '</label>' ?>
                        <div class="reveal-if-active go-up"> 
                            <div>
                                <?= zen_draw_input_field('testimonials_name', $testimonials_name, 'id="tm-name4" title="' . ALT_FIELD_NAME . '" class="require-if-active resizeField" data-require-pair="#switch_4"') ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_NAME ?></div>
                            </div>
<?php
if (!zen_is_logged_in() || zen_in_guest_checkout()) {
?>
                            <i title="<?= TITLE_EMAIL ?>"><?= EXCLAMATION_CIRCLE ?></i>
                            <div>
                                <?= zen_draw_input_field('testimonials_mail', $testimonials_mail, ' id="tm-email4" spellcheck="false" title="' . ALT_FIELD_EMAIL . '"  class="require-if-active resizeField" data-require-pair="#switch_4"', 'email') ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_MAIL ?></div>
                            </div>
<?php
} else {
?>
                            <?= zen_draw_hidden_field('testimonials_mail', $testimonials_mail) ?>
<?php
}
?> 
                            <div>
                                <?= zen_draw_input_field('testimonials_title', $testimonials_title, 'id="tm-title4" title="' . ALT_FIELD_TITLE . '" class="require-if-active resizeField" data-require-pair="#switch_4"') ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_TITLE ?></div>
                            </div>

                            <div>
                                <div class="switch-title"><?= TEXT_FIELD_4_QUESTION1 ?></div>
                                <div id="feedback-about">
                                    <?= zen_draw_radio_field('feedback_about', '2', '', 'id="store_feedback_1"') .
                                        '<label for="store_feedback_1" title="' . TEXT_FIELD_4_QUESTION2 . '">' .
                                            TEXT_FIELD_4_QUESTION2 .
                                        '</label>' ?>

                                    <?= zen_draw_radio_field('feedback_about', '3', '', 'id="store_feedback_2"') .
                                        '<label for="store_feedback_2" title="' . TEXT_FIELD_4_QUESTION3 . '">' . 
                                            TEXT_FIELD_4_QUESTION3 .
                                        '</label>' ?>

                                    <?= zen_draw_radio_field('feedback_about', '4', '', 'id="store_feedback_3"') .
                                    '<label for="store_feedback_3" title="' . TEXT_FIELD_4_QUESTION4 . '">' .
                                        TEXT_FIELD_4_QUESTION4 .
                                    '</label>' ?>
                                </div>
                            </div>

                            <p><?= TEXT_FIELD_4_QUESTION5 ?></p>
                            <div>
                                <?= zen_draw_textarea_field('testimonials_html_text', '70', '4', $testimonials_html_text, 'id="tm-html4" class="require-if-active resizeField" data-require-pair="#switch_4"');  ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_DESCRIPTION ?></div>
                            </div>
                        </div>
                    </div>
 <!-- Other feedback switch_5 //-->
                    <div class="switch-wrap">
                        <?= zen_draw_radio_field('feedback', LABEL_FEEDBACK_6, '', 'id="switch_5"') . '<label for="switch_5">' . LABEL_FEEDBACK_6 . '</label>' ?>
                        <div class="reveal-if-active go-up"> 
                            <div>
                                <?= zen_draw_input_field('testimonials_name', $testimonials_name, ' id="tm-name5" title="' . ALT_FIELD_NAME . '" class="require-if-active resizeField" data-require-pair="#switch_5"') ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_NAME ?></div>
                            </div>
<?php
if (!zen_is_logged_in() || zen_in_guest_checkout()) {
?>
                            <i title="<?= TITLE_EMAIL ?>"><?= EXCLAMATION_CIRCLE ?></i>
                            <div>
                                <?= zen_draw_input_field('testimonials_mail', $testimonials_mail, ' id="tm-email5" spellcheck="false" title="' . ALT_FIELD_EMAIL . '" class="require-if-active resizeField" data-require-pair="#switch_5"', 'email')  ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_MAIL ?></div>
                            </div>
<?php
} else {
?>
                            <?= zen_draw_hidden_field('testimonials_mail', $testimonials_mail) ?>
<?php
}
?>
                            <div>
                                <?= zen_draw_input_field('testimonials_title', $testimonials_title, 'id="tm-title6" title="' . ALT_FIELD_TITLE . '" class="require-if-active resizeField" data-require-pair="#switch_5"') ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_TITLE ?></div>
                            </div>
                            <p><?= TEXT_FIELD_6_QUESTION1 ?></p>
                            <div>
                                <?= zen_draw_textarea_field('testimonials_html_text', '70', '4', $testimonials_html_text, 'id="tm-html5" class="require-if-active resizeField" data-require-pair="#switch_5"');  ?>
                                <div class="label"><?= TEXT_TESTIMONIALS_DESCRIPTION ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="reveal">
                        <div class="switch-footer">
                            <div class="switch-title"><?= TEXT_FIELD_CONTACT ?></div>
                            <input type="radio" id="switch_email" name="contact_3" value="email">
                            <label for="switch_email" class="inputLabel"><?= TEXT_FIELD_CONTACT_EMAIL ?></label> 
                            <input type="radio" id="switch_no" name="contact_3" value="no" checked>
                            <label for="switch_no" class="inputLabel"><?= TEXT_NO ?></label>
                            <br class="clearBoth">
                            <div>
                                <input type="radio" id="switch_phone" name="contact_3" value="phone">
                                <label for="switch_phone" class="inputLabel"><?= TEXT_FIELD_CONTACT_PHONE ?></label>
                                <div>
                                    <div><?= TEXT_FIELD_PHONE_NUMBER ?></div>
                                    <input type="tel" name="telephone" id="telephone" class="require-if-active resizeField" placeholder="123-123-1234" title="<?= ALT_FIELD_PHONE_NUMBER ?>" data-require-pair="#switch_phone">
                                </div>
                            </div>
                        </div>
                        <br class="clearBoth"> 
                        <br>
                        <div class="switch-footer">
                            <div class="switch-title"><?= TEXT_FIELD_PERMISSION ?></div>
                            <?= zen_draw_radio_field('make_public', 'yes', '', 'id="make_public_yes" checked ') ?>
                             <label for="make_public_yes" class="inputLabel"><?= TEXT_YES ?></label>
                            <?= zen_draw_radio_field('make_public', 'no', '', 'id="make_public_no"') ?>
                            <label for="make_public_no" class="inputLabel"><?= TEXT_NO ?></label>
                        </div> 
                        <br class="clearBoth"> 
<?php
if (DISPLAY_ADD_IMAGE === 'on') {
?>
                        <div class="box" id="clear-box">
                            <p class="guidelines"><?= TEXT_FIELD_FEEDBACK_IMAGE ?></p>
                            <input type="file" name="file" id="inp_file" class="upfile upfile-1">
                            <label for="inp_file">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg>
                                <span class="btn-file"><?= TEXT_FIELD_PICK_IMAGE ?></span>
                            </label>

                            <div class="box-preview">
                                <img class="north" id="upload-Preview">
                                <input id="inp_img" name="tm_img" type="hidden" value="">
                            </div>
                        </div>
                        <br>
                        <div class="buttonRow center"><?= zen_image_button(BUTTON_IMAGE_DELETE, BUTTON_DELETE_ALT, ' id="file-reset" ') ?></div> 
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

                if (w > h) {
                    if (w > max_size) {
                        h *= max_size / w;
                        w = max_size;
                    }
                } else if (h > max_size) {
                    w *= max_size / h;
                    h = max_size;
                }

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
        alert('<?= ERROR_FIELD_IMAGE ?>');  
    }
}

document.getElementById('inp_file').addEventListener('change', fileChange, false);    

$('#file-reset').on('click', function(e) {
   var $el = $('#clear-box');
   document.getElementById("upload-Preview").src = '';
   $el.wrap('<form>').closest('form').get(0).reset();
   $el.unwrap();
});
</script>
                        <br class="clearBoth">
<?php
}
?>
                        <?= zen_draw_input_field($antiSpamFieldName, '', ' size="40" id="CUAS" style="visibility:hidden; display:none;" autocomplete="off"') ?>
<?php
$postme = '';
if (DISPLAY_PRIVACY_CONDITIONS === 'true') {
    $postme = 'postme';
?>
                        <div class="switch-footer">
                            <div class="switch-title"><?= TEXT_PRIVACY_CONFIRM ?></div>
                            <?= zen_draw_checkbox_field('privacy_conditions', '1',  $privacy, ' class="checky" id="privacy_left" ') . '<label for="privacy_left" class="inputLabel">Agree</label>' ?> 
                        </div>
                        <br class="clearBoth">
<?php
}
?>
                    </div>
                </div>

                <br class="clearBoth">
                <div class="buttonRow back"><?= zen_back_link() . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>' ?></div>
                <div class="buttonRow forward">
                    <button class="cssButton submit_button button  button_submit_testimonials" onmouseover="this.className='cssButtonHover  button_submit_testimonials button_submit_testimonialsHover'" onmouseout="this.className='cssButton submit_button button  button_submit_testimonials'" type="submit" id="<?= $postme ?>"><?= BUTTON_TESTIMONIALS_SUBMIT_ALT ?></button>
                </div>
                <br><br>
            </div>
        </div>
<script >
$(document).ready(function () {
    var FormStuff = {
        init: function () {
            // kick it off once, in case the radio is already checked when the page loads
            this.applyConditionalRequired();
            this.bindUIActions();
            $("#postme").prop('disabled', true);
            $("#postme").css({opacity:0.3,cursor:'default'});
        },

        bindUIActions: function () {
            // when a radio or checkbox changes value, click or otherwise
            $('input[name="feedback"]').on('change', this.applyConditionalRequired);
        },

        applyConditionalRequired: function () {
            $('input[name="feedback"]').each(function () {
                let parentId = $(this).parent('.switch-wrap').attr('id');

                if ($(this).is(':checked')) {
                    $('#'+parentId).find('input[name!="feedback"], select, textarea').each(function() {
                        if ($(this).hasClass('require-if-active')) {
                            $(this).prop('required', true);
                        } else {
                            $(this).prop('required', false);
                        }
                    });
                    $('#'+parentId).find('input, select, textarea').prop('disabled', false);
                } else {
                    $('#'+parentId).find('input[name!="feedback"], select, textarea').prop('required', false);
                    $('#'+parentId).find('input[name!="feedback"], select, textarea').prop('disabled', true);
                }
            });
        }
    };

    FormStuff.init();

    $(".checky").click(function() {
        if ($(".checky").is(":checked")) {
            $("#postme").removeAttr("disabled"); 
            $("#postme").css({opacity:1,cursor:'pointer'}); 
        } else {
            $("#postme").attr("disabled","disabled");
            $("#postme").css({opacity:0.3,cursor:'default'});
        }
    });
});
</script>
    </div>
    <?= '</form>' ?>
</div>
