 <!-- App Capsule -->
<div id="appCapsule" class="pt-0">

    <div class="login-form mt-1">
        <div class="section">
            <img src="<?php echo base_url('assets/themes/mobile/img') ?>/sample/photo/vector4.png" alt="image" class="form-image">
        </div>
        <div class="section mt-1">
            <h1>Absensi Online</h1>
            <h4>Kabupaten Agam</h4>
        </div>
        <div class="section mt-1 mb-5">
        <?php echo form_open('auth/dologin','class="" id="formAjax"'); ?>
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <i class="clear-input">
                            <ion-icon name="close-circle"></ion-icon>
                        </i>
                    </div>
                </div>

                <div class="form-button-group">
                    <button type="submit" class="btn btn-primary_or btn-block btn-lg" id="result">Login</button>
                </div>

            </form>
        </div>
    </div>

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
                    <h3 class="subtitle">Hi, Pengguna Aplikasi Absensi Online</h3>
                    <div class="text">
                    Mulai hari <b>Kamis,1 Desember 2022</b> khusus ASN akses login menggunakan <b>username & password akun SIMPEG!</b>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
     setTimeout(() => {
            notification('notification-sikap', 100000);
        }, 300);
    $('#formAjax').submit(function() {
        var result = $('#result');
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType :"JSON",
            error:function(){
                $('#error_page #box-alert').text('Tidak dapat menghubungkan ke internet');
                toastbox('error_page', 2000)
                result.html('Login');
                result.attr("disabled", false);
            },
            beforeSend:function(){
                result.html('<span class="spinner-border spinner-border-sm mr-05" role="status" aria-hidden="true"></span> Login');
                result.attr("disabled", true);
            },
            success: function(res) {
                if (res.status == true) {
                    location.reload();
                }else if(res.status == "AKTIVASI"){
                     window.open('https://simpeg.agamkab.go.id/auth/login_service?key='+res.data+'', '_blank');
                    result.html('Login');
                     result.attr("disabled", false);
                //   $('#error_page #box-alert').text('Tidak dapat menghubungkan ke internet');
                }else {
                    // bx_alert_msg(res.message);
                    $('#error_page #box-alert').text(res.message);
                    toastbox('error_page', 2000)
                    result.html('Login');
                    result.attr("disabled", false);
                }
            }
        });
        return false;
    });
</script>