/* 
 * Javascritp for asset master
 */
function TabToggleAssetAssign(TabId, menuId1, menuId2)
{
    if (TabId == 'ShowAssEmpList') {
        $('#tblAssetAssignedEmpAfterSearch').show();
        $('#assignAsset2').hide();
        $('#assTbl').hide();
        $('#tblAssetListBycate').hide();
        $('#' + menuId1).addClass('active');
        $('#' + menuId2).removeClass('active');
    }
    else if (TabId == 'HideAssEmpList') {
        $('#tblAssetAssignedEmpAfterSearch').hide();
        $('#assignAsset2').show();
        $('#' + menuId1).removeClass('active');
        $('#' + menuId2).addClass('active');
    }

}


//----------------------delete portions-----------------//

function deleteAssetRegisterMaster(url, $tableID)
{
    var formId = $('form#frmAssetRegister').attr('id');
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
                    AccessDenied();
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl(); //for pagination
                document.getElementById(formId).reset();
                $('#assetStatusTbl').hide();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}

function deleteAssetCategoryMaster(url)
{
    var formId = $('form#frmAssetCategory').attr('id');
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
                    AccessDenied();
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl(); //for pagination

                document.getElementById(formId).reset();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}
//----------------------delete portions ends-----------------//
//left menu nevigation
function fnLeftNNMenuNavigation(url, menuId, navId1, navId2) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {

                // $('#inner-sub-menu').empty().append(result.html).trigger('datePicker');
                $('#AssetStatusDisplaySearch').hide();
                $('#displayAsset').show();
                $('#assignedAssetDisplaySearch').show();
                $('#submenutr .sub-menu ul li').addClass('active');
                $('#' + menuId).addClass('active');
                $('#navMenuPath3').text('');
                $('#navMenuPath1').text(navId1);
                $('#navMenuPath2').text('> ' + navId2 + ' >');
                paginationTbl();
                $("html,body").animate({scrollTop: 0}, 0);
                stopLoading();
            }
            else {
                stopLoading();
                $('.messageDiv').show();
                $('.message').empty().addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
                //stopLoading();
                $("html,body").animate({scrollTop: 0}, 0);
            }

        },
        error: function() {
            fnCmnErrorMessage('An unknown technical error was encountered. Please try later');
        }
    });
}

//sub menu nevigation 
function fnSubNNMenuNavigation(url, menuId, navId1, navId2, navId3) {
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#assetRegister').empty().append(result.html);
                //$('.application-form').empty().append(result.html).trigger('datePicker');
                // $('#inner-sub-menu').empty().append(result.html).trigger('datePicker');
                $('#AssetStatusDisplaySearch').show();
                $('#assignedAssetDisplaySearch').hide();

                $('#submenutr .sub-menu ul li').removeClass('active');
                $('#' + menuId).addClass('active');
                $('#navMenuPath1').text(navId1);
                $('#navMenuPath2').text('> ' + navId2);
                $('#navMenuPath3').text(' ' + navId3);
                paginationTbl();
                stopLoading();
                $("html,body").animate({scrollTop: 0}, 0);
            }
            else {
                fnCmnErrorMessage(result.message);
                stopLoading();
                $("html,body").animate({scrollTop: 0}, 0);
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
        }
    });
}

////inner sub menu nevigation 
//function fnInnerSubMenuNavigation(url,menuId, cmnID){ 
//    $('.messageDiv').hide(); 
//    var loadID = {'loadID': $('#'+cmnID).val() };      
//    startLoading();
//    $.ajax({            
//            type: 'POST',
//            url: url,
//            data: loadID,
//            dataType:'json',         
//            success: function (result){ 
//               if(result.success){    
//                    $('.right-inner-sub-content').empty().append(result.html);                  
//                    $('#inner-sub-menu .sub-menu ul li').removeClass('active');
//                    $('#'+menuId).addClass('active');                  
//                     paginationTbl();
//                     stopLoading();
//                     $("html,body").animate({scrollTop: 0}, 0);
//                }
//                else{
//                     $('.messageDiv').show();                       
//                     $('.message').empty().addClass('alert-box').addClass('error-box');
//                     $('.message').append('<span>Error: </span>' + result.message);
//                     stopLoading();
//                     $("html,body").animate({scrollTop: 0}, 0);
//                }
//           },
//            error: function(){ alert('Error in Class file or Controller:');}
//        });   
//}
//-----------------------------------

