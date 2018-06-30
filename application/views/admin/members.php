<div class="white-area-content">
<div class="db-header clearfix">
    <div class="page-header-title"> <span class="glyphicon glyphicon-user"></span> <?php echo lang("ctn_1") ?></div>
    <div class="db-header-extra"><input type="button" class="btn btn-primary btn-sm" value="<?php echo lang("ctn_73") ?>" data-toggle="modal" data-target="#memberModal" />
</div>
</div>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url() ?>"><?php echo lang("ctn_2") ?></a></li>
  <li><a href="<?php echo site_url("admin") ?>"><?php echo lang("ctn_1") ?></a></li>
  <li class="active"><?php echo lang("ctn_74") ?></li>
</ol>

<p><?php echo lang("ctn_75") ?></p>

<hr>
<?php echo form_open(site_url("admin/search_member/"), array("class" => "form-inline")) ?>
  <div class="form-group">
    <label class="sr-only" for="exampleInputEmail3"><?php echo lang("ctn_76") ?></label>
    <input type="text" class="form-control" id="exampleInputEmail3" placeholder="<?php echo lang("ctn_76") ?>" name="search">
  </div>
  <div class="form-group">
    <label class="sr-only" for="exampleInputPassword3"><?php echo lang("ctn_76") ?></label>
    <select name="option" class="form-control">
    <option value="0"><?php echo lang("ctn_77") ?></option>
    <option value="1"><?php echo lang("ctn_78") ?></option>
    <option value="2"><?php echo lang("ctn_79") ?></option>
    <option value="3"><?php echo lang("ctn_80") ?></option>
    </select>
  </div>
  <input type="submit" class="btn btn-primary" value="<?php echo lang("ctn_76") ?>" />
<?php echo form_close() ?>

<hr>


    <div class="align-center">
      <?php echo $this->pagination->create_links(); ?>
    </div>

<table class="table table-bordered">
<tr class="table-header"><td><?php echo lang("ctn_77") ?>
<?php if($col === 1) : ?>
    <?php if($sort == 1) : ?>
    <a href="<?php echo site_url("admin/members/1/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
    <?php else : ?>
    <a href="<?php echo site_url("admin/members/1/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
    <?php endif; ?>
<?php else : ?>
    <a href="<?php echo site_url("admin/members/1/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
<?php endif; ?>
</td><td><?php echo lang("ctn_81") ?>
<?php if($col === 2) : ?>
    <?php if($sort == 1) : ?>
    <a href="<?php echo site_url("admin/members/2/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
    <?php else : ?>
    <a href="<?php echo site_url("admin/members/2/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
    <?php endif; ?>
<?php else : ?>
    <a href="<?php echo site_url("admin/members/2/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
<?php endif; ?>
</td><td><?php echo lang("ctn_78") ?>
<?php if($col === 6) : ?>
    <?php if($sort == 1) : ?>
    <a href="<?php echo site_url("admin/members/6/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
    <?php else : ?>
    <a href="<?php echo site_url("admin/members/6/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
    <?php endif; ?>
<?php else : ?>
    <a href="<?php echo site_url("admin/members/6/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
<?php endif; ?>
</td><td><?php echo lang("ctn_322") ?>
<?php if($col === 3) : ?>
    <?php if($sort == 1) : ?>
    <a href="<?php echo site_url("admin/members/3/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
    <?php else : ?>
    <a href="<?php echo site_url("admin/members/3/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
    <?php endif; ?>
<?php else : ?>
    <a href="<?php echo site_url("admin/members/3/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
<?php endif; ?>
</td><td><?php echo lang("ctn_83") ?>
<?php if($col === 4) : ?>
    <?php if($sort == 1) : ?>
    <a href="<?php echo site_url("admin/members/4/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
    <?php else : ?>
    <a href="<?php echo site_url("admin/members/4/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
    <?php endif; ?>
<?php else : ?>
    <a href="<?php echo site_url("admin/members/4/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
