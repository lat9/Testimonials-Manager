<?php

/** 
 * cowboygeek template lang.testimonials_manage.php
 * Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) 
 * Copyright 2022 Fonticons, Inc. 
 * @version $Id: Testimonials_Manager.php v3.0 10-14-2022 davewest $
 * @version $ID: zc 157d testimonials_manage.php $
 */
 
 // <i class="fas fa-heart fa-fw"></i>
 // <i class="fa fa-exclamation-triangle fa-fw"></i>
 //fa fa-exclamation-circle
 

define('NAVBAR_TITLE', 'Add My Testimonial');
define('HEADING_ADD_TITLE', '<h1>Add My Testimonial</h1>');
define('TESTIMONIAL_SUCCESS', 'Your testimonial has been successfully submitted and will be added to our other testimonials as soon as we approve it.');
define('TESTIMONIAL_SUBMIT', 'Submit your testimonial using the form below.');
define('EMAIL_SUBJECT', 'Your Testimonial Submission At ' . STORE_NAME);
define('EMAIL_GREET', 'Dear ');
define('EMAIL_SEPARATOR', '--------------------------');
define('EMAIL_TEXT', 'Your testimonial has been successfully submitted at ' . STORE_NAME . '. It will be added to our other testimonials as soon as we approve it. You will receive an email about the status of your submitted. If you have not received it within the next 48 hours, please contact us before submitting your testimonial again.' . "\n\n");
define('EMAIL_OWNER_SUBJECT', 'Testimonial submission at ' . STORE_NAME);
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'This testimonial was submitted to us by you or by one of our users. If you did not submit a testimonial, or feel that you have received this email in error, please send an email to %s ');
define('EMAIL_SPAM_DISCLAIMER', 'This email is sent in accordance with the US CAN-SPAM Law in effect 01/01/2004. Removal requests can be sent to this address and will be honored and respected.');
define('TABLE_HEADING_TESTIMONIALS', 'Customer Testimonials');
define('TESTIMONIAL_CONTACT', 'Contact Information');
define('TEXT_TESTIMONIALS_TITLE', 'Title:');
define('TEXT_TESTIMONIALS_NAME', 'Your Name:');
define('TEXT_TESTIMONIALS_MAIL', 'Your Email:');
define('TEXT_TESTIMONIALS_HTML_TEXT', 'Testimonial');
define('TEXT_TESTIMONIALS_DESCRIPTION', 'Comments:');
define('TEXT_TESTIMONIALS_DESCRIPTION_INFO', '<div><strong>Testimonial Text must be between ' . ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH . ' &amp; ' . ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH . ' characters!</strong></div>');
define('TEXT_TESTIMONIAL_LOGIN_PROMPT', 'You are required to login or create an account in order to submit a testimonial');
define('ERROR_TESTIMONIALS_NAME_REQUIRED', '<strong>Your Name is Required!</strong>');
define('ERROR_TESTIMONIALS_EMAIL_REQUIRED', 'You Must include your Email address!');
define('ERROR_TESTIMONIALS_TITLE_REQUIRED', '<strong>A Testimonial Title is Required!</strong>');
define('ERROR_TESTIMONIALS_DESCRIPTION_REQUIRED', '<strong>Testimonial is Required!</strong>');
define('ERROR_TESTIMONIALS_TEXT_MAX_LENGTH', '<strong>Less than ' . ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH . ' characters!</strong>');
define('ERROR_TESTIMONIALS_TEXT_MIN_LENGTH', '<strong>Less than ' . ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH . ' characters!</strong>');
define('ERROR_TESTIMONIALS', 'Errors have occurred on your submission! Please correct and resubmit!');
define('TESTIMONIAL_BLOCKEMAIL_ADDRESS_CHECK_ERROR', 'That Email address is banned!');
define('TESTIMONIAL_GIVE_RATING', '<i><b>' . STORE_NAME . ' </b></i>-- Only shop that has a 0 to 5 star rating system! <br />If you Picked the alien, please tell us why so we can improve our products or service.');
define('TESTIMONIAL_RATING', 'Please give a rating for this review.');
define('ERROR_CONTACT_USER', 'You must select one of three answers for contacting you!');
define('LABEL_FEEDBACK_1', 'online Shopping Experience!');
define('LABEL_FEEDBACK_2', 'online Order Experience!');  
define('LABEL_FEEDBACK_3', 'Mobile shopping experience or something you ordered using Mobile/App!');  
define('LABEL_FEEDBACK_4', 'Store Experience!');  
define('LABEL_FEEDBACK_5', 'Map Experience!');  
define('LABEL_FEEDBACK_6', 'Other feedback!'); 
define('TITLE_EMAIL', 'Your email address is not displayed in reviews.'); 
define('TEXT_TESTIMONIALS_HEADER', 'We <svg xmlns="http://www.w3.org/2000/svg" fill="rgba(239,41,41,1)" width="50px" height="auto" viewBox="0 0 512 512"><path d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z"/></svg> Feedback!');
define('TEXT_TESTIMONIALS_FEEDBACK', 'Please select regarding which experience you want to provide feedback on.<br />Your name will appear on reviews. Your Email Address will <strong>NOT</strong> be displayed on reviews.');
define('TEXT_RATING_5', ' Awesome');
define('TEXT_RATING_4', ' Better');
define('TEXT_RATING_3', ' Good');
define('TEXT_RATING_2', ' Bad');
define('TEXT_RATING_1', ' Worst');
define('TEXT_RATING_0', ' Gone');
define('TEXT_YES', 'yes');
define('TEXT_NO', 'no');
define('TEXT_OPTION_1', 'Option 1');
define('TEXT_OPTION_2', 'Option 2');
define('TEXT_OPTION_3', 'Option 3');
define('ALT_FIELD_EMAIL', 'Please enter a Email address (dave@addme.com)');
define('ALT_FIELD_NAME', 'Your name (no special characters)');
define('ALT_FIELD_TITLE', 'Give us a Title (no special characters)');
define('TEXT_FIELD_1_TITLE', 'online shopping experience');
define('TEXT_FIELD_1_QUESTION1', 'Was you able to find what you wanted?');
define('TEXT_FIELD_1_QUESTION2', 'Tell us about your experience. What did you like? What can we do better?');
define('TEXT_FIELD_2_TITLE', 'online order experience');
define('TEXT_FIELD_2_QUESTION1', 'Have you already placed an order?');
define('TEXT_FIELD_3_TITLE', 'Mobile shopping experience');
define('TEXT_FIELD_3_QUESTION1', 'Did you use a mobile device?');
define('TEXT_FIELD_3_QUESTION2', 'Type of Mobile device!: ');
define('TEXT_FIELD_3_QUESTION3', 'Your mobile device type?');
define('TEXT_FIELD_3_QUESTION4', 'Screen size or display size? ');
define('ALT_FIELD_3_QUESTION4', 'Screen size or display size');
define('TEXT_FIELD_3_QUESTION5', 'Tell us about your experience. What did you like? What can we do better?');
define('TEXT_FIELD_4_TITLE', 'Store Experience');
define('TEXT_FIELD_4_QUESTION1', 'Select category you want to provide feedback about.');
define('TEXT_FIELD_4_QUESTION2', 'Associate feedback');
define('TEXT_FIELD_4_QUESTION3', 'In-Store experience');
define('TEXT_FIELD_4_QUESTION4', 'Purchase experience');
define('TEXT_FIELD_4_QUESTION5', 'Tell us about your experience below.');
define('TEXT_FIELD_6_TITLE', 'Other experience');
define('TEXT_FIELD_6_QUESTION1', 'Tell us about your experience. What did you like? What can we do better?');
define('TEXT_FIELD_CONTACT', 'If we have additional questions, may we contact you?');
define('TEXT_FIELD_CONTACT_EMAIL', 'email');
define('TEXT_FIELD_CONTACT_PHONE', 'phone');
define('TEXT_FIELD_PHONE_NUMBER', 'Phone Number: ');
define('ALT_FIELD_PHONE_NUMBER', 'Your phone number (888-123-1234)');
define('TEXT_FIELD_PERMISSION', '(Yes) - I grant you the right and permission to publicly disclose my testimonial.<br />(No) - Make this testimonial Nonpublic please.');
define('TEXT_FIELD_AVATARS', 'We have a number of Avatars you can pick from. Avatars are not assign to any one user and are selected randomly from 15 of our best ones.');
define('TEXT_FIELD_AVATARS_CLICK', 'Click to pick a avatar');
define('TEXT_CLOSED', 'At this time, Testimonials are closed untill it\'s open');
define('TEXT_FIELD_CURRENT_AVATAR', 'Your Current Avatar');
define('TEXT_FIELD_FEEDBACK_IMAGE', 'Include one image with your feedback. Only in jpg or png format. ');
define('TEXT_FIELD_PICK_IMAGE', 'Choose a image');
define('ERROR_FIELD_IMAGE', 'Please only select images in JPG- or PNG-format.');
define('EXCLAMATION_TRIANGLE', '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(7.5,81.6,11,1)" width="20px" height="auto" viewBox="0 0 576 512"><path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>');
define('EXCLAMATION_CIRCLE', '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(0.0.0,1)" width="15px" height="auto" viewBox="0 0 512 512"><path d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zm-248 50c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"/></svg>');
define('NOT_LOGGED_IN_TEXT', 'Not logged in');
