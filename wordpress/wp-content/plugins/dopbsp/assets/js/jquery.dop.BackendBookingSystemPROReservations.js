
/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 1.9
* File                    : jquery.dop.BackendBookingSystemPROReservations.js
* File Version            : 1.1
* Created / Last Modified : 04 December 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Reservations Back End jQuery plugin.
*/

(function($){
    $.fn.DOPBookingSystemPROReservations = function(options){
        var Data = {'AddtMonthViewText': 'Add Month View',
                    'AdultsLabel': 'Adults',
                    'ButtonApproveLabel': 'Approve',
                    'ButtonCancelLabel': 'Cancel',
                    'ButtonCloseLabel': 'Close',
                    'ButtonDeleteLabel': 'Delete',
                    'ButtonJumpToDayLabel': 'Jump to day',
                    'ButtonRejectLabel': 'Reject',
                    'CheckInLabel': 'Check In',
                    'CheckOutLabel': 'Check Out',
                    'ChildrenLabel': 'Children',
                    'ClikToEditLabel': 'Click to edit the reservations',
                    'Currency': '$',
                    'DateCreatedLabel': 'Date Created',
                    'DateType': 1,
                    'DayNames': ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    'DepositLabel': 'Deposit',
                    'DiscountLabel': 'Discount',
                    'DiscountInfoLabel': 'discount',
                    'FirstDay': 1,
                    'HourEndLabel': 'End Hour',
                    'HoursAMPM': false,
                    'HoursEnabled': false,
                    'HourStartLabel': 'Start Hour',
                    'ID': 0,
                    'MonthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    'NextMonthText': 'Next Month',
                    'NoItemsLabel': 'No Items',
                    'PaymentMethodLabel': 'Payment Method',
                    'PeopleLabel': 'People',
                    'PreviousMonthText': 'Previous Month',
                    'PriceLabel': 'Price',
                    'Reinitialize': true,
                    'RemoveMonthViewText': 'Remove Month View',
                    'StatusApprovedLabel': 'Approved',
                    'StatusCanceledLabel': 'Canceled',
                    'StatusExpiredLabel': 'Expired',
                    'StatusLabel': 'Status',
                    'StatusPendingLabel': 'Pending',
                    'StatusRejectedLabel': 'Rejected',
                    'TransactionIDLabel': 'Transaction ID'},
        Container = this,

        ReservationsData = new Array(),
        Reservations = new Array(),

        StartDate = new Date(),
        StartYear = StartDate.getFullYear(),
        StartMonth = StartDate.getMonth()+1,
        StartDay = StartDate.getDate(),
        CurrYear = StartYear,
        CurrMonth = StartMonth,

        AddtMonthViewText = 'Add Month View',
        AdultsLabel = 'Adults',
        ButtonApproveLabel = 'Approve',
        ButtonCancelLabel = 'Cancel',
        ButtonCloseLabel = 'Close',
        ButtonDeleteLabel = 'Delete',
        ButtonJumpToDayLabel = 'Jump to day',
        ButtonRejectLabel = 'Reject',
        CheckInLabel = 'Check In',
        CheckOutLabel = 'Check Out',
        ChildrenLabel = 'Children',
        ClikToEditLabel = 'Click to edit the reservations',
        Currency = '$',
        DateCreatedLabel = 'Date Created',
        DateType = 1,
        DayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        DepositLabel = 'Deposit',
        DiscountLabel = 'Discount',
        DiscountInfoLabel = 'discount',
        FirstDay = 1,
        HourEndLabel = 'End Hour',
        HoursAMPM = false,
        HoursEnabled = false,
        HourStartLabel = 'Start Hour',
        ID = 0,
        LeftToPayLabel = 'Left to pay',
        MonthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        NextMonthText = 'Next Month',
        NoItemsLabel = 'No Items',
        PaymentMethodLabel = 'Payment Method',
        PeopleLabel = 'People',
        PreviousMonthText = 'Previous Month',
        PriceLabel = 'Price',
        RemoveMonthViewText = 'Remove Month View',
        StatusApprovedLabel = 'Approved',
        StatusCanceledLabel = 'Canceled',
        StatusExpiredLabel = 'Expired',
        StatusLabel = 'Status',
        StatusPendingLabel = 'Pending',
        StatusRejectedLabel = 'Rejected',
        TransactionIDLabel = 'Transaction ID',
        
        noMonths = 1,
        dayNo = 0,
        currentReservation = 0,
        currentReservationID = 0,
        
        infoXPos = 0,
        infoYPos = 0,
        
        methods = {            
                    init:function( ){// Init Plugin.
                        return this.each(function(){
                            if (options){
                                $.extend(Data, options);
                            }
                            
                            if (!$(Container).hasClass('dopbsp-initialized') || Data['Reinitialize']){
                                $(Container).addClass('dopbsp-initialized');
                                methods.parseData();
                            }
                        });
                    },
                    parseData:function(){
                        AddtMonthViewText = Data['AddtMonthViewText'];
                        AdultsLabel = Data['AdultsLabel'];
                        ButtonApproveLabel = Data['ButtonApproveLabel'];
                        ButtonCancelLabel = Data['ButtonCancelLabel'];
                        ButtonCloseLabel = Data['ButtonCloseLabel'];
                        ButtonDeleteLabel = Data['ButtonDeleteLabel'];
                        ButtonJumpToDayLabel = Data['ButtonJumpToDayLabel'];
                        ButtonRejectLabel = Data['ButtonRejectLabel'];
                        CheckInLabel = Data['CheckInLabel'];
                        CheckOutLabel = Data['CheckOutLabel'];
                        ChildrenLabel = Data['ChildrenLabel'];
                        ClikToEditLabel = Data['ClikToEditLabel'];
                        Currency = Data['Currency'];
                        DateCreatedLabel = Data['DateCreatedLabel'];
                        DateType = parseInt(Data['DateType'], 10);
                        DayNames = Data['DayNames'];
                        DepositLabel = Data['DepositLabel'],
                        DiscountLabel = Data['DiscountLabel'],
                        DiscountInfoLabel = Data['DiscountInfoLabel'],
                        FirstDay = Data['FirstDay'];
                        HourEndLabel = Data['HourEndLabel'];
                        HoursAMPM = Data['HoursAMPM'] == 'true' ? true:false;
                        HoursEnabled = Data['HoursEnabled'] == 'true' ? true:false;
                        HourStartLabel = Data['HourStartLabel'];
                        ID = Data['ID'];
                        LeftToPayLabel = Data['LeftToPayLabel'],
                        MonthNames = Data['MonthNames'];
                        NextMonthText = Data['NextMonthText'];
                        NoItemsLabel = Data['NoItemsLabel'];
                        PaymentMethodLabel = 'Payment Method',
                        PeopleLabel = Data['PeopleLabel'];
                        PreviousMonthText = Data['PreviousMonthText'];
                        PriceLabel = Data['PriceLabel'];
                        RemoveMonthViewText = Data['RemoveMonthViewText'];
                        StatusApprovedLabel = Data['StatusApprovedLabel'];
                        StatusCanceledLabel = Data['StatusCanceledLabel'];
                        StatusExpiredLabel = Data['StatusExpiredLabel'];
                        StatusLabel = Data['StatusLabel'];
                        StatusPendingLabel = Data['StatusPendingLabel'];
                        StatusRejectedLabel = Data['StatusRejectedLabel'];
                        TransactionIDLabel = Data['TransactionIDLabel'];
                        
                        methods.parseCalendarData();
                    },
                    parseCalendarData:function(){
                        $.post(ajaxurl, {action: 'dopbsp_get_calendar_reservations',
                                         calendar_id: ID}, function(data){
                            if ($.trim(data) != ''){
                                ReservationsData = JSON.parse($.trim(data));
                            }
                            
                            dopbspToggleReservationsMessage('hide', '');
                            methods.initCalendar();
                        });
                    },

                    initCalendar:function(){// Init  Calendar
                        var HTML = new Array(), no;
                        
                        HTML.push('<div class="DOPBookingSystemPROReservations_Container">');                        
                        HTML.push('    <div class="DOPBookingSystemPROReservations_Navigation">');
                        HTML.push('        <div class="add_btn" title="'+AddtMonthViewText+'"></div>');                        
                        HTML.push('        <div class="remove_btn" title="'+RemoveMonthViewText+'"></div>');
                        HTML.push('        <div class="previous_btn" title="'+PreviousMonthText+'"></div>');
                        HTML.push('        <div class="next_btn" title="'+NextMonthText+'"></div>');
                        HTML.push('        <div class="month_year"></div>');
                        HTML.push('        <table class="week">');
                        HTML.push('            <tr>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('                <td class="day"></td>');
                        HTML.push('            </tr>');
                        HTML.push('        </table>');
                        HTML.push('    </div>');
                        HTML.push('    <div class="DOPBookingSystemPROReservations_Calendar"></div>');
                        HTML.push('</div>');
                        
                        Container.html(HTML.join(''));
                        $('#DOPBookingSystemPROReservations_Info'+ID).remove();
                        $('body').append('<div class="DOPBookingSystemPROReservations_Info" id="DOPBookingSystemPROReservations_Info'+ID+'"></div>');
                        
                        no = FirstDay-1;
                        
                        $('.DOPBookingSystemPROReservations_Navigation .week .day', Container).each(function(){
                            no++;
                            
                            if (no == 7){
                                no = 0;
                            }
                            $(this).html(DayNames[no]);
                        });
                        
                        methods.initSettings();
                    },
                    initSettings:function(){// Init  Settings
                        methods.initFilters();
                        methods.initNavigation();
                        methods.initInfo();
                        methods.initReservations();
                    },
                    initFilters:function(){// Init Filters
                        // Actions
                        $jDOPBSP('#DOPBSP-reset-reservations-filter').unbind('click');
                        $jDOPBSP('#DOPBSP-reset-reservations-filter').bind('click', function(){
                            methods.resetFilters();
                        });
                        
                        // Period Filters
                        if (HoursEnabled){
                            $('#DOPBSP-reservations-start-hour').unbind('change');
                            $('#DOPBSP-reservations-start-hour').bind('change', function(){
                                $('#DOPBSP-reservations-end-hour').html('');
                                
                                $('#DOPBSP-reservations-start-hour option').each(function(){
                                    if ($(this).attr('value') >= $('#DOPBSP-reservations-start-hour').val()){
                                        $('#DOPBSP-reservations-end-hour').append('<option value="'+$(this).attr('value')+'">'+$(this).html()+'</option>');
                                    }
                                });
                                $jDOPBSP('#DOPBSP-reservations-end-hour [value="24:00"]').attr('selected', 'selected');
                                
                                methods.showReservations();
                            });
                        
                            $('#DOPBSP-reservations-end-hour').unbind('change');
                            $('#DOPBSP-reservations-end-hour').bind('change', function(){
                                methods.showReservations();
                            });
                        }
                        
                        // Status Filters
                        $('#DOPBSP-reservations-pending').unbind('click');
                        $('#DOPBSP-reservations-pending').bind('click', function(){
                            methods.showReservations();
                        });
                        
                        $('#DOPBSP-reservations-approved').unbind('click');
                        $('#DOPBSP-reservations-approved').bind('click', function(){
                            methods.showReservations();
                        });
                        
                        $('#DOPBSP-reservations-rejected').unbind('click');
                        $('#DOPBSP-reservations-rejected').bind('click', function(){
                            methods.showReservations();
                        });
                        
                        $('#DOPBSP-reservations-canceled').unbind('click');
                        $('#DOPBSP-reservations-canceled').bind('click', function(){
                            methods.showReservations();
                        });
                        
                        // Payment Filters
                        $jDOPBSP('#DOPBSP-reservations-payment-none').unbind('click');
                        $jDOPBSP('#DOPBSP-reservations-payment-none').bind('click', function(){
                            methods.showReservations();
                        });    

                        $jDOPBSP('#DOPBSP-reservations-payment-arrival').unbind('click');
                        $jDOPBSP('#DOPBSP-reservations-payment-arrival').bind('click', function(){
                            methods.showReservations();
                        });

                        $jDOPBSP('#DOPBSP-reservations-payment-paypal').unbind('click');
                        $jDOPBSP('#DOPBSP-reservations-payment-paypal').bind('click', function(){
                            methods.showReservations();
                        });
                    },
                    resetFilters:function(){
                        // Period    
                        $jDOPBSP('#DOPBSP-reservations-start-hour [value="00:00"]').attr('selected', 'selected');
                        $jDOPBSP('#DOPBSP-reservations-end-hour [value="24:00"]').attr('selected', 'selected');

                        // Status
                        $jDOPBSP('#DOPBSP-reservations-pending').removeAttr('checked');
                        $jDOPBSP('#DOPBSP-reservations-approved').removeAttr('checked');
                        $jDOPBSP('#DOPBSP-reservations-rejected').removeAttr('checked');
                        $jDOPBSP('#DOPBSP-reservations-canceled').removeAttr('checked');
                        $jDOPBSP('#DOPBSP-reservations-expired').removeAttr('checked');

                        // Payment
                        $jDOPBSP('#DOPBSP-reservations-payment-none').removeAttr('checked');
                        $jDOPBSP('#DOPBSP-reservations-payment-arrival').removeAttr('checked');
                        $jDOPBSP('#DOPBSP-reservations-payment-paypal').removeAttr('checked');

                        methods.showReservations();
                    },
                    initNavigation:function(){// Init Navigation
                        if (!prototypes.isTouchDevice()){
                            $('.DOPBookingSystemPROReservations_Navigation .previous_btn', Container).hover(function(){
                                $(this).addClass('hover');
                            }, function(){
                                $(this).removeClass('hover');
                            });

                            $('.DOPBookingSystemPROReservations_Navigation .next_btn', Container).hover(function(){
                                $(this).addClass('hover');
                            }, function(){
                                $(this).removeClass('hover');
                            });

                            $('.DOPBookingSystemPROReservations_Navigation .add_btn', Container).hover(function(){
                                $(this).addClass('hover');
                            }, function(){
                                $(this).removeClass('hover');
                            });

                            $('.DOPBookingSystemPROReservations_Navigation .remove_btn', Container).hover(function(){
                                $(this).addClass('hover');
                            }, function(){
                                $(this).removeClass('hover');
                            });
                        }
                        
                        $('.DOPBookingSystemPROReservations_Navigation .previous_btn', Container).click(function(){
                            methods.generateCalendar(StartYear, CurrMonth-1);

                            if (CurrMonth == StartMonth){
                                $('.DOPBookingSystemPROReservations_Navigation .previous_btn', Container).css('display', 'none');
                            }
                        });
                        
                        $('.DOPBookingSystemPROReservations_Navigation .next_btn', Container).click(function(){
                            methods.generateCalendar(StartYear, CurrMonth+1);
                            $('.DOPBookingSystemPROReservations_Navigation .previous_btn', Container).css('display', 'block');
                        });
                        
                        $('.DOPBookingSystemPROReservations_Navigation .add_btn', Container).click(function(){
                            noMonths++;
                            methods.generateCalendar(StartYear, CurrMonth);
                            $('.DOPBookingSystemPROReservations_Navigation .remove_btn', Container).css('display', 'block');
                        });
                        
                        
                        $('.DOPBookingSystemPROReservations_Navigation .remove_btn', Container).click(function(){
                            noMonths--;
                            methods.generateCalendar(StartYear, CurrMonth);
                            
                            if(noMonths == 1){
                                $('.DOPBookingSystemPROReservations_Navigation .remove_btn', Container).css('display', 'none');
                            }
                        });
                    },
                    initReservations:function(){
                        var i;
                        
                        for (i=0; i<ReservationsData.length; i++){
                            ReservationsData[i].level = 0;
                            ReservationsData[i].info = ReservationsData[i].info == '' ? new Array():JSON.parse(ReservationsData[i].info);
                        }
                        
                        methods.showReservations();
                    },
                    showReservations:function(){
                        var i, isOK = false,
                        showStartHour = $('#DOPBSP-reservations-start-hour').val(),
                        showEndHour = $('#DOPBSP-reservations-end-hour').val(),
                        showPending = $('#DOPBSP-reservations-pending').is(':checked') ? true:false,
                        showApproved = $('#DOPBSP-reservations-approved').is(':checked') ? true:false,
                        showRejected = $('#DOPBSP-reservations-rejected').is(':checked') ? true:false,
                        showCanceled = $('#DOPBSP-reservations-canceled').is(':checked') ? true:false,
                        showPaymentNone = $('#DOPBSP-reservations-payment-none').is(':checked') ? true:false,
                        showPaymentArrival = $('#DOPBSP-reservations-payment-arrival').is(':checked') ? true:false,
                        showPaymentPayPal = $('#DOPBSP-reservations-payment-paypal').is(':checked') ? true:false;
                        
                        if (!showPending && !showApproved && !showRejected && !showCanceled){
                            showPending = true;
                            showApproved = true;
                            showRejected = true;
                            showCanceled = true;
                        }
                        
                        if (!showPaymentNone && !showPaymentArrival && !showPaymentPayPal){
                            showPaymentNone = true;
                            showPaymentArrival = true;
                            showPaymentPayPal = true;
                        }
                        
                        Reservations = [];
                        
                        for (i=0; i<ReservationsData.length; i++){
                            isOK = true;
                            
                            if (HoursAMPM && (ReservationsData[i]['end_hour'] < showStartHour || showEndHour < ReservationsData[i]['start_hour'])){
                                isOK = false;
                            }
                            
                            switch (ReservationsData[i]['status']){
                                case 'pending':
                                    if (!showPending){
                                        isOK = false;
                                    }
                                    break;
                                case 'approved':
                                    if (!showApproved){
                                        isOK = false;
                                    }
                                    break;
                                case 'rejected':
                                    if (!showRejected){
                                        isOK = false;
                                    }
                                    break;
                                case 'canceled':
                                    if (!showCanceled){
                                        isOK = false;
                                    }
                                    break;
                            }
                            
                            switch (ReservationsData[i]['payment_method']){
                                case '0':
                                    if (!showPaymentNone){
                                        isOK = false;
                                    }
                                    break;
                                case '1':
                                    if (!showPaymentArrival){
                                        isOK = false;
                                    }
                                    break;
                                case '2':
                                    if (!showPaymentPayPal){
                                        isOK = false;
                                    }
                                    break;
                            }
                            
                            if (isOK){
                                Reservations.push(ReservationsData[i]);
                            }
                        }
                        
                        for (i=0; i<Reservations.length; i++){
                            Reservations[i]['level'] = 0;
                        }
                        
                        methods.generateCalendar(StartYear, CurrMonth);
                    },
                    
                    generateCalendar:function(year, month){// Init Calendar   
                        CurrYear = new Date(year, month, 0).getFullYear();
                        CurrMonth = parseInt(month, 10);    
                                                
                        $('.DOPBookingSystemPROReservations_Navigation .month_year', Container).html(MonthNames[(CurrMonth%12 != 0 ? CurrMonth%12:12)-1]+' '+CurrYear);                        
                        $('.DOPBookingSystemPROReservations_Calendar', Container).html('');                        
                        
                        for (var i=1; i<=noMonths; i++){
                            methods.initMonth(CurrYear, month = month%12 != 0 ? month%12:12, i);
                            month++;
                            
                            if (month % 12 == 1){
                                CurrYear++;
                                month = 1;
                            }                            
                        }
                    },
                    initMonth:function(year, month, position){// Init Month
                        var i, d, cyear, cmonth, cday, start, totalDays = 0,
                        noDays = new Date(year, month, 0).getDate(),
                        noDaysPreviousMonth = new Date(year, month-1, 0).getDate(),
                        firstDay = new Date(year, month-1, 2-FirstDay).getDay(),
                        lastDay = new Date(year, month-1, noDays-FirstDay+1).getDay(),
                        monthHTML = new Array();
                                 
                        dayNo = 0;
                        
                        monthHTML.push('<table class="DOPBookingSystemPROReservations_Month">');
                        monthHTML.push('    <tbody>');
                        
                        if (position > 1){
                            monthHTML.push('<div class="month_year">'+MonthNames[(month%12 != 0 ? month%12:12)-1]+' '+year+'</div>');
                        }
                                                
                        if (firstDay == 0){
                            start = 7;
                        }
                        else{
                            start = firstDay;
                        }
                        
                        for (i=start-1; i>=1; i--){
                            totalDays++;
                            
                            d = new Date(year, month-2, noDaysPreviousMonth-i+1);
                            cyear = d.getFullYear();
                            cmonth = prototypes.timeLongItem(d.getMonth()+1);
                            cday = prototypes.timeLongItem(d.getDate());
                            
                            if (StartYear == year && StartMonth == month){
                                monthHTML.push(methods.initDay('past_day', 
                                                               ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));            
                            }
                            else{
                                monthHTML.push(methods.initDay('last_month'+(position>1 ?  ' mask':''), 
                                                               position > 1 ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_last':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));
                            }
                        }
                        
                        for (i=1; i<=noDays; i++){
                            totalDays++;
                            
                            d = new Date(year, month-1, i);
                            cyear = d.getFullYear();
                            cmonth = prototypes.timeLongItem(d.getMonth()+1);
                            cday = prototypes.timeLongItem(d.getDate());
                            
                            if (StartYear == year && StartMonth == month && StartDay > d.getDate()){
                                monthHTML.push(methods.initDay('past_day', 
                                                               ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));    
                            }
                            else{
                                monthHTML.push(methods.initDay('curr_month', 
                                                               ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));
                            }
                        }

                        if (totalDays+7 < 42){
                            for (i=1; i<=14-lastDay; i++){
                                d = new Date(year, month, i);
                                cyear = d.getFullYear();
                                cmonth = prototypes.timeLongItem(d.getMonth()+1);
                                cday = prototypes.timeLongItem(d.getDate());
                            
                                monthHTML.push(methods.initDay('next_month'+(position<noMonths ?  ' hide':''), 
                                                               position<noMonths ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_next':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));
                            }
                        }
                        else{
                            for (i=1; i<=7-lastDay; i++){
                                d = new Date(year, month, i);
                                cyear = d.getFullYear();
                                cmonth = prototypes.timeLongItem(d.getMonth()+1);
                                cday = prototypes.timeLongItem(d.getDate());
                                
                                monthHTML.push(methods.initDay('next_month'+(position<noMonths ?  ' hide':''), 
                                                               position < noMonths ? ID+'_'+cyear+'-'+cmonth+'-'+cday+'_next':ID+'_'+cyear+'-'+cmonth+'-'+cday, 
                                                               d.getDate()));
                            }
                        }

                        monthHTML.push('    </tbody>');
                        monthHTML.push('</table>');
                        
                        $('.DOPBookingSystemPROReservations_Calendar', Container).append(monthHTML.join(''));
                        
                        methods.initDayEvents();
                    },
                    
                    initDay:function(type, id, day){// Init Day
                        var i, j, k, dayHTML = Array(),
                        date = id.split('_')[1],
                        blocks = new Array(),
                        levels = new Array(),
                        info = '';
                        
                        dayNo++;
                        
                        for (i=0; i<(Reservations.length > 5 ? Reservations.length:5); i++){
                            levels[i] = false;
                            blocks[i] = '<div class="block">';
                            blocks[i] += '<div class="bind-left"></div>';
                            blocks[i] += '<div class="bind-content"></div>';
                            blocks[i] += '<div class="bind-right"></div>';
                            blocks[i] += '</div>';
                        }
                        
                        if (dayNo % 7 == 1){
                            dayHTML.push('<tr>');
                        }                       
                        dayHTML.push('<td class="DOPBookingSystemPROReservations_Day '+type+'" id="reservations_'+id+'">');
                        dayHTML.push('  <div class="header">'+day+'</div>');
                        dayHTML.push('  <div class="content">');
                        
                        for (i=0; i<Reservations.length; i++){
                            info = Reservations[i]['start_hour'] == '' ? '':(HoursAMPM ? prototypes.timeToAMPM(Reservations[i]['start_hour']):Reservations[i]['start_hour']);
                            info += Reservations[i]['end_hour'] == '' ? '':'-'+(HoursAMPM ? prototypes.timeToAMPM(Reservations[i]['end_hour']):Reservations[i]['end_hour']);
                            
                            for (k=0; k<Reservations[i]['info'].length; k++){
                                info += ' '+Reservations[i]['info'][k]['value'];
                            }
                            
                            if ((Reservations[i]['check_in'] <= date && date <= Reservations[i]['check_out']) || (Reservations[i]['check_in'] == date && Reservations[i]['check_out'] == '')){
                                if (Reservations[i]['level'] == 0){
                                    for (j=0; j<Reservations.length; j++){
                                        if (!levels[j]){
                                            levels[j] = true;
                                            Reservations[i]['level'] = j;
                                            
                                            blocks[j] = '';
                                            blocks[j] += '<div class="block">';
                                            blocks[j] += '<div class="bind-left '+(Reservations[i]['check_in'] < date ? 'reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']:'')+'" id="reservations_'+id+'_left_'+i+'"></div>';
                                            blocks[j] += '<div class="bind-content reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']+'" id="reservations_'+id+'_content_'+i+'">'+(Reservations[i]['check_in'] == date ? info:'')+'</div>';
                                            blocks[j] += '<div class="bind-right '+(date < Reservations[i]['check_out'] ? 'reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']:'')+'" id="reservations_'+id+'_right_'+i+'"></div>';
                                            blocks[j] += '</div>';
                                            break;
                                        }
                                    }
                                }
                                else{
                                    levels[Reservations[i]['level']] = true;
                                    blocks[Reservations[i]['level']] = '';
                                    blocks[Reservations[i]['level']] += '<div class="block">';
                                    blocks[Reservations[i]['level']] += '<div class="bind-left '+(Reservations[i]['check_in'] < date ? 'reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']:'')+'" id="reservations_'+id+'_left_'+i+'"></div>';
                                    blocks[Reservations[i]['level']] += '<div class="bind-content reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']+'" id="reservations_'+id+'_left_'+i+'">'+(Reservations[i]['check_in'] == date ? info:'')+'</div>';
                                    blocks[Reservations[i]['level']] += '<div class="bind-right '+(date < Reservations[i]['check_out'] ? 'reservation-block-'+Reservations[i]['id']+' '+Reservations[i]['status']:'')+'" id="reservations_'+id+'_left_'+i+'"></div>';
                                    blocks[Reservations[i]['level']] += '</div>';
                                }
                            }
                        }
                        
                        for (i=blocks.length; i>=5; i--){
                            if (!levels[i]){
                                blocks.splice(i, 1);
                            }
                            else{
                                break;
                            }
                        }
                        
                        dayHTML.push(blocks.join(''));
                        dayHTML.push('  </div>');
                        dayHTML.push('</td>');
                        
                        if (dayNo % 7 == 0){
                            dayHTML.push('</tr>');
                        }
                        
                        return dayHTML.join('');
                    },                    
                    initDayEvents:function(){// Init Events for the days of the Calendar.
                        $('.DOPBookingSystemPROReservations_Day .bind-left.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.expired', Container).hover(function(){
                            if (!$('#DOPBookingSystemPROReservations_Info'+ID).hasClass('is-editable')){
                                methods.showInfo(parseInt($(this).attr('id').split('_')[4], 10));
                            }
                        }, function(){
                            methods.hideInfo();
                        });
                        
                        $('.DOPBookingSystemPROReservations_Day .bind-left.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.expired', Container).unbind('click');
                        $('.DOPBookingSystemPROReservations_Day .bind-left.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.pending,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.approved,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.rejected,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.canceled,\n\
                           .DOPBookingSystemPROReservations_Day .bind-left.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-content.expired,\n\
                           .DOPBookingSystemPROReservations_Day .bind-right.expired', Container).bind('click', function(){
                            if (!$('#DOPBookingSystemPROReservations_Info'+ID).hasClass('is-editable')){
                                $('#DOPBookingSystemPROReservations_Info'+ID).addClass('is-editable');
                            }
                            else{
                                $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                            }
                            methods.showInfo(parseInt($(this).attr('id').split('_')[4], 10));
                            methods.moveInfo();
                        });
                    },
                    
                    initInfo:function(){
                        $(document).mousemove(function(e){
                            infoXPos = e.pageX+30;
                            infoYPos = e.pageY;

                            if ($(window).width() < infoXPos+$('#DOPBookingSystemPROReservations_Info'+ID).width()+parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-left'))+parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-right'))){
                                infoXPos = infoXPos-$('#DOPBookingSystemPROReservations_Info'+ID).width()-parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-left'))-parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-right'))-60;
                            }

                            if ($(document).scrollTop()+$(window).height() < infoYPos+$('#DOPBookingSystemPROReservations_Info'+ID).height()+parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-top'))+parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-bottom'))+10){
                                infoYPos = $(document).scrollTop()+$(window).height()-$('#DOPBookingSystemPROReservations_Info'+ID).height()-parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-top'))-parseInt($('#DOPBookingSystemPROReservations_Info'+ID).css('padding-bottom'))-10;
                            }
                            
                            methods.moveInfo();
                        }); 
                    },
                    moveInfo:function(){
                        if (!$('#DOPBookingSystemPROReservations_Info'+ID).hasClass('is-editable')){
                            $('#DOPBookingSystemPROReservations_Info'+ID).css({'left': infoXPos, 'top': infoYPos});
                        }
                    },
                    showInfo:function(reservationNo){
                        var HTML = new Array(), i, j, status, value,
                        approveEvent = false,
                        rejectEvent = false,
                        cancelEvent = false,
                        deleteEvent = false,
                        jumpEvent = false,
                        dcHourFull = Reservations[reservationNo]['date_created'].split(' ')[1],
                        dcHour = dcHourFull.split(':')[0]+':'+dcHourFull.split(':')[1],
                        dcDate = Reservations[reservationNo]['date_created'].split(' ')[0],
                        dcYear = dcDate.split('-')[0],
                        dcMonth = dcDate.split('-')[1],
                        dcMonthText = MonthNames[parseInt(dcMonth, 10)-1],
                        dcDay = dcDate.split('-')[2],
                        ciYear = Reservations[reservationNo]['check_in'].split('-')[0],
                        ciMonth = Reservations[reservationNo]['check_in'].split('-')[1],
                        ciMonthText = MonthNames[parseInt(ciMonth, 10)-1],
                        ciDay = Reservations[reservationNo]['check_in'].split('-')[2],
                        coYear = Reservations[reservationNo]['check_out'] != '' ? Reservations[reservationNo]['check_out'].split('-')[0]:'',
                        coMonth = Reservations[reservationNo]['check_out'] != '' ? Reservations[reservationNo]['check_out'].split('-')[1]:'',
                        coMonthText = Reservations[reservationNo]['check_out'] != '' ? MonthNames[parseInt(coMonth, 10)-1]:'',
                        coDay = Reservations[reservationNo]['check_out'] != '' ? Reservations[reservationNo]['check_out'].split('-')[2]:'';
                        
                        switch (Reservations[reservationNo]['status']){
                            case 'pending':
                                status = StatusPendingLabel;
                                break;
                            case 'approved':
                                status = StatusApprovedLabel;
                                break;
                            case 'rejected':
                                status = StatusRejectedLabel;
                                break;
                            case 'canceled':
                                status = StatusCanceledLabel;
                                break;
                            default:
                                status = StatusExpiredLabel;
                        }
                        
                        HTML.push('<div class="info-container">');
                        HTML.push('     <label>ID</label>');
                        HTML.push('     <div class="value">'+Reservations[reservationNo]['id']+'</div>');
                        HTML.push('     <br class="DOPBSP-clear" />');
                        HTML.push('</div>');
                        HTML.push('<div class="info-container">');
                        HTML.push('     <label>'+StatusLabel+'</label>');
                        HTML.push('     <div class="value">'+status+'</div>');
                        HTML.push('     <br class="DOPBSP-clear" />');
                        HTML.push('</div>');
                        HTML.push('<div class="info-container">');
                        HTML.push('     <label>'+DateCreatedLabel+'</label>');
                        HTML.push('     <div class="value">'+(DateType == 1 ? dcMonthText+' '+dcDay+', '+dcYear:dcDay+' '+dcMonthText+' '+dcYear)+' '+(HoursAMPM ? prototypes.timeToAMPM(dcHour):dcHour)+'</div>');
                        HTML.push('     <br class="DOPBSP-clear" />');
                        HTML.push('</div>');
                        HTML.push('<br />');
                        
                        HTML.push('<div class="info-container">');
                        HTML.push('     <label>'+CheckInLabel+'</label>');
                        HTML.push('     <div class="value">'+(DateType == 1 ? ciMonthText+' '+ciDay+', '+ciYear:ciDay+' '+ciMonthText+' '+ciYear)+'</div>');
                        HTML.push('     <br class="DOPBSP-clear" />');
                        HTML.push('</div>');
                        
                        if (Reservations[reservationNo]['check_out'] != ''){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+CheckOutLabel+'</label>');
                            HTML.push('     <div class="value">'+(DateType == 1 ? coMonthText+' '+coDay+', '+coYear:coDay+' '+coMonthText+' '+coYear)+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (Reservations[reservationNo]['start_hour'] != ''){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+HourStartLabel+'</label>');
                            HTML.push('     <div class="value">'+(HoursAMPM ? prototypes.timeToAMPM(Reservations[reservationNo]['start_hour']):Reservations[reservationNo]['start_hour'])+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (Reservations[reservationNo]['end_hour'] != ''){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+HourEndLabel+'</label>');
                            HTML.push('     <div class="value">'+(HoursAMPM ? prototypes.timeToAMPM(Reservations[reservationNo]['end_hour']):Reservations[reservationNo]['end_hour'])+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        HTML.push('<br />');
                        
                        if (Reservations[reservationNo]['payment_method'] != '0'){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+PaymentMethodLabel+'</label>');
                            HTML.push('     <div class="value">'+(Reservations[reservationNo]['payment_method'] == '1' ? 'Arrival':'PayPal')+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (Reservations[reservationNo]['paypal_transaction_id'] != ''){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+TransactionIDLabel+'</label>');
                            HTML.push('     <div class="value">'+Reservations[reservationNo]['paypal_transaction_id']+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
//                        if (NoItemsEnabled){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+NoItemsLabel+'</label>');
                            HTML.push('     <div class="value">'+Reservations[reservationNo]['no_items']+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
//                        }
                        
                        if (Reservations[reservationNo]['no_people'] != '' && parseFloat(Reservations[reservationNo]['no_people']) != 0){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+(Reservations[reservationNo]['no_children'] == '' ? PeopleLabel:AdultsLabel)+'</label>');
                            HTML.push('     <div class="value">'+Reservations[reservationNo]['no_people']+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (Reservations[reservationNo]['no_children'] != '' && parseFloat(Reservations[reservationNo]['no_children']) != 0){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+ChildrenLabel+'</label>');
                            HTML.push('     <div class="value">'+Reservations[reservationNo]['no_children']+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (parseFloat(Reservations[reservationNo]['price']) != 0){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+PriceLabel+'</label>');
                            HTML.push('     <div class="value">'+Currency+prototypes.getWithDecimals(Reservations[reservationNo]['price'])+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (parseFloat(Reservations[reservationNo]['deposit']) != 0){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+DepositLabel+'</label>');
                            HTML.push('     <div class="value">'+Currency+prototypes.getWithDecimals(Reservations[reservationNo]['deposit'])+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+LeftToPayLabel+'</label>');
                            HTML.push('     <div class="value">'+Currency+prototypes.getWithDecimals(Reservations[reservationNo]['price']-Reservations[reservationNo]['deposit'])+'</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        
                        if (parseFloat(Reservations[reservationNo]['total_price']) != 0 && parseFloat(Reservations[reservationNo]['total_price']) != parseFloat(Reservations[reservationNo]['price'])){
                            HTML.push('<div class="info-container">');
                            HTML.push('     <label>'+DiscountLabel+'</label>');
                            HTML.push('     <div class="value">'+Currency+prototypes.getWithDecimals(Reservations[reservationNo]['total_price'])+'('+Reservations[reservationNo]['discount']+' % '+DiscountInfoLabel+')</div>');
                            HTML.push('     <br class="DOPBSP-clear" />');
                            HTML.push('</div>');
                        }
                        HTML.push('<br />');
                        
                        if (Reservations[reservationNo]['info'].length > 0){
                            for (i=0; i<Reservations[reservationNo]['info'].length; i++){
                                HTML.push('<div class="info-container">');
                                HTML.push('     <label>'+Reservations[reservationNo]['info'][i]['name']+'</label>');
                                HTML.push('     <div class="value">');
                                
                                if (Object.prototype.toString.call(Reservations[reservationNo]['info'][i]['value']) === '[object Array]'){
                                    for (j=0; j<Reservations[reservationNo]['info'][i]['value'].length; j++){
                                        value = Reservations[reservationNo]['info'][i]['value'][j]['translation'];
                                        
                                        if (j == 1){
                                            HTML.push((prototypes.validEmail(value) ? '<a href="mailto:'+value+'">'+value+'</a>':value)+'</div>');
                                        }
                                        else{
                                            HTML.push(', '+(prototypes.validEmail(value) ? '<a href="mailto:'+value+'">'+value+'</a>':value)+'</div>');
                                        }
                                    }
                                }
                                else{
                                    if (Reservations[reservationNo]['info'][i]['value'] == 'true'){
                                        value = 'Checked';
                                    }
                                    else if (Reservations[reservationNo]['info'][i]['value'] == 'false'){
                                        value = 'Unchecked';
                                    }
                                    else{
                                        value = Reservations[reservationNo]['info'][i]['value'];
                                    }
                                    HTML.push((prototypes.validEmail(value) ? '<a href="mailto:'+value+'">'+value+'</a>':value)+'</div>');
                                }
                                HTML.push('     <br class="DOPBSP-clear" />');
                                HTML.push('</div>');
                            }
                        }
                        
                        HTML.push('<div class="instructions-container">['+ClikToEditLabel+']</div>');
                        HTML.push('<div class="buttons-container">');
                        
                        switch (Reservations[reservationNo]['status']){
                            case 'pending':
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationApprove" id="DOPBookingSystemPROReservations_ReservationApprove'+ID+'">'+ButtonApproveLabel+'</a>');                  
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationReject" id="DOPBookingSystemPROReservations_ReservationReject'+ID+'">'+ButtonRejectLabel+'</a>');
                                approveEvent = true;
                                rejectEvent = true;
                                jumpEvent = true;
                                break;
                            case 'approved':
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationCancel" id="DOPBookingSystemPROReservations_ReservationCancel'+ID+'">'+ButtonCancelLabel+'</a>');
                                cancelEvent = true;
                                jumpEvent = true;
                                break;
                            case 'rejected':
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationApprove" id="DOPBookingSystemPROReservations_ReservationApprove'+ID+'">'+ButtonApproveLabel+'</a>');                  
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationDelete" id="DOPBookingSystemPROReservations_ReservationDelete'+ID+'">'+ButtonDeleteLabel+'</a>');                  
                                approveEvent = true;
                                deleteEvent = true;
                                jumpEvent = true;
                                break;
                            case 'canceled':
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationApprove" id="DOPBookingSystemPROReservations_ReservationApprove'+ID+'">'+ButtonApproveLabel+'</a>');                  
                                HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationDelete" id="DOPBookingSystemPROReservations_ReservationDelete'+ID+'">'+ButtonDeleteLabel+'</a>');                  
                                approveEvent = true;
                                deleteEvent = true;
                                jumpEvent = true;
                                break;
                        }
                        
                        if ($('#DOPBSP-reservations-without-calendar').val() == undefined){
                            HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationJump" id="DOPBookingSystemPROReservations_ReservationJump'+ID+'">'+ButtonJumpToDayLabel+'</a>');
                        }
                        HTML.push('<a href="javascript:void(0)" class="DOPBookingSystemPROReservations_ReservationClose" id="DOPBookingSystemPROReservations_ReservationClose'+ID+'">'+ButtonCloseLabel+'</a>');
                        HTML.push('</div>');
                        
                        $('#DOPBookingSystemPROReservations_Info'+ID).html(HTML.join(''));
                        methods.initInfoEvents(reservationNo, Reservations[reservationNo]['id'], approveEvent, rejectEvent, cancelEvent, deleteEvent, jumpEvent);
                        $('#DOPBookingSystemPROReservations_Info'+ID).css('display', 'block');                         
                    },
                    initInfoEvents:function(no, id, approve, reject, cancel, delete_e, jump){
                        currentReservation = no;
                        currentReservationID = id;
                        approve = approve == undefined ? false:approve;
                        reject = reject == undefined ? false:reject;
                        cancel = cancel == undefined ? false:cancel;
                        delete_e = delete_e == undefined ? false:delete_e;
                        jump = jump == undefined ? false:jump;
                        
                        if (approve){
                            methods.initApproveReservation();
                        }
                        
                        if (reject){
                            methods.initRejectReservation();
                        }
                        
                        if (cancel){
                            methods.initCancelReservation();
                        }
                        
                        if (delete_e){
                            methods.initDeleteReservation();
                        }
                        
                        if (jump){
                            $('#DOPBookingSystemPROReservations_ReservationJump'+ID).unbind('click');
                            $('#DOPBookingSystemPROReservations_ReservationJump'+ID).bind('click', function(){
                                var i, checkIn;

                                for (i=0; i<Reservations.length; i++){
                                    if (Reservations[i]['id'] == currentReservationID){
                                        checkIn = Reservations[i]['check_in'];
                                        break;
                                    }
                                }
                                $('#calendar_jump_to_day').val(checkIn);
                            });
                        }
                        
                        $('#DOPBookingSystemPROReservations_ReservationClose'+ID).unbind('click');
                        $('#DOPBookingSystemPROReservations_ReservationClose'+ID).bind('click', function(){
                            $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                            methods.hideInfo();
                        });
                        
                    },
                    hideInfo:function(){
                        $('#DOPBookingSystemPROReservations_Info'+ID).css('display', 'none');                        
                    },
                    
                    initApproveReservation:function(){   
                        $('#DOPBookingSystemPROReservations_ReservationApprove'+ID).unbind('click');
                        $('#DOPBookingSystemPROReservations_ReservationApprove'+ID).bind('click', function(){
                            if (confirm(DOPBSP_RESERVATIONS_APPROVE_CONFIRMATION)){
                                var wasPending = $('.reservation-block-'+currentReservationID).hasClass('pending') ? true:false,
                                noReservations = 0;

                                $('.reservation-block-'+currentReservationID).removeClass('pending').removeClass('rejected').removeClass('canceled').removeClass('expired').addClass('approved');
                                Reservations[currentReservation]['status'] = 'approved';
                                $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                                methods.hideInfo();

                                dopbspToggleReservationsMessage('show', DOPBSP_SAVE);

                                $.post(ajaxurl, {action:'dopbsp_approve_reservation', calendar_id:ID, reservation_id: currentReservationID}, function(data){
                                    if (wasPending){
                                        noReservations = $('#DOPBSP-new-reservations span').html() == '' ? 0:parseInt($('#DOPBSP-new-reservations span').html(), 10)-1;

                                        if (noReservations == 0){                                            
                                            $('#DOPBSP-new-reservations').removeClass('new');
                                            $('#DOPBSP-new-reservations span').html('');
                                        }
                                        else{                                            
                                            $('#DOPBSP-new-reservations span').html(noReservations);
                                        }
                                    }
                                    
                                    if ($('#calendar_refresh').val() != undefined){
                                        $('#calendar_refresh').val('true');
                                    }
                                    dopbspToggleReservationsMessage('hide', DOPBSP_RESERVATIONS_APPROVE_SUCCESS);
                                });   
                            }
                        });                             
                    },
                    initRejectReservation:function(){
                            $('#DOPBookingSystemPROReservations_ReservationReject'+ID).unbind('click');
                            $('#DOPBookingSystemPROReservations_ReservationReject'+ID).bind('click', function(){
                                if (confirm(DOPBSP_RESERVATIONS_REJECT_CONFIRMATION)){
                                    var wasPending = $('.reservation-block-'+currentReservationID).hasClass('pending') ? true:false,
                                    noReservations = 0;

                                    $('.reservation-block-'+currentReservationID).removeClass('pending').removeClass('approved').removeClass('canceled').removeClass('expired').addClass('rejected');
                                    Reservations[currentReservation]['status'] = 'rejected';
                                    $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                                    methods.hideInfo();

                                    dopbspToggleReservationsMessage('show', DOPBSP_SAVE);

                                    $.post(ajaxurl, {action:'dopbsp_reject_reservation', calendar_id:ID, reservation_id:currentReservationID}, function(data){
                                        if (wasPending){
                                            noReservations = $('#DOPBSP-new-reservations span').html() == '' ? 0:parseInt($('#DOPBSP-new-reservations span').html(), 10)-1;

                                            if (noReservations == 0){                                            
                                                $('#DOPBSP-new-reservations').removeClass('new');
                                                $('#DOPBSP-new-reservations span').html('');
                                            }
                                            else{                                            
                                                $('#DOPBSP-new-reservations span').html(noReservations);
                                            }
                                        }
                                        dopbspToggleReservationsMessage('hide', DOPBSP_RESERVATIONS_REJECT_SUCCESS);
                                    });
                                }
                            });
                    },
                    initCancelReservation:function(){
                        $('#DOPBookingSystemPROReservations_ReservationCancel'+ID).unbind('click');
                        $('#DOPBookingSystemPROReservations_ReservationCancel'+ID).bind('click', function(){
                            if (confirm(DOPBSP_RESERVATIONS_CANCEL_CONFIRMATION)){
                                $('.reservation-block-'+currentReservationID).removeClass('pending').removeClass('approved').removeClass('rejected').removeClass('expired').addClass('canceled');
                                Reservations[currentReservation]['status'] = 'canceled';
                                $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                                methods.hideInfo();

                                dopbspToggleReservationsMessage('show', DOPBSP_SAVE);

                                $.post(ajaxurl, {action:'dopbsp_cancel_reservation', calendar_id:ID, reservation_id:currentReservationID}, function(data){
                                    if ($('#calendar_refresh').val() != undefined){
                                        $('#calendar_refresh').val('true');
                                    }
                                    dopbspToggleReservationsMessage('hide', DOPBSP_RESERVATIONS_CANCEL_SUCCESS);
                                });
                            }
                        });
                    },
                    initDeleteReservation:function(){
                        var i;
                        
                        $('#DOPBookingSystemPROReservations_ReservationDelete'+ID).unbind('click');
                        $('#DOPBookingSystemPROReservations_ReservationDelete'+ID).bind('click', function(){
                            if (confirm(DOPBSP_RESERVATIONS_DELETE_CONFIRMATION)){
                                $('.reservation-block-'+currentReservationID).removeClass('pending').removeClass('approved').removeClass('rejected').removeClass('expired').removeClass('canceled').addClass('deleted');
                                Reservations.splice(currentReservation, 1);
                                
                                for (i=0; i<Reservations.length; i++){
                                    Reservations[i]['level'] = 0;
                                }
                                $('#DOPBookingSystemPROReservations_Info'+ID).removeClass('is-editable');
                                methods.hideInfo();

                                dopbspToggleReservationsMessage('show', DOPBSP_SAVE);

                                $.post(ajaxurl, {action: 'dopbsp_delete_reservation',
                                                 reservation_id: currentReservationID}, function(data){
                                    dopbspToggleReservationsMessage('hide', DOPBSP_RESERVATIONS_DELETE_SUCCESS);
                                });
                            }
                        });
                    }
                  },

        prototypes = {
                        resizeItem:function(parent, child, cw, ch, dw, dh, pos){// Resize & Position an item (the item is 100% visible)
                            var currW = 0, currH = 0;

                            if (dw <= cw && dh <= ch){
                                currW = dw;
                                currH = dh;
                            }
                            else{
                                currH = ch;
                                currW = (dw*ch)/dh;

                                if (currW > cw){
                                    currW = cw;
                                    currH = (dh*cw)/dw;
                                }
                            }

                            child.width(currW);
                            child.height(currH);
                            switch(pos.toLowerCase()){
                                case 'top':
                                    prototypes.topItem(parent, child, ch);
                                    break;
                                case 'bottom':
                                    prototypes.bottomItem(parent, child, ch);
                                    break;
                                case 'left':
                                    prototypes.leftItem(parent, child, cw);
                                    break;
                                case 'right':
                                    prototypes.rightItem(parent, child, cw);
                                    break;
                                case 'horizontal-center':
                                    prototypes.hCenterItem(parent, child, cw);
                                    break;
                                case 'vertical-center':
                                    prototypes.vCenterItem(parent, child, ch);
                                    break;
                                case 'center':
                                    prototypes.centerItem(parent, child, cw, ch);
                                    break;
                                case 'top-left':
                                    prototypes.tlItem(parent, child, cw, ch);
                                    break;
                                case 'top-center':
                                    prototypes.tcItem(parent, child, cw, ch);
                                    break;
                                case 'top-right':
                                    prototypes.trItem(parent, child, cw, ch);
                                    break;
                                case 'middle-left':
                                    prototypes.mlItem(parent, child, cw, ch);
                                    break;
                                case 'middle-right':
                                    prototypes.mrItem(parent, child, cw, ch);
                                    break;
                                case 'bottom-left':
                                    prototypes.blItem(parent, child, cw, ch);
                                    break;
                                case 'bottom-center':
                                    prototypes.bcItem(parent, child, cw, ch);
                                    break;
                                case 'bottom-right':
                                    prototypes.brItem(parent, child, cw, ch);
                                    break;
                            }
                        },
                        resizeItem2:function(parent, child, cw, ch, dw, dh, pos){// Resize & Position an item (the item covers all the container)
                            var currW = 0, currH = 0;

                            currH = ch;
                            currW = (dw*ch)/dh;

                            if (currW < cw){
                                currW = cw;
                                currH = (dh*cw)/dw;
                            }

                            child.width(currW);
                            child.height(currH);

                            switch(pos.toLowerCase()){
                                case 'top':
                                    prototypes.topItem(parent, child, ch);
                                    break;
                                case 'bottom':
                                    prototypes.bottomItem(parent, child, ch);
                                    break;
                                case 'left':
                                    prototypes.leftItem(parent, child, cw);
                                    break;
                                case 'right':
                                    prototypes.rightItem(parent, child, cw);
                                    break;
                                case 'horizontal-center':
                                    prototypes.hCenterItem(parent, child, cw);
                                    break;
                                case 'vertical-center':
                                    prototypes.vCenterItem(parent, child, ch);
                                    break;
                                case 'center':
                                    prototypes.centerItem(parent, child, cw, ch);
                                    break;
                                case 'top-left':
                                    prototypes.tlItem(parent, child, cw, ch);
                                    break;
                                case 'top-center':
                                    prototypes.tcItem(parent, child, cw, ch);
                                    break;
                                case 'top-right':
                                    prototypes.trItem(parent, child, cw, ch);
                                    break;
                                case 'middle-left':
                                    prototypes.mlItem(parent, child, cw, ch);
                                    break;
                                case 'middle-right':
                                    prototypes.mrItem(parent, child, cw, ch);
                                    break;
                                case 'bottom-left':
                                    prototypes.blItem(parent, child, cw, ch);
                                    break;
                                case 'bottom-center':
                                    prototypes.bcItem(parent, child, cw, ch);
                                    break;
                                case 'bottom-right':
                                    prototypes.brItem(parent, child, cw, ch);
                                    break;
                            }
                        },

                        topItem:function(parent, child, ch){// Position item on Top
                            parent.height(ch);
                            child.css('margin-top', 0);
                        },
                        bottomItem:function(parent, child, ch){// Position item on Bottom
                            parent.height(ch);
                            child.css('margin-top', ch-child.height());
                        },
                        leftItem:function(parent, child, cw){// Position item on Left
                            parent.width(cw);
                            child.css('margin-left', 0);
                        },
                        rightItem:function(parent, child, cw){// Position item on Right
                            parent.width(cw);
                            child.css('margin-left', parent.width()-child.width());
                        },
                        hCenterItem:function(parent, child, cw){// Position item on Horizontal Center
                            parent.width(cw);
                            child.css('margin-left', (cw-child.width())/2);
                        },
                        vCenterItem:function(parent, child, ch){// Position item on Vertical Center
                            parent.height(ch);
                            child.css('margin-top', (ch-child.height())/2);
                        },
                        centerItem:function(parent, child, cw, ch){// Position item on Center
                            prototypes.hCenterItem(parent, child, cw);
                            prototypes.vCenterItem(parent, child, ch);
                        },
                        tlItem:function(parent, child, cw, ch){// Position item on Top-Left
                            prototypes.topItem(parent, child, ch);
                            prototypes.leftItem(parent, child, cw);
                        },
                        tcItem:function(parent, child, cw, ch){// Position item on Top-Center
                            prototypes.topItem(parent, child, ch);
                            prototypes.hCenterItem(parent, child, cw);
                        },
                        trItem:function(parent, child, cw, ch){// Position item on Top-Right
                            prototypes.topItem(parent, child, ch);
                            prototypes.rightItem(parent, child, cw);
                        },
                        mlItem:function(parent, child, cw, ch){// Position item on Middle-Left
                            prototypes.vCenterItem(parent, child, ch);
                            prototypes.leftItem(parent, child, cw);
                        },
                        mrItem:function(parent, child, cw, ch){// Position item on Middle-Right
                            prototypes.vCenterItem(parent, child, ch);
                            prototypes.rightItem(parent, child, cw);
                        },
                        blItem:function(parent, child, cw, ch){// Position item on Bottom-Left
                            prototypes.bottomItem(parent, child, ch);
                            prototypes.leftItem(parent, child, cw);
                        },
                        bcItem:function(parent, child, cw, ch){// Position item on Bottom-Center
                            prototypes.bottomItem(parent, child, ch);
                            prototypes.hCenterItem(parent, child, cw);
                        },
                        brItem:function(parent, child, cw, ch){// Position item on Bottom-Right
                            prototypes.bottomItem(parent, child, ch);
                            prototypes.rightItem(parent, child, cw);
                        },
                        
                        touchNavigation:function(parent, child){// One finger navigation for touchscreen devices
                            var prevX, prevY, currX, currY, touch, childX, childY;
                            
                            parent.bind('touchstart', function(e){
                                touch = e.originalEvent.touches[0];
                                prevX = touch.clientX;
                                prevY = touch.clientY;
                            });

                            parent.bind('touchmove', function(e){                                
                                touch = e.originalEvent.touches[0];
                                currX = touch.clientX;
                                currY = touch.clientY;
                                childX = currX>prevX ? parseInt(child.css('margin-left'))+(currX-prevX):parseInt(child.css('margin-left'))-(prevX-currX);
                                childY = currY>prevY ? parseInt(child.css('margin-top'))+(currY-prevY):parseInt(child.css('margin-top'))-(prevY-currY);

                                if (childX < (-1)*(child.width()-parent.width())){
                                    childX = (-1)*(child.width()-parent.width());
                                }
                                else if (childX > 0){
                                    childX = 0;
                                }
                                else{                                    
                                    e.preventDefault();
                                }

                                if (childY < (-1)*(child.height()-parent.height())){
                                    childY = (-1)*(child.height()-parent.height());
                                }
                                else if (childY > 0){
                                    childY = 0;
                                }
                                else{                                    
                                    e.preventDefault();
                                }

                                prevX = currX;
                                prevY = currY;

                                if (parent.width() < child.width()){
                                    child.css('margin-left', childX);
                                }
                                
                                if (parent.height() < child.height()){
                                    child.css('margin-top', childY);
                                }
                            });

                            parent.bind('touchend', function(e){
                                if (!prototypes.isChromeMobileBrowser()){
                                    e.preventDefault();
                                }
                            });
                        },

			rgb2hex:function(rgb){// Convert RGB color to HEX
                            var hexDigits = new Array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

                            rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

                            return (isNaN(rgb[1]) ? '00':hexDigits[(rgb[1]-rgb[1]%16)/16]+hexDigits[rgb[1]%16])+
                                   (isNaN(rgb[2]) ? '00':hexDigits[(rgb[2]-rgb[2]%16)/16]+hexDigits[rgb[2]%16])+
                                   (isNaN(rgb[3]) ? '00':hexDigits[(rgb[3]-rgb[3]%16)/16]+hexDigits[rgb[3]%16]);
			},
			idealTextColor:function(bgColor){// Set text color depending on the background color
			    var rgb = /rgb\((\d+).*?(\d+).*?(\d+)\)/.exec(bgColor);
    
			    if (rgb != null){
			        return parseInt(rgb[1], 10)+parseInt(rgb[2], 10)+parseInt(rgb[3], 10) < 3*256/2 ? 'white' : 'black';
			    }
			    else{
			        return parseInt(bgColor.substring(0, 2), 16)+parseInt(bgColor.substring(2, 4), 16)+parseInt(bgColor.substring(4, 6), 16) < 3*256/2 ? 'white' : 'black';
			    }
			},

                        dateDiference:function(date1, date2){// Diference between 2 dates
                            var time1 = date1.getTime(),
                            time2 = date2.getTime(),
                            diff = Math.abs(time1-time2),
                            one_day = 1000*60*60*24;
                            
                            return parseInt(diff/(one_day))+1;
                        },
                        previousTime:function(time, size, type){
                            var timePieces = time.split(':'),
                            hours = parseInt(timePieces[0], 10),
                            minutes = timePieces[1] == undefined ? 0:parseInt(timePieces[1], 10),
                            seconds = timePieces[2] == undefined ? 0:parseInt(timePieces[2], 10);
                            
                            switch (type){
                                case 'seconds':
                                    seconds = seconds-size;
                                    
                                    if (seconds < 0){
                                        seconds = 60+seconds;
                                        minutes = minutes-1;
                                        
                                        if (minutes < 0){
                                            minutes = 60+minutes;
                                            hours = hours-1 < 0 ? 0:hours-1;
                                        }
                                    }
                                    break;
                                case 'minutes':
                                        minutes = minutes-size;
                                        
                                        if (minutes < 0){
                                            minutes = 60+minutes;
                                            hours = hours-1 < 0 ? 0:hours-1;
                                        }
                                    break;
                                default:
                                    hours = hours-size < 0 ? 0:hours-size;
                            }
                            
                            return prototypes.timeLongItem(hours)+(timePieces[1] == undefined ? '':':'+prototypes.timeLongItem(minutes)+(timePieces[2] == undefined ? '':':'+prototypes.timeLongItem(seconds)));
                        },
                        noDays:function(date1, date2){// Returns no of days between 2 days
                            var time1 = date1.getTime(),
                            time2 = date2.getTime(),
                            diff = Math.abs(time1-time2),
                            one_day = 1000*60*60*24;
                            
                            return Math.round(diff/(one_day))+1;
                        },
                        timeLongItem:function(item){// Return day/month with 0 in front if smaller then 10
                            if (item < 10){
                                return '0'+item;
                            }
                            else{
                                return item;
                            }
                        },
                        timeToAMPM:function(item){// Returns time in AM/PM format
                            var hour = parseInt(item.split(':')[0], 10),
                            minutes = item.split(':')[1],
                            result = '';
                            
                            if (hour == 0){
                                result = '12';
                            }
                            else if (hour > 12){
                                result = prototypes.timeLongItem(hour-12);
                            }
                            else{
                                result = prototypes.timeLongItem(hour);
                            }
                            
                            result += ':'+minutes+' '+(hour < 12 ? 'AM':'PM');
                            
                            return result;
                        },

                        stripslashes:function(str){// Remove slashes from string
                            return (str + '').replace(/\\(.?)/g, function (s, n1) {
                                switch (n1){
                                    case '\\':
                                        return '\\';
                                    case '0':
                                        return '\u0000';
                                    case '':
                                        return '';
                                    default:
                                        return n1;
                                }
                            });
                        },
                        
                        randomize:function(theArray){// Randomize the items of an array
                            theArray.sort(function(){
                                return 0.5-Math.random();
                            });
                            return theArray;
                        },
                        randomString:function(string_length){// Create a string with random elements
                            var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz",
                            random_string = '';

                            for (var i=0; i<string_length; i++){
                                var rnum = Math.floor(Math.random()*chars.length);
                                random_string += chars.substring(rnum,rnum+1);
                            }
                            return random_string;
                        },

                        isIE8Browser:function(){// Detect the browser IE8
                            var isIE8 = false,
                            agent = navigator.userAgent.toLowerCase();

                            if (agent.indexOf('msie 8') != -1){
                                isIE8 = true;
                            }
                            return isIE8;
                        },
                        isIEBrowser:function(){// Detect the browser IE
                            var isIE = false,
                            agent = navigator.userAgent.toLowerCase();

                            if (agent.indexOf('msie') != -1){
                                isIE = true;
                            }
                            return isIE;
                        },
                        isChromeMobileBrowser:function(){// Detect the browser Mobile Chrome
                            var isChromeMobile = false,
                            agent = navigator.userAgent.toLowerCase();
                            
                            if ((agent.indexOf('chrome') != -1 || agent.indexOf('crios') != -1) && prototypes.isTouchDevice()){
                                isChromeMobile = true;
                            }
                            return isChromeMobile;
                        },
                        isAndroid:function(){// Detect the browser Mobile Chrome
                            var isAndroid = false,
                            agent = navigator.userAgent.toLowerCase();

                            if (agent.indexOf('android') != -1){
                                isAndroid = true;
                            }
                            return isAndroid;
                        },
                        isTouchDevice:function(){// Detect touchscreen devices
                            var os = navigator.platform;
                            
                            if (os.toLowerCase().indexOf('win') != -1){
                                return window.navigator.msMaxTouchPoints;
                            }
                            else {
                                return 'ontouchstart' in document;
                            }
                        },

                        openLink:function(url, target){// Open a link
                            switch (target.toLowerCase()){
                                case '_blank':
                                    window.open(url);
                                    break;
                                case '_top':
                                    top.location.href = url;
                                    break;
                                case '_parent':
                                    parent.location.href = url;
                                    break;
                                default:    
                                    window.location = url;
                            }
                        },

                        validateCharacters:function(str, allowedCharacters){// Verify if a string contains allowed characters
                            var characters = str.split(''), i;

                            for (i=0; i<characters.length; i++){
                                if (allowedCharacters.indexOf(characters[i]) == -1){
                                    return false;
                                }
                            }
                            return true;
                        },
                        cleanInput:function(input, allowedCharacters, firstNotAllowed, min){// Remove characters that aren't allowed from a string
                            var characters = $(input).val().split(''),
                            returnStr = '', i, startIndex = 0;

                            if (characters.length > 1 && characters[0] == firstNotAllowed){
                                startIndex = 1;
                            }
                            
                            for (i=startIndex; i<characters.length; i++){
                                if (allowedCharacters.indexOf(characters[i]) != -1){
                                    returnStr += characters[i];
                                }
                            }
                                
                            if (min > returnStr){
                                returnStr = min;
                            }
                            
                            $(input).val(returnStr);
                        },
                        getWithDecimals:function(number, length){
                            length = length == undefined ? 2:length;
                            
                            return parseInt(number) == number ? String(number):parseFloat(number).toFixed(length);
                        },
                        validEmail:function(email){// Validate email
                            var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                            
                            if (filter.test(email)){
                                return true;
                            }
                            return false;
                        },
                        
                        $_GET:function(variable){// Parse $_GET variables
                            var url = window.location.href.split('?')[1],
                            variables = url != undefined ? url.split('&'):[],
                            i; 
                            
                            for (i=0; i<variables.length; i++){
                                if (variables[i].indexOf(variable) != -1){
                                    return variables[i].split('=')[1];
                                    break;
                                }
                            }
                            
                            return undefined;
                        },
                        acaoBuster:function(dataURL){// Access-Control-Allow-Origin buster
                            var topURL = window.location.href,
                            pathPiece1 = '', pathPiece2 = '';
                            
                            if (prototypes.getDomain(topURL) == prototypes.getDomain(dataURL)){
                                if (dataURL.indexOf('https') != -1 || dataURL.indexOf('http') != -1){
                                    if (topURL.indexOf('http://www.') != -1){
                                        pathPiece1 = 'http://www.';
                                    }
                                    else if (topURL.indexOf('http://') != -1){
                                        pathPiece1 = 'http://';
                                    }
                                    else if (topURL.indexOf('https://www.') != -1){
                                        pathPiece1 = 'https://www.';
                                    }
                                    else if (topURL.indexOf('https://') != -1){
                                        pathPiece1 = 'https://';
                                    }

                                    if (dataURL.indexOf('http://www.') != -1){
                                        pathPiece2 = dataURL.split('http://www.')[1];
                                    }
                                    else if (dataURL.indexOf('http://') != -1){
                                        pathPiece2 = dataURL.split('http://')[1];
                                    }
                                    else if (dataURL.indexOf('https://www.') != -1){
                                        pathPiece2 = dataURL.split('https://www.')[1];
                                    }
                                    else if (dataURL.indexOf('https://') != -1){
                                        pathPiece2 = dataURL.split('https://')[1];
                                    }

                                    return pathPiece1+pathPiece2;
                                }
                                else{
                                    return dataURL;
                                }
                            }
                            else{
                                return dataURL;
                            }
                        },
                        getDomain:function(url, includeSubdomain){
                            var domain = url;
                            includeSubdomain = includeSubdomain == undefined ? true:false;
 
                            domain = domain.replace(new RegExp(/^\s+/),""); // Remove white spaces from the begining of the url.
                            domain = domain.replace(new RegExp(/\s+$/),""); // Remove white spaces from the end of the url.
                            domain = domain.replace(new RegExp(/\\/g),"/"); // If found , convert back slashes to forward slashes.
                            domain = domain.replace(new RegExp(/^http\:\/\/|^https\:\/\/|^ftp\:\/\//i),""); // If there, removes 'http://', 'https://' or 'ftp://' from the begining.
                            domain = domain.replace(new RegExp(/^www\./i),""); // If there, removes 'www.' from the begining.
                            domain = domain.replace(new RegExp(/\/(.*)/),""); // Remove complete string from first forward slaash on.

                            return domain;
                        },
                        isSubdomain:function(url){
                            var subdomain;
 
                            url = url.replace(new RegExp(/^\s+/),""); // Remove white spaces from the begining of the url.
                            url = url.replace(new RegExp(/\s+$/),""); // Remove white spaces from the end of the url.
                            url = url.replace(new RegExp(/\\/g),"/"); // If found , convert back slashes to forward slashes.
                            url = url.replace(new RegExp(/^http\:\/\/|^https\:\/\/|^ftp\:\/\//i),""); // If there, removes 'http://', 'https://' or 'ftp://' from the begining.
                            url = url.replace(new RegExp(/^www\./i),""); // If there, removes 'www.' from the begining.
                            url = url.replace(new RegExp(/\/(.*)/),""); // Remove complete string from first forward slaash on.
 
                            if (url.match(new RegExp(/\.[a-z]{2,3}\.[a-z]{2}$/i))){ // Remove '.??.??' or '.???.??' from end - e.g. '.CO.UK', '.COM.AU'
                                url = url.replace(new RegExp(/\.[a-z]{2,3}\.[a-z]{2}$/i),"");
                            }
                            else if (url.match(new RegExp(/\.[a-z]{2,4}$/i))){ // Removes '.??' or '.???' or '.????' from end - e.g. '.US', '.COM', '.INFO'
                                url = url.replace(new RegExp(/\.[a-z]{2,4}$/i),"");
                            }
                            subdomain = (url.match(new RegExp(/\./g))) ? true : false; // Check to see if there is a dot '.' left in the string.

                            return(subdomain);
                        },
                        
                        doHideBuster:function(item){// Make all parents & current item visible
                            var parent = item.parent(),
                            items = new Array();
                                
                            if (item.prop('tagName') != undefined && item.prop('tagName').toLowerCase() != 'body'){
                                items = prototypes.doHideBuster(parent);
                            }
                            
                            if (item.css('display') == 'none'){
                                item.css('display', 'block');
                                items.push(item);
                            }
                            
                            return items;
                        },
                        undoHideBuster:function(items){// Hide items in the array
                            var i;
                            
                            for (i=0; i<items.length; i++){
                                items[i].css('display', 'none');
                            }
                        },
                       
                        setCookie:function(c_name, value, expiredays){// Set cookie (name, value, expire in no days)
                            var exdate = new Date();
                            exdate.setDate(exdate.getDate()+expiredays);

                            document.cookie = c_name+"="+escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toUTCString())+";javahere=yes;path=/";
                        },
                        readCookie:function(name){// Read cookie (name) 
                            var nameEQ = name+"=",
                            ca = document.cookie.split(";");

                            for (var i=0; i<ca.length; i++){
                                var c = ca[i];

                                while (c.charAt(0)==" "){
                                    c = c.substring(1,c.length);            
                                } 

                                if (c.indexOf(nameEQ) == 0){
                                    return unescape(c.substring(nameEQ.length, c.length));
                                } 
                            }
                            return null;
                        },
                        deleteCookie:function(c_name, path, domain){// Delete cookie (name, path, domain)
                            if (readCookie(c_name)){
                                document.cookie = c_name+"="+((path) ? ";path="+path:"")+((domain) ? ";domain="+domain:"")+";expires=Thu, 01-Jan-1970 00:00:01 GMT";
                            }
                        }
                    };

        return methods.init.apply(this);
    }
})(jQuery);