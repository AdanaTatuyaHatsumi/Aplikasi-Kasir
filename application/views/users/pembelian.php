<main id="main" class="main">

    <div class="pagetitle">
      <h1>Pembelian</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item active">Pembelian</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section pembelian">
    <?php echo $this->session->flashdata('pesan') ?>
      <a class="btn btn-primary mb-2" href="<?php echo base_url('pembelian/tambahPembelian') ?>"><i class="bi bi-plus"></i>Pembelian</a>
        <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Data Pembelian</h5>

                  <!-- Table with stripped rows -->
                  <table class="table datatable">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Jumlah Beli</th>
                        <th>Nama Kas</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; foreach($t_pembelian as $t) : ?>
                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $t->nama_bahan ?></td>
                        <td><?php echo $t->jumlah ?></td>
                        <td><?php echo $t->nama_kas ?></td>
                        <td><?php echo $t->tanggal ?></td>
                        <td>
                          <a onclick="return confirm('Yakin Hapus? dengan menghapus saldo akan dikembalikan ke kas')" href="<?php echo base_url('pembelian/deletePembelianAksi/'.$t->id) ?>" class="btn btn-danger"><i class="bi bi-trash-fill"></a></i>
                          <a href="<?php echo base_url('pembelian/editPembelian/'.$t->id) ?>" class="btn btn-warning"><i class="bi bi-exclamation-lg"></a></i>
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
        <p>Note : Sebagai pembelian bahan!</p>
    </section>

  </main><!-- End #main -->