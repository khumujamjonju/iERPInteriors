/* 
 * Javascritp for location master
 */


/**********This javascript section is mainly for Saving Country Master Record Entry 
 twig file->(locationDetails.html.twig,displayCountry.html)********************/



function addCountryMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var country = tbl.find('input[name~="country"]');
    var Ccode = tbl.find('input[name~="countrycode"]');
    if (country.val().trim()=='') {
        country.focus();
        commonMessageAlert('Country Name Field can\'t be empty !');
        return false;
    }
//    if (Ccode.val().trim()=='') {
//        Ccode.focus();
//        commonMessageAlert('Country Code Field can\'t be empty !');
//        return false;
//    }

    $('.messageDiv').hide();
    var formData = $('form#frmCountryDetails').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
            if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                switch (result.jsonData.codeFlag) {
                    case 0 :
                        $('#display-list').empty().append(result.html);
                        paginationTbl(); //for pagination
                        fnCmnSuccessMessage(result.message);//for hide show buttons and diables
                        $('#txt_country').val('');
                        $('#txt_country_code').val('');
//                        $('#txt_country').prop('disabled', true).addClass('disable_bg');
//                        $('#txt_country_code').prop('disabled', true).addClass('disable_bg');
//                        $('#btn_save').hide();
//                        $('#btn_clear').hide();
//                        $('#btn_edit').show();
//                        $('#btn_cancel').show();
                        break;
                    case 1 :
                        fnCmnWarningMessage(result.message);
                        break;

                }
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            alert('Error in Class file or Controller:');
        }
    });
}


function updateCountryMaster(elementObj)
{
    var tbl = $(elementObj).closest('table');
    var country = tbl.find('input[name~="country"]');
//    var Ccode = tbl.find('input[name~="countrycode"]');
    if (country.val().trim()=='') {
        country.focus();
        commonMessageAlert('Country Name Field can\'t be empty !');
        return false;
    }
//    if (Ccode.val().trim()=='') {
//        Ccode.focus();
//        commonMessageAlert('Country Code Field can\'t be empty !');
//        return false;
//    }
    $('.messageDiv').hide();

    var formData = $('form#frmCountryDetails').serializeObject();
    var dataString = JSON.stringify(formData);
    var url = $('#locationUpdateURL').val();
    //alert(url);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
            if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                switch (result.jsonData.codeFlag) {
                    case 0 :
                        $('#display-list').empty().append(result.html);
                        paginationTbl(); //for pagination
                        fnCmnSuccessMessage(result.message);
                        break;
                    case 1 :
                        fnCmnWarningMessage(result.message);
                        break;
                }

                //for hide show buttons and diables
                $('#txt_country').prop('disabled', true).addClass('disable_bg');
                $('#txt_country_code').prop('disabled', true).addClass('disable_bg');
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_update').hide();
                $('#btn_cancel').show();
            }
            else
            {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            alert('Error in Class file or Controller:');
        }
    });
}



function retriveCountryMaster(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function (result) {
            if (result.success) {
                $('#txt_country').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.countryname);
                $('#txt_country_code').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.countrycode);
                $('#inputcid').val(result.jsonData.cid);
                // $('#locationUpdateURL').val('/Tashi/web/app_dev.php/location/update_country/' + result.jsonData.cid);
                //for hide show buttons and diables                   
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').hide();
                $('#btn_update').show();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            alert('Error in Class file or Controller:');
        }
    });
}

function deleteCountryMaster(url)
{
    $('.messageDiv').hide();
//    var formData = $('form#frmCountryDetails').serializeObject();
//    var dataString = JSON.stringify(formData);
    //var url=$('#locationUpdateURL').val();
    if (!confirm('Are you sure you want to delete the selected country?'))
        return;
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        //data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
            if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                fnCmnSuccessMessage(result.message);
                paginationTbl(); //for pagination

                //for hide show buttons and diables
                $('#txt_country').prop('disabled', false).removeClass('disable_bg').val('');
                $('#txt_country_code').prop('disabled', false).removeClass('disable_bg').val('');
                $('#btn_save').show();
                $('#btn_clear').show();
                $('#btn_edit').hide();
                $('#btn_update').hide();
                $('#btn_cancel').hide();


            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            alert('Error in Class file or Controller:');
        }
    });
}



