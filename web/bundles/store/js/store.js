/* 
 * Javascritp for store master
 */
/**********This javascript section is mainly for Saving store Master Record Entry 
           twig file->(.html.twig,.html)********************/



function saveStoreMaster(url,elementObj)
{  
    var tbl = $(elementObj).closest('table'); 
    var storename = tbl.find('input[name~="storename"]');
    var storedes = tbl.find('input[name~="storedescription"]');
      if(storename.val().trim()==''){
        storename.focus();
        commonMessageAlert('Store Name Field can\'t be empty !');
        return false;
    } 
    if(storedes.val().trim()==''){
        storedes.focus();
        commonMessageAlert('store Description Field can\'t be empty !');
        return false;
    } 
     
     
    $('.messageDiv').hide(); 
    var formData = $('form#frmAddStore').serializeObject();
    var dataString = JSON.stringify(formData); 
    //alert(dataString);
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                       fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                    $('#storename').prop('disabled', true).addClass('disable_bg');
                    $('#storedescription').prop('disabled', true).addClass('disable_bg');
                    $('#storeregistrationno').prop('disabled', true).addClass('disable_bg');
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_cancel').show();
                }
                else{
                    fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading(); stopLoading();}
        });   
}


function updateStoreMaster(elementObj)
{
    
    var tbl = $(elementObj).closest('table');  
    var storename = tbl.find('input[name~="storename"]');
    var storedes = tbl.find('input[name~="storedescription"]');
      if(storename.val().trim()==''){
        storename.focus();
        commonMessageAlert('Store Name Field can\'t be empty !');
        return false;
    } 
    if(storedes.val().trim()==''){
        storedes.focus();
        commonMessageAlert('Store Description Field can\'t be empty !');
        return false;
    } 
    
    $('.messageDiv').hide();
    
   
    var formData = $('form#frmAddStore').serializeObject();
    var dataString = JSON.stringify(formData);
    var url=$('#addStoreUpdateURL').val();
     startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                    $('#storename').prop('disabled', true).addClass('disable_bg');
                    $('#storedescription').prop('disabled', true).addClass('disable_bg');
                    $('#storeregistrationno').prop('disabled', true).addClass('disable_bg');
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_update').hide();              
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}



function retriveStoreMaster(url)
 {
    
    $('.messageDiv').hide();  
     startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            success: function (result){ 
               if(result.success){                    
                    $('#storename').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.storename);
                    $('#storedescription').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.storedescription);
                    $('#addStoreUpdateURL').val('/Tashi/web/app_dev.php/Store/update_addStore/'+result.jsonData.Stid);
                    //for hide show buttons and diables                   
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();   
                    $('#btn_edit').hide();  
                    $('#btn_update').show();                         
                    $('#btn_cancel').show(); 
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}


function deleteAddStoreMaster(url)
{  
    $('.messageDiv').hide();  
    if(!confirm('Are you sure want to delete the selected Store?'))
        return;
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            //data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                     $('#storename').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#storedescription').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#btn_save').show(); 
                    $('#btn_clear').show();   
                    $('#btn_edit').hide();  
                    $('#btn_update').hide();                         
                    $('#btn_cancel').hide(); 
                                      
                    
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}



/**********This javascript section is mainly for Saving store building Master Record Entry 
           twig file->(.html.twig,.html)********************/



