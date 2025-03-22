-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Mar 2025 pada 07.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `joinproject`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `status`, `kategori`) VALUES
(20, 'Buku Baru', 'Archived', 'Mobile');

-- --------------------------------------------------------

--
-- Struktur dari tabel `todolist`
--

CREATE TABLE `todolist` (
  `id` int(11) NOT NULL,
  `nama_todo` varchar(255) NOT NULL,
  `nama_project` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `jumlah` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'a@gmail.com', '$2y$10$QRcllzdeaOV8plIG93eMzubt4Typ98haGcwZbfqmtsg/DIYKhMWLu'),
(2, 'user', 'u@gmail.com', '$2y$10$5qoUlaLVrqoiZL2qDCcMf.gC1/DQ8k5lfvtL43Y9EYNd4KKr7bD1i'),
(3, 'weeeaaa', 'ww@gmail.com', '$2y$10$JK9errV6.BB6GOgrOn58geCTD6UYAOuIZt/DURW4/FPBk2t3qq8f2'),
(4, 'Eka', 'e@gmail.com', '$2y$10$0U37Nv57CV3jyRy4yNji4eE/izITCIlx0uLYMSKgA0CN4/nl.l5M2'),
(5, 'Dika', 'dika@gmail.com', '$2y$10$cttRJ0rLp7ZQ3HzhWVl59OcH.z4LulP6BSAuWAAAGBeENHZA/DAiS'),
(6, 'Dafa', 'dafa@gmail.com', '$2y$10$VNI.VO7Kp57Gdy9tWRLQvuc3nvcEwFBLoROoBEhFlXdExucsctqu2'),
(7, 'Tono', 'tono@gmail.com', '$2y$10$cirKE9nullDpr1W9x.laOujG1OE45tU9zuXyOGvXF7S7ZRAHVTn.q'),
(8, 'sss', 'darrellgta@gmail.com', '$2y$10$6dhRObqtjp8XadWqcBn45O92Z1Q/D7JQZ7RCRWHJeBAS8l/vYIofy'),
(9, 'sera', 's@gmail.com', '$2y$10$KMFbXRa0ZrTJf1R60pMZ6OSrvC8B673GdIeWVQS.gkOmhBz5KuypC'),
(10, 'eko', 'eko@gmail.com', '$2y$10$UYFvZ2m55VxbWs6qZtWkGO.Zmq0t4iRogioWbx3QbwKIvCLYL/u1u');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `todolist`
--
ALTER TABLE `todolist`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `todolist`
--
ALTER TABLE `todolist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
