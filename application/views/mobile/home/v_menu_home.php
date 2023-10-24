   <!-- App Header -->
   <div class="appHeader transparent scrolled">
       <div class="pageTitle">
           Home
       </div>
   </div>
   <!-- * App Header -->
   <?php
    date_default_timezone_set('Asia/Jakarta');
    ?>
   <!-- App Capsule -->
   <div id="appCapsule" style="margin-top: -20px;">

       <!-- <div id="alertContainer" class="alert alert-warning" role="alert" style="font-size: 14px;">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="closeAlert()">
               <span aria-hidden="true">&times;</span>
           </button>
           <h4 class="subtitle mb-0 text-white">Hi, <span id="namePlaceholder"></span></h4>
           Jangan lupa untuk melakukan absensi dan mengisi Laporan Kinerja Harian (LKH).
           <br>
       </div> -->

       <div class="header-large-title">
           <h3 class="title" style="font-size: 22px;">Home</h3>
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
        $jam_apel = "--:--:--";
        if (!empty($absen_hari_ini)) {
            foreach ($absen_hari_ini as $row) {
                if ($row->status_in_out == "masuk") {
                    $jam_masuk = tanggal_format($row->checktime, 'H:i:s');
                }

                if ($row->status_in_out == "pulang") {
                    $jam_pulang = tanggal_format($row->checktime, 'H:i:s');
                }
            }
        }
        if (!empty($jadwal_apel->checktime)) {
            $jam_apel = tanggal_format($jadwal_apel->checktime, 'H:i:s');
        }
        ?>
       <div class="section mt-2">
           <div class="col-12 p-0">
               <div class="row">
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
               </div>
           </div>
       </div>
       <?php if (!empty($jadwal_apel_hari_ini) && ($jadwal_apel_hari_ini->name == "Wirid Pengajian Korpri" || $jadwal_apel_hari_ini->name == "Upacara")) {
            if (hari($jadwal_apel_hari_ini->tgl_apel) === "Jumat") {
                $jenis_apel = "Wirid";
            } else if (hari($jadwal_apel_hari_ini->tgl_apel) === "Rabu") {
                $jenis_apel = "Olahraga";
            } else {
                $jenis_apel = "Upacara";
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
        }
        if (!empty($jadwal)) {
            $set_jadwal = start_jadwal_set($jadwal);
            if ($set_jadwal->start_time != "00:00") {
            ?>
               <div class="listview-title mt-2">Jadwal Besok (<?= tgl_indonesia($jadwal->rentan_tanggal) ?>)</div>
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
                               <?php } else { ?>
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
                               <?php } else { ?>
                                   <span class="badge badge-success">di kantor</span>
                               <?php } ?>
                           </div>
                       </div>
                   </li>
               </ul>
           <?php } else if ($set_jadwal->start_time_shift != "00:00") {
            ?>
               <div class="listview-title mt-2">Jadwal Besok (<?= tgl_indonesia($jadwal->rentan_tanggal) ?>)</div>
               <ul class="listview image-listview">
                   <li>
                       <div class="item">
                           <div class="icon-box bg-primary">
                               <ion-icon name="return-up-forward-outline"></ion-icon>
                           </div>
                           <div class="in">
                               <div>
                                   <?= $set_jadwal->start_time_shift ?>
                                   <footer><?= "$set_jadwal->check_in_time1_shift - $set_jadwal->check_in_time2_shift" ?></footer>
                               </div>
                               <?php if ($jadwal->in) { ?>
                                   <span class="badge badge-danger">Luar kantor</span>
                               <?php } else { ?>
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
                                   <?= $set_jadwal->end_time_shift ?>
                                   <footer><?= "$set_jadwal->check_out_time1_shift - $set_jadwal->check_out_time2_shift" ?></footer>
                               </div>
                               <?php if ($jadwal->out) { ?>
                                   <span class="badge badge-danger">Luar kantor</span>
                               <?php } else { ?>
                                   <span class="badge badge-success">di kantor</span>
                               <?php } ?>
                           </div>
                       </div>
                   </li>
               </ul>
           <?php } ?>
       <?php }
        if (!empty($jadwal_apel_hari_ini)) {
            if (hari($jadwal_apel_hari_ini->tgl_apel) === "Jumat") {
                $jenis_apel = "Wirid";
            } else if (hari($jadwal_apel_hari_ini->tgl_apel) === "Rabu") {
                $jenis_apel = "Olahraga";
            } else {
                $jenis_apel = "Upacara";
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
                               <footer><?= tanggal_format($jadwal_apel_hari_ini->start_time, 'H:i'); ?> - <?= tanggal_format($jadwal_apel_hari_ini->end_time, 'H:i'); ?></footer>
                           </div>
                           <?php if ($jadwal_apel_hari_ini->lokasi != NULL) { ?>
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

   <?php if ($pejabat_instansi == TRUE) { ?>
       <!-- welcome notification  -->
       <div id="notification-welcome" class="notification-box">
           <div class="notification-dialog android-style">
               <div class="notification-header">
                   <div class="in">
                       <strong>AbsenOnline</strong>
                       <span>just now</span>
                   </div>
                   <a href="#" class="close-button">
                       <ion-icon name="close"></ion-icon>
                   </a>
               </div>
               <div class="notification-content">
                   <div class="in">
                       <h3 class="subtitle">Hi, <?= _name($biodata->nama_lengkap) ?> </h3>
                       <div class="text">
                           Hai, anda bisa mendapatkan notifikasi absensi pegawai lewat telegram . Dapatkan notifikasi dengan mengklik <a href="https://t.me/SikapBot?start=<?= encrypt_url($this->session->userdata('tpp_user_id'), 'telegram_bot_key', false) ?>">Daftar Sekarang </a>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <!-- * welcome notification -->

   <?php } ?>
   <div id="notification-sikap" class="notification-box">
       <div class="notification-dialog android-style">
           <div class="notification-header">
               <div class="in">
                   <strong>Pemberitahuan</strong>
                   <span>just now</span>
               </div>
               <a href="#" class="close-button">
                   <ion-icon name="close"></ion-icon>
               </a>
           </div>
           <div class="notification-content">
               <div class="in">
                   <h3 class="subtitle">Hi, <?= _name($biodata->nama_lengkap) ?> </h3>
                   <div class="text">
                       Diberitahukan kepada seluruh pengguna aplikasi SIKAP(LKH dan Absensi Online), Laporan Hari Kerja (LKH)
                       tanggal <strong>19 oktober 2023</strong>. Khusus hari ini dapat di isi.
                       Atas perhatiannya kami ucapkan terima kasih!
                   </div>
               </div>
           </div>
       </div>
   </div>
   <script>
       $('#panduan').click(function() {
           window.location.href = "<?= base_url('home/panduan') ?>";
       })
       $('.ambil_absen').click(function() {
           window.location.href = "<?= base_url('absen') ?>";
       })

       $('.owl-carousel').owlCarousel({
           margin: 10,
           loop: true,
           autoWidth: true,
           items: 4
       })


       //    setTimeout(() => {
       //        notification('notification-welcome', 9000);
       //    }, 500);
       //     setTimeout(() => {
       //            notification('notification-sikap',90000);
       //        }, 500);
       //    $(".notification-box .close-button").click(function(event) {
       //        event.preventDefault();
       //        $(".notification-box.show").removeClass("show");
       //    });
       // tap to close notification
       $(".notification-box.tap-to-close .notification-dialog").click(function() {
           $(".notification-box.show").removeClass("show");
       });

       //    //close alert
       //    var alertContainer = document.getElementById('alertContainer');
       //    var namePlaceholder = document.getElementById('namePlaceholder');

       //    var biodata = {
       //        nama_lengkap: "<?= $biodata->nama_lengkap ?>" // Ganti dengan nama yang sesuai
       //    };

       //    namePlaceholder.textContent = biodata.nama_lengkap;

       //    function closeAlert() {
       //        alertContainer.style.display = 'none';
       //    }
   </script>