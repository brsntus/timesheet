      <div class="row">
        <div class="span7 offset-one-third">
          <h1>Timesheet</h1>
          <p>Sign in using the form below, or sign up if you don't have an account yet.</p>
          <p>&nbsp;</p>
          <ul class="tabs" data-tabs="tabs">
            <li <?=((isset($active_tab) && $active_tab == 'sign-in') || !isset($active_tab)) ? 'class="active"' : ''?>><a href="#sign-in">Sign In</a></li>
            <?php if (SIGN_UP_ACTIVE): ?>
              <li <?=(isset($active_tab) && $active_tab == 'sign-up') ? 'class="active"' : '' ?>><a href="#sign-up">Sign Up</a></li>
            <?php endif ?>
          </ul>
          
          <div class="tab-content">
            <div id="sign-in" <?=((isset($active_tab) && $active_tab == 'sign-in') || !isset($active_tab)) ? 'class="active"' : ''?>>
              <?php if (isset($login_error)): ?>
                <div class="alert-message error">
                  <p><?=$login_error?></p>
                </div>
              <?php endif ?>
              <form action="<?=BASE_PATH?>/pages/do_login" method="POST" class="form-stacked">
                <fieldset>
                  <div class="clearfix">
                    <label for="email">Email</label>
                    <div class="input-prepend">
                      <span class="add-on">@</span>
                      <input class="span6" id="email" name="email" size="30" type="text">
                    </div>
                  </div><!-- /clearfix -->
                  <div class="clearfix">
                    <label for="password">Password</label>
                    <div class="input-prepend">
                      <span class="add-on">*</span>
                      <input class="span6" id="password" name="password" size="30" type="password">
                    </div>
                  </div><!-- /clearfix -->
                  <div class="clearfix">
                    <input type="checkbox" name="keep_me_logged_in" value="1" id="keep_me_logged_in" checked="checked" style="float:left;">
                    <label for="keep_me_logged_in">&nbsp;Keep me logged in</label>
                  </div><!-- /clearfix -->                  
                </fieldset>
                <div class="actions">
                  <button type="submit" class="btn primary">Sign In</button>
                </div>
              </form>
            </div>
            
            <?php if (SIGN_UP_ACTIVE): ?>
            <div id="sign-up" <?=(isset($active_tab) && $active_tab == 'sign-up') ? 'class="active"' : '' ?>>
              <?php if (isset($register_error)): ?>
                <div class="alert-message error">
                  <p><?=$register_error?></p>
                </div>
              <?php endif ?>
              <form action="<?=BASE_PATH?>/pages/save_register" method="POST" class="form-stacked">
                <fieldset>
                  <div class="clearfix">
                    <label for="name">Name</label>
                    <div class="input-prepend">
                      <span class="add-on">A</span>
                      <input class="span6" id="name" name="name" size="30" type="text">
                    </div>
                  </div><!-- /clearfix -->
                  
                  <div class="clearfix">
                    <label for="email">Email</label>
                    <div class="input-prepend">
                      <span class="add-on">@</span>
                      <input class="span6" id="email" name="email" size="30" type="text">
                    </div>
                  </div><!-- /clearfix -->
                  
                  <div class="clearfix">
                    <label for="password">Password</label>
                    <div class="input-prepend">
                      <span class="add-on">*</span>
                      <input class="span6" id="password" name="password" size="30" type="password">
                    </div>
                  </div><!-- /clearfix -->
                  
                  <div class="clearfix">
                    <label for="hours_per_day">Daily work hours</label>
                    <div class="input">
                      <input class="span2" id="hours_per_day" name="hours_per_day" size="6" type="text"> <small class="help-inline">Use a . (dot) to separete the decimal values (e.g. 5.5 for 5 and 1/2 hours)</small>
                    </div>
                  </div><!-- /clearfix -->

                  <div class="clearfix">
                    <label for="timezone">Timezone</label>
                    <div class="input">
                      <?=Helper::timezone_select()?>
                    </div>
                  </div><!-- /clearfix -->
                </fieldset>
                <div class="actions">
                  <button type="submit" class="btn primary">Sign Up</button>
                </div>
              </form>
            </div>
            <?php endif ?>
          </div>
        </div>
      </div>
      
      <script type="text/javascript" charset="utf-8">
        $(function() {
          $('.tabs').tabs();
        })
      </script>