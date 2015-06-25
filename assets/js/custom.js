$(document).ready(function(){
    setInterval(function() {
        $('#alert-message').fadeOut('fast');
        $('#alert-message').removeClass('error');
        $('#alert-message').removeClass('success');
        $('#alert-message').removeClass('warning');
        $('#text-alert-message').html('');
        $('#text-alert-flag').html('');
    }, 10000);
    $(".close").click(function(){
        $('#alert-message').fadeOut('fast');
        $('#alert-message').removeClass('error');
        $('#alert-message').removeClass('success');
        $('#alert-message').removeClass('warning');
        $('#text-alert-message').html('');
        $('#text-alert-flag').html('');
    });

    /* * **************************************************** */
    /* * Trim Multiple Whitespaces into Single Space for all input Elements Start Block */
    /* * **************************************************** */
    function trimspace(element) {
        var cat = $(element).val();
        cat = $.trim(cat.replace(/ +(?= )/g, ''));
        if (cat != "") {
            $(element).val(cat);
        } else {
            $(element).val($.trim(cat));
        }
    }
    $('input').bind('blur', function () {
        trimspace(this);
    });
    $('textarea').bind('blur', function () {
        trimspace(this);
    });

    $("input[type=password]").keypress(function(evt) {
        var keycode = evt.charCode || evt.keyCode;
        if (keycode == 32) {
            return false;
        }
    });

    /* * **************************************************** */
    /* * Trim Multiple Whitespaces into Single Space for all input Elements End Block */
    /* * **************************************************** */

    $('.numeric').keydown(function(e) {
            // If you want decimal(.) please use 190 in inArray.
            // Allow: backspace, delete, tab, escape, enter.
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                    // Allow: Ctrl+A
                            (e.keyCode == 65 && e.ctrlKey === true) ||
                            // Allow: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
    
    $('.non-numeric').bind('keyup blur', function() {
        var node = $(this);
        node.val(node.val().replace(/[^a-zA-Z ]/g, ''));
    });
});