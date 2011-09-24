<?php
class Validate {
  private static $_conditions = array();
  private static $_data = array();
  private static $_errors = array();
  private static $_error_messages = array(
    'required' => 'O campo "%1$s" não pode ser vazio',
    'minlength' => 'O campo "%1$s" precisa ter pelo menos %2$s caracteres',
    'maxlength' => 'O campo "%1$s" precisa ter no máximo %2$s caracteres',
    'email' => 'O campo "%1$s" deve ser um e-mail válido',
    'equalsTo' => 'O campo "%1$s" deve ser igual ao campo "%2$s"',
    'pattern' => 'O campo "%1$s" é inválido',
    'alphanum' => 'O campo "%1$s" só pode conter letras ou números',
    'remote' => 'O valor informado no campo "%1$s" já esta em uso'
  );
  
  public static function isValid($data, $conditions) {
    self::$_errors = array();
    self::$_data = $data;
    self::$_conditions = $conditions;
    
    foreach ($conditions as $field => $condition) {
      foreach ($condition['rules'] as $rule => $value) {
        if (method_exists('Validate', $rule)) {
          self::$rule($field, $data, $value);
        }
      }
    }
    
    if (self::$_errors) {
      return false;
    }
    return true;
  }
  
  public static function show_errors($error_messages = array()) {
    $errors = array();
    $messages = array_merge(self::$_error_messages, $error_messages);
    foreach (self::$_errors as $field => $error) {
      switch ($error) {
        case 'minlength':
        case 'maxlength':
        case 'equalsTo':
          $output = vsprintf($messages[$error], array(self::$_conditions[$field]['field_name'], self::$_conditions[$field]['rules'][$error]))."\n";
          break;
        default:
          $output = vsprintf($messages[$error], array(self::$_conditions[$field]['field_name']))."\n";
          break;
      }
      $errors[] = $output;
    }
    return $errors;
  }
  
  public static function set_error($field, $error) {
    if (!array_key_exists($field, self::$_errors)) {
      self::$_errors[$field] = $error;
    }
  }
  
  private static function required($field, $data, $condition) {
    if ($condition === TRUE) {
      if (!array_key_exists($field, $data)) {
        self::set_error($field, 'required');
        return;
      }
      
      if (array_key_exists($field, $data)) {
        $_tmp = trim($data[$field]);
        if (empty($_tmp)) {
          self::set_error($field, 'required');
          return;
        }
      }
    }
  }
  
  private static function minlength($field, $data, $condition) {
    if (!array_key_exists($field, $data)) {
      self::set_error($field, 'minlength');
      return;
    }
    
    if (array_key_exists($field, $data)) {
      $_tmp = trim($data[$field]);
      if (empty($_tmp)) {
        self::set_error($field, 'minlength');
        return;
      } else {
        if (mb_strlen($_tmp, 'UTF-8') < $condition) {
          self::set_error($field, 'minlength');
          return;
        }
      }
    }
  }
  
  private static function maxlength($field, $data, $condition) {
    if (array_key_exists($field, $data)) {
      $_tmp = trim($data[$field]);
      if (mb_strlen($_tmp, 'UTF-8') > $condition) {
        self::set_error($field, 'maxlength');
        return;
      }
    }
  }
  
  private static function email($field, $data, $condition) {
    if (array_key_exists($field, $data)) {
      $_tmp = trim($data[$field]);
      if (preg_match('/^(?:(?:(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|\x5c(?=[@,"\[\]\x5c\x00-\x20\x7f-\xff]))(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]\x5c\x00-\x20\x7f-\xff]|\x5c(?=[@,"\[\]\x5c\x00-\x20\x7f-\xff])|\.(?=[^\.])){1,62}(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]\x5c\x00-\x20\x7f-\xff])|[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]{1,2})|"(?:[^"]|(?<=\x5c)"){1,62}")@(?:(?!.{64})(?:[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.?|[a-zA-Z0-9])+\.(?:xn--[a-zA-Z0-9]+|[a-zA-Z]{2,6})|\[(?:[0-1]?\d?\d|2[0-4]\d|25[0-5])(?:\.(?:[0-1]?\d?\d|2[0-4]\d|25[0-5])){3}\])$/', $data[$field]) == 0) {
        self::set_error($field, 'email');
        return;
      }
    }
  }
  
  private static function equalsTo($field, $data, $condition) {
    if (array_key_exists($field, $data) && array_key_exists($condition, $data)) {
      if ($data[$field] !== $data[$condition]) {
        self::set_error($field, 'equalsTo');
        return;
      }
    }
  }
  
  private static function pattern($field, $data, $condition) {
    if (preg_match($condition, @$data[$field]) == 0) {
      self::set_error($field, 'pattern');
      return;
    }
  }
  
  private static function remote($field, $data, $condition) {
    if (array_key_exists($field, $data)) {
      $url_parts = explode('/', $condition);
      $controller = array_shift($url_parts);
      $action = array_shift($url_parts);
      $return = performAction($controller, $action, array_merge((array)$data[$field], $url_parts));
      if (!$return) {
        self::set_error($field, 'remote');
        return;
      }
    }
  }
  
  private static function alphanum($field, $data, $condition) {
    if (array_key_exists($field, $data)) {
      if (preg_match('/^[a-z0-9]+$/iD', $data[$field]) == 0) {
        self::set_error($field, 'alphanum');
        return;
      }
    }
  }
}
?>