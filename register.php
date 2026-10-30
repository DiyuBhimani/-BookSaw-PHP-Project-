<?php
$conn = new mysqli("localhost", "root", "", "book");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $conn->real_escape_string($_POST['username']);
    $password_raw = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $conn->real_escape_string($_POST['email']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $city = $conn->real_escape_string($_POST['city']);
    $pincode = $conn->real_escape_string($_POST['pincode']);
    $address = $conn->real_escape_string($_POST['address']);

    if ($password_raw !== $confirm_password) {

        $message = "❌ Passwords do not match!";

    } else {

        // Password encryption
        if (function_exists("password_hash")) {
            $password = password_hash($password_raw, PASSWORD_DEFAULT);
        } else {
            // For old PHP versions only
            $password = md5($password_raw);
        }

        // Check username
        $check = $conn->query("SELECT username FROM user WHERE username='$username'");

        if ($check->num_rows > 0) {

            $message = "❌ Username already exists!";

        } else {

            $sql = "INSERT INTO user 
            (username, password, email_id, mobile_no, city, pincode, address)
            VALUES 
            ('$username', '$password', '$email', '$mobile', '$city', '$pincode', '$address')";

            if ($conn->query($sql) === TRUE) {

                $message = "✅ Registration successful! <a href='login.php'>Login Now</a>";

            } else {

                $message = "❌ Error: " . $conn->error;

            }
        }
    }
}

$conn->close();
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>BookStore Registration</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}


body{

    display:flex;
    justify-content:center;
    align-items:center;

    min-height:100vh;

    padding:30px;


    background:

    linear-gradient(
        rgba(255,248,235,.80),
        rgba(245,230,205,.85)
    ),

    url("images/b2.jpeg") center/cover no-repeat;


}


/* Cream Glass Registration Card */

.form-container{

    width:450px;

    padding:35px;


    background:

    rgba(255,250,240,.70);


    backdrop-filter:blur(20px);

    -webkit-backdrop-filter:blur(20px);



    border:

    1px solid rgba(180,140,90,.35);


    border-radius:25px;



    box-shadow:

    0 15px 40px rgba(120,80,40,.25),

    inset 0 0 25px rgba(255,255,255,.5);



    color:#5D4037;

}



/* Heading */


h2{

    text-align:center;

    margin-bottom:25px;

    font-size:32px;

    color:#6D4C41;

    font-weight:600;

}



/* Home Link */


.home-link{

    display:inline-block;

    margin-bottom:15px;

    color:#8D5A2B;

    text-decoration:none;

    font-weight:600;

}


.home-link:hover{

    color:#B7793E;

}



/* Inputs */


input,
textarea{


    width:100%;


    padding:14px 18px;


    margin-bottom:15px;


    border-radius:40px;


    border:

    1px solid #D8C2A4;



    background:

    rgba(255,255,255,.65);



    outline:none;



    color:#5D4037;



    font-size:15px;


}



textarea{


    border-radius:18px;

    resize:none;

    height:90px;

}



input::placeholder,
textarea::placeholder{


    color:#9C7A59;


}



input:focus,
textarea:focus{


    border-color:#B7793E;


    background:white;


    box-shadow:

    0 0 10px rgba(183,121,62,.25);


}



/* Validation Error */


.error-message{


    display:none;

    color:#B00020;

    font-size:13px;

    margin-top:-10px;

    margin-bottom:10px;


}



/* Buttons */


.btn-group{


    display:flex;

    justify-content:space-between;

    gap:15px;


}



button{


    flex:1;


    padding:14px;


    border:none;


    border-radius:40px;


    cursor:pointer;


    font-size:16px;


    font-weight:600;


    transition:.3s;


}



/* Register Button */


.submit-btn{


    background:


    linear-gradient(

        90deg,

        #D4A574,

        #B7793E

    );


    color:white;


}



.submit-btn:hover{


    background:


    linear-gradient(

        90deg,

        #B7793E,

        #8D5A2B

    );


    transform:translateY(-2px);


    box-shadow:

    0 8px 20px rgba(183,121,62,.4);


}



/* Reset Button */


.reset-btn{


    background:#8D6E63;

    color:white;


}



.reset-btn:hover{


    background:#6D4C41;


}



/* Message Box */


.message{


    margin-top:20px;


    padding:12px;


    text-align:center;


    border-radius:12px;



    background:#FCE8E6;


    border:1px solid #E6B8AF;


    color:#A94442;


}



.success{


    background:#E8F5E9;


    border:1px solid #A5D6A7;


    color:#2E7D32;


}



/* Login Link */


.login{


    text-align:center;

    margin-top:20px;

    color:#6D4C41;


}



.login a{


    color:#B7793E;


    text-decoration:none;


    font-weight:600;


}



.login a:hover{


    text-decoration:underline;


}



/* Mobile */


@media(max-width:500px){


.form-container{


    width:100%;


}


}

</style>
</head>

<body>

<div class="form-container">

<h2>Create Account</h2>

<form method="POST" autocomplete="off" onsubmit="return validateForm()">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<input type="password" name="confirm_password" placeholder="Confirm Password" required>

<input type="email" name="email" placeholder="Email Address">

<input type="text" id="mobile" name="mobile" placeholder="Mobile Number" maxlength="10" required>

<div id="mobile-error" class="error-message">
Mobile number must contain 10 digits.
</div>


<input type="text" name="city" placeholder="City">
<input type="text" id="pincode" name="pincode" placeholder="Pincode" maxlength="6" required>

<div id="pincode-error" class="error-message">
Pincode must contain 6 digits.
</div>


<textarea name="address" placeholder="Address"></textarea>

<div class="btn-group">

<button type="submit" name="submit" class="submit-btn">
Register
</button>

<button type="reset" class="reset-btn">
Reset
</button>

</div>

</form>

<div class="login">
Already have an account?
<a href="login.php">Login</a>
</div>

<?php if(!empty($message)){ ?>
<div class="message <?= strpos($message,'✅')!==false ? 'success' : '' ?>">
<?= $message ?>
</div>
<?php } ?>

</div>

<script>

function validateDigits(input,maxLength,errorId){

input.value=input.value.replace(/\D/g,'');

if(input.value.length!=maxLength){

document.getElementById(errorId).style.display='block';

}else{

document.getElementById(errorId).style.display='none';

}

}

document.getElementById("mobile").addEventListener("input",function(){

validateDigits(this,10,"mobile-error");

});

document.getElementById("pincode").addEventListener("input",function(){

validateDigits(this,6,"pincode-error");

});

function validateForm(){

let valid=true;

if(document.getElementById("mobile").value.length!=10){

document.getElementById("mobile-error").style.display="block";
valid=false;

}

if(document.getElementById("pincode").value.length!=6){

document.getElementById("pincode-error").style.display="block";
valid=false;

}

return valid;

}

</script>

</body>
</html>