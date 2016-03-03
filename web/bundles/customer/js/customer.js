/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function isMobileNo(mobileNO){    
    var mobileFormat=/^([0-9]){10}?$/;
    if (mobileFormat.test(mobileNO) === true) {
        return true;
    } else { 
        return false;
    }    
}
function resetAnyForm() {
    if (confirm("Are you sure you want to reset all the fields")) {
        return true;
    }
    return false;
    $('.messageDiv').hide();
}
function cimSaveNewCustomer(url) 
{
    $('.messageDiv').hide();
    if ($('#txtcontactMobNo').val().trim()=='') 
    {
        fnCmnWarningMessage("Enter 10 digits Mobile No.!");
        ('#txtcontactMobNo').focus(); 
        scrollToMessage();
        return;
    }
    if(!isMobileNo($('#txtcontactMobNo').val())){
        fnCmnWarningMessage("Mobile No. is Invalid. Mobile No. must be of 10 digits.");
        $('#txtcontactMobNo').focus();
        scrollToMessage();
        return;
    }
    if ($('#txtCustomerName').val().trim()=='') 
    {
        fnCmnWarningMessage("Enter Customer Name!");
        $('#txtCustomerName').focus();
        scrollToMessage();
        return;
    }
    if ($('#txtContactPerson').val().trim()=='') 
    {
        fnCmnWarningMessage("Enter Contact Person Name!");
        $('#txtContactPerson').focus();
        scrollToMessage();
        return;
    }
//    if ($('#txt_emailId').val().trim()=='') 
//    {
//        fnCmnWarningMessage("Enter Email ID!");
//        $('#txt_emailId').focus();
//        scrollToMessage();
//        return;
//    }
    if($('#txt_emailId').val() != '' && !isValidEmail($('#txt_emailId').val())){
        fnCmnWarningMessage("Email ID is invalid. Please enter a valid Email ID!");
        $('#txt_emailId').focus();
        scrollToMessage();
        return;
    }
    startLoading();
    var CreateCus = $('form#customerSearchForm').serializeObject();
    var dataString = JSON.stringify(CreateCus);   /* convert the JSON object into string */
   // alert(dataString);
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        data: dataString, 
        dataType: 'json',
        success: function(response) {
            if(response.jsonData=='AD'){
                    AccessDenied(response.html);
                    return;
                }
            var isSuccess = response.success;
            var message = response.message;
            if (isSuccess) {
                var rtnHtml = response.html;
                //alert(rtnHtml);
                fnCmnSuccessMessage(message);
                $('#loadFullCustomerDetailsForm').empty().append(rtnHtml);
                scrollToMessage();
                stopLoading();
            }
            else 
            {
                fnCmnWarningMessage(message);
                //$('#loadResultOfSearchAction').empty().append(response.html);
                scrollToMessage();
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
            scrollToMessage();
            stopLoading();
        }
    });
}
function addNewCustomerMaster(url,elementObj)
{  
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('input[name~="mobileNo"]').val().trim()==''){
        fnCmnWarningMessage('Mobile no. can\'t be null !');
        scrollToMessage();        
        return;
    }     
    $('.messageDiv').hide(); 
    startLoading();
    var formData = $('form#frmCreateCustomer').serializeObject();
    var dataString = JSON.stringify(formData);  
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){
               if(result.success){    
                    $('#display-list').empty().append(result.html); 
                    fnCmnSuccessMessage(result.message);
                    scrollToMessage();
                    stopLoading();
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                    $('#txt_mobile_no').prop('disabled', true).addClass('disable_bg');

                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();
                    $('#btn_edit').hide();
                    $('#btn_cancel').hide();
                }
                else{
                    fnCmnWarningMessage(result.message);
                    scrollToMessage();
                    stopLoading();
                }
                stopLoading();
           },
            error: function(){
                fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
                scrollToMessage();
                stopLoading();
            }
        });   
}
function cimEditUpdateCustDetails(url) 
{
    $('.messageDiv').hide();
    if ($('#customerName').val().trim()=='') 
    {
        fnCmnWarningMessage("Customer Name cannot be empty.");
        $('#customerName').focus();
        scrollToMessage();
        return;
    }    
    /*if ($('#CustomerMobileNo').val().trim()=='') 
    {
        fnCmnWarningMessage("Mobile Number cannot be empty.");
        $('#CustomerMobileNo').focus();
        scrollToMessage();
        return;
    }
    if (!isMobileNo($('#CustomerMobileNo').val())) 
    {
        fnCmnWarningMessage("Mobile Number seems to be invalid.");
        $('#CustomerMobileNo').focus();
        scrollToMessage();
        return;
    } */  
    startLoading();
    var CreateCus = $('form#frmCreateCustomer').serializeObject();
    var dataString = JSON.stringify(CreateCus);   /* convert the JSON object into string */
   // alert(dataString);
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        data: dataString, 
        dataType: 'json',
        success: function(response) {
            if(response.jsonData=='AD'){
                    AccessDenied(response.html);
                    return;
                }
            var isSuccess = response.success;
            var message = response.message;
            if (isSuccess) {
               // var rtnHtml = response.html;
                fnCmnSuccessMessage(message);
               // $('#btnCusEdit').show();
               // $('#btncusUpdate').hide();
                //$('#btnClear').hide();
               // $('#frmCreateCustomer input[type="text"], input[type="checkbox"], select').prop("disabled", true);
                scrollToMessage();
                stopLoading();
            }
            else 
            {
                fnCmnWarningMessage(message);
                scrollToMessage();
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function fnShowSubPartCustomerForm($tabId) {
    //if ($tabId > 1 && $('#cimMandatoryAttributeFieldCount').val() > 0) {
    //   alert('Please Enter the Mandatory Additional Field.');
    //   return;
    //}

    $temp = $('#showTableId').val();
    $("#sub_table" + $temp).hide();
    $('#showTableId').val($tabId);
    document.getElementById("sub-tab" + $temp).className = '';
    document.getElementById("sub-tab" + $tabId).className = 'active';
    $("#sub_table" + $tabId).show();
    $('.messageDiv').hide();
    return true;
}


/** This is used for loading the address detail for insertion as well as view
 *    "Pre Assumption is that it would be used only for customer" 
 * Using Twig Name:
 *   cim_captureAll_cusDetail.html
 *   
 *   typeIdentifierForAddress=Customer,  
 * @returns {undefined}
 */ 
function FnLoadSaveAddressType(url,typeIdentifierForAddress)
{
    $('.messageDiv').hide();
    startLoading();
    var selValue = $('#selectAddType'+typeIdentifierForAddress).val();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success)
            {
                $('#addNewAddress').empty().append(result.html);
                stopLoading();
            }
            else
            {
                fnCmnWarningMessage(result.message);
                scrollToMessage();
                stopLoading();
            }
        },
        error: function()
        {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}


function FnCimViewAddress(selectId)
{
    if($('#'+selectId).val()==''){
        return;
    }
    var mode=$('#'+selectId).val().split('&')[1];
    if(mode=='del'){
        if(!confirm('Are you sure you want to delete this Address?'))
            return false;
    }
    var url = $('#'+selectId).val().split('&')[0];
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success)
            {
                if(mode=='del'){
                    $('#newListAddress_GroupId').empty();
                    $('#newListAddress_GroupId').append(result.html).trigger('datePicker').focus();
                    $('#addNewAddress').empty();
                    stopLoading();
                    fnCmnSuccessMessage(result.message);  
                    scrollToMessage();
                    
                }
                else{
                    $('#addNewAddress').empty().append(result.html);  
                    stopLoading();
                }
                
            }
            else
            {
                fnCmnWarningMessage(result.message);
                scrollToMessage();
                stopLoading();
            }
        },
        error: function()
        {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}


function cimFnSelectAddress(id, entity) {
    var cancateFieldValue = $('#' + id).val();
    if (cancateFieldValue === '') {
        alert("Field Can't be null!");
        $('#' + id).focus();
    }
    else {
        var addedAddress = 'instanceAdd' + entity;
        var addedAddressVal = $("input:hidden[name~='" + addedAddress + "']").val();
        var arrayFieldAddress = addedAddressVal.split("+");
        var addressName = arrayFieldAddress[0];
        var addressPkId = arrayFieldAddress[1];
        var arrayFieldValue = cancateFieldValue.split("+");
        var url = arrayFieldValue[0];
        var insertAttribute = {
            "fieldName": addressName,
            "fieldValue": addressPkId,
            "typeIdentifierForAddress": entity
        };
        startLoading();
        var dataString = JSON.stringify(insertAttribute);        
        $.ajax({
            type: 'POST',
            url: url,
            contentType: 'application/json',
            data: dataString,
            dataType: 'html',
            success: function(result) {
                $('#addNewAddress' + entity).empty();
                $('#addNewAddress' + entity).append(result);
                stopLoading();
                paginationTbl();
                doChosen();
            },
            error: function() {
                fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
                scrollToMessage();
                stopLoading();
            }
        });
    }
}


/* uses by
 *          customer_address.html.twig
 */
function cimSaveAddressDetails() {
    $('.messageDiv').hide();
   if ($('#addCode').val().trim() === '') {
        fnCmnWarningMessage("Address Code can't be empty!");
        scrollToMessage();
        $('#addCode').focus();
        return;
    }    
    if ($('#address1').val().trim() === '') {
        fnCmnWarningMessage("Address Line 1 can't be empty!");
        scrollToMessage();
        $('#address1').focus();
        return;
    }
    if ($('#selcountry').val().trim() === '') {
        fnCmnWarningMessage("You must select a country.");
        scrollToMessage();
        $('#selcountry').focus();
        return;
    }
    if ($('#selstate').val().trim() === '') {
        fnCmnWarningMessage("You must select a State.");
        scrollToMessage();
        $('#selstate').focus();
        return;
    }
    /*if ($('#seldistrict').val().trim() === '') {       
        fnCmnWarningMessage("You must select a district!");
        scrollToMessage();
        $('#seldistrict').focus();
        return;
    }
    if ($('#selcity').val().trim() === '') {       
        fnCmnWarningMessage("You must select a city!");
        scrollToMessage();
        $('#selcity').focus();
        return;
    }*/
    if ($('#zipcode').val().trim() === '') {
        fnCmnWarningMessage("Please Enter Postal Code!");
        scrollToMessage();
        $('#zipcode').focus();
        return;
    }

     if (!isPostalCode($('#zipcode').val().trim()))
    {
        fnCmnWarningMessage("Not Valid Postal Code!!!!");
        scrollToMessage();
        return;
    }
    startLoading();
    var url = $('#urlCreateAddress').val();
    $formId = 'frmCreateAddress';
    $('#sameAsTb').hide();
    var formData = new FormData($('#'+$formId)[0]);
    $.ajax({
        type: 'POST',
        url: url,
        contentType: false,
        processData: false,
        data: formData,
        dataType: 'json',
        success: function(response) {
            if(response.jsonData=='AD'){
                    AccessDenied(response.html);
                    return;
                }
                var isSuccess = response.success;
                var message = response.message;
                var rtnHtml = response.html;
             if (isSuccess) {
                $('#newListAddress_GroupId').empty();
                $('#newListAddress_GroupId').append(rtnHtml).trigger('datePicker').focus();
                $('#addNewAddress').empty();
                fnCmnSuccessMessage(message);
                scrollToMessage();
                stopLoading();
           }
             else {
                fnCmnWarningMessage(message);
                scrollToMessage();
                stopLoading();         
            }
         },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

/*
 * Function to call when edit and create new contact
 * @param {type} divId
 * @param {type} url
 * @param {type} action
 * @returns {undefined}
 */
function cimContactViewEdit(divId, url, handleData) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            if(response.jsonData=='AD'){
                    AccessDenied(response.html);
                    return;
                }
            var isSuccess = response.success;
            var message = response.message;
            var rtnHtml = response.html;
            if (isSuccess) {
               $('#' + divId).empty().append(rtnHtml);
                stopLoading();
            } else {
                fnCmnWarningMessage(message);
                scrollToMessage();
                stopLoading();
            }
            handleData(1);
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function cimSearchForCustomer() {
    $('.messageDiv').hide();
    $('#EditArea').empty();
    $('#PrintArea').empty();
    if($('#txtMobileNo').val().trim()!=''){
        if(!isMobileNo($('#txtMobileNo').val())){
            fnCmnWarningMessage('Mobile Number is invalid.');
            $('#txtMobileNo').empty();
            scrollToMessage();
            return;
        }
    }
    var url=$('#inputsearchUrl').val();
    var CreateCus = $('form#customerSearchForm').serializeObject();
    var dataString = JSON.stringify(CreateCus);   /* convert the JSON object into string */
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        data: dataString, 
        dataType: 'json',
        success: function(response) {
            if(response.jsonData=='AD'){
                    AccessDenied(response.html);
                    return;
                }
            var isSuccess = response.success;
            var message = response.message;
            if (isSuccess) {
                var rtnHtml = response.html; 
                //fnCmnSuccessMessage(message);
                $('#idforDisplay').empty().append(rtnHtml);
                $('#idforDisplay').append('<div class="clear"></div>');
                stopLoading();
                paginationTbl();
                lmsShowHideAddressResult('SearchCustomer');
                $('#EditArea').empty();
            }
            else 
            {
                fnCmnWarningMessage(message);
                $('#idforDisplay').empty();
                scrollToMessage();
                stopLoading();
            }            
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function loadEditCustPage(mobtxn)
{   
    $('.messageDiv').hide();
    var selValue = $('#prodtype' + mobtxn).val();
    if(selValue==''){
        return;
    }
    var url=selValue.split('&')[0];
    var action=selValue.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected customer?'))
            return;
    }
    if(action == 'advPay'){
        var addData = { 'key' : 'advPay'};
        $('#PrintArea').empty();
    }else{
        var addData = { 'key' : 'viwHis'};
        $('#PrintArea').empty();
    }
    startLoading();
    $.ajax({
           type: 'POST',
           url: url,
           data: JSON.stringify(addData),
           contentType: 'application/json',            
           dataType: 'json',
           success: function(result) {
               if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
                    if(result.success){
                        var msg=result.message;
                        switch(action){
                            case 'del':                                        
                                        $('#EditArea').empty();
                                        cimSearchForCustomer();
                                        lmsShowHideAddressResult('SearchCustomer');
                                        fnCmnSuccessMessage(result.message);
                                        scrollToMessage();                                                                       
                                        break;
                            case 'edt':
                                        lmsShowHideAddressResult('SearchCustomerResult');
                                        $('#EditArea').empty().append(result.html);
                                        break;
                            case 'viwHis':
                                        lmsShowHideAddressResult('SearchCustomerResult');
                                        $('#EditArea').empty().append(result.html);
                                        $('#for_cus_advance_payment_form').hide();
                                        var cusID = $('#cusID' + result.jsonData ).val();
                                        var cusName = $('#cusName' + result.jsonData ).val();
                                        $('.cusInfo').html('Customer ID: '+ cusID +' ,'+cusName);
                                        break;
                            case 'advPay':                      
                                        $('#EditArea').empty().append(result.html);
                                        $('#for_cus_advance_payment_form').show();
                                        var cusID = $('#cusID' + result.jsonData ).val();
                                        var cusName = $('#cusName' + result.jsonData ).val();
                                        $('.cusInfo').html('Customer ID: '+ cusID +' ,'+cusName);
                                        $('#customer_id').val(result.jsonData); //hidden field use for customer pkid
                                        lmsShowHideAddressResult('SearchCustomerResult');
                                        break;

                       }
                       stopLoading();
                    }
                    else{
                        fnCmnWarningMessage(result.message);
                        scrollToMessage();   
                        stopLoading();
                    }
                    
           },
           error: function() {
                fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
                scrollToMessage();
                stopLoading();
           }
       });
}

function fnEmptyClosestElement(eleObj){
    $(eleObj).closest('div').empty();
}

function cmnCusApprovedOrRejectCreatedAdvancePayment(eleObj, url, key){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    
    //check selected advance payment or not
    var checkflag = 0;
    var breakOut;
    tbl.find('.select_adv_pay').each(function(){
            if($(this).prop('checked') == true){
                checkflag = 1;
                var cus_advance_pkid = $(this).val(); 
                //check description blank
                if($('#description'+cus_advance_pkid).val().trim()==''){ 
                    commonMessageAlert('Please give some description!');
                    fnCmnScrollToElementIDorClass('#wrapper');
                    $('#description'+cus_advance_pkid).focus();
                    breakOut = true;
                    return false;
                }
            }               
     }); 
     if (breakOut) {
        breakOut = false;
        return false;
    }
    if(checkflag == 0){
       commonMessageAlert('Please select one of the Advance Payment details !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
   
    var approveOrRejectedDate = tbl.find('input[name~="txt_approved_or_rejected_date"]');
    if(approveOrRejectedDate.val().trim()==''){
       approveOrRejectedDate.focus();
       commonMessageAlert('Approve or Reject Date can\'t be empty !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
    
    var alertMsg = '';
    switch(key){
        case 'A': alertMsg = 'Are you sure to approve selected advance payment ?';
                  break;
        case 'R': alertMsg = 'Are you sure to reject selected advance payment ?';
                  break;
    }
    if(!confirm(alertMsg)){
        return false;
    }
    
    var formData = $('form#frmApprovalCreateAdvancePayment').serializeObject();  
    var addData = { 'key' : key };
    var dataString = JSON.stringify($.extend(formData,addData)); 
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {           
                $('#search_emp_result').empty().append(result.html);
                if(result.jsonData!=null && !isNaN(result.jsonData)){
                    if(parseInt(result.jsonData)>0){
                        $('#spanCount').text(result.jsonData);
                        $('#spanCount').show();
                    }else{
                        $('#spanCount').hide();
                    }
                }
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
                
                //find selected checkbox
                tbl.find('.select_adv_pay').each(function() {
                    if ($(this).prop('checked') == true) {
                        $(this).closest('tr').empty().remove();
                    }
                }); 
                $('#rapproved_or_rejected_date').val('');
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            fnCmnErrorMessage('An unknown technical error was encountered'); scrollToMessage(); stopLoading();
        }
    });
}

function cmnCusApprovedOrRejectCreatedAdvancePaymentByHod(eleObj, url, key){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    
    //check selected advance payment or not
    var checkflag = 0;
    var breakOut;
    tbl.find('.select_adv_pay').each(function(){
            if($(this).prop('checked') == true){
                checkflag = 1;
                var cus_advance_pkid = $(this).val(); 
                //check description blank
                if($('#description'+cus_advance_pkid).val().trim()==''){
                    commonMessageAlert('Please give some description!');
                    fnCmnScrollToElementIDorClass('#wrapper');
                    $('#description'+cus_advance_pkid).focus();
                    breakOut = true;
                    return false;
                }
            }               
     }); 
     if (breakOut) {
        breakOut = false;
        return false;
    }
    if(checkflag == 0){
       commonMessageAlert('Please select one of the Advance Payment details !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
    
    var approveOrRejectedDate = tbl.find('input[name~="txt_approved_or_rejected_date"]');
    if(approveOrRejectedDate.val().trim()==''){
       approveOrRejectedDate.focus();
       commonMessageAlert('Approve or Reject Date can\'t be empty !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
    
    var alertMsg = '';
    switch(key){
        case 'A': alertMsg = 'Are you sure to approve selected advance payment ?';
                  break;
        case 'R': alertMsg = 'Are you sure to reject selected advance payment ?';
                  break;
    }
    if(!confirm(alertMsg)){
        return false;
    }
     
    var formData = $('form#frmApprovalCreateAdvancePayment').serializeObject();  
    var addData = { 'key' : key };
    var dataString = JSON.stringify($.extend(formData,addData)); 
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {  
                //$('.application-form').empty().append(result.html)
                $('.application-form').empty().append(result.html);
                if(result.jsonData!=null && !isNaN(result.jsonData)){
                    if(parseInt(result.jsonData)>0){
                        $('#spanCount').text(result.jsonData);
                        $('#spanCount').show();
                    }else{
                        $('#spanCount').hide();
                    }
                }
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
                
                //find selected checkbox
                tbl.find('.select_adv_pay').each(function() {
                    if ($(this).prop('checked') == true) {
                        $(this).closest('tr').empty().remove();
                    }
                }); 
                $('#rapproved_or_rejected_date').val('');
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            fnCmnErrorMessage('An unknown technical error was encountered'); scrollToMessage(); stopLoading();
        }
    });
}

function searchPaymentCollection(eleObj, url){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');    
    var collect_by = tbl.find('select[name~="txt_collection_by"]');
    var start_date = tbl.find('input[name~="txt_startDate"]');
    var end_date = tbl.find('input[name~="txt_endDate"]');
//    if(collect_by.val().trim()=='' && start_date.val().trim()=='' && end_date.val().trim()==''){     
//       commonMessageAlert('Please filled out the field eihter Collection By or Start Date!');
//       fnCmnScrollToElementIDorClass('#wrapper');
//       return false;
//    } 
    
    if(start_date.val() != '' && end_date.val() != ''){
        if( (new Date(start_date.val()).getTime() > new Date(end_date.val()).getTime()))
        {
            commonMessageAlert('Start Date can not be greater than  End Date, please check !');
            fnCmnScrollToElementIDorClass('#wrapper');   
            start_date.focus();
            return false;
        }
    }
    if(start_date.val().trim()=='' && end_date.val() != ''){       
            commonMessageAlert('Start Date can not be blank !');
            fnCmnScrollToElementIDorClass('#wrapper');   
            start_date.focus();
            return false;
    }
    
    
    var formData = $('form#customerPaymentCollectionForm').serializeObject();      
    var dataString = JSON.stringify(formData); 
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {           
                $('#searchResult').empty().append(result.html);  
                paginationTbl();
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            fnCmnErrorMessage('An unknown technical error was encountered'); scrollToMessage(); stopLoading();
        }
    });
}
function fnFindingCashPaymentMode(paymentModeID){
    if(paymentModeID == ''){
        $('#payment_number').prop('readonly', false).removeClass('inputDisable_bg');
        $('.payment_no_necessary').hide();    
        $('#current_balance_field').hide();
        $('#balance').html('');
        $('#enter_account_id').empty().append('<option value="">--select--</option>');
       
        return false;
    }
    var isNeccessaryFieldKey = $('#keyToDetectCash' + paymentModeID).val();
    if(isNeccessaryFieldKey == 0){
        $('#payment_number').prop('readonly', true).addClass('inputDisable_bg').val('');
        $('.payment_no_necessary').hide();
        return true;
    }else{
        $('#payment_number').prop('readonly', false).removeClass('inputDisable_bg');
        $('.payment_no_necessary').show();
        return true;
    }
}

function loadAccountSource(keyValue, url){
    $('.messageDiv').hide();
    if(keyValue == ''){
        $('#current_balance_field').hide();
        $('#balance').html('');
        $('#enter_account_id').empty().append('<option value="">--select--</option>');
        return false;
    }
    var key = '';  
    if(keyValue == 1){
       key = 'cash'; 
    }else{
       key = 'bank'; 
    }
    $('#current_balance_field').hide();
    $('#balance').html('');
    startLoading();
     $.ajax({
        type: 'POST',
        url: url,
        data: { 'key': key},      
        dataType: 'json',
        success: function(result) {
            if (result.success) {  
               $('#enter_account_id').empty().append(result.html); 
               if(result.jsonData.key == 'cash'){
                    $('#current_balance_field').show();
                    $('#balance').html(result.jsonData.current_cash_bal);                            
                    if(result.jsonData.current_cash_bal <= 0){
                        $('#balance').css('color', 'red');
                    }                             
               }
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');           
            }
             stopLoading();
             return true;
        },
        error: function() {
            fnCmnErrorMessage(result.message);
            fnCmnScrollToElementIDorClass('#wrapper');  
        }
    });
}

function loadCurrentBankBalance(bankPkid, url){
    $('.messageDiv').hide();
    if(bankPkid == ''){
        $('#balance').html('');  
        $('.balance').val('');  
        $('#current_balance_field').hide(); 
        return false;
    }
    //$('#current_balance_field').hide();
    $('#balance').html('');
    startLoading();
     $.ajax({
        type: 'POST',
        url: url,
        data: { 'bankPkid': bankPkid},      
        dataType: 'json',
        success: function(result) {
            if (result.success) {  
                //$('#current_balance_field').show();
                $('#balance').html(result.jsonData.bank_current_balace);  
                $('.balance').val(result.jsonData.bank_current_balace);  
                if(result.jsonData.bank_current_balace > 0){
                    $('#balance').css('color', '#000');
                }else{
                    $('#balance').css('color', 'red');
                }
                $('#current_balance_field').show();
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');           
            }
             stopLoading();
        },
        error: function() {
            fnCmnErrorMessage(result.message);
            fnCmnScrollToElementIDorClass('#wrapper');  
        }
    });
}


function saveCusAdvancePayment(eleObj, url){
    $('.messageDiv').hide();
     var formData = $('form#frmCusAdvancePayment').serializeObject();  
     var tbl = $(eleObj).closest('table');
     var advance_amt = tbl.find('input[name=txt_advance_amount]');
     if(advance_amt.val().trim()==''){
        commonMessageAlert('Amount is mandatory!');
        fnCmnScrollToElementIDorClass('#wrapper');
        advance_amt.focus();
        return false;
     }
     
     var payment_date = tbl.find('input[name=txt_payment_date]');
     if(payment_date.val().trim()==''){
        commonMessageAlert('Payment Date is mandatory!');
        fnCmnScrollToElementIDorClass('#wrapper');
        payment_date.focus();
        return false;
     }
     
     var payment_mode = tbl.find('select[name=txt_payment_mode]');
     if(payment_mode.val().trim()==''){
        commonMessageAlert('please select Payment Mode !');
        fnCmnScrollToElementIDorClass('#wrapper');
        payment_mode.focus();
        return false;
     }
     var payment_no = tbl.find('input[name=txt_payment_number]');
     var check_payment_no = $('#keyToDetectCash' + payment_mode.val()).val();
     if(check_payment_no == 1){
        if(payment_no.val().trim()==''){
            commonMessageAlert('Payment No is mandatory!');
            fnCmnScrollToElementIDorClass('#wrapper');
            payment_no.focus();
            return false;
         }
     }
     var enter_account_id = tbl.find('select[name=txt_enter_account_id]');
     if(enter_account_id.val().trim()==''){
        commonMessageAlert('Account To Enter Advance Amount must be select !');
        fnCmnScrollToElementIDorClass('#wrapper');
        enter_account_id.focus();
        return false;
     }
     
     var description = tbl.find('textarea[name=txt_description]');
     if(description.val().trim()==''){
        commonMessageAlert('please give some description !');
        fnCmnScrollToElementIDorClass('#wrapper');
        description.focus();
        return false;
     }
 
     var addData = {'key' : $('#key').val()}; 
     var dataString = JSON.stringify($.extend(formData,addData));
     
     startLoading();
     $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#cus_advance_history').empty().append(result.html);
                //condition, if advance payment is edit form approved page and save then do this 
                if(result.jsonData.code == 0){
                    fnCmnWarningMessage(result.message);
                    fnCmnScrollToElementIDorClass('#wrapper');                 
                }else{
                    if(result.jsonData.save_from_approve_page !== ''){                    
                        $('#frmApprovalCreateAdvancePayment').empty().append(result.secondHtml);
                        paginationTbl(); //for pagination
                    }
                    paginationTbl2(); //for pagination                    
                    $('#EditArea').empty();
                    $('#PrintArea').empty().append(result.page);
                    $('#PrintArea').show();
                    fnCmnScrollToElementIDorClass('#PrintArea');
                    
                    //show pop up no of pending approval
                    if(parseInt(result.jsonData.apprCount)>0){
                        $('#spanCount').text(result.jsonData.apprCount);
                        $('#spanCount').show();
                    }else{
                        $('#spanCount').hide();
                    } 
                    fnCmnSuccessMessage(result.message);
                }             
                
//                $('.view_his_btn').hide();
//                $('#cus_advance_payment_id').val(result.jsonData.advPayID); //set advance payment id
                
               // fnCmnScrollToElementIDorClass('#wrapper'); 
                
                //for hide show buttons and diables fields              
//                tbl.find('input[type = text], input[type = date], select, textarea').each(function(){
//                     $(this).prop('disabled', true).addClass('inputDisable_bg');               
//                });
//                if($('#keyToDetectCash' + result.jsonData.paymentModeID).val() == 0){
//                    tbl.find('input[name = txt_payment_number]').prop('disabled', false).prop('readonly', true).addClass('inputDisable_bg');
//                }
//                
//                $('#btn_save').hide();
//                $('#btn_clear').hide();
//                $('#btn_edit').show();  
//                $('#btn_cancel').show(); 
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');           
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnErrorMessage('An unknown technical error was encountered'); 
            scrollToMessage(); 
            
        }
    });
}

function fnCloseEmptyElement(elementIDorClass){
    $('.messageDiv').hide();
    $(elementIDorClass).empty();
}


function fnShowAdvancePaymentHistory(url,type){
    $('.messageDiv').hide();
    var addData = {'key' : $('#key').val() };
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,   
        data: JSON.stringify(addData),
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#cus_advance_history').empty().append(result.html);
                $('.cus_advance_history_area').show();
                 paginationTbl2(); //for pagination 
                 if(type=='history'){
                    $('.view_his_btn').hide();
                    $('.view_bill').hide();                  
                 }else{
                    $('.view_his_btn').hide();
                    $('.view_bill').hide();
                 }
                 $('.close_his_btn').show();
                
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');           
            }
             stopLoading();
        },
        error: function() {
            fnCmnErrorMessage('An unknown technical error was encountered'); scrollToMessage(); stopLoading();
        }
    });
}

