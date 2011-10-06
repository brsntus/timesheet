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