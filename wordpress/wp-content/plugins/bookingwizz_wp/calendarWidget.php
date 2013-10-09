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

$_SESSION['site']=$_SERVER['REQUEST_URI'];

require_once(BOOKING_WIZARD_HOME_DIR."includes/config.php"); //Load the functions




$date = (!empty($_REQUEST["date"]))?strip_tags(str_replace("'","`",$_REQUEST["date"])):'';
$dateFrom = (!empty($_REQUEST["dateFrom"]))?strip_tags(str_replace("'","`",$_REQUEST["dateFrom"])):'';
$dateTo = (!empty($_REQUEST["dateTo"]))?strip_tags(str_replace("'","`",$_REQUEST["dateTo"])):'';

$lb1 = (!empty($_REQUEST["lb1"]))?strip_tags(str_replace("'","`",$_REQUEST["lb1"])):'';
$lb2 = (!empty($_REQUEST["lb2"]))?strip_tags(str_replace("'","`",$_REQUEST["lb2"])):'';
$lb3 = (!empty($_REQUEST["lb3"]))?strip_tags(str_replace("'","`",$_REQUEST["lb3"])):'';

$ajax = (!empty($_REQUEST["ajax"]))?strip_tags(str_replace("'","`",$_REQUEST["ajax"])):'';

$eventID = (!empty($_GET["eventID"]))?$_GET["eventID"]:'';
$selEvent = (!empty($_GET["selEvent"]))?$_GET["selEvent"]:'';
$name = (!empty($_REQUEST["name"]))?strip_tags(str_replace("'","`",$_REQUEST["name"])):'';
$phone = (!empty($_REQUEST["phone"]))?strip_tags(str_replace("'","`",$_REQUEST["phone"])):'';
$email = (!empty($_REQUEST["email"]))?strip_tags(str_replace("'","`",$_REQUEST["email"])):'';
$comments = (!empty($_REQUEST["comments"]))?strip_tags(str_replace("'","`",$_REQUEST["comments"])):'';
$qty = (!empty($_REQUEST["qty_".$selEvent]))?strip_tags(str_replace("'","`",$_REQUEST["qty_".$selEvent])):'';
$time = (!empty($_GET["time"]))?$_GET["time"]:'';

$serviceID = (!empty($_REQUEST["serviceID"]))?strip_tags(str_replace("'","`",$_REQUEST["serviceID"])):1;

$showServices = 1;


if(isset($curSrviceID) && !empty($curSrviceID)){
    $showServices = 0;
    $serviceID=$curSrviceID;
}else{
    $curSrviceID = $serviceID;
}
$showServices = (isset($_REQUEST["show_services"]))?$_REQUEST["show_services"]:$showServices;
############################## REQUEST CALENDAR DATE IF NAVIGATION USED ################################
$startDay = getServiceSettings($serviceID, 'startDay');
$iMonth = (!empty($_REQUEST["month"]))?strip_tags(str_replace("'","`",$_REQUEST["month"])):date('n');
$iYear = (!empty($_REQUEST["year"]))?strip_tags(str_replace("'","`",$_REQUEST["year"])):date('Y');	
$calendar = "";
$calendar = setupSmallCalendar($iMonth,$iYear,$serviceID);
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
$title =_getDate(date('F Y',$iCurrentMonth));

$serviceLink="&serviceID={$serviceID}";
################### PREPARE LINKS FOR CALENDAR NAVIGATION ######################
$Wprevious_month = "<a href=\"?month=".date('m',$iPrevMonth)."&year=".date('Y',$iPrevMonth).$serviceLink."&show_services=".$showServices."&serviceID=".$serviceID."\" class=\"Wprevious_month small\">"._getDate(date('M',$iPrevMonth))."</a>";
$Wnext_month_link = "<a href=\"?month=".date('m',$iNextMonth)."&year=".date('Y',$iNextMonth).$serviceLink."&show_services=".$showServices."&serviceID=".$serviceID."\" class=\"Wnext_month small\">"._getDate(date('M',$iNextMonth))."</a>";
################### PREPARE CALENDAR HEADER DEPENDING ON MON OR SUN AS FIRST DAY ######################
if($startDay=="0"){
	$calendarHeader = '<td class="weekend dash_border">'.getShortWeek(0).'</td><td class="dash_border">'.getShortWeek(1).'</td><td class="dash_border">'.getShortWeek(2).'</td><td class="dash_border">'.getShortWeek(3).'</td><td class="dash_border">'.getShortWeek(4).'</td><td class="dash_border">'.getShortWeek(5).'</td><td class="weekend dash_border">'.getShortWeek(6).'</td>';
} else if($startDay=="1"){ 
	$calendarHeader = '<td class="dash_border">'.getShortWeek(1).'</td><td class="dash_border">'.getShortWeek(2).'</td><td class="dash_border">'.getShortWeek(3).'</td><td class="dash_border">'.getShortWeek(4).'</td><td class="dash_border">'.getShortWeek(5).'</td><td class="weekend dash_border">'.getShortWeek(6).'</td><td class="weekend dash_border">'.getShortWeek(0).'</td>';
}
	
	
	
