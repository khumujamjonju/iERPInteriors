
//this js is for viewing company details when go button is clicked
//created by sanatomba
function FnViewCompany(url, compid)
{
    $('.messageDiv').hide();
    if ($(compid).val().trim()=='') {
        return;
    }
    var compid = {'comid': $(compid).val()};
    var dataString = JSON.stringify(compid);

    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {
                $('#company_grid').empty().append(result.html);
                paginationTbl();

            }
            else
            {
                fnCmnWarningMessage(result.message);
                scrollToMessage();
                stopLoading();
            }
        },
        error: function()
        {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}




////this js is for viewing supplier details when go button is clicked
//created by sanatomba
function FnViewPurchase(url)
{

    var dataString = JSON.stringify();

    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {
                $('#sup_grid').empty().append(result.html);
                lmsShowHideAddressResult('SearchCompanyResult');
                paginationTbl2();
                stopLoading();
            }
            else
            {
                fnCmnWarningMessage(result.message);
                scrollToMessage();
                stopLoading();
            }
        },
        error: function()
        {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            scrollToMessage();
            stopLoading();
        }
    });
}

//loading company details
function loadCompany_Page(mobtxn)
{
    var selValue = $('#TYPEID' + mobtxn).val();
    if (selValue == '') {
        return;
    }
    var url = selValue.split('&')[0];
    var action = selValue.split('&')[1];

    if (action == 'del') {
        if (!confirm('Are you sure you want to remove the selected company?'))
            return;
    }
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success) {
                if (action == 'comp') {
                    $('#company_detailsgrid').empty().append(result.html);
                    lmsShowHideAddressResult('SearchCompanyResult');

                    $('#btn_save').show();
                    $('#btn_edit').hide();
                    $('#btn_clear').hide();

                }
                else if (action == 'del') {
                }
                stopLoading();
            }
            else {
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







//this js is for loading purchase order form
//created by sanatomba
function loadPO_Page(url)
{
    var subid = {supid: $('#TYPEID').val()};

    if (document.getElementById('TYPEID').value=='0') {
        fnCmnWarningMessage('Please select supplier!');
        scrollToMessage();
        return false;
    }
    var dataString = JSON.stringify(subid);
   
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {
                $('#purchase_order_details').empty().append(result.html);
                lmsShowHideAddressResult('SearchCustomerResult');
                $('#btn_save').show();
                $('#btn_edit').hide();
                $('#btn_clear').hide();
                stopLoading();
            }
            else {
                fnCmnWarningMessage(result.message);
                stopLoading();
                scrollToMessage();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            stopLoading();
            scrollToMessage();
        }
    });
}




//this js is for loading Projectrelated items
//created by sanatomba
function loadProjectRelatedItems_Page(checkbox)
{

    //$('.'+checkbox).removeAttr('disabled');
    $('.' + checkbox).val('1');

}


//this js is for loading  product page

