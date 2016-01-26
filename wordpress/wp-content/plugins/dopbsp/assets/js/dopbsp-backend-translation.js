/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 1.9
* File                    : dopbsp-backend-translation.js
* File Version            : 1.2
* Created / Last Modified : 03 December 2013
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO Translation Scripts.
*/


//****************************************************************************** Translation

function dopbspChangeTranslation(){
    if (clearClick){
        dopbspToggleMessage('show', DOPBSP_SAVE);
        
        $jDOPBSP.post(ajaxurl, {action: 'dopbsp_change_translation',
                                language: $jDOPBSP('#DOPBSP-admin-translation').val()}, function(data){
            window.location.reload();
        });
    }
}

// Edit Translation

function dopbspShowTranslation(){// Show all translation.
    if (clearClick){
        dopbspToggleMessage('show', DOPBSP_LOAD);
        dopbspHideTranslationForm(true);
        $jDOPBSP('#DOPBSP-translation-content').html('');
        
        $jDOPBSP.post(ajaxurl, {action: 'dopbsp_show_translation',
                                location: $jDOPBSP('#DOPBSP-translation-location').val(),
                                language: $jDOPBSP('#DOPBSP-translation-language').val()}, function(data){
            $jDOPBSP('#DOPBSP-translation-content').html(data);
            dopbspToggleMessage('hide', DOPBSP_TRANSLATION_LOADED);
            dopbspHideTranslationForm(false);
        });
    }
}

function dopbspEditTranslation(id, language, value, onBlur){
    onBlur = onBlur == undefined ? false:true;
    
    if (ajaxRequestInProgress != undefined && !onBlur){
        ajaxRequestInProgress.abort();
    }
    
    if (saveTranslationTimeout != undefined){
        clearTimeout(saveTranslationTimeout);
    }
    $jDOPBSP('.DOPBSP-admin .translation-loader').css('display', 'none');
    $jDOPBSP('#DOPBSP-translation-loader'+id).css('display', 'block');
    
    if (onBlur){
        $jDOPBSP.post(ajaxurl, {action: 'dopbsp_edit_translation',
                                id: id,
                                language: language,
                                value: value}, function(data){
            $jDOPBSP('#DOPBSP-translation-loader'+id).css('display', 'none');
        });
    }
    else{
        saveTranslationTimeout = setTimeout(function(){
            clearTimeout(saveTranslationTimeout);
            
            ajaxRequestInProgress = $jDOPBSP.post(ajaxurl, {action: 'dopbsp_edit_translation',
                                                            id: id,
                                                            language: language,
                                                            value: value}, function(data){
                $jDOPBSP('#DOPBSP-translation-loader'+id).css('display', 'none');
            });
        }, 600);
    }
}

function dopbspSearchTranslation(){
    var search = $jDOPBSP('#DOPBSP-translation-search').val().toLowerCase();
    
    $jDOPBSP('#DOPBSP-translation-content tr').each(function(){
        if ($jDOPBSP('td:first-child', this).html().toLowerCase().indexOf(search) != -1
            || $jDOPBSP('textarea', this).val().toLowerCase().indexOf(search) != -1
            || search == ''){
            $jDOPBSP(this).removeAttr('style');
        }
        else{
            $jDOPBSP(this).css('display','none');
        }
    });
}

function dopbspResetTranslation(){
    if (clearClick && confirm(DOPBSP_TRANSLATION_RESET_CONFIRMATION)){
        dopbspToggleMessage('show', DOPBSP_SAVE);
        dopbspHideTranslationForm(true);
        $jDOPBSP('#DOPBSP-translation-content').html('');
        
        $jDOPBSP.post(ajaxurl, {action: 'dopbsp_reset_translation'}, function(data){
            window.location.reload();
        });
    }
    
}

function dopbspHideTranslationForm(value){
    value = value == undefined ? true:value;
    
    if (value){
        $jDOPBSP('#DOPBSP-translation-location').attr('disabled', 'disabled');
        $jDOPBSP('#DOPBSP-translation-language').attr('disabled', 'disabled');
        $jDOPBSP('#DOPBSP-translation-search').attr('disabled', 'disabled');
    }
    else{
        $jDOPBSP('#DOPBSP-translation-location').removeAttr('disabled');
        $jDOPBSP('#DOPBSP-translation-language').removeAttr('disabled');
        $jDOPBSP('#DOPBSP-translation-search').removeAttr('disabled');
    }                               
}