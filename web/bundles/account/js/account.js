function saveAccountHead(eleObj,url) { 
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    var account_type = tbl.find('select[name~="txt_acc_type"]');
    if(account_type.val() == ''){     
       commonMessageAlert('Please select Account Type !');
       fnCmnScrollToElementIDorClass('#wrapper');   
       account_type.focus();
       return false;
    } 
    var acc_head_name = tbl.find('input[name~="txt_acc_head_name"]');
    if(acc_head_name.val().trim() == ''){      
       commonMessageAlert('Account Head Name can\'t be empty !');
       fnCmnScrollToElementIDorClass('#wrapper'); 
       acc_head_name.focus();
       return false;
    } 
    
    var formData = $('form#frmAccountHead').serializeObject();
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
                $('#display_list').empty().append(result.html);
                paginationTbl();// for pagination   
                $('#acc_head_id').val(result.id);
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');                

                //for hide show buttons and diables fields                  
                tbl.find('input[type = text], select, textarea').each(function(){
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function editAccountHeadField(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    
     //for hide show buttons and diables fields                  
    tbl.find('input[type = text], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg');               
    });

    $('#btn_edit').hide();
    $('#btn_cancel').show();
    $('#btn_save').hide();
    $('#btn_clear').hide();
    $('#btn_update').show();
}

function cancelAccoundHeadField(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');    
     //for hide show buttons and diables fields                  
    tbl.find('input[type = text], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
    }); 
    $('#acc_head_id').val('');
    
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_save').show();
    $('#btn_clear').show();
    $('#btn_update').hide();
}



