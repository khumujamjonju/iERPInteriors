function fnAddAttribute(targetTblID, attrNameID){
    var attr_name = $('#'+attrNameID+' option:selected').text();
    var attr_value = $('#'+attrNameID).val();
    var rowCount = parseInt($('#'+targetTblID+' tr').length + 1);  
    $('#'+targetTblID+' tr').last().before('<tr class="attribute'+rowCount+'">\n\
                                              <td class="td-white-bg">'+ attr_name +'</td>\n\
                                              <td class="td-white-bg" align="center"><div class="delete" onclick="removeAttributeTr('+ rowCount +');"></div></td>\n\
                                         </tr>');   
}


function ResetAll(elemObj) {
    $('.messageDiv').hide();
    var tbl = $(elemObj).closest('table');
    tbl.find('input[type = text], select, textarea').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');
    });
    
}

function removeAttributeTr(attrTrClass){ 
    $('#attribute_list').find("tr.attribute"+attrTrClass).remove();  
}
//javascript sections mainly for supplier master

function loadSupDetails(url) { //removeMousePointer
                
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
                $('.application-form').empty().append(result.html);    
                //adding pointer event null to empployee tabs
//                $('#Supplier_address, #Supplier_mobile, #Supplier_Bank_Detail').addClass('removeMousePointer');
                stopLoading();
                $('#btn_add_another').hide();
                $('#btn_update').hide(); 
                $('#btn_cancel').show();
                $('#btn_clear').hide();
            }
            else {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('Error in Class file or Controller:');
        }
    });
} 


function loadSupDetailsforEdit(url) { //removeMousePointer
                
    var formData = $('form#frmPurchaseSupplier').serializeObject();
    var addData={ 'supid':  $('#supplierID').val()};
    var dataString = JSON.stringify($.extend(formData,addData));
    
   
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result) {
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) 
            {
                $('#EditArea').empty().append(result.html);
                $('#Supplier_address, #Supplier_mobile, #Supplier_Bank_Detail').removeClass('removeMousePointer');
                $('#btn_add_another').hide();
                $('#btn_update').show(); 
                $('#btn_save').hide(); 
                $('#btn_cancel').show();
                $('#btn_clear').hide();
            }
            else {
               $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('Error in Class file or Controller:');
        }
    });
} 


function addsupplier(url, formID,elementObj)
{  
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('input[name~="txt_pur_companyname"]').val().trim()==''){
        commonMessageAlert('Supplier name is Mandatory!');
        return false;
    }
    if(tbl.find('input[name~="txt_sup_codename"]').val().trim()==''){
        commonMessageAlert('Supplier Code is Mandatory!');
        return false;
    }
    if(tbl.find('input[name~="txt_Registration"]').val().trim()==''){
        commonMessageAlert('Registration No Field is Mandatory!');
        return false;
    }
    if(tbl.find('input[name~="txt_pur_firstname"]').val().trim()==''){
        commonMessageAlert('First name is Mandatory!');
        return false;
    } 
     
    if(tbl.find('input[name~="txt_pur_lastname"]').val().trim()==''){
        commonMessageAlert('Last name is Mandatory!');
        return false;
    }
     
     
     
