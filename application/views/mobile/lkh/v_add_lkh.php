   <!-- App Header -->
   <div class="appHeader bg-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            LKH
        </div>
    </div>
    <!-- * App Header -->
     <!-- App Capsule -->
     <div id="appCapsule">
       <div class="section full mb-2">
            <?php if ($jumlkh) { ?>
            <div class="alert alert-secondary alert-dismissible p-2">
            <?php echo $jumlkh->ket  ?>.
            </div>
            <?php }else { ?>
            <div class="alert alert-warning alert-dismissible p-2">
            <span class="font-weight-semibold">Anda tidak berhak mengisi form LKH.
            </div>
            <?php }
	
	   if(empty($tanggal_lkh)){ ?>
	    <div class="alert alert-warning alert-dismissible p-2">
            <span class="font-weight-semibold">Peringatan!</span>Jadwal anda belum tersedia mohon hubungi administrator tentang jadwal anda.</div> 
	    <?php } ?>

           <div class="wide-block pb-1 pt-2">

            <?php echo form_open('/lkh/AjaxSave','class="form-horizontal" id="formAjax"'); ?>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <div class="wide-block pt-2 pb-2">
                                <div class="custom-control custom-checkbox d-inline">
                                    <input type="checkbox" class="custom-control-input" id="customCheck2" name='dl'/>
                                    <label class="custom-control-label p-0" for="customCheck2"></label>
                                </div>
                            Melaksanakan Dinas Luar 
                            </div>    
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="name5">Tanggal Kegiatan</label>
                            <select class="form-control select-icons" name="tgl" data-fouc>
                                    <?php $no=1; foreach ($tanggal_lkh as $v) { 
					if(!empty($cek_persentase_kemarin)){ ?>
					<option value="<?php echo $v ?>" data-icon="calendar3"><?php echo tgl_ind_hari($v) ?></option>					                                        
					<?php }else { ?>
					<option value="<?php echo $v ?>" data-icon="calendar3" <?php if($tanggal_lkh[1] === $v) {echo "selected='yes'"; }?>><?php echo tgl_ind_hari($v) ?></option>
					<?php }} ?>  
                            </select>
                        </div>
                        <div class="p-1 mt-1 alert alert-secondary border-0 alert-dismissible" style="margin-top:10px;">
                            Total jam kerja <span id="total_jam"></span>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="email5">Waktu Kegiatan</label>
                            <div class="form-group-feedback form-group-feedback-left">
                                <div class="form-control-feedback">
                                <i class="icon-watch2"></i>
                                </div>
                                <input type="text" name="jam1" class="form-control result" placeholder="jam mulai" readonly="">
                            </div>
                        </div>
                    </div> 
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                                <div class="chip chip-secondary ml-05 mb-05">
                                    <span class="chip-label">s/d</span>
                                </div>
                                <span class="spinner-border spinner-border-sm" id="spinner_waktu" role="status" aria-hidden="true"></span>
                    </div> 
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <div class="form-group-feedback form-group-feedback-left">
                                <div class="form-control-feedback">
                                <i class="icon-pencil3"></i>
                                </div>
                                <input type="text" name="jam2" class="form-control clockpicker readonlyjm" placeholder="jam selesai" autocomplete="off">
                            </div>
                        </div><br>
                        <div class="p-1 m-0 alert alert-secondary border-0 alert-dismissible">
                            Jumlah jam yang harus diisi: <span id="total_jam_reg"></span>
                        </div>
                         <div class="mt-1 progress" >
                            <div class="progress-bar bg-danger" id="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"><span id='percent'>0% Complete</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="address5">Uraian Kegiatan</label>
                            <textarea class="ckeditor_text" name="kegiatan" id="kegiatan"></textarea>
                        </div>
                    </div>
                    <!-- <div class="mt-2">
                        <p id="instructions">Press start Button</p>
                        <a class="btn btn-danger" id="tap-voice">TAP</a>
                    </div>
                     -->
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="address5">Hasil</label>
                            <textarea class="ckeditor_text" name="hasil" id="hasil"></textarea>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="address5">Verifikator</label>
                            <div class="profile-head">
                                <div class="iconedbox iconedbox-xl icon-box">
                                    <ion-icon name="person-circle-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <h3 class="name"><?php if ($verifikator) { echo nama_icon_nip($verifikator->ver_nama, $verifikator->ver_gelar_dpn,$verifikator->ver_gelar_blk,''); ?></h3>
                                    <h5 class="subtext"><?php echo nama_icon_nip('','','',$verifikator->jabatan); } ?> </h5>
                                    <?php 
                                    if ($verifikator->user_id_ver) {
                                        echo '<input type="hidden" name="verifikator" value="'.$verifikator->user_id_ver.'">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <button class="btn btn-danger btn-block" type="submit" id=result>Simpan</button>
                    </div>
                    <input type="hidden" name="jam1_encry">
                    <input type="hidden" name="total_jam_encry">
                    <input type="hidden" name="jam_pulang_encry">
                    <input type="hidden" name="mod" value="add">
                    <?php echo form_close() ?> 
            </div>
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
                    <h3 class="subtitle">Hi, <?= _name($biodata->nama_lengkap) ?> </h3>
                    <div class="text">
                       Diberitahukan kepada seluruh pengguna aplikasi SIKAP(LKH dan Absensi Online), dikarenakan adanya perbaikan penyedia internet pengisian LKH diperpanjang hingga hari Rabu, 2 November 2022. Demikian kami sampaikan mohon maaf atas gangguan ini. Terima Kasih</div>
                </div>
            </div>
        </div>
     </div>

     <script>

         $(document).ready(function(){
            // setTimeout(() => {
            //     notification('notification-sikap',99000);
            // }, 200);
            function CKupdate(){
            for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();
            }

            $('#formAjax').submit(function(e) {
                 var kegiatan = $('#kegiatan');
                 var hasil = $('#hasil');
                CKupdate();
                var result = $('#result');
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType :"JSON",
                    error:function(){
                        $('#error_page #box-alert').text('Tidak dapat menghubungkan ke internet');
                        toastbox('error_page', 2000)
                        result.html('Simpan');
                        result.attr("disabled", false);
                    },
                    beforeSend:function(){
                        result.attr("disabled", true);
                    },
                    success: function(res) {
                        if (res.status == true) {
                            result.removeAttr("disabled", true);
                            load_jam($('[name="tgl"]').val());
                            $('#error_page #box-alert').text(res.message);
                            toastbox('error_page', 5000);
                            $('[name="jam2"]').val('');
                            CKEDITOR.instances.kegiatan.setData("")
                            CKEDITOR.instances.hasil.setData("")
                            // window.location.href = '<?= site_url('/home')?>';
                        }else {
                            // bx_alert_msg(res.message);
                            $('#error_page #box-alert').text(res.message);
                            toastbox('error_page', 5000)
                            result.html('Simpan');
                            result.attr("disabled", false);
                        }
                    }
                });
                return false;
            });
        
            $('.ckeditor_text').each(function(e){
                CKEDITOR.replace( this.id, {  
                height:'130px',
                tabSpaces: 4,
                customConfig: "<?= site_url('assets/themes/plugins/ckeditor/custom/ckeditor_config_text_add_fix.js'); ?>" });
            });

            

            load_jam($('[name="tgl"]').val());
            // var verifikasi = $('[name="cekverifikasi"]').val();
            // if (verifikasi == 1) {
            //     load_verifikasi()
            // }  

            $('.clockpicker').clockpicker({
                placement: 'bottom',
                align: 'left',
                autoclose: true,
            });
            
            $('.readonlyjm').on('focus',function(){
                $(this).trigger('blur');
            });
            
            $('#back-lkh').click(function(){
            window.location.href = '<?= site_url('/home/?id=lkh')?>';
            });

            var speechRecognition = window.webkitSpeechRecognition

            var recognation = new speechRecognition()

            var textbox = $('[name="kegiatan"]'); 
            var instructions = $('#instructions');

            var content = ''


            recognation.continuous = true

            recognation.onstart = function () {
                instructions.text('Voice Recognation is on')
            }

            $("#tap-voice").click(function (event) {
                if(content.length) {
                    content += ''
                }
                recognation.start()
            })

            

            recognation.onspeechend = function () {
                instructions.text("No Activity")
            }
            
            recognation.onerror = function () {
                instructions.text("Try Again")
            }
            
            recognation.onresult = function (event) {
                var current = event.resultIndex;
                var transcript = event.results[current][0].transcript

                content += transcript
                textbox.val(content)

            }


        });

        $('[name="tgl"]').change(function() {
            load_jam($(this).val());
        })

      

        function load_jam(tgl_id) {
            var result  = $('.result');
            var spinner = $('#spinner_waktu');
            $.ajax({
                type: 'get',
                url: "<?= site_url('/lkh/AjaxGet') ?>",
                data: {mod:"time",tgl_id:tgl_id},
                dataType : "JSON",
                error:function(){
                result.attr("disabled", false);
                spinner.hide();
                    bx_alert('gagal menghubungkan ke server cobalah mengulang halaman ini kembali');
                },
                beforeSend:function(){
                result.attr("disabled", true);
                 spinner.show();
                },
                success: function(res) {
                    if (res.status == true) {
                        $('[name="jam1"]').val(res.data.jam_mulai);
                        $('[name="jam1_encry"]').val(res.data.jam_mulai_encry);
                        $('[name="total_jam_encry"]').val(res.data.total_jam_encry);
                        $('[name="jam_pulang_encry"]').val(res.data.jam_pulang_encry);
                        $('#total_jam').text(res.data.total_jam);
                        $('#total_jam_reg').text(res.data.total_jam_reg);
                        
                        $('#progress-bar').animate({width: res.data.persen+"%"}, 100);
                        $('#percent').text(res.data.persen+"%");
                    
                    }
                    result.attr("disabled", false);
                    spinner.hide();
                }
            });
        }

        
        // function load_verifikasi() {
        // $.ajax({
        //         url: "<?= site_url('verifikasi/index') ?>",
        //         dataType :"html",
        //         data:{ modul:'cek'},
        //         cache : true,
        //             success: function(x){
        //                     $('#ModalListview').modal('show');
        //                     $('.modal-body').html(x);
        //             }
        //         });
        // }
     </script>
