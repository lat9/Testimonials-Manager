<?php
/**
 * Testimonials Manager admin
 *
 * @version $Id: Testimonials Manager v3.0 4 03-10-2023 davewest $
 * Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) 
 * Copyright 2022 Fonticons, Inc. 
 * @version $ID: zc 157d testimonials_manager.php $
 */
 
define('HEADING_TITLE', 'Testimonials Manager');
define('STATUS_GREEN', ' approved green ');
define('STATUS_BLUE', ' pending blue ');
define('STATUS_RED', ' baned red ');
define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_DELETE', ' Delete all');
define('TABLE_HEADING_TESTIMONIALS', 'Testimonials Title');
define('TABLE_HEADING_NAME', 'Author\'s Name');
define('TABLE_HEADING_MAIL', 'Author\'s E-Mail');
define('TABLE_HEADING_RATING', 'Rating');
define('TABLE_HEADING_LANGUAGES', 'Language');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_SORT_ORDER', 'Sort Order');
define('TEXT_TESTIMONIALS_TITLE', 'Testimonials Title:');
define('TEXT_TESTIMONIALS_NAME', 'Author\'s Name:');
define('TEXT_TESTIMONIALS_URL', 'Author\'s URL:');
define('TEXT_TESTIMONIALS_MAIL', 'Author\'s E-Mail:');
define('TEXT_TESTIMONIALS_DATE', 'Date Added:');
define('ENTRY_DATE_ADDED_TEXT', '&nbsp;(ie. 05/21/1970)');
define('TEXT_TESTIMONIALS_COMPANY', 'Company Name:');
define('TEXT_TESTIMONIALS_CITY', 'City:');
define('TEXT_TESTIMONIALS_COUNTRY', 'State or Country:');
define('TEXT_TESTIMONIALS_HTML_TEXT', 'Testimonial:<br /><br />Use with HTML or plan text?<br />Creates a mess with HTML or you like it.. Just test what works with you like HTML. ONLY admin create new or edit HTML or Plan text.');
define('TEXT_TESTIMONIALS_DATE_INFO', '<strong>Leaving the Date Added Field empty will insert today\'s date or you can enter the date of any past testimonials.</strong>');
define('TABLE_HEADING_DATE_ADDED', 'Date Added:');
define('TEXT_INFO_TESTIMONIALS_STATUS', 'Status:');
define('TEXT_INFO_TESTIMONIALS_RATING', 'Store Rating:');
define('TEXT_INFO_TESTIMONIALS_PUBLIC', 'Can we Display this one:');
define('TEXT_INFO_TESTIMONIALS_FEEDBACK', 'Testimonial Feedback:');
define('TEXT_INFO_TESTIMONIALS_CONTACT_NAME', 'Contact Name:');
define('TEXT_INFO_TESTIMONIALS_CONTACT_EMAIL', 'Contact Email:');
define('TEXT_INFO_TESTIMONIALS_TITLE', 'Testimonial Title:');
define('TEXT_INFO_TESTIMONIALS_DESCRIPTION', 'Testimonial:');
define('TEXT_DATE_TESTIMONIALS_CREATED', 'Testimonial Submitted:');
define('TEXT_DATE_TESTIMONIALS_LAST_MODIFIED', 'Last Modified:');
define('TEXT_IMAGE_NONEXISTENT', 'IMAGE DOES NOT EXIST');
define('TEXT_INFO_TESTIMONIALS_CONTACT', 'Can we Contact you:');
define('TEXT_INFO_TESTIMONIALS_CONTACT_PHONE', 'Contact Phone:');
define('TEXT_INFO_TESTIMONIALS_PRIVACY', 'Privacy Checked:');
define('TEXT_INFO_TESTIMONIALS_GEN_INFO', 'More INFO:');
define('TEXT_TESTIMONIALS_STATUS_CHANGE', 'Status Change: %s');
define('TEXT_INFO_HEADING_DELETE_TESTIMONIALS', 'Delete Testimonials');
define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this Testimonial?');
define('SUCCESS_PAGE_INSERTED', 'Success: The Testimonial has been inserted.');
define('SUCCESS_PAGE_UPDATED', 'Success: The Testimonial has been updated.');
define('SUCCESS_PAGE_REMOVED', 'Success: The Testimonials item has been removed.');
define('SUCCESS_PAGE_STATUS_UPDATED', 'Success: The status of the Testimonial item has been updated.');
define('ERROR_PAGE_AUTHOR_REQUIRED', 'Error: The Author\'s Name is Required!');
define('ERROR_PAGE_EMAIL_REQUIRED', 'Error: The Author\'s E-mail Address is Required!');
define('ERROR_PAGE_TEXT_REQUIRED', 'Error: A Testimonial is Required!');
define('ERROR_PAGE_TITLE_REQUIRED', 'Error: A Testimonial Title is Required!');
define('ERROR_UNKNOWN_STATUS_FLAG', 'Error: Unknown status flag.');
define('TABLE_HEADING_STATUS', 'Status');
define('TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS', 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> testimonials items)');
define('IMAGE_NEW_PAGE', 'New Testimonials Item');
define('TEXT_INFO_PAGE_IMAGE', 'Testimonial Image:');
define('TEXT_INFO_CURRENT_IMAGE', 'Current Image:');
define('TEXT_IMAGES_TESTIMONIALS_DELETE', '<strong>Use \'No Avatar\' image!</strong>');
define('TEXT_INFO_DELETE_IMAGE', '<strong>Please Delete the Avatar image yourself!</strong>');
define('TEXT_AVATAR_IMAGE_MANUAL', 'Switch to another select Avatar image:');
define('TEXT_AVATAR_PAGE_IMAGE', 'Testimonial Avatar:');
define('TEXT_AVATAR_CURRENT_IMAGE', 'Current Avatar:');
define('TEXT_AVATAR_NO_IMAGE', 'Missing Avatar');
define('TEXT_INFO_NO_IMAGE', 'No Image uploaded');
define('TEXT_REMOVE_WARRING', '<b> Warring: </b> this will remove only the menus and configuration settings!<br /> You must delete all files yourself!');
define('TEXT_UPDATE_WARRING', '<b> Warring: </b> this will check for updated Testimonials Manager from Zen Cart Plugin\'s. If one exists, you will still need to download and follow the install/upgrade instructions!');
define('TEXT_UPDATE_DISCLAMER', '<b>Note: </b> We don\'t endorse auto checking by constantly calling to another site<br />We will make it easy for you to do that by clicking this check button, your option not mine.');
define('TEXT_TM_STATUS_0', 'Pending Review');
define('TEXT_TM_STATUS_1', 'Approved');
define('TEXT_TM_STATUS_2', 'Banned - Not allowed to create');
define('TEXT_TESTIMONIALS_OPTIONAL', '&nbsp;<span class="fieldRequired">(Optional)</span>');
define('TEXT_NO_VOTING', '&nbsp;&nbsp;Helpful no voting! ');
define('TEXT_YES_VOTING', '&nbsp;&nbsp;Helpful yes voting! ');
define('TEXT_INFO_TESTIMONIALS_SUBMIT_IMAGE', 'Submited image: ');
define('TEXT_YES', 'yes');
define('TEXT_NO', 'no');
define('TEXT_PHONE', 'phone');
define('TEXT_EMAIL', 'email');
define('TEXT_OTHER_FIELDS', 'Other fields for Admin ONLY! <br /> All the info do that is clicks not for other fields with informations.');
define('TEXT_PRIVACY', 'Privacy checked:');
define('TEXT_PUBLIC', 'Make Public:');
define('TEXT_USER_PHONE', 'Contact User phone:');
define('TEXT_CONTACT_USER', 'Can we contact User:');
define('TEXT_RATING', 'Testimonial Rating:');
define('TEXT_FEEDBACK', 'Feedback Status:');
define('TEXT_IMAGES_TESTMONIALS', 'No images in this testimonials');
define('TEXT_TESTIMONIALS_IMAGE_LOCAL', '); or enter local file below');
define('TEXT_TESTIMONIALS_IMAGE_TARGET', 'Image Target (Save To):');
define('TEXT_TESTIMONIALS_IMAGE_TARGET_INFO', '<strong>Suggested Target location for the image on the server:</strong> ' . DIR_FS_CATALOG_IMAGES . 'uploads/');
define('ERROR_TESTIMONIALS_IMAGE_REQUIRED', 'Error: Testimonials image required.');
define('TEXT_ACTION_DELETE_FILE_CONFIRM', 'You really want to delete that photo?');
define('TEXT_FILENAME', 'Filename: &nbsp;&nbsp;');
define('CALENDER_ALT', '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(33.3,33.3,33.3,1)" width="15px" height="auto" viewBox="0 0 448 512"><path d="M148 288h-40c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12zm108-12v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 96v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm192 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96-260v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48zm-48 346V160H48v298c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z"/></svg>');
define('CIRCLE_GREEN', '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(6,130,15,1)" width="18px" height="auto" viewBox="0 0 496 512">');
define('CIRCLE_BLUE', '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(17,59,217,1)" width="18px" height="auto" viewBox="0 0 496 512">');
define('CIRCLE_RED', '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(255,0,0,1)" width="18px" height="auto" viewBox="0 0 496 512">');
define('USER_CIRCLE', '<path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 96c48.6 0 88 39.4 88 88s-39.4 88-88 88-88-39.4-88-88 39.4-88 88-88zm0 344c-58.7 0-111.3-26.6-146.5-68.2 18.8-35.4 55.6-59.8 98.5-59.8 2.4 0 4.8.4 7.1 1.1 13 4.2 26.6 6.9 40.9 6.9 14.3 0 28-2.7 40.9-6.9 2.3-.7 4.7-1.1 7.1-1.1 42.9 0 79.7 24.4 98.5 59.8C359.3 421.4 306.7 448 248 448z"/></svg>');