//    if(tbl.find('textarea[name~="txt_permAddress"]').val().trim()==''){
//        commonMessageAlert('Permanant address is Mandatory!');
//        return false;
//    }
//    if(tbl.find('input[name~="txt_pin"]').val().trim()==''){
//        commonMessageAlert('Pin No is Mandatory!');
//        return false;
//    }
//    if(tbl.find('input[name~="txt_mobile"]').val().trim()==''){
//        commonMessageAlert('Mobile No is Mandatory!');
//        return false;
//    }
//    if (isNaN(tbl.find('input[name~="txt_mobile"]').val()))
//    {
//        commonMessageAlert("Enter a valid Mobile Number like 9856012345");
//        return false;
//    }
//    var mobile=tbl.find('input[name~="txt_mobile"]').val();
//    if(mobile.length !==10)
//    {
//        commonMessageAlert(" Your Mobile Number must be 10 digit no");
//        return false;
//    }
//    
//    if(tbl.find('input[name~="txt_alternateno"]').val().trim()=='')
//    {
//         
//    }
//    else
//        {
//            if (isNaN(tbl.find('input[name~="txt_alternateno"]').val()))
//        {
//            commonMessageAlert("Enter a valid Mobile Number like 9856012345");
//            return false;
//        }
//        var mobile1 = tbl.find('input[name~="txt_alternateno"]').val();
//        if (mobile1.length !== 10)
//        {
//            commonMessageAlert(" Your Mobile Number must be 10 digit no");
//            return false;
//        }
//            
//        }
        
    $('.messageDiv').hide(); 
     if($('#txt_logo').val().trim()!=''){
        var fileInput=document.getElementById('txt_logo');
        var filename=fileInput.files[0].name;
        var validFiles=['jpg','jpeg','png','gif','bmp'];
        var extSplit = filename.split('.');
        var extReverse = extSplit.reverse();
        var ext = extReverse[0];        
        var fsizeMb=fileInput.files[0].size/1024/1024;
        var isValid=false;
        for(var i=0;i<validFiles.length;i++){
            if(ext.toLowerCase()==validFiles[i]){
                isValid=true;
                break;
            }
        }
        if(fsizeMb%2>=1){
            fnCmnWarningMessage('File size exceeds maximum uploadable size. Recommended size is upto 512Kb.');
            $('#txt_logo').focus();
            scrollToMessage();
            return;
        }        
        else if(!isValid){
            fnCmnWarningMessage('The image file you have chosen is invalid.');
            $('#txt_logo').focus();
            scrollToMessage();
            return;
        }
    }
    
    startLoading();
    var formData = new FormData($('#'+formID)[0]);
    
    $.ajax({            
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (result){ 
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){ 
               stopLoading(); 
               $('.messageDiv').show();  
                    $('#supplierID').val(result.jsonData.supplier_id);
                   // $('#SupplierURLid').val(result.jsonData.supplierUpdateURL); 
                                         
                    $('.message').empty().removeClass('warning').addClass('alert-box').addClass('success');
                    $('.message').append('<span>Success: </span>' + result.message);
                    $('#Supplier_address, #Supplier_mobile, #Supplier_Bank_Detail').removeClass('removeMousePointer');   
                   // for hide show buttons and diables
                    $('#'+tableID).find('input[type = text],textarea, input[type = date], input[type = file], input[type = radio]').each(function(){
                    $(this).prop('disabled', true).addClass('inputDisable_bg');               
                    });
                    
                    $('#btn_add_another').show();
                    $('#btn_save').hide(); 
                    $('#btn_clear').show();
                    $('#btn_update ').hide();
                    
                }
                else{
                     $('.messageDiv').show();  
                     stopLoading();
                     $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });   
}


function addsupplierMobileNo(url,elementObj)
{  
    var tbl = $(elementObj).closest('table');  
    
    if($('#txt_email').val()!='' && !isValidEmail($('#txt_email').val())){
        fnCmnWarningMessage("Please enter a valid Email id!");
        scrollToMessage();
        $('#txt_email').focus();        
        return;
    }
    
    if(tbl.find('input[name~="txt_supplier_mobile"]').val().trim()==''){
        commonMessageAlert('Mobile No field is mandatory!');
        return false;
    }
    if (isNaN(tbl.find('input[name~="txt_supplier_mobile"]').val()))
    {
        commonMessageAlert("Enter a valid Mobile Number like 9856012345");
        return false;
    }
    var mobile=tbl.find('input[name~="txt_supplier_mobile"]').val();
    if(mobile.length !==10)
    {
        commonMessageAlert(" Your Mobile Number must be 10 digit only");
        return false;
    }
    
    if(tbl.find('input[name~="txt_supplier_phone"]').val().trim()=='')
    {
        
    }
    else
        {
            if (isNaN(tbl.find('input[name~="txt_supplier_phone"]').val()))
            {
                commonMessageAlert("Enter a valid Phone Number like 0385244011");
                return false;
            }
            var mobile=tbl.find('input[name~="txt_supplier_phone"]').val();
            if(mobile.length !==10)
            {
                commonMessageAlert(" Your Phone Number must be 10 digit only");
                return false;
            }
        }
    
    
    
    
    
    
    
   
    $('.messageDiv').hide(); 
    var formData = $('form#frmSupplierContactMaster').serializeObject();
    var addData={ 'supid':$('#supplierID').val()};
    var dataString = JSON.stringify($.extend(formData,addData));
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){ 
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
             if(result.success){  
                   switch(result.jsonData)
                    {
                        case 0:
                            fnCmnWarningMessage(result.message);
                            break;
                            
                        case 1:
                            $('#display-list').empty().append(result.html); 
                            $('.messageDiv').show();                       
                                fnCmnSuccessMessage(result.message);
                                paginationTbl();  
                                 //for hide show buttons and diables
                                tbl.find('input[type = text]').each(function(){
                                $(this).prop('disabled', true).addClass('inputDisable_bg');               
                            });
                    
                            $('#btn_add_another').show();
                            $('#btn_save').hide(); 
                            $('#btn_clear').show();
                            break;
                        
                    }
                }
                else{
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });   
}

function AddnewsupplierMobileMaster(tableID)
{   //for hide show buttons and diables
    $('#' + tableID).find('input[type = text]').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg'); 
        $(this).val('');
    });
    
     
    
    
    $('.messageDiv').hide();      
    $('#btn_save').show();
    $('#btn_add_another').hide();
    $('#btn_clear').show();
}           
 
 
function RetriveMobileNo(url)
{  
    
    $('.messageDiv').hide();  
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            success: function (result){
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){  
                    
                   $('#mobiledetails').empty().append(result.html);
                   $('#displaymobilelist').empty().append(result.secondHtml);
                   $('#displaymobilelist').show(); 
                   $('#txt_supplier_phone').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.telephone);
                   $('#txt_email').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.email);
                   $('#txt_website').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.website);
                   //for hide show buttons and diables                   
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide(); 
                    $('#btn_cancel').show();
                   
                }
                else{
                     $('.messageDiv').show();                       
                     $('.message').empty().addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });
} 

