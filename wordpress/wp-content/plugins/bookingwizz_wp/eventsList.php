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
require_once(BOOKING_WIZARD_HOME_DIR."includes/config.php"); //Load the functions

$prf = (!empty($_REQUEST["prf"]))?strip_tags(str_replace("'","`",$_REQUEST["prf"])):$prefix;

$date = (!empty($_REQUEST["date"]))?strip_tags(str_replace("'","`",$_REQUEST["date"])):'';
$lb1 = (!empty($_REQUEST["lb1"]))?strip_tags(str_replace("'","`",$_REQUEST["lb1"])):'';
$lb2 = (!empty($_REQUEST["lb2"]))?strip_tags(str_replace("'","`",$_REQUEST["lb2"])):'';

$serviceID = (!empty($_REQUEST["serviceID"]))?strip_tags(str_replace("'","`",$_REQUEST["serviceID"])):1;


$showServices = 1;


if(isset($curSrviceID) && !empty($curSrviceID)){
    $showServices = 0;
    $serviceID=$curSrviceID;
}else{
    $curSrviceID = $serviceID;
}

$showServices = (isset($_REQUEST["show_services"]))?$_REQUEST["show_services"]:$showServices;


$eventID =( !empty($_REQUEST["eventID"]))?strip_tags(str_replace("'","`",$_REQUEST["eventID"])):'';
$date =(!empty($_REQUEST["date"]))?strip_tags(str_replace("'","`",$_REQUEST["date"])):'';

$ajax = (!empty($_REQUEST["ajax"]))?strip_tags(str_replace("'","`",$_REQUEST["ajax"])):'';
if(!$ajax){
    $_SESSION['site']=$_SERVER['REQUEST_URI'];
}

$startDay = getServiceSettings($serviceID, 'startDay');
$iMonth = (!empty($_REQUEST["month"]))?strip_tags(str_replace("'","`",$_REQUEST["month"])):date('m');
$iYear = (!empty($_REQUEST["year"]))?strip_tags(str_replace("'","`",$_REQUEST["year"])):date('Y');	
$calendar = "";
$calendar = setupCalendar($iMonth,$iYear,$serviceID);
list($iPrevMonth, $iPrevYear) = prevMonth($iMonth, $iYear);
list($iNextMonth, $iNextYear) = nextMonth($iMonth, $iYear);
$iCurrentMonth = date('n');
$iCurrentYear = date('Y');
$iCurrentDay = '';
if(($iMonth == $iCurrentMonth) && ($iYear == $iCurrentYear)){
	$iCurrentDay = date('d');
	$thismonth=true;
}
$iNextMonth = mktime(0, 0, 0, $iNextMonth, 1, $iNextYear);
$iPrevMonth = mktime(0, 0, 0, $iPrevMonth, 1, $iPrevYear);
$iCurrentDay = $iCurrentDay;
$iCurrentMonth = mktime(0, 0, 0, $iMonth, 1, $iYear);
$title =_getDate(date('F',$iCurrentMonth))." ".date('Y',$iCurrentMonth);
############################## REQUEST CALENDAR DATE IF NAVIGATION USED ################################
$serviceLink="&serviceID={$serviceID}";
################### PREPARE LINKS FOR CALENDAR NAVIGATION ######################
$prev_month_link = "<a href=\"?month=".date('m',$iPrevMonth)."&year=".date('Y',$iPrevMonth).$serviceLink."&show_services=".$showServices."&ajax=yes&prf=".$prf."\" class=\"previous_month_".$prf."\">"._getDate(date('M',$iPrevMonth))."</a>";
$next_month_link = "<a href=\"?month=".date('m',$iNextMonth)."&year=".date('Y',$iNextMonth).$serviceLink."&show_services=".$showServices."&ajax=yes&prf=".$prf."\" class=\" next next_month_".$prf."\">"._getDate(date('M',$iNextMonth))."</a>";
################### PREPARE CALENDAR HEADER DEPENDING ON MON OR SUN AS FIRST DAY ######################
	
?>
<?php if($ajax!='yes'){?>
<link rel="stylesheet" href="<?php echo BW_PLUGIN_URL?>resources/css/widget_style.css" type="text/css" />


<script type="text/javascript">if (typeof jQuery != "function"){	document.write('<scr' + 'ipt type="text/javascript" src="<?php echo BW_SCRIPT_URL?>js/jquery-1.7.2.min.js"></scr' + 'ipt>');        var Jq = document.createElement('script'); Jq.type = 'text/javascript'; Jq.async = true;        Jq.src = ('<?php echo BW_SCRIPT_URL?>js/jquery-1.7.2.min.js');        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(Jq, s);}</script>
<script type="text/javascript">if (typeof jQuery.bw_colorbox != "function"){     var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = false;    ga.src = ('<?php echo BW_SCRIPT_URL?>js/jquery.bw_colorbox.js');    var s = document.getElementsByTagName('head')[0]; s.appendChild(ga);        var st = document.createElement('link'); st.type = 'text/css'; st.media = 'screen'; st.rel='stylesheet';    st.href = ('<?php echo BW_SCRIPT_URL?>css/bw_colorbox.css');    var s = document.getElementsByTagName('link')[0]; s.parentNode.insertBefore(st, s);         }function redirect(url,name){ window.open(url,name); }</script>


<div id="BW_events_list_<?php echo $prf?>" class="BW_events_list">
    <?php } ?>
    <div id="Woverlay_<?php echo $prf?>" class="Woverlay"><div></div></div>
