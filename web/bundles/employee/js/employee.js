function  loadEmpDetails(url, IDorClassName, key) {

    $('.messageDiv').hide();
    var empID;
    if ($('#empID').val().trim()=='') {
        empID = '';
    } else {
        empID = $('#empID').val();
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: {'loadID': empID, 'key': key},
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $(IDorClassName).empty().append(result.html);
                if (result.jsonData !== 0) {
                    $('#profile-view').prop('src', '/TASHI/web/' + result.jsonData.profile_pic);
                    $('#empID').val(result.jsonData.empID);
                    $('#display_txt_employeeID').html('Employee ID : ' + result.jsonData.assignEmpID + ' , ' + result.jsonData.person_name);
                    $('#employee_id').val(result.jsonData.assignEmpID);
                    $('#emp_firstname').val(result.jsonData.first_name);
                    $('#emp_middlename').val(result.jsonData.middle_name);
                    $('#emp_lastname').val(result.jsonData.last_name);
                    $('#emp_dob').val(result.jsonData.dob); 
                    $('#father_name').val(result.jsonData.father_name);
                    $('#emp_nation').val(result.jsonData.nationality);
                    $('#emp_religion').val(result.jsonData.religion);
                    if (result.jsonData.gender == 'M') {
                        $('#emp_gender_male').prop('checked', true);
                    }
                    if (result.jsonData.gender == 'F') {
                        $('#emp_gender_female').prop('checked', true);
                    }
                    if (result.jsonData.marital == 'M') {
                        $('#emp_married').prop('checked', true);
                    }
                    if (result.jsonData.marital == 'U') {
                        $('#emp_unmarried').prop('checked', true);
                    }

                    $('#emp_personal_tbl').find('input[type = text], input[type = date], input[type = file], input[type = radio], select').each(function() {
                        $(this).prop('disabled', true).addClass('inputDisable_bg');
                    });

                    $('#btn_save').hide();
                    $('#btn_clear').hide();
                    $('#btn_update').hide();
                    $('#btn_edit').show();
                    $('#btn_cancel').show();

                } else {
                    //adding pointer event null to empployee tabs
                  //  $('#job_details, #address_details, #contact_details, #bank_details, #dependant_details').addClass('removeMousePointer');
                }

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}


//----------------------delete portions-----------------//

function deleteEmpSubModule(url, subModuleName, formId)
{
    $('.messageDiv').hide();
    if (!confirm('Are you sure you want to delete the ' + subModuleName + '?'))
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}


function deleteEmpReligionModule(url, subModuleName, formId)
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function deleteEmpNationalityModule(url, subModuleName, formId)
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function deleteEmpJobProfileMaster(url)
{
    $('.messageDiv').hide();
    if (!confirm('Are you sure you want to delete Job Profile?'))
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
                $('#frmEmpJobProfile').trigger("reset");
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function deleteEmpWorkingTypeMaster(url)
{

    $('.messageDiv').hide();
    if (!confirm('Are you sure you want to delete the selected Asset Category?'))
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function deleteEmpEmployeeTypeMaster(url)
{

    $('.messageDiv').hide();
    if (!confirm('Are you sure you want to delete Employee Type?'))
        return;
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}
//---------------- delete portions ends----------------------------//
function addUpdateJobTitleMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var job_title_name = tbl.find('input[name~="job_title_name"]');
    if (job_title_name.val().trim()=='') {
        job_title_name.focus();
        commonMessageAlert('Designation Name can not be empty!');
        return false;
    }
    $('.messageDiv').hide();
    var formData = $('form#frmEmpJobTitle').serializeObject();
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
//                $('#job_title_name').prop('disabled', true).addClass('disable_bg');
//                $('#job_title_des').prop('disabled', true).addClass('disable_bg');
                $('#frmEmpJobTitle').trigger("reset");
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function addUpdateReligionMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var religion_name = tbl.find('input[name~="religion_name"]');
    if (religion_name.val().trim()=='') {
        religion_name.focus();
        commonMessageAlert('Religion Name can not be empty!');
        return false;
    }
    $('.messageDiv').hide();
    var formData = $('form#frmEmpReligion').serializeObject();
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
//                $('#job_title_name').prop('disabled', true).addClass('disable_bg');
//                $('#job_title_des').prop('disabled', true).addClass('disable_bg');
                $('#frmEmpReligion').trigger("reset");
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function addUpdateNationalityMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var nationality_name = tbl.find('input[name~="nationality_name"]');
    if (nationality_name.val().trim()=='') {
        nationality_name.focus();
        commonMessageAlert('Nationality Name can not be empty!');
        return false;
    }
    $('.messageDiv').hide();
    var formData = $('form#frmEmpNationality').serializeObject();
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
//                $('#job_title_name').prop('disabled', true).addClass('disable_bg');
//                $('#job_title_des').prop('disabled', true).addClass('disable_bg');
                $('#frmEmpNationality').trigger("reset");
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function updateEmpJObTitle(elementObj)
{
    var tbl = $(elementObj).closest('table');
    var jobName = tbl.find('input[name~="job_title_name"]');
    if (jobName.val().trim()=='') {
        jobName.focus();
        commonMessageAlert('Designation Name Field can\'t be empty !');
        return false;
    }
    $('.messageDiv').hide();
    var formData = $('form#frmEmpJobTitle').serializeObject();
    var dataString = JSON.stringify(formData);
    //  alert(dataString); exit();
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
                fnCmnSuccessMessage(result.message);
                paginationTbl(); //for pagination

                //for hide show buttons and diables
                $('#job_title_name').prop('disabled', true).addClass('inputDisable_bg');
                $('#description').prop('disabled', true).addClass('inputDisable_bg');
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_update').hide();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function retrieveEmpJobTitle(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#job_title_name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.job_title_name);
                $('#job_title_des').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.job_title_des);
                $('#jobTitleId').val(result.jsonData.jobTitleID);
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function retrieveEmpReligion(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#religion_name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.religion_name);
                $('#religionId').val(result.jsonData.religionId);
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function retrieveEmpNationality(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#nationality_name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.nationality_name);
                $('#nationalityId').val(result.jsonData.nationalityId);
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
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
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
        success: function(result) {
            if (result.success) {
                $('#job_title_name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.jobTitleName);
                $('#description').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.description);
                $('#jobTitleUpdateURL').val('/Tashi/web/app_dev.php/location/update_country/' + result.jsonData.cid);
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
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

//function retriveEmpJobTitle(url) {
//    $('.messageDiv').hide();
//    startLoading();
//    $.ajax({
//        type: 'POST',
//        url: url,
//        dataType: 'json',
//        success: function(result) {
//            if (result.success) {
//                 $('#employeeTypeId').val(result.jsonData.jobTitleName);
//                $('#job_title_name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.jobTitleName);
//                $('#description').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.description);
//               
//                //for hide show buttons and diables                   
//                $('#btn_save').hide();
//                $('#btn_clear').hide();
//                $('#btn_edit').hide();
//                $('#btn_update').show();
//                $('#btn_cancel').show();
//                stopLoading();
//            }
//            else {
//                $('.messageDiv').show();
//                $('.message').empty().addClass('alert-box').addClass('error-box');
//                $('.message').append('<span>Error: </span>' + result.message);
//                stopLoading();
//            }
//        },
//        error: function() {
//            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
//        }
//    });
//}



function addEmpWorkingtype(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    if (tbl.find('input[name~="workingtype"]').val().trim()=='') {
        commonMessageAlert('Category can\'t be null !');
        return false;
    }

    $('.messageDiv').hide();
    var formData = $('form#frmEmpWorkingType').serializeObject();
    var dataString = JSON.stringify(formData);
    // alert(dataString);
    startLoading();
    $.ajax
            ({
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
                        //for making table empty and append
                        $('#display-list').empty().append(result.html);
                        $('#workingtypeId').val(result.jsonData.workingtypeId);
                        //to show message box div
                        $('.messageDiv').show();
                        //to empty message box empty and append
                        $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                        $('.message').append('<span>Success: </span>' + result.message);
                        //for pagination in table gridview
                        paginationTbl();

                        //for hide show and disabling button

                        $('#txt_workingtype').prop('disabled', true).addClass('inputDisable_bg');
                        $('#txt_description').prop('disabled', true).addClass('inputDisable_bg');
                        $('#btn_save').hide();
                        $('#btn_clear').hide();
                        $('#btn_edit').show();
                        $('#btn_cancel').show();

                        //to hide all the button when save is clicked

                    }
                    else
                    {
                        $('.messageDiv').show();
                        $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                        $('.message').append('<span>Error: </span>' + result.message);

                    }
                    stopLoading();
                },
                error: function() {
                    fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
                }
            });
}



function retreiveEmpWorkingType(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result)
        {
            if (result.success)
            {
                $('#employeeTypeId').val(result.jsonData.workingtypename);
                $('#txt_workingtype').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.workingtypename);
                $('#txt_description').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.description);

                //for hide show buttons and diables                   
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').hide();
                $('#btn_update').show();
                $('#btn_cancel').show();

            }
            else
            {
                $('.messageDiv').show();
                $('.message').empty().addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);

            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}



/**
 * Module Name : Employee Module
 * Purpose or objective of the  page : This controller is used to describe the functionalities of 
 * Links :ERP\LMSBundle\Controller\EmployeeController.php
 * Created By :sophiya
 * Created Date :5-2-15
 * Last Modified Date :
 * Last Modified By :
 * Test Carried Out :
 * Test Carried By :
 * Action: 
 * Use Twig file: views/Employee/employeeMasterWorkingExpert.html.twig
 *                views/Employee/displayEmpWorkingExpert.html.twig
 */
function addEmpWorkExpt(url, elementObj) {
    var tbl = $(elementObj).closest('table');
    if (tbl.find('input[name~="exptName"]').val().trim()=='') {
        commonMessageAlert('Worker Expertise can not be null!');
        return false;
    }

    $('.messageDiv').hide();
    var formData = $('form#frmEmpMastWorkExpt').serializeObject();
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
               // $('#workerExpertId').val(result.jsonData.workerExpertId);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');// to show message
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl();// for pagination    
                //for hide show buttons and diables
                $('#txt_exptName').prop('disabled', true).addClass('inputDisable_bg');
                $('#txt_exptDesciption').prop('disabled', true).addClass('inputDisable_bg');
                $('#frmEmpMastWorkExpt').trigger("reset");
                $('#btn_save').prop('value', 'Save');
                // $('#btn_update').hide(); // NO NEED FOR THIS BECAUSE ALREADY DISPLAY:NONE
                $('#btn_clear').hide();
                $('#btn_cancel').show();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);

            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}


function retrieveEmpWorkerExpert(url) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#workerExpertId').val(result.jsonData.workerExpertId);
                $('#exptName').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.workerexpertName);
                $('#exptDesciption').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.description);
                //$('#workerExpertUpdateURL').val('/TASHI/web/app_dev.php/employee/update_emp_worker_expert/' + result.jsonData.workerexpertID);
                //for hide show buttons and disables                   
                $('#btn_save').prop('value', 'Update');
                $('#btn_clear').hide();
                $('#btn_cancel').show();

            }
            else {
                $('.messageDiv').show();
                $('.message').empty().addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);

            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}


