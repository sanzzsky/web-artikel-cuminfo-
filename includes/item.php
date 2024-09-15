<?php
$sql = "SELECT id, gambar, judul, tanggal, author, isiArtikel FROM artikel";
$result = $conn->query($sql);

function truncate_words($text, $limit) {
    $words = explode(' ', $text);
    if (count($words) > $limit) {
        return implode(' ', array_slice($words, 0, $limit)) . ',';
    } else {
        return $text;
    }
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $gambar = substr($row["gambar"], 3); // Menghapus tiga huruf pertama dari nilai gambar
        $isiSingkat = truncate_words($row["isiArtikel"], 45); // Memotong teks setelah 50 kata
        echo '
        <div class="item">
            <a href="pages/isi-item.php?id=' . $row["id"] . '">
                <img class="gambar-item" src="' . $gambar . '" alt="Gambar"/> 
            </a>
            <div class="item-konten">
                <a href="pages/isi-item.php?id=' . $row["id"] . '" class="ajudul">
                    <div class="judul-konten">' . $row["judul"] . '</div>
                </a>
                <div class="date-author">
                    <p>' . date("F j, Y", strtotime($row["tanggal"])) . '<span>ㅤ|ㅤ</span>' . $row["author"] . '</p>
                </div>
                <p>' . $isiSingkat . '
                    <a href="pages/isi-item.php?id=' . $row["id"] . '" class="baca">Baca selengkapnya...</a>
                </p>
            </div>
        </div>';
    }
} else {
    echo "Belum ada artikel, silahkan tambahkan artikel";
}
?>
