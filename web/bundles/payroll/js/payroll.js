//shop pop up modal form
function showPopUpForm(elementId, url){
// Load dialog on page load 
//$('#basic-modal-content').modal();
//$('<div></div>').load('page.html').modal(); // AJAX
//$.modal('<p><b>HTML</b> elements</p>'); // HTML
//$.modal(document.getElementById('basicModalContent')); // DOM
 startLoading();
$.ajax({
        type: 'POST',
        url: url,      
        dataType: 'json',
        success: function(result) {         
            if (result.success) {
                $(elementId).empty().append(result.html).modal();
                $('#simplemodal-container').show("explode",{pieces: 16}, 600);
                stopLoading();
		//return false;                      
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
               
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
}


function calculateBasicAndHra(grossVal, basicPcVal, hraPcVal, travelPc){   
    if(grossVal == ''){
        grossVal = 0;
        $('#basic_salary').val('');
        $('#hra').val('');
    }else{
        var basicPc = parseFloat(basicPcVal);
        var hraPc = parseFloat(hraPcVal);
        var gross = parseFloat(grossVal);

        //basic calculation
        var basic = parseFloat((basicPc/100) *  gross);
        $('#basic_salary').val(parseFloat(basic).toFixed(0));

        //hra calculation
        var hra = parseFloat((hraPcVal/100) *  basic);
        $('#hra').val(parseFloat(hra).toFixed(0));
        
        //travel calculation  travelPc
        
        var ta = parseFloat((travelPc/100) *  gross);
        $('#travelling_allowance').val(parseFloat(ta).toFixed(0));
    }
}

function saveBasicHraCalculation(eleObj,url) { 
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    var basic_cal_pc = tbl.find('input[name~="txt_basic_cal_pc"]');
    if(basic_cal_pc.val().trim()==''){     
       commonMessageAlert('Basic Calculation Percent(%) can\'t be empty !');
       fnCmnScrollToElementIDorClass('#wrapper');   
       basic_cal_pc.focus();
       return false;
    } 
    var hra_cal_pc = tbl.find('input[name~="txt_hra_cal_pc"]');
    if(hra_cal_pc.val().trim()==''){      
       commonMessageAlert('HRA Calculation Percent(%) can\'t be empty !');
       fnCmnScrollToElementIDorClass('#wrapper'); 
       hra_cal_pc.focus();
       return false;
    } 
    
    var applicable_date = tbl.find('input[name~="txt_date_of_use"]');
    if(applicable_date.val().trim()==''){     
       commonMessageAlert('Applicable Date On can\'t be empty !');
       fnCmnScrollToElementIDorClass('#wrapper'); 
       applicable_date.focus();
       return false;
    } 
    
    var formData = $('form#frmPayrollMaster').serializeObject();
    var dataString = JSON.stringify(formData);
     //alert(dataString); 
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
                switch(result.jsonData.existing_flag){
                    case 0: //if newly add ctive record
                            $('#display_list').empty().append(result.html);
                            $('#payrol_master_id').val(result.jsonData.payrolMasterID);
                            fnCmnSuccessMessage(result.message);
                            fnCmnScrollToElementIDorClass('#wrapper');  
                            paginationTbl();// for pagination   

                            //for hide show buttons and diables fields                  
                            tbl.find('input[type = text], input[type = date], select, textarea').each(function(){
                                $(this).prop('disabled', true).addClass('inputDisable_bg');               
                            });

                            $('#btn_edit').show();
                            $('#btn_cancel').show();
                            $('#btn_save').hide();
                            $('#btn_clear').hide();
                            $('#btn_update').hide();
                            break;
                   case 1: //if already exist active record
                            fnCmnWarningMessage(result.jsonData.msg);
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
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
}

function editPayrolMasterField(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    
     //for hide show buttons and diables fields                  
    tbl.find('input[type = text],input[type = date], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg');               
    });

    $('#btn_edit').hide();
    $('#btn_cancel').show();
    $('#btn_save').hide();
    $('#btn_clear').hide();
    $('#btn_update').show();
}

function cancelPayrolMasterField(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');    
     //for hide show buttons and diables fields                  
    tbl.find('input[type = text],input[type = date], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
    });
    
    $('#payrol_master_id').val('');
    $('#status').val(1);
    $('#status_field').hide();

    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_save').show();
    $('#btn_clear').show();
    $('#btn_update').hide();
}

function payrolMasterAction(eleObj, empID, actionID){ 
    $('.messageDiv').hide(); 
    
    var rawurl = $(actionID + empID).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete payrol calculation ?'))
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
                  switch(action){
                      case 'upd' :                         
                                   $('#payrol_master_id').val(result.jsonData.payrolMasterID);                              
                                   $('#basic_cal_pc').prop('disabled', false).prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.basic_cal_pc);
                                   $('#hra_cal_pc').prop('disabled', false).prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.hra_cal_pc);
                                   $('#status').prop('disabled', false).removeClass('inputDisable_bg').prop('disabled', false).val(result.jsonData.status);
                                   $('#status_field').show();
                                   $('#date_of_use').prop('disabled', false).removeClass('inputDisable_bg').prop('disabled', false).val(result.jsonData.date_of_use);
                                   $('#description').prop('disabled', false).removeClass('inputDisable_bg').val(result.jsonData.description);                                
                                   
                                   //buttons hide show
                                   $('#btn_edit').hide();
                                   $('#btn_cancel').show();
                                   $('#btn_save').hide();
                                   $('#btn_clear').hide();
                                   $('#btn_update').show();
                                   break;
                      case 'del' : 
                                   $(eleObj).closest('tr').remove();                          
                                   fnCmnSuccessMessage(result.message);
                                   fnCmnScrollToElementIDorClass('#wrapper');
                                                          
                                   var tbl = $('#payroll_master_form_tbl');  
                                   tbl.find('input[type = text],input[type = date], select, textarea').each(function(){
                                        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
                                   });

                                   $('#payrol_master_id').val('');
                                   $('#status').val(1);
                                   $('#status_field').hide();
                                   
                                    //buttons hide show
                                   $('#btn_edit').hide();
                                   $('#btn_cancel').hide();
                                   $('#btn_save').show();
                                   $('#btn_clear').show();
                                   $('#btn_update').hide();
                                  
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
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
}

function saveEmolumentDeductionMaster(eleObj, pageKey, url){ 
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    var emolument_or_deduction_name = tbl.find('input[name~="txt_emolument_or_deduction_name"]');
    var field_type = tbl.find('select[name~="txt_field_type"]');
    switch(pageKey){
        case 'normalForm':  
                            if(emolument_or_deduction_name.val().trim()==''){     
                               commonMessageAlert('Name(Emolument Or Deduction) can\'t be empty !');
                               fnCmnScrollToElementIDorClass('#wrapper');  
                               emolument_or_deduction_name.focus();
                               return false;
                            }  
    
                            if(field_type.val().trim()==''){     
                               commonMessageAlert('Please select a type !');
                               fnCmnScrollToElementIDorClass('#wrapper');  
                               field_type.focus();
                               return false;
                            }  
                            startLoading();
                            break;
        case 'popUpForm':   if(emolument_or_deduction_name.val().trim()==''){ 
                               fnCmnWarningMessage1('Name(Emolument Or Deduction) can\'t be empty !', '#popup_form_message');                                                       
                               emolument_or_deduction_name.focus();
                               return false;
                            }  
    
                            if(field_type.val().trim()==''){ 
                               fnCmnWarningMessage1('Please select a type !', '#popup_form_message');                                                         
                               field_type.focus();
                               return false;
                            }  
                            startAjaxLoaderFormPopUp('#popup_form_message');
                            break;
    }   
    var formData = $('form#frmEmolumentDeduction').serializeObject();
    var addData = { 'txt_page_key' : pageKey };
    var dataString = JSON.stringify($.extend(formData,addData));   
    // alert(dataString); 
    
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
                 switch(pageKey){
                     case 'normalForm':  
                                        $('#display_list').empty().append(result.html);
                                        $('#emolument_or_deduction_id').val(result.jsonData);
                                        fnCmnSuccessMessage(result.message);
                                        fnCmnScrollToElementIDorClass('#wrapper');  
                                        paginationTbl();// for pagination   

                                        //for hide show buttons and diables fields                  
                                       // tbl.find('input[type = text], select, textarea').each(function(){
                                           // $(this).prop('disabled', true).addClass('inputDisable_bg');               
                                       // });
                                       tbl.find('input[type = text], select, textarea').each(function(){
                                            $(this).val('');               
                                        });

                                       // $('#btn_edit').hide();
                                        $('#btn_cancel').show();
                                        $('#btn_save').hide();
                                        $('#btn_clear').hide();
                                        $('#btn_update').hide();
                                        break;
                     case 'popUpForm':
                                        switch(result.jsonData.addFieldType){
                                            case 'Emolument' :  $('#emolumentsFormTbl').find('tr').last().before(result.html);                                                              
                                                                break;
                                            case 'Deduction' :  $('#deductionsFormTbl').find('tr').last().before(result.html);
                                                                break;
                                         }
                                       fnCmnSuccessMessage1(result.message, '#popup_form_message');    
                                       //for hide show buttons and diables fields                  
                                        tbl.find('input[type = text], select, textarea').each(function(){
                                            $(this).val('');               
                                        });
                                       break;
                 }            
            }
            else {
                switch(pageKey){
                    case 'normalForm' :  fnCmnErrorMessage(result.message);
                                        fnCmnScrollToElementIDorClass('#wrapper');                                                              
                                        break;
                    case 'popUpForm' :  fnCmnErrorMessage1(result.message, '#popup_form_message');
                                        break;
                 }               
            }
             stopLoading();
             $('#ajax_loader_popup_form').hide();
        },
        error: function() {
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    }); 
    
}
function emolumentDeductionAction(eleObj, modeID, actionID){ 
    $('.messageDiv').hide(); 
    
    var rawurl = $(actionID + modeID).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete record ?'))
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
                  switch(action){
                      case 'upd' : $('#emolument_or_deduction_id').val(result.jsonData.emolument_or_deduction_id);
                                   $('#emolument_or_deduction_name').val(result.jsonData.emolument_or_deduction_name);
                                   $('#field_type').val(result.jsonData.attibute_type);
                                   $('#description').val(result.jsonData.description);                                 
                                   //buttons hide show
                                   $('#btn_edit').hide();
                                   $('#btn_cancel').show();
                                   $('#btn_save').hide();
                                   $('#btn_clear').hide();
                                   $('#btn_update').show();
                                   break;

                     case 'del' : $(eleObj).closest('tr').remove(); 
                        
                                   fnCmnSuccessMessage(result.message);
                                   fnCmnScrollToElementIDorClass('#wrapper');
                                    
                                   $('#emolument_or_deduction_id').val('');
                                   var tbl = $('#emolumentDeductionTbl');  
                                   tbl.find('input[type = text], select, textarea').each(function(){
                                        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
                                   });
                                   //buttons hide show
                                   $('#btn_edit').hide();
                                   $('#btn_cancel').hide();
                                   $('#btn_save').show();
                                   $('#btn_clear').show();
                                   $('#btn_update').hide();
                                  
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
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
}
function editEmolumentDeductionMasterField(eleObj){
    var tbl = $(eleObj).closest('table');  
    tbl.find('input[type = text], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg');               
    });
    $('#emolument_or_deduction_id').val('');
    $('#btn_edit').hide();
    $('#btn_cancel').show();
    $('#btn_save').hide();
    $('#btn_clear').hide();
    $('#btn_update').show();
}
function cancelEmolumentDeductionMasterField(eleObj){
    var tbl = $(eleObj).closest('table');  
    tbl.find('input[type = text], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
    });
    $('#emolument_or_deduction_id').val('');
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_save').show();
    $('#btn_clear').show();
    $('#btn_update').hide();
}


