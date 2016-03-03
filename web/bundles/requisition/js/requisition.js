function load_Page(url,elementObj)
{   var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="selectedEMp"]').val().trim()==''){
        fnCmnWarningMessage('Select employee first!');
        scrollToMessage();
        return false;
    }
    
    var empid={empid:$('#TYPEID').val()}; 
    var dataString = JSON.stringify(empid);
    $.ajax({
           type: 'POST',
           url: url,
           data:dataString ,
           contentType: 'application/json',            
           dataType: 'json',
           success: function(result) {
              
           if(result.success)
            {
                 $('#divOrderDetails').empty().append(result.html);
            }
           else
           {
                 fnCmnWarningMessage(result.message);
           }
           },
           error: function() 
           {
               fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
           }
       });
}

function LoadSubCategory1(thisid)
{
    var url =$('#'+thisid).val();
    if(url=="")
    {
        //fnCmnWarningMessage("Please Select A Category");
        $('#tbodyDynamic').empty();
        ScrollToMessage();
        return false;
    }
    startLoading();
    var tabId = url.split("/").pop(); 
    var inputsearch=document.getElementById('searchvalue');
    inputsearch.value=tabId;  
    $.ajax({            
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
          if(Response.success) 
            {  
                $('#tbodyDynamic').empty().append(Response.html);
                $('#dynamicproductcat').empty().append(Response.secondHtml);
                stopLoading();
            }
            else
            {
                fnCmnWarningMessage(Response.message);
                $('#dynamicproductcat').empty().append(Response.secondHtml);
                $('#tbodyDynamic').empty();
                ScrollToMessage();
                stopLoading();
            }
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToMessage();
        }
    }); 
}
function loadsubcatdynamic_req(id)
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
                                    
                var tb=document.getElementById('tbodyDynamic');
                var tr=document.getElementById(id);
                var i=tr.rowIndex;
                while(tb.rows.length>i)
                {
                    tb.deleteRow(i);
                }
                //$('#tbodyDynamic').append(Response.html);
                $('#prdproductList').empty().append(Response.html);
                
                $('#addStock').empty();
                $('#searchvalue').val(tabId);
                $('.trMessage').hide();
                $('#createprod').empty();
                $('#prdtList').empty();
                stopLoading();
            
        },
        error: function()
        { 
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
        }
    });     
}

 function SelectProductIdforReqEntry1(url){
    $('.messageDiv').hide();
    var prdid={prid:$('#selStkPrdList').val()};
     
    if(document.getElementById('pkid').value == '0')
    {
        commonMessageAlert('Please Select Project Area!');
        scrollToMessage();
        return false;
    }
    
     if(document.getElementById('selStkPrdList').value == '0')
    {
        commonMessageAlert('Please Select Category and then Product!');
        scrollToMessage();
        return false;
    }
      
    $('#spanErronSel').text('');
    $('#inputProductCode').val(prdid);
    
     
    startLoading();
    var frmdata=$('form#Requesition_details').serializeObject();
    var dataString=JSON.stringify($.extend(frmdata,prdid));
    $.ajax({            
        type: 'POST',
        url: url,
        data:dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        { 
          if(Response.success) 
            {      
                stopLoading();
                $('.messageDiv').hide();
                $('#result_po').show();
                $('#display_product').append(Response.html);    
                var quoted_total = 0;
                $('#display_product').find('.total').each(function(){
                    var element_input_val = $(this).val();
                    if(element_input_val == '')
                    {
                        element_input_val = 0;
                    }
                    quoted_total = parseFloat(quoted_total + parseFloat(element_input_val));  
                    
                    $('.quotedtotal').html(quoted_total);
                    $('#quoted').val(quoted_total);
                });
            
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

function CriteriaPurposeSearch(selid,pkid){
  
    switch(selid.value){
        case '1':   
            document.getElementById('officeuse'+pkid).placeholder='BRANCH CODE';
            $('#officeuse' + pkid).show();
            break;
        case '2':
            document.getElementById('officeuse'+pkid).placeholder='PROJECT ID/ORDER NO.';
            $('#officeuse' + pkid).show();
            break;
        case '3':
            document.getElementById('officeuse'+pkid).placeholder='EMPLOYEE ID';
            $('#officeuse' + pkid).show();
            break;
        
       
    }
}

function SearchRequisitionCriteria(selid){
    var sel=document.getElementById(selid);
    $('#trcriteria').show();
    $('#selProjCategory').hide();
    $('#txtCriteria').hide();
    $('#txtdate').hide();
    $('#divDate').hide();
    $('#selProjStatus').hide();
    $('#tdtitle').text('Criteria');
    switch(sel.value){
        case 'select':           
            $('#trcriteria').hide();
            $('#Date').hide();
            $('#selPurStatus').hide();
            break;
        case 'all':           
            $('#trcriteria').hide();
            break;
         
       case 'requisition':
           $('#Date').show();
            break;
        
        case 'status':
           $('#selPurStatus').show();
           $('#Date').hide();
            break;
        default:
           $('#tdtitle').empty();            
           break;
    }
}

function SearchRequisition(){
    $('.messageDiv').hide();
   
    var x = document.getElementById("selSearchRequisition").value;
    if (x == 0)
    {
        fnCmnWarningMessage('Please Select Search Criteria!');
        scrollToMessage();
        return false;
    }
    
    
    switch($('#selSearchRequisition').val()){        
         
        case 'date':
            if($('#date').val().trim()==''){
                fnCmnWarningMessage('Please select date!!!');
                $('#date').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'status':
            if($('#selPurStatus').val().trim()==''){
                fnCmnWarningMessage('Select Status!!!');
                $('#selPurStatus').focus();
                scrollToMessage();
                return;
            }
            break;
    }
    
     
    
    
    startLoading();
    var url=$('#inputsearchrequisitionUrl').val();
    var frmData=$('form#frmRequisitionDetails').serializeObject();
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
                $('#divRequisitionOrderDetailsList').empty().append(result.html);  
                paginationTbl();
//                 $('.messageDiv').show();  
//                fnCmnSuccessMessage(result.message);
//                scrollToMessage();
            }
            else{
                $('#divRequisitionOrderDetailsList').empty();
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

function loadFromSearchReqPage(rtxn)
{   
    var selValue = $('#TYPEID' + rtxn).val();
    
    if(selValue==''){
        return;
    }
    var url=selValue.split('&')[0];
    var action=selValue.split('&')[1];
    
    var addData={ 'rid': rtxn};
    
    
    var dataString = JSON.stringify(addData);
   
    $.ajax({
           type: 'POST',
           url: url,
           contentType: 'application/json',
           data:dataString,
           dataType: 'json',
           success: function(result) {
               if(result.success){
                   if(action=='edit'){ 
                        lmsShowHideAddressResult('SearchRequisition');
                        $('#EditPurchase').empty().append(result.html);
                     } else  if(action=='view'){ 
                        lmsShowHideAddressResult('SearchRequisition');
                        $('#EditPurchase').empty().append(result.html);
                     }
                   else if(action=='cancel'){
                        lmsShowHideAddressResult('SearchRequisition');
                        $('#EditPurchase').empty().append(result.html);
                        $('#cancelpo').show();
                        $('#approveid').hide();
                    } 
           }
           else{
                 fnCmnWarningMessage(result.message);
               }
           },
           error: function() {
               fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
           }
       });
}

function loadEditReqPage(potxn)
{   
    var selValue = $('#TYPEID' + potxn).val();
    
    if(selValue==''){
        return;
    }
    var url=selValue.split('&')[0];
    var action=selValue.split('&')[1];
    
    var addData={ 'rid': potxn};
    
    startLoading();
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
               if (result.success) {
                if (action == 'edit') {

                    var id = result.jsonData;

                    lmsShowHideAddressResult('SearchPurchaseOrder');
                    $('#approvedetails').empty().append(result.html);
                } else if (action == 'stock')
                {
                    $('#approvedetails').empty().append(result.html);
                    $('#requisitionID').val(potxn);
                }
                else if (action == 'aprv') {
                    lmsShowHideAddressResult('SearchPurchaseOrder');
                    $('#approvedetails').empty().append(result.html);
                    $('#cancelpo').hide();
                } else
                {
                    lmsShowHideAddressResult('SearchPurchaseOrder');
                    $('#approvedetails').empty().append(result.html);
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



function SaveRequisitionDetails(url,elementObj)
{   
    $('.messageDiv').hide(); 
    var tbl = $(elementObj).closest('table');  
    
     $(".txt_quantity").each(function () 
     {  if($(this).val()<= 0)
           {
            var $message = 'Quantity is mandatory!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
           }
      });
    
     $(".ddlb_unit").each(function () 
     {  if($(this).val()<=0)
           {
            var $message = 'Please Select a Unit!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
           }
     });
     $(".purpose_list").each(function () 
     {  if($(this).val()<=0)
           {
            var $message = 'Please select a purpose!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
           }
     });
      $(".purpose_list").each(function () 
     {  if($(this).val()==1)
           {
                if ($('.purposecode').val().trim()=='')
            {
                var $message = 'Branch code is mandatory!';
                fnCmnWarningMessage($message);
                scrollToMessage();
                exit();
            }
           }
           if($(this).val()==2)
           {
                  if ($('.purposecode').val().trim()=='')
            {
                var $message = 'Project ID/Order No. is mandatory!';
                fnCmnWarningMessage($message);
                scrollToMessage();
                exit();
            }
           }
           if($(this).val()==3)
           {
                if ($('.purposecode').val().trim()=='')
            {
                var $message = 'Employee ID is mandatory!';
                fnCmnWarningMessage($message);
                scrollToMessage();
                exit();
            }
            
           }
     });
     
    if(document.getElementById('pkid').value == '0')
    {
        fnCmnWarningMessage('Please Select Category!');
        scrollToMessage();
        return false;
    }
    
     if(document.getElementById('selStkPrdList').value == '0')
    {
        fnCmnWarningMessage('Please Select Sub-Category and then Product!');
        scrollToMessage();
        return false;
    }
   
    if(tbl.find('input[name~="reqdate"]').val().trim()==''){
        fnCmnWarningMessage('Requisition date is mandatory!');
        scrollToMessage();
        return false;
        
    }
     
   
    if(tbl.find('textarea[name~="description"]').val().trim()==''){
        fnCmnWarningMessage('description is mandatory!');
        scrollToMessage();
        return false;
        
    }
    
    var formData = $('form#OrderDetails').serializeObject();
    var dataString = JSON.stringify(formData);
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
                $('#OrderDetails').empty().append(result.html)
                fnCmnSuccessMessage(result.message);
                $('#divOrderDetails').empty();
                scrollToMessage();
               }
                else
                {
                     $('.messageDiv').show(); 
                     fnCmnWarningMessage(result.message);
                     $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){
                fnCmnWarningMessage('An unknown technical error were encountered.');
                scrollToMessage();
                stopLoading();
            }
        });   
}

function UpdateRequisitionDetails(url,elementObj)
{   
   var poid={rid:$('#rid').val()};
   var eid={eid:$('#eid').val()};
   var tbl = $(elementObj).closest('table');  
  
   $('.messageDiv').hide(); 
   var tbl = $(elementObj).closest('table');  
    
     $(".txt_quantity").each(function () 
     {  if($(this).val()<= 0)
           {
            var $message = 'Quantity is mandatory!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
           }
      });
    
     $(".ddlb_unit").each(function () 
     {  if($(this).val()<=0)
           {
            var $message = 'Please Select a Unit!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
           }
     });
     $(".purpose_list").each(function () 
     {  if($(this).val()<=0)
           {
            var $message = 'Please select a purpose!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
           }
     });
      $(".purposecode").each(function () 
     {  if($(this).val()<=0)
           {
            var $message = 'Purpose code is mandatory!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
           }
     });
     
    
   
    if(tbl.find('input[name~="reqdate"]').val().trim()==''){
        fnCmnWarningMessage('Requisition date is mandatory!');
        scrollToMessage();
        return false;
        
    }
     
   
    if(tbl.find('textarea[name~="description"]').val().trim()==''){
        fnCmnWarningMessage('description is mandatory!');
        scrollToMessage();
        return false;
    }
    $('.messageDiv').hide(); 
    var formData = $('form#frmRequisitionDetails').serializeObject();
    var dataString = JSON.stringify($.extend(formData,poid,eid));
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
                stopLoading();
                $('#EditPurchase').empty();
                $('#divRequisitionOrderDetailsList').empty();
                $('#divRequisitionOrderDetailsList').empty().append(result.html);  
                paginationTbl();
                fnCmnSuccessMessage(result.message);
                scrollToMessage();
               }
                else
                {
                     $('.messageDiv').show();  scrollToMessage();                      
                     $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){ }
        });   
}

function ApproveRequisitionDetails(url)
{   if(confirm('Are you sure!'))
    {

    var rid={rid:$('#rid').val()};
    $('.messageDiv').hide(); 
    var formData = $('form#frmRequisitionDetails').serializeObject();
    var dataString = JSON.stringify($.extend(formData,rid));
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
                fnCmnSuccessMessage(result.message);
                $('#display-list').empty().append(result.html); 
                paginationTbl();
                $('#approvedetails').empty();
                scrollToMessage();
               }
                else
                {
                     $('.messageDiv').show();                       
                     $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){ 
            fnCmnWarningMessage('An unknown technical error were encountered.');
                scrollToMessage();
                stopLoading();
            }
        });   
    }
    else
    {
      return false;  
    }
}


function Closediv()
{   lmsShowHideAddressResult('SearchRequisition');
    $('#showHistory').empty();
}

function CancelRequisitionDetails(url,elementObj)
{   
    var rid={rid:$('#rid').val()};
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('textarea[name~="description"]').val().trim()==''){
        commonMessageAlert('Please Enter Remark!');
        scrollToMessage();
        return false;
        
    }
    
    $('.messageDiv').hide(); 
    var formData = $('form#frmRequisitionDetails').serializeObject();
    var dataString = JSON.stringify($.extend(formData,rid));
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
                $('#EditPurchase').empty();
                $('#divRequisitionOrderDetailsList').empty().append(result.html);  
                paginationTbl();
                fnCmnSuccessMessage(result.message);
                scrollToMessage();
               }
                else
                {
                     $('.messageDiv').show();                       
                     $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){
                fnCmnWarningMessage('An unknown technical error were encountered.');
                scrollToMessage();
                stopLoading();
            }
        });   
}


