function fnAddAttribute(targetTblID, attrNameID){
    var attr_name = $('#'+attrNameID+' option:selected').text();
    var attr_value = $('#'+attrNameID).val();
    var rowCount = parseInt($('#'+targetTblID+' tr').length + 1);  
    $('#'+targetTblID+' tr').last().before('<tr class="attribute'+rowCount+'">\n\
                                              <td class="td-white-bg">'+ attr_name +'</td>\n\
                                              <td class="td-white-bg" align="center"><div class="delete" onclick="removeAttributeTr('+ rowCount +');"></div></td>\n\
                                         </tr>');   
}

function removeAttributeTr(attrTrClass){ 
    $('#attribute_list').find("tr.attribute"+attrTrClass).remove();  
}

function loadbuildingbystoreid(thisid){
    $('.messageDiv').hide();
    $('#tdStkBldg').empty().append('<select name="selStkBldg" id="selStkBldg" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkFloor').empty().append('<select name="selStkFloor" id="selStkFloor" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkRoom').empty().append('<select name="selStkRoom" id="selStkRoom" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkRack').empty().append('<select name="selStkRack" id="selStkRack" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkBin').empty().append('<select name="selStkBin" id="selStkBin" class="cmnWidth"><option value="">--select--</option></select>');
    var url=$('#'+thisid).val();
    if(url==''){  
        $('#inputStoreId').val('');
        return;
    }
    startLoading(); 
    var storeid=url.split('&')[1];
    $('#inputStoreId').val(storeid);
    url=url.split('&')[0];
    $.ajax({
        type: 'POST',
        url: url,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.success){
                $('#tdStkBldg').empty().append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.html);
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
function loadfloorbybldgid(thisid){
    $('.messageDiv').hide();   
    $('#tdStkFloor').empty().append('<select name="selStkFloor" id="selStkFloor" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkRoom').empty().append('<select name="selStkRoom" id="selStkRoom" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkRack').empty().append('<select name="selStkRack" id="selStkRack" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkBin').empty().append('<select name="selStkBin" id="selStkBin" class="cmnWidth"><option value="">--select--</option></select>');
    var url=$('#'+thisid).val();
    if(url==''){  
        $('#inputBldgId').val('');
        return;
    }
    startLoading();
    var bldgid=url.split('&')[1];
    url=url.split('&')[0];
    $('#inputBldgId').val(bldgid);
    $.ajax({
        type: 'POST',
        url: url,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.success){
                $('#tdStkFloor').empty().append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.html);
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
function laodroombyfloorid(thisid){
    $('.messageDiv').hide();       
    $('#tdStkRoom').empty().append('<select name="selStkRoom" id="selStkRoom" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkRack').empty().append('<select name="selStkRack" id="selStkRack" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkBin').empty().append('<select name="selStkBin" id="selStkBin" class="cmnWidth"><option value="">--select--</option></select>');
    var url=$('#'+thisid).val();
    if(url==''){  
        $('#inputFloorId').val('');
        return;
    }
    startLoading();
    var floorid=url.split('&')[1];
    url=url.split('&')[0];
    $('#inputFloorId').val(floorid);
    $.ajax({
        type: 'POST',
        url: url,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.success){
                $('#tdStkRoom').empty().append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.html);
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
function laodrackbyroomid(thisid){
    $('.messageDiv').hide();         
    $('#tdStkRack').empty().append('<select name="selStkRack" id="selStkRack" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkBin').empty().append('<select name="selStkBin" id="selStkBin" class="cmnWidth"><option value="">--select--</option></select>');
    var url=$('#'+thisid).val();
    if(url==''){  
        $('#inputRoomId').val('');
        return;
    }
    startLoading();
    var roomid=url.split('&')[1];
    url=url.split('&')[0];
    $('#inputRoomId').val(roomid);
    $.ajax({
        type: 'POST',
        url: url,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.success){
                $('#tdStkRack').empty().append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.html);
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
function laodbinbyrackid(thisid){
    $('.messageDiv').hide();         
    $('#tdStkBin').empty().append('<select name="selStkBin" id="selStkBin" class="cmnWidth"><option value="">--select--</option></select>');
    var url=$('#'+thisid).val();
    if(url==''){  
        $('#inputRackId').val('');
        return;
    }
    startLoading();
    var rackid=url.split('&')[1];
    url=url.split('&')[0];
    $('#inputRackId').val(rackid);
    $.ajax({
        type: 'POST',
        url: url,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.success){
                $('#tdStkBin').empty().append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.html);
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
function selectBinId(thisid){
    $('.messageDiv').hide();
    var binid=$('#'+thisid).val();
    $('#inputBinId').val(binid);
}

function PORadioChange(id,url){
    $('.messageDiv').hide();
    var radio=document.getElementById(id);
    document.getElementById('inputPOselection').value=radio.value;
    startLoading();
    $('#divPOProdList').empty();
    $('#divStockEntryDetail').empty();
    if(radio.value==0){
        $('#divPrdWithoutPO').show();
        $('#divPrdWithPO').hide();
    }
    else if(radio.value==1){
        $('#divPrdWithPO').show();
        $('#divPrdWithoutPO').hide();        
    }
    stopLoading();
}

function stkLoadSubCategory(thisid)
{
    $('#selStkPrdList').empty().append('<option value="">--Select--</option>');
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
                //$('#tbodyDynamic').empty().append(Response.html);
                $('#prdproductList').empty().append(Response.secondHtml);
                stopLoading();
            }
            else
            {
                fnCmnWarningMessage(Response.message);
                $('#prdproductList').empty().append(Response.secondHtml);
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
function StkLoadDynamicSubCat(id)
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

function SelectProductIdforStockEntry(){
    $('.messageDiv').hide();
    var prdid=$('#selStkPrdList').val();
    if(prdid==''){
        $('#spanErronSel').text('Product not selected.');
        return;
    }
    $('#spanErronSel').text('');
    $('#inputProductCode').val(prdid);
    GotoStockEntryDetail();
    
}
function SelectProductIdforStockEntryOnKeyPress(key){
     $('.messageDiv').hide();
     var keycode = (key.which) ? key.which : key.keyCode;
    if(keycode!=13)
    {
        return false;
    }
    else{
        var prdid=$('#txtPrdcode').val(); 
        $('#inputProductCode').val(prdid);
        if(prdid==''){
            $('#spanErronEnter').text('Enter Product Code');
            return;
        }
        $('#spanErronEnter').text('');
        GotoStockEntryDetail();
    }   
    
}
function GotoStockEntryDetail(){
    $('.messageDiv').hide();
    var url=$('#inputstkdetailUrl').val();
    if(url==''){
        return;
    }
    startLoading();
    var frmdata=$('form#StockMainFrm').serializeObject();
    var dataString=JSON.stringify(frmdata);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType:'json',
        success:function(result){
            if(result.success){
                $('#divStockEntryDetail').empty().append(result.html);
                document.getElementById('divStockEntryDetail').scrollIntoView();
                stopLoading();
            }
            else{
                $('#divStockEntryDetail').empty();
                stopLoading();
                fnCmnWarningMessage(result.message);
                ScrollToMessage();                
            }
        },
        error: function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToMessage();
        }
    });    
}
function AppendTax(){
    var tbody=document.getElementById('tbodyTax');
    var selTax=document.getElementById('selStkTax');
    var msgspan=document.getElementById('spantaxErr');
    if(selTax.value=='')
        return;
    var taxid=selTax.value;
    var taxName=selTax.options[selTax.selectedIndex].text;
    msgspan.innerHTML='';
    for(var i=0;i<tbody.rows.length;i++){
        if(tbody.rows[i].id=='trTax'+taxid){
            msgspan.innerHTML='Tax already added';
            return;
        }
    }
    var tr=tbody.insertRow();
    tr.id="trTax"+taxid;
    var cell1=tr.insertCell();
    var cell2=tr.insertCell();
   // var cell3=tr.insertCell();
    
    cell1.innerHTML= taxName; cell1.className='td-gray-bg'; cell1.width=120+'px';
    cell2.innerHTML='<input type="text" name="txtTaxVal" id="txtTaxVal'+taxid+'" placeholder="Enter Tax Value" class="money" value="0.00" onkeyup="isMoney(this.id);"/>'+
                    '<input type="hidden" name="inputTaxId" id="inputTaxId'+taxid+'" value="'+taxid+'"/>'+
                    '<input type="hidden" name="inputIsExisting" id="inputIsExisting'+taxid+'" value=""/>'+
                    '&nbsp;<input type="button" value="-" title="Remove Tax from the list" onclick="RemoveTaxRow(\''+taxid+'\');"/>';
    cell2.className='td-white-bg'; cell2.align='left'; cell2.width=200+'px';
    //ell3.innerHTML='<input type="button" class="button" value="-" title="Remove Tax from the list" onclick="RemoveTaxRow(\''+taxid+'\');"/>';
    //cell3.className='td-white-bg'; cell3.align='left';
    /*var str='<tr id=><td class="td-gray-bg">'+taxName+
            '</td><td class="td-white-bg" width="200px"><input type="text" name="txtTaxVal" placeholder="Enter Tax Value" class="cmnWidth"/>'+
            '<input type="hidden" name="inputTaxId" id="inputTaxId'+taxid+'" value="'+taxid+'"/></td>'+
            '<td></td></tr>';*/
//    alert(tbody.innerHTML);
//    tbody.innerHTML=tbody.innerHTML+str; 
    document.getElementById('defaultRow').style.display='none';
}

function RemoveTaxRow(taxid){
    var tbody=document.getElementById('tbodyTax');
    var tr=document.getElementById('trTax'+taxid);  
    var inputtaxid=document.getElementById('inputIsExisting'+taxid);
    //var taxid=document.getElementById('inputTaxId'+taxid);    
    if(inputtaxid.value!=''){
        if(!confirm('Tax you are trying to delete seems to be from database. Proceed?')){
            return;    
        }
        
    }
    tbody.deleteRow(tr.rowIndex-1);
    if(tbody.rows.length==0){
        document.getElementById('defaultRow').style.display='';
    }
}

function InsertStock(url){
    $('.messageDiv').hide();
//    if($('#selUnit').val()=='0'){
//        fnCmnWarningMessage('Select Unit.');
//        $('#selstkStore').focus();
//        scrollToMessage();
//        return;
//    }
    if($('#selstkStore').val().trim()==''){
        fnCmnWarningMessage('You must atleast select a store as stock location');
        $('#selstkStore').focus();
        scrollToMessage();
        return;
    }    
//    if($('#stkMfgDate').val()!='' && $('#stkExpDate').val()!=''){
//        var mfgDate=new Date($('#stkMfgDate').val());
//        var expDate=new Date($('#stkExpDate').val()); 
//        if(mfgDate>expDate){
//            fnCmnWarningMessage('Manufacturing Date cannot be greater than Expiry Date.');
//            $('#stkQty').focus();
//            scrollToMessage();
//            return;
//        }
//    }
    if($('#stkQty').val().trim()==''){
        fnCmnWarningMessage('Enter Stock Quantity.');
        $('#stkQty').focus();
        scrollToMessage();
        return;
    }
    if( parseInt($('#stkQty').val())<=0){
        fnCmnWarningMessage('Stock Quantity is invalid.');
        $('#stkQty').focus();
        scrollToMessage();
        return;
    }
    if($('#txtStockDesc').val().trim()==''){
        fnCmnWarningMessage('Enter Description.');
        $('#txtStockDesc').focus();
        scrollToMessage();
        return;
    }
    var frmData=$('form#StockMainFrm').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
       type: 'POST',
       url: url,
       data: dataString,
       dataType: 'json',
       contentType: 'application/json',
       success: function(result){
           if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
           if(result.success){
               $('#divStockEntryDetail').empty();
                fnCmnSuccessMessage(result.message);
                stopLoading();
                scrollToMessage();                
           }
           else{
                fnCmnWarningMessage(result.message);
                stopLoading();
                scrollToMessage();
           }
       },
       error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToMessage();
       }
    });
}
function toggleStkSearchCriteria(key){
    $('.messageDiv').hide();
    var txtKey=$('#txtProd');
    txtKey.val('');
    $('#txtFrom').val('');
    $('#txtTo').val('');
    var divrange=$('#divRange');
    divrange.hide();
    txtKey.hide();    
        switch(key){
            case 'sku':
                txtKey.attr('placeholder','Enter SKU of the product');
                txtKey.show();
                break;
            case 'qty':
                txtKey.attr('placeholder','Enter Quantity');
                divrange.show();
                break;
            case 'val':
                txtKey.attr('placeholder','Enter Stock Value');
                divrange.show();
                break;
            /*case 're':
                txtKey.attr('placeholder','Reorder Quantity');
                divrange.show();
                break;*/
        }
    }
//    var select=document.getElementById(thisid);
//    var idtoshow=select.value;
//    var divtoshow=document.getElementById(idtoshow);
//    for(var i=0;i<select.options.length;i++){
//        if(idtoshow!=select.options[i].value){
//            var idtohide=select.options[i].value
//            var divtohide=document.getElementById(idtohide);
//            divtohide.style.display='none';
//        }
//    }
//    divtoshow.style.display='';  
function StkSearchQuantityToggle(id){
    $('.messageDiv').hide();
    var radio=document.getElementById(id);
    document.getElementById('inputQuantitySelection').value=radio.value;
}
function StkSearchDayToggle(id){
    $('.messageDiv').hide();
    var radio=document.getElementById(id);
    document.getElementById('inputDaySelection').value=radio.value;
}
function loadbuildingbystoreid_search(thisid){
    $('.messageDiv').hide();
    $('#tdStkBldgSearch').empty().append('<select name="selStkBldgSearch" id="selStkBldgSearch" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkFloorSearch').empty().append('<select name="selStkFloorSearch" id="selStkFloorSearch" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkRoomSearch').empty().append('<select name="selStkRoomSearch" id="selStkRoomSearch" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkRackSearch').empty().append('<select name="selStkRackSearch" id="selStkRackSearch" class="cmnWidth"><option value="">--select--</option></select>');
    var url=$('#'+thisid).val();
    if(url==''){  
        return;
    }
    startLoading(); 
    var storeid=url.split('&')[1];
    $('#inputStoreId').val(storeid);
    url=url.split('&')[0];
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.success){
                $('#tdStkBldgSearch').empty().append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.html);
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
function loadfloorbybldgid_search(thisid){
    $('.messageDiv').hide();   
    $('#tdStkFloorSearch').empty().append('<select name="selStkFloorSearch" id="selStkFloorSearch" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkRoomSearch').empty().append('<select name="selStkRoomSearch" id="selStkRoomSearch" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkRackSearch').empty().append('<select name="selStkRackSearch" id="selStkRackSearch" class="cmnWidth"><option value="">--select--</option></select>');
    var url=$('#'+thisid).val();
    if(url==''){  
        return;
    }
    startLoading();
    var bldgid=url.split('&')[1];
    url=url.split('&')[0];
    $('#inputBldgId').val(bldgid);
    $.ajax({
        type: 'POST',
        url: url,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.success){
                $('#tdStkFloorSearch').empty().append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.html);
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
function laodroombyfloorid_search(thisid){
    $('.messageDiv').hide();       
    $('#tdStkRoomSearch').empty().append('<select name="selStkRoomSearch" id="selStkRoomSearch" class="cmnWidth"><option value="">--select--</option></select>');
    $('#tdStkRackSearch').empty().append('<select name="selStkRackSearch" id="selStkRackSearch" class="cmnWidth"><option value="">--select--</option></select>');
    var url=$('#'+thisid).val();
    if(url==''){  
        return;
    }
    startLoading();
    var floorid=url.split('&')[1];
    url=url.split('&')[0];
    $('#inputFloorId').val(floorid);
    $.ajax({
        type: 'POST',
        url: url,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.success){
                $('#tdStkRoomSearch').empty().append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.html);
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
function laodrackbyroomid_search(thisid){
    $('.messageDiv').hide();         
    $('#tdStkRackSearch').empty().append('<select name="selStkRackSearch" id="selStkRackSearch" class="cmnWidth"><option value="">--select--</option></select>');
    var url=$('#'+thisid).val();
    if(url==''){  
        return;
    }
    startLoading();
    var roomid=url.split('&')[1];
    url=url.split('&')[0];
    $('#inputRoomId').val(roomid);
    $.ajax({
        type: 'POST',
        url: url,
        contentType:'application/json',
        dataType: 'json',
        success: function(result){
            if(result.success){
                $('#tdStkRackSearch').empty().append(result.html);
                stopLoading();
            }
            else{
                stopLoading();
                fnCmnWarningMessage(result.html);
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
function SearchStock(){
    $('.messageDiv').hide();    
    var criteria=$('#selSearchStkBy').val();
    var txtKey=$('#txtProd');
    var txtFrom=$('#txtFrom');
    var txtTo=$('#txtTo');
    switch(criteria){        
        case 'sku':
            if(txtKey.val().trim()==''){
                fnCmnWarningMessage('Enter SKU of the product.');
                txtKey.focus();
                return;
            }
            break;
        case 'qty':
            if(txtFrom.val().trim()==''){
                fnCmnWarningMessage('Enter Start Value.');
                txtFrom.focus();
                return;
            }
            if(isNaN(txtFrom.val())){
                fnCmnWarningMessage('Stock Quantity is invalid.');
                txtFrom.focus();
                return;
            }
            if(!isNaN(txtFrom.val() && !isNaN(txtTo.val()))){
                if(parseInt(txtFrom.val())>parseInt(txtTo.val())){
                    fnCmnWarningMessage('Start value cannot be greater than End value.');
                    txtFrom.focus();
                    return;
                }
            }
            break;
        case 'val':
            if(txtFrom.val().trim()==''){
                fnCmnWarningMessage('Enter Start Value.');
                txtFrom.focus();
                return;
            }
            if(isNaN(txtFrom.val())){
                fnCmnWarningMessage('Stock Value is invalid.');
                txtFrom.focus();
                return;
            }
            if(!isNaN(txtFrom.val() && !isNaN(txtTo.val()))){
                if(parseInt(txtFrom.val())>parseInt(txtTo.val())){
                    fnCmnWarningMessage('Start value cannot be greater than End value.');
                    txtFrom.focus();
                    return;
                }
            }
            break;
        /*case 're':
            if(txtFrom.val().trim()==''){
                fnCmnWarningMessage('Enter Start Value.');
                txtFrom.focus();
                return;
            }
            if(isNaN(txtFrom.val())){
                fnCmnWarningMessage('Quantity is invalid.');
                txtFrom.focus();
                return;
            }
            if(!isNaN(txtFrom.val() && !isNaN(txtTo.val()))){
                if(parseInt(txtFrom.val())>parseInt(txtTo.val())){
                    fnCmnWarningMessage('Start value cannot be greater than End value.');
                    txtFrom.focus();
                    return;
                }
            }
            break;*/
    }
    var url=$('#inputsearchstockURL').val();
    var frmData=$('form#SearchStockForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
       type: 'POST',
       url: url,
       data: dataString,
       dataType: 'json',
       contentType: 'application/json',
       success: function(result){
           if(result.jsonData=='AD'){
                AccessDenied(result.html);
                return;
            }
           if(result.success){
                $('#divStkSearchResult').empty().append(result.html);
                stopLoading();
                scrollToMessage();
                paginationTbl();
           }
           else{
                $('#divStkSearchResult').empty();                
                fnCmnWarningMessage(result.message);
                stopLoading();
                scrollToMessage();
           }
           $('#divStkDetail').empty();
       },
       error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToMessage();
       }
    });
}

function stockActions(url,action){
    $('.messageDiv').hide();
//    if($('#'+selactionid).val().trim()==''){
//        return;
//    }
//    var url=$('#'+selactionid).val().split('&')[0];
//    var action=$('#'+selactionid).val().split('&')[1];
    if(action=='del'){
        if(!confirm('Are you sure you want to delete the selected stock.')){
            return;
        }
    }
    var frmData=$('form#SearchStockForm').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
       type: 'POST',
       url: url,
       data: dataString,
       dataType: 'json',
       contentType: 'application/json',
       success: function(result){
           if(result.success){          

                if(result.jsonData=='AD'){
                    AccessDenied(result.html);
                    return;
                }
               var msg=result.message;
                if(action=='del'){
                    SearchStock();
                    stopLoading();
                    $('#divStkDetail').empty();
                    fnCmnSuccessMessage(msg);                    
                    scrollToMessage();
                }
                else{
                    lmsShowHideAddressResult('stksearchres');
                    $('#divStkDetail').empty().append(result.html);
                    stopLoading();
                    document.getElementById('divStkDetail').scrollIntoView();
                }
           }
           else{
                $('#divStkDetail').empty();
                fnCmnWarningMessage(result.message);
                stopLoading();
                scrollToMessage();
           }
       },
       error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToMessage();
       }
    });
}
function UpdateStock(url){
    $('.messageDiv').hide();
    if($('#selstkStore').val().trim()==''){
        fnCmnWarningMessage('You must atleast select a store as stock location');
        $('#selstkStore').focus();
        scrollToMessage();
        return;
    }
//    if($('#stkMfgDate').val()!='' && $('#stkExpDate').val()!=''){
//        var mfgDate=new Date($('#stkMfgDate').val());
//        var expDate=new Date($('#stkExpDate').val()); 
//        if(mfgDate>expDate){
//            fnCmnWarningMessage('Manufacturing Date cannot be greater than Expiry Date.');
//            $('#stkQty').focus();
//            scrollToMessage();
//            return;
//        }
//    }
    if($('#stkQty').val().trim()==''){
        fnCmnWarningMessage('Enter Stock Quantity.');
        $('#stkQty').focus();
        scrollToMessage();
        return;
    }
    if( parseInt($('#stkQty').val())<=0){
        fnCmnWarningMessage('Stock Quantity is invalid.');
        $('#stkQty').focus();
        scrollToMessage();
        return;
    }
    if($('#txtStockDesc').val().trim()==''){
        fnCmnWarningMessage('Enter Description.');
        $('#txtStockDesc').focus();
        scrollToMessage();
        return;
    }
    var frmData=$('form#ViewEditStockFrm').serializeObject();
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
       type: 'POST',
       url: url,
       data: dataString,
       dataType: 'json',
       contentType: 'application/json',
       success: function(result){
           if(result.success){
                fnCmnSuccessMessage(result.message);
                stopLoading();
                scrollToMessage();                
           }
           else{
                fnCmnWarningMessage(result.message);
                stopLoading();
                scrollToMessage();
           }
       },
       error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToMessage();
       }
    });
}
function loadPOProducts(){
    $('.messageDiv').hide();
    
    if($('#txtPoNumber').val().trim()==''){
        fnCmnWarningMessage('Enter Purchase Order Number.');
        $('#txtPoNumber').focus();
        scrollToMessage();
        return;
    }
    $('#divStockEntryDetail').empty();
    var url=$('#inputPOProductsUrl').val();
    var frmData={'ponumber':$('#txtPoNumber').val()};
    var dataString=JSON.stringify(frmData);
    startLoading();
    $.ajax({
       type: 'POST',
       url: url,
       data: dataString,
       dataType: 'json',
       contentType: 'application/json',
       success: function(result){
           if(result.success){
                $('#divPOProdList').empty().append(result.html)
                stopLoading();  
                paginationTbl();
           }
           else{
               $('#divPOProdList').empty();
                fnCmnWarningMessage(result.message);
                stopLoading();
                scrollToMessage();
           }
       },
       error:function(){
            stopLoading();
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToMessage();
       }
    });
}
function setProductCode(prdCode){
    $('#inputProductCode').val(prdCode);
    GotoStockEntryDetail();
    lmsShowHideAddressResult('PrdList');
}
function txtPOKeypress(key){
    $('.messageDiv').hide();
     var keycode = (key.which) ? key.which : key.keyCode;
    if(keycode!=13)
    {
        return false;
    }
    else{
        loadPOProducts();
    }
}