function toggleSearchAssetCriteria(selid) {
    var sel = document.getElementById(selid);
    $('#trcriteria').show();
    $('#selProjCategory').hide();
    $('#txtCriteria').hide();
    $('#txtdate').hide();
    $('#divDate').hide();
    $('#selProjStatus').hide();
    //$('#tbodyDynamic').empty();
    $('#tdtitle').text('Criteria');
    switch (sel.value) {
        case 'all':
            $('#trcriteria').hide();
            break;
        case 'ordno':
            document.getElementById('txtCriteria').placeholder = 'Enter Project ID/Order Number';
            $('#txtCriteria').show();
            break;
        case 'cname':
            document.getElementById('txtCriteria').placeholder = 'Enter Customer Name';
            $('#txtCriteria').show();
            break;
        case 'ename':
            document.getElementById('txtCriteria').placeholder = 'Enter Site Coordinator Name/ID';
            $('#txtCriteria').show();
            break;
        case 'cat':
            $('#selProjCategory').show();
            break;
        case 'date':
            $('#divDate').show();
            break;
        case 'status':
            $('#selProjStatus').show();
            break;
        default:
            $('#tdtitle').empty();
            break;
    }
}


function SearchAsset() {
    $('.messageDiv').hide();
    switch ($('#selSearchProjCriteria').val()) {

        case 'cat':
            if ($('#selProjCategory').val().trim()=='') {
                fnCmnWarningMessage('Select Asset Category!!!');
                $('#selProjCategory').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'date':
            if ($('#assetname').val().trim()=='') {
                fnCmnWarningMessage('Enter Asset Name or Id!!!');
                $('#assetname').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'status':
            if ($('#selProjStatus').val().trim()=='') {
                fnCmnWarningMessage('Select Asset Status!!!');
                $('#selProjStatus').focus();
                scrollToMessage();
                return;
            }
            break;
    }
    startLoading();
    var url = $('#inputsearchprojectUrl').val();
    var frmData = $('form#frmAssetSearch').serializeObject();
    var dataString = JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                stopLoading();
                $('#divProjectList').empty().append(result.html);
                paginationTbl();
            }
            else {
                $('#divProjectList').empty();
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}

function SearchEmpAsset() {
    $('.messageDiv').hide();
    switch ($('#selSearchProjCriteria').val()) {

        case 'cat':
            if ($('#selProjCategory').val().trim()=='') {
                fnCmnWarningMessage('Select Asset Category!!!');
                $('#selProjCategory').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'date':
            if ($('#assetname').val().trim()=='') {
                fnCmnWarningMessage('Enter Asset Name or Id!!!');
                $('#assetname').focus();
                scrollToMessage();
                return;
            }
            break;
    }
    startLoading();
    var url = $('#inputsearchprojectUrl').val();
    var frmData = $('form#frmAssetEmpSearch').serializeObject();
    var dataString = JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                stopLoading();
                $('#divProjectList').empty().append(result.html);
                paginationTbl();
            }
            else {
                $('#divProjectList').empty();
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}





function UpdateAssetStatus(url) {
    $('.messageDiv').hide();
    if ($('#selItemStatus').val().trim()=='') {
        fnCmnWarningMessage('Select Item Status');
        $('#selItemStatus').focus();
        scrollToMessage();
        return;
    }
    if ($('#selItemStatus').val() == $('#inputcurritemstatus').val()) {
        fnCmnWarningMessage('Project is already in \'' + $("#selItemStatus :selected").text() + '\' status');
        $('#selItemStatus').focus();
        scrollToMessage();
        return;
    }
//    if ($('#txtstatusDate').val().trim()=='') {
//        fnCmnWarningMessage('Select status date');
//        $('#txtstatusDate').focus();
//        scrollToMessage();
//        return;
//    }
    if ($('#txtRemarks').val().trim()=='') {
        fnCmnWarningMessage('Enter few words in remark field');
        $('#txtRemarks').focus();
        scrollToMessage();
        return;
    }
    startLoading();
    var frmData = $('form#ProjectForm').serializeObject();
    var dataString = JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#divItemDetail').empty().append(result.html);
                scrollToMessage();
            } else {
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function searchAssetByName(url) {

    $('.messageDiv').hide();
    var formData = $('form#frmassignassetaftersearch').serializeObject();
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
                $('.afterCheckAsset').hide();
                $('#assetList').show();
                $('#assetList').empty().append(result.html);
                paginationTbl2(); //for paging table
            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}
function selectedCheckBox(assetid, assetCatId) {

    $('#assetId').val(assetid);

    $('#assetcategoryId').val(assetCatId);

}

//---------------date 30-apr-2015------------------------//
function displayAssetAccToSelCategory(url, val)
{

    $('.messageDiv').hide();
    startLoading();

    $.ajax({
        type: 'POST',
        url: url,
        data: {'AssCategoryId': val},
        dataType: 'json',
        success: function(result) {
            if (result.success) {

                $('#assetList').show();
                $('#assetList').empty().append(result.html);
                paginationTbl2(); //for pagination
            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}

//------------------------------------------------------------//


function deleteAssetAssignMaster(url, $tableID)
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
            if (result.success) {
                $('#display-list').empty().append(result.html);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl3();
                $('#tblAssetAssignedEmp').show();
                $('#TblEmpListAfterSearch').hide();
                $('#assignAsset2').hide();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}




function saveAssetAssignMaster(url, elementObj)
{
//    var tbl = $(elementObj).closest('table');
//    var checkAsset = document.getElementsByName(checkAsset)
//    if (checkAsset.val().trim()=='') {
//        checkAsset.focus();
//        commonMessageAlert('Please select the click box to Assign !');
//        return false;
//    }
    
    var Assetcheck=document.getElementsByName('checkAsset');
    
    var isSelected=false;
    for(var i=0;i<Assetcheck.length;i++){
        if(Assetcheck[i].checked){
            isSelected=true;
            break;
        }
    }
    if(!isSelected){
        fnCmnWarningMessage('You have not selected any Asset item(s).');
        scrollToMessage();
        return;
    } 
    
    $('.messageDiv').hide();
    var formData = $('form#frmAssignAsset').serializeObject();
    var dataString = JSON.stringify(formData);
    // alert(dataString);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                $('#tblAssetAssignedEmpAfterSearch').empty().append(result.html);
                $('#AssignedAssAftrSrchId').val(result.jsonData.AssignedAssAftrSrchId);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl(); //for pagination

                //for hide show buttons and diables

                $('#txt_start_date').prop('disabled', true).addClass('inputDisable_bg');
                $('#txt_end_date').prop('disabled', true).addClass('inputDisable_bg');
                $('#save').hide();
                $('#btn_cancel').show();

                $('#frmAssignAsset').hide();
                $('#frmAssignAssetByName').hide();
                //$('#AfterSearchAssignbutton').hide();
                $('#tblAssetAssignedEmpAfterSearch').show();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}

function retriveAssetAssignMaster(url)
{

    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#assetcategoryIn').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetcategory);
                $('#assetList').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetList);
                $('#txt_start_date').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.start_date);
                $('#txt_end_date').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.end_date);
                $('#AssignedAssAftrSrchId').val(result.jsonData.assetAssignPk);
                //for hide show buttons and diables                   
                $('#save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').hide();
                $('#btn_update').show();
                $('#btn_cancel').show();
                $('#HideafterCheckAsset').show();
                $('#ShowafterCheckAsset').show();
                $('#assignAsset2').show();
                // paginationTbl3(); 
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}


//---------------------assign asset ends----------------------------//
function assignAssetToEmployeeSearch(url)
{
    //  alert(url); exit();
    $('.messageDiv').hide();

    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        contentType: 'application/json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                //alert(result.success);
                $('#divAssetEmpindex').empty().append(result.html);
                $('#divAssetEmpDetail').empty().append(result.secondHtml);
                paginationTbl2(); //for pagination
            }

            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}


//show button and enable input fields on click edit button
function assetEdit(tableID) {
    $('#btn_update').show();
    $('#btn_clear').show();
    $('#btn_edit').hide();
    $('#save').hide();
    $('#assetStatusTbl').show();

    $('#' + tableID).find('textarea,select,input[type = text], input[type = date], input[type = file], input[type = radio]').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });

}

//show button and enable input fields on click edit button
function AsetEditBtn(eleObj) {
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    tbl.find('input[type = text], input[type = date], input[type = file],select, textarea').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });
    $('#btn_save').hide();
    $('#btn_update').show();
    $('#btn_clear').show();
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
}

