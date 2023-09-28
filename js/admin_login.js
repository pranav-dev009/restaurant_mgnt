//validate form data
$(document).ready(function () {
    $("form[name='adminDetails']").validate({
        rules: {
            adminName:{
                required: true
            },
            adminPswd:{
                required: true
            }
        },
        messages: {
            adminName: {
                required: "Please enter username"
            },
            adminPswd: {
                required: "Please enter password"
            }
        }
    });
});
