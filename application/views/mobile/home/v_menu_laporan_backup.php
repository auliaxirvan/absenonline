   <!-- App Header -->
   <div class="appHeader bg-light">
        <div class="pageTitle">
            Laporan
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
            </li>
        </ul>

        <?php 
            $array_laporan = array();
            foreach ($laporan as $row) {
                $temp = [];
                $temp['jam']            = tanggal_format($row->checktime,'H:i:s');
                $temp['status']         = $row->status_in_out;
                $temp['instansi']       = _name($row->dept_name);
                $temp['status_kerja']   = $row->status_kerja;
                $temp['jarak']          = $row->jarak;

                if(!isset($array_laporan[tanggal_format($row->checktime,'Y-m-d')])){
                    $array_laporan[tanggal_format($row->checktime,'Y-m-d')] = [];
                }
                    $array_laporan[tanggal_format($row->checktime,'Y-m-d')][] = $temp;
            }
            
        ?>
        <?php $no=1;
              foreach ($array_laporan as $id => $values) { ?>
        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="icon-box bg-success">
                       <?= tanggal_format($id,'d') ?>
                    </div>
                    <div class="in">
                        <div>
                            <?= tgl_indonesia($id) ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php foreach ($values as $key => $v) { 
            		$icon_color ='';
                    $icon_jam = '';
                    if ($v['status'] == "masuk") {
                         $icon_jam = 'return-up-forward-outline';
                         $icon_color = 'bg-primary';
                    }
                    if ($v['status'] == "pulang") {
                        $icon_jam = 'return-down-back-outline';
                        $icon_color = 'bg-warning';
                    }

                    if ($v['status_kerja'] == "WFO") {
                            $lokasi = 'di '.$v['instansi'];
                            $icon_color_pin = 'bg-success';
                    }else {
                            if (!empty($v['jarak'])) {
                                $jar = convert_meter($v['jarak']);
                                $jarak = "(Radius $jar)";
                            }else $jarak ="";

                            $lokasi = "di Luar Kantor $jarak";
                            $icon_color_pin = 'bg-danger';
                    }

            	?>
            <li>
                <div class="item">
                    <div class="icon-box <?= $icon_color ?>">
                        <ion-icon name="<?= $icon_jam ?>"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            <?= $v['jam'] ?>
                            <footer><?= $lokasi ?></footer>
                        </div>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
        <?php    
            }
        ?>
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


        <script>
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
                            id: 'set_tanggal',
                            'tanggal_1':$('[name="tanggal_1"]').val(),
                            'tanggal_2':$('[name="tanggal_2"]').val(),
                          },
                    dataType :"json",
                    error:function(){
                        
                    },
                    beforeSend:function(){
                       
                    },
                    success: function(res){
                        if(res.status == true) {
                            //load_data('laporan');
                            window.setTimeout( show_popup, 1000 );
                        }
                    }
                });
            } 

            function show_popup() {
                load_data('laporan');
            }
        </script>
       
    <!-- * App Capsule -->