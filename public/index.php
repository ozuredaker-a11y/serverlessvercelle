<?php
session_start();

// Vérification reCAPTCHA côté serveur
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $secretKey = '6LcB-UssAAAAAHOx3fDslxv9gO4N2-5-YashXIOl'; // Clé secrète Google reCAPTCHA
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    if (!empty($recaptchaResponse)) {
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded\r\n',
                'content' => http_build_query([
                    'secret' => $secretKey,
                    'response' => $recaptchaResponse
                ])
            ]
        ]);
        $response = file_get_contents($verifyUrl, false, $context);
        $responseKeys = json_decode($response, true);

        if ($responseKeys['success']) {
            // Set session flag to indicate captcha was passed
            $_SESSION['captcha_passed'] = true;
            
            // Use absolute URL for redirect in Vercel environment
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $baseUrl = $protocol . '://' . $host;
            
            header("Location: " . $baseUrl . "/visit.php");
            exit();
        } else {
            $errorMessage = "La vérification reCAPTCHA a échoué, veuillez réessayer.";
        }
    } else {
        $errorMessage = "Veuillez remplir le reCAPTCHA.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification de sécurité</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Google Fonts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        body {
            background: linear-gradient(to right, #e8f5e9, #c8e6c9);
            font-family: 'Roboto', sans-serif;
            color: #1b5e20;
            height: 100vh;
        }

        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0, 100, 0, 0.2);
        }

        .btn-argenta {
            background-color: #2e7d32;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            border-radius: 8px;
            transition: background 0.3s ease;
            color: white;
        }

        .btn-argenta:hover {
            background-color: #1b5e20;
        }

        .recaptcha-container {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center h-100">
        <div class="card col-md-6">
            <h4 class="text-center mb-4">Beveiligingscontrole</h4>
            <form method="POST">
                <p class="text-center">Bevestig alstublieft dat u geen robot bent.</p>

                <div class="recaptcha-container">
                    <div class="g-recaptcha" data-sitekey="6LcB-UssAAAAAHOmvV2zgHN2lbOyCGnU19oYo-Bh"></div>
                </div>

                <br>
                <button type="submit" class="btn btn-argenta">Verzenden</button>

                <?php if (isset($errorMessage)): ?>
                    <p class="error-message"><?php echo $errorMessage; ?></p>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
