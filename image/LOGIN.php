<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            padding: 20px;
            width: 350px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.911);
            border-radius: 55px;
            margin: 5%;
            box-shadow: 11px 11px 0px 0px rgb(4, 4, 4);
            outline: 1px solid rgb(1, 1, 1);
            transition: box-shadow 0.3s ease;
        }
        .login-container:hover {
            box-shadow: 20px 20px 0px 0px rgb(127, 195, 98);
        }
        .login-container h2 {
            margin-bottom: 20px;
        }
        .login-container input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container button {
            width: 70%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            border-radius: 37px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #45a049;
        }
        .forgot-password {
            display: block;
            width: 70%;
            padding: 10px;
            background-color: #f44336; /* Red color for Forgot Password */
            border: none;
            color: white;
            border-radius: 37px;
            cursor: pointer;
            margin-top: 10px; /* Space between buttons */
            text-align: center;
            text-decoration: none; /* Removes underline */
        }
        .forgot-password:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            
            <!-- Google reCAPTCHA -->
            <div class="g-recaptcha" data-sitekey="6Lf4OJoqAAAAAN7v_flawpcH4_r70CmmlS0jvCKM"></div>
            <br/>
            
            <button type="submit" name="submit">Login</button>
            <!-- Forgot Password Button with a link to motdepasse.php -->
            <a href="motdepasse.php" class="forgot-password">Mot de passe oublié</a>
        </form>
    </div>

    <?php
    // Include the Composer autoload file with the correct path
    require_once 'C:/xampp/htdocs/front/view/autoload.php';

    if (isset($_POST['submit'])) {
        // Secret key for Google reCAPTCHA
        $recaptcha = new \ReCaptcha\ReCaptcha("6Lf4OJoqAAAAADhG2Xkcp6_zPTWCicJAul6uPvsy");

        // Get the response from the user
        $gRecaptchaResponse = $_POST['g-recaptcha-response'];

        // Check if CAPTCHA is valid
        $remoteIp = $_SERVER['REMOTE_ADDR'];
        $resp = $recaptcha->setExpectedHostname('localhost')
                          ->verify($gRecaptchaResponse, $remoteIp);

        if ($resp->isSuccess()) {
            // CAPTCHA is valid
            echo "Success! You can now log in.";
            // You can proceed with the login process here (e.g., check credentials in DB)
        } else {
            // CAPTCHA is invalid
            $errors = $resp->getErrorCodes();
            var_dump($errors); // For debugging
        }
    }
    ?>

    <!-- Google reCAPTCHA Script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>
</html>