function SelectProductIdforPurchaseEntry(url) {
    $('.messageDiv').hide();
    var prdid = {prid: $('#selStkPrdList').val()};

    var poid = {poid: $('#pavalue').val()};
    if (document.getElementById('selStkPrdList').value == '0')
    {
        fnCmnWarningMessage('Please Select Category and then Product!');
        scrollToMessage();
        return false;
    }

    $('#spanErronSel').text('');
    $('#inputProductCode').val(prdid);


    //startLoading();
    var frmdata = $('form#PO_details').serializeObject();
    var dataString = JSON.stringify($.extend(frmdata, prdid,poid));

    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        {
            if (Response.jsonData == 'AD') {
                AccessDenied(Response.html);
                return;
            }
            if (Response.success)
            {
                stopLoading();
                $('.messageDiv').hide();
                $('#result_po').show();
                $('#display_product').append(Response.html);
                //$('#display_product').append(Response.html);
//                var quoted_total = 0;
//                $('#display_product').find('.total').each(function(){
//                    var element_input_val = $(this).val();
//                    if(element_input_val == '')
//                    {
//                        element_input_val = 0;
//                    }
//                    quoted_total = parseFloat(quoted_total + parseFloat(element_input_val));  
//                    
//                    $('.quotedtotal').html(quoted_total);
//                    $('#quoted').val(quoted_total);
//                });

            } else {

            }
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


function fnCalculateTax() {
    //calculate total tax 
    var tax_total = 0;

    $('#display_product').find('.taxtotal', '.grandtotal').each(function() {
        var element_input_val = $(this).val();
        if (element_input_val == '')
        {
            element_input_val = 0;
        }
        tax_total = parseFloat(tax_total + parseFloat(element_input_val));
        $('.taxtotal1').html(tax_total);
        $('#taxtotal').val(tax_total);

        var grand_total = 0;
        var tax = $('#taxtotal').val();
        var quoted = $('#total').val();
        grand_total = parseFloat(grand_total + parseFloat(quoted) + parseFloat(tax));
        $('.grandtotal').html(grand_total);
        $('#grand').val(grand_total);
    });
    //calculate Grand total
}


function fnQuantityWithAmount(pkid) {
    //calculate total tax
    var quantity = document.getElementById('quantityID' + pkid).value;
    var price = document.getElementById('price' + pkid).value;

    var tax_total = parseFloat(quantity * parseFloat(price));
    $('#totalprice' + pkid).val(tax_total);
    $('#totalquoted' + pkid).val(tax_total);
    calculateAmount();

}

function calculateAmount()
{       //var elem = document.getElementsByName("quotedtotal").value;
    var total = 0;
    var tax = 0;
    $('.total2').each(function() {

        total += parseFloat($(this).val());

        $('#total').val(total);
        $('.grandtotal').html(total);
        $('#grand').val(total);
    });

    $('.taxtotal').each(function() {

        tax += parseFloat($(this).val());

        $('#grand').val(total + tax);
    });

    //$('#grand').val(parseFloat(total) +parseFloat(tax) );    


}

function purLoadSubCategory(thisid)
{

    var url = $('#' + thisid).val();
    if (url == "")
    {
        //fnCmnWarningMessage("Please Select A Category");
        $('#tbodyDynamic').empty();
        ScrollToMessage();
        return false;
    }
    startLoading();
    var tabId = url.split("/").pop();
    var inputsearch = document.getElementById('searchvalue');
    inputsearch.value = tabId;
    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        success: function(Response)
        {
            if (Response.jsonData == 'AD') {
                AccessDenied(Response.html);
                return;
            }
            if (Response.success)
            {
                // $('#tbodyDynamic').empty().append(Response.html);
                $('#prdproductList').empty().append(Response.html);
                //$('#prdproductList').empty().append(Response.html);
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

function loadsubcatdynamic_purchase(id)
{
    $('.messageDiv').hide();
    var url = $('#pkid' + id).val();

    if (url == "")
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
            if (Response.jsonData == 'AD') {
                AccessDenied(Response.html);
                return;
            }
            var tb = document.getElementById('tbodyDynamic');
            var tr = document.getElementById(id);
            var i = tr.rowIndex;
            while (tb.rows.length > i)
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


function SelectProductIdforPurchaseEntryOnKeyPress(key)
{
    $('.messageDiv').hide();
    var keycode = (key.which) ? key.which : key.keyCode;
    if (keycode != 13)
    {
        return false;
    }
    else
    {
        var prdid = $('#txtPrdcode').val();
        $('#inputProductCode').val(prdid);
        if (prdid == '')
        {
            $('#spanErronEnter').text('Enter Product Code');
            return;
        }
        $('#spanErronEnter').text('');
        GotoPurchaseProductEntryDetail();
    }

}


function GotoPurchaseProductEntryDetail()
{
    $('.messageDiv').hide();
    var url = $('#inputstkdetailUrl').val();

    if (url == '')
    {
        return;
    }
    startLoading();
    var frmdata = $('form#PO_details').serializeObject();

    var dataString = JSON.stringify(frmdata);
    alert(dataString);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success) {
                $('#display_product').empty().append(result.html);
                document.getElementById('display_product').scrollIntoView();
                stopLoading();
            }
            else {
                $('#display_product').empty();
                stopLoading();
                fnCmnWarningMessage(result.message);
                ScrollToMessage();
            }
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            ScrollToMessage();
        }
    });
}


function SavePODetails(url, elementObj)
{
    var supid = {supid: $('#supplierid').val()};
    var comid = {comid: $('#companyid').val()};

    $('.messageDiv').hide();
    var tbl = $(elementObj).closest('table');

    $(".txt_quantity").each(function()
    {
        if ($(this).val() <= 0)
        {
            var $message = 'Quantity is mandatory!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
        }
    });

//     $(".txt_dquantity").each(function () 
//     {  if($(this).val()<= 0)
//           {
//            var $message = 'DeliveryQuantity is mandatory!';
//            fnCmnWarningMessage($message);
//            scrollToMessage();
//            exit();
//           }
//     });
    $(".ddlb_unit").each(function()
    {
        if ($(this).val() <= 0)
        {
            var $message = 'Please Select a Unit!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
        }
    });
    $(".taxtotal").each(function()
    {
        if ($(this).val() === 0)
        {
            var $message = 'Tax amount is mandatory!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
        }
    });

    if (document.getElementById('selStkPrdList').value == '0')
    {
        fnCmnWarningMessage('Please Select Product!');
        scrollToMessage();
        return false;
    }


    if (tbl.find('input[name~="podate"]').val().trim()=='') {
        fnCmnWarningMessage('Order date is mandatory!');
        scrollToMessage();
        return false;

    }
    if (tbl.find('input[name~="expdeliverdate"]').val().trim()=='') {
        fnCmnWarningMessage('Delivery date is mandatory!');
        scrollToMessage();
        return false;
    }

    if (tbl.find('textarea[name~="description"]').val().trim()=='') {
        fnCmnWarningMessage('Order detail is mandatory!');
        scrollToMessage();
        return false;
    }
    if (tbl.find('select[name~="transport"]').val()=='') {
        fnCmnWarningMessage('Transporter is mandatory!');
        scrollToMessage();
        return false;
    }
    if (tbl.find('select[name~="transmode"]').val()=='') {
        fnCmnWarningMessage('Mode of transport is mandatory!');
        scrollToMessage();
        return false;
    }

    if (tbl.find('input[name~="trcost"]').val().trim()=='') {
        fnCmnWarningMessage('Transport cost is mandatory!');
        scrollToMessage();
        return false;
    }
    if (tbl.find('select[name~="postatus"]').val()=='') {
        fnCmnWarningMessage('Status is mandatory!');
        scrollToMessage();
        return false;
    }
    if (tbl.find('select[name~="purby"]').val()=='') {
        fnCmnWarningMessage('Please select purchase by!');
        scrollToMessage();
        return false;
    }
    if (tbl.find('select[name~="selpayMode"]').val()=='') {
        fnCmnWarningMessage('Mode of payment is mandatory!');
        scrollToMessage();
        return false;
    }
    
//    if (tbl.find('input[name~="amount"]').val().trim()=='') {
//        fnCmnWarningMessage('Enter amount!');
//        scrollToMessage();
//        return false;
//    }


    var formData = $('form#PODETAILS').serializeObject();
    var dataString = JSON.stringify($.extend(formData, supid, comid));
    startLoading();

    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {
                $('.messageDiv').show();
                $('#purchase_order_details').empty();
                fnCmnSuccessMessage(result.message);
                scrollToMessage();
            }
            else
            {
                $('.messageDiv').show();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
//                     $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
//                     $('.message').append('<span>Error: </span>' + result.message);

            }
            stopLoading();
        },
        error: function() {
            alert('Error in Class file or Controller:');
        }
    });
}