function Dispatch(url)
{   
    //var tbl = $(elementObj).closest('table');  
    if(document.getElementById('selectedEMp').value == ''){
        commonMessageAlert('Select Employee first!');
        scrollToMessage();
        return false;
        
    }
    $('.messageDiv').hide(); 
    var formData = $('form#frmRequisitionDetails').serializeObject();
    var dataString = JSON.stringify(formData);
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
                fnCmnSuccessMessage(result.message);
                scrollToMessage();
               }
                else
                {
                     $('.messageDiv').show();                       
                     $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){
                fnCmnWarningMessage('An unknown technical error were encountered.');
                scrollToMessage();
                stopLoading();
            }
        });   
}


function SearchRequisitionByReqNo(url,elementObj)
{   
    var tbl = $(elementObj).closest('table');  
   // if(tbl.find('input[name~="requisition"]').value == '')
    if(document.getElementById('requisition').value.trim() ==''){
        commonMessageAlert('Requisition no is mandatory!');
        scrollToMessage();
        return false;
    }
    $('.messageDiv').hide(); 
    var formData = $('form#frmRequisitionDetails').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function (result){ 
               if(result.success)
               {  
                
                $('#details').empty().append(result.html);
               }
                else
                {
                     $('.messageDiv').show();                       
                     $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){
                fnCmnWarningMessage('An unknown technical error were encountered.');
                scrollToMessage();
                stopLoading();
            }
        });   
}



