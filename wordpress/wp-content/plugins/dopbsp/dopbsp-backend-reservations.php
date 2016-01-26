<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : dopbsp-backend-reservations.php
* File Version            : 1.3
* Created / Last Modified : 21 December 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Reservations Class.
*/

    if (!class_exists("DOPBookingSystemPROBackEndReservations")){
        class DOPBookingSystemPROBackEndReservations extends DOPBookingSystemPROBackEnd{
            private $DOPBSP_templates;
            
            function DOPBookingSystemPROBackEndReservations(){// Constructor.
                add_action('init', array(&$this, 'cleanReservations'));
                
                if ($this->validPage()){
                    $this->DOPBSP_templates = new DOPBSPTemplates();
                }
            }

// Pages            
            function printReservationsPage(){// Prints out the settings page.
                $this->DOPBSP_templates->reservationsList(false);
            }
            
// Reservations            
            function showNewReservations(){ // Get number of pending reservations.
                global $wpdb;
                
                $reservations = $wpdb->get_results('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE calendar_id="'.$_POST['calendar_id'].'" AND status = "pending"');
                echo $wpdb->num_rows;
                
            	die();      
            }
            
            function initReservations(){ // Get calendar settings
                global $wpdb;
                global $DOPBSP_currencies;
                
                $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                
                if ($_POST['view'] == 'calendar'){
                    $data = array('AddtMonthViewText' => DOPBSP_ADD_MONTH_VIEW,
                                  'AdultsLabel' => DOPBSP_RESERVATIONS_NO_ADULTS_LABEL,
                                  'ButtonApproveLabel' => DOPBSP_RESERVATIONS_APPROVE_LABEL,
                                  'ButtonCancelLabel' => DOPBSP_RESERVATIONS_CANCEL_LABEL,
                                  'ButtonCloseLabel' => DOPBSP_RESERVATIONS_CLOSE_LABEL,
                                  'ButtonDeleteLabel' => DOPBSP_RESERVATIONS_DELETE_LABEL,
                                  'ButtonJumpToDayLabel' => DOPBSP_RESERVATIONS_JUMP_TO_DAY_LABEL,
                                  'ButtonRejectLabel' => DOPBSP_RESERVATIONS_REJECT_LABEL,
                                  'CheckInLabel' => DOPBSP_RESERVATIONS_CHECK_IN_LABEL,
                                  'CheckOutLabel' => DOPBSP_RESERVATIONS_CHECK_OUT_LABEL,
                                  'ChildrenLabel' => DOPBSP_RESERVATIONS_NO_CHILDREN_LABEL,
                                  'ClikToEditLabel' => DOPBSP_CLICK_TO_EDIT_LABEL,
                                  'Currency' => $DOPBSP_currencies[(int)$settings->currency-1]['sign'],
                                  'DateCreatedLabel' => DOPBSP_RESERVATIONS_DATE_CREATED_LABEL,
                                  'DateType' => $settings->date_type,
                                  'DayNames' => array(DOPBSP_DAY_SUNDAY, DOPBSP_DAY_MONDAY, DOPBSP_DAY_TUESDAY, DOPBSP_DAY_WEDNESDAY, DOPBSP_DAY_THURSDAY, DOPBSP_DAY_FRIDAY, DOPBSP_DAY_SATURDAY),
                                  'DepositLabel' => DOPBSP_RESERVATIONS_DEPOSIT_PRICE_LABEL,
                                  'DiscountLabel' => DOPBSP_RESERVATIONS_DISCOUNT_PRICE_LABEL,
                                  'DiscountInfoLabel' => DOPBSP_RESERVATIONS_DISCOUNT_PRICE_TEXT,
                                  'FirstDay' => $settings->first_day,
                                  'HourEndLabel' => DOPBSP_RESERVATIONS_END_HOURS_LABEL,
                                  'HoursAMPM' => $settings->hours_ampm,
                                  'HoursEnabled' => $settings->hours_enabled,
                                  'HourStartLabel' => DOPBSP_RESERVATIONS_START_HOURS_LABEL,
                                  'ID' => $_POST['calendar_id'],
                                  'MonthNames' => array(DOPBSP_MONTH_JANUARY, DOPBSP_MONTH_FEBRUARY, DOPBSP_MONTH_MARCH, DOPBSP_MONTH_APRIL, DOPBSP_MONTH_MAY, DOPBSP_MONTH_JUNE, DOPBSP_MONTH_JULY, DOPBSP_MONTH_AUGUST, DOPBSP_MONTH_SEPTEMBER, DOPBSP_MONTH_OCTOBER, DOPBSP_MONTH_NOVEMBER, DOPBSP_MONTH_DECEMBER),
                                  'NextMonthText' => DOPBSP_NEXT_MONTH,
                                  'NoItemsLabel' => DOPBSP_RESERVATIONS_NO_ITEMS_LABEL,
                                  'PaymentMethodArrivalEnabled' => $settings->payment_arrival_enabled,
                                  'PaymentMethodLabel' => DOPBSP_RESERVATIONS_PAYMENT_METHOD_LABEL,
                                  'PaymentMethodPayPalEnabled' => $settings->payment_paypal_enabled,
                                  'PeopleLabel' => DOPBSP_RESERVATIONS_NO_PEOPLE_LABEL,
                                  'PreviousMonthText' => DOPBSP_PREVIOUS_MONTH,
                                  'PriceLabel' => DOPBSP_RESERVATIONS_PRICE_LABEL,
                                  'Reinitialize' => true,
                                  'RemoveMonthViewText' => DOPBSP_REMOVE_MONTH_VIEW,
                                  'StatusApprovedLabel' => DOPBSP_RESERVATIONS_STATUS_APPROVED,
                                  'StatusCanceledLabel' => DOPBSP_RESERVATIONS_STATUS_CANCELED,
                                  'StatusExpiredLabel' => DOPBSP_RESERVATIONS_STATUS_EXPIRED,
                                  'StatusLabel' => DOPBSP_RESERVATIONS_STATUS_LABEL,
                                  'StatusPendingLabel' => DOPBSP_RESERVATIONS_STATUS_PENDING,
                                  'StatusRejectedLabel' => DOPBSP_RESERVATIONS_STATUS_REJECTED,
                                  'TransactionIDLabel' => DOPBSP_RESERVATIONS_PAYMENT_METHOD_PAYPAL_TRANSACTION_ID_LABEL);
                }
                else{
                    $form = $wpdb->get_results('SELECT * FROM '.DOPBSP_Forms_Fields_table.' WHERE form_id="'.$settings->form.'" ORDER BY position');
                    
                    if (!is_network_admin()){
                        $language = get_option('DOPBSP_backend_language_'.wp_get_current_user()->ID);

                        if ($language == ''){
                            $language = DOPBSP_CONFIG_BACKEND_DEFAULT_LANGUAGE;
                            add_option('DOPBSP_backend_language_'.wp_get_current_user()->ID, DOPBSP_CONFIG_BACKEND_DEFAULT_LANGUAGE);
                        }
                    }
                    else{
                        $language = DOPBSP_CONFIG_BACKEND_DEFAULT_LANGUAGE;
                    }
                    
                    $form_fields = array();
                
                    foreach ($form as $field){
                        $translation = json_decode(stripslashes($field->translation));
                        $field->name = $field->translation;
                        $field->translation = $translation->$language;

                        if ($field->type == 'text'){
                            array_push($form_fields, $field);
                        }
                    }
                
                    $data = array('DateType' => $settings->date_type,
                                  'DayNames' => array(DOPBSP_DAY_SUNDAY, DOPBSP_DAY_MONDAY, DOPBSP_DAY_TUESDAY, DOPBSP_DAY_WEDNESDAY, DOPBSP_DAY_THURSDAY, DOPBSP_DAY_FRIDAY, DOPBSP_DAY_SATURDAY),
                                  'DayShortNames' => array(DOPBSP_SHORT_DAY_SUNDAY, DOPBSP_SHORT_DAY_MONDAY, DOPBSP_SHORT_DAY_TUESDAY, DOPBSP_SHORT_DAY_WEDNESDAY, DOPBSP_SHORT_DAY_THURSDAY, DOPBSP_SHORT_DAY_FRIDAY, DOPBSP_SHORT_DAY_SATURDAY),
                                  'FirstDay' => $settings->first_day,
                                  'Form' => $form_fields,
                                  'HoursAMPM' => $settings->hours_ampm,
                                  'HoursEnabled' => $settings->hours_enabled,
                                  'MonthNames' => array(DOPBSP_MONTH_JANUARY, DOPBSP_MONTH_FEBRUARY, DOPBSP_MONTH_MARCH, DOPBSP_MONTH_APRIL, DOPBSP_MONTH_MAY, DOPBSP_MONTH_JUNE, DOPBSP_MONTH_JULY, DOPBSP_MONTH_AUGUST, DOPBSP_MONTH_SEPTEMBER, DOPBSP_MONTH_OCTOBER, DOPBSP_MONTH_NOVEMBER, DOPBSP_MONTH_DECEMBER),
                                  'MonthShortNames' => array(DOPBSP_SHORT_MONTH_JANUARY, DOPBSP_SHORT_MONTH_FEBRUARY, DOPBSP_SHORT_MONTH_MARCH, DOPBSP_SHORT_MONTH_APRIL, DOPBSP_SHORT_MONTH_MAY, DOPBSP_SHORT_MONTH_JUNE, DOPBSP_SHORT_MONTH_JULY, DOPBSP_SHORT_MONTH_AUGUST, DOPBSP_SHORT_MONTH_SEPTEMBER, DOPBSP_SHORT_MONTH_OCTOBER, DOPBSP_SHORT_MONTH_NOVEMBER, DOPBSP_SHORT_MONTH_DECEMBER),
                                  'MultipleDaysSelect' => $settings->multiple_days_select,
                                  'MultipleHoursSelect' => $settings->multiple_hours_select,
                                  'NoReservations' => $wpdb->num_rows,
                                  'PaymentMethodArrivalEnabled' => $settings->payment_arrival_enabled,
                                  'PaymentMethodPayPalEnabled' => $settings->payment_paypal_enabled);
                }
                
                echo json_encode($data);
                
                die();
            }
            
            function initAddReservation(){ // Get calendar settings
                global $wpdb;
                global $DOPBSP_currencies;
                
                $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                $form = $wpdb->get_results('SELECT * FROM '.DOPBSP_Forms_Fields_table.' WHERE form_id="'.$settings->form.'" ORDER BY position');
                    
                if (!is_network_admin()){
                    $language = get_option('DOPBSP_backend_language_'.wp_get_current_user()->ID);

                    if ($language == ''){
                        $language = DOPBSP_CONFIG_BACKEND_DEFAULT_LANGUAGE;
                        add_option('DOPBSP_backend_language_'.wp_get_current_user()->ID, DOPBSP_CONFIG_BACKEND_DEFAULT_LANGUAGE);
                    }
                }
                else{
                    $language = DOPBSP_CONFIG_BACKEND_DEFAULT_LANGUAGE;
                }

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
                              'CheckInLabel' => DOPBSP_ADD_RESERVATION_CHECK_IN_LABEL,
                              'CheckOutLabel' => DOPBSP_ADD_RESERVATION_CHECK_OUT_LABEL,
                              'Currency' => $DOPBSP_currencies[(int)$settings->currency-1]['sign'],
                              'CurrencyCode' => $DOPBSP_currencies[(int)$settings->currency-1]['code'],
                              'DayNames' => array(DOPBSP_DAY_SUNDAY, DOPBSP_DAY_MONDAY, DOPBSP_DAY_TUESDAY, DOPBSP_DAY_WEDNESDAY, DOPBSP_DAY_THURSDAY, DOPBSP_DAY_FRIDAY, DOPBSP_DAY_SATURDAY),
                              'DayShortNames' => array(DOPBSP_SHORT_DAY_SUNDAY, DOPBSP_SHORT_DAY_MONDAY, DOPBSP_SHORT_DAY_TUESDAY, DOPBSP_SHORT_DAY_WEDNESDAY, DOPBSP_SHORT_DAY_THURSDAY, DOPBSP_SHORT_DAY_FRIDAY, DOPBSP_SHORT_DAY_SATURDAY),
                              'DateType' => $settings->date_type,
                              'Deposit' => $settings->deposit,
                              'DepositText' => DOPBSP_ADD_RESERVATION_DEPOSIT_TEXT,
                              'DiscountsNoDays' => $discountsNoDays,
                              'DiscountText' => DOPBSP_ADD_RESERVATION_DISCOUNT_TEXT,
                              'EndHourLabel' => DOPBSP_ADD_RESERVATION_END_HOURS_LABEL,
                              'FirstDay' => $settings->first_day,
                              'Form' => $form,
                              'FormID' => $settings->form,
                              'FormEmailInvalid' => DOPBSP_ADD_RESERVATION_FORM_EMAIL_INVALID,
                              'FormRequired' => DOPBSP_ADD_RESERVATION_FORM_REQUIRED,
                              'HoursAMPM' => $settings->hours_ampm,
                              'HoursEnabled' => $settings->hours_enabled,
                              'HoursDefinitions' => json_decode($settings->hours_definitions),
                              'HoursIntervalEnabled' => $settings->hours_interval_enabled,
                              'ID' => $_POST['calendar_id'],
                              'Language' => $language,
                              'MaxNoChildren' => $settings->max_no_children,
                              'MaxNoPeople' => $settings->max_no_people,
                              'MaxYear' => $settings->max_year,
                              'MaxStay' => $settings->max_stay,
                              'MinNoChildren' => $settings->min_no_children,
                              'MinNoPeople' => $settings->min_no_people,
                              'MinStay' => $settings->min_stay,
                              'MonthNames' => array(DOPBSP_MONTH_JANUARY, DOPBSP_MONTH_FEBRUARY, DOPBSP_MONTH_MARCH, DOPBSP_MONTH_APRIL, DOPBSP_MONTH_MAY, DOPBSP_MONTH_JUNE, DOPBSP_MONTH_JULY, DOPBSP_MONTH_AUGUST, DOPBSP_MONTH_SEPTEMBER, DOPBSP_MONTH_OCTOBER, DOPBSP_MONTH_NOVEMBER, DOPBSP_MONTH_DECEMBER),
                              'MonthShortNames' => array(DOPBSP_SHORT_MONTH_JANUARY, DOPBSP_SHORT_MONTH_FEBRUARY, DOPBSP_SHORT_MONTH_MARCH, DOPBSP_SHORT_MONTH_APRIL, DOPBSP_SHORT_MONTH_MAY, DOPBSP_SHORT_MONTH_JUNE, DOPBSP_SHORT_MONTH_JULY, DOPBSP_SHORT_MONTH_AUGUST, DOPBSP_SHORT_MONTH_SEPTEMBER, DOPBSP_SHORT_MONTH_OCTOBER, DOPBSP_SHORT_MONTH_NOVEMBER, DOPBSP_SHORT_MONTH_DECEMBER),
                              'MorningCheckOut' => $settings->morning_check_out,
                              'MultipleDaysSelect' => $settings->multiple_days_select,
                              'MultipleHoursSelect' => $settings->multiple_hours_select,
                              'NoAdultsLabel' => DOPBSP_ADD_RESERVATION_NO_ADULTS_LABEL,
                              'NoChildrenEnabled' => $settings->no_children_enabled,
                              'NoChildrenLabel' => DOPBSP_ADD_RESERVATION_NO_CHILDREN_LABEL,
                              'NoItemsLabel' => DOPBSP_ADD_RESERVATION_NO_ITEMS_LABEL,
                              'NoItemsEnabled' => $settings->no_items_enabled,
                              'NoPeopleLabel' => DOPBSP_ADD_RESERVATION_NO_PEOPLE_LABEL,
                              'NoPeopleEnabled' => $settings->no_people_enabled,
                              'NoServicesAvailableText' => DOPBSP_ADD_RESERVATION_NO_SERVICES_AVAILABLE,
                              'PaymentArrivalEnabled' => $settings->payment_arrival_enabled,
                              'PaymentArrivalLabel' => DOPBSP_ADD_RESERVATION_PAYMENT_ARRIVAL_LABEL,
                              'PaymentMethodLabel' => DOPBSP_ADD_RESERVATION_PAYMENT_METHOD_LABEL,
                              'PaymentNoneLabel' => DOPBSP_ADD_RESERVATION_PAYMENT_NONE_LABEL,
                              'PaymentPayPalEnabled' => $settings->payment_paypal_enabled,
                              'PaymentPayPalLabel' => DOPBSP_ADD_RESERVATION_PAYMENT_PAYPAL_LABEL,
                              'PaymentPayPalTransactionIDLabel' => DOPBSP_ADD_RESERVATION_PAYMENT_PAYPAL_TRANSACTON_ID_LABEL,
                              'PluginURL' => DOPBSP_Plugin_URL,
                              'StartHourLabel' => DOPBSP_ADD_RESERVATION_START_HOURS_LABEL,
                              'StatusApprovedLabel' => DOPBSP_ADD_RESERVATION_STATUS_APPROVED_LABEL,
                              'StatusLabel' => DOPBSP_ADD_RESERVATION_STATUS_LABEL,
                              'StatusPendingLabel' => DOPBSP_ADD_RESERVATION_STATUS_PENDING_LABEL,
                              'TotalPriceLabel' => DOPBSP_ADD_RESERVATION_TOTAL_PRICE_LABEL);
                
                echo json_encode($data);
                
                die();
            }
            
            function addReservation(){
                if (session_id() == ""){
                    session_start();
                }
                
                if (isset($_POST['calendar_id'])){
                    global $wpdb;
                    
                    $language = get_option('DOPBSP_backend_language_'.wp_get_current_user()->ID);

                    if ($language == ''){
                        $language = DOPBSP_CONFIG_BACKEND_DEFAULT_LANGUAGE;
                        add_option('DOPBSP_backend_language_'.wp_get_current_user()->ID, DOPBSP_CONFIG_BACKEND_DEFAULT_LANGUAGE);
                    }
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
                                                                   'paypal_transaction_id' => $_POST['paypal_transaction_id'],
                                                                   'status' => $_POST['status'],
                                                                   'info' => json_encode($form),
                                                                   'days_hours_history' => json_encode($days_hours_history)));
                    $reservationId = $wpdb->insert_id;
                    
                    $DOPemail = new DOPBookingSystemPROEmail();
                    
                    if ($_POST['status'] == 'pending'){
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
                        
                        $this->approveReservationCalendarChange($reservationId, $settings);
                        
                        $ci = explode('-', $_POST['check_in']);
                        echo $ci[0].'-'.(int)$ci[1];
                    }
                }
                
                echo '';                
                die();
            }
            
            function getCalendarReservations(){ // Search & get reservations in JSON format.
                global $wpdb;
                
                $calendar_id = $_POST['calendar_id'];
                
                $query = 'SELECT * FROM '.DOPBSP_Reservations_table.' WHERE'.($calendar_id != 0 ? ' calendar_id="'.$calendar_id.'"':'');
                $query .= ($calendar_id != 0 ? ' AND':'').' status <> "expired" ORDER BY check_in ASC, start_hour ASC';
                
                $reservations = $wpdb->get_results($query);
                echo json_encode($reservations);
                
            	die();      
            }
            
            function getListReservations(){ // Search & display reservations.
                global $wpdb;              
                $reservationsHTML = array();
                
                $calendar_id = $_POST['calendar_id'];
                $without_calendar = $_POST['without_calendar'] == 'true' ? true:false;
                $start_day = $_POST['start_day'];
                $end_day = $_POST['end_day'];
                $start_hour = $_POST['start_hour'];
                $end_hour = $_POST['end_hour'];
                $status_pending = $_POST['status_pending'] == 'true' ? true:false;
                $status_approved = $_POST['status_approved'] == 'true' ? true:false;
                $status_rejected = $_POST['status_rejected'] == 'true' ? true:false;
                $status_canceled = $_POST['status_canceled'] == 'true' ? true:false;
                $status_expired = $_POST['status_expired'] == 'true' ? true:false;
                $payment_none = $_POST['status_expired'] == 'true' ? true:false;
                $payment_arrival = $_POST['status_expired'] == 'true' ? true:false;
                $payment_paypal = $_POST['status_expired'] == 'true' ? true:false;
                $search = $_POST['search'];
                $search_by = $_POST['search_by'];
                $page = $_POST['page'];
                $no_page = $_POST['no_page'];
                $order = $_POST['order'];
                $order_by = $_POST['order_by'];
                           
                $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$calendar_id.'"');

                $query = 'SELECT * FROM '.DOPBSP_Reservations_table.' WHERE calendar_id="'.$calendar_id.'"';

