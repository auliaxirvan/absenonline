    <!-- App Header -->
    <div class="appHeader no-border transparent position-absolute">
        <div class="left">
            <a href="javascript:history.back()" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Absen</div>
        <div class="right">
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section mt-2">
            <?php if(!empty($jadwal)) {?>
            <?php if($start_jadwal->start_time != "00:00:00") { ?>
                <?php if (empty($libur)) { ?>
                  <?php if($start_jadwal->start_date != $start_jadwal->end_date) {?>
                <div class="mb-1 alert alert-outline-primary alert-dismissible fade show p-1" role="alert">
                     <h4 class="alert-title mb-0">Jam Masuk Kerja <?= tgl_indonesia($start_jadwal->start_date)  ?></h4>
                    <div class="chip chip-media">
                        <i class="chip-icon bg-primary">
                            <ion-icon name="return-up-forward-outline"></ion-icon>
                        </i>
                        <span class="chip-label"><?= tanggal_format($start_jadwal->start_time,'H:i') ?></span>
                    </div>
                     <h4 class="alert-title mb-0">Jam Pulang Kerja <?= tgl_indonesia($start_jadwal->end_date)  ?></h4>
                    <div class="chip chip-media mt-1">
                        <i class="chip-icon bg-warning">
                            <ion-icon name="return-down-back-outline"></ion-icon>
                        </i>
                        <span class="chip-label"><?= tanggal_format($start_jadwal->end_time,'H:i') ?></span>
                    </div>
                </div>
                 <?php } else {?>
                <div class="mb-1 alert alert-outline-primary alert-dismissible fade show p-1" role="alert">
                     <h4 class="alert-title mb-0">Jam Kerja <?= tgl_indonesia($start_jadwal->start_date)  ?></h4>
                    <div class="chip chip-media">
                        <i class="chip-icon bg-primary">
                            <ion-icon name="return-up-forward-outline"></ion-icon>
                        </i>
                        <span class="chip-label"><?= tanggal_format($start_jadwal->start_time,'H:i') ?></span>
                    </div>
                    <div class="chip chip-media mt-1">
                        <i class="chip-icon bg-warning">
                            <ion-icon name="return-down-back-outline"></ion-icon>
                        </i>
                        <span class="chip-label"><?= tanggal_format($start_jadwal->end_time,'H:i') ?></span>
                    </div>
                </div>
                <?php } }elseif ($jadwal->daysoff_id) { ?>
                    <div class="mb-1 alert alert-outline-primary alert-dismissible fade show p-1" role="alert">
                        <h4 class="alert-title mb-0">Libur</h4>
                    </div>
                <?php }elseif ($jadwal->cuti) { ?>
                <div class="mb-1 alert alert-outline-primary alert-dismissible fade show p-1" role="alert">
                    <h4 class="alert-title mb-0">Anda dalam masa cuti</h4>
                </div>
                <?php } ?>
            <?php }else { ?>
                <div class="mb-1 alert alert-outline-primary alert-dismissible fade show p-1" role="alert">
                    <h4 class="alert-title mb-0">Tidak ada jadwal</h4>
                </div>
            <?php } } ?>
             <div class="card bg-light mb-2">
                <div class="card-body p-1">
                    <span id="loading_lokasi"></span>
                    <button type="button" class="btn btn-primary mt-1" id="reload_page" style="margin-top: 3px !important;position: absolute;z-index: 99;margin-left: 4px;">
                        <ion-icon name="locate-outline"></ion-icon>
                        Cek Ulang GPS
                    </button>
                     <div id="map" style="width:100%;height:180px;display: none;"></div>
                     
                </div>
            </div>
            <?php
            $btn_disabled ="";
	    $btn_disabled_apel = "";
            $wfo = true;
            $wfh = false;
            $status_check = '';  
            
            //cek status masuk atau pulang  
            if (!empty($status)) {
                $status_check = $status;
            }
            
            if (empty($status)) {
                $btn_disabled ="disabled";
            }

	    if(!empty($jadwal_apel_hari_ini->checktime)){
                $btn_disabled_apel = "disabled";
            }else {
                $btn_disabled_apel = $btn_disabled;
            }

            $telah_absen_out ='';
            if(!empty($telah_absen->status_in_out)) {
                $telah_absen_out = $telah_absen->status_in_out;
            }
            // var_dump($status);
            // var_dump($telah_absen_out);


            //cek telah absen
            if ($status_check == $telah_absen_out) {
                $btn_disabled ="disabled";
            } 

            $time_in_out = "";
            if (!empty($jadwal) && !empty($status)) {
                
                if ($status == "masuk") {
                    if ($jadwal->in == 1) {
                          $wfh = true; 
                    }
                    $time_in_out = $start_jadwal->start_time;
                }elseif($status == "pulang") {
                    if ($jadwal->out == 1) {
                          $wfh = true; 
                    }
                    $time_in_out = $start_jadwal->end_time;
                }
            }
            ?>
            <?php if ($wfo == true) {?>
            <div class="card bg-light mb-2">
                <div class="card-header">Absen di Kantor</div>
                <div class="card-body p-1">
                    <div class="alert alert-outline-primary alert-dismissible fade show p-1" role="alert">
                        <h4 class="alert-title" id="jarak"></h4>
                        Hanya dapat mengambil absen jika anda berada di kantor
                    </div>
                    <button type="button" <?= $btn_disabled ?> class="btn btn-primary mt-1 col-12 btn_absen" id="wfo_btn" <?php if(empty($id_allow)) { echo "style='display: none'"; }?>>
                        <ion-icon name="checkmark-circle-outline"></ion-icon>
                        Ambil Absen
                    </button>
                     <?php
                     if(!empty($jadwal_apel) && $jadwal_apel->name == "Wirid Pengajian Korpri") {
                            //  var_dump($jadwal_apel);
                         if(date('H:i:s') >= $jadwal_apel->start_time && date('H:i:s') <= $jadwal_apel->end_time) {?>
                    <button type="button" <?= $btn_disabled_apel ?> class="btn btn-danger mt-1 col-12 btn_apel" id="apel_btn" style="display:none">
                        <ion-icon name="checkmark-circle-outline"></ion-icon>
                        Ambil Absen Wirid
                    </button>   
                    <?php } 
                    }?>
                </div>
            </div>
            <?php } ?>
            <?php if ($wfh == true) {?>
            <div class="card bg-light mb-2">
                <div class="card-header">Absen di Luar Kantor</div>
                <div class="card-body p-1">
                    <div class="alert alert-outline-warning alert-dismissible fade show p-1" role="alert">
                        <h4 class="alert-title"></h4>
                        Anda dapat mengambil absen di luar kantor dengan membagikan lokasi saat ini
                    </div>
                     <button type="button" <?= $btn_disabled ?> class="btn btn-danger mt-1 col-12 btn_absen" id="wfh_btn" style="display:none">
                        <ion-icon name="checkmark-circle-outline"></ion-icon>
                        Ambil Absen
                    </button>   
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- * App Capsule -->

 <script type="text/javascript">
    var get_lat = <?= $this->input->get('lat') ?>;
    var get_lng = <?= $this->input->get('lng') ?>;
    var status_check = "<?= $status_check ?>";
    var time_in_out = "<?= $time_in_out ?>";
    var id_allows = <?= count($id_allow); ?> 

    var latlng_kantor = <?= json_encode($latlng_kantor) ?>;
    var lokasi;
    var jarak_terdekat = new Array;

    $('#loading_lokasi').html(loadingdata);

    var myLat;
    var myLong;
    var myLatLng;
    var jarak;

    $(document).ready(function() {
          Array.min = function( array ){
            return Math.min.apply( Math, array );
        };

        myLatLng = {
            lat: get_lat,
            lng: get_lng
        };
       initMap();
        
        var no = 0;
        const jarak = [];
        for (let i = 0; i < latlng_kantor.lat.length; i++) {   
             myLatLng_kantor = {
                lat: latlng_kantor.lat[i], 
                lng: latlng_kantor.lng[i]
            };
            const get_jarak = findDistance(myLatLng,myLatLng_kantor);    
            jarak.push(get_jarak);
        }
        const j_terdekat = Array.min(jarak);
        jarak_terdekat.push(j_terdekat);

        if(id_allows > 0){
            $('#wfo_btn').show();
        }else {
            $('#wfo_btn').hide();
            $('#apel_btn').hide();
        }

        radius = jarak.indexOf(Number(j_terdekat).toFixed(2));
        
        if(latlng_kantor.lokasi[radius] !== "")
        {
            lokasi = latlng_kantor.lokasi[radius];
        }
        note_radius = 'Anda berada diluar radius area kantor : ';
        if (j_terdekat <= latlng_kantor.radius[radius]) {
            note_radius = 'Anda berada didalam radius area kantor : ';
            $('#wfo_btn').show();
            $('#wfh_btn').hide();
            $('#apel_btn').show();
        }
        $('#jarak').html(note_radius+j_terdekat+' m');
    });
    // set geolocation
    // var x = navigator.geolocation;
    // x.getCurrentPosition(success, failure);
    //     // function get current position success
    // function success(position){
    //      myLat = position.coords.latitude;
    //      myLong = position.coords.longitude;

    //     // set latitude and longitude
    //     var coords = new google.maps.LatLng(myLat, myLong);
    //     // $('#lokasi').val(myLat+','+myLong);

    //     var map;
    //     myLatLng = {
    //         lat: get_lat,
    //         lng: get_lng
    //     };

    //     initMap();
    //     jarak = findDistance(myLatLng,myLatLng_kantor);
    //     $('#wfo_btn').hide();    
    //     note_radius = 'Anda berada diluar radius area kantor :';
    //     if (jarak < 51) {
    //         note_radius = 'Anda berada didalam radius area kantor :';
    //         $('#wfo_btn').show();
    //     }
    //     $('#jarak').html(note_radius+jarak+' m');
    // }
    // // function get current position fail
    // function failure(){
    //     alert('geolocation failure!');
    // }

    setTimeout(
        function() 
            {
                window.location.replace(window.location.pathname);
            }, 80000
     );


      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLng,
          zoom: 18,
          fullscreenControl: true,
          zoomControl: true,
          streetViewControl: true
        });

        const contentString =
            'Lokasi Anda';

        const infowindow = new google.maps.InfoWindow({
            content: contentString,
          });

        const marker = new google.maps.Marker({
            position: myLatLng,
            map,
            title: "Lokasi Anda",
        });

          for (let i = 0; i < latlng_kantor.lat.length; i++) {   
             myLatLng_kantor = {
                lat: parseFloat(latlng_kantor.lat[i]), 
                lng: parseFloat(latlng_kantor.lng[i])
            };
            wellCircle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: myLatLng_kantor,
                radius: parseFloat(latlng_kantor.radius[i]),
            });
         }


        marker.addListener("click", () => {
            infowindow.open(map, marker);
        });      
            $('#map').show();
            $('#loading_lokasi').html('');
            $('#wfh_btn').show();
      }

      $('#reload_page').click(function(){ 
           //location.reload();
        //    window.location.reload(true);
        //  window.location.replace("https://akb.agamkab.go.id/absen/absen");
            // url = (window.location.href);
            // location.hash = url.replace(/#.*$/, '').replace(/\?.*$/, '');
           // window.history.replaceState(null, null, window.location.pathname);
            // location.reload();
            window.location.replace(window.location.pathname);
      });

    if (performance.navigation.type == 2) {
        window.location.replace("<?= site_url('home') ?>");
    }
     

      function findDistance(pos1, pos2) {
           var R = 6371e3; // R is earth’s radius
           var lat1 = pos1.lat; // starting point lat
           var lat2 = pos2.lat;         // ending point lat
           var lon1 = pos1.lng; // starting point lon
           var lon2 = pos2.lng;         // ending point lon
           var lat1radians = toRadians(pos1.lat);
           var lat2radians = toRadians(pos2.lat);

           var latRadians = toRadians(lat2-lat1);
           var lonRadians = toRadians(lon2-lon1);

           var a = Math.sin(latRadians/2) * Math.sin(latRadians/2) +
                Math.cos(lat1radians) * Math.cos(lat2radians) *
                Math.sin(lonRadians/2) * Math.sin(lonRadians/2);
           var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

           var d = R * c;

           //console.log(d)
           // return Math.round(d);
           return d.toFixed(2);
        }

        function toRadians(val){
            var PI = 3.1415926535;
            return val / 180.0 * PI;
        }

        $('.btn_absen').click(function(){
            id = $(this).attr('id');
            ajax_get(id);
        });

        $('.btn_apel').click(function(){
            id = <?= (!empty($jadwal_apel->id)) ? $jadwal_apel->id : "NULL"  ?>;
            ajax_get_apel(id);
        });

        function ajax_get(id) {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('absen/ajax_get') ?>",
                data: {id: id,
                        'mylatlng':myLatLng,
                        'latlng_kantor':myLatLng_kantor,
                        'jarak':jarak_terdekat[0],
                        'status_check':status_check,
                        'time_in_out':time_in_out,
                        'alamat_lokasi': lokasi,
                      },
                dataType :"json",
                error:function(){
                    $('#error_page #box-alert').text('Tidak dapat menghubungkan ke internet');
                    toastbox('error_page', 2000)
                    $('.btn_absen').attr("disabled", false);
                },
                beforeSend:function(){
                    $('.btn_absen').attr("disabled", true);
                    $('#loading_home').addClass("show");
                },
                success: function(res){
                    $('#error_page #box-alert').text(res.message);
                    toastbox('error_page', 2000)
                    
                    if (res.status== true) {
                        window.location.replace("<?= site_url('home') ?>");
                    }else{
                    	$('.btn_absen').attr("disabled", false);
                    	$('#loading_home').removeClass("show");
                    }
                }
            });
        } 

         function ajax_get_apel(id){
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('absen/ajax_get_apel') ?>",
                data: {id: id,
		       'mylatlng':myLatLng,
		      'jarak':jarak_terdekat[0],
                      },
                dataType :"json",
                error:function(){
                    $('#error_page #box-alert').text('Tidak dapat menghubungkan ke internet');
                    toastbox('error_page', 2000)
                    $('.btn_apel').attr("disabled", false);
                },
                beforeSend:function(){
                    $('.btn_apel').attr("disabled", true);
                    $('#loading_home').addClass("show");
                },
                success: function(res){
                    $('#error_page #box-alert').text(res.message);
                    toastbox('error_page', 2000)
                    
                    if (res.status== true) {
                        window.location.replace("<?= site_url('home') ?>");
                    }else{
                    	$('.btn_apel').attr("disabled", false);
                    	$('#loading_home').removeClass("show");
                    }
                }
            });
        }

        // merubah geotag menjadi alamat
        function convert_latlng(pos) {

            // membuat geocoder
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': pos}, function(r) {

                if (r && r.length > 0) {
                    alamat = r[0].formatted_address;
                } else {
                    alamat = '';
                }
                // alert(alamat);

            });
        }
      
    </script>

 