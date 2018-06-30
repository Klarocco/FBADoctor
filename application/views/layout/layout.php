<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php if (isset($page_title)) : ?><?php echo $page_title ?> - <?php endif; ?><?php echo $this->settings->info->site_name ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <link href="<?php echo base_url(); ?>images/fevicon.png" rel="shotcut icon" type="image/x-icon"/>
    <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url(); ?>bootstrap/css/creditly.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>bootstrap/css/teaser.css" rel="stylesheet" media="teaser">
    <script src="<?php echo base_url(); ?>bootstrap/js/creditly.js"></script>
    <link href="<?php echo base_url(); ?>styles/main.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>styles/dashboard.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>styles/responsive.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>styles/colpick.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <link href="<?php echo base_url(); ?>assets/frameworks/bootstrap/css/jquery.timepicker.min.css" rel="stylesheet" type="text/css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>scripts/ckeditor/ckeditor.js"></script>
     <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
    <link href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css" rel="stylesheet" media="screen">

    <script src="<?php echo base_url(); ?>scripts/custom/jquery-1.12.4.js"></script>
    <script src="<?php echo base_url(); ?>scripts/custom/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>scripts/custom/dataTables.responsive.min.js"></script>

    <script src="<?php echo base_url(); ?>scripts/custom/jquery-1.11.1.js"></script>
    <script src="<?php echo base_url(); ?>scripts/custom/jquery.validate.min.js"></script>
    <?php
        $this->load->helper('cookie');
        $config = $this->config->item("cookieprefix");
    ?>

    <script type="text/javascript">
        var global_base_url = "<?php echo site_url('/') ?>";
    </script>

    <script type="text/javascript">
        $(document).ready(function ()
        {
            $('li').click(function ()
            {
                if ($(this).hasClass("active"))
                {
                    $(this).removeClass("active");
                }
                else
                {
                    $(this).addClass('active');
                }
            });
            $("#sidebar-toggle").on('click', function ()
            {
                var windwidth = $(window).width();
                if (windwidth < 768)
                {
                    $('body').removeClass('sidebar-collapse');
                    if ($("body").hasClass("sidebar-open"))
                    {

                        $('body').removeClass('sidebar-open');
                    } else
                    {

                        $('body').addClass('sidebar-open');
                    }
                }
                else
                {
                    if ($("body").hasClass("sidebar-collapse"))
                    {
                        $('body').removeClass("sidebar-collapse");
                    }
                    else
                    {
                        $('body').removeClass("sidebar-expanded-on-hover");
                        $('body').addClass("sidebar-collapse");
                    }
                }

            });
            $(".main-sidebar").hover(function ()
            {
                if ($("body").hasClass("sidebar-collapse"))
                {
                    $('body').removeClass("sidebar-collapse");
                    $('body').addClass("sidebar-expanded-on-hover");
                }
                else if ($("body").hasClass("sidebar-expanded-on-hover"))
                {
                    $('body').removeClass("sidebar-expanded-on-hover");
                    $('body').addClass("sidebar-collapse");
                }
            });
        });
    </script>

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/frameworks/font-awesome/css/font-awesome.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/frameworks/ionicons/css/ionicons.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/frameworks/adminlte/css/adminlte.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/frameworks/adminlte/css/skins/skin-green.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/frameworks/domprojects/css/dp.min.css'; ?>">
    <link ref="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <style>
        td.details-control
        {
            background: url('<?php echo base_url().'images/details_open.png'?>') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control
        {
            background: url('<?php echo base_url().'images/details_close.png'?>') no-repeat center center;
        }

        tr td.colspan{
            padding-left: 60px;
        }
        .white-area-content
        {
            margin-left: 30px;
        }
        /*.main-header .navbar
        {
            margin-left: 250px;
        }
        .main-header .logo
        {
            width:250px;
        }*/
        .row
        {
            margin-right: 0px;
            margin-left: 0px;
        }
        .main-header .logo .logo-mini {
            display: none;
        }
    </style>

    <?php echo $cssincludes ?>
</head>
<body class="skin-green fixed sidebar-mini">
<div class="wrapper" id="wrapperdiv">
    <header class="main-header">
        <a href="#" class="logo">
            <span class="logo-mini"><b></b><h3 style="margin-top: 12px;">FBADoctor</h3></span>
            <span class="logo-lg"><b></b><h3 style="margin-top: 12px;">FBADoctor</h3></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#"  class="sidebar-toggle" id="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <?php
                    if ($this->input->cookie($config . "old_user")) {
                        $id = $this->input->cookie($config . "old_user");
                        ?>
                        <li><a href="<?php echo site_url('Login/pro/' . $id . '/1'); ?>">switch back to admin</a></li>
                        <?php
                    }
                    ?>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="margin-right:20px;">
                            <?php $filePath =$this->settings->info->upload_path . "/users/". $this->user->info->first_name.$this->user->info->last_name."/".$this->user->info->avatar;?>
                            <?php (file_exists($filePath)) ? $imagePath= base_url()."images/users/".$this->user->info->first_name.$this->user->info->last_name."/".$this->user->info->avatar :
                                $imagePath = base_url(). "images/default.png"; ?>
                            <img src="<?php echo base_url();?>images/user-128.png" class="user-image" alt="User Image" onerror="<?php echo base_url()?>images/default.png">
                            <span class="hidden-xs"><?php echo $this->user->info->username; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="<?php echo base_url();?>images/user-128.png" class="user-image " alt="User Image" onerror="<?php echo base_url()?>images/default.png">
                                <p><?php echo $this->user->info->username; ?><small><?php echo lang('header_member_since'); ?> <?php echo date('d-m-Y', $this->user->info->joined); ?></small></p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo site_url('user_settings'); ?>" class="btn btn-default btn-flat"><?php echo lang('ctn_200'); ?></a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo site_url("login/logout"); ?>" class="btn btn-default btn-flat"><?php echo lang('ctn_149'); ?></a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar" style="width:250px;">
        <section class="sidebar">

            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo base_url(); ?>images/user-128.png" class="user-image img-circle"  alt="User Image" onerror="<?php echo base_url()?>images/default.png">
                </div>

                <div class="pull-left info">
                    <p><?php echo $this->user->info->username; ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> <?php echo lang('ctn_528'); ?></a>
                </div>
            </div>
            <br>

            <ul class="sidebar-menu">
                <li class="<?php if (isset($activeLink['home']['general'])) echo "active" ?>">
                    <a href="<?php echo site_url('home'); ?>"><i class="fa fa-home"></i> <span><?php echo lang('ctn_526'); ?></span></a>
                </li>

                <?php if ($this->user->info->admin): ?>
                    <li class="treeview  <?php if (isset($activeLink['admin'])) echo "active" ?>">
                        <a href="#" class="not-active"><i class="fa fa-user-plus"></i> <span><?php echo lang("ctn_157"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right" ></i></span></a>
                        <ul class="treeview-menu">
                            <li class="<?php if (isset($activeLink['admin']['account'])) echo "active" ?>"><a href="<?php echo site_url('account/index'); ?>"><?php echo lang("ctn_342"); ?></a></li>
                            <li class="<?php if (isset($activeLink['admin']['settings'])) echo "active" ?>"><a href="<?php echo site_url("admin/settings"); ?>"><?php echo lang('ctn_158'); ?></a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                    <li class="treeview  <?php if (isset($activeLink['amazon_case'])) echo "active" ?>">
                        <a href="#" class="not-active"><i class="fa fa-dollar"></i> <span><?php echo lang("ctn_560"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <?php if($this->user->info->admin) : ?>
                                <li class="<?php if (isset($activeLink['amazon_case']['amazon_case'])) echo "active" ?>"><a href="<?php echo site_url("amazon_case/index"); ?>"><?php echo lang("ctn_549"); ?></a></li>
                            <?php endif;?>
                            <li class="<?php if (isset($activeLink['amazon_case']['generate_amazon_case'])) echo "active" ?>"><a href="<?php echo site_url("amazon_case/generatedCase"); ?>"><?php echo lang("ctn_559"); ?></a></li>
                            <li class="<?php if (isset($activeLink['amazon_case']['order_tracking_info'])) echo "active" ?>"><a href="<?php echo site_url("amazon_case/orderTrackingInfo"); ?>"><?php echo lang("ctn_622"); ?></a></li>
                        </ul>
                    </li>

                    <li class="treeview  <?php if (isset($activeLink['custome_case'])) echo "active" ?>">
                        <a href="#" class="not-active"><i class="fa fa-gavel" aria-hidden="true"></i><span><?php echo lang("ctn_623"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                        <ul class="treeview-menu">
                            <?php if($this->user->info->admin) : ?>
                                <li class="<?php if (isset($activeLink['custome_case']['custom_case'])) echo "active" ?>"><a href="<?php echo site_url("custom_case/index"); ?>"><?php echo lang("ctn_624"); ?></a></li>
                            <?php endif;?>
                                <li class="<?php if (isset($activeLink['custome_case']['generate_custom_case'])) echo "active" ?>"><a href="<?php echo site_url("custom_case/customcaselist"); ?>"><?php echo lang("ctn_625"); ?></a></li>
                        </ul>
                    </li>

                   <li class="treeview  <?php if (isset($activeLink['inventory_salvager'])) echo "active" ?>">
                        <a href="#" class="not-active"><i class="fa fa-tasks"></i> <span><?php echo lang("ctn_571"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right" ></i></span></a>
                        <ul class="treeview-menu">
                            <?php if($this->user->info->admin) : ?>
                                <li class="<?php if (isset($activeLink['inventory_salvager']['inventory_salvager'])) echo "active" ?>"><a href="<?php echo site_url("inventory_salvager/index"); ?>"><?php echo lang("ctn_579"); ?></a></li>
                            <?php endif;?>
                                <li class="<?php if (isset($activeLink['inventory_salvager']['generate_inventory_case'])) echo "active" ?>" style="overflow:hidden;"><a href="<?php echo site_url("inventory_salvager/generatedInvetoryCases"); ?>"><?php echo lang("ctn_580"); ?></a></li>
                        </ul>
                    </li>

                    <li class="treeview <?php if (isset($activeLink['affiliate'])) echo "active" ?>">
                        <a href="#" class="not-active"><i class="fa fa-history"></i><span><?php echo lang("ctn_627"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right" ></i></span></a>
                        <ul class="treeview-menu">
                            <li class="<?php if (isset($activeLink['affiliate'])) echo "active" ?>"><a href="<?php echo site_url("affiliate"); ?>"><?php echo lang("ctn_628"); ?></a></li>
                        </ul>
                    </li>

                    <li class="treeview  <?php if(isset($activeLink['settings'])) echo "active" ?>">
                        <a href="#" class="not-active"><i class="fa fa-cog"></i> <span><?php echo lang("ctn_156"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right" ></i></span></a>
                        <ul class="treeview-menu">
                             <li class="<?php if (isset($activeLink['settings']['general'])) echo "active" ?>"><a href="<?php echo site_url("user_settings"); ?>"><?php echo lang("ctn_518"); ?></a></li>
                             <li class="<?php if (isset($activeLink['settings']['feedback_setting'])) echo "active" ?>"><a href="<?php echo site_url("feedback_setting/"); ?>"><span><?php echo lang("ctn_344") ?></span></a></li>
                             <li class="<?php if (isset($activeLink['settings']['link_amazon_account'])) echo "active" ?>"><a href="<?php echo site_url("feedback_setting/link_amazon_account"); ?>"><?php echo lang("ctn_585"); ?></a></li>
                        </ul>
                    </li>
            </ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-12" >

                    <?php if ($this->settings->info->install) : ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info"><b><span class="glyphicon glyphicon-warning-sign"></span></b> <a href="<?php echo site_url("install") ?>">Great job on uploading all the files and setting up the site correctly! Let's now create the Admin account and set the default settings. Click here! This message will disappear once you have run the install process.</a></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php $gl = $this->session->flashdata('globalmsg'); ?>
                    <?php if (!empty($gl)) : ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success"><b><span class="glyphicon glyphicon-ok"></span></b> <?php echo $this->session->flashdata('globalmsg') ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php $el = $this->session->flashdata('errormsg'); ?>
                    <?php if (!empty($el)) : ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger"><b><span class="glyphicon glyphicon-remove"></span></b> <?php echo $this->session->flashdata('errormsg') ?></div>
                                </div>
                            </div>
                    <?php endif; ?>

                    <?php echo $content ?>
                    <p class="align-center small-text"><?php echo lang("ctn_170") ?> <a href="http://www.webdimensions.co.in/">Webdimensions</a><br /> <?php echo $this->settings->info->site_name ?> V<?php echo $this->settings->version ?> </p>
                </div>
            </div>
        </section>
    </div>
</div>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/frameworks/jquery/jquery.timepicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/frameworks/adminlte/js/jscolor.js"></script>
<script src="<?php echo base_url() ?>assets/frameworks/adminlte/js/jscolor.min.js"></script>
</body>
</html>