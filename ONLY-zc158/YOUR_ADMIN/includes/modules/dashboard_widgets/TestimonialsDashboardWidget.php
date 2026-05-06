<?php
/**
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 May 11 New in v1.5.7 $
  * @version $Id: Testimonials Manager v3.0 1 3-9-2023 davewest $
 */

if (!zen_is_superuser() && !check_page(FILENAME_TESTIMONIALS_MANAGER, '')) return; //if not created yet??

// to disable this module for everyone, uncomment the following "return" statement so the rest of this file is ignored
// return;

 $tm_plugin = $db->Execute("SELECT status FROM " . TABLE_PLUGIN_CONTROL . " WHERE unique_key = 'TestimonialManager'");
 if ($tm_plugin->fields['status'] == 2) return;


$maxRows = 15;

defined('TEXT_TM_STATUS_0') || define('TEXT_TM_STATUS_0', 'Pending Review');
defined('TEXT_TM_STATUS_1') || define('TEXT_TM_STATUS_1', 'Approved');
defined('TEXT_TM_STATUS_2') || define('TEXT_TM_STATUS_2', 'Banned - Not allowed to create');



  
    
    $sql = "SELECT * FROM " . TABLE_TESTIMONIALS_MANAGER . " ORDER BY date_added DESC";
    $testimonials = $db->Execute($sql, (int)$maxRows, true, 1800);

    $totalTM = $db->Execute("select count(*) as count from " . TABLE_TESTIMONIALS_MANAGER . "");

  
  
?>


                    
                    
<div class="panel panel-default reportBox">
    <div class="panel-heading header"><?php echo BOX_CONFIGURATION_TESTIMONIALS_MANAGER . '&nbsp;&nbsp;' . $totalTM->fields['count'] . '&nbsp;&nbsp;' . '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER) . '">' . BOX_CONFIGURATION_TESTIMONIALS_MANAGER; ?></a></div>
    <table class="table table-striped table-condensed">
    <?php
        foreach ($testimonials as $TMcustomer) {
          ?>
        <tr>
          <td class="dataTableContent">
            <span ><?php echo $TMcustomer['testimonials_name']; ?></span> 
          </td>
          <td class="dataTableContent">
            <span ><?php echo zen_image(DIR_WS_TEMPLATE_IMAGES . 'stars_' . $TMcustomer['tm_rating'] . '.gif'); ?></span> 
            
          </td>  
          <td class="dataTableContent">
                    <?php
   if (zen_not_null($TMcustomer['status'])) {
    switch ($TMcustomer['status']) {
      case '0': //Pending Review
      echo '<span title="' . TEXT_TM_STATUS_0 .'" >' . TEXT_TM_STATUS_0 . '</span>'; 
        break;
      case '1': //Approved
      echo '<span title="' . TEXT_TM_STATUS_1 .'" >' . TEXT_TM_STATUS_1 . '</span>'; 
        break;
      case '2':  // Banned - Not allowed to create
      echo '<span title="' . TEXT_TM_STATUS_2 .'" >' . TEXT_TM_STATUS_2 . '</span>'; 
        break;              
      }
    }
                    ?>
                    </td>
          <td class="text-right"><?php echo zen_date_short($TMcustomer['date_added']); ?></td>
        </tr>
    <?php
      }
    ?>
    </table>
</div>  
<!--  enable popovers-->
<script>
    jQuery(function () {
        jQuery('[data-toggle="popover"]').popover({html:true,sanitize: true})
    })
</script>


