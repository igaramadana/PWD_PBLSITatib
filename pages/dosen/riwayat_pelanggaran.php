  <!-- Preloader -->
  <div id="preloader">
      <div class="lds-ripple">
          <div></div>
          <div></div>
      </div>
  </div>

  <!-- Main wrapper -->
  <div id="main-wrapper">

      <!-- Header -->
      <?php include("header.php"); ?>

      <!-- Sidebar -->
      <?php include("sidebar.php"); ?>

      <!-- Content body -->
      <div class="content-body">
          <div class="container-fluid">
              <!-- Breadcrumb -->
              <div class="row page-titles">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item active"><a href="javascript:void(0)">Riwayat Pelanggaran</a></li>
                  </ol>
              </div>

              <!-- Rekap Pelanggaran Section -->
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header d-flex justify-content-between align-items-center">
                              <h4 class="card-title">RiwayatPelanggaran Mahasiswa</h4>
                          </div>
                          <div class="card-body">

                              <!-- Search and Sort Buttons -->
                              <div class="row mb-3">
                                  <!-- Search Form -->
                                  <div class="col-md-6">
                                      <form action="riwayat_pelanggaran.php" method="get" class="d-flex">
                                          <div class="input-group">
                                              <!-- Input pencarian berdasarkan keyword -->
                                              <input type="text" class="form-control" name="search"
                                                  value="<?php echo htmlspecialchars($search ?? ''); ?>"
                                                  placeholder="Cari disini...">
                                              <!-- Tombol submit pencarian -->
                                              <button type="submit" class="btn btn-primary">
                                                  <i class="fa fa-search"></i>
                                              </button>
                                          </div>
                                      </form>
                                  </div>

                                  <!-- Sort by  Nama -->
                                  <div class="col-md-6 text-end">
                                      <form action="rekap_pelanggaran.php" method="get">
                                          <div class="d-flex justify-content-end">
                                              <div class="input-group w-50">
                                                  <!-- Dropdown untuk sort -->
                                                  <select name="sort" class="form-control" onchange="this.form.submit()">
                                                      <option value="">Sort by</option>
                                                      <option value="nama_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nama_asc') ? 'selected' : ''; ?>>Nama: A-Z</option>
                                                      <option value="nama_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nama_desc') ? 'selected' : ''; ?>>Nama: Z-A</option>
                                                  </select>
                                              </div>
                                          </div>
                                      </form>
                                  </div>

                                  <!-- Table -->
                                  <div class="table-responsive">
                                      <table class="table table-bordered text-center">
                                          <thead class="bg-primary text-white">
                                              <tr>
                                                  <th class="text-center">No.</th>
                                                  <th class="text-center">NIM</th>
                                                  <th class="text-center">Nama Mahasiswa</th>
                                                  <th class="text-center">Prodi Mahasiswa</th>
                                                  <th class="text-center">Deskripsi Pelanggaran</th>
                                              </tr>
                                          </thead>
                                          <!-- Loop untuk menampilkan data pelanggaran -->
                                          <?php if (!empty($pelanggaranList)) : ?>
                                              <?php
                                                $no = ($startFrom ?? 0) + 1;
                                                foreach ($pelanggaranList as $pelanggaran) : ?>
                                                  <tr>
                                                      <!-- Nomor urut -->
                                                      <td class="text-center"><?php echo $no++; ?></td>
                                                      <td class="text-center"><?php echo htmlspecialchars($pelanggaran['NIM']); ?></td>
                                                      <!-- Nama mahasiswa -->
                                                      <td class="text-center"><?php echo htmlspecialchars($pelanggaran['NamaMahasiswa']); ?></td>
                                                      <!-- Prodi Mahasiswa -->
                                                      <td class="text-center"><?php echo htmlspecialchars($pelanggaran['Prodi']); ?></td>
                                                      <!-- Deskripsi pelanggaran -->
                                                      <td class="text-center"><?php echo htmlspecialchars($pelanggaran['Deskripsi']); ?></td>
                                                      <!-- Dropdown untuk mengubah status -->
                                                      <td class="text-center">
                                                          <form action="update_status.php" method="post">
                                                              <!-- Input tersembunyi untuk ID pelanggaran -->
                                                              <input type="hidden" name="pelanggaran_id" value="<?php echo $pelanggaran['PelanggaranID']; ?>">
                                                              <!-- Dropdown untuk memilih status -->
                                                              <!-- Sort by Status atau Nama -->
                                                              <div class="col-md-6 text-end">
                                                                  <form action="riwayat_pelanggaran.php" method="get">
                                                                      <div class="d-flex justify-content-end">
                                                                          <div class="input-group w-50">
                                                                              <!-- Dropdown untuk sort -->
                                                                              <select name="sort" class="form-control" onchange="this.form.submit()">
                                                                                  <option value="">Sort by</option>
                                                                                  <option value="nama_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nama_asc') ? 'selected' : ''; ?>>Nama: A-Z</option>
                                                                                  <option value="nama_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'nama_desc') ? 'selected' : ''; ?>>Nama: Z-A</option>
                                                                              </select>
                                                                          </div>
                                                                      </div>
                                                                  </form>
                                                              </div>

                                                          </form>
                                                      </td>
                                                  </tr>
                                              <?php endforeach; ?>
                                          <?php else : ?>
                                              <!-- Jika data kosong -->
                                              <tr>
                                                  <td colspan="6" class="text-center">Tidak ada data pelanggaran yang ditemukan.</td>
                                              </tr>
                                          <?php endif; ?>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Footer Scripts -->
          <?php include("footer.php"); ?>

          </body>

          </html>