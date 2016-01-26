
/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : jquery.dop.BackendBookingSystemPROAddReservation.js
* File Version            : 1.2
* Created / Last Modified : 25 December 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Add Reservation jQuery plugin.
*/

(function($){
    $.fn.DOPBookingSystemPROAddReservation = function(options){
        var Data = {'AddReservationSuccess': 'Success! Reservation has been added.',
                    'AddLastHourToTotalPrice': true,
                    'CheckInLabel': 'Check In',
                    'CheckOutLabel': 'Check Out',
                    'Currency': '$',
                    'CurrencyCode': 'USD',
                    'DateType': 1,
                    'DayNames': ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    'DayShortNames': ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    'Deposit': 0,
                    'DepositText': 'deposit',
                    'DiscountsNoDays': [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    'DiscountText': 'discount',
                    'EndHourLabel': 'Finish at',
                    'FirstDay': 1,
                    'Form': [],
                    'FormID': 1,
                    'FormEmailInvalid': 'is invalid. Please enter a valid Email.',
                    'FormRequired': 'is required.',
                    'FormTitle': 'Contact Information',
                    'HoursAMPM': 'false',
                    'HoursEnabled': 'false',
                    'HoursDefinitions': [{"value": "00:00"}],
                    'HoursIntervalEnabled': false,
                    'ID': 0,
                    'Language': 'en',
                    'MaxNoChildren': 2,
                    'MaxNoPeople': 4,
                    'MaxYear': new Date().getFullYear(),
                    'MaxStay': 0,
                    'MinNoChildren': 0, 
                    'MinNoPeople': 1,
                    'MinStay': 1,
                    'MonthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    'MonthShortNames': ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    'MorningCheckOut': 'false',
                    'MultipleDaysSelect': 'true',
                    'MultipleHoursSelect': 'true',
                    'NoAdultsLabel': 'No Adults',
                    'NoChildrenEnabled': 'true',
                    'NoChildrenLabel': 'No Chilren',
                    'NoItemsEnabled': true,
                    'NoItemsLabel': 'No book items',
                    'NoPeopleLabel': 'No People',
                    'NoPeopleEnabled': 'true',
                    'NoServicesAvailableText': 'There are no services available for the period you selected.',
                    'PaymentArrivalEnabled': 'true',
                    'PaymentArrivalLabel': 'On Arrival',
                    'PaymentMethodLabel': 'Payment Method',
                    'PaymentNoneLabel': 'None',
                    'PaymentPayPalEnabled': 'true',
                    'PaymentPayPalLabel': 'PayPal',
                    'PaymentPayPalTransactionIDLabel': 'PayPal Transaction ID',
                    'PluginURL': '',
                    'Reinitialize': 'false',
                    'StartHourLabel': 'Start at',
                    'StatusApprovedLabel': 'Approved',
                    'StatusLabel': 'Status',
                    'StatusPendingLabel': 'Pending',
                    'TotalPriceLabel': 'Total:'},
        Container = this,

        Schedule = {},

        StartDate = new Date(),
        StartYear = StartDate.getFullYear(),
        StartMonth = StartDate.getMonth()+1,
        StartDay = StartDate.getDate(),
        
        AddReservationSuccess = 'Success! Reservation has been added.',
        AddLastHourToTotalPrice = true,
        CheckInLabel = 'Check In',
        CheckOutLabel = 'Check Out',
        Currency = '$',
        CurrencyCode = 'USD',
        DateType = 1,
        DayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        DayShortNames = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        Deposit = 0,
        DepositText = 'deposit',
        DiscountsNoDays = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        DiscountText = 'discount',
        EndHourLabel = 'Finish at',
        FirstDay = 1,
        Form = [],
        FormID = 1,
        FormEmailInvalid = 'is invalid. Please enter a valid Email.',
        FormRequired = 'is required.',
        HoursAMPM = false,
        HoursEnabled = true,
        HoursDefinitions = [{"value": "00:00"}, {"value": "00:15"}, {"value": "00:30"}, {"value": "00:45"}, {"value": "01:00"}, {"value": "01:15"}, {"value": "01:30"}, {"value": "01:45"}, {"value": "02:00"}, {"value": "02:15"}, {"value": "02:30"}, {"value": "02:45"}, {"value": "03:00"}, {"value": "03:15"}, {"value": "03:30"}, {"value": "03:45"}, {"value": "04:00"}, {"value": "04:15"}, {"value": "04:30"}, {"value": "04:45"}, {"value": "05:00"}, {"value": "05:15"}, {"value": "05:30"}, {"value": "05:45"}, {"value": "06:00"}, {"value": "06:15"}, {"value": "06:30"}, {"value": "06:45"}, {"value": "07:00"}, {"value": "07:15"}, {"value": "07:30"}, {"value": "07:45"}, {"value": "08:00"}, {"value": "08:15"}, {"value": "08:30"}, {"value": "08:45"}, {"value": "09:00"}, {"value": "09:15"}, {"value": "09:30"}, {"value": "09:45"}, {"value": "10:00"}, {"value": "10:15"}, {"value": "10:30"}, {"value": "10:45"}, {"value": "11:00"}, {"value": "11:15"}, {"value": "11:30"}, {"value": "11:45"}, {"value": "12:00"}, {"value": "12:15"}, {"value": "12:30"}, {"value": "12:45"}, {"value": "13:00"}, {"value": "13:15"}, {"value": "13:30"}, {"value": "13:45"}, {"value": "14:00"}, {"value": "14:15"}, {"value": "14:30"}, {"value": "14:45"}, {"value": "15:00"}, {"value": "15:15"}, {"value": "15:30"}, {"value": "15:45"}, {"value": "16:00"}, {"value": "16:15"}, {"value": "16:30"}, {"value": "16:45"}, {"value": "17:00"}, {"value": "17:15"}, {"value": "17:30"}, {"value": "17:45"}, {"value": "18:00"}, {"value": "18:15"}, {"value": "18:30"}, {"value": "18:45"}, {"value": "19:00"}, {"value": "19:15"}, {"value": "19:30"}, {"value": "19:45"}, {"value": "20:00"}, {"value": "20:15"}, {"value": "20:30"}, {"value": "20:45"}, {"value": "21:00"}, {"value": "21:15"}, {"value": "21:30"}, {"value": "21:45"}, {"value": "22:00"}, {"value": "22:15"}, {"value": "22:30"}, {"value": "22:45"}, {"value": "23:00"}, {"value": "23:15"}, {"value": "23:30"}, {"value": "23:45"}],
        HoursIntervalEnabled = false,
        ID = 0,
        Language = 'en',
        MaxNoChildren = 3,
        MaxNoPeople = 10,
        MaxYear = new Date().getFullYear(),
        MaxStay = 0,
        MinNoChildren = 0, 
        MinNoPeople = 1,
        MinStay = 1,
        MonthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        MonthShortNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        MorningCheckOut = false,
        MultipleDaysSelect = true,
        MultipleHoursSelect = true,
        NoAdultsLabel = 'No Adults',
        NoChildrenEnabled = true,
        NoChildrenLabel = 'No Chilren',
        NoItemsEnabled = true,
        NoItemsLabel = 'No book items',
        NoPeopleLabel = 'No People',
        NoPeopleEnabled = true,
        NoServicesAvailableText  = 'There are no services available for the period you selected',
        PaymentArrivalEnabled = true,
        PaymentArrivalLabel = 'On Arrival',
        PaymentMethodLabel = 'Payment Method',
        PaymentNoneLabel = 'None',
        PaymentPayPalEnabled = true,
        PaymentPayPalLabel = 'PayPal',
        PaymentPayPalTransactionIDLabel = 'PayPal Transaction ID',
        PluginURL = '',
        StartHourLabel = 'Start at',
        StatusApprovedLabel = 'Approved',
        StatusLabel = 'Status',
        StatusPendingLabel = 'Pending',
        TotalPriceLabel = 'Total:',
        
        showCalendar = true,
        firstYearLoaded = false,

        noMonths = 1,
        dayStartSelection,

        methods = {
                    init:function(){// Init Plugin.
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
                        AddReservationSuccess = Data['AddReservationSuccess'];
                        AddLastHourToTotalPrice = Data['AddLastHourToTotalPrice'] == "true" ? true:false;
                        CheckInLabel = Data['CheckInLabel'];
                        CheckOutLabel = Data['CheckOutLabel'];
                        Currency = Data['Currency'];
                        CurrencyCode = Data['CurrencyCode'];
                        DateType = parseInt(Data['DateType']);
                        DayNames = Data['DayNames'];
                        DayShortNames = Data['DayShortNames'];
                        Deposit = parseFloat(Data['Deposit']);
                        DepositText = Data['DepositText'];
                        DiscountsNoDays = Data['DiscountsNoDays'];
                        DiscountText = Data['DiscountText'];
                        EndHourLabel = Data['EndHourLabel'];
                        FirstDay = parseInt(Data['FirstDay']);
                        Form = Data['Form'];
                        FormID = Data['FormID'];
                        FormEmailInvalid = Data['FormEmailInvalid'];
                        FormRequired = Data['FormRequired'];
                        HoursAMPM = Data['HoursAMPM'] == 'true' ? true:false;
                        HoursEnabled = Data['HoursEnabled'] == 'true' ? true:false;
                        HoursDefinitions = Data['HoursDefinitions'];
                        HoursIntervalEnabled = Data['HoursIntervalEnabled'] == 'true' ? true:false;
                        ID = Data['ID'];
                        Language = Data['Language'];
                        MaxNoChildren = parseInt(Data['MaxNoChildren']);
                        MaxNoPeople = parseInt(Data['MaxNoPeople']);
                        MaxYear = Data['MaxYear'];
                        MaxStay = parseInt(Data['MaxStay']);
                        MinNoChildren = parseInt(Data['MinNoChildren']);
                        MinNoPeople = parseInt(Data['MinNoPeople']);
                        MinStay = parseInt(Data['MinStay']);
                        MonthNames = Data['MonthNames'];
                        MonthShortNames = Data['MonthShortNames'];
                        MorningCheckOut = Data['MorningCheckOut'] == 'true' ? true:false;
                        MultipleDaysSelect = Data['MultipleDaysSelect'] == 'true' ? true:false;
                        MultipleHoursSelect = Data['MultipleHoursSelect'] == 'true' ? true:false;
                        NoAdultsLabel = Data['NoAdultsLabel'];
                        NoChildrenEnabled = Data['NoChildrenEnabled'] == 'true' ? true:false;
                        NoChildrenLabel = Data['NoChildrenLabel'];
                        NoItemsEnabled = Data['NoItemsEnabled'] == 'true' ? true:false;
                        NoItemsLabel = Data['NoItemsLabel'];
                        NoPeopleLabel = Data['NoPeopleLabel'];
                        NoPeopleEnabled = Data['NoPeopleEnabled'] == 'true' ? true:false;
                        NoServicesAvailableText  = Data['NoServicesAvailableText'];
                        PaymentArrivalEnabled = Data['PaymentArrivalEnabled'] == 'true' ? true:false;
                        PaymentArrivalLabel = Data['PaymentArrivalLabel'];
                        PaymentMethodLabel = Data['PaymentMethodLabel'];
                        PaymentPayPalEnabled = Data['PaymentPayPalEnabled'] == 'true' ? true:false;
                        PaymentPayPalLabel = Data['PaymentPayPalLabel'];
                        PaymentPayPalTransactionIDLabel = Data['PaymentPayPalTransactionIDLabel'];
                        PluginURL = Data['PluginURL'];
                        StartHourLabel = Data['StartHourLabel'];
                        StatusApprovedLabel = Data['StatusApprovedLabel'];
                        StatusLabel = Data['StatusLabel'];
                        StatusPendingLabel = Data['StatusPendingLabel'];
                        TotalPriceLabel = Data['TotalPriceLabel'];
                        
                        MorningCheckOut = HoursEnabled ? false:MorningCheckOut;
                        MultipleDaysSelect = HoursEnabled ? false:MultipleDaysSelect;
                        
                        methods.parseCalendarData(new Date().getFullYear());
                    },
                    parseCalendarData:function(year){
                        var scheduleBuffer = {};
                        
                        $.post(ajaxurl, {action: 'dopbsp_load_schedule',
                                         calendar_id: ID,
                                         year: year}, function(data){
                            if ($.trim(data) != ''){
                                scheduleBuffer = JSON.parse($.trim(data));
                                
                                for (var day in scheduleBuffer){
                                    scheduleBuffer[day] = JSON.parse(scheduleBuffer[day]);
                                }
                                $.extend(Schedule, scheduleBuffer);
                            }
                            
                            if (showCalendar && (StartMonth < 12-noMonths+1 || firstYearLoaded || year == MaxYear)){
                                dopbspToggleReservationsMessage('hide', '');
                                showCalendar = false;
                                methods.generateForm();
                            }
                            
                            if (!firstYearLoaded){
                                firstYearLoaded = true;
                            }
                                                       
                            if (year < MaxYear){
                                methods.parseCalendarData(year+1);
                            }
                        });
                    },

                    generateForm:function(){// Init  Calendar
                        var HTML = new Array(), i, j;
                        
                        HTML.push('<div class="DOPBookingSystemPROAddReservation_Container">'); 
                        HTML.push('     <form name="DOPBookingSystemPROAddReservation_Form'+ID+'" id="DOPBookingSystemPROAddReservation_Form'+ID+'" action="" method="POST">');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_Language'+ID+'" id="DOPBookingSystemPROAddReservation_Language'+ID+'" value="'+Language+'" />');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_Page'+ID+'" id="DOPBookingSystemPROAddReservation_Page'+ID+'" value="'+window.location.href+'" />');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_PluginURL'+ID+'" id="DOPBookingSystemPROAddReservation_PluginURL'+ID+'" value="'+PluginURL+'" />');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_ID" id="DOPBookingSystemPROAddReservation_ID'+ID+'" value="'+ID+'" />');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_PriceItemValue'+ID+'" id="DOPBookingSystemPROAddReservation_PriceItemValue'+ID+'" value="0" />');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_PriceValue'+ID+'" id="DOPBookingSystemPROAddReservation_PriceValue'+ID+'" value="0" />');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_DiscountValue'+ID+'" id="DOPBookingSystemPROAddReservation_DiscountValue'+ID+'" value="0" />');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_PriceToPayValue'+ID+'" id="DOPBookingSystemPROAddReservation_PriceToPayValue'+ID+'" value="0" />');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_PriceDepositValue'+ID+'" id="DOPBookingSystemPROAddReservation_PriceDepositValue'+ID+'" value="0" />');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_Currency'+ID+'" id="DOPBookingSystemPROAddReservation_Currency'+ID+'" value="'+Currency+'" />');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_CurrencyCode'+ID+'" id="DOPBookingSystemPROAddReservation_CurrencyCode'+ID+'" value="'+CurrencyCode+'" />');
                        HTML.push('         <input type="hidden" name="DOPBookingSystemPROAddReservation_FormID'+ID+'" id="DOPBookingSystemPROAddReservation_FormID'+ID+'" value="'+FormID+'" />');
                        
                        // Check In
                        HTML.push('         <div class="add-reservation-form-item">');
                        HTML.push('             <label for="DOPBookingSystemPROAddReservation_CheckInView'+ID+'">'+CheckInLabel+'</label>');
                        HTML.push('             <div class="add-reservation-fields">');
                        HTML.push('                 <input type="text" name="DOPBookingSystemPROAddReservation_CheckInView'+ID+'" id="DOPBookingSystemPROAddReservation_CheckInView'+ID+'" class="small" value="" />');
                        HTML.push('                 <input type="hidden" name="DOPBookingSystemPROAddReservation_CheckIn'+ID+'" id="DOPBookingSystemPROAddReservation_CheckIn'+ID+'" value="" />');
                        HTML.push('             </div>');
                        HTML.push('             <br class="DOPBookingSystemPROAddReservation_Clear" />');
                        HTML.push('         </div>');
                        
                        // Check Out
                        if (!HoursEnabled && MultipleDaysSelect){
                            HTML.push('         <div class="add-reservation-form-item">');
                            HTML.push('             <label for="DOPBookingSystemPROAddReservation_CheckOut'+ID+'">'+CheckOutLabel+'</label>');
                            HTML.push('             <div class="add-reservation-fields">');
                            HTML.push('                 <input type="text" name="DOPBookingSystemPROAddReservation_CheckOutView'+ID+'" id="DOPBookingSystemPROAddReservation_CheckOutView'+ID+'" class="small" value="" />');
                            HTML.push('                 <input type="hidden" name="DOPBookingSystemPROAddReservation_CheckOut'+ID+'" id="DOPBookingSystemPROAddReservation_CheckOut'+ID+'" value="" />');
                            HTML.push('             </div>');
                            HTML.push('             <br class="DOPBookingSystemPROAddReservation_Clear" />');
                            HTML.push('         </div>');
                        }
                                                
                        if (HoursEnabled){
                            // Start Hour                            
                            HTML.push('         <div class="DOPBookingSystemPROAddReservation_HoursSelect" id="DOPBookingSystemPROAddReservation_HoursSelect'+ID+'">');
                            HTML.push('             <div class="add-reservation-form-item">');
                            HTML.push('                 <label for="DOPBookingSystemPROAddReservation_StartHour'+ID+'">'+StartHourLabel+'</label>');
                            HTML.push('                 <div class="add-reservation-fields">');
                            HTML.push('                     <select name="DOPBookingSystemPROAddReservation_StartHour'+ID+'" id="DOPBookingSystemPROAddReservation_StartHour'+ID+'" '+(!MultipleHoursSelect && HoursIntervalEnabled ? '':'class="small"')+'><option value=""></option></select>');
                            HTML.push('                 </div>');
                            HTML.push('                 <br class="DOPBookingSystemPROAddReservation_Clear" />');
                            HTML.push('             </div>');
                            
                            // End Hour
                            if (MultipleHoursSelect){
                                HTML.push('         <div class="add-reservation-form-item">');
                                HTML.push('             <label for="DOPBookingSystemPROAddReservation_EndHourView'+ID+'">'+EndHourLabel+'</label>');
                                HTML.push('             <div class="add-reservation-fields">');
                                HTML.push('                 <select name="DOPBookingSystemPROAddReservation_EndHourView'+ID+'" id="DOPBookingSystemPROAddReservation_EndHourView'+ID+'" class="small"><option value=""></option></select>');
                                HTML.push('             </div>');
                                HTML.push('             <br class="DOPBookingSystemPROAddReservation_Clear" />');
                                HTML.push('         </div>');
                            }
                            
                            HTML.push('             <input type="hidden" name="DOPBookingSystemPROAddReservation_EndHour'+ID+'" id="DOPBookingSystemPROAddReservation_EndHour'+ID+'" value="" />');
                            HTML.push('         </div>');
                        }
                        
                        // No Items
                        HTML.push('         <div class="add-reservation-form-item" id="DOPBookingSystemPROAddReservation_NoItemsSelect'+ID+'">');
                        HTML.push('             <label for="DOPBookingSystemPROAddReservation_NoItems'+ID+'">'+NoItemsLabel+'</label>');
                        HTML.push('             <div class="add-reservation-fields">');
                        HTML.push('                 <select name="DOPBookingSystemPROAddReservation_NoItems'+ID+'" id="DOPBookingSystemPROAddReservation_NoItems'+ID+'" class="small">');
                        HTML.push('                     <option value="1">1</option>');
                        HTML.push('                 </select>');
                        HTML.push('             </div>');
                        HTML.push('             <br class="DOPBookingSystemPROAddReservation_Clear" />');
                        HTML.push('         </div>');
                        
                        // Price
                        HTML.push('         <div class="add-reservation-form-item price" id="DOPBookingSystemPROAddReservation_Price'+ID+'">');
                        HTML.push('             <label>'+TotalPriceLabel+'</label>');
                        HTML.push('             <div class="add-reservation-fields value"></div>');
                        HTML.push('             <br class="DOPBookingSystemPROAddReservation_Clear" />');
                        HTML.push('         </div>');
                        
                        // Message 
                        HTML.push('         <div class="add-reservation-form-item message" id="DOPBookingSystemPROAddReservation_InfoMessage'+ID+'">');
                        HTML.push('             <label>&nbsp;</label>');
                        HTML.push('             <div class="add-reservation-fields value"></div>');
                        HTML.push('             <br class="DOPBookingSystemPROAddReservation_Clear" />');
                        HTML.push('         </div>');
                        
                        // ***************************************************** Contact Form
                        
                        HTML.push('         <div class="DOPBookingSystemPROAddReservation_ContactForm" id="DOPBookingSystemPROAddReservation_ContactForm'+ID+'">');
                        
                        // Payment Method
                        HTML.push('             <div class="add-reservation-form-item">');
                        HTML.push('                 <label for="DOPBookingSystemPROAddReservation_PaymentMethod'+ID+'">'+PaymentMethodLabel+'</label>');
                        HTML.push('                 <div class="add-reservation-fields">');
                        HTML.push('                     <select name="DOPBookingSystemPROAddReservation_PaymentMethod'+ID+'" id="DOPBookingSystemPROAddReservation_PaymentMethod'+ID+'"></select>');
                        HTML.push('                 </div>');
                        HTML.push('                 <br class="DOPBookingSystemPROAddReservation_Clear" />');
                        HTML.push('             </div>');
                        
                        // PayPal Transaction ID
                        HTML.push('         <div class="add-reservation-form-item" id="DOPBookingSystemPROAddReservation_PayPalTransactionID'+ID+'_Item">');
                        HTML.push('             <label for="DOPBookingSystemPROAddReservation_PayPalTransactionID'+ID+'">'+PaymentPayPalTransactionIDLabel+'</label>');
                        HTML.push('             <div class="add-reservation-fields">');
                        HTML.push('                 <input type="text" name="DOPBookingSystemPROAddReservation_PayPalTransactionID'+ID+'" id="DOPBookingSystemPROAddReservation_PayPalTransactionID'+ID+'" value="" />');
                        HTML.push('             </div>');
                        HTML.push('             <br class="DOPBookingSystemPROAddReservation_Clear" />');
                        HTML.push('         </div>');
                        
                        // Status
                        HTML.push('             <div class="add-reservation-form-item">');
                        HTML.push('                 <label for="DOPBookingSystemPROAddReservation_Status'+ID+'">'+StatusLabel+'</label>');
                        HTML.push('                 <div class="add-reservation-fields">');
                        HTML.push('                     <select name="DOPBookingSystemPROAddReservation_Status'+ID+'" id="DOPBookingSystemPROAddReservation_Status'+ID+'">');
                        HTML.push('                         <option value="pending">'+StatusPendingLabel+'</option>');
                        HTML.push('                         <option value="approved">'+StatusApprovedLabel+'</option>');
                        HTML.push('                     </select>');
                        HTML.push('                 </div>');
                        HTML.push('                 <br class="DOPBookingSystemPROAddReservation_Clear" />');
                        HTML.push('             </div>');

                        for (i=0; i<Form.length; i++){
                            HTML.push('         <div class="add-reservation-form-item">');
                            HTML.push('             <label for="DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']+'">'+Form[i]['translation']+(Form[i]['required'] == 'true' ? ' *':'')+'</label>');
                            HTML.push('             <div class="add-reservation-fields">');
                                    
                            
                            switch (Form[i]['type']){
                                case 'checkbox':
                                    HTML.push('         <input type="checkbox" name="DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']+'" id="DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']+'" />');
                                    break;
                                case 'text':
                                    HTML.push('         <input type="text" name="DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']+'" id="DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']+'" value="" />');
                                    break;
                                case 'select':
                                    HTML.push('         <select name="DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']+(Form[i]['multiple_select'] == 'true' ? '[]':'')+'" id="DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']+'" value=""'+(Form[i]['multiple_select'] == 'true' ? ' multiple':'')+'>');
                                    
                                    for (j=0; j<Form[i]['options'].length; j++){
                                        if (Form[i]['options'][j]['translation'] != ''){
                                            HTML.push('     <option value="'+Form[i]['options'][j]['id']+'">'+Form[i]['options'][j]['translation']+'</option>');
                                        }
                                    }
                                    HTML.push('         </select>');
                                    break;
                                case 'textarea':
                                    HTML.push('         <textarea name="DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']+'" id="DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']+'" col="" rows="6"></textarea>');
                                    break;
                            }
                            HTML.push('             </div>');
                            HTML.push('             <br class="DOPBookingSystemPROAddReservation_Clear" />');
                            HTML.push('         </div>');
                        }
                        
                        if (NoPeopleEnabled){
                            // No People
                            HTML.push('         <div class="add-reservation-form-item">');
                            HTML.push('             <label for="DOPBookingSystemPROAddReservation_NoPeople'+ID+'">'+(NoChildrenEnabled ? NoAdultsLabel:NoPeopleLabel)+'</label>');
                            HTML.push('             <div class="add-reservation-fields">');
                            HTML.push('                 <select name="DOPBookingSystemPROAddReservation_NoPeople'+ID+'" id="DOPBookingSystemPROAddReservation_NoPeople'+ID+'" class="small">');
                            
                            for (i=MinNoPeople; i<=MaxNoPeople; i++){
                                HTML.push('                 <option value="'+i+'">'+i+'</option>');
                            }
                            HTML.push('                 </select>');
                            HTML.push('             </div>');
                            HTML.push('             <br class="DOPBookingSystemPROAddReservation_Clear" />');
                            HTML.push('         </div>');  
                            
                            // No Children
                            if (NoChildrenEnabled){
                                HTML.push('     <div class="add-reservation-form-item">');
                                HTML.push('         <label for="DOPBookingSystemPROAddReservation_NoChildren'+ID+'">'+NoChildrenLabel+'</label>');
                                HTML.push('         <div class="add-reservation-fields">');
                                HTML.push('             <select name="DOPBookingSystemPROAddReservation_NoChildren'+ID+'" id="DOPBookingSystemPROAddReservation_NoChildren'+ID+'" class="small">');
                                
                                for (i=MinNoChildren; i<=MaxNoChildren; i++){
                                    HTML.push('             <option value="'+i+'">'+i+'</option>');
                                }
                                HTML.push('             </select>');
                                HTML.push('         </div>');
                                HTML.push('         <br class="DOPBookingSystemPROAddReservation_Clear" />');
                                HTML.push('     </div>');  
                            }
                        }
                        HTML.push('         </div>');
                        HTML.push('     </form>');
                        HTML.push('</div>');
                        
                        Container.html(HTML.join(''));
                        methods.initForm();
                    },
                    
                    initForm:function(){
                        var i, j;
                        
                        methods.initFormDates();
                        
                        $('#DOPBookingSystemPROAddReservation_NoItems'+ID).unbind('change');
                        $('#DOPBookingSystemPROAddReservation_NoItems'+ID).bind('change', function(){
                            if (HoursEnabled){
                                methods.calculateHoursPrice();                                  
                            }
                            else{
                                methods.calculateDaysPrice();                            
                            }
                        });
                        
                        $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).unbind('change');
                        $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).bind('change', function(){
                            if ($(this).val() == 2){
                                $('#DOPBookingSystemPROAddReservation_PayPalTransactionID'+ID+'_Item').css('display', 'block');
                            }
                            else{
                                $('#DOPBookingSystemPROAddReservation_PayPalTransactionID'+ID+'_Item').css('display', 'none');
                            }
                        });
                        
                        for (i=0; i<Form.length; i++){
                            if (Form[i]['allowed_characters'] != ''){
                                $('#DOPBookingSystemPROAddReservation_FormField'+Form[i]['id']).unbind('keyup');
                                $('#DOPBookingSystemPROAddReservation_FormField'+Form[i]['id']).bind('keyup', function(){
                                    var id = parseInt($(this).attr('id').split('DOPBookingSystemPROAddReservation_FormField')[1]);
                                    
                                    for (j=0; j<Form.length; j++){
                                        if (Form[j]['id'] == id){
                                            prototypes.cleanInput($(this), Form[j]['allowed_characters']);
                                        }
                                    }
                                });
                            }
                        }
                        
                        $('#DOPBSP-submit-reservation').unbind('click');
                        $('#DOPBSP-submit-reservation').bind('click', function(){
                            methods.book();
                        });
                    },
                    initFormDates:function(){    
                        $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).unbind('click');
                        $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).bind('click', function(){  
                            methods.resetForm();
                        });
                        
                        $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).unbind('blur');
                        $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).bind('blur', function(){  
                            if ($(this).val() == ''){  
                               methods.resetForm();
                            }
                        });
                            
                        if (!HoursEnabled && MultipleDaysSelect){                    
                            $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).datepicker('destroy');                      
                            $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).datepicker({minDate: 0,
                                                                                               dateFormat: DateType == 1 ? 'MM dd, yy':'dd MM yy',
                                                                                               altField: '#DOPBookingSystemPROAddReservation_CheckIn'+ID,
                                                                                               altFormat: 'yy-mm-dd',
                                                                                               firstDay: FirstDay,
                                                                                               dayNames: DayNames,
                                                                                               dayNamesMin: DayShortNames,
                                                                                               monthNames: MonthNames,
                                                                                               monthNamesMin: MonthShortNames});
                            $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).datepicker('destroy');
                            $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).datepicker({minDate: 0,
                                                                                                dateFormat: DateType == 1 ? 'MM dd, yy':'dd MM yy',
                                                                                                altField: '#DOPBookingSystemPROAddReservation_CheckOut'+ID,
                                                                                                altFormat: 'yy-mm-dd',
                                                                                                firstDay: FirstDay,
                                                                                                dayNames: DayNames,
                                                                                                dayNamesMin: DayShortNames,
                                                                                                monthNames: MonthNames,
                                                                                                monthNamesMin: MonthShortNames});
                            $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).attr('disabled', 'disabled');
                            $('.ui-datepicker').removeClass('notranslate').addClass('notranslate');
                            
                            $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).unbind('click');
                            $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).bind('click', function(){
                                $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).val('');
                                $('#DOPBookingSystemPROAddReservation_CheckOut'+ID).val('');
                                $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).attr('disabled', 'disabled');
                            });
                            
                            $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).unbind('change');
                            $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).bind('change', function(){
                                var year = parseInt($('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val().split('-')[0], 10),
                                month = parseInt($('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val().split('-')[1], 10)-1,
                                day = parseInt($('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val().split('-')[2], 10),
                                minDateValue = StartYear == year && StartMonth-1 == month && StartDay == day+MinStay-1 ? (MorningCheckOut ? 1:0):prototypes.dateDiference(new Date(), new Date(year, month, day+MinStay-(MorningCheckOut ? 0:1)));
                                
                                $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).removeAttr('disabled');

                                $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).val('');
                                $('#DOPBookingSystemPROAddReservation_CheckOut'+ID).val('');
                                $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).datepicker('destroy');
                                
                                if (MaxStay == 0){
                                    $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).datepicker({minDate: minDateValue, 
                                                                                                        dateFormat: DateType == 1 ? 'MM dd, yy':'dd MM yy',
                                                                                                        altField: '#DOPBookingSystemPROAddReservation_CheckOut'+ID,
                                                                                                        altFormat: 'yy-mm-dd',
                                                                                                        firstDay: FirstDay,
                                                                                                        dayNames: DayNames,
                                                                                                        dayNamesMin: DayShortNames,
                                                                                                        monthNames: MonthNames,
                                                                                                        monthNamesMin: MonthShortNames}); 
                                }
                                else{
                                    $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).datepicker({minDate: minDateValue, 
                                                                                                        maxDate: prototypes.dateDiference(new Date(), new Date(year, month, day+MaxStay-(MorningCheckOut ? 0:1))), 
                                                                                                        dateFormat: DateType == 1 ? 'MM dd, yy':'dd MM yy',
                                                                                                        altField: '#DOPBookingSystemPROAddReservation_CheckOut'+ID,
                                                                                                        altFormat: 'yy-mm-dd',
                                                                                                        firstDay: FirstDay,
                                                                                                        dayNames: DayNames,
                                                                                                        dayNamesMin: DayShortNames,
                                                                                                        monthNames: MonthNames,
                                                                                                        monthNamesMin: MonthShortNames}); 
                                }
                                $('.ui-datepicker').removeClass('notranslate').addClass('notranslate');
                                
                                setTimeout(function(){  
                                    $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).val('').select();
                                    $('#DOPBookingSystemPROAddReservation_CheckOut'+ID).val('');
                                    $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).val('').select();
                                }, 100);
                            });
                                                        
                            $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).unbind('click');
                            $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).bind('click', function(){
                                $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).val('');  
                                $('#DOPBookingSystemPROAddReservation_CheckOut'+ID).val('');  
                                methods.hideForm();
                            });

                            $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).unbind('blur');
                            $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).bind('blur', function(){
                                if ($(this).val() == ''){
                                    methods.hideForm();
                                }
                            });

                            $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).unbind('change');
                            $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).bind('change', function(){
                                methods.calculateDaysPrice();
                            });
                        }
                        else{
                            $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).datepicker('destroy');
                            $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).datepicker({minDate: 0,
                                                                                               dateFormat: DateType == 1 ? 'MM dd, yy':'dd MM yy',
                                                                                               altField: '#DOPBookingSystemPROAddReservation_CheckIn'+ID,
                                                                                               altFormat: 'yy-mm-dd',
                                                                                               firstDay: FirstDay,
                                                                                               dayNames: DayNames,
                                                                                               dayNamesMin: DayShortNames,
                                                                                               monthNames: MonthNames,
                                                                                               monthNamesMin: MonthShortNames});
                            $('.ui-datepicker').removeClass('notranslate').addClass('notranslate');
                            
                            $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).unbind('change');
                            $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).bind('change', function(){
                                if (HoursEnabled){
                                    dayStartSelection = $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val();
                                    methods.initHours();
                                }
                                else{
                                    methods.calculateDaysPrice();                                    
                                }
                            });
                        }
                    },
                    initFormHours:function(){
                        $('#DOPBookingSystemPROAddReservation_StartHour'+ID).unbind('change');
                        $('#DOPBookingSystemPROAddReservation_StartHour'+ID).bind('change', function(){
                            var hoursDef = Schedule[dayStartSelection] != undefined ? Schedule[dayStartSelection]['hours_definitions']:HoursDefinitions;

                            if (MultipleHoursSelect){
                                $('#DOPBookingSystemPROAddReservation_EndHourView'+ID).html($('#DOPBookingSystemPROAddReservation_StartHour'+ID).html());

                                $('#DOPBookingSystemPROAddReservation_EndHourView'+ID+' option').each(function(){
                                    if (HoursIntervalEnabled || !AddLastHourToTotalPrice){
                                        if ($(this).attr('value') <= $('#DOPBookingSystemPROAddReservation_StartHour'+ID).val() && $(this).attr('value') != ''){
                                            $(this).remove();
                                        }
                                    }
                                    else{
                                        if ($(this).attr('value') < $('#DOPBookingSystemPROAddReservation_StartHour'+ID).val() && $(this).attr('value') != ''){
                                            $(this).remove();
                                        }
                                    }
                                })
                                methods.hideForm();
                            }
                            else{                           
                                if (HoursEnabled && HoursIntervalEnabled){
                                    $('#DOPBookingSystemPROAddReservation_EndHour'+ID).val(methods.nextHour($('#DOPBookingSystemPROAddReservation_StartHour'+ID).val(), hoursDef));
                                }
                                
                                methods.hideForm();
                                methods.calculateHoursPrice();                                
                            }
                        });
                        
                        $('#DOPBookingSystemPROAddReservation_EndHourView'+ID).unbind('change');
                        $('#DOPBookingSystemPROAddReservation_EndHourView'+ID).bind('change', function(){
                            $('#DOPBookingSystemPROAddReservation_EndHour'+ID).val($('#DOPBookingSystemPROAddReservation_EndHourView'+ID).val());
                            methods.hideForm();
                            methods.calculateHoursPrice();
                        });
                    },
                    resetForm:function(){
                        $('#DOPBookingSystemPROAddReservation_CheckInView'+ID).val('');
                        $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val('');

                        if (!HoursEnabled && MultipleDaysSelect){                            
                            $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).val(''); 
                            $('#DOPBookingSystemPROAddReservation_CheckOut'+ID).val(''); 
                            $('#DOPBookingSystemPROAddReservation_CheckOutView'+ID).attr('disabled', 'disabled');
                        }
                            
                        if (HoursEnabled){
                            $('#DOPBookingSystemPROAddReservation_HoursSelect'+ID).css('display', 'none');
                            $('#DOPBookingSystemPROAddReservation_StartHour'+ID).html('<option value=""></option>');
                                
                            if (MultipleHoursSelect){
                                $('#DOPBookingSystemPROAddReservation_EndHourView'+ID).html('<option value=""></option>');
                            }
                        }
                        
                        methods.hideForm();
                    },
                    unavailableForm:function(message){
                        $('#DOPBookingSystemPROAddReservation_NoItems'+ID).html('<option value="1">1</option>');
                        $('#DOPBookingSystemPROAddReservation_NoItemsSelect'+ID).css('display', 'none');
                        $('#DOPBookingSystemPROAddReservation_Price'+ID).css('display', 'none');
                        $('#DOPBookingSystemPROAddReservation_PriceItemValue'+ID).val('');
                        $('#DOPBookingSystemPROAddReservation_PriceValue'+ID).val('');
                        $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID+' .value').html(message);
                        $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID).css('display', 'block');
                        $('#DOPBookingSystemPROAddReservation_ContactForm'+ID).css('display', 'none');
                    },
                
                    initHours:function(){
                        var hoursDef = HoursDefinitions,
                        date = $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val(),
                        hoursHTML = new Array(), i;
                        
                        $('#DOPBookingSystemPROAddReservation_HoursSelect'+ID).css('display', 'block');

                        if (Schedule[date] != undefined){
                            hoursDef = Schedule[date]['hours_definitions'];
                        }   
                        hoursHTML.push('<option value=""></option>'); 
                        
                        for (i=0; i<hoursDef.length; i++){
                            hoursHTML.push('<option value="'+hoursDef[i]['value']+'">'+(HoursAMPM ? prototypes.timeToAMPM(hoursDef[i]['value']):hoursDef[i]['value'])+(!MultipleHoursSelect && HoursIntervalEnabled ? '-'+(HoursAMPM ? prototypes.timeToAMPM(methods.nextHour(hoursDef[i]['value'], hoursDef)):methods.nextHour(hoursDef[i]['value'], hoursDef)):'')+'</option>');
                        }
                        
                        $('#DOPBookingSystemPROAddReservation_StartHour'+ID).html(hoursHTML.join(''));
                        
                        if (MultipleHoursSelect){
                            $('#DOPBookingSystemPROAddReservation_EndHourView'+ID).html(hoursHTML.join(''));
                        }
                            
                        $('#DOPBookingSystemPROAddReservation_HoursSelect'+ID).css('display', 'block');    
                        methods.initFormHours();
                    },
                    
                    calculateDaysPrice:function(){
                        var bookedDays = new Array(),
                        i, y, d, m,
                        ciDay, ciy, cim, cid,
                        coDay, coy, com, cod,
                        firstMonth, lastMonth, firstDay, lastDay,
                        currYear, currMonth, currDay, currBookedDay,
                        available = true, itemPrice = 0, noItems = 1000000, totalPrice = 0, totalToPay = 0,  depositToPay = 0,
                        oldNoItems = $('#DOPBookingSystemPROAddReservation_NoItems'+ID).val(),
                        dayFound, noDays = 0, discountValue = 0,
                        noItemsHTML = new Array();
                        
                        if (MultipleDaysSelect){
                            ciDay = $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val();
                            coDay = $('#DOPBookingSystemPROAddReservation_CheckOut'+ID).val();
                        }
                        else{                            
                            ciDay = $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val();
                            coDay = $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val();
                        }
                        
                        if (ciDay.split('-').length == 3 && coDay.split('-').length == 3 && Schedule != {}){
                            ciy = parseInt(ciDay.split('-')[0], 10);
                            cim = parseInt(ciDay.split('-')[1], 10);
                            cid = parseInt(ciDay.split('-')[2], 10);
                            coy = parseInt(coDay.split('-')[0], 10);
                            com = parseInt(coDay.split('-')[1], 10);
                            cod = parseInt(coDay.split('-')[2], 10);
                            
                            for (y=ciy; y<=coy; y++){
                                firstMonth = y == ciy ? cim:1;
                                lastMonth = y == coy ? com:12;

                                for (m=firstMonth; m<=lastMonth; m++){
                                    firstDay = y == ciy && m == cim ? cid:1;
                                    lastDay = y == coy && m == com ? cod:new Date(y,m,0).getDate();

                                    for (d=firstDay; d<=lastDay; d++){
                                        currYear = String(y);
                                        currMonth = prototypes.timeLongItem(m);
                                        currDay = prototypes.timeLongItem(d);

                                        bookedDays.push(currYear+'-'+currMonth+'-'+currDay);
                                    }
                                }
                            }
                            
                            noDays = prototypes.noDays(new Date(bookedDays[0].split('-')[0], bookedDays[0].split('-')[1]-1, bookedDays[0].split('-')[2]), new Date(bookedDays[bookedDays.length-1].split('-')[0], bookedDays[bookedDays.length-1].split('-')[1]-1, bookedDays[bookedDays.length-1].split('-')[2]))-(MorningCheckOut ? 1:0);
                            
                            if (noDays > 1){
                                if (noDays > 31){
                                    discountValue = DiscountsNoDays[29];
                                }
                                else{
                                    discountValue = DiscountsNoDays[noDays-2];
                                }
                            }
                            
                            if (Schedule[bookedDays[0]] == undefined || Schedule[bookedDays[bookedDays.length-(MorningCheckOut ? 2:1)]] == undefined || Schedule[bookedDays[0]]['bind'] == '2' || Schedule[bookedDays[0]]['bind'] == '3' || Schedule[bookedDays[bookedDays.length-(MorningCheckOut ? 2:1)]]['bind'] == '1' || Schedule[bookedDays[bookedDays.length-(MorningCheckOut ? 2:1)]]['bind'] == '2'){
                                available = false;
                            }
                            
                            if (available){
                                for (i=0; i<bookedDays.length-(MorningCheckOut ? 1:0); i++){
                                    dayFound = false;
                                    currBookedDay = bookedDays[i];

                                    if (Schedule[currBookedDay] != undefined && (Schedule[currBookedDay]['status'] == 'available' || Schedule[currBookedDay]['status'] == 'special') && 
                                        ((i != 0 && i != bookedDays.length-(MorningCheckOut ? 2:1) && Schedule[currBookedDay]['bind'] != '1' && Schedule[currBookedDay]['bind'] != '3') || i==0 || i == bookedDays.length-(MorningCheckOut ? 2:1))){
                                        
                                        dayFound = true;

                                        if (Schedule[currBookedDay]['price'] != ''){
                                            itemPrice += Schedule[currBookedDay]['promo'] == '' ? parseFloat(Schedule[currBookedDay]['price']):parseFloat(Schedule[currBookedDay]['promo']);
                                        }

                                        if (Schedule[currBookedDay]['available'] == ''){
                                            noItems = 1;
                                        } 
                                        else if (parseInt(Schedule[currBookedDay]['available'], 10) < noItems){
                                            noItems = parseInt(Schedule[currBookedDay]['available'], 10);
                                        }
                                    }

                                    if (!dayFound){
                                        available = false;
                                        break;
                                    }
                                }
                            }

                            if (!available){
                                methods.unavailableForm(NoServicesAvailableText);
                            }
                            else{
                                for (i=1; i<=noItems; i++){
                                    if (oldNoItems == i){
                                        noItemsHTML.push('<option value="'+i+'" selected="selected">'+i+'</option>');                                        
                                    }
                                    else{
                                        noItemsHTML.push('<option value="'+i+'">'+i+'</option>');
                                    }
                                }

                                $('#DOPBookingSystemPROAddReservation_NoItems'+ID).html(noItemsHTML.join(''));
                                
                                if (NoItemsEnabled){
                                    $('#DOPBookingSystemPROAddReservation_NoItemsSelect'+ID).css('display', 'block');
                                }
                                else{
                                    $('#DOPBookingSystemPROAddReservation_NoItemsSelect'+ID).css('display', 'none');
                                }
                                   
                                if (itemPrice == 0){
                                    $('#DOPBookingSystemPROAddReservation_PaymentArrival'+ID).css('display', 'none');
                                    $('#DOPBookingSystemPROAddReservation_PaymentPayPal'+ID).css('display', 'none');
                                    $('#DOPBookingSystemPROAddReservation_Price'+ID).css('display', 'none');
                                    $('#DOPBookingSystemPROAddReservation_PriceItemValue'+ID).val(0);
                                    $('#DOPBookingSystemPROAddReservation_PriceValue'+ID).val(0);
                                    $('#DOPBookingSystemPROAddReservation_DiscountValue'+ID).val(0);
                                    $('#DOPBookingSystemPROAddReservation_PriceToPayValue'+ID).val(0);
                                    $('#DOPBookingSystemPROAddReservation_PriceDepositValue'+ID).val(0);
                                    
                                    $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).html('<option value="0">'+PaymentNoneLabel+'</option>');
                                    $('#DOPBookingSystemPROAddReservation_PayPalTransactionID'+ID+'_Item').css('display', 'none');
                                }
                                else{
                                    if (Schedule[bookedDays[0]] != undefined && Schedule[bookedDays[0]]['bind'] == '1'){
                                        itemPrice = Schedule[bookedDays[0]]['promo'] == '' ? parseFloat(Schedule[bookedDays[0]]['price']):parseFloat(Schedule[bookedDays[0]]['promo']);
                                    }
                                    
                                    totalPrice = Math.round(itemPrice*$('#DOPBookingSystemPROAddReservation_NoItems'+ID).val()*100)/100;
                                    
                                    if (discountValue == 0){
                                        totalToPay = Math.round(totalPrice*100)/100;
                                    }
                                    else{
                                        totalToPay = Math.round((totalPrice-(totalPrice*discountValue/100))*100)/100;
                                    }
                                    
                                    if (PaymentPayPalEnabled){
                                        depositToPay = Math.round(Deposit*totalToPay)/100;
                                    }

                                    $('#DOPBookingSystemPROAddReservation_PaymentArrival'+ID).css('display', 'block');
                                    $('#DOPBookingSystemPROAddReservation_PaymentPayPal'+ID).css('display', 'block');
                                    $('#DOPBookingSystemPROAddReservation_PriceItemValue'+ID).val(itemPrice);
                                    $('#DOPBookingSystemPROAddReservation_PriceValue'+ID).val(totalPrice);
                                    $('#DOPBookingSystemPROAddReservation_DiscountValue'+ID).val(discountValue);
                                    $('#DOPBookingSystemPROAddReservation_PriceToPayValue'+ID).val(totalToPay);
                                    $('#DOPBookingSystemPROAddReservation_PriceDepositValue'+ID).val(depositToPay);
                                    
                                    $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).html('<option value="0">'+PaymentNoneLabel+'</option>');
                            
                                    if (PaymentArrivalEnabled){
                                        $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).append('<option value="1">'+PaymentArrivalLabel+'</option>');
                                    }
                                    
                                    if (PaymentPayPalEnabled){
                                        $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).append('<option value="2">'+PaymentPayPalLabel+'</option>');
                                    }
                                    $('#DOPBookingSystemPROAddReservation_PayPalTransactionID'+ID+'_Item').css('display', 'none');
                                    
                                    $('#DOPBookingSystemPROAddReservation_Price'+ID+' .value').html((Currency+prototypes.getWithDecimals(totalToPay, 2))+' '+(discountValue != 0 ? '<span class="cut">'+Currency+prototypes.getWithDecimals(totalPrice, 2)+'</span>':''));
                                    
                                    if (discountValue != 0){
                                        $('#DOPBookingSystemPROAddReservation_Price'+ID+' .value').append('<br />'+Currency+prototypes.getWithDecimals(totalPrice*discountValue/100, 2)+' '+DiscountText+' ('+discountValue+'%)');
                                    }
                                    
                                    if (depositToPay != 0){
                                        $('#DOPBookingSystemPROAddReservation_Price'+ID+' .value').append('<br />'+Currency+prototypes.getWithDecimals(depositToPay, 2)+' '+DepositText+' ('+Deposit+'%)');
                                    }
                                    $('#DOPBookingSystemPROAddReservation_Price'+ID).css('display', 'block');
                                }

                                $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID).css('display', 'none');
                                $('#DOPBookingSystemPROAddReservation_ContactForm'+ID).css('display', 'block');                              
                            }
                        }
                    },
                    calculateHoursPrice:function(){
                        var bookedHours = new Array(),
                        i, ciDay, sHour, eHour, currBookedHour,
                        available = true, itemPrice = 0, noItems = 1000000, totalPrice = 0, totalToPay = 0,  depositToPay = 0,
                        oldNoItems = $('#DOPBookingSystemPROAddReservation_NoItems'+ID).val(),
                        hourFound,
                        noItemsHTML = new Array();
                        
                        ciDay = $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val();
                        
                        if (ciDay.split('-').length == 3){
                            if (Schedule[ciDay] != undefined){
                                if (MultipleHoursSelect){
                                    sHour = $('#DOPBookingSystemPROAddReservation_StartHour'+ID).val();
                                    eHour = $('#DOPBookingSystemPROAddReservation_EndHour'+ID).val();
                                }
                                else{                            
                                    sHour = $('#DOPBookingSystemPROAddReservation_StartHour'+ID).val();
                                    eHour = $('#DOPBookingSystemPROAddReservation_StartHour'+ID).val();
                                }

                                $.each(Schedule[ciDay]['hours_definitions'], function(index){
                                    if (sHour <= Schedule[ciDay]['hours_definitions'][index]['value'] && Schedule[ciDay]['hours_definitions'][index]['value'] <= eHour){
                                        bookedHours.push(Schedule[ciDay]['hours_definitions'][index]['value']);
                                    }
                                });
                                
                                if (Schedule[ciDay]['hours'][bookedHours[0]] == undefined || Schedule[ciDay]['hours'][bookedHours[bookedHours.length-1]] == undefined || Schedule[ciDay]['hours'][bookedHours[0]]['bind'] == '2' || Schedule[ciDay]['hours'][bookedHours[0]]['bind'] == '3' || Schedule[ciDay]['hours'][bookedHours[bookedHours.length-1]]['bind'] == '1' || Schedule[ciDay]['hours'][bookedHours[bookedHours.length-1]]['bind'] == '2'){
                                    available = false;
                                }
                                
                                if (available){
                                    for (i=0; i<bookedHours.length-((!AddLastHourToTotalPrice || HoursIntervalEnabled) && MultipleHoursSelect && Schedule[ciDay]['hours'][bookedHours[0]]['bind'] == 0 ? 1:0); i++){
                                        hourFound = false;
                                        currBookedHour = bookedHours[i];  
                                        
                                        if (Schedule[ciDay]['hours'][currBookedHour] != undefined && (Schedule[ciDay]['hours'][currBookedHour]['status'] == 'available' || Schedule[ciDay]['hours'][currBookedHour]['status'] == 'special') && 
                                            ((i != 0 && i != bookedHours.length-1 && Schedule[ciDay]['hours'][currBookedHour]['bind'] != '1' && Schedule[ciDay]['hours'][currBookedHour]['bind'] != '3') || i==0 || i == bookedHours.length-1)){
                                            
                                            hourFound = true;

                                            if (Schedule[ciDay]['hours'][currBookedHour]['price'] != ''){
                                                itemPrice += Schedule[ciDay]['hours'][currBookedHour]['promo'] == '' ? parseFloat(Schedule[ciDay]['hours'][currBookedHour]['price']):parseFloat(Schedule[ciDay]['hours'][currBookedHour]['promo']);
                                            }

                                            if (Schedule[ciDay]['hours'][currBookedHour]['available'] == ''){
                                                noItems = 1;
                                            } 
                                            else if (parseInt(Schedule[ciDay]['hours'][currBookedHour]['available'], 10) < noItems){
                                                noItems = parseInt(Schedule[ciDay]['hours'][currBookedHour]['available'], 10);
                                            }
                                        }

                                        if (!hourFound){
                                            available = false;
                                            break;
                                        }
                                    }
                                }

                                if (!available){
                                    methods.unavailableForm(NoServicesAvailableText);
                                }
                                else{
                                    for (i=1; i<=noItems; i++){
                                        if (oldNoItems == i){
                                            noItemsHTML.push('<option value="'+i+'" selected="selected">'+i+'</option>');                                        
                                        }
                                        else{
                                            noItemsHTML.push('<option value="'+i+'">'+i+'</option>');
                                        }
                                    }

                                    $('#DOPBookingSystemPROAddReservation_NoItems'+ID).html(noItemsHTML.join(''));
                                
                                    if (NoItemsEnabled){
                                        $('#DOPBookingSystemPROAddReservation_NoItemsSelect'+ID).css('display', 'block');
                                    }
                                    else{
                                        $('#DOPBookingSystemPROAddReservation_NoItemsSelect'+ID).css('display', 'none');
                                    }

                                    if (itemPrice == 0){
                                        $('#DOPBookingSystemPROAddReservation_PaymentArrival'+ID).css('display', 'none');
                                        $('#DOPBookingSystemPROAddReservation_PaymentPayPal'+ID).css('display', 'none');
                                        $('#DOPBookingSystemPROAddReservation_Price'+ID).css('display', 'none');
                                        $('#DOPBookingSystemPROAddReservation_PriceItemValue'+ID).val(0);
                                        $('#DOPBookingSystemPROAddReservation_PriceValue'+ID).val(0);
                                        $('#DOPBookingSystemPROAddReservation_DiscountValue'+ID).val(0);
                                        $('#DOPBookingSystemPROAddReservation_PriceToPayValue'+ID).val(0);
                                        $('#DOPBookingSystemPROAddReservation_PriceDepositValue'+ID).val(0);
                                    
                                        $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).html('<option value="0">'+PaymentNoneLabel+'</option>');
                                        $('#DOPBookingSystemPROAddReservation_PayPalTransactionID'+ID+'_Item').css('display', 'none');
                                    }
                                    else{
                                        if (Schedule[ciDay]['hours'][bookedHours[0]] != undefined && Schedule[ciDay]['hours'][bookedHours[0]]['bind'] == '1'){
                                            itemPrice = Schedule[ciDay]['hours'][bookedHours[0]]['promo'] == '' ? parseFloat(Schedule[ciDay]['hours'][bookedHours[0]]['price']):parseFloat(Schedule[ciDay]['hours'][bookedHours[0]]['promo']);
                                        }
                                    
                                        totalPrice = Math.round(itemPrice*$('#DOPBookingSystemPROAddReservation_NoItems'+ID).val()*100)/100;
                                        totalToPay = totalPrice;
                                        
                                        if (PaymentPayPalEnabled){
                                            depositToPay = Math.round(Deposit*totalToPay)/100;
                                        }

                                        $('#DOPBookingSystemPROAddReservation_PaymentArrival'+ID).css('display', 'block');
                                        $('#DOPBookingSystemPROAddReservation_PaymentPayPal'+ID).css('display', 'block');
                                        $('#DOPBookingSystemPROAddReservation_PriceItemValue'+ID).val(itemPrice);
                                        $('#DOPBookingSystemPROAddReservation_PriceValue'+ID).val(totalPrice);
                                        $('#DOPBookingSystemPROAddReservation_DiscountValue'+ID).val(0);
                                        $('#DOPBookingSystemPROAddReservation_PriceToPayValue'+ID).val(totalToPay);
                                        $('#DOPBookingSystemPROAddReservation_PriceDepositValue'+ID).val(depositToPay);
                                    
                                        $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).html('<option value="0">'+PaymentNoneLabel+'</option>');

                                        if (PaymentArrivalEnabled){
                                            $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).append('<option value="1">'+PaymentArrivalLabel+'</option>');
                                        }

                                        if (PaymentPayPalEnabled){
                                            $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).append('<option value="2">'+PaymentPayPalLabel+'</option>');
                                        }
                                        $('#DOPBookingSystemPROAddReservation_PayPalTransactionID'+ID+'_Item').css('display', 'none');
                                        
                                        $('#DOPBookingSystemPROAddReservation_Price'+ID+' .value').html(Currency+prototypes.getWithDecimals(totalToPay, 2));
                                    
                                        if (depositToPay != 0){
                                            $('#DOPBookingSystemPROAddReservation_Price'+ID+' .value').append('<br /><span class="medium">'+Currency+prototypes.getWithDecimals(depositToPay, 2)+' deposit ('+Deposit+'%)</span>');
                                        }
                                        $('#DOPBookingSystemPROAddReservation_Price'+ID).css('display', 'block');
                                    }

                                    $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID).css('display', 'none');
                                    $('#DOPBookingSystemPROAddReservation_ContactForm'+ID).css('display', 'block');                                
                                }                                
                            }
                            else{
                                methods.unavailableForm(NoServicesAvailableText);
                            }
                        }                  
                    },
                    hideForm:function(){
                        $('#DOPBookingSystemPROAddReservation_NoItems'+ID).html('<option value="1">1</option>');
                        $('#DOPBookingSystemPROAddReservation_NoItemsSelect'+ID).css('display', 'none');
                        $('#DOPBookingSystemPROAddReservation_Price'+ID).css('display', 'none');
                        $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID).css('display', 'none');
                        $('#DOPBookingSystemPROAddReservation_ContactForm'+ID).css('display', 'none');                        
                    },
                                        
                    book:function(){
                        if (clearReservationsClick && methods.validForm()){
                            var formData = new Array(), 
                            history = {},
                            i, j, o, y, d, m,
                            bookedDays = new Array(),
                            ciDay, ciy, cim, cid,
                            coDay, coy, com, cod,
                            firstMonth, lastMonth, firstDay, lastDay,
                            currYear, currMonth, currDay, currBookedDay,
                            bookedHours = new Array(),
                            sHour, eHour, currBookedHour,
                            email = '',
                            noReservations;
                            
                            // Form data
                            
                            for (i=0; i<Form.length; i++){
                                formData[i] = {"id": "",
                                               "name": "",
                                               "value": ""};
                                formData[i]['id'] = Form[i]['id'];
                                formData[i]['name'] = Form[i]['translation'];
                                
                                if (Form[i]['is_email'] == 'true' && email == ''){
                                    email = $('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).val();
                                }
                                
                                switch (Form[i]['type']){
                                    case 'checkbox':
                                        formData[i]['value'] = $('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).is(':checked');
                                        break
                                    case 'select':
                                        if ($('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).val() != null){
                                            if (Form[i]['multiple_select'] == 'true'){
                                                var selectedOptions = $('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).val();
                                                formData[i]['value'] = new Array();
                                                
                                                for (j=0; j<selectedOptions.length; j++){
                                                    for (o=0; o<Form[i]['options'].length; o++){
                                                        if (Form[i]['options'][o]['id'] == selectedOptions[j]){
                                                            formData[i]['value'][j] = Form[i]['options'][o];
                                                        }
                                                    }
                                                }
                                            }
                                            else{
                                                var selectedOption = $('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).val();
                                                formData[i]['value'] = new Array();
                                                
                                                for (o=0; o<Form[i]['options'].length; o++){
                                                    if (Form[i]['options'][o]['id'] == selectedOption){
                                                        formData[i]['value'][0] = Form[i]['options'][o];
                                                    }
                                                }
                                            }
                                        }
                                        break
                                    default:
                                        formData[i]['value'] = $('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).val();
                                }
                            }
                            
                            // Days data
                            if (!HoursEnabled){
                                if (MultipleDaysSelect){
                                    ciDay = $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val();
                                    coDay = $('#DOPBookingSystemPROAddReservation_CheckOut'+ID).val();
                                }
                                else{                            
                                    ciDay = $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val();
                                    coDay = $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val();
                                }

                                ciy = parseInt(ciDay.split('-')[0], 10);
                                cim = parseInt(ciDay.split('-')[1], 10);
                                cid = parseInt(ciDay.split('-')[2], 10);
                                coy = parseInt(coDay.split('-')[0], 10);
                                com = parseInt(coDay.split('-')[1], 10);
                                cod = parseInt(coDay.split('-')[2], 10);

                                for (y=ciy; y<=coy; y++){
                                    firstMonth = y == ciy ? cim:1;
                                    lastMonth = y == coy ? com:12;

                                    for (m=firstMonth; m<=lastMonth; m++){
                                        firstDay = y == ciy && m == cim ? cid:1;
                                        lastDay = y == coy && m == com ? cod:new Date(y,m,0).getDate();

                                        for (d=firstDay; d<=lastDay; d++){
                                            currYear = String(y);
                                            currMonth = prototypes.timeLongItem(m);
                                            currDay = prototypes.timeLongItem(d);

                                            bookedDays.push(currYear+'-'+currMonth+'-'+currDay);
                                        }
                                    }
                                }

                                for (i=0; i<bookedDays.length-(MorningCheckOut ? 1:0); i++){
                                    currBookedDay = bookedDays[i];

                                    history[currBookedDay] = {"available": "",
                                                              "bind": "",
                                                              "price": "",
                                                              "promo": "",
                                                              "status": ""};
                                    history[currBookedDay]['available'] = Schedule[currBookedDay]['available'];
                                    history[currBookedDay]['bind'] = Schedule[currBookedDay]['bind'];
                                    history[currBookedDay]['price'] = Schedule[currBookedDay]['price'];
                                    history[currBookedDay]['promo'] = Schedule[currBookedDay]['promo'];
                                    history[currBookedDay]['status'] = Schedule[currBookedDay]['status'];
                                }
                            }
                            else{
                                ciDay = $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val();
                                    
                                if (MultipleHoursSelect){
                                    sHour = $('#DOPBookingSystemPROAddReservation_StartHour'+ID).val();
                                    eHour = $('#DOPBookingSystemPROAddReservation_EndHour'+ID).val();
                                }
                                else{                            
                                    sHour = $('#DOPBookingSystemPROAddReservation_StartHour'+ID).val();
                                    eHour = $('#DOPBookingSystemPROAddReservation_StartHour'+ID).val();
                                }

                                $.each(Schedule[ciDay]['hours_definitions'], function(index){
                                    if (sHour <= Schedule[ciDay]['hours_definitions'][index]['value'] && Schedule[ciDay]['hours_definitions'][index]['value'] <= eHour){
                                        bookedHours.push(Schedule[ciDay]['hours_definitions'][index]['value']);
                                    }
                                });
                                
                                for (i=0; i<bookedHours.length-((!AddLastHourToTotalPrice || HoursIntervalEnabled) && MultipleHoursSelect && Schedule[ciDay]['hours'][bookedHours[0]]['bind'] == 0 ? 1:0); i++){
                                    currBookedHour = bookedHours[i];
                                    
                                    history[currBookedHour] = {"available": "",
                                                               "bind": "",
                                                               "price": "",
                                                               "promo": "",
                                                               "status": ""};
                                    history[currBookedHour]['available'] = Schedule[ciDay]['hours'][currBookedHour]['available'];
                                    history[currBookedHour]['bind'] = Schedule[ciDay]['hours'][currBookedHour]['bind'];
                                    history[currBookedHour]['price'] = Schedule[ciDay]['hours'][currBookedHour]['price'];
                                    history[currBookedHour]['promo'] = Schedule[ciDay]['hours'][currBookedHour]['promo'];
                                    history[currBookedHour]['status'] = Schedule[ciDay]['hours'][currBookedHour]['status'];
                                }
                            }
                            
                            dopbspToggleReservationsMessage('show', DOPBSP_SAVE);
        
                            $.post(ajaxurl, {action: 'dopbsp_add_reservation', 
                                             calendar_id: ID,
                                             check_in: $('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val(),
                                             check_out: !HoursEnabled && MultipleDaysSelect ? $('#DOPBookingSystemPROAddReservation_CheckOut'+ID).val():'',
                                             start_hour: HoursEnabled ? $('#DOPBookingSystemPROAddReservation_StartHour'+ID).val():'',
                                             end_hour: HoursEnabled && MultipleHoursSelect ? $('#DOPBookingSystemPROAddReservation_EndHour'+ID).val():(HoursEnabled && !MultipleHoursSelect && HoursIntervalEnabled ? $('#DOPBookingSystemPROAddReservation_EndHour'+ID).val():''),
                                             no_items: $('#DOPBookingSystemPROAddReservation_NoItems'+ID).val(),
                                             currency: Currency,
                                             currency_code: CurrencyCode,
                                             total_price: $('#DOPBookingSystemPROAddReservation_PriceValue'+ID).val(),
                                             discount: $('#DOPBookingSystemPROAddReservation_DiscountValue'+ID).val(),
                                             price: $('#DOPBookingSystemPROAddReservation_PriceToPayValue'+ID).val(),
                                             deposit: $('#DOPBookingSystemPROAddReservation_PriceDepositValue'+ID).val(),
                                             email: email,
                                             no_people: NoPeopleEnabled ? $('#DOPBookingSystemPROAddReservation_NoPeople'+ID).val():'',
                                             no_children: NoPeopleEnabled & NoChildrenEnabled ? $('#DOPBookingSystemPROAddReservation_NoChildren'+ID).val():'',
                                             status: $('#DOPBookingSystemPROAddReservation_Status'+ID).val(),
                                             payment_method: $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).val(),
                                             paypal_transaction_id: $('#DOPBookingSystemPROAddReservation_PaymentMethod'+ID).val() == '2' ? $('#DOPBookingSystemPROAddReservation_PayPalTransactionID'+ID).val():'',
                                             form: formData,
                                             days_hours_history: history}, function(data){
                                data = $.trim(data);
                                
                                var year, month;
                                
                                methods.resetForm();
                                $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID+' .value').html('<span class="success">'+AddReservationSuccess+'</span>');
                                $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID).css('display', 'block');
                                
                                dopbspToggleReservationsMessage('hide', AddReservationSuccess);
                                
                                if ($('#DOPBookingSystemPROAddReservation_Status'+ID).val() == 'pending'){
                                    noReservations = $('#DOPBSP-new-reservations span').html() == '' ? 1:parseInt($('#DOPBSP-new-reservations span').html(), 10)+1;

                                    if (noReservations > 0){                                            
                                        $('#DOPBSP-new-reservations').addClass('new');
                                    }                                   
                                    $('#DOPBSP-new-reservations span').html(noReservations);
                                }
                                
                                if ($('#calendar_refresh').val() != undefined){
                                    $('#calendar_refresh').val('true');
                                }
                                
                                if (data != ''){
                                    year = parseInt(data.split('-')[0]);
                                    month = parseInt(data.split('-')[1]);
                                    
                                    for (var day in Schedule){
                                        if (day.indexOf(year) != -1){                                      
                                            delete Schedule[day];
                                        }                            
                                    }

                                    $.post(ajaxurl, {action: 'dopbsp_load_schedule', calendar_id: ID, year: year}, function(data){
                                        if ($.trim(data) != ''){
                                            $.extend(Schedule, JSON.parse($.trim(data)));
                                        }
                                    });
                                }
                            });
                        }
                    },
                    validForm:function(){
                        var validForm = true, i;
                        
                        if ($('#DOPBookingSystemPROAddReservation_CheckIn'+ID).val() != '' && ($('#DOPBookingSystemPROAddReservation_CheckOut'+ID).val() == undefined || $('#DOPBookingSystemPROAddReservation_CheckOut'+ID).val() != '')
                            && ($('#DOPBookingSystemPROAddReservation_StartHour'+ID).val() == undefined || $('#DOPBookingSystemPROAddReservation_StartHour'+ID).val() != '')
                            && ($('#DOPBookingSystemPROAddReservation_EndHourView'+ID).val() == undefined || $('#DOPBookingSystemPROAddReservation_EndHourView'+ID).val() != '')){
                            
                            for (i=0; i<Form.length; i++){
                                switch (Form[i]['type']){
                                    case 'checkbox':
                                        if (Form[i]['required'] == 'true' && $('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).is(':checked')){
                                            $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID+' .value').html(Form[i]['translation']+' '+FormRequired);
                                            $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID).css('display', 'block');
                                            return false;
                                        }
                                        break;
                                    case 'text':
                                        if (Form[i]['required'] == 'true' && $('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).val() == ''){
                                            $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID+' .value').html(Form[i]['translation']+' '+FormRequired);
                                            $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID).css('display', 'block');
                                            return false;
                                        }
                                        else if (Form[i]['is_email'] == 'true' && !prototypes.validEmail($('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).val())){
                                            $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID+' .value').html(Form[i]['translation']+' '+FormEmailInvalid);
                                            $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID).css('display', 'block');
                                            return false;
                                            
                                        }
                                        break;
                                    case 'select':
                                        if (Form[i]['required'] == 'true' && ($('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).val() == '' || $('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).val() == null)){
                                            $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID+' .value').html(Form[i]['translation']+' '+FormRequired);
                                            $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID).css('display', 'block');
                                            return false;
                                        }
                                        break;
                                    case 'textarea':
                                        if (Form[i]['required'] == 'true' && $('#DOPBookingSystemPROAddReservation_FormField'+ID+'_'+Form[i]['id']).val() == ''){
                                            $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID+' .value').html(Form[i]['translation']+' '+FormRequired);
                                            $('#DOPBookingSystemPROAddReservation_InfoMessage'+ID).css('display', 'block');
                                            return false;
                                        }
                                        break;
                                }
                            }
                            
                            return validForm;
                        }
                        else{
                            return false;
                        }
                    },
                    
                    nextHour:function(hour, hours){
                        var nextHour = '24:00', i;
                        
                        for (i=hours.length-1; i>=0; i--){
                            if (hours[i]['value'] > hour){
                                nextHour = hours[i]['value'];
                            }
                        }
                        
                        return nextHour;
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
    };
})(jQuery);