function savePaymentMode(eleObj, url){
   $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    var paymentMode = tbl.find('input[name~="txt_payment_mode"]');
    if(paymentMode.val().trim()==''){
       paymentMode.focus();
       commonMessageAlert('Mode Name can\'t be empty !');
       return false;
    }  
    
    var formData = $('form#frmPaymentMode').serializeObject();
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
                    AccessDenied(result.html);
                    return;
                }
           
            if (result.success) { 
                $('#display_list').empty().append(result.html);
                $('#payment_mode_id').val(result.jsonData);
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');  
                paginationTbl();// for pagination   
                 
                //for hide show buttons and diables fields                  
                tbl.find('input[type = text], textarea').each(function(){
                    $(this).prop('disabled', true).addClass('inputDisable_bg');               
                });

                $('#btn_edit').show();
                $('#btn_cancel').show();
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_update').hide();
              
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
               
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    }); 
    
}

function payrolModeAction(eleObj, modeID, actionID){ 
    $('.messageDiv').hide(); 
    
    var rawurl = $(actionID + modeID).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete payment mode ?'))
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
                  switch(action){
                      case 'upd' : $('#payment_mode_id').val(result.jsonData.paymentModeID);
                                   $('#payment_mode_name').val(result.jsonData.paymentModeName);
                                   $('#description').val(result.jsonData.description);                                 
                                   //buttons hide show
                                   $('#btn_edit').hide();
                                   $('#btn_cancel').show();
                                   $('#btn_save').hide();
                                   $('#btn_clear').hide();
                                   $('#btn_update').show();
                                   break;
                      case 'del' : $(eleObj).closest('tr').remove(); 
                        
                                    fnCmnSuccessMessage(result.message);
                                    fnCmnScrollToElementIDorClass('#wrapper');
                                    
                                   $('#payment_mode_id').val('');
                                   var tbl = $(eleObj).closest('table');  
                                   tbl.find('input[type = text], textarea').each(function(){
                                        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
                                    });
                                    //buttons hide show
                                    $('#btn_edit').hide();
                                    $('#btn_cancel').hide();
                                    $('#btn_save').show();
                                    $('#btn_clear').show();
                                    $('#btn_update').hide();
                                  
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
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
}

function editPaymentModeField(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');    
     //for hide show buttons and diables fields                  
    tbl.find('input[type = text], textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg');               
    });

    $('#btn_edit').hide();
    $('#btn_cancel').show();
    $('#btn_save').hide();
    $('#btn_clear').hide();
    $('#btn_update').show();
}

