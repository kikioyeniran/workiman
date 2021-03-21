const loading_container = $('#loading')

$('#account-login-popup').find('.open-register-tab').on('click', function (event) {
    event.preventDefault();
    $(".popup-tab-content").hide();
    $("#register.popup-tab-content").show();
    $("body").find('.popup-tabs-nav a[href="#register"]').parent("li").click();
});
function comma(Num) { //function to add commas to textboxes
    // $("#value").val($("#value").val().replace(/[^0-9,]/g, ''));
    Num += '';
    Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
    Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
    // Num = Num.replace(',', '');
    let x, x1, x2
    x = Num.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    return x1 + x2;
}