function EnableEditsupplierMobileNoOnly(inputclassname)
{  
    //for hide show buttons and diables
    $('.messageDiv').hide();
    $('.'+inputclassname).prop('disabled',false).removeClass('disable_bg');
    $('.'+inputclassname).prop('disabled',false);
    $('#btn_save').hide();
    $('#btn_add_another').hide();
    $('#btn_clear').show();
   
}



function Updatemobileonly(url,elementObj,pkid)
{  
    var tbl = $(elementObj).closest('table');

   var mobile = document.getElementById('mobile_list'+pkid).value;
   if(mobile.length !==10)
            {
                commonMessageAlert(" Your mobile number must be 10 digit only");
                return false;
            }
    
    $('.messageDiv').hide();
    var formData = $('form#form_mobile_details_list').serializeObject();
    var addData={ 'supid':  $('#supplierID').val()};
    var dataString = JSON.stringify($.extend(formData,addData));
    
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){  
                    $('.messageDiv').show();                       
                    fnCmnSuccessMessage(result.message);
                    $('#display-list').empty().append(result.html);
                    paginationTbl();
                    scrollToMessage();
                 }
                else{
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                     scrollToMessage();
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        }); 
     
   
}

function Deletemobileonly(url,elementObj)
{  
    var tbl = $(elementObj).closest('table');  
    $('.messageDiv').hide();
    var formData = $('form#form_mobile_details_list').serializeObject();
    var addData={ 'supid':  $('#supplierID').val()};
    var dataString = JSON.stringify($.extend(formData,addData));
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){ 
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success)
                {  
                    $('.messageDiv').show();  
                    $(elementObj).closest('tr').remove();  
                    fnCmnSuccessMessage(result.message);
                  
                   
                }
                else
                {
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        }); 
     
   
}

function EnableEditTransportMobileNoOnly(inputclassname)
{  
    //for hide show buttons and diables
    $('.messageDiv').hide();
    $('.'+inputclassname).prop('disabled',false).removeClass('disable_bg');
    $('.'+inputclassname).prop('disabled',false);
    //$('#btn_save').hide();
    //$('#btn_add_another').hide();
   //$('#btn_clear').show();
   
}

function UpdateTransportmobileonly(url,elementObj,pkid)
{  
    var tbl = $(elementObj).closest('table');

   var mobile = document.getElementById('mobile_list'+pkid).value;
   if(mobile.length !==10)
            {
                commonMessageAlert(" Your mobile number must be 10 digit only");
                return false;
            }
    
    $('.messageDiv').hide();
    var formData = $('form#frmTransportor').serializeObject();
    var addData={ 'tranportid':  $('#transportId').val()};
    var dataString = JSON.stringify($.extend(formData,addData));
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){  
                    $('.messageDiv').show();                       
                    fnCmnSuccessMessage(result.message);
                    scrollToMessage();
                 }
                else{
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                     scrollToMessage();
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        }); 
     
   
}

function DeleteTransportmobileonly(url,elementObj)
{  
    var tbl = $(elementObj).closest('table');  
    $('.messageDiv').hide();
    var formData = $('form#frmTransportor').serializeObject();
    var addData={ 'id':  $('#transportId').val()};
    var dataString = JSON.stringify($.extend(formData,addData));
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){ 
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success)
                {  
                    $('.messageDiv').show();  
                    $(elementObj).closest('tr').remove();  
                    fnCmnSuccessMessage(result.message);
                  
                   
                }
                else
                {
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        }); 
     
   
}


