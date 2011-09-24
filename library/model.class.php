<?php
class Model {
  protected $model;
  
  function __construct() {
		$this->model = get_class($this);
  }
}
?>