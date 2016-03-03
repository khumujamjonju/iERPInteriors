function SearchEmployee(elementObj){
    
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="selectedEMp"]').val().trim()==''){
        commonMessageAlert('Please select employee first!');
        return false;
    } 
    $('.messageDiv').hide();
    startLoading();
    var url=$('#inputsearchempUrl').val();
    var frmData=$('form#WalletEntry').serializeObject();
    var dataString=JSON.stringify(frmData);
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
                stopLoading();
                $('#divEmpDetails').empty().append(result.html);  
                $('#btnUpdate').hide();
                }
            else{
                $('#divEmpDetails').empty();
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}


function autoCompleteEmployeeSearch(url,elementObj){
    var tbl = $(elementObj).closest('table');
    if (tbl.find('input[name~="employeename"]').val().trim()=='') {
        commonMessageAlert('Enter Employee ID!');
        return false;
    } 
    
$('.messageDiv').hide();
    startLoading();
    var frmData=$('form#WalletDeposit').serializeObject();
    var dataString=JSON.stringify(frmData);
    
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
                stopLoading();
                $('#divEmpWalletDetails').empty().append(result.html);  
                $('#btnUpdate').hide();
                }
            else{
                $('#divEmpWalletDetails').empty();
                stopLoading();
                fnCmnWarningMessage('No result found! please create employee wallet');
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
   
}

function autoCompleteEmployeeAtmSearch(url,elementObj){
var tbl = $(elementObj).closest('table');
if (tbl.find('input[name~="employeename"]').val().trim()=='') {
        commonMessageAlert('Enter Employee ID!');
        return false;
} 
$('.messageDiv').hide();
    startLoading();
    var frmData=$('form#WalletAtmDeposit').serializeObject();
    var dataString=JSON.stringify(frmData);
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
                stopLoading();
                $('#divEmpAtmWalletDetails').empty().append(result.html);  
                $('#btnUpdate').hide();
                paginationTbl();  
                }
            else{
                stopLoading();
                $('#divEmpAtmWalletDetails').empty();
                fnCmnWarningMessage('No result found!');
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
   
}

function SearchDepositeBYcriteria(selid){
     
 var sel=document.getElementById(selid);
    $('#trcriteria').hide();
    $('#divdate').hide();
    $('#txtCriteria').hide();
    $('#trproject').hide();
    $('#projectdisplay').hide();
  
   
    switch(sel.value){
        case 'all':           
            $('#trcriteria').hide();
            $('#divdate').hide();
            $('#txtCriteria').hide();
            $('#trproject').hide();
            $('#projectdisplay').hide();
            break;
        case 'empID':
            document.getElementById('txtCriteria').placeholder='Enter Employee ID';
            $('#txtCriteria').show();
            $('#trcriteria').show();
            $('#trproject').hide();
            $('#projectdisplay').hide();
            $('#divdate').hide();
            break;
        case 'date':
            $('#txtCriteria').show();
            $('#trcriteria').hide();
            $('#trproject').hide();
            $('#projectdisplay').hide();
            $('#divdate').show();
            break;
        
       case 'type':
            $('#txtCriteria').show();
            $('#trcriteria').hide();
            $('#divdate').hide();
            $('#trproject').show();
            $('#projectdisplay').show();
            break;
    }
   
}
function CriteriaExpenseSearch(selid){
   
    var sel=document.getElementById(selid);
    $('#trcriteria').hide();
    $('#divdate').hide();
    $('#txtCriteria').hide();
    $('#trproject').hide();
    $('#projectdisplay').hide();
  
   
    switch(sel.value){
        case 'all':           
            $('#trcriteria').hide();
            $('#divdate').hide();
            $('#txtCriteria').hide();
            $('#trproject').hide();
            $('#projectdisplay').hide();
            break;
        case 'empID':
            document.getElementById('txtCriteria').placeholder='Enter Employee ID';
            $('#txtCriteria').show();
            $('#trcriteria').show();
            $('#trproject').hide();
            $('#projectdisplay').hide();
            $('#divdate').hide();
            break;
        case 'date':
            $('#txtCriteria').show();
            $('#trcriteria').hide();
            $('#trproject').hide();
            $('#projectdisplay').hide();
            $('#divdate').show();
            break;
        
       case 'project':
            $('#txtCriteria').show();
            $('#trcriteria').hide();
            $('#divdate').hide();
            $('#trproject').show();
            $('#projectdisplay').show();
            break;
    }
}
function SearchDeposit(url,elementObj){
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="selSearchDeposit"]').val().trim()==''){
        commonMessageAlert('Please select search criteria!');
        return false;
    }  
    
    if(tbl.find('select[name~="selSearchDeposit"]').val() == 'empID')
        {
        if(tbl.find('input[name~="txtCriteria"]').val().trim()==''){
        commonMessageAlert('Employee ID is mandatory!');
        return false;
        }else{}
   
    }
    if(tbl.find('select[name~="selSearchDeposit"]').val() == 'type')
        {
        if(tbl.find('select[name~="projectid"]').val().trim()==''){
        commonMessageAlert('Select source type!');
        return false;
        }else{}
   
    }
    
