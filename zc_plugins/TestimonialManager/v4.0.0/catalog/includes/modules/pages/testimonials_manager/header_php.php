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
 * @version $Id: Author: DrByte  Sun Oct 18 23:02:01 2015 -0400 Modified in v1.5.5 $
 * @version $Id: Testimonials_Manager.php v2.0 1-14-2021 davewest $
 */

// This should be first line of the script:
$zco_notifier->notify('NOTIFY_HEADER_START_TESTIMONIALS_MANAGER');

require DIR_WS_MODULES . zen_get_module_directory('require_languages.php');

$id = (int)($_GET['testimonials_id'] ?? -1);
 
 //should not pass without an id
if ($id < 1) {
    zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER_ALL));
}

$page_check = $db->Execute("SELECT * FROM " . TABLE_TESTIMONIALS_MANAGER . " WHERE testimonials_id = $id LIMIT 1");
if ($page_check->EOF) {
    zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER_ALL));
}

$date_published = $page_check->fields['date_added'];
$action = $_GET['action'] ?? '';

if ($action !== '') {
    $tm_id = $id; 
    $tmcookie_na = 'cw' . $tm_id;

    if (isset($_COOKIE[$tmcookie_na])) {
        zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $tm_id, $request_type));
    } else {
        switch ($action) {
            case 'helpyes': 
                $tmv_yes = $db->Execute("SELECT * FROM " . TABLE_TESTIMONIALS_MANAGER . " WHERE testimonials_id = " . (int)$tm_id . " LIMIT 1"); 
 
                $totalYes = $tmv_yes->fields['helpful_yes'] + 1;
                $tmRating = $tmv_yes->fields['tm_rating'];
                $sq2 = "UPDATE " . TABLE_TESTIMONIALS_MANAGER . " SET helpful_yes = " .  $totalYes  . " WHERE testimonials_id = " . (int)$tm_id . " LIMIT 1";
                $db->Execute($sq2);
                break;

            case 'helpno': 
                $tmv_no = $db->Execute("SELECT * FROM " . TABLE_TESTIMONIALS_MANAGER . " WHERE testimonials_id = " . (int)$tm_id . " LIMIT 1"); 
 
                $totalNo = $tmv_no->fields['helpful_no'] + 1;
                $tmRating = $tmv_no->fields['tm_rating'];
                $sq2 = "UPDATE " . TABLE_TESTIMONIALS_MANAGER . " SET helpful_no = " .  $totalNo  . " WHERE testimonials_id = " . (int)$tm_id . "  LIMIT 1";
                $db->Execute($sq2);
                break;
        }
 
        /**
         * set the session cookie parameters
         */
        $path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if (defined('SESSION_USE_ROOT_COOKIE_PATH') && SESSION_USE_ROOT_COOKIE_PATH  === 'True') {
            $path = '/';
        }
        $path = (defined('CUSTOM_COOKIE_PATH')) ? CUSTOM_COOKIE_PATH : $path;

        $domainPrefix = (!defined('SESSION_ADD_PERIOD_PREFIX') || SESSION_ADD_PERIOD_PREFIX === 'True') ? '.' : '';
        if (filter_var($cookieDomain, FILTER_VALIDATE_IP)) {
            $domainPrefix = '';
        }

        $secureFlag = (ENABLE_SSL === 'true' && str_starts_with(HTTP_SERVER, 'https:') && str_starts_with(HTTPS_SERVER, 'https:')) || (ENABLE_SSL === 'false' && str_starts_with(HTTP_SERVER, 'https:'));

        $samesite = (defined('COOKIE_SAMESITE')) ? COOKIE_SAMESITE : 'lax';
        if (!in_array($samesite, ['lax', 'strict', 'none'])) {
            $samesite = 'lax';
        }

        /*  set cookie parameters   */
        $tmcookie_val = $tm_id . '%' . $tmRating;
        setcookie($tmcookie_na, $tmcookie_val, time() + (86400 * 5), $path, (!empty($cookieDomain) ? $domainPrefix . $cookieDomain : ''), $secureFlag);  //86400 = 1 day

        zen_redirect(zen_href_link(FILENAME_TESTIMONIALS_MANAGER, 'testimonials_id=' . $tm_id, $request_type)); 
    }
}

$breadcrumb->add(NAVBAR_TITLE);
// This should be last line of the script:
$zco_notifier->notify('NOTIFY_HEADER_END_TESTIMONIALS_MANAGER');
