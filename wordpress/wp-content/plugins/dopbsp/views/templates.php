<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : templates.php
* File Version            : 2.0
* Created / Last Modified : 27 December 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Templates Class.
*/

    if (!class_exists("DOPBSPTemplates")){
        class DOPBSPTemplates{
            function DOPBSPTemplates(){// Constructor.
            }
            
// Templates            
            function calendarsList(){// Return Template              
                if (class_exists("DOPBookingSystemPROBackEnd")){
                    $DOPBSP_pluginSeries = new DOPBookingSystemPROBackEnd();
                }
                $this->returnTranslations();
?>            
    <div class="wrap DOPBSP-admin">
<!-- Header -->
        <?php $this->returnHeader(DOPBSP_TITLE); ?>
        <input type="hidden" name="calendar_id" id="calendar_id" value="" />
        <input type="hidden" name="calendar_jump_to_day" id="calendar_jump_to_day" value="" />
        <input type="hidden" name="calendar_refresh" id="calendar_refresh" value="" />
<!-- Content -->        
        <div class="main">
            
            <div class="column column1">
                <div class="column-header">
<?php 
                if (isset($_GET['page']) && $DOPBSP_pluginSeries->userHasPermissions(wp_get_current_user()->ID)){ 
?>                  

                        <div class="add-button" id="DOPBSP-add-calendar-btn">
                            <a href="javascript:dopbspAddCalendar()" title="<?php echo DOPBSP_ADD_CALENDAR_SUBMIT?>"></a>
                        </div>

                        <a href="javascript:void()" class="header-help"><span><?php echo DOPBSP_CALENDARS_HELP?>"</span></a>
<?php
                }
                else{
?>           
                        <a href="javascript:void()" class="header-help"><span><?php echo DOPBSP_CALENDARS_NO_ADD_HELP?>"</span></a>
<?php
                }
?>                               
                </div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="column-separator"></div>
            <div class="column column2">
                <div class="column-header"></div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="column-separator"></div>
            <div class="column column3">
                <div class="column-header"></div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <br class="DOPBSP-clear" />
        </div>
    </div>       
<?php
                $this->reservationsList();
            }
            
            function reservationsList($show_with_calendar = true){// Return Reservation Template
                if (class_exists("DOPBookingSystemPROBackEnd") && !$show_with_calendar){
                    $DOPBSP_pluginSeries = new DOPBookingSystemPROBackEnd();
                }
                $this->returnTranslations();
?>            
    <div class="wrap DOPBSP-admin" id="DOPBSP-admin-reservations"<?php echo $show_with_calendar ? ' style="display: none;"':'' ?>>
<!-- Header -->
        <?php $this->returnReservationsHeader(($show_with_calendar ? '':DOPBSP_TITLE.' - ').DOPBSP_TITLE_RESERVATIONS, $show_with_calendar); ?>
<!-- Content -->   
        <div class="main">
            <div class="reservations-header">
<?php 
                if (!$show_with_calendar){
?>
                    <div class="reservation-filter" id="DOPBSP-reservations-calendars-filter">
                        <div class="title"><?php echo DOPBSP_RESERVATIONS_FILTERS_CALENDAR?></div>
                        <div class="filters">
                            <select name="calendar_id" id="calendar_id" class="big" onchange="dopbspShowReservations()">
                                <?php echo $DOPBSP_pluginSeries->showReservationsCalendars()?>
                            </select>
                            <input type="hidden" name="DOPBSP-reservations-without-calendar" id="DOPBSP-reservations-without-calendar" value="true" />
                        </div>
                        <a href="javascript:void()" class="help">
                            <span><?php echo DOPBSP_RESERVATIONS_FILTERS_CALENDAR_HELP?></span>
                        </a>
                        <br class="DOPBSP-clear" />
                    </div>
<?php
                }
?>
                <div class="reservation-filter" id="DOPBSP-reservations-actions-filter">
                    <div class="title"><?php echo DOPBSP_RESERVATIONS_ACTIONS?></div>
                    <div class="filters">
                        <input type="button" name="DOPBSP-add-reservation" id="DOPBSP-add-reservation" class="submit-style" value="<?php echo DOPBSP_RESERVATIONS_ACTIONS_ADD; ?>" onclick="dopbspInitAddReservation()" />
                        <input type="button" name="DOPBSP-reset-reservations-filter" id="DOPBSP-reset-reservations-filter" class="submit-style" value="<?php echo DOPBSP_RESERVATIONS_ACTIONS_RESET; ?>" />
                        <input type="button" name="DOPBSP-submit-reservation" id="DOPBSP-submit-reservation" class="submit-style" value="<?php echo DOPBSP_RESERVATIONS_ACTIONS_SUBMIT; ?>" onclick="" />
                        <input type="button" name="DOPBSP-back-reservation" id="DOPBSP-back-reservation" class="submit-style" value="<?php echo DOPBSP_RESERVATIONS_ACTIONS_BACK; ?>" onclick="dopbspInitReservations()" />
                    </div>
                    <a href="javascript:void()" class="help">
                        <span><?php echo DOPBSP_RESERVATIONS_ACTIONS_HELP?></span>
                    </a>
                    <br class="DOPBSP-clear" />
                </div>
                <div class="reservation-filter" id="DOPBSP-reservations-view-filter">
                    <div class="title"><?php echo DOPBSP_RESERVATIONS_FILTERS_VIEW?></div>
                    <div class="filters">
                        <select name="DOPBSP-reservations-view" id="DOPBSP-reservations-view" onchange="dopbspInitReservations()">
                            <option value="calendar"><?php echo DOPBSP_RESERVATIONS_FILTERS_VIEW_CALENDAR?></option>
                            <option value="list" selected="selected"><?php echo DOPBSP_RESERVATIONS_FILTERS_VIEW_LIST?></option>
                        </select>
                    </div>
                    <a href="javascript:void()" class="help">
                        <span><?php echo DOPBSP_RESERVATIONS_FILTERS_VIEW_HELP?></span>
                    </a>
                    <br class="DOPBSP-clear" />
                </div>
                <div class="reservation-filter" id="DOPBSP-reservations-period-filter">
                    <div class="title"><?php echo DOPBSP_RESERVATIONS_FILTERS_PERIOD?></div>
                    <div class="filters">
                        <label id="DOPBSP-reservations-start-day-label" for="DOPBSP-reservations-start-day"><?php echo DOPBSP_RESERVATIONS_FILTERS_START_DAY?></label>
                        <input type="text" name="DOPBSP-reservations-start-day" id="DOPBSP-reservations-start-day" val="" />
                        <input type="hidden" name="DOPBSP-reservations-start-day-alt" id="DOPBSP-reservations-start-day-alt" val="" />
                        <label id="DOPBSP-reservations-end-day-label" for="DOPBSP-reservations-end-day"><?php echo DOPBSP_RESERVATIONS_FILTERS_END_DAY?></label>
                        <input type="text" name="DOPBSP-reservations-end-day" id="DOPBSP-reservations-end-day" val="" />
                        <input type="hidden" name="DOPBSP-reservations-end-day-alt" id="DOPBSP-reservations-end-day-alt" val="" />
                        <label id="DOPBSP-reservations-start-hour-label" for="DOPBSP-reservations-start-hour"><?php echo DOPBSP_RESERVATIONS_FILTERS_START_HOUR?></label>
                        <select name="DOPBSP-reservations-start-hour" id="DOPBSP-reservations-start-hour" class="small">
                            <option value="00:00">00:00</option>
                            <option value="01:00">01:00</option>
                            <option value="02:00">02:00</option>
                            <option value="03:00">03:00</option>
                            <option value="04:00">04:00</option>
                            <option value="05:00">05:00</option>
                            <option value="06:00">06:00</option>
                            <option value="07:00">07:00</option>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="12:00">12:00</option>
                            <option value="13:00">13:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                            <option value="20:00">20:00</option>
                            <option value="21:00">21:00</option>
                            <option value="22:00">22:00</option>
                            <option value="23:00">23:00</option>
                            <option value="24:00">24:00</option>
                        </select>
                        <label id="DOPBSP-reservations-end-hour-label" for="DOPBSP-reservations-end-hour"><?php echo DOPBSP_RESERVATIONS_FILTERS_END_HOUR?></label>
                        <select name="DOPBSP-reservations-end-hour" id="DOPBSP-reservations-end-hour" class="small">
                            <option value="00:00">00:00</option>
                            <option value="01:00">01:00</option>
                            <option value="02:00">02:00</option>
                            <option value="03:00">03:00</option>
                            <option value="04:00">04:00</option>
                            <option value="05:00">05:00</option>
                            <option value="06:00">06:00</option>
                            <option value="07:00">07:00</option>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="12:00">12:00</option>
                            <option value="13:00">13:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                            <option value="20:00">20:00</option>
                            <option value="21:00">21:00</option>
                            <option value="22:00">22:00</option>
                            <option value="23:00">23:00</option>
                            <option value="24:00">24:00</option>
                        </select>
                    </div>
                    <a href="javascript:void()" class="help">
                        <span><?php echo DOPBSP_RESERVATIONS_FILTERS_PERIOD_HELP?></span>
                    </a>
                    <br class="DOPBSP-clear" />
                </div>
                <div class="reservation-filter" id="DOPBSP-reservations-status-filter">
                    <div class="title"><?php echo DOPBSP_RESERVATIONS_FILTERS_STATUS?></div>
                    <div class="filters">
                        <input type="checkbox" name="DOPBSP-reservations-pending" id="DOPBSP-reservations-pending" />
                        <label class="checkbox" id="DOPBSP-reservations-pending-label" for="DOPBSP-reservations-pending"><?php echo DOPBSP_RESERVATIONS_FILTERS_STATUS_PENDING?></label>
                        <input type="checkbox" name="DOPBSP-reservations-approved" id="DOPBSP-reservations-approved" />
                        <label class="checkbox" id="DOPBSP-reservations-approved-label" for="DOPBSP-reservations-approved"><?php echo DOPBSP_RESERVATIONS_FILTERS_STATUS_APPROVED?></label>
                        <input type="checkbox" name="DOPBSP-reservations-rejected" id="DOPBSP-reservations-rejected" />
                        <label class="checkbox" id="DOPBSP-reservations-rejected-label" for="DOPBSP-reservations-rejected"><?php echo DOPBSP_RESERVATIONS_FILTERS_STATUS_REJECTED?></label>
                        <input type="checkbox" name="DOPBSP-reservations-canceled" id="DOPBSP-reservations-canceled" />
                        <label class="checkbox" id="DOPBSP-reservations-canceled-label" for="DOPBSP-reservations-canceled"><?php echo DOPBSP_RESERVATIONS_FILTERS_STATUS_CANCELED?></label>
                        <input type="checkbox" name="DOPBSP-reservations-expired" id="DOPBSP-reservations-expired" />
                        <label class="checkbox" id="DOPBSP-reservations-expired-label" for="DOPBSP-reservations-expired"><?php echo DOPBSP_RESERVATIONS_FILTERS_STATUS_EXPIRED?></label>
                    </div>
                    <a href="javascript:void()" class="help type2">
                        <span><?php echo DOPBSP_RESERVATIONS_FILTERS_STATUS_HELP?></span>
                    </a>
                    <br class="DOPBSP-clear" />
                </div>
                <div class="reservation-filter" id="DOPBSP-reservations-payment-filter">
                    <div class="title"><?php echo DOPBSP_RESERVATIONS_FILTERS_PAYMENT?></div>
                    <div class="filters">
                        <input type="checkbox" name="DOPBSP-reservations-payment-none" id="DOPBSP-reservations-payment-none" />
                        <label class="checkbox" id="DOPBSP-reservations-payment-none-label" for="DOPBSP-reservations-payment-none"><?php echo DOPBSP_RESERVATIONS_FILTERS_PAYMENT_NONE?></label>
                        <input type="checkbox" name="DOPBSP-reservations-payment-arrival" id="DOPBSP-reservations-payment-arrival" />
                        <label class="checkbox" id="DOPBSP-reservations-payment-arrival-label" for="DOPBSP-reservations-payment-arrival"><?php echo DOPBSP_RESERVATIONS_FILTERS_PAYMENT_ARRIVAL?></label>
                        <input type="checkbox" name="DOPBSP-reservations-payment-paypal" id="DOPBSP-reservations-payment-paypal" />
                        <label class="checkbox" id="DOPBSP-reservations-payment-paypal-label" for="DOPBSP-reservations-payment-paypal"><?php echo DOPBSP_RESERVATIONS_FILTERS_PAYMENT_PAYPAL?></label>                        
                    </div>
                    <a href="javascript:void()" class="help type2">
                        <span><?php echo DOPBSP_RESERVATIONS_FILTERS_PAYMENT_HELP?></span>
                    </a>
                    <br class="DOPBSP-clear" />
                </div>
                <div class="reservation-filter" id="DOPBSP-reservations-search-filter">
                    <div class="title"><?php echo DOPBSP_RESERVATIONS_FILTERS_SEARCH?></div>
                    <div class="filters">
                        <input type="text" name="DOPBSP-reservations-search" id="DOPBSP-reservations-search" val="" />
                        <label id="DOPBSP-reservations-search-by-label" for="DOPBSP-reservations-search-by"><?php echo DOPBSP_RESERVATIONS_FILTERS_SEARCH_BY?></label>
                        <select name="DOPBSP-reservations-search-by" id="DOPBSP-reservations-search-by">
                            <option value="id">ID</option>
                        </select>
                    </div>
                    <a href="javascript:void()" class="help">
                        <span><?php echo DOPBSP_RESERVATIONS_FILTERS_SEARCH_HELP?></span>
                    </a>
                    <br class="DOPBSP-clear" />
                </div>
                <div class="reservation-filter" id="DOPBSP-reservations-pagination-filter">
                    <div class="title"><?php echo DOPBSP_RESERVATIONS_FILTERS_PAGINATION?></div>
                    <div class="filters">
                        <input type="hidden" name="DOPBSP-reservations-no-pages" id="DOPBSP-reservations-no-pages" value="" />
                        <select name="DOPBSP-reservations-pagination-page" id="DOPBSP-reservations-pagination-page">
                            <option value="1">1</option>
                        </select>
                        <label id="DOPBSP-reservations-pagination-no-page-label" for="DOPBSP-reservations-pagination-no-page"><?php echo DOPBSP_RESERVATIONS_FILTERS_PAGINATION_NO_PAGE?></label>
                        <select name="DOPBSP-reservations-pagination-no-page" id="DOPBSP-reservations-pagination-no-page" class="small">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25" selected="selected">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <a href="javascript:void()" class="help">
                        <span><?php echo DOPBSP_RESERVATIONS_FILTERS_PAGINATION_HELP?></span>
                    </a>
                    <br class="DOPBSP-clear" />
                </div>
                <div class="reservation-filter" id="DOPBSP-reservations-order-filter">
                    <div class="title"><?php echo DOPBSP_RESERVATIONS_FILTERS_ORDER?></div>
                    <div class="filters">
                        <select name="DOPBSP-reservations-order" id="DOPBSP-reservations-order">
                            <option value="ASC"><?php echo DOPBSP_RESERVATIONS_FILTERS_ORDER_ASCENDING?></option>
                            <option value="DESC"><?php echo DOPBSP_RESERVATIONS_FILTERS_ORDER_DESCENDING?></option>
                        </select>
                        <label id="DOPBSP-reservations-order-by-label" for="DOPBSP-reservations-order-by"><?php echo DOPBSP_RESERVATIONS_FILTERS_ORDER_BY?></label>
                        <select name="DOPBSP-reservations-order-by" id="DOPBSP-reservations-order-by">
                            <option value="check_in"><?php echo DOPBSP_RESERVATIONS_CHECK_IN_LABEL?></option>
                            <option value="check_out" style="display:none;"><?php echo DOPBSP_RESERVATIONS_CHECK_OUT_LABEL?></option>
                            <option value="start_hour"><?php echo DOPBSP_RESERVATIONS_START_HOURS_LABEL?></option>
                            <option value="end_hour"><?php echo DOPBSP_RESERVATIONS_END_HOURS_LABEL?></option>
                            <option value="id">ID</option>
                            <option value="status"><?php echo DOPBSP_RESERVATIONS_STATUS_LABEL?></option>
                            <option value="date_created"><?php echo DOPBSP_RESERVATIONS_DATE_CREATED_LABEL?></option>
                        </select>
                    </div>
                    <a href="javascript:void()" class="help">
                        <span><?php echo DOPBSP_RESERVATIONS_FILTERS_ORDER_HELP?></span>
                    </a>
                    <br class="DOPBSP-clear" />
                </div>
            </div>
            <div class="reservations-content"></div>
        </div>
    </div>
<?php
            }
            
            function bookingForms(){// Return Template              
                if (class_exists("DOPBookingSystemPROBackEnd")){
                    $DOPBSP_pluginSeries = new DOPBookingSystemPROBackEnd();
                }
                $this->returnTranslations();
?>            
    <div class="wrap DOPBSP-admin">
<!-- Header -->
        <?php $this->returnHeader(DOPBSP_TITLE.' - '.DOPBSP_TITLE_BOOKING_FORMS); ?>
        <input type="hidden" id="booking_form_id" value="" />
<!-- Content -->
        <div class="main">
            <div class="column column1">
                <?php if($DOPBSP_pluginSeries->userHasPermissions(wp_get_current_user()->ID)) { ?>
                <div class="column-header">
                    <div class="add-button" id="DOPBSP-add-booking-form-btn">
                        <a href="javascript:dopbspAddBookingForm()" title="<?php echo DOPBSP_ADD_BOOKING_FORM_SUBMIT ?>"></a>
                    </div>
                    <a href="javascript:void()" class="header-help"><span><?php echo DOPBSP_BOOKING_FORMS_HELP?>"</span></a>                    
                </div>
                <?php } ?>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="column-separator"></div>
            <div class="column column2">
                <div class="column-header"></div>
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <br class="DOPBSP-clear" />
        </div>
    </div>
<?php
            }
            
            function translation(){// Return Translation Template
                $this->returnTranslations();
?>            
    <div class="wrap DOPBSP-admin">
<!-- Header -->
        <?php $this->returnHeader(DOPBSP_TITLE.' - '.DOPBSP_TITLE_TRANSLATION); ?>
<!-- Content -->
        <div class="main">
            <div class="translation-header">
                <!-- Location Select -->
                <label for="DOPBSP-translation-location"><?php echo DOPBSP_TRANSLATION_SECTION?></label>
                <select name="DOPBSP-translation-location" id="DOPBSP-translation-location" onchange="dopbspShowTranslation()">
                    <option value="frontend"><?php echo DOPBSP_TRANSLATION_SECTION_FRONTEND?></option>
                    <option value="backend"><?php echo DOPBSP_TRANSLATION_SECTION_BACKEND?></option>
                </select>
                <!-- Language Select -->
                <label for="DOPBSP-translation-language"><?php echo DOPBSP_TRANSLATION_LANGUAGE?></label>
                <?php $this->returnLanguages('DOPBSP-translation-language', 'dopbspShowTranslation'); ?>
                <!-- Search -->
                <label for="DOPBSP-translation-search"><?php echo DOPBSP_TRANSLATION_SEARCH?></label>
                <input type="text" name="DOPBSP-translation-search" id="DOPBSP-translation-search" value="" onkeyup="dopbspSearchTranslation()" />
                <a href="javascript:void()" class="header-help last"><span><?php echo DOPBSP_TRANSLATION_HELP?></span></a>
                <input type="button" name="DOPBSP-translation-reset" id="DOPBSP-translation-reset" class="submit-style" value="<?php echo DOPBSP_TRANSLATION_RESET?>" onclick="dopbspResetTranslation()" />
                <br class="DOPBSP-clear" />
            </div>
            <div class="translation-content" id="DOPBSP-translation-content"></div>
        </div>
    </div>
<?php
            }
            
            function settings(){// Settings Template
                $this->returnTranslations();
?>  
    <div class="wrap DOPBSP-admin">
<!-- Header -->
        <?php $this->returnHeader(DOPBSP_TITLE.' - '.DOPBSP_TITLE_SETTINGS); ?>
<!-- Content -->  
        <div class="main">
            <form method="post" class="DOPBSP-form" action="" style="padding:0;"></form>
            <div class="column column1">
                <div class="column-content-container">
                    <div class="column-content">
                        <ul>
                            <li class="item item-selected" id="dopbsp-user-permissions" onclick="dopbspShowUsersPermissions();"><?php echo DOPBSP_USERS_PERMISSIONS?></li>
                            <li class="item" id="dopbsp-user-post-permissions" onclick="dopbspShowUsersCustomPostsPermissions();"><?php echo DOPBSP_USERS_CUSTOM_POSTS_TYPE_PERMISSIONS?></li>
                        </ul>                            
                    </div>
                </div>
            </div>
            <div class="column-separator"></div>
            <div class="column column2">
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <div class="column column3">
                <div class="column-content-container">
                    <div class="column-content">
                        &nbsp;
                    </div>
                </div>
            </div>
            <br class="DOPBSP-clear" />
        </div>
    </div>
<?php
            }
            
            function settingsUsersPermissions(){
                global $wpdb; 
?>
            
<!-- *************************************************************************** Administrators -->

<?php 
    $users_administrators = $wpdb->get_results('SELECT * FROM '.DOPBSP_Users_table.' WHERE type="administrator"');
    $users_admins = $wpdb->num_rows;
?>

                <a href="javascript:void(0)" id="dopbsp-administrators-show-hide" class="show-hide first"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_ADMINISTRATORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_administrators_permissions" id="dopbsp_administrators_permissions" onclick="dopbspEditGeneralUserPermissions('administrator');" <?php if (get_option('DOPBSP_administrators_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_administrators_permissions"><?=DOPSBP_USERS_ADMINISTRATORS_BULK_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-administrators-list">
<?php
    if($users_admins < 1){
        echo DOPBSP_USERS_NO_ADMINISTRATORS;
    }
    else{
        foreach ($users_administrators as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->user_id);
            $user_name = get_user_by( 'id', $user->user_id );
            
?>     
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->user_id?>" value="true" id="user<?php echo $user->user_id?>" class="DOPSBP-chk-all-admin DOPSBP-check-all" onclick="dopbspEditUserPermissions(<?php echo $user->user_id?>, '2', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_all == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->user_id?>"><?php echo $user_name->user_login?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?>                        
                </div>

<!-- *************************************************************************** Authors -->                

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_authors = get_users('orderby=nicename&role=author');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-authors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_AUTHORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_authors_permissions" id="dopbsp_authors_permissions" onclick="dopbspEditGeneralUserPermissions('author');" <?php if (get_option('DOPBSP_authors_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_authors_permissions"><?=DOPSBP_USERS_AUTHORS_BULK_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-authors-list">
<?php  
    if(!$users_authors){
        echo DOPBSP_USERS_NO_AUTHORS;
    }
    else{                  
        foreach ($users_authors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-author DOPSBP-check-all" onclick="dopbspEditUserPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
                    
<!-- *************************************************************************** Contributors -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_contributors = get_users('orderby=nicename&role=contributor');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-contributors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_CONTRIBUTORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_contributors_permissions" id="dopbsp_contributors_permissions" onclick="dopbspEditGeneralUserPermissions('contributor');" <?php if (get_option('DOPBSP_contributors_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_contributors_permissions"><?=DOPBSP_USERS_CONTRIBUTORS_BULK_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-contributors-list">
<?php 
    if(!$users_contributors){
        echo DOPBSP_USERS_NO_CONTRIBUTORS;
    } 
    else {
        foreach ($users_contributors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-contributor DOPSBP-check-all" onclick="dopbspEditUserPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
         
<!-- *************************************************************************** Editors -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_editors = get_users('orderby=nicename&role=editor');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-editors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_EDITORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_editors_permissions" id="dopbsp_editors_permissions" onclick="dopbspEditGeneralUserPermissions('editor');" <?php if (get_option('DOPBSP_editors_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_editors_permissions"><?=DOPSBP_USERS_EDITORS_BULK_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-editors-list">
<?php  
    if(!$users_editors){
        echo DOPBSP_USERS_NO_EDITORS;
    }
    else{ 
        foreach ($users_editors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-editor DOPSBP-check-all" onclick="dopbspEditUserPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
         
<!-- *************************************************************************** Subscribers -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_subscribers = get_users('orderby=nicename&role=subscriber');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-subscribers-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_SUBSCRIBERS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_subscribers_permissions" id="dopbsp_subscribers_permissions" onclick="dopbspEditGeneralUserPermissions('subscriber');" <?php if (get_option('DOPBSP_subscribers_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_subscribers_permissions"><?=DOPBSP_USERS_SUBSCRIBERS_BULK_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-subscribers-list">
<?php
    if(!$users_subscribers){
        echo DOPBSP_USERS_NO_SUBSCRIBERS;
    }
    else{
        foreach ($users_subscribers as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-subscriber DOPSBP-check-all" onclick="dopbspEditUserPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
<?php            
            }
            
            function settingsUsersCustomPostsPermissions(){
                global $wpdb; 
?>
            
<!-- *************************************************************************** Administrators -->

<?php 
    $users_administrators = $wpdb->get_results('SELECT * FROM '.DOPBSP_Users_table.' WHERE type="administrator"');
    $users_admins = $wpdb->num_rows;
?>
                <a href="javascript:void(0)" id="dopbsp-administrators-show-hide" class="show-hide first"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_ADMINISTRATORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_administrators_permissions" id="dopbsp_administrators_permissions" onclick="dopbspEditGeneralUserCustomPostsPermissions('administrator');" <?php if (get_option('DOPBSP_administrators_custom_posts_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_administrators_permissions"><?=DOPSBP_USERS_ADMINISTRATORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-administrators-list">
<?php
    if($users_admins < 1){
        echo DOPBSP_USERS_NO_ADMINISTRATORS; echo $wpdb->num_rows;
    }
    else{
        foreach ($users_administrators as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->user_id);
            $user_name = get_user_by( 'id', $user->user_id );
            
?>     
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->user_id?>" value="true" id="user<?php echo $user->user_id?>" class="DOPSBP-chk-all-admin DOPSBP-check-all" onclick="dopbspEditUserCustomPostsPermissions(<?php echo $user->user_id?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_custom_posts == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->user_id?>"><?php echo $user_name->user_login?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?>                        
                </div>

<!-- *************************************************************************** Authors -->                

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_authors = get_users('orderby=nicename&role=author');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-authors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_AUTHORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_authors_permissions" id="dopbsp_authors_permissions" onclick="dopbspEditGeneralUserCustomPostsPermissions('author');" <?php if (get_option('DOPBSP_authors_custom_posts_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_authors_permissions"><?=DOPSBP_USERS_AUTHORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-authors-list">
<?php  
    if(!$users_authors){
        echo DOPBSP_USERS_NO_AUTHORS;
    }
    else{                  
        foreach ($users_authors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-author DOPSBP-check-all" onclick="dopbspEditUserCustomPostsPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_custom_posts == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
                    
<!-- *************************************************************************** Contributors -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_contributors = get_users('orderby=nicename&role=contributor');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-contributors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_CONTRIBUTORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_contributors_permissions" id="dopbsp_contributors_permissions" onclick="dopbspEditGeneralUserCustomPostsPermissions('contributor');" <?php if (get_option('DOPBSP_contributors_custom_posts_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_contributors_permissions"><?=DOPBSP_USERS_CONTRIBUTORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-contributors-list">
<?php  
    if(!$users_contributors){
        echo DOPBSP_USERS_NO_CONTRIBUTORS;
    } 
    else {
        foreach ($users_contributors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-contributor DOPSBP-check-all" onclick="dopbspEditUserCustomPostsPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_custom_posts == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
         
<!-- *************************************************************************** Editors -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_editors = get_users('orderby=nicename&role=editor');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-editors-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_EDITORS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_editors_permissions" id="dopbsp_editors_permissions" onclick="dopbspEditGeneralUserCustomPostsPermissions('editor');" <?php if (get_option('DOPBSP_editors_custom_posts_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_editors_permissions"><?=DOPSBP_USERS_EDITORS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-editors-list">
<?php  
    if(!$users_editors){
        echo DOPBSP_USERS_NO_EDITORS;
    }
    else{ 
        foreach ($users_editors as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);        
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-editor DOPSBP-check-all" onclick="dopbspEditUserCustomPostsPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_custom_posts == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
         
<!-- *************************************************************************** Subscribers -->

                <a href="javascript:dopbspMoveTop()" class="go-top"><?php echo DOPBSP_GO_TOP?></a>
<?php 
    $users_subscribers = get_users('orderby=nicename&role=subscriber');
?>
                <span class="go-top-separator">|</span>
                <a href="javascript:void(0)" id="dopbsp-subscribers-show-hide" class="show-hide"><?php echo DOPBSP_USERS_SHOW?></a>
                <h3 class="settings"><?php echo DOPBSP_USERS_SUBSCRIBERS?></h3>
                <div class="column-select">
                    <input type="checkbox" class="DOPSBP-check-all" name="dopbsp_subscribers_permissions" id="dopbsp_subscribers_permissions" onclick="dopbspEditGeneralUserCustomPostsPermissions('subscriber');" <?php if (get_option('DOPBSP_subscribers_custom_posts_permissions') > 0){echo 'checked=checked';} ?>>
                    <label for="dopbsp_subscribers_permissions"><?=DOPBSP_USERS_SUBSCRIBERS_BULK_CUSTOM_POSTS_TYPE_PERMISSIONS_INFO?></label>
                </div>
                <div class="column-select users" id="dopbsp-subscribers-list">
<?php
    if(!$users_subscribers){
        echo DOPBSP_USERS_NO_SUBSCRIBERS;
    }
    else{
        foreach ($users_subscribers as $user){
            $user_permissions = $wpdb->get_row('SELECT * FROM '.DOPBSP_Users_table.' WHERE user_id='.$user->ID);
?>
                    <span class="pre"></span>
                    <input type="checkbox" name="user<?php echo $user->ID?>" value="true" id="user<?php echo $user->ID?>" class="DOPSBP-chk-all-subscriber DOPSBP-check-all" onclick="dopbspEditUserCustomPostsPermissions(<?php echo $user->ID?>, '1', $jDOPBSP(this).attr('checked'))" <?php if ($user_permissions->view_custom_posts == 'true'){echo 'checked=checked';} ?>>
                    <label for="user<?php echo $user->ID?>"><?php echo $user->user_nicename?></label> 
                    <span class="suf"></span>
                    <br class="DOPBSP-clear">
<?php
        }
    }
?> 
                </div>
<?php            
            }
            
// Components
            function returnHeader($title){ // Default page header.
?>
                <h2></h2>
                <div class="main-header">
                    <h3><?php echo $title?></h3>
                    <div id="DOPBSP-admin-message"></div>
                    <?php $this->returnLanguages(); ?>
                    <a href="http://envato-help.dotonpaper.net/booking-system-pro-wordpress-plugin.html#faq" target="_blank" class="DOPBSP-help"><?php echo DOPBSP_HELP_FAQ ?></a>
                    <a href="http://envato-help.dotonpaper.net/booking-system-pro-wordpress-plugin.html" target="_blank" class="DOPBSP-help"><?php echo DOPBSP_HELP_DOCUMENTATION ?></a>
                    <br class="DOPBSP-clear" />
                </div>
<?php                
            }
            
            function returnReservationsHeader($title, $show_with_calendar){ // Default page header.
?>
                <h2></h2>
                <div class="main-header">
                    <h3><?php echo $title?></h3>
                    <div id="DOPBSP-admin-reservations-message"></div>
<?php 
                if (!$show_with_calendar){
?>
                    <?php $this->returnLanguages(); ?>
                    <a href="http://envato-help.dotonpaper.net/booking-system-pro-wordpress-plugin.html#faq" target="_blank" class="DOPBSP-help"><?php echo DOPBSP_HELP_FAQ ?></a>
                    <a href="http://envato-help.dotonpaper.net/booking-system-pro-wordpress-plugin.html" target="_blank" class="DOPBSP-help"><?php echo DOPBSP_HELP_DOCUMENTATION ?></a>
<?php
                }
?>
                    <br class="DOPBSP-clear" />
                </div>
<?php                
            }
            
            function returnTranslations(){// Add translation to JavaScript variables for AJAX usage.
                global $wpdb;
                
                if (isset($_GET['page'])){
                    $current_page = $_GET['page'];

                    switch($current_page){
                        case "dopbsp-reservations":
                            $DOPBSP_curr_page = "Reservations List";
                            break;
                        case "dopbsp-booking-forms":
                            $DOPBSP_curr_page = "Forms List";
                            break;
                        case "dopbsp-translation":
                            $DOPBSP_curr_page = "Translation";
                            break;
                        case "dopbsp-settings":
                            $DOPBSP_curr_page = "Settings";
                            break;
                        default:
                            $DOPBSP_curr_page = "Calendars List";
                            break;
                    }
                }
                else{
                    $DOPBSP_curr_page = "Calendars List";
                }
                
                if (!is_super_admin()){
                    $DOPBSP_user_role = wp_get_current_user()->roles[0];
                }
                else{
                    $DOPBSP_user_role = "administrator";
                }
?>          
            <script type="text/JavaScript">
                var DOPBSP_curr_page = '<?php echo $DOPBSP_curr_page?>',
                DOPBSP_user_role = '<?php echo $DOPBSP_user_role?>',
                DOPBSP_plugin_url = '<?php echo DOPBSP_Plugin_URL?>',
                DOPBSP_plugin_abs = '<?php echo DOPBSP_Plugin_AbsPath?>',
                
<?php
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
                
                $translation = $wpdb->get_results('SELECT * FROM '.DOPBSP_Translation_table.'_'.$language.' WHERE location="backend"');

                foreach ($translation as $item){    
                    echo $item->key_data.' = \''.str_replace('<<single-quote>>', "\'", stripslashes($item->translation)).'\', ';
                }
?>
                DOPBSP_END_TRANSLATION_LIST = 'End translation.';
            </script>
<?php  
            }
            
            function returnLanguages($id = 'DOPBSP-admin-translation', $function = 'dopbspChangeTranslation', $class = ''){ // List languages select.
                $current_backend_language = get_option('DOPBSP_backend_language_'.wp_get_current_user()->ID);
                
                if ($current_backend_language == ''){
                    $current_backend_language = DOPBSP_CONFIG_BACKEND_DEFAULT_LANGUAGE;
                    add_option('DOPBSP_backend_language_'.wp_get_current_user()->ID, DOPBSP_CONFIG_BACKEND_DEFAULT_LANGUAGE);
                }
?>
                <select name="<?php echo $id?>" id="<?php echo $id?>"<?php $class == '' ? '':' class="'.$class.'"'; ?> onchange="<?php echo $function.'()'?>">
                    <option value="af"<?php echo $current_backend_language == 'af' ? ' selected="selected"':''?>>Afrikaans (Afrikaans)</option>
                    <option value="al"<?php echo $current_backend_language == 'al' ? ' selected="selected"':''?>>Albanian (Shqiptar)</option>
                    <option value="ar"<?php echo $current_backend_language == 'ar' ? ' selected="selected"':''?>>Arabic (>العربية)</option>
                    <option value="az"<?php echo $current_backend_language == 'az' ? ' selected="selected"':''?>>Azerbaijani (Azərbaycan)</option>
                    <option value="bs"<?php echo $current_backend_language == 'bs' ? ' selected="selected"':''?>>Basque (Euskal)</option>
                    <option value="by"<?php echo $current_backend_language == 'by' ? ' selected="selected"':''?>>Belarusian (Беларускай)</option>
                    <option value="bg"<?php echo $current_backend_language == 'bg' ? ' selected="selected"':''?>>Bulgarian (Български)</option>
                    <option value="ca"<?php echo $current_backend_language == 'ca' ? ' selected="selected"':''?>>Catalan (Català)</option>
                    <option value="cn"<?php echo $current_backend_language == 'cn' ? ' selected="selected"':''?>>Chinese (中国的)</option>
                    <option value="cr"<?php echo $current_backend_language == 'cr' ? ' selected="selected"':''?>>Croatian (Hrvatski)</option>
                    <option value="cz"<?php echo $current_backend_language == 'cz' ? ' selected="selected"':''?>>Czech (Český)</option>
                    <option value="dk"<?php echo $current_backend_language == 'dk' ? ' selected="selected"':''?>>Danish (Dansk)</option>
                    <option value="du"<?php echo $current_backend_language == 'du' ? ' selected="selected"':''?>>Dutch (Nederlands)</option>
                    <option value="en"<?php echo $current_backend_language == 'en' ? ' selected="selected"':''?>>English</option>
                    <option value="eo"<?php echo $current_backend_language == 'eo' ? ' selected="selected"':''?>>Esperanto (Esperanto)</option>
                    <option value="et"<?php echo $current_backend_language == 'et' ? ' selected="selected"':''?>>Estonian (Eesti)</option>
                    <option value="fl"<?php echo $current_backend_language == 'fl' ? ' selected="selected"':''?>>Filipino (na Filipino)</option>
                    <option value="fi"<?php echo $current_backend_language == 'fi' ? ' selected="selected"':''?>>Finnish (Suomi)</option>
                    <option value="fr"<?php echo $current_backend_language == 'fr' ? ' selected="selected"':''?>>French (Français)</option>
                    <option value="gl"<?php echo $current_backend_language == 'gl' ? ' selected="selected"':''?>>Galician (Galego)</option>
                    <option value="de"<?php echo $current_backend_language == 'de' ? ' selected="selected"':''?>>German (Deutsch)</option>
                    <option value="gr"<?php echo $current_backend_language == 'gr' ? ' selected="selected"':''?>>Greek (Ɛλληνικά)</option>
                    <option value="ha"<?php echo $current_backend_language == 'ha' ? ' selected="selected"':''?>>Haitian Creole (Kreyòl Ayisyen)</option>
                    <option value="he"<?php echo $current_backend_language == 'he' ? ' selected="selected"':''?>>Hebrew (עברית)</option>
                    <option value="hi"<?php echo $current_backend_language == 'hi' ? ' selected="selected"':''?>>Hindi (हिंदी)</option>
                    <option value="hu"<?php echo $current_backend_language == 'hu' ? ' selected="selected"':''?>>Hungarian (Magyar)</option>
                    <option value="is"<?php echo $current_backend_language == 'is' ? ' selected="selected"':''?>>Icelandic (Íslenska)</option>
                    <option value="id"<?php echo $current_backend_language == 'id' ? ' selected="selected"':''?>>Indonesian (Indonesia)</option>
                    <option value="ir"<?php echo $current_backend_language == 'ir' ? ' selected="selected"':''?>>Irish (Gaeilge)</option>
                    <option value="it"<?php echo $current_backend_language == 'it' ? ' selected="selected"':''?>>Italian (Italiano)</option>
                    <option value="ja"<?php echo $current_backend_language == 'ja' ? ' selected="selected"':''?>>Japanese (日本の)</option>
                    <option value="ko"<?php echo $current_backend_language == 'ko' ? ' selected="selected"':''?>>Korean (한국의)</option>            
                    <option value="lv"<?php echo $current_backend_language == 'lv' ? ' selected="selected"':''?>>Latvian (Latvijas)</option>
                    <option value="lt"<?php echo $current_backend_language == 'lt' ? ' selected="selected"':''?>>Lithuanian (Lietuvos)</option>            
                    <option value="mk"<?php echo $current_backend_language == 'mk' ? ' selected="selected"':''?>>Macedonian (македонски)</option>
                    <option value="mg"<?php echo $current_backend_language == 'mg' ? ' selected="selected"':''?>>Malay (Melayu)</option>
                    <option value="ma"<?php echo $current_backend_language == 'ma' ? ' selected="selected"':''?>>Maltese (Maltija)</option>
                    <option value="no"<?php echo $current_backend_language == 'no' ? ' selected="selected"':''?>>Norwegian (Norske)</option>            
                    <option value="pe"<?php echo $current_backend_language == 'pe' ? ' selected="selected"':''?>>Persian (فارسی)</option>
                    <option value="pl"<?php echo $current_backend_language == 'pl' ? ' selected="selected"':''?>>Polish (Polski)</option>
                    <option value="pt"<?php echo $current_backend_language == 'pt' ? ' selected="selected"':''?>>Portuguese (Português)</option>
                    <option value="ro"<?php echo $current_backend_language == 'ro' ? ' selected="selected"':''?>>Romanian (Română)</option>
                    <option value="ru"<?php echo $current_backend_language == 'ru' ? ' selected="selected"':''?>>Russian (Pусский)</option>
                    <option value="sr"<?php echo $current_backend_language == 'sr' ? ' selected="selected"':''?>>Serbian (Cрпски)</option>
                    <option value="sk"<?php echo $current_backend_language == 'sk' ? ' selected="selected"':''?>>Slovak (Slovenských)</option>
                    <option value="sl"<?php echo $current_backend_language == 'sl' ? ' selected="selected"':''?>>Slovenian (Slovenski)</option>
                    <option value="sp"<?php echo $current_backend_language == 'sp' ? ' selected="selected"':''?>>Spanish (Español)</option>
                    <option value="sw"<?php echo $current_backend_language == 'sw' ? ' selected="selected"':''?>>Swahili (Kiswahili)</option>
                    <option value="se"<?php echo $current_backend_language == 'se' ? ' selected="selected"':''?>>Swedish (Svenskt)</option>
                    <option value="th"<?php echo $current_backend_language == 'th' ? ' selected="selected"':''?>>Thai (ภาษาไทย)</option>
                    <option value="tr"<?php echo $current_backend_language == 'tr' ? ' selected="selected"':''?>>Turkish (Türk)</option>
                    <option value="uk"<?php echo $current_backend_language == 'uk' ? ' selected="selected"':''?>>Ukrainian (Український)</option>
                    <option value="ur"<?php echo $current_backend_language == 'ur' ? ' selected="selected"':''?>>Urdu (اردو)</option>
                    <option value="vi"<?php echo $current_backend_language == 'vi' ? ' selected="selected"':''?>>Vietnamese (Việt)</option>
                    <option value="we"<?php echo $current_backend_language == 'we' ? ' selected="selected"':''?>>Welsh (Cymraeg)</option>
                    <option value="yi"<?php echo $current_backend_language == 'yi' ? ' selected="selected"':''?>>Yiddish (ייִדיש)</option>
                </select>                    
<?php  
            }
        }
    }