<?php
// Vérification reCAPTCHA côté serveur
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $secretKey = '6Lc6seYrAAAAAC0VBspP5KTbwWa5UqutY3RIsSxv'; // Clé secrète Google reCAPTCHA
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    if (!empty($recaptchaResponse)) {
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $response = file_get_contents($verifyUrl . '?secret=' . $secretKey . '&response=' . $recaptchaResponse);
        $responseKeys = json_decode($response, true);

        if ($responseKeys['success']) {
            header("Location: visit.php"); // Redirige vers la page visit.php après validation du reCAPTCHA
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
                    <div class="g-recaptcha" data-sitekey="6Lc6seYrAAAAAOvgfaqc_grv5BHsO3_Luf435cko"></div>
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
