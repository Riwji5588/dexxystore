<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<body>
    <result></result>
</body>

<script>
    $(document).ready(async function() {
        let url = new URL(window.location.href);
        let message = url.searchParams.get("message") || "";
        let token = url.searchParams.get('token') || "";;
        let tokenList = token.split(',') || [];

        try {

            if (tokenList.length > 0 && message.length > 0) {
                tokenList.forEach(async (token) => {
                    await sendLine(token, message);
                    document.getElementsByTagName('result')[0].innerHTML = "Success";
                })
            } else {
                throw new Error("token or message is empty");
            }


        } catch (e) {
            console.log(e);
            document.getElementsByTagName("result")[0].innerHTML = e.message;

        }
    });

    function sendLine(token = "", message = "") {
        let options = {
            url: "https://script.google.com/macros/s/AKfycbx3Hf05ha2eiouI7gG1mf1HV-7ALswtHjeOJDfwaosiDcBwdwkaqaAzgnXmxBBYREID/exec?token=" + token + "&message=" + message,
        };

        $.ajax({
            url: options.url,
            success: function(data) {
                console.log(data);
            },
            error: function(data) {
                console.log('error')
                console.log(data);
            }
        });
    }
</script>