function UpdatePODetails(url, elementObj)
{
    var supid = {supid: $('#supplierid').val()};
    var comid = {comid: $('#comid').val()};
    var poid = {poid: $('#poid').val()};

    var tbl = $(elementObj).closest('table');

    $(".txt_quantity").each(function()
    {
        if ($(this).val() <= 0)
        {
            var $message = 'Quantity is mandatory!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
        }
    });

    $(".txt_dquantity").each(function()
    {
        if ($(this).val() <= 0)
        {
            var $message = 'DeliveryQuantity is mandatory!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
        }
    });
    $(".ddlb_unit").each(function()
    {
        if ($(this).val() <= 0)
        {
            var $message = 'Please Select a Unit!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
        }
    });
    $(".taxtotal").each(function()
    {
        if ($(this).val() === 0)
        {
            alert('test');
            var $message = 'Tax amount is mandatory!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
        }
    });

    if (tbl.find('input[name~="podate"]').val().trim()=='') {
        fnCmnWarningMessage('Order date is mandatory!');
        scrollToMessage();
        return false;

    }
    if (tbl.find('input[name~="expdeliverdate"]').val().trim()=='') {
        fnCmnWarningMessage('Delivery date is mandatory!');
        scrollToMessage();
        return false;
    }

    if (tbl.find('textarea[name~="description"]').val().trim()=='') {
        fnCmnWarningMessage('Order detail is mandatory!');
        scrollToMessage();
        return false;
    }
    if (tbl.find('select[name~="transport"]').val().trim()=='') {
        fnCmnWarningMessage('Transporter is mandatory!');
        scrollToMessage();
        return false;
    }
    if (tbl.find('select[name~="transmode"]').val().trim()=='') {
        fnCmnWarningMessage('Mode of transport is mandatory!');
        scrollToMessage();
        return false;
    }

    if (tbl.find('input[name~="trcost"]').val().trim()=='') {
        fnCmnWarningMessage('Transport cost is mandatory!');
        scrollToMessage();
        return false;
    }
    
    if (tbl.find('select[name~="purby"]').val().trim()=='') {
        fnCmnWarningMessage('Please select purchase by!');
        scrollToMessage();
        return false;
    }
//    if (tbl.find('select[name~="selpayMode"]').val().trim()=='') {
//        fnCmnWarningMessage('Mode of payment is mandatory!');
//        scrollToMessage();
//        return false;
//    }
//    if (tbl.find('input[name~="paydate"]').val().trim()=='') {
//        fnCmnWarningMessage('Select payment date!');
//        scrollToMessage();
//        return false;
//    }
//    if (tbl.find('input[name~="amount"]').val().trim()=='') {
//        fnCmnWarningMessage('Enter amount!');
//        scrollToMessage();
//        return false;
//    }

    $('.messageDiv').hide();
    var formData = $('form#frmPurchaseDetails').serializeObject();
    var dataString = JSON.stringify($.extend(formData, supid, comid, poid));
    startLoading();

    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {
                $('.messageDiv').show();
                $('#EditPurchase').empty();
                $('#divPurchaseOrderDetailsList').empty().append(result.html);
                paginationTbl();
                fnCmnSuccessMessage(result.message);
                scrollToMessage();
            }
            else
            {
                $('.messageDiv').hide();
                scrollToMessage();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
        }
    });
}