function saveStoreBuildingMaster(url,elementObj)
{      
    var tbl = $(elementObj).closest('table');
    var building = tbl.find('input[name~="buildingname"]');
    var add1 = tbl.find('textarea[name~="address1"]');
    var add2 = tbl.find('textarea[name~="address2"]');
    var zip = tbl.find('input[name~="zipcode"]');
    if (tbl.find('select[name~="storename"]').val().trim()=='') {
        commonMessageAlert('Please Select Store Name !');
        return false;
    }
    if(building.val().trim()==''){
        building.focus();
        commonMessageAlert('Please Enter The Building Name !');
        return false;
    }
    if(add1.val().trim()==''){
        add1.focus();
        commonMessageAlert('Address Field can\'t be empty !');
        return false;
    }
//    if(add2.val().trim()==''){
//        add2.focus();
//        commonMessageAlert('Address Field can\'t be empty !');
//        return false;
//    } 
          if(tbl.find('select[name~="txt_country"]').val().trim()==''){
        commonMessageAlert('Please Select Country !');
        return false;
    } 
              if(tbl.find('select[name~="txt_state"]').val().trim()==''){
        commonMessageAlert('Please Select State !');
        return false;
    }
          if(tbl.find('select[name~="txt_district"]').val().trim()==''){
        commonMessageAlert('Please Select District  !');
        return false;
    } 
          if(tbl.find('select[name~="txt_city"]').val().trim()==''){
        commonMessageAlert('Please Select city !');
        return false;
    } 
    
    if(zip.val().trim()==''){
        zip.focus();
        commonMessageAlert('Zip Code Field can\'t be empty !');
        return false;
    }
     
    $('.messageDiv').hide(); 
    var formData = $('form#frmAddStoreBuilding').serializeObject();
    var dataString = JSON.stringify(formData); 
    //alert(dataString);
    startLoading();
    
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                $('#storename').prop('disabled', true).addClass('disable_bg');
                $('#buildingname').prop('disabled', true).addClass('disable_bg');
                $('#address1').prop('disabled', true).addClass('disable_bg');
                $('#address2').prop('disabled', true).addClass('disable_bg');
                $('#country').prop('disabled', true).addClass('disable_bg');
                $('#state').prop('disabled', true).addClass('disable_bg');
                
                $('#district').prop('disabled', true).addClass('disable_bg');
                
                $('#city').prop('disabled', true).addClass('disable_bg');
                $('#zipcode').prop('disabled', true).addClass('disable_bg');
                $('#btn_save').hide();
                $('#btn_clear').hide();
                $('#btn_edit').show();
                $('#btn_cancel').show();
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}


function updateStoreBuildingMaster(elementObj){
    
    var tbl = $(elementObj).closest('table');
    if (tbl.find('select[name~="storename"]').val().trim()=='') {
        commonMessageAlert('Please Select Store Name !');
        return false;
    }
    if (tbl.find('input[name~="buildingname"]').val().trim()=='') {
        commonMessageAlert('Please Enter The Building Name !');
        return false;
    }
    
    
    if (tbl.find('textarea[name~="address1"]').val().trim()=='') {
        commonMessageAlert('Address Field can\'t be empty !');
        return false;
    }
    
//          if(tbl.find('textarea[name~="address2"]').val().trim()==''){
//        commonMessageAlert('Address Field can\'t be empty !');
//        return false;
//    } 
          if(tbl.find('select[name~="txt_country"]').val().trim()==''){
        commonMessageAlert('Please Select Country !');
        return false;
    } 
              if(tbl.find('select[name~="txt_state"]').val().trim()==''){
        commonMessageAlert('Please Select State !');
        return false;
    }
          if(tbl.find('select[name~="txt_district"]').val().trim()==''){
        commonMessageAlert('Please Select District  !');
        return false;
    } 
          if(tbl.find('select[name~="txt_city"]').val().trim()==''){
        commonMessageAlert('Please Select city !');
        return false;
    } 
          if(tbl.find('input[name~="zipcode"]').val().trim()==''){
        commonMessageAlert('Zip Code Field can\'t be empty !');
        return false;
    } 
    
    $('.messageDiv').hide();
    
   
    var formData = $('form#frmAddStoreBuilding').serializeObject();
    var dataString = JSON.stringify(formData);
    var url=$('#addStorebuildingUpdateURL').val();
     startLoading();
     
     
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                    $('#storename').prop('disabled', true).addClass('disable_bg');
                $('#buildingname').prop('disabled', true).addClass('disable_bg');
                $('#address1').prop('disabled', true).addClass('disable_bg');
                $('#address2').prop('disabled', true).addClass('disable_bg');
                $('#country').prop('disabled', true).addClass('disable_bg');
                $('#state').prop('disabled', true).addClass('disable_bg');
                $('#district').prop('disabled', true).addClass('disable_bg');
                $('#city').prop('disabled', true).addClass('disable_bg');
                $('#zipcode').prop('disabled', true).addClass('disable_bg');
                   
                   
                    
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_update').hide();
                                      
                    
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}