/**********This javascript section is mainly for Saving State Master Record Entry 
 twig file->(locationDetails.html.twig,displayState.html)********************/



function saveStateMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var state = tbl.find('input[name~="state"]');
//    var Scode = tbl.find('input[name~="statecode"]');
    if (tbl.find('select[name~="country"]').val().trim()=='') {
        commonMessageAlert('Please Select country !');
        return false;
    }
    if (state.val().trim()=='') {
        state.focus();
        commonMessageAlert('State Name Field can\'t be empty !');
        return false;
    }
//    if (Scode.val().trim()=='') {
//        Scode.focus();
//        commonMessageAlert('State Code Field can\'t be empty !');
//        return false;
//    }
    $('.messageDiv').hide();
    var formData = $('form#frmStateDetails').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
            if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                switch (result.jsonData.codeFlag) {
                    case 0 :
                        $('#display-list').empty().append(result.html);
                        paginationTbl(); //for pagination
                        fnCmnSuccessMessage(result.message);
                        //for hide show buttons and diables
                        $('#country').val('');
                        $('#statename').val('');
                        $('#statecode').val('');
//                        $('#country').prop('disabled', true).addClass('disable_bg');
//                        $('#statename').prop('disabled', true).addClass('disable_bg');
//                        $('#statecode').prop('disabled', true).addClass('disable_bg');
//                        $('#btn_save').hide();
//                        $('#btn_clear').hide();
//                        $('#btn_edit').show();
//                        $('#btn_cancel').show();
                        break;
                    case 1 :
                        fnCmnWarningMessage(result.message);
                        break;

                }
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            alert('Error in Class file or Controller:');
        }
    });
}
//            if (result.success) {
//                switch (result.jsonData.codeFlag) {
//                    case 0 :
//                        $('#display-list').empty().append(result.html);
//                        paginationTbl(); //for pagination
//                        fnCmnSuccessMessage(result.message);
//                        break;
//                    case 1 :
//                        fnCmnWarningMessage(result.message);
//                        break;
//
//                }
//                //for hide show buttons and diables
//                $('#country').prop('disabled', true).addClass('disable_bg');
//                $('#statename').prop('disabled', true).addClass('disable_bg');
//                $('#statecode').prop('disabled', true).addClass('disable_bg');
//                $('#btn_save').hide();
//                $('#btn_clear').hide();
//                $('#btn_edit').show();
//                $('#btn_cancel').show();
//            }
//            else {
//                fnCmnErrorMessage(result.message);
//            }
//            stopLoading();
//        },
//        error: function() {
//            alert('Error in Class file or Controller:');
//        }
//    });
//}


function updateStateMaster(elementObj) {
    var tbl = $(elementObj).closest('table');
    var state = tbl.find('input[name~="state"]');
    var Scode = tbl.find('input[name~="statecode"]');
    if (tbl.find('select[name~="country"]').val().trim()=='') {
        commonMessageAlert('Please Select country !');
        return false;
    }
    if (state.val().trim()=='') {
        state.focus();
        commonMessageAlert('State Name Field can\'t be empty !');
        return false;
    }
//    if (Scode.val().trim()=='') {
//        Scode.focus();
//        commonMessageAlert('State Code Field can\'t be empty !');
//        return false;
//    }
    $('.messageDiv').hide();

    var formData = $('form#frmStateDetails').serializeObject();
    var dataString = JSON.stringify(formData);
    var url = $('#stateUpdateURL').val();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
            if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                switch (result.jsonData.codeFlag) {
                    case 0 :
                        $('#display-list').empty().append(result.html);
                        paginationTbl(); //for pagination
                        fnCmnSuccessMessage(result.message);
                        break;
                    case 1 :
                        fnCmnWarningMessage(result.message);
                        break;
                }

                //for hide show buttons and diables
                $('#country').prop('disabled', true).addClass('disable_bg');
                $('#statename').prop('disabled', true).addClass('disable_bg');
                $('#statecode').prop('disabled', true).addClass('disable_bg');
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_update').hide();


            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            alert('Error in Class file or Controller:');
        }
    });
}