//show button and enable input fields on click cancel button 
function assetCancel(tableID, inputId) {
    $('.messageDiv').hide();
    $('#btn_update').hide();
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_clear').show();
    $('#btn_save').show();
    $('#save').show();
    $('#assetStatusTbl').hide();
    $('#' + inputId).val('');
    $('.messageDiv').hide();
    $('#' + tableID).find('textarea,select,input[type = text], input[type = date], input[type = file], input[type = radio]').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');
    });
    $('#profile-view').attr('src', '/TASHI/web/bundles/common/images/unk.jpg');

}
/* 
 * Javascritp for asset master
 */
//---------------date 30-apr-2015------------------------//
function displayAssetAccToSelCategory(url, val)
{
    //alert('ok js asset');
    $('.messageDiv').hide();
    startLoading();

    $.ajax({
        type: 'POST',
        url: url,
        data: {'AssCategoryId': val},
        dataType: 'json',
        success: function(result) {
            if (result.success) {

                $('#assetList').show();
                $('#assetList').empty().append(result.html);
                $('.messageDiv').show();
                $('.message').empty().addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}

//------------------------------------------------------------//

//---------------------assign asset ends----------------------------//

/**********This javascript section is mainly for Saving store Master Record Entry 
 twig file->(.html.twig,.html)********************/



function saveAssetCategoryMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var catName = tbl.find('input[name~="assetcategory"]');
    var catDes = tbl.find('textarea[name~="assetcategorydescription"]');
    if (catName.val().trim()=='') {
        catName.focus();
        commonMessageAlert(' Category Field can\'t be Blank !');
        return false;
    }
    if (catDes.val().trim()=='') {
        catDes.focus();
        commonMessageAlert('Category Description Field can\'t be Blank !');
        return false;
    }
    $('.messageDiv').hide();
    var formData = $('form#frmAssetCategory').serializeObject();
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
                $('#display-list').empty().append(result.html);
                $('#AssetCategoryId').val(result.jsonData.AssetCategoryId);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl(); //for pagination

                //for hide show buttons and diables
                $('#assetcategory').prop('disabled', true).addClass('inputDisable_bg');
                $('#assetcategorydescription').prop('disabled', true).addClass('inputDisable_bg');
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_update').hide();
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
            alert('Error in Class file or Controller:');
        }
    });
}

