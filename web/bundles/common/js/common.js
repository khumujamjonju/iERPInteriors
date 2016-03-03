//for hide show table 
function fnHideShow(elementId) {
    var key = $('.' + elementId + '_hide_show_key').val();
    if (key == 1) {
        $('.' + elementId).hide();
        $('.' + elementId + '_hide_show_key').val(0);
        $('.' + elementId + '_hide_show_icon').removeClass('minus').addClass('plus');
    }
    if (key == 0) {
        $('.' + elementId).show();
        $('.' + elementId + '_hide_show_key').val(1);
        $('.' + elementId + '_hide_show_icon').removeClass('plus').addClass('minus');
    }
}

//validation digit only
function validationDigit(eleID) {
    if (isNaN(String.fromCharCode(event.keyCode))|| event.keyCode==13) {
        $(eleID).focus();
        fnCmnWarningMessage('Please enter valid digit !!!');
        $('.messageDiv').show();
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    } else {
        $('.messageDiv').hide();
    }
}

//common empty element
function fnCmnEmptyElement(elementIDorClass) {
    $(elementIDorClass).empty();
}
function fnCmnEmptyElementAndShowAnotherElement(emptyElement, showElement) {
    $(emptyElement).empty();
    $(showElement).show();
}

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function fnCmnScrollToElementIDorClass(elementIDorClass) {
    $("html,body").animate({scrollTop: $(elementIDorClass).offset().top}, 500);
}


function fnCmnSuccessMessage($message) {
    $('.message').removeClass('error-box');
    $('.message').removeClass('warning');
    $('.messageDiv').show();
    $('.message').empty().addClass('alert-box').addClass('success');
    $('.message').append('<span>Success : </span>' + $message);
    // $('.message').attr('tabindex', -1).focus();
}
function fnCmnErrorMessage($message) {
    $('.message').removeClass('success');
    $('.message').removeClass('warning');
    $('.messageDiv').show();
    $('.message').empty().addClass('alert-box').addClass('error-box');
    $('.message').append('<span>Error : </span>' + $message);
    ///$('.message').attr('tabindex', 1).focus();
}
function fnCmnWarningMessage($message) {

    //$('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
    //$('.message').append('<span>Error: </span>' + result.message);
    $('.message').removeClass('success');
    $('.message').removeClass('error-message');
    $('.messageDiv').show();
    $('.trMessage').focus();
    $('.message').empty().addClass('alert-box').addClass('warning');
    $('.message').append('<span>Info : </span>' + $message);
    //$('.message').attr('tabindex', 2).focus();
}
//********message alert for popup form*******
function fnCmnSuccessMessage1($message, elementIDorClass) {
    $(elementIDorClass).removeClass('error-box');
    $(elementIDorClass).removeClass('warning');
    $(elementIDorClass).show();
    $(elementIDorClass).empty().addClass('alert-box').addClass('success');
    $(elementIDorClass).append('<span>Success : </span>' + $message);
    // $('.message').attr('tabindex', -1).focus();
}
function fnCmnErrorMessage1($message, elementIDorClass) {
    $(elementIDorClass).removeClass('success');
    $(elementIDorClass).removeClass('warning');
    $(elementIDorClass).show();
    $(elementIDorClass).empty().addClass('alert-box').addClass('error-box');
    $(elementIDorClass).append('<span>Error : </span>' + $message);
    ///$('.message').attr('tabindex', 1).focus();
}
function fnCmnWarningMessage1($message, elementIDorClass) {
    $(elementIDorClass).removeClass('success');
    $(elementIDorClass).removeClass('error-message');
    $(elementIDorClass).show();  
    $(elementIDorClass).empty().addClass('alert-box').addClass('warning');
    $(elementIDorClass).append('<span>Info : </span>' + $message);
    //$('.message').attr('tabindex', 2).focus();
}

//showing the message alert box
function commonMessageAlert1(msg, elementIDorClass)
{
    $(elementIDorClass).show();
    $(elementIDorClass).empty().addClass('alert-box').addClass('warning');
    $(elementIDorClass).append('<span>Warning: </span>' + msg);
}

//*****end popup message*******

//pop up form ajax loader 
function startAjaxLoaderFormPopUp(elementIDorClass){
    var loaderImg = $('#ajax_loader_popup_form').html();
    $(elementIDorClass).removeClass('alert-box').removeClass('success').removeClass('warning').removeClass('error-box').removeClass('notice').html(loaderImg);
}

//showing the message alert box
function commonMessageAlert(msg)
{
    $('.messageDiv').show();
    $('.message').empty().addClass('alert-box').addClass('warning');
    $('.message').append('<span>Warning: </span>' + msg);
}


//show button and enable input fields on click edit button
function commonEditBtn(txtInputID1, txtInputID2) {
    $('#btn_update').show();
    $('#btn_clear').hide();
    $('#btn_edit').hide();

    $('#' + txtInputID1).prop('disabled', false).removeClass('inputDisable_bg');
    $('#' + txtInputID2).prop('disabled', false).removeClass('inputDisable_bg');
}

//show button and enable input fields on click cancel button 
function commonCancelBtn(txtInputID1, txtInputID2, txtInputID3) {
    $('#btn_update').hide();
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_clear').show();
    $('#btn_save').show();
    $('.messageDiv').hide();
    $('#' + txtInputID3).val('');
    $('#' + txtInputID1).prop('disabled', false).removeClass('inputDisable_bg').val('');
    $('#' + txtInputID2).prop('disabled', false).removeClass('inputDisable_bg').val('');
}

