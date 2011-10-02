<div class="content">
  <div class="page-header">
    <h1>My Account <small>Change your account settings and information</small></h1>
  </div>
  
  <?php if (Session::get('show_message')): ?>
    <?php if (Session::get('show_message') == 'success'): ?>
      <div class="alert-message success" data-alert>
        <a class="close" href="#">&times;</a>
        <p><strong>Hooray!</strong> Your settings were change successfully.</p>
      </div>
    <?php endif ?>
    <?php if (Session::get('show_message') == 'error'): ?>
      <div class="alert-message error" data-alert>
        <a class="close" href="#">&times;</a>
        <p><strong>Oh snap!</strong> Something went wrong.</p>
      </div>
    <?php endif ?>
    <?php Session::remove('show_message'); ?>
  <?php endif ?>
  
  
  <div class="row">
    <div class="span16">
      <form action="<?=BASE_PATH?>/user/save" method="POST" class="form-stacked">
        <fieldset>
          <div class="clearfix">
            <label for="name">Name</label>
            <div class="input-prepend">
              <span class="add-on">A</span>
              <input class="span6" id="name" name="name" size="30" type="text" value="<?=Session::get('name')?>">
            </div>
          </div><!-- /clearfix -->
          
          <div class="clearfix">
            <label for="email">Email</label>
            <div class="input-prepend">
              <span class="add-on">@</span>
              <input class="span6" id="email" name="email" size="30" type="text" disabled="disabled" value="<?=Session::get('email')?>">
            </div>
          </div><!-- /clearfix -->
          
          <div class="clearfix">
            <label for="password">Password</label>
            <div class="input-prepend">
              <span class="add-on">*</span>
              <input class="span6" id="password" name="password" size="30" type="password" value=""> <small class="help-inline">Leave blank if don't want to change</small>
            </div>
          </div><!-- /clearfix -->
          
          <div class="clearfix">
            <label for="hours_per_day">Daily work hours</label>
            <div class="input">
              <?=Helper::hours_per_day_select(Session::get('hours_per_day'))?>
            </div>
          </div><!-- /clearfix -->
          
        </fieldset>
        <div class="actions">
          <button type="submit" class="btn primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript" charset="utf-8">
  $(function() {
    
  });
</script>