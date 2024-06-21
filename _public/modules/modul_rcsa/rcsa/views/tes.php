 <!-- 
  OLD
  $flashData = $this->session->flashdata('tab');
// $nextTab = $this->session->flashdata('tabval');
$id = $this->session->flashdata('id');
$done = $this->session->flashdata('done');
$rcsa_no = $this->session->flashdata('rcsa_no');
// if
// ($id) {
//   echo "<script>
//             alert('$flashData');
//             window.location.href = '" . base_url(_MODULE_NAME_REAL_ . '/tambah-peristiwa/edit/' . $id . '/' . $rcsa_no) . "';
//           </script>";
// } 
if ($done) {
  echo "<script>
            alert('$flashData');
            window.location.href = '" . base_url(_MODULE_NAME_REAL_ . '/risk-event/' . $id . '/' . $rcsa_no) . "';
          </script>";
}
 else {
    echo "<script>
            alert('$flashData');
          window.location.href = '" . base_url(_MODULE_NAME_REAL_ . '/tambah-peristiwa/edit/' . $id . '/' . $rcsa_no) . "';
          </script>";
} -->





<?php
$flashData = $this->session->flashdata('tab');
// $nextTab = $this->session->flashdata('tabval');
$id = $this->session->flashdata('id');
$done = $this->session->flashdata('done');
$rcsa_no = $this->session->flashdata('rcsa_no');
// doi::dump($id);
 if($id['id']==201){
  echo "<script>
  alert('{$id['msg']}');
</script>";
}else{
  
 
  // echo "<script>
  //           alert('$flashData');
  //           window.location.href = '" . base_url(_MODULE_NAME_REAL_ . '/tambah-peristiwa/edit/' . $id . '/' . $rcsa_no) . "';
  //         </script>";

if ($done) {
  echo "<script>
            alert('$flashData');
            window.location.href = '" . base_url(_MODULE_NAME_REAL_ . '/risk-event/' . $id . '/' . $rcsa_no) . "';
          </script>";
}
 else {
    echo "<script>
            alert('$flashData');
          window.location.href = '" . base_url(_MODULE_NAME_REAL_ . '/tambah-peristiwa/edit/' . $id . '/' . $rcsa_no) . "';
          </script>";
}
}





