<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Periksa apakah data POST tidak kosong
if (!empty($_POST)) {
   // Data postingan tidak kosong masukkan record baru
  // Siapkan variabel yang akan dimasukkan, kita harus memeriksa apakah variabel POST ada, jika tidak, kita dapat mengosongkannya secara default
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
   // Periksa apakah variabel POST "nama" ada, jika tidak default nilainya kosong, pada dasarnya sama untuk semua variabel
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $notelp = isset($_POST['notelp']) ? $_POST['notelp'] : '';
    $pekerjaan = isset($_POST['pekerjaan']) ? $_POST['pekerjaan'] : '';

    // Insert data baru ke dalam tabel kontak
    $stmt = $pdo->prepare('INSERT INTO kontak VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$id, $nama, $email, $notelp, $pekerjaan]);
    // Output Pesan
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Contact</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="nama">Nama</label>
        <input type="text" name="id" value="auto" id="id">
        <input type="text" name="nama" id="nama">
        <label for="email">Email</label>
        <label for="notelp">No. Telp</label>
        <input type="text" name="email" id="email">
        <input type="text" name="notelp" id="notelp">
        <label for="pekerjaan">Pekerjaan</label>
        <input type="text" name="pekerjaan" id="pekerjaan">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>