   <!-- App Header -->
    <div class="appHeader transparent scrolled">
        <div class="pageTitle">
            Home
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule" style="margin-top: -20px;">

        <div class="header-large-title">
            <h1 class="title">Home Shift</h1>
            <h4 class="subtitle">Hi, <?= _name($biodata->nama_lengkap) ?></h4>
        </div>
         <div class="section mt-1">
                 <div class="chip chip-media" id="panduan">
                    <i class="chip-icon bg-warning">
                        <ion-icon name="help-circle-outline"></ion-icon>
                    </i>
                    <span class="chip-label">Panduan</span>
                </div>
        </div>

         <div class="section mt-1">
            <div class="text-center">
                 <div class="header-large-title">
                    <h1 class="title" id="waktu"><?= date('H:i:s') ?></h1>
                    <h4 class="subtitle"><?= tgl_indonesia(date('Y-m-d')) ?></h4>
                </div>
            </div>
        </div>

        <?php 
            $jam_masuk = "--:--:--";
            $jam_pulang = "--:--:--";
            $start_date = "--:--:----";
            $end_date = "--:--:----";
	    $jam_apel = "--:--:--";

                if(!empty($absen_masuk)){
                    $start_date = tgl_indonesia($absen_shift_hari_ini->start_date);
                    $jam_masuk = tanggal_format($absen_masuk[0]->checktime,'H:i:s');
                }
                if(!empty($absen_pulang)){
                    $end_date = tgl_indonesia($absen_shift_hari_ini->end_date);
                    $jam_pulang = tanggal_format($absen_pulang[0]->checktime,'H:i:s');
                }
 		        if(!empty($jadwal_apel->checktime)) {
                    $jam_apel = tanggal_format($jadwal_apel->checktime,'H:i:s');
            	}

            // if($absen_shift_hari_ini->start_date != $absen_shift_hari_ini->end_date){
            //     if(!empty($absen_masuk)){
            //         $start_date = tgl_indonesia($absen_shift_hari_ini->start_date);
            //         $jam_masuk = tanggal_format($absen_masuk[0]->checktime,'H:i:s');
            //     }
            //     if(!empty($absen_pulang)){
            //         $end_date = tgl_indonesia($absen_shift_hari_ini->end_date);
            //         $jam_pulang = tanggal_format($absen_pulang[0]->checktime,'H:i:s');
            //     }
            // }

            
            $jam_masuk_kemarin = "--:--:--";
            $jam_pulang_kemarin = "--:--:--";
            $start_date_kemarin = "--:--:----";
            $end_date_kemarin = "--:--:----";
            if(!empty($absen_shift_kemarin)){
                $start_date_kemarin = tgl_indonesia($absen_shift_kemarin->start_date);
                $end_date_kemarin = tgl_indonesia($absen_shift_kemarin->end_date);
                if(!empty($absen_masuk_kemarin)){
                    $jam_masuk_kemarin = tanggal_format($absen_masuk_kemarin[0]->checktime,'H:i:s');
                }
                if(!empty($absen_pulang_kemarin)){
                    $jam_pulang_kemarin = tanggal_format($absen_pulang_kemarin[0]->checktime,'H:i:s');
                }
            }
            
            
        ?>
        <div class="section mt-2">
            <div class="col-12 p-0">
                <div class="row">
                    <?php if($absen_shift_hari_ini->start_date != $absen_shift_hari_ini->end_date || $absen_shift_kemarin->start_date != $absen_shift_kemarin->end_date) {?>
                    <div class="col-6">
                        <div class="card text-center">
                            <div class="card-body px-0  ambil_absen_24jam" data-id="<?= tgl_minus(date("Y-m-d"),1) ?>">
                                <h5 class="text-black">Absen Kemarin  <span class="badge badge-success"><?= $absen_shift_kemarin->kd_shift?></span> </h5>
                                <h5 class="text-black" style="height:30px;"><?= $start_date_kemarin ?></h5>
                                <h5 class="card-title text-primary"><?= $jam_masuk_kemarin ?></h5>
                                 <div class="chip chip-media">
				                    <i class="chip-icon bg-primary">
				                        <ion-icon name="return-up-forward-outline"></ion-icon>
				                    </i>
				                    <span class="chip-label text-nowrap">Absen Masuk</span>
				                </div>
                                <p>
                                <h5 class="text-black"><?= $end_date_kemarin ?></h5>
                                <h5 class="card-title text-primary"><?= $jam_pulang_kemarin ?></h5>
                                 <div class="chip chip-media">
				                    <i class="chip-icon bg-warning">
				                        <ion-icon name="return-down-back-outline"></ion-icon>
				                    </i>
				                    <span class="chip-label text-nowrap">Absen Pulang</span>
				                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card text-center">
                            <div class="card-body px-0 ambil_absen_24jam" data-id="<?= date("Y-m-d") ?>">
                                <h5 class="text-black">Absen Hari Ini <span class="badge badge-success"><?= $absen_shift_hari_ini->kd_shift?></span></h5>
                                <h5 class="text-black" style="height:30px;"><?= tgl_indonesia($absen_shift_hari_ini->start_date) ?></h5>
                                <h5 class="card-title text-primary"><?= $jam_masuk ?></h5>
                                 <div class="chip chip-media">
				                    <i class="chip-icon bg-primary">
				                        <ion-icon name="return-up-forward-outline"></ion-icon>
				                    </i>
				                    <span class="chip-label text-nowrap">Absen Masuk</span>
				                </div>
                                <p>
                                <h5 class="text-black"><?= tgl_indonesia($absen_shift_hari_ini->end_date) ?></h5>
                                <h5 class="card-title text-primary"><?= $jam_pulang ?></h5>
                                 <div class="chip chip-media">
				                    <i class="chip-icon bg-warning">
				                        <ion-icon name="return-down-back-outline"></ion-icon>
				                    </i>
				                    <span class="chip-label text-nowrap">Absen Pulang</span>
				                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                   <div class="col-6">
                        <div class="card text-center">
                            <div class="card-body px-0">
                                <h5 class="card-title text-primary"><?= $jam_masuk ?></h5>
                                 <div class="chip chip-media ambil_absen">
				                    <i class="chip-icon bg-primary">
				                        <ion-icon name="return-up-forward-outline"></ion-icon>
				                    </i>
				                    <span class="chip-label text-nowrap">Absen Masuk</span>
				                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card text-center">
                            <div class="card-body px-0">
                                <h5 class="card-title text-warning"><?= $jam_pulang ?></h5>
                                <div class="chip chip-media ambil_absen">
				                    <i class="chip-icon bg-warning">
				                        <ion-icon name="return-down-back-outline"></ion-icon>
				                    </i>
				                    <span class="chip-label text-nowrap">Absen Pulang</span>
				                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
   	<?php if(!empty($jadwal_apel_hari_ini) && $jadwal_apel_hari_ini->name == "Wirid Pengajian Korpri") { 
         if(hari($jadwal_apel_hari_ini->tgl_apel) === "Jumat"){
            $jenis_apel = "Wirid";
        }else if(hari($jadwal_apel_hari_ini->tgl_apel) === "Rabu"){
            $jenis_apel = "Olahraga";
        }else{
            $jenis_apel = "Apel";
        }
        ?>
            <div class="section mt-2">
                <div class="col-12 p-0">
                    <div class="row">
                        <div class="col-3">
                        </div>
                        <div class="col-6">
                            <div class="card text-center">
                                <div class="card-body px-0">
                                    <h5 class="card-title text-primary"><?= $jam_apel ?></h5>
                                    <div class="chip chip-media ambil_absen">
                                        <i class="chip-icon bg-primary">
                                            <ion-icon name="man-outline"></ion-icon>
                                        </i>
                                        <span class="chip-label text-nowrap">Absen <?= $jenis_apel ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } ?>

        <?php
            if (!empty($jadwal)) {
            $set_jadwal = start_jadwal_set($jadwal);
            if ($set_jadwal->start_time != "00:00") {
                if($set_jadwal->start_date != $set_jadwal->end_date){ ?>
        <div class="listview-title mt-2">Jadwal Masuk Besok (<?= tgl_indonesia($set_jadwal->start_date) ?>)</div>
        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="icon-box bg-primary">
                        <ion-icon name="return-up-forward-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            <?= $set_jadwal->start_time ?>
                            <footer><?= "$set_jadwal->check_in_time1 - $set_jadwal->check_in_time2" ?></footer>
                        </div>
                        <?php if ($jadwal->in) { ?>
                        <span class="badge badge-danger">Luar kantor</span>
                        <?php }else{ ?>
                        <span class="badge badge-success">di kantor</span>
                        <?php } ?>
                    </div>
                </div>
            </li>
        </ul> 
        <div class="listview-title">Jadwal Pulang Besok (<?= tgl_indonesia($set_jadwal->end_date) ?>)</div>
        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="icon-box bg-warning">
                        <ion-icon name="return-down-back-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            <?= $set_jadwal->end_time ?>
                            <footer><?= "$set_jadwal->check_out_time1 - $set_jadwal->check_out_time2" ?></footer>
                        </div>
                         <?php if ($jadwal->out) { ?>
                        <span class="badge badge-danger">Luar kantor</span>
                        <?php }else{ ?>
                        <span class="badge badge-success">di kantor</span>
                        <?php } ?>
                    </div>
                </div>
            </li>
        </ul>
        <?php } else { ?>
        <div class="listview-title">Jadwal Besok (<?= tgl_indonesia($jadwal->rentan_tanggal) ?>)</div>
        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="icon-box bg-primary">
                        <ion-icon name="return-up-forward-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            <?= $set_jadwal->start_time ?>
                            <footer><?= "$set_jadwal->check_in_time1 - $set_jadwal->check_in_time2" ?></footer>
                        </div>
                        <?php if ($jadwal->in) { ?>
                        <span class="badge badge-danger">Luar kantor</span>
                        <?php }else{ ?>
                        <span class="badge badge-success">di kantor</span>
                        <?php } ?>
                    </div>
                </div>
            </li>
            <li>
                <div class="item">
                    <div class="icon-box bg-warning">
                        <ion-icon name="return-down-back-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            <?= $set_jadwal->end_time ?>
                            <footer><?= "$set_jadwal->check_out_time1 - $set_jadwal->check_out_time2" ?></footer>
                        </div>
                         <?php if ($jadwal->out) { ?>
                        <span class="badge badge-danger">Luar kantor</span>
                        <?php }else{ ?>
                        <span class="badge badge-success">di kantor</span>
                        <?php } ?>
                    </div>
                </div>
            </li>
        </ul>
        <?php } } }
 	
	if(!empty($jadwal_apel_hari_ini) && $jadwal_apel_hari_ini->name == "Wirid Pengajian Korpri") {
        if(hari($jadwal_apel_hari_ini->tgl_apel) == "Jumat"){
            $jenis_apel = "Wirid";
        }else if(hari($jadwal_apel_hari_ini->tgl_apel) == "Rabu"){
            $jenis_apel = "Olahraga";
        }else{
            $jenis_apel = "Apel";
        }    
    ?>
        
        <div class="listview-title mt-2"><?= $jenis_apel; ?> Hari Ini (<?= tgl_indonesia($jadwal_apel_hari_ini->tgl_apel) ?>)</div>
        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="icon-box bg-primary">
                        <ion-icon name="man-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            <?= $jadwal_apel_hari_ini->name ?>
                            <footer><?= tanggal_format($jadwal_apel_hari_ini->start_time,'H:i'); ?> - <?= tanggal_format($jadwal_apel_hari_ini->end_time,'H:i'); ?></footer>
                        </div>
                        <?php if($jadwal_apel_hari_ini->lokasi != NULL) {?>
                        <span class="badge badge-success">di <?= $jadwal_apel_hari_ini->lokasi ?></span>
                        <?php } else { ?> 
                        <span class="badge badge-success">di kantor</span>
                        <?php } ?> 
                    </div>
                </div>
            </li>
        </ul>
         <?php }  ?>
    </div>
        

<script>
    $('#panduan').click(function() {
        window.location.href = "<?= base_url('home/panduan') ?>";
    })
    $('.ambil_absen_24jam').click(function() {
        var data_id = $(this).attr("data-id");
        window.location.href = "<?= base_url('absen/index/') ?>"+ data_id;
    });    
    
    $('.ambil_absen').click(function() {
        window.location.href = "<?= base_url('absen') ?>";
    });

    $('.owl-carousel').owlCarousel({
        margin:10,
        loop:true,
        autoWidth:true,
        items:4
    })

</script>

      