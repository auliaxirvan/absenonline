   <!-- App Header -->
   <div class="appHeader bg-primary scrolled">
        <div class="pageTitle">
            Profil
        </div>
    </div>
    <!-- * App Header -->

    <!-- Search Component -->
    <div id="search" class="appHeader">
        <form class="search-form">
            <div class="form-group searchbox">
                <input type="text" class="form-control" placeholder="Search...">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
                <a href="javascript:;" class="ml-1 close toggle-searchbox">
                    <ion-icon name="close-circle"></ion-icon>
                </a>
            </div>
        </form>
    </div>
    <!-- * Search Component -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="icon-box bg-secondary">
                        <ion-icon name="person-circle-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            <?php echo name_degree(_name($biodata->nama),$biodata->gelar_dpn,$biodata->gelar_blk)   ?>
                            <footer><?php echo $biodata->status_pegawai ?></footer>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="icon-box">
                       <!--  <ion-icon name="person-circle-outline"></ion-icon> -->
                    </div>
                    <div class="in">
                        <div>
                            Instansi
                            <footer><?php echo _name($instansi->dept_name) ?>
                                    </br><?php echo $instansi->alamat ?>
                            </footer>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <div class="section mt-2">
            <div class="section-title">Jadwal yang akan datang</div>
            <div class="carousel-multiple owl-carousel owl-theme ml-0">
                <?php if (!empty($jadwal)) {
                        foreach ($jadwal as $row) {
                            $set_jadwal = start_jadwal_set($row);

                            if ($set_jadwal->start_time != "00:00") {
                                $bg_color = "bg-success";
                                $set_masuk = "$set_jadwal->start_time ($set_jadwal->check_in_time1 - $set_jadwal->check_in_time2) ";
                                $set_pulang = "$set_jadwal->end_time ($set_jadwal->check_out_time1 - $set_jadwal->check_out_time2) ";
                            }else {
                                $bg_color = "bg-danger";
                                $set_masuk = "Libur";
                                $set_pulang = "Libur";
                            }
                 ?>
                <div class="item">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <div class="chip chip-media">
                                    <i class="chip-icon <?= $bg_color ?>">
                                        <ion-icon name="calendar-outline"></ion-icon>
                                    </i>
                                    <span class="chip-label text-nowrap"><?= tgl_indonesia($row->rentan_tanggal) ?></span>
                                </div>
                            </div>
                            <div>
                                 <div class="chip chip-media mt-1">
                                    <i class="chip-icon bg-primary">
                                        <ion-icon name="return-up-forward-outline"></ion-icon>
                                    </i>
                                    <span class="chip-label text-nowrap"><?= $set_masuk ?></span>
                                </div>
                            </div>
                           
                            <div>
                                <div class="chip chip-media mt-1">
                                    <i class="chip-icon bg-warning">
                                        <ion-icon name="return-down-back-outline"></ion-icon>
                                    </i>
                                    <span class="chip-label text-nowrap"><?= $set_pulang ?></span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
               <?php } } ?>
            </div>

        </div>


       <!--  <div class="section mt-2">
            <div class="card text-center">
                <div class="card-header">
                    Profil
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $biodata->nama_lengkap ?></h5>
                    <p class="card-text"><?= $instansi->dept_name ?></p>
                </div>
            </div>
        </div> -->


        <!-- <div class="section full mt-2">
            <div class="section-title">Kehadiran Bulan ini</div>
            <div class="wide-block pt-2 pb-2">
                <div class="row">
                    <div class="col-4">
                        <div id="circle1" class="circle-progress">
                            <div class="in">
                                <div class="text">
                                    <h3 class="value">0</h3>
                                    Hadir
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div id="circle2" class="circle-progress">
                            <div class="in">
                                <div class="text">
                                    <h3 class="value">0</h3>
                                    Terlambar
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div id="circle3" class="circle-progress">
                            <div class="in">
                                <div class="text">
                                    <h3 class="value">0</h3>
                                    Pulang Cepat
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div> -->

    </div>

    <script>
    $('#circle1').circleProgress({
            value: 1,
            size: 500, // do not delete this
            fill: {
                gradient: ["#1E74FD", "#592BCA"]
            },
            animation : {
                duration: 2000
            }
        });
        $('#circle2').circleProgress({
            value: 1,
            size: 500, // do not delete this
            fill: {
                gradient: ["#EC4433", "#FE9500"]
            },
            animation : {
                duration: 2000
            }
        });
        $('#circle3').circleProgress({
            value: 1,
            size: 500, // do not delete this
            fill: {
                gradient: ["#00CDFF", "#1E74FD"]
            },
            animation : {
                duration: 2000
            }
        });

    $('.owl-carousel').owlCarousel({
        margin:10,
        loop:true,
        autoWidth:true,
        items:4
    })
    </script>