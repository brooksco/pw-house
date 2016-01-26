<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : config.php
* File Version            : 1.1
* Created / Last Modified : 25 December 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO configuration file.
*/

// ***************************************************************************** Begin General Defaults

    define('DOPBSP_CONFIG_INIT_DATABASE', false); // Set to "true" if you want to verify the database structure at each action.
    define('DOPBSP_CONFIG_REPAIR_TRANSLATION_DATABASE', false);  // Set to "true" to repair translation database. All your previous translation will be replace.
    define('DOPBSP_CONFIG_DELETE_DATA_ON_DELETE', true);  // Set to "true" if you want to delete all data when you delete the plugin from admin.
    
// ***************************************************************************** End General Defaults
    

// ***************************************************************************** Begin Translation Defaults

    define('DOPBSP_CONFIG_BACKEND_DEFAULT_LANGUAGE', 'en'); // Set Back End default language.
    define('DOPBSP_CONFIG_FRONTEND_DEFAULT_LANGUAGE', 'en'); // Set Front End default language.
    
// ***************************************************************************** End Translation Defaults
    
    
// ***************************************************************************** Begin Users Permissions Defaults

    define('DOPBSP_CONFIG_ADMINISTRATORS_PERMISSIONS', 0); // Set to "1" to allow administrators to view all calendars by default. "0" to not allow.
    define('DOPBSP_CONFIG_AUTHORS_PERMISSIONS', 0); // Set to "1" to allow authors to create calendars by default. "0" to not allow.
    define('DOPBSP_CONFIG_CONTRIBUTORS_PERMISSIONS', 0); // Set to "1" to allow contributors to create calendars by default. "0" to not allow.
    define('DOPBSP_CONFIG_EDITORS_PERMISSIONS', 0); // Set to "1" to allow editors to create calendars by default. "0" to not allow.
    define('DOPBSP_CONFIG_SUBSCRIBERS_PERMISSIONS', 0); // Set to "1" to allow subscribers to create calendars by default. "0" to not allow.
    
    define('DOPBSP_CONFIG_ADMINISTRATORS_CUSTOM_POSTS_PERMISSIONS', 1); // Set to "1" to allow administrator to create Custom Posts by default. "0" to not allow.
    define('DOPBSP_CONFIG_AUTHORS_CUSTOM_POSTS_PERMISSIONS', 1); // Set to "1" to allow administrator to create Custom Posts by default. "0" to not allow.
    define('DOPBSP_CONFIG_CONTRIBUTORS_CUSTOM_POSTS_PERMISSIONS', 1); // Set to "1" to allow administrator to create Custom Posts by default. "0" to not allow.
    define('DOPBSP_CONFIG_EDITORS_CUSTOM_POSTS_PERMISSIONS', 1); // Set to "1" to allow administrator to create Custom Posts by default. "0" to not allow.
    define('DOPBSP_CONFIG_SUBSCRIBERS_CUSTOM_POSTS_PERMISSIONS', 1); // Set to "1" to allow administrator to create Custom Posts by default. "0" to not allow.
    
// ***************************************************************************** End Users Permissions Defaults
    

// ***************************************************************************** Begin Custom Post Type Defaults
    
    define('DOPBSP_CONFIG_CUSTOM_POST_SLUG', 'booking-system'); // Set Custom Post Type slug.
    define('DOPBSP_CONFIG_CUSTOM_POST_OVERWRITE_POSTS_LOOP', false); // Set to "true" if you want to add Booking System Custom Posts in blog posts.
    define('DOPBSP_CONFIG_CUSTOM_POST_NOT_ALLOWED_POST_TYPES_IN_LOOP', 'page,attachment,nav_menu_item,revision'); // The slugs of the post types, separated by comma, that will not appear in blog posts.
    
// ***************************************************************************** End Custom Post Type Defaults   
    
    
// ***************************************************************************** Begin Databese Defaults    
    
// Translation
    define('DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_KEY_DATA', '');
    define('DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_LOCATION', 'backend');
    define('DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_POSITION', 0);
    define('DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_PARENT_KEY', '');
    define('DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_TEXT_DATA', ''); // Type TEXT
    define('DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_TRANSLATION', ''); // Type TEXT
    
// Settings    
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_CALENDAR_ID', 0);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_AVAILABLE_DAYS', 'true,true,true,true,true,true,true');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_FIRST_DAY', 1);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_CURRENCY', 109);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_FIXED_TAX', 0);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_PERCENT_TAX', 0);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DATE_TYPE', 1);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_TEMPLATE', 'default');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_TEMPLATE_EMAIL', 'default');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MIN_STAY', 1);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MAX_STAY', 0);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_NO_ITEMS_ENABLED', 'true');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_VIEW_ONLY', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_PAGE_URL', '');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_NOTIFICATIONS_EMAIL', '');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_SMTP_ENABLED', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_SMTP_HOST_NAME', '');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_SMTP_HOST_PORT', 25);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_SMTP_SSL', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_SMTP_USER', '');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_SMTP_PASSWORD', '');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MULTIPLE_DAYS_SELECT', 'true');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MORNING_CHECK_OUT', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DETAILS_FROM_HOURS', 'true');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_ENABLED', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_INFO_ENABLED', 'true');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_DEFINITIONS', ''); // Type TEXT
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MULTIPLE_HOURS_SELECT', 'true');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_AMPM', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_LAST_HOUR_TO_TOTAL_PRICE', 'true');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_INTERVAL_ENABLED', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DISCOUNTS_NO_DAYS', '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DEPOSIT', 0);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_FORM', 1);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_INSTANT_BOOKING', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_NO_PEOPLE_ENABLED', 'true');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MIN_NO_PEOPLE', 1);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MAX_NO_PEOPLE', 4);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_NO_CHILDREN_ENABLED', 'true');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MIN_NO_CHILDREN', 0);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MAX_NO_CHILDREN', 2);
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_TERMS_AND_CONDITIONS_ENABLED', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_TERMS_AND_CONDITIONS_LINK', '');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_PAYMENT_ARRIVAL_ENABLED', 'true');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_PAYMENT_PAYPAL_ENABLED', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_PAYMENT_PAYPAL_USERNAME', '');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_PAYMENT_PAYPAL_PASSWORD', '');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_PAYMENT_PAYPAL_SIGNATURE', '');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_PAYMENT_PAYPAL_CREDIT_CARD', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_PAYMENT_PAYPAL_SANDBOX_ENABLED', 'false');
    define('DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MAX_YEAR', date('Y'));

