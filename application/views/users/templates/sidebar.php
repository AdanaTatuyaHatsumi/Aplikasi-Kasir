<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link" href="<?php echo base_url('dashboard') ?>">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->


  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="<?php echo base_url('produk') ?>">
          <i class="bi bi-circle"></i><span>Produk</span>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url('bahan') ?>">
          <i class="bi bi-circle"></i><span>Bahan</span>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url('kas') ?>">
          <i class="bi bi-circle"></i><span>Kas</span>
        </a>
      </li>
    </ul>
  </li><!-- End Components Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-journal-text"></i><span>Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="<?php echo base_url('pembelian') ?>">
          <i class="bi bi-circle"></i><span>Pembelian</span>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url('penjualan') ?>">
          <i class="bi bi-circle"></i><span>Penjualan</span>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url('pemasukan') ?>">
          <i class="bi bi-circle"></i><span>Pemasukan</span>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url('pengeluaran') ?>">
          <i class="bi bi-circle"></i><span>Pengeluaran</span>
        </a>
      </li>
    </ul>
  </li><!-- End Forms Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-layout-text-window-reverse"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="tables-general.html">
          <i class="bi bi-circle"></i><span>Laba Rugi</span>
        </a>
      </li>
    </ul>
  </li><!-- End Tables Nav -->
</ul>

</aside><!-- End Sidebar-->