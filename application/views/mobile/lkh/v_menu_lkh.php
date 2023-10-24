   <!-- App Header -->
   <div class="appHeader bg-light">
        <div class="pageTitle">
            LKH
        </div>
        <div class="right">
            <a href="#" class="headerButton" data-toggle="modal" data-target="#actionSheetInset">
                <ion-icon name="search-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->
     <!-- App Capsule -->
     <div id="appCapsule">
     <ul class="listview image-listview">
    
     <li>
                <div class="item">
                    <div class="icon-box bg-secondary">
                        <ion-icon name="calendar-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            PERIODE 
                            <footer><?= tanggal_format($this->session->userdata('rank1'),'d-m-Y') ?> -
                            <?= tanggal_format($this->session->userdata('rank2'),'d-m-Y') ?></footer>
                        </div>                  
                    </div>
                </div>
                <div class="item">
                    <div class="in">
                        <footer>
                            <span class="chip-label text-nowrap">Keterangan Warna :</span>
                        <p>
                        <div class="chip chip-media">
                            <i class="chip-icon bg-warning"></i>
                            <span class="chip-label text-nowrap">Belum diverifikasi</span>
                        </div><p>  
                        <div class="chip chip-media">
                            <i class="chip-icon bg-danger"></i>
                            <span class="chip-label text-nowrap">Ditolak</span>
                        </div><p>
                        <div class="chip chip-media">
                            <i class="chip-icon bg-info"></i>
                            <span class="chip-label text-nowrap">Dinas Luar</span>
                        </div><p>
                        <div class="chip chip-media">
                            <i class="chip-icon bg-success"></i>
                            <span class="chip-label text-nowrap">Telah diverifikasi</span>
                        </div> 
                        </footer>              
                    </div>
                </div>
            </li>

        </ul>
        <?php 
            $array_lkh = array();
            foreach ($data_lkh as $row) {
                $temp = [];
                $temp['id']            = $row->id;
                $temp['jam_mulai']            = tanggal_format($row->jam_mulai,'H:i:s');
                $temp['jam_selesai']            = tanggal_format($row->jam_selesai,'H:i:s');
                $temp['persentase']            = $row->persentase;
                $temp['status']            = $row->status;
                $temp['jenis']            = $row->jenis;
                $temp['kegiatan']            = $row->kegiatan;
                $temp['hasil']            = $row->hasil;
                // $temp['status']         = $row->status_in_out;
                // $temp['instansi']       = _name($row->dept_name);
                // $temp['status_kerja']   = $row->status_kerja;
                // $temp['jarak']          = $row->jarak;

                if(!isset($array_lkh[tanggal_format($row->tgl_lkh,'Y-m-d')])){
                    $array_lkh[tanggal_format($row->tgl_lkh,'Y-m-d')] = [];
                }
                    $array_lkh[tanggal_format($row->tgl_lkh,'Y-m-d')][] = $temp;
            }
            
        ?>
        <?php  $no= 1; foreach ($array_lkh as $id => $values) {  ?>
          <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="icon-box bg-primary">
                       <?= tanggal_format($id,'d') ?>
                    </div>
                    <div class="in">
                        <div>
                            <?= tgl_indonesia($id) ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php foreach($values as $key => $v ) { ?>
            <li>
                <a href="<?= url_view($v['id'],$v['status']) ?>" class="item" >
                    <div class="icon-box bg-<?php
                    if($v['jenis'] == 3){
                        echo "info";
                    }else {
                        if($v['status'] == 0) {
                            echo "warning";
                        }elseif($v['status'] == 1) {
                            echo "success";
                        }elseif($v['status'] == 2) {
                            echo "danger";
                        }elseif($v['status'] == 3) {
                            echo "danger";
                        }elseif($v['status'] == 4) {
                            echo "warning";
                        }
                    }?>">
                    <ion-icon name="<?php 
                    if($v['status'] == 0) {
                        echo "hourglass";
                    }elseif($v['status'] == 1) {
                        echo "checkmark-circle";
                    }elseif($v['status'] == 2) {
                        echo "close-circle";
                    }elseif($v['status'] == 3) {
                        echo "close-circle";
                    }elseif($v['status'] == 4) {
                        echo "warning";
                    }?>"></ion-icon>
                    </div>
                    <div class="in">
                        <div style="width: 100%;">       
                          <div class="text"><?= $v['kegiatan']; ?> </div>
                            <footer><?= $v['jam_mulai']; ?> - <?= $v['jam_selesai']; ?> </footer>
                                <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: <?= $v['persentase'];?>%;" aria-valuenow="100"
                                  aria-valuemin="0" aria-valuemax="100"><?= $v['persentase']; ?> %</div>
                                </div>
                        </div>
                    </div>
                </a>
            </li>
            <?php } ?>
        </ul>
        <?php } ?>
        <?php if($verifikator->ver_nama != NULL){ ?>
        <div class="fab-button bottom-right">
            <a href="<?= site_url('/lkh/add')?>" class="fab">
                <ion-icon name="add-outline"></ion-icon>
            </a>
        </div>
        <?php } ?>
     </div>

          <!-- Default Action Sheet Inset -->
    <div class="modal fade action-sheet inset" id="actionSheetInset" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Tanggal</h5>
                </div>
                <div class="modal-body">
                     <div class="action-sheet-content">
                    <form>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name3">Tanggal Awal</label>
                                <input type="date" name="tanggal_1" class="form-control"
                                    placeholder="masukkan tanggal">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                         <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="name3">Tanggal Akhir</label>
                                <input type="date" name="tanggal_2" class="form-control"
                                    placeholder="masukkan tanggal">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <button type="button" class="btn btn-secondary btn-block btn-lg" id="filter_tanggal"
                                data-dismiss="modal">Filter</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- * Default Action Sheet Inset -->

    <?php
                    $verifikasi = '';
                    if ($jumlah_nonver) {
                    $verifikasi = 1;?>

                    <!-- Modal Listview -->
                    <div class="modal fade modalbox" id="ModalListview" data-backdrop="static" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Verifikasi Data LKH</h5>
                                    <a href="javascript:;" data-dismiss="modal">Tutup</a>
                                </div>
                                <div class="modal-body p-0" id="data-verifikasi">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- * Modal Listview -->
                    <?php } ?>
                    <input type="hidden" name="cekverifikasi" value="<?php echo $verifikasi ?>">


    <script>
        
        $(document).ready(function(){   
            var verifikasi = $('[name="cekverifikasi"]').val();
            if (verifikasi == 1) {
                load_verifikasi()
            }  

        });
    
         $('#filter_tanggal').click(function(){
                $('#actionSheetForm').modal('hide');
                if ($('[name="tanggal_1"]').val()=='' || $('[name="tanggal_2"]').val()=='' ) {
                    $('#error_page #box-alert').text('data tanggal harus diisi');
                    toastbox('error_page', 2000)
                }else {
                    load_tanggal();
                }
               
            });

            
            function load_tanggal() {
                $.ajax({
                    url: "<?php echo site_url('home/ajax_get') ?>",
                    data: {
                            id: 'set_tanggal_lkh',
                            'tanggal_1_lkh':$('[name="tanggal_1"]').val(),
                            'tanggal_2_lkh':$('[name="tanggal_2"]').val(),
                          },
                    dataType :"json",
                    error:function(){
                        
                    },
                    beforeSend:function(){
                       
                    },
                    success: function(res){
                        if(res.status == true) {
                            window.setTimeout( show_popup, 1000 );
                        }
                    }
                });
            }
            function show_popup() {
                load_data('lkh');
            } 

            function load_verifikasi() {
            $.ajax({
                    url: "<?php echo site_url('verifikasi/index') ?>",
                    dataType :"html",
                    data:{ modul:'cek'},
                    cache : true,
                        success: function(x){
                                $('#ModalListview').modal('show');
                                $('#data-verifikasi').html(x);
                        }
                    });
            }
    </script>
                