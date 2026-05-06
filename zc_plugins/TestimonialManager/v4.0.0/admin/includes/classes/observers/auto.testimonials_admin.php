<?php
// -----
// Part of the Testimonials Manager plugin, v4.0.0 and later.
//
// Last updated: v4.0.0
//
if (!defined('IS_ADMIN_FLAG') || IS_ADMIN_FLAG !== true) {
    die('Illegal Access');
}

use Zencart\Traits\InteractsWithPlugins;
use Zencart\Traits\ObserverManager;

class zcObserverTestimonialsAdmin extends
{
    use ObserverManager;
    use InteractsWithPlugins;

    public function __construct()
    {
        $this->attach(
            $this,
            [
                /* From /admin/index_dashboard.php */
                'NOTIFY_ADMIN_DASHBOARD_WIDGETS',
            ]
        );
    }

    public function update(&$class, $eventID, $p1, &$p2, &$p3, &$p4)
    {
        switch ($eventID) {
            // -----
            // Issued by /admin/index_dashboard.php, enabling the addition of
            // other dashboard widgets.
            //
            // On entry:
            //
            // $p1 ... n/a
            // $p2 ... Contains a reference to the current array of widgets
            //
            case 'NOTIFY_ADMIN_DASHBOARD_WIDGETS':
                $this->detectZcPluginDetails(__DIR__);
                $p2[] = ['column' => 3, 'sort' => 20, 'visible' => true, 'path' => $this->zcPluginPath . 'admin/includes/dashboard_widgets/TestimonialsDashboardWidget.php'];
                break;
 
            default:
                break;
        }
    }
}
