const loading_container = $('#loading')

$('#account-login-popup').find('.open-register-tab').on('click', function(event) {
    event.preventDefault();
    $(".popup-tab-content").hide();
    $("#register.popup-tab-content").show();
    $("body").find('.popup-tabs-nav a[href="#register"]').parent("li").click();
});

