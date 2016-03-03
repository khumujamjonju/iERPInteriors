/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function toggleSelectArea(chkbox,id){
    var input=document.getElementById('inputarea'+id);
    if(chkbox.checked){
        input.value=id;
    }else{
        input.value='';
    }
}
function ManageProductCategory(url,formId)
{       //               create Category name
  $('.messageDiv').hide();
    var AreaInputs=document.getElementsByClassName('inputarea');
    var isSelected=false;
    for(var i=0;i<AreaInputs.length;i++){
        if(AreaInputs[i].value!=''){
            isSelected=true;
            break;
        }
    }
    if(!isSelected){
        fnCmnWarningMessage("You did not selected any Project Area");
        scrollToMessage();
        return;
        }
    
    if($('#txtCategory').val().trim()=='')
    {
        fnCmnWarningMessage("Enter Category Name");
        $('#txtCategory').focus();
        scrollToMessage();
        return;
    }
    if($('#txtDescription').val().trim()==''){
        fnCmnWarningMessage("Enter Description");
        $('#txtDescription').focus();
        scrollToMessage();
        return;
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
                    AccessDenied();
                    return;
                }
            if(Response.success){        
                fnCmnSuccessMessage(Response.message);
                scrollToMessage();
                $('#Newcatlist').empty().append(Response.html);
                stopLoading();
                paginationTbl();
                
            }
            else{
                fnCmnWarningMessage(Response.message);
                scrollToMessage();
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
function CategoryActions(rawurl)
{
    $('.messageDiv').hide();
//    var rawurl = $('#prodcat'+id).val();
//    if(rawurl==''){
//        return;
//    }
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected category'))
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
                    AccessDenied();
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
function CancelCategoryUpdate(url){
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
          if(Response.success) 
            {                
                $('#right-content').empty().append(Response.html);
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
function categoryAction(id)
{
    $('.messageDiv').hide();
    var rawurl = $('#prodcat'+id).val();
    if(rawurl==''){
        return;
    }
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected category'))
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
          if(Response.success) 
            {
                if(action=='del'){
                    $('#Newcatlist').empty().append(Response.html);
                    paginationTbl();
                    fnCmnSuccessMessage(Response.message);
                    scrollToMessage();
                }
                else{
                    $('#catsaveEditPage').empty().append(Response.html);
                }
                
            }
            else{
                fnCmnWarningMessage(Response.message);
                scrollToMessage();
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
    stopLoading();
}
function cancelcategoryupdate(url){
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
          if(Response.success) 
            {
               $('.right-content').empty().append(Response.html);
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

function NewSubCategoryPage()
{   
    $('.messageDiv').hide();
    var url= $('#catid').val();
    if(url=='')
    {
        fnCmnWarningMessage("Please select a Category");
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
            if(Response.success){
                $('#subcatArea').empty().append(Response.html);
            }
            else{
                fnCmnWarningMessage(Response.message);
                scrollToMessage();
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
    stopLoading();
}
function insertsubcat(url,formId)
{
    $('.messageDiv').hide();
    if($('#subCatName').val().trim()==''){
        fnCmnWarningMessage('Enter Sub Category Name');
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
            if(Response.success) 
            {
                fnCmnSuccessMessage(Response.message);
                scrollToMessage();
                $('#catListArea').empty().append(Response.html);
                NewSubCategoryPage();
            }
            else{
                fnCmnWarningMessage(Response.message);
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });  
    stopLoading();
}
function DeleteSubCat(url,formId){
    $('.messageDiv').hide();
    if(!confirm('Are you sure?'))
        return;
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
            if(Response.success) 
            {
                fnCmnSuccessMessage(Response.message);
                scrollToMessage();
                var url1= $('#catid').val();
                $.ajax({            
                    type: 'POST',
                    url: url1,
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(Response)
                    { 
                        if(Response.success){
                            $('#subcatArea').empty().append(Response.html);
                        }
                        else{                            
                        }
                    },
                    error: function()
                    { 
                    }
                });
            }
            else{
                fnCmnWarningMessage(Response.message);
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    }); 
    stopLoading();
}
function subcatAddEdit(id)
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
             if(Response.success) 
               {
                   $('#addsubcat').empty().append(Response.html);
               }
               else{
                   fnCmnWarningMessage(Response.message);
                   scrollToMessage();
               }
           },
           error: function()
           { 
               fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
               scrollToMessage();
           }
       });
    stopLoading();
}

////////////////////////////////////////////////////////
///////         ATTRIBUTE       ////////////////////////
////////////////////////////////////////////////////////
function createNewAttribute(url,formId)
{          
    $('.messageDiv').hide();
     if($('#txt_productAttributeName').val().trim()=='')
    { 
        fnCmnWarningMessage('Enter Attribute Name!!');
        $('#txt_productAttributeName').focus();
        scrollToMessage();
        return false;
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
            if(Response.success)
            {
                $('#display-list').empty().append(Response.html);                
                fnCmnSuccessMessage(Response.message);
                scrollToMessage();
                paginationTbl();
            }
            else
            {
                fnCmnWarningMessage(Response.message);
            }
            scrollToMessage();            
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();            
        }        
    });
    stopLoading();
}

function EditDeleteAttributeMaster(id)
{
    $('.messageDiv').hide();
    var rawurl= $('#catattr'+id).val();
    if(rawurl=='')
    return;
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected Attribute?'))
            return;
    }
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success){
                if(action=='edt'){
                    $('#attrinsertform').empty().append(Response.html);
                    document.getElementById('attrinsertform').scrollIntoView();
                }
                else if(action=='del'){
                    $('#right-content').empty().append(Response.html);
                    paginationTbl();
                    fnCmnSuccessMessage(Response.message);                    
                    scrollToMessage();
                }
            }
            else{
                fnCmnWarningMessage(Response.message);
                scrollToMessage();
            }
        },
        error: function()
        { 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });  
}
function cancelAttrUpdate()
{
    $('#txt_productAttributeName').val('');
    $('#txt_pkid').val('');
    $('#txt_Description').val('');
    $('#btn_update').hide();
    $('#btn_save').show();
    $('#btn_cancel').hide();
}
function UpdateAttribute(url){
    $('.messageDiv').hide();    
    var frmData=$('form#frmAttribute').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(Response)
        {
            stopLoading();
            if(Response.success){
                $('#display-list').empty().append(Response.html);                
                fnCmnSuccessMessage(Response.message);  
                scrollToMessage();
                paginationTbl();
            }
            else{
                fnCmnWarningMessage(Response.message);
            }
            scrollToMessage();
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
    
}
function loadsubcatforattrassign()
{
    $('.messageDiv').hide();
    var url =$('#pkid').val();
    if(url=='')
    {            
        document.getElementById('searchvalue').value='';
        $('#textlabel').text('Select Attribute');
        $('#tbodyDynamic').empty();
        return;
    }
    startLoading();
    var tabId = url.split("/").pop(); 
    document.getElementById('searchvalue').value=tabId;    
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        {
            stopLoading();
            if(Response.success) 
            {
                $('#tbodyDynamic').empty().append(Response.html);
                $('#attributeadd').empty().append(Response.secondHtml);
                if(Response.jsonData!=null){
                    $('#isExistingAttr').val('1');
                }
                else{
                     $('#isExistingAttr').val('0');
                }
                showdefualtRow_AttrAssign();
            }
            else
            {
                $('#tbodyDynamic').empty();               
                $('#attributeadd').empty().append(Response.secondHtml);
                if(Response.jsonData!=null){
                    $('#isExistingAttr').val('1');
                }
                else{
                     $('#isExistingAttr').val('0');
                }
                showdefualtRow_AttrAssign();
            }
            $('#textlabel').text(Response.page);
        },
        error: function()
        {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });      
}

