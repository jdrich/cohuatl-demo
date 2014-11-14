<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php (new \App\Model\Config(new \Cohuatl\Store('BlogConfig')))['blog_title']; ?></title>
        <link rel="stylesheet" href="css/main.css">
        <script src="js/main.js"></script>
    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>
