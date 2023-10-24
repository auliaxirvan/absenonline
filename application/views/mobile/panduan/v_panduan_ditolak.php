<!-- App Header -->
<div class="appHeader no-border transparent">
        <div class="left">
        </div>
        <div class="pageTitle">
            Panduan LKH ditolak
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
                <img src="<?= base_url('assets/images/panduan/lkhtolak1.jpg') ?>" alt="alt" class="imaged w-100 square mb-4" >
                <p>1. Pilih data LKH yang ditolak</p>
            </div>
            <div class="item p-2">
                <img src="<?= base_url('assets/images/panduan/lkhtolak2.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <p>2. perbarui form data lkh, lalu tekan simpan .</p>
            </div>
            <div class="item p-2">
                <img src="<?= base_url('assets/images/panduan/lkhtolak3.jpg') ?>" alt="alt" class="imaged w-100 square mb-4">
                <p>3. data lkh yang diperbarui berhasil di update</p>
                <h2>Selesai</h2>
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