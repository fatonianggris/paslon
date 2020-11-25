<?php
$user = $this->session->userdata('ktpapps');
$template = $this->db->get_where('template', array('id_template' => 1))->result();
?>
<nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <!-- ============================================================== -->
    <!-- Logo -->
    <!-- ============================================================== -->
    <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>">
            <!-- Logo icon --><b>
                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                <!-- Dark Logo icon -->
                <img src="<?php echo base_url(); ?>main_assets/admin_asset/assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                <!-- Light Logo icon -->
                <img src="<?php echo base_url() . $template[0]->logo_website; ?>" alt="homepage" width="40px" class="light-logo" />
            </b>
            <!--End Logo icon -->
            <!-- Logo text --><span>
                <!-- dark Logo text -->
                <!-- Light Logo text -->    
                <img src="<?php echo base_url() . $template[0]->logo_nama_website; ?>" class="light-logo" width="140px" alt="homepage" /></span> </a>
    </div>
    <!-- ============================================================== -->
    <!-- End Logo -->
    <!-- ============================================================== -->
    <div class="navbar-collapse">
        <!-- ============================================================== -->
        <!-- toggle and nav items -->
        <!-- ============================================================== -->
        <ul class="navbar-nav mr-auto">
            <!-- This is  -->
            <li class="nav-item hidden-sm-up"> <a class="nav-link nav-toggler waves-effect waves-light" href="javascript:void(0)"><i class="ti-menu"></i></a></li>
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-lock waves-effect waves-light" href="javascript:void(0)"><i class="ti-menu"></i></a></li>                    
        </ul>
        <ul class="navbar-nav my-lg-0">          
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo base_url() . $user['img']; ?>" alt="user" class="img-circle" width="30"></a>
                <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                    <span class="with-arrow"><span class="bg-primary"></span></span>
                    <div class="d-flex no-block align-items-center p-1 text-white m-b-10" style="background: <?php echo $template[0]->warna_website; ?>">
                        <div class=""><img src="<?php echo base_url() . $user['img']; ?>" alt="user" class="img-circle" width="60"></div>
                        <div class="m-l-10">
                            <h4 class="m-b-0"><?php echo ucwords($user['nama_admin']); ?></h4>
                            <p class=" m-b-0"><?php echo substr($user['email'], 0, 26); ?></p>
                        </div>
                    </div>                                 
                    <a class="dropdown-item" href="<?php echo site_url('auth/logout'); ?>"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>         
                </div>
            </li>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <li class="nav-item right-side-toggle"> <a class="nav-link  waves-effect waves-light" href="<?php echo site_url('pengaturan/get_user/' . $user['id_user']); ?>"><i class="ti-settings"></i></a></li>
        </ul>
    </div>
</nav>