function fnCloseHistoy(divId,tblTdArea){
    $(divId).empty();
    $(tblTdArea).hide();
    $('.view_his_btn').show();
    $('.view_bill').show();
    $('.close_his_btn').hide();
    
    
}

function fnAdvancePaymentAction(advPayID, eleObj)
{    
    $('.messageDiv').hide();
    var selValue = $('#advPay' + advPayID).val();
    if(selValue==''){
        return;
    }
    var url=selValue.split('&')[0]; 
    var action=selValue.split('&')[1];
    if(action == 'edit'){
        var addData = { 'key' : 'E'};
    }else if(action == 'del'){
        var addData = { 'key' : 'D'};
    }else if(action == 'print'){
        var addData = { 'key' : 'print'};
    }    
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the advance payment record?'))
            return;
    }   
    startLoading();
    $.ajax({
           type: 'POST',
           url: url,   
           data:  JSON.stringify(addData),
           contentType: 'application/json',
           dataType: 'json',
           success: function(result) { 
               if(result.success){
                   switch(action){
                      case 'edit':  if(result.jsonData.key == 'E'){
                                        $('#customer_id').val(result.jsonData.cusID);
                                        $('#cus_advance_payment_id').val(result.jsonData.advancePaymentID);
                                        $('#advance_amount').val(result.jsonData.advanceAmount);
                                        $('#payment_date').val(result.jsonData.paymentDate);
                                        $('#paymentMode').val(result.jsonData.paymentModeID);
                                        $('#description').val(result.jsonData.description);
                                        if(result.jsonData.paymentNo !== 0){
                                            $('#payment_number').val(result.jsonData.paymentNo);
                                        }else{
                                             $('#payment_number').val('');
                                        }  
                                        $('#enter_account_id').empty().append(result.html);
                                        $('#enter_account_id').val(result.jsonData.enterAccountId);

                                        //for hide show buttons and diables fields              
                                        $('#advance_payment_tbl').find('input[type = text], input[type = date], select, textarea').each(function(){
                                             $(this).prop('disabled', false).removeClass('inputDisable_bg');               
                                        });
                                        if($('#keyToDetectCash' + result.jsonData.paymentModeID).val() == 0){
                                            $('#payment_number').prop('disabled', false).prop('readonly', true).addClass('inputDisable_bg').val('');
                                        }
                                        $('#for_cus_advance_payment_form').show();
                                        
                                        $('#btn_save').show();
                                        $('#btn_clear').hide();
                                        $('#btn_edit').hide(); 
                                        $('#btn_cancel').show(); 
                                    }
                                    stopLoading();
                                    break;
                      case  'del':  if(result.jsonData.key == 'D'){
                                        $(eleObj).closest('tr').empty().remove();
                                        fnCmnSuccessMessage(result.message);
                                        fnCmnScrollToElementIDorClass('#wrapper');  
                                        
                                        $('#advance_payment_tbl').find('input[type = text], input[type = date], select, textarea').each(function(){
                                             $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
                                        });
                                    }
                                    $('#payment_number').prop('readonly', false);
                                    $('#cus_advance_payment_id').val('');
                                    stopLoading();
                                    break;    
                      case 'print':             
                          //_edit_advance_payment
                                $('#PrintArea').empty().append(result.html);
                                stopLoading();
                                //fnCmnScrollToElementIDorClass('#PrintArea');
                                $('#divBlocker').show();
                                $('#PrintArea').show();
                        break;                
                                 
                   }
                    
                }
                else{
                    fnCmnWarningMessage(result.message);
                    scrollToMessage();  
                    stopLoading();
                }
                
           },
           error: function() {
                fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
                scrollToMessage();
                stopLoading();
           }
       });
}

