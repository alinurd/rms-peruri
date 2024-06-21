<?php
$err = "";
$hide = "top";
$option = array('class' => 'form-signin', 'id' => 'form_login');
if ($this->session->userdata('result_login')) {
  $err = $this->session->userdata('result_login');
  $this->session->set_userdata('result_login', '');
  $hide = "";
}
if (validation_errors()) {
  $err = validation_errors();
  $hide = "";
}
?>
<style>
  .login-group {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    /* height: 100vh; */
    /* Ini akan membuat elemen berada di tengah vertikal di layar */
  }

  /* .login-group {
    align-items: center;
  } */
  .login-button {

    font-size: 30px;
    background: #06375f ;
    color: #ffffffc0;
    width: 50px;
    height: 50px;
    border: 5px solid #ffffffc0;
    border-radius: 50%;
    outline: #333;
    transition: all ease-in-out 500ms;
  }

  .login-button:hover {

    font-size: 30px;
    background: #000;
    color: #fff;
    width: 50px;
    height: 50px;
    border: 5px solid #fff;
    border-radius: 50%;
    outline: #333;
    transition: all ease-in-out 500ms;
  }



  .screen-lock {
    text-align: center;
    background-color: #0D4DA1;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);

  }


  .lock-icon {
    font-size: 48px;
    color: #333;
  }



  .inputxxx {
    text-align: center;

    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
  }



  h1 {
    font-size: 24px;
    margin: 10px 0;
    color: #333;
    text-shadow: #ccc;
    /* color: #333; */
  }

  p {
    font-size: 16px;
    color: #777;
  }

  .etc-logo-login {
    /* background-image: base_url('themes/default/assets/images/logo-white.png');
    background-size: 50%; */
    background-position: center;
    background-repeat: no-repeat;
    max-width: 100%;
    height: 100px;
    /* padding-top: 15px;
    padding-bottom: 20px; */
  }
</style>

<div class="screen-lock">
  <div class="lock-icon">
    <img class="etc-logo-login" src="<?= base_url('themes/default/assets/images/logo-white.png'); ?>" title="">
  </div>
  <br>
  <p id="countdown"></p>
  <h1>Screen Locked</h1>
  <p>Please enter username & password to unlock.</p>
  <p><i>The input data will be reset.</i></p>

  <?php echo form_open('auth/open_lock', $option); ?>
  <!-- <form id="login-form" class="text-left"> -->
  <div class="main-login-form">
    <div class="login-group">
      <div class="form-group">
<?php $url = str_replace('"', '>', '', $basedata);
    echo $url; ?>
        <label for="lg_username" class="sr-only"><i class="fa fa-key fa-fw"></i>Username</label>
        <input name="username" class="form-control inputxxx" type="text" placeholder="username" autocomplete="off">
        <input name="basedata" class="form-control inputxxx" type="hidden" value="<?= $basedata ?>" placeholder="username/email/nip" autocomplete="off">
      </div>
      <div class="form-group">
        <label for="lg_password" class="sr-only">Password</label>
        <input name="password" class="form-control inputxxx" type="password" placeholder="password" autocomplete="off">
      </div>
    </div>
    <button type="submit" class="login-button"><i class="fa fa-unlock fa-fw"></i></i></button>
  </div>
  </form>
  </form>
</div>


<script>
  // Set waktu awal dalam detik (15 menit)
  var countdownTime = 900;

  // Fungsi untuk menampilkan hitungan mundur
  function startCountdown() {
    var countdownElement = document.getElementById("countdown");

    // Update hitungan mundur setiap 1 detik
    var countdownInterval = setInterval(function() {
      var minutes = Math.floor(countdownTime / 60);
      var seconds = countdownTime % 60;

      // Format waktu menjadi menit:detik (misalnya, "12:34")
      var formattedTime = padZero(minutes) + ":" + padZero(seconds);

      // Tampilkan waktu hitungan mundur
      countdownElement.innerHTML = "Sisa waktu: " + formattedTime;

      // Kurangi waktu hitungan mundur
      countdownTime--;

      // Hentikan hitungan mundur jika waktu habis
      if (countdownTime < 0) {
        clearInterval(countdownInterval);
        countdownElement.innerHTML = "Waktu telah habis!";
      }
    }, 1000);
  }

  // Fungsi untuk menambah "0" di depan angka jika kurang dari 10
  function padZero(number) {
    return (number < 10 ? "0" : "") + number;
  }

  // Mulai hitungan mundur saat halaman dimuat
  window.onload = startCountdown;
</script>