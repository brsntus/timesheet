<?php
class PagesController extends AppController {
  public $before_filter = array(
    array(
      'method' => '_check_login',
      'except' => array('logout', 'save_register')
    )
  );
  
  function _check_login() {
    if (Helper::is_logged_in()) {
      Helper::redirect_home();
    } else {
      Helper::check_cookie();
    }
  }
  
  function index() {
    echo $this->render();
  }
  
  function do_login() {
    if (isset($_POST) && $_POST) {
      $users = new User();
      if ($users->check_credentials($_POST)) {
        Helper::do_login((array)$users->find_by_email($_POST['email']), (bool)(isset($_POST['keep_me_logged_in']) && $_POST['keep_me_logged_in'] == 1));
      }
    }
    
    $this->set('login_error', 'Login or password invalid');
    echo $this->render('pages/index');
  }
  
  function logout() {
    Helper::do_logout();
  }
  
  function save_register() {
    $errors = array();
    if (isset($_POST) && !empty($_POST)) {
      $user = new User();
      $user_data = $user->create($_POST);
      if ($user_data) {
        Helper::do_login($user_data);
      }
    }
    
    $this->set('active_tab', 'sign-up');
    $this->set('register_error', 'There was an error with your register');    
    echo $this->render('pages/index');
  }
}
?>