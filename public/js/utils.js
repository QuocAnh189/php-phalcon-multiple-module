let Profile = {
    check: function (id) {
        if ($.trim($("#" + id)[0].value) === '') {
            $("#" + id)[0].focus();
            $("#" + id + "_alert").show();

            return false;
        }

        return true;
    },
    validate: function () {
        if (Profile.check("name") === false) {
            return false;
        }
        if (Profile.check("email") === false) {
            return false;
        }
        $("#profileForm")[0].submit();
    }
};

var SignUp = {
    check: function (id) {
        if ($.trim($("#" + id)[0].value) === '') {
            $("#" + id)[0].focus();
            $("#" + id + "_alert").show();

            return false;
        }

        return true;
    },
    validate: function () {
        if (SignUp.check("name") === false) {
            return false;
        }
        if (SignUp.check("username") === false) {
            return false;
        }
        if (SignUp.check("email") === false) {
            return false;
        }
        if (SignUp.check("password") === false) {
            return false;
        }
        if ($("#password")[0].value !== $("#confirmPassword")[0].value) {
            $("#confirmPassword")[0].focus();
            $("#confirmPassword_alert").show();

            return false;
        }
        $("#registerForm")[0].submit();
    }
};

$(document).ready(function () {
    $("#registerForm .alert").hide();
    $("#profileForm .alert").hide();
});
