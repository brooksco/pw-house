<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : dopbsp-frontend-woocommerce.php
* File Version            : 1.1
* Created / Last Modified : 21 December 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Front End WooCommerce Class.
*/

    if (!class_exists("DOPBookingSystemPROFrontEndWooCommerce")){
        class DOPBookingSystemPROFrontEndWooCommerce extends DOPBookingSystemPROFrontEnd{
            function DOPBookingSystemPROFrontEndWooCommerce(){// Constructor
                // Actions
                add_action('init', array(&$this, 'removeButtonsInShop')); // Remove "Add to cart" & "Read more", in shop page.
                add_action('woocommerce_before_calculate_totals', array(&$this, 'updateCartPrice')); // Update cart price.
                add_action('woocommerce_cart_updated', array(&$this, 'deleteCartItem')); // Delete item from database when is deleted from cart.
                
                // Filters
                add_filter('woocommerce_single_product_summary', array(&$this, 'addSummary'), 35); // Add calendar in summary on product page.
                add_filter('woocommerce_product_tabs', array(&$this, 'addTab')); // Add calendar in tab on product page.
                add_filter('woocommerce_get_item_data', array(&$this, 'updateCartInfo'), 10, 2); // Update bookings info in cart.
                
                
            }
            
// Change shop page.            
            function removeButtonsInShop(){ // Remove "Add to cart" & "Read more", in shop page.
                remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10); // Remove all buttons.
                add_action('woocommerce_after_shop_loop_item', array(&$this, 'replaceButtonsInShop'), 11); // Replace "Add to cart" button with "Read more", in shop page, for the ones that contain a calendar.
            }
            
            function replaceButtonsInShop(){ // Replace "Add to cart" button with "View availability", in shop page, for the ones that contain a calendar.
                global $post;
                global $product;
                global $DOPBSP_pluginSeries_translation;
                
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($post->ID, 'dopbsp_woocommerce_calendar', true),
                                                    'language' => get_post_meta($post->ID, 'dopbsp_woocommerce_language', true) == '' ? 'en':get_post_meta($post->ID, 'dopbsp_woocommerce_language', true),
                                                    'position' => get_post_meta($post->ID, 'dopbsp_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'dopbsp_woocommerce_position', true));
                
                if ($dopbsp_woocommerce_options['calendar'] == 0){
                    add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 12); // Add product button if a calendar is not attached.
                }
                else{
                    $DOPBSP_pluginSeries_translation->setTranslation('frontend', $dopbsp_woocommerce_options['language']);
                
                    echo apply_filters('woocommerce_loop_add_to_cart_link', sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button product_type_%s">%s</a>',
                                                                                    esc_url($product->post->guid),
                                                                                    esc_attr($product->id),
                                                                                    esc_attr($product->get_sku()),
                                                                                    esc_attr($product->product_type),
                                                                                    DOPBSP_WOOCOMMERCE_VIEW_AVAILABILITY));
                }
            }
            
