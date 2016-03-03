function SearchProjectCustomer(url){
    $('.messageDiv').hide();
    if($('#txtSearchCust').val().trim()==''){
        fnCmnWarningMessage('Enter Customer ID or Name');
        $('#txtSearchCust').focus();
        scrollToMessage();
        return;
    }     
    startLoading();
    var frmData=$('form#NewProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.success){
                $('#divCustList').empty().append(result.html);
                stopLoading();
                paginationTbl();                
            }
            else{
                $('#divCustList').empty();
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();              
            }
        },
        error:function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function SearchCustOnEnter(event,url){
    $('.messageDiv').hide();
    if (event.which == 13) {        
        SearchProjectCustomer(url);
        return false; //to stop page refresh
    }
}
function stepper(txt,currStep){
    $('p#step_p').text('Step '+currStep+': '+txt);
    for(var i=1;i<=6;i++){
            $('div#divStep'+i).hide();
        }
    $('div#divStep'+currStep).show();
}
function projectStep2(custid,url){
    $('.messageDiv').hide();
    if($('#selCustAdd'+custid).val().trim()==''){
        fnCmnWarningMessage('You must select an Address');
        $('#selCustAdd'+custid).focus();
        scrollToMessage();
        return;
    }
    if($('#selCustCont'+custid).val().trim()==''){
        fnCmnWarningMessage('You must select an Contact');
        $('#selCustCont'+custid).focus();
        scrollToMessage();
        return;
    }
    startLoading();
    $('#custId').val(custid);
    $('#addressId').val($('#selCustAdd'+custid).val());
    $('#contactId').val($('#selCustCont'+custid).val());
    var frmData=$('Form#NewProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data:dataString,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                $('#divStep2').empty().append(result.html);
                stepper('Enter Project Detail','2');
                stopLoading();                    
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();              
            }
        },
        error:function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function CreateProjectAndProceedToStep3(url){
    $('.messageDiv').hide();
    if($('#selProjArea').val().trim()==''){
        fnCmnWarningMessage('Select Project Area!!!');
        $('#selProjArea').focus();
        scrollToMessage();
        return;
    }
    if($('#selIndType').val().trim()==''){
        fnCmnWarningMessage('Select Industry Type!!!');
        $('#selIndType').focus();
        scrollToMessage();
        return;
    }
    if($('#selCoordinator').val().trim()==''){
        fnCmnWarningMessage('Select Site Coordinator!!!');
        $('#selCoordinator').focus();
        scrollToMessage();
        return;
    } 
    if($('#txtdimension').val().trim()==''){
        fnCmnWarningMessage('Enter Project Dimension!!!');
        $('#txtdimension').focus();
        scrollToMessage();
        return;
    }
    if($('#selProjectStatus').val().trim()==''){
        fnCmnWarningMessage('Select Project Status!!!');
        $('#selProjectStatus').focus();
        scrollToMessage();
        return;
    }
    if($('#txtStartDate').val().trim()==''){
        fnCmnWarningMessage('Select Project Execution Date!!!');
        $('#txtStartDate').focus();
        scrollToMessage();
        return;
    }
    if($('#txtCompleteDate').val().trim()==''){
        fnCmnWarningMessage('Select Tentative Completion Date!!!');
        $('#txtCompleteDate').focus();
        scrollToMessage();
        return;
    }   
    var sdate= new Date($('#txtStartDate').val());
    var cdate= new Date($('#txtCompleteDate').val());
    if(sdate>cdate){
        fnCmnWarningMessage('Start Date cannot be greater than Completion Date!!!');
        $('#txtCompleteDate').focus();
        scrollToMessage();
        return;
    }
    if($("select[name='userlist'] option:selected").length<=0){
        if(!confirm('Are you sure you want to proceed without notification to anyone? It is recommended to notify to the related employees.')){
            return;
        }
    }    
    startLoading();
    var frmData=$('form#NewProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type:'post',
        url:url,
        data:dataString,
        contentType:'application/json',
        dataType:'json',
        success:function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                $('#divStep3').empty().append(result.html);
                stepper('Add Project Items & Services','3');
                stopLoading();
            }else{
                fnCmnWarningMessage(result.message);
                scrollToMessage();
                stopLoading();
            }
        },
        error:function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function LoadProjItems(){
    $('.messageDiv').hide();
    if($('#selProjectCat').val().trim()==''){
        fnCmnWarningMessage('Select a Category First');
        $('#selProjectCat').focus();
        scrollToMessage();
        return;
    }    
    var url=$('#selProjectCat').val().split('&')[0];
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                $('#divItemList').empty().append(result.html);
                stopLoading();                    
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();              
            }
        },
        error:function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function LoadItemsForAddNewItem(url){
    $('.messageDiv').hide();    
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                $('#divItemDetail').empty().append(result.html);
                stopLoading();                    
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();              
            }
        },
        error:function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function toggleProducts(span,ulid){
    if($(span).attr('class')=='span_close'){
        $('#'+ulid).show();
        $(span).removeClass('span_close');
        $(span).addClass('span_open');
    }
    else{
        $('#'+ulid).hide();
        $(span).removeClass('span_open');
        $(span).addClass('span_close');
    }
}
function toggleItemSelection(catid,chkbox){
    //var mainCheck=document.getElementById('mainChk'+catid);    
    var childChecks=document.getElementsByClassName('chkboxes'+catid);
    var inputisSelected=document.getElementsByClassName('isitemselectedinput'+catid);    
//    if(mainCheck==chkbox){
//        for(var i=0;i<childChecks.length;i++){
//            childChecks[i].checked=mainCheck.checked;
//            if(mainCheck.checked){
//                inputisSelected[i].value='1';
//            }else{
//                inputisSelected[i].value='0';
//            }
//        }
//    }
//    else{
//        var allCheck=true;
       for(var i=0;i<childChecks.length;i++){
           if(childChecks[i].checked){
               inputisSelected[i].value='1';
           }
           else{
//               allCheck=false;
               inputisSelected[i].value='0';
           }
       }
//       mainCheck.checked=allCheck;       
//    }
    CalculateEstimatedCost(catid);
}
function toggleServiceChk(catid,prodid,chkbox){
    var chkboxsrv=document.getElementsByClassName('chkSrv'+prodid);
    var inputisselected=document.getElementsByClassName('issrvselected'+prodid);
    for(var i=0;i<chkboxsrv.length;i++){
        if(chkbox.checked){        
            chkboxsrv[i].disabled=false;            
        }else{
            chkboxsrv[i].disabled=true;
            chkboxsrv[i].checked=false;
            inputisselected[i].value=0;
        }
    }
    CalculateEstimatedCost(catid);
}
function CalculateEstimatedCost(catid){
    var checkItem=document.getElementsByClassName('chkboxes'+catid);
    var txtquantity=document.getElementsByClassName('quantity'+catid);
    var inputPrice=document.getElementsByClassName('price'+catid);
    var txtSubTotal=document.getElementsByClassName('subtotal'+catid);
   // var txtCharge=document.getElementsByClassName('charge'+catid);
    //var txtTotPrice=document.getElementById('txtTotalPrice'+catid);   
    //var txtTotCharge=document.getElementById('txtTotalCharge'+catid); 
    var txtCatSubTotal=document.getElementById('txtCatSubTotal'+catid); 
    //var txtGrandPrice=document.getElementById('txtGrandPrice');
   // var txtGrandCharge=document.getElementById('txtGrandCharge'); 
    var txtBudget=document.getElementById('txtTotBudget');
    var totPrice=0;
    //var totCharge=0;
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            var price=inputPrice[i].value;
            if(price=='' || isNaN(price)){
                price=0;
            }
            var qty=txtquantity[i].value;
            //var charge=txtCharge[i].value;
            if(qty!='' && !isNaN(qty)){
                txtSubTotal[i].value=floorFigure(parseFloat(price)*parseInt(qty));
                totPrice+=parseFloat(price)*parseInt(qty);
            }else{
                txtSubTotal[i].value='0.00';
            }
//            if(charge!='' && !isNaN(charge)){
//               totCharge+=parseFloat(charge); 
//            }
        }else{
            txtSubTotal[i].value='0.00';
        }
    }
    //txtTotPrice.value= floorFigure(totPrice); //for formatting upto 2 decimal points
    txtCatSubTotal.value= floorFigure(totPrice);
    //txtTotCharge.value= (Math.floor(100 * totCharge) / 100).toFixed(2);
    var catwisetotal=document.getElementsByClassName('catsubtotal');
   // var txttotalCharges=document.getElementsByClassName('totalcharge');
    var pTotal=0;
    for(var i=0;i<catwisetotal.length;i++){
        var price=catwisetotal[i].value;
        //var charge=txttotalCharges[i].value;
        pTotal+=parseFloat(price);
        //cTotal+=parseFloat(charge);
    }
    //txtGrandPrice.value=(Math.floor(100 * pTotal) / 100).toFixed(2);
    //txtGrandCharge.value=(Math.floor(100 * cTotal) / 100).toFixed(2);
    //txtBudget.value=(Math.floor(100 * (pTotal+cTotal)) / 100).toFixed(2);
    txtBudget.value=floorFigure(pTotal);
}

