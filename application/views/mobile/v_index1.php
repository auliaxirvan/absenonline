 <style type="text/css">
     #a, #b, #c, #d, #e {
      fill: none;
     /* stroke: #0bf779;*/
      stroke: #fff;
      stroke-dashoffset: 0;
      stroke-width: 1;
      transition: all 300ms ease;
    }
    #a.active, #b.active, #c.active, #d.active, #e.active {
      animation: draw 6s forwards;
    }
    #a {
      stroke-dasharray: 12.1542625427;
    }
    #b {
      stroke-dasharray: 19.7911586761;
    }
    #c {
      stroke-dasharray: 53.0072517395;
    }
    #d {
      stroke-dasharray: 23.7017784119;
    }
    #e {
      stroke-dasharray: 8.8374814987;
    }
    @keyframes draw {
      20% {
        stroke-dashoffset: 40;
      }
      40% {
        stroke-dashoffset: 0;
      }
      100% {
        stroke-dashoffset: 0;
      }
    }
 </style>   
    <div id="load"></div>
     <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="javascript:;" class="item active menu_klik" data-menu="home">
            <div class="col">
                <ion-icon name="home-outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>
        <a href="<?= base_url('home/peta') ?>" class="item" data-menu="peta">
            <div class="col">
                <ion-icon name="map-outline"></ion-icon>
                <strong>Peta</strong>
            </div>
        </a>
        <a href="<?= base_url('absen') ?>" class="item">
            <div class="col">
                <div class="action-button" style="display: inline-block;">
                    <!-- <ion-icon name="finger-print" style="font-size: 56px;"></ion-icon> -->
                    <svg id="fingerprint" viewBox="0 0 34 34" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>Finger Print</title>
                        <g id="document" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="_fingerprint" transform="translate(1.000000, 1.000000)" stroke="#ffffff">
                               <!--  <circle id="outer-circle" cx="16" cy="16" r="16"></circle> -->
                                <g transform="translate(7.000000, 6.000000)" stroke-linecap="round">
                                    <path id="a" d="M3.14414922,1.97419264 C3.14414922,1.97419264 5.30885997,0.506351808 9.06036082,0.506351808 C12.8118617,0.506351808 14.781903,1.97419264 14.781903,1.97419264"></path>
                                    <path id="b" d="M0.466210729,7.27628774 C0.466210729,7.27628774 3.19024811,2.75878123 9.09512428,2.96502806 C15.0000005,3.17127489 17.4745821,7.17202872 17.4745821,7.17202872" ></path>
                                    <path id="c" d="M2,16.4687762 C2,16.4687762 1.12580828,14.9305411 1.27082278,11.9727304 C1.45871447,8.14036841 5.19587478,5.30175361 9.05270871,5.30175361 C12.9095426,5.30175361 15.0000001,7.82879552 15.8975926,9.33195218 C16.5919575,10.4947729 17.7597991,14.4361492 14.6226101,15.0206592 C12.41268,15.4324056 11.5911303,13.4911155 11.5911303,12.9859143 C11.5911303,11.9727302 11.1054172,10.2336826 9.05270848,10.2336826 C6.99999978,10.2336826 6.11384543,11.8665663 6.4593664,13.7955614 C6.6532895,14.8782069 7.59887942,18.3701197 12.0173963,19.5605638" ></path>
                                    <path id="d" d="M7.0204614,19.6657197 C7.0204614,19.6657197 3.88328263,16.5690127 3.88328268,12.9603117 C3.88328274,9.35161068 6.59923746,7.80642537 9.0076008,7.80642554 C11.4159641,7.8064257 14.1798468,9.55747124 14.1798468,12.759562" ></path>
                                    <path id="e" d="M8.95538742,12.6694189 C8.95538742,12.6694189 9.04883608,18.1288401 15.069217,17.3610597"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
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
        function startInterval(){  
            setInterval('updateTime();', 1000);  
        }
        startInterval();//start it right away
        function updateTime(){
            var nowMS = now.getTime();
            nowMS += 1000;
            now.setTime(nowMS);
            var clock = $('#waktu');
            if(clock){
                // clock.innerHTML = now.toTimeString();//adjust to suit
                var curr_hour = now.getHours();
                var curr_min = now.getMinutes();
                var curr_sec = now.getSeconds();
                clock.html(curr_hour+':'+curr_min+':'+curr_sec);
            }
        }

        $(document).ready(function() {
            load_data('home');
        });



        $('.menu_klik').click(function(){
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
                data: {id: id},
                dataType :"json",
                error:function(){
                    //$('#load').html('');
                    $('#loading_home').removeClass("show");
                },
                beforeSend:function(){
                    $('#loading_home').addClass("show");
                    //$('#load').html(loadingdata);
                },
                success: function(res){
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


          setInterval(function(){ 
            // alert("Hello"); 
             el.click();
          }, 2000); 

    
    </script>