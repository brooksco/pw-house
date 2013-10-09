<?php
/* * ****************************************************************************
  #                         BookingWizz for WordPress v1.2
  #******************************************************************************
  #      Author:     Convergine (http://www.convergine.com)
  #      Website:    http://www.convergine.com
  #      Support:    http://support.convergine.com
  #      Version:     1.2
  #
  #      Copyright:   (c) 2009 - 2012  Convergine.com
  #
  #****************************************************************************** */
define('WP_HOME_DIR', dirname(dirname(dirname(dirname(__FILE__)))));
require_once (WP_HOME_DIR . "/wp-load.php");
require_once(BOOKING_WIZARD_HOME_DIR."includes/config.php"); //Load the functions

$prf = $eventID;
?>

<link rel="stylesheet" href="<?php echo BW_PLUGIN_URL ?>resources/css/widget_style.css" type="text/css" />
<script type="text/javascript">

    if (typeof jQuery != "function")
    {
        document.write('<scr' + 'ipt type="text/javascript" src="<?php echo BW_SCRIPT_URL?>js/jquery-1.7.2.min.js"></scr' + 'ipt>');
    }
</script>
<?php
$query = "SELECT * FROM bs_reservations WHERE eventID='{$eventID}' AND status=1"; //print $query;
$result = mysql_query($query);
if (mysql_num_rows($result) > 0) {
    ?>
    <ul class="bw_attendees_list">
        <?php while ($row = mysql_fetch_assoc($result)) { ?>
            <li><?php echo ($row['name']) ?></li>
        <?php } ?>
    </ul>

<?php } ?>


