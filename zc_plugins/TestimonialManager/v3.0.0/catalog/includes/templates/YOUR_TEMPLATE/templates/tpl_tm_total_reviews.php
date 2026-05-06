<?php
/**
 * Testimonials Manager
 *
 * @package Template System
 * @copyright 2007 Clyde Jones
  * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Testimonials Manager v3.0 13 9-19-2022 davewest $
 * Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc.
 */

$red_star = '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(239,41,41,1)" width="40px" height="auto" viewBox="0 0 576 512"><path d="M528.1 171.5L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6zM388.6 312.3l23.7 138.4L288 385.4l-124.3 65.3 23.7-138.4-100.6-98 139-20.2 62.2-126 62.2 126 139 20.2-100.6 98z"/></svg>';
$black_star = '<svg xmlns="http://www.w3.org/2000/svg" fill="rgba(239,41,41,1)" width="40px" height="auto" viewBox="0 0 576 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>';

  //count of total reviews
    $feedback_query = "select count(*) as count from " . TABLE_TESTIMONIALS_MANAGER . " 
                       where language_id = '" . (int)$_SESSION['languages_id'] . "'
                        and status = '1'";

    $feedback = $db->Execute($feedback_query);
    
  //Average Store Rating    
    $feedback_average_rating_query = "select avg(tm_rating) as average_rating from " . TABLE_TESTIMONIALS_MANAGER . "
                       where language_id = '" . (int)$_SESSION['languages_id'] . "'
                        and status = '1'";

    $feedback_average_rating = $db->Execute($feedback_average_rating_query);

$stars_rating = number_format((float)$feedback_average_rating->fields['average_rating'], 1, '.', '');
$prating = number_format((float)$feedback_average_rating->fields['average_rating'], 2, '.', '')  * 20;

echo '<link rel="stylesheet" type="text/css" href="' . ($template->get_template_dir('/tm_total_reviews.css',DIR_WS_TEMPLATE, $current_page_base,'css') . '/tm_total_reviews.css') . '" type="text/css" />';

echo '<h2>Number of store reviews of ' . $feedback->fields['count'] . ' for a average rating of ' . $stars_rating . ' out of 5 stars!</h2>';

echo '<div class="star-rating" title="Total Average rating!">
    <div class="back-stars">
        <i aria-hidden="true">' . $red_star . '</i>
        <i aria-hidden="true">' . $red_star . '</i>
        <i aria-hidden="true">' . $red_star . '</i>
        <i aria-hidden="true">' . $red_star . '</i>
        <i aria-hidden="true">' . $red_star . '</i>
        
        <div class="front-stars" style="width: ' . $prating . '%">
            <i aria-hidden="true">' . $black_star . '</i>
            <i aria-hidden="true">' . $black_star . '</i>
            <i aria-hidden="true">' . $black_star . '</i>
            <i aria-hidden="true">' . $black_star . '</i>
            <i aria-hidden="true">' . $black_star . '</i>
        </div>
    </div>
</div> ';
?>

