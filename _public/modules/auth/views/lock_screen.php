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
    body {
        background-color: #f4f4f4;
        font-family: 'Arial', sans-serif;
    }

    .screen-lock {
        text-align: center;
        background-color: #005398;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
        max-width: 80%;
        margin: 100px auto;
        color: #fff;
    }

    .lock-icon img {
        max-width: 30%;
        height: auto;
        margin-bottom: 20px;
    }

    .lock-icon {
        position: relative; /* Memungkinkan elemen anak untuk diposisikan relatif terhadap elemen ini */
        overflow: hidden; /* Menyembunyikan bagian dari elemen yang melampaui batas */
    }

    .shine {
        position: absolute;
        top: -50%; /* Memposisikan cahaya di atas elemen */
        left: -50%; /* Memposisikan cahaya di sebelah kiri elemen */
        width: 200%; /* Lebar dua kali lipat dari elemen */
        height: 200%; /* Tinggi dua kali lipat dari elemen */
        background: linear-gradient(60deg, rgba(255, 255, 255, 0.5) 0%, rgba(255, 255, 255, 0) 100%);
        animation: shine 5s infinite; /* Menambahkan animasi */
    }

    @keyframes shine {
        0% {
            transform: translate(-100%, -100%); /* Memulai dari luar kiri atas */
        }
        100% {
            transform: translate(100%, 100%); /* Bergerak ke luar kanan bawah */
        }
    }

    h1 {
        font-size: 28px;
        margin: 10px 0;
        color: #ffffff;
    }

    p {
        font-size: 16px;
        color: #e0e0e0;
    }

    .inputxxx {
        width: 100%;
        padding: 12px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
        transition: border-color 0.3s;
    }

    .inputxxx:focus {
        border-color: #06375f;
    }

    .login-button {
      margin-top: 20px;
        font-size: 20px;
        background: #06375f;
        border: 2px solid white;
        color: #ffffff;
        width: 60px;
        height: 60px;
        /* border: none; */
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.3s, transform 0.3s;
    }

    .login-button:hover {
        background:grey;
        transform: scale(1.1);
    }

    /* #countdown {
        font-size: 18px;
        margin: 10px 0;
    } */

    #countdown {
        font-size: 18px;
        margin: 10px 0;
        animation: blink 2s infinite; /* Menambahkan animasi kedap-kedip */
    }

    @keyframes blink {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0;
        }
    }

    .main-login-form {
      display: flex;
      flex-direction: column; /* Mengatur elemen dalam kolom */
      align-items: center; /* Memusatkan elemen secara horizontal */
      justify-content: center; /* Memusatkan elemen secara vertikal */
      margin-top: 20px; /* Jarak atas untuk memberikan ruang */
  }

  .login-group {
      width: 100%; /* Memastikan grup login mengambil lebar penuh */
      max-width: 400px; /* Lebar maksimum untuk grup login */
  }
</style>

<div class="screen-lock">
    <div class="lock-icon"  style="background-color: white;border-radius:10px;">
        <img class="etc-logo-login" src="<?= base_url('themes/default/assets/images/logo-white.png'); ?>" title="">
        <div class="shine"></div>
    </div>
    <p class="text-center bg-danger" style="max-width: 20%;border-radius:10px;" id="countdown"></p>
    <h1>SCREEN LOCKED</h1>
    <p style="color: red;">Please enter username & password to unlock.<br><i>The input data will be reset.</i></p>
    <?php echo form_open('auth/open_lock', $option); ?>
    <div class="main-login-form">
        <div class="login-group">
            <div class="form-group">
                <label for="lg_username" class="sr-only">Username</label>
                <input name="username" class="form-control inputxxx" type="text" placeholder="Username" autocomplete="off">
                <input name="basedata" class="form-control inputxxx" type="hidden" value="<?= $basedata ?>" placeholder="username/email/nip" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="lg_password" class="sr-only">Password</label>
                <input name="password" class="form-control inputxxx" type="password" placeholder="Password" autocomplete="off">
            </div>
        </div>
        <button type="submit" class="login-button"><i class="fa fa-unlock fa-fw"></i></button>
    </div>
    <?php echo form_close(); ?>
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

            // // Tampilkan waktu hitungan mundur
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