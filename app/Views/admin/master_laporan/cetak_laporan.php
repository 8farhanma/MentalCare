<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Diagnosis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    /* CSS styling for the PDF content */
    body {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th,
    table td {
        padding: 8px;
        border: 1px solid #000;
    }

    table th {
        background-color: #f0f0f0;
    }
    </style>
</head>

<body>
    <?php
    // Set zona waktu sesuai dengan waktu yang diinginkan
    date_default_timezone_set('Asia/Jakarta');
    ?>
    <h1 align="center">Laporan Data Diagnosis</h1>
    <h5>Tanggal Cetak : <?= date('d-m-Y H:i:s') ?></h5>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Usia</th>
                <th>Tanggal</th>
                <th>Penyakit</th>
                <th>CF Akhir</th>
                <th>Presentase</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporan as $key => $row): ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= esc($row['p_1']); ?></td>
                <td><?= $row['tgl_diagnosis'] ?></td>
                <td><?= $row['nama_penyakit'] ?></td>
                <td><?= $row['cf_akhir'] ?></td>
                <td><?= $row['presentase'] ?>%</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Tombol Kembali -->
    <div class="text-center mt-4 btn-print">
        <a href="<?= base_url('admin/master_laporan') ?>" class="btn btn-secondary">
            Kembali ke Daftar Laporan
        </a>
    </div>

            <!-- CSS untuk menyembunyikan button saat cetak -->
            <style>
            @media print {
                .btn-print {
                    display: none;
                }
            }
            </style>

            <script>
            window.onload = function() {
                window.print();
            }
            </script>


</body>

</html>