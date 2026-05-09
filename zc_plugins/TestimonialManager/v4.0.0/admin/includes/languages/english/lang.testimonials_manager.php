<?php
/**
 * Testimonials Manager
 *
 * Last Updated: v4.0.0
 *
 * @version $Id: Testimonials Manager v3.0 4 03-10-2023 davewest $
 * Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) 
 * Copyright 2022 Fonticons, Inc. 
 */
 $define = [
    'HEADING_TITLE' => 'Testimonials Manager',
    
    'STATUS_GREEN' => ' approved green ',
    'STATUS_BLUE' => ' pending blue ',
    'STATUS_RED' => ' baned red ',

    'TABLE_HEADING_ID' => 'ID',
    'TABLE_HEADING_DELETE' => ' Delete all',
    'TABLE_HEADING_TESTIMONIALS' => 'Testimonials Title',
    'TABLE_HEADING_NAME' => 'Author\'s Name',
    'TABLE_HEADING_MAIL' => 'Author\'s E-Mail',
    'TABLE_HEADING_RATING' => 'Rating',
    'TABLE_HEADING_LANGUAGES' => 'Language',
    'TABLE_HEADING_ACTION' => 'Action',
    'TABLE_HEADING_SORT_ORDER' => 'Sort Order',
    'TABLE_HEADING_DATE_ADDED' => 'Date Added:',
    'TABLE_HEADING_STATUS' => 'Status',

    'TEXT_TESTIMONIALS_TITLE' => 'Testimonials Title:',
    'TEXT_TESTIMONIALS_NAME' => 'Author\'s Name:',
    'TEXT_TESTIMONIALS_URL' => 'Author\'s URL:',
    'TEXT_TESTIMONIALS_MAIL' => 'Author\'s E-Mail:',
    'TEXT_TESTIMONIALS_DATE' => 'Date Added:',
    'ENTRY_DATE_ADDED_TEXT' => '&nbsp;(i.e. 05/21/1970)',
    'TEXT_TESTIMONIALS_COMPANY' => 'Company Name:',
    'TEXT_TESTIMONIALS_CITY' => 'City:',
    'TEXT_TESTIMONIALS_COUNTRY' => 'State or Country:',
    'TEXT_TESTIMONIALS_HTML_TEXT' => 'Testimonial:<br><br>Use with HTML or plain text.<br>Creates a mess with HTML or you like it. Just test what works with you like HTML. ONLY admin create new or edit HTML or Plain text.',
    'TEXT_TESTIMONIALS_DATE_INFO' => '<strong>Leaving the Date Added Field empty will insert today\'s date or you can enter the date of any past testimonials.</strong>',

    'TEXT_INFO_TESTIMONIALS_STATUS' => 'Status:',
    'TEXT_INFO_TESTIMONIALS_RATING' => 'Store Rating:',
    'TEXT_INFO_TESTIMONIALS_PUBLIC' => 'Display to the public?:',
    'TEXT_INFO_TESTIMONIALS_FEEDBACK' => 'Testimonial Feedback:',
    'TEXT_INFO_TESTIMONIALS_CONTACT_NAME' => 'Contact Name:',
    'TEXT_INFO_TESTIMONIALS_CONTACT_EMAIL' => 'Contact Email:',
    'TEXT_INFO_TESTIMONIALS_TITLE' => 'Testimonial Title:',
    'TEXT_INFO_TESTIMONIALS_DESCRIPTION' => 'Testimonial:',
    'TEXT_INFO_TESTIMONIALS_CONTACT' => 'Can we Contact you:',
    'TEXT_INFO_TESTIMONIALS_CONTACT_PHONE' => 'Contact Phone:',
    'TEXT_INFO_TESTIMONIALS_PRIVACY' => 'Privacy Checked:',
    'TEXT_INFO_TESTIMONIALS_GEN_INFO' => 'More INFO:',

    'TEXT_DATE_TESTIMONIALS_CREATED' => 'Testimonial Submitted:',
    'TEXT_DATE_TESTIMONIALS_LAST_MODIFIED' => 'Last Modified:',
    'TEXT_IMAGE_NONEXISTENT' => 'IMAGE DOES NOT EXIST',

    'TEXT_TESTIMONIALS_STATUS_CHANGE' => 'Status Change: %s',
    'TEXT_INFO_HEADING_DELETE_TESTIMONIALS' => 'Delete Testimonials',
    'TEXT_INFO_DELETE_INTRO' => 'Are you sure you want to delete this Testimonial?',
    'TEXT_INFO_DELETE_IMAGE' => 'Are you sure you want to delete this image?',

    'SUCCESS_PAGE_INSERTED' => 'Success: The Testimonial has been inserted.',
    'SUCCESS_PAGE_UPDATED' => 'Success: The Testimonial has been updated.',
    'SUCCESS_PAGE_REMOVED' => 'Success: The Testimonials item has been removed.',
    'SUCCESS_PAGE_STATUS_UPDATED' => 'Success: The status of the Testimonial item has been updated.',

    'ERROR_PAGE_AUTHOR_REQUIRED' => 'Error: The Author\'s Name is Required!',
    'ERROR_PAGE_EMAIL_REQUIRED' => 'Error: The Author\'s E-mail Address is Required!',
    'ERROR_PAGE_TEXT_REQUIRED' => 'Error: A Testimonial is Required!',
    'ERROR_PAGE_TITLE_REQUIRED' => 'Error: A Testimonial Title is Required!',
    'ERROR_UNKNOWN_STATUS_FLAG' => 'Error: Unknown status flag.',


    'TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS' => 'Displaying <b>%d</b> to <b>%d</b> (of <b>%d</b> testimonials items)',
    'IMAGE_NEW_PAGE' => 'New Testimonials Item',
    'TEXT_INFO_PAGE_IMAGE' => 'Testimonial Image:',
    'TEXT_INFO_CURRENT_IMAGE' => 'Current Image:',
    'TEXT_INFO_NO_IMAGE' => 'No Image uploaded',
    'TEXT_UPDATE_DISCLAMER' => '<b>Note: </b> We don\'t endorse auto checking by constantly calling to another site<br>We will make it easy for you to do that by clicking this check button, your option not mine.',
    'TEXT_NO_VOTING' => 'Helpful no voting! ',
    'TEXT_YES_VOTING' => 'Helpful yes voting! ',
    'TEXT_INFO_TESTIMONIALS_SUBMIT_IMAGE' => 'Submitted image: ',
    'TEXT_YES' => 'yes',
    'TEXT_NO' => 'no',
    'TEXT_PHONE' => 'phone',
    'TEXT_EMAIL' => 'email',
    'TEXT_OTHER_FIELDS' => 'Other fields for Admin ONLY!<br>All the info do that is clicks not for other fields with informations.',
    'TEXT_PRIVACY' => 'Privacy checked:',
    'TEXT_PUBLIC' => 'Make Public:',
    'TEXT_USER_PHONE' => 'Contact User phone:',
    'TEXT_CONTACT_USER' => 'Can we contact User:',
    'TEXT_RATING' => 'Testimonial Rating:',
    'TEXT_FEEDBACK' => 'Feedback Status:',
    'TEXT_IMAGES_TESTMONIALS' => 'No images in this testimonials',
    'TEXT_ACTION_DELETE_FILE_CONFIRM' => 'You really want to delete that photo?',
    'TEXT_FILENAME' => 'Filename: &nbsp;&nbsp;',

    'CALENDER_ALT' => '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(33.3,33.3,33.3,1)" width="15px" height="auto" viewBox="0 0 448 512"><path d="M148 288h-40c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12zm108-12v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 96v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm192 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96-260v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48zm-48 346V160H48v298c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z"/></svg>',
    'CIRCLE_GREEN' => '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(6,130,15,1)" width="18px" height="auto" viewBox="0 0 496 512">',
    'CIRCLE_BLUE' => '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(17,59,217,1)" width="18px" height="auto" viewBox="0 0 496 512">',
    'CIRCLE_RED' => '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(255,0,0,1)" width="18px" height="auto" viewBox="0 0 496 512">',
    'USER_CIRCLE' => '<path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 96c48.6 0 88 39.4 88 88s-39.4 88-88 88-88-39.4-88-88 39.4-88 88-88zm0 344c-58.7 0-111.3-26.6-146.5-68.2 18.8-35.4 55.6-59.8 98.5-59.8 2.4 0 4.8.4 7.1 1.1 13 4.2 26.6 6.9 40.9 6.9 14.3 0 28-2.7 40.9-6.9 2.3-.7 4.7-1.1 7.1-1.1 42.9 0 79.7 24.4 98.5 59.8C359.3 421.4 306.7 448 248 448z"/></svg>',
];

return $define;