?>
<?php if($ajax!='yes'){?>
<link rel="stylesheet" href="<?php echo BW_PLUGIN_URL?>resources/css/widget_style.css" type="text/css" />

<script type="text/javascript">if (typeof jQuery != "function"){	document.write('<scr' + 'ipt type="text/javascript" src="<?php echo BW_SCRIPT_URL?>js/jquery-1.7.2.min.js"></scr' + 'ipt>');        var Jq = document.createElement('script'); Jq.type = 'text/javascript'; Jq.async = true;        Jq.src = ('<?php echo BW_SCRIPT_URL?>js/jquery-1.7.2.min.js');        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(Jq, s);}</script>
<script type="text/javascript">if (typeof jQuery.bw_colorbox != "function"){     var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = false;    ga.src = ('<?php echo BW_SCRIPT_URL?>js/jquery.bw_colorbox.js');    var s = document.getElementsByTagName('head')[0]; s.appendChild(ga);        var st = document.createElement('link'); st.type = 'text/css'; st.media = 'screen'; st.rel='stylesheet';    st.href = ('<?php echo BW_SCRIPT_URL?>css/bw_colorbox.css');    var s = document.getElementsByTagName('link')[0]; s.parentNode.insertBefore(st, s);         }function redirect(url,name){ window.open(url,name); }</script>

<div id="Wcalendar">

<?php }?>
    <div id="Woverlay" class="Woverlay"><div></div></div>
			<?php
                        if($showServices){
				$sql="SELECT * FROM bs_services";
				$res=mysql_query($sql);
				if(mysql_num_rows($res)>1){
			?>
	<div style="float:right">
		<form name="ff1" id="ff1" method="post">
			<select name="serviceID" id="WserviceID" <?/*onchange="document.forms['ff1'].submit()"*/?>>
				
				<?php while($row=mysql_fetch_assoc($res)){?>
					<option value="<?php echo $row['id']?>" <?php echo ($serviceID==$row['id'])?"selected":""?>><?php echo $row['name']?></option>
				<?php }?>
			</select>
		</form>
	</div>
	<div style="clear:both"></div>
	<?php }}?>
<!-- CALENDAR NAVIGATION -->
    <table cellspacing="0" cellpadding="0" width="100%" class="dash_border">
    <tr class="calendar_header small">
        <th  width="5%">
            <?php echo $Wprevious_month?>
        </th>
        <th align="center" width="90%">
            <?php echo $title?>
        </th>
        <th align="right"  width="5%">
            <?php echo $Wnext_month_link?>
        </th>
    </tr>
	<tr>
            <td colspan=3 align=center>
                <table class="bw_calendar small" cellpadding="1" cellspacing="1" border="0" width="100%">
                    <tbody>
                        <tr>
                            <?php echo $calendarHeader; ?>
                        </tr>
                    </tbody>
                    <?php echo $calendar; ?>
                </table>
            </td>
	</tr>
    </table>

</div>


<script language="javascript" type="text/javascript">	jQuery(".day_number").on("click",function(){		jQuery(".showInfo").hide();		jQuery(this).find(".showInfo").show();	});	jQuery("#WserviceID").on("change",function(){		var el=jQuery(this);		var href="<?php echo BW_PLUGIN_URL?>calendarWidget.php?ajax=yes&serviceID="+el.val();		getAjaxWCalendar(href);		});	function getLightbox(reserveDate,serviceID){jQuery.bw_colorbox({href:'<?php echo BW_SCRIPT_URL?>booking.php',urlData:{date:reserveDate,serviceID:serviceID},innerWidth:'1100px',innerHeight:'800px',iframe:true});return false;}function getLightbox2(eventID,serviceID,date){jQuery.bw_colorbox({href:'<?php echo BW_SCRIPT_URL?>event-booking.php?',urlData:{eventID:eventID,serviceID:serviceID,date:date},innerWidth:'1100px',innerHeight:'800px',iframe:true});return false;}function getLightboxDays(date,serviceID){                jQuery.bw_colorbox({href:'<?php echo BW_SCRIPT_URL?>booking-days.php',urlData:{dateFrom:date,serviceID:serviceID},innerWidth:'1060px',innerHeight:'800px',iframe:true});return false;        }	jQuery(document).ready(function() {	jQuery("a.Wprevious_month.small").on("click",function(){		var el=jQuery(this);		var href="<?php echo BW_PLUGIN_URL?>calendarWidget.php"+el.attr('href')+"&ajax=yes"	;	getAjaxWCalendar(href);		return false;	});	jQuery("a.Wnext_month.small").on("click",function(){		var el=jQuery(this);		var href="<?php echo BW_PLUGIN_URL?>calendarWidget.php"+el.attr('href')+"&ajax=yes";		getAjaxWCalendar(href);		return false;	});	});function getAjaxWCalendar(href){	jQuery("#Woverlay").show();		jQuery.ajax({			url:href,			dataType:"html",			success:function(data){				jQuery("#Wcalendar").html(data);			}		});}function resizeFrame(height,width){    jQuery.bw_colorbox.resize({width:width+'px',height:height+'px'})}</script> 