$('.messageDiv').hide();
    startLoading();
    var frmData=$('form#SearchDeposit').serializeObject();
    var dataString=JSON.stringify(frmData);
 
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
                stopLoading();
                $('#divSearchDeposite').empty().append(result.html);  
                paginationTbl();  
                }
            else{
                $('#divSearchDeposite').empty();
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
   
}

function SearchExpenses(url,elementObj){
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="selSearchExpense"]').val().trim()==''){
        commonMessageAlert('Please select search criteria!');
        return false;
    }
    if(tbl.find('select[name~="selSearchExpense"]').val() == 'empID')
        {
        if(tbl.find('input[name~="txtCriteria"]').val().trim()==''){
        commonMessageAlert('Employee ID is mandatory!');
        return false;
        }else{}
   
    }
    if(tbl.find('select[name~="selSearchExpense"]').val() == 'project')
        {
        if(tbl.find('select[name~="projectid"]').val().trim()==''){
        commonMessageAlert('Select project name!');
        return false;
        }else{}
   
    }
    
    
$('.messageDiv').hide();
    startLoading();
    var frmData=$('form#SearchExpenses').serializeObject();
    var dataString=JSON.stringify(frmData);
 
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
                stopLoading();
                $('#divSearchExpenses').empty().append(result.html);  
                paginationTbl();  
                }
            else{
                $('#divSearchExpenses').empty();
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
   
}


function SearchEmployeeIDSearch(url,elementObj){
     
 var tbl = $(elementObj).closest('table');  
    if(tbl.find('input[name~="employeename"]').val().trim()==''){
        commonMessageAlert('Enter Employee ID!');
        return false;
    }  
$('.messageDiv').hide();
    startLoading();
    var frmData=$('form#WalletExpenses').serializeObject();
    var dataString=JSON.stringify(frmData);
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
                stopLoading();
                $('#divEmpWalletDetails').empty().append(result.html);  
                $('#btnUpdate').hide();
                }
            else{
                $('#divEmpWalletDetails').empty();
                stopLoading();
                fnCmnWarningMessage('No Record Found!');
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
   
}

function SearchCriteriaforWallet(url){
   
    var addData={ 'empid':  $('#empid').val()};
    var frmData=$('form#WalletDeposit').serializeObject();
    var dataString = JSON.stringify($.extend(frmData,addData));
    $('.messageDiv').hide();  
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            data:dataString,
            success: function (result){
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success)
               {  
                  $('#showdetailssource').empty().append(result.html)  ;
                  $('#balance').empty();
               }
                else
                {
                     $('.messageDiv').show();                       
                     $('.message').empty().addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });
}


function DisplayBankCurrentBalance(url) {
    var frmData = $('form#WalletDeposit').serializeObject();
    var dataString = JSON.stringify(frmData);
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: dataString,
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {
                $('#balance').empty().append(result.html);
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
            fnCmnWarningMessage('Error in Class file or Controller:');
        }
    });
}




