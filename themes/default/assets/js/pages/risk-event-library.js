function resultHasil(x){
	console.log(x)
}
$(function(){
	
	$("#l_t1, #q_l_t1").change(function () {
		var parent = $(this).parent();
		var id = $(this).attr('id');
		var nilai = $(this).val();
		var type = 0;
		var target_combo='';
	
		if (id === 'l_t1') {
			type = 1;
			target_combo = $("#l_t2");
		} else if (id === 'l_t2') {
			type = 2;
			target_combo = $("#l_t3");
		}
	
		var data = { 'type': type, 'id': nilai };
		var url = "ajax/takstonomi";
	
		cari_ajax_combo("post", parent, data, target_combo, url, 'resultHasil');
	});
	

	$("#l_kel, #q_l_kel").change(function(){
		var parent = $(this).parent();
		var id = $(this).attr('id');
		var nilai = $(this).val();
		var data={'id':nilai};
		if (id=='l_kel')
			var target_combo = $("#l_risk_type_no");
		else
			var target_combo = $("#q_l_risk_type_no");
		var url = "ajax/get_rist_type";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
	
	$("#add_cause").click(function(){
	// $(this).addClass('disabled');
	var theTable= document.getElementById("instlmt_cause");
	var rl = theTable.tBodies[0].rows.length;
	
	if (theTable.rows[rl].cells[1].childNodes[0].value=="0"){
		alert("Groups Tidak boleh Kosong!");
	}else{
	
		var lastRow = theTable.tBodies[0].rows[rl];
		var tr = document.createElement("tr");
		
		if((rl-1)%2==0)
			tr.className="dn_block";
		else
			tr.className="dn_block_alt";
		
		var td1 =document.createElement("TD");
		td1.setAttribute("style","text-align:center;width:10%;");
		var td2 =document.createElement("TD");
		td2.setAttribute("align","left");
		var td3 =document.createElement("TD");
		td3.setAttribute("style","text-align:center;width:10%;");
		
		++rl;
		td1.innerHTML=rl+editCouse;
		td2.innerHTML=cboCouse;
		td3.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install_cause(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.appendChild(td3);
		theTable.tBodies[0].insertBefore(tr , lastRow);
		$(".select4").select2({
			allowClear: false,
			placeholder: " - Select - ",
			width:'600px'
		});
	}
	$("#add_new_cause").removeClass('disabled');
})

	$("#add_new_cause").click(function(){
	$(this).addClass('disabled');
	var theTable= document.getElementById("instlmt_cause");
	var rl = theTable.tBodies[0].rows.length;
	
	if (theTable.rows[rl].cells[1].childNodes[0].value=="0"){
		alert("Groups Tidak boleh Kosong!");
	}else{
	
		var lastRow = theTable.tBodies[0].rows[rl];
		var tr = document.createElement("tr");
		
		if((rl-1)%2==0)
			tr.className="dn_block";
		else
			tr.className="dn_block_alt";
		
		var td1 =document.createElement("TD");
		td1.setAttribute("style","text-align:center;width:10%;");
		var td2 =document.createElement("TD");
		td2.setAttribute("align","left");
		var td3 =document.createElement("TD");
		td3.setAttribute("style","text-align:center;width:10%;");
		
		++rl;
		td1.innerHTML=rl+editCouse;
		td2.innerHTML=cbnCouse;
		td3.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install_cause(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
		
		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.appendChild(td3);
		theTable.tBodies[0].insertBefore(tr , lastRow);
		$(".select4").select2({
			allowClear: false,
			placeholder: " - Select - ",
			width:'600px'
		});
	}
	$("#add_new_cause").removeClass('disabled');
})

});


function remove_install_cause(t,iddel){
	if(confirm("Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone")){
		var ri = t.parentNode.parentNode.rowIndex;
		$("#spinner-save-tepat").show();
		//form = $("#frm_data_dashbord").serialize();
		var form = {iddel:iddel}; 
		var url=base_url+"risk-event-library/del-library";
		$.ajax({
			type: "POST",
			url: url,
			data: form,
			success: function(msg){
				t.parentNode.parentNode.parentNode.deleteRow(ri-1);
				// alert(msg + " record sukses dihapus");
			},
			failed: function(msg){
				alert("gagal");
			},
		});
	}
	return false;
}

function add_install_impact(){
		
		$("#add_impact").removeClass('disabled').addClass('disabled');
		var theTable= document.getElementById("instlmt_impact");
		var rl = theTable.tBodies[0].rows.length;
		
		if (theTable.rows[rl].cells[1].childNodes[0].value=="0"){
			alert("Groups Tidak boleh Kosong!");
		}else{
		
			var lastRow = theTable.tBodies[0].rows[rl];
			var tr = document.createElement("tr");
			
			if((rl-1)%2==0)
				tr.className="dn_block";
			else
				tr.className="dn_block_alt";
			
			var td1 =document.createElement("TD");
			td1.setAttribute("style","text-align:center;width:10%;");
			var td2 =document.createElement("TD");
			td2.setAttribute("align","left");
			var td3 =document.createElement("TD");
			td3.setAttribute("style","text-align:center;width:10%;");
			
			++rl;
			td1.innerHTML=rl+editImpact;
			td2.innerHTML=cboImpact;
			td3.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install_impact(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
			
			tr.appendChild(td1);
			tr.appendChild(td2);
			tr.appendChild(td3);
			theTable.tBodies[0].insertBefore(tr , lastRow);
			$(".select5").select2({
			   allowClear: false,
				placeholder: " - Select - ",
				width:'600px'
			});
		}
		$("#add_impact").removeClass('disabled');
	}
	function add_new_install_impact(){
		
		$("#add_new_impact").removeClass('disabled').addClass('disabled');
		var theTable= document.getElementById("instlmt_impact");
		var rl = theTable.tBodies[0].rows.length;
		
		if (theTable.rows[rl].cells[1].childNodes[0].value=="0"){
			alert("Groups Tidak boleh Kosong!");
		}else{
		
			var lastRow = theTable.tBodies[0].rows[rl];
			var tr = document.createElement("tr");
			
			if((rl-1)%2==0)
				tr.className="dn_block";
			else
				tr.className="dn_block_alt";
			
			var td1 =document.createElement("TD");
			td1.setAttribute("style","text-align:center;width:10%;");
			var td2 =document.createElement("TD");
			td2.setAttribute("align","left");
			var td3 =document.createElement("TD");
			td3.setAttribute("style","text-align:center;width:10%;");
			
			++rl;
			td1.innerHTML=rl+editImpact;
			td2.innerHTML=cbiImpact;
			td3.innerHTML='<span nilai="0" style="cursor:pointer;" onclick="remove_install_impact(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';
			
			tr.appendChild(td1);
			tr.appendChild(td2);
			tr.appendChild(td3);
			theTable.tBodies[0].insertBefore(tr , lastRow);
			$(".select5").select2({
			   allowClear: false,
				placeholder: " - Select - ",
				width:'600px'
			});
		}
		$("#add_new_impact").removeClass('disabled');
	}

	function remove_install_impact(t,iddel){
		if(confirm("Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone")){
			var ri = t.parentNode.parentNode.rowIndex;
			$("#spinner-save-tepat").show();
			//form = $("#frm_data_dashbord").serialize();
			var form = {iddel:iddel}; 
			var url='<?php echo base_url("risk-event-library/del-library");?>';
			$.ajax({
				type: "POST",
				url: url,
				data: form,
				success: function(msg){
					t.parentNode.parentNode.parentNode.deleteRow(ri-1);
					// alert(msg + " record sukses dihapus");
				},
				failed: function(msg){
					alert("gagal");
				},
			});
		}
		return false;
	}