<div class="calendar_<?php echo $prf?>">
<?php
if($showServices){
                       
				$sql="SELECT * FROM bs_services";
				$res=mysql_query($sql);
				if(mysql_num_rows($res)>1){
			?>
	<div style="float:right">
		<form name="ff1" id="ff1" method="post">
			<select name="serviceID" id="EserviceID_<?php echo $prf?>" <?/*onchange="document.forms['ff1'].submit()"*/?>>
				
				<?php while($row=mysql_fetch_assoc($res)){?>
					<option value="<?php echo $row['id']?>" <?php echo ($serviceID==$row['id'])?"selected='selected'":""?>><?php echo $row['name']?></option>
				<?php }?>
			</select>
                    <input type="hidden" name="prf" value="<?php echo $prf?>">
		</form>
	</div>
	<div style="clear:both"></div>
	<?php }}?>
<!-- CALENDAR NAVIGATION -->
    <table cellspacing="5" class="event_list_naw">
    <tr>
        <th height="50" class="left" width="100">
            <?php echo $prev_month_link?>
        </th>
        <th align="center" class="center " width="400">
            <?php echo $title?>
        </th>
        <th align="right" class="right"  width="100">
            <?php echo $next_month_link?>
        </th>
    </tr>
    </table>
<!-- CALENDAR NAVIGATION END -->
<br />

</div>
<div id="eventListConteiner">
<?php
                                $dateStart = $iYear."-".$iMonth."-01";
                                $dateEnd = $iYear."-".$iMonth."-".date("t",mktime(0, 0, 0, $iMonth, 1, $iYear));
                               
                                $eventsList = array();
                                for($i = $dateStart;$i<=$dateEnd;$i=date("Y-m-d",strtotime("$i + 1 days"))){
                                    
                                    foreach(getEventsByDate($i, $serviceID) as $events){
                                       // dump($events);
                                        $eventsList[$events['event']['eventDate']]=array("event"=>$events['event'],"qty"=>$events['qty']);
                                    }
                                }
                                
                                if(count($eventsList)>0){
                                foreach ($eventsList as $event){
                                    $row = $event['event'];
                                    
				
                                $spaces_left = $event['qty'];
                                $datetocheck = date("Y-m-d",strtotime($row['eventDate']));
                                $click = "getEvent('" . $row['id'] . "'," . $row['serviceID'] . ",'" . $datetocheck . "');";
                                
                                if($row['eventDate'] > date("Y-m-d") && $spaces_left > 0){
                                    $past = "";
                                }else{
                                    $past= "past";
                                    $click='';
                                    }
?>

    <div class="eventConteiner <?php  echo $past ?>">
                <div class='eventTitle1'><a href="javascript:;" onclick="<?php $click ?>"><?php echo $row['title'] ?></a> / <?php echo getService($row['serviceID'], 'name') ?></div>

                <table cellspacing="0" cellpadding="0" border="0" style="margin-bottom:0px">
                    <tr>
                        <td valign="top" class="eventDescription">
                                
                                                            
                                <?php if (!empty($row['path'])) { ?><img src="<?php echo BW_SCRIPT_URL?><?php echo $row['path'] ?>" height="100"><?php } ?>
                                <?php echo $row['description'] ?>		
                        </td>
                        <td valign="top" width="205">
                            <table class="tableR" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td colspan="2" class="tdB">
                                        <label><?php echo EVENT_START ?></label>
                                        
                                        <span class="date <?php  echo $past ?>"><?php echo getDateFormat($row["eventDate"]) ?></span>
                                            
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
                                    <?php if ($row['eventDate'] < date("Y-m-d") && $spaces_left > 0) { ?>
                                        <div class="past">Passed event</div>
                                    <?php }elseif($spaces_left<1){ ?>
                                        <div class="past">Event fully Booked</div>
                                        <?php }else{ ?>
                                        <input type="image" onClick="<?php echo $click ?>" src="<?php echo BW_PLUGIN_URL ?>resources/images/book_now.png">
                                        <?php }?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
<?php }}else{?>
	<h2><?php echo NO_EVENT_MONTH?></h2>
<?php }?>

       <div style="clear: both"></div>
</div>


</div>


<script language="javascript" type="text/javascript">jQuery("#EserviceID_<?php echo $prf?>").on("change",function(){var el=jQuery(this);var href="<?php echo BW_PLUGIN_URL?>eventsList.php?ajax=yes&prf=<?php echo $prf?>&serviceID="+el.val();getAjaxECalendar(href);});function getEvent(eventID,serviceID,date){jQuery.bw_colorbox({href:'<?php echo BW_SCRIPT_URL?>event-booking.php',innerWidth:'1100px',innerHeight:'800px',iframe:true,urlData:{eventID:eventID,serviceID:serviceID,date:date}});return false;}jQuery(document).ready(function() {jQuery("a.previous_month_<?php echo $prf?>").on("click",function(){var el=jQuery(this);var href="<?php echo BW_PLUGIN_URL?>eventsList.php"+el.attr('href');getAjaxECalendar(href);return false;});jQuery("a.next_month_<?php echo $prf?>").on("click",function(){var el=jQuery(this);var href="<?php echo BW_PLUGIN_URL?>eventsList.php"+el.attr('href');getAjaxECalendar(href);return false;});});function getAjaxECalendar(href){jQuery("#Woverlay_<?php echo $prf?>").show();jQuery.ajax({url:href,dataType:"html",success:function(data){jQuery("#BW_events_list_<?php echo $prf?>").html(data);}});}function resizeFrame(height,width){    jQuery.bw_colorbox.resize({width:width+'px',height:height+'px'})}</script> 

