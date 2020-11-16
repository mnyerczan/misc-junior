<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$viewParameters->get("title")?></title>
        <script type="text/javascript" src="<?= BACKSTEP ?>public/js/gat.js?t=<?=date("s")?>"></script>
        <link rel="stylesheet" href="<?= BACKSTEP ?>public/style/layout.css?t=<?=date("s")?>">
    </head>
    <body>
        <?php require_once "app/template/header.php" ?>
        <?php require_once "app/template/{$viewParameters->get("view")}View.php" ?>
        <?php require_once "app/template/footer.php" ?>
    </body>
</html>