function UpdatePurchaseQuantityDetails(url, elementObj)
{
    var supid = {supid: $('#supplierid').val()};
    var comid = {comid: $('#comid').val()};
    var poid = {poid: $('#poid').val()};

    var tbl = $(elementObj).closest('table');
    $(".txt_dquantity").each(function()
    {
        if ($(this).val() <= 0)
        {
            var $message = 'DeliveryQuantity is mandatory!';
            fnCmnWarningMessage($message);
            scrollToMessage();
            exit();
        }
    });
    $('.messageDiv').hide();
    var formData = $('form#frmPurchaseDetails').serializeObject();
    var dataString = JSON.stringify($.extend(formData, supid, comid, poid));
    startLoading();

    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {
                $('.messageDiv').show();
                $('#EditPurchase').empty();
                $('#divPurchaseOrderDetailsList').empty().append(result.html);
                paginationTbl();
                fnCmnSuccessMessage(result.message);
                scrollToMessage();
            }
            else
            {
                $('.messageDiv').show();
                scrollToMessage();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
        }
    });
}








function ApprovePODetails(url)
{
    if (confirm('Are you sure! You want to appoved purchase order details?'))
    {
        var poid = {poid: $('#poid').val()};
        $('.messageDiv').hide();
        var formData = $('form#frmPurchaseDetails').serializeObject();
        var dataString = JSON.stringify($.extend(formData, poid));
        startLoading();

        $.ajax({
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function(result) {
                if (result.jsonData == 'AD') {
                    AccessDenied(result.html);
                    return;
                }
                if (result.success)
                {
                    $('.messageDiv').show();
                    fnCmnSuccessMessage(result.message);
                    $('#approvedetails').empty();
                    $('#display-list').empty().append(result.html);
                    paginationTbl();
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
            error: function() {
                fnCmnWarningMessage('Error in Class file or Controller:');
            }
        });
    }
    else {
        return false;
    }
}

function CancelPODetails(url, elementObj)
{
    if (confirm('Are you sure! You want to cancel purchase order?'))
    {
        var poid = {poid: $('#poid').val()};
        var tbl = $(elementObj).closest('table');
        if (tbl.find('textarea[name~="description"]').val().trim()=='') {
            commonMessageAlert('Cancel order description is mandatory!');
            scrollToMessage();
            return false;

        }

        $('.messageDiv').hide();
        var formData = $('form#frmPurchaseDetails').serializeObject();
        var dataString = JSON.stringify($.extend(formData, poid));
        startLoading();
        $.ajax({
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType: 'json',
            success: function(result) {
                if (result.jsonData == 'AD') {
                    AccessDenied(result.html);
                    return;
                }
                if (result.success)
                {
                    $('.messageDiv').show();
                    $('#EditPurchase').empty();
                    $('#display-list').empty().append(result.html);
                    fnCmnSuccessMessage(result.message);
                    scrollToMessage();
                    paginationTbl();
                }
                else
                {
                    $('.messageDiv').show();
                    $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                    $('.message').append('<span>Error: </span>' + result.message);
                }
                stopLoading();
            },
            error: function() {
                fnCmnWarningMessage('Error in Class file or Controller:');
            }
        });
    } else
    {
        return false;
    }
}

function loadEditPurPage(potxn)
{
    var selValue = $('#TYPEID' + potxn).val();

    if (selValue == '') {
        return;
    }
    var url = selValue.split('&')[0];
    var action = selValue.split('&')[1];
    startLoading();
    var addData = {'poid': potxn};


    var dataString = JSON.stringify(addData);

    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success) {
                if (action == 'edit') {

                    var id = result.jsonData;

                    lmsShowHideAddressResult('SearchPurchaseOrder');
                    $('#approvedetails').empty().append(result.html);

                    $('#transporter').val(result.jsonData.t);
                    $('#modetransport').val(result.jsonData.tm);
                    $('#status').val(result.jsonData.st);
                    $('#selpayMode').val(result.jsonData.pay);
                    $('#purby').val(result.jsonData.eid);
                    $('#amount').val(result.jsonData.rs);
                    $('#transcost').val(result.jsonData.cost);

                    var pay = result.jsonData.pay;
                    if (pay == '1')
                    {
                        var y = 0;
                    }
                    else
                    {
                        var y = 1;
                    }
                    // alert(pay+'&'+y);
                    $('#selpayMode').val(pay + '&' + y);

                    // var count  = id.length;
                    var myStringArray = id;
                    var arrayLength = myStringArray.length;
                    for (var i = 0; i < arrayLength; i++) {
                        //alert(myStringArray[i]);
                        var va = myStringArray[i];
                        alert(va);
                        // $('#unit').val(va);
                    }
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
            else {
                fnCmnWarningMessage(result.message);
                stopLoading();
                scrollToMessage();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            stopLoading();
            scrollToMessage();
        }
    });
}

function loadFromSearchPurPage(potxn)
{
    var selValue = $('#TYPEID' + potxn).val();

    if (selValue == '') {
        return;
    }
    startLoading();
    var url = selValue.split('&')[0];
    var action = selValue.split('&')[1];

    var addData = {'poid': potxn};


    var dataString = JSON.stringify(addData);

    $.ajax({
        type: 'POST',
        url: url,
        contentType: 'application/json',
        data: dataString,
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success) {
                if (action == 'update') {
                     $('.messageDiv').hide();
                    var id = result.jsonData;
                    lmsShowHideAddressResult('SearchPurchaseOrder');
                     $('.messageDiv').hide();
                     $('#EditPurchase').empty().append(result.html);
                } else
                if (action == 'view') {
                    var id = result.jsonData;
                    lmsShowHideAddressResult('SearchPurchaseOrder');
                    $('#EditPurchase').empty().append(result.html);
                }
                else
                if (action == 'edit') {

                    var id = result.jsonData;
                     $('.messageDiv').hide();
                    lmsShowHideAddressResult('SearchPurchaseOrder');
                    $('#EditPurchase').empty().append(result.html);

                    $('#transporter').val(result.jsonData.t);
                    $('#modetransport').val(result.jsonData.tm);
                    $('#status').val(result.jsonData.st);

                    // $('#selpayMode').val(result.jsonData.pay)&0;
                    $('#purby').val(result.jsonData.eid);
                    $('#amount').val(result.jsonData.rs);
                    $('#transcost').val(result.jsonData.cost);

                    var pay = result.jsonData.pay;
                    if (pay == '1')
                    {
                        var y = 0;
                    }
                    else
                    {
                        var y = 1;
                    }
                    // alert(pay+'&'+y);
                    $('#selpayMode').val(pay + '&' + y);

                    // var count  = id.length;
                    var myStringArray = id;
                    var arrayLength = myStringArray.length;
                    for (var i = 0; i < arrayLength; i++) {
                        //alert(myStringArray[i]);
                        var va = myStringArray[i];
                        
                        // $('#unit').val(va);
                    }
                }
                else if (action == 'cancel') {
                    lmsShowHideAddressResult('SearchPurchaseOrder');
                    $('#EditPurchase').empty().append(result.html);
                    $('#cancelpo').show();
                    $('#approveid').hide();
                    $('.messageDiv').hide();
                }
                stopLoading();
            }
            else {
                fnCmnWarningMessage(result.message);
                stopLoading();
                scrollToMessage();
            }
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has encountered. Please try later.');
            stopLoading();
            scrollToMessage();
        }
    });
}

