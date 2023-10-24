<div class="section full mt-2">
  <?php if(empty($data_verifikator)){?> 
  <?php }else if($data_verifikator[0]->jenis == 3){ ?> 
  <span class="badge badge-info">Dinas Luar
  </span> 
  <?php } ?>
  <?php
if(empty($data_verifikator))
{
echo "<span class='badge badge-warning'>Tidak ada data</span>";
} else {?>
  <div class="custom-control custom-checkbox mb-1">
        <input type="checkbox" class="custom-control-input" id="customCheckb1" data-toggle="modal" data-target="#DialogBasic1" <?php if($jum_data_verifikator == 0) { echo "disabled"; }?>>
        <label class="custom-control-label" for="customCheckb1">Verifikasi semua kegiatan </label>
  </div>
  <div class="wide-block">
    <!-- timeline -->
    <?php echo form_open('/verifikasi/AjaxSaveVerAll/','id="formAjaxAll"'); ?>
    <div class="timeline timed">
      <?php foreach($data_verifikator as $row) :?>
      <div class="item">
        <span class="time"> 
                <?php if($row->status == 0 || $row->status == 4) {?>
                  <input type="hidden" name='ver_all[]' value="<?= $row->id ?>"/>
                <?php } ?>
          <?= $row->jam_mulai; ?> 
          <?= $row->jam_selesai; ?>
        </span>
        <div class="dot <?= cekIconColorProgres($row->status)?>">
        </div>
        <div class="content">
          <h4 class="title">
            <?= $row->kegiatan; ?>
          </h4>
          <div class="text-center">
            <?= $row->hasil; ?>
          </div>
        </div>
        <?php if($row->status == 0 || $row->status == 4) { ?>
        <span class="iconedbox text-success">
          <ion-icon name="checkbox" role="img" class="md hydrated acc" aria-label="add" da="<?= $row->id;?>" data-toggle="modal" data-target="#DialogBasic">
          </ion-icon>
        </span>
        <span class="iconedbox text-danger">
          <ion-icon name="close" role="img" class="md hydrated decc" aria-label="add" da="<?= $row->id;?>" data-toggle="modal" data-target="#DialogForm">
          </ion-icon>
        </span>
        <?php } ?>
      </div>
      <?php endforeach; ?>
    </div>
    <input type="hidden" name='user_id' value="<?= $user->user_id; ?>"/>
    <!-- * timeline -->
        <!-- modal acc all-->
        <div class="modal fade dialogbox" id="DialogBasic1" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="form-group basic">
                <div class="modal-header">
                  <h5 class="modal-title">Yakin verifikasi semua data  ? </h5>  
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                      <button type="button" class="btn btn-text-secondary" data-dismiss="modal" id="close-all">Tutup</button>
                      <button type="submit" class="btn btn-text-primary">Simpan</button>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
<!-- end modal acc all-->
    <?php echo form_close(); ?>
  </div>
  <?php } ?>
</div>
<!-- modal acc -->
<div class="modal fade dialogbox" id="DialogBasic" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <?php echo form_open('/verifikasi/AjaxSaveVer/','id="formAjax"'); ?>
      <div class="form-group basic">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Verifikasi ? 
        </h5>  
      </div>
      <div class="modal-footer">
        <div class="btn-inline">
        <input type="hidden" value="" name="ver" id="ver">
        <input type="hidden" class="form-control" name="user_id_" value="<?= $user->user_id;?>">
        <input type="hidden" class="form-control" name="mod"  value="pilih">
        <button type="button" class="btn btn-text-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-text-primary">Simpan
            </button>
        </div>
      </div>
    </div>
        </div>
    <?php echo form_close(); ?>
  </div>
