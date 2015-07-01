<?php
/**
 * Created by PhpStorm.
 * User: rausd_000
 * Date: 02.04.2015
 * Time: 16:31
 */
    require('staff.inc.php');
    require_once(INCLUDE_DIR.'class.ticket.php');
    require_once(INCLUDE_DIR.'class.dept.php');
    require_once(INCLUDE_DIR.'class.filter.php');
    require_once(INCLUDE_DIR.'class.canned.php');
    require_once(INCLUDE_DIR.'class.json.php');
    require_once(INCLUDE_DIR.'class.dynamic_forms.php');
    require_once(INCLUDE_DIR.'class.export.reporting.php');       // For paper sizes

    if ($_POST) {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        //SQL-Query anpassen
        $searchQuery = " ticket_thread.created BETWEEN '" . $startDate . "' AND '" . $endDate ."'";
    }

    if($_REQUEST['a'] == 'export') {
        $query = $_SESSION['search_'.$token];

        $ts = strftime('%Y%m%d');
        Export::saveTickets($query, "tickets-$ts.csv", 'csv');
    }
    $page = $user? 'reporting-view.inc.php' : 'reporting.inc.php';

    $nav->setTabActive('reporting');
    require(STAFFINC_DIR.'header.inc.php');
    require(STAFFINC_DIR.$page);
    include(STAFFINC_DIR.'footer.inc.php');

?>