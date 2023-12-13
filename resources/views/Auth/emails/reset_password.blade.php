<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation de mot de passe</title>
</head>
<body>
    <h2>Réinitialisation de mot de passe</h2>
    <p>Bonjour,</p>
    <p>Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>
    <p>Merci de cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe :</p>
    <p>
        <a href="{{ $reset_url }}">Réinitialiser votre mot de passe</a>
    </p>
    <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune autre action n'est nécessaire.</p>
    <p>Merci,</p>
    <p>Votre équipe {{ config('app.name') }}</p>
</body>
</html>
