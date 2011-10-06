      <div class="row">
        <div class="span7 offset-one-third">
          <h1>Timesheet</h1>
          <p>Sign in using the form below, or sign up if you don't have an account yet.</p>
          <p>&nbsp;</p>
          <ul class="tabs" data-tabs="tabs">
            <li <?=((isset($active_tab) && $active_tab == 'sign-in') || !isset($active_tab)) ? 'class="active"' : ''?>><a href="#sign-in">Sign In</a></li>
            <li <?=(isset($active_tab) && $active_tab == 'sign-up') ? 'class="active"' : '' ?>><a href="#sign-up">Sign Up</a></li>
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
            
            <div id="sign-up" <?=(isset($active_tab) && $active_tab == 'sign-up') ? 'class="active"' : '' ?>>
              <?php if (SIGN_UP_ACTIVE): ?>
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
                      <?=Helper::hours_per_day_select()?>
                    </div>
                  </div><!-- /clearfix -->
                </fieldset>
                <div class="actions">
                  <button type="submit" class="btn primary">Sign Up</button>
                </div>
              </form>
              <?php else: ?>
                <p>The sign up process is currently disabled.</p>
                <p>If you want to create an account, please send an email to the site administrator.</p>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
      
      <script type="text/javascript" charset="utf-8">
        $(function() {
          $('.tabs').tabs();
        })
      </script>