function divPrint() {  
    $("#printHere").addClass("printable");
    window.print();
}

function fnCancelCusAdvancePaymentEdit(eleObj){ 
    $('#cus_advance_payment_id').val('');
    var tbl = $(eleObj).closest('table');
    //for hide show buttons and diables fields              
    tbl.find('input[type = text], input[type = date], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');                 
    }); 
    $('#payment_number').prop('readonly', false);
      
    $('#btn_save').show();
    $('#btn_clear').show();
    $('#btn_edit').hide(); 
    $('#btn_cancel').hide(); 
}

function editCusAdvancePayment(eleObj){
    var tbl = $(eleObj).closest('table');
    //for hide show buttons and diables fields              
    tbl.find('input[type = text], input[type = date], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg');                 
    });
    
    var selected_payment_mode_id = $('#paymentMode').val();
    if($('#keyToDetectCash' + selected_payment_mode_id).val() == 0){
        tbl.find('input[name = txt_payment_number]').prop('disabled', false).prop('readonly', true).addClass('inputDisable_bg');   
    }
    
    $('#btn_save').show();
    $('#btn_clear').hide();
    $('#btn_edit').hide(); 
    $('#btn_cancel').show(); 
}



function toggleIsPrimaryAdd(value){
    $('#inputisPrimaryAdd').val(value);
}
/*function FnViewCimAddress(selectId)
{
    $('.messageDiv').hide();
    if($('#'+selectId).val()==''){
        return;
    }
    var mode=$('#'+selectId).val().split('&')[1];
    if(mode=='del'){
        if(!confirm('Are you sure you want to delete this Address?'))
            return false;
    }
    startLoading();
    var url = $('#'+selectId).val().split('&')[0];
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success)
            {
                if(mode=='del'){
                    $('#newListAddress_GroupId').empty();
                    $('#newListAddress_GroupId').append(result.html).trigger('datePicker').focus();
                    $('#addNewAddress').empty();
                    fnCmnSuccessMessage(result.message);
                    scrollToMessage();
                    stopLoading();
                }
                else{
                    $('#addNewAddress').empty().append(result.html);  
                    stopLoading();
                }
            }
            else
            {
                fnCmnWarningMessage(result.message);
                scrollToMessage();
                stopLoading();
            }
        },
        error: function()
        {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}*/
