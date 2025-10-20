<?php 
session_start();
include "config.php"; 
if(!isset($_SESSION["admin_id"])) header("Location: index.php");
$admin = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { overflow-x: hidden; background-color: #f5f7fa; }
        .navbar-brand { font-weight: bold; }
        .admin-info { display: flex; align-items: center; gap: 8px; color: #fff; font-weight: 500; }
        .admin-info i { font-size: 20px; }

        /* Sidebar */
        .sidebar { position: fixed; top:0; left:0; bottom:0; background-color:#212529; padding-top:70px; width:205px; transition: all 0.3s; z-index:1000; }
        .sidebar.collapsed { width:70px; }
        .sidebar a { color:#fff !important; padding:12px 20px; display:flex; align-items:center; gap:12px; text-decoration:none; font-weight:500; transition: all 0.3s; white-space:nowrap; }
        .sidebar a:hover { background-color:#495057; padding-left:25px; }
        .sidebar a.active { background-color:#0d6efd; color:#fff !important; }
        .sidebar.collapsed a span { display:none; }

        /* Konten utama */
        #content { margin-left:220px; margin-top:75px; padding:20px; transition: all 0.3s; }
        .sidebar.collapsed ~ #content { margin-left:70px; }

        /* Info box dashboard */
       .info-box {
    background-color:#fff; 
    border-radius:10px; 
    padding:25px; 
    margin-bottom:25px; 
    box-shadow:0 3px 10px rgba(0,0,0,0.1); 
    transition: all 0.3s ease;
    cursor:pointer;
}
.info-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
    background-color:#f8f9fa;
}

/* 🔹 Fokus ke angka saja */
.info-box h2 {
    font-size: 2.5rem;   /* ukuran angka seragam */
    font-weight: 800;    /* ketebalan sama */
    color: #212529;      /* warna teks seragam */
    margin-top: 10px;
}

    </style>
</head>
<body>
<!-- Navbar atas -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3 fixed-top">
  <button class="btn btn-outline-light me-3" id="toggleSidebar"><i class="bi bi-list"></i></button>
  <a class="navbar-brand">Diagnosa Hipertensi</a>
  <div class="ms-auto d-flex align-items-center gap-3">
      <div class="admin-info"><i class="bi bi-person-circle"></i> Hello, <?php echo $admin; ?></div>
      <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
  </div>
</nav>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a data-page="welcome" class="active"><i class="bi bi-house-door"></i> <span>Dashboard</span></a>
    <a data-page="pasien.php"><i class="bi bi-person-plus"></i> <span>Data Pasien</span></a>
    <a data-page="rekam.php"><i class="bi bi-file-earmark-medical"></i> <span>Data Rekam Medis</span></a>
    <a data-page="diagnosa.php"><i class="bi bi-activity"></i> <span>Lihat Diagnosa</span></a>
</div>

<!-- Konten utama -->
<div id="content">
    <div class="text-center mt-5">
        <h2 class="fw-bold text-dark">Selamat Datang, <?php echo $admin; ?>! 🎉</h2> 
        <br>
        <p class="lead text-muted">
           <b> Semoga hari Anda menyenangkan & penuh semangat.<br>
            Teruslah memberikan pelayanan terbaik dengan sistem ini 💪.</b>
        </p>
        
        <br>

        <!-- Info Box -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="info-box text-center border-start border-primary border-4 shadow-sm" id="boxPasien">
                    <i class="bi bi-people-fill text-primary" style="font-size: 40px;"></i>
                    <h4 class="mt-2 fw-bold">Total Pasien</h4>
                    <h2 class="text-dark fw-bolder mt-2" id="totalPasien">Loading...</h2>
                    <p class="text-muted">Jumlah seluruh pasien terdaftar</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box text-center border-start border-success border-4 shadow-sm" id="boxRekam">
                    <i class="bi bi-clipboard2-pulse text-success" style="font-size: 40px;"></i>
                    <h4 class="mt-2 fw-bold">Rekam Medis Terbaru</h4>
                    <h2 class="text-dark mt-2 fw-semibold" id="rekamTerbaru">Loading...</h2>
                    <p class="text-muted">Data rekam medis terbaru pasien</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box text-center border-start border-danger border-4 shadow-sm" id="boxDiagnosa">
                    <i class="bi bi-heart-pulse text-danger" style="font-size: 40px;"></i>
                    <h4 class="mt-2 fw-bold">Diagnosa Hari Ini</h4>
                    <h2 class="text-dark fw-bolder mt-2" id="diagnosaHariIni">Loading...</h2>
                    <p class="text-muted">Jumlah diagnosa yang dilakukan hari ini</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-box-arrow-right"></i> Konfirmasi Logout</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p>Halo, <b><?= $admin ?></b> Anda yakin ingin keluar dari aplikasi?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="logout.php" class="btn btn-danger">Ya, Keluar</a>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    // Toggle sidebar
    $("#toggleSidebar").click(function(){ $("#sidebar").toggleClass("collapsed"); });

    // Navigasi sidebar
    $(".sidebar a").click(function(e){
        e.preventDefault(); 
        $(".sidebar a").removeClass("active"); 
        $(this).addClass("active"); 

        let page = $(this).data("page");
        if(page === "welcome") {
            $("#content").load("dashboard.php #content>*");
        } else {
            $("#content").load(page, loadDashboardInfo);
        }
    });

    // Load dashboard info AJAX
    function loadDashboardInfo(){
        $.get("dashboard_info.php", function(data){
            let info = JSON.parse(data);
            $("#totalPasien").text(info.totalPasien);
            $("#rekamTerbaru").text(info.rekamTerbaru);
            $("#diagnosaHariIni").text(info.diagnosaHariIni);
        }).fail(function(){
            $("#totalPasien").text("-");
            $("#rekamTerbaru").text("-");
            $("#diagnosaHariIni").text("-");
        });
    }

    // Load pertama kali
    loadDashboardInfo();
});
</script>
</body>
</html>
