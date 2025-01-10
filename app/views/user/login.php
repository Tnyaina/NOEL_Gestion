<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="css/notification.css">
    <title>Login</title>
</head>

<body>
    <h3>ETU003080 && ETU003188</h3>
    <h3>Admin : admin@example.com && mdp :12345678</h3>
    <div id="notification-container"></div>
    <section class="container">
        <div class="auth-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <img src="assets/illustration.png" alt="illustration" class="illustration" />
                <h1 class="opacity">LOGIN</h1>
                <form action="/login" method="POST" id="loginForm">
                    <div class="form-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Adresse email" required />
                        <div class="error-message" id="emailError"></div>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Mot de passe" required />
                        <div class="error-message" id="passwordError"></div>
                    </div>
                    <?php if (isset($error)): ?>
                        <script>
                            window.addEventListener('DOMContentLoaded', function() {
                                notificationManager.show('<?php echo htmlspecialchars($error); ?>', 'error');
                            });
                        </script>
                    <?php endif; ?>
                    <button class="opacity" type="submit">Se connecter</button>
                </form>
                <div class="auth-link opacity">
                    Pas encore de compte ? <a href="/register">S'inscrire</a>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        <div class="theme-btn-container"></div>
    </section>

    <script src="js/themes.js"></script>
    <script src="js/login.js"></script>
    <script src="js/notification.js"></script>
</body>

</html>