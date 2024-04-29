function signIn() {
    event.preventDefault(); 
    var username = $("#username").val();
    var password = $("#password").val();

    $.ajax({
        url: "http://localhost/shop/authenticate/processSignin",
        type: "POST",
        data: {
            username: username,
            password: password
        },
        dataType: "json",
        success: function(data) {
            if (data.success == true) {
                toastr.success('Đăng nhập thành công');

                setTimeout(function() {
                    window.location.href = data.redirect_url;
                }, 1000); 

            } else {
                if(data.error_message != null) {
                    toastr.warning(data.error_message);
                }
                
                if(data.error_message_username != null ) {
                    $('.error-message-username').html(data.error_message_username);
                }else {
                    $('.error-message-username').html('');
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

