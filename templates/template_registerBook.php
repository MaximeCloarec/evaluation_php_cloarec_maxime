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
    <main>
        <form action="/book" method="post">
            <input type="text" name="title" id="" placeholder="saisir le titre">
            <input type="text" name="description" id="" placeholder="saisir une description">
            <input type="date" name="date" id="" placeholder="saisir la date de publication">
            <input type="text" name="author" id="" placeholder="saisir le nom de l'auteur">
            <select name="category" id="">
                <?php foreach ($category as $cat) : ?>
                    <option name="category" value="<?= $cat->getId() ?>"><?= $cat->getName() ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Ajouter" name="submit">
        </form>
        <?= $data["succes"] ?? "" ?>
        <?= $data["error"] ?? "" ?>
    </main>
</body>

</html>