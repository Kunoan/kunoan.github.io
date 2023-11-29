<!DOCTYPE html>
<html>
<head>
    <title>Form Input dan Pencarian Barang</title>
</head>
<body>
    <h2>Form Input dan Pencarian Barang</h2>
    <div>
        <h3>Input Barang</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="nama_barang">Nama Barang:</label><br>
            <input type="text" id="nama_barang" name="nama_barang" required><br><br>

            <label for="tujuan">Tujuan:</label><br>
            <input type="text" id="tujuan" name="tujuan" required><br><br>

            <label for="jumlah_barang">Jumlah Barang:</label><br>
            <input type="number" id="jumlah_barang" name="jumlah_barang" required><br><br>

            <input type="submit" value="Simpan">
        </form>
    </div>

    <div>
        <h3>Pencarian Barang</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <label for="cari_nama_barang">Cari Nama Barang:</label><br>
            <input type="text" id="cari_nama_barang" name="cari_nama_barang" required><br><br>

            <input type="submit" value="Cari">
        </form>

        <?php
        $host = 'localhost'; // Host database (jaringan lokal)
        $username = 'root'; // Username database
        $password = ''; // Password database (kosong karena menggunakan XAMPP)
        $database = 'mata_gelapdb'; // Nama database

        // Melakukan koneksi ke database
        $conn = new mysqli($host, $username, $password, $database);

        // Memeriksa koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Jika form pencarian dikirimkan
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['cari_nama_barang'])) {
            $cari_nama_barang = $_GET['cari_nama_barang'];

            // Menampilkan data berdasarkan pencarian nama barang
            $sql = "SELECT * FROM barang WHERE nama_barang LIKE '%$cari_nama_barang%'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h3>Hasil Pencarian:</h3>";
                echo "<table border='1'>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Tujuan</th>
                        <th>Jumlah Barang</th>
                    </tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row['nama_barang'] . "</td>
                        <td>" . $row['tujuan'] . "</td>
                        <td>" . $row['jumlah_barang'] . "</td>
                    </tr>";
                }

                echo "</table>";
            } else {
                echo "Data tidak ditemukan.";
            }
        }

        // Memproses data dari form input barang
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama_barang = $_POST['nama_barang'];
            $tujuan = $_POST['tujuan'];
            $jumlah_barang = $_POST['jumlah_barang'];

            // Menyimpan data ke dalam tabel 'barang'
            $sql = "INSERT INTO barang (nama_barang, tujuan, jumlah_barang) VALUES ('$nama_barang', '$tujuan', '$jumlah_barang')";

            if ($conn->query($sql) === TRUE) {
                echo "<br>Data berhasil disimpan";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Menutup koneksi
        $conn->close();
        ?>
    </div>
</body>
</html>