//for expenses section
function SearchCriteriaforExpenses(url){
    var addData={ 'empid':  $('#empid').val()};
    var frmData=$('form#FormMyExpense').serializeObject();
    var dataString = JSON.stringify($.extend(frmData,addData));
    $('.messageDiv').hide();  
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            data:dataString,
            success: function (result){
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success)
               {  
                  $('#showdetailssource').empty().append(result.html)  ; 
                  $('#showitemslist').empty(); 
                   
               }
                else
                {
                     $('.messageDiv').show();                       
                     $('.message').empty().addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });
}
//ends here

function SearchCriteriaforItemsShowing(url){
    
    var frmData=$('form#FormMyExpense').serializeObject();
    var dataString = JSON.stringify(frmData);
    $('.messageDiv').hide();  
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            data:dataString,
            success: function (result){
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success)
               {  
                  $('#showitemslist').empty().append(result.html)  ; 
                   
               }
                else
                {
                     $('.messageDiv').show();                       
                     $('.message').empty().addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('Error in Class file or Controller:');}
        });
}

function RetriveWalletDetails(url)
{  
    var addData={ 'empid':  $('#txt_eid').val()};
    var dataString = JSON.stringify(addData);
    
    $('.messageDiv').hide();  
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            data:dataString,
            success: function (result){ 
               if(result.success){  
                     
                   $('#divEmpDetails').empty().append(result.html);
                   $('#account_type').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.type);
                   $('#txt_description').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.description);
                   $('#ename').prop('disabled', true).val(result.jsonData.ename);
                   $('#eid').prop('disabled', true).val(result.jsonData.eid);
                   $('#id').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.empid);
                   $('#acct_id').val(result.jsonData.id);             
                   $('#btnSave').hide();
                   $('#btnUpdate').show(); 
                   
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


function RetriveATMDetails(url)
{  
     
    $('.messageDiv').hide();  
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            success: function (result){ 
               if(result.success){  
                     
                   $('#account_type').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.type);
                   $('#txt_description').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.description);
                   $('#employeeName').prop('disabled', true).val(result.jsonData.ename);
                   $('#employeeID').prop('disabled', true).val(result.jsonData.eid);
                   $('#employeepk').prop('disabled', false).val(result.jsonData.empid);
                   $('#txt_bank_name').val(result.jsonData.bank);   
                   $('#txt_account_no').val(result.jsonData.account);  
                   $('#txt_card_no').val(result.jsonData.card);  
                   $('#atm_id').val(result.jsonData.id); 
                   $('#btnSave').hide();
                   $('#btnUpdate').show(); 
                   
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





//---------------------------------- Start Wallet Atm Master(ADD,EDIT,RETRIVE,DELETE)-------------------------------- 

function SaveWalletAtmDetails(url,elementObj){
    
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('input[name~="bankName"]').val().trim()==''){
        commonMessageAlert('Bank Name is mandatory!');
        return false;
    } 
    if(tbl.find('input[name~="accountNo"]').val().trim()==''){
        commonMessageAlert('Account Number is mandatory!');
        return false;
    }
    if(tbl.find('input[name~="cardNo"]').val().trim()==''){
        commonMessageAlert('Card Number is mandatory!');
        return false;
    }
    $('.messageDiv').hide();
    startLoading();
     
    var frmData=$('form#WalletAtmDeposit').serializeObject();
    var dataString=JSON.stringify(frmData);
     
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
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#WalletAtm').empty();
                $('#displayWalletDetails').empty().append(result.html);
                paginationTbl();  
                }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}

function UpdateWalletAtmDetails(url,elementObj){
    
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('input[name~="bankName"]').val().trim()==''){
        commonMessageAlert('Bank Name is mandatory!');
        return false;
    } 
    if(tbl.find('input[name~="accountNo"]').val().trim()==''){
        commonMessageAlert('Account Number is mandatory!');
        return false;
    }
    if(tbl.find('input[name~="cardNo"]').val().trim()==''){
        commonMessageAlert('Card Number is mandatory!');
        return false;
    }
    $('.messageDiv').hide();
    startLoading();
     
    var frmData=$('form#WalletAtmDeposit').serializeObject();
    var dataString=JSON.stringify(frmData);
     
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
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#WalletAtm').empty();
                $('#displayWalletDetails').empty().append(result.html);
                paginationTbl();  
                }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}