function UpdatesupplierMaster(url,formID,elementObj)
{   
    var tbl = $(elementObj).closest('table');  
    
     if(tbl.find('input[name~="txt_pur_companyname"]').val().trim()==''){
        commonMessageAlert('Company name is Mandatory!');
        return false;
    } 
    if(tbl.find('input[name~="txt_pur_firstname"]').val().trim()==''){
        commonMessageAlert('First name is Mandatory!');
        return false;
    } 
   
    if(tbl.find('input[name~="txt_pur_lastname"]').val().trim()==''){
        commonMessageAlert('Last name is Mandatory!');
        return false;
    }
   
       
     if(tbl.find('input[name~="txt_Registration"]').val().trim()==''){
        commonMessageAlert('Registration No Field is Mandatory!');
        return false;
    }
    
    
    $('.messageDiv').hide();
    
    if($('#txt_logo').val().trim()!=''){
        var fileInput=document.getElementById('txt_logo');
        var filename=fileInput.files[0].name;
        var validFiles=['jpg','jpeg','png','gif','bmp'];
        var extSplit = filename.split('.');
        var extReverse = extSplit.reverse();
        var ext = extReverse[0];        
        var fsizeMb=fileInput.files[0].size/1024/1024;
        var isValid=false;
        for(var i=0;i<validFiles.length;i++){
            if(ext.toLowerCase()==validFiles[i]){
                isValid=true;
                break;
            }
        }
        if(fsizeMb%2>=1){
            fnCmnWarningMessage('File size exceeds maximum uploadable size. Recommended size is upto 512Kb.');
            $('#txt_logo').focus();
            scrollToMessage();
            return;
        }        
        else if(!isValid){
            fnCmnWarningMessage('The image file you have chosen is invalid.');
            $('#txt_logo').focus();
            scrollToMessage();
            return;
        }
    }
    
    startLoading();
    var formData = new FormData($('#'+formID)[0]);
   
  
    $.ajax({            
            type: 'POST',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (result){
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){  
                    
                    $('#supID').val(result.jsonData.supplier_id);
                    $('.messageDiv').show();                       
                    fnCmnSuccessMessage(result.message);
                    
                       
                    //for hide show buttons and diables
                   // $('#'+tableID).find('input[type = text],textarea[type="text"] , input[type = date], input[type = file], input[type = radio]').each(function(){
                   // $(this).prop('disabled', true).addClass('inputDisable_bg');               
               // });
                    $('#btn_add_another').hide();
                    $('#btn_save').hide(); 
                    $('#btn_cancel').show();
                }
                else{
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });   
}


function AddnewsupplierMaster(tableID)
{   //for hide show buttons and diables
    $('#' + tableID).find('input[type = text],textarea , input[type = date], input[type = file], input[type = radio]').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg'); 
        $(this).val('');
    })
    
     $('#' + tableID).find('input[type = radio]').each(function() {
        $(this).prop('checked', false);
    })
    $('#' + tableID).find('textarea').each(function() {
        $(this).html('');
    })
    
    $('.messageDiv').hide();      
    $('#btn_save').show();
    $('#btn_add_another').hide();
    $('#btn_clear').show();
    $('#btn_update').hide();
}           
                    

function addnewsupplierBankDetails(url,elementObj)
{  
    
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('input[name~="txt_bank_name"]').val().trim()==''){
        commonMessageAlert('Bank Name is mandatory!');
        scrollToMessage();
        return false;
    }
    if(tbl.find('input[name~="txt_branch"]').val().trim()==''){
        commonMessageAlert('Branch name is mandatory!');
        scrollToMessage();
        return false;
    }
    if(tbl.find('input[name~="txt_branchcode"]').val().trim()==''){
        commonMessageAlert('Branch code is mandatory!');
        scrollToMessage();
        return false;
    }
    if(tbl.find('input[name~="txt_accountno"]').val().trim()==''){
        commonMessageAlert('Account no is mandatory!');
        scrollToMessage();
        return false;
    }
    if(tbl.find('select[name~="account_type"]').val().trim()==''){
        commonMessageAlert('Please select account Type!');
        scrollToMessage();
        return false;
    }   
    if(tbl.find('input[name~="txt_contact"]').val().trim()==''){
        commonMessageAlert('Contact number is mandatory!');
        scrollToMessage();
        return false;
    }
    var mobile=tbl.find('input[name~="txt_contact"]').val();
    if(mobile.length!==10)
    {
        commonMessageAlert(" Your Contact Number must be 10 digit only");
        scrollToMessage();
        return false;
    }
    $('.messageDiv').hide(); 
    var formData = $('form#frmPurchaseSupplierBankDetail').serializeObject();
    var addData={ 'supid':  $('#supplierID').val()};
    var dataString = JSON.stringify($.extend(formData,addData));
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    $('.messageDiv').show();            
                    
                    fnCmnSuccessMessage(result.message);
                    //fnCmnSuccessMessage(result.message);
                    paginationTbl(); 
                    //for hide show buttons and diables
                    $(tbl).find('input[type = text],textarea, select').each(function(){
                    $(this).prop('disabled', true).addClass('inputDisable_bg');  
                    }); 
                    scrollToMessage();
                    $('#btn_save').hide();  
                    $('#btn_clear').hide();
                }
                else{
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                     scrollToMessage();
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });   
}

