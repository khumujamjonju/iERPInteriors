function ManageArea(url,formId,mode)
{       //               create Category name
    $('.messageDiv').hide();
    if($('#txtAreaName').val().trim()=='')
    {
        fnCmnWarningMessage("Enter Area Name");
        $('#txtAreaName').focus();
        scrollToMessage();
        return;
    }
    if($('#txtDescription').val().trim()=='')
    {
        fnCmnWarningMessage("Enter Description");
        $('#txtDescription').focus();
        scrollToMessage();
        return;
    }
    if(mode=='upd'){
        if(!confirm('Confirm Update?')){
            return;
        }
    }
    startLoading(); 
    var formData = $('form#'+formId).serializeObject();
    /* convert the JSON object into string */  
    var dataString = JSON.stringify(formData);
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
         if(Response.success)
            {      
                fnCmnSuccessMessage(Response.message);
                if(mode=='ins'){
                    $('#txtAreaName').val('');
                    $('#txtDescription').val('');
                }                
                $('#tdAreaList').empty().append(Response.html);
                paginationTbl();
                stopLoading();
            }
          else
            {
                fnCmnWarningMessage(Response.message);
                stopLoading();
                scrollToMessage();
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            stopLoading();
            scrollToMessage();
        }
    });    
}
function ProjectAreaAction(url,action)
{
    $('.messageDiv').hide();    
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected Project Area'))
            return;
    }
    startLoading();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
          if(Response.success) 
            {
                if(action=='del'){
                    $('#right-content').empty().append(Response.html);
                    paginationTbl();
                    fnCmnSuccessMessage(Response.message);
                    stopLoading();
                    scrollToMessage();
                }
                else{
                    $('#catsaveEditPage').empty().append(Response.html);
                    stopLoading();
                }                
            }
            else{
                fnCmnWarningMessage(Response.message);
                stopLoading();
                scrollToMessage();
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            stopLoading();
            scrollToMessage();
        }
    });
}
function CancelAreaUpdate(url){
    $('.messageDiv').hide(); 
    if(!confirm('Are you sure you want to cancel the update?')){
        return;
    }
    startLoading();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
          if(Response.success){
               $('#right-content').empty().append(Response.html);
                paginationTbl();
                stopLoading();
            }else{
                stopLoading();
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function ManageIndustryType(url,formId,mode)
{       //               create Category name
    $('.messageDiv').hide();
    if($('#txtname').val().trim()=='')
    {
        fnCmnWarningMessage("Enter Industry Type");
        $('#txtname').focus();
        scrollToMessage();
        return;
    }
//    if($('#txtDescription').val().trim()=='')
//    {
//        fnCmnWarningMessage("Enter Description");
//        $('#txtDescription').focus();
//        scrollToMessage();
//        return;
//    }
    if(mode=='upd'){
        if(!confirm('Confirm update?')){
            return;
        }
    }
    startLoading(); 
    var formData = $('form#'+formId).serializeObject();
    /* convert the JSON object into string */  
    var dataString = JSON.stringify(formData);
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(Response)
        {
            if(Response.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
         if(Response.success)
            {      
                fnCmnSuccessMessage(Response.message);
                if(mode=='ins'){
                    $('#txtname').val('');
                    $('#txtDescription').val('');
                }
                $('#tdAreaList').empty().append(Response.html);
                paginationTbl();
                stopLoading();
            }
          else
            {
                fnCmnWarningMessage(Response.message);
                stopLoading();
                scrollToMessage();
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            stopLoading();
            scrollToMessage();
        }
    });    
}
function IndustryTypeAction(url,action)
{
    $('.messageDiv').hide();   
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected Industry Type?'))
            return false;
    }
    startLoading();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        {
            if(Response.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
          if(Response.success) 
            {
                if(action=='del'){
                    $('.application-form').empty().append(Response.html);
                    paginationTbl();
                    fnCmnSuccessMessage(Response.message);
                    stopLoading();
                    scrollToMessage();
                }
                else{
                    $('#catsaveEditPage').empty().append(Response.html);
                    stopLoading();
                }                
            }
            else{
                fnCmnWarningMessage(Response.message);
                stopLoading();
                scrollToMessage();
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            stopLoading();
            scrollToMessage();
        }
    });
}
function CancelIndustryUpdate(url){
    $('.messageDiv').hide(); 
    if(!confirm('Are you sure you want to cancel the update?')){
        return;
    }
    startLoading();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
          if(Response.success){
                $('.application-form').empty().append(Response.html);
                paginationTbl();
                stopLoading();
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function ProjectItemMgt()
{   
    $('.messageDiv').hide();
    var url= $('#catid').val();
    if(url=='')
    {
        fnCmnWarningMessage("Select Project Category");
        scrollToMessage();
        return ;
    } 
    startLoading();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        {
            if(Response.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            if(Response.success){
                $('#subcatArea').empty().append(Response.html);
                stopLoading();
            }
            else{
                fnCmnWarningMessage(Response.message);
                stopLoading();
                scrollToMessage();
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            stopLoading();
            scrollToMessage();
        }
    });    
}
function InsertProjectItem(url,formId)
{
    $('.messageDiv').hide();
    if($('#subCatName').val().trim()==''){
        fnCmnWarningMessage('Enter Name');
        $('#subCatName').focus();
        scrollToMessage();
        return;
    }
    startLoading();
    var formData = $('form#'+formId).serializeObject();
    var dataString = JSON.stringify(formData);
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(Response)
        {
            if(Response.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
            
            if(Response.success) 
            {   
                var msg=Response.message;                
                $('#catListArea').empty().append(Response.html);
                ProjectItemMgt();
                scrollToMessage();
                stopLoading();
                fnCmnSuccessMessage(msg);
            }
            else{
                fnCmnWarningMessage(Response.message);
                stopLoading();
                scrollToMessage();                
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            stopLoading();
            scrollToMessage();
        }
    });      
}
function ManageItemPage(id)
{
    $('.messageDiv').hide();
    var url = $('#prodcat'+id).val();
      if(url=="")
    return false;
       // alert(url);
    startLoading();
    $.ajax({            
           type: 'POST',
           url: url,
           contentType: 'application/json',
           dataType: 'json',
           success: function(Response)
           { 
               if(Response.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
             if(Response.success) 
               {
                   $('#addsubcat').empty().append(Response.html);
                   stopLoading();
               }
               else{
                   fnCmnWarningMessage(Response.message);
                   stopLoading();
                   scrollToMessage();
               }
           },
           error: function()
           { 
               fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
               stopLoading();
               scrollToMessage();
           }
       });    
}


