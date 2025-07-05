-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jul 2025 pada 20.25
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `whsimrs`
--

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `detailbarang`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `detailbarang` (
`kd_barang` varchar(10)
,`nama_barang` varchar(40)
,`kd_merek` varchar(7)
,`kd_distributor` varchar(7)
,`tanggal_masuk` date
,`harga_barang` int(7)
,`stok_barang` int(4)
,`gambar` varchar(255)
,`keterangan` varchar(200)
,`merek` varchar(30)
,`foto_merek` varchar(50)
,`nama_distributor` varchar(40)
,`no_telp` varchar(13)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `detailtransaksi`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `detailtransaksi` (
`kd_pretransaksi` varchar(7)
,`kd_transaksi` varchar(7)
,`kd_barang` varchar(12)
,`jumlah` int(4)
,`sub_total` int(11)
,`nama_barang` varchar(40)
,`harga_barang` int(7)
,`jumlah_beli` int(4)
,`total_harga` int(8)
,`tanggal_beli` date
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_barang`
--

CREATE TABLE `table_barang` (
  `kd_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(40) NOT NULL,
  `kd_merek` varchar(7) NOT NULL,
  `kd_distributor` varchar(7) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `harga_barang` int(7) NOT NULL,
  `stok_barang` int(4) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `spesifikasi` varchar(1000) NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_barang_hardware`
--

CREATE TABLE `table_barang_hardware` (
  `kd_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(40) NOT NULL,
  `kd_merek` varchar(7) NOT NULL,
  `kd_distributor` varchar(7) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `harga_barang` int(7) NOT NULL,
  `stok_barang` int(4) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `spesifikasi` varchar(1000) NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_distributor`
--

CREATE TABLE `table_distributor` (
  `kd_distributor` varchar(7) NOT NULL,
  `nama_distributor` varchar(40) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_telp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_merek`
--

CREATE TABLE `table_merek` (
  `kd_merek` varchar(7) NOT NULL,
  `merek` varchar(30) NOT NULL,
  `foto_merek` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_pretransaksi`
--

CREATE TABLE `table_pretransaksi` (
  `kd_pretransaksi` varchar(7) NOT NULL,
  `kd_transaksi` varchar(7) NOT NULL,
  `kd_barang` varchar(12) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `penempatan` varchar(20) NOT NULL,
  `penerima` varchar(50) NOT NULL,
  `sub_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Trigger `table_pretransaksi`
--
DELIMITER $$
CREATE TRIGGER `batal_beli` AFTER DELETE ON `table_pretransaksi` FOR EACH ROW UPDATE table_barang SET
stok_barang = stok_barang + OLD.jumlah
WHERE kd_barang = OLD.kd_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transaksi` AFTER INSERT ON `table_pretransaksi` FOR EACH ROW UPDATE table_barang SET
stok_barang = stok_barang - new.jumlah
WHERE kd_barang = new.kd_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_beli` AFTER UPDATE ON `table_pretransaksi` FOR EACH ROW UPDATE table_barang SET
stok_barang = stok_barang + OLD.jumlah - NEW.jumlah
WHERE kd_barang = new.kd_barang
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_pretransaksi_hardware`
--

CREATE TABLE `table_pretransaksi_hardware` (
  `kd_pretransaksi` varchar(7) NOT NULL,
  `kd_transaksi` varchar(7) NOT NULL,
  `kd_barang` varchar(12) NOT NULL,
  `jumlah` int(4) NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `penempatan` varchar(40) NOT NULL,
  `penerima` varchar(50) NOT NULL,
  `sub_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Trigger `table_pretransaksi_hardware`
--
DELIMITER $$
CREATE TRIGGER `batal_beli_copy1` AFTER DELETE ON `table_pretransaksi_hardware` FOR EACH ROW UPDATE table_barang SET
stok_barang = stok_barang + OLD.jumlah
WHERE kd_barang = OLD.kd_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transaksi_copy1` AFTER INSERT ON `table_pretransaksi_hardware` FOR EACH ROW UPDATE table_barang SET
stok_barang = stok_barang - new.jumlah
WHERE kd_barang = new.kd_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_beli_copy1` AFTER UPDATE ON `table_pretransaksi_hardware` FOR EACH ROW UPDATE table_barang SET
stok_barang = stok_barang + OLD.jumlah - NEW.jumlah
WHERE kd_barang = new.kd_barang
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_transaksi`
--

CREATE TABLE `table_transaksi` (
  `kd_transaksi` varchar(7) NOT NULL,
  `kd_user` varchar(7) NOT NULL,
  `jumlah_beli` int(4) NOT NULL,
  `penempatan` varchar(20) NOT NULL,
  `total_harga` int(8) NOT NULL,
  `tanggal_beli` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_transaksi_hardware`
--

CREATE TABLE `table_transaksi_hardware` (
  `kd_transaksi` varchar(7) NOT NULL,
  `kd_user` varchar(7) NOT NULL,
  `jumlah_beli` int(4) NOT NULL,
  `penempatan` varchar(20) NOT NULL,
  `total_harga` int(8) NOT NULL,
  `tanggal_beli` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `table_user`
--

CREATE TABLE `table_user` (
  `kd_user` varchar(7) NOT NULL,
  `nama_user` varchar(30) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `foto_user` varchar(50) NOT NULL,
  `level` enum('Admin','Network Engineer','Hardware') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `table_user`
--

INSERT INTO `table_user` (`kd_user`, `nama_user`, `username`, `password`, `foto_user`, `level`) VALUES
('US002', 'Administrator', 'administrator', 'MTIzNDU=', '1751696306257.jpg', 'Admin'),
('US003', 'Wahyu Ummy Putra', 'network_putra', 'MTIzNDU=', '1751696382357.jpg', 'Network Engineer'),
('US004', 'Nofriadi', 'network_nofriadi', 'MTIzNDU=', '175169643640.jpg', 'Network Engineer'),
('US005', 'Arie Primadona Harza', 'hardware_ari', 'MTIzNDU=', '1751696480470.jpg', 'Hardware'),
('US006', 'Gilank Pratama Putra', 'hardware_gilank', 'MTIzNDU=', '17516965005.jpg', 'Hardware'),
('US007', 'Mirantie Prima Surya', 'karu_mirantie', 'MTIzNDU=', '1751696582924.jpg', 'Admin');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `transaksi`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `transaksi` (
`kd_pretransaksi` varchar(7)
,`kd_transaksi` varchar(7)
,`kd_barang` varchar(12)
,`jumlah` int(4)
,`sub_total` int(11)
,`nama_barang` varchar(40)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `transaksi_terbaru`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `transaksi_terbaru` (
`kd_transaksi` varchar(7)
,`kd_user` varchar(7)
,`jumlah_beli` int(4)
,`total_harga` int(8)
,`tanggal_beli` date
,`nama_user` varchar(30)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `detailbarang`
--
DROP TABLE IF EXISTS `detailbarang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detailbarang`  AS SELECT `table_barang`.`kd_barang` AS `kd_barang`, `table_barang`.`nama_barang` AS `nama_barang`, `table_barang`.`kd_merek` AS `kd_merek`, `table_barang`.`kd_distributor` AS `kd_distributor`, `table_barang`.`tanggal_masuk` AS `tanggal_masuk`, `table_barang`.`harga_barang` AS `harga_barang`, `table_barang`.`stok_barang` AS `stok_barang`, `table_barang`.`gambar` AS `gambar`, `table_barang`.`keterangan` AS `keterangan`, `table_merek`.`merek` AS `merek`, `table_merek`.`foto_merek` AS `foto_merek`, `table_distributor`.`nama_distributor` AS `nama_distributor`, `table_distributor`.`no_telp` AS `no_telp` FROM ((`table_barang` join `table_merek` on(`table_barang`.`kd_merek` = `table_merek`.`kd_merek`)) join `table_distributor` on(`table_barang`.`kd_distributor` = `table_distributor`.`kd_distributor`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `detailtransaksi`
--
DROP TABLE IF EXISTS `detailtransaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detailtransaksi`  AS SELECT `table_pretransaksi`.`kd_pretransaksi` AS `kd_pretransaksi`, `table_pretransaksi`.`kd_transaksi` AS `kd_transaksi`, `table_pretransaksi`.`kd_barang` AS `kd_barang`, `table_pretransaksi`.`jumlah` AS `jumlah`, `table_pretransaksi`.`sub_total` AS `sub_total`, `table_barang`.`nama_barang` AS `nama_barang`, `table_barang`.`harga_barang` AS `harga_barang`, `table_transaksi`.`jumlah_beli` AS `jumlah_beli`, `table_transaksi`.`total_harga` AS `total_harga`, `table_transaksi`.`tanggal_beli` AS `tanggal_beli` FROM ((`table_pretransaksi` join `table_barang` on(`table_pretransaksi`.`kd_barang` = `table_barang`.`kd_barang`)) join `table_transaksi` on(`table_transaksi`.`kd_transaksi` = `table_pretransaksi`.`kd_transaksi`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `transaksi`
--
DROP TABLE IF EXISTS `transaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transaksi`  AS SELECT `table_pretransaksi`.`kd_pretransaksi` AS `kd_pretransaksi`, `table_pretransaksi`.`kd_transaksi` AS `kd_transaksi`, `table_pretransaksi`.`kd_barang` AS `kd_barang`, `table_pretransaksi`.`jumlah` AS `jumlah`, `table_pretransaksi`.`sub_total` AS `sub_total`, `table_barang`.`nama_barang` AS `nama_barang` FROM (`table_pretransaksi` join `table_barang` on(`table_pretransaksi`.`kd_barang` = `table_barang`.`kd_barang`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `transaksi_terbaru`
--
DROP TABLE IF EXISTS `transaksi_terbaru`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transaksi_terbaru`  AS SELECT `table_transaksi`.`kd_transaksi` AS `kd_transaksi`, `table_transaksi`.`kd_user` AS `kd_user`, `table_transaksi`.`jumlah_beli` AS `jumlah_beli`, `table_transaksi`.`total_harga` AS `total_harga`, `table_transaksi`.`tanggal_beli` AS `tanggal_beli`, `table_user`.`nama_user` AS `nama_user` FROM (`table_transaksi` join `table_user` on(`table_transaksi`.`kd_user` = `table_user`.`kd_user`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `table_barang`
--
ALTER TABLE `table_barang`
  ADD PRIMARY KEY (`kd_barang`),
  ADD KEY `kd_distributor` (`kd_distributor`),
  ADD KEY `kd_merek` (`kd_merek`);

--
-- Indeks untuk tabel `table_barang_hardware`
--
ALTER TABLE `table_barang_hardware`
  ADD PRIMARY KEY (`kd_barang`),
  ADD KEY `kd_distributor` (`kd_distributor`),
  ADD KEY `kd_merek` (`kd_merek`);

--
-- Indeks untuk tabel `table_distributor`
--
ALTER TABLE `table_distributor`
  ADD PRIMARY KEY (`kd_distributor`);

--
-- Indeks untuk tabel `table_merek`
--
ALTER TABLE `table_merek`
  ADD PRIMARY KEY (`kd_merek`);

--
-- Indeks untuk tabel `table_pretransaksi`
--
ALTER TABLE `table_pretransaksi`
  ADD PRIMARY KEY (`kd_pretransaksi`);

--
-- Indeks untuk tabel `table_pretransaksi_hardware`
--
ALTER TABLE `table_pretransaksi_hardware`
  ADD PRIMARY KEY (`kd_pretransaksi`);

--
-- Indeks untuk tabel `table_transaksi`
--
ALTER TABLE `table_transaksi`
  ADD PRIMARY KEY (`kd_transaksi`),
  ADD KEY `kd_user` (`kd_user`);

--
-- Indeks untuk tabel `table_transaksi_hardware`
--
ALTER TABLE `table_transaksi_hardware`
  ADD PRIMARY KEY (`kd_transaksi`),
  ADD KEY `kd_user` (`kd_user`);

--
-- Indeks untuk tabel `table_user`
--
ALTER TABLE `table_user`
  ADD PRIMARY KEY (`kd_user`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `table_transaksi`
--
ALTER TABLE `table_transaksi`
  ADD CONSTRAINT `table_transaksi_ibfk_1` FOREIGN KEY (`kd_user`) REFERENCES `table_user` (`kd_user`);

--
-- Ketidakleluasaan untuk tabel `table_transaksi_hardware`
--
ALTER TABLE `table_transaksi_hardware`
  ADD CONSTRAINT `table_transaksi_hardware_ibfk_1` FOREIGN KEY (`kd_user`) REFERENCES `table_user` (`kd_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