function StockReturn(pkid)
{   
    var selValue = $('#TYPEID' + pkid).val();
    if(selValue==''){return;}
    var url=selValue.split('&')[0];
    var action=selValue.split('&')[1];
    
    if(action=='return')
        {
            $('.messageDiv').hide();
        if ($('#returnquantity' + pkid).val().trim() == '') {
            commonMessageAlert('Quantity is mandatory!');
            scrollToMessage();
            return false;
        } if ($('#ddlb_purpose' + pkid).val().trim() == '') {
            commonMessageAlert('Select purpose!');
            scrollToMessage();
            return false;
        }
        if ($('#remark' + pkid).val().trim() == '') {
            commonMessageAlert('Remarks is mandatory!');
            scrollToMessage();
            return false;
        }
        
       
        
        
        }
  
    var formData = $('form#RequisitionStockReturn').serializeObject();
    var dataString = JSON.stringify(formData);
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
                   if(action=='return'){ 
                        $('.messageDiv').show();  
                        fnCmnSuccessMessage(result.message);
                        scrollToMessage();
                     } 
                   else if(action=='view'){
                        lmsShowHideAddressResult('SearchRequisition');
                        $('#showHistory').empty().append(result.html); 
                    }
                }
                else
                {
                     $('.messageDiv').show();                       
                     $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                     $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
           },
            error: function(){ 
                fnCmnWarningMessage('An unknown technical error were encountered.');
                scrollToMessage();
                stopLoading();
            }
        });   
}