// Calendars    
    define('DOPBSP_CONFIG_DATABASE_CALENDARS_DEFAULT_USER_ID', 0);
    define('DOPBSP_CONFIG_DATABASE_CALENDARS_DEFAULT_POST_ID', 0);
    define('DOPBSP_CONFIG_DATABASE_CALENDARS_DEFAULT_NAME', '');
    define('DOPBSP_CONFIG_DATABASE_CALENDARS_DEFAULT_MIN_PRICE', 0);
    define('DOPBSP_CONFIG_DATABASE_CALENDARS_DEFAULT_MAX_PRICE', 0);
    define('DOPBSP_CONFIG_DATABASE_CALENDARS_DEFAULT_AVAILABILITY', ''); // Type TEXT

// Days    
    define('DOPBSP_CONFIG_DATABASE_DAYS_DEFAULT_CALENDAR_ID', 0);
    define('DOPBSP_CONFIG_DATABASE_DAYS_DEFAULT_DAY', '');
    define('DOPBSP_CONFIG_DATABASE_DAYS_DEFAULT_YEAR', date('Y'));
    define('DOPBSP_CONFIG_DATABASE_DAYS_DEFAULT_DATA', ''); // Type TEXT
   
// Reservations    
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_CALENDAR_ID', 0);
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_CHECK_IN', '');
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_CHECK_OUT', '');
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_START_HOUR', '');
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_END_HOUR', '');
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_NO_ITEMS', 1);
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_CURRENCY', '');
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_CURRENCY_CODE', '');
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_TOTAL_PRICE', 0);
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_DISCOUNT', 0);
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_PRICE', 0);
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_DEPOSIT', 0);
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_LANGUAGE', 'en');
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_EMAIL', 0);
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_NO_PEOPLE', 1);
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_NO_CHILDREN', 0);
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_PAYMENT_METHOD', 0);
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_PAYPAL_TRANSACTION_ID', '');
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_STATUS', 'pending');
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_INFO', ''); // Type TEXT
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_DAYS_HOURS_HISTORY', ''); // Type TEXT
    define('DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_DATE_CREATED', 0); // Type DATE
    
// Users    
    define('DOPBSP_CONFIG_DATABASE_USERS_DEFAULT_USER_ID', 0);
    define('DOPBSP_CONFIG_DATABASE_USERS_DEFAULT_TYPE', '');
    define('DOPBSP_CONFIG_DATABASE_USERS_DEFAULT_VIEW', 'true');
    define('DOPBSP_CONFIG_DATABASE_USERS_DEFAULT_VIEW_ALL', 'false');
    define('DOPBSP_CONFIG_DATABASE_USERS_DEFAULT_VIEW_CUSTOM_POSTS', 'false');
    define('DOPBSP_CONFIG_DATABASE_USERS_DEFAULT_ADMIN_CALENDARS', ''); // Type TEXT

// Forms
    define('DOPBSP_CONFIG_DATABASE_FORMS_DEFAULT_USER_ID', 0);
    define('DOPBSP_CONFIG_DATABASE_FORMS_DEFAULT_NAME', '');
    
// Forms Fields    
    define('DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_FORM_ID', 0);
    define('DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_TYPE', '');
    define('DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_POSITION', 0);
    define('DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_MULTIPLE_SELECT', 'false');
    define('DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_ALLOWED_CHARACTERS', ''); // Type TEXT
    define('DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_SIZE', 0);
    define('DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_IS_EMAIL', 'false');
    define('DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_REQUIRED', 'false');
    define('DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_TRANSLATION', ''); // Type TEXT
    
// Forms Select Options    
    define('DOPBSP_CONFIG_DATABASE_FORMS_SELECT_OPTIONS_DEFAULT_FIELD_ID', 0);
    define('DOPBSP_CONFIG_DATABASE_FORMS_SELECT_OPTIONS_DEFAULT_TRANSLATION', ''); // Type TEXT
    
// WooCommerce    
    define('DOPBSP_CONFIG_DATABASE_WOOCOMMERCE_DEFAULT_CART_KEY', '');
    define('DOPBSP_CONFIG_DATABASE_WOOCOMMERCE_DEFAULT_DATA', ''); // Type TEXT
    
// ***************************************************************************** End Databese Defaults