function retreiveStoreBuilding(url)
 { //alert(url);
    
    $('.messageDiv').hide();  
     startLoading();
     
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            success: function (result){ 
               if(result.success){       
                   //alert(result.jsonData.storenameId);
                    $('#storename').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.storenameId);
                    $('#buildingname').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.buildingname);
                     $('#address1').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.storeaddressId);
                     $('#address2').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.storeaddress2Id);
                     $('#country').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.countryID);
                     var stateIdArr=result.jsonData.stateIdArr;
                     var stateNameArr=result.jsonData.stateNameArr;
                     var stateSelectBox=document.getElementById('state');
                     stateSelectBox.options.length=0;
                     stateSelectBox.options[stateSelectBox.options.length]=new Option('--Select--','');
                        for(var i=0;i<stateIdArr.length;i++){
                             stateSelectBox.options[stateSelectBox.options.length] = new Option(stateNameArr[i], stateIdArr[i]);
                         }
                    $('#state').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.stateID);
                    var districtIdArr=result.jsonData.districtIdArr;
                var districtNameArr=result.jsonData.districtNameArr;
                var districtSelectBox=document.getElementById('district');
                districtSelectBox.options.length=0;
                districtSelectBox.options[districtSelectBox.options.length]=new Option('--Select--','');
                for(var i=0;i<districtIdArr.length;i++){
                   districtSelectBox.options[districtSelectBox.options.length] = new Option(districtNameArr[i], districtIdArr[i]);
                }
                     $('#district').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.districtID);
                     
                    var cityIdArr=result.jsonData.cityIdArr;
                var cityNameArr=result.jsonData.cityNameArr;
                var citySelectBox=document.getElementById('city');
                citySelectBox.options.length=0;
                citySelectBox.options[citySelectBox.options.length]=new Option('--Select--','');
                for(var i=0;i<cityIdArr.length;i++){
                   citySelectBox.options[citySelectBox.options.length] = new Option(cityNameArr[i], cityIdArr[i]);
                }
                     $('#city').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.cityID);
                   //  $('#ddlb_address_list').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.addressType);
                     $('#zipcode').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.pin);
                    $('#addStorebuildingUpdateURL').val('/Tashi/web/app_dev.php/Store/update_addStoreBuilding/'+result.jsonData.StBid);
                    //for hide show buttons and diables                   
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();   
                    $('#btn_edit').hide();  
                    $('#btn_update').show();                         
                    $('#btn_cancel').show(); 
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}

function deleteStoreBuildingMaster(url)
{  
    $('.messageDiv').hide();  
    if(!confirm('Are you sure you want to delete the selected Building Name?'))
        return;
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            //data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                     $('#storename').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#buildingname').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#address1').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#address2').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#country').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#state').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#district').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#city').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#zipcode').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#btn_save').show(); 
                    $('#btn_clear').show();   
                    $('#btn_edit').hide();  
                    $('#btn_update').hide();                         
                    $('#btn_cancel').hide(); 
                                      
                    
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}

/**********This javascript section is mainly for Saving store floor Master Record Entry 
           twig file->(.html.twig,.html)********************/



function saveStoreFloorMaster(url,elementObj)
{  
    var tbl = $(elementObj).closest('table'); 
    var Floor = tbl.find('input[name~="floorno"]');
    if(tbl.find('select[name~="storename"]').val().trim()==''){
        commonMessageAlert('Please Select Store Name!');
        return false;
    } 
    if(tbl.find('select[name~="buildingname"]').val().trim()==''){
        commonMessageAlert('Please Select Building Name!');
        return false;
    } 
    if (Floor.val().trim()=='') {
        Floor.focus();
        commonMessageAlert('Floor No. Field can\'t be empty !');
        return false;
    }
     
    $('.messageDiv').hide(); 
    var formData = $('form#frmAddStoreFloor').serializeObject();
    var dataString = JSON.stringify(formData); 
    //alert(dataString);
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
//                if (result.success) {
//                switch (result.jsonData.codeFlag) {
//                    case 0 :
//                        $('#display-list').empty().append(result.html);
//                        paginationTbl(); //for pagination
//                        fnCmnSuccessMessage(result.message);
//                        break;
//                    case 1 :
//                        fnCmnWarningMessage(result.message);
//                        break;
//                }
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                    $('#storename').prop('disabled', true).addClass('disable_bg');
                    $('#buildingname').prop('disabled', true).addClass('disable_bg');
                    $('#floorno').prop('disabled', true).addClass('disable_bg');
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_cancel').show();
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}


function updateStoreFloorMaster(elementObj){
    
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="storename"]').val().trim()==''){
        commonMessageAlert('Please Select Store Name!');
        return false;
    } 
    if(tbl.find('select[name~="buildingname"]').val().trim()==''){
        commonMessageAlert('Please SelectBuilding Name !');
        return false;
    } 
      if(tbl.find('input[name~="floorno"]').val().trim()==''){
        commonMessageAlert('Floor No. Field can\'t be empty !');
        return false;
    } 
    
    $('.messageDiv').hide();
    
   
    var formData = $('form#frmAddStoreFloor').serializeObject();
    var dataString = JSON.stringify(formData);
    var url=$('#addStoreFloorUpdateURL').val();
     startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                     $('#storename').prop('disabled', true).addClass('disable_bg');
                    $('#buildingname').prop('disabled', true).addClass('disable_bg');
                    $('#floorno').prop('disabled', true).addClass('disable_bg');
                   
                    
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_update').hide();
                                      
                    
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}



