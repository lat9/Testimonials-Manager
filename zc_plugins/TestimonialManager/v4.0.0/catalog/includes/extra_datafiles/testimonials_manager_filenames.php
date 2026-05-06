<?php
/**
 * Testimonials Manager
 *
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 Jul 10 Modified in v1.5.8-alpha $
 *
 * @version $Id: Testimonials_Manager.php v1.5.2 4-16-2010 Clyde Jones $
 */

if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
/**
 * Database name defines
 *
 */
  define('FILENAME_TESTIMONIALS_MANAGER', 'testimonials_manager');
  define('FILENAME_TESTIMONIALS_MANAGER_ALL', 'display_all_testimonials');
  define('FILENAME_TESTIMONIALS_ADD', 'testimonials_add');
  define('FILENAME_ACCOUNT_AVATAR', 'account_avatar');
  define('FILENAME_DEFINE_TESTIMONIALS_ADD', 'define_testimonials_add');
  
if (!defined('DB_PREFIX')) define('DB_PREFIX', '');
  define('TABLE_TESTIMONIALS_MANAGER', DB_PREFIX . 'testimonials_manager');