function retriveStateMaster(url)
{

    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function (result) {
            if (result.success) {
                $('#country').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.countryId);
                $('#statename').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.statename);
                $('#statecode').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.statecode);
                $('#inputsid').val(result.jsonData.sid);
                //$('#ddlb_country').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.country);
//                $('#stateUpdateURL').val('/Tashi/web/app_dev.php/location/update_state/' + result.jsonData.sid);
                //for hide show buttons and diables                   
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').hide();
                $('#btn_update').show();
                $('#btn_cancel').show();
                stopLoading();
            }
            else {
                fnCmnErrorMessage(result.message);
                stopLoading();
            }
            
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function deleteStateMaster(url)
{
    $('.messageDiv').hide();
//    var formData = $('form#frmCountryDetails').serializeObject();
//    var dataString = JSON.stringify(formData);
    //var url=$('#locationUpdateURL').val();
    if (!confirm('Are you sure want to delete the selected State?'))
        return;
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        //data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
            if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                fnCmnSuccessMessage(result.message);
                paginationTbl(); //for pagination

                //for hide show buttons and diables
                $('#country').prop('disabled', false).removeClass('disable_bg').val('');
                $('#statename').prop('disabled', false).removeClass('disable_bg').val('');
                $('#statecode').prop('disabled', false).removeClass('disable_bg').val('');
                $('#btn_save').show();
                $('#btn_clear').show();
                $('#btn_edit').hide();
                $('#btn_update').hide();
                $('#btn_cancel').hide();
                stopLoading();

            }
            else {
                stopLoading();
                fnCmnErrorMessage(result.message);
                scrollToMessage();
            }
            
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}




/**********This javascript section is mainly for Saving District Master Record Entry 
 twig file->(locationDistrict.html.twig,displayDistrict.html)********************/



function addDistrictMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var district = tbl.find('input[name~="districts"]');
    //var Dcode = tbl.find('input[name~="districtcode"]');
    if (tbl.find('select[name~="txt_country"]').val().trim()=='') {
        commonMessageAlert('Please Select country !');
        return false;
    }
    if (tbl.find('select[name~="txt_state"]').val().trim()=='') {
        commonMessageAlert('Please Select State');
        return false;
    }
    if (district.val().trim()=='') {
        district.focus();
        commonMessageAlert('District Name Field can\'t be empty !');
        return false;
    }
