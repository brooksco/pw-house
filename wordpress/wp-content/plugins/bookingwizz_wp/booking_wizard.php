<?php

/*
  Plugin Name: BookingWizz for WordPress
  Plugin URI: http://www.convergine.com
  Description: Plugin brings original BookingWizz php booking system into your wordpress with tons of cool features.
  Author: Convergine.com
  Version: 1.2
  Release Date: May 1 2013
  Author URI: http://www.convergine.com
 */

#################################### INSTALL & UNINSTALL PART #########################################################################
//installation function
global $wp_url;

//$wp_url = get_bloginfo('siteurl');
$wp_url = get_site_url();
$bw_url_info = parse_url( get_site_url());
$bw_url = $bw_url_info['scheme']."://".$bw_url_info['host'].$bw_url_info['path'];

//add the hooks for install/uninstall and menu.
register_activation_hook(__FILE__, 'BW_install');
register_deactivation_hook(__FILE__, 'BW_uninstall');
add_action('admin_menu', 'BW_admin_actions');
add_action('init','BW_plugin_init');
add_action('wp_logout','BW_plugin_logout');
add_shortcode('BW_calendar', 'BW_calendar'); //NEW IN v2
add_shortcode('BW_events_list', 'BW_events_list'); //NEW IN v2
add_shortcode('BW_event', 'BW_event'); //NEW IN v2
add_shortcode('BW_attendees_list', 'BW_attendees'); //NEW IN v2
add_action('widgets_init', 'BW_add_widget');

define('BOOKING_WIZARD_HOME_DIR', dirname(dirname(dirname(dirname(__FILE__)))).'/'.get_option('BW_install_path').'/');
define('BW_PLUGIN_URL', BW_get_plugin_url ());
define('BW_SCRIPT_URL', $bw_url."/".get_option('BW_install_path').'/');
define("PLUGIN_DIR",dirname(__FILE__));

function BW_get_plugin_url (){
	

    return trailingslashit(plugins_url(null,__FILE__));
}

function BW_plugin_init() {
if (!session_id())
session_start();
    $WpUser = wp_get_current_user();

    if(isset($WpUser->allcaps['activate_plugins']) && $WpUser->allcaps['activate_plugins']==1) {
        $_SESSION['logged_in'] = true;
        $_SESSION['BW_Wordpress'] = true;
    }


}

 function BW_plugin_logout(){
     $_SESSION['logged_in'] = false;
     unset($_SESSION['logged_in']);
 }

function BW_install() {
    global $wpdb;
    /*$BW_tables = array(
        "bs_events",
        "bs_reservations",
        "bs_reservations_items",
        "bs_reserved_time",
        "bs_reserved_time_items",
        "bs_schedule",
        "bs_service_settings",
        "bs_services",
        "bs_settings",
        "bs_transactions");
    $error = false;
    $message = "Plugin not installed! Not all tables was added<br>";


    $tables = array();


    $query = "SHOW TABLES";
    $result = mysql_query($query) or die(mysql_error());
    While ($row = mysql_fetch_array($result)) {


        $tables[] = $row[0];

    }


    foreach ($BW_tables as $k) {
        if (!in_array($k, $tables)) {
            $message.="$k<br/>";
            $error = true;
        }
    }


    if ($error) {
        BW_trigger_error($message, E_USER_ERROR);
    
    }else{
        BW_setOption("is_word_press","1");
        BW_setOption("api_key","");
    }*/
    update_option('BW_install','0');
    update_option('BW_plugin_api_key','');
    
}

//BW_trigger_error('Some error message', E_USER_ERROR);
 
