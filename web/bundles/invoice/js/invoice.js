//for hide show table 
function SearchInvProjects(url){
    $('.messageDiv').hide();
    if($('#txtcustid').val().trim()==''){
        fnCmnWarningMessage('Enter Customer ID or Name.!!!');  
        $('#txtcustid').focus();
        scrollToMessage();
        return;
    }
    startLoading();
    var frmData=$('form#FormCreateInvoice').serializeObject();
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
                $('#divInvProjectList').empty().append(result.html); 
                stopLoading();
                paginationTbl();
           }
           else{
            $('#divInvDetail').empty().empty();
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
function NewInvoiceAction(selid){
    $('.messageDiv').hide();
    var url=$('#'+selid).val();
    if(url==''){
        return;
    }
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
               $('#divInvDetail').empty().append(result.html); 
                paginationTbl2();
               $('#divinvitemlist').empty().append(result.secondHtml);
               stopLoading();
               lmsShowHideAddressResult('projlist');
               document.getElementById('tbCreateInvoice').scrollIntoView();
           }
           else{
               $('#divInvDetail').empty();
               $('#tdinvitemlist').empty();
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
function cancelInvoice(){
    $('.messageDiv').hide();
    if(!confirm('Are you sure you want to cancel the current process?')){
        return;
    }
    $('#divInvDetail').empty();
}
function togglInvItemSelection(mainchkid,chkbox,childChkName,inputName){
    var mainChkbox=document.getElementById(mainchkid);
    var childCheck=document.getElementsByName(childChkName);
    var inpItemChk=document.getElementsByName(inputName);
    var isAllChecked=true;
    for(var i=0;i<childCheck.length;i++){
        if(mainChkbox==chkbox){
            childCheck[i].checked=mainChkbox.checked;
        }
        else{
            if(!childCheck[i].checked){
                isAllChecked=false;
                break;
                inpItemChk[i].value='0';
            }else{
                inpItemChk[i].value='1';
            }
        }
    }
    if(mainChkbox!=chkbox){
        mainChkbox.checked=isAllChecked;
    }
    for(var i=0;i<childCheck.length;i++){
        if(!childCheck[i].checked){
                inpItemChk[i].value='';
            }else{
                inpItemChk[i].value='1';
            }
    }
    CalculateTotal();
}
function CalculateInvItemTotal(groupid){
    var qty=document.getElementById('txtQty'+groupid).value;
   // var charge=document.getElementById('txtCharge'+groupid).value;
    var taxpc=document.getElementById('txtTaxpc'+groupid).value;
    var markup=document.getElementById('txtmPrice'+groupid).value;
    var unitprice=document.getElementById('txtuprice'+groupid).value;
    var txtTaxAmt=document.getElementById('txtTaxamt'+groupid);
    var txtItemTotal=document.getElementById('txtitemTotal'+groupid);
    var price=0;
    if(taxpc==''||isNaN(taxpc)){
        taxpc=0;
    }
    if(markup==''||isNaN(markup)){
        price=unitprice;
    }
    else if(parseFloat(markup)<=0){
        price=unitprice;       
    }
    else{
        price=markup;        
    }
    taxpc=parseFloat(taxpc);
    var totWtoutTax = qty*price;
    var taxAmt=totWtoutTax *(parseFloat(taxpc)/100);
    txtTaxAmt.value=floorFigure(taxAmt,2);
    txtItemTotal.value=floorFigure(totWtoutTax,2);
    CalculateTotal();
}
function ConvertTaxPctoAmt(groupid){
    //var qty=document.getElementById('txtQty'+groupid).value;
    //var charge=document.getElementById('txtCharge'+groupid).value;
    var taxpc=document.getElementById('txtTaxpc'+groupid).value;
    //var markup=document.getElementById('txtmPrice'+groupid).value;
    //var unitprice=document.getElementById('txtuprice'+groupid).value;
    var txtTaxAmt=document.getElementById('txtTaxamt'+groupid);
    var txtItemTotal=document.getElementById('txtitemTotal'+groupid);
//    var price=0;
    if(taxpc==''||isNaN(taxpc)){
        taxpc=0;
    }
//    if(markup==''||isNaN(markup)){
//        price=unitprice;
//    }
//    else if(parseFloat(markup)<=0){
//        price=unitprice;       
//    }
//    else{
//        price=markup;        
//    }
    taxpc=parseFloat(taxpc);
    var totWtoutTax = parseFloat(txtItemTotal.value); 
    var taxAmt=totWtoutTax*(taxpc/100);
    txtTaxAmt.value=floorFigure(taxAmt,2); 
    //txtItemTotal.value=floorFigure(totWtoutTax+taxAmt,2);
    CalculateTotal();
}
function TaxAmountChange(groupid){
    //var qty=document.getElementById('txtQty'+groupid).value;
    //var charge=document.getElementById('txtCharge'+groupid).value;
    var txtTaxpc=document.getElementById('txtTaxpc'+groupid);
    //var markup=document.getElementById('txtmPrice'+groupid).value;
    //var unitprice=document.getElementById('txtuprice'+groupid).value;
    var taxAmt=document.getElementById('txtTaxamt'+groupid).value;
    var txtItemTotal=document.getElementById('txtitemTotal'+groupid);
    //var txtItemTotal=document.getElementById('txtitemTotal'+groupid);
//    var price=0;
    if(taxAmt==''||isNaN(taxAmt)){
        taxAmt=0;
    }
//    if(markup==''||isNaN(markup)){
//        price=unitprice;
//    }
//    else if(parseFloat(markup)<=0){
//        price=unitprice;       
//    }
//    else{
//        price=markup;        
//    }
    taxAmt=parseFloat(taxAmt);
    //var totWtoutTax = qty*price; 
    var totWtoutTax = parseFloat(txtItemTotal.value);
    //txtItemTotal.value=floorFigure(taxAmt+totWtoutTax,2);    
    txtTaxpc.value=floorFigure(taxAmt/(totWtoutTax/100),2);
    //txtItemTotal.value=floorFigure(totWithTax,2);    
    CalculateTotal();
}
function CalculateTotal(){
    var chkboxes=document.getElementsByName('chkinclude');
    var txtTaxAmts=document.getElementsByName('txtTaxamt');
    var txtItemTotals=document.getElementsByName('txtitemTotal');
    var txtSubTotal=document.getElementById('txtSubtotal');
    var txtTaxTotal=document.getElementById('txtTaxtotal');
    var discount=document.getElementById('txtDiscount').value;
    var txtGrandTotal=document.getElementById('txtGrandTotal');
    var deposit=document.getElementById('txtDeposit').value;
    var txtBalance=document.getElementById('txtBalance');    
    var subtotal=0,taxtotal=0;
    var checkFlag=0;
    for(var i=0;i<chkboxes.length;i++){
        if(chkboxes[i].checked){
            checkFlag=1;
            var itemtotal= txtItemTotals[i].value;
            var taxamt=txtTaxAmts[i].value;
            if(itemtotal=='' || isNaN(itemtotal)){
                itemtotal=0;
            }
            subtotal+=parseFloat(itemtotal);
            if(taxamt==''||isNaN(taxamt)){
                taxamt=0;
            }
            taxtotal+=parseFloat(taxamt);
        }
    }
    if(checkFlag){
        if(discount==''||isNaN(discount)){
            discount=0;
        }
        if(deposit==''||isNaN(deposit)){
            deposit=0;
        }
        //var totDeduction=;
        var totAddition=subtotal+taxtotal;
        var grandTotal=totAddition-parseFloat(discount);
        var balance=totAddition-parseFloat(discount)-parseFloat(deposit);
        
        txtSubTotal.value=floorFigure(subtotal,2);
        txtTaxTotal.value=floorFigure(taxtotal,2);
        if(grandTotal<0){
            grandTotal=0;
        }
        if(balance<0){
            balance=0;
        }
        txtGrandTotal.value= floorFigure(grandTotal,2);
        txtBalance.value= floorFigure(balance,2);
    }
    else{
        txtSubTotal.value='0.00';
        txtTaxTotal.value='0.00';
        txtGrandTotal.value='0.00';
        txtBalance.value='0.00';
    }
}
function CreateInvoice(url,frmid,mode){
    $('.messageDiv').hide();
    if($('#selBillAddress').val().trim()==''){
        fnCmnWarningMessage('Select Billing Address.!!!');  
        $('#selBillAddress').focus();
        scrollToMessage();
        return;
    }
    if($('#txtInvDate').val().trim()==''){
        fnCmnWarningMessage('Select Invoice Date.!!!');  
        $('#txtInvDate').focus();
        scrollToMessage();
        return;
    }
    var payCheck=document.getElementsByName('chkboxPay');
    var checkFlag=0;
    for(var i=0;i<payCheck.length;i++){
        if(payCheck[i].checked){
            checkFlag=1;  
            break;
        }
    }
    if(checkFlag==0){
        fnCmnWarningMessage('Select atleast one payment term.!!!');  
        scrollToMessage();
        return;
    }
    var itemChk=document.getElementsByName('chkinclude');
    var itemFlag=0;
    for(var i=0;i<itemChk.length;i++){
        if(itemChk[i].checked){
            itemFlag=1;
            break;
        }
    }
    if(itemFlag==0){
        fnCmnWarningMessage('You have not selected any item.!!!');  
        scrollToMessage();
        return;
    }
    if(mode=='EDT'){
        if(!confirm('Confirm Update?')){
            return;
        }
    }
    startLoading();
    var frmData=$('form#'+frmid).serializeObject();
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
              var msg=result.message;
            if(mode=='EDT'){ 
                SearchInvoice();
                fnCmnSuccessMessage(msg);
                scrollToMessage();
            }else{
                $('#divInvDetail').empty().append(result.html);                  
                $('#divinvitemlist').empty();
                $('#divinvoiceArea').append(result.secondHtml);
            }
            stopLoading();
           }
           else{
               $('#divInvDetail').empty();
               $('#tdinvitemlist').empty();
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
function  InvoiceAction(invoiceid,appenddiv,ref){
    $('.messageDiv').hide();
    if($('#selInvoiceAction'+invoiceid).val().trim()==''){
        return;
    }
    var rawurl=$('#selInvoiceAction'+invoiceid).val();
    var url=rawurl.split('&')[0];
    var action=rawurl.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected invoice?')){
            return;
        }
    }
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
              var msg=result.message;
                if(action=='view' || action=='approve'||action=='payment'){
                    $('#'+appenddiv).empty().append(result.html); 
                    lmsShowHideAddressResult('invoicelist');
                    document.getElementById(appenddiv).scrollIntoView();
                    stopLoading();
                }else if(action=='print'){
                    $('#'+appenddiv).empty().append(result.html); 
                    $('#divPrint').append(result.secondHtml);
                    lmsShowHideAddressResult('invoicelist');
                    document.getElementById(appenddiv).scrollIntoView();
                    stopLoading();
                }
                else if(action=='del'&& ref=='CREATE'){
                    $('#divInvDetail').empty().append(result.html); 
                    document.getElementById('divInvDetail').scrollIntoView();
                    fnCmnSuccessMessage(result.message);
                    scrollToMessage();
                    paginationTbl2();
                    stopLoading();
                }
                else if(action=='del'&& ref=='SEARCH'){ //if delete is from search page then search result as per selected search criteria
                    SearchInvoice();
                    fnCmnSuccessMessage(msg);
                    scrollToMessage(); 
                    stopLoading();
                }
                else if(action=='edit'){ //if delete is from search page then search result as per selected search criteria
                    $('#'+appenddiv).empty().append(result.html); 
                    $('#divinvitemlist').empty().append(result.secondHtml);
                    lmsShowHideAddressResult('invoicelist');
                    document.getElementById(appenddiv).scrollIntoView();
                    stopLoading();
                }
           }
           else{
               $('#'+appenddiv).empty();
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
function ApproveInvoice(url){
    $('.messageDiv').hide();
    if(!confirm('Confirm Approval?')){
        return;
    }    
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
                $('.application-form').empty().append(result.html); 
                fnCmnSuccessMessage(result.message);
                scrollToMessage();                
                stopLoading();
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
function CancelInvoiceApproval(){
    $('.messageDiv').hide();
    if(!confirm('Are you sure you want to cancel the current action?')){
        return;
    }
    $('#divInvoicedetail').empty();
    lmsShowHideAddressResult('invoicelist');
    document.getElementById('applicationform').scrollIntoView();
}
function toggleSearchInvCriteria(selid){
    var sel=document.getElementById(selid);
    $('#trcriteria').show();
    $('#txtCriteria').val('');
    $('#selInvStatus').hide();
    $('#txtCriteria').hide();
    $('#divDate').hide();
    //$('#tbodyDynamic').empty();
     $('#tdtitle').text('Criteria');
    switch(sel.value){
        case 'all':           
            $('#trcriteria').hide();
            break;
        case 'invno':
            document.getElementById('txtCriteria').placeholder='Enter Invoice Number';
            $('#txtCriteria').show();
            break;
        case 'ordno':
            document.getElementById('txtCriteria').placeholder='Enter Project ID/Order Number';
            $('#txtCriteria').show();
            break;
        case 'cname':
            document.getElementById('txtCriteria').placeholder='Enter Customer Name/ID';
            $('#txtCriteria').show();
            break;    
        case 'date':
            $('#divDate').show();
            break; 
        case 'status':
            $('#selInvStatus').show();
            break;
        default:
            $('#tdtitle').empty();            
            break;
    }
}    
    function SearchInvoice(){
    $('.messageDiv').hide();
    switch($('#selSearchInvCriteria').val()){  
        case 'invno':
            if($('#txtCriteria').val().trim()==''){
                fnCmnWarningMessage('Enter Invoice Number!!!');
                $('#txtCriteria').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'ordno':
            if($('#txtCriteria').val().trim()==''){
                fnCmnWarningMessage('Enter Project ID/Order Number!!!');
                $('#txtCriteria').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'cname':
            if($('#txtCriteria').val().trim()==''){
                fnCmnWarningMessage('Enter Customer Name/ID!!!');
                $('#txtCriteria').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'date':
            if($('#txtinvdate').val().trim()==''){
                fnCmnWarningMessage('Select Invoice Date!!!');
                $('#txtinvdate').focus();
                scrollToMessage();
                return;
            }            
            break;
        case 'status':
            if($('#selInvStatus').val().trim()==''){
                fnCmnWarningMessage('Select Invoice Approval Status!!!');
                $('#selInvStatus').focus();
                scrollToMessage();
                return;
            }
            break;
    }
    startLoading();
    var url=$('#inputsearchinvoiveUrl').val();
    var frmData=$('form#frmSearchInvoice').serializeObject();
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
                $('#divInvoiceList').empty().append(result.html);  
                paginationTbl();
            }
            else{
                $('#divInvoiceList').empty();
                
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

