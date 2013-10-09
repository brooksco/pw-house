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

if (isset($_POST['BW_script_license']) && $_POST['BW_script_license'] == 'yes') {

    $BW_license = trim($_POST['BW_submit_license']);
    $BW_username = trim($_POST['codecanyon_username']);
    $BW_domain = $_POST['BW_domain'];

    $BW_message = "";

    $BW_item_name = "87919";

    $BW_envato_apikey = 'kvtkbq11x97wj9jmo8cum6drjsm4sw97';

    $BW_envato_username = "Convergine";

    $BW_license_to_check = preg_replace('/[^a-zA-Z0-9_ -]/s', '', !empty($BW_license) ? $BW_license : "");
    $BW_continue = false;
    

    if (!empty($BW_username) && !empty($BW_domain)) {
        if (!empty($BW_license_to_check) && !empty($BW_envato_apikey) && !empty($BW_envato_username)) {

            //Initialize curl

            $BW_api_url = 'http://marketplace.envato.com/api/edge/' . $BW_envato_username . '/' . $BW_envato_apikey . '/verify-purchase:' . $BW_license_to_check . '.json';

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $BW_api_url);

            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $ch_data = curl_exec($ch);

            curl_close($ch);

            if (!empty($ch_data)) {

                $json_data = json_decode($ch_data, true);

                if (isset($json_data['verify-purchase']) && count($json_data['verify-purchase']) > 0) {

                    //echo "License Type: " . $json_data['verify-purchase']['licence'] . "<br />";
                    //echo "Item Name (ID): " . $json_data['verify-purchase']['item_name'] . "(".$json_data['verify-purchase']['item_id'].")<br />";
                    //echo "Buyer Username: " . $json_data['verify-purchase']['buyer'] . "<br />";
                    //echo "Purchase Date: " . $json_data['verify-purchase']['created_at'] . "<br />";
                    $BW_continue = true;

                    if ($json_data['verify-purchase']['item_id'] != $BW_item_name) {
                        $BW_message .= "<div >License key belongs to a different product</div>";
                        $BW_continue = false;
                    }
                    if (strtolower($json_data['verify-purchase']['buyer']) != strtolower($BW_username)) {

                        $BW_message .= "<div >Username and License key do not match. Please check the username.</div>";
                        $BW_continue = false;
                    }
                   
                    //$BW_continue = true;
                } else {

                    //echo "Error fetching the info. Possible reason: license key invalid. Here's the curl return: ";
                    $BW_message .= "<div >Error fetching the info. Possible reason: license key invalid or incorrect username. </div>";
                    //print_r($json_data);
                }
            } else {

                //echo 'Something went terribly wrong!';
                $BW_message .= "<div >Something went terribly wrong!</div>";
            }
        } else {

            //echo 'You either didn`t pass the license key into the url or didn`t enter your envato username/apikey into configuration';
            $BW_message .= "<div >System Error, please contact convergine support team!</div>";
        }
    } else {
        $BW_message .= "<div >License key, username and authorized domain fields are required</div>";
    }


    if ($BW_continue) {

        BW_updateOption("api_key", $BW_license);
        BW_updateOption("is_word_press","1");
        update_option("BW_plugin_api_key", $BW_license);
        update_option('BW_install','2');
        
        $BWInstall = 2;


        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=utf-8\n";
        $headers .= "From: 'authorization' <noreply@" . $_SERVER['HTTP_HOST'] . "> \n";
        $subject = "Authorization[BookinWizz WP 1.0]";
        //$wp_url = get_bloginfo('siteurl');
        $wp_url = get_site_url();
        $message = "License: " . $BW_license . "<br /> Url: " . $wp_url . "<br /> 
                Username: " . $BW_username . "<br />Authorized Domain: " . $BW_domain . "<br />Host: " . $_SERVER['HTTP_HOST'];

        wp_mail("info@convergine.com", $subject, $message, $headers);
        ?>
        <div class="updated"><p><strong><?php _e('License validated! Thank you for purchasing our script, we hope you will enjoy it!'); ?></strong></p></div>
        <?php
    } else {
        ?>
        <div class="updated"><p><strong><?php _e($BW_message); ?></strong></p></div>
        <?php
    }
}

$BW_apiKey = BW_getOption("api_key");

if (empty($BW_apiKey)) {
    ?>
    <div class="wrap">
        <?php echo "<h4>" . __('BookingWizz License Key Validation', '') . "</h4>"; ?>
        <p><?php _e("<b>Step 2 of 3</b><br>To finish the installation please enter your valid codecanyon license key and codecanyon username which comes in receipt with your purchase of our script.<br />Don't worry, you will be prompted to do this only once.<br /><br />Please don't forget that for <b>EVERY INSTALLATION</b> of this script you need to get separate license from codecanyon.net (by purchasing our script, each purchase equals to 1 additional license, as stated in <a href='http://codecanyon.net/wiki/support/legal-terms/licensing-terms/' target='_blank'>Envato Licensing Terms</a>) "); ?></p>	

        <form name="ccpt_form" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="BW_script_license" value="yes">

            <p><label style="display: inline-block;width: 120px;"><?php _e("License Key: "); ?></label><input type="text" name="BW_submit_license" value="" size="40"> (original BookingWizz license key)</p>


            <p><label style="display: inline-block;width: 120px;"><?php _e("Username: "); ?></label><input type="text" name="codecanyon_username" value="" size="40"> (exact username of account which purchased BookingWizz)</p>

            <p><label style="display: inline-block;width: 120px;"><?php _e("Authorized Domain: "); ?></label><input type="text" name="BW_domain" value="" size="40"> (domain which will have final license associated with)</p>

            <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Validate License Key') ?>" />
            </p>
        </form>   
    </div>
    <?php
}else{
    $BW_continue = true;
}
?>