function addUpdateTransportMaster(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    var transportor_name = tbl.find('input[name~="transportor_name"]');
    if (transportor_name.val().trim()=='') {
        transportor_name.focus();
        commonMessageAlert('Purpose Name can not be empty!');
        return false;
    }
    else if (tbl.find('textarea[name~="transportor_des"]').val().trim()=='') {
        commonMessageAlert('Purpose Description can not be empty!');
        return false;
    }
    
//    var transportor_des = tbl.find('input[name~="transportor_des"]');
//    if (transportor_des.val().trim()=='') {
//        transportor_des.focus();
//        commonMessageAlert('Purpose Description can not be empty!');
//        return false;
//    }
    $('.messageDiv').hide();
    var formData = $('form#frmRequiTrans').serializeObject();
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
                $('#frmRequiTrans').trigger("reset");
                $('#btn_save').prop('value', 'Save');
                $('#btn_clear').hide();
                $('#btn_cancel').show();
            }
            else {
                fnCmnErrorMessage(result.message);
            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}


function retrieveRequisitionTransport(url)
{
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#transportor_name').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.transportor_name);
                $('#transportor_des').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.transportor_des);
                $('#transportorId').val(result.jsonData.transportorId);
                //$('#jobTitleUpdateURL').val('/Tashi/web/app_dev.php/location/update_country/' + result.jsonData.cid);
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


function deleteTransportModule(url, subModuleName, formId)
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


function CloseEditsection()
{   lmsShowHideAddressResult('SearchRequisition');
    $('#EditPurchase').empty();
}
