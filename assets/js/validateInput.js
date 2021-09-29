function phonenumber(inputtxt)
{
    var phoneno = /^\d{10}$/;
    if(inputtxt.value.match(phoneno)) {
        return true;
    }
    else
    {
        alert("message");
        return false;
    }
}

function ValidateEmail(mail)
{
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
    {
        return (true)
    }
    return (false)
}