function deleteWalletATMDetails(url,elementObj)
{   
    if(confirm('Are you sure to delete record?'))
    {
    var tbl = $(elementObj).closest('table');  
    $('.messageDiv').hide();
    
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
              if(result.success)
                {    
                    $('#displayWalletDetails').empty().append(result.html);  
                    $('.messageDiv').show();  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); 
                    
                }
                else
                {
                     $('.messageDiv').show();                       
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ alert('Error in Class file or Controller:');}
        });   
}
else
    {
      return false;  
    }
}







//---------------------------------- End Wallet Atm Master(ADD,EDIT,RETRIVE,DELETE)-------------------------------- 

function SaveWalletDetails(url,elementObj){
    
    if ($('#txt_description').val().trim() === '') {
        fnCmnWarningMessage("Description is mandatory");
        scrollToMessage();
        $('#txt_description').focus();
        return;
    }
    $('.messageDiv').hide();
    startLoading();
     
    var frmData=$('form#WalletEntry').serializeObject();
    var dataString=JSON.stringify(frmData);
     
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
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#divEmpDetails').empty();
                $('#displayWalletDetails').empty().append(result.html);
                paginationTbl();  
                }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}

function UpdateWalletDetails(url,elementObj){
    if ($('#txt_description').val().trim() === '') {
        fnCmnWarningMessage("Description is mandatory");
        scrollToMessage();
        $('#txt_description').focus();
        return;
    }
    $('.messageDiv').hide();
    startLoading();
    var addData1={ 'eid':  $('#txt_eid').val()};
    var addData={ 'id':  $('#acct_id').val()};
    var frmData=$('form#WalletEntry').serializeObject();
    var dataString=JSON.stringify($.extend(frmData,addData,addData1));
    
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
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#divEmpDetails').empty();
                $('#displayWalletDetails').empty().append(result.html);
                paginationTbl();  
                }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}



function deleteWalletDetails(url,elementObj)
{   
    if(confirm('Are you sure to delete record?'))
    {
    var tbl = $(elementObj).closest('table');  
    $('.messageDiv').hide();
    
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){ 
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
              if(result.success)
                {    
                    $('#displayWalletDetails').empty().append(result.html);  
                    $('.messageDiv').show();  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); 
                    
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


function SaveWalletDepositDetails(url,elementObj){
    
    var tbl = $(elementObj).closest('table');  
    
    if(tbl.find('select[name~="sourcename"]').val()==''){
        commonMessageAlert('source type is mandatory!');
        return false;
    }
    if(tbl.find('select[name~="selectlist"]').val()==''){
        commonMessageAlert('source id is mandatory!');
        return false;
    }
     if(tbl.find('select[name~="sourcename"]').val() == 3)
    {
        if (tbl.find('select[name~="selectmode"]').val()=='') {
            commonMessageAlert('payment mode is mandatory!');
            return false;
        }
        if (tbl.find('select[name~="selectmode"]').val() == 1) {
        }
        else {
            if (tbl.find('input[name~="txt_payment_number"]').val().trim()=='') {
                commonMessageAlert('payment no is mandatory!');
                return false;
            }
        }
    }
     if(tbl.find('input[name~="amount"]').val().trim()==''){
        commonMessageAlert('amount is mandatory!');
        return false;
    }
    if(tbl.find('textarea[name~="description"]').val().trim()==''){
        commonMessageAlert('description is mandatory!');
        return false;
    }
  
   
     if(confirm('Are you sure you want to save the record? Once Deposit is save it can neither be editable nor deletable'))
    { $('.messageDiv').hide();
    startLoading();
    var frmData=$('form#WalletDeposit').serializeObject();
    var dataString=JSON.stringify(frmData);
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
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#divEmpWalletDetails').empty();
                }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    }); 
    }else
    {
      return false;  
    }
}


