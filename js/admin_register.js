//validate form data
$(document).ready(function () {
    $("form[name='adminDetails']").validate({
        rules: {
            adminName: {
                required: true
            },
            adminEmail: {
                required: true
            },
            adminPswd: {
                required: true
            },
            confirmPswd: {
                required: true
            }
        },
        messages: {
           adminName: {
               required: "Please enter username"
           },
           adminEmail: {
               required: "Please enter email"
           },
           adminPswd: {
               required: "Please enter password"
           },
           confirmPswd: {
               required: "Please enter confirm password"
           }
        }
    });
});

//match the passwords
function matchPasswords() {
    $.ajax({
        url: "admin_registration.php",
        type: "POST",
        data: {
            action: "matchPasswords",
            pswd: $("#adminPswd").val(),
            confirmPswd: $("#confirmPswd").val(),
        },
        success: function(response) {
            if(response=="NotMatched") {
                $("#errmsg").html("<div class='alert alert-danger'>Both passwords dosen't Match</div>");
                $('#submit').attr('disabled', true);
            }
            else {
                $("#errmsg").html("");
                $('#submit').attr('disabled',false);
            }
        }
    });
}
