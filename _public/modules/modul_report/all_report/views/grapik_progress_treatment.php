<div id="coba">
    <div class="col-md-12 col-sm-6 col-xs-6">
        <center>
            <canvas id="mybarChart_progress_treatment"></canvas>
            <br>&nbsp;<hr>
            <table class="table" width="90%">
                <thead>
                    <tr>
                        <th width="70%">Treatment</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($master as $kategori => $dataBulan): ?>
                        <?php if ($kategori !== '' && array_sum($dataBulan) > 0): ?>
                            <tr>
                                <td>
                                    <span style="background-color: <?php 
                                        if ($kategori === 'Kurang') echo 'rgba(255, 99, 71, 0.7)'; 
                                        elseif ($kategori === 'Sama') echo 'rgb(148, 194, 255)'; 
                                        elseif ($kategori === 'Lebih') echo 'rgba(144, 238, 144, 0.7)';
                                        else echo '#ccc'; 
                                    ?>; color: white;">
                                        &nbsp;<?= 
                                            $kategori === 'Kurang' ? 'Kurang Dari Target' : 
                                            ($kategori === 'Sama' ? 'Sama Dengan Target' : 
                                            ($kategori === 'Lebih' ? 'Lebih Dari Target' : 'Tidak Diketahui')) 
                                        ?>&nbsp;
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?= array_sum($dataBulan); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </center>
    </div>
</div>
<?php
// Daftar bulan dari Januari hingga Desember
$bulan = [
    1 => 'Jan',
    2 => 'Feb',
    3 => 'Mar',
    4 => 'Apr',
    5 => 'May',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Aug',
    9 => 'Sep',
    10 => 'Oct',
    11 => 'Nov',
    12 => 'Dec',
];

// Inisialisasi array untuk setiap kategori
$dataKategori = [
    'Sama' => array_fill_keys(array_values($bulan), 0),
    'Kurang' => array_fill_keys(array_values($bulan), 0),
    'Lebih' => array_fill_keys(array_values($bulan), 0),
];

// Iterasi data master dan isi array kategori
foreach ($master as $kategori => $dataBulan) {
    if (isset($dataKategori[$kategori])) {
        foreach ($dataBulan as $bulanKey => $jumlah) {
            if (isset($dataKategori[$kategori][$bulanKey])) {
                $dataKategori[$kategori][$bulanKey] = (int)$jumlah;
            }
        }
    }
}

// Prepare data for JavaScript
$data = [
    'data' => [
        'labels' => array_values($bulan), // Label bulan
        'datasets' => [
            [
                'label' => 'Kurang Dari Target',
                'data' => array_values($dataKategori['Kurang']),
                'backgroundColor' => 'rgba(255, 99, 71, 0.7)', // Warna merah lembut
            ],
            [
                'label' => 'Sama Dengan Target',
                'data' => array_values($dataKategori['Sama']),
                'backgroundColor' => 'rgb(148, 194, 255)', // Warna biru lembut
            ],
            [
                'label' => 'Lebih Dari Target',
                'data' => array_values($dataKategori['Lebih']),
                'backgroundColor' => 'rgba(144, 238, 144, 0.7)', // Warna hijau lembut
            ],
        ],
    ],
    'judul' => [$post['title_text'], 'Periode ' . $post['periode_no']],
];

$dataJson = json_encode($data);

?>

<script>
    const data = <?= $dataJson; ?>;

    // Fungsi untuk menggambar grafik
    function graph_progress_treatment(chartData, chartId) {
        const ctx = document.getElementById(chartId).getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Grafik batang
            data: chartData.data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: chartData.judul.join(' - '),
                    },
                },
                scales: {
                    x: {
                        stacked: true, // Jika ingin bar bertumpuk
                        beginAtZero: true,
                    },
                    y: {
                        stacked: true, // Jika ingin bar bertumpuk
                        beginAtZero: true,
                    },
                },
            },
        });
    }

    // Panggil fungsi untuk menggambar grafik
    graph_progress_treatment(data, 'mybarChart_progress_treatment');
</script>