function SaveWalletExpensesDetails(url,formId,elementObj){

    $('.messageDiv').hide();
    var tbl = $(elementObj).closest('table');     
    if(tbl.find('select[name~="sourcename"]').val()==''){
        commonMessageAlert('Expense type is mandatory!');
        tbl.find('select[name~="sourcename"]').focus();
        return;
    }
    if(tbl.find('select[name~="amount"]').val()==''){
        commonMessageAlert('Amount is mandatory!');
        tbl.find('select[name~="amount"]').focus();
        return;
    }
    if(tbl.find('input[name~="amount"]').val().trim()==''){
        commonMessageAlert('Amount is mandatory!');
        tbl.find('input[name~="amount"]').focus();
        return;
    }
    if(tbl.find('textarea[name~="description"]').val().trim()==''){
        commonMessageAlert('Description is mandatory!');
        tbl.find('input[name~="description"]').focus();
        return;
    } 
     if($('#fileExpensesImg').val().trim()!=''){
        var fileInput=document.getElementById('fileExpensesImg');
        var filename=fileInput.files[0].name;
        var validFiles=['jpg','jpeg','png','gif','bmp'];
        var extSplit = filename.split('.');
        var extReverse = extSplit.reverse();
        var ext = extReverse[0];        
        var isValid=false;
        for(var i=0;i<validFiles.length;i++){
            if(ext.toLowerCase()==validFiles[i]){
                isValid=true;
                break;
            }
        }
//        if(fsizeMb%2>=1){
//            fnCmnWarningMessage('File size exceeds maximum uploadable size. Recommended size is upto 512Kb.');
//            $('#fileExpensesImg').focus();
//            scrollToMessage();
//            return;
//        }        
        if(!isValid){
            fnCmnWarningMessage('The image file you have chosen is invalid.');
            $('#fileExpensesImg').focus();
            scrollToMessage();
            return;
        }
    }
     
//    if(mode=='upd'){
//        if(!confirm('Confirm Update?'))
//            return;
//    }
    
    startLoading();
     
    var formData = new FormData($('#'+formId)[0]);
    //var dataString = JSON.stringify(formData);
    $.ajax({            
        type: 'POST',
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (result){
           
            if(result.jsonData){
                $('#divExpConfirm').show();
                stopLoading();
            }else{
                if(result.success){ 
                    stopLoading();
                    //fnCmnSuccessMessage(result.message);
                    //paginationTbl();  
                    $('#pConfirm').show();
                    $('#tbExpDetail').hide();
                    $('#divExpConfirm').hide();
                    $('#addnewExpenses').show();
                    $('#btnSavebefore').hide();
//                    $('#tbExpDetail').find('input[type = text], input[type = date], input[type = radio], select, textarea').each(function() {
//                        $(this).prop('disabled', true).addClass('inputDisable_bg');
//                    });
                    }
                else{
                    stopLoading();
                    fnCmnWarningMessage(result.message);
                    scrollToMessage();
                }
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
//function editWalletExpensesforSaving(eleObj) {
//    var tbl = $(eleObj).closest('table');
//    tbl.find('input[type = text], input[type = date], input[type = radio], select, textarea').each(function() {
//        $(this).prop('disabled', false).removeClass('inputDisable_bg');
//    });
//
//    $('#addnewExpenses').hide();
//    $('#btnSavebefore').show();
//   
//}


function UpdateWalletExpensesDetails(url,formId){
    $('.messageDiv').hide();

    startLoading();
     
    var formData = new FormData($('#'+formId)[0]);
    
   
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
                fnCmnSuccessMessage(result.message);
                scrollToMessage();
                lmsShowHideAddressResult('TranList');
                $('#divTranDetail').empty();
                }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function calculatephotoFileSize(file,recommendedsizeinMb,spanid){
    if(file.files[0]!=null){
        var size=file.files[0].size;
        var sizeinMb=size/1024/1024;
        if(sizeinMb>recommendedsizeinMb){            
            $('#'+spanid).css('color','#ff0000');
        }else{
            $('#'+spanid).css('color','#009900');
        }
        $('#'+spanid).text((size/1024).toFixed(2)+'Kb');
    }
    else{
        $('#'+spanid).text('');
    }
}
function loadApproveCancel(txn)
{   
    $('.messageDiv').hide();
    var selValue = $('#TYPEID' + txn).val();    
    if(selValue==''){
        return;
    }
    startLoading();
    var url=selValue.split('&')[0];
    var action=selValue.split('&')[1];    
    var addData={ 'id': txn};
    var dataString = JSON.stringify(addData);
    $.ajax({
           type: 'POST',
           url: url,
           contentType: 'application/json',
           data:dataString,
           dataType: 'json',
           success: function(result) {
               if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){                    
                   if (action == 'edit') {
                    lmsShowHideAddressResult('ShowWalletExpenses');
                    $('#divTranDetail').empty().append(result.html);
                    $('#sourceid').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.etype);
                    $('#empcode').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.empid);
                    $('#employee').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.ename);
                    $('#txt_amount').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.amount);
                    $('#descrp').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.descrp);
                    $('#ddlb_selectlist').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.proid);
                    $('#Itemshow').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.item);
                    $('#Itemshow1').prop('disabled', true).addClass('disable_bg').val(result.jsonData.itemname);
                } else
                if (action == 'view') {
                    lmsShowHideAddressResult('ShowWalletExpenses');
                    $('#divTranDetail').empty().append(result.html);
                }
                else if (action == 'aprv') {
                    lmsShowHideAddressResult('ShowWalletExpenses');
                    $('#divTranDetail').empty().append(result.html);
                    $('#cancelexpense').hide();
                    $('#approveid').show();
                }
                else
                {
                    lmsShowHideAddressResult('ShowWalletExpenses');
                    $('#divTranDetail').empty().append(result.html);
                    $('#cancelexpense').show();
                    $('#approveid').hide();
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
function LoadPendingExpense(){
    $('.divMessage').hide();
    var url=$('#inputloadexpurl').val();
    $.ajax({            
            type: 'POST',
            url: url,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){ 
                if(result.success){            
                    $('#divExpdetail').empty();
                    $('#WalletExpensesApprove').empty().append(result.html); 
                    paginationTbl();
                }
                else{
                    fnCmnWarningMessage(result.message);
                    scrollToMessage();                    
                }
                
           },
        error: function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function ApproveExpenses(url)
{   
    var poid={id:$('#txt_id').val()}; 
    $('.messageDiv').hide(); 
    startLoading();
    var formData = $('form#WalletExpensesApprove').serializeObject();
    var dataString = JSON.stringify($.extend(formData,poid));        
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
                    fnCmnSuccessMessage(result.message);                    
                    scrollToMessage();
                    stopLoading();
                }
                else{
                    fnCmnWarningMessage(result.message);
                    scrollToMessage();
                    stopLoading();
                }                
            },
        error: function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
            stopLoading();
        }
    });   
}
function ApproveCancelExpensesDetails(url,action)
{   
    $('.messageDiv').hide(); 
    if(action=='approve'){
        if(!confirm('Confirm Approval?')){
            return;
        }
    }
    if(action=='cancel'){
        if($('#txtRemark').val().trim()==''){
            fnCmnWarningMessage('Enter Remark.');
            $('#txtRemark').focus();
            scrollToMessage();
            return;
        }
        if(!confirm('Are you sure you want to cancel this request?')){
            return;
        }        
    }
    startLoading();
    var formData = $('form#FormExpenses').serializeObject();
    var dataString = JSON.stringify(formData);        
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
                    var msg=result.message;
                    $('#divExpdetail').empty();  
                    LoadPendingExpense();
                    fnCmnSuccessMessage(msg);
                    scrollToMessage();
                    stopLoading();
                }
                else
                {
                    fnCmnWarningMessage(result.message);
                    scrollToMessage();
                    stopLoading();
                }                
           },
            error: function(){stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();}
        });
}



