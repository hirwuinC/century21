$(document).ready(function () {
    $('#submitLogin').on('click', function(){
        console.log('click', base_url)
        window.location.href = base_url;
    });
});