</div>
<!-- end modal acc -->
<!-- modal decc -->
<div class="modal fade dialogbox" id="DialogForm" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Ditolak ?
        </h5>
      </div>
      <?php echo form_open('verifikasi/AjaxSaveComment/','id="formAjaxComment"'); ?>
        <div class="modal-body text-left mb-2">
          <div class="form-group basic">
            <div class="input-wrapper">
              <label class="label" for="email1">Masukkan alasan ditolak
              </label>
              <textarea type="tolak" class="form-control" id="komentar" name="komentar" placeholder="alasan" rows="3" cols="3" required> </textarea>
              <input type="hidden" value="" name="ver_t" id="ver_t">
              <input type="hidden" class="form-control" name="user_id_" value="<?= $user->user_id;?>">
              <i class="clear-input">/
                <ion-icon name="close-circle">
                </ion-icon>
              </i>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="btn-inline">
            <button type="button" class="btn btn-text-secondary" data-dismiss="modal">Tutup
            </button>
            <button type="submit" class="btn btn-text-primary">Simpan
            </button>
          </div>
        </div>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- end modal decc -->
<script>
    $('#close-all').click(function(){
    $('#customCheckb1').prop('checked',false);
  }
  );

  $('.acc').click(function(){
    var da=$(this).attr("da");
    $('#ver').val(da);
  }
  );
  $('.decc').click(function(){
    var da=$(this).attr("da");
    $('#ver_t').val(da);
  }
  );

  $('#formAjax').submit(function() {
      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType : "JSON",
        error:function(){
        $('#error_page #box-alert').text('Tidak dapat menghubungkan ke internet');
        toastbox('error_page', 2000)
        },
       beforeSend:function(){
        //   result.attr("disabled", true);
        //   spinner.show();
       },
        success: function(res) {
            $('#error_page #box-alert').text(res.message);
            toastbox('error_page', 2000)
          if (res.status == true) {
          	load_notif(tgl_lkh);
              dataLoadButton();
              $('#DialogBasic').modal('hide');
              $('#DialogForm').modal('hide');
          }else {
            // bx_alert(res.message);
          }
        //   result.attr("disabled", false);
        //   spinner.hide();
        }
    });
      return false;
  });

  $('#formAjaxAll').submit(function() {
      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType : "JSON",
        error:function(){
        $('#error_page #box-alert').text('Tidak dapat menghubungkan ke internet');
        toastbox('error_page', 2000)
        },
       beforeSend:function(){
        //   result.attr("disabled", true);
        //   spinner.show();
       },
        success: function(res) {
            $('#error_page #box-alert').text(res.message);
            toastbox('error_page', 2000)
          if (res.status == true) {
          	load_notif(tgl_lkh);
              dataLoadButton();
              $('#DialogBasic1').modal('hide');
          }else {
            // bx_alert(res.message);
          }
        //   result.attr("disabled", false);
        //   spinner.hide();
        }
    });
      return false;
  });

  $('#formAjaxComment').submit(function() {
      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: $(this).serialize(),
        dataType : "JSON",
        error:function(){
          $('#error_page #box-alert').text('Tidak dapat menghubungkan ke internet');
          toastbox('error_page', 2000)
        },
       beforeSend:function(){
          // result.attr("disabled", true);
          // spinner.show();
       },
        success: function(res) {
          $('#error_page #box-alert').text(res.message);
            toastbox('error_page', 2000)
          if (res.status == true) {
          	load_notif(tgl_lkh);
              dataLoadButton();
              $('#DialogBasic').modal('hide');
              $('#DialogForm').modal('hide');
          }else {
            $('#error_page #box-alert').text('Error');
             toastbox('error_page', 2000)
          }
        }
    });
      return false;
  });

  function dataLoadButton()
  {
    $.ajax({
          type: 'POST',
          url: "<?= site_url('/verifikasi/viewJson/').$user->id ?>",
          data: {data: $('input[name="tgl_id"]').val()},
          dataType : "JSON",
          error:function(){
            // result.attr("disabled", false);
            // spinner.hide();
            // bx_alert('gagal menghubungkan ke server cobalah mengulang halaman ini kembali');
          },
          beforeSend:function(){
            // result.attr("disabled", true);
            // spinner.show();
        },
          success: function(res) {
            if (res.status == true) {
              $('#home').html(res.data);
            }else {
            }
            // result.attr("disabled", false);
            // spinner.hide();
          }
      });
        return false;
  }

</script>
