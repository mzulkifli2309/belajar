<?php
$hasil = null;

// Proses saat form disubmit
if (isset($_POST['submit'])) {
  $bw   = $_POST['bw'];
  $bws  = $_POST['bws'];
  $bwsk = $_POST['bwsk'];

  // Hitung kadar air
  if (($bws - $bw) != 0) {
    $kadar_air = (($bws - $bwsk) / ($bws - $bw)) * 100;
    $hasil = number_format($kadar_air, 2);

    // Koneksi ke database
    $koneksi = mysqli_connect("localhost", "root", "", "moist");

    // Simpan ke database
    $query = "INSERT INTO hasil_moist (bw, bws, bwsk, kadar_air)
              VALUES ('$bw', '$bws', '$bwsk', '$kadar_air')";
    mysqli_query($koneksi, $query);
  } else {
    $hasil = "Error: pembagi tidak boleh nol";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=360, initial-scale=1.0" />
  <title>Kalkulator moist</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      background-color: #f0f0f0;
    }
    .container {
      width: 360px;
      min-height: 100vh;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      padding: 20px;
      box-sizing: border-box;
    }
    h1 {
      font-size: 20px;
      text-align: center;
    }
    label {
      margin-bottom: 2px;
      display: block;
      font-weight: bold;
      color: teal;
    }
    input {
      width: 100%;
      padding: 6px;
      margin-bottom: 5px;
      box-sizing: border-box;
      border: 2px solid teal;
    }
    button {
      padding: 10px 20px;
      background-color: teal;
      color: white;
      border: none;
      cursor: pointer;
    }
    .hasil {
      margin-top: 20px;
      padding: 10px;
      background: #e0f7fa;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Kalkulator Kadar Air</h1>
    <div class="inputan">
      <p>Masukkan Data</p>

      <form method="post">
        <label for="bw">BW</label>
        <input type="number" id="bw" name="bw" step="0.0001" placeholder="Berat wadah" required />

        <label for="bws">BW + S</label>
        <input type="number" id="bws" name="bws" step="0.0001" placeholder="Berat wadah + sampel" required />

        <label for="bwsk">BW + SK</label>
        <input type="number" id="bwsk" name="bwsk" step="0.0001" placeholder="Berat wadah + sampel kering" required />

        <button type="submit" name="submit">Hitung</button>
      </form>

      <?php if ($hasil !== null): ?>
        <div class="hasil">
          <strong>Hasil Kadar Air:</strong><br>
          <?= is_numeric($hasil) ? $hasil . ' %' : $hasil ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