// Days query
                if ($start_day != ''){
                    if ($end_day != ''){
                        $query .= ' AND (check_in >= "'.$start_day.'" AND check_in <= "'.$end_day.'"';
                    }
                    else{
                        $query .= ' AND (check_in >= "'.$start_day.'"';
                    }
                    
                    if ($end_day != '' && $settings->hours_enabled == 'false' && $settings->multiple_days_select == 'true'){
                        $query .= ' OR check_out >= "'.$start_day.'" AND check_out <= "'.$end_day.'")';
                    }
                    else{
                        $query .= ')';
                    }
                }
                elseif ($end_day != ''){
                    $query .= ' AND check_in <= "'.$end_day.'"';
                }
                
// Hours query
                if ($settings->hours_enabled == 'true'){
                    $query .= ' AND (start_hour >= "'.$start_hour.'" AND start_hour <= "'.$end_hour.'"';
                    
                    if ($settings->multiple_hours_select == 'true'){
                        $query .= ' OR end_hour >= "'.$start_hour.'" AND end_hour <= "'.$end_hour.'")';
                    }
                    else{
                        $query .= ')';
                    }
                    
                }
                
// Status query                
                if ($status_pending || $status_approved || $status_rejected || $status_canceled || $status_expired){
                    $status_init = false;

                    if ($status_pending){
                        $query .= $status_init ? ' OR status = "pending"':' AND (status = "pending"';
                        $status_init = true;
                    }
                    if ($status_approved){
                        $query .= $status_init ? ' OR status = "approved"':' AND (status = "approved"';
                        $status_init = true;
                    }
                    if ($status_rejected){
                        $query .= $status_init ? ' OR status = "rejected"':' AND (status = "rejected"';
                        $status_init = true;
                    }
                    if ($status_canceled){
                        $query .= $status_init ? ' OR status = "canceled"':' AND (status = "canceled"';
                        $status_init = true;
                    }
                    if ($status_expired){
                        $query .= $status_init ? ' OR status = "expired"':' AND (status = "expired"';
                        $status_init = true;
                    }
                    $query .= ')';                    
                }
                else{
                    $query .= ' AND status <> "expired"';
                }

