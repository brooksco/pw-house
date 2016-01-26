<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : dopbsp-backend-woocommerce.php
* File Version            : 1.1
* Created / Last Modified : 21 December 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Back End WooCommerce Class.
*/

    if (!class_exists("DOPBookingSystemPROBackEndWooCommerce")){
        class DOPBookingSystemPROBackEndWooCommerce extends DOPBookingSystemPROBackEnd{
            function DOPBookingSystemPROBackEndWooCommerce(){// Constructor.
                // Actions
                add_action('woocommerce_product_write_panel_tabs', array(&$this, 'addTab')); // Add tab.
                add_action('woocommerce_product_write_panels', array(&$this, 'showTab')); // Show options.
                add_action('woocommerce_process_product_meta', array(&$this, 'saveTab')); // Save options.
                add_action('woocommerce_before_calculate_totals', array(&$this, 'updateCartPrice')); // Update cart price.
                add_action('woocommerce_order_status_on-hold', array(&$this, 'book')); // Add reservetions to Booking System after payment has been completed.
                add_action('woocommerce_payment_complete', array(&$this, 'book')); // Add reservetions to Booking System after payment has been completed.
                
                // Filters
                add_filter('woocommerce_get_item_data', array(&$this, 'updateCartInfo'), 10, 2); // Update bookings info in cart.
            }
            
// Back End Tab.            
            function addTab(){ // Add tab.
                echo '<li class="dopbsp_tab"><a href="#dopbsp_tab_data">'.DOPBSP_WOOCOMMERCE.'</a></li>';
            }
            
            function showTab(){ // Show options.
                global $post;
	
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($post->ID, 'dopbsp_woocommerce_calendar', true),
                                                    'language' => get_post_meta($post->ID, 'dopbsp_woocommerce_language', true) == '' ? 'en':get_post_meta($post->ID, 'dopbsp_woocommerce_language', true),
                                                    'position' => get_post_meta($post->ID, 'dopbsp_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'dopbsp_woocommerce_position', true));
	
?>
    <div id="dopbsp_tab_data" class="panel woocommerce_options_panel">
        <div class="options_group">
            <p class="form-field">
                <?php woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_calendar',
                                                  'options' => $this->getCalendars(),
                                                  'label' => DOPBSP_WOOCOMMERCE_TAB_CALENDAR_LABEL,
                                                  'description' => DOPBSP_WOOCOMMERCE_TAB_CALENDAR_HELP)); ?>
                <?php woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_language',
                                                  'options' => $this->getLanguages(),
                                                  'label' => DOPBSP_WOOCOMMERCE_TAB_LANGUAGE_LABEL,
                                                  'description' => DOPBSP_WOOCOMMERCE_TAB_LANGUAGE_HELP,
                                                  'value' => $dopbsp_woocommerce_options['language'])); ?>
                <?php woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_position',
                                                  'options' => array('summary' => DOPBSP_WOOCOMMERCE_TAB_POSITION_SUMMARY,
                                                                     'tabs' => DOPBSP_WOOCOMMERCE_TAB_POSITION_TABS,
                                                                     'summary-tabs' => DOPBSP_WOOCOMMERCE_TAB_POSITION_SUMMARY_AND_TABS),
                                                  'label' => DOPBSP_WOOCOMMERCE_TAB_POSITION_LABEL,
                                                  'description' => DOPBSP_WOOCOMMERCE_TAB_POSITION_HELP,
                                                  'value' => $dopbsp_woocommerce_options['position'])); ?>
            </p>
        </div>	
    </div>