function retreiveStoreFloor(url)
 {
    
    $('.messageDiv').hide();  
     startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            success: function (result){ 
               if(result.success){                  
                    $('#storename').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.storenameId);
                     var buildingIdArr=result.jsonData.buildingIdArr;
                var buildingNameArr=result.jsonData.buildingNameArr;
                var buildingSelectBox=document.getElementById('buildingname');
                buildingSelectBox.options.length=0;
                buildingSelectBox.options[buildingSelectBox.options.length]=new Option('--Select--','');
                for(var i=0;i<buildingIdArr.length;i++){
                   buildingSelectBox.options[buildingSelectBox.options.length] = new Option(buildingNameArr[i], buildingIdArr[i]);
                }
                    $('#buildingname').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.buildingnameId);
                     $('#floorno').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.floorno);
                    $('#addStoreFloorUpdateURL').val('/Tashi/web/app_dev.php/Store/update_addStoreFloor/'+result.jsonData.Fid);
                    //for hide show buttons and diables                   
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();   
                    $('#btn_edit').hide();  
                    $('#btn_update').show();                         
                    $('#btn_cancel').show(); 
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}

function deleteStoreFloorMaster(url)
{  
    $('.messageDiv').hide();  
//    var formData = $('form#frmCountryDetails').serializeObject();
//    var dataString = JSON.stringify(formData);
    //var url=$('#locationUpdateURL').val();
    if(!confirm('Are you sure you want to delete the selected Floor No.?'))
        return;
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            //data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                    $('#storename').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#buildingname').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#floorno').prop('disabled', false).removeClass('disable_bg').val('');
                     $('#btn_save').show(); 
                    $('#btn_clear').show();   
                    $('#btn_edit').hide();  
                    $('#btn_update').hide();                         
                    $('#btn_cancel').hide(); 
                                      
                    
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}


////// store room



/**********This javascript section is mainly for Saving store Room Master Record Entry 
           twig file->(.html.twig,.html)********************/



function saveStoreRoomMaster(url,elementObj)
{  
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="storename"]').val().trim()==''){
        commonMessageAlert('Please Select Store Name !');
        return false;
    } 
    if(tbl.find('select[name~="buildingname"]').val().trim()==''){
        commonMessageAlert('Please Select Building Name!');
        return false;
    } 
      if(tbl.find('select[name~="floorno"]').val().trim()==''){
        commonMessageAlert('Please Select Floor No. !');
        return false;
    } 
     if(tbl.find('input[name~="roomno"]').val().trim()==''){
        commonMessageAlert('Room No. Field can\'t be empty !');
        return false;
    } 
     
    $('.messageDiv').hide(); 
    var formData = $('form#frmAddStoreRoom').serializeObject();
    var dataString = JSON.stringify(formData); 
    //alert(dataString);
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
//                 if (result.success) {
//                switch (result.jsonData.codeFlag) {
//                    case 0 :
//                        $('#display-list').empty().append(result.html);
//                        paginationTbl(); //for pagination
//                        fnCmnSuccessMessage(result.message);
//                        break;
//                    case 1 :
//                        fnCmnWarningMessage(result.message);
//                        break;
//                }
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                    $('#storename').prop('disabled', true).addClass('disable_bg');
                    $('#buildingname').prop('disabled', true).addClass('disable_bg');
                    $('#floorno').prop('disabled', true).addClass('disable_bg');
                    $('#roomno').prop('disabled', true).addClass('disable_bg');
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_cancel').show();
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}


function updateStoreRoomMaster(elementObj){
    
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="storename"]').val().trim()==''){
        commonMessageAlert('Please Select Store Name  !');
        return false;
    } 
    if(tbl.find('select[name~="buildingname"]').val().trim()==''){
        commonMessageAlert('Please Select Building Name  !');
        return false;
    } 
      if(tbl.find('select[name~="floorno"]').val().trim()==''){
        commonMessageAlert('Please Select Floor No. !');
        return false;
    } 
     if(tbl.find('input[name~="roomno"]').val().trim()==''){
        commonMessageAlert('Room No. Field can\'t be empty !');
        return false;
    } 
     
    
    $('.messageDiv').hide();
    
   
    var formData = $('form#frmAddStoreRoom').serializeObject();
    var dataString = JSON.stringify(formData);
    var url=$('#addStoreRoomUpdateURL').val();
     startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                     $('#storename').prop('disabled', true).addClass('disable_bg');
                    $('#buildingname').prop('disabled', true).addClass('disable_bg');
                    $('#floorno').prop('disabled', true).addClass('disable_bg');
                    $('#roomno').prop('disabled', true).addClass('disable_bg');
                   
                    
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_update').hide();
                                      
                    
                }
                else{
                    fnCmnErrorMessage(result.message);
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}