function projectStep3(url){ //project detail
    $('.messageDiv').hide();
    if($('#selCoordinator').val().trim()==''){
        fnCmnWarningMessage('Select site coordinator');
        $('#selCoordinator').focus();
        scrollToMessage();
        return;
    }
    var checkItem=document.getElementsByName('itemchkbox');
    var txtQty=document.getElementsByName('txtQuantity');
    
    var isSelected=false;
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            isSelected=true;
            break;
        }
    }
    if(!isSelected){
        fnCmnWarningMessage('You have not selected any item(s).');
        scrollToMessage();
        return;
    }   
    var selUnit=document.getElementsByName('selItemUnits');
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            var qty=txtQty[i].value;
            if(selUnit[i].value==''){
                fnCmnWarningMessage('You have not selected Unit of one or more item(s).');
                scrollToMessage();
                selUnit[i].focus();
                return; 
            }
        }
    }
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            var qty=txtQty[i].value;
            if(qty==''||isNaN(qty)){
                fnCmnWarningMessage('You have not provided quantity of one or more selected item(s).');
                scrollToMessage();
                txtQty[i].focus();
                return; 
            }
            if(parseFloat(qty)<=0){
                fnCmnWarningMessage('You have not provided quantity of one or more selected item(s).');
                scrollToMessage();
                txtQty[i].focus();
                return; 
            }
        }
    }
    var txtCharges=document.getElementsByName('txtCharge');
    var chargesFlag=0;
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            var amt=txtCharges[i].value;
            if(amt.trim()==''||isNaN(amt)){
                chargesFlag=1;  
                txtCharges[i].focus();
            }
            if(parseFloat(amt)<=0){
                chargesFlag=1;
                txtCharges[i].focus();
            }
        }
    }    
    if(chargesFlag==1){
        if(!confirm('You have not provided the charge of one or more selected Item(s).Is this okay?')){
            return;
        }
    }
    startLoading();
    var frmData=$('form#NewProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                $('#divStep3').empty().append(result.html);
                stepper('Enter Project Detail','3');
                $('#divAdvPay').children().prop('disabled',true);
                stopLoading();                    
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();              
            }
        },
        error:function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function AddProjectItemService(url,from){
    $('.messageDiv').hide();
    var checkItem=document.getElementsByName('itemchkbox');
    var txtQty=document.getElementsByName('txtQuantity');
    
    var isSelected=false;
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            isSelected=true;
            break;
        }
    }
    if(!isSelected){
        fnCmnWarningMessage('You have not selected any item(s).');
        scrollToMessage();
        return;
    }   
    var selUnit=document.getElementsByName('selItemUnits');
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            var qty=txtQty[i].value;
            if(selUnit[i].value==''){
                fnCmnWarningMessage('You have not selected Unit of one or more item(s).');
                scrollToMessage();
                selUnit[i].focus();
                return; 
            }
        }
    }
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            var qty=txtQty[i].value;
            if(qty==''||isNaN(qty)){
                fnCmnWarningMessage('You have not provided quantity of one or more selected item/service.');
                scrollToMessage();
                txtQty[i].focus();
                return; 
            }
            if(parseFloat(qty)<=0){
                fnCmnWarningMessage('You have not provided quantity of one or more selected item/service.');
                scrollToMessage();
                txtQty[i].focus();
                return; 
            }
        }
    } 
    var txtserviceIsSelected=document.getElementsByName('txtserviceIsSelected');
    var txtserviceqty=document.getElementsByName('txtserviceqty');
    var txtservicecharge=document.getElementsByName('txtserviceprice');
    for(i=0;i<txtserviceIsSelected.length;i++){
        if(txtserviceIsSelected[i].value=='1'){
            var qty=txtserviceqty[i].value;
            var price=txtservicecharge[i].value;
            if(qty==''||isNaN(qty) || qty=='0'){
                fnCmnWarningMessage('You have not entered Quantity of one or more services(s).');
                scrollToMessage();
                txtserviceqty[i].focus();
                return;
            }
            if(price=''||isNaN(price)){
                fnCmnWarningMessage('You have not entered Charge of one or more services(s).');
                scrollToMessage();
                txtservicecharge[i].focus();
                return;
            }
        }
    }
    startLoading();
    if(from=='createproject'){
        var frmData=$('form#NewProjectForm').serializeObject();
    }else{
        var frmData=$('form#ProjectForm').serializeObject();
    }
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                if(from=='createproject'){
                    $('#divnewProj').empty().append(result.html);
                }else{
                    $('#divProjDetail').empty().append(result.html);
                    fnCmnSuccessMessage(result.message);
                    scrollToMessage();
                }
                stopLoading();                    
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();              
            }
        },
        error:function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function AddProjectNewItem(url){ //project detail
    $('.messageDiv').hide();
    var checkItem=document.getElementsByName('itemchkbox');
    var txtQty=document.getElementsByName('txtQuantity');
    
    var isSelected=false;
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            isSelected=true;
            break;
        }
    }
    if(!isSelected){
        fnCmnWarningMessage('You have not selected any item(s).');
        scrollToMessage();
        return;
    }   
    var selUnit=document.getElementsByName('selItemUnits');
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            var qty=txtQty[i].value;
            if(selUnit[i].value==''){
                fnCmnWarningMessage('You have not selected Unit of one or more item(s).');
                scrollToMessage();
                selUnit[i].focus();
                return; 
            }
        }
    }
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            var qty=txtQty[i].value;
            if(qty==''||isNaN(qty)){
                fnCmnWarningMessage('You have not provided quantity of one or more selected item(s).');
                scrollToMessage();
                txtQty[i].focus();
                return; 
            }
            if(parseFloat(qty)<=0){
                fnCmnWarningMessage('You have not provided quantity of one or more selected item(s).');
                scrollToMessage();
                txtQty[i].focus();
                return; 
            }
        }
    }
    var txtCharges=document.getElementsByName('txtCharge');
    var chargesFlag=0;
    for(var i=0;i<checkItem.length;i++){
        if(checkItem[i].checked){
            var amt=txtCharges[i].value;
            if(amt.trim()==''||isNaN(amt)){
                chargesFlag=1;  
                txtCharges[i].focus();
            }
            if(parseFloat(amt)<=0){
                chargesFlag=1;
                txtCharges[i].focus();
            }
        }
    }    
    if(chargesFlag==1){
        if(!confirm('You have not provided the charge of one or more selected Item(s).Is this okay?')){
            return;
        }
    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                $('#divProjDetail').empty().append(result.html);
                $('#divItemDetail').empty();
                fnCmnSuccessMessage(result.message);
                stopLoading();                    
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();              
            }
        },
        error:function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

