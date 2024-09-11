<main id="main" class="main">

    <div class="pagetitle">
      <h1>Tambah Pembelian</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item">Pembelian</li>
          <li class="breadcrumb-item">Tambah Pembelian</li>
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
              <form method="POST" action="<?php echo base_url('pembelian/tambahPembelianAksi') ?>" enctype="multipart/form-data">
                <div class="form-group mb-2">
                  <label>Nama Bahan</label>
                  <select name="nama_bahan" class="form-select" aria-label="Default select example">
                    <option value="">--- Pilih Bahan ---</option>
                    <?php foreach($t_bahan as $t) : ?>
                    <option value="<?php echo $t->nama_bahan ?>">---<?php echo strtoupper($t->nama_bahan) ?>--- <?php echo 'harga '.$t->harga_bahan ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?php echo form_error('nama_bahan','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group mb-2">
                  <label>Jumlah</label>
                  <input type="text" name="jumlah" class="form-control" id="inputText">
                  <?php echo form_error('jumlah','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group mb-2">
                  <label>Kas</label>
                  <select name="nama_kas" class="form-select" aria-label="Default select example">
                    <option value="">--- Pilih Kas ---</option>
                    <?php foreach($t_kas as $t) : ?>
                    <option value="<?php echo $t->nama_kas ?>">---<?php echo strtoupper($t->nama_kas) ?>--- <?php echo 'Saldo '.$t->saldo_kas ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?php echo form_error('nama_kas','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <a href="<?php echo base_url('pembelian') ?>" type="btn" class="btn btn-danger">Cancel</a>
                </div>
              </form><!-- End Horizontal Form -->

            </div>
          </div>
          
        </div>

            
      </div>
    </section>

  </main><!-- End #main -->