function loadState() {
    var url = $('#urlLoadStateList').val();
     $('#selstate').html('');
     $('#selstate').html('<option value="">--select--</option>');
     $('#seldistrict').html('');
     $('#seldistrict').html('<option value="">--select--</option>');
     $('#selcity').html('');
     $('#selcity').html('<option value="">--select--</option>');
    var insertAttribute = {
        "countryId": $('#selcountry').val()
    };
    startLoading();
    var dataString = JSON.stringify(insertAttribute);
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(result) {
            if(result.success){
                $('#loadStateList').empty();
                $('#loadStateList').append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }

        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function loadDistrict() {
    $('.messageDiv').hide();
    var url = $('#urlLoadDistrictList').val();
    var insertAttribute = {
        "stateId": $('#selstate').val()
    };
    $('#seldistrict').html('');
    $('#seldistrict').html('<option value="">--select--</option>');
    $('#selcity').html('');
    $('#selcity').html('<option value="">--select--</option>');
    startLoading();
    var dataString = JSON.stringify(insertAttribute);
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(result) {
            if(result.success){
                $('#loadDistrictList').empty();
                $('#loadDistrictList').append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }

        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });

}
function loadCity() {
    $('.messageDiv').hide();
    var url = $('#urlLoadCityList').val();
    var insertAttribute = {
        "districtId": $('#seldistrict').val()
    };
    $('#selcity').html('');
    $('#selcity').html('<option value="">--select--</option>');
    startLoading();
    var dataString = JSON.stringify(insertAttribute);
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(result) {
            if(result.success){
                $('#tdCitylist').empty();
                $('#tdCitylist').append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
                stopLoading();
            }

        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });

}

