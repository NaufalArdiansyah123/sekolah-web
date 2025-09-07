<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Berita Terbaru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .news-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .page-title {
            border-left: 5px solid #0d6efd;
            padding-left: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-newspaper me-2"></i>Portal Berita
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Daftar Berita Terbaru</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBeritaModal">
                <i class="fas fa-plus me-1"></i> Tambah Berita
            </button>
        </div>

        <div class="row" id="berita-list">
            <!-- Daftar berita akan ditampilkan di sini -->
        </div>
    </div>

    <!-- Modal Tambah Berita -->
    <div class="modal fade" id="tambahBeritaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Berita Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahBerita">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Berita</label>
                            <input type="text" class="form-control" id="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Politik">Politik</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Olahraga">Olahraga</option>
                                <option value="Teknologi">Teknologi</option>
                                <option value="Hiburan">Hiburan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Berita</label>
                            <textarea class="form-control" id="isi" rows="5" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="simpanBerita">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Berita -->
    <div class="modal fade" id="editBeritaModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditBerita">
                        <input type="hidden" id="editId">
                        <div class="mb-3">
                            <label for="editJudul" class="form-label">Judul Berita</label>
                            <input type="text" class="form-control" id="editJudul" required>
                        </div>
                        <div class="mb-3">
                            <label for="editKategori" class="form-label">Kategori</label>
                            <select class="form-select" id="editKategori" required>
                                <option value="Politik">Politik</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Olahraga">Olahraga</option>
                                <option value="Teknologi">Teknologi</option>
                                <option value="Hiburan">Hiburan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editTanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="editTanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="editIsi" class="form-label">Isi Berita</label>
                            <textarea class="form-control" id="editIsi" rows="5" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="updateBerita">Update</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Data contoh berita
        let beritaList = [
            {
                id: 1,
                judul: "Pertumbuhan Ekonomi Indonesia Meningkat di Tahun 2023",
                kategori: "Ekonomi",
                tanggal: "2023-10-15",
                isi: "Pertumbuhan ekonomi Indonesia menunjukkan peningkatan signifikan pada kuartal ketiga tahun 2023, didorong oleh peningkatan konsumsi domestik dan ekspor."
            },
            {
                id: 2,
                judul: "Timnas Indonesia Sukses Kalahkan Vietnam dalam Laga Persahabatan",
                kategori: "Olahraga",
                tanggal: "2023-10-12",
                isi: "Timnas Indonesia berhasil mengalahkan Vietnam dengan skor 3-1 dalam pertandingan persahabatan yang digelar di Stadion Utama Gelora Bung Karno."
            }
        ];

        // Fungsi untuk menampilkan berita
        function tampilkanBerita() {
            const beritaContainer = document.getElementById('berita-list');
            beritaContainer.innerHTML = '';

            if (beritaList.length === 0) {
                beritaContainer.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada berita. Silakan tambah berita baru.</p>
                    </div>
                `;
                return;
            }

            beritaList.forEach(berita => {
                const formattedDate = new Date(berita.tanggal).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                const beritaCard = document.createElement('div');
                beritaCard.className = 'col-md-6 col-lg-4';
                beritaCard.innerHTML = `
                    <div class="card news-card h-100">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">${berita.kategori}</span>
                            <h5 class="card-title">${berita.judul}</h5>
                            <p class="card-text text-muted small">${formattedDate}</p>
                            <p class="card-text">${berita.isi.substring(0, 100)}...</p>
                        </div>
                        <div class="card-footer bg-transparent action-buttons">
                            <button class="btn btn-sm btn-outline-primary btn-edit" data-id="${berita.id}">
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-hapus" data-id="${berita.id}">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                `;
                beritaContainer.appendChild(beritaCard);
            });

            // Tambahkan event listener untuk tombol edit dan hapus
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = parseInt(this.getAttribute('data-id'));
                    editBerita(id);
                });
            });

            document.querySelectorAll('.btn-hapus').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = parseInt(this.getAttribute('data-id'));
                    hapusBerita(id);
                });
            });
        }

        // Fungsi untuk menambah berita
        document.getElementById('simpanBerita').addEventListener('click', function() {
            const judul = document.getElementById('judul').value;
            const kategori = document.getElementById('kategori').value;
            const tanggal = document.getElementById('tanggal').value;
            const isi = document.getElementById('isi').value;

            if (!judul || !kategori || !tanggal || !isi) {
                alert('Semua field harus diisi!');
                return;
            }

            const newId = beritaList.length > 0 ? Math.max(...beritaList.map(b => b.id)) + 1 : 1;
            
            beritaList.push({
                id: newId,
                judul,
                kategori,
                tanggal,
                isi
            });

            // Tutup modal dan reset form
            const modal = bootstrap.Modal.getInstance(document.getElementById('tambahBeritaModal'));
            modal.hide();
            document.getElementById('formTambahBerita').reset();

            // Tampilkan ulang daftar berita
            tampilkanBerita();
            
            alert('Berita berhasil ditambahkan!');
        });

        // Fungsi untuk mengedit berita
        function editBerita(id) {
            const berita = beritaList.find(b => b.id === id);
            
            if (berita) {
                document.getElementById('editId').value = berita.id;
                document.getElementById('editJudul').value = berita.judul;
                document.getElementById('editKategori').value = berita.kategori;
                document.getElementById('editTanggal').value = berita.tanggal;
                document.getElementById('editIsi').value = berita.isi;
                
                const modal = new bootstrap.Modal(document.getElementById('editBeritaModal'));
                modal.show();
            }
        }

        // Fungsi untuk update berita
        document.getElementById('updateBerita').addEventListener('click', function() {
            const id = parseInt(document.getElementById('editId').value);
            const judul = document.getElementById('editJudul').value;
            const kategori = document.getElementById('editKategori').value;
            const tanggal = document.getElementById('editTanggal').value;
            const isi = document.getElementById('editIsi').value;

            if (!judul || !kategori || !tanggal || !isi) {
                alert('Semua field harus diisi!');
                return;
            }

            const index = beritaList.findIndex(b => b.id === id);
            
            if (index !== -1) {
                beritaList[index] = {
                    id,
                    judul,
                    kategori,
                    tanggal,
                    isi
                };

                // Tutup modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('editBeritaModal'));
                modal.hide();

                // Tampilkan ulang daftar berita
                tampilkanBerita();
                
                alert('Berita berhasil diupdate!');
            }
        });

        // Fungsi untuk menghapus berita
        function hapusBerita(id) {
            if (confirm('Apakah Anda yakin ingin menghapus berita ini?')) {
                beritaList = beritaList.filter(b => b.id !== id);
                tampilkanBerita();
                alert('Berita berhasil dihapus!');
            }
        }

        // Inisialisasi tampilan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            tampilkanBerita();
            
            // Set tanggal default untuk form tambah ke hari ini
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal').value = today;
        });
    </script>
</body>
</html>