function retreiveStoreRoom(url)
 {
    
    $('.messageDiv').hide();  
     startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            success: function (result){ 
               if(result.success){                  
                    $('#storename').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.storenameId);
                     var buildingIdArr=result.jsonData.buildingIdArr;
                var buildingNameArr=result.jsonData.buildingNameArr;
                var buildingSelectBox=document.getElementById('buildingname');
                buildingSelectBox.options.length=0;
                buildingSelectBox.options[buildingSelectBox.options.length]=new Option('--Select--','');
                for(var i=0;i<buildingIdArr.length;i++){
                   buildingSelectBox.options[buildingSelectBox.options.length] = new Option(buildingNameArr[i], buildingIdArr[i]);
                }
                    $('#buildingname').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.buildingnameId);
                    var floorIdArr=result.jsonData.floorIdArr;
                var floorNameArr=result.jsonData.floorNameArr;
                var floorSelectBox=document.getElementById('floorno');
                floorSelectBox.options.length=0;
                floorSelectBox.options[floorSelectBox.options.length]=new Option('--Select--','');
                for(var i=0;i<floorIdArr.length;i++){
                   floorSelectBox.options[floorSelectBox.options.length] = new Option(floorNameArr[i], floorIdArr[i]);
                }
                     $('#floorno').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.floornoId);
                     $('#roomno').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.roomno);
                    $('#addStoreRoomUpdateURL').val('/Tashi/web/app_dev.php/Store/update_addStoreRoom/'+result.jsonData.Rid);
                    //for hide show buttons and diables                   
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();   
                    $('#btn_edit').hide();  
                    $('#btn_update').show();                         
                    $('#btn_cancel').show(); 
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}


function deleteStoreRoomMaster(url)
{  
    $('.messageDiv').hide();  
//    var formData = $('form#frmCountryDetails').serializeObject();
//    var dataString = JSON.stringify(formData);
    //var url=$('#locationUpdateURL').val();
    if(!confirm('Are you sure you want to delete the selected Room No.?'))
        return;
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            //data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                    $('#storename').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#buildingname').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#floorno').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#roomno').prop('disabled', false).removeClass('disable_bg').val('');
                     $('#btn_save').show(); 
                    $('#btn_clear').show();   
                    $('#btn_edit').hide();  
                    $('#btn_update').hide();                         
                    $('#btn_cancel').hide(); 
                                      
                    
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}



////// store rack
//show button and enable input fields on click edit button


/**********This javascript section is mainly for Saving store Rack Master Record Entry 
           twig file->(.html.twig,.html)********************/



