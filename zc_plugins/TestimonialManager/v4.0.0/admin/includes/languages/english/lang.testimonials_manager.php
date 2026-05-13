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

    'ENTRY_DATE_ADDED_TEXT' => '&nbsp;(i.e. 05/21/1970)',

    'ERROR_NO_SELECTIONS_FOR_DELETE' => 'No testimonials were selected for removal, please try again.',
    'ERROR_PAGE_AUTHOR_REQUIRED' => 'The <em>Author\'s Name</em> is required.',
    'ERROR_PAGE_EMAIL_REQUIRED' => 'The <em>Author\'s E-mail</em> is required.',
    'ERROR_PAGE_TEXT_REQUIRED' => 'The testimonial\'s content is required.',
    'ERROR_PAGE_TITLE_REQUIRED' => 'A <em>Testimonial Title</em> is required.',
    'ERROR_UNKNOWN_STATUS_FLAG' => 'Error: Unknown status flag.',

    'STATUS_APPROVED' => 'Approved',
    'STATUS_BANNED' => 'Banned',
    'STATUS_PENDING' => 'Pending',
    'STATUS_TITLE_CURRENT' => 'Currently %s',   //- Filled in with one of Approved, Banned or Pending
    'STATUS_TITLE_CHANGE' => 'Change to %s',    //- Filled in with one of Approved, Banned or Pending

    'SUCCESS_PAGE_INSERTED' => 'A testimonial has been successfully added.',
    'SUCCESS_PAGE_UPDATED' => 'A testimonial has been successfully updated.',
    'SUCCESS_PAGE_REMOVED' => '%u testimonial(s) have been successfully removed.',
    'SUCCESS_PAGE_STATUS_UPDATED' => 'A testimonial\'s status has been successfully updated.',

    'TABLE_HEADING_DATE_ADDED' => 'Date Added:',
    'TABLE_HEADING_DELETE' => 'Select/Unselect All',
    'TABLE_HEADING_ID' => 'ID',
    'TABLE_HEADING_NAME' => 'Author\'s Name',
    'TABLE_HEADING_MAIL' => 'Author\'s E-Mail',
    'TABLE_HEADING_RATING' => 'Rating',
    'TABLE_HEADING_STATUS' => 'Status',
    'TABLE_HEADING_TESTIMONIALS' => 'Testimonials Title',

    'TEXT_DATE_TESTIMONIALS_CREATED' => 'Date Created:',
    'TEXT_DATE_TESTIMONIALS_LAST_MODIFIED' => 'Last Modified:',

    'TEXT_TESTIMONIALS_DATE' => 'Date Added:',
    'TEXT_TESTIMONIALS_DATE_INFO' => '<strong>Leaving the Date Added Field empty will insert today\'s date or you can enter the date of any past testimonials.</strong>',
    'TEXT_TESTIMONIALS_HTML_TEXT' => 'Testimonial:<br><br>Use plain text only; HTML tags will be sanitized.',
    'TEXT_TESTIMONIALS_MAIL' => 'Author\'s E-Mail:',
    'TEXT_TESTIMONIALS_NAME' => 'Author\'s Name:',
    'TEXT_TESTIMONIALS_STATUS_CHANGE' => 'Status Change: %s',
    'TEXT_TESTIMONIALS_TITLE' => 'Testimonials Title:',

    'TEXT_IMAGE_NONEXISTENT' => 'IMAGE DOES NOT EXIST',

    'TEXT_INFO_CURRENT_IMAGE' => 'Current Image:',
    'TEXT_INFO_DELETE_INTRO' => 'Are you sure you want to delete these testimonials?',
    'TEXT_INFO_DELETE_IMAGE' => 'Are you sure you want to delete this image?',
    'TEXT_INFO_HEADING_DELETE_TESTIMONIALS' => 'Delete Testimonials',
    'TEXT_INFO_NO_IMAGE' => 'No Image uploaded',
    'TEXT_INFO_PAGE_IMAGE' => 'Testimonial Image:',

    'TEXT_INFO_TESTIMONIALS_CONTACT' => 'Can we Contact you:',
    'TEXT_INFO_TESTIMONIALS_CONTACT_EMAIL' => 'Contact Email:',
    'TEXT_INFO_TESTIMONIALS_CONTACT_NAME' => 'Contact Name:',
    'TEXT_INFO_TESTIMONIALS_CONTACT_PHONE' => 'Contact Phone:',
    'TEXT_INFO_TESTIMONIALS_DESCRIPTION' => 'Testimonial:',
    'TEXT_INFO_TESTIMONIALS_FEEDBACK' => 'Testimonial Feedback:',
    'TEXT_INFO_TESTIMONIALS_GEN_INFO' => 'More Info:',
    'TEXT_INFO_TESTIMONIALS_PRIVACY' => 'Privacy Checked:',
    'TEXT_INFO_TESTIMONIALS_PUBLIC' => 'Display to the public?:',
    'TEXT_INFO_TESTIMONIALS_RATING' => 'Store Rating:',
    'TEXT_INFO_TESTIMONIALS_STATUS' => 'Status:',
    'TEXT_INFO_TESTIMONIALS_SUBMIT_IMAGE' => 'Submitted image: ',
    'TEXT_INFO_TESTIMONIALS_TITLE' => 'Testimonial Title:',

    // -----
    // Miscellaneous items, separately sorted.
    //
    'BUTTON_DELETE_SELECTED' => 'Delete Selected Testimonials',
    'IMAGE_NEW_PAGE' => 'Add a Testimonial',
    'TEXT_CONTACT_USER' => 'Contact Author?:',
    'TEXT_DISPLAY_NUMBER_OF_TESTIMONIALS' => 'Displaying <b>%1$u</b> to <b>%2$u</b> (of <b>%3$u</b> testimonials items)',
    'TEXT_EDIT_IMAGE' => 'Edit Image:',
    'TEXT_EMAIL' => 'email',
    'TEXT_FEEDBACK' => 'Feedback Status:',
    'TEXT_FILENAME' => 'Filename: %1$s (%2$upx x %3$upx / %4$ukB)',
    'TEXT_HELPFUL' => 'Helpful?',
    'TEXT_HELPFUL_NO' => 'Not Helpful Votes:',
    'TEXT_HELPFUL_YES' => 'Helpful Votes:',
    'TEXT_HELPFUL_YES_NO' => 'Yes (%1$s) No (%2$s)',
    'TEXT_IMAGE_DIR' => 'Upload to /images/{subdirectory}',
    'TEXT_IMAGES_DELETE' => '<strong>Remove Image?</strong> <span class="smallText">(The image is removed from the testimonial and deleted from the server)</span>',
    'TEXT_IMAGES_TESTMONIALS' => 'No image supplied for this testimonial',
    'TEXT_NO' => 'no',
    'TEXT_PHONE' => 'phone',
    'TEXT_PRIVACY' => 'Privacy checked:',
    'TEXT_PUBLIC' => 'Make Public:',
    'TEXT_RATING' => 'Testimonial Rating:',
    'TEXT_USER_PHONE' => 'Contact User phone:',
    'TEXT_YES' => 'yes',

    'CALENDER_ALT' => '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(33.3,33.3,33.3,1)" width="15px" height="auto" viewBox="0 0 448 512"><path d="M148 288h-40c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12zm108-12v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 96v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm192 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96-260v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48zm-48 346V160H48v298c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z"/></svg>',

    //- %1$s = fill color (e.g. 'rgba(6,130,15,1'), %2$s = width (e.g. '18px')
    'CIRCLE_FORMAT' => '<svg xmlns="http://www.w3.org/2000/svg" fill="%1$s" width="%2$s" height="auto" viewBox="0 0 496 512">',
    'USER_CIRCLE' => '<path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 96c48.6 0 88 39.4 88 88s-39.4 88-88 88-88-39.4-88-88 39.4-88 88-88zm0 344c-58.7 0-111.3-26.6-146.5-68.2 18.8-35.4 55.6-59.8 98.5-59.8 2.4 0 4.8.4 7.1 1.1 13 4.2 26.6 6.9 40.9 6.9 14.3 0 28-2.7 40.9-6.9 2.3-.7 4.7-1.1 7.1-1.1 42.9 0 79.7 24.4 98.5 59.8C359.3 421.4 306.7 448 248 448z"/></svg>',
];

return $define;