function loadsubcatdyforattrassign(id)
{
    $('.messageDiv').hide();
    var url =$('#pkid'+id).val();
    startLoading();
    if(url=='')
    {
        var tb = document.getElementById('tbodyDynamic');
         $('#textlabel').text('Select Attribute');
        var tr = document.getElementById(id);
        var i = tr.rowIndex;
        while (tb.rows.length > i)
        {
            tb.deleteRow(i);
        }
        return false;
    }
    var tabId = url.split("/").pop();  
   
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success) 
            {                        
                var tb=document.getElementById('tbodyDynamic');
                var tr=document.getElementById(id);
                var i=tr.rowIndex;
                while(tb.rows.length>i)
                {
                    tb.deleteRow(i);
                }
                $('#tbodyDynamic').append(Response.html);
                $('#attributeadd').empty().append(Response.secondHtml);
                if(Response.jsonData!=null){
                    $('#isExistingAttr').val('1');
                }
                else{
                     $('#isExistingAttr').val('0');
                }
                showdefualtRow_AttrAssign();
                $('#textlabel').text(Response.page);
                document.getElementById('searchvalue').value=tabId;
                stopLoading();
            }
            else
            {
                var tb=document.getElementById('tbodyDynamic');
                var tr=document.getElementById(id);
                var i=tr.rowIndex;
                while(tb.rows.length>i){
                    tb.deleteRow(i);
                }
                document.getElementById('searchvalue').value=tabId;
                $('#attributeadd').empty().append(Response.secondHtml);
                if(Response.jsonData!=null){
                    $('#isExistingAttr').val('1');
                }
                else{
                     $('#isExistingAttr').val('0');
                }
                showdefualtRow_AttrAssign();
                $('#textlabel').text(Response.page);
                stopLoading();
                if(Response.message!=null && Response.message!=''){
                    fnCmnWarningMessage(Response.message);
                }
            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });     
}
function AppendAttributeForAssignment()
{
    $('.messageDiv').hide();
    if($('#pkid').val().trim()==''){
        return;
    }
    var path = $('#selectattribute').val(); 
    if(path==''){
        return;
    }
    var tabId = path.split("/").pop();

    if(document.getElementById('attr'+tabId))
    {
       fnCmnWarningMessage('Already selected');
       return false;
    }
    startLoading();
    $.ajax({            
        type: 'POST',
        url: path,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success) 
            { 
                $('#attributeadd').append(Response.html);  
                var tbody=document.getElementById('attributeadd');
                var defRow=document.getElementById('defRow');
                if(defRow!=null){
                    tbody.deleteRow(0);
                }
                if(Response.jsonData!=null){
                    $('#isExistingAttr').val('1');
                }
                else{
                    $('#isExistingAttr').val('0');
                }
                stopLoading();                       
            }
            else
            {
                stopLoading();
                fnCmnWarningMessage(Response.message);
            }
        },
        error: function()
        {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    }); 
}
function showdefualtRow_AttrAssign(){
    var tbody=document.getElementById('attributeadd');
    if(tbody.rows.length<=0){
        $('#attributeadd').append('<tr id="defRow">'+
                    '<td class="td-white-bg" align="center" colspan="2" style="color:#ff0000;">'+
                    'No Attributes Selected.</td></tr>');
    }
}
function insertcatAttr(url,formId)
{
    $('.messageDiv').hide();
    
    if($('#pkid').val().trim()==''){
        fnCmnWarningMessage('No Category/Subcategory selected.');
        scrollToMessage();
        return;
    }
    var tbody=document.getElementById('attributeadd');
    if(tbody.rows.length<=0 && $('#isExistingAttr').val()=='0'){ // if value of hidden input #isExistingAttr is 1 then it the selected catrgory/subcat has existing attribute and allowing it to delete.
        fnCmnWarningMessage('No attribute(s) selected');
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
            if(Response.success) 
            {
                stopLoading();
                fnCmnSuccessMessage(Response.message);
                scrollToMessage();
            }
            else
            {
                stopLoading();
                fnCmnWarningMessage(Response.message);
                scrollToMessage();
            }
        },
        error: function()
        {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    }); 
 }