/**
 * Module Name : Employee job profile
 * Purpose or objective of the  page : This controller is used to describe the functionalities of 
 * Links :ERP\LMSBundle\Controller\employeeController.php
 * Created By : chingkhei
 * Created Date : 5Feb2015
 * Last Modified Date :
 * Last Modified By :
 * Test Carried Out :
 * Test Carried By :
 * Action: 
 * Use Twig file: views\employee\employeeMasterJobProfile.html.twig
 */
function addEmpJObProfile(url, elementObj) {
    var tbl = $(elementObj).closest('table');
    if (tbl.find('input[name~="job_profile_name"]').val().trim()=='') {
        commonMessageAlert('Job Profile can\'t be null !');
        return false;
    }


    $('.messageDiv').hide();
    var formData = $('form#frmEmpJobProfile').serializeObject();
    var dataString = JSON.stringify(formData);
    //alert(dataString); exit();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#display-list').empty().append(result.html);
                $('#jobProfileId').val(result.jsonData.jobProfileId);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl(); //for pagination

                //for hide show buttons and diables
                $('#txt_job_profile_name').prop('disabled', true).addClass('inputDisable_bg');
                $('#txt_job_profile_description').prop('disabled', true).addClass('inputDisable_bg');
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_cancel').show();



            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);

            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function retriveEmpJObProfile(url) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#employeeTypeId').val(result.jsonData.jobProfileName);
                $('#txt_job_profile_name').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.jobProfileName);
                $('#txt_job_profile_description').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.jobProfiledescription);
                //for hide show buttons and diables                   
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').hide();
                $('#btn_update').show();
                $('#btn_cancel').show();

            }
            else {
                $('.messageDiv').show();
                $('.message').empty().addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);

            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}


/**
 * Module Name : Employee Module
 * Purpose or objective of the  page : This controller is used to describe the functionalities of 
 * Links :ERP\LMSBundle\Controller\EmployeeController.php
 * Created By :sophiya
 * Created Date :9-2-15
 * Last Modified Date :
 * Last Modified By :
 * Test Carried Out :
 * Test Carried By :
 * Action: 
 * Use Twig file: views/Employee/employeeMasterWorkingExpert.html.twig
 *                views/Employee/displayEmpWorkingExpert.html.twig
 */
function addEmpWorkingSalaryType(url, elementObj) {
    var tbl = $(elementObj).closest('table');
    if (tbl.find('input[name~="Emp_Working_salary_type_Name"]').val().trim()=='') {
        commonMessageAlert('Wages Type can not be null!');
        return false;
    }

    $('.messageDiv').hide();
    var formData = $('form#frmEmpWorkingSalaryType').serializeObject();
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
             //   $('#workingSalaryTypeId').val(result.jsonData.workingSalaryTypeId);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');// to show message
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl();// for pagination    
                //for hide show buttons and diables
                //$('#Emp_Working_salary_type_Name').prop('disabled', true).addClass('inputDisable_bg');
                //$('#Emp_Working_salary_type_Des').prop('disabled', true).addClass('inputDisable_bg');
                $('#frmEmpWorkingSalaryType').trigger("reset");
                $('#btn_save').prop('value', 'Save');
                // $('#btn_update').hide(); // NO NEED FOR THIS BECAUSE ALREADY DISPLAY:NONE
                $('#btn_clear').hide();
                $('#btn_cancel').show();
                stopLoading();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function retrieveEmpWorkingSalaryType(url) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#workingSalaryTypeId').val(result.jsonData.workingSalaryTypeId);
                $('#Emp_Working_salary_type_Name').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.workingSalaryTypeName);
                $('#Emp_Working_salary_type_Des').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.description);
                //for hide show buttons and diables                   
                $('#btn_save').prop('value', 'Update');
                $('#btn_clear').hide();
                $('#btn_cancel').show();
                stopLoading();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}



function addEmpType(url, elementObj) {
    var tbl = $(elementObj).closest('table');
    if (tbl.find('input[name~="employeetypename"]').val().trim()=='') {
        commonMessageAlert('Employee type can\'t be null !');
        return false;
    }

    $('.messageDiv').hide();
    var formData = $('form#frmEmployeeType').serializeObject();
    var dataString = JSON.stringify(formData);
    //  alert(dataString); exit();
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
                $('#employeeTypeId').val(result.jsonData.employeeTypeId);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl(); //for paging table

                //for hide show buttons and diables
                $('#employeeTypeName').prop('disabled', true).addClass('inputDisable_bg');
                $('#employeeTypenameDescription').prop('disabled', true).addClass('inputDisable_bg');
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_cancel').show();

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function createDepartment(url, elementObj) {
    $('.messageDiv').hide();
    var tbl = $(elementObj).closest('table');
    if (tbl.find('input[name~="deptName"]').val().trim()=='') {
        commonMessageAlert('Department Name can not be null!');
        return false;
    } else if (tbl.find('textarea[name~="description"]').val().trim()=='') {
        commonMessageAlert('Description can not be null!');
        return false;
    }
    var formData = $('form#frmEmployeeDepartment').serializeObject();
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
                $('#empDeptId').val(result.jsonData.deptID);
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
                paginationTbl(); //for paging table
                //for hide show buttons and diables 
                /*var tbl = $(elementObj).closest('table');
                 tbl.find('input[type="text"], textarea').each(function() {
                 $(this).prop('disabled', true).addClass('inputDisable_bg');
                 });*/
                $('#frmEmployeeDepartment').trigger("reset");
                $('#btn_save').prop('value', 'Save');
                $('#btn_clear').hide();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}


function createBranchOffice(url, elementObj) {
    $('.messageDiv').hide();

    var tbl = $(elementObj).closest('table');
    var branch_name = tbl.find('input[name~="txt_branch_name"]');
    if (branch_name.val().trim()=='') {
        branch_name.focus();
        commonMessageAlert('Branch Name can not be blank !');
        return false;
    }
    var branch_code = tbl.find('input[name~="txt_branch_code"]');
    if (branch_code.val().trim()=='') {
        branch_code.focus();
        commonMessageAlert('Branch Code can not be blank !');
        return false;
    }
    var mobile = tbl.find('input[name~="txt_mobile_no"]');
    if (mobile.val().trim()=='') {
        mobile.focus();
        commonMessageAlert('Mobile No can not be blank !');
        return false;
    } else {
        if (!isMobileNo(mobile.val())) {
            mobile.focus();
            commonMessageAlert('please valid format of Mobile No i.e. 10 digit no !');
            return false;
        }
    }
    var phone = tbl.find('input[name~="txt_telephone_no"]');
    if (phone.val() !== '') {
        if (!isMobileNo(phone.val())) {
            phone.focus();
            commonMessageAlert('please valid format of Telephone No i.e. 10 digit no including state code!');
            return false;
        }
    }
    var address = tbl.find('textarea[name~="txt_address1"]');
    if (address.val().trim()=='') {
        address.focus();
        commonMessageAlert('Address can not be blank !');
        return false;
    }
    var country = tbl.find('select[name~="txt_country"]');
    if (country.val()=='') {
        country.focus();
        commonMessageAlert('Country must be select !');
        return false;
    }
    var state = tbl.find('select[name~="txt_state"]');
    if (state.val()=='') {
        state.focus();
        commonMessageAlert('State must be select !');
        return false;
    }
//    var district = tbl.find('select[name~="txt_district"]');
//    if (district.val().trim()=='') {
//        district.focus();
//        commonMessageAlert('District must be select !');
//        return false;
//    }
//    var city = tbl.find('select[name~="txt_city"]');
//    if (city.val().trim()=='') {
//        city.focus();
//        commonMessageAlert('City must be select !');
//        return false;
//    }


    var formData = $('form#frmBranchOffice').serializeObject();
    var dataString = JSON.stringify(formData);
    //  alert(dataString); exit();
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
                $('#branch_add_txn_id').val(result.jsonData);
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
                paginationTbl(); //for paging table

                //for hide show buttons and diables                
                tbl.find('input[type="text"], textarea, select').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg');
                });

                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_cancel').show();
                $('#btn_update').hide();

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}
function editBranchOfficeBtn(eleObj) {
    var tbl = $(eleObj).closest('table');
    tbl.find('input[type="text"], textarea, select').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });

    $('#btn_save').hide();
    $('#btn_clear').hide();
    $('#btn_edit').hide();
    $('#btn_cancel').show();
    $('#btn_update').show();
}

