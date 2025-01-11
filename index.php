<?php
include "koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
  <link rel="icon" href="http://www.freelogovectors.net/wp-content/uploads/2018/03/real_madrid_cub_de_futbol-logo.png">
</head>
<style>
  .card-img-top {
    height: 280px;
    object-fit: cover;
    width: 100%;

  }
  .col {
    padding: 10px;
  }

  .navbar .bi {
    font-size: 1.5rem;
    cursor: pointer;
    margin-left: 10px;
  }

  body {
    background-color: white;
    color: black;
  }

  body.dark {
    background-color: black;
    color: white;
  }

  .navbar.dark {
    background-color: black;
  }

  .navbar.dark .nav-link {
    color: white;
  }

  .navbar.dark .navbar-brand {
    color: white;
  }


  .footer.dark .footerbtn {
    color: white;
  }

  .footer.light .bi {
    color: black;
  }

  .navbar .bi {
    font-size: 1.3rem;
    cursor: pointer;
    margin-left: 5px;
    padding: 5px;
    border-radius: 10px;
  }

  .navbar .bil {
    font-size: 1.3rem;
    cursor: pointer;
    margin-left: 5px;
    padding: 5px;
    border-radius: 10px;
  }


  .navbar .bi {
    background-color: red;
    color: white;
  }

  .navbar .bil {
    background-color: black;
    color: white;
  }

  body.navbar .bi {
    background-color: black;
    color: white;
  }

  .navbar .bi:hover {
    background-color: red;
    color: white;
  }

  .navbar.dark {
    color: white;
  }

  .container-img {
    width: 100%;
    height: 300px;
  }

  .img {
    border-radius: 20px;
  }

  .card-header {
    background-color: red;
  }

  #profil {
    background-color: #f8f9fa;
    padding: 2rem 0;
    width: 100vw;
    position: relative;
    left: 0;
    /* Rata kiri */
    margin-left: calc(-50vw + 50%);
    margin-right: calc(-50vw + 50%);
  }

  .profil {
    margin: 0;
  }

  .foto {
    width: 300px;
    height: 300px;
    object-fit: cover;
    border-radius: 50%;
  }

  body.dark .link {
    color: #ffffff;
  }
</style>

<body>
  <!-- nav begin -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container">
      <a class="navbar-brand" href="#">My Daily Journal</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
          <li class="nav-item">
            <a class="nav-link" href="#">HOME</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#articel">ARTICEL</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#galery">GALERY</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#schedule">SCHEDULE</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#profil">ABOUT ME</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">LOGIN</a>
          </li>
          
          <li class="nav-item  mt-2 mt-lg-0">
            <a onclick="togglemode()" class="bil bi-moon-fill" id="mode-dark"></a>

          </li>
          <li class="nav-item  mt-2 mt-lg-0">
            <a onclick="togglemode()" class="bi bi-brightness-high-fill" id="mode-light"></a>

          </li>


        </ul>

      </div>
    </div>
  </nav>
  <!--nav end-->
  <!--hero begin -->
  <section id="hero" class="text-center p-5 bg-secondary text-sm-start">
    <div class="container">
      <div class="d-sm-flex flex-sm-row-reverse align-items-center">
        <img src="https://i.redd.it/m4cd5cbn56e41.png" class="img img-fluid" width="300" height="">
        <div>
          <h1 class="fw-bold display-4">Real Madrid </h1>
          <h4 class="lead display-4">Real Madrid adalah club terbaik di dunia ia memiliki trophi 15 ucl dimana ucl
            terbanyak di club di dunia </h4>
          <h6>
            <span id="tanggal"></span>
            <span id="jam"></span>
          </h6>
        </div>
      </div>
    </div>
  </section>
  <!--hero end-->
 <!-- article begin -->
<section id="articel" class="text-center p-5">
  <div class="container">
    <h1 class="fw-bold display-4 pb-3">article</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
      <?php
      $sql = "SELECT * FROM articel ORDER BY tanggal DESC";
      $hasil = $conn->query($sql); 

      while($row = $hasil->fetch_assoc()){
      ?>
        <div class="col">
          <div class="card h-100">
            <img src="img/<?= $row["gambar"]?>" class="card-img-top" alt="..." />
            <div class="card-body">
              <h5 class="card-title"><?= $row["judul"]?></h5>
              <p class="card-text">
                <?= $row["isi"]?>
              </p>
            </div>
            <div class="card-footer">
              <small class="text-body-secondary">
                <?= $row["tanggal"]?>
              </small>
            </div>
          </div>
        </div>
        <?php
      }
      ?> 
    </div>
  </div>
</section>
<!-- article end -->
  <!--galery begin-->
  <section id="galery" class="text-center p-5  bg-secondary">
    <div class="container">
      <h1 class="fw-bold display-4 pb-3">Galery</h1>
      <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
        <?php
          // Query untuk mengambil data dari tabel gallery
          $sql2 = "SELECT * FROM gallery ORDER BY tanggal DESC";
          $hasil2 = $conn->query($sql2);

          $active_class = "active"; // Kelas active untuk item pertama

          if ($hasil2->num_rows > 0) {
            while ($row = $hasil2->fetch_assoc()) {
              $image_file = $row['gambar']; // Mengambil nama file dari kolom gambar
              $image_url = "img/" . $image_file; // Gabungkan dengan path folder img
              echo '
                        <div class="carousel-item ' . $active_class . '">
                            <img src="' . $image_url . '" class="d-block w-100" alt="Gallery Image" />
                        </div>';
              $active_class = ""; // Hapus kelas active untuk item berikutnya
            }
          } else {
            echo '<div class="carousel-item active">
                            <p>No images available in the gallery.</p>
                        </div>';
          }
          ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </section>
  <!--galery end-->
 <!--Schedule begin-->