function BW_trigger_error($message, $errno) {
 
    if(isset($_GET['action'])
          & $_GET['action'] == 'error_scrape') {
 
        echo '<strong>' . $message . '</strong>';
 
        exit;
 
    } else {
 
        trigger_error($message, $errno);
 
    }
 
}
function BW_uninstall() {
    global $wpdb;
}
function BW_sanitize_path($path){
    $delimeter = '\\';
    if(strpos($_SERVER['DOCUMENT_ROOT'],"/")!==FALSE){
        $path = str_replace("\\", "/", $path);
        $path = str_replace("\\\\", "/", $path);
        return $path;
    }
     $path = str_replace( "//","\\", $path);
      return $path;
    
}
function BW_chek_license(){
    
    
    
    $BWInstall = get_option('BW_install');
    
    
    $BW_api_key = BW_getOption('api_key');
    
    if($BWInstall<1){
        include_once 'includes/checkBWinstall.php';
        
    }
    
    
    
    if($BWInstall=='1' && empty($BW_api_key)){
        include_once 'includes/checkBWLicense.php';
        
    }
    if($BWInstall=='2'){
        $PluginApiKey = get_option('BW_plugin_api_key');
        if (empty($PluginApiKey)) {
            include_once 'includes/checkLicense.php';
            if ($BW_continue) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    
    
   
}
		
function BW_calendar($atts) {
    
    if(BW_chek_license()){
        
        $copyright_img = ""; //powered by convergine logo.
        global $wp_url;
        global $wpdb;
        extract(shortcode_atts(array(
                    'id' => ''
                        ), $atts));
        $prefix = rand(10,1000);
        if($id!='all')  {$curSrviceID = $id;}else{$curSrviceID=0;}
        ob_start();
        //include_once  BOOKING_WIZARD_HOME_DIR.'calendar.php';
        include  'calendar.php';
        $content = ob_get_contents();
        ob_clean();
        return $content;
        
    }
}

function BW_events_list($atts) {
    
    if(BW_chek_license()){
        
        $copyright_img = ""; //powered by convergine logo.
        global $wp_url;
        global $wpdb;
        extract(shortcode_atts(array(
                    'id' => ''
                        ), $atts));
        
       $prefix = rand(10,1000);
       if($id!='all')  {$curSrviceID = $id;}else{$curSrviceID=0;}
       ob_start();
        include PLUGIN_DIR.'/eventsList.php';
       $content = ob_get_contents();
        ob_clean();
        return $content;
        
    }
}

function BW_attendees($atts) {
    
    if(BW_chek_license()){
        
        $copyright_img = ""; //powered by convergine logo.
        global $wp_url;
        global $wpdb;
        extract(shortcode_atts(array(
                    'eventid' => ''
                        ), $atts));
        
       $eventID=$eventid;
       
       ob_start();
       
        include PLUGIN_DIR.'/bookingEventAttendees.php';
        $content = ob_get_contents();
        ob_clean();
        return $content;
        
    }
}

function BW_event($atts) {
    
    if(BW_chek_license()){
        
        $copyright_img = ""; //powered by convergine logo.
        global $wp_url;
        global $wpdb;
        extract(shortcode_atts(array(
                    'id' => ''
                        ), $atts));
        
       $eventID = $id;
       
       ob_start();
        include PLUGIN_DIR.'/bookingEvent.php';
        $content = ob_get_contents();
        ob_clean();
        return $content;
        
    }
}

//Creating our menu in WP admin.
function BW_admin_actions() {
    global $wp_url;

    add_menu_page("Dashboard", "BookingWizz", "administrator", basename(__file__), "BW_admin", $wp_url . "/wp-content/plugins/bookingwizz_wp/resources/images/calendar.png");

    //add_menu_page( "PayPal Terminal Settings", "PayPal Terminal", "administrator", basename(__file__), "ccpt_display_admin_menu", "icon URL");
    //add_options_page("PayPal Terminal Settings", "PayPal Terminal Settings", 1, "PayPal Terminal Settings", "ccpt_admin");
    add_submenu_page(basename(__file__), 'Schedule', 'Schedule', 'administrator', 'BW_schedule', 'BW_schedule');
    add_submenu_page(basename(__file__), 'Bookings', 'Bookings', 'administrator', 'BW_bookings', 'BW_bookings');
    add_submenu_page(basename(__file__), 'Events', 'Events', 'administrator', 'BW_events', 'BW_events');
    //add_submenu_page(basename(__file__), 'Add Event', 'Add Event', 'administrator', 'BW_add_events', 'BW_add_events');
    
    add_submenu_page(basename(__file__), 'Manual Bookings', 'Manual Bookings', 'administrator', 'BW_reserve', 'BW_reserve');
    //add_submenu_page(basename(__file__), 'Manual Bookings Add', 'Manual Bookings Add', 'administrator', 'BW_reserve_add', 'BW_reserve_add');
    
    add_submenu_page(basename(__file__), 'Services', 'Services', 'administrator', 'BW_services', 'BW_services');
    //add_submenu_page(basename(__file__), 'Add Service', 'Add Service', 'administrator', 'BW_service', 'BW_service');
    
     add_submenu_page(basename(__file__), 'Coupons', 'Coupons', 'administrator', 'BW_coupons', 'BW_coupons');
    
    add_submenu_page(basename(__file__), 'Settings', 'Settings', 'administrator', 'BW_settings', 'BW_settings');
    
    add_submenu_page(basename(__file__), 'Addons', 'Addons', 'administrator', 'BW_addons', 'BW_addons');
    
    $pluginsMenu = unserialize(BW_getOption("custom_menu"));
   // print_r($pluginsMenu);
    if(is_array($pluginsMenu)){
        foreach($pluginsMenu as $menu){
            add_submenu_page(basename(__file__), $menu['menu_title'], $menu['menu_title'], 'administrator', $menu['menu_action'], 'BW_page');

        }
    }
   
}
function BW_page(){
    global $bw_url;
    $page = $_GET['page'];
    if(BW_chek_license()){
    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/getAdminPage.php?p={$page}'></iframe>
            </div>");
   } 
    
}
//function for including needed page into wp admin upon request from menu
function BW_admin() { /* plugin overview page */
    global $bw_url;
   if(BW_chek_license()){
    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/admin.php'></iframe>
            </div>");
   }     
}
function BW_schedule() { /* plugin overview page */
    global $bw_url;
    //print var_dump(parse_url($wp_url));
   if(BW_chek_license()){
    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/bs-schedule.php'></iframe>
            </div>");
   }      
}
function BW_bookings() { /* plugin overview page */
    global $bw_url;
   if(BW_chek_license()){
    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/bs-bookings.php'></iframe>
            </div>");

   }         
}
function BW_events() { /* plugin overview page */
    global $bw_url;
   
       if(BW_chek_license()){      

    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/bs-events.php'></iframe>
            </div>");
       }     
}
function BW_add_events() { /* plugin overview page */
    global $bw_url;
      if(BW_chek_license()){      

    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/bs-events-add.php'></iframe>
            </div>");
      }    
}
function BW_reserve() { /* plugin overview page */
    global $bw_url;
      if(BW_chek_license()){      

    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/bs-reserve-view.php'></iframe>
            </div>");
      }     
}
function BW_reserve_add() { /* plugin overview page */
    global $bw_url;
      if(BW_chek_license()){      

    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/bs-reserve.php'></iframe>
            </div>");
      }    
}

function BW_coupons() { /* plugin overview page */
    global $bw_url;
      if(BW_chek_license()){      

    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/bs-coupons.php'></iframe>
            </div>");
      }
}

function BW_services() { /* plugin overview page */
    global $bw_url;
      if(BW_chek_license()){      

    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/bs-services.php'></iframe>
            </div>");
      }
}
function BW_service() { /* plugin overview page */
    global $bw_url;
      if(BW_chek_license()){      

    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/bs-services-add.php'></iframe>
            </div>");
      }
}
function BW_settings() { /* plugin overview page */
    global $bw_url;
      if(BW_chek_license()){      

    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/bs-settings.php'></iframe>
            </div>");
      }    
}

function BW_addons() { /* plugin overview page */
    global $bw_url;
      if(BW_chek_license()){      

    
    echo("
            <div style='width: 100%; display: block; min-height: 600px;' >
            <iframe width='100%' style='min-height:600px;' id='BW_frame' src='{$bw_url}/".get_option('BW_install_path')."/bs-addons.php'></iframe>
            </div>");
      }    
}

function BW_getOption($option) {

    $option = trim($option);

    if (empty($option))
        return false;

    $option = addslashes($option);
    $sql = "SELECT * FROM bs_settings WHERE option_name='{$option}'";
    $res = mysql_query($sql);
    if (@mysql_num_rows($res) > 0) {
        $row = mysql_fetch_assoc($res);
        return $row['option_value'];
    } else {
        return false;
    }
}

function BW_setOption($option_name, $option_value) {

    $option_name = trim($option_name);

    if (BW_getOption($option_name) !== false)
        return false;

    if (is_string($option_value))
        $option_value = trim($option_value);
    if (is_array($option_value))
        $option_value = serialize($option_value);

    $sql = "INSERT INTO  bs_settings (option_name,option_value) VALUES ('{$option_name}','{$option_value}')";
    $res = mysql_query($sql);

    return true;
}

function BW_updateOption($option_name, $option_value) {

    $option_name = trim($option_name);

    if (BW_getOption($option_name) === false) {
        if (BW_setOption($option_name, $option_value))
            return true;
    }

    if (is_string($option_value))
        $option_value = trim($option_value);
    if (is_array($option_value))
        $option_value = serialize($option_value);

    $sql = "UPDATE bs_settings SET option_value='{$option_value}' WHERE  option_name='{$option_name}'";
    $res = mysql_query($sql);

    return true;
}

function BW_deleteOption($option_name) {

    $option_name = trim($option_name);

    if (BW_getOption($option_name) === false) {
        return false;
    }

    if (!BW_checkCoreOptions($option_name)) {
        $sql = "DELETE FROM bs_settings WHERE option_name='{$option_name}'";
        $res = mysql_query($sql);
        return true;
    } else {
        return false;
    }
}

function BW_checkCoreOptions($option_name) {
    global $coreOptionsList;

    $option_name = trim($option_name);

    if (in_array($option_name, $coreOptionsList))
        return true;

    return false;
}
function BW_add_widget() {
    register_widget('bw_widget');
    register_widget('bw_widget_events');
}

class bw_widget extends WP_Widget {

    function bw_widget() {
        /* Widget settings. */
        $widget_ops = array('classname' => 'bw_widget', 'description' => __('Booking Calendar', 'bw_widget'));
        /* Widget control settings. */
        $control_ops = array('width' => 250, 'height' => 200, 'id_base' => 'bw_widget');
        /* Create the widget. */
        $this->WP_Widget('bw_widget', __('Booking Calendar', 'bw_widget'), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {

        global $wp_url;
        global $wpdb;
        extract($args);

        /* User-selected settings. */
        $title = apply_filters('widget_title', $instance['title']);
        
        $curSrviceID = $instance['serviceID'];
        echo $before_widget;
        if ( ! empty( $title ) )
	echo $before_title . $title . $after_title;
        
        include  'calendarWidget.php';
        


        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['serviceID'] = strip_tags($new_instance['serviceID']);
        //$instance['name'] = strip_tags( $new_instance['name'] );
        //$instance['sex'] = $new_instance['sex'];
        //$instance['show_sex'] = $new_instance['show_sex'];

        return $instance;
    }

    function form($instance) {

        /* Set up some default widget settings. */
        //$defaults = array( 'title' => 'Example', 'name' => 'John Doe', 'sex' => 'male', 'show_sex' => true );
        $defaults = array('title' => 'Booking Calendar','serviceID'=>"1");
        $instance = wp_parse_args((array) $instance, $defaults);
?>
        					<p>
        						<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
        						<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        					</p>
                                                <p>
        						<label for="<?php echo $this->get_field_id('serviceID'); ?>">Service:</label>
        						
                                                        <select name="<?php echo $this->get_field_name('serviceID'); ?>" id="<?php echo $this->get_field_id('serviceID'); ?>">
                                                             <option value="0" <?php echo $instance['serviceID']==0?"selected='selected'":""?>>All Services</option>
                                                             <?php
                                                                $sql = "SELECT * FROM bs_services ORDER BY name";
                                                                $res = mysql_query($sql);
                                                                while($row = mysql_fetch_assoc($res)){
                                                             ?>
                                                             <option value="<?php echo $row['id']?>" <?php echo $instance['serviceID']==$row['id']?"selected='selected'":""?>><?php echo $row['name']?></option>
                                                             <?php }?>
                                                            
                                                            
                                                        </select>
                                                        
        					</p>
        <?php
    }
}
    
    class bw_widget_events extends WP_Widget {

    function bw_widget_events() {
        /* Widget settings. */
        $widget_ops = array('classname' => 'bw_widget_events', 'description' => __('Booking Upcomming Events', 'bw_widget_events'));
        /* Widget control settings. */
        $control_ops = array('width' => 250, 'height' => 200, 'id_base' => 'bw_widget_events');
        /* Create the widget. */
        $this->WP_Widget('bw_widget_events', __('Booking Upcomming Events', 'bw_widget_events'), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {

        global $wp_url;
        global $wpdb;
        extract($args);

        /* User-selected settings. */
        $title = apply_filters('widget_title', $instance['title']);
        
        $eventsCount = $instance['eventsCount'];
        $curSrviceID = $instance['serviceID'];
        echo $before_widget;
        if ( ! empty( $title ) )
	echo $before_title . $title . $after_title;
        
        include  'upcomingEventsWidget.php';
        


        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['eventsCount'] = strip_tags($new_instance['eventsCount']);
        $instance['serviceID'] = strip_tags($new_instance['serviceID']);
       

        return $instance;
    }

    function form($instance) {

        /* Set up some default widget settings. */
        //$defaults = array( 'title' => 'Example', 'name' => 'John Doe', 'sex' => 'male', 'show_sex' => true );
        $defaults = array('title' => 'Booking Upcomming Events','eventsCount'=>"5",'serviceID'=>"1");
        $instance = wp_parse_args((array) $instance, $defaults);
?>
        					<p>
        						<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
        						<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        					</p>
                                                <p>
        						<label for="<?php echo $this->get_field_id('eventsCount'); ?>">Count of upcoming events:</label>
        						<input class="widefat" id="<?php echo $this->get_field_id('eventsCount'); ?>" name="<?php echo $this->get_field_name('eventsCount'); ?>" value="<?php echo $instance['eventsCount']; ?>" style="width:100%;" />
                                                        
        					</p>
                                                <select name="<?php echo $this->get_field_name('serviceID'); ?>" id="<?php echo $this->get_field_id('serviceID'); ?>">
                                                             <option value="0" <?php echo $instance['serviceID']==0?"selected='selected'":""?>>All Services</option>
                                                             <?php
                                                                $sql = "SELECT * FROM bs_services ORDER BY name";
                                                                $res = mysql_query($sql);
                                                                while($row = mysql_fetch_assoc($res)){
                                                             ?>
                                                             <option value="<?php echo $row['id']?>" <?php echo $instance['serviceID']==$row['id']?"selected='selected'":""?>><?php echo $row['name']?></option>
                                                             <?php }?>
                                                            
                                                            
                                                        </select>
        <?php
    }

}
add_action('media_buttons','BW_sc_select',11);
add_action('admin_head', 'button_js');

function BW_sc_select(){
    global $wp_url;
    $icon = $wp_url . "/wp-content/plugins/bookingwizz_wp/resources/images/calendar.png";
    $shortcode_tags = array(
        "Display all Calendars"=>"BW_calendar id=all",
        "Display particular Calendar"=>"BW_calendar id=X ",
        "Dispalay Events"=>"BW_events_list id=all",
        "Dispalay Events of particular Calendar"=>"BW_events_list id=X ",
        "Dispalay single Event"=>"BW_event id=X ",
        "Dispalay Event Attendees"=>"BW_attendees_list eventID=X ");
     /* ------------------------------------- */
     /* enter names of shortcode to exclude bellow */
     /* ------------------------------------- */
    $exclude = array("wp_caption", "embed");
    echo '<div style="display:inline-block">
        <img src="'.$icon.'" id="BW_shortcode_list" style="margin-left:5px" title="Shortcode menu">&nbsp;
            <select id="sc_select" style="display:none"><option>Shortcode</option>';
    foreach ($shortcode_tags as $key => $val){
            if(!in_array($key,$exclude)){
            $shortcodes_list .= '<option value="['.$val.']">'.$key.'</option>';
            }
        }
     echo $shortcodes_list;
     echo '</select></div>';
}

function button_js() {
        echo '
            <script>
        jQuery(document).ready(function(){
        
           jQuery("#sc_select").change(function() {
                          send_to_editor(jQuery("#sc_select :selected").val());
                          return false;
                });
           jQuery("#BW_shortcode_list").click(function(){
                        var drop = jQuery(this).next();
                        console.log(drop);
                        if(drop.is(":visible")){
                            drop.hide();
                        }else{
                            drop.show();
                        }
                })
        });
        </script>';
}
?>