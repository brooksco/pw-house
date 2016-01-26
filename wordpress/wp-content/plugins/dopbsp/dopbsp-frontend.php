<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2,0
* File                    : dopbsp-frontend.php
* File Version            : 2.0
* Created / Last Modified : 25 December 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Front End Class.
*/

    if (session_id() == ""){
        session_start();
    }

    if (!class_exists("DOPBookingSystemPROFrontEnd")){
        class DOPBookingSystemPROFrontEnd{
            function DOPBookingSystemPROFrontEnd(){// Constructor.
                add_action('wp_enqueue_scripts', array(&$this, 'addScripts'));
                
                add_action('init', array(&$this, 'init'));
                add_action('init', array(&$this, 'initCustomPostsType'));
                
                if (DOPBSP_CONFIG_CUSTOM_POST_OVERWRITE_POSTS_LOOP){
                    add_filter('pre_get_posts', array(&$this, 'getCustomPosts')); // Get custom Post
                }
                add_filter('the_content', array(&$this, 'addBookingSystemPROInCustomPosts')); // Add calendar in dopbsp posts
            }
            
            function addScripts(){
                wp_register_script('DOPBSP_DOPBookingSystemPROJS', plugins_url('assets/js/jquery.dop.FrontendBookingSystemPRO.js', __FILE__), array('jquery'), false, true);

                // Enqueue JavaScript.
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                
                if (!wp_script_is('jquery-ui-datepicker', 'queue')){
                    wp_enqueue_script('jquery-ui-datepicker');
                }
                wp_enqueue_script('DOPBSP_DOPBookingSystemPROJS');
            }

            function init(){// Init Booking System.
                $this->initConstants();
                add_shortcode('dopbsp', array(&$this, 'calendarShortcode'));
            }

            function initConstants(){// Constants init.
                global $wpdb;
                
                // Translation Table
                if (!defined('DOPBSP_Translation_table')){
                    define('DOPBSP_Translation_table', $wpdb->prefix.'dopbsp_translation');
                }
                
                // Settings Table
                if (!defined('DOPBSP_Settings_table')){
                    define('DOPBSP_Settings_table', $wpdb->prefix.'dopbsp_settings');
                }
                
                // Calendars Table
                if (!defined('DOPBSP_Calendars_table')){
                    define('DOPBSP_Calendars_table', $wpdb->prefix.'dopbsp_calendars');
                }
                
                // Days Table
                if (!defined('DOPBSP_Days_table')){
                    define('DOPBSP_Days_table', $wpdb->prefix.'dopbsp_days');
                }
                
                // Users Table
                if (!defined('DOPBSP_Reservations_table')){
                    define('DOPBSP_Reservations_table', $wpdb->prefix.'dopbsp_reservations');
                }
                
                // Users Table
                if (!defined('DOPBSP_Users_table')){
                    define('DOPBSP_Users_table', $wpdb->prefix.'dopbsp_users');
                }
                
                // Booking Forms Tables
                if (!defined('DOPBSP_Forms_table')){
                    define('DOPBSP_Forms_table', $wpdb->prefix.'dopbsp_forms');
                }
                
                if (!defined('DOPBSP_Forms_Fields_table')){
                    define('DOPBSP_Forms_Fields_table', $wpdb->prefix.'dopbsp_forms_fields');
                }
                
                if (!defined('DOPBSP_Forms_Select_Options_table')){
                    define('DOPBSP_Forms_Select_Options_table', $wpdb->prefix.'dopbsp_forms_select_options');
                }
                
                // WooCommerce Table
                if (!defined('DOPBSP_WooCommerce_table')){
                    define('DOPBSP_WooCommerce_table', $wpdb->prefix.'dopbsp_woocommerce');
                }
            }

            function calendarShortcode($atts){// Read Shortcodes.
                extract(shortcode_atts(array(
                    'class' => 'dopbsp',
                ), $atts));
                                
                if (!array_key_exists('id', $atts)){
                    $atts['id'] = 1;
                }
                                
                if (!array_key_exists('lang', $atts)){
                    $atts['lang'] = DOPBSP_CONFIG_FRONTEND_DEFAULT_LANGUAGE;
                }
                                
                if (!array_key_exists('woocommerce', $atts)){
                    $atts['woocommerce'] = 'false';
                }
                
                $id = $atts['id'];
                $language = $atts['lang'];
                //$woocommerce = $atts['woocommerce'];
                
                $_SESSION['DOPBookingSystemPROFrontEndLanguage'.$id] = $language;
                $data = array();
                
                //************************************************************** Hook - Add action before calendar init.
                do_action('dopbsp_frontend_before_calendar_init');
                
                //************************************************************** Hook - Add content before calendar.
                ob_start();
                    do_action('dopbsp_frontend_content_before_calendar');
                    $dopbsp_frontend_before_calendar = ob_get_contents();
                ob_end_clean();
                array_push($data, $dopbsp_frontend_before_calendar);
                
                // Calendar code.
                array_push($data, '<link rel="stylesheet" type="text/css" href="'.plugins_url('templates/'.$this->getCalendarTemplate($id).'/css/jquery-ui-1.8.21.customDatepicker.css', __FILE__).'" />');
                array_push($data, '<link rel="stylesheet" type="text/css" href="'.plugins_url('templates/'.$this->getCalendarTemplate($id).'/css/jquery.dop.FrontendBookingSystemPRO.css', __FILE__).'" />');
                
                array_push($data, '<script type="text/JavaScript">');
                array_push($data, '    jQuery(document).ready(function(){');
                array_push($data, '        jQuery("#DOPBookingSystemPRO'.$id.'").DOPBookingSystemPRO('.$this->getCalendarSettings($atts).');');
                array_push($data, '    });');
                array_push($data, '</script>');
                
                array_push($data, '<div class="DOPBookingSystemPROContainer" id="DOPBookingSystemPRO'.$id.'"><a href="'.admin_url('admin-ajax.php').'"></a></div>');
                
                
                //************************************************************** Hook - Add content after calendar.
                ob_start();
                    do_action('dopbsp_frontend_content_after_calendar');
                    $dopbsp_frontend_after_calendar = ob_get_contents();
                ob_end_clean();
                array_push($data, $dopbsp_frontend_after_calendar);
                
                return implode("\n", $data);
            }
 
            function getCalendarTemplate($id){// Get Gallery Info.
                global $wpdb;                
                $settings = $wpdb->get_row('SELECT template FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$id.'"');
                
                return $settings->template;
            }

            function getCalendarSettings($atts){// Get Gallery Info.
                global $wpdb;
                global $DOPBSP_pluginSeries_translation;
                global $DOPBSP_currencies;
                $data = array();
                
                $id = $atts['id'];
                $language = $atts['lang'];
                $woocommerce = $atts['woocommerce'];
                
                $DOPBSP_pluginSeries_translation->setTranslation('frontend', $language);
                
                $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$id.'"');
                $form = $wpdb->get_results('SELECT * FROM '.DOPBSP_Forms_Fields_table.' WHERE form_id="'.$settings->form.'" ORDER BY position');
                
                foreach ($form as $field){
                    $translation = json_decode(stripslashes($field->translation));
                    $field->translation = $translation->$language;
                    
                    if ($field->type == 'select'){
                        $options = $wpdb->get_results('SELECT * FROM '.DOPBSP_Forms_Select_Options_table.' WHERE field_id='.$field->id.' ORDER BY field_id ASC');
                        
                        foreach ($options as $option){
                            $option_translation = json_decode(stripslashes($option->translation));
                            $option->translation = $option_translation->$language;
                        }
                        $field->options = $options;
                    }
                }
                
                $discountsNoDays = explode(',', $settings->discounts_no_days);
                
                for ($i=0; $i<count($discountsNoDays); $i++){
                    $discountsNoDays[$i] = (float)$discountsNoDays[$i];
                }
                
                $data = array('AddLastHourToTotalPrice' => $settings->last_hour_to_total_price,
                              'AddtMonthViewText' => DOPBSP_ADD_MONTH_VIEW,
                              'AvailableDays' => explode(',', $settings->available_days),
                              'AvailableOneText' => DOPBSP_AVAILABLE_ONE_TEXT,
                              'AvailableText' => DOPBSP_AVAILABLE_TEXT,
                              'BookedText' => DOPBSP_BOOKED_TEXT,
                              'BookNowLabel' => DOPBSP_BOOK_NOW_LABEL,
                              'CheckInLabel' => DOPBSP_CHECK_IN_LABEL,
                              'CheckOutLabel' => DOPBSP_CHECK_OUT_LABEL,
                              'Currency' => $DOPBSP_currencies[(int)$settings->currency-1]['sign'],
                              'CurrencyCode' => $DOPBSP_currencies[(int)$settings->currency-1]['code'],
                              'DayNames' => array(DOPBSP_DAY_SUNDAY, DOPBSP_DAY_MONDAY, DOPBSP_DAY_TUESDAY, DOPBSP_DAY_WEDNESDAY, DOPBSP_DAY_THURSDAY, DOPBSP_DAY_FRIDAY, DOPBSP_DAY_SATURDAY),
                              'DayShortNames' => array(DOPBSP_SHORT_DAY_SUNDAY, DOPBSP_SHORT_DAY_MONDAY, DOPBSP_SHORT_DAY_TUESDAY, DOPBSP_SHORT_DAY_WEDNESDAY, DOPBSP_SHORT_DAY_THURSDAY, DOPBSP_SHORT_DAY_FRIDAY, DOPBSP_SHORT_DAY_SATURDAY),
                              'DateType' => $settings->date_type,
                              'Deposit' => $settings->deposit,
                              'DepositText' => DOPBSP_DEPOSIT_TEXT,
                              'DiscountsNoDays' => $discountsNoDays,
                              'DiscountText' => DOPBSP_DISCOUNT_TEXT,
                              'EndHourLabel' => DOPBSP_END_HOURS_LABEL,
                              'FirstDay' => $settings->first_day,
                              'Form' => $form,
                              'FormID' => $settings->form,
                              'FormEmailInvalid' => DOPBSP_FORM_EMAIL_INVALID,
                              'FormRequired' => DOPBSP_FORM_REQUIRED,
                              'FormTitle' => DOPBSP_FORM_TITLE,
                              'HoursAMPM' => $settings->hours_ampm,
                              'HoursEnabled' => $settings->hours_enabled,
                              'HoursDefinitions' => json_decode($settings->hours_definitions),
                              'HoursInfoEnabled' => $settings->hours_info_enabled,
                              'HoursIntervalEnabled' => $settings->hours_interval_enabled,
                              'ID' => $id,
                              'Language' => $language,
                              'MaxNoChildren' => $settings->max_no_children,
                              'MaxNoPeople' => $settings->max_no_people,
                              'MaxYear' => $settings->max_year,
                              'MaxStay' => $settings->max_stay,
                              'MaxStayWarning' => DOPBSP_MAX_STAY_WARNING,
                              'MinNoChildren' => $settings->min_no_children,
                              'MinNoPeople' => $settings->min_no_people,
                              'MinStay' => $settings->min_stay,
                              'MinStayWarning' => DOPBSP_MIN_STAY_WARNING,
                              'MonthNames' => array(DOPBSP_MONTH_JANUARY, DOPBSP_MONTH_FEBRUARY, DOPBSP_MONTH_MARCH, DOPBSP_MONTH_APRIL, DOPBSP_MONTH_MAY, DOPBSP_MONTH_JUNE, DOPBSP_MONTH_JULY, DOPBSP_MONTH_AUGUST, DOPBSP_MONTH_SEPTEMBER, DOPBSP_MONTH_OCTOBER, DOPBSP_MONTH_NOVEMBER, DOPBSP_MONTH_DECEMBER),
                              'MonthShortNames' => array(DOPBSP_SHORT_MONTH_JANUARY, DOPBSP_SHORT_MONTH_FEBRUARY, DOPBSP_SHORT_MONTH_MARCH, DOPBSP_SHORT_MONTH_APRIL, DOPBSP_SHORT_MONTH_MAY, DOPBSP_SHORT_MONTH_JUNE, DOPBSP_SHORT_MONTH_JULY, DOPBSP_SHORT_MONTH_AUGUST, DOPBSP_SHORT_MONTH_SEPTEMBER, DOPBSP_SHORT_MONTH_OCTOBER, DOPBSP_SHORT_MONTH_NOVEMBER, DOPBSP_SHORT_MONTH_DECEMBER),
                              'MorningCheckOut' => $settings->morning_check_out,
                              'MultipleDaysSelect' => $settings->multiple_days_select,
                              'MultipleHoursSelect' => $settings->multiple_hours_select,
                              'NextMonthText' => DOPBSP_NEXT_MONTH,
                              'NoAdultsLabel' => DOPBSP_NO_ADULTS_LABEL,
                              'NoChildrenEnabled' => $settings->no_children_enabled,
                              'NoChildrenLabel' => DOPBSP_NO_CHILDREN_LABEL,
                              'NoItemsLabel' => DOPBSP_NO_ITEMS_LABEL,
                              'NoItemsEnabled' => $settings->no_items_enabled,
                              'NoPeopleLabel' => DOPBSP_NO_PEOPLE_LABEL,
                              'NoPeopleEnabled' => $settings->no_people_enabled,
                              'NoServicesAvailableText' => DOPBSP_NO_SERVICES_AVAILABLE,
                              'PaymentArrivalEnabled' => $settings->payment_arrival_enabled,
                              'PaymentArrivalLabel' => $settings->instant_booking == 'true' ? DOPBSP_PAYMENT_ARRIVAL_LABEL:DOPBSP_PAYMENT_ARRIVAL_WITH_APPROVAL_LABEL,
                              'PaymentArrivalSuccess' => DOPBSP_PAYMENT_ARRIVAL_SUCCESS,
                              'PaymentArrivalSuccessInstantBooking' => DOPBSP_PAYMENT_ARRIVAL_SUCCESS_INSTANT_BOOKING,
                              'PaymentPayPalEnabled' => $settings->payment_paypal_enabled,
                              'PaymentPayPalLabel' => DOPBSP_PAYMENT_PAYPAL_LABEL,
                              'PaymentPayPalSuccess' => DOPBSP_PAYMENT_PAYPAL_SUCCESS,
                              'PaymentPayPalError' => DOPBSP_PAYMENT_PAYPAL_ERROR,
                              'PluginURL' => DOPBSP_Plugin_URL,
                              'PreviousMonthText' => DOPBSP_PREVIOUS_MONTH,
                              'RemoveMonthViewText' => DOPBSP_REMOVE_MONTH_VIEW,
                              'ServicesLabel' => DOPBSP_SERVICES_LABEL,
                              'StartHourLabel' => DOPBSP_START_HOURS_LABEL,
                              'TotalPriceLabel' => DOPBSP_TOTAL_PRICE_LABEL,
                              'TermsAndConditionsEnabled' => $settings->terms_and_conditions_enabled,
                              'TermsAndConditionsInvalid' => DOPBSP_TERMS_AND_CONDITIONS_INVALID,
                              'TermsAndConditionsLabel' => DOPBSP_TERMS_AND_CONDITIONS_LABEL,
                              'TermsAndConditionsLink' => $settings->terms_and_conditions_link,
                              'UnavailableText' => DOPBSP_UNAVAILABLE_TEXT,
                              'ViewOnly' => $settings->view_only,
                              'WooCommerceEnabled' => $woocommerce,
                              'WooCommerceAddToCartLabel' => DOPBSP_WOOCOMMERCE_ADD_TO_CART_LABEL,
                              'WooCommerceAddToCartSuccess' => DOPBSP_WOOCOMMERCE_ADD_TO_CART_SUCCESS);
                
                return json_encode($data);
            }
            
            function loadSchedule(){// Load Calendar Data.
                if (isset($_POST['calendar_id'])){
                    global $wpdb;
                    $schedule = array();
                    
                    $days = $wpdb->get_results('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                    
                    foreach ($days as $day):
                        $schedule[$day->day] = $day->data;
                    endforeach;
                    
                    if (count($schedule) > 0){
                        echo json_encode($schedule);
                    }
                    else{
                        echo '';
                    }
                    
                    //********************************************************** Hook - Add action after calendar init.
                    do_action('dopbsp_frontend_after_calendar_init');

                    die();
                }
            }
            
            function bookRequest(){
                if (session_id() == ""){
                    session_start();
                }
                
                if (isset($_POST['calendar_id'])){
                    global $wpdb;
                    
                    //********************************************************** Hook - Add action before booking request.
                    do_action('dopbsp_frontend_before_booking');
                    
                    $language = isset($_SESSION['DOPBookingSystemPROFrontEndLanguage'.$_POST['calendar_id']]) ? $_SESSION['DOPBookingSystemPROFrontEndLanguage'.$_POST['calendar_id']]:DOPBSP_CONFIG_FRONTEND_DEFAULT_LANGUAGE;
                    $form = $_POST['form'];
                    $days_hours_history = $_POST['days_hours_history'];
                    
                    $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                    
                    $wpdb->insert(DOPBSP_Reservations_table, array('calendar_id' => $_POST['calendar_id'],
                                                                   'check_in' => $_POST['check_in'],
                                                                   'check_out' => $_POST['check_out'],
                                                                   'start_hour' => $_POST['start_hour'],
                                                                   'end_hour' => $_POST['end_hour'],
                                                                   'no_items' => $_POST['no_items'],
                                                                   'currency' => $_POST['currency'],
                                                                   'currency_code' => $_POST['currency_code'],
                                                                   'total_price' => $_POST['total_price'],
                                                                   'discount' => $_POST['discount'],
                                                                   'price' => $_POST['price'],
                                                                   'deposit' => $_POST['deposit'],
                                                                   'language' => $language,
                                                                   'email' => $_POST['email'],
                                                                   'no_people' => $_POST['no_people'],
                                                                   'no_children' => $_POST['no_children'],
                                                                   'payment_method' => $_POST['payment_method'],
                                                                   'status' => $settings->instant_booking == 'false' ? 'pending':'approved',
                                                                   'info' => json_encode($form),
                                                                   'days_hours_history' => json_encode($days_hours_history)));
                    $reservationId = $wpdb->insert_id;
                    
                    $DOPemail = new DOPBookingSystemPROEmail();
                    
                    if ($settings->instant_booking == 'false'){
                        $DOPemail->sendMessage('booking_without_approval',
                                               $language,
                                               $_POST['calendar_id'], 
                                               $reservationId,
                                               $_POST['check_in'],
                                               $_POST['check_out'],
                                               $_POST['start_hour'],
                                               $_POST['end_hour'],
                                               $_POST['no_items'],
                                               $_POST['currency'],
                                               $_POST['price'],
                                               $_POST['deposit'],
                                               $_POST['total_price'],
                                               $_POST['discount'],
                                               $form,
                                               $_POST['no_people'],
                                               $_POST['no_children'],
                                               $_POST['email'],
                                               true,
                                               true);
                    }
                    else{
                        $DOPemail->sendMessage('booking_with_approval',
                                               $language,
                                               $_POST['calendar_id'], 
                                               $reservationId,
                                               $_POST['check_in'],
                                               $_POST['check_out'],
                                               $_POST['start_hour'],
                                               $_POST['end_hour'],
                                               $_POST['no_items'],
                                               $_POST['currency'],
                                               $_POST['price'],
                                               $_POST['deposit'],
                                               $_POST['total_price'],
                                               $_POST['discount'],
                                               $form,
                                               $_POST['no_people'],
                                               $_POST['no_children'],
                                               $_POST['email'],
                                               true,
                                               true);
                        
                        $DOPreservations = new DOPBookingSystemPROBackEndReservations();
                        $DOPreservations->approveReservationCalendarChange($reservationId, $settings);
                        
                        $ci = explode('-', $_POST['check_in']);
                        echo $ci[0].'-'.(int)$ci[1];
                    }
                    //********************************************************** Hook - Add action after booking request.
                    do_action('dopbsp_frontend_after_booking');
                }
                
                echo '';                
                die();
            }
            
            function paypalCheck(){
                if (session_id() == ""){
                    session_start();
                }
                
                if (isset($_POST['calendar_id']) && isset($_SESSION['DOPBSP_PayPal'.$_POST['calendar_id']])){
                    $status = $_SESSION['DOPBSP_PayPal'.$_POST['calendar_id']];
                    $_SESSION['DOPBSP_PayPal'.$_POST['calendar_id']] = '';
                    
                    switch ($status){
                        case 'success':
                            //************************************************** Hook - Add action after PayPal success.
                            do_action('dopbsp_frontend_after_paypal_success');
                            break;
                        case 'error':
                            //************************************************** Hook - Add action after PayPal error.
                            do_action('dopbsp_frontend_after_paypal_error');
                            break;
                    }
                    
                    echo $status;                    
                }
                else{
                    echo 'no';
                }               
            }
            
// Custom Post Type      
            function initCustomPostsType(){ // Init Custom Post Type in Front End
                $postdata = array('exclude_from_search' => false,
                                  'has_archive' => true,
                                  'menu_icon' => plugins_url('assets/gui/images/custom-post-type-icon.png', __FILE__),
                                  'public' => true,
                                  'publicly_queryable' => true,
                                  'rewrite' => true,
                                  'taxonomies' => array('category', 'post_tag'),
                                  'show_in_nav_menus' => true,
                                  'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions'));
                register_post_type(DOPBSP_CONFIG_CUSTOM_POST_SLUG, $postdata);
            }
            
            function getCustomPosts($query){ // Get Custom Post
                if ((is_home() && $query->is_main_query())){
                    $not_allowed_post_types = explode(',', DOPBSP_CONFIG_CUSTOM_POST_NOT_ALLOWED_POST_TYPES_IN_LOOP);
                    $post_types = array();
                    $curr_post_types = get_post_types();

                    foreach ($curr_post_types as $post_type){
                        if (!in_array($post_type, $not_allowed_post_types)){
                            array_push($post_types, $post_type);
                        }
                    }	

                    array_push($post_types, DOPBSP_CONFIG_CUSTOM_POST_SLUG);
                    $query->set('post_type', $post_types);
                }
                        
                return $query;
            }
            
            function addBookingSystemPROInCustomPosts($content){ // Add calendar in dopbsp posts
                global $wpdb;
                $post_type = get_post_type();
                
                if ($post_type == DOPBSP_CONFIG_CUSTOM_POST_SLUG){
                    $custom_content = $content;
                    
                    $calendar = $wpdb->get_results('SELECT * FROM '.DOPBSP_Calendars_table.' WHERE post_id="'.get_the_ID().'" ORDER BY id');

                    if (isset($calendar[0]->id)){
                        $custom_content .= do_shortcode('[dopbsp id="'.$calendar[0]->id.'"]');
                    }
                    return $custom_content;
                }
                else{
                    return $content;
                }
            }

        }
    }