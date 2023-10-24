<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#efefef">
    <meta name="msapplication-navbutton-color" content="#efefef">
    <meta name="apple-mobile-web-app-status-bar-style" content="#efefef">
    <title>Absen</title>
    <meta name="description" content="">
    <meta name="keywords" content="" />
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/themes/mobile') ?>/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('assets/themes/mobile') ?>/img/icon/192x192.png">
    <link rel="stylesheet" href="<?php echo base_url('assets/themes/mobile') ?>/css/style.css">

    <?php foreach($css as $file){ ?>
        <link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" />
    <?php } ?>

     <style type="text/css">
         .btn-primary_or {
            background: #f04e27 !important;
            border-color: #f04e27 !important;
            color: #ffffff !important;
        }

        .bg-primary_or {
            background: #f04e27 !important;
        }

        .form-group.boxed .form-control:focus {
          border-color: #f04e27;
        }

        .text-primary_or, a.text-primary {
          color: #f04e27 !important;
        }

        .appBottomMenu .item .action-button {
            background: #f04e27 !important;
        }

        .appHeader.scrolled.bg-primary.is-active {
            background: #f04e27 !important;
        }

        .appBottomMenu .item.active i.icon, .appBottomMenu .item.active ion-icon, .appBottomMenu .item.active strong {
            color: #f04e27 !important;
        }
        body {
          -webkit-user-select: none;
             -moz-user-select: -moz-none;
              -ms-user-select: none;
                  user-select: none;
        }
        .timeline .item .content ol, .timeline .item .content ul{
            text-align: center;
            list-style-position: inside;
            margin-left: -3em;
        }
     </style>

    <!-- Jquery -->
    <script src="<?php echo base_url('assets/themes/mobile') ?>/js/lib/jquery-3.4.1.min.js"></script>

    <script type="text/javascript">
        var loadingdata =' <button class="btn btn-light" type="button" disabled>'+
                '<span class="spinner-border spinner-border-sm mr-05" role="status" aria-hidden="true"></span>'+
                'Loading...'+
            '</button>';
        var id_device ='';
        if (!localStorage.getItem('id_device')) {
              id_device = "<?= $this->input->get('id_device') ?>";
        }
        
    </script>
   
</head>

<body>

    <!-- loader -->
    <div id="loader">
       <!--  <div class="spinner-border text-primary_or" role="status"></div> -->
       <div class="toast-box toast-center show">
            <div class="in">
                <div class="text">
                    <div class="spinner-border text-light" role="status">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * loader -->

    <?php echo $output ?>

    <div id="error_page" class="toast-box toast-center">
        <div class="in">
            <div class="text" id="box-alert">
                    
            </div>
        </div>
    </div>   
    <!-- toast center -->
    <div id="loading_home" class="toast-box toast-center">
        <div class="in">
            <div class="text">
                <div class="spinner-border text-light" role="status">
                </div>
            </div>
        </div>
    </div>
    <!-- toast center --> 
    <?php foreach($js as $file){ ?>
        <script src="<?php echo $file; ?>"> </script>
    <?php } ?>
     <!-- Bootstrap-->
    <script src="<?php echo base_url('assets/themes/mobile') ?>/js/lib/popper.min.js"></script>
    <script src="<?php echo base_url('assets/themes/mobile') ?>/js/lib/bootstrap.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="<?php echo base_url('assets/themes/mobile/ionicons@5.0.0') ?>/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="<?php echo base_url('assets/themes/mobile') ?>/js/plugins/owl-carousel/owl.carousel.min.js"></script>
    <!-- jQuery Circle Progress -->
    <script src="<?php echo base_url('assets/themes/mobile') ?>/js/plugins/jquery-circle-progress/circle-progress.min.js"></script>
    <!-- Base Js File -->
    <script src="<?php echo base_url('assets/themes/mobile') ?>/js/base_unwoker.js"></script>

   <script type="text/javascript">
       if (id_device != '') {
            localStorage.setItem('id_device', id_device);
       }

      if(window.navigator && navigator.serviceWorker) {
          navigator.serviceWorker.getRegistrations()
          .then(function(registrations) {
            for(let registration of registrations) {
              registration.unregister();
            }
          });
        }
   </script>


</body>
</html>