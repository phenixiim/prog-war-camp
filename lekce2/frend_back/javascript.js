function sendData() {
    $.post('backend.php', $('form').serialize()).done(function(response){
        $('form').append(response);
    });
}

$('form button').click(function(e) {
    e.preventDefault();
    sendData();
});
