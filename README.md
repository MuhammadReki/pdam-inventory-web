# 💧 PDAM Inventory

Sistem inventory barang berbasis web untuk **Perumda Air Minum Tirta Sago (PAMTIGO) Kota Payakumbuh**.

## 🛠️ Tech Stack

- Laravel 13
- PHP 8.3
- MySQL
- Bootstrap 5
- Chart.js

## ✨ Fitur

- Login multi-role (superadmin, pimpinan, staff)
- Dashboard dengan statistik
- CRUD Master Barang
- CRUD Barang Masuk
- CRUD Barang Keluar
- Notifikasi real-time
- AI Assistant (Gemini)
- Export Laporan (PDF & Excel)
- Prediksi Restock
- Multi-bahasa (ID & EN)

## 📸 Tampilan Aplikasi

![Dashboard PDAM Inventory](screenshots/Foto%201.png)

## 🚀 Cara Install

```bash
# Clone repo
git clone https://github.com/MuhammadReki/pdam-inventory-web.git
cd pdam-inventory-web

# Install dependencies
composer install
npm install

# Setup .env
cp .env.example .env
php artisan key:generate

# Setup database di .env, lalu:
php artisan migrate --seed

# Build asset
npm run build

# Jalankan
php artisan serve