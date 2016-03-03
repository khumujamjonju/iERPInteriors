function ManageActivities(url,action){
    $('.messageDiv').hide();
    if($('#selModule').val().trim()==''){
        fnCmnWarningMessage("Select Module!");
        $('#selModule').focus();
        scrollToMessage();
        return;
    }
    if($('#txtActivityName').val().trim()==''){
        fnCmnWarningMessage("Enter Activity Name!");
        $('#txtActivityName').focus();
        scrollToMessage();
        return;
    }
    if($('#txtFunctionName').val().trim()==''){
        fnCmnWarningMessage("Enter Function Name!");
        $('#txtFunctionName').focus();
        scrollToMessage();
        return;
    }
    if($('#txtPath').val().trim()==''){
        fnCmnWarningMessage("Enter Controller Path!");
        $('#txtPath').focus();
        scrollToMessage();
        return;
    }
    if(action=='EDT'){
        if(!confirm('Confirm Update?'))
            return;
    }
    startLoading();
    var frmData=$('form#FormActivity').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        data: dataString, 
        dataType: 'json',
        success: function(result) {           
            if (result.success) {  
                //if(action=='EDT'){
                    $('#divActivityList').empty().append(result.html);
//                }else{
//                    $('#right-content').empty().append(result.html);
//                }
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
function activityAction(selid){
    $('.messageDiv').hide();
    var urlaction=$('#'+selid).val();
    if(urlaction==''){
        return;
    }
    var url=urlaction.split('&')[0];
    var action=urlaction.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected Activity?'))
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
                if(action=='del'){
                    $('#right-content').empty().append(result.html);
                    fnCmnSuccessMessage(result.message);
                    scrollToMessage();
                    paginationTbl();
                }else{
                    $('#divActivityDetail').empty().append(result.html);
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
function cancelActivity(url){
    $('.messageDiv').hide();
    if(!confirm('Are you sure you want to cancel the update and add a new record?'))
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
function loadActivity(url,mode){
    $('.messageDiv').hide();    
    //startLoading();
    if(mode=='INS'){
        $('#txtActivityName').val('');
        $('#txtdesc').val('');
        $('#txtFunctionName').val('');
        $('#txtPath').val('');    
    }
    var frmData=$('form#FormActivity').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        data: dataString, 
        dataType: 'json',
        success: function(result) {           
            if (result.success) {
                $('#divActivityList').empty().append(result.html);
                scrollToMessage();
                //stopLoading();
                paginationTbl();
            }
            else 
            {
                fnCmnWarningMessage(result.message);
                scrollToMessage();
                //stopLoading();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
            scrollToMessage();
           // stopLoading();
        }
    });
}