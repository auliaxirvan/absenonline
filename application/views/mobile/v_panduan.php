<!-- App Header -->
<div class="appHeader no-border transparent">
        <div class="left">
        </div>
        <div class="pageTitle">
            Panduan
        </div>
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section full mt-2">
            <div class="wide-block pt-2 pb-2">
                <div class="row ">
                    <div class="col-6 mb-2">
                        <a class="card h-100 align-items-center justify-content-center" href="<?= site_url('/home/panduan_absen')?>">
                            <img src="<?= base_url('assets/images/icon_panduan/icon_absen.png') ?>"class="card-img" alt="image" style="margin-top:10px; width:45px; height:45px">
                            <div class="card-body pt-1 text-center">
                                <h4 class="mb-0">Panduan cara mengambil absen</h4>
                            </div>
                        </a> 
                    </div>
                    <div class="col-6 mb-2">
                        <a class="card h-100 align-items-center justify-content-center" href="<?= site_url('/home/panduan_lkh')?>">
                            <img src="<?= base_url('assets/images/icon_panduan/icon_lkh.png') ?>" class="card-img" alt="image" style="margin-top:10px; width:45px; height:45px">
                            <div class="card-body pt-1 text-center">
                                <h4 class="mb-0">Panduan penggunaan fitur LKH </h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 mb-2">
                        <a class="card h-100 align-items-center justify-content-center" href="<?= site_url('/home/panduan_verifikasi')?>">
                            <img src="<?= base_url('assets/images/icon_panduan/icon_verifikasi.png') ?>"class="card-img" alt="image" style="margin-top:10px;  width:45px; height:45px">
                            <div class="card-body pt-1 text-center">
                                <h4 class="mb-0">Panduan verifikasi data LKH</h4>
                            </div>
                        </a> 
                    </div>
                    <div class="col-6 mb-2">
                        <a class="card h-100 align-items-center justify-content-center" href="<?= site_url('/home/panduan_ditolak')?>">
                            <img src="<?= base_url('assets/images/icon_panduan/icon_decline.png') ?>"class="card-img" alt="image" style="margin-top:10px;  width:45px; height:45px">
                            <div class="card-body pt-1 text-center">
                                <h4 class="mb-0">Panduan jika data LKH ditolak</h4>
                            </div>
                        </a> 
                    </div>
                    <div class="col-12 mb-2">
                        <a class="card h-100 align-items-center justify-content-center" href="<?= site_url('/home/panduan_indikator')?>">
                            <img src="<?= base_url('assets/images/icon_panduan/icon_keterangan.png') ?>" class="card-img" alt="image" style="margin-top:10px; width:45px; height:45px">
                            <div class="card-body pt-1 text-center">
                                <h4 class="mb-0">Keterangan Indikator & Icon fitur LKH</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 mb-2">
                        <a class="card h-100 align-items-center justify-content-center" href="https://www.youtube.com/watch?v=Mukz1VTP1sE">
                            <img src="<?= base_url('assets/images/icon_panduan/icon_youtube.png') ?>" class="card-img" alt="image" style="margin-top:10px; width:45px; height:45px">
                            <div class="card-body pt-1 text-center">
                                <h4 class="mb-0">Video Panduan Aplikasi Absen Online</h4>
                            </div>
                        </a>
                    </div>
                    
                </div>
               
                <!-- <div class="row" style="margin-top:10px;">
                    <div class="col-12">
                        <div class="item">
                            <div class="card" style="align-items: center; justify-content: center;">
                                <div class="embed-responsive embed-responsive-21by9" style="height:600px;">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/GemwGD_Lgpk" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <script>
        var slider = $('.owl-carousel');

        $('#nextItem').click(function () {
            slider.trigger('next.owl.carousel');
        });
    </script>