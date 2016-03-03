function ManageModule(url,action){
    $('.messageDiv').hide();
    if($('#txtModuleName').val().trim()==''){
        fnCmnWarningMessage("Enter Module Name!");
        $('#txtModuleName').focus();
        scrollToMessage();
        return;
    }
    if(action=='EDT'){
        if(!confirm('Confirm Update?'))
            return;
    }
    startLoading();
    var frmData=$('form#FormModule').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST', 
        url: url, 
        contentType: 'application/json', 
        data: dataString, 
        dataType: 'json',
        success: function(result) {           
            if (result.success) {  
                if(action=='EDT'){
                    $('#divmoduleList').empty().append(result.html);
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
function moduleAction(selid){
    $('.messageDiv').hide();
    var urlaction=$('#'+selid).val();
    if(urlaction==''){
        return;
    }
    var url=urlaction.split('&')[0];
    var action=urlaction.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected module?'))
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
                    $('#divModuleDetail').empty().append(result.html);
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
function cancelUpdate(url){
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