function SearchCriteriaForWalletExpenses(selid){
   
    var sel=document.getElementById(selid);
    $('#trcriteria').show();
    $('#selProjCategory').hide();
    $('#txtCriteria').hide();
    $('#txtdate').hide();
    $('#divDate').hide();
    $('#selProjStatus').hide();
    //$('#tbodyDynamic').empty();
     $('#tdtitle').text('Criteria');
    switch(sel.value){
        case 'all':           
            $('#trcriteria').hide();
            break;
        case 'project':
             $('#Date').hide();
             $('#txtCriteria').hide();
            break;
        case 'employee':
            document.getElementById('txtCriteria').placeholder='Enter Employee ID';
            $('#txtCriteria').show();
             $('#Date').hide();
            break;
        
       case 'date':
            $('#Date').show();
             
            break; 
         
    }
}
function SearchMyTransaction(url){
    $('.messageDiv').hide();
    if($('#txtfdate').val()!='' && $('#txttdate').val()!=''){
        var fdate=new Date($('#txtfdate').val());
        var tdate=new Date($('#txttdate').val());
        if(fdate>tdate){
            fnCmnWarningMessage('From date cannot be later than To date');
            $('#txtfdate').focus();
            scrollToMessage();
            return;
        }
    }
    var formData = $('form#FormMyTransactions').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();    
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){ 
               if(result.success){  
                    $('#divTransactionlist').empty().append(result.html);
                    $('#divTranDetail').empty();
                    stopLoading();
                    //paginationTbl();
                }
                else{
                    $('#divTransactionlist').empty();
                    $('#divTranDetail').empty();
                    fnCmnWarningMessage(result.message);
                    scrollToMessage();
                    stopLoading();
                }
            },
            error: function(){
                fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
                scrollToMessage();
                stopLoading();
            }
        });
}
function viewexpensedetail(txn){
//    $('.messageDiv').hide();  
//   
//    startLoading();    
//    $.ajax({            
//            type: 'POST',
//            url: url,
//            contentType: 'application/json',
//            dataType: 'json',
//            success: function (result){ 
//               if(result.success){  
//                    $('#divTranDetail').empty().append(result.html);
//                    stopLoading();
//                    lmsShowHideAddressResult('TranList');
//                    document.getElementById('divTranDetail').scrollIntoView();
//                }
//                else{
//                    $('#divTranDetail').empty();
//                    fnCmnWarningMessage(result.message);
//                    scrollToMessage();
//                    stopLoading();
//                }
//            },
//            error: function(){
//                fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
//                scrollToMessage();
//                stopLoading();
//            }
//        });


$('.messageDiv').hide();
    var selValue = $('#TYPEID' + txn).val();    
    if(selValue==''){
        return;
    }
    startLoading();
    var url=selValue.split('&')[0];
    var action=selValue.split('&')[1];    
    var addData={ 'id': txn};
    var dataString = JSON.stringify(addData);
    $.ajax({
           type: 'POST',
           url: url,
           contentType: 'application/json',
           data:dataString,
           dataType: 'json',
           success: function(result) {
               if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               if(result.success){                    
                   if (action == 'edit') {
                    stopLoading();
                    lmsShowHideAddressResult('TranList');
                    $('#divTranDetail').empty().append(result.html);
                    $('#sourceid').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.etype);
                    $('#empcode').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.empid);
                    $('#employee').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.ename);
                    $('#txt_amount').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.amount);
                    $('#descrp').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.descrp);
                    $('#ddlb_selectlist').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.proid);
                    $('#Itemshow').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.item);
                    $('#Itemshow1').prop('disabled', true).addClass('disable_bg').val(result.jsonData.itemname);
                } else
                if (action == 'view') {
                    $('#divTranDetail').empty().append(result.html);
                    stopLoading();
                    lmsShowHideAddressResult('TranList');
                    document.getElementById('divTranDetail').scrollIntoView();
                }stopLoading();
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
function toggleStatusTd(param){
    if(param==0){
        $('.tdstatus').hide();
    }else{
        $('.tdstatus').show();
    }
}
function selectCashPaymentMode(paymentModeID){
    if(paymentModeID == ''){
        $('#payment_number').prop('readonly', false).removeClass('inputDisable_bg');
        $('.payment_no_necessary').hide();
        return false;
    }
    var isNeccessaryFieldKey = $('#keyToDetectCash' + paymentModeID).val();
    if(isNeccessaryFieldKey == 0){
        //$('#payment_number').prop('readonly', true).addClass('inputDisable_bg');
        $('#payment_number').attr('disabled',true);
        $('.payment_no_necessary').hide();
        return;
    }else{
        //$('#payment_number').prop('readonly', true).removeClass('inputDisable_bg');
        $('#payment_number').attr('disabled',false);
        $('.payment_no_necessary').show();
        return;
    }
}