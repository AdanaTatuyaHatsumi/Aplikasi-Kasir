<main id="main" class="main">

    <div class="pagetitle">
      <h1>Bahan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item active">Bahan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section bahan">
    <?php echo $this->session->flashdata('pesan') ?>
      <a class="btn btn-primary mb-2" href="<?php echo base_url('bahan/tambahBahan') ?>"><i class="bi bi-plus"></i>Bahan</a>
        <div class="row">
          <?php foreach($t_bahan as $t) : ?>
            <div class="col-lg-3">
                <!-- Card with an image on top -->
                <div class="card">
                    <?php if(empty($t->foto_bahan)){
                      ?>
                        <img src="assets/img/card.jpg" class="card-img-top" alt="...">
                      <?php
                    } else {
                      ?>
                        <img src="assets/foto_bahan/<?php echo $t->foto_bahan ?>" class="card-img-top" alt="...">
                      <?php
                    } ?>
                    
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $t->nama_bahan ?></h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Rp.<?php echo $t->harga_bahan ?></li>
                        <li class="list-group-item">Tgl.<?php echo $t->tanggal ?></li>
                        <li class="list-group-item">
                          <a onclick="return confirm('Yakin Hapus')" href="<?php echo base_url('bahan/deleteBahanAksi/'.$t->id) ?>" class="btn btn-danger"><i class="bi bi-trash-fill"></a></i>
                          <a href="<?php echo base_url('bahan/editBahan/'.$t->id) ?>" class="btn btn-warning"><i class="bi bi-exclamation-lg"></a></i>
                        </li>
                    </ul>
                </div><!-- End Card with an image on top -->
            </div>
          <?php endforeach; ?>
        </div>
        <?php if(empty($t_bahan)){
          echo '<p>tidak ada data, silahkan tambahkan!</p>';
        } ?>
        <p>Note : Barang yang akan di Beli, di menu pembelian!</p>
    </section>

  </main><!-- End #main -->