function SearchCriteria(selid) {

    var sel = document.getElementById(selid);
    $('#trcriteria').show();
    $('#selProjCategory').hide();
    $('#txtCriteria').hide();
    $('#txtdate').hide();
    $('#divDate').hide();
    $('#selProjStatus').hide();
    //$('#tbodyDynamic').empty();
    $('#tdtitle').text('Criteria');
    switch (sel.value) {
        case 'all':
            $('#trcriteria').hide();
            break;
        case 'ordno':
            document.getElementById('txtCriteria').placeholder = 'Enter Purchase Order Number';
            $('#txtCriteria').show();
            $('#Date').hide();
            $('#selPurStatus').hide();
            break;
        case 'sname':
            document.getElementById('txtCriteria').placeholder = 'Enter Vendor Name';
            $('#txtCriteria').show();
            break;

        case 'podate':
            $('#Date').show();
            break;
        case 'expdate':
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



function SearchPurchase() {
    $('.messageDiv').hide();

    var x = document.getElementById("selSearchPurchaseOrder").value;
    if (x == 0)
    {
        fnCmnWarningMessage('Please Select Search Criteria!');
        scrollToMessage();
        return false;
    }
    switch ($('#selSearchPurchaseOrder').val()) {
        case 'ordno':
            if ($('#txtCriteria').val().trim() == '') {
                fnCmnWarningMessage('Enter Purchase Order Number!!!');
                $('#txtCriteria').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'date':
            if ($('#date').val().trim()=='') {
                fnCmnWarningMessage('Please select date!!!');
                $('#date').focus();
                scrollToMessage();
                return;
            }
            break;
        case 'status':
            if ($('#selPurStatus').val().trim()=='') {
                fnCmnWarningMessage('Select Purchase Order Status!!!');
                $('#selPurStatus').focus();
                scrollToMessage();
                return;
            }
            break;
    }

    var sdate = new Date($('#txtfrom').val());
    var cdate = new Date($('#todate').val());
    if (sdate > cdate) {
        fnCmnWarningMessage('Date From cannot be greater than to Date!!!');
        $('#todate').focus();
        scrollToMessage();
        return;
    }


    startLoading();
    var url = $('#inputsearchpurchaseUrl').val();
    var frmData = $('form#frmPurchaseDetails').serializeObject();
    var dataString = JSON.stringify(frmData);
    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success) {
                stopLoading();
                $('#divPurchaseOrderDetailsList').empty().append(result.html);
                $('#EditPurchase').empty();
                paginationTbl();
//                 $('.messageDiv').show();  
//                fnCmnSuccessMessage(result.message);
//                scrollToMessage();
            }
            else {
                $('#divPurchaseOrderDetailsList').empty();
                $('#EditPurchase').empty();
                stopLoading();
                fnCmnWarningMessage(result.message);
                scrollToMessage();
            }
        },
        error: function() {
            stopLoading();
            fnCmnWarningMessage('An unknown technical error was encountered. Please try later');
            scrollToMessage();
        }
    });
}
function ModeChange(url, selectbox) {

    var ispayreqd = selectbox.value.split('&')[1];
    var pkid = selectbox.value.split('&')[0];
    $('#txt_id').val(pkid);
    if (ispayreqd == 1) {

        $('#paymentno').attr('disabled', false);
        $('#bankname').attr('disabled', false);
    } else if (ispayreqd == 0) {
        $('#bankname').attr('disabled', true);
        $('#bankname').val('');
        $('#paymentno').attr('disabled', true);
        $('#paymentno').val('');
    }
    var addData = {'pkid': pkid};
    var frmData = $('form#POsearch').serializeObject();
    var dataString = JSON.stringify($.extend(frmData, addData));
    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: dataString,
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {
                $('#showdetailpayment').empty().append(result.html);
                $('#balance').empty();
            }
            else
            {
                $('.messageDiv').show();
                $('.message').empty().addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('Error in Class file or Controller:');
        }
    });






}

