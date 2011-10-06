<?php
class UserController extends AppController {
  function index() {
    echo 'opa!!!';
  }

  function account() {
    echo $this->render();
  }
  
  function save() {
    $user = new User();
    if (empty($_POST['password'])) {
      unset($_POST['password']);
    } else {
      $_POST['password'] = sha1($_POST['password']);
    }
    if ($user->save($_POST)) {
      Session::set('name', $_POST['name']);
      Session::set('hours_per_day', $_POST['hours_per_day']);
      Session::set('show_message', 'success');
    } else {
      Session::set('show_message', 'error');
    }
    Helper::redirect_back();
  }
}
?>