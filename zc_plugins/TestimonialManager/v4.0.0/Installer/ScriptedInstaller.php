<?php
/**
 * Testimonials Manager
 *
 * Last updated: v4.0.0
 *
 * @copyright 2007 Clyde Jones
 * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Testimonials Manager v3.0 2 09/15/2022 davewest $
 */
use Zencart\PluginSupport\ScriptedInstaller as ScriptedInstallBase;

class ScriptedInstaller extends ScriptedInstallBase
{
    private string $configGroupTitle = 'Testimonials Manager';
    private string $tableName = DB_PREFIX . 'testimonials_manager';
    private \sniffer $sniffer;

    protected function executeInstall()
    {
        // -----
        // First, determine the configuration-group-id and install the settings.
        //
        $cgi = $this->getOrCreateConfigGroupId(
            $this->configGroupTitle,
            $this->configGroupTitle . ' Settings'
        );
  
        $sql =
            "INSERT IGNORE INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function, val_function)
             VALUES
                ('Number of Testimonials to display in Testimonials sidebox', 'MAX_DISPLAY_TESTIMONIALS_MANAGER_TITLES', '5', 'Set the number of testimonials to display in the Latest Testimonials box.', $cgi, 1, NOW(), NULL, NULL, NULL),

                ('Testimonial Title Minimum Length', 'ENTRY_TESTIMONIALS_TITLE_MIN_LENGTH', '2', 'Minimum length of Testimonial title.', $cgi, 2, NOW(), NULL, NULL, NULL),

                ('Testimonial Text Minimum Length', 'ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH', '10', 'Minimum length of Testimonial description.', $cgi, 3, NOW(), NULL, NULL, NULL),

                ('Testimonial Contact Name Minimum Length', 'ENTRY_TESTIMONIALS_CONTACT_NAME_MIN_LENGTH', '2', 'Minimum length of Testimonial contact name.', $cgi, 4, NOW(), NULL, NULL, NULL),

                ('Display Truncated Testimonials in Sidebox', 'DISPLAY_TESTIMONIALS_MANAGER_TRUNCATED_TEXT', 'true', 'Display truncated text in sidebox', $cgi, 5, NOW(), NULL, 'zen_cfg_select_option([''true'', ''false''], ', NULL),

                ('Length of truncated testimonials to display', 'TESTIMONIALS_MANAGER_DESCRIPTION_LENGTH', '150','If Display Truncated Testimonials in Sidebox is true - set the amount of characters to display from the Testimonials in the Testimonials Manager sidebox.', $cgi, 6, NOW(), NULL, NULL, NULL),

                ('Number of Testimonials to display on all testimonials page', 'MAX_DISPLAY_TESTIMONIALS_MANAGER_ALL_TESTIMONIALS', '5', 'Set the number of testimonials to display on the all testimonials page.', $cgi, 7, NOW(), NULL, NULL, NULL),

                ('Display Date Published on Testimonials page', 'DISPLAY_TESTIMONIALS_DATE_PUBLISHED', 'true', 'Display date published on testimonials page', $cgi, 8, NOW(), NULL, 'zen_cfg_select_option([''true'', ''false''], ', NULL),

                ('Display View All Testimonials Link In Sidebox', 'DISPLAY_ALL_TESTIMONIALS_TESTIMONIALS_MANAGER_LINK', 'true', 'Display View All Testimonials Link In Sidebox', $cgi, 9, NOW(), NULL, 'zen_cfg_select_option([''true'', ''false''], ', NULL),

                ('Display Add New Testimonial Link In Sidebox', 'DISPLAY_ADD_TESTIMONIAL_LINK', 'true', 'Display Add New Testimonial Link In Sidebox', $cgi, 10, NOW(), NULL, 'zen_cfg_select_option([''true'', ''false''], ', NULL),

                ('Testimonial Image Width', 'TESTIMONIAL_IMAGE_WIDTH', '80', 'Set the Width of the Testimonial Image', $cgi, 11, NOW(), NULL, NULL, NULL),

                ('Testimonial Image Height', 'TESTIMONIAL_IMAGE_HEIGHT', '80', 'Set the Height of the Testimonial Image', $cgi, 12, NOW(), NULL, NULL, NULL),

                ('Image upload Directory', 'TM_UPLOAD_DIRECTORY', 'uploads/', 'Set the Directory for the Testimonial file uploads, relative to the <code>/images</code> directory.', $cgi, 14, NOW(), NULL, NULL, NULL),
                ('Display Submit Testimonial Page', 'TM_DISPLAY_SUBMIT', 'on', 'Display Submit Testimonial page. disable=off enabled=on', $cgi, 15, NOW(), NULL, 'zen_cfg_select_option([''on'', ''off''], ', NULL),

                ('Display upload image field in add testimonials?', 'DISPLAY_ADD_IMAGE', 'on', 'Display upload image field in add testimonials on = displayed, off = not displayed', $cgi, 16, NOW(), NULL, 'zen_cfg_select_option([''on'', ''off''], ', NULL),

                ('Only registered customers may submit a testimonial', 'REGISTERED_TESTIMONIAL', 'true', 'Only registered customers may submit a testimonial', $cgi, 17, NOW(), NULL, 'zen_cfg_select_option([''true'', ''false''], ', NULL),

                ('Testimonial - Show Store Name and Address', 'TESTIMONIAL_STORE_NAME_ADDRESS', 'true', 'Include Store Name and Address', $cgi, 18, NOW(), NULL, 'zen_cfg_select_option([''true'', ''false''], ', NULL),

                ('Define Testimonial', 'DEFINE_TESTIMONIAL_STATUS', '3', 'Enable the Defined Testimonial Text?<br>0= Link ON, Define Text OFF<br>1= Link ON, Define Text ON<br>2= Link OFF, Define Text ON<br>3= Link OFF, Define Text OFF', $cgi, 19, NOW(), NULL, 'zen_cfg_select_option(array(''0'', ''1'', ''2'', ''3''), ', NULL),

                ('Testimonial Text Maximum Length', 'ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH', '1000', 'Maximum length of Testimonial description.', $cgi, 20, NOW(), NULL, NULL, NULL)";
 
        $this->executeInstallerSql($sql);
        
        // -----
        // Remove any previous TM version's version setting; if previously set, change the define-page status to "off".
        //
        $this->executeInstallerSql(
            "DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'TM_VERSION' LIMIT 1"
        );
        if (defined('TM_VERSION')) {
            $this->executeInstallerSql(
                "UPDATE " . TABLE_CONFIGURATION . "
                    SET configuration_value = '3'
                  WHERE configuration_key = 'DEFINE_TESTIMONIAL_STATUS'
                  LIMIT 1"
            );
        }

        // Admin Menu for Testimonial Manager Configuration Menu
        zen_deregister_admin_pages('TMConfig');
        zen_register_admin_page('TMConfig', 'BOX_TOOLS_TESTIMONIALS_MANAGER', 'FILENAME_CONFIGURATION', 'gID=' . $cgi, 'configuration', 'Y');

        // Admin Menu for Testimonial Manager Tools Menu
        zen_deregister_admin_pages('toolsTestimonialsManager');
        zen_register_admin_page('toolsTestimonialsManager', 'BOX_TOOLS_TESTIMONIALS_MANAGER', 'FILENAME_TESTIMONIALS_MANAGER', '', 'tools', 'Y');  

        // check to see if table exists
        global $sniffer;
        $this->sniffer = $sniffer;
        if ($this->sniffer->table_exists($this->tableName)) {
            $this->updateTestimonialsTables();
        } else {
            $this->executeInstallerSql(
                "CREATE TABLE `" . $this->tableName . "` (
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
                    `tm_feedback` varchar(255) DEFAULT NULL,
                    `tm_contact_user` varchar(20) NOT NULL DEFAULT 'no',
                    `tm_contact_phone` varchar(32) NOT NULL DEFAULT '',
                    `tm_gen_info` text DEFAULT NULL,
                    `tm_privacy_conditions` tinyint(1) NOT NULL DEFAULT 0,
                    `helpful_yes` int(12) NOT NULL,
                    `helpful_no` int(12) NOT NULL,
                    `tm_make_public` varchar(20) DEFAULT NULL,
                    `testimonials_upimg` varchar(255) NOT NULL,
                PRIMARY KEY  (`testimonials_id`))"
            );
            
            $sql =
                "INSERT INTO " . $this->tableName . "
                    (`language_id`, `testimonials_title`, `testimonials_name`, `testimonials_image`, `testimonials_html_text`, `testimonials_mail`, `status`, `date_added`, `tm_rating`, `tm_feedback`, `tm_contact_user`, `tm_contact_phone`, `tm_gen_info`, `tm_privacy_conditions`, `helpful_yes`, `helpful_no`, `tm_make_public`, `testimonials_upimg`)
                 VALUES
                    (1, 'About CowboyGeek', 'Dave', 'avatars/cbgdave.png', 'I\'m Dave, I\'m basically not the normal saddler. I\'ve been around horses all my life, training, trail riding so on. I had to make allot of my own gear that I used and started about 15 years ago making things for other folk. That\'s about where normal stops. I make things I need and can not find anywhere else. I also got into computers before they was common home PC’s… back before Windows came out we had to code our own games.\r\n\r\nYou never know what you may find here!', 'dave@cowboygeek.com', 1, '2019-04-09 22:44:32', 5, '', 'email', '', NULL, 1, 10, 8, 'yes', 'uploads/copper2.jpg'),

                    (1, 'Great', 'Clyde Designs', 'avatars/clyde-design.png', 'This is just a test submission to show you how it looks, great, eh?', 'clyde@mysticmountainnaturals.com', 1, '2015-05-18 20:05:01', 5, 'About CowboyGeek', 'no', '', NULL, 1, 0, 0, 'yes', '')";

            $this->executeInstallerSql($sql);
        }