function AddUpdateContactPerson(url, showId, hideId) {
    $('.messageDiv').hide();
    $primary = $("select[name~='selPrimaryContact']").val();
    if ($("#primaryContact").length) {
        if ($primary === '1') {
            var confirmer = confirm("Primary Contact Person Already Exist. Do You Want To Change?");
            if (confirmer === true) {
                cimSaveContactPersonInfos(url, showId, hideId);
            }
            else {
                $("select[name~='selPrimaryContact']").focus();
                return false;
            }
        } else {
            cimSaveContactPersonInfos(url, showId, hideId);
        }
    } else {
        cimSaveContactPersonInfos(url, showId, hideId);
    }
}
function DeleteContactPerson(url){
    $('.messageDiv').hide();
    if(!confirm('Are you sure to delete this Contact?')){
        return;
    }
    startLoading();
    /* convert the JSON object into string */
    var contactDetailForm = $('form#FormCustomerContact').serializeObject();
    var dataString = JSON.stringify(contactDetailForm);
    $('.messageDiv').hide();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(response) {
            if(response.jsonData=='AD'){
                    AccessDenied(response.html);
                    return;
                }
            if(response.success){
                fnCmnSuccessMessage(response.message);
                $("#newListContactDetails").empty().append(response.html);
                scrollToMessage();
                stopLoading();
            } else {
                fnCmnWarningMessage(response.message);
                scrollToMessage();
                stopLoading();
            }          
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function cimSaveContactPersonInfos(url, showId, hideId) {
    if ($('#contact_personName').val()=='') {
           fnCmnWarningMessage("Name cannot be empty!");
           scrollToMessage();
           $('#contact_personName').focus();
            return;   
    }
    if($('#txt_emailId').val()!='' && !isValidEmail($('#txt_emailId').val())){
        fnCmnWarningMessage("Please enter a valid Email id!");
        scrollToMessage();
        $('#txt_emailId').focus();        
        return;
    }
//    if ($('#phoneNo').val()!=''){
//        var phoneno= $('#phoneNo').val();
//        if(phoneno.length<7 || phoneno.length>11){    
//            fnCmnWarningMessage("Phone No. is invalid. Phone number must between 7-11 digit");
//            $('#contact_mobileNo').focus();
//            scrollToMessage();
//            return;
//        }
//    }
    if ($('#contact_mobileNo').val()=='') {
        fnCmnWarningMessage("Please enter a Mobile No.!");
        $('#contact_mobileNo').focus();
        scrollToMessage();
        return;
    }
    else {
        if (!isMobileNo($('#contact_mobileNo').val())) {
            fnCmnWarningMessage("Invalid Mobile No.!!");
            $('#contact_mobileNo').focus();
            scrollToMessage();
            return;
        }
    }
    if(hideId=='contactFormUpdate'){//if update
        if(!confirm('Confirm Update?')){
            return;
        }
    }
    startLoading();
    /* convert the JSON object into string */
    var contactDetailForm = $('form#FormCustomerContact').serializeObject();
    var dataString = JSON.stringify(contactDetailForm);
    $('.messageDiv').hide();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(response) {
            if(response.jsonData=='AD'){
                    AccessDenied(response.html);
                    return;
                }
            var isSuccess = response.success;
            var message = response.message;
            var rtnHtml = response.html;
            if (isSuccess) {
                $("#newListContactDetails").empty().append(rtnHtml).trigger('datePicker');
                cmnfnEmptyShow('divForSearchResultContact', 'tabSearchForContact', 'inpSearchParamValueContact', 'button_addContact');
                $('#' + showId).show();
                $('#' + hideId).hide();
                fnCmnSuccessMessage(message);
                scrollToMessage();
                stopLoading();

            } else {
                fnCmnWarningMessage(message);
                scrollToMessage();
                stopLoading();
            }            
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function searchCustForCom(url) {    
    var form = $('form#CustCommunicationForm').serializeObject();
    var dataString = JSON.stringify(form);   /* convert the JSON object into string */    
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        data: dataString, 
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#divcomcustSearchResult').empty().append(response.html);
                $('.messageDiv').hide();
                stopLoading();
                paginationTbl();                
            }
            else 
            {
                $('#divcomcustSearchResult').empty();                
                fnCmnWarningMessage(response.message);
                scrollToMessage();
                stopLoading();
            }
            $('#divcomCommunication').empty();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function toggleChildCheckComm(thisid){
    var mainChk=document.getElementById(thisid);
    var allChks=document.getElementsByClassName('selchkcomm');
    var txtSelected=document.getElementById('txtTotalSelected');
    for(var i=0;i<allChks.length;i++){
        allChks[i].checked=mainChk.checked;
    }
    if(mainChk.checked){
        txtSelected.value=allChks.length;
    }
    else{
        txtSelected.value=0;
    }
}
function toggleMainCheckComm(mainChkId,pkid){
    var mainChk=document.getElementById(mainChkId);
    var allChks=document.getElementsByClassName('selchkcomm');
    var allinput=document.getElementsByClassName('selinputcomm');
    var txtSelected=document.getElementById('txtTotalSelected');
    var isAllChecked=true;
    for(var i=0;i<allChks.length;i++){
        if(!allChks[i].checked){
            isAllChecked=false;
            break;
        }
    }
    mainChk.checked=isAllChecked;
    var counter=0;
    for(var i=0;i<allChks.length;i++){
        if(allChks[i].checked){
            //document.getElementById('inputisselected'+i).value='1';
            allinput[i].value='1';
            counter++;
        }
        else{
            //document.getElementById('inputisselected'+i).value='0';
            allinput[i].value='0';
        }
    }
    txtSelected.value=counter;
}
function Communicate(){
    $('.messageDiv').hide();
    if($("#selCommType").val().trim()===''){
        fnCmnWarningMessage('Please select a Communication type');
        scrollToMessage();
        return;
    }
    var totalSelected= parseInt(document.getElementById('txtTotalSelected').value);
    if(totalSelected<=0){
        fnCmnWarningMessage('You must select alteast one customer to communicate');
        scrollToMessage();
        return;
    }
    
    var url=$("#selCommType").val().split('&')[0];
    var comtype=$("#selCommType").val().split('&')[1];
    if(comtype=='email'){
        var emailArr=document.getElementsByClassName('inputsComEmail');
        var chkboxArr=document.getElementsByClassName('selchkcomm');
        for(var i=0;i<emailArr.length;i++){
            if(chkboxArr[i].checked && emailArr[i].value.trim()==''){
                fnCmnWarningMessage('Please unchecked the customer with no email id.');
                scrollToMessage();
                return;
            }
        }
    }
    startLoading();
    var frmdata=$('form#CustCommunicationForm').serializeObject();
    var dataString=JSON.stringify(frmdata);
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        data: dataString, 
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#divcomCommunication').empty().append(response.html);
                stopLoading();
            }
            else 
            {
                fnCmnWarningMessage(response.message);   
                $('#divcomCommunication').empty();
                scrollToMessage();
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function CommunicationHistory(selactionId){
    $('.messageDiv').hide();
    if($('#'+selactionId).val().trim()==''){
        return;
    }
    var url=$('#'+selactionId).val();
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#divcomCommunication').empty().append(response.html);
                lmsShowHideAddressResult('tdcomsearchcustresult');
                stopLoading();
            }
            else 
            {
                fnCmnWarningMessage(response.message);   
                $('#divcomCommunication').empty();
                scrollToMessage();
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function SendEmail(url){
    $('.messageDiv').hide();
    if($('#txtSubject').val().trim()==''){
        fnCmnWarningMessage('Please enter subject of the message.');
        $('#txtSubject').focus();
        scrollToMessage();
        return;
    }
    if($('#txtareaEmail').val().trim()===''){
        fnCmnWarningMessage('Please enter message body.');        
        $('#txtareaEmail').focus();
        scrollToMessage();
        return;
    }
    var fileArr=document.getElementsByClassName('attachment');
    var isSelected=true;
    var unselectedFile;
    if(fileArr!=null){
        for(var i=0;i<fileArr.length;i++){      
            if(fileArr[i].files[0]==null){
                isSelected=false;
                break;
            }
        }
        if(!isSelected){
            fnCmnWarningMessage('One or more Attachment not selected.');      
            scrollToMessage();
            return;
        }
    }
    if(!confirm('Confirm sending mail?')){
        return;
    }
    startLoading();
    var formData = new FormData($('#CustCommunicationForm')[0]);
    //var frmdata=$('form#CustCommunicationForm').serializeObject();
    //var dataString=JSON.stringify(frmdata);
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
//        type: 'POST', 
//        url: url, 
//        contentType: 'application/json', 
//        data: dataString, 
//        dataType: 'json',
        success: function(response) {
            if (response.success) {
                //$('#divcomCommunication').empty().append(response.html);                
                fnCmnSuccessMessage(response.message); 
                scrollToMessage();
                stopLoading();
            }
            else 
            {
                fnCmnWarningMessage(response.message);   
               // $('#divcomCommunication').empty();
                scrollToMessage();
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function SendSMS(url){
    $('.messageDiv').hide();
    if($('#txtSubject').val().trim()==''){
        fnCmnWarningMessage('Please enter subject of the message.');
        $('#txtSubject').focus();
        scrollToMessage();        
        return;
    }
    if($('#txtSmsMessage').val().trim()===''){
        fnCmnWarningMessage('Please enter message to be sent.');
        $('#txtSmsMessage').focus();
        scrollToMessage();        
        return;
    }
    startLoading();
    var frmdata=$('form#CustCommunicationForm').serializeObject();
    var dataString=JSON.stringify(frmdata);
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        data: dataString, 
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                //$('#divcomCommunication').empty().append(response.html);
                fnCmnSuccessMessage(response.message); 
                scrollToMessage();
                stopLoading();
            }
            else 
            {
                fnCmnWarningMessage(response.message);   
                //$('#divcomCommunication').empty();
                scrollToMessage();
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function CheckDeliveryStatus(selactionid,msgspanid){
    $('.messageDiv').hide();
    if($('#'+selactionid).val().trim()==''){       
        return;
    }
    var url=$('#'+selactionid).val();
    var span=$('#'+msgspanid);
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        dataType: 'json',
        success: function(response) {
            if (response.success) {   
                if(response.html=='0'){
                    span.text('Waiting for delivery');
                    span.style.color='#0000ff';                
                }
                else if(response.html=='1'){
                    span.text('Delivered');
                    span.style.color='#00ff00';
                }
                else if(response.html=='2'){
                    span.text('Not Sent');
                    span.style.color='#ff0000';
                }
                stopLoading();
            }
            else 
            {
                fnCmnWarningMessage(response.message);
                scrollToMessage();
            stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function AddAttachmentRow(){
    var trow='<tr><td><div style="margin:0; padding:2px; border:1px solid #ccc;">'+
                '<input type="file" class="attachment" name="attachemnt[]" style="width:200px;">'+        
                '<a href="javascript:void(0);" title="Remove Attachment" onclick="RemoveAttachmentRow(this);" style="color:#333; font-size: 13px;padding:5px; text-decoration: none;">x</a>'+
             '</div></td></tr>';
    $('#tbAttachment tr:last').after(trow);
    $('#btnAddAttach').val('Add More');
}
function RemoveAttachmentRow(element){     
    
//    if(rowcount>1){
        $(element).closest('tr').remove();
        var rowcount=$('#tbAttachment tr').length;
        if(rowcount<=1){
            $('#btnAddAttach').val('Add Attachment');
        }
//    }
}



