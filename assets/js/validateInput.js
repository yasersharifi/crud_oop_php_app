// validate mobile functions
function ValidateMobile(mobile)
{
    if(/^\d{11}$/.test(mobile))
        return true;
    return false;
}

// validate email functions
function ValidateEmail(mail)
{
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
        return true;
    return false;
}

// check is required item
function IsRequired(item) {
    if (item == "" || item == NaN || item == undefined)
        return false;
    return true;
}
