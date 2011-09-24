<?php
class Helper {  
  public static function redirect($url = '', $local = true) {
    $url = $local ? BASE_PATH.$url : $url;
    header("Location: {$url}");
    exit();
  }
  
  public static function redirect_back() {
    self::redirect($_SERVER['HTTP_REFERER'], false);
  }
  
  public static function is_ajax() {
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
  }
  
  public static function time_ago($date, $dateto = false, $granularity = 1) {
    $periods_inflection = array(
      'singular' => array(
        'decade' => 'decáda',
        'year' => 'ano',
        'month' => 'mês',
        'week' => 'semana',
        'day' => 'dia',
        'hour' => 'hora',
        'minute' => 'minuto',
        'second' => 'segundo'
      ),
      'plural' => array(
        'decade' => 'decádas',
        'year' => 'anos',
        'month' => 'meses',
        'week' => 'semanas',
        'day' => 'dias',
        'hour' => 'horas',
        'minute' => 'minutos',
        'second' => 'segundos'
      )
    );

    $date = strtotime($date);
    $difference = $dateto ? strtotime($dateto) - $date : time() - $date;
    $periods = array(
      'decade' => 315360000,
      'year' => 31536000,
      'month' => 2628000,
      'week' => 604800, 
      'day' => 86400,
      'hour' => 3600,
      'minute' => 60,
      'second' => 1
    );

    $retval = '';             
    foreach ($periods as $key => $value) {
      if ($difference >= $value) {
        $time = floor($difference/$value);
        $difference %= $value;
        $retval .= ($retval ? ' ' : '').$time.' ';
        $retval .= (($time > 1) ? $periods_inflection['plural'][$key] : $periods_inflection['singular'][$key]);
        $granularity--;
      }
      if ($granularity == '0') { break; }
    }
    return $retval ? ' há '.$retval : ' agora';
  }
  
  /*
  Função para retornar a idade de uma pessoa.
  Recebe como parametro uma data no formato YYYY-mm-dd
  A comparação é feita concatenando o mês e dia.
  Verifica se o mês/dia atual é menor que o mês/dia de nascimento.
  Se for menor, retorna: ano atual - ano de nascimento - 1.
  Se for maior ou igual retorna: ano atual - ano de nascimento.
  */
  public static function age($dob) {
    list($y, $m, $d) = explode("-", $dob);
    $age = (date("md") < $m . $d) ? (date("Y") - $y - 1) : (date("Y") - $y);
    return $age;
  }
  
  // Função para contar a quantidade de palavras utilizando caracteres em qualquer lingua, desde que estejam em UTF-8
  public static function str_word_count_utf8($string, $format = 0) {
    $word_count_mask = "/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}]*/u";

    switch ($format) {
      case 1:
        preg_match_all($word_count_mask, $string, $matches);
        return $matches[0];
      case 2:
        preg_match_all($word_count_mask, $string, $matches, PREG_OFFSET_CAPTURE);
        $result = array();
        foreach ($matches[0] as $match) {
          $result[$match[1]] = $match[0];
        }
        return $result;
    }
    return preg_match_all($word_count_mask, $string, $matches);
  }
  
  public static function debug($variable, $name = '') {
    $firephp = FirePHP::getInstance(true);
    if (DEBUG_ACTIVE) {
      $firephp->setEnabled(true);
    } else {
      $firephp->setEnabled(false);
    }
    //return $firephp;
    $firephp->log($variable, $name);
  }
    
  public static function pluralize($amount, $none, $singular, $plural, $print_amount = false) {
    $message = '';
    if ($amount == 0) {
      $message = $none;
    } elseif ($amount == 1) {
      $message = $singular;
    } else {
      $message = $plural;
    }
    
    return $print_amount ? $amount . ' ' . $message : $message;
  }
  
  public static function pp($var) {
    echo '<pre>' . print_r($var, true) . '</pre>';
  }
}
?>