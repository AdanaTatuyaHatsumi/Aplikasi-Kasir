<main id="main" class="main">

    <div class="pagetitle">
      <h1>Penjualan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item active">Penjualan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section penjualan">
    <?php echo $this->session->flashdata('pesan') ?>
      <a class="btn btn-primary mb-2" href="<?php echo base_url('penjualan/tambahPenjualan') ?>"><i class="bi bi-plus"></i>Penjualan</a>
        <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Data Penjualan</h5>

                  <!-- Table with stripped rows -->
                  <table class="table datatable">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Jumlah Terjual</th>
                        <th>Nama Kas</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; foreach($t_penjualan as $t) : ?>
                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $t->nama_produk ?></td>
                        <td><?php echo $t->jumlah ?></td>
                        <td><?php echo $t->nama_kas ?></td>
                        <td><?php echo $t->tanggal ?></td>
                        <td>
                          <a onclick="return confirm('Yakin Hapus? dengan menghapus saldo akan dikembalikan ke kas')" href="<?php echo base_url('penjualan/deletePenjualanAksi/'.$t->id) ?>" class="btn btn-danger"><i class="bi bi-trash-fill"></a></i>
                          <a href="<?php echo base_url('penjualan/editPenjualan/'.$t->id) ?>" class="btn btn-warning"><i class="bi bi-exclamation-lg"></a></i>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                  <!-- End Table with stripped rows -->

                </div>
              </div>
            </div>
        </div>
        <p>Note : Sebagai penjualan produk!</p>
    </section>

  </main><!-- End #main -->