//function EmployeeWallet(selectest){
//    
//    var empwallet=selectest.value;
//    //alert(empwallet);
//    $('#txt_empwalletno').val(empwallet);
////    var addData={'empid': empwallet};
////    var dataString = JSON.stringify(addData);
////    startLoading();
////    $.ajax({            
////            type: 'POST',
////            url: url,
////            data: dataString,
////            contentType: 'application/json',
////            dataType: 'json',
////            success: function (result){ 
////               if(result.success)
////               {  
////                 //$('#walletdisplay').empty().append(result.html);
////                 
////               }
////                else
////                {
////                     $('.messageDiv').show();                       
////                     $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
////                     $('.message').append('<span>Error: </span>' + result.message);
////                }
////                stopLoading();
////           },
////            error: function(){ alert('Error in Class file or Controller:');}
////        }); 
//     
//     
//}

function DisplayDetails(url)
{

    $('.messageDiv').hide();
    var formData = $('form#PO_details').serializeObject();
    var dataString = JSON.stringify(formData);
    startLoading();

    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {

                lmsShowHideAddressResult('CreatePurchaseOrder');
                $('#showpodetails').empty().append(result.html);
            }
            else
            {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('Error in Class file or Controller:');
        }
    });
}

function removeall()
{
    // $('#resulttab').hide();
    // $('#result_po').hide;
    $('#quotedprice').val('0');
    $('#grand').val('0');
    $('#tax').val('0');

}