function projectStep4(url){ //Project Detail
    $('.messageDiv').hide();
    if($('#selProjectStatus').val().trim()==''){
        fnCmnWarningMessage('Select Project Status!!!');
        $('#selProjectStatus').focus();
        scrollToMessage();
        return;
    }
    if($('#txtStartDate').val().trim()==''){
        fnCmnWarningMessage('Select Project Start Date!!!');
        $('#txtStartDate').focus();
        scrollToMessage();
        return;
    }
    if($('#txtCompleteDate').val().trim()==''){
        fnCmnWarningMessage('Select Tentative Completion Date!!!');
        $('#txtCompleteDate').focus();
        scrollToMessage();
        return;
    }   
    var sdate= new Date($('#txtStartDate').val());
    var cdate= new Date($('#txtCompleteDate').val());
    if(sdate>cdate){
        fnCmnWarningMessage('Start Date cannot be greater than Completion Date!!!');
        $('#txtCompleteDate').focus();
        scrollToMessage();
        return;
    }
    startLoading();
    var frmData=$('form#NewProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data:dataString, 
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                $('#divStep4').empty().append(result.html);
                stepper('Enter Advance Payment Detail','4');
                $('#divAdvPay').children().prop('disabled',true);
                stopLoading();                    
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();              
            }
        },
        error:function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function payModeChange(selectbox){
    var ispayreqd=selectbox.value.split('&')[1];
    if(ispayreqd==1){
        $('#txtTranNo').attr('disabled',false);
        $('#txtBankName').attr('disabled',false);
    }else if(ispayreqd==0){
        $('#txtTranNo').attr('disabled',true);
        $('#txtTranNo').val('');
        $('#txtBankName').attr('disabled',true);
        $('#txtBankName').val('');
    }
}
function toggleAdvancePay(radio){
    $('.messageDiv').hide();
    document.getElementById('inputIsAdvPaid').value=radio.value;
    if(radio.value==1){
        $("#divAdvPay").find("input,select,textarea").prop("disabled",false);       
        var ispayreqd=$('#selpayMode').val();
        if(ispayreqd==''){
            ispayreqd=0;
        }else{
            ispayreqd=ispayreqd.split('&')[1];
        }
        if(ispayreqd==1){
            $('#txtTranNo').attr('disabled',false);
            $('#txtBankName').attr('disabled',false);
        }else{
            $('#txtTranNo').attr('disabled',true);
            $('#txtBankName').attr('disabled',true);
        }
    }else{
        $("#divAdvPay").find("input,select,textarea,button").prop("disabled",true);
         $("#divAdvPay").find("input,select,textarea").val('');
        $('#txtAmount').val('0.00');
        $('#txtreAmount').val('0.00');
    }
}
function projectStep5(url){
    $('.messageDiv').hide();
    if($('#inputIsAdvPaid').val().trim()=='1'){
        if($('#selpayMode').val().trim()==''){
            fnCmnWarningMessage('Select Payment Mode!!!');
            $('#selpayMode').focus();
            scrollToMessage();
            return;
        }
        if($('#txtPayDate').val().trim()==''){
            fnCmnWarningMessage('Select Date of Payment!!!');
            $('#txtPayDate').focus();
            scrollToMessage();
            return;
        }
        if($('#txtAmount').val().trim()==''){
            fnCmnWarningMessage('Enter Received Amount!!!');
            $('#txtAmount').focus();
            scrollToMessage();
            return;
        }        
        if(parseFloat($('#txtAmount').val())<=0){
            fnCmnWarningMessage('Enter a valid Amount!!!');
            $('#txtAmount').focus();
            scrollToMessage();
            return;
        }
        if($('#txtreAmount').val().trim()==''){
            fnCmnWarningMessage('Re-enter Received Amount!!!');
            $('#txtreAmount').focus();
            scrollToMessage();
            return;
        }
        if(parseFloat($('#txtAmount').val())!=parseFloat($('#txtreAmount').val())){
            fnCmnWarningMessage('Received Amount Mismatched!!!');
            $('#txtreAmount').focus();
            scrollToMessage();
            return;
        }
        if($('#txtalertpc').val().trim()!=''){
            if(parseFloat($('#txtalertpc').val())>100){
                fnCmnWarningMessage('Consumption limit cannot be greater than 100%!!!');
                $('#txtalertpc').focus();
                scrollToMessage();
                return;
            }
        }
    }else{
        if(!confirm('Proceed without Advance Payment?')){
            return;
        }
    }
    startLoading();
    var frmData=$('form#NewProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){                 
                $('#divStep5').empty().append(result.html);
                stepper('Review Project Detail & Confirm','5');  
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();              
            }
        },
        error:function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function CreateProject(url){
    $('.messageDiv').hide();
    if(!confirm('Create Project?')){
        return;
    }
    startLoading();
    var frmData=$('form#NewProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){                 
                $('#divStep6').empty().append(result.html);
                stepper('Successfull','6');  
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();              
            }
        },
        error:function(){
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}
function ProjectNavigation(menuid,url){
    $('.messageDiv').hide(); 
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
            if(result.success){ 
                stopLoading();
                $('#divProjDetail').empty().append(result.html);  
                $('ul#tabs li').removeClass('active');
                $('#'+menuid).addClass('active');           
               // paginationTbl2();    
                document.getElementById('divTabs').scrollIntoView();
            }
           else{
               stopLoading();
               fnCmnWarningMessage(result.message);
               scrollToMessage();
           }
      },
       error: function(){ 
           fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
           stopLoading();
           scrollToMessage();
       }
    });
}

