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
$BW_continue = false;

$BW_tables = array(
    "bs_coupons",
    "bs_events",
    "bs_reservations",
    "bs_reservations_items",
    "bs_reserved_time",
    "bs_reserved_time_items",
    "bs_schedule",
    "bs_schedule_days",
    "bs_service_settings",
    "bs_service_days_settings",
    "bs_services",
    "bs_settings",
    "bs_transactions");

if (isset($_POST['BW_action_install']) && $_POST['BW_action_install'] == 'yes') {
    $_BW_dir = trim($_POST['BW_directory'], "/");
    $BW_dir = BW_sanitize_path(ABSPATH . "$_BW_dir");
    $BW_message = "BookingWizz was not found in specified path";
    if (is_dir($BW_dir)) {

        $dirList = scandir($BW_dir);
        //print_r($dirList);
        if (count($dirList) > 2) {
            if (is_dir($BW_dir . "/includes/")) {
                if (is_file($BW_dir . "/includes/sql.php")) {
                    $BW_continue = true;
                    update_option('BW_install_path', $_BW_dir);

                    $BWError = false;
                    $tables = array();


                    $query = "SHOW TABLES";
                    $result = mysql_query($query) or die(mysql_error());
                    While ($row = mysql_fetch_array($result)) {


                        $tables[] = $row[0];
                    }


                    foreach ($BW_tables as $k) {
                        if (!in_array($k, $tables)) {
                            $BW_continue=false;
                            $BW_message.="Table $k not found<br/>";
                            $BWError = true;
                        }
                    }

                    if ($BWError) {
                        $BWContinue = false;
                        $BWMessage = "";
                        
                        include_once "BWInstall.php";
                        if ($BWContinue) {
                            update_option('BW_install', '1');
                            $BWInstall = 1;
                            BW_setOption("is_word_press","1");
                        }
                    } else {
                        update_option('BW_install', '1');
                        $BWInstall = 1;
                        if(!empty($BW_api_key)){
                            update_option('BW_install', '2');
                            $BWInstall = 2;
                            BW_updateOption("is_word_press","1");
                        }
                    }
                }
            }
        }
    }
    
    if($BW_continue){
        ?>
        <div class="updated"><p><strong><?php _e('BookingWizz detected in specified path'); ?></strong></p></div>
        <?php
    } else {
        ?>
        <div class="updated"><p><strong><?php _e($BW_message); ?></strong></p></div>
        <?php
    }
}

if ($BWInstall<1) {
    ?>
    <div class="wrap">
        <?php echo "<h4>" . __('Checking BookingWizz Installation', '') . "</h4>"; ?>
        <p><?php _e("<b>Step 1 of 3</b><br>This plugin requires original bookingwizz v5.2 to be present on this server.
                        Please enter path to bookingwizz below"); ?></p>

        <form name="BW_form" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="BW_action_install" value="yes">

            <p><?php _e("Install Directory: "); ?><input type="text" name="BW_directory" value="" size="40"> (e.g.  /booking/ note the trailing slash! )</p>

            <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Check Installation') ?>" />
            </p>
        </form>   
    </div>
    <?php
}else{
    $BW_continue = true;
}
?>