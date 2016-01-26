/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 1.9
* File                    : dopbsp-backend-widget.js
* File Version            : 1.0
* Created / Last Modified : 01 November 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Back End Widget Scripts.
*/
           
    function dopbspConfigureWidgetForm(id, selection){
        jQuery('#DOPBSP-widget-id-'+id).css('display', 'none');
        jQuery('#DOPBSP-widget-lang-'+id).css('display', 'none');

        switch (selection){
            case 'calendar':
                jQuery('#DOPBSP-widget-id-'+id).css('display', 'block');
                jQuery('#DOPBSP-widget-lang-'+id).css('display', 'block');
                break;
            case 'sidebar':
                jQuery('#DOPBSP-widget-id-'+id).css('display', 'block');
                break;
        }
    }