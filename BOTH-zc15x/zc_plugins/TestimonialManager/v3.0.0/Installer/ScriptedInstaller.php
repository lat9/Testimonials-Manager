<?php
/**
 * Testimonials Manager
 *
 * @copyright 2007 Clyde Jones
 * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Testimonials Manager v3.0 2 09/15/2022 davewest $
 */
 
 
use Zencart\PluginSupport\ScriptedInstaller as ScriptedInstallBase;

class ScriptedInstaller extends ScriptedInstallBase
{

    protected function executeInstall()
    {
    
    global $sniffer, $db;
    
    // set version 3.0.0 ;
        
     // Get db prefix if any
 	$db_prefix = DB_PREFIX;       
 
    // Set table name
 	$table_name = $db_prefix . 'testimonials_manager';


//bof check for existing install

$config_check = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title  LIKE 'Testimonials Manager';");	

if (isset($config_check->fields['configuration_group_id'])) {
   $deletecatid = $config_check->fields['configuration_group_id'];

  if ($config_check->RecordCount() > 0) {
     
     while (!$config_check->EOF) {   
   // kill config
     $db->Execute("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_group_id = " . $deletecatid . ";"); 
     $db->Execute("DELETE FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_id = " . $deletecatid . ";");

    $config_check->MoveNext();
  }
 }
}
 
    //now we install this version
    $insert_result1 = $db->Execute("INSERT INTO " . TABLE_CONFIGURATION_GROUP . " (configuration_group_title, configuration_group_description, sort_order, visible) VALUES ('Testimonials Manager', 'Testimonials Manager', '1', '1');");
       
      $db->Execute("UPDATE ". TABLE_CONFIGURATION_GROUP . " SET `sort_order` = LAST_INSERT_ID() WHERE configuration_group_id = LAST_INSERT_ID()");

     if ($insert_result1 === false) exit ('Error in Createing New Configuration Group - Testimonials Manager<br/> ');

 // Get the id of the new configuration category
    $categoryid = array();
    $id_result = $db->Execute("SELECT configuration_group_id FROM ". TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = 'Testimonials Manager'");
  if (!$id_result->EOF) {
     $categoryid = $id_result->fields;
     $tm_config_id = $categoryid['configuration_group_id'];
  } else {
    exit ('Failed Finding Testimonials Manager Configuration_Group ID<br/>Exit');
    }
  
$sql = "INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function, val_function) VALUES 
('Number Of Testimonials to display in Testimonials sidebox', 'MAX_DISPLAY_TESTIMONIALS_MANAGER_TITLES', '5', 'Set the number of testimonials to display in the Latest Testimonials box.', $tm_config_id, 1, NOW(), NOW(), NULL, NULL, NULL),
('Testimonial Title Minimum Length','ENTRY_TESTIMONIALS_TITLE_MIN_LENGTH','2','Minimum length of Testimonial title.', $tm_config_id, 2, NOW(), NOW(), NULL, NULL, NULL),
('Testimonial Text Minimum Length','ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH','10','Minimum length of Testimonial description.', $tm_config_id, 3, NOW(), NOW(), NULL, NULL, NULL),
('Testimonial Contact Name Minimum Length','ENTRY_TESTIMONIALS_CONTACT_NAME_MIN_LENGTH','2','Minimum length of Testimonial contact name.', $tm_config_id, 4, NOW(), NOW(), NULL, NULL, NULL),
('Display Truncated Testimonials in Sidebox','DISPLAY_TESTIMONIALS_MANAGER_TRUNCATED_TEXT','true','Display truncated text in sidebox', $tm_config_id, 5, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'',''false''), ', NULL),
('Length of truncated testimonials to display','TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH','150','If Display Truncated Testimonials in Sidebox is true - set the amount of characters to display from the Testimonials in the Testimonials Manager sidebox.', $tm_config_id, 6, NOW(), NOW(), NULL, NULL, NULL),
('Number Of Testimonials to display on all testimonials page','MAX_DISPLAY_TESTIMONIALS_MANAGER_ALL_TESTIMONIALS','5','Set the number of testimonials to display on the all testimonials page.', $tm_config_id, 7, NOW(), NOW(), NULL, NULL, NULL),
('Display Date Published on Testimonials page','DISPLAY_TESTIMONIALS_DATE_PUBLISHED','true','Display date published on testimonials page', $tm_config_id, 8, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'',''false''), ', NULL),
('Display View All Testimonials Link In Sidebox','DISPLAY_ALL_TESTIMONIALS_TESTIMONIALS_MANAGER_LINK','true','Display View All Testimonials Link In Sidebox', $tm_config_id, 9, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'',''false''), ', NULL),
 ('Display Add New Testimonial Link In Sidebox','DISPLAY_ADD_TESTIMONIAL_LINK','true','Display Add New Testimonial Link In Sidebox', $tm_config_id, 10, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'',''false''), ', NULL),
 ('Testimonial Image Width','TESTIMONIAL_IMAGE_WIDTH','80','Set the Width of the Testimonial Image', $tm_config_id, 11, NOW(), NOW(), NULL, NULL, NULL),
('Testimonial Image Height','TESTIMONIAL_IMAGE_HEIGHT','80','Set the Height of the Testimonial Image', $tm_config_id, 12, NOW(), NOW(), NULL, NULL, NULL),
('Avatar Image Directory','TESTIMONIAL_IMAGE_DIRECTORY','avatars/','Set the Directory for the Testimonial Image', $tm_config_id, 13, NOW(), NOW(), NULL, NULL, NULL),
('Image upload Directory','TM_UPLOAD_DIRECTORY','uploads/','Set the Directory for the Testimonial file uplads.', $tm_config_id, 14, NOW(), NOW(), NULL, NULL, NULL),
('Display Submit Testimonial Page','TM_DISPLAY_SUBMIT','on','Display Submit Testimonial page. disable=off enabled=on', $tm_config_id, 15, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''on'',''off''), ', NULL),
('Display upload image field in add testimonials?','DISPLAY_ADD_IMAGE','on','Display upload image field in add testimonials on = displayed, off = not displayed', $tm_config_id, 16, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''on'',''off''), ', NULL),
('Only registered customers may submit a testimonial','REGISTERED_TESTIMONIAL','true','Only registered customers may submit a testimonial', $tm_config_id, 17, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'',''false''), ', NULL),
('Testimonial - Show Store Name and Address','TESTIMONIAL_STORE_NAME_ADDRESS','true','Include Store Name and Address', $tm_config_id, 18, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''true'',''false''), ', NULL),
('Define Testimonial','DEFINE_TESTIMONIAL_STATUS','1','Enable the Defined Testimonial Text?<br />0= Link ON, Define Text OFF<br />1= Link ON, Define Text ON<br />2= Link OFF, Define Text ON<br />3= Link OFF, Define Text OFF', $tm_config_id, 19, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(''0'',''1'',''2'',''3''), ', NULL),
('Testimonial Text Maximum Length','ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH','1000','Maximum length of Testimonial description.', $tm_config_id, 20, NOW(), NOW(), NULL, NULL, NULL),
('Testimonial Manager Version','TM_VERSION','3.0.0','Testimonial Manager version', $tm_config_id, 21, NOW(), NOW(), NULL, NULL, NULL)";            
 
   $this->executeInstallerSql($sql);

    // find next sort order in admin_pages table
    $result = $db->Execute("SELECT (MAX(sort_order)+2) as sort FROM ".TABLE_ADMIN_PAGES);
    $admin_page_sort = $result->fields['sort'];
    
    // Admin Menu for Testimonial Manager Configuration Menu
    zen_deregister_admin_pages('TMConfig');
    zen_register_admin_page('TMConfig', 'BOX_TOOLS_TESTIMONIALS_MANAGER', 'FILENAME_CONFIGURATION', 'gID='. $tm_config_id . '', 'configuration', 'Y', $admin_page_sort);
    
    // Admin Menu for Testimonial Manager Tools Menu
    zen_deregister_admin_pages('toolsTestimonialsManager');
    zen_register_admin_page('toolsTestimonialsManager', 'BOX_TOOLS_TESTIMONIALS_MANAGER', 'FILENAME_TESTIMONIALS_MANAGER', '', 'tools', 'Y', $admin_page_sort);  
    
    
             // check to see if table exists
         if (!$sniffer->table_exists($table_name)) {

      		$result = $db->Execute("CREATE TABLE `".$table_name."` (
      		  `testimonials_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      		  `language_id` int(11) NOT NULL DEFAULT 0,
      		  `testimonials_title` varchar(255) NOT NULL DEFAULT '',
      		  `testimonials_name` varchar(255) NOT NULL DEFAULT '',
      		  `testimonials_image` varchar(254) NOT NULL DEFAULT '',
      		  `testimonials_html_text` text NOT NULL,
      		  `testimonials_mail` varchar(96) NOT NULL DEFAULT '',
      		  `status` int(1) NOT NULL DEFAULT 0,
      		  `date_added` datetime DEFAULT NULL,
      		  `last_update` datetime DEFAULT NULL,
      		  `tm_rating` int(1) NOT NULL DEFAULT 0,
      		  `tm_feedback` varchar(255) NOT NULL,
      		  `tm_contact_user` varchar(20) NOT NULL DEFAULT 'no',
      		  `tm_contact_phone` varchar(32) NOT NULL,
      		  `tm_gen_info` text DEFAULT NULL,
      		  `tm_privacy_conditions` tinyint(1) NOT NULL DEFAULT 0,
      		  `helpful_yes` int(12) NOT NULL,
      		  `helpful_no` int(12) NOT NULL,
      		  `tm_make_public` varchar(20) DEFAULT NULL,
      		  `testimonials_upimg` varchar(255) NOT NULL,
      		PRIMARY KEY  (`testimonials_id`))");

              if ($result) {
		echo 'Testimonial Database Table Successfully Created.<br />';
	       
	           $db->Execute("INSERT INTO " . $table_name . " (`testimonials_id`, `language_id`, `testimonials_title`, `testimonials_name`, `testimonials_image`, `testimonials_html_text`, `testimonials_mail`, `status`, `date_added`, `last_update`, `tm_rating`, `tm_feedback`, `tm_contact_user`, `tm_contact_phone`, `tm_gen_info`, `tm_privacy_conditions`, `helpful_yes`, `helpful_no`, `tm_make_public`, `testimonials_upimg`) VALUES
(3, 1, 'About CowboyGeek', 'Dave', 'avatars/cbgdave.png', 'I\'m Dave, I\'m basically not the normal saddler. I\'ve been around horses all my life, training, trail riding so on. I had to make allot of my own gear that I used and started about 15 years ago making things for other folk. That\'s about where normal stops. I make things I need and can not find anywhere else. I also got into computers before they was common home PC’s… back before Windows came out we had to code our own games.\r\n\r\nYou never know what you may find here!', 'dave@cowboygeek.com', 1, '2015-05-18 20:40:48', '2019-04-09 22:44:32', 5, '', 'email', '', NULL, 1, 10, 8, 'yes', 'uploads/copper2.jpg'),
(2, 1, 'Great', 'Clyde Designs', 'avatars/clyde-design.png', 'This is just a test submission to show you how it looks, great, eh?', 'clyde@mysticmountainnaturals.com', 1, '2015-05-18 20:05:01', '2018-11-25 10:23:12', 5, 'About CowboyGeek', 'no', '', NULL, 1, 0, 0, 'yes', '')");
		
		} else { 
		echo 'There was a problem in trying to create the database. You may need to do this manually using the following SQL code: <br>' . $table_name; 
		}
    } else {
    echo $table_name . ' Already exist!<br />';
    
    }


//modify customer table for avatars, add a default avatar
if (!$sniffer->field_exists(TABLE_CUSTOMERS,'tm_avatar')) $db->Execute("ALTER TABLE " . TABLE_CUSTOMERS . " ADD COLUMN tm_avatar VARCHAR(255) NOT NULL DEFAULT 'avatars/user-male-icon.png'");


}   

    protected function executeUninstall()
    {
     // Get db prefix if any
 	$db_prefix = DB_PREFIX;       
 
    // Set table name
 	$table_name = $db_prefix . 'testimonials_manager';
 	
 	zen_deregister_admin_pages(['TMConfig']);
        zen_deregister_admin_pages(['toolsTestimonialsManager']);

        $deleteTM = "'MAX_DISPLAY_TESTIMONIALS_MANAGER_TITLES', 'ENTRY_TESTIMONIALS_TITLE_MIN_LENGTH', 'ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH', 'ENTRY_TESTIMONIALS_CONTACT_NAME_MIN_LENGTH', 'DISPLAY_TESTIMONIALS_MANAGER_TRUNCATED_TEXT', 'TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH', 'MAX_DISPLAY_TESTIMONIALS_MANAGER_ALL_TESTIMONIALS', 'DISPLAY_TESTIMONIALS_DATE_PUBLISHED', 'DISPLAY_ALL_TESTIMONIALS_TESTIMONIALS_MANAGER_LINK', 'DISPLAY_ADD_TESTIMONIAL_LINK', 'TESTIMONIAL_IMAGE_WIDTH', 'TESTIMONIAL_IMAGE_HEIGHT', 'TESTIMONIAL_IMAGE_DIRECTORY', 'TM_UPLOAD_DIRECTORY', 'TM_DISPLAY_SUBMIT', 'DISPLAY_ADD_IMAGE', 'REGISTERED_TESTIMONIAL', 'TESTIMONIAL_STORE_NAME_ADDRESS', 'DEFINE_TESTIMONIAL_STATUS', 'ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH', 'TM_VERSION'";
        
        $sql = "DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key IN (" . $deleteTM . ")";
        $this->executeInstallerSql($sql);

         $sql = "DELETE FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = 'Testimonials Manager'";
         $this->executeInstallerSql($sql);
         
         $sql = "ALTER TABLE " . TABLE_CUSTOMERS . " DROP tm_avatar";
         $this->executeInstallerSql($sql);

         $sql = "DROP TABLE ' . $table_name . '"; 
         $this->executeInstallerSql($sql);
         
    }


}