// Payment query       
                if ($payment_none || $payment_arrival || $payment_paypal){
                    $payment_init = false;

                    if ($payment_none){
                        $query .= $payment_init ? ' OR payment_method = 0':' AND (payment_method = 0';
                        $payment_init = true;
                    }
                    if ($payment_arrival){
                        $query .= $payment_init ? ' OR payment_method = 1':' AND (payment_method = 1';
                        $payment_init = true;
                    }
                    if ($payment_paypal){
                        $query .= $payment_init ? ' OR payment_method = 2':' AND (payment_method = 2';
                        $payment_init = true;
                    }
                    $query .= ')';                    
                }

// Search query
                if ($search != ''){
                    switch ($search_by){
                        case 'id':
                            $query .= ' AND id = "'.$search.'"';
                            break;
                        case 'paypal_id':
                            $query .= ' AND paypal_transaction_id = "'.$search.'"';
                            break;
                        default:
                            $query .= ' AND info LIKE \'%'.$search.'%\'';
                    }
                }
                
// Order query
                $query .= ' ORDER BY '.$order_by.' '.$order;
                                
                switch ($order_by){
                    case 'check_in':
                        $query .= ($settings->multiple_days_select == 'true' && $settings->hours_enabled == 'false' ? ', check_out ASC':'').
                                  ($settings->hours_enabled == 'true' ? ', start_hour ASC':'').
                                  ($settings->hours_enabled == 'true' && $settings->multiple_hours_select == 'true' ? ', end_hour ASC':'').
                                  ', date_created ASC'.
                                  ', id ASC';
                        break;
                    case 'check_out':
                        $query .= ', check_in ASC'.
                                  ($settings->hours_enabled == 'true' ? ', start_hour ASC':'').
                                  ($settings->hours_enabled == 'true' && $settings->multiple_hours_select == 'true' ? ', end_hour ASC':'').
                                  ', date_created ASC'.
                                  ', id ASC';
                        break;
                    case 'start_hour':
                        $query .= ', check_in ASC'.
                                  ($settings->multiple_days_select == 'true' && $settings->hours_enabled == 'false' ? ', check_out ASC':'').
                                  ($settings->hours_enabled == 'true' && $settings->multiple_hours_select == 'true' ? ', end_hour ASC':'').
                                  ', date_created ASC'.
                                  ', id ASC';
                        break;
                    case 'end_hour':
                        $query .= ', check_in ASC'.
                                  ($settings->multiple_days_select == 'true' && $settings->hours_enabled == 'false' ? ', check_out ASC':'').
                                  ($settings->hours_enabled == 'true' ? ', start_hour ASC':'').
                                  ', date_created ASC'.
                                  ', id ASC';
                        break;
                    case 'id':
                        $query .= ', check_in ASC'.
                                  ($settings->multiple_days_select == 'true' && $settings->hours_enabled == 'false' ? ', check_out ASC':'').
                                  ($settings->hours_enabled == 'true' ? ', start_hour ASC':'').
                                  ($settings->hours_enabled == 'true' && $settings->multiple_hours_select == 'true' ? ', end_hour ASC':'').
                                  ', date_created ASC';
                        break;
                    case 'date_created':
                        $query .= ', check_in ASC'.
                                  ($settings->multiple_days_select == 'true' && $settings->hours_enabled == 'false' ? ', check_out ASC':'').
                                  ($settings->hours_enabled == 'true' ? ', start_hour ASC':'').
                                  ($settings->hours_enabled == 'true' && $settings->multiple_hours_select == 'true' ? ', end_hour ASC':'').
                                  ', id ASC';
                        break;
                    default:
                        $query .= ', check_in ASC'.
                                  ($settings->multiple_days_select == 'true' && $settings->hours_enabled == 'false' ? ', check_out ASC':'').
                                  ($settings->hours_enabled == 'true' ? ', start_hour ASC':'').
                                  ($settings->hours_enabled == 'true' && $settings->multiple_hours_select == 'true' ? ', end_hour ASC':'').
                                  ', date_created ASC'.
                                  ', id ASC';
                }

                $reservations = $wpdb->get_results($query);
                
                echo $wpdb->num_rows.';;;;;;;;;;;';
                        