//    if (Dcode.val().trim()=='') {
//        Dcode.focus();
//        commonMessageAlert('District Code Field can\'t be empty !');
//        return false;
//    }
    $('.messageDiv').hide();
    var formData = $('form#frmDistrictDetails').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                switch (result.jsonData.codeFlag) {
                    case 0 :
                        $('#display-list').empty().append(result.html);
                        paginationTbl(); //for pagination
                        fnCmnSuccessMessage(result.message);
                        //for hide show buttons and diables
                        $('#country').val('');
                        $('#states').val('');
                        $('#txt_district').val('');
                        $('#txt_district_code').val('');
//                        $('#country').prop('disabled', true).addClass('disable_bg');
//                        $('#states').prop('disabled', true).addClass('disable_bg');
//                        $('#txt_district').prop('disabled', true).addClass('disable_bg');
//                        $('#txt_district_code').prop('disabled', true).addClass('disable_bg');
//                        $('#btn_save').hide();
//                        $('#btn_clear').hide();
//                        $('#btn_edit').show();
//                        $('#btn_cancel').show();
                        break;
                    case 1 :
                        fnCmnWarningMessage(result.message);
                        break;

                }
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function updateDistrictMaster(elementObj)
{
    var tbl = $(elementObj).closest('table');
    var district = tbl.find('input[name~="districts"]');
    //var Dcode = tbl.find('input[name~="districtcode"]');
    if (tbl.find('select[name~="txt_country"]').val().trim()=='') {
        commonMessageAlert('Please Select Country !');
        return false;
    }
    if (tbl.find('select[name~="txt_state"]').val().trim()=='') {
        commonMessageAlert('Please Select State');
        return false;
    }
    if (district.val().trim()=='') {
        district.focus();
        commonMessageAlert('District Name Field can\'t be empty !');
        return false;
    }
//    if (Dcode.val().trim()=='') {
//        Dcode.focus();
//        commonMessageAlert('District Code Field can\'t be empty !');
//        return false;
//    }

    $('.messageDiv').hide();
    var formData = $('form#frmDistrictDetails').serializeObject();
    var dataString = JSON.stringify(formData);
    var url = $('#districtUpdateURL').val();
//    alert(url);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                switch (result.jsonData.codeFlag) {
                    case 0 :
                        $('#display-list').empty().append(result.html);
                        paginationTbl(); //for pagination
                        fnCmnSuccessMessage(result.message);
                        break;
                    case 1 :
                        fnCmnWarningMessage(result.message);
                        break;
                }

                //for hide show buttons and diables
                $('#country').prop('disabled', true).addClass('disable_bg');
                $('#states').prop('disabled', true).addClass('disable_bg');
                $('#txt_district').prop('disabled', true).addClass('disable_bg');
                $('#txt_district_code').prop('disabled', true).addClass('disable_bg');
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_update').hide();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}