function retriveAssetCategoryMaster(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#assetcategory').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetName);
                $('#assetcategorydescription').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetDescription);
                $('#AssetCategoryId').val(result.jsonData.ACid);

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
            alert('Error in Class file or Controller:');
        }
    });
}

/**********This javascript section is mainly for Saving asset Master Register Entry 
 twig file->(.html.twig,.html)********************/

function saveAssetRegisterMaster(url, elementObj, tableID)
{
    var tbl = $(elementObj).closest('table');
    if (tbl.find('select[name~="assetCategory"]').val().trim()=='') {
        commonMessageAlert('Asset Category Field must be Selected !');
        return false;
    }
    if (tbl.find('input[name~="assetname"]').val().trim()=='') {
        commonMessageAlert('Asset Name Field can\'t be Blank !');
        return false;
    }
    if (tbl.find('input[name~="txt_asset_locatioin"]').val().trim()=='') {
        commonMessageAlert('Location Field can\'t be Blank !');
        return false;
    }
    $('.messageDiv').hide();
    var formData = new FormData($('#frmAssetRegister')[0]);
//    var formData = $('form#frmAssetRegister').serializeObject();
//    var dataString = JSON.stringify(formData);
    // alert(dataString);
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
                    AccessDenied();
                    return;
                }
            if (result.success) {
                $('#display-list').empty().append(result.html);
                $('#assetRegisterId').val(result.jsonData.assetRegisterId);
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                $('.message').append('<span>Success: </span>' + result.message);
                paginationTbl(); //for pagination

                //for hide show buttons and diables
                $('#' + tableID).find('textarea,select,input[type = text], input[type = date], input[type = file], input[type = radio]').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg');
                });
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_update').hide();
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
            alert('Error in Class file or Controller:');
        }
    });
}

function retriveAssetRegisterMaster(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
//                alert(result.jsonData.assetPicture);
                $('#assetCategory').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.categoryId);
                $('#assetname').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetName);
                $('#assetmaker').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetmaker);
                $('#txt_asset_modelno').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetmodelno);
                $('#txt_asset_expiry').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetexpiry);
                $('#txt_asset_waranty').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetwaranty);
                $('#txt_asset_supplier').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetsupplier);
                $('#txt_asset_po_no').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetpono);
                $('#txt_asset_location').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetlocation);
                $('#txt_asset_description').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetdescription);
                $('#asset_prod_serial').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assProductSerial);
                $('#txt_asset_Manuf_date').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assManufDate);
                $('#txt_asset_BarCode').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assBarCode);
                $('#txt_asset_purPrice').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assPurchasePrice);
                $('#txt_asset_purDate').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetPurchaseDate);
                // $('#emp_pro_pic').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetPicture);
                $('#profile-view').attr('src', '/TASHI/web/' + result.jsonData.assetPicture);

                $('#assetRegisterId').val(result.jsonData.ARid);
                //$('#assetStatusTbl').show();
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
            alert('Error in Class file or Controller:');
        }
    });
}

