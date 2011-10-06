<ul class="nav">
  <li <?=isset($this) ? ($this->_controller == 'Clock' ? 'class="active"' : '') : ''?>><a href="<?=BASE_PATH?>/clock">Clock In/Out</a></li>
  <li <?=isset($this) ? ($this->_controller == 'Timesheet' ? 'class="active"' : '') : ''?>><a href="<?=BASE_PATH?>/timesheet">Timesheet</a></li>
  <li <?=isset($this) ? ($this->_controller == 'Report' ? 'class="active"' : '') : ''?>><a href="<?=BASE_PATH?>/report">Reports</a></li>
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