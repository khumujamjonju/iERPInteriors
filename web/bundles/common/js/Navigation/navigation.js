//this function is used for pagination of record display
function paginationTbl()
{
    $('#example').dataTable({
        //"aaSorting": [[ 1, "desc" ]],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
      
}  
function paginationTbl2()
{
    $('#example2').dataTable({
        //"aaSorting": [[ 1, "desc" ]],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
}
function paginationTbl3()
{
    $('#example3').dataTable({
        //"aaSorting": [[ 1, "desc" ]],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers"
    });
}
//main menu nevigation
function fnMainMenuNavigation(url,menuId,navId1,navId2){
 // alert(menuId);
    $('.messageDiv').hide(); 
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){  
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
                if(result.success){    
                    $('#content').empty().append(result.html).trigger("datePicker");  
                    $('#tabs ul li a').removeClass('active');
                    $('#'+menuId).addClass('active');               
                    $('#navMenuPath3').text('');    
                    $('#navMenuPath1').text(navId1);
                   // $('#navMenuPath2').text('> '+navId2+' >'); 
                   if(navId2!=''){
                        $('#navMenuPath2').text('> '+navId2);   
                    }
                    paginationTbl();
                    stopLoading();
                    $("html,body").animate({scrollTop: 0}, 0);
                }
                else{
                     $('.messageDiv').show();                       
                     $('.message').empty().addClass('alert-box').addClass('warning');
                     $('.message').append('<span>Warning: </span>' + result.message);
                     stopLoading();
                     $("html,body").animate({scrollTop: 0}, 0);
                }
           },
            error: function(){ 
                fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
                scrollToMessage();
                stopLoading();
            }
        });   
}

//left menu nevigation
function fnLeftMenuNavigation(url,menuId,navId1,navId2,navId3){
    $('.messageDiv').hide(); 
     startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);                    
                    return;
                }
                if(result.success){ 
                   stopLoading();
                    $('#right-content').empty().append(result.html).trigger("datePicker");  
//                    if(result.secondHtml!=null){
//                        $('.application-form').empty().append(result.secondHtml);
//                    }
                    $('#newmenu ul li').removeClass('active');
                    $('#'+menuId).addClass('active');                        
                    $('#navMenuPath1').text(navId1); 
                    $('#navMenuPath2').text('> '+navId2);
                    if(navId3!==undefined){
                        $('#navMenuPath3').text('> '+navId3);
                    }else{
                        $('#navMenuPath3').text('');
                    }
                    paginationTbl(); 
                    paginationTbl2(); 
                    paginationTbl3();
                    $("html,body").animate({scrollTop: 0}, 0);
                }
                else{
                    stopLoading();
                     $('.messageDiv').show();                       
                     $('.message').empty().addClass('alert-box').addClass('warning');
                     $('.message').append('<span>Warning: </span>' + result.message);
                     //stopLoading();
                     $("html,body").animate({scrollTop: 0}, 0);
                }
                 
           },
            error: function(){ 
                fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
                scrollToMessage();
                stopLoading();
            }
        });         
}
//sub menu nevigation 
function fnSubMenuNavigation(url,menuId,navId1,navId2,navId3){ 
    $('.messageDiv').hide(); 
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){                
                if(result.jsonData=='AD'){
                    AccessDenied(result.html);                    
                    return;
                }
                if(result.success){                                 
                
                   //$('#right-content').empty().append(result.html); 
                   $('.application-form').empty().append(result.html).trigger('datePicker');
                    //$('.newdashboard').empty().append(result.html);                  
                    $('.sub-menu ul li').removeClass('active');
                    $('#'+menuId).addClass('active'); 
                    $('#navMenuPath1').text(navId1); 
                    $('#navMenuPath2').text('> '+navId2);
                    if(navId3!=''){
                        $('#navMenuPath3').text('> '+navId3);
                    }
                    if(result.secondHtml!=null){
                        AppendSecondHtml(result.secondHtml['appendid'],result.secondHtml['html']);
                    }
                    stopLoading();
                    paginationTbl();                    
                    $("html,body").animate({scrollTop: 0}, 0);
                }
                else{
                     fnCmnErrorMessage(result.message);
                     stopLoading();
                     $("html,body").animate({scrollTop: 0}, 0);
                }
           },
            error: function(){ 
                fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
                scrollToMessage();
                stopLoading();
            }
        });   
}

//inner sub menu nevigation 
function fnInnerSubMenuNavigation(url,menuId, cmnID){ 
    $('.messageDiv').hide(); 
    var loadID = {'loadID': $('#'+cmnID).val() };      
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: loadID,
            dataType:'json',         
            success: function (result){ 
               if(result.success){   
                    $('.right-inner-sub-content').empty().append(result.html);                  
                    $('#inner-sub-menu .sub-menu ul li').removeClass('active');
                    $('#'+menuId).addClass('active');                  
                     paginationTbl();
                     stopLoading();
                     $("html,body").animate({scrollTop: 0}, 0);
                }
                else{
                     $('.messageDiv').show();                       
                     $('.message').empty().addClass('alert-box').addClass('warning');
                     $('.message').append('<span>Error: </span>' + result.message);
                     stopLoading();
                     $("html,body").animate({scrollTop: 0}, 0);
                }
           },
            error: function(){ 
                fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');  
                scrollToMessage();
                stopLoading();
            }
        });   
}
function AppendSecondHtml(appendid,html){
    $('#'+appendid).empty().append(html);
}