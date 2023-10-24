   <style>
    #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

      #btn_screen {
        margin-top: 60px !important;
        position: absolute;
        z-index: 99;
        margin-left: 10px;

      }
   </style>
    <div id="btn_screen">
      <button type="button" class="btn btn-secondary pl-1 pr-1" onclick="$('#ModalBasic').modal();" >
          <ion-icon name="list-outline"></ion-icon>
           <?= $tgl_peta ?>
      </button>
      <button type="button" class="btn btn-secondary pr-0 pl-1" data-toggle="modal" data-target="#actionSheetInset">
          <ion-icon name="search-outline"></ion-icon>
      </button>
    </div>
    
   <div id="map"></div>

    <!-- Default Action Sheet Inset -->
    <div class="modal fade action-sheet inset" id="actionSheetInset" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Tanggal</h5>
                </div>
                <div class="modal-body">
                     <div class="action-sheet-content">
                    <form>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name3">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control"
                                    placeholder="masukkan tanggal">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <button type="button" class="btn btn-secondary btn-block btn-lg" id="filter_tanggal"
                                data-dismiss="modal">Filter</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Default Action Sheet Inset -->

<script type="text/javascript">

     $('#filter_tanggal').click(function(){
          if ($('[name="tanggal"]').val()=='') {
                $('#error_page #box-alert').text('data tanggal harus diisi');
                toastbox('error_page', 2000)
          }else {
            window.location.replace(window.location.pathname+"?tgl="+$('[name="tanggal"]').val());
          }
          
      });

    if (performance.navigation.type == 2) {
        window.location.replace("<?= site_url('home') ?>");
    }

	var myLat;
    var myLong;
    //var myLatLng;

    $(document).ready(function(){
    	if (!myLat) {
    		$('#loading_home').addClass("show");
    	}

    	 $('.pin_map').click(function(){
	    	
	    	 $('#ModalBasic').modal('hide');
	         $('#loading_home').addClass("show");

	         var result=$(this).data('latlong').split(',');
    		 myLatLng = {
	            lat: parseFloat(result[0]),
	            lng: parseFloat(result[1])
	        };
	        initMap(myLatLng,18);
	    });
         
    });

   
    
    // set geolocation
    var x = navigator.geolocation;
    x.getCurrentPosition(success, failure);
        // function get current position success
    function success(position){
         myLat = position.coords.latitude;
         myLong = position.coords.longitude;

        // set latitude and longitude
        var coords = new google.maps.LatLng(myLat, myLong);

        myLatLng = {
            lat: myLat,
            lng: myLong
        };

        initMap(myLatLng,13);
         
        

    }

     // function get current position fail
    function failure(){
        alert('geolocation failure!');
    }


    var icon_wfo = "https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=|02ff89|ffffff";
    var icon_wfh = "https://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=|ff9d00|ffffff";

    var locations = [
        <?php foreach ($absen as $row) { 
            if($row->status_kerja == "WFO") {
                $icon = 'icon_wfo';
            }else $icon = 'icon_wfh';
          ?>
                      ["<?= $row->nama ?><br><?= $row->status_in_out ?> <?= tanggal_format($row->checktime,'H:i:s') ?>", 
                        <?= $row->lokasi ?>, 
                        4, 
                        <?= $icon ?>
                      ],
        <?php } ?>
    ];

   
    

    function initMap(lokasi,zoom) {


        var map = new google.maps.Map(document.getElementById('map'), {
        zoom: zoom,
        center: lokasi,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      var infowindow = new google.maps.InfoWindow();

      var marker, i;
      
      
      for (i = 0; i < locations.length; i++) {  
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map,
          icon: locations[i][4]
        });
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
          }
        })(marker, i));
      }

       window.setTimeout( loading_false, 1000 );
     
    }

     function loading_false() {
             $('#loading_home').removeClass("show");
     }

    
    </script>

<?php 
    $array_absen = array();
    foreach ($absen as $row) {

        if(!isset($array_absen[$row->status_in_out])){
            $array_absen[$row->status_in_out] = [];
        }
            $array_absen[$row->status_in_out][] = $row;
    }
    

?>

