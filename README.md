
---

# CBIS (Cloud-Based Information System) Smart Campus

Proyek ini adalah **aplikasi web dashboard CBIS (Cloud-Based Information System)** berbasis **Laravel** yang didukung dengan **Load Balancing (ALB Round Robin)**, **Redis Cache**, dan **Monitoring dengan Grafana & Prometheus**.
Selain itu, sistem ini terintegrasi dengan **Edge Computing** dan **IoT devices** (seperti RFID), yang memungkinkan pemrosesan data secara real-time di **MySQL Edge Device** serta ditampilkan langsung di **perangkat visualisasi** (misalnya TV Display).

---

## ✨ Fitur Utama

* **Web Dashboard berbasis Laravel**

  * Login & autentikasi user
  * Dashboard interaktif dengan data real-time
* **Load Balancer Round Robin (Nginx / ALB)**

  * Distribusi traffic secara merata antar instance aplikasi
  * Meningkatkan ketersediaan (High Availability)
* **Redis Cache**

  * Optimasi query database
  * Menjamin integritas dan konsistensi data
* **Monitoring & Observability**

  * **Prometheus** untuk scraping metrics
  * **Grafana** untuk visualisasi performa & kesehatan sistem
* **Edge Computing & IoT**

  * Integrasi dengan **RFID reader**
  * Pemrosesan data di **MySQL Edge Device**
  * Streaming data ke dashboard secara real-time
  * Visualisasi di perangkat display (TV, panel, dll.)


## ⚙️ Teknologi yang Digunakan

* **Backend**: Laravel 10 (PHP Framework)
* **Database**: MySQL (Cloud & Edge Device)
* **Cache**: Redis
* **Load Balancer**: Nginx (Round Robin Method)
* **Monitoring**: Prometheus + Grafana
* **IoT & Edge**: RFID Reader + Edge Computing Device
* **Containerization**: Docker & Docker Compose

---

## 🚀 Cara Menjalankan

1. Clone repository

   ```bash
   git clone -b alb https://github.com/alimusyafa-psc/projectsmartcampus.git
   cd projectsmartcampus
   ```
2. Jalankan dengan Docker Compose

   ```bash
   docker-compose up -d
   ```
3. Akses aplikasi di browser

   ```
   http://localhost:8080
   ```

---

## 📌 Catatan

* Pastikan **Docker** dan **Docker Compose** sudah terinstal.
* Gunakan **environment file (.env)** untuk konfigurasi database, cache, dan monitoring.

---

## 📜 Lisensi

Proyek ini dikembangkan untuk kebutuhan **Smart Campus CBIS** dan bersifat open source.

---