<?php
            }
            
            function saveTab($post_id){ // Save options.
                update_post_meta($post_id, 'dopbsp_woocommerce_calendar', $_POST['dopbsp_woocommerce_calendar']);
                update_post_meta($post_id, 'dopbsp_woocommerce_language', $_POST['dopbsp_woocommerce_language']);
                update_post_meta($post_id, 'dopbsp_woocommerce_position', $_POST['dopbsp_woocommerce_position']);
            }
            
            function getCalendars(){// Show Calendars List.
                global $wpdb;
                                    
                $calendars_options = array();
                $no_calendars = 0;
                $calendars_options[0] = '- '.DOPBSP_WOOCOMMERCE_TAB_NO_CALENDAR.' -';
                
                if ($this->administratorHasPermissions(wp_get_current_user()->ID)){
                    $calendars = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' ORDER BY id');
                    $no_calendars = $wpdb->num_rows;

                }
                else{
                    if ($this->userHasPermissions(wp_get_current_user()->ID)){
                        $calendars = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE user_id="'.wp_get_current_user()->ID.'" ORDER BY id');
                    }

                    if ($this->userCalendarsIds(wp_get_current_user()->ID)){
                        $calendarsIds = explode(',', $this->userCalendarsIds(wp_get_current_user()->ID));
                        $calendarlist = '';
                        $calendars_found = array();
                        $i=0;

                        foreach($calendarsIds as $calendarId){
                            if ($calendarId){
                                if ($i < 1){
                                    $calendarlist .= $calendarId;
                                }
                                else{
                                  $calendarlist .= ", ".$calendarId;  
                                }

                                array_push($calendars_found, $calendarId);
                                $i++;
                            }
                        }

                        if ($calendarlist){
                           $calendars_assigned = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE id IN ('.$calendarlist.') ORDER BY id');   
                        }
                    }
                    else{
                        $calendars_assigned = $calendars;
                    }
                }
                
                if ($no_calendars != 0 || (isset($calendars_assigned) && count($calendars_assigned) != 0)){
                    if ($calendars){
                        foreach ($calendars as $calendar){
                            if (isset($calendars_found)){
                                if (!in_array($calendar->id, $calendars_found)){
                                    $calendars_options[$calendar->id] = 'ID '.$calendar->id.': '.$calendar->name;
                                }
                            }
                            
                            if($this->administratorHasPermissions(wp_get_current_user()->ID)){
                                $calendars_options[$calendar->id] = 'ID '.$calendar->id.': '.$calendar->name;
                            }
                        }
                    }
                    
                    if (isset($calendars_assigned)){
                        foreach ($calendars_assigned as $calendar){
                            $calendars_options[$calendar->id] = 'ID '.$calendar->id.': '.$calendar->name;
                        }
                    }
                   
                }
                
                return $calendars_options;
            }
            
            function getLanguages(){ // Get languages.
                $languages_options = array('af' => 'Afrikaans (Afrikaans)',
                                           'al' => 'Albanian (Shqiptar)',
                                           'ar' => 'Arabic (>العربية)',
                                           'az' => 'Azerbaijani (Azərbaycan)',
                                           'bs' => 'Basque (Euskal)',
                                           'by' => 'Belarusian (Беларускай)',
                                           'bg' => 'Bulgarian (Български)',
                                           'ca' => 'Catalan (Català)',
                                           'cn' => 'Chinese (中国的)',
                                           'cr' => 'Croatian (Hrvatski)',
                                           'cz' => 'Czech (Český)',
                                           'dk' => 'Danish (Dansk)',
                                           'du' => 'Dutch (Nederlands)',
                                           'en' => 'English',
                                           'eo' => 'Esperanto (Esperanto)',
                                           'et' => 'Estonian (Eesti)',
                                           'fl' => 'Filipino (na Filipino)',
                                           'fi' => 'Finnish (Suomi)',
                                           'fr' => 'French (Français)',
                                           'gl' => 'Galician (Galego)',
                                           'de' => 'German (Deutsch)',
                                           'gr' => 'Greek (Ɛλληνικά)',
                                           'ha' => 'Haitian Creole (Kreyòl Ayisyen)',
                                           'he' => 'Hebrew (עברית)',
                                           'hi' => 'Hindi (हिंदी)',
                                           'hu' => 'Hungarian (Magyar)',
                                           'is' => 'Icelandic (Íslenska)',
                                           'id' => 'Indonesian (Indonesia)',
                                           'ir' => 'Irish (Gaeilge)',
                                           'it' => 'Italian (Italiano)',
                                           'ja' => 'Japanese (日本の)',
                                           'ko' => 'Korean (한국의)',            
                                           'lv' => 'Latvian (Latvijas)',
                                           'lt' => 'Lithuanian (Lietuvos)',            
                                           'mk' => 'Macedonian (македонски)',
                                           'mg' => 'Malay (Melayu)',
                                           'ma' => 'Maltese (Maltija)',
                                           'no' => 'Norwegian (Norske)',            
                                           'pe' => 'Persian (فارسی)',
                                           'pl' => 'Polish (Polski)',
                                           'pt' => 'Portuguese (Português)',
                                           'ro' => 'Romanian (Română)',
                                           'ru' => 'Russian (Pусский)',
                                           'sr' => 'Serbian (Cрпски)',
                                           'sk' => 'Slovak (Slovenských)',
                                           'sl' => 'Slovenian (Slovenski)',
                                           'sp' => 'Spanish (Español)',
                                           'sw' => 'Swahili (Kiswahili)',
                                           'se' => 'Swedish (Svenskt)',
                                           'th' => 'Thai (ภาษาไทย)',
                                           'tr' => 'Turkish (Türk)',
                                           'uk' => 'Ukrainian (Український)',
                                           'ur' => 'Urdu (اردو)',
                                           'vi' => 'Vietnamese (Việt)',
                                           'we' => 'Welsh (Cymraeg)',
                                           'yi' => 'Yiddish (ייִדיש)');
                return $languages_options;
            }
            
