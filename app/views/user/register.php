<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="css/notification.css">
    <title>Inscription</title>
</head>

<body>
    <div id="notification-container"></div>
    <section class="container">
        <div class="auth-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <img src="assets/illustration.png" alt="illustration" class="illustration" />
                <h1 class="opacity">Inscription</h1>
                <form action="/inscription" method="POST" id="registerForm">
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
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirmer le mot de passe" required />
                        <div class="error-message" id="confirmPasswordError"></div>
                    </div>
                    <?php if (isset($error)): ?>
                        <script>
                            window.addEventListener('DOMContentLoaded', function() {
                                notificationManager.show('<?php echo htmlspecialchars($error); ?>', 'error');
                            });
                        </script>
                    <?php endif; ?>
                    <button class="opacity" type="submit">S'inscrire</button>
                </form>
                <div class="auth-link opacity">
                    <a href="/">Déjà un compte ? Se connecter</a>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        <div class="theme-btn-container"></div>
    </section>

    <script src="js/themes.js"></script>
    <script src="js/register.js"></script>
    <script src="js/notification.js"></script>
</body>

</html>