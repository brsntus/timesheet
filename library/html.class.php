<?php
class HTML {
	public static function includeJs($file) {
		$data = '<script src="'.STATIC_FILES_URL.'/js/'.$file.'.js"></script>'."\n";
		return $data;
	}

	public static function includeCss($file, $options = array()) {
	  $data = '';
	  if (array_key_exists('condition', $options)) {
	    $data .= "<!--[if {$options['condition']}]>\n";
	  }
		$data .= '<link rel="stylesheet" href="'.STATIC_FILES_URL.'/css/'.$file.'.css" type="text/css"';
		if (array_key_exists('media', $options)) {
		  $data .= ' media="' . $options['media'];
		}
		$data .= '">'."\n";
		if (array_key_exists('condition', $options)) {
	    $data .= "<![endif]-->\n";
	  }
		return $data;
	}
	
	public static function js() {
	  global $__js;
	  $data = '';	  
    foreach ($__js[APPLICATION_ENV] as $file) {
      $data .= self::includeJs($file);
    }	  
	  return $data;
	}
	
	public static function css() {
	  global $__css;
	  $data = '';
    foreach ($__css[APPLICATION_ENV] as $file => $options) {
      $data .= self::includeCss($file);
    }
	  return $data;
	}
	
	/**
	 * Cria um select com a lista de opções passada.
	 *
	 * @param string $field_name - Nome do campo.
	 * @param array $options_list - Lista de dados dos options.
	 * @param string $options  - Opções extras(selected,include_blank) e atributos(class,id...).
	 * @return string
	 */
	public static function select($field_name, $options_list = array(), $options = array()) {
		$defaults = array('include_blank' => false, 'include_blank_value' => '', 'id' => $field_name);
		$options = array_merge($defaults, $options);
		
		$html = '';
		$selected = '';
		
		if (isset($options['selected'])) {
			$selected = $options['selected'];
			unset($options['selected']);
		}
		
		if (isset($options['include_blank'])) {
			if ($options['include_blank'] === true) {
				$include_blank = '<option></option>';
			} else if ($options['include_blank'] === false){
				$include_blank = '';
			} else {
				$include_blank = '<option value="' . $options['include_blank_value'] . '">' . $options['include_blank'] . '</option>';
			}
			unset($options['include_blank']);
		}
		
		$html = '<select name="' . $field_name . '" ' . self::create_attributes($options) . '>';
		$html .= $include_blank;
		foreach ($options_list as $key => $value) {
			$selected_on = '';
			if ((string) $selected === (string) $key) {
				$selected_on = ' selected="selected"';
			}
			$html .= '<option' . $selected_on . ' value="' . $key . '">' . $value . '</option>';
		}
		$html .= '</select>';
		return $html;
	}
	
	/**
	 * Exibe um select de html com os anos passados.
	 *
	 * @param string $field_name - Nome do campo.
	 * @param string $start_year - Ano de inicio.
	 * @param string $end_year - Ano de fim.
	 * @param string $options - Veja select para mais detalhes.
	 */
	public static function select_date_year($field_name, $start_year, $end_year, $options = array()) {
		$defaults = array('selected' => Date('Y'));
		$options = array_merge($defaults, $options);
		
		$data_list = array();
		for ($i = $start_year; $i <= $end_year; $i++) { 
			$data_list[$i] = $i;
		}
		
		return self::select($field_name, $data_list, $options);
	}
	
	
	/**
	 * Exibe um select de html para com os meses do ano.
	 *
	 * @param string $field_name - Nome do campo.
	 * @param array $options - Veja select para mais detalhes.
	 * @return string
	 */
	public static function select_date_month($field_name, $options = array()) {
		$defaults = array('selected'=>Date('m'), 'id' => $field_name);
		$options = array_merge($defaults, $options);
		
		$months = array(
		  '01' => 'Janeiro',
		  '02' => 'Fevereiro',
		  '03' => 'Março',
		  '04' => 'Abril',
		  '05' => 'Maio',
		  '06' => 'Junho',
		  '07' => 'Julho',
		  '08' => 'Agosto',
		  '09' => 'Setembro',
		  '10' => 'Outubro',
		  '11' => 'Novembro',
		  '12' => 'Dezembro'
		);
		
		return self::select($field_name, $months, $options);
	}
	
	
	/**
	 * Exibe um select de html para com os dias do mês.
	 *
	 * @param string $field_name - Nome do campo.
	 * @param array $options - Veja select para mais detalhes.
	 * @return string
	 */
	public static function select_date_day($field_name, $options = array()) {
		$defaults = array('selected' => Date('d'), 'id' => $field_name);
		$options = array_merge($defaults, $options);
		
		$data_list = array();
		for ($i=1; $i <= 31; $i++) {
			$n = ($i < 10) ? '0'.$i : $i;
			$data_list[$n]=$n;
		}

		return self::select($field_name, $data_list, $options);
	}
	
	public static function create_attributes($attributes) {
		$attributes_list = array('rel','class','title','id','alt','value','name','data-method','data-confirm');
		$data = "";
		foreach ($attributes as $key => $value) {
			if(in_array($key,$attributes_list)) {
				$data .= ''.$key.'="'.$value.'" ';
			}
		}
		return $data;
	}
	
	public static function select_date_of_birth($dob) {
    if ($dob) {
      list($year, $month, $day) = explode('-', $dob);
    } else {
      $year = $month = $day = false;
    }
    
    $return = '';
    $return .= HTML::select_date_day('dob_day', array('selected' => $day, 'include_blank' => true));
    $return .= ' '.HTML::select_date_month('dob_month', array('selected' => $month, 'include_blank' => true));
    $return .= ' '.HTML::select_date_year('dob_year', date('Y')-150, date('Y'), array('selected' => $year, 'include_blank' => true));
    return $return;
  }
}
?>