<main id="main" class="main">

    <div class="pagetitle">
      <h1>Tambah Kas</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item">Kas</li>
          <li class="breadcrumb-item">Tambah Kas</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
      <?php echo $this->session->flashdata('pesan') ?>
        <!-- Left side columns -->
        <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>
              
              <!-- Horizontal Form -->
              <form method="POST" action="<?php echo base_url('kas/tambahKasAksi') ?>" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Nama Kas</label>
                  <input type="text" name="nama_kas" class="form-control mb-2" id="inputText">
                  <?php echo form_error('nama_kas','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group">
                  <label>Saldo Kas</label>
                  <input type="text" name="saldo_kas" class="form-control mb-2" id="inputText">
                  <?php echo form_error('saldo_kas','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="<?php echo base_url('kas') ?>" type="btn" class="btn btn-danger">Cancel</a>
                </div>
              </form><!-- End Horizontal Form -->

            </div>
          </div>
          
        </div>

            
      </div>
    </section>

  </main><!-- End #main -->