function retriveAssetDetailIndexMaster(url)
{

    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {

                $('#assetCategory').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.categoryId);
                $('#assetname').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetName);
                $('#assetmaker').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetmaker);
                $('#txt_asset_modelno').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetmodelno);
                $('#txt_asset_expiry').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetexpiry);
                $('#txt_asset_waranty').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetwaranty);
                $('#txt_asset_supplier').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetsupplier);
                $('#txt_asset_po_no').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetpono);
                $('#txt_asset_location').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetlocation);
                $('#txt_asset_description').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetdescription);


                $('#asset_prod_serial').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assProductSerial);
                $('#txt_asset_Manuf_date').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assManufDate);
                $('#txt_asset_BarCode').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assBarCode);
                $('#txt_asset_purPrice').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assPurchasePrice);
                $('#txt_asset_purDate').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetPurchaseDate);

                $('#assetRegisterId').val(result.jsonData.ARid);
                $('#assetStatusTbl').show();
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
            alert('Error in Class file or Controller:');
        }
    });
}
function ViewAssetDetail(assetId) {
    //  alert(url); exit();
    $('.messageDiv').hide();
    if ($('#selaction' + assetId).val().trim()=='') {
        return;
    }

    var url = $('#selaction' + assetId).val();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
             if(result.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if (result.success) {
                stopLoading();

                $('#inputassetId').val(assetId);
                $('#divAssetindex').empty().append(result.html);
                $('#divAssetDetail').empty().append(result.secondHtml);
            }
            else {
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
        }
    });
}

function assignAssetIndexDetail(assetId)
{
    //  alert(url); exit();
    $('.messageDiv').hide();
    if ($('#selaction' + assetId).val().trim()=='') {
        return;
    }
    var url = $('#selaction' + assetId).val();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        contentType: 'application/json',
        success: function(result) {
            if (result.success) {
                //alert(result.success);
                $('#divAssetindex').empty().append(result.html);
                $('#divAssetDetail').empty().append(result.secondHtml);
                // $('#assetRegister').empty().append(result.secondHtml);

                $('#assetCat').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.categoryId);
                $('#AssetName').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetName);
                $('#asset_maker').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetmaker);
                $('#txtassetmodelno').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetmodelno);
                $('#txt_asset_expiry').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetexpiry);
                $('#txt_asset_waranty').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetwaranty);
                $('#txt_asset_supplier').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetsupplier);
                $('#txtassetpono').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetpono);
                $('#txt_asset_location').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetlocation);
                $('#txt_asset_description').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetdescription);
                $('#assetprodserial').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assProductSerial);
                $('#txt_asset_Manuf_date').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assManufDate);
                $('#txtassetBarCode').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assBarCode);
                $('#txt_asset_purPrice').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assPurchasePrice);
                $('#txt_asset_purDate').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.assetPurchaseDate);
                $('#assetRegister').val(result.jsonData.ARid);
            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}

function AssetNavigation(menuid, url) {
    $('.messageDiv').hide();
    if (url == '') {
        return;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                stopLoading();
                $('#divAssetDetail').empty().append(result.html);
                $('ul#tabs li').removeClass('active');
                $('#' + menuid).addClass('active');
                // paginationTbl2();    
                document.getElementById('divTabs').scrollIntoView();
            }
            else {
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error: function() {
            fnCmnErrorMessage('An unknown technical error was encountered. Please try later');
            stopLoading();
            scrollToMessage();
        }
    });
}

function AssetEmpNavigation(menuid, url) {
    $('.messageDiv').hide();
    if (url == '') {
        return;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                stopLoading();
                $('#tblAssetAssignedEmpAfterSearch').empty().append(result.html);
                $('ul#tabs li').removeClass('active');
                $('#' + menuid).addClass('active');
                // paginationTbl2();    
                document.getElementById('divTabs').scrollIntoView();
            }
            else {
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error: function() {
            fnCmnErrorMessage('An unknown technical error was encountered. Please try later');
            stopLoading();
            scrollToMessage();
        }
    });
}