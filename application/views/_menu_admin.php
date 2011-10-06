<ul class="nav">
  <li <?=isset($this) ? ($this->_controller == 'User' ? 'class="active"' : '') : ''?>><a href="<?=BASE_PATH?>/user">Users</a></li>
  <li <?=isset($this) ? ($this->_controller == 'Holiday' ? 'class="active"' : '') : ''?>><a href="<?=BASE_PATH?>/holiday">Holidays</a></li>
</ul>
<ul class="nav secondary-nav">
  <li class="dropdown" data-dropdown="dropdown">
    <a href="javascript:;" class="dropdown-toggle"><?=Session::get('name')?></a>
    <ul class="dropdown-menu">
      <li><a href="<?=BASE_PATH?>/user/account">My Account</a></li>
      <li class="divider"></li>
      <li><a href="<?=BASE_PATH?>/pages/logout">Logout</a></li>
    </ul>
  </li>
</ul>