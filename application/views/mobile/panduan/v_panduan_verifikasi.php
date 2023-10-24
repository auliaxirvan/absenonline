<!-- App Header -->
<div class="appHeader no-border transparent">
        <div class="left">
        </div>
        <div class="pageTitle">
            Panduan Verifikasi
        </div>
        <div class="right">
            <a href="javascript:;" class="headerButton text-secondary goBack">
                Skip
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- App Capsule -->
    <div id="appCapsule">


        <div class="carousel-slider owl-carousel owl-theme">
            <div class="item p-2"> 
                <img src="<?= base_url('assets/images/panduan/verifikasilkh1.jpg') ?>" alt="alt" class="imaged w-100 square mb-4" >
                <p>1. Jika status anda sebagai verifikator, aplikasi akan menampilkan data LKH yang belum diverifikasi, pilih data yang akan di verifikasi</p>
            </div>
            <div class="item p-2">
                <img src="<?= base_url('assets/images/panduan/verifikasilkh2.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <p>2. Pilih tanggal yang akan diverifikasi, jika data LKH benar pilih tombol centang.</p>
            </div>
            <div class="item p-2">
                <img src="<?= base_url('assets/images/panduan/verifikasilkh3.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <p>3. aplikasi akan meminta persetujuan verifikasi LKH, jika diterima pilih tombol simpan</p>
                <h2>Selesai di verifikasi</h2>
            </div>
            <div class="item p-2">
                <img src="<?= base_url('assets/images/panduan/verifikasilkh4.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <p>4. jika data tidak benar dan anda menolak data LKH, pilih tombol silang pada aplikasi</p>
            </div>
            <div class="item p-2">
                <img src="<?= base_url('assets/images/panduan/verifikasilkhtolak1.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <p>5. aplikasi akan meminta persetujuan verifikasi LKH, masukkan alasan penolakan lalu pilih tombol simpan</p>
                <h2>Selesai menolak LKH</h2>
            </div>
        </div>

        <div class="carousel-button-footer">
            <div class="row">
                <div class="col-6">
                    <a href="javascript:;" class="btn btn-secondary btn-lg btn-block" id="backItem">Sebelumnya</a>
                </div>
                <div class="col-6">
                    <a href="javascript:;" class="btn btn-primary btn-lg btn-block" id="nextItem">Selanjutnya</a>
                </div>
            </div>
        </div>


    </div>
    <!-- * App Capsule -->

    <script>
        var slider = $('.owl-carousel');

        $('#nextItem').click(function () {
            slider.trigger('next.owl.carousel');
        });
        $('#backItem').click(function () {
            slider.trigger('prev.owl.carousel');
        });
    </script>