function saveStoreRackMaster(url,elementObj)
{  
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="storename"]').val().trim()==''){
        commonMessageAlert('Please Select Store Name  !');
        return false;
    } 
    if(tbl.find('select[name~="buildingname"]').val().trim()==''){
        commonMessageAlert('Please Select Building Name  !');
        return false;
    } 
      if(tbl.find('select[name~="floorno"]').val().trim()==''){
        commonMessageAlert('Please Slect Floor No. Field !');
        return false;
    } 
     if(tbl.find('select[name~="roomno"]').val().trim()==''){
        commonMessageAlert('Please Select Room No. ');
        return false;
    } 
    if(tbl.find('input[name~="rackno"]').val().trim()==''){
        commonMessageAlert('Rack Name Field can\'t be null !');
        return false;
    } 
    if(tbl.find('input[name~="rackrowno"]').val().trim()==''){
        commonMessageAlert('Rack Row No. Field can\'t be null !');
        return false;
    } 
    if(tbl.find('input[name~="rackcolumnno"]').val().trim()==''){
        commonMessageAlert('Rack Column Name Field can\'t be null !');
        return false;
    } 
     
    $('.messageDiv').hide(); 
    var formData = $('form#frmAddStoreRack').serializeObject();
    var dataString = JSON.stringify(formData); 
    //alert(dataString);
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
//                if (result.success) {
//                switch (result.jsonData.codeFlag) {
//                    case 0 :
//                        $('#display-list').empty().append(result.html);
//                        paginationTbl(); //for pagination
//                        fnCmnSuccessMessage(result.message);
//                        break;
//                    case 1 :
//                        fnCmnWarningMessage(result.message);
//                        break;
//                }
                
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                    $('#storename').prop('disabled', true).addClass('disable_bg');
                    $('#buildingname').prop('disabled', true).addClass('disable_bg');
                    $('#floorno').prop('disabled', true).addClass('disable_bg');
                    $('#roomno').prop('disabled', true).addClass('disable_bg');
                    $('#rackno').prop('disabled', true).addClass('disable_bg');
                    $('#rackrowno').prop('disabled', true).addClass('disable_bg');
                    $('#rackcolumnno').prop('disabled', true).addClass('disable_bg');
                   
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_cancel').show();
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}
function saveBin(url,elementObj)
{  
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="storename"]').val().trim()==''){
        commonMessageAlert('Please Select Store Name  !');
        return false;
    } 
    if(tbl.find('select[name~="buildingname"]').val().trim()==''){
        commonMessageAlert('Please Select Building Name  !');
        return false;
    } 
      if(tbl.find('select[name~="floorno"]').val().trim()==''){
        commonMessageAlert('Please Slect Floor No. Field !');
        return false;
    } 
     if(tbl.find('select[name~="roomno"]').val().trim()==''){
        commonMessageAlert('Please Select Room No. ');
        return false;
    } 
    if(tbl.find('select[name~="selRack"]').val().trim()==''){
        commonMessageAlert('Please Select a Rack ');
        return false;
    } 
    if(tbl.find('input[name~="binno"]').val().trim()==''){
        commonMessageAlert('Bin No. is mandatory !');
        return false;
    }     
    $('.messageDiv').hide(); 
    var formData = $('form#frmBin').serializeObject();
    var dataString = JSON.stringify(formData); 
    //alert(dataString);
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){                 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                    $('#storename').prop('disabled', true).addClass('disable_bg');
                    $('#buildingname').prop('disabled', true).addClass('disable_bg');
                    $('#floorno').prop('disabled', true).addClass('disable_bg');
                    $('#roomno').prop('disabled', true).addClass('disable_bg');
                    $('#selRack').prop('disabled', true).addClass('disable_bg');
                    $('#binno').prop('disabled', true).addClass('disable_bg');                   
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_cancel').show();
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}

function updateStoreRackMaster(elementObj){
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="storename"]').val().trim()==''){
        commonMessageAlert('Store Name Field can\'t be null !');
        return false;
    } 
    if(tbl.find('select[name~="buildingname"]').val().trim()==''){
        commonMessageAlert('Building Name Field can\'t be null !');
        return false;
    } 
      if(tbl.find('select[name~="floorno"]').val().trim()==''){
        commonMessageAlert('Floor No. Field can\'t be null !');
        return false;
    } 
     if(tbl.find('select[name~="roomno"]').val().trim()==''){
        commonMessageAlert('Room No. Field can\'t be null !');
        return false;
    } 
    if(tbl.find('input[name~="rackno"]').val().trim()==''){
        commonMessageAlert('Rack Name Field can\'t be null !');
        return false;
    } 
    if(tbl.find('input[name~="rackrowno"]').val().trim()==''){
        commonMessageAlert('Rack Row No. Field can\'t be null !');
        return false;
    } 
    if(tbl.find('input[name~="rackcolumnno"]').val().trim()==''){
        commonMessageAlert('Rack Column Name Field can\'t be null !');
        return false;
    } 
    
    $('.messageDiv').hide();
    
   
    var formData = $('form#frmAddStoreRack').serializeObject();
    var dataString = JSON.stringify(formData);
    var url=$('#addStoreRackUpdateURL').val();
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                   $('#storename').prop('disabled', true).addClass('disable_bg');
                    $('#buildingname').prop('disabled', true).addClass('disable_bg');
                    $('#floorno').prop('disabled', true).addClass('disable_bg');
                    $('#roomno').prop('disabled', true).addClass('disable_bg');
                    $('#rackno').prop('disabled', true).addClass('disable_bg');
                    $('#rackrowno').prop('disabled', true).addClass('disable_bg');
                    $('#rackcolumnno').prop('disabled', true).addClass('disable_bg');
                   
                    
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();
                    $('#btn_edit').show();
                    $('#btn_update').hide();
                                      
                    
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}
function RetrieveBin(url){
    $('.messageDiv').hide();
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#divManageBin').empty().append(result.html);
                }
                else{
                    fnCmnErrorMessage(result.message);
                    scrollToMessage();
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });
}
function updateBin(url,elementObj){
    $('.messageDiv').hide();
    var tbl = $(elementObj).closest('table');  
    if(tbl.find('select[name~="storename"]').val()==''){
        commonMessageAlert('Store Name Field can\'t be null !');
        return false;
    } 
    if(tbl.find('select[name~="buildingname"]').val()==''){
        commonMessageAlert('Building Name Field can\'t be null !');
        return false;
    } 
      if(tbl.find('select[name~="floorno"]').val()==''){
        commonMessageAlert('Floor No. Field can\'t be null !');
        return false;
    } 
     if(tbl.find('select[name~="roomno"]').val()==''){
        commonMessageAlert('Room No. Field can\'t be null !');
        return false;
    } 
    if(tbl.find('select[name~="selRack"]').val()==''){
        commonMessageAlert('Please select a Rack !');
        return false;
    } 
    if(tbl.find('input[name~="binno"]').val().trim()==''){
        commonMessageAlert('Bin No. is mandatory!');
        return false;
    }    
    if(!confirm('Confirm Update?')){
        return;
    }
    var formData = $('form#frmBin').serializeObject();
    var dataString = JSON.stringify(formData);
     startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });  
}


