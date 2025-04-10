-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
<<<<<<< HEAD
-- Waktu pembuatan: 08 Mar 2025 pada 17.45
=======
-- Waktu pembuatan: 12 Feb 2025 pada 02.25
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6
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
-- Database: `risti_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `subtasks`
--

CREATE TABLE `subtasks` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `subtasks`
--

INSERT INTO `subtasks` (`id`, `task_id`, `description`, `completed`) VALUES
<<<<<<< HEAD
(1, 1, 'squid game 2', 0),
(2, 8, 'subtask', 0),
(3, 9, 'ada', 0);
=======
(1, 1, 'squid game 2', 0);
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6

-- --------------------------------------------------------

--
-- Struktur dari tabel `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` varchar(100) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `priority` enum('penting','tidak penting','biasa') DEFAULT 'penting',
  `status` enum('ditunda','belum dikerjakan','selesai') DEFAULT 'ditunda'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `created_at`, `description`, `due_date`, `priority`, `status`) VALUES
(1, 1, 'nonton film', '2025-01-24 13:54:57', NULL, NULL, 'penting', 'ditunda'),
(4, 3, 'tugas sekolah', '2025-02-04 04:03:53', 'bahasa inggris', '2025-02-05', 'penting', 'belum dikerjakan'),
<<<<<<< HEAD
(5, 4, 'qefew', '2025-02-12 01:13:50', 'wffwefew', '2025-02-12', 'tidak penting', 'ditunda'),
(8, 5, 'makanas', '2025-03-08 15:59:11', NULL, '2025-03-28', 'tidak penting', 'selesai'),
(9, 5, 'berubah', '2025-03-08 16:06:26', NULL, '2025-03-21', 'biasa', NULL),
(11, 5, 'mandi', '2025-03-08 16:12:35', 'mandi', '2025-03-08', 'penting', 'selesai');
=======
(5, 4, 'qefew', '2025-02-12 01:13:50', 'wffwefew', '2025-02-12', 'tidak penting', 'ditunda');
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'refa', '$2y$10$pnHbTXIueQAF5S/d7y7Og.8qbDHZ6Zz7/w.6KVyQfOrHF8S.M0dum'),
(2, 'tikaa', '$2y$10$lcQzmSbgkJwYIUqUkyTOxe6lAGGf4BpnSsApUsm94C5/OquB.eHfq'),
(3, 'kartika', '$2y$10$Qw4C6VOpR7hHfYm8zfsKQe4hUtWOHxh931dJxZxnJLlJza/kRUUAS'),
<<<<<<< HEAD
(4, 'risti', '$2y$10$dBkofEnmI/.WELoQjTPb4OAqcGE/eDWUVkfR6JBuD..LgDEYAYsxK'),
(5, 'hanssnoturtype', '$2y$10$y3wexkg8xKbh1FGj8WzXqOtf.yseJu1bL2YkDZ/1V02XDE09SZTxq'),
(6, 'adas', '$2y$10$5pA8NaU/yqCO93LOrcgobOKo0oocbMi7MRGeXFUfXtGau2eVDcno.'),
(7, 'dasdad', '$2y$10$HC1TZjsqfxeC26wnU.VSNOM1Y3xHgrFSd7n7GtZXMaAfUwR8901ji');
=======
(4, 'risti', '$2y$10$dBkofEnmI/.WELoQjTPb4OAqcGE/eDWUVkfR6JBuD..LgDEYAYsxK');
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indeks untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `subtasks`
--
ALTER TABLE `subtasks`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6

--
-- AUTO_INCREMENT untuk tabel `tasks`
--
ALTER TABLE `tasks`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `subtasks`
--
ALTER TABLE `subtasks`
  ADD CONSTRAINT `subtasks_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
