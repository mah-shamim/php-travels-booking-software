var alert_msg = sessionStorage.getItem("alert_msg");

// alert(alert_msg);

if (alert_msg == ""){} else {
   
// =====================================================-----> Infromation Updated 
if (alert_msg == "updated"){ 
vt.success('Infromation has been updated successfully',{
    title:"Information Updated",
    position: "bottom-center",
    callback: function (){
} }) 
sessionStorage.setItem("alert_msg", "");
}

// =====================================================-----> Logout 
if (alert_msg == "logout"){ 
    vt.success('You have been logout successfully',{
        title:"Logout Successful",
        position: "bottom-center",
        callback: function (){
    } }) 
    sessionStorage.setItem("alert_msg", "");
}

// =====================================================-----> invalid login 
if (alert_msg == "invalid_login"){ 
    vt.error('Please check your email and password',{
        title:"Invalid Login",
        position: "bottom-center",
        callback: function (){
    } }) 
    sessionStorage.setItem("alert_msg", "");
}

// =====================================================-----> reset password 
if (alert_msg == "reset_password"){ 
    vt.success('New pasword has been sent to your mail',{
        title:"Reset Password",
        position: "bottom-center",
        callback: function (){
    } }) 
    sessionStorage.setItem("alert_msg", "");
}

// =====================================================-----> wrong email
if (alert_msg == "wrong_email"){ 
    vt.error('No account found with this email',{
        title:"Invalid Email Address",
        position: "bottom-center",
        callback: function (){
    } }) 
    sessionStorage.setItem("alert_msg", "");
}

// =====================================================-----> wrong email
if (alert_msg == "not_active"){ 
    vt.error('Please contact the admin to activate your account',{
        title:"Account not active",
        position: "bottom-center",
        callback: function (){
    } }) 
    sessionStorage.setItem("alert_msg", "");
}

}