function retriveDistrictMaster(url)
{

    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function (result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                $('#country').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.countryId);
                var stateIdArr = result.jsonData.stateIdArr;
                var stateNameArr = result.jsonData.stateNameArr;
                var stateSelectBox = document.getElementById('states');
                stateSelectBox.options.length = 0;
                stateSelectBox.options[stateSelectBox.options.length] = new Option('--Select--', '');
                for (var i = 0; i < stateIdArr.length; i++) {
                    stateSelectBox.options[stateSelectBox.options.length] = new Option(stateNameArr[i], stateIdArr[i]);
                }
                $('#states').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.stateId);
                $('#txt_district').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.districtname);
                $('#txt_district_code').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.districtcode);
                $('#inputdid').val(result.jsonData.did);
                //$('#ddlb_country').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.country);
                //$('#districtUpdateURL').val('/Tashi/web/app_dev.php/location/update_district/' + result.jsonData.id);
                //for hide show buttons and diables                   
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').hide();
                $('#btn_update').show();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function deleteDistrictMaster(url)
{
    $('.messageDiv').hide();
//    var formData = $('form#frmCountryDetails').serializeObject();
//    var dataString = JSON.stringify(formData);
    //var url=$('#locationUpdateURL').val();
    if (!confirm('Are you sure want to delete the selected District?'))
        return;
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        //data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
            if (result.success) {
                $('#display-list').empty().append(result.html);
                fnCmnSuccessMessage(result.message);
                paginationTbl(); //for pagination

                //for hide show buttons and diables
                $('#country').prop('disabled', false).removeClass('disable_bg').val('');
                $('#states').prop('disabled', false).removeClass('disable_bg').val('');
                $('#txt_district').prop('disabled', false).removeClass('disable_bg').val('');
                $('#txt_district_code').prop('disabled', false).removeClass('disable_bg').val('');
                $('#btn_save').show();
                $('#btn_clear').show();
                $('#btn_edit').hide();
                $('#btn_update').hide();
                $('#btn_cancel').hide();


            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

/*************District Javascript Sections ends here****************/


/**********This javascript section is mainly for Saving City Master Record Entry 
 twig file->(locationCity.html.twig,displayCity.html)********************/



function addCityMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var city = tbl.find('input[name~="city_name"]');
    if (tbl.find('select[name~="txt_country"]').val().trim()=='') {
        commonMessageAlert('Please Select Country !');
        return false;
    }
    if (tbl.find('select[name~="txt_state"]').val().trim()=='') {
        commonMessageAlert('Please Select State !');
        return false;
    }
    if (tbl.find('select[name~="txt_district"]').val().trim()=='') {
        commonMessageAlert('Please Select District !');
        return false;
    }
    if (city.val().trim()=='') {
        city.focus();
        commonMessageAlert('City Name Field can\'t be empty !');
        return false;
    }
//    if (Citycode.val().trim()=='') {
//        Citycode.focus();
//        commonMessageAlert('City Code Field can\'t be empty !');
//        return false;
//    }
    $('.messageDiv').hide();
    var formData = $('form#frmCityDetails').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                switch (result.jsonData.codeFlag) {
                    case 0 :
                        $('#display-list').empty().append(result.html);
                        paginationTbl(); //for pagination
                        fnCmnSuccessMessage(result.message);
                        //for hide show buttons and diables
                        $('#country').val('');
                        $('#states').val('');
                        $('#districts').val('');
                        $('#cityname').val('');
                        $('#citycode').val('');
//                        $('#btn_save').hide();
//                        $('#btn_clear').hide();
//                        $('#btn_edit').show();
//                        $('#btn_cancel').show();
                        break;
                    case 1 :
                        fnCmnWarningMessage(result.message);
                        break;
                }
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}



function updateCityMaster(elementObj)
{
    var tbl = $(elementObj).closest('table');
    var city = tbl.find('input[name~="city_name"]');
    var Citycode = tbl.find('input[name~="citycode"]');
    if (tbl.find('select[name~="txt_country"]').val().trim()=='') {
        commonMessageAlert('Please Select Country !');
        return false;
    }
    if (tbl.find('select[name~="txt_state"]').val().trim()=='') {
        commonMessageAlert('Please Select State !');
        return false;
    }
    if (tbl.find('select[name~="txt_district"]').val().trim()=='') {
        commonMessageAlert('Please Select District !');
        return false;
    }
    if (city.val().trim()=='') {
        city.focus();
        commonMessageAlert('City Name can\'t be empty !');
        return false;
    }
//    if (Citycode.val().trim()=='') {
//        Citycode.focus();
//        commonMessageAlert('City Code Field can\'t be empty !');
//        return false;
//    }
    $('.messageDiv').hide();
    var formData = $('form#frmCityDetails').serializeObject();
    var dataString = JSON.stringify(formData);
    var url = $('#cityUpdateURL').val();
//    alert(url);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                        paginationTbl(); //for pagination
                        fnCmnSuccessMessage(result.message);
//                switch (result.ag) {
//                    case 0 :
//                        $('#display-list').empty().append(result.html);
//                        paginationTbl(); //for pagination
//                        fnCmnSuccessMessage(result.message);
//                        break;
//                    case 1 :
//                        fnCmnWarningMessage(result.message);
//                        break;
//                }
                //for hide show buttons and diables
                $('#country').prop('disabled', true).addClass('disable_bg');
                $('#states').prop('disabled', true).addClass('disable_bg');
                $('#districts').prop('disabled', true).addClass('disable_bg');
                $('#cityname').prop('disabled', true).addClass('disable_bg');
                $('#citycode').prop('disabled', true).addClass('disable_bg');
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_update').hide();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}


function retriveCityMaster(url)
{

    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function (result) {
            if (result.success) {
                $('#country').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.countryId);
                var stateIdArr = result.jsonData.stateIdArr;
                var stateNameArr = result.jsonData.stateNameArr;
                var stateSelectBox = document.getElementById('states');
                stateSelectBox.options.length = 0;
                stateSelectBox.options[stateSelectBox.options.length] = new Option('--Select--', '');
                for (var i = 0; i < stateIdArr.length; i++) {
                    stateSelectBox.options[stateSelectBox.options.length] = new Option(stateNameArr[i], stateIdArr[i]);
                }
                $('#states').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.stateId);

                var districtIdArr = result.jsonData.districtIdArr;
                var districtNameArr = result.jsonData.districtNameArr;
                var districtSelectBox = document.getElementById('districts');
                districtSelectBox.options.length = 0;
                districtSelectBox.options[districtSelectBox.options.length] = new Option('--Select--', '');
                for (var i = 0; i < districtIdArr.length; i++) {
                    districtSelectBox.options[districtSelectBox.options.length] = new Option(districtNameArr[i], districtIdArr[i]);
                }
                $('#districts').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.districtId);
                $('#cityname').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.cityname);
                $('#citycode').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.citycode);
                $('#inputcid').val(result.jsonData.cid);
                //$('#ddlb_country').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.country);
                //$('#cityUpdateURL').val('/Tashi/web/app_dev.php/location/update_city/' + result.jsonData.id);
                //for hide show buttons and diables                   
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').hide();
                $('#btn_update').show();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function deletecityMaster(url)
{
    $('.messageDiv').hide();
//    var formData = $('form#frmCountryDetails').serializeObject();
//    var dataString = JSON.stringify(formData);
    //var url=$('#locationUpdateURL').val();
    if (!confirm('Are you sure want to delete the selected City?'))
        return;
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        //data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                fnCmnSuccessMessage(result.message);
                paginationTbl(); //for pagination

                //for hide show buttons and diables
                $('#country').prop('disabled', false).removeClass('disable_bg').val('');
                $('#states').prop('disabled', false).removeClass('disable_bg').val('');
                $('#districts').prop('disabled', false).removeClass('disable_bg').val('');
                $('#cityname').prop('disabled', false).removeClass('disable_bg').val('');
                $('#citycode').prop('disabled', false).removeClass('disable_bg').val('');
                $('#btn_save').show();
                $('#btn_clear').show();
                $('#btn_edit').hide();
                $('#btn_update').hide();
                $('#btn_cancel').hide();


            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}



