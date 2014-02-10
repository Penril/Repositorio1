<div class="login">
<?php $this->load->view('includes/info'); ?>  

<form method="post" action="<?php echo base_url(); ?>login/index" class="form-horizontal" role="form">
  <div class="form-group">
    <div class="col-md-offset-2 col-md-8">
      <input type="text" class="form-control" name="username" placeholder="Nombre de Usuario" autocomplete="off"/>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-md-offset-2 col-md-8">
      <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off"/>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
      <input class="btn btn-block btn-primary btn-primary" name="submit" type="submit" value="Ingresar"/>
    </div>
  </div>
</form>

</div>

