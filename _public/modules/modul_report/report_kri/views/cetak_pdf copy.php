<?php
$pdf = new PdfTcp('L', 'mm', 'Letter', true, 'UTF-8', false);
$pdf->SetTitle('Riask_Register');
$pdf->SetTopMargin(20);
// $pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage('L', 'A0');
$i = 0;


$blnname = "All Bulan";
                if($bulan){
                    $blnname = date('F', strtotime("2024-$bulan"));
                }
$html = '    
<table class="table table-bordered table-sm" id="reportKRI" style="border-color: #000; border-width: 1px; " border="1">
        <thead>
            <tr>
                <td colspan="2" rowspan="6" style="text-align: left;border-right:none;"><img src="" width="100"></td>
                <td colspan="28" rowspan="6" style="text-align:center;border-left:none;">
                    <h1>RISK REGISTER [KEY RISK INDIKATOR]</h1>
                </td>

                <td colspan="2" rowspan="2" style="text-align:left;">No.</td>
                <td colspan="4" rowspan="2" style="text-align:left;">: 004/RM-FORM/I/<?= $row1["periode_name"]; ?></td>
            </tr>
            <tr>
                <td style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="2" rowspan="2" style="text-align:left;">Revisi</td>
                <td colspan="4" rowspan="2" style="text-align:left;">: 1</td>
            </tr>
            <tr>
                <td style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="2" rowspan="2" style="text-align:left;">Tanggal Revisi</td>
                <td colspan="4" rowspan="2" style="text-align:left;">: 31 Januari <?= $row1["periode_name"]; ?> </td>
            </tr>
            <tr>
                <td style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="22" style="border: none;"></td>
            </tr>

            
            <tr>
                <th style="background-color: #f6c111; color:#000;" rowspan="2">No</th>
                <th style="background-color: #f6c111; color:#000;" rowspan="2"><label>Sasaran</label></th>
                <th style="background-color: #f6c111; color:#000;" rowspan="2"><label>Tema Risiko (T1)</label></th>
                <th style="background-color: #f6c111; color:#000;" rowspan="2"><label>Kategori Risiko (T2)</label></th>
                <th style="background-color: #f6c111; color:#000;" rowspan="2"><label>Sub Kategori Risiko</label></th>

                <th  style="background-color: #8cc881; color:#000;" colspan="4"><label>Identifikasi Risiko</label></th>

                <th style="background-color: #696969; color:#000;" rowspan="2"><label>Key Risk Indicators</label></th>
                <th style="background-color: #696969; color:#000;" rowspan="2"><label>Unit Satuan KRI</label></th>
                <th style="background-color: #696969; color:#000;" colspan="3"><label>Kategori Threshold KRI</label></th>


                <th style="background-color: #73aee2; color:#000;" colspan="6"><label>Analisis Risiko Inheren ['.$blnname.']</label></th>
                <th style="background-color: #f2c898; color:#000;" colspan="3"><label>Evaluasi Risiko</label></th>
                 <th style="background-color: #d9fa74; color:#000;" colspan="2"><label>Penanganan Risiko</label></th>
                 <th  style="background-color: #cd80d0; color:#000;" rowspan="2"><label>Follow Up</label></th>
                <th style="background-color: #b1b1b1; color:#000;" colspan="10"><label>Analisis Risiko Residual</label></th>
            </tr>
            <tr>
                <th style="background-color: #8cc881; color:#000;"><label class="w250">Peristiwa (T3)</label></th>
                <th style="background-color: #8cc881; color:#000;"><label class="w250">Penyebab</label></th>
                <th style="background-color: #8cc881; color:#000;"><label class="w250">Dampak Kualitatif</label></th>
                <th style="background-color: #8cc881; color:#000;"><label class="w250">Dampak Kuantitatif</label></th>

                <th style="background-color: #7FFF00;color: #000;"><label class="w250">Aman</label></th>
                <th style="background-color: #FFFF00;color:#000;"><label class="w250">Hati-Hati</label></th>
                <th style="background-color: #fd0202; color: #000;"><label class="w250">Bahaya</label></th>

                <th style="background-color: #73aee2; color:#000;" colspan="2"><label>Kemungkinan</label></th>
                <th style="background-color: #73aee2; color:#000;" colspan="2"><label>Dampak</label></th>
                <th style="background-color: #73aee2; color:#000;" colspan="2"><label> Level</label></th>

                <!-- <th><label>Urgency</label></th> -->
             

                <th style="background-color: #f2c898; color:#000;" ><label>Control</label></th>
                <th style="background-color: #f2c898; color:#000;"><label>Risk Control Assessment</label></th>
                <th style="background-color: #f2c898; color:#000;"><label>PIC</label></th>

                <th style="background-color: #d9fa74; color:#000;"><label>Rencana Perlakuan Risiko</label></th>
                <th style="background-color: #d9fa74; color:#000;"><label>Dampak Kuantitatif Risiko Residual</label></th>
            

                <th style="background-color: #b1b1b1; color:#000;"><label>Realisasi Penanganan Risiko</label></th>
                <th style="background-color: #b1b1b1; color:#000;"><label>Biaya Penananganan Risiko </label></th>
                <th style="background-color: #b1b1b1; color:#000;"><label>Loss Event</label></th> 
                <th style="background-color: #b1b1b1; color:#000;"colspan="2"><label>Kemungkinan</label></th>
                <th style="background-color: #b1b1b1; color:#000;"colspan="2"><label>Dampak</label></th>
                <th style="background-color: #b1b1b1; color:#000;"colspan="2"><label>Level Risiko Residual</label></th>
                <th style="background-color: #b1b1b1; color:#000;"><label>Rencana Perlakuan Risiko (existing + tambahan)</label></th>
            </tr>
        </thead>
        <tbody>
        ';
        //    doi::dump($field);
            $no = 1;
            foreach ($field as $key => $row) :
                $actDetail=$this->db->where('rcsa_detail_no', $row['id_rcsa_detail'])->order_by('bulan')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
                if($bulan>0){
                    $actDetail=$this->db->where('rcsa_detail_no', $row['id_rcsa_detail'])->where('bulan', $bulan)->order_by('bulan')->get(_TBL_VIEW_RCSA_ACTION_DETAIL)->result_array();
                }
                foreach ($actDetail as   $xx) :
                    $residual_impact_action=$xx['residual_impact_action'];
                    $residual_likelihood_action=$xx['residual_likelihood_action'];



                    $x = $this->db->where('rcsa_detail', $xx['rcsa_detail_no'])->get('bangga_view_rcsa_report_kri')->row_array();
                    $data_kri = $this->db->where('rcsa_detail', $xx['rcsa_detail_no'])->get('bangga_kri')->row_array();
                    $kri_detail = $this->db->where('rcsa_detail', $xx['rcsa_detail_no'])->where('bulan', $xx['bulan'])->get('bangga_kri_detail')->row_array();


                    $kri = $this->db->where('id', $data_kri['kri_no'])->get('bangga_data_combo')->row_array();
                    $kri_stuan = $this->db->where('id', $data_kri['satuan'])->get('bangga_data_combo')->row_array();
                    $kriVal=$kri_detail['realisasi'];
                    
                if ($kriVal >= $data_kri['min_rendah'] && $kriVal <= $data_kri['max_rendah']) {
                    $rangeMessage = $kriVal;
                } elseif ($kriVal >= $data_kri['min_menengah'] && $kriVal <= $data_kri['max_menengah']) {
                    $rangeMessage = $kriVal;
                } elseif ($kriVal >= $data_kri['min_tinggi'] && $kriVal <= $data_kri['max_tinggi']) {
                    $rangeMessage = $kriVal;
                } else {
                    $rangeMessage = "";
                } 
     
                
                $sasaran = $this->db->where('rcsa_no', $row['rcsa_no'])->get('bangga_rcsa_sasaran')->row_array();
                $tema = $this->db->where('id', $row['tema'])->get(_TBL_LIBRARY)->row_array();
                $control_as = $this->db->where('id', $row['risk_control_assessment'])->get('bangga_data_combo')->row_array();
                $pic = $this->db->where('id', $row['pic'])->get('bangga_owner')->row_array();

                $residual_level = $this->data->get_master_level(true, $row['residual_level']);
                $inherent_level = $this->data->get_master_level(true, $row['inherent_level']);


                $like = $this->db
                    ->where('id', $residual_level['likelihood'])
                    ->get('bangga_level')->row_array();

                $impact = $this->db
                    ->where('id', $residual_level['impact'])
                    ->get('bangga_level')->row_array(); 
                $likeinherent = $this->db
                    ->where('id', $residual_likelihood_action)
                    ->get('bangga_level')->row_array();

                $impactinherent = $this->db
                    ->where('id', $residual_impact_action)
                    ->get('bangga_level')->row_array();

                $act = $this->db
                    ->where('id', $row['id_rcsa_action'])
                    ->get('bangga_rcsa_action')->row_array();
                    // doi::dump($row);
           
                        
                    if($kri){
           $html.='
                <tr>
                    <td valign="top" style="text-align: center;">'. $no++ .'</td>
                    <td valign="top">'.$sasaran["sasaran"] .' </td>
                    <td valign="top">'.$tema["description"] .'</td>
                    <td valign="top">'.$row["kategori"] .'</td>
                    <td valign="top">'.($row["subrisiko"] == 1) ? "negatif" : "positif" .'</td>
                    <td valign="top">'.$row["event_name"].'</td>
                    <td valign="top">'.format_list($row["couse"], "### ").'</td>
                    <td valign="top">'.format_list($row["impact"], "### ").'</td>
                    <td valign="top">'.$row["risk_impact_kuantitatif"] .'</td> 

                    
                    <td>'.$kri["data"] .'</td>
                    <td valign="top">';
                   
					if ($kri_stuan["data"] == "%") {
						echo "persen [%]";
					} else {
						echo $kri_stuan["data"];
					}
                    $html .= '  </td>
                    <td >'.$data_kri["min_rendah"] .' - '.$data_kri["max_rendah"] .' <br> 
                        <center>
                        <b>'; 
                         if ($kriVal >= $data_kri["min_rendah"] && $kriVal <= $data_kri["max_rendah"]) {
                            echo "[ ".$kriVal ." ]";
                         }
                         $html .= '  </b>
                        </center>
                    </td>
				    <td >'.$data_kri["min_menengah"] .' - '.$data_kri["max_menengah"] .' <br>
                 <center>
                 <b>'; 
                         if ($kriVal >= $data_kri["min_menengah"] && $kriVal <= $data_kri["max_menengah"]) {
                            echo "[ ".$kriVal ." ]";
                         }
                $html .= ' </b>
                 </center></td>
				    <td >'.$data_kri["min_tinggi"] .' - '.$data_kri["max_tinggi"] .' <br>
                <center> <b clas>';
                         if ($kriVal >= $data_kri["min_tinggi"] && $kriVal <= $data_kri["max_tinggi"]) {
                                 echo "[ ".$kriVal ." ]";
                         }
                         $html .= ' </b>
                         </center></td>
				 
	 
                    <td valign="top" style="text-align: center;">'.$likeinherent["code"] .'</td>
                    <td valign="top" style="text-align: center;">'.$likeinherent["level"].'</td>
                    <td valign="top" style="text-align: center;">'.$impactinherent["code"].'</td>
                    <td valign="top" style="text-align: center;">'.$impactinherent["level"].'</td>
                    <td valign="top" style="text-align: center;">'.intval($likeinherent["code"]) * intval($impactinherent["code"]).'</td>
                      
                    <td valign="top" style="text-align: center; background-color:'.$xx["warna_action"].';color:'.$xx["warna_text_action"].';">'.$xx["inherent_analisis_action"].'</td>

                    <!-- <td valign="top" style="text-align: center;">'.$row["urgensi_no_kadiv"].'</td> -->
                    <td valign="top">'.format_list($row["control_name"], "###").'</td>
                    <td valign="top">'.$control_as["data"].'</td>
                    <td valign="top">'.$pic["name"].'</td>


                    <td valign="top">Proaktif: <br>'.$act["proaktif"].' <hr>Reaktif: <br>'.$act["reaktif"].'</td>
                  
                  <td valign="top">'.$xx["damp_loss"].'</td>';

                  $arrayData = json_decode($act["owner_no"], true);
                  // doi::dump($act["owner_no"]);

                  if ($arrayData !== null) {
                      $owners = array(); // Membuat array kosong untuk menyimpan data owner
                      foreach ($arrayData as $element) {
                          $element = strval($element);
                          $Accountable = $this->db->where("id", $element)->get("bangga_owner")->row_array();
                          if ($Accountable) {
                              $owners[] = $Accountable["name"]; // Menyimpan nama owner ke dalam array
                          }
                      }

                      // Menggabungkan data owner menjadi satu string dengan pemisah koma
                      $ownersString = implode(", ", $owners);
                  } else {
                      $ownersString = "-"; // Setel string menjadi kosong jika $arrayData null
                  }
                  $html .= '

                  <td valign="top">'.format_list($ownersString).'</td>

                    <!-- residual -->

                    <td valign="top">'.$xx["realisasi"].'</td>
                    <td valign="top">'.$act["amount"] .'</td>
                        <td valign="top">'.$xx["keterangan"].'</td> 

                    <td valign="top" style="text-align: center;">'.$like["code"].'</td>
                    <td valign="top" style="text-align: center;">'.$like["level"].'</td>
                    <td valign="top" style="text-align: center;">'.$impact["code"].'</td>
                    <td valign="top" style="text-align: center;">'.$impact["level"].'</td>
                    <td valign="top" style="text-align: center;">'.intval($like["code"]) * intval($impact["code"]).'</td>
                    <td valign="top" style="text-align: center; background-color:'.$residual_level["color"].';color:'.$residual_level["color_text"].';">'.$residual_level["level_mapping"].'</td>

                    <td valign="top">'.$xx["perlakuan_risiko"].'</td> 
                    
               
      </tr>';
            } endforeach; endforeach; ?>
            
 
            
            <?php
            $html .= ' <tbody></table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            ob_end_clean();
            $pdf->Output('Risk_Register.pdf', 'I');
            
            echo $html;
            // ?>