<?php endif; ?>
</td><td><?php echo lang("ctn_84") ?>
<?php if($col === 5) : ?>
    <?php if($sort == 1) : ?>
    <a href="<?php echo site_url("admin/members/5/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-up icon-nolink"></span></a>
    <?php else : ?>
    <a href="<?php echo site_url("admin/members/5/1/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink"></span></a>
    <?php endif; ?>
<?php else : ?>
    <a href="<?php echo site_url("admin/members/5/0/" . $page) ?>"><span class="glyphicon glyphicon-chevron-down icon-nolink faded"></span></a>
<?php endif; ?>
</td><td>Options</td></tr>

<?php foreach($members->result() as $r) : ?>
    <?php if($r->oauth_provider == "google") {
        $provider = "Google";
    } elseif($r->oauth_provider == "twitter") {
        $provider = "Twitter";
    } elseif($r->oauth_provider == "facebook") {
        $provider = "Facebook";
    } else {
        $provider = lang("ctn_85");
    }
    ?>
<tr><td><a href="<?php echo site_url("profile/" . $r->username) ?>"><?php echo $r->username ?></a></td><td><?php echo $r->first_name . " " . $r->last_name ?></td><td><?php echo $r->email ?></td><td><?php echo $this->common->get_user_role($r) ?></td><td><?php echo date($this->settings->info->date_format, $r->joined) ?></td><td><?php echo $provider ?></td><td><a href="<?php echo site_url("admin/edit_member/" . $r->ID) ?>" class="btn btn-warning btn-xs"><?php echo lang("ctn_55") ?></a> <a href="<?php echo site_url("admin/delete_member/" . $r->ID . "/" . $this->security->get_csrf_hash()) ?>" onclick="return confirm('<?php echo lang("ctn_86") ?>')" class="btn btn-danger btn-xs"><?php echo lang("ctn_57") ?></a></td></tr>
<?php endforeach; ?>

</table>

    <div class="align-center">
      <?php echo $this->pagination->create_links(); ?>
    </div>


    <div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo lang("ctn_73") ?></h4>
      </div>
      <div class="modal-body">
      <?php echo form_open(site_url("admin/add_member_pro"), array("class" => "form-horizontal")) ?>
            <div class="form-group">
                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_78") ?></label>
                    <div class="col-md-9">
                        <input type="email" class="form-control" id="email-in" name="email">
                    </div>
            </div>
            <div class="form-group">

                        <label for="username-in" class="col-md-3 label-heading"><?php echo lang("ctn_77") ?></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="username" name="username">
                            <div id="username_check"></div>
                        </div>
            </div>
            <div class="form-group">

                        <label for="password-in" class="col-md-3 label-heading"><?php echo lang("ctn_87") ?></label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" id="password-in" name="password" value="">
                        </div>
             </div>

                <div class="form-group">

                        <label for="cpassword-in" class="col-md-3 label-heading"><?php echo lang("ctn_88") ?></label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" id="cpassword-in" name="password2" value="">
                        </div>
                </div>

                <div class="form-group">

                        <label for="name-in" class="col-md-3 label-heading"><?php echo lang("ctn_79") ?></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="name-in" name="first_name">
                        </div>
                </div>
                <div class="form-group">

                        <label for="name-in" class="col-md-3 label-heading"><?php echo lang("ctn_80") ?></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="name-in" name="last_name">
                        </div>
                </div>
                <div class="form-group">

                        <label for="name-in" class="col-md-3 label-heading"><?php echo lang("ctn_322") ?></label>
                        <div class="col-md-9">
                            <select name="user_role" class="form-control">
                            <option value="-1"><?php echo lang("ctn_33") ?></option>
                            <option value="0" selected><?php echo lang("ctn_34") ?></option>
                            <?php foreach($user_roles->result() as $r) : ?>
                                <option value="<?php echo $r->ID ?>"><?php echo $r->name ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("ctn_60") ?></button>
        <input type="submit" class="btn btn-primary" value="<?php echo lang("ctn_61") ?>" />
        <?php echo form_close() ?>
      </div>
    </div>
  </div>
</div>

</div>