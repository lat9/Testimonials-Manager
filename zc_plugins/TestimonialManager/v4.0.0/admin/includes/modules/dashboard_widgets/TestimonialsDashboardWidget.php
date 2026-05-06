<?php
/**
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 May 11 New in v1.5.7 $
  * @version $Id: Testimonials Manager v3.0 1 3-9-2023 davewest $
 */

if (!zen_is_superuser() && !check_page(FILENAME_TESTIMONIALS_MANAGER, '')) {
    return; //if not created yet??
}

$totalTM = $db->Execute("SELECT COUNT(*) AS count FROM " . TABLE_TESTIMONIALS_MANAGER);
?>
<div class="panel panel-default reportBox">
    <div class="panel-heading header">
        <?= BOX_CONFIGURATION_TESTIMONIALS_MANAGER .
            '&nbsp;&nbsp;' .
            $totalTM->fields['count'] .
            '&nbsp;&nbsp;' .
            '<a href="' . zen_href_link(FILENAME_TESTIMONIALS_MANAGER) . '">' .
                BOX_CONFIGURATION_TESTIMONIALS_MANAGER .
            '</a>' ?>
    </div>
    <table class="table table-striped table-condensed">
<?php
$maxRows = 15;
$sql = "SELECT * FROM " . TABLE_TESTIMONIALS_MANAGER . " ORDER BY date_added DESC";
$testimonials = $db->Execute($sql, (int)$maxRows, true, 1800);
foreach ($testimonials as $TMcustomer) {
    $status_label = constant('TEXT_TM_STATUS_' . $TMcustomer['status']);;
?>
        <tr>
            <td class="dataTableContent">
                <?= zen_output_string_protected($TMcustomer['testimonials_name']) ?>
            </td>
            <td class="dataTableContent">
                <?= str_repeat(zen_icon('star-shadow', size: 'lg'), (int)$TMcustomer['tm_rating']) ?>
            </td>
            <td class="dataTableContent">
                <span title="<?= $status_label ?>"><?= $status_label ?></span>
            </td>
            <td class="text-right"><?= zen_date_short($TMcustomer['date_added']) ?></td>
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