function GotoProjectDetailIndex(url,appendDiv){
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
                $('#'+appendDiv).empty().append(result.html);
                $('#divProjDetail').empty().append(result.secondHtml);                 
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
        }
    });
}
function GotoAddItemDetail(url){
    $('.messageDiv').hide();
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
                stopLoading();                
                $('#divItemDetail').empty().append(result.html); 
                lmsShowHideAddressResult('ItemList');
                document.getElementById('divItemDetail').scrollIntoView();                
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
function CalculateItemTotal(txtqty,txtcharge,txtprice,txtTotal){
    var qty=document.getElementById(txtqty).value;
    //var charge=document.getElementById(txtcharge).value;
    var price=document.getElementById(txtprice).value;    
    var txttotal=document.getElementById(txtTotal);
    if(!isNaN(qty) && qty!=''){
        var total=parseInt(qty)*parseFloat(price);
        txttotal.value=floorFigure(total);
    }else{
        txttotal.value='0.00';
    }
}
function toggleWorkerSelection(chkbox,empid){
    if(chkbox.checked){
        $('#inputEmpId'+empid).val(empid);
    }else{
        $('#inputEmpId'+empid).val('');
    }
}
function AddItemDetail(url){
    $('.messageDiv').hide();
    if($('#selItemStatus').val().trim()==''){
        fnCmnWarningMessage('Select Work Status!!!');
        $('#selItemStatus').focus();
        scrollToMessage();
        return;
    }if($('#selProdStatus').val().trim()==''){
        fnCmnWarningMessage('Select Product Status!!!');
        $('#selProdStatus').focus();
        scrollToMessage();
        return;
    }
    if($('#txtStartDate').val().trim()==''){
        fnCmnWarningMessage('Select Start Date!!!');
        $('#txtStartDate').focus();
        scrollToMessage();
        return;
    }
    if($('#txtDeadline').val().trim()==''){
        fnCmnWarningMessage('Select Deadline date!!!');
        $('#txtDeadline').focus();
        scrollToMessage();
        return;
    }
    var sdate=new Date($('#txtStartDate').val());
    var edate=new Date($('#txtDeadline').val());
    if(sdate>edate){
        fnCmnWarningMessage('Start date cannot be greater than Deadline.!!!');
        $('#selProdStatus').focus();
        scrollToMessage();
        return;
    }    
    if($('#txtTeamno').val().trim()==''){
        fnCmnWarningMessage('Enter Number of Team for the item!!!');
        $('#txtTeamno').focus();
        scrollToMessage();
        return;
    }
    //var teamno=parseInt($('#txtTeamno').val());
//    var selectedworkers=document.getElementsByName('inputEmpId');
//   // var totalSelected=0;
//    var isSelected=false;
//    for(var i=0;i<selectedworkers.length;i++){
//        if(selectedworkers[i].value.trim()!=''){
//            isSelected=true;
//           // totalSelected++;
//        }
//    }
//    if(!isSelected){
//        fnCmnWarningMessage('You have not selected any worker.!!!');       
//        scrollToMessage();
//        return;
//    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
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
               $('#divProjDetail').empty().append(result.html); 
               stopLoading();
               fnCmnSuccessMessage(result.message);
               scrollToMessage();
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
   // if(teamno!=totalselecte)
        
}
function ItemDetailAction(id){
    $('.messageDiv').hide();    
    var url=$('#selItemAction'+id).val();
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
                stopLoading();                
                $('#divItemDetail').empty().append(result.html).trigger('datepicker'); 
                lmsShowHideAddressResult('ItemList');
                document.getElementById('divItemDetail').scrollIntoView();                
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
function EditItemDetail(url){
    $('.messageDiv').hide();    
    if($('#txtStartDate').val().trim()==''){
        fnCmnWarningMessage('Select Start Date!!!');
        $('#txtStartDate').focus();
        scrollToMessage();
        return;
    }
    if($('#txtDeadline').val().trim()==''){
        fnCmnWarningMessage('Select Deadline date!!!');
        $('#txtDeadline').focus();
        scrollToMessage();
        return;
    }
    
    var sdate=new Date($('#txtStartDate').val());
    var edate=new Date($('#txtDeadline').val());
    if(sdate>edate){
        fnCmnWarningMessage('Start date cannot be greater than Deadline.!!!');
        $('#selProdStatus').focus();
        scrollToMessage();
        return;
    }
    if($('#txtQty').val().trim()==''){
        fnCmnWarningMessage('Enter a valid Quantity');
        $('#txtQty').focus();
        scrollToMessage();
        return;
    }
    if(parseInt($('#txtQty').val().trim())<=0){
        fnCmnWarningMessage('Enter a valid Quantity');
        $('#txtQty').focus();
        scrollToMessage();
        return;
    }
//    if(parseFloat($('#txtCharge').val())==0){
//        if(!confirm('Do you really want to continue with 0 (zero) Installation Charge?')){
//            $('#txtCharge').focus();
//            return;
//        }
//    }
    if($('#txtTeamno').val().trim()==''){
        fnCmnWarningMessage('Enter Number of Team!!!');
        $('#txtTeamno').focus();
        scrollToMessage();
        return;
    }    
    //var teamno=parseInt($('#txtTeamno').val());
    var selectedworkers=document.getElementsByClassName('classempid');
   // var totalSelected=0;
    var isSelected=false;
    for(var i=0;i<selectedworkers.length;i++){
        if(selectedworkers[i].value.trim()!=''){
            isSelected=true;
           // totalSelected++;
        }
    }
    if(!isSelected){
        fnCmnWarningMessage('You have not selected any worker.!!!');       
        scrollToMessage();
        return;
    }
    if(!confirm('Confirm Update?')){
        return;
    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
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
               $('#divProjDetail').empty().append(result.html); 
               stopLoading();
               fnCmnSuccessMessage(result.message);
               scrollToMessage();
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
   // if(teamno!=totalselecte)
        
}
function AddDailyReport(url){
    $('.messageDiv').hide();
    if($('#selWorkStatus').val().trim()==''){
        fnCmnWarningMessage('Select work status!!!');
        $('#selWorkStatus').focus();
        scrollToMessage();
        return;
    }
    if($('#txtRptDate').val().trim()==''){
        fnCmnWarningMessage('Select Report Date!!!');
        $('#txtRptDate').focus();
        scrollToMessage();
        return;
    }
    if($('#txtRptdetail').val().trim()==''){
        fnCmnWarningMessage('Enter Report Detail!!!');
        $('#txtRptDate').focus();
        scrollToMessage();
        return;
    }
    var validFiles=['jpg','jpeg','png','gif','doc','docx','pdf','bmp','.xls','xlsx'];
    if($('#fileWorkImg').val().trim()!=''){
        var ext=$('#fileWorkImg').val().split('.')[1];
        var isValid=false;
        for(var i=0;i<validFiles.length;i++){
            if(ext.toUpperCase()==validFiles[i].toUpperCase()){
                isValid=true;
                break;
            }
        }
        if(!isValid){
            fnCmnWarningMessage('The file you have selected is invalid.');
            $('#fileWorkImg').focus();
            scrollToMessage();
            return;
        }
    }
    if(!confirm('Are you ready to proceed?')){
        return;
    }
    startLoading();
    var frmData=new FormData($('#ProjectForm')[0]);
    $.ajax({
        type: 'POST',
        url: url,
        data: frmData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                stopLoading();
                fnCmnSuccessMessage(result.message);
                scrollToMessage();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function GotoAddAdvancePay(url){
    $('.messageDiv').hide();
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
               stopLoading();                
               $('#divaddAdvPay').empty().append(result.html); 
               document.getElementById('divaddAdvPay').scrollIntoView();
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
function AddNewAdvancePayment(url){
    $('.messageDiv').hide();
    if($('#selpayMode').val().trim()==''){
        fnCmnWarningMessage('Select Payment Mode!!!');
        $('#selpayMode').focus();
        scrollToMessage();
        return;
    }
    if($('#txtPayDate').val().trim()==''){
        fnCmnWarningMessage('Select Date of Payment!!!');
        $('#txtPayDate').focus();
        scrollToMessage();
        return;
    }
    if($('#txtAmount').val().trim()==''){
        fnCmnWarningMessage('Enter Received Amount!!!');
        $('#txtAmount').focus();
        scrollToMessage();
        return;
    }        
    if(parseFloat($('#txtAmount').val())<=0){
        fnCmnWarningMessage('Enter a valid Amount!!!');
        $('#txtAmount').focus();
        scrollToMessage();
        return;
    }
    if($('#txtreAmount').val().trim()==''){
        fnCmnWarningMessage('Re-enter Received Amount!!!');
        $('#txtreAmount').focus();
        scrollToMessage();
        return;
    }
    if(parseFloat($('#txtAmount').val())!=parseFloat($('#txtreAmount').val())){
        fnCmnWarningMessage('Received Amount Mismatched!!!');
        $('#txtreAmount').focus();
        scrollToMessage();
        return;
    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
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
               $('#divProjDetail').empty().append(result.html); 
               document.getElementById('divProjDetail').scrollIntoView();
               fnCmnSuccessMessage(result.message);
               scrollToMessage();
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
function CancelAdvPay(){
    $('.messageDiv').hide();
    if(!confirm('Are you sure you want to cancel current process?')){
        return;
    }
    $('#divaddAdvPay').empty();
}
function toggleSearchProjCriteria(selid){
    var sel=document.getElementById(selid);
    $('#trcriteria').show();
    $('#selProjArea').hide();
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
        case 'ordno':
            document.getElementById('txtCriteria').placeholder='Enter Project ID/Order Number';
            $('#txtCriteria').show();
            break;
        case 'cname':
            document.getElementById('txtCriteria').placeholder='Enter Customer Name';
            $('#txtCriteria').show();
            break;
        case 'ename':
            document.getElementById('txtCriteria').placeholder='Enter Site Coordinator Name/ID';
            $('#txtCriteria').show();
            break;
        case 'area':
            $('#selProjArea').show();
            break;
        case 'date':
            $('#divDate').show();
            break; 
        case 'status':
            $('#selProjStatus').show();
            break;
        default:
            $('#tdtitle').empty();            
            break;
    }
}
function SearchProject(){
    $('.messageDiv').hide();
    switch($('#selSearchProjCriteria').val()){        
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
                fnCmnWarningMessage('Enter Customer Name!!!');
                $('#txtCriteria').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'ename':
            if($('#txtCriteria').val().trim()==''){
                fnCmnWarningMessage('Enter Site Coordinator Name/ID!!!');
                $('#txtCriteria').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'area':
            if($('#selProjArea').val().trim()==''){
                fnCmnWarningMessage('Select Project Area!!!');
                $('#selProjArea').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'date':
            if($('#txtsdate').val().trim()=='' && $('#txtedate').val().trim()==''){
                fnCmnWarningMessage('You need to provide atleast one date!!!');
                $('#txtsdate').focus();
                scrollToMessage();
                return;
            }
            if($('#txtedate').val()!='' && $('#txtsdate').val()!='' ){
                var sdate=new Date($('#txtsdate').val());
                var edate=new Date($('#txtedate').val());
                if(sdate>edate){
                    fnCmnWarningMessage('Start Date cannot be greater than Completion Date!!!');
                    $('#txtedate').focus();
                    scrollToMessage();
                    return;
                }
            }
            break;
        case 'status':
            if($('#selProjStatus').val().trim()==''){
                fnCmnWarningMessage('Select Project Status!!!');
                $('#selProjStatus').focus();
                scrollToMessage();
                return;
            }
            break;
    }
    startLoading();
    var url=$('#inputsearchprojectUrl').val();
    var frmData=$('form#frmSearchProject').serializeObject();
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
                $('#divProjectList').empty().append(result.html);  
                paginationTbl();
            }
            else{
                $('#divProjectList').empty();
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
function ViewProjectDetail(selAction){
    $('.messageDiv').hide();
    if($('#'+selAction).val().trim()==''){
        return;
    }
    var url=$('#'+selAction).val();
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
                $('#divprojindex').empty().append(result.html);
                $('#divProjDetail').empty().append(result.secondHtml);  
                lmsShowHideAddressResult('projlist');
                document.getElementById('divprojindex').scrollIntoView();
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
function GotoUpdProjDoc(url){
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
                $('#divDocdetail').empty().append(result.html); 
                lmsShowHideAddressResult('DocList');
                document.getElementById('divDocdetail').scrollIntoView();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
        }
    });
}
function UploadProjectDocument(url,mode){
    $('.messageDiv').hide();
    if($('#txtDocTitle').val().trim()==''){
        fnCmnWarningMessage('Title of the Document is mandatory!!!');
        $('#txtDocTitle').focus();
        scrollToMessage();
        return;
    }
    if($('#fileProjDoc').val().trim()=='' && mode=='INST'){
        fnCmnWarningMessage('You have not selected any document!!!');
        $('#txtDocDesc').focus();
        scrollToMessage();
        return;
    }
    startLoading();
    var frmData=new FormData($('#ProjectForm')[0]);
    $.ajax({
        type: 'POST',
        url: url,
        data: frmData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#divProjDetail').empty().append(result.html);
                scrollToMessage();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function ProjectDocAction(selid){
    $('.messageDiv').hide();
    if($('#'+selid).val().trim()==''){
        return;
    }
    var selvalue=$('#'+selid).val();
    var action=selvalue.split('&')[1];
    var url=selvalue.split('&')[0];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete this document?')){
            return;
        }
    }
    startLoading();    
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                if(action=='del'){
                    $('#divProjDetail').empty().append(result.html);
                    fnCmnSuccessMessage(result.message);
                    scrollToMessage();
                }
                else{
                     $('#divDocdetail').empty().append(result.html);
                }
                stopLoading();
                
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function GotoUpdateProjStatus(url){
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
                $('#divProjectStatus').empty().append(result.html); 
                lmsShowHideAddressResult('StatusList');
                document.getElementById('divProjectStatus').scrollIntoView();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
       },
        error: function(){ 
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
        }
    });
}
function UpdateProjectStatus(url){
    $('.messageDiv').hide();
    if($('#selProjectStatus').val().trim()==''){
        fnCmnWarningMessage('Select Project Status');
        $('#selProjectStatus').focus();
        scrollToMessage();
        return;
    }
    if($('#selProjectStatus').val()==$('#inputstatusid').val()){
        fnCmnWarningMessage('Project is already in \''+$("#selProjectStatus :selected").text()+'\' status');
        $('#selProjectStatus').focus();
        scrollToMessage();
        return;
    }
    if($('#txtstatusDate').val().trim()==''){
        fnCmnWarningMessage('Select status date');
        $('#txtstatusDate').focus();
        scrollToMessage();
        return;
    }
    if($('#txtRemarks').val().trim()==''){
        fnCmnWarningMessage('Enter few words in remark field');
        $('#txtRemarks').focus();
        scrollToMessage();
        return;
    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,        
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#divProjDetail').empty().append(result.html);
                scrollToMessage();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function ProjectEditor(url,appendarea){
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,               
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                stopLoading();
                $('#'+appendarea).empty().append(result.html);
                scrollToMessage();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function updateProjectDetail(url){
    $('.messageDiv').hide();
    if($('#selIndType').val().trim()==''){
         fnCmnWarningMessage('Select Industry Type!!!!');
        $('#selIndType').focus();
        scrollToMessage();
        return;   
    }
    if($('#txtStartDate').val().trim()==''){
         fnCmnWarningMessage('Select Project Execution Date!!!!');
        $('#txtStartDate').focus();
        scrollToMessage();
        return;   
    }
    if($('#txtEndDate').val().trim()==''){
        fnCmnWarningMessage('Select Tentative Completion Date!!!!');
        $('#txtEndDate').focus();
        scrollToMessage();
        return;   
    }
    if($('#txtdimension').val().trim()==''){
        fnCmnWarningMessage('Enter Project Dimension!!!!');
        $('#txtdimension').focus();
        scrollToMessage();
        return;   
    }
    if($('#txtDesc').val().trim()==''){
        fnCmnWarningMessage('Enter Project Description!!!!');
        $('#txtDesc').focus();
        scrollToMessage();
        return;   
    }
    if($('#txtRemark').val().trim()==''){
        fnCmnWarningMessage('Enter Modification Remark!!!!');
        $('#txtRemark').focus();
        scrollToMessage();
        return;   
    }
    var sdate=new Date($('#txtStartDate').val());
    var edate=new Date($('#txtEndDate').val());
    if(sdate>edate){
        fnCmnWarningMessage('Project Start Date cannot be greater than Completion Date.!!!!');
        $('#txtEndDate').focus();
        scrollToMessage();
        return;
    }
    if(!confirm('Confirm Update')){
        return;
    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,               
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#divProjDetailOnly').empty().append(result.html);
                scrollToMessage();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function UpdateProjectReferrer(url){
    $('.messageDiv').hide();
    if($('#txtRefName').val().trim()==''){
         fnCmnWarningMessage('Enter Referrer Name.');
        $('#txtRefName').focus();
        scrollToMessage();
        return;   
    }
    if($('#txtRefContact').val().trim()==''){!!!!
        fnCmnWarningMessage('Enter Referrer Contact Number');
        $('#txtRefContact').focus();
        scrollToMessage();
        return;   
    }
    var sdate=new Date($('#txtStartDate').val());
    var edate=new Date($('#txtEndDate').val());
    if(!confirm('Confirm Update')){
        return;
    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,               
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#divProjRefDetail').empty().append(result.html);
                scrollToMessage();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function SwapChangeCoordinator(){
    $('.messageDiv').hide();
    $('#tbchangecoordinator').show();
    $('#tbCoordinator').hide();
}
function ChangeCoordinator(url){
    $('.messageDiv').hide();
    if($('#selCoordinator').val().trim()==''){
         fnCmnWarningMessage('Please select a new Coordinator');
        $('#selCoordinator').focus();
        scrollToMessage();
        return;   
    }
    if(!confirm('Confirm Change Project Coordinator?')){
        return;
    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,        
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#divProjCoordinator').empty().append(result.html);
                scrollToMessage();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function CancelChangeCoordinator(){
    $('.messageDiv').hide();
    if(!confirm('Are you sure you want to cancel current action?')){
        return;
    }
    $('#tbchangecoordinator').hide();
    $('#tbCoordinator').show();
}
function UpdateItemStatus(url){
    $('.messageDiv').hide();
    if($('#selItemStatus').val().trim()==''){
        fnCmnWarningMessage('Select Item Status');
        $('#selItemStatus').focus();
        scrollToMessage();
        return;
    }
    if($('#selItemStatus').val()==$('#inputcurritemstatus').val()){
        fnCmnWarningMessage('Project is already in \''+$("#selItemStatus :selected").text()+'\' status');
        $('#selItemStatus').focus();
        scrollToMessage();
        return;
    }
    if($('#txtstatusDate').val().trim()==''){
        fnCmnWarningMessage('Select status date');
        $('#txtstatusDate').focus();
        scrollToMessage();
        return;
    }
    if($('#txtRemarks').val().trim()==''){
        fnCmnWarningMessage('Enter few words in remark field');
        $('#txtRemarks').focus();
        scrollToMessage();
        return;
    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,        
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#divItemDetail').empty().append(result.html);
                scrollToMessage();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function UpdateProductStatus(url){
    $('.messageDiv').hide();
    if($('#selProdStatus').val().trim()==''){
        fnCmnWarningMessage('Select Product Status');
        $('#selProdStatus').focus();
        scrollToMessage();
        return;
    }
    if($('#selProdStatus').val()==$('#inputcurrProdstatus').val()){
        fnCmnWarningMessage('Project is already in \''+$("#selProdStatus :selected").text()+'\' status');
        $('#selProdStatus').focus();
        scrollToMessage();
        return;
    }
    if($('#txtstatusDate').val().trim()==''){
        fnCmnWarningMessage('Select status date');
        $('#txtstatusDate').focus();
        scrollToMessage();
        return;
    }
    if($('#txtRemarks').val().trim()==''){
        fnCmnWarningMessage('Enter few words in remark field');
        $('#txtRemarks').focus();
        scrollToMessage();
        return;
    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,        
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                stopLoading();
                fnCmnSuccessMessage(result.message);
                $('#divItemDetail').empty().append(result.html);
                scrollToMessage();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function GoToAddNewItemService(url){
   $('.messageDiv').hide(); 
   startLoading();
    $.ajax({
        type: 'POST',
        url: url,       
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){
                $('#divItemService').empty().append(result.html);
                stopLoading();
                document.getElementById('divItemService').scrollIntoView();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function ItemServiceAction(srvId){
    $('.messageDiv').hide();
    var urlaction=$('#selItemServiceAction'+srvId).val();
    if(urlaction==''){
        return;
    }
    var url=urlaction.split('&')[0];
    var action=urlaction.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure want to delete the selected service?')){
            return;
        }
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,       
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){                
                if(action=='del'){
                    fnCmnSuccessMessage(result.message);
                    $('#divItemDetail').empty().append(result.html);
                    scrollToMessage();
                    document.getElementById('divItemDetail').scrollIntoView();
                    $('#divItemService').empty();
                }else{
                    $('#divItemService').empty().append(result.html);
                    document.getElementById('divItemService').scrollIntoView();
                }
                stopLoading();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function ManageItemService(url,mode){
    $('.messageDiv').hide();
    if(mode=='ins'){
        if($('#selServicelist').val().trim()==''){
            fnCmnWarningMessage('Select a service!!!');
            $('#selServicelist').focus();
            scrollToMessage();
            return;
        }
    }
    if($('#txtQty').val().trim()==''){
        fnCmnWarningMessage('Please enter a valid Quantity!!!');
        $('#txtQty').focus();
        scrollToMessage();
        return;
    }
    if(parseInt($('#txtQty').val())<=0 && isNaN($('#txtQty').val())){
        fnCmnWarningMessage('Please enter a valid Quantity!!!');
        $('#txtQty').focus();
        scrollToMessage();
        return;
    }
    if($('#txtCharge').val().trim()==''){
        fnCmnWarningMessage('Please enter a valid Service Charge!!!');
        $('#txtCharge').focus();
        scrollToMessage();
        return;
    }
    if(parseFloat($('#txtCharge').val())<=0){
       if(!confirm('Charge for this service is 0(zero). Is this Okay?')){
            $('#txtCharge').focus();
            return;
       }
    }
    if(mode=='edt'){
        if(!confirm('Confirm Update?')){
            return;
        }
    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,   
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){                
                fnCmnSuccessMessage(result.message);
                $('#divItemDetail').empty().append(result.html);
                scrollToMessage();
                document.getElementById('divItemDetail').scrollIntoView();   
                $('#divItemService').empty();
                stopLoading();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function CancelItemService(){
    $('.messageDiv').hide();
    if(!confirm('Are you sure you want to cancel the update?')){
        return;
    }
    $('#divItemService').empty();
    document.getElementById('divItemDetail').scrollIntoView();
}
function ManageAdditionalService(url,mode){
    $('.messageDiv').hide();
    if(mode=='ins'){
        if($('#txtServiceName').val().trim()==''){
            fnCmnWarningMessage('Enter Service Name!!!');
            $('#txtServiceName').focus();
            scrollToMessage();
            return;
        }
    }
    if($('#txtQty').val().trim()==''){
        fnCmnWarningMessage('Please enter a valid Quantity!!!');
        $('#txtQty').focus();
        scrollToMessage();
        return;
    }
    if(parseInt($('#txtQty').val())<=0 && isNaN($('#txtQty').val())){
        fnCmnWarningMessage('Please enter a valid Quantity!!!');
        $('#txtQty').focus();
        scrollToMessage();
        return;
    }
    if($('#txtCharge').val().trim()==''){
        fnCmnWarningMessage('Please enter a valid Service Charge!!!');
        $('#txtCharge').focus();
        scrollToMessage();
        return;
    }
    if(parseFloat($('#txtCharge').val())<=0){
       if(!confirm('Charge for this service is 0(zero). Is this Okay?')){
            $('#txtCharge').focus();
            return;
       }
    }
    if(mode=='edt'){
        if(!confirm('Confirm Update?')){
            return;
        }
    }
    startLoading();
    var frmData=$('form#ProjectForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,   
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){                
                fnCmnSuccessMessage(result.message);
                $('#divProjDetail').empty().append(result.html);
                scrollToMessage();
                document.getElementById('divProjDetail').scrollIntoView();  
                $('#divItemService').empty();
                stopLoading();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function CancelAdditionalService(){
    $('.messageDiv').hide();
    if(!confirm('Are you sure you want to cancel the update?')){
        return;
    }
    $('#divItemService').empty();
    document.getElementById('divProjDetail').scrollIntoView();
}
function AdditionalServiceAction(srvId){
    $('.messageDiv').hide();
    var urlaction=$('#selAction'+srvId).val();
    if(urlaction==''){
        return;
    }
    var url=urlaction.split('&')[0];
    var action=urlaction.split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure want to delete the selected service?')){
            return;
        }
    }
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,       
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){                
                if(action=='del'){
                    fnCmnSuccessMessage(result.message);
                    $('#divProjDetail').empty().append(result.html);
                    scrollToMessage();
                    document.getElementById('divProjDetail').scrollIntoView();
                    $('#divItemService').empty();
                }else{
                    $('#divItemService').empty().append(result.html);
                    document.getElementById('divItemService').scrollIntoView();
                }
                stopLoading();
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function LoadProductByCat(url,catid,eleobj){
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,       
        contentType: 'application/json',
        dataType: 'json',
        success: function(result){
            if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
            if(result.success){                
                $('#td'+catid).empty().append(result.html);
                stopLoading();
                lmsShowHideAddressResult(catid);
                $(eleobj).removeAttr("onclick");
                $(eleobj).click(function(){
                    lmsShowHideAddressResult(catid);
                });
            }else{
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}