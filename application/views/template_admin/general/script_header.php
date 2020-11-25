<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<!-- Favicon icon -->
<?php
$template = $this->db->get_where('template', array('id_template' => 1))->result();
?>
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() . $template[0]->logo_favicon; ?>">
<title><?php echo ucwords($template[0]->judul_website); ?></title>
<!-- This page CSS -->
<!-- chartist CSS -->
<link href="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<!--Toaster Popup message CSS -->
<link href="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
<!--c3 plugins CSS -->
<link href="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/c3-master/c3.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?php echo base_url(); ?>main_assets/admin_asset/assets/dist/css/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
<!-- Color picker plugins css -->
<link href="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
<!-- Dashboard 1 Page CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/dropify/dist/css/dropify.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/wizard/steps.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>main_assets/admin_asset/assets/alertifyjs/css/alertify.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>main_assets/admin_asset/assets/alertifyjs/css/alertify.rtl.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>main_assets/admin_asset/assets/alertifyjs/css/themes/default.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>main_assets/admin_asset/assets/alertifyjs/css/themes/default.rtl.min.css" />
<!-- Date picker plugins css -->
<link href="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
<link href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
        font-weight: normal;
    }
    tfoot{
        display: table-header-group;

    }
    .clear-td{
        visibility:hidden;
    }

    table.dataTable tr th.select-checkbox.selected::after {
        content: "✔";
        margin-top: -11px;
        margin-left: -4px;
        text-align: center;
        text-shadow: rgb(176, 190, 217) 1px 1px, rgb(176, 190, 217) -1px -1px, rgb(176, 190, 217) 1px -1px, rgb(176, 190, 217) -1px 1px;
    }

    .disable-bor {
        border-color: #212529; 
    }

    .skin-custom {
        /*Theme Colors*/ }
    .skin-custom .topbar {
        background: <?php echo $template[0]->warna_website; ?>;
        /* Old browsers */
        /*background: -moz-linear-gradient(left, #f62d51 0%, #660fb5 100%);
        /* FF3.6-15 */
        /* background: -webkit-linear-gradient(left, #f62d51 0%, #660fb5 100%);
        /* Chrome10-25,Safari5.1-6 */
        /*background: linear-gradient(to right, #f62d51 0%, #660fb5 100%);
        /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */ }
    .skin-custom .topbar .top-navbar .navbar-header .navbar-brand .dark-logo {
        display: none; }
    .skin-custom .topbar .top-navbar .navbar-header .navbar-brand .light-logo {
        display: inline-block;
        color: <?php echo $template[0]->warna_website; ?>; }
    .skin-custom .sidebar-nav ul li a.active, .skin-red .sidebar-nav ul li a:hover {
        color: <?php echo $template[0]->warna_website; ?>; }
    .skin-custom .sidebar-nav ul li a.active i, .skin-red .sidebar-nav ul li a:hover i {
        color: <?php echo $template[0]->warna_website; ?>; }
    .skin-custom .sidebar-nav > ul > li.selected > a {
        color: <?php echo $template[0]->warna_website; ?>;
        border-left: 3px solid <?php echo $template[0]->warna_website; ?>; }
    .skin-custom .sidebar-nav > ul > li.selected > a i {
        color: <?php echo $template[0]->warna_website; ?>; }
    .skin-custom .page-titles .breadcrumb .breadcrumb-item.active {
        color: <?php echo $template[0]->warna_website; ?>; }

    .card .card-subtitle-new {
        font-weight: 300;
        margin-bottom: 0px;
        color: #000000;
    }

    .input-group-text-hasil {
        display: flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        margin-bottom: 0;
        font-size: 1.5rem;
        font-weight: 400;
        line-height: 1.5;
        color: #4F5467;
        text-align: center;
        white-space: nowrap;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 0.25rem;
    }

    .input-group-prepend, .input-group-append-hasil {
        display: flex;
        justify-content: center;
    }

    .table-pemilihan th, .table-pemilihan td {
        padding: 0.5rem;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
    }
</style>