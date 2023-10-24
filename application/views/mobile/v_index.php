<script src="<?= base_url('assets/themes/plugins') ?>/lottie_player/dist/lottie-player.js"></script>
<div id="load"></div>
<!-- App Bottom Menu -->
<div class="appBottomMenu">
    <a href="javascript:;" class="item active menu_klik" data-menu="home">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="javascript:;" class="item menu_klik lkh" class="item" data-menu="lkh">
        <div class="col">
            <ion-icon name="document-text-outline"></ion-icon>
            <strong>LKH</strong>
        </div>
    </a>
    <a href="<?= base_url('absen') ?>" class="item">
        <div class="col">
            <div class="action-button p-1" style="display: inline-block;">
                <lottie-player src="<?= base_url('assets/themes/plugins') ?>/lottie_player/data_json/finger_white.json" background="transparent" speed="0.8" loop autoplay></lottie-player>
            </div>
        </div>
    </a>
    <a href="javascript:;" class="item menu_klik" data-menu="laporan">
        <div class="col">
            <ion-icon name="list-outline"></ion-icon>
            <strong>Laporan</strong>
        </div>
    </a>
    <a href="javascript:;" class="item menu_klik" data-menu="profil">
        <div class="col">
            <ion-icon name="person-outline"></ion-icon>
            <strong>Profil</strong>
        </div>
    </a>
</div>
<!-- * App Bottom Menu -->


<script type="text/javascript">
    $(window).on('pushstate', function(event) {
        alert("push");
    });
    var now = new Date(<?php echo time() * 1000 ?>);

    function startInterval() {
        setInterval('updateTime();', 1000);
    }
    startInterval(); //start it right away
    function updateTime() {
        var nowMS = now.getTime();
        nowMS += 1000;
        now.setTime(nowMS);
        var clock = $('#waktu');
        if (clock) {
            // clock.innerHTML = now.toTimeString();//adjust to suit
            var curr_hour = now.getHours();
            var curr_min = now.getMinutes();
            var curr_sec = now.getSeconds();
            clock.html(curr_hour + ':' + curr_min + ':' + curr_sec);
        }
    }

    $(document).ready(function() {
        var id_back = '<?= $id_back ?>';
        console.log(id_back);
        if (id_back != '') {
            $('.menu_klik').removeClass("active");
            $('.lkh').addClass("active");

            load_data(id_back);
        } else if (id_back == '') {
            load_data('home');
        }

    });



    $('.menu_klik').click(function() {
        if ($(this).hasClass("active") == false) {
            $('.menu_klik').removeClass("active");
            var id = $(this).data('menu');
            $(this).addClass("active");
            load_data(id);
        }

    });

    function load_data(id) {
        $.ajax({
            url: "<?php echo site_url('home/ajax_get') ?>",
            data: {
                id: id
            },
            dataType: "json",
            error: function() {
                //$('#load').html('');
                $('#loading_home').removeClass("show");
            },
            beforeSend: function() {
                $('#loading_home').addClass("show");
                //$('#load').html(loadingdata);
            },
            success: function(res) {
                $('#loading_home').removeClass("show");
                $('#load').html(res.data);
            }
        });
    }

    var a = $('#a');
    var b = $('#b');
    var c = $('#c');
    var d = $('#d');
    var e = $('#e');

    var el = $('#fingerprint');

    el.click(function() {
        a.toggleClass('active');
        b.toggleClass('active');
        c.toggleClass('active');
        d.toggleClass('active');
        e.toggleClass('active');
    })


    setInterval(function() {
        // alert("Hello"); 
        el.click();
    }, 2000);
</script>