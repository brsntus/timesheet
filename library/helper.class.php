<?php
class Helper {
  public static function do_login($data, $keep_logged_in = true) {
    unset($data['password']);
    foreach ($data as $key => $value) {
      Session::set($key, $value);
    }

    //if ($keep_logged_in)
      $expire = SESSION_TIMEOUT_LONG + time();
    //else
    //  $expire = SESSION_TIMEOUT_SHORT + time();
    setcookie(COOKIE_NAME, $data['salt'], $expire, '/');
    self::redirect_home();
  }
  
  public static function do_logout() {
    Session::destroy();
    setcookie(COOKIE_NAME, null, 1, '/');
    self::redirect();
  }
  
  public static function check_salt($salt) {
    $users = new User();
    return $users->check_salt($salt);
  }
  
  public static function check_cookie() {
    if (isset($_COOKIE[COOKIE_NAME])) {
      $salt = self::check_salt(strval($_COOKIE[COOKIE_NAME]));
      if ($salt) {
        $users = new User();
        $data = (array)$users->find_by_salt($salt);
        self::do_login($data, true);
      }
    }

    return false;
  }
  
  public static function is_logged_in() {
    if (Session::get('id')) {
      return true;
    }
    return false;
  }
  
  public static function can_edit($id) {
    return (Session::get('id') == $id);
  }
  
  public static function redirect($url = '', $local = true) {
    $url = $local ? BASE_PATH.$url : $url;
    header("Location: {$url}");
    exit();
  }
  
  public static function redirect_back() {
    self::redirect($_SERVER['HTTP_REFERER'], false);
  }

  public static function redirect_home() {
    switch (Session::get('type')) {
      case 'employee':
        $location = '/clock';
        break;
      case 'boss':
        $location = '/report/employees';
        break;
      case 'admin':
        $location = '/user';
        break;
      default:
        $location = '/404';
    }
    self::redirect($location);
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
  
  public static function monthly_hours($hours_per_day) {
    switch ($hours_per_day) {
      case 6:
        return 180;
        break;
      case 8:
        return 220;
        break;
      default:
        return false;
        break;
    }
  }
  
  public static function days_of_the_week($base_date = false, $format = 'l, d M') {
    $base_date = $base_date ? $base_date : date('Y-m-d');
    list($year, $month, $day) = explode('-', $base_date);
    $week = date('W', mktime(0, 0, 0, $month, $day, $year));
    $return = array();
    for ($week_day = 1; $week_day <= 7; $week_day++) {
      $return[] = date($format, strtotime("{$year}W{$week}{$week_day}"));
    }
    return $return;
  }
  
  public static function seconds_to_hours($sec, $padHours = true) {
    // start with a blank string
    $hms = "";

    // do the hours first: there are 3600 seconds in an hour, so if we divide
    // the total number of seconds by 3600 and throw away the remainder, we're
    // left with the number of hours in those seconds
    $hours = intval(intval($sec) / 3600); 

    // add hours to $hms (with a leading 0 if asked for)
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
          : $hours. ":";

    // dividing the total seconds by 60 will give us the number of minutes
    // in total, but we're interested in *minutes past the hour* and to get
    // this, we have to divide by 60 again and then use the remainder
    $minutes = intval(($sec / 60) % 60); 
    if ($minutes < 0) {
      $minutes *= -1;
    }

    // add minutes to $hms (with a leading 0 if needed)
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

    // seconds past the minute are found by dividing the total number of seconds
    // by 60 and using the remainder
    $seconds = intval($sec % 60); 
    if ($seconds < 0) {
      $seconds *= -1;
    }

    // add seconds to $hms (with a leading 0 if needed)
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

    // done!
    return $hms;
  }
  
  public static function hours_to_seconds($hours) {
    list($h, $m, $s) = explode(':', $hours);
    return ($h*60*60) + ($m*60) + $s;
  }
  
  public static function calendar($start, $end) {
    // Firstly, format the provided dates.
    // This function works best with YYYY-MM-DD
    // but other date formats will work thanks
    // to strtotime().
    $start = date("Y-m-d", strtotime($start));
    $end = date("Y-m-d", strtotime($end));

    // Start the variable off with the start date
    $days[] = $start;

    // Set a 'temp' variable, sCurrentDate, with
    // the start date - before beginning the loop
    $current_date = $start;

    // While the current date is less than the end date
    while($current_date < $end) {
      // Add a day to the current date
      $current_date = date("Y-m-d", strtotime("+1 day", strtotime($current_date)));

      // Add this new day to the days array
      $days[] = $current_date;
    }

    // Once the loop has finished, return the
    // array of days.
    return $days;
  }

  public static function timezone_select($selected = false) {
    $timezones = DateTimeZone::listIdentifiers();
    $tmzs = array();
    foreach ($timezones as $tz) {
      $tmzs[$tz] = $tz;
    }

    $options = array('selected' => $selected ? $selected : date_default_timezone_get());

    return HTML::select('timezone', $tmzs, $options);
  }

  public static function log($message) {
    $file = @fopen(ROOT . DS . 'tmp' . DS . 'logs' . DS . 'timesheet.log', 'a');
    if ($file) {
      fwrite($file, '['.date('d/m/Y H:i:s').'] '.$message."\n");
      fclose($file);
    }
  }
}
?>