function cancelBranchOfficeBtn(eleObj) {
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    tbl.find('input[type="text"], textarea, select').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');
    });
    $('#branch_add_txn_id').val('');
    $('#btn_save').show();
    $('#btn_clear').show();
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_update').hide();
}

function branchOfficeAction(eleObj, url, actionKey) {
    $('.messageDiv').hide();
    if (actionKey == 'del') {
        if (!confirm('Are you sure to delete Branch Office ?')) {
            return false;
        }
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                switch (actionKey) {
                    case 'edit':
                        $('.application-form').empty().append(result.html);
                        $('#branch_add_txn_id').val(result.jsonData.branch_add_txn_id);
                        $('#branchName').val(result.jsonData.branch_name);
                        $('#branchCode').val(result.jsonData.branch_code);
                        $('#mobileNo').val(result.jsonData.mobile_no);
                        $('#telephoneNo').val(result.jsonData.phone_no);
                        $('#address1').val(result.jsonData.address);
                        $('#country').val(result.jsonData.country_id);
                        $('#state').val(result.jsonData.state_id);
                        $('#district').val(result.jsonData.district_id);
                        $('#city').val(result.jsonData.city_id);

                        $('#btn_save').hide();
                        $('#btn_clear').hide();
                        $('#btn_edit').hide();
                        $('#btn_cancel').show();
                        $('#btn_update').show();
                        break;
                    case 'del':
                        $(eleObj).closest('tr').remove();
                        var tbl = $('#branchOfficeFieldTbl');
                        tbl.find('input[type="text"], textarea, select').each(function() {
                            $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');
                        });
                        $('#branch_add_txn_id').val('');
                        $('#btn_save').show();
                        $('#btn_clear').show();
                        $('#btn_edit').hide();
                        $('#btn_cancel').hide();
                        $('#btn_update').hide();
                        fnCmnSuccessMessage(result.message);
                        fnCmnScrollToElementIDorClass('#wrapper');
                        break;
                }


            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}


function loadBranchOffice(url, divID) {
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $(divID).empty().append(result.html);
                paginationTbl(); //for paging table
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function retriveDepartmentInfo(url) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#deptId').val(result.jsonData.deptID);
                $('#deptName').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.deptName);
                $('#description').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.description);
                //for hide show buttons and diables                   
                $('#btn_save').prop('value', 'Update');
                $('#btn_clear').hide();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}


function deleteEmpDepartment(eleObj, url) {
    $('.messageDiv').hide();

    if (!confirm('Are you sure to delete department ?')) {
        return false;
    }

    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {

                $('#empDeptId').val('');
                $('#deptName').prop('disabled', false).removeClass('inputDisable_bg').val('');
                $('#description').prop('disabled', false).removeClass('inputDisable_bg').val('');

                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');

                $(eleObj).closest('tr').remove();
                //for hide show buttons and diables                   
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').hide();
                $('#btn_update').show();
                $('#btn_cancel').show();

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}





function retriveEmpType(url) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#employeeTypeId').val(result.jsonData.employeeTypeId);
                $('#employeeTypeName').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.employeeTypeName);
                $('#employeeTypenameDescription').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.empTypeDescription);
                //for hide show buttons and diables                   
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').hide();
                $('#btn_update').show();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}



