<div class="table-responsive" >
    <strong>Link Risk Context</strong><br/>
    <table class="table table-bordered table-hover">
		<tbody>
			<tr><td width="20%">Sasaran</td><td><?=$data['sasaran'];?></td></tr>
			<tr><td>Peristiwa</td><td><?=$data['event_name'];?></td></tr>
			<tr><td>Penyebab</td><td><?=$data['couse'];?></td></tr>
			<tr><td>Dampak</td><td><?=$data['impact'];?></td></tr>
			<tr><td>Existing Control</td><td><?=$data['control_no'];?></td></tr>
			<tr><td>Risk Control Assessment</td><td><?=$data['risk_control'];?></td></tr>
			<tr><td>Risk Treathment</td><td><?=$data['treatment'];?></td></tr>
		</tbody>
	</table>
    <br>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th rowspan="2" width="10%">No</th>
                <th colspan="2">Mitigasi / Treathment</th>
                <th rowspan="2">Unit Penanggung Jawab</th>
                <th rowspan="2">Biaya</th>
                <th rowspan="2">Target Waktu</th>
            </tr>
            <tr>
                <th>Proaktif</th>
                <th>Reaktif</th>
            </tr>
        </thead>
		<tbody>
            <?php
            $no=0;
            foreach($mitigasi as $row):?>
			<tr>
                <td><?=++$no;?></td>
                <td><?=$row['proaktif'];?></td>
                <td><?=$row['reaktif'];?></td>
                <td><?=$row['penanggung_jawab'];?></td>
                <td><?=$row['amount'];?></td>
                <td><?=$row['target_waktu'];?></td>
            </tr>
            <?php
            endforeach;?>
        </tbody>
	</table>
    <br>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th>Treathment</th>
                <th>Realisasi</th>
                <th>Risk Level</th>
                <th>Short Report</th>
                <th>Keterangan</th>
            </tr>
        </thead>
		<tbody>
            <?php
            $no=0;
            foreach($realisasi as $row):?>
			<tr>
                <td><?=++$no;?></td>
                <td><?=$row['type_name'];?></td>
                <td><?=$row['realisasi'];?></td>
                <td style="background-color:<?=$row['warna_action'];?>;color:<?=$row['warna_text_action'];?>;"><?=$row['inherent_analisis_action'];?></td>
                <td><?=$row['status_action_detail'];?></td>
                <td><?=$row['keterangan'];?></td>
            </tr>
            <?php
            endforeach;?>
        </tbody>
	</table>
</div>
