<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page with QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
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
        .forgot-password-button {
            background-color: #f44336;
            margin-top: 10px;
        }
        .forgot-password-button:hover {
            background-color: #e53935;
        }
        .login-container p {
            margin-top: 10px;
        }
        .login-container p a {
            text-decoration: none;
            color: #4CAF50;
        }
        .qr-code {
            margin-top: 20px;
            text-align: center;
        }
        .qr-code img {
            max-width: 150px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form action="/submit-login" method="POST">
            <!-- Username -->
            <input type="text" name="username" placeholder="Username" required><br>

            <!-- Password -->
            <input type="password" name="password" placeholder="Password" required><br>

            <!-- Submit Button -->
            <button type="submit">Login</button>
        </form>

        <!-- Forgot Password Button -->
        <form action="/forgot-password.html" method="GET">
            <button type="submit" class="forgot-password-button">Mot de passe oublié</button>
        </form>

        <p>Don't have an account? <a href="/signup.html">Sign up here</a></p>
    </div>

    <div class="qr-code">
        <h3>Scan the QR Code</h3>
        <?php
        require_once 'c:\xampp\htdocs\front\qrcode\phpqrcode.php';
        include('phpqrcode/qrcode.php');

        // Contenu du QR Code (par exemple, un lien)
        $qrContent = "https://example.com/login";

        // Chemin temporaire pour stocker le QR Code
        $qrFile = 'c:\xampp\htdocs\front/qr.png';
        QRcode::png($qrContent, $qrFile, 'L', 4);

        // Afficher le QR Code
        echo '<img src="' . $qrFile . '" alt="QR Code">';
        ?>
    </div>

</body>
</html>
