

<script src="js/jquery-1.5.2.min.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="js/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="js/jquery.bgswitcher.js"></script>
<script src="js/pagetop.js"></script>

<script src="js/topslide.js"></script>
<script src="js/jquery.freetile.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<script>
$(function() {
    $('.dtmenu').click(function() {
        var menu = $(this).attr('id');
        var num = menu.replace('menu_','');
        $('#submenu_'+num).toggle();
    });
});

</script>