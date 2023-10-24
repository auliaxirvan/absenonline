   <!-- App Header -->
   <div class="appHeader bg-light">
        <div class="pageTitle">
            Laporan
        </div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#actionSheetInset">
                <ion-icon name="search-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->


    <!-- App Capsule -->
    <div id="appCapsule">

    	<ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="icon-box bg-secondary">
                        <ion-icon name="calendar-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            PERIODE
                            <footer><?= tanggal_format($this->session->userdata('rank1'),'d-m-Y') ?> -
                            <?= tanggal_format($this->session->userdata('rank2'),'d-m-Y') ?></footer>
                        </div>
                        
                    </div>
                </div>
            </li>
        </ul>

        <?php $no=1;
       
        $data_report = start_jadwal_report($laporan);
        foreach ($data_report as $id) {
         if(!empty($id->jam_masuk || !empty($id->jam_pulang))) {
        ?>
        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="icon-box bg-success">
                       <?= tanggal_format($id->rentan_tanggal,'d') ?>
                    </div>
                    <div class="in">
                        <div>
                          <?= tgl_indonesia($id->rentan_tanggal) ?>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <?php 
                // $jam_masuk = jam_masuk_tabel($id->jam_masuk, $id->jam_masuk_shift,$id->status_in,$id->start_time_notfixed, $id->jam_masuk_notfixed);
                // $jam_pulang = jam_pulang_tabel($id->jam_pulang, $id->jam_pulang_shift, $id->status_out, $id->end_time_notfixed, $id->jam_pulang_notfixed);
                 if ($id->status_kerja_masuk == "WFO") {                     
                        $lokasi_masuk = 'di '._name($id->dept_masuk);
                        $icon_color_pin_masuk = 'bg-success';
                }else if($id->status_kerja_masuk == "WFH") {
                        if (!empty($id->jarak_masuk)) {
                            $jar_m = convert_meter($id->jarak_masuk);
                            $jarak_m = "(Radius $jar_m)";
                        }else $jarak ="";
                            $lokasi_masuk = "di Luar Kantor $jarak_m";
                            $icon_color_pin_masuk = 'bg-danger';
                } else if($id->status_in == "1") {
                    $lokasi_masuk = _name($id->dept_masuk); 
                }else {
                    $lokasi_masuk = 'Mesin finger di '._name($id->dept_masuk); 
                }

                if ($id->status_kerja_pulang == "WFO") {                     
                        $lokasi_pulang = 'di '._name($id->dept_pulang);
                        $icon_color_pin_pulang = 'bg-success';
                }else if($id->status_kerja_pulang == "WFH") {
                        if (!empty($id->jarak_pulang)) {
                            $jar_p = convert_meter($id->jarak_pulang);
                            $jarak_p = "(Radius $jar_p)";
                        }else $jarak ="";
                            $lokasi_pulang = "di Luar Kantor $jarak_p";
                            $icon_color_pin_pulang = 'bg-danger';
                } else if($id->status_out == "1") {
                    $lokasi_pulang = _name($id->dept_masuk); 
                }else {
                     $lokasi_pulang = 'Mesin finger di '._name($id->dept_pulang); 

                }
                ?>
                <?php if(!empty($id->jam_masuk)) {?>
                <div class="item">
                    <div class="icon-box bg-primary">
                        <ion-icon name="return-up-forward-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            <?= $id->jam_masuk ?>
                            <footer><?php if(!empty($id->alamat_lokasi)) { echo "di ".$id->alamat_lokasi; }else{ echo $lokasi_masuk; } ?></footer>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if(!empty($id->jam_pulang)) {?>
                <div class="item">
                    <div class="icon-box bg-warning">
                        <ion-icon name="return-down-back-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            <?= $id->jam_pulang ?>
                            <footer><?= $lokasi_pulang ?></footer>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </li>
        </ul>
        <?php    
              }
            }
        ?>
     </div>

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
                                <label class="label" for="name3">Tanggal Awal</label>
                                <input type="date" name="tanggal_1" class="form-control"
                                    placeholder="masukkan tanggal">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                         <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name3">Tanggal Akhir</label>
                                <input type="date" name="tanggal_2" class="form-control"
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


        <script>
            $('#filter_tanggal').click(function(){
                $('#actionSheetForm').modal('hide');
                if ($('[name="tanggal_1"]').val()=='' || $('[name="tanggal_2"]').val()=='' ) {
                    $('#error_page #box-alert').text('data tanggal harus diisi');
                    toastbox('error_page', 2000)
                }else {
                    load_tanggal();
                }
               
            });

            function load_tanggal() {
                $.ajax({
                    url: "<?php echo site_url('home/ajax_get') ?>",
                    data: {
                            id: 'set_tanggal',
                            'tanggal_1':$('[name="tanggal_1"]').val(),
                            'tanggal_2':$('[name="tanggal_2"]').val(),
                          },
                    dataType :"json",
                    error:function(){
                        
                    },
                    beforeSend:function(){
                       
                    },
                    success: function(res){
                        if(res.status == true) {
                            //load_data('laporan');
                            window.setTimeout( show_popup, 1000 );
                        }
                    }
                });
            } 

            function show_popup() {
                load_data('laporan');
            }
        </script>
       
    <!-- * App Capsule -->