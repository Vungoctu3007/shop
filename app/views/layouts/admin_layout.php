<html>

<head>
    <title>Admin</title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href=" <?php echo _WEB_ROOT; ?>/app/public2/assets/clients/css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="app/public2/assets/client/css/nucleo-icons.css" rel="stylesheet" />
    <link href="app/public2/assets/client/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="app/public2/assets/client/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="app/public2/assets/client/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="app/public2/assets/clients/css/nucleo-icons.css" rel="stylesheet" />
    <link href="app/public2/assets/clients/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="app/public2/assets/clients/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="app/public2/assets/clients/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body>

    <div class="chung">
        <div class="trai">
            <?php
            //  $this->render('blocks/danhmucAdmin');
            $this->render('blocks/admin/danhmucAdmin');
            ?>
        </div>

        <div class="phai">
            <?php

            if (isset($sub_content) && isset($content)) {
                $this->render('blocks/admin/headerAdmin', $sub_content);
                $this->render($content, $sub_content);
                $this->render('blocks/admin/footerAdmin');
            } else {
                $this->render('blocks/admin/headerAdmin');
                echo "Page Not Found";
                $this->render('blocks/admin/footerAdmin');
            }

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