function UpdatebanksupplierBankDetails(url,elementObj)
{  
    
   var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="txt_bank_name"]').val()==''){
        commonMessageAlert('Bank name is mandatory!');
        scrollToMessage();return false;
    }
    if(tbl.find('input[name~="txt_branch"]').val().trim()==''){
        commonMessageAlert('Branch name is mandatory!');
        scrollToMessage();return false;
    }
    if(tbl.find('input[name~="txt_branchcode"]').val().trim()==''){
        commonMessageAlert('Branch code is mandatory!');
        scrollToMessage();return false;
    }
    if(tbl.find('select[name~="account_type"]').val()==''){
        commonMessageAlert('Please select account Type!');
        scrollToMessage();return false;
    }
    if(tbl.find('input[name~="txt_accountno"]').val().trim()==''){
        commonMessageAlert('Account no is mandatory!');
        scrollToMessage();return false;
    }
    
    if(tbl.find('input[name~="txt_contact"]').val().trim()==''){
        commonMessageAlert('Contact number can\'t be null !');
        scrollToMessage();return false;
    }
     
    
    var mobile=tbl.find('input[name~="txt_contact"]').val();
    if(mobile.length!==10)
    {
        commonMessageAlert(" Your Mobile Number must be 10 digit no");
        scrollToMessage();return false;
    }
    $('.messageDiv').hide(); 
    var formData = $('form#frmPurchaseSupplierBankDetail').serializeObject();
    var addData={ 'supid':  $('#supplierID').val()};
    var addID={'bid':$('#bankID').val()};
    var dataString = JSON.stringify($.extend(formData,addData,addID));
  
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    $('#bankformdetails').empty().append(result.secondHtml);  
                    $('.messageDiv').show(); 
                    
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); scrollToMessage();
                    $('#btn_newSave').show(); 
                    $('#btn_save').show(); 
                    $('#btn_update').hide(); 
                    $('#btn_clear').show();
                   
                }
                else{
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });   
}

function RetriveSupBankDetails(url)
{  
    
    $('.messageDiv').hide();  
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            success: function (result){
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){ 
                   $('#bankformdetails').empty().append(result.html);
                   
                   $('#bankID').val(result.jsonData.bankid);
                   $('#txt_Name_Of_The_Bank').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.name);
                   $('#txt_Branch_Name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.branch);
                   $('#txt_branchcode').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.branch_code);
                   $('#txt_accountno').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.account_no);
                   $('#ddlb_account_type_list').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.account_type);
                   $('#txt_micr').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.micr);
                   $('#txt_ifsc').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.ifsc);
                   $('#txt_Contact_Number').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.contact);
                   $('#location').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.location);
                    //for hide show buttons and diables                   
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide(); 
                    $('#btn_cancel').hide();
                    $('#btn_update').show();
                   
                }
                else{
                     $('.messageDiv').show();                       
                     $('.message').empty().addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });
} 

function UpdatesupplierMobileDetails(url,elementObj)
{  
   
    var tbl = $(elementObj).closest('table');  
    if($('#txt_email').val()!='' && !isValidEmail($('#txt_email').val().trim())){
        fnCmnWarningMessage("Please enter a valid Email id!");
        scrollToMessage();
        $('#txt_email').focus();        
        return;
    }
    $('.messageDiv').hide(); 
    var formData = $('form#frmSupplierContactMaster').serializeObject();
    var addData={ 'supid':  $('#supplierID').val()};
    var dataString = JSON.stringify($.extend(formData,addData));
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    $('.messageDiv').show();                       
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); 
                    
                    
                    //for hide show buttons and diables
//                    $(tbl).find('input[type = text],textarea, select').each(function(){
//                    $(this).prop('disabled', true).addClass('inputDisable_bg');               
//                    }); 
                    
                    $('#btn_newSave').show(); 
                    $('#btn_save').hide(); 
                    $('#btn_clear').show();
                   
                }
                else{
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ alert('Error in Class file or Controller:');}
        });   
}  
  
//searching supplier list details
function searchOrCreateSupplier(url){
    $('.messageDiv').hide();
    var formData = $('form#frmSearchSupplier').serializeObject();
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
                $('.messageDiv').show();
                //fnCmnSuccessMessage(result.message);
                paginationTbl(); //for paging table
                stopLoading();
            }
            else {
                $('.messageDiv').show();
                fnCmnErrorMessage(result.message);
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('Error in Class file or Controller:');
        }
    });
}

function ViewSupplier(url){
    
    $('.messageDiv').hide();
    var formData = $('form#frmSearchSupplier').serializeObject();
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
                //$('#display-list').empty().append(result.html);
                $('.messageDiv').show();
                stopLoading();
            }
            else {
                $('.messageDiv').show();
                fnCmnErrorMessage(result.message);
                stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('Error in Class file or Controller:');
        }
    });
}
//from erp
function SearchForSupplier() {
    $('.messageDiv').hide();
    $('#EditArea').empty();
    var url=$('#inputsearchUrl').val();
    startLoading();
    var CreateCus = $('form#customerSearchForm').serializeObject();
    var dataString = JSON.stringify(CreateCus);   /* convert the JSON object into string */
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        data: dataString, 
        dataType: 'json',
        success: function(response) {
            var isSuccess = response.success;
            var message = response.message;
            if (isSuccess) {
                var rtnHtml = response.html;
                //fnCmnSuccessMessage(message);
                $('#idforDisplay').empty().append(rtnHtml);
                paginationTbl2();
                $('#EditArea').empty();
                stopLoading();
            }
            else 
            {   stopLoading();
                fnCmnWarningMessage('No result found!');
                $('#idforDisplay').empty();
                scrolltoMessage();
               
                
            }           
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrolltoMessage();
                stopLoading();
        }
    });
}