function searchOrCreateEmployee(url) {

    $('.messageDiv').hide();
    var formData = $('form#frmSearchEmployee').serializeObject();
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
                $('#search_emp_result').empty().append(result.html);
                fnHideShow('emp_search_form');
                fnHideShow('emp_search_result_list');
                fnCmnScrollToElementIDorClass('#wrapper');
                paginationTbl2(); //for paging table

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}
function employeeAction(url,action,eleObj) {
    $('.messageDiv').hide();
    if (action == 'del') {
        if (!confirm('Are you sure you want to delete the selected employee ?'))
            return;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                switch (action) {
                    case 'del' :
                        $(eleObj).closest('tr').remove();
                        fnCmnSuccessMessage(result.message);
                        fnCmnScrollToElementIDorClass('#wrapper');
                        $('#particular_employee_details').empty(); //emptied current showing employee details 
                        break;

                    case 'upd' :                       
                        $('#particular_employee_details').empty().append(result.html);
                        fnHideShow('emp_search_result_list');
                        fnCmnScrollToElementIDorClass('#wrapper');
                        break;
                }

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}
/*function employeeAction(eleObj, empID, actionID) {
    $('.messageDiv').hide();
    var rawurl = $(actionID + empID).val();
    if (rawurl == '') {
        return;
    }
    var url = rawurl.split('&')[0];
    var action = rawurl.split('&')[1];
    if (action == 'del') {
        if (!confirm('Are you sure you want to delete the selected employee ?'))
            return false;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                switch (action) {
                    case 'del' :
                        $(eleObj).closest('tr').remove();
                        fnCmnSuccessMessage(result.message);
                        fnCmnScrollToElementIDorClass('#wrapper');
                        $('#particular_employee_details').empty(); //emptied current showing employee details 
                        break;

                    case 'upd' :                       
                        $('#particular_employee_details').empty().append(result.html);
                        fnHideShow('emp_search_result_list');
                        fnCmnScrollToElementIDorClass('#wrapper');
                        break;
                }

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}*/

function loadWorkerDetails(url) {
    $('.messageDiv').hide();
    var empID;
    if ($('#employeeID').val().trim()=='') {
        empID = '';
    } else {
        empID = $('#employeeID').val();
    }

    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: {'loadID': empID},
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#empWorkerDetail').empty().append(result.html);
                if (result.jsonData !== 0) {   
                    $('#employeeID').val(result.jsonData.empID);
                    $('#display_txt_employeeID').html('Employee ID : ' + result.jsonData.assignEmpID);
                    $('#worker_name').val(result.jsonData.workerName);
                    $('#worker_parents').val(result.jsonData.relationShip);
                    $('#joiningDate').val(result.jsonData.joiningDate);
                    $('#status').val(result.jsonData.statusID);
                    $('#mobile').val(result.jsonData.mobile);
                    $('#phone').val(result.jsonData.phone);
                    $('#salaryType').val(result.jsonData.salaryTypeID);
                    $('#workingType').val(result.jsonData.workingTypeID);
                    $('#salaryAmount').val(result.jsonData.amountPay);
                    $('#jobTitle').val(result.jsonData.jobTitleID);
                    $('#jobprofile').html(result.jsonData.jobProfile);
                    $('#branch_office').val(result.jsonData.branchOffice);
                    $('#address').val(result.jsonData.address);
                    //check expertise 
                    var i = 0;
                    $('#expertise_fields').find('.expertise').each(function(){ 
                        var all_expertise = JSON.parse(result.jsonData.expertise);
                        for(i = 0; i< all_expertise.length; i++){  
                            if( $(this).val() == all_expertise[i]){
                                $(this).prop('checked', true);
                                break;
                            }
                        }
                    });
                    
                    if (result.jsonData.gender == 'M') {
                        $('#gender_male').prop('checked', true);
                    }
                    if (result.jsonData.gender == 'F') {
                        $('#gender_female').prop('checked', true);
                    }
                    //for hide show buttons and diables
                    $('#personal_detials_tbl').find('input[type = text], input[type = date], input[type = checkbox], input[type = radio], select, textarea').each(function() {
                        $(this).prop('disabled', true).addClass('inputDisable_bg');
                    });

                    $('#btn_save').hide();
                    $('#btn_clear').hide();
                    $('#btn_update').hide();
                    $('#btn_edit').show();
                    $('#btn_cancel').hide();

                }

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}


function checkValue(eleID) {
    if ($(eleID).val() !== '') {
        $('.messageDiv').hide();
    }
}

function saveWorkerDetails(eleObj, url) {
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');

    var name = tbl.find('input[name~="txt_worker_name"]');
    if (name.val().trim()=='') {
        name.focus();
        fnCmnWarningMessage('Name can not be blank !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var parent = tbl.find('input[name~="txt_worker_parents"]');
    if (parent.val().trim()=='') {
        parent.focus();
        fnCmnWarningMessage('Parent/Relationship can not be blank !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }

    if ($('#gender_male').prop('checked') == false && $('#gender_female').prop('checked') == false) {
        $('#gender_male').focus();
        fnCmnWarningMessage('Gender must be select !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }

    var joiningDate = tbl.find('input[name~="txt_joining_date"]');
    if (joiningDate.val().trim()=='') {
        joiningDate.focus();
        fnCmnWarningMessage('Joining Date can not be blank !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var branch_office = tbl.find('select[name~="txt_branch_office"]');
    if (branch_office.val()=='') {
        branch_office.focus();
        fnCmnWarningMessage('Branch Office must be select !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var mobile = tbl.find('input[name~="txt_mobile"]');
    if (mobile.val().trim()=='') {
        mobile.focus();
        fnCmnWarningMessage('Mobile can not be blank !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var salaryType = tbl.find('select[name~="txt_salary_type"]');
    if (salaryType.val()=='') {
        salaryType.focus();
        fnCmnWarningMessage('Wage Type must be select !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var wage_amount = tbl.find('input[name~="txt_salary_amount"]');
    if (wage_amount.val().trim()=='') {
        wage_amount.focus();
        fnCmnWarningMessage('Wage Amount Per Wage Type can not be blank !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    if ($('#expertise').val() == 0) {
        $('#expertise').focus();
        fnCmnWarningMessage('Please set first worker expertise from master setting !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var checkExpertiseFlag = 0;
    tbl.find('.expertise').each(function(){
        if($(this).prop('checked') == true){
            checkExpertiseFlag = 1;
        }
    });
    if(checkExpertiseFlag == 0){
        fnCmnWarningMessage('One of the expertise must select !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    
    
    var workingType = tbl.find('select[name~="txt_working_type"]');
    if (workingType.val()=='') {
        workingType.focus();
        fnCmnWarningMessage('Working Type must be select !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }   
    
    var address = tbl.find('textarea[name~="txt_address"]');
    if (address.val().trim()=='') {
        address.focus();
        fnCmnWarningMessage('Address can not be blank !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }

    var formData = new FormData($('#emp_workker_details')[0]);
    formData.append('txt_employee_id', $('#employeeID').val());

    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $('#employeeID').val(result.jsonData.employeeID);
                $('#display_txt_employeeID').html('Employee ID : ' + result.jsonData.assignEmpID);
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');

                //for hide show buttons and diables
                tbl.find('input[type = text], input[type = date], input[type = checkbox], input[type = radio], select, textarea').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg');
                });

                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_update').hide();
                $('#btn_edit').show();
                $('#btn_cancel').show();

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function editWokerFields(eleObj) {
    var tbl = $(eleObj).closest('table');
    tbl.find('input[type = text], input[type = date], input[type = checkbox], input[type = radio], select, textarea').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });

    $('#btn_save').hide();
    $('#btn_clear').hide();
    $('#btn_update').show();
    $('#btn_edit').hide();
    $('#btn_cancel').show();
}

function cancelWorkerDetails(eleObj) {
    if (confirm('Are you sure to cancel update ?')) {
        $('.messageDiv').hide();
        $('#particular_employee_details').empty();
//        var tbl = $(eleObj).closest('table'); 
//        $('#display_txt_employeeID').html('');
//        $('#employeeID').val('');
//        $('#status').val(1);
//        tbl.find('input[type = text], input[type = date], input[type = radio], select, textarea').each(function() {
//            $(this).prop('disabled', false).removeClass('inputDisable_bg');
//        });
//        tbl.find('input[type = text], input[type = date], select, textarea').each(function() {
//            $(this).val('');
//        });
//        tbl.find('input[type = radio], input[type = checkbox]').each(function() {
//            $(this).prop('checked', false);
//        });
//
//        $('#btn_save').show();
//        $('#btn_clear').show();
//        $('#btn_update').hide();
//        $('#btn_edit').hide();
//        $('#btn_cancel').hide();

    } else {
        return false;
    }
}

// ---------employee create > person details module starts here--------employee_id--------//
function checkPersonalDetails(empPkid){
    if($(empPkid).val().trim()==''){
        fnCmnWarningMessage('Please save first Personal Details !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }else{
        return true;
    }
}

function saveEmpPersonDetails(eleObj, url) {
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');

    var employeeID = tbl.find('input[name~="txt_employee_id"]');
    if (employeeID.val().trim()=='') {
        employeeID.focus();
        fnCmnWarningMessage('Employee ID can not be blank !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }

    var firstName = tbl.find('input[name~="txt_emp_firstname"]');
    if (firstName.val().trim()=='') {
        firstName.focus();
        fnCmnWarningMessage('First Name can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var lastName = tbl.find('input[name~="txt_emp_lastname"]');
    if (lastName.val().trim()=='') {
        lastName.focus();
        fnCmnWarningMessage('Last Name can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }

    if ($('#emp_gender_male').prop('checked') == false && $('#emp_gender_female').prop('checked') == false) {
        $('#emp_gender_male').focus();
        fnCmnWarningMessage('Gender must be select !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var dob = tbl.find('input[name~="txt_emp_dob"]');
    if (dob.val().trim()=='') {
        dob.focus();
        fnCmnWarningMessage('DOB can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }

    var fatherName = tbl.find('input[name~="txt_father_name"]');
    if (fatherName.val().trim()=='') {
        fatherName.focus();
        fnCmnWarningMessage('Father Name can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }


    var formData = new FormData($('#emp_personal_details')[0]);
    formData.append('empID', $('#empID').val());
    //alert(dataString); 
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                if (result.jsonData.code == 1) {
                    switch (result.jsonData.emp_ID_Flag) {
                        case 1: //if already exist employee Id
                            employeeID.focus();
                            fnCmnWarningMessage(result.message);
                            fnCmnScrollToElementIDorClass('#wrapper');
                            break;
                        case 0: //if new entry employee Id 
                            $('#empID').val(result.jsonData.empID);
                            $('#display_txt_employeeID').html('Employee ID : ' + result.jsonData.assignEmpID + ' , '+ result.jsonData.person_name);
                            fnCmnSuccessMessage(result.message);
                            fnCmnScrollToElementIDorClass('#wrapper');

                            //for hide/show buttons and diables
                            tbl.find('input[type = text], input[type = date], input[type = file], input[type = radio]').each(function() {
                                $(this).prop('disabled', true).addClass('inputDisable_bg');
                            });
                            //removing mouse pointer event null to empployee tabs
                            // $('#job_details, #address_details, #contact_details, #bank_details, #dependant_details').removeClass('removeMousePointer');

                            $('#btn_save').hide();
                            $('#btn_clear').hide();
                            $('#btn_update').hide();
                            $('#btn_edit').show();
                            $('#btn_cancel').show();
                            break;
                    }
                } else {
                    fnCmnWarningMessage(result.message);
                    fnCmnScrollToElementIDorClass('#wrapper');
                }


            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');

            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function empEmpPersonalDetailBtn(eleObj) {
    var tbl = $(eleObj).closest('table');
    tbl.find('input[type = text], input[type = date], input[type = file], input[type = radio], select').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });

    $('#btn_save').hide();
    $('#btn_update').show();
    $('#btn_clear').show();
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
}

function cancelEmpPersonDetails(eleObj) {//employeeID
    if (confirm('Are you sure, cancel update ?')) {
        $('.messageDiv').hide();
        $('#empID').val('');
        $('#display_txt_employeeID').html('');
        var tbl = $(eleObj).closest('table');
        tbl.find('input[type = text], input[type = date], input[type = file], input[type = radio], select').each(function() {
            $(this).prop('disabled', false).removeClass('inputDisable_bg');
        });
        tbl.find('input[type = text], input[type = date], input[type = file], select').each(function() {
            $(this).val('');
        });
        tbl.find('input[type = radio]').each(function() {
            $(this).prop('checked', false);
        });
        //adding pointer event null to empployee tabs
        $('#job_details, #address_details, #contact_details, #bank_details, #dependant_details').addClass('removeMousePointer');

        $('#btn_save').show();
        $('#btn_clear').show();
        $('#btn_update').hide();
        $('#btn_edit').hide();
        $('#btn_cancel').hide();
    } else {
        return false;
    }
}


function saveEmpJobDetais(eleObj, url) {
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    var jobDesignation = tbl.find('select[name~="txt_emp_job_title"]');
    if (jobDesignation.val()=='') {
        fnCmnWarningMessage('Job Designation can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        jobDesignation.focus();
        return false;
    }
    var joiningDate = tbl.find('input[name~="txt_emp_joiningdate"]');
    if (joiningDate.val().trim()=='') {
        fnCmnWarningMessage('Joining Date can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        joiningDate.focus();
        return false;
    }
    var salaryGrade = tbl.find('input[name~="txt_emp_salary_grade"]');
    if (salaryGrade.val().trim()=='') {
        fnCmnWarningMessage('Salary Grade can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        salaryGrade.focus();
        return false;
    }
    var grossSalary = tbl.find('input[name~="txt_emp_gross_salary"]');
    if (grossSalary.val().trim()=='') {
        fnCmnWarningMessage('Gross Salary can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        grossSalary.focus();
        return false;
    }
    var department = tbl.find('select[name~="txt_department"]');
    if (department.val()=='') {
        fnCmnWarningMessage('Please select Department !');
        fnCmnScrollToElementIDorClass('#wrapper');
        department.focus();
        return false;
    }
    var branch = tbl.find('select[name~="txt_branch"]');
    if (branch.val()=='') {
        fnCmnWarningMessage('Please select Branch !');
        fnCmnScrollToElementIDorClass('#wrapper');
        branch.focus();
        return false;
    }

    var jobProfile = tbl.find('textarea[name~="txt_emp_job_profile"]');
    if (jobProfile.val().trim()=='') {
        fnCmnWarningMessage('Job Profile can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        jobProfile.focus();
        return false;
    }

    var formData = $('form#emp_job_details').serializeObject();
    var addData = {'empID': $('#empID').val()};
    // add data to the serialize object
    var dataString = JSON.stringify($.extend(formData, addData));
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

                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');

                //for hide show buttons and diables 
                tbl.find('input[type = text], input[type = date], select, textarea').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg');
                });
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}
function editJobDetailsFields(eleObj) {
    var tbl = $(eleObj).closest('table');
    tbl.find('input[type = text], input[type = date], select, textarea').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });

    $('#btn_save').show();
    $('#btn_clear').hide();
    $('#btn_edit').hide();
}

function loadAddressForm(url, loadFormDivID) {
    $('.messageDiv').hide();
    var address_type = $('#address_type_select_ID');
    if (address_type.val().trim()=='') {
        address_type.focus();
        fnCmnWarningMessage('Select address type to proceed !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: {'txt_Address_Type_ID': address_type.val(), 'empID': $('#empID').val()},
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                if (result.jsonData == 1) {
                    fnCmnWarningMessage(result.message);
                    fnCmnScrollToElementIDorClass('#wrapper');
                } else {
                    $(loadFormDivID).empty().append(result.html);
                    fnHideShow('emp_add_detail_form');
                    $('#addTxnID').val('');
                }
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}
function cmnLoadLocationList(eleObj, url, appendEleID) {
    $('.messageDiv').hide();
    switch (appendEleID) {
        case 'state':
            $('#district').empty().append('<option value="">--Select--</option>');
            $('#city').empty().append('<option value="">--Select--</option>');
            break;
        case 'district':
            $('#city').empty().append('<option value="">--Select--</option>');
            break;
    }

    $.ajax({
        type: 'POST',
        url: url,
        data: {'load_list_key': $(eleObj).val()},
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#' + appendEleID).empty().append(result.html);
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function saveAddressDetails(url, eleObj) {
    $('.messageDiv').hide();
    var frm = $(eleObj).closest('form');
    var address = frm.find('textarea[name~="txt_address1"]');
    if (address.val().trim()=='') {
        address.focus();
        fnCmnWarningMessage('Address Street 1 can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var country = frm.find('select[name~="txt_country"]');
    if (country.val()=='') {
        country.focus();
        fnCmnWarningMessage('Country can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var state = frm.find('select[name~="txt_state"]');
    if (state.val()=='') {
        state.focus();
        fnCmnWarningMessage('State can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var district = frm.find('select[name~="txt_district"]');
    if (district.val()=='') {
        district.focus();
        fnCmnWarningMessage('District can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    var city = frm.find('select[name~="txt_city"]');
    if (city.val()=='') {
        city.focus();
        fnCmnWarningMessage('City can\'t be empty !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
//    var block_village = frm.find('input[name~="txt_block_village"]');
//    if (block_village.val().trim()=='') {
//        block_village.focus();
//        fnCmnWarningMessage('Block/Village can\'t be empty !');
//        fnCmnScrollToElementIDorClass('#wrapper');
//        return false;
//    }
//    var postal_code = frm.find('input[name~="txt_postal_code"]');
//    if (postal_code.val().trim()=='') {
//        postal_code.focus();
//        fnCmnWarningMessage('Postal Code can\'t be empty !');
//        fnCmnScrollToElementIDorClass('#wrapper');
//        return false;
//    }
//    var landmark = frm.find('textarea[name~="txt_landmark"]');
//    if (landmark.val().trim()=='') {
//        landmark.focus();
//        fnCmnWarningMessage('Landmark Code can\'t be empty !');
//        fnCmnScrollToElementIDorClass('#wrapper');
//        return false;
//    }



    var formData = $('form#empAddressDetail').serializeObject();
    var addData = {'empID': $('#empID').val()};
    // add data to the serialize object
    var dataString = JSON.stringify($.extend(formData, addData));

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
                if (result.jsonData.check_primary_add_flag == 0) {
                    $('#emp_address_details_list').empty().append(result.html);
                    $('#addTxnID').val(result.jsonData.addTxnID);
                    paginationTbl(); //for pagination
                    fnCmnSuccessMessage(result.message);
                    //for hide show buttons and diables
                    frm.find('input[type = text], input[type = checkbox], select, textarea').each(function() {
                        $(this).prop('disabled', true).addClass('inputDisable_bg');
                    });
                    $('#btn_add_address').prop('disabled', true).addClass('inputDisable_bg');

                    $('#btn_save').hide();
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_update').hide();
                } else {
                    fnCmnWarningMessage(result.message);
                }

                fnCmnScrollToElementIDorClass('#wrapper');

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function retriveEmpAddressRecord(frmID, url) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {//addTxnID
                $('#empAddressDetailDiv').empty().append(result.html);
                $('#addTxnID').val(result.jsonData.addTxnID);
                $('#address_type_select_ID').val(result.jsonData.addressTypeID);
                $('#address1').val(result.jsonData.address1);
                $('#address2').val(result.jsonData.address2);
                $('#country').val(result.jsonData.countryID);
                $('#state').val(result.jsonData.stateID);
                $('#district').val(result.jsonData.districtID);
                $('#city').val(result.jsonData.cityID);
                $('#postal_code').val(result.jsonData.postalCode);
                $('#block_village').val(result.jsonData.blockVillage);
                $('#landmark').val(result.jsonData.landmark);
                if (result.jsonData.isPrimary == 1) {
                    $('#check_primary').prop('checked', true);
                }

                //table hide 
                fnHideShow('emp_add_detail');
                fnHideShow('emp_add_detail_form');

                //disables fields
                $(frmID).find('input[type = text], input[type = checkbox], select, textarea').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg');
                });
                $('#btn_add_address').prop('disabled', true).addClass('inputDisable_bg');

                //buttons hide           
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_update').hide();
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function deleteEmpAddressRecord(eleObj, formDivID, url) {
    $('.messageDiv').hide();
    if (confirm('Are you sure to delete record ?')) {
        startLoading();
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            success: function(result) {
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
                if (result.success) {
                    $(eleObj).closest('tr').remove();
                    fnCmnSuccessMessage(result.message);
                    fnCmnScrollToElementIDorClass('#wrapper');

                    $(formDivID).empty();
                    $('#btn_add_address').prop('disabled', false).removeClass('inputDisable_bg');
                    $('#addTxnID').prop('disabled', false).removeClass('inputDisable_bg').val('');
                    $('#address_type_select_ID').prop('disabled', false).removeClass('inputDisable_bg').val('');

                    //buttons hide           
                    $('#btn_save').hide();
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_update').hide();
                }
                else {
                    fnCmnErrorMessage(result.message);
                    fnCmnScrollToElementIDorClass('#wrapper');
                }
                stopLoading();
            },
            error: function() {
                fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
            }
        });
    } else {
        return false;
    }
}

function cancelAddressForm(eleObj, divID) {
    var frm = $(eleObj).closest('form');
    $('#address_type_select_ID').val('');
    $('#addTxnID').val('');
    $('#btn_add_address').prop('disabled', false).removeClass('inputDisable_bg');
    frm.find('input[type = text], input[type = checkbox], select, textarea').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });
    $(divID).empty();
}

function editAddressDetails(eleObj) {
    var frm = $(eleObj).closest('form');
    frm.find('input[type = text], input[type = checkbox], select, textarea').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });
    $('#btn_add_address').prop('disabled', false).removeClass('inputDisable_bg');

    $('#btn_save').hide();
    $('#btn_clear').hide();
    $('#btn_edit').hide();
    $('#btn_update').show();
}

function saveEmpContactDetails(url, eleObj, key) {
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    var frm = $(eleObj).closest('form');
    //I => for insert key
    var contact_person_id = frm.find('input[name~="txt_contact_person_id"]');
    if (key == 'I') {
        if (contact_person_id.val() !== '') {
            fnCmnWarningMessage('Already exist contact details. Please edit to update or newly add');
            fnCmnScrollToElementIDorClass('#wrapper');
            return false;
        }
    }
    if (contact_person_id.val().trim()=='') {
        var mobile = frm.find('input[name~="txt_emp_contact_mobile"]');
        if ((mobile.val().trim()=='')) {
            var exist_mobile_key = 0;
            $('#contact_mobiles').find('.mobFields').each(function(){
                if($(this).val() !== ''){
                    exist_mobile_key = 1;
                }
            });
            if(exist_mobile_key == 0){
                mobile.focus();
                fnCmnWarningMessage('Mobile No can not be blank !');
                fnCmnScrollToElementIDorClass('#wrapper');
                return false;
            }                      
        } else if ((!isMobileNo(mobile.val()))) {
            mobile.focus();
            fnCmnWarningMessage('Please enter valid format of mobile no !');
            fnCmnScrollToElementIDorClass('#wrapper');
            return false;
        }
    }
    var email_office = frm.find('input[name~="txt_emp_official_email"]');
    if ((email_office.val() !== '') && (!isValidEmail(email_office.val()))) {
        email_office.focus();
        fnCmnWarningMessage('Please enter valid format of Official Email !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }

    var email_private = frm.find('input[name~="txt_emp_private_email"]');
    if ((email_private.val() !== '') && (!isValidEmail(email_private.val()))) {
        email_private.focus();
        fnCmnWarningMessage('Please enter valid format of Private Email !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }

    var webSite = frm.find('input[name~="txt_emp_website"]');
    if ((webSite.val() !== '') && (!isValidURL(webSite.val()))) {
        webSite.focus();
        fnCmnWarningMessage('Please enter valid format of website name !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }

    var formData = $('form#contactDetail').serializeObject();
    var addData = {'empID': $('#empID').val()};
    // add data to the serialize object
    var dataString = JSON.stringify($.extend(formData, addData));

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
                switch (result.jsonData.contact_flag) {
                    case 0:
                        $('#emp_contact_details_list').empty().append(result.html);
                        $('#contact_mobiles').empty().append(result.secondHtml);
                        paginationTbl(); //for pagination
                        fnCmnSuccessMessage(result.message);
                        //for hide show buttons and diables
                        tbl.find('input[type = text]').each(function() {
                            $(this).prop('disabled', true).addClass('inputDisable_bg');
                        });
                        tbl.find('.cmnCtrlBtn').each(function() {
                            $(this).prop('disabled', true).addClass('inputDisable_bg').addClass('removeMousePointer');
                        });

                        $('#btn_save').hide();
                        $('#btn_clear').hide();
                        $('#btn_edit').show();
                        $('#btn_update').hide();
                        break;
                    case 1:
                        fnCmnWarningMessage(result.message);
                        fnCmnScrollToElementIDorClass('#wrapper');
                        break;

                }

            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });

}

function saveEmpBankDetails(url, eleObj) {
    var tbl = $(eleObj).closest('table');
    var formData = new FormData($('#emp_bank_details_frm')[0]);
    formData.append('empID', $('#empID').val());

    if (tbl.find('input[name~="txt_bank_name"]').val().trim()=='') {
        commonMessageAlert('Bank Name can not be null!');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    } else if (tbl.find('input[name~="txt_branch_name"]').val().trim()=='') {
        commonMessageAlert('Branch Name can not be null!');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    } else if (tbl.find('input[name~="txt_branch_code"]').val().trim()=='') {
        commonMessageAlert('Branch Code can not be null!');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    else if (tbl.find('select[name~="txt_account_type"]').val().trim()=='') {
        commonMessageAlert('Please select an appropraite account type!');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    } else if (tbl.find('input[name~="txt_account_no"]').val().trim()=='') {
        commonMessageAlert('Account number can not be null!');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    } else if (tbl.find('textarea[name~="txt_location"]').val().trim()=='') {
        commonMessageAlert('Location can not be null!');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }



    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $('#emp_bank_details_list').empty().append(result.html);
                $('#bankDetaiID').val(result.jsonData);
                fnCmnSuccessMessage(result.message);
                paginationTbl(); //for paging table       

                //for hide show buttons and diables fields                  
                tbl.find('input[type = text], input[type = file], select, textarea').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg');
                });

                $('#btn_edit').show();
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_update').hide();

            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}
function retriveBankDetails(url, eleObj) {
    var tbl = $(eleObj).closest('table');
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#bankDetaiID').val(result.jsonData.bankMasterID);
                $('#bank_name').val(result.jsonData.bankName);
                $('#branch_Name').val(result.jsonData.branchName);
                $('#branch_code').val(result.jsonData.branchCode);
                $('#account_type').val(result.jsonData.accTypeID);
                $('#micr_code').val(result.jsonData.MICRcode);
                $('#ifsc_code').val(result.jsonData.IFSCcode);
                $('#account_no').val(result.jsonData.accNo);
                $('#contact_no').val(result.jsonData.contactNo);
                $('#location').html(result.jsonData.location);

                //to open form when click on edit  
                $('#add_bank_btn_div').hide();
                $('#bank_detail_from_div').show();

                //for hide show buttons and diables              
                $('#btn_update').show();
                $('#btn_edit').hide();
                $('#btn_save').hide();
                $('#btn_clear').hide();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });

}

function retriveContactDetails(url, formID) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#contact_mobiles').empty().append(result.html);

                $('#emp_official_email').val(result.jsonData.email_office);
                $('#emp_private_email').val(result.jsonData.email_private);
                $('#emp_website').val(result.jsonData.website);
                $('#contact_phone').val(result.jsonData.phoneNo);

                //diabled all field in contact detail field         
                $(formID).find('.cmnField, .mobFields').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg');
                });
                $(formID).find('.cmnCtrlBtn').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg').addClass('removeMousePointer');
                });

                //to open form when click on edit   
                $('#add_contact_btn_div').hide();
                $('#empAddressDetailDiv').show();

                // collapse 
                fnHideShow('emp_contact_detail');

                //for hide show buttons and diables              
                $('#btn_update').hide();
                $('#btn_edit').show();
                $('#btn_save').hide();
                $('#btn_clear').hide();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}
function deleteContactDetails(eleObj, url) {
    $('.messageDiv').hide();
    if (confirm('Are you sure to delete contact details ?')) {
        startLoading();
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            success: function(result) {
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
                if (result.success) {
                    var tr = $(eleObj).closest('tr');
                    tr.after('<tr>\n\
                                <td class="tbl-grid-view-row-no-bg" align="center" colspan="7"> <b>No Data available in table</b>  </td>\n\
                            </tr>');
                    tr.empty().remove();
                    fnCmnSuccessMessage(result.message);
                    fnCmnScrollToElementIDorClass('#wrapper');
                    // if display mobile list when edit before delete, then clear mobile list
                    $('#contact_mobiles').empty().append('<table>\n\
                                                            <tr>\n\
                                                                <td> <input class="cmnWidth cmnField" type="text" id="emp_contact_mobile" name="txt_emp_contact_mobile" onKeypress="return validationDigit(\'#emp_contact_mobile\');"/>  </td>\n\
                                                                <td><input type="button" class="button blue cmnField" value="Add" onclick="addFieldDynamic(this,\'txt_emp_contact_mobile\');"/></td>\n\
                                                            </tr>\n\
                                                        </table> ');
                    $('#contactPersonID').val(''); // hidden personal ID field to null, this identified existing contact details of employee
                    $('#contactDetail').find('input[type = text]').each(function() {
                        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');
                    });

                    $('#btn_save').show();
                    $('#btn_clear').show();
                    $('#btn_edit').hide();
                    $('#btn_update').hide();
                }
                else {
                    fnCmnErrorMessage(result.message);
                }
                stopLoading();
            },
            error: function() {
                fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
            }
        });
    } else {
        return false;
    }
}

function showEnableFields(formID) {
    //diabled all field in contact detail field         
    $(formID).find('.cmnField').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });
    $(formID).find('.cmnCtrlBtn').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg').removeClass('removeMousePointer');
    });
    $('#btn_update').show();
    $('#btn_edit').hide();
}
function cancelContactDetailFields(eleObj) {
    $('#contact_mobiles').empty().append('<table>\n\
                                            <tr>\n\
                                                <td> <input class="cmnWidth cmnField" type="text" id="emp_contact_mobile" name="txt_emp_contact_mobile"/>  </td>\n\
                                                <td><input type="button" class="button blue cmnField" value="Add" onclick="addFieldDynamic(this,\'txt_emp_contact_mobile\');"/></td>\n\
                                            </tr>\n\
                                        </table> ');
    $(eleObj).closest('table').find('input[type = text], input[type = date], textarea').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');
    });

    $('#dependentID').val('').prop('disabled', false).removeClass('inputDisable_bg');

    $('#btn_save').show();
    $('#btn_clear').show();
    $('#btn_edit').hide();
    $('#btn_update').hide();
}
function editIndividualMobileNos(eleObj, deleteBtnClass, updateBtnClass, cancelEmpMobClass, inputFieldID) {
    $(eleObj).hide();
    $(deleteBtnClass).hide();
    $(updateBtnClass).show();
    $(cancelEmpMobClass).show();
    $(inputFieldID).prop('disabled', false).removeClass('inputDisable_bg').removeClass('removeMousePointer');
}
function cancelUpdate(eleObj, deleteBtnClass, editBtnClass, updateBtnClass, inputFieldID) {
    $(eleObj).hide();
    $(deleteBtnClass).show();
    $(editBtnClass).show();
    $(updateBtnClass).hide();
    $(inputFieldID).prop('disabled', true).addClass('inputDisable_bg').addClass('removeMousePointer');
}

function updateEmpMobileNos(eleObj, loopIndexNo, url, inputFieldID) {
    $('.messageDiv').hide();
    var mobileNo = $(inputFieldID).val();
    if ((mobileNo !== '') && (!isMobileNo(mobileNo))) {
        $(inputFieldID).focus();
        fnCmnWarningMessage('Please enter valid format of mobile no !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: {'empID': $('#empID').val(), 'txt_mob_no': $(inputFieldID).val(), 'loopIndexNo': loopIndexNo},
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $(eleObj).closest('tr').empty().append(result.html);
                $('#emp_contact_details_list').empty().append(result.secondHtml);
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function editEmpMobileNos(eleObj, ur, inputID) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $(eleObj).closest('tr').remove();
                fnCmnSuccessMessage(result.message);
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function deleteEmpMobileNo(eleObj, url) {
    $('.messageDiv').hide();
    if (confirm('Are you sure to delete mobile no. ?')) {
        startLoading();
        $.ajax({
            type: 'POST',
            url: url,
            data: {'empID': $('#empID').val(), 'detectKey': $('#keyToDetectWhoseNos').val()},
            dataType: 'json',
            success: function(result) {
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
                if (result.success) {
                    switch (result.jsonData) {
                        case 'E' :  // for employee 
                            $('#emp_contact_details_list').empty().append(result.html);
                            paginationTbl(); //for pagination
                            break;
                        case 'D' :  //for dependent 
                            $('#emp_dependent_details_list').empty().append(result.html);
                            paginationTbl(); //for pagination
                            break;
                    }

                    $(eleObj).closest('tr').remove();
                    fnCmnSuccessMessage(result.message);
                    fnCmnScrollToElementIDorClass('#wrapper');
                }
                else {
                    fnCmnErrorMessage(result.message);
                    fnCmnScrollToElementIDorClass('#wrapper');
                }
                stopLoading();
            },
            error: function() {
                fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
            }
        });
    } else {
        return false;
    }
}

function deleteBankDetails(url, eleObj) {
    $('.messageDiv').hide();
    if (confirm('Are you sure to delete record?'))
    {
        startLoading();
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            success: function(result) {
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
                if (result.success) {
                    $(eleObj).closest('tr').remove();
                    fnCmnSuccessMessage(result.message);
                }
                else {
                    fnCmnErrorMessage(result.message);
                }
                stopLoading();
            },
            error: function() {
                fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
            }
        });
    } else {
        return false;
    }

}

function saveEmpDependentDetails(url, eleObj) {
    var frm = $(eleObj).closest('form');
    $('.messageDiv').hide();

    var tbl = $(eleObj).closest('table');
    if (tbl.find('input[name~="txt_first_name"]').val().trim()=='') {
        commonMessageAlert('First Name can not be null!');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }else if (tbl.find('input[name~="txt_last_name"]').val().trim()=='') {
        commonMessageAlert('Last Name can not be null!');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    } else if (tbl.find('input[name~="txt_relation"]').val().trim()=='') {
        commonMessageAlert('Relation can not be null!');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    } else if (tbl.find('textarea[name~="txt_address"]').val().trim()=='') {
        commonMessageAlert('Address can not be null!');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }   
    
    
    
    var formData = $('form#frmEmpDependentDetails').serializeObject();
    var addData = {'empID': $('#empID').val()};
    // add data to the serialize object
    var dataString = JSON.stringify($.extend(formData, addData));
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
                $('#emp_dependent_details_list').empty().append(result.html);
                $('#contact_mobiles').empty().append(result.secondHtml);
                $('#dependentID').val(result.jsonData);
                paginationTbl(); //for pagination
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
                //for hide show buttons and diables
                frm.find('input[type = text], input[type = date], textarea').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg');
                });
                frm.find('.cmnCtrlBtn').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg').addClass('removeMousePointer');
                });

                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_update').hide();

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}

function retriveEmpDependentRecord(formID, url) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#dependentID').val(result.jsonData.dependentID);
                $('#contact_mobiles').empty().append(result.html);
                $('#first_name').val(result.jsonData.first_name);
                $('#last_name').val(result.jsonData.last_name);
                $('#middle_name').val(result.jsonData.middle_name);
                $('#occupation').val(result.jsonData.occupation);
                $('#relation').val(result.jsonData.relation);
                $('#phone_no').val(result.jsonData.phone);
                $('#address').val(result.jsonData.address);
                $('#dob').val(result.jsonData.dob);
                //for hide show buttons and diables
                fnHideShow('emp_dependent_detail');
                $('#add_dependent_btn_div').hide();
                $('#emp_dependent_form_div').show();
                $(formID).find('.cmnField, .mobFields').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg');
                });
                $(formID).find('.cmnCtrlBtn').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg').addClass('removeMousePointer');
                });

                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_update').hide();
                $('#btn_cancel').show();
                $('#btn_edit').show();

            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
        }
    });
}
function deleteEmpDependentRecord(eleObj, formID, url) {
    $('.messageDiv').hide();
    if (confirm('Are you sure to delete record ?')) {
        startLoading();
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            success: function(result) {
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
                if (result.success) {
                    $(eleObj).closest('tr').remove();
                    $('#dependentID').val('');
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#middle_name').val('');
                    $('#occupation').val('');
                    $('#relation').val('');
                    $('#phone_no').val('');
                    $('#address').val('');
                    $('#dob').val('');
                    //for hide show buttons and diables              
                    $(formID).find('.cmnField, .mobFields').each(function() {
                        $(this).prop('disabled', false).removeClass('inputDisable_bg');
                    });
                    $(formID).find('.cmnCtrlBtn').each(function() {
                        $(this).prop('disabled', false).removeClass('inputDisable_bg').removeClass('removeMousePointer');
                    });
                    $('#contact_mobiles').empty().append('<table>\n\
                                                   <tr>\n\
                                                       <td> <input class="cmnWidth cmnField" type="text" id="emp_contact_mobile" name="txt_emp_contact_mobile"/>  </td>\n\
                                                       <td><input type="button" class="button blue cmnField" value="Add" onclick="addFieldDynamic(this,\'txt_emp_contact_mobile\');"/></td>\n\
                                                   </tr>\n\
                                               </table> ');

                    $('#btn_save').show();
                    $('#btn_clear').show();
                    $('#btn_update').hide();
                    $('#btn_cancel').show();
                    $('#btn_edit').hide();

                }
                else {
                    fnCmnErrorMessage(result.message);
                    fnCmnScrollToElementIDorClass('#wrapper');
                }
                stopLoading();
            },
            error: function() {
                fnCmnWarningMessage('An unknown technical error was encountered.'); stopLoading(); scrollToMessage();
            }
        });
    } else {
        return false;
    }
}

function ediDependentDetail(eleObj) {
    var frm = $(eleObj).closest('form');
    frm.find('.cmnField').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });
    frm.find('.cmnCtrlBtn').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg').removeClass('removeMousePointer');
    });
    $('#btn_save').hide();
    $('#btn_clear').hide();
    $('#btn_edit').hide();
    $('#btn_update').show();
    $('#btn_cancel').show();
}

function editBankDetailsFields(eleObj) {
    var tbl = $(eleObj).closest('table');
    tbl.find('input[type = text], input[type = file], select, textarea').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });
    $('#btn_edit').hide();
    $('#btn_update').show();
}
function clearAllfields(eleObj) {
    var tbl = $(eleObj).closest('table');
    tbl.find('input[type = text],input[type = date], input[type = file], select, textarea').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
        $(this).val('');
    });
    tbl.find('textarea').each(function() {
        $(this).html('');
    });
    $('#btn_update').hide();
    $('#btn_edit').hide();
    $('#btn_save').show();
    $('#btn_clear').show();
}
function showHideBtnOrForm(eleObj, hideShowDivID) {
    $(eleObj).closest('div').hide();
    $('#' + hideShowDivID).show();
}

function cancelDependentDetailsField(eleObj) {

}

//show button and enable input fields on click edit button 
function empEditPDBtn(tableID) {
    $('#btn_update').show();
    $('#btn_clear').show();
    $('#btn_edit').hide();
    //disabling all fields
    $('#' + tableID).find('input[type = text], input[type = date], input[type = file], input[type = radio]').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });

}

//show button and enable input fields on click cancel button  
function empCancelPDBtn(tableID) {
    $('#btn_update').hide();
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_clear').show();
    $('#btn_save').show();
    $('.messageDiv').hide();

    $('#empID').val(''); // set common emp ID to null
    //adding pointer event null to empployee tabs
    // $('#job_details, #address_details, #bank_details, #dependant_details').addClass('removeMousePointer');
    //disabling and reset value to null
    $('#' + tableID).find('input[type = text], input[type = date], input[type = file], input[type = radio]').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
        $(this).prop('value', '');
    });
    $('#' + tableID).find('input[type = radio]').each(function() {
        $(this).prop('checked', false);
    });

}

function clickOnChooseFile(elementID) {
    $(elementID).click();
}













// ---------employee create > person details module ends here----------------//







//-----------     end employee type js    ---------------//


function addFieldDynamic(eleObj, inputFieldName) {
    var lastTblTr = $(eleObj).closest('table').find('tr').last();
    lastTblTr.after('<tr>\n\
                        <td><input class="cmnWidth ' + inputFieldName + '" type="text" id="txt_emp_qualification" name="' + inputFieldName + '" onKeypress="return validationDigit(\'.' + inputFieldName + '\');"\n\
maxlength="10'+ inputFieldName + '" placeholder="e.g:9856012345"> </td>\n\
                        <td><input type="button" class="button blue"  value="-" onclick="removeTr(this);"/></td>\n\
                    </tr>');
}

function removeTr(eleObj) {
    $(eleObj).closest('tr').remove();
}

function empTypeChange(val) {
    var emp_type = val.substring(0, 1);
    if (emp_type == 'W') {
        $('.empWorkersField').show();
    }
    else {
        $('.empWorkersField').hide();
    }
}
function formResetWorker() {
    $('#empTypeWorkerTab').hide();
    $('#empTypeWorkerSalaryTab').hide();
    var formId = $('form').attr('id');
    var r = confirm("Are you sure to Reset all fields?");
    if (r === true) {
        document.getElementById(formId).reset();
        $('#' + formId).find('#profile-view').attr('src', '../bundles/Tashi/images/unk.jpg');
        return true;
    }
    else {
        return false;
    }
}
/**********************FROM ERP*************************/
function addEmployeeAttribute(id, fieldname)
{
    var name = "";
    switch (fieldname) {
        case "experience":
            name = 'txt_experience';
            break;
        case "qualification":
            name = 'txt_qualification';
            break;
    }
    $(id).parent().parent().after('<tr>' +
            '<td class="td-gray-bg"></td>' +
            '<td class="td-white-bg" colspan="3">' +
            '<input type="text" name="' + name + '">\n\
             </td>\n\
</tr>');
}

function employeeDetailsFrmSubmit(url) {
    $('.trMessage').hide();
    if ($('#txtEmpNo').val().trim() == '') {
        fnCmnWarningMessage('Employee Number cannot be empty.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#first_name').val().trim() == '') {
        fnCmnWarningMessage('First name cannot be empty.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#last_name').val().trim() == '') {
        fnCmnWarningMessage('Last name cannot be empty.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#dob').val().trim() == '') {
        fnCmnWarningMessage('Date of Birth cannot be empty.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#gender').val().trim() == '') {
        fnCmnWarningMessage('Gender cannot be empty.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#designation').val().trim() == '') {
        fnCmnWarningMessage('Designation cannot be empty.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#txtMobileNo').val().trim() == '') {
        fnCmnWarningMessage('Mobile Number cannot be empty.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#txtMobileNo').val().trim().length != 10) {
        fnCmnWarningMessage('Mobile Number must be 10 digit.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    var mobno = $('#txtMobileNo').val().trim();
    if (isNaN(mobno)) {
        fnCmnWarningMessage('Only Numbers are allowed in mobile number');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#txtEmail').val().trim() == '') {
        fnCmnWarningMessage('Email cannot be empty.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if (!isValidEmail($('#txtEmail').val().trim())) {
        fnCmnWarningMessage('Please enter a valid Email.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    var formData = new FormData($('#employeeAddForm')[0]);
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            $('#ajaxLoadPage').empty().append(response.html);
            fnCmnSuccessMessage(response.message);
            ScrollToCustMessage('divEmpmessage');
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToCustMessage('divEmpmessage');
        }
    });
}


function menuTabClick(id, appendId, url) {
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $("ul.nav_tabs li:last").hide();
                $(id).closest('ul').children('li').removeClass('active');
                $(id).addClass('active');
                $('.message').removeClass('error-box');
                $('.message').removeClass('warning');
                $('.message').removeClass('success');
                $('.trMessage').hide();
                $('#' + appendId).empty().append(response.html).trigger('datePicker');
            } else {
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToCustMessage('divEmpmessage');
        }
    });
}

function simpleEmptyAppend(appendId, url, selectId) {
    if (appendId == '' && url == '') {
        if ($('#' + selectId).val().trim() == '') {
            return;
        }
        url = $('#' + selectId).val().split('&')[0];
        appendId = $('#' + selectId).val().split('&')[1];
        var action = $('#' + selectId).val().split('&')[2];
        if (action == 'del') {
            if (!confirm('Are you sure you want to delete this address?'))
                return false;
        }
    }
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                if (action == 'del') {
                    $('#' + appendId).empty().append(response.html);
                    fnCmnSuccessMessage('Address has been deleted successfully.');
                }
                else
                {
                    $('#' + appendId).empty().append(response.html).trigger('datePicker');
                    fnCmnRemoveGeneralClass();
                }
            } else {
                fnCmnWarningMessage(response.message);
                ScrollToCustMessage('divEmpmessage');
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToCustMessage('divEmpmessage');
        }
    });
}
function NewAddressForm() {
    if ($('#selectAddType').val().trim() == '') {
        $('.trMessage').hide();
        return;
    }
    var url = $('#selectAddType').val();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#addNewAddress').empty().append(response.html);
                $('.trMessage').hide();
            } else {
                fnCmnWarningMessage(response.message);
                ScrollToCustMessage('divEmpmessage');
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToCustMessage('divEmpmessage');
        }
    });
}
function employeeAddressInsrt(appendId, url, frmId) {
    $('.trMessge').hide();
    if ($('#address1').val().trim() == '') {
        fnCmnWarningMessage('Address1 cannot be empty.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#country').val().trim() == '') {
        fnCmnWarningMessage('Select a country.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#state').val().trim() == '') {
        fnCmnWarningMessage('Select a state.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#district').val().trim() == '') {
        fnCmnWarningMessage('Select a district.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    if ($('#zipcode').val().trim() == '') {
        fnCmnWarningMessage('Enter Postal Code.');
        ScrollToCustMessage('divEmpmessage');
        return;
    }
    var form = $('form#' + frmId).serializeObject();
    /* convert the JSON object into string */
    var dataString = JSON.stringify(form);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            if(response.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (response.success) {
                $('#' + appendId).empty().append(response.html).trigger('datePicker');
                fnCmnSuccessMessage('Address has been saved successfully');
                ScrollToCustMessage('divEmpmessage');
            } else {
                fnCmnWarningMessage(response.message);
                ScrollToCustMessage('divEmpmessage');
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToCustMessage('divEmpmessage');
        }
    });
}

function searchGoAction(obj, appendId) {
    var id = $(obj).parent().find('select').val();
    var url = $('#actionUrl').val();
    var option = id.split('+');
    var append = {
        "mode": option[0],
        "personId": option[1]
    };
    var dataString = JSON.stringify(append);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#' + appendId).empty().append(response.html);
                fnCmnRemoveGeneralClass();
            } else {
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToCustMessage('divEmpmessage');
        }
    });

}

function enableDisabled(id) {
    $(id).closest('form').find('input,select').each(function() {
        $(this).prop('disabled', false);
        $(this).prop('class', '');
    });
    $('#edtButton').show();
    $(id).hide();
}

function ScrollToCustMessage(divmessageId) {
    document.getElementById(divmessageId).scrollIntoView(true);
}

function onCancleClick(formId) {
    document.getElementById(formId).reset();
    $('#btn_save').prop('value', 'Save');
    $('#btn_cancel').hide();
    $('#btn_clear').show();
}