function retreiveStoreRack(url)
 {
    
    $('.messageDiv').hide();  
     startLoading();
    $.ajax({            
            type: 'POST',
            url: url,           
            dataType:'json',
            success: function (result){ 
               if(result.success){  
                     $('#storename').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.storenameId);
                     var buildingIdArr=result.jsonData.buildingIdArr;
                var buildingNameArr=result.jsonData.buildingNameArr;
                var buildingSelectBox=document.getElementById('buildingname');
                buildingSelectBox.options.length=0;
                buildingSelectBox.options[buildingSelectBox.options.length]=new Option('--Select--','');
                for(var i=0;i<buildingIdArr.length;i++){
                   buildingSelectBox.options[buildingSelectBox.options.length] = new Option(buildingNameArr[i], buildingIdArr[i]);
                }
                    $('#buildingname').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.buildingnameId);
                    
                    var floorIdArr=result.jsonData.floorIdArr;
                var floorNameArr=result.jsonData.floorNameArr;
                var floorSelectBox=document.getElementById('floorno');
                floorSelectBox.options.length=0;
                floorSelectBox.options[floorSelectBox.options.length]=new Option('--Select--','');
                for(var i=0;i<floorIdArr.length;i++){
                   floorSelectBox.options[floorSelectBox.options.length] = new Option(floorNameArr[i], floorIdArr[i]);
                }                     
                $('#floorno').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.floornoId);
                
                var roomIdArr=result.jsonData.roomIdArr;
                var roomNameArr=result.jsonData.roomNameArr;
                var roomSelectBox=document.getElementById('roomno');
                roomSelectBox.options.length=0;
                roomSelectBox.options[roomSelectBox.options.length]=new Option('--Select--','');
                for(var i=0;i<roomIdArr.length;i++){
                   roomSelectBox.options[roomSelectBox.options.length] = new Option(roomNameArr[i], roomIdArr[i]);
                }
                     $('#roomno').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.roomnoId);                   
                     $('#rackno').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.rackno);
                    $('#rackrowno').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.rackrowno);
                     $('#rackcolumnno').prop('disabled', false).removeClass('disable_bg').val(result.jsonData.rackcolumnno);
                     
                    $('#addStoreRackUpdateURL').val('/Tashi/web/app_dev.php/Store/update_addStoreRack/'+result.jsonData.Rackid);
                    //for hide show buttons and diables                   
                    $('#btn_save').hide(); 
                    $('#btn_clear').hide();   
                    $('#btn_edit').hide();  
                    $('#btn_update').show();                         
                    $('#btn_cancel').show(); 
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}