function cancelPamentModeField(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    $('#payment_mode_id').val('');
     //for hide show buttons and diables fields                  
    tbl.find('input[type = text], textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
    });
    
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_save').show();
    $('#btn_clear').show();
    $('#btn_update').hide();
}

function searchEmpSalarySlipDetails(eleObj, url){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    var month = tbl.find('select[name~="txt_month"]'); 
    if(month.val().trim()==''){
       month.focus();
       commonMessageAlert('please select Month!');
       return false;
    }  
    
    var formData = $('form#frmSearchEmployee').serializeObject();
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
           
            if (result.success) { 
                $('#search_emp_result').empty().append(result.html); 
                fnHideShow('emp_search_form');
                fnHideShow('emp_search_result_list');
               // fnCmnSuccessMessage(result.message);
              //  fnCmnScrollToElementIDorClass('#wrapper');  
                paginationTbl();// for pagination   
                              
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
               
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    }); 
}

function employeeSalarySlipAction(eleObj, empID, actionID){ 
    $('.messageDiv').hide(); 
    var rawurl = $(actionID + empID).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected employee ?'))
            return false;
    }
    var addData = { 'txt_month' : $('#monthID').val(), 
                    'txt_year' : $('#year').val(),
                    'key' : action
                  };
    var dataString = JSON.stringify(addData);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,  
        data: dataString,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) { 
                $('#salary_slip_form').empty().append(result.page);  
                $('#emolumentsFormTbl').find('tr').last().before(result.html);
                $('#deductionsFormTbl').find('tr').last().before(result.secondHtml);
                fnHideShow('emp_search_result_list');  

                //showing month year in employee salary slip
                var monthYear = $('#monthName').val() + ', ' + $('#year').val();
                $('#monthYear').html(monthYear);
                              
                if(result.jsonData.resultFlag == 1){   
                    $('#created_salary_slip_id').val(result.jsonData.salSlipID);                  
                    $('#earningTotal').val(result.jsonData.earningTotal);
                    $('#epf_amount').val(result.jsonData.epf);                   
                    $('#repaid_advance_amt').val(result.jsonData.deductionAdjustedAdvancePay);
                    $('#adjustment_wallet_bal').val(result.jsonData.deductionAdjustedWalletBal);
                    
                    //disable fields
                    $('#created_salary_form_tbl').find('.useField').each(function(){
                        $(this).prop('disabled', true).addClass('inputDisable_bg');  
                    });
                    $('.emolumentDeductionAddBtn').addClass('removeMousePointer');
                    $('#addNewEmolumentDeductionFieldTr').hide(); // hide add new emolument or deducion field
                    $('#btn_save').hide();
                    $('#btn_edit').show();
                    $('#btn_update').hide();
                    $('#btn_Sendmail').hide();
                    $('#btn_print').hide();
                }
                
                //show calculated net salary
                 fnCalculateNetSalary();
                
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
}



