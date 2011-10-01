      <div class="row">
        <div class="span7 offset-one-third">
          <h1>No, motherfucker</h1>
          <p>Do you see any Teletubbies in here? Do you see a slender plastic tag clipped to my shirt with my name printed on it? Do you see a little Asian child with a blank expression on his face sitting outside on a mechanical helicopter that shakes when you put quarters in it? No? Well, that's what you see at a toy store. And you must think you're in a toy store, because you're here shopping for an infant named Jeb.</p>
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
                  <input type="checkbox" name="keep_me_logged_in" value="1" id="keep_me_logged_in" checked="checked">
                  <label for="keep_me_logged_in">Keep me logged in</label>
                </fieldset>
                <div class="actions">
                  <button type="submit" class="btn primary">Sign In</button>
                </div>
              </form>
            </div>
            
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
                      <span class="add-on">@</span>
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
                  
                  <div class="row">
                    <div class="span3">
                      <div class="clearfix">
                        <label for="salary">Salary</label>
                        <div class="input-prepend">
                          <span class="add-on">$</span>
                          <input class="span2" id="salary" name="salary" size="15" type="text">
                        </div>
                      </div><!-- /clearfix -->
                    </div>
                    
                    <div class="span3">
                      <div class="clearfix">
                        <label for="hours_per_day">Daily work hours</label>
                        <div class="input">
                          <!--input class="span2" id="hours_per_day" name="hours_per_day" size="15" type="text"-->
                          <select class="span3" id="hours_per_day" name="hours_per_day">
                            <option></option>
                            <option value="6">6 hours</option>
                            <option value="8">8 hours</option>
                          </select>
                        </div>
                      </div><!-- /clearfix -->
                    </div>
                  </div>
                  
                </fieldset>
                <div class="actions">
                  <button type="submit" class="btn primary">Sign Up</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <script type="text/javascript" charset="utf-8">
        $(function() {
          $('.tabs').tabs();
        })
      </script>