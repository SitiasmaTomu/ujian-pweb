<?php
include 'functions.php';
// konek untuk MySQL database
$pdo = pdo_connect_mysql();
// Dapatkan halaman melalui permintaan GET (param URL: halaman), jika tidak ada, default halamannya adalah 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Jumlah rekaman yang akan ditampilkan pada setiap halaman
$records_per_page = 5;


//Siapkan pernyataan SQL dan dapatkan catatan dari tabel kontak kami, LIMIT akan menentukan halamannya
$stmt = $pdo->prepare('SELECT * FROM kontak ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Ambil catatannya sehingga kami dapat menampilkannya di templat kami.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);


//Mendapatkan jumlah total kontak, hal ini agar kita dapat menentukan apakah harus ada tombol next dan previous
$num_contacts = $pdo->query('SELECT COUNT(*) FROM kontak')->fetchColumn();
?>


<?=template_header('Read')?>

<div class="content read">
	<h2>Read Contacts</h2>
	<a href="create.php" class="create-contact">Create Contact</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nama</td>
                <td>Email</td>
                <td>No. Telp</td>
                <td>Pekerjaan</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['id']?></td>
                <td><?=$contact['nama']?></td>
                <td><?=$contact['email']?></td>
                <td><?=$contact['notelp']?></td>
                <td><?=$contact['pekerjaan']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$contact['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$contact['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>