/**********This javascript section is mainly for Saving City Master Record Entry 
 twig file->(locationCity.html.twig,displayCity.html)********************/

function addAddressTypeMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    if (tbl.find('input[name~="addressType"]').val().trim()=='') {
        commonMessageAlert('Address Type Field can\'t be null !');
        return false;
    }
//    if (tbl.find('input[name~="addressTypeCode"]').val().trim()=='') {
//        commonMessageAlert('Address Type Code Field can\'t be null !');
//        return false;
//    }

    $('.messageDiv').hide();
    var formData = $('form#frmAddressTypeDetails').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                switch (result.jsonData.codeFlag) {
                    case 0 :
                        $('#display-list').empty().append(result.html);
                        paginationTbl(); //for pagination
                        fnCmnSuccessMessage(result.message);
                        break;
                    case 1 :
                        fnCmnWarningMessage(result.message);
                        break;
                }

                //for hide show buttons and diables
                $('#txt_addresstype').val('');
                $('#txt_addresstypeCode').val('');
//                $('#btn_save').hide();
//                $('#btn_clear').hide();
//                $('#btn_edit').show();
//                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}


function updateAddressTypeMaster(elementObj) {

    var tbl = $(elementObj).closest('table');

    if (tbl.find('input[name~="addressType"]').val().trim()=='') {
        commonMessageAlert('Address Type Field can\'t be null !');
        return false;
    }
//    if (tbl.find('input[name~="addressTypeCode"]').val().trim()=='') {
//        commonMessageAlert('Address Type Code Field can\'t be null !');
//        return false;
//    }



    $('.messageDiv').hide();


    var formData = $('form#frmAddressTypeDetails').serializeObject();
    var dataString = JSON.stringify(formData);
    var url = $('#locationUpdateAddTypeURL').val();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                switch (result.jsonData.codeFlag) {
                    case 0 :
                        $('#display-list').empty().append(result.html);
                        paginationTbl(); //for pagination
                        fnCmnSuccessMessage(result.message);
                        break;
                    case 1 :
                        fnCmnWarningMessage(result.message);
                        break;
                }

                //for hide show buttons and diables
                $('#txt_addresstype').prop('disabled', true).addClass('disable_bg');
                $('#txt_addresstypeCode').prop('disabled', true).addClass('disable_bg');
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_update').hide();


            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function retriveAddressTypeMaster(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function (result) {
            
            if (result.success) {
                $('#txt_addresstype').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.addressTypeName);
                $('#txt_addresstypeCode').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.addressTypeCode);
                $('#inputcid').val(result.jsonData.aTid);
//                $('#locationUpdateAddTypeURL').val('/Tashi/web/app_dev.php/location/update_address_type/' + result.jsonData.aTid);
                //for hide show buttons and diables                   
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').hide();
                $('#btn_update').show();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function deleteAddressTypeMaster(url)
{
    $('.messageDiv').hide();
//    var formData = $('form#frmCountryDetails').serializeObject();
//    var dataString = JSON.stringify(formData);
    //var url=$('#locationUpdateURL').val();
    if (!confirm('Are you sure want to delete the selected Address Type?'))
        return;
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        //data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function (result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                fnCmnSuccessMessage(result.message);
                paginationTbl(); //for pagination

                //for hide show buttons and diables
                $('#txt_addresstype').prop('disabled', false).removeClass('disable_bg').val('');
                $('#txt_addresstypeCode').prop('disabled', false).removeClass('disable_bg').val('');
                $('#btn_save').show();
                $('#btn_clear').show();
                $('#btn_edit').hide();
                $('#btn_update').hide();
                $('#btn_cancel').hide();


            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}


function cmnsLoadLocationList(eleObj, url, appendEleID) {
    $('.messageDiv').hide();
    $.ajax({
        type: 'POST',
        url: url,
        data: {'load_list_key': $(eleObj).val()},
        dataType: 'json',
        success: function (result) {
            if (result.success) {
                $('#' + appendEleID).empty().append(result.html);
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
        },
        error: function () {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

//show button and enable input fields on click edit button
function locEditBtn(txt_country, txt_country_code, country, statename, statecode, states, txt_district, txt_district_code, locstate, locdistrict, cityname,
        citycode, txt_addresstype, txt_addresstypeCode) {
    $('#btn_update').show();
    $('#btn_clear').hide();
    $('#btn_edit').hide();

    //country
    $('#' + txt_country).prop('disabled', false).removeClass('disable_bg');
    $('#' + txt_country_code).prop('disabled', false).removeClass('disable_bg');
    //state
    $('#' + country).prop('disabled', false).removeClass('disable_bg');
    $('#' + statename).prop('disabled', false).removeClass('disable_bg');
    $('#' + statecode).prop('disabled', false).removeClass('disable_bg');
    //district
    $('#' + states).prop('disabled', false).removeClass('disable_bg');
    $('#' + txt_district).prop('disabled', false).removeClass('disable_bg');
    $('#' + txt_district_code).prop('disabled', false).removeClass('disable_bg');
    //city
    $('#' + locstate).prop('disabled', false).removeClass('disable_bg');
    $('#' + locdistrict).prop('disabled', false).removeClass('disable_bg');
    $('#' + cityname).prop('disabled', false).removeClass('disable_bg');
    $('#' + citycode).prop('disabled', false).removeClass('disable_bg');
    $('#' + txt_addresstype).prop('disabled', false).removeClass('disable_bg');
    $('#' + txt_addresstypeCode).prop('disabled', false).removeClass('disable_bg');
}




/*************address Javascript Sections ends here****************/

