
function ClickOnChooseFile(elementID){
    $(elementID).click();
}
function loadDropDown(eleObj,url,appendid){
    $('.messageDiv').hide(); 
    switch(eleObj.id){
        case 'selcountry':
            $('#selstate').empty().append('<option value="" selected>--Select--</option>');
            $('#seldistrict').empty().append('<option value="" selected>--Select--</option>');
            $('#selcity').empty().append('<option value="" selected>--Select--</option>');          
            break;
        case 'selstate':
            $('#seldistrict').empty().append('<option value="" selected>--Select--</option>');
            $('#selcity').empty().append('<option value="" selected>--Select--</option>');
            break;
        case 'seldistrict':            
            $('#selcity').empty().append('<option value="" selected>--Select--</option>');
            break;
    }
    $.ajax({
        type: 'POST',
        url: url,
        data: {'load_list_key': $(eleObj).val()},
        dataType: 'json',        
        success: function (result) {
            if (result.success) {
                $('#' + appendid).empty().append(result.html);
            }
            else {
                fnCmnErrorMessage(result.message);
                scrollToMessage();
            }
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
            scrollToMessage();
        }
    });
}


/**********This javascript section is mainly for Saving store building Master Record Entry 
 twig file->(.html.twig,.html)********************/
function addUpdateCompanyMoblieMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var mobile_name = tbl.find('input[name~="mobile_name"]');
    if (mobile_name.val().trim()=='') {
        mobile_name.focus();
        commonMessageAlert('Mobile Number can not be empty!');
        return false;
    }
    $('.messageDiv').hide();
    var formData = $('form#frmCompanyMobile').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                paginationTbl(); //for pagination
                fnCmnSuccessMessage(result.message);//for hide show buttons and diables
                $('#frmCompanyMobile').trigger("reset");
                $('#btn_save').prop('value', 'Save');
                $('#btn_clear').hide();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function addUpdateCompanyEmailMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var Email_name = tbl.find('input[name~="Email_name"]');
    if (Email_name.val().trim()=='') {
        Email_name.focus();
        commonMessageAlert('Email can not be empty!');
        return false;
    }
    
    if($('#Email_name').val()!='' && !isValidEmail($('#Email_name').val())){
        fnCmnWarningMessage("Please enter a valid Email id!");
        scrollToMessage();
        $('#Email_name').focus();        
        return;
    }
    
    $('.messageDiv').hide();
    var formData = $('form#frmCompanyEmail').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                paginationTbl(); //for pagination
                fnCmnSuccessMessage(result.message);//for hide show buttons and diables
                $('#frmCompanyEmail').trigger("reset");
                $('#btn_save').prop('value', 'Save');
                $('#btn_clear').hide();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function addUpdateCompanyTelephoneMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var telephone_name = tbl.find('input[name~="telephone_name"]');
    if (telephone_name.val().trim()=='') {
        telephone_name.focus();
        commonMessageAlert('Telephone Number can not be empty!');
        return false;
    }
    $('.messageDiv').hide();
    var formData = $('form#frmCompanyTelephoneNo').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                paginationTbl(); //for pagination
                fnCmnSuccessMessage(result.message);//for hide show buttons and diables
                $('#frmCompanyTelephoneNo').trigger("reset");
                $('#btn_save').prop('value', 'Save');
                $('#btn_clear').hide();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function addUpdateCompanyFaxMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var fax_name = tbl.find('input[name~="fax_name"]');
    if (fax_name.val().trim()=='') {
        fax_name.focus();
        commonMessageAlert('Fax Number can not be empty!');
        return false;
    }
    $('.messageDiv').hide();
    var formData = $('form#frmCompanyFax').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                paginationTbl(); //for pagination
                fnCmnSuccessMessage(result.message);//for hide show buttons and diables
                $('#frmCompanyFax').trigger("reset");
                $('#btn_save').prop('value', 'Save');
                $('#btn_clear').hide();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function retrieveCompanyMobile(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#mobile_name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.mobile_name);
                $('#comMobileId').val(result.jsonData.comMobileId);
                //$('#jobTitleUpdateURL').val('/Tashi/web/app_dev.php/location/update_country/' + result.jsonData.cid);
                //for hide show buttons and disables                   
                $('#btn_save').prop('value', 'Update');
                $('#btn_clear').hide();
                //$('#btn_edit').hide();
                //$('#btn_update').show();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function retrieveCompanyEmail(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            
            if (result.success) {
                $('#Email_name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.Email_name);
                $('#comEmailId').val(result.jsonData.comEmailId);
                //$('#jobTitleUpdateURL').val('/Tashi/web/app_dev.php/location/update_country/' + result.jsonData.cid);
                //for hide show buttons and disables                   
                $('#btn_save').prop('value', 'Update');
                $('#btn_clear').hide();
                //$('#btn_edit').hide();
                //$('#btn_update').show();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function retrieveCompanyTelephone(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#telephone_name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.telephone_name);
                $('#comTeleId').val(result.jsonData.comTeleId);
                //$('#jobTitleUpdateURL').val('/Tashi/web/app_dev.php/location/update_country/' + result.jsonData.cid);
                //for hide show buttons and disables                   
                $('#btn_save').prop('value', 'Update');
                $('#btn_clear').hide();
                //$('#btn_edit').hide();
                //$('#btn_update').show();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function retrieveCompanyFax(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#fax_name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.Fax_name);
                $('#comFaxId').val(result.jsonData.comFaxId);
                //$('#jobTitleUpdateURL').val('/Tashi/web/app_dev.php/location/update_country/' + result.jsonData.cid);
                //for hide show buttons and disables                   
                $('#btn_save').prop('value', 'Update');
                $('#btn_clear').hide();
                //$('#btn_edit').hide();
                //$('#btn_update').show();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function deleteCompanyMobileModule(url, subModuleName, formId)
{
    $('.messageDiv').hide();
    if (!confirm('Are you sure want to delete the ' + subModuleName + '?'))
        return;
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $('#' + formId).trigger("reset");
                $('#display-list').empty().append(result.html);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}


function deleteCompanyEmailModule(url, subModuleName, formId)
{
    $('.messageDiv').hide();
    if (!confirm('Are you sure want to delete the ' + subModuleName + '?'))
        return;
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $('#' + formId).trigger("reset");
                $('#display-list').empty().append(result.html);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function deleteCompanyTelephoneModule(url, subModuleName, formId)
{
    $('.messageDiv').hide();
    if (!confirm('Are you sure want to delete the ' + subModuleName + '?'))
        return;
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $('#' + formId).trigger("reset");
                $('#display-list').empty().append(result.html);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function deleteCompanyFaxModule(url, subModuleName, formId)
{
    $('.messageDiv').hide();
    if (!confirm('Are you sure want to delete the ' + subModuleName + '?'))
        return;
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $('#' + formId).trigger("reset");
                $('#display-list').empty().append(result.html);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}


function saveCompanyMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var CompanyName = tbl.find('input[name~="CompanyName"]');
    var Registration_number = tbl.find('input[name~="Registration_number"]');
    var TelNo = tbl.find('input[name~="TelNo"]');
    var add1 = tbl.find('textarea[name~="address1"]');
    var zip = tbl.find('input[name~="zipcode"]');
    
    if (CompanyName.val().trim()=='') {
        CompanyName.focus();
        commonMessageAlert('Please Enter The Company Name !');
        return false;
    }
    if (Registration_number.val().trim()=='') {
        Registration_number.focus();
        commonMessageAlert('Please Enter The Register Number !');
        return false;
    }
//    if (TelNo.val().trim()=='') {
//        TelNo.focus();
//        commonMessageAlert('Please Enter The Telephone Number !');
//        return false;
//    }
    
    if(add1.val().trim()==''){
        add1.focus();
        commonMessageAlert('Address Field can\'t be empty !');
        return false;
        }
        if(tbl.find('select[name~="selcountry"]').val().trim()==''){
            commonMessageAlert('Please Select Country !');
            return false;
            } 
              if(tbl.find('select[name~="selstate"]').val().trim()==''){
        commonMessageAlert('Please Select State !');
        return false;
        }
//            if(tbl.find('select[name~="txt_district"]').val().trim()==''){
//            commonMessageAlert('Please Select District  !');
//            return false;
//        } 
//        if(tbl.find('select[name~="txt_city"]').val().trim()==''){
//            commonMessageAlert('Please Select city !');
//            return false;
//        }    
            if(zip.val().trim()==''){
            zip.focus();
            commonMessageAlert('Zip Code Field can\'t be empty !');
            return false;
        }
    $('.messageDiv').hide();
    var formData = new FormData($('#frmCompanyDetails')[0]); 
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                fnCmnSuccessMessage(result.message);
                scrollToMessage();
                stopLoading();
            }
            else {
                fnCmnWarningMessage(result.message);
                scrollToMessage();
                stopLoading();
            }
        },
        error: function () {
            fnCmnErrorMessage('An unknown technical error was encountered.');
            scrollToMessage();
            stopLoading();
        }
    });
}

