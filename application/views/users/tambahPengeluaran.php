<main id="main" class="main">

    <div class="pagetitle">
      <h1>Tambah Pengeluaran</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="">Home</a></li>
          <li class="breadcrumb-item">Pengeluaran</li>
          <li class="breadcrumb-item">Tambah Pengeluaran</li>
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
              <form method="POST" action="<?php echo base_url('pengeluaran/tambahPengeluaranAksi') ?>" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Nama Pengeluaran</label>
                  <input type="text" name="nama_pengeluaran" class="form-control mb-2" id="inputText">
                  <?php echo form_error('nama_pengeluaran','<div class="text-small text-danger"></div>') ?>
                </div>
                <div class="form-group">
                  <label>Jumlah</label>
                  <input type="text" name="jumlah" class="form-control mb-2" id="inputText">
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
                  <a href="<?php echo base_url('pengeluaran') ?>" type="btn" class="btn btn-danger">Cancel</a>
                </div>
              </form><!-- End Horizontal Form -->

            </div>
          </div>
          
        </div>

            
      </div>
    </section>

  </main><!-- End #main -->