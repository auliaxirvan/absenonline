<!-- App Header -->
<div class="appHeader no-border transparent">
        <div class="left">
        </div>
        <div class="pageTitle">
            Panduan Absen
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
                <img src="<?= base_url('assets/images/11.jpg') ?>" alt="alt" class="imaged w-100 square mb-4" >
                <p>1. klik tombol ambil absen</p>
            </div>
            <div class="item p-2">
                <img src="<?= base_url('assets/images/12.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <p>2. cek gps lalu klik ambil absen.</p>
            </div>
            <div class="item p-2">
                <img src="<?= base_url('assets/images/13.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <h2>Selesai</h2>
                <p>3. absen akan tampil pada halaman home</p>
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