// Cart actions.            
            function updateCartPrice(){ // Update cart price.
                global $wpdb;
		global $woocommerce;
                
                $cart = $woocommerce->cart->cart_contents;
                
                foreach ($cart as $key => $cart_item){
                    $result = $wpdb->get_row('SELECT * FROM '.DOPBSP_WooCommerce_table.' WHERE cart_key="'.$key.'"');
                    
                    if ($result){
                        $data = json_decode($result->data);
                        $cart_item['data']->price = $data->price;
                        $cart_item['data']->dopbsp = $data;
                    }
                }
            }

            function updateCartInfo($other_data, $cart_item){ // Update bookings info in cart.
                global $DOPBSP_pluginSeries_translation;
                
                if (isset($cart_item['data']->dopbsp)){
                    $data = $cart_item['data']->dopbsp;
                    $DOPBSP_pluginSeries_translation->setTranslation('frontend', $data->language);

                    $other_data[] = array('name' =>  DOPBSP_CHECK_IN_LABEL,
                                          'value' => $data->check_in);

                    if ($data->check_out != ''){
                        $other_data[] = array('name' =>  DOPBSP_CHECK_OUT_LABEL,
                                              'value' => $data->check_out);
                    }

                    if ($data->start_hour != ''){
                        $other_data[] = array('name' =>  DOPBSP_START_HOURS_LABEL,
                                              'value' => $data->start_hour);
                    }

                    if ($data->end_hour != ''){
                        $other_data[] = array('name' =>  DOPBSP_END_HOURS_LABEL,
                                              'value' => $data->end_hour);
                    }

                    if ((int)$data->no_items > 1){
                        $other_data[] = array('name' =>  DOPBSP_NO_ITEMS_LABEL,
                                              'value' => $data->no_items);
                    }
                }
                
                return $other_data;
            }

            function book(){ // Add reservetions to Booking System after payment has been completed.
                global $wpdb;
                global $woocommerce;
                
                $cart = $woocommerce->cart->cart_contents;
                
                foreach ($cart as $key => $cart_item){
                    $result = $wpdb->get_row('SELECT * FROM '.DOPBSP_WooCommerce_table.' WHERE cart_key="'.$key.'"');
                    
                    if ($result){
                        $data = json_decode($result->data);
                        
//                                                                                                    'language' => $language,
//                                                                                                    'product_id' => $product_id,
//                                                                                                    'calendar_id' => $calendar_id,
//                                                                                                    'check_in' => $check_in,
//                                                                                                    'check_out' => $check_out,
//                                                                                                    'start_hour' => $start_hour,
//                                                                                                    'end_hour' => $end_hour,
//                                                                                                    'no_items' => $no_items,
//                                                                                                    'currency' => $currency,
//                                                                                                    'currency_code' => $currency_code,
//                                                                                                    'total_price' => $total_price,
//                                                                                                    'discount' => $discount,
//                                                                                                    'price' => $price,
//                                                                                                    'deposit' => $deposit,
//                                                                                                    'days_hours_history' => $days_hours_history

                        $wpdb->insert(DOPBSP_Reservations_table, array('calendar_id' => $data->calendar_id,
                                                                       'check_in' => $data->check_in,
                                                                       'check_out' => $data->check_out,
                                                                       'start_hour' => $data->start_hour,
                                                                       'end_hour' => $data->end_hour,
                                                                       'no_items' => $data->no_items,
                                                                       'currency' => $data->currency,
                                                                       'currency_code' => $data->currency_code,
                                                                       'total_price' => $data->total_price,
                                                                       'discount' => $data->discount,
                                                                       'price' => $data->price,
                                                                       'deposit' => $data->deposit,
                                                                       'language' => $data->language,
                                                                       'email' => '',
                                                                       'no_people' => '',
                                                                       'no_children' => '',
                                                                       'payment_method' => 'woo',
                                                                       'status' => 'approved',
                                                                       'info' => '',
                                                                       'days_hours_history' => json_encode($data->days_hours_history)));
                        $reservationId = $wpdb->insert_id;

                        $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');

                        $DOPreservations = new DOPBookingSystemPROBackEndReservations();
                        $DOPreservations->approveReservationCalendarChange($reservationId, $settings);
                        
                        $wpdb->delete(DOPBSP_WooCommerce_table, array('cart_key' => $key));
                    }
                }
            }     
        }
    }