//preview photo before upload
function readURL(input, targetID) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#' + targetID).attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}


//for common form reset
function formReset() {

    var formId = $('form').attr('id');
    var r = confirm("Are you sure to Reset all fields?");
    if (r === true) {
        document.getElementById(formId).reset();
        $('#' + formId).find('#profile-view').attr('src', '../bundles/common/images/unk.jpg');
        return true;
    }
    else {
        return false;
    }
}

//for loading on click button
function startLoading() {
    $('.loadingDiv').show();
    $("#randomArea").Loadingdotdotdot({
        "speed": 400,
        "maxDots": 4
    });
    $('#divBlocker').show();
}
function stopLoading() {
    $('.loadingDiv').hide();
    $("#randomArea").html("");
    $("#randomArea").Loadingdotdotdot("Stop");
    $('#divBlocker').hide();
}
function scrollToMessage() {
    $('html, body').animate({
        scrollTop: $("#messageDiv").offset().top
    }, 100);
}
function scrolltodiv(divid) {
    $('html, body').animate({
        scrollTop: $("#" + divid).offset().top
    }, 100);
}
function isPostalCode(zipcode) {
    var regZipcode = /^([0-9]){6}?$/;
    if (regZipcode.test(zipcode) === true) {
        return true;
    } else {
        return false;
    }

}
function toUpper(thisid) {
    var txtbox = document.getElementById(thisid);
    txtbox.value = txtbox.value.toUpperCase();
}
/*
 * use by customer_contact.html.twig
 *WORK for 3 id
 *use when i want a div to empty any id say X, another id say Y to empty and hide, one more id say Zto show
 *cim_captureAll_customerDetails.html.twig 322
 */
function cmnEmpty($Id)
{
    $('#' + $Id).empty();
}
function cmnNulEmpty($iDvalToempty, $idToHide) {
    $('#' + $iDvalToempty).val('');
    $('#' + $idToHide).hide();
}
function cmnShow($idToShow) {
    $('#' + $idToShow).show();
}
function cmnfnEmptyShow($idToEmpty, $iDToHide, $iDvalToempty, $IdToShow) {
    cmnEmpty($idToEmpty);
    cmnNulEmpty($iDvalToempty, $iDToHide);
    cmnShow($IdToShow);
}
function lmsShowHideAddressResult(idSurfix)
{
    var spanCloseOpenHandler = $('#spanCloseOpenHandler' + idSurfix).val();
    if (spanCloseOpenHandler === '0') {
        $("#trAddress" + idSurfix).hide();
        document.getElementById('spanId' + idSurfix).className = 'span_close';   // document.getElementById('spanCloseOpenHandler').value='1';
        $('#spanCloseOpenHandler' + idSurfix).val('1');
    }
    else {
        $("#trAddress" + idSurfix).show();
        document.getElementById('spanId' + idSurfix).className = 'span_open';
        $('#spanCloseOpenHandler' + idSurfix).val('0');
    }
    return true;
}
function cmnFormEditionEnable(formid, showId, hideId) {
    $('form#' + formid + ' input').attr('readonly', false);
    $('form#' + formid + ' input').attr('disabled', false);
    $('form#' + formid + ' input').removeClass('disabled-content');
    $('form#' + formid + ' select').attr('disabled', false);
    $('form#' + formid + ' select').removeClass('disabled-content');
    $('form#' + formid + ' textarea').attr('readonly', false);
    $('form#' + formid + ' textarea').attr('disabled', false);
    $('form#' + formid + ' textarea').removeClass('disabled-content');
    $('#' + showId).show();
    $('#' + hideId).hide();
    $('#' + formid + ' input').attr('disabled', false);
}
$('#right-content').on('datePicker', function () {
    $('.datepicker').datepicker({
        showOn: "button",
        buttonImage: $('#datePickerImage').val(),
        dateFormat: "dd-M-yy",
        changeMonth: true,
        changeYear: true,
        buttonImageOnly: true
    });
});
function formatMoney(thisid) {
    var ctrl = document.getElementById(thisid);
    if(isNaN(ctrl.value)){
        ctrl.value = '0.00';
    }else{
        ctrl.value = (Math.floor(100 * ctrl.value) / 100).toFixed(2);
    }
}
function floorFigure(figure, decimals) { //figure=number to be formated. decimals=decimal places

    if (!decimals)
        decimals = 2;
    var d = Math.pow(10, decimals);
    return ((figure * d) / d).toFixed(decimals);
}
;
function CallPrint(containerid) {
    var prtContent = document.getElementById(containerid);
    var WinPrint = window.open('', '_newtab');
    //WinPrint.resizeTo(screen.width, screen.height);
    WinPrint.document.write(prtContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    // WinPrint.close();
}
function disableEnterKey(e) {
    var key;
    if (window.event)
        key = window.event.keyCode;     //IE
    else
        key = e.which;     //firefox
    if (key == 13)
        return false;
    else
        return true;
}
function AccessDenied(html){
    $('#content').empty().append(html);
    $('#content').append('<div class="clear"></div>');
    //$('#right-content1').empty().append(html);
    stopLoading();
}
function NullonEnterKey(key){
    var keycode = (key.which) ? key.which : key.keyCode;
    if(keycode==13){
        return false;
    }
}


