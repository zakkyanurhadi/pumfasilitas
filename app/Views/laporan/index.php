<title>Sistem Pengaduan Fasilitas - Polinela</title>
<?php
// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// UNKOMENTARI BAGIAN INI UNTUK POST HANDLING:
// Proses form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error_message'] = 'Token keamanan tidak valid.';
        header('Location: create.php');
        exit;
    }

    $controller->createReport();
    exit;
}

// Tampilkan pesan error jika ada
$errors = $_SESSION['error_messages'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];
unset($_SESSION['error_messages'], $_SESSION['form_data']);
?>
<?= $this->extend('layouts/user/main') ?>


<title>Form Laporan</title>

<?= $this->section('content') ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pelaporan Kampus - Form Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <style>
        :root {
            --primary-blue: #2c5ef3;
            --dark-blue: #0e3eb4;
            --text-dark: #1a202c;
            --text-grey: #718096;
            --bg-light: #f8f9fa;

            /* Tambahkan variabel yang hilang untuk memperbaiki transparansi */
            --white: #FFFFFF;
            --gray-100: #F7FAFC;
            --gray-200: #EDF2F7;
            --gray-800: #2D3748;
            /* Warna teks dropdown */
            --border-radius: 0.5rem;
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            color: var(--text-dark);
            padding-top: 80px;
            /* Tambahkan padding untuk menghindari konten tertutup navbar */
        }

        /* === NAVBAR === */
        .navbar {
            z-index: 9999 !important;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand img {
            z-index: 9999 !important;
            height: 45px;
            margin-right: 10px;
        }

        .nav-link {
            z-index: 9999 !important;
            color: var(--text-dark);
            font-weight: 500;
            margin-left: 1.5rem;
            transition: 0.3s;
        }

        .nav-link:hover {
            z-index: 9999 !important;
            color: var(--primary-blue);
        }

        /* User Profile Dropdown Styling */
        .user-profile {
            z-index: 9999 !important;
            position: relative;
        }

        .profile-info {
            z-index: 9999 !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--border-radius);
            transition: background-color 0.3s ease;
        }

        .profile-info:hover {
            z-index: 9999 !important;
            background-color: #f0f0f0;
            /* Warna hover yang lebih jelas */
        }

        .profile-pic {
            z-index: 9999 !important;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--white);
        }

        .dropdown {
            z-index: 9999 !important;
            display: none;
            position: absolute;
            top: 120%;
            right: 0;
            background-color: var(--white);
            color: var(--gray-800);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            width: 250px;
            z-index: 9999;
            /* Naikkan z-index untuk memastikan di atas elemen lain */
            overflow: hidden;
            animation: dropdown-fade-in 0.2s ease-out;
        }

        @keyframes dropdown-fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-header {
            z-index: 9999 !important;
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            gap: 1rem;
        }

        .profile-pic-large {
            z-index: 9999 !important;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .role {
            z-index: 9999 !important;
            font-size: 0.9rem;
            color: var(--secondary-color);
        }

        .dropdown ul {
            z-index: 9999 !important;
            list-style: none;
        }

        .dropdown ul li a {
            z-index: 9999 !important;
            display: block;
            padding: 0.75rem 1rem;
            color: var(--gray-800);
            text-decoration: none;
            transition: background-color 0.2s ease;
        }

        .dropdown ul li a:hover {
            z-index: 9999 !important;
            background-color: var(--gray-100);
        }

        .btn-nav-login {
            z-index: 9999 !important;
            background-color: var(--primary-blue);
            color: white;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-nav-login:hover {
            z-index: 9999 !important;
            background-color: var(--dark-blue);
            color: white;
            transform: translateY(-2px);
        }


        /* Animasi Fade In Up */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animasi Scale In */
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Animasi Bounce */
        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Animasi Pulse */
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }


        /* Animasi untuk section */
        .animate-section {
            animation: fadeInUp 0.8s ease-out;
            animation-fill-mode: both;
        }

        .animate-section:nth-child(1) {
            animation-delay: 0.1s;
        }

        .animate-section:nth-child(2) {
            animation-delay: 0.2s;
        }

        .animate-section:nth-child(3) {
            animation-delay: 0.3s;
        }

        .animate-section:nth-child(4) {
            animation-delay: 0.4s;
        }

        .animate-section:nth-child(5) {
            animation-delay: 0.5s;
        }

        /* Animasi untuk category cards */
        .category-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            animation: scaleIn 0.5s ease-out;
            animation-fill-mode: both;
        }

        .category-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .category-card:nth-child(2) {
            animation-delay: 0.15s;
        }

        .category-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .category-card:nth-child(4) {
            animation-delay: 0.25s;
        }

        .category-card:nth-child(5) {
            animation-delay: 0.3s;
        }

        .category-card:nth-child(6) {
            animation-delay: 0.35s;
        }

        .category-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
        }

        .category-card input[type="radio"]:checked+.category-content {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: #3b82f6;
            box-shadow: 0 10px 30px -5px rgba(59, 130, 246, 0.3);
        }

        .category-card input[type="radio"]:checked+.category-content {
            animation: pulse 0.5s ease-out;
        }

        .category-card .category-content {
            transition: all 0.3s ease;
        }

        /* Animasi untuk icon kategori */
        .category-icon {
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon {
            animation: bounce 0.6s ease infinite;
        }

        /* File drop zone animations */
        .file-drop-zone {
            border: 2px dashed #d1d5db;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .file-drop-zone.dragover {
            border-color: #3b82f6;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            transform: scale(1.02);
            box-shadow: 0 10px 30px -5px rgba(59, 130, 246, 0.2);
        }

        /* Image preview animations */
        .image-preview {
            position: relative;
            overflow: hidden;
            animation: scaleIn 0.4s ease-out;
            transition: all 0.3s ease;
        }

        .image-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .image-preview:hover img {
            transform: scale(1.1);
        }

        .remove-image {
            position: absolute;
            top: 4px;
            right: 4px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: all 0.3s ease;
            transform: scale(0);
        }

        .image-preview:hover .remove-image {
            opacity: 1;
            transform: scale(1);
        }

        .remove-image:hover {
            background: rgba(239, 68, 68, 0.9);
            transform: scale(1.1);
        }

        /* Toggle switch animations */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        input:checked+.slider {
            background-color: #3b82f6;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }

        .slider:active:before {
            width: 24px;
        }

        /* Button animations */
        button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.15);
        }

        button:active {
            transform: translateY(0);
            box-shadow: 0 5px 10px -5px rgba(0, 0, 0, 0.15);
        }

        /* Input focus animations */
        input[type="text"],
        input[type="email"],
        textarea {
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2);
        }

        /* Section divider animation */
        .section-divider {
            margin: 3rem 0;
            border-bottom: 2px solid #e5e7eb;
            position: relative;
            overflow: hidden;
        }

        .section-divider::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #3b82f6, transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        /* Success message animation */
        .success-message {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Number badge animation */
        .number-badge {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Checkbox animation */
        input[type="checkbox"] {
            transition: all 0.2s ease;
        }

        input[type="checkbox"]:checked {
            animation: bounce 0.4s ease;
        }

        /* Info box animation */
        .info-box {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Hover effect untuk form sections */
        .form-section {
            transition: all 0.3s ease;
        }

        .form-section:hover {
            box-shadow: 0 15px 40px -10px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Custom Bootstrap styles */
        .bg-white {
            background-color: #fff !important;
        }

        .rounded-xl {
            border-radius: 0.75rem !important;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        .border-gray-200 {
            border-color: #e5e7eb !important;
        }

        .text-blue-600 {
            color: #2563eb !important;
        }

        .text-gray-900 {
            color: #111827 !important;
        }

        .text-gray-600 {
            color: #4b5563 !important;
        }

        .text-gray-700 {
            color: #374151 !important;
        }

        .text-gray-500 {
            color: #6b7280 !important;
        }

        .bg-blue-100 {
            background-color: #dbeafe !important;
        }

        .bg-green-100 {
            background-color: #d1fae5 !important;
        }

        .bg-purple-100 {
            background-color: #e9d5ff !important;
        }

        .bg-red-100 {
            background-color: #fee2e2 !important;
        }

        .bg-yellow-100 {
            background-color: #fef3c7 !important;
        }

        .bg-gray-100 {
            background-color: #f3f4f6 !important;
        }

        .bg-blue-50 {
            background-color: #eff6ff !important;
        }

        .bg-yellow-50 {
            background-color: #fffbeb !important;
        }

        .bg-gray-50 {
            background-color: #f9fafb !important;
        }

        .border-blue-200 {
            border-color: #bfdbfe !important;
        }

        .border-yellow-200 {
            border-color: #fde68a !important;
        }

        .text-blue-900 {
            color: #1e3a8a !important;
        }

        .text-yellow-900 {
            color: #78350f !important;
        }

        .text-blue-700 {
            color: #1d4ed8 !important;
        }

        .text-yellow-700 {
            color: #a16207 !important;
        }

        .text-red-600 {
            color: #dc2626 !important;
        }

        .text-green-600 {
            color: #16a34a !important;
        }

        .text-green-800 {
            color: #166534 !important;
        }

        .text-green-700 {
            color: #15803d !important;
        }

        .bg-green-600 {
            background-color: #16a34a !important;
        }

        .hover\:bg-green-700:hover {
            background-color: #15803d !important;
        }

        .bg-blue-600 {
            background-color: #2563eb !important;
        }

        .hover\:bg-blue-700:hover {
            background-color: #1d4ed8 !important;
        }

        .hover\:bg-gray-50:hover {
            background-color: #f9fafb !important;
        }

        .focus\:ring-blue-500:focus {
            --tw-ring-color: #3b82f6 !important;
        }

        .focus\:border-transparent:focus {
            border-color: transparent !important;
        }

        .focus\:ring-blue-500:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5) !important;
        }

        .focus\:ring-blue-500:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color) !important;
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color) !important;
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000) !important;
        }

        .grid {
            display: grid !important;
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        .grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }

        .grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }

        .gap-4 {
            gap: 1rem !important;
        }

        .gap-6 {
            gap: 1.5rem !important;
        }

        .space-y-1> :not([hidden])~ :not([hidden]) {
            margin-top: 0.25rem !important;
        }

        .space-y-2> :not([hidden])~ :not([hidden]) {
            margin-top: 0.5rem !important;
        }

        .space-y-4> :not([hidden])~ :not([hidden]) {
            margin-top: 1rem !important;
        }

        .space-y-6> :not([hidden])~ :not([hidden]) {
            margin-top: 1.5rem !important;
        }

        .space-y-8> :not([hidden])~ :not([hidden]) {
            margin-top: 2rem !important;
        }

        .space-x-3> :not([hidden])~ :not([hidden]) {
            margin-left: 0.75rem !important;
        }

        .space-x-4> :not([hidden])~ :not([hidden]) {
            margin-left: 1rem !important;
        }

        .flex {
            display: flex !important;
        }

        .items-center {
            align-items: center !important;
        }

        .items-start {
            align-items: flex-start !important;
        }

        .justify-between {
            justify-content: space-between !important;
        }

        .justify-center {
            justify-content: center !important;
        }

        .text-center {
            text-align: center !important;
        }

        .block {
            display: block !important;
        }

        .hidden {
            display: none !important;
        }

        .relative {
            position: relative !important;
        }

        .absolute {
            position: absolute !important;
        }

        .w-full {
            width: 100% !important;
        }

        .w-10 {
            width: 2.5rem !important;
        }

        .w-16 {
            width: 4rem !important;
        }

        .w-5 {
            width: 1.25rem !important;
        }

        .w-8 {
            width: 2rem !important;
        }

        .w-12 {
            width: 3rem !important;
        }

        .w-3 {
            width: 0.75rem !important;
        }

        .h-10 {
            height: 2.5rem !important;
        }

        .h-16 {
            height: 4rem !important;
        }

        .h-5 {
            height: 1.25rem !important;
        }

        .h-8 {
            height: 2rem !important;
        }

        .h-12 {
            height: 3rem !important;
        }

        .h-3 {
            height: 0.75rem !important;
        }

        .h-4 {
            height: 1rem !important;
        }

        .h-32 {
            height: 8rem !important;
        }

        .h-28 {
            height: 7rem !important;
        }

        .min-h-screen {
            min-height: 100vh !important;
        }

        .p-4 {
            padding: 1rem !important;
        }

        .p-6 {
            padding: 1.5rem !important;
        }

        .p-8 {
            padding: 2rem !important;
        }

        .px-4 {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        .px-6 {
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }

        .px-8 {
            padding-left: 2rem !important;
            padding-right: 2rem !important;
        }

        .py-2 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        .py-3 {
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
        }

        .py-8 {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }

        .py-1 {
            padding-top: 0.25rem !important;
            padding-bottom: 0.25rem !important;
        }

        .py-6 {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }

        .pt-8 {
            padding-top: 2rem !important;
        }

        .pb-8 {
            padding-bottom: 2rem !important;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .mb-4 {
            margin-bottom: 1rem !important;
        }

        .mb-6 {
            margin-bottom: 1.5rem !important;
        }

        .mt-1 {
            margin-top: 0.25rem !important;
        }

        .mt-4 {
            margin-top: 1rem !important;
        }

        .mt-8 {
            margin-top: 2rem !important;
        }

        .mt-16 {
            margin-top: 4rem !important;
        }

        .ml-1 {
            margin-left: 0.25rem !important;
        }

        .ml-2 {
            margin-left: 0.5rem !important;
        }

        .ml-4 {
            margin-left: 1rem !important;
        }

        .mr-2 {
            margin-right: 0.5rem !important;
        }

        .mr-4 {
            margin-right: 1rem !important;
        }

        .mx-auto {
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .max-w-4xl {
            max-width: 56rem !important;
        }

        .max-w-7xl {
            max-width: 80rem !important;
        }

        .rounded-lg {
            border-radius: 0.5rem !important;
        }

        .rounded-full {
            border-radius: 9999px !important;
        }

        .border {
            border-width: 1px !important;
        }

        .border-2 {
            border-width: 2px !important;
        }

        .border-gray-200 {
            border-color: #e5e7eb !important;
        }

        .border-gray-300 {
            border-color: #d1d5db !important;
        }

        .border-blue-200 {
            border-color: #bfdbfe !important;
        }

        .border-yellow-200 {
            border-color: #fde68a !important;
        }

        .border-transparent {
            border-color: transparent !important;
        }

        .border-b {
            border-bottom-width: 1px !important;
        }

        .border-t {
            border-top-width: 1px !important;
        }

        .bg-gray-50 {
            background-color: #f9fafb !important;
        }

        .text-sm {
            font-size: 0.875rem !important;
            line-height: 1.25rem !important;
        }

        .text-xs {
            font-size: 0.75rem !important;
            line-height: 1rem !important;
        }

        .text-lg {
            font-size: 1.125rem !important;
            line-height: 1.75rem !important;
        }

        .text-xl {
            font-size: 1.25rem !important;
            line-height: 1.75rem !important;
        }

        .text-3xl {
            font-size: 1.875rem !important;
            line-height: 2.25rem !important;
        }

        .font-medium {
            font-weight: 500 !important;
        }

        .font-semibold {
            font-weight: 600 !important;
        }

        .font-bold {
            font-weight: 700 !important;
        }

        .opacity-50 {
            opacity: 0.5 !important;
        }

        .cursor-pointer {
            cursor: pointer !important;
        }

        .overflow-hidden {
            overflow: hidden !important;
        }

        .transition-colors {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke !important;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1) !important;
            transition-duration: 150ms !important;
        }

        .duration-300 {
            transition-duration: 300ms !important;
        }

        .duration-400 {
            transition-duration: 400ms !important;
        }

        .duration-500 {
            transition-duration: 500ms !important;
        }

        .duration-600 {
            transition-duration: 600ms !important;
        }

        .duration-800 {
            transition-duration: 800ms !important;
        }

        .ease-out {
            transition-timing-function: cubic-bezier(0, 0, 0.2, 1) !important;
        }

        .ease-in-out {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .rounded-xl {
            border-radius: 0.75rem !important;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        .shadow {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.075) !important;
        }

        .shadow-lg {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .text-red-500 {
            color: #ef4444 !important;
        }

        .text-green-600 {
            color: #16a34a !important;
        }

        .bg-green-50 {
            background-color: #f0fdf4 !important;
        }

        .bg-green-600 {
            background-color: #16a34a !important;
        }

        .hover\:bg-green-700:hover {
            background-color: #15803d !important;
        }

        .bg-blue-600 {
            background-color: #2563eb !important;
        }

        .hover\:bg-blue-700:hover {
            background-color: #1d4ed8 !important;
        }

        .bg-gray-50 {
            background-color: #f9fafb !important;
        }

        .hover\:bg-gray-50:hover {
            background-color: #f9fafb !important;
        }

        .border-gray-300 {
            border-color: #d1d5db !important;
        }

        .text-gray-700 {
            color: #374151 !important;
        }

        .text-gray-900 {
            color: #111827 !important;
        }

        .text-gray-600 {
            color: #4b5563 !important;
        }

        .text-gray-500 {
            color: #6b7280 !important;
        }

        .text-blue-600 {
            color: #2563eb !important;
        }

        .text-blue-900 {
            color: #1e3a8a !important;
        }

        .text-blue-700 {
            color: #1d4ed8 !important;
        }

        .text-yellow-900 {
            color: #78350f !important;
        }

        .text-yellow-700 {
            color: #a16207 !important;
        }

        .text-red-600 {
            color: #dc2626 !important;
        }

        .bg-blue-100 {
            background-color: #dbeafe !important;
        }

        .bg-green-100 {
            background-color: #d1fae5 !important;
        }

        .bg-purple-100 {
            background-color: #e9d5ff !important;
        }

        .bg-red-100 {
            background-color: #fee2e2 !important;
        }

        .bg-yellow-100 {
            background-color: #fef3c7 !important;
        }

        .bg-gray-100 {
            background-color: #f3f4f6 !important;
        }

        .bg-blue-50 {
            background-color: #eff6ff !important;
        }

        .bg-yellow-50 {
            background-color: #fffbeb !important;
        }

        .border-blue-200 {
            border-color: #bfdbfe !important;
        }

        .border-yellow-200 {
            border-color: #fde68a !important;
        }

        .focus\:ring-blue-500:focus {
            --tw-ring-color: #3b82f6 !important;
        }

        .focus\:border-transparent:focus {
            border-color: transparent !important;
        }

        .focus\:ring-blue-500:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5) !important;
        }

        .focus\:ring-blue-500:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color) !important;
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(3px + var(--tw-ring-offset-width)) var(--tw-ring-color) !important;
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000) !important;
        }

        .grid {
            display: grid !important;
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        .grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }

        .grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }

        .gap-4 {
            gap: 1rem !important;
        }

        .gap-6 {
            gap: 1.5rem !important;
        }

        .space-y-1> :not([hidden])~ :not([hidden]) {
            margin-top: 0.25rem !important;
        }

        .space-y-2> :not([hidden])~ :not([hidden]) {
            margin-top: 0.5rem !important;
        }

        .space-y-4> :not([hidden])~ :not([hidden]) {
            margin-top: 1rem !important;
        }

        .space-y-6> :not([hidden])~ :not([hidden]) {
            margin-top: 1.5rem !important;
        }

        .space-y-8> :not([hidden])~ :not([hidden]) {
            margin-top: 2rem !important;
        }

        .space-x-3> :not([hidden])~ :not([hidden]) {
            margin-left: 0.75rem !important;
        }

        .space-x-4> :not([hidden])~ :not([hidden]) {
            margin-left: 1rem !important;
        }

        .flex {
            display: flex !important;
        }

        .items-center {
            align-items: center !important;
        }

        .items-start {
            align-items: flex-start !important;
        }

        .justify-between {
            justify-content: space-between !important;
        }

        .justify-center {
            justify-content: center !important;
        }

        .text-center {
            text-align: center !important;
        }

        .block {
            display: block !important;
        }

        .hidden {
            display: none !important;
        }

        .relative {
            position: relative !important;
        }

        .absolute {
            position: absolute !important;
        }

        .w-full {
            width: 100% !important;
        }

        .w-10 {
            width: 2.5rem !important;
        }

        .w-16 {
            width: 4rem !important;
        }

        .w-5 {
            width: 1.25rem !important;
        }

        .w-8 {
            width: 2rem !important;
        }

        .w-12 {
            width: 3rem !important;
        }

        .w-3 {
            width: 0.75rem !important;
        }

        .h-10 {
            height: 2.5rem !important;
        }

        .h-16 {
            height: 4rem !important;
        }

        .h-5 {
            height: 1.25rem !important;
        }

        .h-8 {
            height: 2rem !important;
        }

        .h-12 {
            height: 3rem !important;
        }

        .h-3 {
            height: 0.75rem !important;
        }

        .h-4 {
            height: 1rem !important;
        }

        .h-32 {
            height: 8rem !important;
        }

        .h-28 {
            height: 7rem !important;
        }

        .min-h-screen {
            min-height: 100vh !important;
        }

        .p-4 {
            padding: 1rem !important;
        }

        .p-6 {
            padding: 1.5rem !important;
        }

        .p-8 {
            padding: 2rem !important;
        }

        .px-4 {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        .px-6 {
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }

        .px-8 {
            padding-left: 2rem !important;
            padding-right: 2rem !important;
        }

        .py-2 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        .py-3 {
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
        }

        .py-8 {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }

        .py-1 {
            padding-top: 0.25rem !important;
            padding-bottom: 0.25rem !important;
        }

        .py-6 {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }

        .pt-8 {
            padding-top: 2rem !important;
        }

        .pb-8 {
            padding-bottom: 2rem !important;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }

        .mb-4 {
            margin-bottom: 1rem !important;
        }

        .mb-6 {
            margin-bottom: 1.5rem !important;
        }

        .mt-1 {
            margin-top: 0.25rem !important;
        }

        .mt-4 {
            margin-top: 1rem !important;
        }

        .mt-8 {
            margin-top: 2rem !important;
        }

        .mt-16 {
            margin-top: 4rem !important;
        }

        .ml-1 {
            margin-left: 0.25rem !important;
        }

        .ml-2 {
            margin-left: 0.5rem !important;
        }

        .ml-4 {
            margin-left: 1rem !important;
        }

        .mr-2 {
            margin-right: 0.5rem !important;
        }

        .mr-4 {
            margin-right: 1rem !important;
        }

        .mx-auto {
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .max-w-4xl {
            max-width: 56rem !important;
        }

        .max-w-7xl {
            max-width: 80rem !important;
        }

        .rounded-lg {
            border-radius: 0.5rem !important;
        }

        .rounded-full {
            border-radius: 9999px !important;
        }

        .border {
            border-width: 1px !important;
        }

        .border-2 {
            border-width: 2px !important;
        }

        .border-gray-200 {
            border-color: #e5e7eb !important;
        }

        .border-gray-300 {
            border-color: #d1d5db !important;
        }

        .border-blue-200 {
            border-color: #bfdbfe !important;
        }

        .border-yellow-200 {
            border-color: #fde68a !important;
        }

        .border-transparent {
            border-color: transparent !important;
        }

        .border-b {
            border-bottom-width: 1px !important;
        }

        .border-t {
            border-top-width: 1px !important;
        }

        .bg-gray-50 {
            background-color: #f9fafb !important;
        }

        .text-sm {
            font-size: 0.875rem !important;
            line-height: 1.25rem !important;
        }

        .text-xs {
            font-size: 0.75rem !important;
            line-height: 1rem !important;
        }

        .text-lg {
            font-size: 1.125rem !important;
            line-height: 1.75rem !important;
        }

        .text-xl {
            font-size: 1.25rem !important;
            line-height: 1.75rem !important;
        }

        .text-3xl {
            font-size: 1.875rem !important;
            line-height: 2.25rem !important;
        }

        .font-medium {
            font-weight: 500 !important;
        }

        .font-semibold {
            font-weight: 600 !important;
        }

        .font-bold {
            font-weight: 700 !important;
        }

        .opacity-50 {
            opacity: 0.5 !important;
        }

        .cursor-pointer {
            cursor: pointer !important;
        }

        .overflow-hidden {
            overflow: hidden !important;
        }

        .transition-colors {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke !important;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1) !important;
            transition-duration: 150ms !important;
        }

        .duration-300 {
            transition-duration: 300ms !important;
        }

        .duration-400 {
            transition-duration: 400ms !important;
        }

        .duration-500 {
            transition-duration: 500ms !important;
        }

        .duration-600 {
            transition-duration: 600ms !important;
        }

        .duration-800 {
            transition-duration: 800ms !important;
        }

        .ease-out {
            transition-timing-function: cubic-bezier(0, 0, 0.2, 1) !important;
        }

        .ease-in-out {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            }

            .md\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            }

            .md\:grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            }
        }

        @media (min-width: 1024px) {
            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            }

            .lg\:grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
            }
        }

        .success-style {
            transition: all 0.2s ease-in-out;
        }

        .success-style:hover {
            background-color: #ffffff !important;
            color: #11ff00bd !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: 0.2s ease;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Error Messages -->
    <?php if (!empty($errors)): ?>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Perbaiki kesalahan berikut:</h4>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success_message'])): ?>
        <!-- Pesan Sukses -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-3"></i>
                    <div>
                        <?php
                        echo $_SESSION['success_message'];
                        unset($_SESSION['success_message']);
                        ?>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="bg-white border-bottom border-gray-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-header">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Kirim Laporan Baru</h1>
            <p class="text-gray-600">Lengkapi formulir di bawah ini untuk melaporkan masalah di kampus. Semua informasi akan membantu kami menyelesaikan masalah dengan lebih cepat.</p>
        </div>
    </div>

    <!-- Form Utama -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form id="reportForm" method="POST" enctype="multipart/form-data" class="space-y-8">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <!-- Bagian 1: Detail Laporan -->
            <div class="bg-white rounded-xl shadow-sm p-8 form-section animate-section" id="section-details">
                <div class="d-flex align-items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg d-flex align-items-center justify-content-center number-badge">
                        <span class="text-blue-600 font-bold text-lg">1</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Detail Laporan</h2>
                        <p class="text-sm text-gray-600">Berikan informasi detail tentang masalah yang Anda laporkan</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="reportTitle" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Laporan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="reportTitle" name="title" required
                            class="form-control"
                            placeholder="Judul singkat dan deskriptif untuk laporan Anda">
                        <p class="text-xs text-gray-500 mt-1">Minimal 5 karakter</p>
                    </div>

                    <div>
                        <label for="reportDescription" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Detail <span class="text-red-500">*</span>
                        </label>
                        <textarea id="reportDescription" name="description" rows="6" required
                            class="form-control"
                            placeholder="Berikan detail sebanyak mungkin tentang masalah..."></textarea>
                        <p class="text-xs text-gray-500 mt-1">Jelaskan masalahnya, kapan Anda mengetahuinya, dan detail relevan lainnya (minimal 20 karakter)</p>
                    </div>
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">Tingkat Prioritas</label>
                        <select id="priority" name="priority" class="form-select">
                            <option value="rendah">Rendah - Masalah kecil, bisa menunggu</option>
                            <option value="sedang" selected>Sedang - Penting tapi tidak mendesak</option>
                            <option value="tinggi">Tinggi - Mendesak, perlu perhatian segera</option>
                            <option value="kritis">Kritis - Masalah keselamatan atau keamanan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="section-divider"></div>

            <!-- Bagian 2: Lokasi -->
            <div class="bg-white rounded-xl shadow-sm p-8 form-section animate-section" id="section-location">
                <div class="d-flex align-items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg d-flex align-items-center justify-content-center number-badge">
                        <span class="text-blue-600 font-bold text-lg">2</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Informasi Lokasi</h2>
                        <p class="text-sm text-gray-600">Bantu kami menemukan masalah dengan memberikan detail lokasi</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="detailedLocation" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Lokasi Detail
                        </label>
                        <textarea id="detailedLocation" name="detailedLocation" rows="4"
                            class="form-control"
                            placeholder="Contoh: Lantai 2 Gedung Teknik, ruangan 205, dekat tangga darurat sebelah kiri..."></textarea>
                    </div>

                    <div class="info-box bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="d-flex align-items-start space-x-3">
                            <div class="w-5 h-5 bg-blue-100 rounded-full d-flex align-items-center justify-content-center mt-1">
                                <i class="fas fa-map-marker-alt text-blue-600 text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-blue-900">Tips Lokasi</h4>
                                <p class="text-sm text-blue-700 mt-1">Jelaskan selengkap mungkin. Sertakan landmark, ruangan terdekat, atau detail lain yang akan membantu tim kami menemukan masalah dengan cepat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-divider"></div>

            <!-- Bagian 3: Kategori -->
            <div class="bg-white rounded-xl shadow-sm p-8 form-section animate-section" id="section-category">
                <div class="d-flex align-items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg d-flex align-items-center justify-content-center number-badge">
                        <span class="text-blue-600 font-bold text-lg">3</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Pilih Kategori Laporan</h2>
                        <p class="text-sm text-gray-600">Pilih kategori yang paling sesuai dengan laporan Anda</p>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Infrastruktur -->
                    <div class="col-md-6 col-lg-4">
                        <label class="category-card d-block">
                            <input type="radio" name="category" value="infrastruktur" class="d-none" required>
                            <div class="category-content border-2 border-gray-200 rounded-lg p-6 text-center">
                                <div class="category-icon w-16 h-16 bg-blue-100 rounded-lg d-flex align-items-center justify-content-center mx-auto mb-4">
                                    <i class="fas fa-building text-blue-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">Infrastruktur</h3>
                                <p class="text-sm text-gray-600">Bangunan, jalan, trotoar, utilitas</p>
                            </div>
                        </label>
                    </div>

                    <!-- Fasilitas -->
                    <div class="col-md-6 col-lg-4">
                        <label class="category-card d-block">
                            <input type="radio" name="category" value="fasilitas" class="d-none" required>
                            <div class="category-content border-2 border-gray-200 rounded-lg p-6 text-center">
                                <div class="category-icon w-16 h-16 bg-green-100 rounded-lg d-flex align-items-center justify-content-center mx-auto mb-4">
                                    <i class="fas fa-lightbulb text-green-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">Fasilitas</h3>
                                <p class="text-sm text-gray-600">AC, pencahayaan, pipa, lift</p>
                            </div>
                        </label>
                    </div>

                    <!-- Akademik -->
                    <div class="col-md-6 col-lg-4">
                        <label class="category-card d-block">
                            <input type="radio" name="category" value="akademik" class="d-none" required>
                            <div class="category-content border-2 border-gray-200 rounded-lg p-6 text-center">
                                <div class="category-icon w-16 h-16 bg-purple-100 rounded-lg d-flex align-items-center justify-content-center mx-auto mb-4">
                                    <i class="fas fa-book text-purple-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">Akademik</h3>
                                <p class="text-sm text-gray-600">Peralatan kelas, teknologi, lab</p>
                            </div>
                        </label>
                    </div>

                    <!-- Keamanan -->
                    <div class="col-md-6 col-lg-4">
                        <label class="category-card d-block">
                            <input type="radio" name="category" value="keamanan" class="d-none" required>
                            <div class="category-content border-2 border-gray-200 rounded-lg p-6 text-center">
                                <div class="category-icon w-16 h-16 bg-red-100 rounded-lg d-flex align-items-center justify-content-center mx-auto mb-4">
                                    <i class="fas fa-shield-alt text-red-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">Keamanan</h3>
                                <p class="text-sm text-gray-600">CCTV, kontrol akses, darurat</p>
                            </div>
                        </label>
                    </div>

                    <!-- Pemeliharaan -->
                    <div class="col-md-6 col-lg-4">
                        <label class="category-card d-block">
                            <input type="radio" name="category" value="pemeliharaan" class="d-none" required>
                            <div class="category-content border-2 border-gray-200 rounded-lg p-6 text-center">
                                <div class="category-icon w-16 h-16 bg-yellow-100 rounded-lg d-flex align-items-center justify-content-center mx-auto mb-4">
                                    <i class="fas fa-tools text-yellow-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">Pemeliharaan</h3>
                                <p class="text-sm text-gray-600">Lansekap, kebersihan, perawatan umum</p>
                            </div>
                        </label>
                    </div>
                    <!-- Lainnya -->
                    <div class="col-md-6 col-lg-4">
                        <label class="category-card d-block">
                            <input type="radio" name="category" value="lainnya" class="d-none" required>
                            <div class="category-content border-2 border-gray-200 rounded-lg p-6 text-center">
                                <div class="category-icon w-16 h-16 bg-gray-100 rounded-lg d-flex align-items-center justify-content-center mx-auto mb-4">
                                    <i class="fas fa-question-circle text-gray-600 text-2xl"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900 mb-2">Lainnya</h3>
                                <p class="text-sm text-gray-600">Masalah yang tidak tercakup di atas</p>
                            </div>
                        </label>
                    </div>
                </div>
                <div id="categoryError" class="text-danger text-sm mt-4 d-none">Silakan pilih kategori untuk melanjutkan</div>
            </div>
            <div class="section-divider"></div>
            <!-- Bagian 4: Upload Foto -->
            <div class="bg-white rounded-xl shadow-sm p-8 form-section animate-section" id="section-photos">
                <div class="d-flex align-items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg d-flex align-items-center justify-content-center number-badge">
                        <span class="text-blue-600 font-bold text-lg">4</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Tambahkan Foto</h2>
                        <p class="text-sm text-gray-600">Upload foto yang membantu mengilustrasikan masalah</p>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="file-drop-zone rounded-lg p-8 text-center" id="fileDropZone">
                        <div class="w-12 h-12 bg-blue-100 rounded-full d-flex align-items-center justify-content-center mx-auto mb-4">
                            <i class="fas fa-cloud-upload-alt text-blue-600 text-2xl"></i>
                        </div>
                        <p class="text-lg font-medium text-gray-700 mb-2">Letakkan gambar di sini atau klik untuk memilih</p>
                        <p class="text-sm text-gray-500 mb-4">Mendukung JPG, PNG, GIF hingga 10MB per file</p>
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click()">
                            Pilih File
                        </button>
                        <input type="file" id="fileInput" name="photos[]" multiple accept="image/*" class="d-none">
                    </div>

                    <div id="imagePreviewContainer" class="row g-3 d-none">
                        <!-- Pratinjau gambar akan masuk ke bawah -->
                    </div>


                    <div class="info-box bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="d-flex align-items-start space-x-3">
                            <div class="w-5 h-5 bg-yellow-100 rounded-full d-flex align-items-center justify-content-center mt-1">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-xs"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-yellow-900">Panduan Foto</h4>
                                <ul class="text-sm text-yellow-700 mt-1 space-y-1">
                                    <li>• Ambil foto yang jelas dan cukup cahaya</li>
                                    <li>• Sertakan beberapa sudut jika membantu</li>
                                    <li>• Hindari menyertakan orang dalam foto untuk privasi</li>
                                    <li>• Tambahkan objek referensi untuk skala jika diperlukan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-divider"></div>

            <!-- Bagian 5: Pengaturan & Kirim -->
            <div class="bg-white rounded-xl shadow-sm p-8 form-section animate-section" id="section-submit">
                <div class="d-flex align-items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg d-flex align-items-center justify-content-center number-badge">
                        <span class="text-blue-600 font-bold text-lg">5</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Pengaturan & Kirim</h2>
                        <p class="text-sm text-gray-600">Tinjau pengaturan dan kirim laporan Anda</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Pengaturan Privasi -->
                    <div class="border border-gray-200 rounded-lg p-6">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">Buat Laporan Pribadi</h3>
                                <p class="text-sm text-gray-600 mt-1">Hanya personel yang berwenang yang dapat melihat laporan ini</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="isPrivate" name="isPrivate">
                            </div>
                        </div>
                    </div>

                    <!-- Syarat dan Ketentuan -->
                    <div class="space-y-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" name="agreeTerms" required>
                            <label class="form-check-label" for="agreeTerms">
                                Saya mengonfirmasi bahwa informasi yang diberikan dalam laporan ini akurat sesuai pengetahuan saya.
                                Saya memahami bahwa pelaporan palsu dapat mengakibatkan tindakan disipliner. <span class="text-danger">*</span>
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="agreeContact" name="agreeContact">
                            <label class="form-check-label" for="agreeContact">
                                Saya setuju untuk dihubungi oleh staf pemeliharaan jika informasi tambahan diperlukan untuk menyelesaikan masalah ini.
                            </label>
                        </div>
                    </div>

                    <!-- Ringkasan -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Ringkasan Laporan</h3>
                        <div id="reportSummary" class="space-y-2 text-sm text-gray-600">
                            <p>Lengkapi formulir di atas untuk melihat ringkasan laporan Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="d-flex align-items-center justify-content-between pt-8 pb-8">
                <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="btn btn-outline-secondary">
                    Kembali ke Atas
                </button>

                <div class="d-flex align-items-center space-x-4">
                    <button type="button" id="saveDraftButton" class="btn btn-outline-secondary">
                        Simpan Draft
                    </button>
                    <button type="submit" id="submitButton" class="btn btn-success">
                        Kirim Laporan
                    </button>
                </div>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('shadow');
            } else {
                document.querySelector('.navbar').classList.remove('shadow');
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (!empty($form_data)): ?>
                // Pre-fill form fields
                const formData = <?php echo json_encode($form_data); ?>;

                if (formData.title) {
                    document.getElementById('reportTitle').value = formData.title;
                }

                if (formData.description) {
                    document.getElementById('reportDescription').value = formData.description;
                }

                if (formData.detailedLocation) {
                    document.getElementById('detailedLocation').value = formData.detailedLocation;
                }

                if (formData.category) {
                    const radio = document.querySelector(`input[name="category"][value="${formData.category}"]`);
                    if (radio) radio.checked = true;
                }

                if (formData.isPrivate) {
                    document.getElementById('isPrivate').checked = true;
                }

                if (formData.agreeContact) {
                    document.getElementById('agreeContact').checked = true;
                }

                if (formData.agreeTerms) {
                    document.getElementById('agreeTerms').checked = true;
                }

                updateSummary();
            <?php endif; ?>
        });
        // State Management
        let selectedCategory = '';
        let uploadedFiles = [];

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            setupCategorySelection();
            setupFileUpload();
            setupFormValidation();
            loadDraftData();
            updateSummary();
            initScrollAnimations();

            // Update summary on input change
            document.getElementById('reportForm').addEventListener('input', updateSummary);
            document.getElementById('reportForm').addEventListener('change', updateSummary);
        });

        // Scroll Animations
        function initScrollAnimations() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.animate-section').forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                observer.observe(section);
            });
        }

        // Category Selection with Radio Buttons
        function setupCategorySelection() {
            const categoryRadios = document.querySelectorAll('input[name="category"]');

            categoryRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        selectedCategory = this.value;
                        document.getElementById('categoryError').classList.add('d-none');
                        updateSummary();

                        // Add selection animation
                        const content = this.nextElementSibling;
                        anime({
                            targets: content,
                            scale: [0.95, 1],
                            duration: 300,
                            easing: 'easeOutElastic(1, .6)'
                        });
                    }
                });
            });
        }

        // File Upload
        function setupFileUpload() {
            const dropZone = document.getElementById('fileDropZone');
            const fileInput = document.getElementById('fileInput');

            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                const files = Array.from(e.dataTransfer.files);
                handleFileUpload(files);
            });

            fileInput.addEventListener('change', function() {
                const files = Array.from(this.files);
                handleFileUpload(files);
            });
        }

        function handleFileUpload(files) {
            const imageContainer = document.getElementById('imagePreviewContainer');
            const validFiles = files.filter(file => file.type.startsWith('image/') && file.size <= 10 * 1024 * 1024);

            if (validFiles.length === 0) {
                alert('Silakan pilih file gambar yang valid (JPG, PNG, GIF) di bawah 10MB.');
                return;
            }

            imageContainer.classList.remove('d-none');

            validFiles.forEach((file, index) => {
                uploadedFiles.push(file);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-md-4 col-sm-6';

                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'image-preview w-full h-100 rounded-lg border border-gray-200';
                    previewDiv.dataset.index = uploadedFiles.length - validFiles.length + index;
                    previewDiv.innerHTML = `
                        <img src="${e.target.result}" alt="Pratinjau" class="w-100 h-auto object-fit-cover rounded-lg">
                        <button type="button" class="remove-image" onclick="removeImage(${uploadedFiles.length - validFiles.length + index})">
                            <i class="fas fa-times"></i>
                        </button>
                    `;

                    colDiv.appendChild(previewDiv);
                    imageContainer.appendChild(colDiv);

                    // Animate preview appearance
                    anime({
                        targets: previewDiv,
                        scale: [0, 1],
                        opacity: [0, 1],
                        duration: 500,
                        easing: 'easeOutElastic(1, .8)'
                    });

                    updateSummary();
                };
                reader.readAsDataURL(file);
            });
        }

        function removeImage(index) {
            const imageContainer = document.getElementById('imagePreviewContainer');
            const previewDiv = imageContainer.querySelector(`[data-index="${index}"]`);

            if (previewDiv) {
                // Animate removal
                anime({
                    targets: previewDiv,
                    scale: 0,
                    opacity: 0,
                    duration: 300,
                    easing: 'easeInBack',
                    complete: function() {
                        // Remove the parent column div
                        const colDiv = previewDiv.parentElement;
                        colDiv.remove();

                        uploadedFiles.splice(index, 1);

                        // Update indexes
                        const previews = imageContainer.querySelectorAll('.image-preview');
                        previews.forEach((preview, i) => {
                            preview.dataset.index = i;
                            const button = preview.querySelector('.remove-image');
                            button.setAttribute('onclick', `removeImage(${i})`);
                        });

                        if (uploadedFiles.length === 0) {
                            imageContainer.classList.add('d-none');
                        }

                        updateSummary();
                    }
                });
            }
        }

        // Form Validation
        function setupFormValidation() {
            const form = document.getElementById('reportForm');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (validateForm()) {
                    const submitButton = document.getElementById('submitButton');
                    const originalText = submitButton.textContent;

                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengirim...';
                    submitButton.classList.add('opacity-50');

                    // Animate button
                    anime({
                        targets: submitButton,
                        scale: [1, 0.95, 1],
                        duration: 500
                    });

                    // Submit form
                    setTimeout(() => {
                        form.submit();
                    }, 1000);
                }
            });
        }

        function validateForm() {
            // Validate category
            const categoryRadio = document.querySelector('input[name="category"]:checked');
            if (!categoryRadio) {
                alert('Silakan pilih kategori untuk laporan Anda.');
                document.getElementById('categoryError').classList.remove('d-none');

                // Animate error
                anime({
                    targets: '#categoryError',
                    translateX: [-10, 10, -10, 10, 0],
                    duration: 400
                });

                document.getElementById('section-category').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                return false;
            }

            // Validate title
            const title = document.getElementById('reportTitle').value.trim();
            if (!title || title.length < 5) {
                alert('Judul laporan harus minimal 5 karakter.');
                document.getElementById('reportTitle').focus();

                // Animate input
                anime({
                    targets: '#reportTitle',
                    translateX: [-10, 10, -10, 10, 0],
                    duration: 400
                });

                document.getElementById('section-details').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                return false;
            }

            // Validate description
            const description = document.getElementById('reportDescription').value.trim();
            if (!description || description.length < 20) {
                alert('Deskripsi laporan harus minimal 20 karakter.');
                document.getElementById('reportDescription').focus();

                // Animate textarea
                anime({
                    targets: '#reportDescription',
                    translateX: [-10, 10, -10, 10, 0],
                    duration: 400
                });

                document.getElementById('section-details').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                return false;
            }

            // Validate terms
            const agreeTerms = document.getElementById('agreeTerms').checked;
            if (!agreeTerms) {
                alert('Anda harus menyetujui syarat dan ketentuan untuk mengirim laporan Anda.');
                document.getElementById('section-submit').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                return false;
            }

            return true;
        }

        // Update Summary
        function updateSummary() {
            const summaryContainer = document.getElementById('reportSummary');
            const title = document.getElementById('reportTitle').value.trim();
            const description = document.getElementById('reportDescription').value.trim();
            const location = document.getElementById('detailedLocation').value.trim();
            const isPrivate = document.getElementById('isPrivate').checked;
            const categoryRadio = document.querySelector('input[name="category"]:checked');

            const categoryNames = {
                'infrastruktur': 'Infrastruktur',
                'fasilitas': 'Fasilitas',
                'akademik': 'Akademik',
                'keamanan': 'Keamanan',
                'pemeliharaan': 'Pemeliharaan',
                'lainnya': 'Lainnya'
            };

            let summaryHTML = '<div class="space-y-2">';

            if (categoryRadio) {
                summaryHTML += `
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Kategori:</span>
                        <span class="font-medium text-gray-900">${categoryNames[categoryRadio.value]}</span>
                    </div>
                `;
            }

            if (title) {
                summaryHTML += `
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Judul:</span>
                        <span class="font-medium text-gray-900">${title.substring(0, 50)}${title.length > 50 ? '...' : ''}</span>
                    </div>
                `;
            }

            if (description) {
                summaryHTML += `
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Deskripsi:</span>
                        <span class="font-medium text-gray-900">${description.length} karakter</span>
                    </div>
                `;
            }

            if (location) {
                summaryHTML += `
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">Lokasi:</span>
                        <span class="font-medium text-gray-900">✓ Diberikan</span>
                    </div>
                `;
            }

            summaryHTML += `
                <div class="d-flex justify-content-between">
                    <span class="text-gray-600">Foto:</span>
                    <span class="font-medium text-gray-900">${uploadedFiles.length} gambar</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-gray-600">Privasi:</span>
                    <span class="font-medium text-gray-900">${isPrivate ? 'Pribadi' : 'Publik'}</span>
                </div>
            `;

            summaryHTML += '</div>';

            if (!categoryRadio && !title && !description) {
                summaryHTML = '<p class="text-gray-600">Lengkapi formulir di atas untuk melihat ringkasan laporan Anda</p>';
            }

            summaryContainer.innerHTML = summaryHTML;

            // Animate summary update
            anime({
                targets: '#reportSummary',
                opacity: [0.5, 1],
                duration: 300
            });
        }

        // Save Draft
        document.getElementById('saveDraftButton').addEventListener('click', function() {
            saveDraft();
        });

        function saveDraft() {
            const categoryRadio = document.querySelector('input[name="category"]:checked');
            const formData = {
                category: categoryRadio ? categoryRadio.value : '',
                title: document.getElementById('reportTitle').value,
                description: document.getElementById('reportDescription').value,
                location: document.getElementById('detailedLocation').value,
                isPrivate: document.getElementById('isPrivate').checked,
                agreeContact: document.getElementById('agreeContact').checked,
                timestamp: new Date().toISOString()
            };

            localStorage.setItem('reportDraft', JSON.stringify(formData));

            const button = document.getElementById('saveDraftButton');
            const originalText = button.textContent;
            button.textContent = '✓ Draft Tersimpan!';
            button.classList.add('success-style');

            // Animate success
            anime({
                targets: button,
                scale: [1, 1.1, 1],
                duration: 500,
                easing: 'easeOutElastic(1, .6)'
            });

            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('success-style');
            }, 2000);
        }

        function loadDraftData() {
            const draftData = localStorage.getItem('reportDraft');
            if (draftData) {
                const shouldLoad = confirm('Draft laporan ditemukan. Apakah Anda ingin melanjutkan dari draft?');

                if (shouldLoad) {
                    try {
                        const data = JSON.parse(draftData);

                        if (data.category) {
                            const categoryRadio = document.querySelector(`input[name="category"][value="${data.category}"]`);
                            if (categoryRadio) {
                                categoryRadio.checked = true;
                                selectedCategory = data.category;
                            }
                        }

                        if (data.title) document.getElementById('reportTitle').value = data.title;
                        if (data.description) document.getElementById('reportDescription').value = data.description;
                        if (data.location) document.getElementById('detailedLocation').value = data.location;
                        if (data.isPrivate) document.getElementById('isPrivate').checked = data.isPrivate;
                        if (data.agreeContact) document.getElementById('agreeContact').checked = data.agreeContact;

                        updateSummary();

                        // Animate loaded data
                        anime({
                            targets: '.form-section',
                            opacity: [0.5, 1],
                            scale: [0.98, 1],
                            duration: 800,
                            delay: anime.stagger(100)
                        });
                    } catch (e) {
                        console.error('Error memuat data draft:', e);
                    }
                } else {
                    localStorage.removeItem('reportDraft');
                }
            }
        }

        // Auto-save
        let autoSaveTimeout;
        document.getElementById('reportForm').addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                const hasData = document.getElementById('reportTitle').value.trim() ||
                    document.getElementById('reportDescription').value.trim() ||
                    document.querySelector('input[name="category"]:checked');

                if (hasData) {
                    saveDraft();
                }
            }, 30000); // Auto-save every 30 seconds
        });

        // Warning before leaving
        window.addEventListener('beforeunload', function(e) {
            const hasData = document.getElementById('reportTitle').value.trim() ||
                document.getElementById('reportDescription').value.trim() ||
                document.querySelector('input[name="category"]:checked');

            const agreeTerms = document.getElementById('agreeTerms').checked;

            if (hasData && !agreeTerms) {
                e.preventDefault();
                e.returnValue = 'Anda memiliki perubahan yang belum disimpan. Apakah Anda yakin ingin meninggalkan halaman?';
                return e.returnValue;
            }
        });

        // Smooth scroll animation for sections
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add parallax effect on scroll
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelectorAll('.form-section');

            parallax.forEach((element, index) => {
                const speed = 0.05 * (index + 1);
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });
    </script>
</body>

</html>
<?= $this->endSection() ?>