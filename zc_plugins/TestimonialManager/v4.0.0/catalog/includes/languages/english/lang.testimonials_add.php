<?php
/** 
 * cowboygeek template lang.testimonials_manage.php
 * Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) 
 * Copyright 2022 Fonticons, Inc. 
 */
 
 // <i class="fas fa-heart fa-fw"></i>
 // <i class="fa fa-exclamation-triangle fa-fw"></i>
 //fa fa-exclamation-circle
 
 
$define = [
    'NAVBAR_TITLE' => 'Add My Testimonial',
    'HEADING_ADD_TITLE' => 'Add My Testimonial',

    'ALT_FIELD_3_QUESTION4' => 'Screen size or display size',
    'ALT_FIELD_EMAIL' => 'Please enter a Email address (dave@addme.com)',
    'ALT_FIELD_NAME' => 'Your name (no special characters)',
    'ALT_FIELD_PHONE_NUMBER' => 'Your phone number (888-123-1234)',
    'ALT_FIELD_TITLE' => 'Give us a Title (no special characters)',

    'BUTTON_RESET_IMAGE' => 'Reset Image',

    'EMAIL_OWNER_SUBJECT' => 'Testimonial submission at ' . STORE_NAME,
    'EMAIL_SEPARATOR' => '--------------------------',
    'EMAIL_SUBJECT' => 'Your Testimonial Submission At ' . STORE_NAME,
    'EMAIL_TEXT' => 'Your testimonial has been successfully submitted at ' . STORE_NAME . ' and will be added to our other testimonials once we approve it. You will receive an email about the status of your submittal. If you have not received the email within the next 48 hours, please contact us before submitting your testimonial again.' . "\n",
    'EMAIL_DISCLAIMER_NEW_CUSTOMER' => 'This testimonial was submitted to us by you or by one of our users. If you did not submit a testimonial, or feel that you have received this email in error, please send an email to %s ',

    'EXCLAMATION_CIRCLE' => '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(0.0.0,1)" width="15px" height="auto" viewBox="0 0 512 512"><path d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zm-248 50c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>',

    'ERROR_CONTACT_USER' => 'You must select one of three answers for contacting you!',
    'ERROR_FIELD_IMAGE' => 'Only images in JPG- or PNG-format are currently supported.',
    'ERROR_TESTIMONIALS' => 'Errors have occurred on your submission! Please correct and resubmit!',
    'ERROR_TESTIMONIALS_DESCRIPTION_REQUIRED' => '<strong>Testimonial is Required!</strong>',
    'ERROR_TESTIMONIALS_EMAIL_REQUIRED' => 'You Must include your Email address!',
    'ERROR_TESTIMONIALS_TEXT_MAX_LENGTH' => '<strong>More than ' . ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH . ' characters!</strong>',
    'ERROR_TESTIMONIALS_TEXT_MIN_LENGTH' => '<strong>Less than ' . ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH . ' characters!</strong>',
    'ERROR_TESTIMONIALS_NAME_REQUIRED' => '<strong>Your Name is Required!</strong>',
    'ERROR_TESTIMONIALS_TITLE_REQUIRED' => '<strong>A Testimonial Title is Required!</strong>',

    'LABEL_FEEDBACK_1' => 'online Shopping Experience!',
    'LABEL_FEEDBACK_2' => 'online Order Experience!',
    'LABEL_FEEDBACK_3' => 'Mobile shopping experience or something you ordered using Mobile/App!',
    'LABEL_FEEDBACK_4' => 'Store Experience!',
    'LABEL_FEEDBACK_5' => 'Map Experience!',
    'LABEL_FEEDBACK_6' => 'Other feedback!',

    'TESTIMONIAL_GIVE_RATING' => '<i><b>' . STORE_NAME . ' </b></i>-- Only shop that has a 0 to 5 star rating system!<br>If you Picked the alien, please tell us why so we can improve our products or service.',
    'TESTIMONIAL_RATING' => 'Please give a rating for this review.',
    'TESTIMONIAL_SUCCESS' => 'Your testimonial has been successfully submitted and will be added to our other testimonials as soon as we approve it.',

    'TEXT_AGREE' => 'Agree',    //- Used for privacy checkbox

    'TEXT_FIELD_CONTACT' => 'If we have additional questions, may we contact you?',
    'TEXT_FIELD_CONTACT_EMAIL' => 'Email',
    'TEXT_FIELD_CONTACT_PHONE' => 'Phone',
    'TEXT_FIELD_PHONE_NUMBER' => 'Phone Number: ',

    'TEXT_FIELD_PERMISSION' => '(Yes) - I grant you the right and permission to publicly disclose my testimonial.<br>(No) - Make this testimonial Nonpublic please.',

    'TEXT_FIELD_FEEDBACK_IMAGE' => 'Include one image with your feedback. Only in jpg or png format. ',
    'TEXT_FIELD_PICK_IMAGE' => 'Choose an image',

    'TEXT_FIELD_1_QUESTION1' => 'Were you able to find what you wanted?',
    'TEXT_FIELD_1_QUESTION2' => 'Tell us about your experience. What did you like? What can we do better?',
    'TEXT_FIELD_2_QUESTION1' => 'Have you already placed an order?',
    'TEXT_FIELD_3_QUESTION1' => 'Did you use a mobile device?',
    'TEXT_FIELD_3_QUESTION2' => 'Type of Mobile device!: ',
    'TEXT_FIELD_3_QUESTION3' => 'Your mobile device type?',
    'TEXT_FIELD_3_QUESTION4' => 'Screen size or display size? ',
    'TEXT_FIELD_3_QUESTION5' => 'Tell us about your experience. What did you like? What can we do better?',
    'TEXT_FIELD_4_QUESTION1' => 'Select category you want to provide feedback about.',
    'TEXT_FIELD_4_QUESTION2' => 'Associate feedback',
    'TEXT_FIELD_4_QUESTION3' => 'In-Store experience',
    'TEXT_FIELD_4_QUESTION4' => 'Purchase experience',
    'TEXT_FIELD_4_QUESTION5' => 'Tell us about your experience below.',
    'TEXT_FIELD_6_QUESTION1' => 'Tell us about your experience. What did you like? What can we do better?',

    'TEXT_FIELD_1_TITLE' => 'online shopping experience',
    'TEXT_FIELD_2_TITLE' => 'online order experience',
    'TEXT_FIELD_3_TITLE' => 'Mobile shopping experience',
    'TEXT_FIELD_4_TITLE' => 'Store Experience',
    'TEXT_FIELD_6_TITLE' => 'Other experience',

    'TEXT_NO' => 'No',

    'TEXT_RATING_5' => 'Five stars',
    'TEXT_RATING_4' => 'Four stars',
    'TEXT_RATING_3' => 'Three stars',
    'TEXT_RATING_2' => 'Two stars',
    'TEXT_RATING_1' => 'One star',
    'TEXT_RATING_0' => 'No stars',

    'TEXT_TESTIMONIAL_LOGIN_PROMPT' => 'You need to login or create an account prior to submitting a testimonial',
    'TEXT_TESTIMONIALS_DESCRIPTION' => 'Comments:',
    'TEXT_TESTIMONIALS_FEEDBACK' => 'Please select regarding which experience you want to provide feedback on.<br>Your name will appear on reviews, but your email-address will <strong>not</strong>.',
    'TEXT_TESTIMONIALS_HEADER' => 'We <svg xmlns="http://www.w3.org/2000/svg" fill="rgba(239,41,41,1)" width="50px" height="auto" viewBox="0 0 512 512"><path d="M462.3 62.6C407.5 15.9 326 24.3 275.7  76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z"/></svg> Feedback!',
    'TEXT_TESTIMONIALS_HTML_TEXT' => 'Testimonial',
    'TEXT_TESTIMONIALS_MAIL' => 'Your Email:',
    'TEXT_TESTIMONIALS_NAME' => 'Your Name:',
    'TEXT_TESTIMONIALS_TITLE' => 'Title:',
    'TEXT_YES' => 'Yes',

    'TITLE_EMAIL' => 'Your email address is not displayed in reviews.', 
];

return $define; 
