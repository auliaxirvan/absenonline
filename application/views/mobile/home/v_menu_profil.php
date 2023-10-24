<?php 

$jum_hari_kerja_rekap   = array(0);
$jum_hadir_kerja_rekap  = array(0);
$jum_terlambar_rekap    = array(0);
$jum_pulang_cepat_rekap = array(0);
$jum_tk_rekap           = array(0);
$jum_tidak_upacara_rekap= array(0);
$jum_tidak_sholatza_rekap= array(0);
$jum_dinas_luar_rekap   = array(0);
$jum_cuti_rekap         = array(0);  
$user = array();

foreach ($pegawai_absen as $row) {
    $jum_hari_kerja_rekap[]     = jum_hari_kerja_rekap($row->json_absen);
    $jum_hadir_kerja_rekap[]    = jum_hadir_kerja_rekap($row->json_absen);
    $jum_terlambar_rekap[]      = jum_terlambar_rekap($row->json_absen);
    $jum_pulang_cepat_rekap[]   = jum_pulang_cepat_rekap($row->json_absen);
    $jum_tk_rekap[]             = jum_tk_rekap($row->json_absen);
    $jum_tidak_upacara_rekap[]  = jum_tidak_upacara_rekap($row->json_absen);
    $jum_tidak_sholatza_rekap[] = jum_tidak_sholatza_rekap($row->json_absen, $row->agama_id);
    $jum_dinas_luar_rekap[]     = jum_dinas_luar_rekap($row->json_absen);
    $jum_cuti_rekap[]           = jum_cuti_rekap($row->json_absen);  
    $user[] = 1;  
}

$jum_hari_kerja_rekap_sum   = array_sum($jum_hari_kerja_rekap);
$jum_hadir_kerja_rekap_sum  = array_sum($jum_hadir_kerja_rekap);
$jum_terlambar_rekap_sum    = array_sum($jum_terlambar_rekap);
$jum_pulang_cepat_rekap_sum = array_sum($jum_pulang_cepat_rekap);
$jum_tk_rekap_sum           = array_sum($jum_tk_rekap);
$jum_tidak_upacara_rekap_sum= array_sum($jum_tidak_upacara_rekap);
$jum_tidak_sholatza_rekap_sum= array_sum($jum_tidak_sholatza_rekap);
$jum_dinas_luar_rekap_sum   = array_sum($jum_dinas_luar_rekap);
$jum_cuti_rekap_sum         = array_sum($jum_cuti_rekap); 
$jum_user = count($user);

?>
   <!-- App Header -->
   <div class="appHeader bg-primary scrolled">
        <div class="pageTitle">
            Profil
        </div>
    </div>
    <!-- * App Header -->

    <!-- Search Component -->
    <div id="search" class="appHeader">
        <form class="search-form">
            <div class="form-group searchbox">
                <input type="text" class="form-control" placeholder="Search...">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
                <a href="javascript:;" class="ml-1 close toggle-searchbox">
                    <ion-icon name="close-circle"></ion-icon>
                </a>
            </div>
        </form>
    </div>
    <!-- * Search Component -->

    <!-- App Capsule -->
    <div id="appCapsule">

        <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="icon-box bg-secondary">
                        <ion-icon name="person-circle-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            <?php echo name_degree(_name($biodata->nama),$biodata->gelar_dpn,$biodata->gelar_blk)   ?>
                            <footer><?php echo $biodata->status_pegawai ?></footer>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="icon-box">
                       <!--  <ion-icon name="person-circle-outline"></ion-icon> -->
                    </div>
                    <div class="in">
                        <div>
                            Instansi
                            <footer><?php echo _name($instansi->dept_name) ?>
                                    </br><?php echo $instansi->alamat ?>
                            </footer>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="section mt-1 p-0">
            <div id="pengguna">
        </div>
         <ul class="listview image-listview">
            <li>
                <div class="item">
                    <div class="icon-box bg-primary">
                        <ion-icon name="return-up-forward-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            Hadir
                        </div>
                        <span class="badge badge-primary"><?php echo $jum_hadir_kerja_rekap_sum ?></span>
                    </div>
                </div>
            </li>
            <li>
                <div class="item">
                    <div class="icon-box bg-dark">
                        <ion-icon name="return-up-forward-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            Terlambat
                        </div>
                        <span class="badge badge-primary"><?php echo $jum_terlambar_rekap_sum ?></span>
                    </div>
                </div>
            </li>
            <li>
                <div class="item">
                    <div class="icon-box bg-success">
                        <ion-icon name="return-up-forward-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            Pulang Cepat
                        </div>
                        <span class="badge badge-primary"><?php echo $jum_pulang_cepat_rekap_sum ?></span>
                    </div>
                </div>
            </li>
            <li>
                <div class="item">
                    <div class="icon-box bg-warning">
                        <ion-icon name="return-up-forward-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            Tanpa Keterangan (TK)
                        </div>
                        <span class="badge badge-primary"><?php echo $jum_tk_rekap_sum ?></span>
                    </div>
                </div>
            </li>
            <li>
                <div class="item">
                    <div class="icon-box bg-info">
                        <ion-icon name="return-up-forward-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            Dinas Luar 
                        </div>
                        <span class="badge badge-primary"><?php echo $jum_dinas_luar_rekap_sum ?></span>
                    </div>
                </div>
            </li>
             <li>
                <div class="item">
                    <div class="icon-box bg-danger">
                        <ion-icon name="return-up-forward-outline"></ion-icon>
                    </div>
                    <div class="in">
                        <div>
                            Cuti 
                        </div>
                        <span class="badge badge-primary"><?php echo $jum_cuti_rekap_sum ?></span>
                    </div>
                </div>
            </li>
        </ul>
    </div>

<script type="text/javascript">
    $(function () {

        $(document).ready(function () {

        // Build the chart
        $('#pengguna').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Kehadiran Bulan ini'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: "Persentase",
                colorByPoint: true,
                data: [
                    {
                        name: "Hadir",
                        y: <?php echo $jum_hadir_kerja_rekap_sum ?>                }, 
                    
                    {
                        name: "Terlambat",
                        y: <?php echo $jum_terlambar_rekap_sum ?>                }, 
                    {
                        name: "Pulang Cepat",
                        y: <?php echo $jum_pulang_cepat_rekap_sum ?>                }, 
                    {
                        name: "TK",
                        y: <?php echo $jum_tk_rekap_sum ?>                }, 
                    {
                        name: "Dinas luar",
                        y: <?php echo $jum_dinas_luar_rekap_sum ?>                }, 
                    {
                        name: "Cuti",
                        y: <?php echo $jum_cuti_rekap_sum ?>                }, 
                            
                     ]
                        
                }]
            });
        });
    });
</script>