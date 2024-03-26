<html>
<head>
    <title>Admin</title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href=" <?php echo _WEB_ROOT; ?>/app/public2/assets/clients/css/style.css" />

</head>

<body>
    <div class="chung">
        <div class="trai">
            <?php
                    //  $this->render('blocks/danhmucAdmin');
                    include './app/views/blocks/admin/danhmucAdmin.php';
            ?>
        </div>

        <div class="phai">
            <?php
                  //  $this->render('blocks/headerAdmin');
                  include './app/views/blocks/admin/headerAdmin.php';

                  //  $this->render('home/homeAdmin');
                  include './app/views/home/homeAdmin.php';

                  //  $this->render('blocks/footerAdmin');
                  include './app/views/blocks/admin/footerAdmin.php';
            ?>

        </div>
    </div>

    <script type="text/javascript" src=" <?php echo _WEB_ROOT; ?>/app/public2/assets/clients/js/scrips.js"> </script>
</body>

</html>

<style>
    .chung {
        display: block;
        width: 100%;
        height: 800px;
    }

    .trai {
        width: 20%;
        height: 800px;
        float: left;
    }

    .phai {
        width: 80%;
        height: 800px;
        float: left;
    }
</style>