// Add calendar on product page.            
            function addSummary(){ // Add calendar in product summary on product page.
                global $post;
	
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($post->ID, 'dopbsp_woocommerce_calendar', true),
                                                    'language' => get_post_meta($post->ID, 'dopbsp_woocommerce_language', true) == '' ? 'en':get_post_meta($post->ID, 'dopbsp_woocommerce_language', true),
                                                    'position' => get_post_meta($post->ID, 'dopbsp_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'dopbsp_woocommerce_position', true));
                    
                if ($dopbsp_woocommerce_options['calendar'] != '0'){
                    if ($dopbsp_woocommerce_options['position'] == 'summary'){
                        echo do_shortcode('[dopbsp id='.$dopbsp_woocommerce_options['calendar'].' lang='.$dopbsp_woocommerce_options['language'].' woocommerce=true]');
                    }
                
                    if ($dopbsp_woocommerce_options['position'] == 'summary-tabs'){
                        echo '<div class="DOPBookingSystemPRO_OuterSidebar" id="DOPBookingSystemPRO_OuterSidebar'.$dopbsp_woocommerce_options['calendar'].'"></div>';
                    }
                }
            }
            
            function addTab(){ // Add tab on product page.
		global $post;
                global $DOPBSP_pluginSeries_translation;
		$tab = array();
	
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($post->ID, 'dopbsp_woocommerce_calendar', true),
                                                    'language' => get_post_meta($post->ID, 'dopbsp_woocommerce_language', true) == '' ? 'en':get_post_meta($post->ID, 'dopbsp_woocommerce_language', true),
                                                    'position' => get_post_meta($post->ID, 'dopbsp_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'dopbsp_woocommerce_position', true));
                
                if ($dopbsp_woocommerce_options['calendar'] != '0' && ($dopbsp_woocommerce_options['position'] == 'tabs' || $dopbsp_woocommerce_options['position'] == 'summary-tabs')){
                    $DOPBSP_pluginSeries_translation->setTranslation('frontend', $dopbsp_woocommerce_options['language']);
                    
                    $tab['booking-system'] = array('title' => DOPBSP_WOOCOMMERCE_TAB_TITLE,
                                                   'priority' => 1,
                                                   'callback' => array($this, 'showTabContent'));
                    return $tab;
                }
            }
            
            function showTabContent(){ // Add calendar in tab on product page.
                global $post;
	
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($post->ID, 'dopbsp_woocommerce_calendar', true),
                                                    'language' => get_post_meta($post->ID, 'dopbsp_woocommerce_language', true) == '' ? 'en':get_post_meta($post->ID, 'dopbsp_woocommerce_language', true),
                                                    'position' => get_post_meta($post->ID, 'dopbsp_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'dopbsp_woocommerce_position', true));
                    
                echo do_shortcode('[dopbsp id='.$dopbsp_woocommerce_options['calendar'].' woocommerce=true]');
            }
            
// Cart actions.
            function addToCart(){ // Add booking to cart.
                global $wpdb;
		global $woocommerce;
                
                $language = $_POST['language'];
                $product_id = $_POST['product_id'];
                $calendar_id = $_POST['calendar_id'];
                $check_in = $_POST['check_in'];
                $check_out = $_POST['check_out'];
                $start_hour = $_POST['start_hour'];
                $end_hour = $_POST['end_hour'];
                $no_items = $_POST['no_items'];
                $currency = $_POST['currency'];
                $currency_code = $_POST['currency_code'];
                $total_price = $_POST['total_price'];
                $discount = $_POST['discount'];
                $price = $_POST['price'];
                $deposit = $_POST['deposit'];
                $days_hours_history = $_POST['days_hours_history'];
                                             
                $woocommerce->cart->add_to_cart($product_id, 1, null, null, array('dopbsp' => array('language' => $language,
                                                                                                    'product_id' => $product_id,
                                                                                                    'calendar_id' => $calendar_id,
                                                                                                    'check_in' => $check_in,
                                                                                                    'check_out' => $check_out,
                                                                                                    'start_hour' => $start_hour,
                                                                                                    'end_hour' => $end_hour,
                                                                                                    'no_items' => $no_items,
                                                                                                    'currency' => $currency,
                                                                                                    'currency_code' => $currency_code,
                                                                                                    'total_price' => $total_price,
                                                                                                    'discount' => $discount,
                                                                                                    'price' => $price,
                                                                                                    'deposit' => $deposit,
                                                                                                    'days_hours_history' => $days_hours_history)));
                $cart = $woocommerce->cart->cart_contents;
                
                foreach ($cart as $key => $cart_item){
                    if (isset($cart_item['dopbsp'])){
                        $wpdb->insert(DOPBSP_WooCommerce_table, array('cart_key' => $key, 
                                                                      'data' => json_encode($cart_item['dopbsp'])));
                    }
                }
            }
            
            function deleteCartItem(){ // Delete item from database when is deleted from cart.
                global $wpdb;
                
                if (isset($_GET['remove_item'])){
                    $wpdb->delete(DOPBSP_WooCommerce_table, array('cart_key' => $_GET['remove_item']));
                }
            }
            
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
        }
    }