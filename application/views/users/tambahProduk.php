<main id="main" class="main">

    <div class="pagetitle">
      <h1>Tambah Produk</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item">Produk</li>
          <li class="breadcrumb-item">Tambah Produk</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>

              <!-- Horizontal Form -->
              <form method="POST" action="<?php echo base_url('produk/tambahProdukAksi') ?>" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Nama Produk</label>
                  <input type="text" name="nama_produk" class="form-control mb-2" id="inputText">
                  <?php echo form_error('nama_produk','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group">
                  <label>Harga Produk</label>
                  <input type="text" name="harga_produk" class="form-control mb-2" id="inputText">
                  <?php echo form_error('harga_produk','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group">
                  <label>Foto Produk</label>
                  <input type="file" name="foto_produk" class="form-control mb-2">
                </div>
                <div class="form-group">
                  <label>Stok Produk</label>
                  <input type="text" name="stok_produk" class="form-control mb-2">
                  <?php echo form_error('stok_produk','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="<?php echo base_url('produk') ?>" type="btn" class="btn btn-danger">Cancel</a>
                </div>
              </form><!-- End Horizontal Form -->

            </div>
          </div>
          
        </div>

            
      </div>
    </section>

  </main><!-- End #main -->