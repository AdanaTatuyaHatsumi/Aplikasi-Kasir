<main id="main" class="main">

    <div class="pagetitle">
      <h1>Produk</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item">Master</li>
          <li class="breadcrumb-item active">Produk</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section produk">
    <?php echo $this->session->flashdata('pesan') ?>
      <a class="btn btn-primary mb-2" href="<?php echo base_url('produk/tambahProduk') ?>"><i class="bi bi-plus"></i>Produk</a>
        <div class="row">
          <?php foreach($t_produk as $t) : ?>
            <div class="col-lg-3">
                <!-- Card with an image on top -->
                <div class="card">
                    <?php if(empty($t->foto_produk)){
                      ?>
                        <img src="assets/img/card.jpg" class="card-img-top" alt="...">
                      <?php
                    } else {
                      ?>
                        <img src="assets/foto_produk/<?php echo $t->foto_produk ?>" class="card-img-top" alt="...">
                      <?php
                    } ?>
                    
                    <div class="card-body">
                        <h5 class="card-title"><?php echo str_replace('-',' ',$t->nama_produk) ?></h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Rp.<?php echo $t->harga_produk ?></li>
                        <li class="list-group-item">Tgl.<?php echo $t->tanggal ?></li>
                        <li class="list-group-item">St.<?php echo $t->stok_produk ?></li>
                        <li class="list-group-item">
                          <a onclick="return confirm('Semua data penjualan yang berhubungan dengan produk ini akan terhapus permanen, Yakin hapus?')" href="<?php echo base_url('produk/deleteProdukAksi/'.$t->id) ?>" class="btn btn-danger"><i class="bi bi-trash-fill"></a></i>
                          <a href="<?php echo base_url('produk/editProduk/'.$t->id) ?>" class="btn btn-warning"><i class="bi bi-exclamation-lg"></a></i>
                        </li>
                    </ul>
                </div><!-- End Card with an image on top -->
            </div>
          <?php endforeach; ?>
        </div>
        <?php if(empty($t_produk)){
          echo '<p>tidak ada data, silahkan tambahkan!</p>';
        } ?>
        <p>Note : Barang yang akan di jual!</p>
    </section>

  </main><!-- End #main -->