function SearchBySupplierName(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    if (document.getElementById('TYPEID').value == '0')
    {
        fnCmnWarningMessage('Please select supplier first!');
        scrollToMessage();
        return false;
    }
    $('.messageDiv').hide();
    var formData = $('form#PurchasePayment').serializeObject();
    var dataString = JSON.stringify(formData);
    //startLoading();

    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {
                //$('#PaymentDetails').empty().append(result.html);
                $('#display-list').empty().append(result.html);
                paginationTbl();
            }
            else
            {
                $('#display-list').empty();
                fnCmnWarningMessage(result.message);
                $('.messageDiv').show();
                //$('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
               // $('.message').append('<span>Error: </span>' + result.message);
            }
            //stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('Error in Class file or Controller:');
        }
    });
}






function PurchasePaymentDetails(url, elementObj)
{
    var tbl = $(elementObj).closest('table');
    if (tbl.find('select[name~="selpayMode"]').val().trim()=='') {
        fnCmnWarningMessage('Please select mode of payment!');
        scrollToMessage();
        return false;
    }
    if (tbl.find('select[name~="selpayMode"]').val() == 1) 
    {
    } else
    {
        if (tbl.find('select[name~="selectlist"]').val()=='') {
            fnCmnWarningMessage('Please select bank name!');
            scrollToMessage();
            return false;
        }
        
    }
    if (tbl.find('input[name~="pay"]').val() == 1) {
    }
    else
        {
            if (tbl.find('input[name~="paymentno"]').val() == '') {
                fnCmnWarningMessage('Cheque/Transaction/DD no is mandatory!');
                scrollToMessage();
                return false;
            }
        }

    if (tbl.find('input[name~="paydate"]').val().trim()=='') {
        fnCmnWarningMessage('Payment date is mandatory!');
        scrollToMessage();
        return false;
    }
    if (tbl.find('input[name~="amount"]').val().trim()=='') {
        fnCmnWarningMessage('Amount is mandatory!');
        scrollToMessage();
        return false;
    }
    if (tbl.find('textarea[name~="remarks"]').val().trim()=='') {
        fnCmnWarningMessage('Remark is mandatory!');
        scrollToMessage();
        return false;
    }
    if (isNaN(tbl.find('input[name~="amount"]').val())) {
        fnCmnWarningMessage("Enter a valid amount");
        scrollToMessage();
        return false;
    }


    $('.messageDiv').hide();
    var tbl = $(elementObj).closest('table');

    var formData = $('form#PurchasePayment').serializeObject();
    var dataString = JSON.stringify(formData);
     
    startLoading();

    $.ajax({
        type: 'POST',
        url: url,
        data: dataString,
        contentType: 'application/json',
        dataType: 'json',
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {
                $('.messageDiv').show();
                fnCmnSuccessMessage(result.message);
                //alert(result.html);
                $('#display-list').empty().append(result.html);
                $('#PaymentDetails').empty().append(result.secondHtml);
                paginationTbl();
                scrollToMessage();
            }
            else
            {
                $('.messageDiv').show();
                $('.message').empty().removeClass('warning').addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
                stopLoading();
                scrollToMessage();
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('Error in Class file or Controller:');
        }
    });
}

function DisplayBankPaymentBalance(url, selectbox) {
    var pkid = selectbox.value;
    var addData = {'pkid': pkid};
    var frmData = $('form#POsearch').serializeObject();
    var dataString = JSON.stringify($.extend(frmData, addData));

    $('.messageDiv').hide();
    startLoading();
    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data: dataString,
        success: function(result) {
            if (result.jsonData == 'AD') {
                AccessDenied(result.html);
                return;
            }
            if (result.success)
            {
                $('#balance').empty().append(result.html);
            }
            else
            {
                $('.messageDiv').show();
                $('.message').empty().addClass('alert-box').addClass('error-box');
                $('.message').append('<span>Error: </span>' + result.message);
            }
            stopLoading();
        },
        error: function() {
            fnCmnWarningMessage('Error in Class file or Controller:');
        }
    });
}


//created by sanatomba



