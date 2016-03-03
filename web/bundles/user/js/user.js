function ManageGroup(url,action){
    $('.messageDiv').hide();
    if($('#txtGroupName').val().trim()==''){
        fnCmnWarningMessage("Enter Group Name!");
        $('#txtGroupName').focus();
        scrollToMessage();
        return;
    }
    if(action=='EDT'){
        if(!confirm('Confirm Update?'))
            return;
    }
    startLoading();
    var frmData=$('form#FormUserGroup').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        data: dataString, 
        dataType: 'json',
        success: function(result) { 
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if (result.success) {  
                if(action=='EDT'){
                    $('#divGroupList').empty().append(result.html);
                }else{
                    $('#right-content').empty().append(result.html);
                }
                fnCmnSuccessMessage(result.message);
                scrollToMessage();
                stopLoading();
                paginationTbl();
            }
            else 
            {
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
function groupAction(selid){
    $('.messageDiv').hide();
    var urlaction=$('#'+selid).val();
    if(urlaction==''){
        return;
    }
    var url=urlaction.split('&')[0];
    var action=urlaction.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected Group?'))
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
            if (result.success) {  
                if(action=='del'){
                    $('#right-content').empty().append(result.html);
                    fnCmnSuccessMessage(result.message);
                    scrollToMessage();
                    paginationTbl();
                }else{
                    $('#divGroupDetail').empty().append(result.html);
                }            
                stopLoading();
            }
            else 
            {
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
function cancelGroup(url){
    $('.messageDiv').hide();
    if(!confirm('Are you sure you want to cancel the update?'))
        return;

    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) {           
            if (result.success) {  
                $('#right-content').empty().append(result.html);    
                paginationTbl();
                stopLoading();
            }
            else 
            {
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
////////////////////////////////////////////////////
////////////////      USER ACCOUNT     ////////////
////////////////////////////////////////////////////
function toggleCriteriaUser(select){
    $('.messageDiv').hide();
    switch(select.value){
        case 'all':
            $('#txtuidname').hide();
            break;
        case 'idname':
            $('#txtuidname').show();
            break;
    }
}
function searchEmployee(){
    $('.messageDiv').hide();
    if($('#selCriteria').val()=='idname' && $('#txtuidname').val().trim()==''){
        fnCmnWarningMessage("Enter Employee ID/ Name!");
        $('#txtuidname').focus();
        scrollToMessage();
        return;
    }
    var url=$('#inputSearchEmpUrl').val();
    var frmData=$('Form#FormCreateUserAccount').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        data:dataString,
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) {           
            if (result.success) {  
                $('#divEmpList').empty().append(result.html); 
                 $('#divCreateAccount').empty();
                paginationTbl();
                stopLoading();
            }
            else 
            {
                $('#divEmpList').empty();
                $('#divCreateAccount').empty();
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
function GotoCreateAccount(url){
    $('.messageDiv').hide();
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
                lmsShowHideAddressResult('emplist');
                $('#divCreateAccount').empty().append(result.html);   
                stopLoading();
            }
            else 
            {
                $('#divCreateAccount').empty();
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
function ToggleGroupSelection(chk){
    if(chk.checked){
        $('#inputIsGrpselected').val('1');
    }else{
        var chkboxes=document.getElementsByName('chkGroup');
        $('#inputIsGrpselected').val('');
        for(var i=0;i<chkboxes.length;i++){
            if(chkboxes[i].checked){
                $('#inputIsGrpselected').val('1');
                break;
            }
        }
    }
}
function CreateAccount(url){
    $('.messageDiv').hide();
//    if($('#inputIsGrpselected').val().trim()==''){
//        fnCmnWarningMessage("You have not selected any Group!!");
//        scrollToMessage();
//        return;
//    }
    if($('#txtuname').val().trim()==''){
        fnCmnWarningMessage("Enter User/Login Name!!");
        $('#txtuidname').focus();
        scrollToMessage();
        return;
    }
    if(!PasswordValidLetter($('#txtuname').val())){
        fnCmnWarningMessage("Unacceptable symbol/letter found in User/Login Name!!");
        $('#txtpass').focus();
        scrollToMessage();
        return;
    }
    if($('#txtpass').val().trim()==''){
        fnCmnWarningMessage("Enter Password!!");
        $('#txtpass').focus();
        scrollToMessage();
        return;
    }
    if($('#txtpass').val().length<8){
        fnCmnWarningMessage("Password must be at least 8 letter long!!");
        $('#txtpass').focus();
        scrollToMessage();
        return;
    }
    if($('#txtpass').val()!=$('#txtcpass').val()){
        fnCmnWarningMessage("Password Mismatch!!");
        $('#txtpass').focus();
        scrollToMessage();
        return;
    }    
    if(!IsNumberCharPresent($('#txtpass').val())){
        fnCmnWarningMessage("Password must contain atleast 1 Alphabet and 1 Number!!");
        $('#txtpass').focus();
        scrollToMessage();
        return; 
    }
    if(!PasswordValidLetter($('#txtpass').val())){
        fnCmnWarningMessage("Unacceptable symbol/letter found in password!!");
        $('#txtpass').focus();
        scrollToMessage();
        return;
    }
    if($('#txtWef').val().trim()==''){
        fnCmnWarningMessage("Select Effective Date!!");
        $('#txtWef').focus();
        scrollToMessage();
        return;
    }
    if($('#txtExpDate').val()!=''){
        var wefDate=new Date($('#txtWef').val());
        var exDate=new Date($('#txtExpDate').val());
        if(wefDate>=exDate){
            fnCmnWarningMessage("Account Effective Date cannot be greater than or equal to Expiry Date!!");
            $('#txtWef').focus();
            scrollToMessage();
            return;
        }
    }
    if(!confirm('Proceed?')){
        return;
    }
    startLoading();
    var formData=$('Form#FormCreateAccount').serializeObject();
    var dataString=JSON.stringify(formData);
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
            if (result.success){  
                var msg=result.message;
                $('#divCreateAccount').empty();
                searchEmployee();
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
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
            scrollToMessage();
            stopLoading();
        }
    });
}
function userAccountAction(accountid){
    $('.messageDiv').hide();
    if($('#selUserAccAction'+accountid).val().trim()==''){
        return;
    }
    var url=$('#selUserAccAction'+accountid).val();
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
            if (result.success){  
                $('#divActions').empty().append(result.html);
                stopLoading();
                lmsShowHideAddressResult('acclist');
                paginationTbl2();
            }
            else 
            {
                $('#divActions').empty();
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
function toggleCriteriaAccount(select){
    $('.messageDiv').hide();
    var txtKeyword=document.getElementById('txtkeyword');
    txtKeyword.value='';
    txtKeyword.style.display='none';
    switch(select.value){
        case 'idname':
            txtKeyword.placeholder='Enter Employee ID/Name';
            txtKeyword.style.display='';
            break;
        case 'uname':
            txtKeyword.placeholder='Enter User/Login Name';
            txtKeyword.style.display='';
            break;    
    }
}
function searchAccount(){
    $('.messageDiv').hide();
    if($('#selCriteria').val()=='idname' && $('#txtkeyword').val().trim()==''){
        fnCmnWarningMessage("Enter Employee ID/ Name!");
        $('#txtuidname').focus();
        scrollToMessage();
        return;
    }
    if($('#selCriteria').val()=='uname' && $('#txtkeyword').val().trim()==''){
        fnCmnWarningMessage("Enter User/Login Name!");
        $('#txtuidname').focus();
        scrollToMessage();
        return;
    }
    var url=$('#inputSearchAccUrl').val();
    var frmData=$('Form#FormSearchAccount').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        data:dataString,
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) { 
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }           
            if (result.success){  
                $('#divAccList').empty().append(result.html);    
                paginationTbl();
                stopLoading();
            }
            else 
            {
                $('#divAccList').empty();
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
function blockAccount(url){
    $('.messageDiv').hide();
    if($('#txtRemark').val().trim()==''){
        fnCmnWarningMessage("Enter Remarks!!");
        $('#txtRemark').focus();
        scrollToMessage();
        return;
    }
    if(!confirm('Are you sure you want to block this account?')){
        return;
    }
    var frmData=$('Form#FormBlockAccount').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        data:dataString,
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) { 
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }           
            if (result.success){ 
                var msg=result.message;  
                searchAccount();
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
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
            scrollToMessage();
            stopLoading();
        }
    });
}
function ReactivateAccount(url){
    $('.messageDiv').hide();
    var expdatestr=$('#txtExpDate').val();
    if(expdatestr!=''){
        var curDate=new Date();
        var expDate=new Date(expdatestr);
        if(curDate>expDate){
            fnCmnWarningMessage("Expiry Date cannot be lesser than Current Date!!");
            $('#txtExpDate').focus();
            scrollToMessage();
            return;
        }
    }
    if(!confirm('Confirm Account Reactivation?')){
        return;
    }
    var frmData=$('Form#FormReActivateAccount').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        data:dataString,
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) { 
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }           
            if (result.success){ 
                var msg=result.message;
                searchAccount();
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
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
            scrollToMessage();
            stopLoading();
        }
    });
}
function ViewAccountHistory(url){
    $('.messageDiv').hide();
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
            if (result.success){ 
                $('#divActions').empty().append(result.html);
                paginationTbl();
                stopLoading();
            }
            else 
            {
                $('#divActions').empty();
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


function ShowActivity(url){
  
    $('.messageDiv').hide();
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
            if (result.success){ 
                lmsShowHideAddressResult('acchistory');
                $('#ActivitySaving').empty().append(result.html);
                 
                stopLoading();
            }
            else 
            {
                $('#divShow').empty();
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


function ShowGroupUser(url){
  
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) {           
            if (result.success){ 
                lmsShowHideAddressResult('acchistory');
                $('#divAssignUserGrpu').empty().append(result.html);
                 
                stopLoading();
            }
            else 
            {
                $('#divShow').empty();
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

function SaveAssignActivity(url){
  
    $('.messageDiv').hide();
    startLoading();
    var frmData=$('Form#ActivityAssign').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        data:dataString,
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) { 
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }           
            if (result.success){
                fnCmnSuccessMessage(result.message);
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
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
            scrollToMessage();
            stopLoading();
        }
    });
}

function UpdateAssignActivity(url){
  
    $('.messageDiv').hide();
    startLoading();
    var frmData=$('Form#ActivityAssign').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        data:dataString,
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) { 
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }           
            if (result.success){
                fnCmnSuccessMessage(result.message);
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
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
            scrollToMessage();
            stopLoading();
        }
    });
}


function SaveUserGroupTxn(url){
  
    $('.messageDiv').hide();
    startLoading();
    var frmData=$('Form#FormAssignUserGrpu').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
        type: 'POST', 
        url: url, 
        data:dataString,
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) { 
            if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }           
            if (result.success){
                fnCmnSuccessMessage(result.message);
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
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
            scrollToMessage();
            stopLoading();
        }
    });
}





function ActivateAccount(url){
    $('#err_p').text('');
    if($('#txtpass').val().trim()==''){
        $('#err_p').text('Enter your new password');
        $('#txtpass').focus();
        return;
    }
    if($('#txtpass').val()!=$('#txtcpass').val()){
        $('#err_p').text('Password Mismatch.');
        $('#txtcpass').focus();
        return;
    }
    if($('#txtpass').val().length<8){
        $('#err_p').text("Password must be at least 8 letter long!!");
        $('#txtpass').focus();
        return;
    }        
    if(!IsNumberCharPresent($('#txtpass').val())){
        $('#err_p').text("Password must contain atleast 1 Alphabet and 1 Number!!");
        $('#txtpass').focus();
        return; 
    }
    if(!PasswordValidLetter($('#txtpass').val())){
        $('#err_p').text("Unacceptable symbol/letter found in password!!");
        $('#txtpass').focus();
        return;
    }    
    $('#btnactivate').val('Please wait...');
    $('#btnactivate').prop('disabled', true);
    var frmData=$('Form#FormActivateAccount').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST', 
        url: url, 
        data:dataString,
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) {           
            if (result.success){
                $('#divActivation').hide();
                $('#divSuccess').show();
            }
            else 
            {                
                $('#err_p').text(result.message);
                $('#btnactivate').val('Activate');
                $('#btnactivate').prop('disabled', false);
            }
        },
        error: function() {
            $('#err_p').text('An unknown technical error has encountered. Please try later.');  
            $('#btnactivate').val('Activate');
            $('#btnactivate').prop('disabled', false);
        }
    });
}
function ForgotPassword(url){
    $('#err_p').text('');
    if($('#txtuname').val().trim()=='' && $('#txtemail').val().trim()=='' ){
        $('#err_p').text("Please enter your User Name or registered Email Id.!!");
        return; 
    }
    if($('#txtuname').val().trim()=='' && $('#txtemail').val()!=''){
        var email=$('#txtemail').val();
        var reg=new RegExp("^[A-Za-z0-9,!#\$%&amp;'\*\+/=\?\^_`\{\|}~-]+(\.[a-z0-9,!#\$%&amp;'\*\+/=\?\^_`\{\|}~-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*\.([A-Za-z]{2,})$");
        if(!reg.test(email)){
            $('#err_p').text("Please enter a valid email id.");
            return; 
        }
    }
    $('#btnSend').val('Please wait...');
    $('#btnSend').prop('disabled', true);
    var frmData=$('Form#FormForgotPassword').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST', 
        url: url, 
        data:dataString,
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) {           
            if (result.success){
                $('#divDetail').hide();
                $('#divSuccess').show();
            }
            else 
            {                
                $('#err_p').text(result.message);
                $('#btnSend').val('Send Password Reset Link');
                $('#btnSend').prop('disabled', false);
            }
        },
        error: function() {
            $('#err_p').text('An unknown technical error has encountered. Please try later.');  
            $('#btnSend').val('Send Password Reset Link');
            $('#btnSend').prop('disabled', false);
        }
    });
}
function ResetPassword(url){
    $('#err_p').text('');
    if($('#txtpass').val().trim()==''){
        $('#err_p').text('Enter your new password');
        $('#txtpass').focus();
        return;
    }
    if($('#txtpass').val()!=$('#txtcpass').val()){
        $('#err_p').text('Password Mismatch.');
        $('#txtcpass').focus();
        return;
    }
    if($('#txtpass').val().length<8){
        $('#err_p').text("Password must be at least 8 letter long!!");
        $('#txtpass').focus();
        return;
    }        
    if(!IsNumberCharPresent($('#txtpass').val())){
        $('#err_p').text("Password must contain atleast 1 Alphabet and 1 Number!!");
        $('#txtpass').focus();
        return; 
    }
    if(!PasswordValidLetter($('#txtpass').val())){
        $('#err_p').text("Unacceptable symbol/letter found in password!!");
        $('#txtpass').focus();
        return;
    }    
    $('#btnchange').val('Please wait...');
    $('#btnchange').prop('disabled', true);
    var frmData=$('Form#FormResetPassword').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST', 
        url: url, 
        data:dataString,
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) {           
            if (result.success){
                $('#divField').hide();
                $('#divSuccess').show();
            }
            else 
            {                
                $('#err_p').text(result.message);
                $('#btnchange').val('Change Password');
                $('#btnchange').prop('disabled', false);
            }
        },
        error: function() {
            $('#err_p').text('An unknown technical error has encountered. Please try later.');  
            $('#btnchange').val('Change Password');
            $('#btnchange').prop('disabled', false);
        }
    });
}
function ChangePassword(url){
    $('.messageDiv').hide();
    if($('#txtopass').val().trim()==''){
        fnCmnWarningMessage('Enter your old password.');
        scrollToMessage();
        $('#txtopass').focus();
        return;
    }
    if($('#txtpass').val().trim()==''){
        fnCmnWarningMessage('Enter your new password.');
        scrollToMessage();
        $('#txtpass').focus();
        return;
    }
    if($('#txtpass').val()!=$('#txtcpass').val()){
        fnCmnWarningMessage('Password Mismatch.');
        scrollToMessage();
        $('#txtcpass').focus();
        return;
    }
    if($('#txtpass').val().length<8){
        fnCmnWarningMessage("Password must be at least 8 letter long!!");
        scrollToMessage();
        $('#txtpass').focus();
        return;
    }        
    if(!IsNumberCharPresent($('#txtpass').val())){
        fnCmnWarningMessage("Password must contain atleast 1 Alphabet and 1 Number!!");
        scrollToMessage();
        $('#txtpass').focus();
        return; 
    }
    if(!PasswordValidLetter($('#txtpass').val())){
        fnCmnWarningMessage("Unacceptable symbol/letter found in password!!");
        scrollToMessage();
        $('#txtpass').focus();
        return;
    }
    startLoading();
    var frmData=$('Form#FormChangePassword').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST', 
        url: url, 
        data:dataString,
        contentType: 'application/json', 
        dataType: 'json',
        success: function(result) {           
            if (result.success){
                $('#tbDetail').hide();
                $('#divSuccess').show();
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
function UpdateAssignActivitySearchUserbyGroup(url,elementObj){
     
 var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="selCriteria"]').val().trim()==''){
        commonMessageAlert('Select group name first!');
        return false;
    }  
$('.messageDiv').hide();
    startLoading();
    var frmData=$('form#FormSearchActivity').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({            
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType:'json',
        success: function (result){ 
           if(result.success){ 
                stopLoading();
                $('#DisplayActivity').empty().append(result.html);  
                }
            else{
                $('#DisplayActivity').empty();
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
function Logout(url){
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType:'json',
        success: function (result){ 
           if(!result.success){                 
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

function toggleSelectAllforuseractivity(thisid,pkid){
    var mainChk=document.getElementById('chkCommAll'+pkid);
     
    var allChks=document.getElementsByClassName('selchkcomm'+pkid);
    if(thisid==mainChk.id){
        for(var i=0;i<allChks.length;i++){
            allChks[i].checked=mainChk.checked;
        }
    }else{
          var allChecked=true;
          for(var i=0;i<allChks.length;i++){
                if(!allChks[i].checked){
                    allChecked=false;
                    break;
                }
            }
            mainChk.checked=allChecked;
        }
}

function AssignPassword(url){
    $('.messageDiv').hide();
    if(!PasswordValidLetter($('#txtuname').val())){
        fnCmnWarningMessage("Unacceptable symbol/letter found in User/Login Name!!");
        $('#txtpass').focus();
        scrollToMessage();
        return;
    }
    if($('#txtpass').val().trim()==''){
        fnCmnWarningMessage("Enter Password!!");
        $('#txtpass').focus();
        scrollToMessage();
        return;
    }
    if($('#txtpass').val().length<8){
        fnCmnWarningMessage("Password must be at least 8 letter long!!");
        $('#txtpass').focus();
        scrollToMessage();
        return;
    }
    if($('#txtpass').val()!=$('#txtcpass').val()){
        fnCmnWarningMessage("Password Mismatch!!");
        $('#txtpass').focus();
        scrollToMessage();
        return;
    }    
    if(!IsNumberCharPresent($('#txtpass').val())){
        fnCmnWarningMessage("Password must contain atleast 1 Alphabet and 1 Number!!");
        $('#txtpass').focus();
        scrollToMessage();
        return; 
    }
    if(!PasswordValidLetter($('#txtpass').val())){
        fnCmnWarningMessage("Unacceptable symbol/letter found in password!!");
        $('#txtpass').focus();
        scrollToMessage();
        return;
    }
    if(!confirm('Confirm Password Assignment?')){
        return;
    }
    startLoading();
    var formData=$('Form#FormAssignPassword').serializeObject();
    var dataString=JSON.stringify(formData);
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
            if (result.success){  
                var msg=result.message;
                searchAccount();
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
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
            scrollToMessage();
            stopLoading();
        }
    });
}
function ChangeExpiryDate(url){
    $('.messageDiv').hide();
    if($('#txtExpDate').val()!=''){
        var wefDate=new Date($('#txtWef').val());
        var exDate=new Date($('#txtExpDate').val());
        if(wefDate>=exDate){
            fnCmnWarningMessage("Expiry Date cannot be greater than or equal to Effective Date!!");
            $('#txtWef').focus();
            scrollToMessage();
            return;
        }
    }
    if(!confirm('Confirm Changing Expiry Date?')){
        return;
    }
    startLoading();
    var formData=$('Form#FormChangeExpiry').serializeObject();
    var dataString=JSON.stringify(formData);
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
            if (result.success){  
                var msg=result.message;
                searchAccount();
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
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
            scrollToMessage();
            stopLoading();
        }
    });
}