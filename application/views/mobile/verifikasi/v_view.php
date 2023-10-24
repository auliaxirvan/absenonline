   <!-- App Header -->
   <div class="appHeader bg-light">
        <div class="left">
            <a id="back">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Verifikasi Laporan
        </div>
    </div>
    <!-- * App Header -->
     <!-- App Capsule -->

           <div id="appCapsule">
                <div class="section mt-2">
                    <div class="profile-head">
                        <div class="avatar">
                              <div class="iconedbox iconedbox-xl icon-box">
                                    <ion-icon name="person-circle-outline"></ion-icon>
                                </div>
                        </div>
                        <div class="in">
                            <h3 class="name"> <?php echo nama_icon_nip($user->nama, $user->gelar_dpn,$user->gelar_blk,''); ?></h3>
                            <h5 class="subtext"> <?php echo nama_icon_nip('', '','', $user->jabatan); ?></h5>
                        </div>
                    </div>
                </div>
                 <!-- pilled tab -->
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">

              <div class="section full mt-1">
                  <div class="section-title">Tanggal Verifikasi</div>
                  <div class="wide-block pt-2 pb-2">
                      <ul class="nav nav-tabs style1" role="tablist">
                        <?php  foreach ($tanggal_lkh as $row) {  $tgl_verifikasi[] = $row->rentan_tanggal; ?> 
                          <li class="nav-item" id="tgl_pilih">
                              <a class="tanggal nav-link" data-toggle="tab" href="#home"  da="<?php echo $row->rentan_tanggal; ?>" role="tab">
                              <div style="padding-bottom:15px"><br><br><?php echo tglInd_hrtabel($row->rentan_tanggal) ?></div>
                               <span class="badge bg-danger" id="<?php echo $row->rentan_tanggal ?>" ></span>
                              </a>
                          </li>
                          <?php } ?>
                          <input type="hidden" name="tgl_id" value="0">
                          
                      </ul>
                      <div class="tab-content mt-2 text-center">
                            <span class="spinner-border spinner-border-sm" id="spinner_waktu" role="status" aria-hidden="true" style="display:none;"></span>
                            <div class="tab-pane fade show active" id="home" role="tabpanel">
                            
                            </div>
                      </div>
                  </div>
              </div>
            </div>
              <!-- * pilled tab -->
           </div>
           <input type="hidden" name="user_id" value="<?php echo $user->user_id; ?>">
<script>

var tgl_lkh = <?= json_encode($tgl_verifikasi) ?>;
var user_id = $('[name="user_id"]').val();

$(document).ready(function(){
  load_notif(tgl_lkh);
                        
});
function load_notif(tgl) {
    $.ajax({
          type:"get",
          url: '<?= site_url('/verifikasi/AjaxGet') ?>',
          data:{ mod:'load_notif', id:user_id, tgl, tgl},
          dataType :"JSON",
          cache : true,
              success: function(res){
                    if (res.status) {
                    	var tgl = res.data.tanggal;
                    	var jum = res.data.count;
                    		for (var i = 0; i < jum.length; i++) {
                    			$('#'+tgl[i]).text(jum[i]);
                    		}
                    }
              }
        });
}

  $('.tanggal').click(function(){ 
    $('.tanggal').removeClass("active");
    $(this).addClass("active");    
    
    load_notif(tgl_lkh);
    var da=$(this).attr("da");
    $('input[name="tgl_id"]').val(da);
    var spinner = $('#spinner_waktu');
      $.ajax({
          type: 'POST',
          url: '<?= site_url('/verifikasi/viewJson/') ?>'+<?= $user->id ?>,
          data: {data: $('input[name="tgl_id"]').val()},
          dataType : "JSON",
          error:function(){
            // result.attr("disabled", false);
            spinner.hide();
            // bx_alert('gagal menghubungkan ke server cobalah mengulang halaman ini kembali');
          },
          beforeSend:function(){
            // result.attr("disabled", true);
            spinner.show();
        },
          success: function(res) {
            if (res.status == true) {
              $('#home').html(res.data);
            }else {
            }
            // result.attr("disabled", false);
            spinner.hide();
          }
      });
        return false;
  });
   $('#back').click(function(){
       window.location.href = '<?= site_url('/home?id=lkh')?>';
  });
</script>

                  