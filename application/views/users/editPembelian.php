<main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Pembelian</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item">Pembelian</li>
          <li class="breadcrumb-item">Edit Pembelian</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
    <?php echo $this->session->flashdata('pesan') ?>
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>

              <!-- Horizontal Form -->
              <form method="POST" action="<?php echo base_url('pembelian/editPembelianAksi') ?>" enctype="multipart/form-data">
              <?php foreach($e_pembelian as $e) : ?>
                <div class="form-group mb-2">
                  <input type="hidden" name="id" class="form-control" id="inputText" value="<?php echo $e->id ?>">
                  <label>Nama Bahan</label>
                  <input type="text" name="nama_bahan" class="form-control" id="inputText" value="<?php echo $e->nama_bahan ?>" disabled>
                  <input type="hidden" name="nama_bahan" class="form-control" id="inputText" value="<?php echo $e->nama_bahan ?>">
                  <?php echo form_error('nama_bahan','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group mb-2">
                  <label>Jumlah</label>
                  <input type="text" name="jumlah" class="form-control" id="inputText" value="<?php echo $e->jumlah ?>">
                  <?php echo form_error('jumlah','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group mb-2">
                  <label>Kas</label>
                  <input type="text" name="nama_kas" class="form-control" id="inputText" value="<?php echo $e->nama_kas ?>" disabled>
                  <input type="hidden" name="nama_kas" class="form-control" id="inputText" value="<?php echo $e->nama_kas ?>">
                  <?php echo form_error('nama_kas','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="<?php echo base_url('pembelian') ?>" type="btn" class="btn btn-danger">Cancel</a>
                </div>
                <?php endforeach; ?>
              </form><!-- End Horizontal Form -->

            </div>
          </div>
          
        </div>

            
      </div>
    </section>

  </main><!-- End #main -->