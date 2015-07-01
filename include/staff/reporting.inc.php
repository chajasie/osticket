<?php
if(!defined('OSTSCPINC') || !$thisstaff || !@$thisstaff->isStaff()) die('Access Denied');

$supportTime = 0;
$qs = array();
$select = 'SELECT ticket_thread.ticket_id, ticket_thread.user_id, ticket_thread.created, sum(ticket_thread.supportTime) as dauer, ticket.number as number, ticket__cdata.subject as subject ';
$from = 'FROM ticket_thread ';
$left = "LEFT JOIN ticket on ticket_thread.ticket_id=ticket.ticket_id LEFT JOIN ticket__cdata ON ticket__cdata.ticket_id=ticket.ticket_id ";
$where="WHERE thread_type='R' AND poster <> 'SYSTEM' AND";
$today = date('Y-m-d');
$today = date('Y-m-d', strtotime($today. ' + 1 days'));
$firstOfMonth = date('Y-m-01');
$search = " ticket_thread.created BETWEEN '" . $firstOfMonth . "' AND '" . $today . "'";

$sort = " GROUP BY ticket_id ORDER BY ticket_thread.created";
if($searchQuery){
    $search = $searchQuery;
}
$query=$select . $from . $left . $where . $search . $sort;
//echo $query;
$hash = md5($query);
$_SESSION['search_'.$qhash] = $query;

$res = db_query($query);
?>

<form action="reporting.php" method="POST" name="staff" >
    <?php csrf_token(); ?>
    <input type="hidden" name="do" value="mass_process" >
    <input type="hidden" id="action" name="a" value="" >
    <input class="dp" type="input" value="" name="startDate" />
    <input class="dp" type="input" value="" name="endDate" />

    <input type="submit" value="Suchen" />
</form>
<hr />

<form action="reporting.php" method="POST" name='reporting' id="reporting">
    <?php csrf_token(); ?>
    <input type="hidden" name="a" value="mass_process" >
    <input type="hidden" name="do" id="action" value="" >

    <table class="list" border="0" cellspacing="1" cellpadding="2" width="940">
        <thead>
        <tr>
            <?php if($thisstaff->canManageTickets()) { ?>
                <th width="8px">&nbsp;</th>
            <?php } ?>
            <th width="90">Ticket Number</th>
            <th width="260">Hilfethema</th>
            <th width="170">zuletzt Durchgeführt:</th>
            <th width="170">Dauer</th>
        </tr>
        </thead>
        <tbody>

        <?php
         while ($row = db_fetch_array($res)) {
             $supportTime += $row['supportTime'];
        ?>
        <tr>
            <td></td>
            <td><?php echo $row['number']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td><?php echo substr($row['created'], 0, -3); ?></td>
            <td><?php echo $row['dauer']; ?></td>
        </tr>
        <?php
         }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="7">
                <?php
                    echo sprintf('<a class="export-csv no-pjax" href="?%s">%s</a>',
                    Http::build_query(array(
                        'a' => 'export',
                        'h' => $hash)),
                    __('Export'));
                ?>
            </td>
        </tr>
        </tfoot>
    </table>

</form>