function accountHeadAction(eleObj, accHeadId, actionID){ 
    $('.messageDiv').hide(); 
    
    var rawurl = $(actionID + accHeadId).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete Account Head ?'))
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
                                    //for hide show buttons and diables fields                  
                                    $('#frmAccountHead').find('input[type = text], select, textarea').each(function(){
                                        $(this).prop('disabled', false).removeClass('inputDisable_bg');               
                                    });
                                   $('#acc_head_id').val(result.jsonData.acc_head_id); 
                                   $('#acc_type').val(result.jsonData.account_type); 
                                   $('#acc_head_name').val(result.jsonData.account_head_name); 
                                   $('#description').val(result.jsonData.description); 
                                                                                                   
                                   //buttons hide show
                                   $('#btn_edit').hide();
                                   $('#btn_cancel').show();
                                   $('#btn_save').hide();
                                   $('#btn_clear').hide();
                                   $('#btn_update').show();
                                   break;
                      case 'del' : 
                                   $(eleObj).closest('tr').empty().remove();                          
                                   fnCmnSuccessMessage(result.message);
                                   fnCmnScrollToElementIDorClass('#wrapper');
                                                          
                                   var tbl = $('#account_head_form_tbl');  
                                   tbl.find('input[type = text], select, textarea').each(function(){
                                        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
                                   });
                                   $('#acc_head_id').val('');                                  
                                   
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function loadAccountCommonList(eleObj, eleId, url){ 
    $('.messageDiv').hide(); 
    var account_type_id = $(eleObj).val();
    if(account_type_id == ''){      
            return false;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url, 
        data: { 'account_type_id' : account_type_id },
        dataType: 'json',
        success: function(result) {
			if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) { 
                $('#acc_head').empty().append(result.html);                
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

////// account entry /////
function saveAccountEntry(eleObj,url) { 
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    
    var account_head = tbl.find('select[name~="txt_acc_head"]');
    if(account_head.val() == ''){     
       commonMessageAlert('Account Head must be select !');
       fnCmnScrollToElementIDorClass('#wrapper');   
       account_head.focus();
       return false;
    } 
    
    var ammount = tbl.find('input[name~="txt_ammount"]');
    if(ammount.val().trim() == ''){      
       commonMessageAlert('Amount can\'t be empty !');
       fnCmnScrollToElementIDorClass('#wrapper'); 
       ammount.focus();
       return false;
    }
    var payment_mode = tbl.find('select[name=txt_payment_mode]');
     if(payment_mode.val() == ''){
        commonMessageAlert('please select Payment Mode !');
        fnCmnScrollToElementIDorClass('#wrapper');
        payment_mode.focus();
        return false;
     }
     var payment_no = tbl.find('input[name=txt_payment_number]');
     var check_payment_no = $('#keyToDetectCash' + payment_mode.val()).val();
     if(check_payment_no == 1){
        if(payment_no.val().trim() == ''){
            commonMessageAlert('Payment No can not be blank !');
            fnCmnScrollToElementIDorClass('#wrapper');
            payment_no.focus();
            return false;
         }
     }
     
     var enter_account_id = tbl.find('select[name=txt_enter_account_id]');
     if(enter_account_id.val() == ''){
        commonMessageAlert('Source Account must be select !');
        fnCmnScrollToElementIDorClass('#wrapper');
        enter_account_id.focus();
        return false;
     }
    
    var entry_date = tbl.find('input[name~="txt_entry_date"]');
    if(entry_date.val().trim() == ''){      
       commonMessageAlert('Entry Date can not be blank !');
       fnCmnScrollToElementIDorClass('#wrapper'); 
       entry_date.focus();
       return false;
    }
    
    var source_account_type = tbl.find('select[name~="txt_source_account_type"]');
    if(source_account_type.val() == ''){     
       commonMessageAlert('Source Account Type must be select !');
       fnCmnScrollToElementIDorClass('#wrapper');   
       source_account_type.focus();
       return false;
    } 
    
    var source_account = tbl.find('select[name~="txt_enter_account_id"]');
    if(source_account.val() == ''){     
       commonMessageAlert('Source Account must be select !');
       fnCmnScrollToElementIDorClass('#wrapper');   
       source_account.focus();
       return false;
    } 
    
    var description = tbl.find('textarea[name~="txt_description"]');
    if(description.val().trim() == ''){      
       commonMessageAlert('Please give some Description !');
       fnCmnScrollToElementIDorClass('#wrapper'); 
       description.focus();
       return false;
    }
    
    var formData = $('form#frmAccountEntry').serializeObject();
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
                $('#account_entry_income_list').empty().append(result.html);
                paginationTbl();// for pagination 
                $('#account_entry_expense_list').empty().append(result.secondHtml);                 
                paginationTbl2();// for pagination  
                 $('#account_entry_contra_list').empty().append(result.page);                 
                paginationTbl3();// for pagination                  
               // $('#acc_id').val(result.jsonData.account_id);
                $('#current_balance_field').hide();
                $('#balance').html();
                $('#month').val(result.jsonData.currentMonth);
                $('#year').val(result.jsonData.currentYear);
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');                

                //for hide show buttons and diables fields   allContraTansaction               
                tbl.find('input[type = text], select, textarea').each(function(){
                    $(this).val('');               
                });

//                $('#btn_edit').show();
//                $('#btn_cancel').show();
//                $('#btn_save').hide();
//                $('#btn_clear').hide();
//                $('#btn_update').hide();                                
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
               
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
            stopLoading();
        }
    });
}

function searchOptionField(eleObj){
    var optionKey = $(eleObj).val();
    switch(optionKey){
        case 'period':  $('#option').show();
                        $('#monthAndYear').hide();
                        $('#month').val('');
                        $('#year').val('');
                        break;
        case 'month&year': var d = new Date();
                        $('#year').val(d.getFullYear());
                        $('#option').hide();
                        $('#monthAndYear').show();
                        $('#startDate').val('');
                        $('#endDate').val('');
                        break;
    }
}

function searchAccountEntry(eleObj, url){
    $('.messageDiv').hide();
    var search_by = $('#search_by').val();
    if(search_by == 'period'){
        var start_date = $('#startDate').val();
        var end_date = $('#endDate').val();
        if(new Date(start_date).valueOf() > new Date(end_date).valueOf()){
            commonMessageAlert('Start Date can\'t be greater than End Date !');
            fnCmnScrollToElementIDorClass('#wrapper');   
            $('#startDate').focus();
            return false;
        }
        if($('#startDate').val() == ''){
            commonMessageAlert('Start Date can\'t be blank  !');
            fnCmnScrollToElementIDorClass('#wrapper');   
            $('#startDate').focus();
            return false;
        }
        if($('#endDate').val().trim() == ''){
            commonMessageAlert('End Date can\'t be blank !');
            fnCmnScrollToElementIDorClass('#wrapper');   
            $('#endDate').focus();
            return false;
        }
    }
    if(search_by == 'month&year'){
        if($('#month').val() == ''){
            commonMessageAlert('Please select Month !');
            fnCmnScrollToElementIDorClass('#wrapper');   
            $('#month').focus();
            return false;
        }
        if($('#year').val().trim() == ''){
            commonMessageAlert('Year can\'t be blank !');
            fnCmnScrollToElementIDorClass('#wrapper');   
            $('#year').focus();
            return false;
        }
    }
    var formData = $('form#searchAccountEntryForm').serializeObject();
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
            if (result.success) {  //searchResult     
                $('#searchResult').empty().append(result.html);
                paginationTbl();// for pagination                              
                paginationTbl2();// for pagination         
                paginationTbl3();// for pagination         
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
               
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function editAccounEntryField(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    
     //for hide show buttons and diables fields                  
    tbl.find('input[type = text], input[type = date], select, textarea').each(function(){
        $(this).prop('disabled', true).addClass('inputDisable_bg');               
    });

    $('#btn_edit').hide();
    $('#btn_cancel').show();
    $('#btn_save').hide();
    $('#btn_clear').hide();
    $('#btn_update').show();
}

function cancelAccoundEntryField(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');    
     //for hide show buttons and diables fields                  
    tbl.find('input[type = text], input[type = date], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
    });
    $('#acc_id').val('');
    
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_save').show();
    $('#btn_clear').show();
    $('#btn_update').hide();
}

function loadAccountEntryDetail(url){
    $('.messageDiv').hide();
    if($('#year').val() == ''){
       commonMessageAlert('Year can\'t be empty !');
       fnCmnScrollToElementIDorClass('#wrapper'); 
       $('#year').focus();
       $('#month').val('');
       return false;
    }
    $('#periodDate').val('');
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: { 'month' : $('#month').val(), 'year': $('#year').val()},    
        dataType: 'json',
        success: function(result) {  
if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }		
            if (result.success) {    
                $('#account_entry_income_list').empty().append(result.html);
                paginationTbl();// for pagination 
                $('#account_entry_expense_list').empty().append(result.secondHtml);                 
                paginationTbl2();// for pagination      
                 $('#account_entry_contra_list').empty().append(result.page);                 
                paginationTbl3();// for pagination    
                $('#periodDate').addClass('inputDisable_bg');
                $('#month').removeClass('inputDisable_bg');
                $('#year').removeClass('inputDisable_bg');
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
               
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function loadAccountEntryAnyPeriod(eleObj, url){ 
    $('.messageDiv').hide();
    if($(eleObj).val() == ''){
//       commonMessageAlert('Year can\'t be empty !');
//       fnCmnScrollToElementIDorClass('#wrapper'); 
//       $('#year').focus();
       return false;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: { 'periodDate' : $(eleObj).val() },    
        dataType: 'json',
        success: function(result) {  
				if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }		
            if (result.success) {    
                $('#account_entry_income_list').empty().append(result.html);
                paginationTbl();// for pagination 
                $('#account_entry_expense_list').empty().append(result.secondHtml);                 
                paginationTbl2();// for pagination  
                
                $(eleObj).removeClass('inputDisable_bg');
                $('#month').val('').addClass('inputDisable_bg');
                $('#year').val('').addClass('inputDisable_bg');
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
               
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function accountEntryAction(eleObj, accHeadId, actionID){ 
    $('.messageDiv').hide(); 
    
    var rawurl = $(actionID + accHeadId).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete account entry detail ?'))
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
                      case 'upd' :  $('#acc_head').empty().append(result.html);   
                                    //for hide show buttons and diables fields                  
                                   $('#account_entry_form_tbl').find('input[type = text], input[type = date], select, textarea').each(function(){
                                       $(this).prop('disabled', false).removeClass('inputDisable_bg');               
                                   });                               
                                   $('#acc_id').val(result.jsonData.acc_id); 
                                   $('#acc_type').val(result.jsonData.acc_type_id); 
                                   $('#acc_head').val(result.jsonData.acc_head_id); 
                                   $('#ammount').val(result.jsonData.amount); 
                                   $('#entry_date').val(result.jsonData.date); 
                                   $('#description').val(result.jsonData.description); 
                                                                                                   
                                   //buttons hide show
                                   $('#btn_edit').hide();
                                   $('#btn_cancel').show();
                                   $('#btn_save').hide();
                                   $('#btn_clear').hide();
                                   $('#btn_update').show();
                                   break;
                      case 'del' : 
                                   $(eleObj).closest('tr').empty().remove();                          
                                   fnCmnSuccessMessage(result.message);
                                   fnCmnScrollToElementIDorClass('#wrapper');
                                                          
                                   var tbl = $('#account_entry_form_tbl');  
                                   tbl.find('input[type = text], input[type = date], select, textarea').each(function(){
                                        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
                                   });
                                   $('#acc_id').val('');                                  
                                   
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}


function saveCompanyBankInfo(url, eleObj,mode){   
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    
//    var company_name = tbl.find('select[name~="txt_company"]'); 
//    if(company_name.val() == '' ){      
//        fnCmnWarningMessage('Company Name can\'t be empty !'); 
//        fnCmnScrollToElementIDorClass('#wrapper');
//         company_name.focus();
//        return false;
//    }
    var bank_name = tbl.find('input[name~="txt_bank_name"]'); 
    if(bank_name.val().trim() == '' ){       
        fnCmnWarningMessage('Bank Name can\'t be empty !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        bank_name.focus();
        return false;
    }
    
    
    var branch_name = tbl.find('input[name~="txt_branch_name"]'); 
    if(branch_name.val().trim() == '' ){       
        fnCmnWarningMessage('Branch Name can\'t be empty !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        branch_name.focus();
        return false;
    }
    var account_type = tbl.find('select[name~="txt_account_type"]'); 
    if(account_type.val() == '' ){      
        fnCmnWarningMessage('Account Type can\'t be empty !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        account_type.focus();
        return false;
    }
    var account_name = tbl.find('input[name~="txt_account_name"]'); 
    if(account_name.val().trim() == '' ){      
        fnCmnWarningMessage('Account Name can\'t be empty !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        account_name.focus();
        return false;
    }
    var account_no = tbl.find('input[name~="txt_account_no"]'); 
    if(account_no.val().trim() == '' ){      
        fnCmnWarningMessage('Account Number can\'t be empty !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        account_no.focus();
        return false;
    }
    
    var current_bal = tbl.find('input[name~="txt_account_balance"]'); 
    if(current_bal.val().trim() == '' ){      
        fnCmnWarningMessage('Current Balance can\'t be empty !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        current_bal.focus();
        return false;
    }
    
    var location = tbl.find('textarea[name~="txt_location"]'); 
    if(location.val().trim() == '' ){
        location.focus();
        fnCmnWarningMessage('Location can\'t be empty !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
   if(parseFloat($('#txtBalance').val())!=parseFloat($('#txtReBalance').val()) && mode!='edt'){
        fnCmnWarningMessage('Balance Amount does not match!');
        scrollToMessage();
        $('#txtBalance').focus();
        return ;
   }
   if(mode=='edt'){
       if(!confirm('Confirm Update?')){
           return;
       }
   }
    var formData = new FormData($('#frmCompanyBankDetail')[0]); 
  //  formData.append('txt_employee_id', $('#employeeID').val());
    
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
                switch(result.jsonData.account_flag){
                    case 1: //if already exist bank account number
                            account_no.focus();
                            fnCmnSuccessMessage(result.message);
                            fnCmnScrollToElementIDorClass('#wrapper');
                            break;
                    case 0: //if new entry bank account
                            $('#display-list').empty().append(result.html);
                            paginationTbl();// for pagination        
                            fnCmnSuccessMessage(result.message);
                            fnCmnScrollToElementIDorClass('#wrapper');  

                            $('#company_bank_id').val(result.id);             
                            //for hide show buttons and diables
                            tbl.find('input[type = text],input[type = file], select, textarea').each(function(){
                                $(this).prop('disabled', true).addClass('inputDisable_bg');               
                            });

                            $('#btn_save').hide();
                            $('#btn_clear').hide();
                            $('#btn_update').hide();
                            $('#btn_edit').show();
                            $('#btn_cancel').show(); 
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}




function saveCompanyCashInfo(url, eleObj,mode){   
    
    if(mode=='ins'){
        if(!confirm('Once Cash Account is Save! It Can\'t be editable nor deletable ?'))
            return false;
    }
    
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    

    var amount = tbl.find('input[name~="cash_amount"]'); 
    if(amount.val().trim() == '' ){       
        fnCmnWarningMessage('Cash Account is mandatory!'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        amount.focus();
        return false;
    }
    
    var description = tbl.find('textarea[name~="description"]'); 
    if(description.val().trim() == '' ){
        description.focus();
        fnCmnWarningMessage('Description is mandatory!'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        return false;
    }
   
   if(mode=='edt'){
       if(!confirm('Confirm Update?')){
           return;
       }
   }
    var formData = new FormData($('#frmCompanyCashDetail')[0]); 
  //  formData.append('txt_employee_id', $('#employeeID').val());
   // alert(formData);
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
                switch(result.jsonData.account_flag){
                    
                    case 1: //if new entry cash account!
                            $('#display-list').empty().append(result.html);
                            fnCmnSuccessMessage(result.message);
                            tbl.find('input[type = text],input[type = file],textarea').each(function(){
                                $(this).val('');               
                            });
                            $('#company_cash_id').val('');
                            $('#btn_save').show();
                            $('#btn_clear').show();
                            $('#btn_update').hide();
                            paginationTbl();// for pagination 
                            stopLoading();
                            break;
                    case 0: 
                            $('#display-list').empty().append(result.html);
                            fnCmnSuccessMessage(result.message);
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}




function editBankDetailsFields(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    
     //for hide show buttons and diables fields                  
    tbl.find('input[type = text],input[type = file], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg');               
    });

    $('#btn_edit').hide();
    $('#btn_cancel').show();
    $('#btn_save').hide();
    $('#btn_clear').hide();
    $('#btn_update').show();
}

function cancelBankDetailsFields(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');    
     //for hide show buttons and diables fields                  
    tbl.find('input[type = text],input[type = file], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
    });
    $('#company_bank_id').val('');
    $('#file_control_btn').hide();
    $('#photoPassbook').removeClass('removeMousePointer').removeClass('inputDisable_bg');
    
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_save').show();
    $('#btn_clear').show();
    $('#btn_update').hide();
}

function bankAccountAction(url,action,eleObj){ 
    $('.messageDiv').hide();
    if(action=='del'){
        if(!confirm('Are you sure you want to delete Bank Account ?'))
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
                                    //for hide show buttons and diables fields                  
                                   $('#bank_account_form_tbl').find('input[type = text],input[type = file], select, textarea').each(function(){
                                       $(this).prop('disabled', false).removeClass('inputDisable_bg');               
                                   });  
                                 //alert(result.jsonData.bal);
                                   $('#company_bank_id').val(result.jsonData.result.company_bank_id); 
                                   $('#company').val(result.jsonData.result.company_id); 
                                   $('#bank_name').val(result.jsonData.result.bankName); 
                                   $('#branch_Name').val(result.jsonData.result.branchName); 
                                   $('#branch_code').val(result.jsonData.result.branchCode); 
                                   $('#account_type').val(result.jsonData.result.accountType);
                                   $('#micr_code').val(result.jsonData.result.micr);
                                   $('#ifsc_code').val(result.jsonData.result.ifsc);
                                   $('#account_name').val(result.jsonData.result.accountName);
                                   $('#account_no').val(result.jsonData.result.accountNo);
                                   $('#account_balance').val(result.jsonData.bal);
                                   $('#contact_no').val(result.jsonData.result.contactNo);
                                   $('#location').val(result.jsonData.result.location);
                                   if(result.jsonData.result.scan_doc_file != ''){
                                       $('#file_control_btn').show();
                                       $('#photoPassbook').addClass('removeMousePointer').addClass('inputDisable_bg');
                                       $('#changePassbookBtn').show();
                                       $('#cancelPassbookBtn').hide();
                                   }
                                   
                                   //buttons hide show
                                   $('#btn_edit').hide();
                                   $('#btn_cancel').show();
                                   $('#btn_save').hide();
                                   $('#btn_clear').hide();
                                   $('#btn_update').show();
                                   break;
                      case 'del' : 
                                   $(eleObj).closest('tr').empty().remove();                          
                                   fnCmnSuccessMessage(result.message);
                                   fnCmnScrollToElementIDorClass('#wrapper');
                                                          
                                   $('#bank_account_form_tbl').find('input[type = text],input[type = file], select, textarea').each(function(){
                                       $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
                                   });
                                   $('#company_bank_id').val('');   
                                   $('#file_control_btn').hide();
                                   $('#photoPassbook').removeClass('removeMousePointer').removeClass('inputDisable_bg');
                                   
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
            stopLoading();
        }
    });
}


function cashAccountAction(eleObj, accHeadId, actionID){ 
    $('.messageDiv').hide(); 
    
    var rawurl = $(actionID + accHeadId).val(); 
    if(rawurl==''){
        return;
    }
    
    var url=rawurl.split('&')[0];  
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete Bank Account ?'))
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
                                    //for hide show buttons and diables fields  
                                   $('#company_cash_id').val(result.jsonData.id); 
                                   $('#cash_amount').val(result.jsonData.amount); 
                                   $('#description').val(result.jsonData.des); 
                                   //buttons hide show
                                   $('#btn_save').hide();
                                   $('#btn_clear').hide();
                                   $('#btn_update').show();
                                   break;
                      case 'del' : 
                                   $(eleObj).closest('tr').empty().remove();                          
                                   fnCmnSuccessMessage(result.message);
                                   fnCmnScrollToElementIDorClass('#wrapper');
                                                          
                                   $('#bank_account_form_tbl').find('input[type = text],input[type = file], select, textarea').each(function(){
                                       $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
                                   });
                                   $('#company_bank_id').val('');   
                                   $('#file_control_btn').hide();
                                   $('#photoPassbook').removeClass('removeMousePointer').removeClass('inputDisable_bg');
                                   
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
            stopLoading();
        }
    });
}









function enableFileChange(fileEleId, changeBtn, cancelPBtn){
    $(fileEleId).removeClass('removeMousePointer').removeClass('inputDisable_bg');
    $(changeBtn).hide();
    $(cancelPBtn).show();
}

function disableFileChange(fileEleId, changeBtn, cancelPBtn){
    $(fileEleId).addClass('removeMousePointer').addClass('inputDisable_bg');
    $(changeBtn).show();
    $(cancelPBtn).hide();
}

function changeFieldText(eleObj, otherRadioBtnId, pageKey){    
    var key = $(eleObj).val();
    var tbl = $(eleObj).closest('table');
    $('#bank_deposite_withdrawal_id').val('');
    tbl.find('input[type = text],input[type = date],input[type = file], select[name=txt_source_type], textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
    });
    if(pageKey == 'bank'){
        $('.current_balance').html(''); 
        $('#current_balance').val('');  
    }
    $('.deposit_withdrawal_key').val(key); // hidden key to detect bank deposit or widrawal 
    $('#load_accounts').empty();
    $('.account_no').html(''); 
    $('#account_no').val('');   
    $('#file_control_btn').hide();
    $('#photoPassbook').removeClass('removeMousePointer').removeClass('inputDisable_bg');
    
    //for hide show buttons and diables
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_save').show();
    $('#btn_clear').show();
    $('#btn_update').hide();
       
    $(eleObj).prop('disabled', true);
    $(otherRadioBtnId).prop('disabled', false);
    switch(key){
        case 'D': $('.deposit_withdraw_amt').html('Deposited Amount');
                  $('.deposit_withdraw_date').html('Deposited Date');
                  $('.deposit_withdraw_by').html('Deposited  By');   
                  $('.deposit_field').show();
                  break;
        case 'W': $('.deposit_withdraw_amt').html('Withdrawal Amount');
                  $('.deposit_withdraw_date').html('Withdrawal Date');
                  $('.deposit_withdraw_by').html('Withdrawal  By');
                  $('.deposit_field').hide();
                  break;
    }
}

function loadCurrentBankSatatus(eleObj, account_key,type){
    $('.messageDiv').hide();   
    var url = $(eleObj).val().split('&')[0];
    
    if(url == ''){        
        switch(type){
            case 'source':
                $('#spanSourceBalance').text('0.00');
                $('#txtSourceBalance').val(0);
                break;
            case 'target':
                $('#spanTargetBalance').text('0.00');
                $('#txtTargetBalance').val(0);
                break;
        }
        return false;
    }   
    
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,   
        //data: { 'cash_or_bank_id': id, 'account_key' : account_key },
        dataType: 'json',
        success: function(result) {
                    if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {      
                switch(type){
                    case 'source':
                        $('#spanSourceBalance').text(result.jsonData);
                        $('#txtSourceBalance').val(result.jsonData);
                        break;
                    case 'target':
                        $('#spanTargetBalance').text(result.jsonData);
                        $('#txtTargetBalance').val(result.jsonData);
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
            stopLoading();
        }
    });
}

function loadAccountsSource(keyValue, url){
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
			if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
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


function saveBankDepositWithdrawalHistory(url, eleObj){   
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    var key = $('.deposit_withdrawal_key').val(); // take hidden key value to detect bank deposit or widrawal
    var source_type = tbl.find('select[name~="txt_source_type"]'); 
    var amount = tbl.find('input[name~="txt_deposit_withdrawal_amount"]'); 
//    if(key == 'D'){      
//        if(source_type.val() != 7){  
//            var deposit_amount = amount.val();
//            var source_account_amount = $('.balance').val();
//            if( parseFloat(source_account_amount) < parseFloat(deposit_amount) ){
//                fnCmnWarningMessage('Can not proceed, source account balance is less than Deposit Amount, please check !'); 
//                fnCmnScrollToElementIDorClass('#wrapper'); 
//                amount.focus();
//                return false;
//            }                     
//        }
//    }
    if($('#inputTranType').val()=='CB' && $('#targetBank').val()==''){
        fnCmnWarningMessage('Select Target Bank .'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        $('#targetBank').focus();
        return false;
    }
    if($('#inputTranType').val()=='BB'){
        if($('#sourceBank').val()==''){
            fnCmnWarningMessage('Select Source Bank .'); 
            fnCmnScrollToElementIDorClass('#wrapper');
            $('#sourceBank').focus();
            return false;
        }
        if($('#targetBank').val()==''){
                fnCmnWarningMessage('Select Target Bank .'); 
                fnCmnScrollToElementIDorClass('#wrapper');
                $('#targetBank').focus();
                return false;
        } 
        if($('#sourceBank').val()!='' && ($('#sourceBank').val()==$('#targetBank').val())){
            fnCmnWarningMessage('Source and Target Bank cannot be same.'); 
            fnCmnScrollToElementIDorClass('#wrapper');
            $('#targetBank').focus();
            return false;
        }
    }
    if($('#inputTranType').val()=='BC' && $('#sourceBank').val()==''){
        fnCmnWarningMessage('Select Source Bank .'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        $('#sourceBank').focus();
        return false;
    }
    if(parseFloat($('#deposit_withdrawal_amount').val())<=0){
        fnCmnWarningMessage('Please enter a valid amount.'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        $('#targetBank').focus();
        return false;
    }
    if(parseFloat($('#deposit_withdrawal_amount').val())!=parseFloat($('#deposit_withdrawal_cnfirm_amount').val())){
        fnCmnWarningMessage('The Amount you entered does not match.'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        $('#targetBank').focus();
        return false;
    }
    var bank_name = tbl.find('select[name~="txt_bank"]'); 
    if(bank_name.val() == '' ){      
        fnCmnWarningMessage('Bank Name can\'t be empty !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        bank_name.focus();
        return false;
    }
//    if($('#paymentMode').val()==''){
//        fnCmnWarningMessage('Please select a transaction mode !'); 
//        fnCmnScrollToElementIDorClass('#wrapper');
//        bank_name.focus();
//        return false;
//    }
    if($('#deposit_withdrawal_date').val()==''){
        fnCmnWarningMessage('Please select transaction date !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        bank_name.focus();
        return false;
    }
    if($('#deposit_withdrawal_by').val()==''){
        fnCmnWarningMessage('Please enter the field transaction by !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        bank_name.focus();
        return false;
    }
    if($('#deposit_withdrawal_reciept').val()!=''){
        var fileInput=document.getElementById('deposit_withdrawal_reciept');
        var filename=fileInput.files[0].name;
        var validFiles=['jpg','jpeg','png','gif','bmp'];
        var extSplit = filename.split('.');
        var extReverse = extSplit.reverse();
        var ext = extReverse[0];        
        //var fsizeMb=fileInput.files[0].size/1024/1024;
        var isValid=false;
        for(var i=0;i<validFiles.length;i++){
            if(ext.toLowerCase()==validFiles[i]){
                isValid=true;
                break;
            }
        }       
         if(!isValid){
            fnCmnWarningMessage('The file you have chosen is invalid !');
            $('#deposit_withdrawal_reciept').focus();
            scrollToMessage();
            return;
        }
    }
    if($('#description').val().trim()==''){
        fnCmnWarningMessage('Please enter description !');
        $('#description').focus();
        scrollToMessage();
        return;
    }
    
    if(!confirm('Are you ready to proceed?')){
        return false;
    }
    
    var formData = new FormData($('#frmBankDepositWidrawal')[0]); 
  //  formData.append('txt_employee_id', $('#employeeID').val());
    
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
                switch(result.jsonData.code){
                    case 0: //if error occure when file upload
                            fnCmnWarningMessage(result.message);
                            fnCmnScrollToElementIDorClass('#wrapper');
                            break;
                    case 1: //successfully save then do this code
                            $('#display-list').empty().append(result.html);
                            paginationTbl();// for pagination        
                            fnCmnSuccessMessage(result.message);
                            fnCmnScrollToElementIDorClass('#wrapper');  
                            
                            tbl.find('input[type = text],input[type = file],select, textarea').each(function(){
                                //$(this).removeClass('inputDisable_bg').val('');
                                $(this).val('');
                            });
                            $('#balance').html('');  
                            $('.balance').val('');  
                            $('#current_balance_field').hide();   
                            //$('#bank_deposite_withdrawal_id').val(''); 
                            $('#load_accounts').empty();  
                            $('#payment_number').prop('readonly', false).removeClass('inputDisable_bg');
                            $('.account_no').html(''); 
                            $('#account_no').val('');
                            $('.current_balance').html(''); 
                            $('#current_balance').val('');  
                            $('#file_control_btn').hide();
                            $('#deposit_withdrawal_reciept').removeClass('removeMousePointer').removeClass('inputDisable_bg');  

                            $('#btn_save').show();
                            $('#btn_clear').show();
                           // $('#btn_update').hide();
                           // $('#btn_edit').hide();
                           // $('#btn_cancel').hide(); 
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}
function ManageContraTransaction(url, eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    if($('#inputTranType').val()=='CB' && $('#targetBank').val()==''){
        fnCmnWarningMessage('Select Target Bank .'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        $('#targetBank').focus();
        return;
    }
    if($('#inputTranType').val()=='BB'){
        if($('#sourceBank').val()==''){
            fnCmnWarningMessage('Select Source Bank .'); 
            fnCmnScrollToElementIDorClass('#wrapper');
            $('#sourceBank').focus();
            return;
        }
        if($('#targetBank').val()==''){
                fnCmnWarningMessage('Select Target Bank .'); 
                fnCmnScrollToElementIDorClass('#wrapper');
                $('#targetBank').focus();
                return;
        } 
        if($('#sourceBank').val()!='' && ($('#sourceBank').val()==$('#targetBank').val())){
            fnCmnWarningMessage('Source and Target Bank cannot be same.'); 
            fnCmnScrollToElementIDorClass('#wrapper');
            $('#targetBank').focus();
            return;
        }
    }
    if($('#inputTranType').val()=='BC' && $('#sourceBank').val()==''){
        fnCmnWarningMessage('Select Source Bank .'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        $('#sourceBank').focus();
        return;
    }
    if(parseFloat($('#deposit_withdrawal_amount').val())<=0){
        fnCmnWarningMessage('Please enter a valid amount.'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        $('#targetBank').focus();
        return;
    }
    if(parseFloat($('#deposit_withdrawal_amount').val())!=parseFloat($('#deposit_withdrawal_cnfirm_amount').val())){
        fnCmnWarningMessage('The Amount you entered does not match.'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        $('#targetBank').focus();
        return;
    }
    var bank_name = tbl.find('select[name~="txt_bank"]'); 
    if(bank_name.val() == '' ){      
        fnCmnWarningMessage('Bank Name can\'t be empty !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        bank_name.focus();
        return;
    }
    if($('#deposit_withdrawal_date').val()==''){
        fnCmnWarningMessage('Please select transaction date !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        bank_name.focus();
        return;
    }
    if($('#deposit_withdrawal_by').val()==''){
        fnCmnWarningMessage('Please enter the field transaction by !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        bank_name.focus();
        return;
    }
    if($('#deposit_withdrawal_reciept').val()!=''){
        var fileInput=document.getElementById('deposit_withdrawal_reciept');
        var filename=fileInput.files[0].name;
        var validFiles=['jpg','jpeg','png','gif','bmp'];
        var extSplit = filename.split('.');
        var extReverse = extSplit.reverse();
        var ext = extReverse[0];        
        //var fsizeMb=fileInput.files[0].size/1024/1024;
        var isValid=false;
        for(var i=0;i<validFiles.length;i++){
            if(ext.toLowerCase()==validFiles[i]){
                isValid=true;
                break;
            }
        }       
         if(!isValid){
            fnCmnWarningMessage('The file you have chosen is invalid !');
            $('#deposit_withdrawal_reciept').focus();
            scrollToMessage();
            return;
        }
    }
    if($('#description').val().trim()==''){
        fnCmnWarningMessage('Please enter description !');
        $('#description').focus();
        scrollToMessage();
        return;
    }
    
    if(!confirm('Are you ready to proceed?')){
        return false;
    }
    
    var formData = new FormData($('#frmBankDepositWidrawal')[0]); 
  //  formData.append('txt_employee_id', $('#employeeID').val());
    
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
            if (result.success){ 
                if($('#inputTranType').val()=='CB' || $('#inputTranType').val()=='BC'){
                                       
                }   
                $('#bCashBalance').empty().html('&#8377; '+ result.jsonData.cashbal);        
                $('#spanSourceBalance').empty().html('&#8377; '+result.jsonData.sourcebal);
                $('#spanTargetBalance').empty().html('&#8377; '+result.jsonData.targetbal);
                $('#tdTranList').empty().append(result.html);
                paginationTbl();
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}
function contraAction(url,action){
    $('.messageDiv').hide();
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected transaction record?')){
            return;
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
            if (result.success){
                if(action=='del'){
                    $('#tdTranList').empty().append(result.html);
                    paginationTbl();
                    fnCmnSuccessMessage(result.message);
                }else if(action=='upd'){
                    var obj=result.jsonData.contra;
                    $('#bank_deposite_withdrawal_id').val(obj.pkid);
                    $('#inputTranType').val(obj.transactionTypeFk.custom1);                   
                    if(obj.sourceFk!=null){
                        $('#sourceBank > option').each(function(){
                           if(this.value.split('&')[1]==obj.sourceFk.bankPk){ 
                               $('#sourceBank').val(this.value);
                            }
                        });                        
                    }
                    if(obj.targetFk!=null){
                        $('#targetBank > option').each(function(){
                           if(this.value.split('&')[1]==obj.targetFk.bankPk){ 
                               $('#targetBank').val(this.value);
                           }
                        });
                    }
                    $('#bRcptNo').empty().text(obj.receiptNo);                    
                    $('#spanSourceBalance').empty().html('&#8377 '+ result.jsonData.sourceBal);
                    $('#spanTargetBalance').empty().html('&#8377 '+ result.jsonData.targetBal);
                    $('#deposit_withdrawal_amount').val(obj.amount);
                    $('#deposit_withdrawal_cnfirm_amount').val(obj.amount);
                    $('#deposit_withdrawal_date').val($.datepicker.formatDate('dd M yyyy', new Date(obj.transactionDate)));
                    $('#deposit_withdrawal_by').val(obj.transactionBy);
                    if(result.html!=''){
                        $('#file_control_btn').empty().append(result.html);
                        $('#file_control_btn').show();
                        $('#divFile').hide();
                    }else{
                        $('#file_control_btn').empty().hide();
                        $('#divFile').show();
                    }
                    $('#description').val(obj.remarks);
                    switch(obj.transactionTypeFk.custom1){
                        case 'CB':
                            $('#radioCB').prop('checked','true');
                            $('#trCashBal').show();
                            $('#trSourceBank').hide();            
                            $('#trTargetBank').show();            
                            break;
                        case 'BB':
                            $('#radioBB').prop('checked','true');
                            $('#trSourceBank').show();            
                            $('#trTargetBank').show();
                            $('#trCashBal').hide();
                            break;
                        case 'BC':
                            $('#radioBC').prop('checked','true');
                            $('#trCashBal').show();
                            $('#trSourceBank').show();            
                            $('#trTargetBank').hide();            
                            break;
                    }
                    $('#trRcptNo').show();
                    $('#btn_save').hide();
                    $('#btnCancel').show();
                    $('#btn_edit').show();
                    document.getElementsByClassName('application-form')[0].scrollIntoView();
                } 
                stopLoading();
            }
            else{
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
                stopLoading();
            }
            
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}
function DeleteContraTransaction(url){
    $('.messageDiv').hide();
    if(!confirm('Are you sure you want to delete this record?')){
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
            if (result.success){
                $('.application-form').empty.append(result.html);
                fnCmnSuccessMessage(result.msg);
                document.getElementById('messageDiv').scrollIntoView();
            }else{
                fnCmnSuccessMessage(result.msg);
                document.getElementById('messageDiv').scrollIntoView();
            }
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });  
}
function changeProof(){
    $('#file_control_btn').hide();
    $('#divFile').show();
    $('#cancel_a').show();
}
function cancelChangeProof(){
    $('#file_control_btn').show();
    $('#divFile').hide();
    $('#cancel_a').hide();
    $('#deposit_withdrawal_reciept').val('');
}
function ToggleRemoveFile(obj){
    if($('#inputIsDel').val()=='1'){
        $(obj).html('Delete');
        $('#inputIsDel').val('');
    }else{
        $(obj).html('Undo');
        $('#inputIsDel').val('1');
    }
}

function cancelBankDepositWithdrawalHistory(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');    
     //for hide show buttons and diables fields                     
    tbl.find('input[type = text],input[type = file],input[type = date], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
    });
    $('.account_no').html(''); 
    $('#account_no').val('');
    $('.current_balance').html(''); 
    $('#current_balance').val('');  
    $('#bank_deposite_withdrawal_id').val('');
    $('#file_control_btn').hide();
    $('#photoPassbook').removeClass('removeMousePointer').removeClass('inputDisable_bg');
    
    //for hide show buttons and diables
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_save').show();
    $('#btn_clear').show();
    $('#btn_update').hide();
}

function bankDepositWidrawHistoryAction(eleObj, accHeadId, actionID){ 
    $('.messageDiv').hide(); 
    
    var rawurl = $(actionID + accHeadId).val(); 
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
                      case 'upd' :                                                                                               
                                   $('#bank_deposite_withdrawal_id').val(result.jsonData.bank_deposite_withdrawal_id); 
                                   $('#bank').val(result.jsonData.bank_id); 
                                   $('#deposit_withdrawal_amount').val(result.jsonData.amount); 
                                   $('#deposit_withdrawal_date').val(result.jsonData.date); 
                                   $('#deposit_withdrawal_by').val(result.jsonData.deposit_withdraw_by); 
                                   $('#description').val(result.jsonData.description); 
                                   $('.account_no').html(result.jsonData.account_no); 
                                   $('#account_no').val(result.jsonData.account_no);
                                   $('.current_balance').html(result.jsonData.current_balance); 
                                   $('#current_balance').val(result.jsonData.current_balance); 
                                   $('#paymentMode').val(result.jsonData.payment_mode_id);                                    
                                   $('#keyToDetectCash' + result.jsonData.payment_mode_id).val(result.jsonData.payement_mode_cash_check_val);
                                   if(result.jsonData.payement_no == 0){
                                       $('#payment_number').val(''); 
                                   }else{
                                       $('#payment_number').val(result.jsonData.payement_no); 
                                   }
                                   
                                   // for radio button controls
                                   $('.radioBtnKey').prop('checked', false).prop('disabled', false);
                                   switch(result.jsonData.deposit_widrawal_key){
                                       case 'D':   $('#deposit_key').prop('checked', true).prop('disabled', true);
                                                   $('.deposit_withdrawal_key').val(result.jsonData.deposit_widrawal_key);
                                                   break;
                                       case 'W':   $('#withdrawal_key').prop('checked', true).prop('disabled', true);
                                                   $('.deposit_withdrawal_key').val(result.jsonData.deposit_widrawal_key);
                                                   break;
                                   }
                                   
                                   if(result.jsonData.receipt_doc_file != ''){
                                       $('#file_control_btn').show();
                                       $('#deposit_withdrawal_reciept').addClass('removeMousePointer').addClass('inputDisable_bg');
                                       $('#changePassbookBtn').show();
                                       $('#cancelPassbookBtn').hide();
                                   }else{
                                       $('#file_control_btn').hide();
                                       $('#deposit_withdrawal_reciept').removeClass('removeMousePointer').removeClass('inputDisable_bg');                                    
                                   }
                                                                                                                                    
                                   $('#btn_cancel').show();
                                   $('#btn_save').hide();
                                   $('#btn_clear').hide();
                                   $('#btn_update').show();
                                   break;
                      case 'del' : 
                                   $(eleObj).closest('tr').empty().remove();                          
                                   fnCmnSuccessMessage(result.message);
                                   fnCmnScrollToElementIDorClass('#wrapper');
                                                          
                                   var tbl = $('#bank_deposit_withdrawal_form_tbl');  
                                   tbl.find('input[type = text], input[type = file], input[type = date], select, textarea').each(function(){
                                        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');               
                                   });
                                   $('.account_no').html(''); 
                                   $('#account_no').val('');
                                   $('.current_balance').html(''); 
                                   $('#current_balance').val(''); 
                                   $('#bank_deposite_withdrawal_id').val(''); 
                                   $('#file_control_btn').hide();
                                   $('#deposit_withdrawal_reciept').removeClass('removeMousePointer').removeClass('inputDisable_bg');
                                   
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function loadDepositWithdrawalHistory(url){
    $('.messageDiv').hide();
    if($('#year').val() == ''){
       commonMessageAlert('Year can\'t be empty !');
       fnCmnScrollToElementIDorClass('#wrapper'); 
       $('#year').focus();
       $('#month').val('');
       return false;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: { 'month' : $('#month').val(), 'year': $('#year').val()},    
        dataType: 'json',
        success: function(result) { 
				if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }        
            if (result.success) {      
                $('#display-list').empty().append(result.html);
                paginationTbl();// for pagination     
                
                $('#periodDate').removeClass('inputDisable_bg');
                $('#month').val('').addClass('inputDisable_bg');
                $('#year').val('').addClass('inputDisable_bg');
                
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
               
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function loadDepositWithdrawalHistoryByDate(eleObj, url){ 
    $('.messageDiv').hide(); 
    if($(eleObj).val() == ''){
//       commonMessageAlert('Year can\'t be empty !');
//       fnCmnScrollToElementIDorClass('#wrapper'); 
//       $('#year').focus();
       return false;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: { 'date' : $(eleObj).val() },    
        dataType: 'json',
        success: function(result) { 
				if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }        
            if (result.success) {    
                $('#display-list').empty().append(result.html);
                paginationTbl();// for pagination 
                
                $(eleObj).removeClass('inputDisable_bg');
                $('#month').val('').addClass('inputDisable_bg');
                $('#year').val('').addClass('inputDisable_bg');
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
               
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function showEmpDetails(eleObj, url){
    $('.messageDiv').hide(); 
    var empPkid = $(eleObj).val();
    if(empPkid == ''){   
        $('.empID').html(''); 
        $('.empName').html(''); 
        $('.empDesignation').html(''); 
        $('.addFields').hide();       
        return false;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,  
        data: { 'empPkid' : empPkid },
        dataType: 'json',
        success: function(result) {
			if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {           
                   $('.empID').html(result.jsonData.emp_id);                   
                   $('.empDesignation').html(result.jsonData.emp_desigation); 
                   $('.addFields').show(); 
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function creatCashAccount(url, eleObj){   
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    
    var employee = tbl.find('select[name~="txt_employee_pkid"]'); 
    if(employee.val() == '' ){      
        fnCmnWarningMessage('Please select one of the Employee !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        employee.focus();
        return false;
    }
    var create_date = tbl.find('input[name~="txt_create_date"]'); 
    if(create_date.val().trim() == '' ){       
        fnCmnWarningMessage('Create Date can not be blank !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        create_date.focus();
        return false;
    }
    
    
    var description = tbl.find('textarea[name~="txt_description"]'); 
    if(description.val().trim() == '' ){       
        fnCmnWarningMessage('Please give some description !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        description.focus();
        return false;
    }
    
    var formData = $('form#frmCreateCashAccount').serializeObject();
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
                if(result.jsonData.cash_acc_flag == 0){
                    $('#display-list').empty().append(result.html);
                    paginationTbl();// for pagination   month
                    
                    fnCmnSuccessMessage(result.message);
                    fnCmnScrollToElementIDorClass('#wrapper');                
                    
                    //for hide show buttons and diables fields                  
                    tbl.find('input[type = date], select, textarea').each(function(){
                        $(this).val('');               
                    });
                    $('#cash_acc_id').val('');   
                    $('#record_active_key').val(1);
                    $('.record_active_key').hide();
                    $('.empID').html('');                   
                    $('.empDesignation').html(''); 
                    $('.addFields').hide(); 
                                      
                    $('#btn_edit').hide();
                    $('#btn_cancel').hide();
                    $('#btn_save').show();
                    $('#btn_clear').hide();
                    $('#btn_update').hide();  
                } else{
                    fnCmnWarningMessage(result.message);
                    fnCmnScrollToElementIDorClass('#wrapper');
                    $('#employee_pkid').focus();
                }                                           
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
               
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function editCashAccountFields(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    
     //for hide show buttons and diables fields                  
    tbl.find('input[type = date], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg');               
    });
    $('#btn_edit').hide();
    $('#btn_cancel').show();
    $('#btn_save').hide();
    $('#btn_clear').hide();
    $('#btn_update').show();
}

function cancelCashAccountFields(eleObj){
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');  
    
     //for hide show buttons and diables fields                  
    tbl.find('input[type = date], select, textarea').each(function(){
        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');             
    });
    $('#record_active_key').val(1);
    $('.record_active_key').hide();
    $('#cash_acc_id').val('');   
    $('.empID').html(''); 
    $('.empDesignation').html(''); 
    $('.addFields').hide(); 
       
    $('#btn_edit').hide();
    $('#btn_cancel').hide();
    $('#btn_save').show();
    $('#btn_clear').hide();
    $('#btn_update').hide();
}

function accountCashAction(eleObj, accHeadId, actionID){ 
    $('.messageDiv').hide(); 
    
    var rawurl = $(actionID + accHeadId).val(); 
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete cash account ?'))
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
                                   $('#cash_acc_id').val(result.jsonData.cash_acc_id); 
                                   $('#employee_pkid').val(result.jsonData.emp_pkid);
                                   $('.empID').html(result.jsonData.emp_id);                                   
                                   $('.empDesignation').html(result.jsonData.emp_designation); 
                                   $('.addFields').show();                                 
                                   $('#create_date').val(result.jsonData.create_date); 
                                   $('#record_active_key').val(result.jsonData.status); 
                                   $('#description').val(result.jsonData.description);                                   
                                   
                                   $('.record_active_key').show();
                                   $('#btn_cancel').show();
                                   $('#btn_save').hide();
                                   $('#btn_clear').hide();
                                   $('#btn_update').show();
                                   break;
                      case 'del' : 
                                   $('#display-list').empty().append(result.html);
                                   paginationTbl();// for pagination   month                         
                                   fnCmnSuccessMessage(result.message);
                                   fnCmnScrollToElementIDorClass('#wrapper');
                                                          
                                   var tbl = $('#create_cash_account_form_tbl');  
                                   tbl.find('input[type = date], select, textarea').each(function(){
                                        $(this).prop('disabled', false).removeClass('inputDisable_bg').val('');             
                                    });
                                   $('#record_active_key').val(1);
                                   $('.record_active_key').hide();
                                   $('#cash_acc_id').val('');   
                                   $('.empID').html('');                                   
                                   $('.empDesignation').html(''); 
                                   $('.addFields').hide(); 

                                   $('#btn_edit').hide();
                                   $('#btn_cancel').hide();
                                   $('#btn_save').show();
                                   $('#btn_clear').hide();
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
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function loadSourceTypeId(eleObj, pageType, url){
    var source_type = $(eleObj).val();
//    if(source_type == '' || source_type == 7){ paymentModeField
//        $('#load_accounts').empty();  
//        $('#balance').html('');  
//        $('.balance').val('');  
//        $('#current_balance_field').hide();         
//        return false;
//    }
    
    var cash_bank_id;
    switch(pageType){
        case 'CA':  //use in cash account page
                    var cash_account_id = $('#cashAccount'); 
                    if(cash_account_id.val() == ''){
                        fnCmnWarningMessage('Please select, one of the Cash Account first!'); 
                        fnCmnScrollToElementIDorClass('#wrapper');
                        cash_account_id.focus();
                        $(eleObj).val('');
                        return false;
                    }
                    cash_bank_id = cash_account_id.val();
                   break;
        case 'BA': //use in bank account page
                    var bank_account_id = $('#bank');
                    if(bank_account_id.val() == ''){
                        fnCmnWarningMessage('Please select, one of the Bank Account first!'); 
                        fnCmnScrollToElementIDorClass('#wrapper');
                        bank_account_id.focus();
                        $(eleObj).val('');
                        return false;
                    }
                    cash_bank_id = bank_account_id.val(); 
                    break;
    }
    if(source_type == '' || source_type == 1){
        $('#paymentModeField').show();
    }else if(source_type == 2){
        $('#paymentModeField').hide();
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: { 'source_type_id': source_type, 'cash_bank_account_id' : cash_bank_id, 'page_type' : pageType },
        dataType: 'json',
        success: function(result) {
			if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {           
                $('#load_accounts').empty().append(result.html);                 
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
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}


function saveCashBankDepositWithdrawalHistory(url, eleObj){   
    $('.messageDiv').hide();
    var tbl = $(eleObj).closest('table');
    var key = $('.deposit_withdrawal_key').val(); // take hidden key value to detect bank deposit or widrawal
    var source_type = tbl.find('select[name~="txt_source_type"]'); 
    var amount = tbl.find('input[name~="txt_deposit_withdrawal_amount"]'); 
    if(key == 'D'){      
        if(source_type.val() != 7){  
            var deposit_amount = amount.val();
            var source_account_amount = $('.balance').val();
            if( parseFloat(source_account_amount) < parseFloat(deposit_amount) ){
                fnCmnWarningMessage('Can not proceed, souce account balance is less than Deposit Amount, please check !'); 
                fnCmnScrollToElementIDorClass('#wrapper'); 
                amount.focus();
                return false;
            }                     
        }
    }
     
    var cash_acc = tbl.find('select[name~="txt_cash_account"]'); 
    if(cash_acc.val() == '' ){      
        fnCmnWarningMessage('Please select one of the Cash Account !'); 
        fnCmnScrollToElementIDorClass('#wrapper');
        cash_acc.focus();
        return false;
    }
    
    var current_balance = tbl.find('input[name~="txt_current_balance"]'); 
    if(key == 'W'){ 
        if(current_balance.val().trim() == 0 ){      
            fnCmnWarningMessage('Can not proceed withdrawal operation, the current bank account seems to zero(0) balance !'); 
            fnCmnScrollToElementIDorClass('#wrapper');        
            return false;
        }
    }
    
    if(amount.val() == '' ){   
        if(key == 'D'){
            fnCmnWarningMessage('Deposited Amount  can not be blank !');
        }else{
            fnCmnWarningMessage('Withdrawal Amount  can not be blank !');
        }      
        fnCmnScrollToElementIDorClass('#wrapper');
        amount.focus();
        return false;
    }
    //check balance for withdrawal
    if(key == 'W'){
        if(parseInt(amount.val()) > parseInt(current_balance.val())){
            fnCmnWarningMessage('Withdrawal Amount can not be greater than current cash account balance, please adjust !');
            fnCmnScrollToElementIDorClass('#wrapper');
            amount.focus();
            return false;
        }
    }
    
    
    var date = tbl.find('input[name~="txt_deposit_withdrawal_date"]'); 
    if(date.val().trim() == '' ){       
        if(key == 'D'){
            fnCmnWarningMessage('Deposited Date can not be blank !');
        }else{
            fnCmnWarningMessage('Withdrawal Date can not be blank !');
        }  
        fnCmnScrollToElementIDorClass('#wrapper');
        date.focus();
        return false;
    }
    var deposit_withdraw_by = tbl.find('input[name~="txt_deposit_withdrawal_by"]'); 
    if(deposit_withdraw_by.val().trim() == '' ){      
        if(key == 'D'){
            fnCmnWarningMessage('Deposited By can not be blank !');
        }else{
            fnCmnWarningMessage('Withdrawal By can not be blank !');
        } 
        fnCmnScrollToElementIDorClass('#wrapper');
        deposit_withdraw_by.focus();
        return false;
    }
    if(key == 'D'){
        var source_type = tbl.find('select[name~="txt_source_type"]'); 
        if(source_type.val() == '' ){      
            fnCmnWarningMessage('Please select one of the Source Type !');
            fnCmnScrollToElementIDorClass('#wrapper');
            source_type.focus();
            return false;
        }

        if(source_type.val() != 7){
            var source_id = tbl.find('select[name~="txt_source_id"]'); 
            if (source_id.val() == '') {
                fnCmnWarningMessage('Please select one of the Source ID !');
                fnCmnScrollToElementIDorClass('#wrapper');
                source_id.focus();
                return false;
            }
        }
    }
    var description = tbl.find('textarea[name~="txt_description"]'); 
    if(description.val().trim() == '' ){             
        fnCmnWarningMessage('Description can not be blank !');      
        fnCmnScrollToElementIDorClass('#wrapper');
        description.focus();
        return false;
    } 
    
    if(!confirm('Save record can not be editable and deletable, are you sure you want to save record ?')){
            return false;
    }
    var formData = new FormData($('#frmCashDepositWidrawal')[0]); 
  //  formData.append('txt_employee_id', $('#employeeID').val());
    
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
                $('#display_list').empty().append(result.html);
                paginationTbl();// for pagination        
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');  
                tbl.find('input[type = text],input[type = file],select, textarea').each(function(){
                    $(this).val('');               
                });  
                $('#cashAccount').val(result.jsonData.cashAcountPkid);
                $('.current_balance').html(result.jsonData.cashAccountCurrentBalance);
                $('#current_balance').val(result.jsonData.cashAccountCurrentBalance);
                $('#balance').html('');  
                $('.balance').val('');  
                $('#current_balance_field').hide();               
                $('#load_accounts').empty();           
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function searchCustomerAdvanceCollection(url, cusPkid){
    $('.messageDiv').hide();   
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: { 'customerPkid': cusPkid },
        dataType: 'json',
        success: function(result) {
			if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {           
                $('#adjust_advance_collection').empty().append(result.html); 
                fnHideShow('collection_customer_list');
                if(result.jsonData.cus_advance_search_flag == 1){                  
                    if(result.jsonData.cus_advance_search_flag){
                        $('#control_btn').show();
                        $('#customer_details').show();
                        $('#customer_details').html('Adjustment for the advance collection  of Customer ID: '+ result.jsonData.customer_id +', ' + result.jsonData.customer_name);
                    }                 
                }else{
                    $('#control_btn').hide();
                    $('#customer_details').html('');
                    $('#customer_details').hide();
                }            
                //calculate customer advance total
                var advance_total = 0;
                $('#advanceCollectionListTbl').find('.advance_amount').each(function(){  
                    advance_total = advance_total + parseFloat($(this).val());
                });
                $('.totalAmount').html(advance_total);
                $('.requiredAdjustAmount').html(advance_total);
                $('#requiredAdjustAmount').val(advance_total);
                $('#requiredNonAdjustableAmount').val(advance_total);
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}

function fnAdjustAdvanceCollectionAmount(eleObj, projectPkid){
    $('.messageDiv').hide();
    $('#alert_amount'+projectPkid).val('');
    $('#alert_pc'+projectPkid).val('');
    var require_adjust_amount = $('#requiredNonAdjustableAmount').val(); 
    var total = 0;
    $('#cus_advance_adjust_form_tbl').find('.calculateField').each(function(){
        var field_value = $(this).val();
        if(field_value == ''){
            field_value = 0;
        }
        total = total + parseFloat(field_value);
    });
    if(parseFloat(require_adjust_amount) < total ){
        fnCmnWarningMessage('Total entry amount can not be greater than required adjust amount !');
        fnCmnScrollToElementIDorClass('#wrapper');    
        var current_element_val = $(eleObj).val();
        var new_value = current_element_val.substring(0, (current_element_val.length - 1));
        $(eleObj).val(new_value);
        return false;
    }else{
        var remaining_amount = parseFloat(require_adjust_amount) - total;
        $('.requiredAdjustAmount').html(remaining_amount);
        $('#requiredAdjustAmount').val(remaining_amount);
    }   
}

function fnCheckInvoiceDueAmount(eleObj, invoicePkid){
    var invoice_due_balance = $('#invoice_due_balance'+invoicePkid).val(); 
    var current_input_value = $(eleObj).val();
    if(parseFloat(current_input_value) > parseFloat(invoice_due_balance)){ 
        fnCmnWarningMessage('Entry amount can not be greater than invoice due balance !');
        fnCmnScrollToElementIDorClass('#wrapper');         
        var new_value = current_input_value.substring(0, (current_input_value.length - 1));
        $(eleObj).val(new_value);
        return false;
    }else{
        fnAdjustAdvanceCollectionAmount(eleObj);
        return;
    }
}

function fnCalculatePcByGivingAmount(eleObj, projectPkid){
    var project_advance = $('#project_advance_amount'+projectPkid).val();
    if(project_advance == ''){
        fnCmnWarningMessage('Please fill out first Project Advance field !');
        fnCmnScrollToElementIDorClass('#wrapper');        
        $('#project_advance_amount'+projectPkid).focus();
        $(eleObj).val(''); 
        return false;
    }
    var amount = $(eleObj).val(); 
    if(amount == '' ){ amount = 0; }
    if(parseFloat(amount) > parseFloat(project_advance)){
        fnCmnWarningMessage('Amount can not be greater than Project Advance amount !');
        fnCmnScrollToElementIDorClass('#wrapper');              
        var new_value = amount.substring(0, (amount.length - 1));
        $(eleObj).val(new_value);
        return false;
    }else{
        var percentage = (100 * parseFloat(amount)) / parseFloat(project_advance);
        if(percentage == 0){ percentage = ''; }
        $('#alert_pc'+projectPkid).val(percentage);
    }        
}

function fnCalculateAmountByGivingPC(eleObj, projectPkid){
    var project_advance = $('#project_advance_amount'+projectPkid).val();
    if(project_advance == ''){
        fnCmnWarningMessage('Please fill out first Project Advance field !');
        fnCmnScrollToElementIDorClass('#wrapper');        
        $('#project_advance_amount'+projectPkid).focus();
        $(eleObj).val(''); 
        return false;
    }
    var pc = $(eleObj).val(); 
    if(pc == '' ){ pc = 0; }
    if(parseFloat(pc) > 100){
        fnCmnWarningMessage('Percentage can not be greater than 100%!');
        fnCmnScrollToElementIDorClass('#wrapper');        
        var new_value = pc.substring(0, (pc.length - 1));
        $(eleObj).val(new_value);
        return false;
    }else{ 
       var amount = ( parseFloat(pc)/ 100) * parseFloat(project_advance);    
       if(amount == 0){ amount = ''; }
       $('#alert_amount'+projectPkid).val(amount); 
    }   
}


function saveCustomerAdvanceAdjust(url, eleObj){
    $('.messageDiv').hide();
    var requiredAdjustAmount = $('#requiredAdjustAmount').val();
    if(requiredAdjustAmount != 0){
        fnCmnWarningMessage('please adjust total required amount to proceed... !');      
        fnCmnScrollToElementIDorClass('#wrapper');       
        return false;
    }
    var formData = $('form#frmCusAdvanceAdjust').serializeObject();
    var dataString = JSON.stringify(formData);
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
                $('#list_of_customer_payment_collection').empty().append(result.html); 
                paginationTbl();// for pagination    
                fnHideShow('collection_customer_list');
                fnCmnSuccessMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper'); 
                $('#customer_id').val('');    
                $('#control_btn').hide();               
                $('#customer_details').html('');
                $('#customer_details').hide();
                $('#adjust_advance_collection').empty();
            }
            else {
                fnCmnErrorMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');
            }
             stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            fnCmnScrollToElementIDorClass('#wrapper');
        }
    });
}


function checkSanctionField(eleObj, accountType, sanctionPkid){
    $('.messageDiv').hide(); 
    var checkCount = 0;
    $('#sanction_salary_amount_tbl').find('.checkSalarySanctionId').each(function(){
        if($(this).prop('checked') == true){
            checkCount = parseInt(checkCount) + 1;
        }         
    });
    
    if (checkCount > 1) {     
        $(eleObj).prop('checked', false);
        commonMessageAlert('Sanction should be done only one at a time, please select only one sanction amount !');
        return false;
    }
  
    if(accountType == 'cash'){
        if(checkCount == 0){ 
            $('#paymentMode').removeClass('inputDisable_bg').removeClass('removeMousePointer'); 
            $('#payment_number').prop('readonly', false).removeClass('inputDisable_bg');
            $('#sanction_control_btn').hide();
            $('#sanction_pkid').val('');
            $('#sanction_salary_amount_tbl').find('#paymentMode, #payment_number, #date, #description').each(function() {
                $(this).val('');
            });
        }else{
            $('#paymentMode').addClass('inputDisable_bg').addClass('removeMousePointer'); 
            $('#payment_number').prop('readonly', true).addClass('inputDisable_bg');  
            $('#sanction_pkid').val(sanctionPkid);
            $('#sanction_control_btn').show();
        }         
    }else if(accountType == 'bank'){
        if(checkCount == 0){ 
            $('#sanction_control_btn').hide();
            $('#sanction_pkid').val('');
            $('#sanction_salary_amount_tbl').find('#paymentMode, #payment_number, #date, #description').each(function() {
                $(this).val('');
            });
        }else{
            $('#sanction_pkid').val(sanctionPkid);
            $('#sanction_control_btn').show();
        }
        $('#payment_number').prop('readonly', false).removeClass('inputDisable_bg');
    }
    
}


function cmnSanctionOrRejectSalarySlip(eleObj, url, action){
    $('.messageDiv').hide();
    var tbl = $('#sanction_salary_amount_tbl');
    
    //check selected advance payment or not
    var checkflag = 0;
    
    tbl.find('input[type = checkbox]').each(function(){
            if($(this).prop('checked') == true){
                checkflag = 1;
            }               
     }); 

    if(checkflag == 0){
       commonMessageAlert('Please select one of the sanction salary amount !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    } 
    if(action == 'Sanction'){
        var sanctionId = $('.checkSalarySanctionId:checkbox:checked').val();
        var accountType = $('#accountType'+sanctionId).val();
        if(accountType == 'bank'){
            var payment_mode = tbl.find('select[name=txt_payment_mode]');
            if(payment_mode.val()== ''){
               commonMessageAlert('please select Payment mode !');
               fnCmnScrollToElementIDorClass('#wrapper');
               payment_mode.focus();
               return false;
            }
            var payment_number = tbl.find('input[name=txt_payment_number]');
            if(payment_number.val().trim() == ''){
               commonMessageAlert('Payment No. can\'t be blank !');
               fnCmnScrollToElementIDorClass('#wrapper');
               payment_number.focus();
               return false;
            }
        }           
    }
    var date = tbl.find('input[name~="txt_date"]');
    if(date.val().trim() == ''){
       date.focus();
       commonMessageAlert('Date can not be blank !');
       fnCmnScrollToElementIDorClass('#wrapper');
       return false;
    }
    var description = tbl.find('textarea[name=txt_description]');
    if(description.val().trim()== ''){
       commonMessageAlert('Please give some description !');
       fnCmnScrollToElementIDorClass('#wrapper');
       description.focus();
       return false;
    }
    
    
    var alertMsg = '';
    switch(action){
        case 'Sanction': alertMsg = 'Are you sure to sanction selected amount ?';
                  break;
        case 'Reject': alertMsg = 'Are you sure to reject selected sanction amount ?';
                  break;
    }
    if(!confirm(alertMsg)){
        return false;
    }
   
    var formData = $('form#frmSanctionSalaryAmount').serializeObject();  
    var addData = { 'key' : action};
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
                $('.application-form').empty().append(result.html);   
                paginationTbl();// for pagination 
                
                //for count pop up
                if(result.jsonData.totalSanctionSalary > 0){
                    $('#countText').html(result.jsonData.totalSanctionSalary);                  
                }else{
                    $('#countText').hide();
                }
                
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

function toggleTranType(element,url){
    $('.messageDiv').hide();
    var tranType=$(element).val();
    $('#inputTranType').val(tranType);
    $('#sourceBank').val('');
    $('#targetBank').val('');
    $('#spanTargetBalance').text('0.00');
    $('#spanSourceBalance').text('0.00');
    $('#txtSourceBalance').val(0);
    $('#txtTargetBalance').val(0);
    switch(tranType){
        case 'CB':
            $('#trSourceBank').hide();            
            $('#trTargetBank').show();            
            break;
        case 'BB':
            $('#trSourceBank').show();            
            $('#trTargetBank').show();
            $('#trCashBal').hide();
            break;
        case 'BC':
            $('#trSourceBank').show();            
            $('#trTargetBank').hide();            
            break;

    }
    if( tranType=='CB' || tranType=='BC'){
        startLoading();
        $.ajax({
            type: 'POST',
            url: url,            
            contentType: 'application/json',
            dataType: 'json',
            success: function(result) {                
                if (result.success) {
                    $('#').empty().html('&#8377;'+result.jsonData);
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
        $('#trCashBal').show();
    }
}