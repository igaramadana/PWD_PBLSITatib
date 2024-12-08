  <?php 
  include "../../process/dosen/fungsi_tampil_profile.php";
  ?>
  
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
                      <li class="breadcrumb-item"><a href="javascript:void(0)">Pelanggaran</a></li>
                      <li class="breadcrumb-item active"><a href="javascript:void(0)">Rekap Pelanggaran</a></li>
                  </ol>
              </div>

              <!-- Rekap Pelanggaran Section -->
              <div class="row">
                  <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header d-flex justify-content-between align-items-center">
                              <h4 class="card-title">Rekap Pelanggaran Mahasiswa</h4>
                          </div>
                          <div class="card-body">

                              <!-- Search and Sort Buttons -->
                              <div class="row mb-3">
                                  <!-- Search Form -->
                                  <div class="col-md-6">
                                      <form action="rekap_pelanggaran.php" method="get" class="d-flex">
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

                                  <!-- Sort by Status -->
                                  <div class="col-md-6 text-end">
                                      <form action="rekap_pelanggaran.php" method="get">
                                          <div class="d-flex justify-content-end">
                                              <div class="input-group w-50">
                                                  <!-- Dropdown untuk sort by status -->
                                                  <select name="status" class="form-control" onchange="this.form.submit()">
                                                      <option value="">Sort by</option>
                                                      <option value="pending" <?php echo (isset($_GET['status']) && $_GET['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                      <option value="progress" <?php echo (isset($_GET['status']) && $_GET['status'] == 'progress') ? 'selected' : ''; ?>>Progress</option>
                                                      <option value="selesai" <?php echo (isset($_GET['status']) && $_GET['status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                                  </select>
                                              </div>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                              <!-- Table -->
                              <div class="table-responsive">
                                  <table class="table table-bordered text-center">
                                      <thead class="bg-primary text-white">
                                          <tr>
                                              <th class="text-center">No.</th>
                                              <th class="text-center">Foto Profil</th>
                                              <th class="text-center">NIM</th>
                                              <th class="text-center">Nama Mahasiswa</th>
                                              <th class="text-center">Deskripsi Pelanggaran</th>
                                              <th class="text-center">Status</th>
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
                                                  <!-- Foto profil mahasiswa -->
                                                  <td class="text-center">
                                                      <img src="../../assets/template/images/avatar/1.jpg"
                                                          alt="Foto Profil <?php echo htmlspecialchars($pelanggaran['NamaMahasiswa']); ?>"
                                                          class="img-fluid" width="50" height="50">
                                                  </td>
                                                  <!-- NIM mahasiswa -->
                                                  <td class="text-center"><?php echo htmlspecialchars($pelanggaran['NIM']); ?></td>
                                                  <!-- Nama mahasiswa -->
                                                  <td class="text-center"><?php echo htmlspecialchars($pelanggaran['NamaMahasiswa']); ?></td>
                                                  <!-- Deskripsi pelanggaran -->
                                                  <td class="text-center"><?php echo htmlspecialchars($pelanggaran['Deskripsi']); ?></td>
                                                  <!-- Dropdown untuk mengubah status -->
                                                  <td class="text-center">
                                                      <form action="update_status.php" method="post">
                                                          <!-- Input tersembunyi untuk ID pelanggaran -->
                                                          <input type="hidden" name="pelanggaran_id" value="<?php echo $pelanggaran['PelanggaranID']; ?>">
                                                          <!-- Dropdown untuk memilih status -->
                                                          <select name="status" class="form-control" onchange="this.form.submit()">
                                                              <option value="pending" <?php echo ($pelanggaran['Status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                              <option value="progress" <?php echo ($pelanggaran['Status'] == 'progress') ? 'selected' : ''; ?>>Progress</option>
                                                              <option value="selesai" <?php echo ($pelanggaran['Status'] == 'selesai') ? 'selected' : ''; ?>>Selesai</option>
                                                          </select>
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