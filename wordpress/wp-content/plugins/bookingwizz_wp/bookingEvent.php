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
require_once (WP_HOME_DIR."/wp-load.php");
$_SESSION['site']=$_SERVER['REQUEST_URI'];

require_once(BOOKING_WIZARD_HOME_DIR."includes/config.php"); //Load the functions

$prf = $eventID;


?>

<link rel="stylesheet" href="<?php echo BW_PLUGIN_URL?>resources/css/widget_style.css" type="text/css" />

<script type="text/javascript">if (typeof jQuery != "function"){	document.write('<scr' + 'ipt type="text/javascript" src="<?php echo BW_SCRIPT_URL?>js/jquery-1.7.2.min.js"></scr' + 'ipt>');        var Jq = document.createElement('script'); Jq.type = 'text/javascript'; Jq.async = true;        Jq.src = ('<?php echo BW_SCRIPT_URL?>js/jquery-1.7.2.min.js');        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(Jq, s);}</script>
<script type="text/javascript">if (typeof jQuery.bw_colorbox != "function"){     var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = false;    ga.src = ('<?php echo BW_SCRIPT_URL?>js/jquery.bw_colorbox.js');    var s = document.getElementsByTagName('head')[0]; s.appendChild(ga);        var st = document.createElement('link'); st.type = 'text/css'; st.media = 'screen'; st.rel='stylesheet';    st.href = ('<?php echo BW_SCRIPT_URL?>css/bw_colorbox.css');    var s = document.getElementsByTagName('link')[0]; s.parentNode.insertBefore(st, s);         }function redirect(url,name){ window.open(url,name); }</script>

<div id="BW_events_list_<?php echo $prf?>" class="BW_events_list">
   
<div id="eventListConteiner">
<?php
		$dateStart = $iYear."-".$iMonth."-01";
		$dateEnd = $iYear."-".$iMonth."-".date("t",mktime(0, 0, 0, $iMonth, 1, $iYear));
		$query="SELECT * FROM bs_events WHERE id={$eventID}";//print $query;
				$result=mysql_query($query);
				if(mysql_num_rows($result)>0){
				while($row=mysql_fetch_assoc($result)){
				$spaces_left = getSpotsLeftForEvent($row["id"]);
                                $datetocheck = date("Y-m-d",strtotime($row['eventDate']));
                                $click = "getEvent_{$eventID}('" . $row['id'] . "'," . $row['serviceID'] . ",'" . $datetocheck . "');";
                                
                                if($row['eventDate'] > date("Y-m-d") && $spaces_left > 0){
                                    $past = "";
                                }else{
                                    $past= "past";
                                    $click='';
                                    }
?>

     <div class="eventConteiner <?php  echo $past ?>">
                <div class='eventTitle1'><a href="javascript:;" onclick="<?php $click ?>"><?php echo $row['title'] ?></a> / <?php echo getService($row['serviceID'], 'name') ?></div>

                <table cellspacing="0" cellpadding="0" border="0" style="margin-bottom:10px">
                    <tr>
                        <td valign="top" class="eventDescription">
                                
                                                            
                                <?php if (!empty($row['path'])) { ?><img src="<?php echo BW_SCRIPT_URL ?><?php echo $row['path'] ?>" height="100"><?php } ?>
                                <?php echo $row['description'] ?>                        </td>                        <td valign="top" width="205">                            <table class="tableR" cellspacing="0" cellpadding="0" border="0">                                <tr>                                    <td colspan="2" class="tdB">                                        <label><?php echo EVENT_START ?></label>                                                                                <span class="date <?php  echo $past ?>"><?php echo getDateFormat($row["eventDate"]) ?></span>                                            
                                            <span  class="time <?php  echo $past ?>">  <?php echo date((getTimeMode()) ? "g:i a" : "H:i", strtotime($row["eventTime"])) ?></span>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%"><div class="eventSpots"><span class="spot  <?php  echo $past ?>"><?php echo $spaces_left ?></span><span class="spot1">spots<br>left</span></div></td>
                                    <td align="center"><div class="eventFee <?php  echo $past ?>">
                                            <?php
                                            if ($row["payment_required"] == "1") {
                                                $price = $row["entryFee"];
                                                if (getOption('enable_tax')) {
                                                    $price = $price + ($price * getOption('tax') / 100);
                                                }
                                                echo getOption('currency') . "&nbsp;" . number_format($price, 2);
                                            } else {
                                                echo "<span style='color:#0FA1D2'>".FREE."</span>";
                                            }
                                            ?>
                                        </div></td>
                                </tr>
                                <tr><td colspan="2" align="center" class="nobrd"> 
                                    <?php if ($row['eventDate'] > date("Y-m-d") && $spaces_left > 0) { ?>
                                        <input type="image" onClick="<?php echo $click ?>" src="<?php echo BW_PLUGIN_URL ?>resources/images/book_now.png">
                                    <?php }else{ ?>
                                        <div class="past">Passed event</div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
<?php }}?>
	

       <div style="clear: both"></div>
</div>
	

</div>

<script language="javascript" type="text/javascript">
	
	function getEvent_<?php echo("$eventID")?>(eventID,serviceID,date){

		jQuery.bw_colorbox({href:'<?php echo BW_SCRIPT_URL?>event-booking.php',urlData:{eventID:eventID,serviceID:serviceID,date:date},innerWidth:'1100px',innerHeight:'800px',iframe:true});	

		return false;
	}
	
	jQuery(document).ready(function() {
	<?php if(!empty($lb1) && $lb1=="yes" && !empty($date)){?>

	jQuery.bw_colorbox({href:"<?php echo BW_SCRIPT_URL?>booking.php?date=<?php echo $date?>&msg2=captcha&serviceID=<?php echo $serviceID?>&name=<?php echo urlencode($name)?>&phone=<?php echo urlencode($phone)?>&email=<?php echo urlencode($email)?>&comments=<?php echo urlencode($comments)?>&<?php echo http_build_query(array('time'=>$time))?>"});	

	<?php } ?>
	<?php if(!empty($lb2) && $lb2=="yes" && !empty($eventID)){?>

	jQuery.bw_colorbox({href:"<?php echo BW_SCRIPT_URL?>event-booking_frame.php?eventID=<?php echo $eventID?>&msg2=captcha&serviceID=<?php echo $serviceID?>&name=<?php echo urlencode($name)?>&phone=<?php echo urlencode($phone)?>&email=<?php echo urlencode($email)?>&qty_<?php echo $selEvent?>=<?php echo urlencode($qty)?>&comments=<?php echo urlencode($comments)?>&selEvent=<?php echo $selEvent ?>"});	

	<?php } ?>
	
	
});


function resizeFrame(height,width){
    jQuery.bw_colorbox.resize({width:width+'px',height:height+'px'})
}
</script> 
