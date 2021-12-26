<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        let url = new URL(window.location.href);
        let message = url.searchParams.get("message");
        let token = url.searchParams.get('token');
        let tokenList = token.split(',');
        const urlLine = 'https://linenotifyapi.herokuapp.com/';
        $(document).ready(() => {
            $.ajax({
                url: urlLine,
                type: 'POST',
                headers: {
                    'Access-Control-Allow-Origin': '*',
                    'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, OPTIONS',
                    'Access-Control-Allow-Headers': 'Content-Type, Authorization, X-Requested-With',
                },
                data: {
                    message: message,
                    token: tokenList
                }
            }).then(function(data) {
                console.log(data);
            });
        })
    });
</script>