$(document).ready(function() {

    //Save Button
    $('#btnSave').on('focusin', function() {
        var styles = {
            borderColor: 'rgb(0,141,76)',
            borderWidth: '2px',
            boxShadow: '0 0 8px #34495e'
        };
        $(this).css(styles);
    });
    $('#btnSave').on('focusout', function() {
        var styles = {
            borderColor: '',
            borderWidth: '',
            boxShadow: ''
        };
        $(this).css(styles);
    });
    
    //Reset Button
    $('#btnReset').on('focusin', function() {
        var styles = {
            borderColor: 'rgb(54,127,169)',
            borderWidth: '2px',
            boxShadow: '0 0 4px #34495e'
        };
        $(this).css(styles);
    });
    $('#btnReset').on('focusout', function() {
        var styles = {
            borderColor: '',
            borderWidth: '',
            boxShadow: ''
        };
        $(this).css(styles);
    });
    //Search Button
    $('#search').on('focusin', function() {
        var styles = {
            borderColor: 'rgb(54,127,169)',
            borderWidth: '2px',
            boxShadow: '0 0 4px red'
        };
        $(this).css(styles);
    });
    $('#search').on('focusout', function() {
        var styles = {
            borderColor: '',
            borderWidth: '',
            boxShadow: ''
        };
        $(this).css(styles);
    });


    $("#successmsg").animate({opacity: 1.0}, 60000).fadeOut("slow");


    $("#btnReset").click(function() {
        window.location.href = window.location.pathname;
    });
    /* * **************************************************** */
    /* * Trim Multiple Whitespaces into Single Space for all input Elements Start Block */
    /* * **************************************************** */
    function trimspace(element) {
        var cat = $('#' + element).val();
        cat = cat.replace(/ +(?= )/g, '');
        if (cat != " ") {
            $('#' + element).val(cat);
        } else {
            $('#' + element).val($.trim(cat));
        }
    }

    $('input').bind('input', function() {
        trimspace(this.id);
    });
    $('textarea').bind('input', function() {
        trimspace(this.id);
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

});