// Pagination query
                $query .= ' LIMIT '.(($page-1)*$no_page).', '.$no_page;       
                //echo $query;

// Reservations
                $reservations = $wpdb->get_results($query);
                
                array_push($reservationsHTML, '<ul class="reservations-list">');
                    
                if ($wpdb->num_rows > 0){
                    foreach ($reservations as $reservation){
                        $display_approve_button = false;
                        $display_reject_button = false;
                        $display_cancel_button = false;
                        $display_delete_button = false;
                        
                        switch ($reservation->status){
                            case 'pending':
                                $reservation_status_label = DOPBSP_RESERVATIONS_STATUS_PENDING;
                                $display_approve_button = true;
                                $display_reject_button = true;
                                break;
                            case 'approved':
                                $reservation_status_label = DOPBSP_RESERVATIONS_STATUS_APPROVED;
                                $display_cancel_button = true;
                                break;
                            case 'rejected':
                                $reservation_status_label = DOPBSP_RESERVATIONS_STATUS_REJECTED;
                                $display_approve_button = true;
                                $display_delete_button = true;
                                break;
                            case 'canceled':
                                $reservation_status_label = DOPBSP_RESERVATIONS_STATUS_CANCELED;
                                $display_approve_button = true;
                                $display_delete_button = true;
                                break;
                            default:
                                $reservation_status_label = DOPBSP_RESERVATIONS_STATUS_EXPIRED;
                                $display_delete_button = true;
                        }
                        
                        switch ($reservation->payment_method){
                            case '1':
                                $reservation_payment_method = DOPBSP_RESERVATIONS_FILTERS_PAYMENT_ARRIVAL;
                                break;
                            case '2':
                                $reservation_payment_method = DOPBSP_RESERVATIONS_FILTERS_PAYMENT_PAYPAL;
                                break;
                            default:
                                $reservation_payment_method = DOPBSP_RESERVATIONS_FILTERS_PAYMENT_NONE;
                        }
                        
                        $dc_hour = substr($reservation->date_created, 11, 5);
                        $dc_date = substr($reservation->date_created, 0, 10);
                        $reservation_date_created = $this->dateToFormat($dc_date, $settings->date_type).' '.($settings->hours_ampm == 'true' ? $this->timeToAMPM($dc_hour):$dc_hour);
                
                        array_push($reservationsHTML, '<li id="DOPBSP_Reservation_ID'.$reservation->id.'">');
                        array_push($reservationsHTML, ' <div class="reservation-container">');
                        array_push($reservationsHTML, '     <div class="reservation-header">');
                        array_push($reservationsHTML, '         <div class="flag '.$reservation->status.'"></div>');
                        array_push($reservationsHTML, '         <div class="info-container">');
                        array_push($reservationsHTML, '             <strong>ID: </strong>'.$reservation->id.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
                        array_push($reservationsHTML, '             <strong>'.DOPBSP_RESERVATIONS_STATUS_LABEL.': </strong><span class="info-status '.$reservation->status.'">'.$reservation_status_label.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
                        array_push($reservationsHTML, '             <strong>'.DOPBSP_RESERVATIONS_DATE_CREATED_LABEL.': </strong>'.$reservation_date_created.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
                        array_push($reservationsHTML, '         </div>');
                        array_push($reservationsHTML, '         <div class="buttons-container">');
                        array_push($reservationsHTML, '             <a href="javascript:void(0)" class="button-approve DOPBSP-reservations-approve-button" id="DOPBSP-reservations-approve-button'.$reservation->id.'" style="display: '.($display_approve_button ? 'block':'none').';">'.DOPBSP_RESERVATIONS_APPROVE_LABEL.'</a>');
                        array_push($reservationsHTML, '             <a href="javascript:void(0)" class="button-reject DOPBSP-reservations-reject-button" id="DOPBSP-reservations-reject-button'.$reservation->id.'" style="display: '.($display_reject_button ? 'block':'none').';">'.DOPBSP_RESERVATIONS_REJECT_LABEL.'</a>');
                        array_push($reservationsHTML, '             <a href="javascript:void(0)" class="button-cancel DOPBSP-reservations-cancel-button" id="DOPBSP-reservations-cancel-button'.$reservation->id.'" style="display: '.($display_cancel_button ? 'block':'none').';">'.DOPBSP_RESERVATIONS_CANCEL_LABEL.'</a>');
                        array_push($reservationsHTML, '             <a href="javascript:void(0)" class="button-delete DOPBSP-reservations-delete-button" id="DOPBSP-reservations-delete-button'.$reservation->id.'" style="display: '.($display_delete_button ? 'block':'none').';">'.DOPBSP_RESERVATIONS_DELETE_LABEL.'</a>');
                        
                        if (!$without_calendar){
                            array_push($reservationsHTML, '             <a href="javascript:$jDOPBSP(\'#calendar_jump_to_day\').val(\''.$reservation->check_in.'\')" class="button-jump">'.DOPBSP_RESERVATIONS_JUMP_TO_DAY_LABEL.'</a>');
                        }
                        array_push($reservationsHTML, '         </div>');
                        array_push($reservationsHTML, '         <br class="DOPBSP-clear" />');
                        array_push($reservationsHTML, '     </div>');
                        array_push($reservationsHTML, '     <div class="reservation-content">');
                        
                        // Column 1
                        array_push($reservationsHTML, '         <div class="data-column">');
                        array_push($reservationsHTML, '             <div class="reservation-field">');
                        array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_CHECK_IN_LABEL.'</label>');
                        array_push($reservationsHTML, '                 <div class="value">'.$this->dateToFormat($reservation->check_in, $settings->date_type).'</div>');
                        array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                        array_push($reservationsHTML, '             </div>');
                        
                        if ($reservation->check_out != ''){
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_CHECK_OUT_LABEL.'</label>');
                            array_push($reservationsHTML, '                 <div class="value">'.$this->dateToFormat($reservation->check_out, $settings->date_type).'</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                        }
                        
                        if ($reservation->start_hour != ''){
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_START_HOURS_LABEL.'</label>');
                            array_push($reservationsHTML, '                 <div class="value">'.($settings->hours_ampm == 'true' ? $this->timeToAMPM($reservation->start_hour):$reservation->start_hour).'</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                        }
                        
                        if ($reservation->end_hour != ''){
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_END_HOURS_LABEL.'</label>');
                            array_push($reservationsHTML, '                 <div class="value">'.($settings->hours_ampm == 'true' ? $this->timeToAMPM($reservation->end_hour):$reservation->end_hour).'</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                        }
                        array_push($reservationsHTML, '         </div>');
                        
                        // Column 2
                        array_push($reservationsHTML, '         <div class="data-column">');

                        if ($reservation->payment_method != 0){
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_PAYMENT_METHOD_LABEL.'</label>');
                            array_push($reservationsHTML, '                 <div class="value">'.$reservation_payment_method.'</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                        }

                        if ($reservation->paypal_transaction_id != ''){
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_PAYMENT_METHOD_PAYPAL_TRANSACTION_ID_LABEL.'</label>');
                            array_push($reservationsHTML, '                 <div class="value">'.$reservation->paypal_transaction_id.'</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                        }

                        if ($settings->no_items_enabled == 'true'){
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_NO_ITEMS_LABEL.'</label>');
                            array_push($reservationsHTML, '                 <div class="value">'.$reservation->no_items.'</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                        }

                        if ($reservation->price != 0){
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_PRICE_LABEL.'</label>');
                            array_push($reservationsHTML, '                 <div class="value">'.$reservation->currency.$this->getWithDecimals($reservation->price).'</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                        }

                        if ($reservation->deposit != 0){
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_DEPOSIT_PRICE_LABEL.'</label>');
                            array_push($reservationsHTML, '                 <div class="value">'.$reservation->currency.$this->getWithDecimals($reservation->deposit).' ('.$settings->deposit.'%)</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_DEPOSIT_PRICE_LEFT_LABEL.'</label>');
                            array_push($reservationsHTML, '                 <div class="value">'.$reservation->currency.$this->getWithDecimals($reservation->price-$reservation->deposit).'</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                        }

                        if ($reservation->total_price != 0 && $reservation->total_price != $reservation->price){
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_DISCOUNT_PRICE_LABEL.'</label>');
                            array_push($reservationsHTML, '                 <div class="value"><span class="cut">'.$reservation->currency.$this->getWithDecimals($reservation->total_price).'</span> ('.$reservation->discount.'% '.DOPBSP_RESERVATIONS_DISCOUNT_PRICE_TEXT.')</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                        }
                        array_push($reservationsHTML, '         </div>');
                        
                        // Column 3
                        array_push($reservationsHTML, '         <div class="data-column">');
                        
                        if ($reservation->info != ''){
                            $info = json_decode($reservation->info);

                            foreach ($info as $item){
                                array_push($reservationsHTML, '             <div class="reservation-field">');
                                array_push($reservationsHTML, '                 <label>'.$item->name.'</label>');
                                array_push($reservationsHTML, '                 <div class="value">');

                                if (is_array($item->value)){
                                    $j = 0;

                                    foreach ($item->value as $value){
                                        $j++;

                                        if ($j == 1){
                                            array_push($reservationsHTML, ($this->validEmail($value->translation) ? '<a href="mailto:'.$value->translation.'">'.$value->translation.'</a>':$value->translation));
                                        }
                                        else{
                                            array_push($reservationsHTML, ', '.($this->validEmail($item->translation) ? '<a href="mailto:'.$value->translation.'">'.$value->translation.'</a>':$value->translation));
                                        }
                                    }
                                }
                                else{
                                    if ($item->value == 'true'){
                                        $value = DOPBSP_BOOKING_FORM_CHECKED;
                                    }
                                    elseif ($item->value == 'false'){
                                        $value = DOPBSP_BOOKING_FORM_UNCHECKED;
                                    }
                                    else{
                                        $value = $item->value;
                                    }
                                    array_push($reservationsHTML, ($this->validEmail($item->value) ? '<a href="mailto:'.$item->value.'">'.$item->value.'</a>':$value));
                                }
                                array_push($reservationsHTML, '                 </div>');
                                array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                                array_push($reservationsHTML, '             </div>');
                            }
                        }

                        if ($reservation->no_people != '' && $reservation->no_people != 0){
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.($reservation->no_children == '' ? DOPBSP_RESERVATIONS_NO_PEOPLE_LABEL:DOPBSP_RESERVATIONS_NO_ADULTS_LABEL).'</label>');
                            array_push($reservationsHTML, '                 <div class="value">'.$reservation->no_people.'</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                        }

                        if ($reservation->no_children != '' && $reservation->no_children != 0){
                            array_push($reservationsHTML, '             <div class="reservation-field">');
                            array_push($reservationsHTML, '                 <label>'.DOPBSP_RESERVATIONS_NO_CHILDREN_LABEL.'</label>');
                            array_push($reservationsHTML, '                 <div class="value">'.$reservation->no_children.'</div>');
                            array_push($reservationsHTML, '                 <br class="DOPBSP-clear" />');
                            array_push($reservationsHTML, '             </div>');
                        }
                        array_push($reservationsHTML, '         </div>');
                        array_push($reservationsHTML, '         <br class="DOPBSP-clear" />');
                        array_push($reservationsHTML, '     </div>');
                        array_push($reservationsHTML, ' </div>');
                        array_push($reservationsHTML, '</li>');
                    }
                }
                else{
                    array_push($reservationsHTML, '<li class="no-data">'.DOPBSP_NO_RESERVATIONS.'</li>');
                }
                array_push($reservationsHTML, '</ul>');
                
                echo implode("\n", $reservationsHTML);
                
            	die();      
            }
            
            function approveReservation(){ // Approve reservation.
                if (isset($_POST['reservation_id'])){
                    global $wpdb;
                    
                    // =========================================================
                    
                    $DOPemail = new DOPBookingSystemPROEmail();
                    $reservationId = $_POST['reservation_id'];
                    
                    $wpdb->update(DOPBSP_Reservations_table, array('status' => 'approved'), array('id' => $reservationId));
                                        
                    $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                    $reservation = $wpdb->get_row('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE id="'.$reservationId.'"');
                    
                    $DOPemail->sendMessage('booking_approved',
                                           $reservation->language,
                                           $_POST['calendar_id'], 
                                           $reservationId,
                                           $reservation->check_in,
                                           $reservation->check_out,
                                           $reservation->start_hour,
                                           $reservation->end_hour,
                                           $reservation->no_items,
                                           $reservation->currency,
                                           $reservation->price,
                                           $reservation->deposit,
                                           $reservation->total_price,
                                           $reservation->discount,
                                           json_decode($reservation->info),
                                           $reservation->no_people,
                                           $reservation->no_children,
                                           $reservation->email,
                                           false,
                                           true);
                    
                    $this->approveReservationCalendarChange($reservationId, $settings);
                    
                    $ci = explode('-', $reservation->check_in);
                    echo $ci[0].'-'.(int)$ci[1];
                    
                    die();
                }
            }
            
            function rejectReservation(){ // Reject reservation.
                if (isset($_POST['reservation_id'])){
                    global $wpdb;

                    $wpdb->update(DOPBSP_Reservations_table, array('status' => 'rejected'), array('id' => $_POST['reservation_id']));
                    $DOPemail = new DOPBookingSystemPROEmail();
                    $reservationId = $_POST['reservation_id'];
                                        
                    $reservation = $wpdb->get_row('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE id="'.$_POST['reservation_id'].'"');
                    
                    $DOPemail->sendMessage('booking_rejected',
                                           $reservation->language,
                                           $_POST['calendar_id'], 
                                           $reservationId,
                                           $reservation->check_in,
                                           $reservation->check_out,
                                           $reservation->start_hour,
                                           $reservation->end_hour,
                                           $reservation->no_items,
                                           $reservation->currency,
                                           $reservation->price,
                                           $reservation->deposit,
                                           $reservation->total_price,
                                           $reservation->discount,
                                           json_decode($reservation->info),
                                           $reservation->no_people,
                                           $reservation->no_children,
                                           $reservation->email,
                                           false,
                                           true);
                    echo '';
                    die();
                }
            }
            
            function cancelReservation(){ // Cancel reservation.
                if (isset($_POST['reservation_id'])){
                    global $wpdb;
                    
                    $DOPemail = new DOPBookingSystemPROEmail();
                    $reservationId = $_POST['reservation_id'];
                    
                    $wpdb->update(DOPBSP_Reservations_table, array('status' => 'canceled'), array('id' => $reservationId));
                                        
                    $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$_POST['calendar_id'].'"');
                    $reservation = $wpdb->get_row('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE id="'.$reservationId.'"');
                    
                    $DOPemail->sendMessage('booking_canceled',
                                           $reservation->language,
                                           $_POST['calendar_id'], 
                                           $reservationId,
                                           $reservation->check_in,
                                           $reservation->check_out,
                                           $reservation->start_hour,
                                           $reservation->end_hour,
                                           $reservation->no_items,
                                           $reservation->currency,
                                           $reservation->price,
                                           $reservation->deposit,
                                           $reservation->total_price,
                                           $reservation->discount,
                                           json_decode($reservation->info),
                                           $reservation->no_people,
                                           $reservation->no_children,
                                           $reservation->email,
                                           false,
                                           true);
                    
                    $this->cancelReservationCalendarChange($reservationId, $settings);
                    
                    echo '';
                    die();
                }
            }
            
            function deleteReservation(){ // Delete reservation.
                if (isset($_POST['reservation_id'])){
                    global $wpdb;
                    
                    $wpdb->query('DELETE FROM '.DOPBSP_Reservations_table.' WHERE id="'.$_POST['reservation_id'].'"');
                    
                    echo '';
                    die();
                }
            }
            
            function approveReservationCalendarChange($reservationId, $settings){ // Change schedule when reservation is approved.
                global $wpdb;
                
                $reservation = $wpdb->get_row('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE id="'.$reservationId.'"');
                $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$reservation->calendar_id.'"');
                   
                if ($reservation->check_out == ''){
                    $day = $wpdb->get_row('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$reservation->calendar_id.'" AND day="'.$reservation->check_in.'"');
                }
                else{
                    if ($settings->morning_check_out == 'true'){
                        $days = $wpdb->get_results('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$reservation->calendar_id.'" AND day>="'.$reservation->check_in.'" AND day<"'.$reservation->check_out.'"');
                    }
                    else{
                        $days = $wpdb->get_results('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$reservation->calendar_id.'" AND day>="'.$reservation->check_in.'" AND day<="'.$reservation->check_out.'"');
                    }
                }

                if ($reservation->check_out == '' && $reservation->start_hour == ''){ 
                    $data = json_decode($day->data);

                    if ($data->available == '' || (int)$data->available < 1){
                        $available = 1;
                    }
                    else{
                        $available = $data->available;
                    }

                    if ($available-$reservation->no_items == 0){
                        $data->price = '';
                        $data->promo = '';
                        $data->status = 'booked';
                    }

                    $data->available = $available-$reservation->no_items;

                    $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                'day' => $day->day));
                }
                else if ($reservation->check_out != ''){                 
                    foreach ($days as $key => $day){
                        $data = json_decode($day->data);

                        if ($data->available == '' || (int)$data->available < 1){
                            $available = 1;
                        }
                        else{
                            $available = $data->available;
                        }

                        if ($available-$reservation->no_items == 0){
                            $data->price = '';
                            $data->promo = '';
                            $data->status = 'booked';
                        }

                        $data->available = $available-$reservation->no_items;

                        $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                    'day' => $day->day));
                    }
                }
                else if ($reservation->start_hour != '' && $reservation->end_hour == ''){ 
                    $data = json_decode($day->data);
                    $start_hour = $reservation->start_hour;
                    $hour = $data->hours->$start_hour;

                    if ($hour->available == '' || (int)$hour->available < 1){
                        $available = 1;
                    }
                    else{
                        $available = (int)$hour->available;
                    }

                    if ($available-$reservation->no_items == 0){
                        $hour->price = '';
                        $hour->promo = '';
                        $hour->status = 'booked';
                    }

                    $hour->available = $available-$reservation->no_items;

                    $data->hours->$start_hour = $hour;
                    $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                'day' => $day->day));
                    if ($settings->details_from_hours == 'true'){
                        $this->setDayFromHours($reservation->calendar_id, $day->day);
                    }
                }
                else if ($reservation->end_hour != ''){
                    $data = json_decode($day->data);

                    foreach ($data->hours as $key => $item){
                        if ($reservation->start_hour <= $key &&
                                ((($settings->last_hour_to_total_price == 'false' || $settings->hours_interval_enabled == 'true') && $key < $reservation->end_hour) || 
                                ($settings->last_hour_to_total_price == 'true' && $settings->hours_interval_enabled == 'false' && $key <= $reservation->end_hour))){
                            $hour = $data->hours->$key;

                            if ($hour->available == '' || (int)$hour->available < 1){
                                $available = 1;
                            }
                            else{
                                $available = (int)$hour->available;
                            }

                            if ($available-$reservation->no_items == 0){
                                $hour->price = '';
                                $hour->promo = '';
                                $hour->status = 'booked';
                            }

                            $hour->available = $available-$reservation->no_items;

                            $data->hours->$key = $hour;
                        }
                    }

                    $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                'day' => $day->day));
                    if ($settings->details_from_hours == 'true'){
                        $this->setDayFromHours($reservation->calendar_id, $day->day);
                    }
                }
            }
            
            function cancelReservationCalendarChange($reservationId, $settings){ // Change schedule when reservation is canceled.
                global $wpdb;
                
                $reservation = $wpdb->get_row('SELECT * FROM '.DOPBSP_Reservations_table.' WHERE id="'.$reservationId.'"');
                $settings = $wpdb->get_row('SELECT * FROM '.DOPBSP_Settings_table.' WHERE calendar_id="'.$reservation->calendar_id.'"');
                $history = json_decode($reservation->days_hours_history);    
                
                if ($reservation->check_out == ''){
                    $day = $wpdb->get_row('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$reservation->calendar_id.'" AND day="'.$reservation->check_in.'"');
                }
                else{
                    if ($settings->morning_check_out == 'true'){
                        $days = $wpdb->get_results('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$reservation->calendar_id.'" AND day>="'.$reservation->check_in.'" AND day<"'.$reservation->check_out.'"');
                    }
                    else{
                        $days = $wpdb->get_results('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$reservation->calendar_id.'" AND day>="'.$reservation->check_in.'" AND day<="'.$reservation->check_out.'"');
                    }
                }
                
                if ($reservation->check_out == '' && $reservation->start_hour == ''){ 
                    $data = json_decode($day->data);
                    $day_date = $day->day;
                    
                    if ($data->status == 'booked'){
                        $data->available = $history->$day_date->available == '' ? '':$data->available+$reservation->no_items;
                        $data->bind = $history->$day_date->bind;
                        $data->price = $history->$day_date->price;
                        $data->promo = $history->$day_date->promo;
                        $data->status = $history->$day_date->status;
                    }
                    else{
                        if ($data->available != ''){
                            $data->available = $data->available+$reservation->no_items;
                        }
                    }
                    $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                'day' => $day_date));
                }
                else if ($reservation->check_out != ''){                 
                    foreach ($days as $key => $day){
                        $data = json_decode($day->data);
                        $day_date = $day->day;

                        if ($data->status == 'booked'){
                            $data->available = $history->$day_date->available == '' ? '':$data->available+$reservation->no_items;
                            $data->bind = $history->$day_date->bind;
                            $data->price = $history->$day_date->price;
                            $data->promo = $history->$day_date->promo;
                            $data->status = $history->$day_date->status;
                        }
                        else{
                            if ($data->available != ''){
                                $data->available = $data->available+$reservation->no_items;
                            }
                        }
                        $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                    'day' => $day_date));
                    }
                }
                else if ($reservation->start_hour != '' && $reservation->end_hour == ''){
                    $data = json_decode($day->data);
                    $hour_time = $reservation->start_hour;
                    $hour = $data->hours->$hour_time;
                    
                    if ($hour->status == 'booked'){
                        $hour->available = $history->$hour_time->available == '' ? '':$hour->available+$reservation->no_items;
                        $hour->bind = $history->$hour_time->bind;
                        $hour->price = $history->$hour_time->price;
                        $hour->promo = $history->$hour_time->promo;
                        $hour->status = $history->$hour_time->status;
                    }
                    else{
                        if ($hour->available != ''){
                            $hour->available = $hour->available+$reservation->no_items;
                        }
                    }

                    $data->hours->$hour_time = $hour;
                    
                    $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                'day' => $day->day));
                    if ($settings->details_from_hours == 'true'){
                        $this->setDayFromHours($reservation->calendar_id, $day->day);
                    }
                }
                else if ($reservation->end_hour != ''){
                    $data = json_decode($day->data);

                    foreach ($data->hours as $key => $item){
                        if ($reservation->start_hour <= $key &&
                                ((($settings->last_hour_to_total_price == 'false' || $settings->hours_interval_enabled == 'true') && $key < $reservation->end_hour) || 
                                ($settings->last_hour_to_total_price == 'true' && $settings->hours_interval_enabled == 'false' && $key <= $reservation->end_hour))){
                            $hour_time = $key;
                            $hour = $data->hours->$hour_time;

                            if ($hour->status == 'booked'){
                                $hour->available = $history->$hour_time->available == '' ? '':$hour->available+$reservation->no_items;
                                $hour->bind = $history->$hour_time->bind;
                                $hour->price = $history->$hour_time->price;
                                $hour->promo = $history->$hour_time->promo;
                                $hour->status = $history->$hour_time->status;
                            }
                            else{
                                if ($hour->available != ''){
                                    $hour->available = $hour->available+$reservation->no_items;
                                }
                            }

                            $data->hours->$hour_time = $hour;
                        }

                        $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $reservation->calendar_id, 
                                                                                                    'day' => $day->day));
                        if ($settings->details_from_hours == 'true'){
                            $this->setDayFromHours($reservation->calendar_id, $day->day);
                        }
                    }
                }
            }
            
            function setDayFromHours($calendar_id, $day){ // Set day data from hours data.
                global $wpdb;
                
                $day_data = $wpdb->get_row('SELECT * FROM '.DOPBSP_Days_table.' WHERE calendar_id="'.$calendar_id.'" AND day="'.$day.'"');
                $data = json_decode($day_data->data);
                
                $available = 0;
                $price = '';
                $status = 'none';

                foreach ($data->hours as $hour){
                    // No Available Check
                    if ($hour->bind == 0 || $hour->bind == 1){
                        if ($hour->available != ''){
                            $available += $hour->available;
                        }

                        // Price Check
                        if ($hour->price != '' && ($price == '' || (float)$hour->price < $price)){
                            $price = (float)$hour->price;
                        }

                        if ($hour->promo != '' && ($price == '' || (float)$hour->promo < $price)){
                            $price = (float)$hour->promo;
                        }

                        //  Status Check
                        if ($hour->status == 'unavailable' && $status == 'none'){
                            $status = 'unavailable';
                        }

                        if ($hour->status == 'booked' && ($status == 'none' || $status == 'unavailable')){
                            $status = 'booked';
                        }

                        if ($hour->status == 'special' && ($status == 'none' || $status == 'unavailable' || $status == 'booked')){
                            $status = 'special';
                        }

                        if ($hour->status == 'available'){
                            $status = 'available';
                        }
                    }
                }
                
                $data->available = $available == 0 ? '':$available;
                $data->price = $price;
                $data->status = $status;
                
                $wpdb->update(DOPBSP_Days_table, array('data' => json_encode($data)), array('calendar_id' => $calendar_id, 
                                                                                            'day' => $day));
            }
            
            function cleanReservations(){ // Set reservations status to expired if Check Out day has passed.
                global $wpdb;
                
                $wpdb->query('UPDATE '.DOPBSP_Reservations_table.' SET status="expired" WHERE status <> "expired" AND ((check_out < \''.date('Y-m-d').'\' AND check_out <> \'\') OR (check_in < \''.date('Y-m-d').'\' AND check_out = \'\'))');
            }
        }
    }