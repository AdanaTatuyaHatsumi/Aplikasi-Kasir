<main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Bahan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item">Bahan</li>
          <li class="breadcrumb-item">Edit Bahan</li>
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
              <?php foreach($e_bahan as $e) : ?>
              <form method="POST" action="<?php echo base_url('bahan/editBahanAksi') ?>" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Nama Bahan</label>
                  <input type="hidden" name="id" class="form-control mb-2" value="<?php echo $e->id ?>">
                  <input type="text" name="nama_bahan" class="form-control mb-2" value="<?php echo $e->nama_bahan ?>">
                  <?php echo form_error('nama_bahan','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group">
                  <label>Harga Bahan</label>
                  <input type="text" name="harga_bahan" class="form-control mb-2" value="<?php echo $e->harga_bahan ?>">
                  <?php echo form_error('harga_bahan','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group">
                  <label>Foto Bahan</label>
                  <input type="file" name="foto_bahan" class="form-control mb-2">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="<?php echo base_url('bahan') ?>" type="btn" class="btn btn-danger">Cancel</a>
                </div>
              </form><!-- End Horizontal Form -->
              <?php endforeach; ?>

            </div>
          </div>
          
        </div>

            
      </div>
    </section>

  </main><!-- End #main -->