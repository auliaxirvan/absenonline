   <!-- App Header -->
   <div class="appHeader bg-light">
        <div class="left">
            <a href="javascript:;" id="back-lkh" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <?php if($datalkh->status == 0 ) :?>
        <div class="right">
            <a href="#" id="remove-lkh" class="headerButton" data-toggle="modal" data-target="#DialogBasic">
                 <ion-icon name="trash"></ion-icon>
            </a>
            <a href="# active" id="edit-lkh" class="headerButton">
                   <ion-icon name="create"></ion-icon>
            </a>
        </div> 
        <?php endif; ?>
        <div class="pageTitle">
        perbaiki laporan ditolak
        </div>
    </div>
    <!-- * App Header -->
     <!-- App Capsule -->
     <div id="appCapsule">
       <div class="section full mb-2">
             <div class="alert alert-warning alert-dismissible p-2">
             <strong>alasan ditolak!</strong> <?php echo $datalkh->comment  ?>.
            </div>
            <div class="wide-block pb-1 pt-2">
            <?php echo form_open('/lkh/AjaxSave','class="form-horizontal" id="formAjax"'); ?>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <div class="wide-block pt-2 pb-2">
                                <div class="custom-control custom-checkbox d-inline">
                                    <input type="checkbox" class="custom-control-input" id="customCheck2" name='dl'  <?php if ($datalkh->jenis == 3) { echo "checked"; } ?>/>
                                    <label class="custom-control-label p-0" for="customCheck2"></label>
                                </div>
                            Melaksanakan Dinas Luar 
                            </div>    
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="name5">Tanggal Kegiatan</label>
                            <input type="text" name="tgl" class="form-control clockpicker" value="<?php echo tgl_ind_hari($datalkh->tgl_lkh) ?>" readonly>
                            <span><i>* tidak dapat merubah tanggal</i></span>
                        </div>
                    </div>
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="email5">Waktu Kegiatan</label>
                            <div class="form-group-feedback form-group-feedback-left">
                                <div class="form-control-feedback">
                                <i class="icon-watch2"></i>
                                </div>
                                <input type="text" name="jam1" class="form-control clockpicker" placeholder="jam mulai" value="<?php echo jm($datalkh->jam_mulai) ?>" readonly>
                                 <span><i>* tidak dapat merubah jam mulai</i></span>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                                <div class="chip chip-secondary ml-05 mb-05">
                                    <span class="chip-label">s/d</span>
                                </div>
                    </div> 
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <div class="form-group-feedback form-group-feedback-left">
                                <div class="form-control-feedback">
                                <i class="icon-pencil3"></i>
                                </div>
                                <input type="text" name="jam2" class="form-control clockpicker" placeholder="jam selesai" value="<?php echo jm($datalkh->jam_selesai) ?>" readonly>
                                <span><i>* tidak dapat merubah jam selesai</i></span>         </div>
                        </div>
                    </div>
                    
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="address5">Uraian Kegiatan</label>
                            <textarea class="ckeditor_text" name="kegiatan" id="kegiatan"><?php echo $datalkh->kegiatan ?></textarea>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="address5">Hasil</label>
                            <textarea class="ckeditor_text" name="hasil" id="hasil"><?php echo $datalkh->hasil ?></textarea>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label" for="address5">Verifikator</label>
                            <div class="profile-head">
                                <div class="avatar">
                                    <div class="iconedbox iconedbox-lg icon-box">
                                        <ion-icon name="person-circle-outline"></ion-icon>
                                    </div>
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
                    <input type="hidden" name="id" value="<?php echo $datalkh->lkh_id; ?>">
                    <input type="hidden" name="mod" value="update">
                    <?php echo form_close() ?> 
            </div>
        </div>
     </div>

     <script>
         $(document).ready(function(){
            function CKupdate(){
            for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();
            }

            $('#formAjax').submit(function() {
                CKupdate();
                var result  = $('#result');
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType :"JSON",
                    error:function(){
                        $('#error_page #box-alert').text('Tidak dapat menghubungkan ke internet');
                        toastbox('error_page', 2000)
                    },
                    beforeSend:function(){

                    },
                    success: function(res) {
                        if (res.status == true) {
                            $('#error_page #box-alert').text(res.message);
                            toastbox('error_page', 2000);
                            window.location.href = '<?= site_url('/home')?>';
                        }else {
                            $('#error_page #box-alert').text(res.message);
                            toastbox('error_page', 2000);
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

            function load_data(id) {
                $.ajax({
                    url: "<?php echo site_url('/home/ajax_get') ?>",
                    data: {id: id},
                    dataType :"json",
                    error:function(){
                        //$('#load').html('');
                        $('#loading_home').removeClass("show");
                    },
                    beforeSend:function(){
                        $('#loading_home').addClass("show");
                        //$('#load').html(loadingdata);
                    },
                    success: function(res){
                        $('#loading_home').removeClass("show");
                        $('#load').html(res.data);
                        }
                    });
                }

                $('#back-lkh').click(function(){
                    load_data('lkh');
                });


                $('#formAjaxDel').submit(function() {
                var result = $('#results');
                $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType :"JSON",
                        error:function(){
                            $('#error_page #box-alert').text('Tidak dapat menghubungkan ke internet');
                            toastbox('error_page', 2000)
                        },
                        beforeSend:function(){
                        },
                        success: function(res) {
                            if (res.status == true) {
                                $('#error_page #box-alert').text(res.message);
                                toastbox('error_page', 2000);
                                window.location.href = '<?= site_url('/home')?>';
                            }else {
                                $('#DialogBasic').modal('hide');
                                $('#error_page #box-alert').text(res.message);
                                toastbox('error_page', 2000);
                                window.location.href = '<?= site_url('/home')?>';
                            }
                        }
                    });
                    return false;
                });
        });


        // $('[name="tgl"]').change(function() {
        //     load_jam($(this).val());
        // })

       



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
