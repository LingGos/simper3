<?php
defined('BASEPATH') OR exit('No direct script access allowed');
switch ($subview) {
    default:
        ?>
        <div class="row padding20">
            <h1 class="text-light fg-orange"><a href="" class="icon mif-arrow-left fg-green"><span></span></a> Aktifitas Pengguna</h1>
            <hr class="thin bg-orange">
            <br/>
            <table class="dataTable border bordered tabel" data-role="datatable" data-auto-width="false">
                <thead>
                    <tr>
                <td class="sortable-column" style="width: 200px">ID Pengguna</td>
                <td class="sortable-column sort-asc" style="width: 200px">Waktu</td>
                <td class="sortable-column" style="width: 50px">Aksi</td>
                <td style="width: 250px">Tabel & ID Data</td>
                <td>Deskripsi</td>
                <td style="width: 200px">IP Addr</td>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($data_query as $row){
                        ?>
                        <tr>
                            <td class="align-center"><?php echo $row->aktPenID; ?></td>
                            <td><?php echo $row->aktWaktu; ?></td>
                            <td><?php echo $row->aktAksi; ?></td>
                            <td><?php echo $row->aktTabel.' / '.$row->aktDataID; ?></td>
                            <td><?php echo ucwords($row->aktDeskripsi); ?></td>
                            <td><?php echo $row->aktIP; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        break;
}
?>
