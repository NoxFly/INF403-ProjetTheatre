<html>
    <head>
        <meta charset='utf-8'>

        <base href="<?php echo $oSite->getBaseUrl().'/'; ?>">

        <title><?php echo $oSite->getTitle(); ?></title>

        <link rel="stylesheet" type="text/css" href="theme/css/structure.css">
        <link rel="stylesheet" type="text/css" href="theme/css/style.css">
        <link rel="stylesheet" type="text/css" href="theme/css/media.css">

        <script src="theme/js/libs/prefixfree.min.js"></script>
        <script src="theme/js/libs/jquery.min.js"></script>
    </head>
    
    <body>
        <?php include('theme/php/navigation.php'); ?>

        <div id="content">
            <?php include($oSite->getPagination()); ?>
        </div>
        
        <?php include('theme/php/footer.php'); ?>
        <script src="theme/js/script.js"></script>
    </body>
</html>