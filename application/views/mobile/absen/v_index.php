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
            <?php if (!empty($jadwal)) { ?>
                <?php if ($jadwal->start_time != "00:00:00") { ?>
                    <div class="mb-1 alert alert-outline-primary alert-dismissible fade show p-1" role="alert">
                        <h4 class="alert-title mb-0">Jam Kerja <?= tgl_indonesia(date('Y-m-d'))  ?></h4>
                        <div class="chip chip-media">
                            <i class="chip-icon bg-primary">
                                <ion-icon name="return-up-forward-outline"></ion-icon>
                            </i>
                            <span class="chip-label"><?= tanggal_format($jadwal->start_time, 'H:i') ?></span>
                        </div>
                        <div class="chip chip-media mt-1">
                            <i class="chip-icon bg-warning">
                                <ion-icon name="return-down-back-outline"></ion-icon>
                            </i>
                            <span class="chip-label"><?= tanggal_format($jadwal->end_time, 'H:i') ?></span>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="mb-1 alert alert-outline-primary alert-dismissible fade show p-1" role="alert">
                        <h4 class="alert-title mb-0">Hari ini libur</h4>
                    </div>
            <?php }
            } ?>
            <div class="card bg-light mb-2">
                <div class="card-body p-1">
                    <span id="loading_lokasi"></span>
                    <button type="button" class="btn btn-primary mt-1" id="reload_page" style="margin-top: 3px !important;position: absolute;z-index: 99;margin-left: 4px;">
                        <ion-icon name="locate-outline"></ion-icon>
                        Cek ulang GPS
                    </button>
                    <div id="map" style="width:100%;height:180px;display: none;"></div>

                </div>
            </div>
            <?php
            $btn_disabled = "";
            $wfo = true;
            $wfh = true;
            $status_check = '';
            if (!empty($status)) {
                $status_check = $status;
            }

            if (empty($status)) {
                $btn_disabled = "disabled";
            }

            if (!empty($telah_absen->status_kerja)) {
                if ($telah_absen->status_kerja == "WFO") {
                    $wfh = false;
                }
                if ($telah_absen->status_kerja == "WFH") {
                    $wfo = false;
                }

                if ($status_check == $telah_absen->status_in_out) {
                    $btn_disabled = "disabled";
                }
            }

            if (!empty($cek_status_kerja1)) {
                if ($cek_status_kerja1->status_kerja == "WFO") {
                    $wfh = false;
                }
                if ($cek_status_kerja1->status_kerja == "WFH") {
                    $wfo = false;
                }
            }

            $time_in_out = "";
            if (!empty($jadwal) && !empty($status)) {
                if ($status == "masuk") {
                    $time_in_out = $jadwal->start_time;
                } elseif ($status == "pulang") {
                    $time_in_out = $jadwal->end_time;
                }
            }

            ?>
            <?php if ($wfo == true) { ?>
                <div class="card bg-light mb-2">
                    <div class="card-header">Absen WFO (Bekerja di kantor)</div>
                    <div class="card-body p-1">
                        <div class="alert alert-outline-primary alert-dismissible fade show p-1" role="alert">
                            <h4 class="alert-title" id="jarak"></h4>
                            Hanya dapat mengambil absen jika anda berada di kantor
                        </div>
                        <button type="button" <?= $btn_disabled ?> class="btn btn-primary mt-1 col-12 btn_absen" id="wfo_btn" style="display: none">
                            <ion-icon name="checkmark-circle-outline"></ion-icon>
                            Ambil Absen WFO
                        </button>
                    </div>
                </div>
            <?php } ?>
            <?php if ($wfh == true) { ?>
                <div class="card bg-light mb-2">
                    <div class="card-header">Absen WFH (Bekerja di rumah)</div>
                    <div class="card-body p-1">
                        <div class="alert alert-outline-warning alert-dismissible fade show p-1" role="alert">
                            <h4 class="alert-title"></h4>
                            Anda dapat mengambil absen diluar kantor, pastikan anda mengaktifkan GPS anda
                        </div>
                        <button type="button" <?= $btn_disabled ?> class="btn btn-danger mt-1 col-12 btn_absen" id="wfh_btn" style="display:none">
                            <ion-icon name="checkmark-circle-outline"></ion-icon>
                            Ambil Absen WFH
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
        var radius = <?= $latlng_kantor['radius'] ?>;

        if (radius) {
            radius = radius;
        } else {
            radius = 20;
        }

        $('#loading_lokasi').html(loadingdata);

        myLatLng_kantor = {
            lat: <?= $latlng_kantor['lat'] ?>,
            lng: <?= $latlng_kantor['lng'] ?>
        };

        var myLat;
        var myLong;
        var myLatLng;
        var jarak;

        $(document).ready(function() {
            myLatLng = {
                lat: get_lat,
                lng: get_lng
            };
            initMap();
            convert_latlng(myLatLng);
            jarak = findDistance(myLatLng, myLatLng_kantor);
            $('#wfo_btn').hide();
            note_radius = 'Anda berada diluar radius area kantor :';
            if (jarak <= radius) {
                note_radius = 'Anda berada didalam radius area kantor :';
                $('#wfo_btn').show();
            }
            $('#jarak').html(note_radius + jarak + ' m');
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
            function() {
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

            wellCircle = new google.maps.Circle({
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#FF0000',
                fillOpacity: 0.35,
                map: map,
                center: myLatLng_kantor,
                radius: radius
            });


            marker.addListener("click", () => {
                infowindow.open(map, marker);
            });
            $('#map').show();
            $('#loading_lokasi').html('');
            $('#wfh_btn').show();
        }

        $('#reload_page').click(function() {
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
            // alert("Back button clicked");
            window.location.replace("<?= site_url('home') ?>");
        }


        function findDistance(pos1, pos2) {
            var R = 6371e3; // R is earth’s radius
            var lat1 = pos1.lat; // starting point lat
            var lat2 = pos2.lat; // ending point lat
            var lon1 = pos1.lng; // starting point lon
            var lon2 = pos2.lng; // ending point lon
            var lat1radians = toRadians(pos1.lat);
            var lat2radians = toRadians(pos2.lat);

            var latRadians = toRadians(lat2 - lat1);
            var lonRadians = toRadians(lon2 - lon1);

            var a = Math.sin(latRadians / 2) * Math.sin(latRadians / 2) +
                Math.cos(lat1radians) * Math.cos(lat2radians) *
                Math.sin(lonRadians / 2) * Math.sin(lonRadians / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            var d = R * c;

            //console.log(d)
            return Math.round(d);
        }

        function toRadians(val) {
            var PI = 3.1415926535;
            return val / 180.0 * PI;
        }

        $('.btn_absen').click(function() {
            id = $(this).attr('id');
            ajax_get(id);
        });

        function ajax_get(id) {
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('absen/ajax_get') ?>",
                data: {
                    id: id,
                    'mylatlng': myLatLng,
                    'latlng_kantor': myLatLng_kantor,
                    'jarak': jarak,
                    'status_check': status_check,
                    'time_in_out': time_in_out
                },
                dataType: "json",
                error: function() {
                    $('#error_page #box-alert').text('Tidak dapat menghubungkan ke internet');
                    toastbox('error_page', 2000)
                    $('.btn_absen').attr("disabled", false);
                },
                beforeSend: function() {
                    $('.btn_absen').attr("disabled", true);
                },
                success: function(res) {
                    $('#error_page #box-alert').text(res.message);
                    toastbox('error_page', 2000)
                    $('.btn_absen').attr("disabled", false);
                    if (res.status == true) {
                        window.location.replace("<?= site_url('home') ?>");
                    }
                }
            });
        }

        // merubah geotag menjadi alamat
        function convert_latlng(pos) {

            // membuat geocoder
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'latLng': pos
            }, function(r) {

                if (r && r.length > 0) {
                    alamat = r[0].formatted_address;
                } else {
                    alamat = 'Alamat tidak di temukan di lokasi !!';
                }
                // alert(alamat);

            });
        }
    </script>