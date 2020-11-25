<?php
$user = $this->session->userdata('ktpapps');
$template = $this->db->get_where('template', array('id_template' => 1))->result();
?>
<ul id="sidebarnav">
    <li class="text-center"><span class=""><b>Hi... "<?php echo strtoupper($user['nama_admin']); ?>"</b></span></li>
    <li class="nav-small-cap"></li>
    <li> <a class="waves-effect waves-dark" href="<?php echo site_url('dashboard'); ?>" aria-expanded="false"><i class="ti-panel"></i><span class="hide-menu">Dashboard</span></a>    
    </li>
    <li class="nav-small-cap"></li>
    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Data Anggota</span></a>
        <ul aria-expanded="false" class="collapse">
            <li><a href="<?php echo site_url('ktp/'); ?>">Daftar Anggota <i class="ti-list"></i></a></li>                               
            <?php if ($user['create_prev'] == 1) { ?>
                <li><a href="<?php echo site_url('ktp/tambah_ktp'); ?>">Tambah Anggota <i class="ti-pencil-alt"></i></a></li>
            <?php } ?>
        </ul>
    </li>
    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Data Petugas</span></a>
        <ul aria-expanded="false" class="collapse"> 
            <li><a href="<?php echo site_url('petugas/'); ?>">Daftar Petugas <i class="ti-list"></i></a></li>        
            <?php if ($user['create_prev'] == 1) { ?>
                <li><a href="<?php echo site_url('petugas/tambah_petugas'); ?>">Tambah Petugas <i class="ti-pencil-alt"></i></a></li>
            <?php } ?>
        </ul>
    </li>
    <li> <a class="waves-effect waves-dark" href="<?php echo site_url('regional/daftar_provinsi'); ?>" aria-expanded="false"><i class="ti-list "></i><span class="hide-menu">Data Regional</span></a></li>
    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-printer"></i><span class="hide-menu">Daerah Pemilihan</span></a>
        <ul aria-expanded="false" class="collapse"> 
            <li><a href="<?php echo site_url('format/formatcetak/daftar_data_anggota'); ?>">Data Dapil<i class="ti-book"></i></a></li>        
            <li><a href="<?php echo site_url('format/formatcetak/daftar_format_pencarian'); ?>">Buat Dapil<i class="ti-tag"></i></a></li>        
        </ul>
    </li>
    <li class="nav-small-cap"></li>
    <?php if ($user['role_admin'] == 0) { ?>
        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-book"></i><span class="hide-menu">Data Akun Admin</span></a>
            <ul aria-expanded="false" class="collapse"> 
                <li><a href="<?php echo site_url('akun/daftar_admin_kabupaten'); ?>">Admin Kabupaten<i class="ti-list"></i></a></li>        
                <li><a href="<?php echo site_url('akun/daftar_admin_provinsi'); ?>">Admin Provinsi<i class="ti-list"></i></a></li>        
                <li><a href="<?php echo site_url('akun/daftar_admin_nasional'); ?>">Admin Nasional <i class="ti-lock"></i></a></li>            
            </ul>
        </li>
    <?php } elseif ($user['role_admin'] == 1) {
        ?>
        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-settings"></i><span class="hide-menu">Pengaturan Akun</span></a>
            <ul aria-expanded="false" class="collapse"> 
                <li><a href="<?php echo site_url('akun/daftar_admin_kabupaten'); ?>">List Admin Kabupaten<i class="ti-list"></i></a></li>        
            </ul>
        </li>
    <?php } elseif ($user['role_admin'] == 2) {
        ?>

    <?php } ?>
    <li> <a class="waves-effect waves-dark" href="<?php echo site_url('pekerjaan/daftar_pekerjaan'); ?>" aria-expanded="false"><i class="ti-briefcase"></i><span class="hide-menu">Data Pekerjaan</span></a></li>
    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-files"></i><span class="hide-menu">Laporan</span></a>
        <ul aria-expanded="false" class="collapse"> 
            <li><a href="<?php echo site_url('laporan/get_laporan'); ?>">Atur Kop Laporan <i class="ti-image"></i></a></li>        
        </ul>
    </li>
    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-export"></i><span class="hide-menu">Mutasi Anggota</span></a>
        <ul aria-expanded="false" class="collapse"> 
            <li><a href="<?php echo site_url('mutasi/daftar_mutasi_keluar'); ?>">Anggota Keluar<i class="ti-shift-right"></i></a></li>    
            <li><a href="<?php echo site_url('mutasi/daftar_mutasi_masuk'); ?>">Anggota Masuk<i class="ti-shift-left"></i></a></li>    
        </ul>
    </li>
    <li> <a class="waves-effect waves-dark" href="<?php echo site_url('pemilihan/daftar_pemilihan'); ?>" aria-expanded="false"><i class="ti-user"></i><span class="hide-menu">Pemilihan</span></a>
    </li>
    <?php if ($user['role_admin'] == 0) { ?>
        <li class="nav-small-cap"></li>
        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-harddrive"></i><span class="hide-menu">Kelola Data</span></a>
            <ul aria-expanded="false" class="collapse"> 
                <li><a href="<?php echo site_url('keloladata/data_ktp'); ?>">Data Anggota <i class="ti-list"></i></a></li>        
                <li><a href="<?php echo site_url('keloladata/data_petugas'); ?>">Data Petugas <i class="ti-list"></i></a></li>                
            </ul>
        </li>
    <?php } ?>
    <?php if ($user['id_user'] == 0) { ?>
        <li><a href="<?php echo site_url('pengaturan/get_template/1'); ?>">Pengaturan Template <i class="ti-settings"></i></a></li>       
    <?php } ?>
    <li class="nav-small-cap"></li>
    <li> <a class="waves-effect waves-dark" href="<?php echo site_url('auth/logout'); ?>" aria-expanded="false"><i class="ti-export text-danger"></i><span class="hide-menu">Log Out</span></a></li>
</ul>