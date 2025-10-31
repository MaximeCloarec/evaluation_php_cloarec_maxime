<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "" ?></title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>

<body>
    <form action="/register" method="post">
        <input type="text" name="firstname" id="" placeholder="saisir votre prénom">
        <input type="text" name="lastname" id="" placeholder="saisir votre nom">
        <input type="email" name="email" id="" placeholder="saisir votre email">
        <input type="password" name="password" id="" placeholder="saisir votre mot de passe">
        <input type="submit" value="Ajouter" name="submit">
    </form>
    <?= $data["succes"] ?? "" ?>
    <?= $data["error"] ?? "" ?>
</body>

</html>