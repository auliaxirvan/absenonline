<!-- App Header -->
<div class="appHeader no-border transparent">
        <div class="left">
        </div>
        <div class="pageTitle">
            Keterangan Indikator & Icon LKH
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
                <img src="<?= base_url('assets/images/panduan/keterangan_icon.jpg') ?>" alt="alt" class="imaged w-100 square mb-4" >
                <p>1. Penjelasan Icon data LKH</p>
            </div>
            <div class="item p-2">
                <img src="<?= base_url('assets/images/panduan/penjelasan_warna_timeline.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <p>2. Penjelasan warna timeline pada verifikasi LKH.</p>
            </div>
            <div class="item p-2">
                <img src="<?= base_url('assets/images/panduan/verifikasi.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <p>3. Saat verifikasi LKH, jika tombol centang dan silang tidak tampil artinya data LKH telah diverifikasi dan jika tombol centang dan silang tampil artinya data LKH harus segera di verifikasi</p>
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