<section id="schedule" class="cradsh text-center p-5">
  <div class="container">
    <h1 class="fw-bold display-4 pb-3">Schedule</h1>
    <div class="row row-cols-md-4 row-cols-1 g-4 d-flex align-items-stretch">
      <div class="col">
        <div class="card mb-3 mx-auto h-100" style="max-width: 18rem;">
          <div class="card-header">Senin</div>
          <div class="card-body">
            <p class="card-text">Basis data(teori) <br>08.40-10.20 | H57</p>
          </div>
          <hr>
          <div class="card-body">
            <p class="card-text">Sistem Operasi <br> 12.30-15-00 | </p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-3 mx-auto h-100" style="max-width: 18rem;">
          <div class="card-header">Selasa</div>
          <div class="card-body">
            <p class="card-text">Pemograman Berbasis Web <br>08.40-10.20 | D2j</p>
          </div>
          <hr>
          <div class="card-body">
            <p class="card-text">Logika Informatika <br> 12.30-15-00 | H52</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-3 mx-auto h-100" style="max-width: 18rem;">
          <div class="card-header">Rabu</div>
          <div class="card-body">
            <p class="card-text">Basis data(Praktek) <br>08.40-10.20 | D3j</p>
          </div>
          <hr>
          <div class="card-body">
            <p class="card-text">Kriptografi <br> 12.30-15-00 | H42</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-3 mx-auto h-100" style="max-width: 18rem;">
          <div class="card-header">Kamis</div>
          <div class="card-body">
            <p class="card-text">Pemograman Berbasis Web <br>08.40-10.20 | D2j</p>
          </div>
          <hr>
          <div class="card-body">
            <p class="card-text">Logika Informatika <br> 12.30-15-00 | H52</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-3 mx-auto h-100" style="max-width: 18rem;">
          <div class="card-header">Jumat</div>
          <div class="card-body">
            <p class="card-text">Rekayasa Perangkat Lunak <br>09.30-12.00 | 2j</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-3 mx-auto h-100" style="max-width: 18rem;">
          <div class="card-header">Sabtu</div>
          <div class="card-body">
            <p class="card-text">FREE</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Schedule end-->
    <!-- Profil Section -->
<section id="profil" class="profil text-center p-5 bg-danger-subtle text-sm-start">
  <div class="d-sm-flex flex-sm-row align-items-center justify-content-center">
    <img src="https://yt3.ggpht.com/a/AATXAJw7JiA0z6jIiM_HQVYzMZj7pJwn2eB4B9LynQ=s900-c-k-c0xffffffff-no-rj-mo"
      class="foto img-fluid rounded-circle" width="300" height="300" style="object-fit: cover; border-radius: 50%;">
    <div class="ms-4">
      <div class="ms-4 ">
        <span>A11.2023.14915</span>
        <h1><strong>Wafiq Febrian Prayitno</strong></h1>
        <span>Program Studi Teknik Informatika</span>
        <br>
        <span><a href="https://dinus.ac.id" class="link text-dark" style="text-decoration: none;"><strong>Udinus Dian Nuswantoro</strong></a></span>
      </div>
    </div>
  </div>
</section>
    <!-- footer begin-->
    <footer class="footer text-center p-3">
      <div>
        <a href="" class="bi bi-instagram h2 p-2 "></a>
        <a href="" class="bi bi-whatsapp h2 p-2 "></a>
        <a href="" class="bi bi-twitter h2 p-2 "></a>
      </div>
      <div>
        Wafiq Febrian Prayitno &copy; 2024
      </div>
    </footer>

    <script type="text/javascript">
      window.setTimeout("tampilwaktu(), 1000");

      function tampilwaktu() {
        var waktu = new Date();
        var bulan = waktu.getMonth() + 1;

        setTimeout("tampilwaktu(), 1000");
        document.getElementById("tanggal").innerHTML =
          waktu.getDate() + "/" + bulan + "/" + waktu.getFullYear();
        document.getElementById("jam").innerHTML =
          waktu.getHours() +
          ":" +
          waktu.getMinutes() +
          ":" +
          waktu.getSeconds();
      }
      let isDarkMode = false;

      function togglemode() {
        isDarkMode = !isDarkMode;

        if (isDarkMode) {
          document.body.classList.add("dark");
          document.getElementById("mode-dark").style.display = "none";
          document.getElementById("mode-light").style.display = "inline";
          // Ubah warna teks universitas menjadi putih
          document.querySelector('.link').classList.add('text-white');
        } else {
          document.body.classList.remove("dark");
          document.getElementById("mode-dark").style.display = "inline";
          document.getElementById("mode-light").style.display = "none";
          // Kembalikan warna teks universitas menjadi hitam
          document.querySelector('.link').classList.remove('text-white');
        }

        const footer = document.querySelector('.footer');
        navbar.classList.toggle("dark");
        footer.classList.toggle("dark");
      }


    </script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>