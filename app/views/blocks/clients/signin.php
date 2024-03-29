<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/bootstrap.min.css"/>
</head>
<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

* {
    box-sizing: border-box;
}

body {
    background: #f6f5f7;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    font-family: 'Montserrat', sans-serif;
    height: 100vh;
    margin: -20px 0 50px;
}

h1 {
    font-weight: bold;
    margin: 0;
}

h2 {
    text-align: center;
}

p {
    font-size: 14px;
    font-weight: 100;
    line-height: 20px;
    letter-spacing: 0.5px;
    margin: 20px 0 30px;
}

span {
    font-size: 12px;
}

a {
    color: #333;
    font-size: 14px;
    text-decoration: none;
    margin: 15px 0;
}

button {
    border-radius: 20px;
    border: 1px solid #FF4B2B;
    background-color: #FF4B2B;
    color: #FFFFFF;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
}

button:active {
    transform: scale(0.95);
}

button:focus {
    outline: none;
}

button.ghost {
    background-color: transparent;
    border-color: #FFFFFF;
}

form {
    background-color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 50px;
    height: 100%;
    text-align: center;
}

input {
    background-color: #eee;
    border: none;
    padding: 12px 15px;
    margin: 8px 0;
    width: 100%;
}

.error-message {
    color: red;
}

.container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
        0 10px 10px rgba(0, 0, 0, 0.22);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 100%;
    min-height: 480px;
}

.form-container {
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

.sign-in-container {
    left: 0;
    width: 50%;
    z-index: 2;
}

.container.right-panel-active .sign-in-container {
    transform: translateX(100%);
}

.sign-up-container {
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
}

.container.right-panel-active .sign-up-container {
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: show 0.6s;
}

@keyframes show {

    0%,
    49.99% {
        opacity: 0;
        z-index: 1;
    }

    50%,
    100% {
        opacity: 1;
        z-index: 5;
    }
}

.overlay-container {
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: transform 0.6s ease-in-out;
    z-index: 100;
}

.container.right-panel-active .overlay-container {
    transform: translateX(-100%);
}

.overlay {
    background: #FF416C;
    background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);
    background: linear-gradient(to right, #FF4B2B, #FF416C);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: 0 0;
    color: #FFFFFF;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.container.right-panel-active .overlay {
    transform: translateX(50%);
}

.overlay-panel {
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    text-align: center;
    top: 0;
    height: 100%;
    width: 50%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
}

.overlay-left {
    transform: translateX(-20%);
}

.container.right-panel-active .overlay-left {
    transform: translateX(0);
}

.overlay-right {
    right: 0;
    transform: translateX(0);
}

.container.right-panel-active .overlay-right {
    transform: translateX(20%);
}

.social-container {
    margin: 20px 0;
}

.social-container a {
    border: 1px solid #DDDDDD;
    border-radius: 50%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 5px;
    height: 40px;
    width: 40px;
}

footer {
    background-color: #222;
    color: #fff;
    font-size: 14px;
    bottom: 0;
    position: fixed;
    left: 0;
    right: 0;
    text-align: center;
    z-index: 999;
}

footer p {
    margin: 10px 0;
}

footer i {
    color: red;
}

footer a {
    color: #3c97bf;
    text-decoration: none;
}
</style>
<body>
<?php
require_once 'vendor/autoload.php';

// init configuration
$clientID = '1042224953790-6pclfk6bg2jtjhc1hjhsiedj8dsmuj5d.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/webmobile/signin/login';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;

  $response = new Response();
  $response->redirect('http://localhost/webmobile/signin/loginWithGoogle/'.$name.'/'.$email);
  // now you can use this profile info to create account in your website and make user logged in.

} else {?>
<h2>Sign in/up Form</h2>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="#">
                <h1>Create Account</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input id="name-signup" type="text" placeholder="Name" />
                <div class="error-message error-message-name"></div>
                <input id="email-signup" type="email" placeholder="Email" />
                <div class="error-message error-message-email-signup"></div>
                <input id="password-signup" type="password" placeholder="Password" />
                <div class="error-message error-message-password-signup"></div>
                <button onclick="signUp()">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form id="loginForm" method="post">
                <h1>Sign in</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?php echo $client->createAuthUrl();?>" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your account</span>
                <input type="email" name="email-signin" id="email-signin" placeholder="Email" required/>
                <div class="error-message error-message-email"></div>
                <input type="password" name="password-signin" id="password-signin" placeholder="Password" required/>
                <div class="error-message error-message-password">

                </div>
                <a href="#">Forgot your password?</a>
                <button type="button" onclick="submitForm()">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
  <?php
}
?>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });

        function submitForm() {
            event.preventDefault(); 

            var email = $("#email-signin").val();
            var password = $("#password-signin").val();

            $.ajax({
                url: "http://localhost/webmobile/signin/processLogin",
                type: "POST",
                data: {
                    email: email,
                    password: password
                },
                dataType: "json",
                success: function(data) {
                    if (data.success == true) {
                        window.location.href = data.redirect_url;
                    } else {
                        if(data.error_message_email != null ) {
                            $('.error-message-email').html(data.error_message_email);
                        }else {
                            $('.error-message-email').html('');
                        }

                        if(data.error_message_password != null ) {
                            $('.error-message-password').html(data.error_message_password);
                        }else {
                            $('.error-message-password').html('');
                        }

                    }
                },
                error: function(error) {
                    console.error("Lỗi khi gửi yêu cầu đăng nhập:", error);
                    alert("An error occurred while processing the request.");
                }
            });
        }

        function signUp() {
            event.preventDefault();

            var name = $('#name-signup').val();
            var email = $('#email-signup').val();
            var password = $('#password-signup').val();

            $.ajax({
                url: "http://localhost/webmobile/signin/processSignUp",
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    password: password
                },
                dataType: "json",
                success: function(data) {
                    if(data.success) {
                        window.location.href = data.redirect_url;
                    }else {
                        if(data.error_messages['name']!= null ) {
                            $('.error-message-name').html(data.error_messages['name']);
                        }else {
                            $('.error-message-name').html('');
                        }
                        
                        if(data.error_messages['email'] != null ) {
                            $('.error-message-email-signup').html(data.error_messages['email']);
                        }else {
                            $('.error-message-email-signup').html('');
                        }

                        if(data.error_messages['password'] != null ) {
                            $('.error-message-password-signup').html(data.error_messages['password']);
                        }else {
                            $('.error-message-password-signup').html('');
                        }
                    }
                    
                },
                error: function(error) {
                    console.error("Lỗi khi gửi yêu cầu đăng ký:", error);
                    alert("An error occurred while processing the request.");
                }
            });
        }
    </script>
    <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/jquery.min.js"></script>
</body>
</html>