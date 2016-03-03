function isValidNumber(key){
    //getting key code of pressed key
    var keycode = (key.which) ? key.which : key.keyCode;
    //var txtQuantity = document.getElementById(txtId);
    //comparing pressed keycodes
    if (!(keycode==8 || keycode==46)&&(keycode < 48 || keycode > 57))
    {
        return false;
    }
    else{
        return true;
    }
}
function IntegerOnly(key){
    var keycode = (key.which) ? key.which : key.keyCode;
    //var txtQuantity = document.getElementById(txtId);
    //comparing pressed keycodes
    if (keycode < 48 || keycode > 57)
    {
        return false;
    }
    else{
        return true;
    }
}
function AlphaNumericOnly(key){
    var keycode = (key.which) ? key.which : key.keyCode;
    //var txtQuantity = document.getElementById(txtId);
    //comparing pressed keycodes
    if ((keycode>=48 && keycode<=57) || (keycode>=65 && keycode<=90) || (keycode>=97 && keycode<=122))
    {
        return true;
    }
    else{
        return false;
    }
}
function isMoney(thisid){    
    var txt=document.getElementById(thisid);
    if(isNaN(txt.value)||txt.value===''){
        txt.value='0.00';
    }
}
function DefaultDecimalValue(txt){
    if(isNaN(txt.value)||txt.value===''){
        txt.value='0.00';
    }else{
        txt.value=FormatNumber(txt,2);
    }
}
function FormatNumber(ctrl,decimalpoint){
    if(isNaN(ctrl.value)||ctrl.value===''){
        ctrl.value='0.00';
    }else{
        ctrl.value=(Math.floor(100 * parseFloat(ctrl.value)) / 100).toFixed(decimalpoint);
    }
}
function isDecimal(value){
    return parseFloat(value);
}
function isValidEmail(email){
    var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
    return pattern.test(email);
}

function isMobileNo(mobileNO){
    
    var mobileFormat=/^([0-9]){10}?$/;
    if (mobileFormat.test(mobileNO) === true) {
        return true;
    } else { 
        return false;
    }    
}


function isPostalCode(zipcode){
    var regZipcode=/^([0-9]){6}?$/;
    if (regZipcode.test(zipcode) === true) {
        return true;
    } else {
        return false;
    }
    
}

function isValidURL(url){
    //  eg.accept: google.com, www.google.com, http://www.google.com
    var urlFormat = /^(http\:\/\/)?[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?$/;
    return urlFormat.test(url);
}
function validateFileSize(fileupload,recommendedsizeinMB){       
    var fsizeMb=fileupload.files[0].size/1024/1024;    
    return (fsizeMb<=recommendedsizeinMB);    
}
function isValidImageFile(fileupload){
        var filename=fileupload.files[0].name;
        var validFiles=['jpg','jpeg','png','gif','bmp'];
        var extSplit = filename.split('.');
        var extReverse = extSplit.reverse();
        var ext = extReverse[0];
        var isValid=false;
        for(var i=0;i<validFiles.length;i++){
            if(ext.toLowerCase()==validFiles[i]){
                isValid=true;
                break;
            }
        }
        return isValid;
}
function PasswordValidLetter(password){
    var result=true;
    for(var i=0;i<password.length;i++){
        var code=password.charCodeAt(i);
        if((code>=48 && code<=57) ||(code>=65 && code<=90) || (code>=97 && code<=122) ||code==95 || code==46||code==64){
            result=true;
        }else{
            result=false;
            break;
        }        
    }
    return result;
}
function IsNumberCharPresent(txt){
    var isLetter=0;
    var isNumber=0;   
    for(var i=0;i<txt.length;i++){
        if(!isNaN(txt[i])){
            isNumber=1;
        }
        var asciicode = txt.charCodeAt(i);
        if((asciicode>=65 && asciicode<=90) || (asciicode>=97 && asciicode<=122)){
            isLetter=1;
        }
    }
    if(isLetter==1 && isNumber==1){
        return true;
    }else{
        return false;
    }
}