function loadEditSupPage(mobtxn)
{    
    
    var selValue = $('#prodtype' + mobtxn).val();
    if(selValue==''){
        return;
    }
    var url=selValue.split('&')[0];
    var action=selValue.split('&')[1];
    
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected supplier?'))
            return;
    }
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
               if(result.success){
                    if(action=='edt'){
                        lmsShowHideAddressResult('SearchCustomer');
                        lmsShowHideAddressResult('SearchCustomerResult');
                        $('#EditArea').empty().append(result.html);
                        $('#supplierID').val(mobtxn);
                        $('#updateID').val(mobtxn);
                        $('#btn_save').hide();
                        $('#btn_clear').hide();
                        stopLoading();
                    }
                    else if(action=='del'){
                        
                        stopLoading();
                        fnCmnSuccessMessage(result.message);
                        
                    }
                    stopLoading();
           }
           else{
                 fnCmnWarningMessage(result.message);
                 stopLoading();
                 scrolltoMessage();
               }
           },
           error: function() {
               fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
               stopLoading();
                 scrolltoMessage();
           }
       });
}
//supplier searching ends here

//delete js code for supllier details
function deleteSupplierBankDetails(url,elementObj)
{   
    if(confirm('Are you sure to delete record?'))
    {
    var tbl = $(elementObj).closest('table');  
    $('.messageDiv').hide();
    var formData = $('form#frmPurchaseSupplierBankDetail').serializeObject();
    var addData={ 'supid':  $('#supplierID').val()};
    var addID={'bid':$('#bankID').val()};
    var dataString = JSON.stringify($.extend(formData,addData,addID));
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
              if(result.success)
                {    
                    $('#display-list').empty().append(result.html);  
                    $('.messageDiv').show();  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); 
                    $('#btn_newSave').show(); 
                    $('#btn_save').hide(); 
                    $('#btn_clear').show();
                }
                else
                {
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });   
}
else
    {
      return false;  
    }
}
function deleteSupplierContactDetails(url,elementObj)
{   if(confirm('Are you sure to delete record?'))
    {
   
    var tbl = $(elementObj).closest('table');  
    $('.messageDiv').hide();
    var formData = $('form#frmPurchaseSupplierBankDetail').serializeObject();
    var addData={ 'supid':  $('#supplierID').val()};
    
    var dataString = JSON.stringify($.extend(formData,addData));
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){ 
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
              if(result.success)
                {    
                    $('#display-list').empty().append(result.html);  
                    $('#mobiledetails').empty().append(result.secondHtml); 
                    $('.messageDiv').show();  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); 
                    $('#btn_newSave').show(); 
                    $('#btn_save').hide(); 
                    $('#btn_clear').show();
                }
                else
                {
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                } 
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });   
            }
            else
                {return false;}
               
}


//delete js code ends here
//address section 

function LoadSaveAddressType(url)
{
   
    $('.messageDiv').hide();
   // var selValue = $('#selectAddType'+typeIdentifierForAddress).val();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.success)
            {
                $('#addNewAddress').empty().append(result.html);
                scrollToMessage();
                stopLoading();
            }
            else
            {
                 fnCmnWarningMessage('failed');
                 scrollToMessage();
                 stopLoading();
            }
        },
        error: function()
        {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            stopLoading();
            scrollToMessage();
        }
    });
}

/* uses by
 *          customer_address.html.twig
 */
function addnewSaveAddressDetails() {
   $('.trMessage').hide();
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
    if ($('#seldistrict').val().trim() === '') {       
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
    }
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
    url = $('#urlCreateAddress').val();
    $formId = 'frmCreateAddress';
    $('#sameAsTb').hide();
    var formData = $('form#frmCreateAddress').serializeObject();
    var addData={ 'supid':  $('#supplierID').val()};
    
    var dataString = JSON.stringify($.extend(formData,addData));

    $.ajax({
        type: 'POST',
        url: url,
        contentType: false,
        processData: false,
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
                $('#newListAddress_GroupId').empty();
                $('#newListAddress_GroupId').append(rtnHtml).trigger('datePicker').focus();
                $('#address_result').empty().append(rtnHtml);
                $('#addNewAddress').empty();
                $('#btnClear').hide();
                fnCmnSuccessMessage(message);
           }
             else {
               fnCmnWarningMessage(message);
               
            }
            scrollToMessage();
         },
        error: function() {
           
        }
    });
}

