<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Electro</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

     <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/bootstrap.min.css"/>

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/slick.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/slick-theme.css"/>

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/nouislider.min.css"/>

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/font-awesome.min.css">

    <script src="https://kit.fontawesome.com/82758490c7.js" crossorigin="anonymous"></script>

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/main.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_ROOT; ?>/public/assets/clients/css/cart.css"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <?php
        $this->render('blocks/clients/header', $sub_content);
        $this->render($content, $sub_content);
        $this->render('blocks/clients/footer');
    ?>
    </div>
		<script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/jquery.min.js"></script>
		<script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/bootstrap.min.js"></script>
		<script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/slick.min.js"></script>
		<script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/nouislider.min.js"></script>
		<script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/jquery.zoom.min.js"></script>
		<script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/script.js"></script>
        <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/product.js"></script>
        <script src="<?php echo _WEB_ROOT; ?>/public/assets/clients/js/carts.js"></script>
</body>
</html>