////////////////////////////////////////////////////////
///////         UNIT       ////////////////////////
////////////////////////////////////////////////////////

function createNewUnit(url,formId)
{                  
    if($('#txt_unit').val().trim()=='')
    { fnCmnWarningMessage('Enter Unit Name!!');
        $('#txt_unit').focus();
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
            if(Response.success)
            {
                stopLoading();
                $('#display-list').empty().append(Response.html);
                paginationTbl();
                fnCmnSuccessMessage(Response.message); 
                scrollToMessage();                
            }
            else
            {
                fnCmnWarningMessage(Response.message); 
                stopLoading();
            }          
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();           
        }
    });  
}
function EditDelUnitMaster(id)
{
    $('.messageDiv').hide();
    var rawurl= $('#unit'+id).val();
    if(rawurl=='')
    return;
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected Attribute?'))
            return;
    }
    if(url=='')
    return false;
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success)
            {
                stopLoading();
                if(action=='edt'){
                    $('#unitCreate').empty().append(Response.html);
                    stopLoading();
                }
                else if(action=='del'){                    
                    $('.application-form').empty().append(Response.html);
                    paginationTbl();
                    fnCmnSuccessMessage(Response.message);
                    scrollToMessage();                    
                }
            }
        },
        error: function()
        {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });  
}
function UpdateUnit(url,formId){
    if($('#txt_unit').val().trim()=='')
    { fnCmnWarningMessage('Enter Unit Name!!');
        $('#txt_unit').focus();
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
            if(Response.success)
            {
                stopLoading();
                $('#display-list').empty().append(Response.html);
                paginationTbl();
                fnCmnSuccessMessage(Response.message); 
                scrollToMessage();
                
            }
            else
            {
                fnCmnWarningMessage(Response.message); 
                stopLoading();
            }          
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}
function cancelupdateunit()
{
    $('#txt_unit').val('');
    $('#pkid').val('');
    $('#txt_Description').val('');
    $('#btn_update').hide();
    $('#btn_save').show();
    $('#btn_cancel').hide();  
}
function loadattribute()
 {
    var url=$('#attriblist').val();
    var tabId = url.split("/").pop();
    if(url==''){
        $('#textlable').text('Select Unit :');
        $('#attrpkid').val('');
            return false;
    }
    startLoading();
    $('#attrpkid').val(tabId);
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success) 
            {
                stopLoading();
                $('#textlable').text(Response.page);
                if(Response.secondHtml=='true'){
                    $('#attrUnitlist').empty().append(Response.html);
                }
                else
                   $('#attrUnitlist').empty();
            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    }); 
}
function addselectedunit()
{
    var url=$('#unitList').val();
    var tabId = url.split("/").pop();     
    if(document.getElementById('unit'+tabId))
    {
        fnCmnWarningMessage('Unit already selected');
        return false;
    }
    if(url=='')
    return false;
    startLoading();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
          if(Response.success) 
            {      
                stopLoading();
                $('.messageDiv').hide();
                $('#attrUnitlist').append(Response.html);                     
            }             
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}

