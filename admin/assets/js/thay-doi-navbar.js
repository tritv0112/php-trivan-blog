$(document).ready(function() {
    let url = window.location.href;
    $(".navbar-side a").each(function() {
        if (this.href === url) {
            $(this).addClass('active-menu');
        }
    });
})