function viewSalarySlipDetails(url){
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,      
        dataType: 'json',
        success: function(result) {
            if (result.success) {           
                $('#salary_slip_detail').empty().append(result.html); 
                fnHideShow('approval_salary_slip');
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
}

function employeeSalarySlipApproveAction(eleObj, salarySlipID, monthName, monthID, year, actionID){ 
    $('.messageDiv').hide(); 
    var rawurl = $(actionID + salarySlipID).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0]; 
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected employee ?'))
            return false;
    }   
    var addData = { 'txt_month' : monthID, 
                    'txt_year' : year,
                    'key' : action
                  };
    var dataString = JSON.stringify(addData);
    startLoading();
    $.ajax({
        type: 'POST',
        url: url, 
        data: dataString,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {                   
                    $('#salary_slip_form').empty().append(result.page);  
                    $('#emolumentsFormTbl').find('tr').last().before(result.html);
                    $('#deductionsFormTbl').find('tr').last().before(result.secondHtml);
                    fnHideShow('approval_salary_slip');  

                    //showing month year in employee salary slip
                    var monthYear = monthName + ', ' + year;
                    $('#monthYear').html(monthYear);
                    
                    //set month and year to the hidden field  
                    $('#monthID').val(monthID);
                    $('#year').val(year);
                    
               
                
                    if(result.jsonData.resultFlag == 1){   
                        $('#created_salary_slip_id').val(result.jsonData.salSlipID);                  
                        $('#earningTotal').val(result.jsonData.earningTotal);
                        $('#epf_amount').val(result.jsonData.epf);                   
                        $('#repaid_advance_amt').val(result.jsonData.deductionAdjustedAdvancePay);
                        $('#adjustment_wallet_bal').val(result.jsonData.deductionAdjustedWalletBal);

                        //disable fields
                        $('#created_salary_form_tbl').find('.useField').each(function(){
                            $(this).prop('disabled', true).addClass('inputDisable_bg');  
                        });
                        $('.emolumentDeductionAddBtn').addClass('removeMousePointer');
                        $('#addNewEmolumentDeductionFieldTr').hide(); //hide add new emolument or deduction button
                        $('#btn_ok').show();
                        $('#btn_save').hide();
                        $('#btn_edit').show();
                        $('#btn_update').hide();                       
                        
                    }
                
                    //show calculated net salary
                     fnCalculateNetSalary();
                
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}

function editSalarySlipField(){
    $('#created_salary_form_tbl').find('.useField').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg');  
    });
    $('.emolumentDeductionAddBtn').removeClass('removeMousePointer');
    $('#addNewEmolumentDeductionFieldTr').show(); // hide add new emolument or deducion field
    $('#basic').addClass('inputDisable_bg');
    $('#hra').addClass('inputDisable_bg');
    $('#advance_amt').addClass('inputDisable_bg');
    $('#btn_save').hide();
    $('#btn_edit').hide();
    $('#btn_update').show();
}

function saveCreatedSalarySlip(eleObj, url){ 
    $('.messageDiv').hide(); 
    
    //validation
    //gross salary can't be blank
    var grossSalary = $('#empGrossSalary').val();
    if(grossSalary == ''){
       commonMessageAlert('Please add Gross Salary for this employee, from edit employee !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
    
    //gross salary can't be blank
    var earningTotal = parseInt($('#earningTotal').val()); 
    if(earningTotal < parseInt(grossSalary)){
       commonMessageAlert('Earning Salary can not be less than Gross Salary, please adjust !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }   
    var frm = $(eleObj).closest('form');  
    var formData = $('form#frmEmployeeSalSlip').serializeObject();
    var addData = { 'txt_month' : $('#monthID').val(),
                    'txt_year' : $('#year').val(),
                    'txt_page_type' : $('#pageType').val()
                  };
    var dataString = JSON.stringify($.extend(formData,addData));   
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,  
        data: dataString,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {   
                if(result.page == 'approvePage'){
                    $('#salarySlipInfo' + result.jsonData).empty().append(result.html);
                }
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper'); 
                $('#created_salary_slip_id').val(result.jsonData.salarySlipID);
                
                $('#created_salary_form_tbl').find('.useField').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg');
                });                                 
                $('.emolumentDeductionAddBtn').addClass('removeMousePointer');
                $('#addNewEmolumentDeductionFieldTr').hide(); // hide add new emolument or deducion field
                
                //pop up count alert               
                if(result.jsonData.pendingApprovalSalary > 0){
                    $('#countText').html(result.jsonData.pendingApprovalSalary);                  
                }else{
                    $('#countText').hide();
                }
                
                $('#btn_save').hide();
                $('#btn_update').hide();
                $('#btn_edit').show();
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}

function checkNoOfCheckBox(eleObj){
    var tbl = $(eleObj).closest('table');
    var checkFlag = 0;   
    tbl.find('.select_adv_pay').each(function(){       
        if($(this).prop('checked') == false){
            checkFlag = 1;
        }
    });
    if(checkFlag == 0){
        $('.checkAll').prop('checked', true);
    }else if(checkFlag == 1){
        $('.checkAll').prop('checked', false);       
    }
   
}

function cmnApprovedOrRejectSalarySlip(eleObj, url, key){
    $('.messageDiv').hide();
    var tbl = $('#approve_salary_slip_tbl');
    
    //check selected advance payment or not
    var checkflag = 0;
    //var breakOut;
    tbl.find('input[type = checkbox]').each(function(){
            if($(this).prop('checked') == true){
                checkflag = 1;
                //var salary_slip_pkid = $(this).val(); 
                //check description blank
//                if($('#description'+salary_slip_pkid).val() == ''){
//                    commonMessageAlert('Please give some description!');
//                    fnCmnScrollToElementIDorClass('#wrapper');
//                    $('#description'+salary_slip_pkid).focus();
//                    breakOut = true;
//                    return false;
//                }
            }               
     }); 
//     if (breakOut) {
//        breakOut = false;
//        return false;
//    }
    if(checkflag == 0){
       commonMessageAlert('Please select one of the salary slip !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    } 
    if(key == 'A'){
        var paymentAccount = tbl.find('select[name=txt_payment_account]');
        if(paymentAccount.val() == ''){
           commonMessageAlert('please select Payment Account !');
           fnCmnScrollToElementIDorClass('#wrapper');
           paymentAccount.focus();
           return false;
        }

        var enter_account_id = tbl.find('select[name=txt_enter_account_id]');
        if(enter_account_id.val().trim()==''){
           commonMessageAlert('Source Account must be select !');
           fnCmnScrollToElementIDorClass('#wrapper');
           enter_account_id.focus();
           return false;
        }        
    }
    
    var description = tbl.find('textarea[name=txt_description]');
    if(description.val() == ''){
       commonMessageAlert('Please give some description !');
       fnCmnScrollToElementIDorClass('#wrapper');
       description.focus();
       return false;
    }
    
    var salary_month = tbl.find('select[name=txt_salary_month]');
    if(salary_month.val() == ''){
       commonMessageAlert('Month must be select!');
       fnCmnScrollToElementIDorClass('#wrapper');
       salary_month.focus();
       return false;
    }
    var salary_year = tbl.find('input[name=txt_salary_year]');
    if(salary_year.val() == ''){
       commonMessageAlert('Year can\'t be blank!');
       fnCmnScrollToElementIDorClass('#wrapper');
       salary_year.focus();
       return false;
    }
    var approveOrRejectedDate = tbl.find('input[name~="txt_approved_or_rejected_date"]');
    if(approveOrRejectedDate.val().trim()==''){
       approveOrRejectedDate.focus();
       commonMessageAlert('Date can not be blank !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
    
    var alertMsg = '';
    switch(key){
        case 'A': alertMsg = 'Are you sure to approve selected salary slip ?';
                  break;
        case 'R': alertMsg = 'Are you sure to reject selected salary slip ?';
                  break;
    }
    if(!confirm(alertMsg)){
        return false;
    }
    var month = $('#month').val(); 
    var year = $('#year').val(); 
    var monthName = $('#monthName').val(); 
    var formData = $('form#frmApprovalSalarySlip').serializeObject();  
    var addData = { 'key' : key};
    var dataString = JSON.stringify($.extend(formData,addData));
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
                $('.approval_list').empty().append(result.html);   
                paginationTbl();// for pagination
                fnHideShow('approval_salary_slip'); 
                fnCmnSuccessMessage(result.message);
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}

function closeView(divID){
    $(divID).empty();
}

function checkAmount(currentEleID, amountID, key){  
    var currentAmtVal = $(currentEleID).val();
    var amountVal = $(amountID).val();
    if(parseFloat(currentAmtVal) > parseFloat(amountVal)){
        switch(key){
            case 'advance':             commonMessageAlert('Entry amount can\'t be greater than Current Due amount !');
                                        break;
            case 'adjustFromWallet':    commonMessageAlert('Entry amount can\'t be greater than Current balance amount !');
                                        break;
        }      
        fnCmnScrollToElementIDorClass('#wrapper');        
        var modifiedAmt = currentAmtVal.substring(0,currentAmtVal.length - 1);
        $(currentEleID).val(modifiedAmt);
        $(currentEleID).focus();
        fnCalculateNetSalary();
        return false;
    }
}

function fnCalculateNetSalary(){ 
    //check validation for  total deduction greater than total earning
//    var totalEarning = $('#earningTotal').val();
//    var totalDeduction = $('#deductionTotal').val();
//    if(parseFloat(totalDeduction) > parseFloat(totalEarning)){
//       commonMessageAlert('Total deduction amount can\'t be greater than total earnig,please adjust deduction !'); 
//       fnCmnScrollToElementIDorClass('#wrapper');
//       return false;
//    }
    
    //calculated total earning of employee 
    var earning_total = 0;
    $('#frmEmployeeSalSlip').find('.earning').each(function(){
        var element_input_val = $(this).val();
        if(element_input_val == ''){
            element_input_val = 0;
        }
        earning_total = parseFloat(earning_total + parseFloat(element_input_val));  
        $('.earningTotal').html(earning_total);
        $('#earningTotal').val(earning_total);
    });
    
    // calculated total deduction of employee 
    var deduction_total = 0;
    $('#frmEmployeeSalSlip').find('.deduction').each(function(){
        var element_input_val = $(this).val();
        if(element_input_val == ''){
            element_input_val = 0;
        }
        deduction_total = parseFloat(deduction_total + parseFloat(element_input_val));  
        $('.deductionTotal').html(deduction_total);
        $('#deductionTotal').val(deduction_total);
    });
          
    //calculate net salary 
    var deduction_totalNo = $('#deductionTotal').val(); //alert(deduction_totalNo);
    if(deduction_totalNo == ''){
        deduction_totalNo = 0;
    } 
    var net_salary = parseFloat($('#earningTotal').val()) - parseFloat(deduction_totalNo); 
    $('.net_salary').html(net_salary);
    $('#net_salary').val(net_salary);
}

function fnCalcullateDueAdvancePayment(eleObj){   
    //check due balance null
    var dueBal = $('#originalTotalDueAdvancePayment').val();
    if(dueBal == '' || dueBal == 0){
        commonMessageAlert('There is no due amount to repay !');
        fnCmnScrollToElementIDorClass('#wrapper');    
        $('#repaid_advance_amt').val('');
        fnCalculateNetSalary();
        return false;
    }
    var originalTotalDuePayment = $('#originalTotalDueAdvancePayment').val();
    var currentInputVal = $(eleObj).val();
    var currentDueAdvanceAmt = $('#originalTotalDueAdvancePayment').val(); 
    if(currentInputVal == ''){
       currentInputVal = 0;
    }   
    if(parseFloat(currentInputVal) > parseFloat(originalTotalDuePayment)){       
        commonMessageAlert('Entry amount can\'t be greater than Current Due amount !');
        fnCmnScrollToElementIDorClass('#wrapper');
        var modifiedAmt = currentInputVal.substring(0,currentInputVal.length - 1);
        $('#repaid_advance_amt').val(modifiedAmt);
        fnCalculateNetSalary();
        return false;
    }else{
        $('.messageDiv').hide();
        var adjustedAmt = parseFloat(currentDueAdvanceAmt) - parseFloat(currentInputVal); 
        $('#totalDueAdvancePayment').val(adjustedAmt);
        $('.totalDueAdvancePayment').html(adjustedAmt);   
        fnCalculateNetSalary();
        return true;
    } 
}


function searchEmployeeForAdvancePayment(eleObj, url){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    
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
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {           
                $('#search_emp_result').empty().append(result.html); 
                $('#emp_advance_payment_div').empty();
                paginationTbl();// for pagination  
                fnHideShow('emp_search_form');
                fnHideShow('emp_search_result_list');
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}

function employeeAdvancePaymentAction(eleObj, modeID, actionID){ 
    $('.messageDiv').hide();  
    var rawurl = $(actionID + modeID).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0]; 
    var action=rawurl.split('&')[1];
//    if(action=='del'){
//        if(!confirm('Are you sure you want to delete payment mode ?'))
//            return false;
//    }  
    if(action == 'cre'){
        var addData = { 'key' : 'cre'};
    }else if(action == 'his'){
        var addData = { 'key' : 'his'};
    }else{
        var addData = { 'key' : 'cusAdvPayEditView'};
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url, 
        data: addData,
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {           
                  switch(action){
                       //create advance payment
                      case 'cre' : $('#emp_advance_payment_div').empty().append(result.html);
                                   $('.emp_advance_form_area').show();
                                   fnHideShow('emp_search_result_list');
                                   fnHideShow('emp_advance_payment_form');
                                   break;
                       //advance payment history          
                      case 'his' : $('#emp_advance_payment_div').empty().append(result.html);  
                                   $('.emp_advance_history_area').show();
                                   $('.emp_advance_form_area').hide();
                                   fnHideShow('emp_search_result_list');
                                   break;   
                      case 'cusAdvPayEditView': 
                                   $('#cus_advance_payment_form_reload').empty().append(result.html);
                                   $('.cusInfo').html('Customer ID: '+ result.jsonData.cus_id + ',' + result.jsonData.custName);
                                   $('#customer_id').val(result.jsonData.cus_id);
                                   $('#Advance_payment_key').val(result.jsonData.paymentType);
                                   $('#cus_advance_payment_id').val(result.jsonData.advPayId);
                                   $('#advance_amount').val(result.jsonData.advAmount);
                                   $('#payment_date').val(result.jsonData.paymentDate);
                                   $('#paymentMode').val(result.jsonData.payment_mode_id);                                                       
                                   $('#description').val(result.jsonData.description);
                                   $('#enter_account_id').empty().append(result.secondHtml);
                                   $('#enter_account_id').val(result.jsonData.enter_account_id);
                                   if(result.jsonData.payment_no == 0){
                                       $('#payment_number').val('');
                                   }else{
                                       $('#payment_number').val(result.jsonData.payment_no);
                                   }

                                   if($('#keyToDetectCash' + result.jsonData.payment_mode_id).val() == 0){
                                      $('#advance_payment_tbl').find('input[name = txt_payment_number]').prop('disabled', false).prop('readonly', true).addClass('inputDisable_bg');
                                   }
                                   $('#for_cus_advance_payment_form').show();
                                   switch(result.jsonData.key){
                                       case 'V' :   $('#btn_save').hide();
                                                    $('#btn_clear').hide();
                                                    $('#btn_edit').hide();  
                                                    $('#btn_cancel').hide();
                                                    $('#btn_close').show();
                                                    $('#advance_payment_tbl').find('input[type = text], input[type = date], select, textarea').each(function(){
                                                        $(this).prop('disabled', true).addClass('inputDisable_bg');               
                                                   });
                                                    break;
                                                    
                                       case 'E' :   $('#page_identified_key').val('approval_page');
                                                    $('#btn_save').show();
                                                    $('#btn_save').show();
                                                    $('#btn_clear').hide();
                                                    $('#btn_edit').hide();  
                                                    $('#btn_cancel').hide();  
                                                    $('#btn_close').show();
                                                    break;
                                   }
                                   fnHideShow('created_advance_payment');                                    
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
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}

function fnShowEmpAdvancePaymentHistory(url){
    $('.messageDiv').hide();    
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,   
        data: {'key' : $('#key').val() },
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {
                $('#emp_advance_payment_history').empty().append(result.html);
                $('.emp_advance_history_area').show();
                $('.view_his_btn').hide();
                $('.close_his_btn').show();
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');           
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}

function saveAdvancePayment(eleObj, url){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    
    var amount = tbl.find('input[name~="txt_advance_amount"]');
    if(amount.val().trim()==''){
       amount.focus();
       commonMessageAlert('Advance Amount can not be blank !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
    
    var createDate = tbl.find('input[name~="txt_create_date"]');
    if(createDate.val().trim()==''){
       createDate.focus();
       commonMessageAlert('Create Date can not be blank !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
    
    var description = tbl.find('textarea[name~="txt_description"]');
    if(description.val().trim()==''){
       description.focus();
       commonMessageAlert('please give some description !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
    
    var formData = $('form#frmAdvancePayment').serializeObject();  
    var formData2 = $('form#frmSearchEmployee').serializeObject();  
    var dataString = JSON.stringify($.extend(formData,formData2)); 
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
                $('#emp_advance_payment_history').empty().append(result.html);
                tbl.find('input[type = text], input[type = date], textarea').each(function(){
                    $(this).val('');               
                });               
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
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}

function editAdvancePayment(eleObj){
    var tbl = $(eleObj).closest('table');
    tbl.find('input[type = text], input[type = date], textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg');               
    }); 
    $('#save_btn').show();
    $('#edit_btn').hide();
}

function checkUncheckAll(eleObj){
    var tbl = $(eleObj).closest('table');
    var i = 0;
    tbl.find('.select_adv_pay').each(function(){       
            i = i + 1;
    });
    if(i > 0){
        if($(eleObj).prop('checked') == true){
        tbl.find('input[type = checkbox]').each(function(){
            $(this).prop('checked', true);               
        });
        }else{
            tbl.find('input[type = checkbox]').each(function(){
                $(this).prop('checked', false);               
            });
        }
    }else if(i == 0){
        commonMessageAlert('There is no field to select !');
        fnCmnScrollToElementIDorClass('#wrapper');
        $('.checkAll').prop('checked', false);       
    }
    
    
    
    
    
}

function cmnApprovedOrRejectCreatedAdvancePayment(eleObj, url, key){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    
    //check selected advance payment or not
    var checkflag = 0;
    tbl.find('input[type = checkbox]').each(function(){
            if($(this).prop('checked') == true){
                checkflag = 1;
            }               
     }); 
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
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {           
                $('#search_emp_result').empty().append(result.html);                                                              
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
                
                tbl.find('input[type = checkbox]').each(function() {
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
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}


function employeeAdvancePayPaymentAction(eleObj, modeID, actionID){
    $('.messageDiv').hide(); 
   
    var rawurl = $(actionID + modeID).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    switch(action){
        case 'pay' : 
                    $('#already_advance_payment_key').val(0);
                    var empID = $('#empID' + modeID).val(); 
                    var empPkid = $('#empPk' + modeID).val(); 
                    var empName = $('#empName' + modeID).val();
                    var empDesig = $('#empDesig' + modeID).val();
                    var empDept = $('#empDept' + modeID).val();
                    var advanceAmt = $('#advanceAmt' + modeID).val();
                    $('#advance_payment_id').val(modeID);
                    $('#employeePkid').val(empPkid);
                    $('.empID').html(empID);
                    $('.empName').html(empName);
                    $('.empDesig').html(empDesig);
                    $('.empDept').html(empDept);
                    $('.advanceAmt').html(advanceAmt); 
                    $('#advance_amount').val(advanceAmt);  
                    $('#advance_payment_div').show();
                    fnHideShow('advance_payment_paid');
                    fnHideShow('advance_pay_payment');
                    
                     break;
        case 'rej' : 
                      if(confirm('Are you sure you want to reject the approved advance payment ?')){
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
                                        paginationTbl();// for pagination    
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
                                    stopLoading();
                                    fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
                                    scrollToMessage();
                                }
                            });
                      }else{
                          return false;
                      }
                      
                    break;
    }
       
}

function payPaymentAdvancePayment(eleObj,key, url){
    $('.messageDiv').hide(); 
    //check for already paid for a particular advance payment 
    switch(key){
        case 'AP': //AP => advance payment
                    if($('#already_advance_payment_key').val() == 1){
                        commonMessageAlert('Aready paid for this payment.');
                        fnCmnScrollToElementIDorClass('#wrapper');
                        return false;
                     }
                     break;
        case 'SP':  //SP => salary slip payment
                    if($('#already_paid_salary_slip_key').val() == 1){
                        commonMessageAlert('Aready paid for this payment.');
                        fnCmnScrollToElementIDorClass('#wrapper');
                        return false;
                     }
                      break;
     }
    
    
    var tbl = $(eleObj).closest('table');
    var paymentMode = tbl.find('select[name~="txt_payment_mode"]');
    if(paymentMode.val().trim()==''){
       paymentMode.focus();
       commonMessageAlert('Please select payment mode !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
   
    var paymentDate = tbl.find('input[name~="txt_payment_date"]');
    if(paymentDate.val().trim()==''){
       paymentDate.focus();
       commonMessageAlert('Please select Payment Date !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
    if($('.checkKey').val() == 0){
        var paymentNoOrID = tbl.find('input[name~="txt_payment_no"]');
        if(paymentNoOrID.val().trim()==''){
                paymentNoOrID.focus();
                commonMessageAlert('Payment No/Transaction ID can\'t be empty !');
                fnCmnScrollToElementIDorClass('#wrapper');
                return false;
           }
    }
    
    //AP  => advance payment
    //SP => salary slip payment
    var  formData;
    switch(key){
        case 'AP':  //AP => advance payment
                    formData = $('form#frmPayPaymentAdvance').serializeObject(); 
                    break;
        case 'SP':  //SP => salary slip payment
                    formData = $('form#frmPayPaymentSalarySlip').serializeObject(); 
                    break;
    }
     
    var dataString = JSON.stringify(formData); //alert(dataString);
    
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
                switch(key){
                    case 'AP':   //AP  => advance payment
                                 $('#approvedID' + result.jsonData.advancePaymentOrSalarySlipID).remove();       
                                 $('#already_advance_payment_key').val(result.jsonData.paidKey);
                                 break;
                    case 'SP':  //SP => salary slip payment 
                                $('#approvedID' + result.jsonData.advancePaymentOrSalarySlipID).remove();       
                                $('#already_paid_salary_slip_key').val(result.jsonData.paidKey);
                                break;                            
                }
                
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
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
//function employeeSalarySlipApproveAction(eleObj, salarySlipID, monthName, monthID, year, actionID){ 
function employeeSalarySlipPayPaymentAction(eleObj,salarySlipID, monthName, monthID, year, actionID){
    $('.messageDiv').hide(); 
   
    var rawurl = $(actionID + salarySlipID).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    switch(action){
        case 'view':var addData = { 'txt_month' : monthID, 
                    'txt_year' : year,
                    'key' : action
                  };
                    var dataString = JSON.stringify(addData);
                    startLoading();
                    $.ajax({
                        type: 'POST',
                        url: url, 
                        data: dataString,
                        dataType: 'json',
                        success: function(result) {
                            if(result.jsonData=='AD'){
                                AccessDenied(result.html);
                                return;
                            }
                            if (result.success) {           
                                $('#salary_slip_form').empty().append(result.page);  
                                $('#emolumentsFormTbl').find('tr').last().before(result.html);
                                $('#deductionsFormTbl').find('tr').last().before(result.secondHtml);
                                fnHideShow('approval_salary_slip');  

                                //showing month year in employee salary slip
                                var monthYear = monthName + ', ' + year;
                                $('#monthYear').html(monthYear);

                                //set month and year to the hidden field  
                                $('#monthID').val(monthID);
                                $('#year').val(year);

                                if(result.jsonData.resultFlag == 1){   
                                    $('#created_salary_slip_id').val(result.jsonData.salSlipID);                  
                                    $('#earningTotal').val(result.jsonData.earningTotal);
                                    $('#epf_amount').val(result.jsonData.epf);                   
                                    $('#repaid_advance_amt').val(result.jsonData.deductionAdjustedAdvancePay);
                                    $('#adjustment_wallet_bal').val(result.jsonData.deductionAdjustedWalletBal);
                                    $('.advanceAmt').html(result.jsonData.netSalary);
                                    //disable fields
                                    $('#created_salary_form_tbl').find('.useField').each(function(){
                                        $(this).prop('disabled', true).addClass('inputDisable_bg');  
                                    });
                                    $('.emolumentDeductionAddBtn').addClass('removeMousePointer');
                                    $('#btn_ok').show();
                                    $('#btn_save').hide();
                                    $('#btn_edit').hide();
                                    $('#btn_update').hide();                       

                                }
                                //show calculated net salary
                                 fnCalculateNetSalary(); 
                                 
                                 
                                 fnHideShow('approval_salary_slip');
                                 $('#salary_slip_payment').show(); //show payment form 
                                 $('#addNewEmolumentDeductionFieldTr').hide(); // hide add new emolument or deducion field
                                 $('.salary-slip-form-tbl-title').html('Salary Slip Details :'); // change salary slip form table title      
                                 $('#salary_slip_id').val(result.jsonData.salSlipID);
                                 
                                                       
                            }
                            else {
                                fnCmnErrorMessage(result.message);
                                fnCmnScrollToElementIDorClass('#wrapper');
                            }
                             stopLoading();
                        },
                        error: function() {
                            stopLoading();
                            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
                            scrollToMessage();
                        }
                    });
                    break;
        case 'pay' : 
                    $('#already_advance_payment_key').val(0);
                    var empID = $('#empID' + salarySlipID).val(); 
                    var empName = $('#empName' + salarySlipID).val();
                    var empDesig = $('#empDesig' + salarySlipID).val();
                    var monthOf = $('#monthOf' + salarySlipID).val();
                    var advanceAmt = $('#advanceAmt' + salarySlipID).val();
                    $('#advance_payment_id').val(salarySlipID);
                    $('.empID').html(empID);
                    $('.empName').html(empName);
                    $('.empDesig').html(empDesig);
                    $('.monthOf').html(monthOf);
                    $('.advanceAmt').html(advanceAmt);                 
                    $('#advance_payment_div').show();
                    fnHideShow('advance_payment_paid');
                    fnHideShow('advance_pay_payment');
                    
                     break;
        case 'rej' : 
                      if(confirm('Are you sure you want to reject the salary slip ?')){
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
                                        $('.approval_list').empty().append(result.html);
                                        paginationTbl();// for pagination   
                                        
                                        $('#salary_slip_payment').hide();
                                        $(eleObj).closest('tr').remove();
                                        $('#salary_slip_detail').empty();
                                        $('#payment_mode').val('');
                                        $('#payment_date').val('');
                                        $('.checkKey').val('');
                                        $('#payment_no').val('');
                                        $('.advanceAmt').html('');
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
                                    stopLoading();
                                    fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
                                    scrollToMessage();
                                }
                            });
                      }else{
                          return false;
                      }
                      
                    break;
    }
       
}

function chagePaymentModeType(eleObj){ 
    var tbl = $(eleObj).closest('table');
    
    var paymentNoOrID = tbl.find('input[name~="txt_payment_no"]');
    var paymentType = tbl.find('#payment_mode option:selected'); 
    if(paymentType.text().toLowerCase() === 'cash'){
        paymentNoOrID.prop('readonly', true).addClass('inputDisable_bg');
        $('.checkKey').val(1);
        $('.payment-no').hide();
    }else{
       paymentNoOrID.prop('readonly', false).removeClass('inputDisable_bg');
       $('.checkKey').val(0);
       $('.payment-no').show();
       
    }
}

function searchWorkerToCreateWage(eleObj, url){
    $('.messageDiv').hide(); 
    var worker_feild_data = $('#worker_data').val();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: { 'worker_data': worker_feild_data},     
        dataType: 'json',
        success: function(result) {
            if (result.success) {              
                $('#search_result').empty().append(result.html);
                paginationTbl();// for pagination  
                fnHideShow('emp_search_result_list');
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
}


function empWorkerAction(eleObj, modeID, actionID){ 
    $('.messageDiv').hide(); 
    var rawurl = $(actionID + modeID).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0]; 
    var action=rawurl.split('&')[1];
    startLoading();
    $.ajax({
        type: 'POST',
        url: url, 
        data: {'key': action},
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                                        AccessDenied(result.html);
                                        return;
                                    }
            if (result.success) {           
                $('#worker_wage_form').empty().append(result.html);  
                fnHideShow('emp_search_result_list'); //emp_worker_id  emp_worker_name  wage_type_id wage_type_amount wage_type
                var emp_worker_info = $('#emp_worker_id' + result.id).val() +', '+ $('#emp_worker_name' + result.id).val();
                $('#worker_pkid').val(result.id);
                $('#emp_worker_info').html(emp_worker_info);  //emp worker info
                $('.wage_type').html( $('#wage_type'+ result.id).val() );  //wage type text
                $('#wage_type_id').val( $('#wage_type_id'+ result.id).val() );  //wage type id 
                $('.total_wage_title').html('No of ' + $('#wage_type'+ result.id).val());  // no of wage title
                $('.wage_type_amount').html($('#wage_type_amount'+ result.id).val()); //wage amount text
                $('#wage_type_amount').val($('#wage_type_amount'+ result.id).val());//wage amount value
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
                      
}

function chooseWageDateOption(single, multiple, key){
    switch(key){
        case 'single':  $('#' + single).show();
                        $('#' + multiple).hide();
                        $('#working_date_from').val('');
                        $('#working_date_to').val('');
                        break;
        case 'multiple':  $('#' + single).hide();
                          $('#' + multiple).show();
                          $('#working_date').val('');                         
                        break;
    }
}
function calculateTotalWageAmount(eleObj){
    var total_wage_type = $(eleObj).val();
    if(total_wage_type == ''){ total_wage_type = 0; }
    var wage_amount = $('#wage_type_amount').val();
    var total_amount = parseFloat(total_wage_type) * parseFloat(wage_amount);
    $('.net_wage').html(total_amount);
    $('#net_wage').val(total_amount);
    if(total_amount == 0){
        $('.net_wage').html('');
        $('#net_wage').val('');
    }
}
function saveWorkerWage(eleObj, url){
    $('.messageDiv').hide(); 
    var tbl = $(eleObj).closest('table');  
    var total_wage_type = tbl.find('input[name~="txt_total_wage_type"]');
    if(total_wage_type.val().trim()==''){          
       commonMessageAlert($('.total_wage_title').html() +' can not be blank !');
       fnCmnScrollToElementIDorClass('#wrapper');   
       total_wage_type.focus();
       return false;
    } 
    
    if($('.wage_date_single').prop('checked') == true){
        var working_date = $('#working_date');
        if(working_date.val().trim()==''){
            commonMessageAlert('Working Date can not be blank !');
            fnCmnScrollToElementIDorClass('#wrapper');   
            working_date.focus();
            return false;
        }
    }
    if($('.wage_date_multiple').prop('checked') == true){
        var working_form_date = $('#working_date_from');
        var working_date_to = $('#working_date_to');
        if(working_form_date.val().trim()==''){
            commonMessageAlert('Working start date(From) can not be blank !');
            fnCmnScrollToElementIDorClass('#wrapper');   
            working_form_date.focus();
            return false;
        }
        if(working_date_to.val().trim()==''){
            commonMessageAlert('Working end date(To) can not be blank !');
            fnCmnScrollToElementIDorClass('#wrapper');   
            working_date_to.focus();
            return false;
        }
        //date comparison
        if( (new Date(working_form_date.val()).getTime() > new Date(working_date_to.val()).getTime()))
        {
            commonMessageAlert('Working start date(From) can not be greater than working end date(To), please check !');
            fnCmnScrollToElementIDorClass('#wrapper');   
            working_form_date.focus();
            return false;
        }
        
        
    }
    
    var formData = $('form#empWorkerWageFrm').serializeObject();  
    var dataString = JSON.stringify(formData); //alert(dataString);
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
                if(result.jsonData.key == 'viewEdit'){  
                    $('.approval_list').empty().append(result.html);
                    paginationTbl();// for pagination   
                }
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');      
                $('#wage_details_pkid').val(result.jsonData.wage_id);              
                var tbl = $(eleObj).closest('table');
                tbl.find('input[type = radio], input[type = text], input[type = date]').each(function() {
                    $(this).prop('disabled', true).addClass('inputDisable_bg');
                });
                $('#btn_save').hide();
                $('#btn_update').hide();
                $('#btn_edit').show();
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
}

function cmnApprovedOrRejectWage(eleObj, url, key){
    $('.messageDiv').hide();
    var tbl = $('#worker_wage_approval_tbl');
    
    //check selected advance payment or not
    var checkflag = 0;
    var breakOut;
    tbl.find('input[type = checkbox]').each(function(){
            if($(this).prop('checked') == true){
                checkflag = 1;
                var salary_slip_pkid = $(this).val(); 
                //check description blank
                if($('#description'+salary_slip_pkid).val().trim()==''){
                    commonMessageAlert('Please give some description!');
                    fnCmnScrollToElementIDorClass('#wrapper');
                    $('#description'+salary_slip_pkid).focus();
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
       commonMessageAlert('Please select one of the salary slip !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }   
    
    if(key == 'A'){
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
               commonMessageAlert('Payment No can not be blank !');
               fnCmnScrollToElementIDorClass('#wrapper');
               payment_no.focus();
               return false;
            }
        }

        var enter_account_id = tbl.find('select[name=txt_enter_account_id]');
        if(enter_account_id.val().trim()==''){
           commonMessageAlert('Source Account must be select !');
           fnCmnScrollToElementIDorClass('#wrapper');
           enter_account_id.focus();
           return false;
        }
    }
    
    var approveOrRejectedDate = tbl.find('input[name~="txt_approved_or_rejected_date"]');
    if(approveOrRejectedDate.val().trim()==''){
       approveOrRejectedDate.focus();
       commonMessageAlert('Date can not be blank !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
    
    var alertMsg = '';
    switch(key){
        case 'A': alertMsg = 'Are you sure to approve selected wages ?';
                  break;
        case 'R': alertMsg = 'Are you sure to reject selected wages ?';
                  break;
    }
    if(!confirm(alertMsg)){
        return false;
    }
      
    var formData = $('form#frmApprovalWage').serializeObject();  
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
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if (result.success) {           
                $('.approval_list').empty().append(result.html);  
                paginationTbl();// for pagination   
                fnHideShow('approval_salary_slip'); 
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');               
                $('#approved_or_rejected_date').val('');
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
}


function wageApproveAction(eleObj, modeID, actionID){ 
    $('.messageDiv').hide(); 
    var rawurl = $(actionID + modeID).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0]; 
    var action=rawurl.split('&')[1]; 
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected employee ?'))
            return false;
    }   
    startLoading();
    $.ajax({
        type: 'POST',
        url: url, 
        data: { 'key' : action },
        dataType: 'json',
        success: function(result) {
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if (result.success) {                   
                    $('#editArea').empty().append(result.html);                 
                    fnHideShow('approval_salary_slip');
                    
                    $('#empWorkerWageFrmTbl').find('input[type = radio], input[type = text], input[type = date]').each(function() {
                        $(this).prop('disabled', true).addClass('inputDisable_bg');
                    });
                    
                    $('#btn_save').hide();
                    $('#btn_update').hide();
                    $('#btn_edit').show();
                    
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            stopLoading();
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           scrollToMessage();
        }
    });
}

function editWorkerWage(eleObj){
    var tbl = $(eleObj).closest('table');
    tbl.find('input[type = radio], input[type = text], input[type = date]').each(function() {
        $(this).prop('disabled', false).removeClass('inputDisable_bg');
    });
    $('#btn_save').hide();
    $('#btn_update').show();
    $('#btn_edit').hide();
}



function SendMailWithAttachment(url)
{
$('.messageDiv').hide(); 
startLoading();
//  var target = $('#printHere');
//  html2canvas(target, 
//   {
//     onrendered: function(canvas) 
//     { alert(canvas);
//     var data = canvas.toDataURL();
//     $.ajax({            
//            type: 'POST',
//            url: url ,     
//            data: { 'data' : data },
//            dataType:'json',
//            success: function (response){
//                      document.getElementById('approval_list1').innerHTML="<br/><br/><br/><br/><br/><br/><img src="+response+" />";                                  
//                                        
//           },
//            error: function(){ alert('something went wrong');}
//    });         
//   }
// });


 html2canvas([document.getElementById('printHere')], {
    onrendered: function (canvas) {
        document.getElementById('imagehgh').appendChild(canvas);
        var data = canvas.toDataURL();
        var empid = $('#txt_empid').val();
//        alert(data);
//        alert(empid);
        // AJAX call to send `data` to a PHP file that creates an image from the dataURI string and saves it to a directory on the server

        var image = new Image();
        image.src = data;
       
        //alert(image.src);
//        $("#image").children().attr({
//            src: img.src
//        });
         $.ajax({            
            type: 'POST',
            url: url ,     
            data: { 'data' : data ,'emp': empid},
            dataType:'json',
            success: function (response){
                stopLoading();
             // alert(response.html);
              //alert(response.message);
           // $('#imagehgh').empty().append(response.html);
            fnCmnSuccessMessage(response.message);  
           },
            error: function(){ fnCmnWarningMessage('Cannot send email!...');stopLoading();}
    });     
       
    }
});
        
}

function convertImgToBase64URL(url, callback, outputFormat){
    var img = new Image();
    img.crossOrigin = 'Anonymous';
    img.onload = function(){
        var canvas = document.createElement('CANVAS'),
        ctx = canvas.getContext('2d'), dataURL;
        canvas.height = this.height;
        canvas.width = this.width;
        ctx.drawImage(this, 0, 0);
        dataURL = canvas.toDataURL(outputFormat);
        callback(dataURL);
        canvas = null; 
    };
    img.src = url;
}

function ConvertToPDF(url)
{
$('.messageDiv').hide(); 
startLoading();

    $.ajax({            
            type: 'POST',
            url: url ,     
            dataType:'json',
            success: function (response){
                stopLoading();
            
            fnCmnSuccessMessage(response.message);  
           },
            error: function(){ fnCmnWarningMessage('Cannot convert to pdf!...');stopLoading();}
     });      
}