function insertAttrUnit(url)
{
    if ($('#attriblist').val().trim()=='')
    {
       fnCmnWarningMessage('Please Select Attribute');
       return ;
    } 
    startLoading();
    var formData = $('form#'+'frmAttrUnitInsert').serializeObject();
    var dataString = JSON.stringify(formData);      
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success) 
            {
                stopLoading();
                fnCmnSuccessMessage(Response.message);
                scrollToMessage();
            }
            else
            {
                stopLoading();
                fnCmnWarningMessage(Response.message);
                scrollToMessage();
            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });   
}

////////////////////////////////////////////////////////
///////////////////    PRODUCT     /////////////////////
////////////////////////////////////////////////////////

function loadsubcat()
{
    $('.messageDiv').hide();
    var url =$('#pkid').val();
    if(url=="")
    {
        document.getElementById('searchvalue').value='';
        $('#prdproductList').empty();
        $('#tbodyDynamic').empty();
        $('#createprod').empty();
        return;
    }
    startLoading();
    var tabId = url.split("/").pop(); 
    document.getElementById('searchvalue').value=tabId;    
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success) 
            {
                stopLoading();
                $('#tbodyDynamic').empty().append(Response.html);
                if(Response.secondHtml!=null){
                    $('#prdproductList').empty().append(Response.secondHtml);
                    paginationTbl();
                }   
                else{
                    $('#prdproductList').empty();
                }
                $('#addStock').empty();
                $('#createprod').empty();
                $('#prdtList').empty();
                $('.trMessage').hide();                 
            }
            else
            {
                stopLoading();
                fnCmnWarningMessage(Response.message);
                scrollToMessage();
                if(Response.secondHtml!=null){
                    $('#prdproductList').empty().append(Response.secondHtml);
                    paginationTbl();
                } 
                else{
                    $('#prdproductList').empty();
                }
                $('#tbodyDynamic').empty();
                $('#addStock').empty();
                $('#createprod').empty();
                $('#prdtList').empty();
            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });      
}
function LoadDynamicItem(id)
{
    $('.messageDiv').hide();
    var url =$('#pkid'+id).val();
    if(url=="")
    {        
        var tb = document.getElementById('tbodyDynamic');
        var tr = document.getElementById(id);
        var i = tr.rowIndex;
        while (tb.rows.length > i)
        {
            tb.deleteRow(i);
        }
        $('#prdproductList').empty();
        $('#categoryarea').empty();
        $('#editArea').empty();
        $('#createprod').empty();        
        return;
    }
    startLoading();
    var tabId = url.split("/").pop();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success) 
            {                        
                var tb=document.getElementById('tbodyDynamic');
                var tr=document.getElementById(id);
                var i=tr.rowIndex;
                while(tb.rows.length>i)
                {
                    tb.deleteRow(i);
                }
                $('#tbodyDynamic').append(Response.html);
                $('#prdproductList').empty().append(Response.secondHtml);
                stopLoading();
                paginationTbl();
            }
            else
            {
                var tb=document.getElementById('tbodyDynamic');
                var tr=document.getElementById(id);
                var i=tr.rowIndex;
                while(tb.rows.length>i){
                    tb.deleteRow(i);
                }
                $('#searchvalue').val(tabId);                  
                $('#prdproductList').empty().append(Response.secondHtml);
                stopLoading();
                paginationTbl();
                fnCmnWarningMessage(Response.message);
                scrollToMessage();

            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });     
}
function loadsubcatdy(id)
{
    $('.messageDiv').hide();
    var url =$('#pkid'+id).val();
    if(url=="")
    {        
        var tb = document.getElementById('tbodyDynamic');
        var tr = document.getElementById(id);
        var i = tr.rowIndex;
        while (tb.rows.length > i)
        {
            tb.deleteRow(i);
        }
        return;
    }
    startLoading();
    var tabId = url.split("/").pop();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success) 
            {                        
                var tb=document.getElementById('tbodyDynamic');
                var tr=document.getElementById(id);
                var i=tr.rowIndex;
                while(tb.rows.length>i)
                {
                    tb.deleteRow(i);
                }
                $('#tbodyDynamic').append(Response.html);
                $('#prdproductList').empty().append(Response.secondHtml);
                paginationTbl();
                $('#addStock').empty();
                $('#searchvalue').val(tabId);
                $('.trMessage').hide();
                $('#createprod').empty();
                $('#prdtList').empty();
                stopLoading();
            }
            else
            {
                var tb=document.getElementById('tbodyDynamic');
                var tr=document.getElementById(id);
                var i=tr.rowIndex;
                while(tb.rows.length>i){
                    tb.deleteRow(i);
                }
                $('#searchvalue').val(tabId);                  
                $('#prdproductList').empty().append(Response.secondHtml);
                paginationTbl();
                $('#addStock').empty();
                $('#createprod').empty();
                $('#prdtList').empty();
                stopLoading();
                fnCmnWarningMessage(Response.message);
                scrollToMessage();

            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });     
}
function GotoCreateNewProd(url)
{
    $('.messageDiv').hide();
    $('#editArea').empty();
    startLoading();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success) 
            {
                lmsShowHideAddressResult('SelectCategory');
                lmsShowHideAddressResult('prdlist');
                $('#createprod').empty().append(Response.html);
                if(Response.page=='true')
                $('#attributearea').empty().append(Response.secondHtml);
                stopLoading();
            }
            else
            {
                stopLoading();
                fnCmnWarningMessage(Response.message);
                $('#createprod').empty();
            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });       
}
function calculateFileSize(file,recommendedsizeinMb,spanid){
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
function newprodInsert(url,formId,mode,from) 
{
    $('.messageDiv').hide();
    if($('#selCategory').val().trim()==''){
        fnCmnWarningMessage('Select Product category!!');
        $('#selCategory').focus();
        scrollToMessage();
        return;
    }
    if($('#prodCodeIns').val().trim()=='')
    { 
        fnCmnWarningMessage('Enter Product Code!!');
        $('#prodCode').focus();
        scrollToMessage();
        return;
    }
    if($('#prodNameIns').val().trim()=='')
    { 
        fnCmnWarningMessage('Enter Product Name!!');
        $('#prodNameIns').focus();
        scrollToMessage();
        return;
    }
    if(parseFloat($('#txtPurchasePrice').val())<=0)
    { 
        if(!confirm('Purchase Price is 0(zero).Is this okay?'))
            return;
    }
    if(parseFloat($('#txtSellingprice').val())<=0)
    { 
        if(!confirm('Selling Price is 0(zero).Is this okay?'))
            return;
    }
    if($('#prodDescIns').val().trim()==''){
        fnCmnWarningMessage('Enter Product Description!!');
        $('#prodDescIns').focus();
        scrollToMessage();
        return;
    }
    if($('#fileProdImg').val().trim()!=''){
        var fileInput=document.getElementById('fileProdImg');
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
//        if(fsizeMb%2>=1){
//            fnCmnWarningMessage('File size exceeds maximum uploadable size. Recommended size is upto 512Kb.');
//            $('#fileProdImg').focus();
//            scrollToMessage();
//            return;
//        }        
         if(!isValid){
            fnCmnWarningMessage('The image file you have chosen is invalid.');
            $('#fileProdImg').focus();
            scrollToMessage();
            return;
        }
    }
    var supplier = document.getElementsByName('chkSupplier[]');
    var supplierChk=false;
    if(supplier==null || supplier.length<=0){
        fnCmnWarningMessage('It seems you have not created any Supplier. You must create atleast one Supplier to proceed.');
        //$('#fileProdImg').focus();
        scrollToMessage();
        return;
    }else{
        for(var i=0;i<supplier.length;i++){
            if(supplier[i].checked){
                supplierChk=true;
                break;
            }
        }
        if(!supplierChk){
            fnCmnWarningMessage('Please select atleast one Supplier to proceed.');
            scrollToMessage();
            return;
        }
    }
    
//    if($('#CatIns').val().trim()=='')
//    { 
//        fnCmnWarningMessage('Please Select Category!!');
//        $('#CatIns').focus();
//        return false;
//    }
    if(mode=='upd'){
        if(!confirm('Confirm Update?'))
            return;
    }
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
        success: function(Response){
            if(Response.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if(Response.success)
            {                
                var msg=Response.message;
                //$('#productSearchList').empty().append(Response.html);
                if(from=='search'){
                    SearchProduct();
                    fnCmnSuccessMessage(msg);
                    scrollToMessage();
                    
                }else{
                    $('.application-form').empty().append(Response.html);
                    stopLoading();                    
                }
            }
            else
            {
                stopLoading();
                fnCmnWarningMessage(Response.message);
                scrollToMessage();
            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}
function ViewProductDetail(url,action,mode,from) 
{
    $('.messageDiv').hide();
    $('#createprod').empty();
//    var selValue = $('#prodtype' + prodID).val();
//    if (selValue === '') {
//        return ;    
//    }    
//    var url=selValue.split('&')[0];
//    var action=selValue.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected product?'))
            return;
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',            
        dataType: 'json',
        success: function(result) {
            if(result.success){ 
                if(Response.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
                var msg=result.message;
                if(action=='del'){                    
                    if(from=='search'){
                        SearchProduct(); 
                        $('#categoryarea').empty();
                        $('#editArea').empty();
                        $('#createprod').empty(); 
                    }
                    else{
                        $('#prdproductList').empty().append(result.html);
                        paginationTbl();                        
                    }
                    stopLoading();
                    fnCmnSuccessMessage(msg);
                    scrollToMessage();
                }
                else{
                    if(mode=='result')
                    {                        
                        lmsShowHideAddressResult('SearchProductResult');
                        lmsShowHideAddressResult('SearchProductForm');                                                
                    }           
                    $('#editArea').empty().append(result.html);
                    document.getElementById('editArea').scrollIntoView();
                    if(result.page=='true'){
                        $('#attributearea').empty().append(result.secondHtml);
                    }
                    lmsShowHideAddressResult('prdlist');
                    stopLoading();
                }                
            }
        else{   
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}
function gotoapproveproduct(url){
    $('.messageDiv').hide();
    $('#createprod').empty();   

    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',            
        dataType: 'json',
        success: function(result) {
            if(result.success){
                $('#editArea').empty().append(result.html);
                document.getElementById('editArea').scrollIntoView();
                if(result.page=='true'){
                    $('#attributearea').empty().append(result.secondHtml);
                }
                stopLoading();
            }
            else{   
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}
function ApproveProduct(url,from){
    $('.messageDiv').hide();
    if(!confirm('Confrim Product Approval?')){
        return;
    }
    startLoading();
    var frmData=$('frm#frmApproveProduct').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(result) {
            if(result.success){ 
                var msg=result.message
                if(from=='search'){
                    SearchProduct();                     
                }
                else{
                    $('#prdproductList').empty().append(result.html);
                    $('#editArea').empty();
                    paginationTbl();              
                }
                stopLoading();
                fnCmnSuccessMessage(msg);
                scrollToMessage();
                
            }
            else{   
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }        
    });
}
function cancelprodapproval(){
    $('.messageDiv').hide();
    if(!confirm('Are you sure you want to cancel Product Approval?')){
        return;
    }
    $('#editArea').empty();
    scrolltodiv('prdproductList');
}
function loadsubcatonly(){
    $('.messageDiv').hide();
    var url =$('#pkid').val();
    if(url=="")
    {
        document.getElementById('searchvalue').value='';
        $('#tbodyDynamic').empty();
        return;
    }
    startLoading();
    var tabId = url.split("/").pop(); 
    document.getElementById('searchvalue').value=tabId;    
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success) 
            {
                stopLoading();
                $('#tbodyDynamic').empty().append(Response.html);                                 
            }
            else
            {
                stopLoading();
                fnCmnWarningMessage(Response.message);
                scrollToMessage();                
                $('#tbodyDynamic').empty();               
            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}
function loadsubcatdyonly(id)
{
    $('.messageDiv').hide();
    var url =$('#pkid'+id).val();
    if(url=="")
    {        
        var tb = document.getElementById('tbodyDynamic');
        var tr = document.getElementById(id);
        var i = tr.rowIndex;
        while (tb.rows.length > i)
        {
            tb.deleteRow(i);
        }
        return;
    }
    startLoading();
    var tabId = url.split("/").pop();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
            if(Response.success) 
            {                        
                var tb=document.getElementById('tbodyDynamic');
                var tr=document.getElementById(id);
                var i=tr.rowIndex;
                while(tb.rows.length>i)
                {
                    tb.deleteRow(i);
                }
                $('#tbodyDynamic').append(Response.html);               
                stopLoading();
            }
            else
            {
                var tb=document.getElementById('tbodyDynamic');
                var tr=document.getElementById(id);
                var i=tr.rowIndex;
                while(tb.rows.length>i){
                    tb.deleteRow(i);
                }
                $('#searchvalue').val(tabId);       
                stopLoading();
                fnCmnWarningMessage(Response.message);
                scrollToMessage();

            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });     
}
function toggleSearchCriteria(select){  
    $('#selSearchCategory').hide();
    $('#selSearchCategory').val('');
    $('#selSupplier').hide();
    $('#selSupplier').val('');
    $('#txtCriteria').hide();
    $('#txtCriteria').val('');
    $('#txtdate').hide();    
    $('#tbodyDynamic').empty();
    $('#tdtitle').text('Criteria');
    switch(select.value){
        case 'cat':
            $('#selSearchCategory').show();
            break;
        case 'sup':
            $('#selSupplier').show();
            break;
        case 'codename':
            document.getElementById('txtCriteria').placeholder='Enter Product Code or Name';
            $('#txtCriteria').show();
            break;
        case 'brand':
            document.getElementById('txtCriteria').placeholder='Enter Manufacturer Name';
            $('#txtCriteria').show();
            break;
        case 'date':
            $('#txtdate').show();
            break;
        default:
            $('#tdtitle').text('');
            break;
    }
}
function SearchProduct(){
    $('.messageDiv').hide();
    switch($('#selSearchProdCriteria').val()){
        case 'cat':
            if($('#selSearchCategory').val().trim()==''){
                fnCmnWarningMessage('Select Product Category');
                $('#selSearchCategory').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'sup':
            if($('#selSupplier').val().trim()==''){
                fnCmnWarningMessage('Select Supplier');
                $('#selSupplier').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'codename':
            if($('#txtCriteria').val().trim()==''){
                fnCmnWarningMessage('Enter Product Code or Name');
                $('#txtCriteria').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'brand':
            if($('#txtCriteria').val().trim()==''){
                fnCmnWarningMessage('Enter Manufacturer Name');
                $('#txtCriteria').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'date':
            if($('#txtdate').val().trim()==''){
                fnCmnWarningMessage('Select Entry Date');
                scrollToMessage();
                return;
            }            
            break;
    }
    var url=$('#inputsearchproductUrl').val();
    var frmData=$('form#frmSearchProduct').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(Response)
        {
            if(Response.jsonData=='AD'){
                    AccessDenied();
                    return;
                }
            if(Response.success) 
            {
                stopLoading();
                $('#prdproductList').empty().append(Response.html);   
                paginationTbl();
            }
            else
            {
                stopLoading();
                fnCmnWarningMessage(Response.message);
                scrollToMessage();                
                $('#prdproductList').empty();               
            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });
}
function AddUnitRow(){
//    var tbl=document.getElementById('tblPrdUnit');
//    var tr=tbl.insertRow();
//    var cell1=tr.insertCell();
//    var cell2=tr.insertCell();
    var trow='<tr>'+
            '<td class="td-white-bg"><input type="hidden" name="txtUnitId[]" value=""><input type="text" name="txtUnit[]" placeholder="Enter Unit Name"></td>'+
            '<td class="td-white-bg"><input type="button" class="button" value="-" title="Remove unit" onclick="RemoveUnitRow(this);"/></td>'+
            '</tr>';
    $('#tblPrdUnit tr:last').after(trow);
//    tr.id='trunit'+;
//    cell1.innerHTML='';
//    cell1.className="td-white-bg";
//    cell2.innerHTML='<input type="button" class="button" value="-" title="Remove unit" onclick="RemoveUnitRow(\''+tr.id+'\');"/>';
//    cell2.className="td-white-bg";    
}
function RemoveUnitRow(btn){
    $(btn).closest('tr').remove();
    var tbl=document.getElementById('tblPrdUnit');
    if($('#tblPrdUnit tr').length<=0){
        var trow='<tr>'+
            '<td class="td-white-bg"><input type="hidden" name="txtUnitId[]" value=""><input type="text" name="txtUnit[]" placeholder="Enter Unit Name"></td>'+
            '<td class="td-white-bg" width="30px"></td>'+
            '</tr>';
        document.getElementById('btnaddunit').style.marginLeft=-33+'px';
        $('#tblPrdUnit').empty().append(trow);
    }
//    var tr=document.getElementById(rowid);
//    tbl.deleteRow(tr.rowIndex);
//    if(tbl.rows.length<=0){
//        var tr=tbl.insertRow();
//        var cell1=tr.insertCell();
//        var cell2=tr.insertCell();
//        tr.id='trunit'+tbl.rows.length;
//        cell1.innerHTML='<input type="text" name="txtUnit" placeholder="Enter Unit Name">';
//        cell1.className="td-white-bg";
//        cell2.innerHTML='<input type="button" class="button" value="-" title="Remove unit" onclick="AddUnitRow();"/>';
//        cell2.className="td-white-bg";
//    }
}
function AddServiceRow(){    
    var trow='<tr>'+
            '<td class="td-white-bg"><input type="hidden" name="txtServiceId[]" value=""><input type="text" name="txtServicename[]" placeholder="Service Name" class="cmnWidth"></td>'+
            '<td><input type="text" name="txtServiceCharge[]" placeholder="Service Charge" class="money" onkeypress="return isValidNumber(event);"/></td>'+
            '<td class="td-white-bg"><input type="button" class="button" value="-" title="Remove Service" onclick="RemoveServiceRow(this);"/></td>'+
            '</tr>';
    $('#tblPrdService tr:last').after(trow);
}
function RemoveServiceRow(btn){
    $(btn).closest('tr').remove();
    var tbl=document.getElementById('tblPrdService');
    if($('#tblPrdService tr').length<=0){
        var trow='<tr>'+
            '<td class="td-white-bg"><input type="hidden" name="txtServiceId[]" value=""><input type="text" name="txtServicename[]" placeholder="Enter Service Name" class="cmnWidth"></td>'+
            '<td class="td-white-bg"><input type="text" name="txtServiceCharge[]" placeholder="Service Charge" class="money" onkeypress="return isValidNumber(event);"/></td>'+
            '<td class="td-white-bg" width="30px"></td>'+
            '</tr>';
        $('#tblPrdService').empty().append(trow);
        document.getElementById('btnAddservice').style.marginLeft=-35+'px';
    }
}


