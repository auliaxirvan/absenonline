<?php if ($jumlah_nonver) { ?>
    <div class="alert alert-dismissible mb-0 p-2">
      <span class="font-weight-semibold">Perhatian!</span><span class="badge bg-danger ml-1"><?php echo $jumlah_nonver ?></span> laporan yang harus diverifikasi
    </div>
    <?php }else {  ?>
    <!-- <div class="alert alert-success alert-dismissible mb-0 p-2">
      tidak ada laporan yang harus diverifikasi
    </div> -->
<?php } ?>
<ul class="listview image-listview flush mb-2">
    <?php
     foreach($verifikasi_user as $verfikasi):?>
    <li>
         <a href="<?php echo url_verifikasi($verfikasi->id); ?>" class="item">
            <div class="iconedbox iconedbox-xl icon-box"><ion-icon name="person-circle-outline"></ion-icon>
            </div>
            <div class="in">
                <div>
                <?= $verfikasi->gelar_dpn; ?> <?= $verfikasi->nama; ?> <?= $verfikasi->gelar_blk; ?>
                        <div class="text-muted"><?= $verfikasi->nip; ?></div>
                        <div class="text-muted"><?= $verfikasi->jabatan; ?></div>
                </div>
                <span class="badge badge-danger"><?= $verfikasi->jum_non_ver ?></span>
            </div>
        </a>
    </li>
    <?php endforeach; ?>
</ul>