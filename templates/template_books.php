<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>

<body>
    <?= $data["error"] ?? "" ?>
    <?php foreach ($books as $book) : ?>
        <div class="grid">
            <div>
                <p> Titre :<?= $book->getTitle() ?></p>
                <p> Description :<?= $book->getDescription() ?></p>
                <p> Date de publication :<?= $book->getPublicationDate() ?></p>
                <p> Auteur :<?= $book->getAuthor() ?></p>
                <p> Catégorie :<?= $book->getCategory()->getName() ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</body>

</html>