<!-- Modal Basic -->
  <div class="modal fade modalbox" id="ModalBasic" data-backdrop="static" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title"><?= $tgl_peta ?></h5>
                  <a href="javascript:;" data-dismiss="modal">Tutup</a>
              </div>
              <div class="modal-body p-0">
                 <div class="tab-content mt-0">
                    <!-- pilled tab -->
                    <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                          <div class="section full mt-0">
                              <!-- <div class="section-title">Pilled Tabs</div> -->
                              <div class="wide-block pt-2 pb-2 px-0">

                                  <ul class="nav nav-tabs style1" role="tablist">
                                      <li class="nav-item">
                                          <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                              <ion-icon name="return-up-forward-outline"></ion-icon>
                                              Masuk
                                          </a>
                                      </li>
                                      <li class="nav-item">
                                          <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                              <ion-icon name="return-down-back-outline"></ion-icon>
                                              Pulang
                                          </a>
                                      </li>
                                  </ul>
                                  <div class="tab-content mt-2">
                                      <div class="tab-pane fade show active" id="home" role="tabpanel">
                                          <?php if (!empty($array_absen['masuk'])) { ?>
                                              <div class="listview-title mt-2">Absen Masuk (<?= count($array_absen['masuk']) ?>)</div>
                                                  <ul class="listview image-listview">
                                                      <?php $no=1; foreach ($array_absen['masuk'] as $row ) {
                                                          if ($row->status_kerja == "WFH") {
                                                                $bg = "bg-warning";
                                                                $meter = convert_meter($row->jarak);
                                                                $di = "di Luar Kantor (Radius $meter)";
                                                          }else {
                                                             $bg = "bg-success";
                                                             $di = "di Kantor";
                                                          }

                                                          
                                                         
                                                       ?>
                                                      <li>
                                                          <a href="#" class="item pin_map" data-latlong="<?= $row->lokasi ?>">
                                                             <div class="icon-box <?= $bg ?>">
                                                                <!-- <ion-icon name="time-outline"></ion-icon> -->
                                                                <?= $no++; ?>
                                                            </div>
                                                              <div class="in">
                                                                  <div>
                                                                      <header><?= _name($row->nama) ?></header>
                                                                      <?= tanggal_format($row->checktime,'H:i:s') ?>
                                                                      <footer><?= $di ?></footer>

                                                                  </div>
                                                                  <?php 
                                                                      if (!empty($row->time_in_out)) {
                                                                            if (tanggal_format($row->checktime,'H:i') > tanggal_format($row->time_in_out,'H:i')) {
                                                                                echo '<span class="badge badge-danger">Terlambat</span>';
                                                                            }
                                                                      }
                                                                  ?>
                                                                  
                                                              </div>
                                                          </a>
                                                      </li>
                                                    <?php } ?>
                                                  </ul>
                                            <?php } ?>
                                      </div>
                                      <div class="tab-pane fade" id="profile" role="tabpanel">
                                           <?php if (!empty($array_absen['pulang'])) { ?>
                                              <div class="listview-title mt-2">Absen Pulang (<?= count($array_absen['pulang']) ?>)</div>
                                                  <ul class="listview image-listview">
                                                      <?php $no=1; foreach ($array_absen['pulang'] as $row ) {
                                                          if ($row->status_kerja == "WFH") {
                                                                $bg = "bg-warning";
                                                                $meter = convert_meter($row->jarak);
                                                                $di = "di Luar Kantor (Radius $meter)";
                                                          }else {
                                                            $bg = "bg-success";
                                                            $di = "di Kantor";
                                                          }
                                                       ?>
                                                      <li>
                                                          <a href="#" class="item pin_map" data-latlong="<?= $row->lokasi ?>">
                                                             <div class="icon-box <?= $bg ?>">
                                                               <!--  <ion-icon name="time-outline"></ion-icon> -->
                                                               <?= $no++ ?>
                                                            </div>
                                                              <div class="in">
                                                                  <div>
                                                                      <header><?= _name($row->nama) ?></header>
                                                                      <?= tanggal_format($row->checktime,'H:i:s') ?>
                                                                      <footer><?= $di ?></footer>
                                                                  </div>
                                                              </div>
                                                          </a>
                                                      </li>
                                                    <?php } ?>
                                                  </ul>
                                            <?php } ?>
                                      </div>
                                  </div>

                              </div>
                          </div>
                      </div>
                      <!-- * pilled tab -->
                 </div>
              </div>
          </div>
      </div>
  </div>
  <!-- * Modal Basic -->