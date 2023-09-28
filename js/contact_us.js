//validate form data
$(document).ready(function () {
    $("form[name='userData']").validate({
        rules: {
            userName: {
                required: true
            },
            userEmail: {
                required: true
            },
            userPhoneno: {
                required: true
            },
            userDetails: {
                required: true
            }
        },
        messages: {
            userName: {
                required: "Please enter username"
            },
            userEmail: {
                required: "Please enter email"
            },
            userPhoneno: {
                required: "Please enter phone no"
            },
            userDetails: {
                required: "Please enter user details"
            }
        }
    });
});
