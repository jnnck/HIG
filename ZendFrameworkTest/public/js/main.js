$(document).ready(function () {
    
    var curAction = $("#usersform").attr("action"); 
    $("#actions").change(function() {
        var action = $(this).val();
        var str1 = window.location.pathname;
        var str2 = "index";
        if(str1.indexOf(str2) != -1){
            $("#usersform").attr("action","../../../"+ curAction + action);
        } else {
            $("#usersform").attr("action", curAction + action);
        }
           
    });
    
    

});


$('li:has(> ul)'    ).addClass('dropdown');
$('ul.nav > li > a' ).addClass('dropdown-toggle');
$('ul.nav > li.dropdown > a' ).attr("data-toggle", "dropdown");
$('ul.nav > li.dropdown > a').append("<b class='caret'></b>");
$('ul.nav > li > ul').addClass('dropdown-menu');

