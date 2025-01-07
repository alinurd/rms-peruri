
  <table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center" style="background: white; min-width: 50px;">No</th>
            <th class="text-center" style=" background: white; min-width: 200px;">Sasaran</th>
            <th class="text-center" style=" background: white; min-width: 200px;">T1</th>
            <th class="text-center" style=" background: white; min-width: 200px;">T2</th>
            <th class="text-center" style=" background: white; min-width: 200px;">T3</th>
        </tr>
        <?php
        // doi::dump($data);
        $no = 1;
        foreach ($data as $d) {
        ?>
            <tr>
                <td class="text-center" style="background: white; min-width: 50px;"><?= $no++ ?></td>
                <td style=" background: white; min-width: 150px;"><?= $d['sasaran'] ?></td>
                <td style=" background: white; min-width: 150px;"><?= $d['tema_risiko'] ?></td>
                <td style=" background: white; min-width: 150px;"><?= $d['t2'] ?></td>
                <td style=" background: white; min-width: 150px;"><?= $d['data_t3'] ?></td>
            </tr>
        <?php
        }
        ?>
    </thead>
</table>
