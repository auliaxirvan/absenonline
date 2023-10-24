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
            <h1 class="title">Home</h1>
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

         <div class="section mt-2">
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
            if(!empty($absen_hari_ini)) {
                 foreach ($absen_hari_ini as $row) {
                        if ($row->status_in_out == "masuk") {
                            $jam_masuk = tanggal_format($row->checktime,'H:i:s');
                        }

                        if ($row->status_in_out == "pulang") {
                            $jam_pulang = tanggal_format($row->checktime,'H:i:s');
                        }
                 }                   
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

       
    </div>
        

 <!-- Panel Left -->
 <div class="modal fade panelbox panelbox-left" id="PanelLeft" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Panduan Aplikasi</h4>
                <a href="javascript:;" data-dismiss="modal" class="panel-close">
                    <ion-icon name="close-outline"></ion-icon>
                </a>
            </div>
            <div class="modal-body">
                <p>
                    <h5>Fungsi Menu</h5>
                    <ol>
                        <li>Home - Menampilkan halaman awal pada aplikasi</li>
                        <li>Peta - Menampilkan lokasi absen teman sekantor</li>
                        <li>Laporan - Menampilkan laporan absen masing-masing pengguna</li>
                        <li>profil - Menampilkan data pengguna</li>
                    </ol>
                </p>
                <hr>
                <p>
                    <h5>Panduan Absen Masuk/Pulang</h5>
                    <ol>
                        <li>Klik tombol ambil absen</li>
                        <li>Pilih absen sesuai jadwal kerja anda (WFO/WFH) lalu klik Ambil Absen (pastikan anda mengaktifkan GPS perangkat anda)</li>
                        <li>Data Absen yang telah di entri akan tampil pada halaman awal</li>
                    </ol>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- * Panel Left -->
<script>
    $('#panduan').click(function() {
        window.location.href = "<?= base_url('home/panduan') ?>";
    })
    $('.ambil_absen').click(function() {
        window.location.href = "<?= base_url('absen') ?>";
    })

 

    // $('.owl-carousel').owlCarousel({
    //     loop:true,
    //     margin:10,
    //     responsiveClass:true,
    //     responsive:{
    //         0:{
    //             items:1,
    //             nav:true
    //         },
    //         600:{
    //             items:3,
    //             nav:false
    //         },
    //         1000:{
    //             items:5,
    //             nav:true,
    //             loop:false
    //         }
    //     }
    // })
</script>

      