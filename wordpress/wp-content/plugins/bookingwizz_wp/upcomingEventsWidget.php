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
//session_start();

define('WP_HOME_DIR', dirname(dirname(dirname(dirname(__FILE__)))));
require (WP_HOME_DIR."/wp-load.php");
require_once(BOOKING_WIZARD_HOME_DIR."includes/config.php"); //Load the functions



?>
<link rel="stylesheet" href="<?php echo BW_PLUGIN_URL?>resources/css/widget_style.css" type="text/css" />
<script type="text/javascript">
    if (typeof jQuery != "function")
{
	document.write('<scr' + 'ipt type="text/javascript" src="<?php echo BW_SCRIPT_URL?>js/jquery-1.7.2.min.js"></scr' + 'ipt>');
}
</script>
<script  type="text/javascript">

    if (typeof jQuery.bw_colorbox != "function")
{

	document.write('<scr'+'ipt type="text/javascript" src="http://"<?php echo BW_SCRIPT_URL?>js/jquery.bw_colorbox.js"></scri'+'pt>');
        document.write('<link type="text/css" media="screen" rel="stylesheet" href="<?php echo BW_SCRIPT_URL?>css/bw_colorbox.css" />');

}
function getLightboxEvent(eventID,serviceID,date){

		jQuery.bw_colorbox({href:'<?php echo BW_SCRIPT_URL?>event-booking.php?eventID='+eventID+"&serviceID="+serviceID+"&date="+date,innerWidth:'1100px',innerHeight:'800px',iframe:true});	

		return false;
	}
function redirect(url,name){ window.open(url,name); }       
</script>
<div class="BW_events_widget">
    <?php
    $eventsCount = (!empty($eventsCount))?$eventsCount:5;
    
   
            
        $dateStart = date("Y-m-d");
        $dateEnd = date("Y-m-d",strtotime("$dateStart +30 days"));
        
        $eventsList = array();
        for ($i = $dateStart; $i <= $dateEnd; $i = date("Y-m-d", strtotime("$i + 1 days"))) {
            
            foreach (getEventsByDate($i, $curSrviceID) as $events) {
                
                $eventsList[$events['event']['eventDate']] = array("event" => $events['event'], "qty" => $events['qty']);
            }
        }
       
        if (count($eventsList) > 0) {
            reset($eventsList) ;
            for ($i=0;$i<=$eventsCount && $i<count($eventsList);$i++) {
                
                if($i==0){
                    $list = current($eventsList);
                }else{
                    $list = next($eventsList);
                }
                $row = $list['event'];

                //$spaces_left = getSpotsLeftForEvent($row["id"]);
                $spaces_left = $list['qty'];
                $datetocheck = date("Y-m-d", strtotime($row['eventDate']));
            
                $click = "getLightboxEvent('" . $row['id'] . "'," . $row['serviceID'] . ",'" . $datetocheck . "');";
                $dateShow = $row["eventDate"]!=$row["eventDateEnd"]?getDateFormat($row["eventDate"])." - ".getDateFormat($row["eventDateEnd"]):getDateFormat($row["eventDate"]);
            ?>
    <div class="BW_events_item">
         <a href="javascript:;" onclick="<?php echo $click?>"><?php echo $row['title']?></a>
        <div class="BW_events_img">
            <?php if(!empty($row['path'])){?><img src="<?php echo BW_SCRIPT_URL?><?php echo $row['path']?>" width="50"><?php }?>
        </div>
        <div class="BW_events_info">
            <span> <?php echo $dateShow?></span>
              <span>      <b><?php echo EVENT_START?></b> <?php echo date((getTimeMode())?"g:i a":"H:i", strtotime($row["eventTime"]))?></span>
           
        </div>
        <div style="clear: both"></div>
    </div>
    <?php }}?>
</div>
    