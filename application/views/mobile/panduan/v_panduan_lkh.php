<!-- App Header -->
<div class="appHeader no-border transparent">
        <div class="left">
        </div>
        <div class="pageTitle">
            Panduan LKH
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
                <img src="<?= base_url('assets/images/panduan/addlkh1.jpg') ?>" alt="alt" class="imaged w-100 square mb-4" >
                <p>1. klik tombol tambah</p>
            </div>
            <div class="item p-2">
                <img src="<?= base_url('assets/images/panduan/addlkh2.jpg') ?>"  alt="alt" class="imaged w-100 h-300 square mb-4">
                <p>2. isi form lkh, lalu klik simpan .</p>
                <h2>Selesai Tambah</h2>
            </div>
            <div class="item p-2">
            <h4>Cara edit data LKH</h4>
                <img src="<?= base_url('assets/images/panduan/editlkh1.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <p>1. Pilih data LKH yang akan di edit</p>
            </div> 
            <div class="item p-2">
                <img src="<?= base_url('assets/images/panduan/editlkh2.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <p>2. Klik tombol edit terletak diatas navigasi aplikasi</p>
                <p>3. Ubah data form lalu tekan tombol simpan</p>
                <h2>Selesai Edit</h2>
            </div> 
            <div class="item p-2">
            <h4>Cara hapus data LKH</h4>  
                <img src="<?= base_url('assets/images/panduan/hapuslkh1.jpg') ?>" alt="alt" class="imaged w-100 h-300 square mb-4">
                <p>1. Klik tombol hapus terletak diatas navigasi aplikasi</p>
                <p>2. Pilih hapus </p>
                <h2>Selesai Hapus</h2>
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