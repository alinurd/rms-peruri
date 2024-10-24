<?php
$flashData = $this->session->flashdata('tab');
 
 
    echo "<script>
            alert('$flashData');
            location.reload(true);
          </script>";
 