function FnViewCimAddress(selectId)
{
    $('.messageDiv').hide();
    if($('#'+selectId).val().trim()==''){
        return;
    }
    var mode=$('#'+selectId).val().split('&')[1];
    if(mode=='del'){
        if(!confirm('Are you sure you want to delete this Address?'))
            return false;
    }
    var url = $('#'+selectId).val().split('&')[0];
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){ 
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
            }
            if (result.success)
            {
                if(mode=='del'){
                    $('#newListAddress_GroupId').empty();
                    $('#newListAddress_GroupId').append(result.html).trigger('datePicker').focus();
                    $('#addNewAddress').empty();
                    fnCmnSuccessMessage(result.message);
                    scrollToMessage();
                }
                else{
                    $('#addNewAddress').empty().append(result.html);                
                }
            }
            else
            {
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error: function()
        {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function newtoggleIsPrimaryAdd(value){
   
    $('#inputisPrimaryAdd').val(value);
}

function LoadSaveBankForm(url)
{
   
    $('.messageDiv').hide();
   // var selValue = $('#selectAddType'+typeIdentifierForAddress).val();
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
            if (result.success)
            {
                $('#bankformdetails').empty().append(result.html);
                $('#btn_update').hide();
                $('#btn_clear').hide();
                lmsShowHideAddressResult('BankDetailsList');
            }
            else
            {
                 fnCmnWarningMessage('failed');
            }
        },
        error: function()
        {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
        }
    });
}

function LoadSaveMobileForm(url)
{
   
    $('.messageDiv').hide();
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
            if (result.success)
            {
                $('#mobiledetails').empty().append(result.html);
                $('#btn_update').hide();
                $('#btn_clear').hide();
                $('#btn_clear').hide();
            }
            else
            {
                 fnCmnWarningMessage('failed');
            }
        },
        error: function()
        {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
        }
    });
}

function CreateTransport(url, elementObj)
{
     if ($('#txt_transport').val().trim() === '') {
        fnCmnWarningMessage("Transport Name is mandatory");
        scrollToMessage();
        $('#txt_transport').focus();
        return;
    }
    if ($('#txt_description').val().trim() === '') {
        fnCmnWarningMessage("Description is mandatory");
        scrollToMessage();
        $('#txt_description').focus();
        return;
    }
    $('.trMessage').hide();
    var formData = $('form#SaveTransport').serializeObject();
   
    var dataString = JSON.stringify(formData);
    $.ajax({
        type: 'POST',
        url: url,
        contentType: false,
        processData: false,
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
                $('#EditAreadisplay').empty().append(response.html);
                fnCmnSuccessMessage(message);
           }
             else {
               fnCmnWarningMessage(message);
            }
            scrollToMessage();
         },
        error: function() { }
    });
    
}

function RetriveTransport(url)
{  
    
    $('.messageDiv').hide();  
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            success: function (result){ 
               if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){  
                    
                   $('#txt_transport').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.trasn);
                   $('#txt_description').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.descrp);
                   $('#transID').val(result.jsonData.id);
                    //for hide show buttons and diables                   
                   $('#btn_save').hide(); 
                   $('#btn_update').show(); 
                   $('#btn_cancel').show();
                   
                }
                else{
                      fnCmnWarningMessage(result.message);
                }
                stopLoading();
                scrollToMessage();
           },
            error: function(){ }
        });
} 

function UpdateTransportMaster(url,elementObj)
{   
   if ($('#txt_transport').val().trim() === '') {
        fnCmnWarningMessage("Transport Name is mandatory");
        scrollToMessage();
        $('#txt_transport').focus();
        return;
    }
    $('.messageDiv').hide();
    var formData = $('form#SaveTransport').serializeObject();
    var addData={ 'tid':  $('#transID').val()};
    var dataString = JSON.stringify($.extend(formData,addData));
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){ 
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){  
                   
                    $('#EditAreadisplay').empty().append(result.html);
                    $('.messageDiv').show();                       
                    fnCmnSuccessMessage(result.message);
                    $('#btn_save').hide(); 
                    paginationTbl();  
                }
                else{
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ }
        });   
}

function DeleteTransport(url)
{  
   if(confirm('Are you sure to delete record?'))
    {
    
    
    
    
    $('.messageDiv').hide();  
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            success: function (result){ 
               if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){  
                    
                    $('#EditAreadisplay').empty().append(result.html);
                    $('.messageDiv').show();                       
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); 
                   
                }
                else{
                      fnCmnWarningMessage(result.message);
                }
                stopLoading();
                scrollToMessage();
           },
            error: function(){ }
        });
    }
    else
        {
            return false;  
        }
} 

function SearchForSupplierCommunication() {
    
    $('.messageDiv').hide();
    $('#commmunicationArea').empty();
    var url=$('#inputsearchUrl').val();
    var CreateCus = $('form#supplierCommunicationSearchForm').serializeObject();
    var dataString = JSON.stringify(CreateCus);/* convert the JSON object into string */
    
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
                $('#idforDisplay').empty().append(rtnHtml);
                $('#idforDisplay').append('<div class="clear"></div>');
                paginationTbl2();
                $('#commmunicationArea').empty();
            }
            else 
            {
                fnCmnWarningMessage(message);
                $('#idforDisplay').empty();
            }            
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
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