        return parent::executeInstall();
    }

    // -----
    // Note: This (https://github.com/zencart/zencart/pull/6498) Zen Cart PR must
    // be present in the base code or a PHP Fatal error is generated due to the
    // function signature difference.
    //
    protected function executeUpgrade($oldVersion)
    {
        global $sniffer;
        $this->sniffer = $sniffer;

        $this->updateTestimonialsTables();

        return parent::executeUpgrade($oldVersion);
    }

    private function updateTestimonialsTables(): void
    {
        $fields_to_drop = [
            'testimonials_url',
            'testimonials_company',
            'testimonials_city',
            'testimonials_country',
            'testimonials_show_email',
        ];
        foreach ($fields_to_drop as $field_name) {
            $this->dropFieldIfExists($field_name);
        }

        $fields_to_add = [
            'tm_rating' => "int(1) NOT NULL default 0",
            'tm_feedback' => "VARCHAR(255) default NULL",
            'tm_contact_user' => "VARCHAR(20) NOT NULL default 'no'",
            'tm_contact_phone' => "VARCHAR(32) NOT NULL default ''",
            'tm_gen_info' => "VARCHAR(255) NOT NULL DEFAULT ''",
            'tm_privacy_conditions' => "tinyint(1) NOT NULL default 0",
            'helpful_yes' => "INT(12) NOT NULL",
            'helpful_no' => "INT(12) NOT NULL",
            'tm_make_public' => "VARCHAR(20) NULL default NULL",
            'testimonials_upimg' => "VARCHAR(255) NOT NULL",
        ];
        foreach ($fields_to_add as $field_name => $default_value) {
            $this->addFieldIfNotExists($field_name, $default_value);
        }

        $fields_to_change = [
            'tm_contact_phone' => "VARCHAR(32) NOT NULL default ''",
            'tm_feedback' => "VARCHAR(255) default NULL",
            'testimonials_title' => " VARCHAR(255) NOT NULL DEFAULT ''",
            'testimonials_mail' => " VARCHAR(96) NOT NULL DEFAULT ''",
            'testimonials_name' => " VARCHAR(255) NOT NULL DEFAULT ''",
            'testimonials_html_text' => " TEXT NOT NULL",
            'date_added' => " DATETIME DEFAULT NULL",
        ];
        foreach ($fields_to_change as $field_name => $default_value) {
            $this->changeFieldDefault($field_name, $default_value);
        }

        // -----
        // Hide the Avatar image directory setting, if present; no longer used
        // as of v4.0.0.
        //
        $this->executeInstallerSql(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_group_id = 6
              WHERE configuration_key = 'TESTIMONIAL_IMAGE_DIRECTORY'"
        );
    }

    private function dropFieldIfExists(string $field_name): void
    {
        if (!$this->sniffer->field_exists($this->tableName, $field_name)) {
            return;
        }

        $this->executeInstallerSql("ALTER TABLE " . $this->tableName . " DROP $field_name");
    }

    private function addFieldIfNotExists(string $field_name, string $default_value): void
    {
        if ($this->sniffer->field_exists($this->tableName, $field_name)) {
            return;
        }
        
        $this->executeInstallerSql("ALTER TABLE " . $this->tableName . " ADD COLUMN $field_name $default_value");
    }

    private function changeFieldDefault(string $field_name, string $default_value): void
    {
        $this->executeInstallerSql("ALTER TABLE " . $this->tableName . " MODIFY $field_name $default_value");
    }

    protected function executeUninstall()
    {
        zen_deregister_admin_pages(['TMConfig', 'toolsTestimonialsManager']);

        // -----
        // Remove the plugin's configuration settings and its configuration group.
        //
        $this->deleteConfigurationGroup($this->configGroupTitle, true);

        parent::executeUninstall();
    }
}