function deleteStoreRackMaster(url)
{  
    $('.messageDiv').hide();  
//    var formData = $('form#frmCountryDetails').serializeObject();
//    var dataString = JSON.stringify(formData);
    //var url=$('#locationUpdateURL').val();
    if(!confirm('Are you sure you want to delete the selected Rack Detail?'))
        return;
    startLoading();
    $.ajax({            
            type: 'POST',
            url: url,
            //data: dataString,
            contentType: 'application/json',
            dataType:'json',
            success: function (result){ 
               if(result.success){    
                    $('#display-list').empty().append(result.html);  
                    fnCmnSuccessMessage(result.message);
                    paginationTbl(); //for pagination
                    
                     //for hide show buttons and diables
                   $('#storename').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#buildingname').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#floorno').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#roomno').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#rackno').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#rackrowno').prop('disabled', false).removeClass('disable_bg').val('');
                    $('#rackcolumnno').prop('disabled', false).removeClass('disable_bg').val('');
                     $('#btn_save').show(); 
                    $('#btn_clear').show();   
                    $('#btn_edit').hide();  
                    $('#btn_update').hide();                         
                    $('#btn_cancel').hide(); 
                                      
                    
                }
                else{
                     fnCmnErrorMessage(result.message);
                }
                 stopLoading();
           },
            error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
        });   
}
function deleteBin(url)
{  
    $('.messageDiv').hide();  
    if(!confirm('Are you sure you want to delete the selected Bin?'))
        return;
    startLoading();
    $.ajax({            
        type: 'POST',
        url: url,
        //data: dataString,
        contentType: 'application/json',
        dataType:'json',
        success: function (result){ 
           if(result.success){    
                $('.application-form').empty().append(result.html);  
                fnCmnSuccessMessage(result.message);
                paginationTbl();
            }
            else{
                 fnCmnErrorMessage(result.message);
            }
             stopLoading();
       },
        error: function(){ fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();}
    });   
}

function cmLoadLocationList(eleObj, url, appendEleID){
        $('.messageDiv').hide();        
    switch(appendEleID){
        case 'state':  $('#district').empty().append('<option value="">--Select--</option>');
                       $('#city').empty().append('<option value="">--Select--</option>');
                       break;
        case 'district':     
                        $('#city').empty().append('<option value="">--Select--</option>');
                        break;
    }    
        
     $.ajax({
        type: 'POST',
        url: url,
        data: { 'load_list_key' : $(eleObj).val() },      
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#'+appendEleID).empty().append(result.html);                                      
            }
            else {
                fnCmnWarningMessage(result.message);
                fnCmnScrollToElementIDorClass('#wrapper');           
            }      
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();
            
        }
    });
}

function cmnLoadStoreList(eleObj, url, appendEleID){
     $('.messageDiv').hide();          
     $.ajax({
        type: 'POST',
        url: url,
        data: { 'load_list_key' : $(eleObj).val() },      
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#'+appendEleID).empty().append(result.html);                                      
            }
            else {
                fnCmnErrorMessage(result.message);           
            }      
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();
        }
    });
}

//show button and enable input fields on click edit button
function storeEditBtn(storename, buildingname, floorno,roomno,rackno, rackrowno, rackcolumnno,address1,address2,country,state,district,city,zipcode) {
    $('#btn_update').show();
    $('#btn_clear').hide();
    $('#btn_edit').hide();

    $('#' + storename).prop('disabled', false).removeClass('disable_bg');
    $('#' + buildingname).prop('disabled', false).removeClass('disable_bg');
    $('#' + floorno).prop('disabled', false).removeClass('disable_bg');
    $('#' + roomno).prop('disabled', false).removeClass('disable_bg');
    $('#' + rackno).prop('disabled', false).removeClass('disable_bg');
    $('#' + rackrowno).prop('disabled', false).removeClass('disable_bg');
    $('#' + rackcolumnno).prop('disabled', false).removeClass('disable_bg');
    $('#' + address1).prop('disabled', false).removeClass('disable_bg');
    $('#' + address2).prop('disabled', false).removeClass('disable_bg');
    $('#' + country).prop('disabled', false).removeClass('disable_bg');
    $('#' + state).prop('disabled', false).removeClass('disable_bg');
    $('#' + district).prop('disabled', false).removeClass('disable_bg');
    $('#' + city).prop('disabled', false).removeClass('disable_bg');
    $('#' + zipcode).prop('disabled', false).removeClass('disable_bg');
    $('#selRack').prop('disabled', false).removeClass('disable_bg');
    $('#binno').prop('disabled', false).removeClass('disable_bg');

}
function loadAllCities(url){
    $('.messageDiv').hide();          
    $.ajax({
        type: 'POST',
        url: url,         
        dataType: 'json',
        success: function(result) {
            if (result.success) {
                $('#display-list').empty().append(result.html);      
                paginationTbl();
            }
            else{
                fnCmnErrorMessage(result.message);           
            }      
        },
        error: function() {
            fnCmnWarningMessage('An unknown technical error has been encountered.'); scrollToMessage(); stopLoading();
        }
    });
}