function toggleMainNOCheckComm(mainChkId)
{
    var mainChk=document.getElementById(mainChkId);
    var allChks=document.getElementsByClassName('selchkcomm');
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
            document.getElementById('inputisselected'+i).value='1';
            counter+=1;
        }
        else{
            document.getElementById('inputisselected'+i).value='0';
        }
    }
    txtSelected.value=counter;
}
function CommunicateCheck(){
    $('.trMessage').hide();
    if($("#selCommType").val().trim()===''){
        fnCmnWarningMessage('Please select a Communication type');
        scrollToMessage();
        return;
    }
    var totalSelected= parseInt(document.getElementById('txtTotalSelected').value);
   
    if(totalSelected<=0){
        fnCmnWarningMessage('You must select alteast one supplier to communicate');
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
                scrolltoMessage();
                return;
            }
        }
    }
    startLoading();
    var frmdata=$('form#supplierCommunicationSearchForm').serializeObject();
    var dataString=JSON.stringify(frmdata);
    
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
            if (response.success) {
                $('#commmunicationArea').empty().append(response.html);
                scrollToMessage();
                stopLoading();
            }
            else 
            {
                fnCmnWarningMessage(response.message);   
                $('#commmunicationArea').empty();
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



function SendCOMSMS(url){
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
    var frmdata=$('form#supplierCommunicationSearchForm').serializeObject();
    var dataString=JSON.stringify(frmdata);
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
            if (response.success) {
                //$('#divcomCommunication').empty().append(response.html);
                fnCmnSuccessMessage(response.message); 
                scrollToMessage();
                $('#txtSubject').val('');  
                $('#txtSmsMessage').val('');
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

function SendSupplierEmail(url){
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
    startLoading();
    var frmdata=$('form#supplierCommunicationSearchForm').serializeObject();
    var dataString=JSON.stringify(frmdata);
   
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
            if (response.success){
                fnCmnSuccessMessage(response.message); 
                scrollToMessage();
                stopLoading();
            }
            else{
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


function ViewCommunicationHistory(selactionId,Id){
    $('.messageDiv').hide();
    if($('#'+selactionId).val().trim()==''){
        return;
    }
    if($('#'+Id).val().trim()==''){
        return;
    }
     
    var url=$('#'+selactionId).val();
    
    var id={ 'mid':  $('#'+Id).val()};
    var dataString=JSON.stringify(id);
    
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json',  
        data:dataString,
        dataType: 'json',
        
        success: function(response) {
            if(response.jsonData=='AD'){
                    AccessDenied(response.html);
                    return;
                }
            if (response.success) {
                lmsShowHideAddressResult('SearchCustomerResult');
                $('#commmunicationArea').empty().append(response.html);
                stopLoading();
            }
            else 
            {
                fnCmnWarningMessage(response.message);   
                $('#commmunicationArea').empty();
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

function checkSupDetails(empPkid){
    if($(empPkid).val().trim()==''){
        fnCmnWarningMessage('Please save supplier details first !');
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }else{
        return true;
    }
}

function addUpdateTransportorMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var transport_name = tbl.find('input[name~="transport_name"]');
    if (transport_name.val().trim()=='') {
        transport_name.focus();
        commonMessageAlert('transportor Name is mandatory!');
        return false;
    }
   if (tbl.find('input[name~="contactperson"]').val().trim()=='') {
        commonMessageAlert('contact person is mandatory!');
        return false;
    }
    
    if ($('#transportId').val().trim()=='')
    {
        if (tbl.find('input[name~="txt_mobile"]').val().trim()=='') {
            commonMessageAlert('mobile no is mandatory!');
            return false;
        }
    }

    
    
    
    
    
    if (tbl.find('textarea[name~="address"]').val().trim()=='') {
        commonMessageAlert('address field is mandatory!');
        return false;
    }
    if (tbl.find('input[name~="pincode"]').val().trim()=='') {
        commonMessageAlert('pincode is mandatory!');
        return false;
    }
    $('.messageDiv').hide();
    var formData = $('form#frmTransportor').serializeObject();
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
                $('#frmTransportor').trigger("reset");
                $('#btn_save').prop('value', 'Save');
                $('#btn_clear').hide();
                $('#btn_cancel').show();
                $('#myvalue').empty();
                stopLoading();
            }
            else {
                fnCmnErrorMessage(result.message);
                stopLoading();
            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}

function retrieveTransport(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                
                $('#myvalue').empty().append(result.html);
                $('#transport_name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.transport_name);
                $('#transport_address').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.address);
                $('#transportId').val(result.jsonData.transportId);
                $('#pincode').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.pincode);
                $('#contactperson').val(result.jsonData.person);
                $('#transport_about').val(result.jsonData.about);
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
            alert('Error in Class file or Controller.');
        }
    });
}

function deleteTransport(url, subModuleName, formId)
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
            alert('Error in Class file or Controller:');
        }
    });
}





