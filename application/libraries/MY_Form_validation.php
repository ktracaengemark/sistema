<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MY_Form_validation Class
 *
 * Extends Form_Validation library
 *
 */
class MY_Form_validation extends CI_Form_validation {

    private $_standard_date_format = 'Y-m-d H:i:s';
    private $mime_types;

    public function __construct() {
        parent::__construct();
    }

    /**
     *
     * decimar_br
     *
     * Verifica se é decimal, mas com virgula no lugar de .
     * @access	public
     * @param	string
     * @return	bool
     */
    public function decimal_br($str) {
        $CI = & get_instance();
        $CI->form_validation->set_message('decimal_br', 'O campo %s não contem um valor decimal válido.');

        return (bool) preg_match('/^[\-+]?[0-9]+\,[0-9]+$/', $str);
    }

    /**
     *
     * valid_cpf
     *
     * Verifica CPF é válido
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_cpf($cpf) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_cpf', 'O <b>%s</b> informado não é válido.');

        if (preg_match('/^[0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}$/', $cpf) == FALSE) {
            return FALSE;
        } else {

            $cpf = preg_replace('/[^0-9]/', '', $cpf);

            if (strlen($cpf) != 11 || preg_match('/^([0-9])\1+$/', $cpf)) {
                return FALSE;
            }

            // 9 primeiros digitos do cpf
            $digit = substr($cpf, 0, 9);

            // calculo dos 2 digitos verificadores
            for ($j = 10; $j <= 11; $j++) {
                $sum = 0;
                for ($i = 0; $i < $j - 1; $i++) {
                    $sum += ($j - $i) * ((int) $digit[$i]);
                }

                $summod11 = $sum % 11;
                $digit[$j - 1] = $summod11 < 2 ? 0 : 11 - $summod11;
            }

            return $digit[9] == ((int) $cpf[9]) && $digit[10] == ((int) $cpf[10]);
        }
    }
	
    function valid_soma_maior($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_soma_maior', '<b>%s</b>');

		$valortotalorca = str_replace(',', '.', str_replace('.', '', $data));
		
		if ($data)  {
			return FALSE;
		} else {
			return TRUE;
		}
       
    }
	
    function valid_soma_menor($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_soma_menor', '<b>%s</b>');

		$valortotalorca = str_replace(',', '.', str_replace('.', '', $data));
		
		if ($data)  {
			return FALSE;
		} else {
			return TRUE;
		}
       
    }
	
    function valid_qtdparcelas($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_qtdparcelas', '<b>%s</b>');

		if (($data) < 1) {
			return FALSE;
		}
       
    }
	
    function valid_aprovado($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_aprovado', '<b>%s</b>');

		if (($data) != "S") {
			return FALSE;
		}
       
    }
		
    function valid_cliente($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_cliente', 'O <b>%s</b> informado não é válido!<br>Selecione um Cliente!');
		if (($data) == 0) {
			return FALSE;
		}
       
    }
	
    function valid_promocao($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_promocao', '<b>%s</b>');

		if (($data) <= 0) {
			return FALSE;
		}
       
    }
	
    function valid_brinde($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_brinde', '<b>%s</b>');

		if (($data) != "S") {
			return FALSE;
		}
       
    }
	
    function valid_celular($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_celular', 'O <b>%s</b> deve conter 11 números.');

		$celular = strlen($data);

		if ( $celular == 11) {
			return TRUE;
		}else{
			return FALSE;
		}
       
    }	
	
    function valid_extensaoBKP($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_extensao', '<b>%s</b>');

		if (($data) == "jpg") {
			return FALSE;
		}
       
    }
	
    function valid_extensao($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_extensao', '<b>%s</b>');
		$tiposPermitidos	= ['png','gif'];
		$tamanho			= $arquivo['size'];
		
		$extensao			= explode('.', $data);
		$extensao			= end($extensao);
		
        if (in_array($extensao, $tiposPermitidos)) {
            return FALSE;
        }
        else {
            return TRUE;
        }

    }	
	
    /**
     * valid_date
     *
     * valida data no pradrao brasileiro
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_date($data) {
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_date', '<b>%s</b> inválida. Use uma data válida no formato DD/MM/AAAA.');

        #$padrao = explode('/', $data);
        $CI->load->library('basico');

        return $CI->basico->check_date($data);
    }

    /**
     * valid_hour
     *
     * valida a hora
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_hour($data) {
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_hour', '<b>%s</b> inválida. Use um horário válido no formato HH:MM.');

        #$padrao = explode('/', $data);
        $CI->load->library('basico');

        return $CI->basico->check_hour($data);
    }
	
    function valid_prazo($data) {
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_prazo', '<b>%s</b> inválido. O Prazo deve ser maior que 5.');

        #$padrao = explode('/', $data);
        $CI->load->library('basico');

        return $CI->basico->check_prazo($data);
    }
	
    function valid_intervalo($data) {
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_intervalo', '<b>%s</b> inválido. O Intervalo deve ser maior que 0.');

        #$padrao = explode('/', $data);
        $CI->load->library('basico');

        return $CI->basico->check_intervalo($data);
    }
	
    function valid_repetir($data) {
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_repetir', '<b>%s</b> inválido. Para Gerar Repetições, ponha a chave no Sim.');

        #$padrao = explode('/', $data);
        $CI->load->library('basico');

        return $CI->basico->check_repetir($data);
    }
	
    function valid_periodo($data) {
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_periodo', '<b>%s</b> inválido. O Período deve ser maior que 1.');

        #$padrao = explode('/', $data);
        $CI->load->library('basico');

        return $CI->basico->check_periodo($data);
    }
	
    /**
     * valid_period
     *
     * valida o período, considerando uma data início e fim e a data fim deve ser maior (posterior) que a data início
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_periodo_hora($horafim, $horainicio) {

        $CI = & get_instance();
        $CI->form_validation->set_message('valid_periodo_hora', '<b>%s</b> inválida. A Hora final deve ser maior que a inicial.');

        $CI->load->library('basico');

        return $CI->basico->check_periodo_hora($horafim, $horainicio);
    }
	
    function valid_periodo_data($datafim, $dataini) {
			/*	
			echo '<br>';
			echo "<pre>";
			print_r($datafim);
			echo '<br>';
			print_r($dataini);
			echo "</pre>";
			exit();
			*/
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_periodo_data', '<b>%s</b> inválida. A data final deve ser maior ou igual que a inicial.');

        $CI->load->library('basico');

        return $CI->basico->check_periodo_data($datafim, $dataini);
    }
	
    function valid_data_termino($datafim, $dataini) {
			/*	
			echo '<br>';
			echo "<pre>";
			print_r($datafim);
			echo '<br>';
			print_r($dataini);
			echo "</pre>";
			exit();
			*/
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_data_termino', '<b>%s</b> inválida. A data em que Termina deve ser maior que a Primeira Repetição.');

        $CI->load->library('basico');

        return $CI->basico->check_data_termino($datafim, $dataini);
    }
	
    function valid_data_termino2($datafim, $dataini) {
			/*	
			echo '<br>';
			echo "<pre>";
			print_r($datafim);
			echo '<br>';
			print_r($dataini);
			echo "</pre>";
			exit();
			*/
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_data_termino2', '<b>%s</b> inválida. A data em que Termina deve ter duração menor que 2 anos.');

        $CI->load->library('basico');

        return $CI->basico->check_data_termino2($datafim, $dataini);
    }
			
    function valid_periodo_intervalo($periodo, $intervalo) {
			/*	
			echo '<br>';
			echo "<pre>";
			print_r($periodo);
			echo '<br>';
			print_r($intervalo);
			echo "</pre>";
			exit();
			*/
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_periodo_intervalo', '<b>%s</b> inválido. O Período deve ser maior que o Intervalo.');

        $CI->load->library('basico');

        return $CI->basico->check_periodo_intervalo($periodo, $intervalo);
    }

    /**
     * valid_cep
     *
     * Verifica se CEP é válido
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_cep($cep) {
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_cep', '<b>%s</b> inválido.');

        return (bool) preg_match('/^([0-9]{2})\.?([0-9]{3})-?([0-9]{3})$/', $cep);
        /*
          if ($retorno['resultado'] == 1 || $retorno['resultado'] == 2)
          return TRUE;
          else
          return FALSE;
         *
         */
    }

    public function is_unique($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique', '<b>%s</b> já cadastrado.');

        if ($field == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');

        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($this->CI->db) ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0) : FALSE;
    }

    public function is_unique_site_BKP($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_site', '<b>%s</b> já cadastrado.');
		/*
        if ($field == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');
		*/
		$str = preg_replace("/([^\w.]+)|(\.(?=.*\.))/", "", $str);
		
		$palavra = strtr($str, "ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
		$palavranova = str_replace("_", " ", $palavra);
		$pattern = '|[^a-zA-Z0-9\-]|';    
		$palavranova = preg_replace($pattern, ' ', $palavranova);
		$str = str_replace(' ', '', $palavranova);
		$str = str_replace('---', '', $str);
		$str = str_replace('--', '', $str);
		$str = strtolower($str);		
		
        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($this->CI->db) ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0) : FALSE;
    }	
	
    public function is_unique_site($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_site', '<b>%s</b> já cadastrado.');
		/*
        if ($field == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');
		*/

		$palavra = strtr($str, "ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
		$palavranova = str_replace("_", " ", $palavra);
		$pattern = '|[^a-zA-Z0-9\-]|';    
		$palavranova = preg_replace($pattern, ' ', $palavranova);
		$str = str_replace(' ', '', $palavranova);
		$str = str_replace('---', '', $str);
		$str = str_replace('--', '', $str);
		$str = preg_replace("/([^\w.]+)|(\.(?=.*\.))/", "", $str);		
		$str = strtolower($str);		

		$pasta = '../' .$str. '';
			
        if (isset($pasta) && is_dir($pasta)) {
            return FALSE;
        }
        else {
			sscanf($field, '%[^.].%[^.]', $table, $field);
			return isset($this->CI->db) ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0) : FALSE;
        }
		
    }
	
    function valid_diretorio($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_diretorio', 'O <b>%s</b> já Existe.');
		
		$pasta = '../' .$data. '';
			
        if (is_dir($pasta)) {
            return FALSE;
        }
        else {
            return TRUE;
        }		

    }	

    public function is_unique_cpf($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_cpf', '<b>%s</b> já cadastrado.');

        #$str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');
        #exit();

        sscanf($field, '%[^.].%[^.]', $table, $field);
        #return isset($this->CI->db)
        #    ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
        #    : FALSE;

        $this->CI->db->limit(1)->get_where($table, array($field => $str));
        echo $this->CI->db->last_query();
        exit();
    }

    public function is_unique_by_id($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_by_id', '<b>%s</b> já cadastrado.');

        #sscanf($field, '%[^.].%[^.]', $table, $field);
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);

        if ($field == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');
		/*
		echo "<pre>";
			print_r($str);
		echo "<br>";
			print_r($field);
		echo "<br>";
			print_r($table);
		echo "<br>";	  
			print_r($field);
		echo "<br>";	  
			print_r($id);
		echo "</pre>";
		exit();
		*/
		return isset($this->CI->db)
                #? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
                ? ($this->CI->db->limit(1)->query('SELECT ' . $field . ' FROM ' . $table . ' WHERE '
                        . 'id' . $table . ' != "' . $id . '" AND ' . $field . ' = "' . $str . '"')->num_rows() === 0) : FALSE;
    
	}
	
    public function is_unique_by_id_empresa($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_by_id_empresa', '<b>%s</b> já cadastrado.');

        #sscanf($field, '%[^.].%[^.]', $table, $field);
        sscanf($field, '%[^.].%[^.].%[^.].%[^.].%[^.]', $table, $field, $id, $field2, $str2);

        if ($field == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');
		/*
		echo "<pre>";
			print_r($str);
		echo "<br>";
			print_r($field);
		echo "<br>";
			print_r($table);
		echo "<br>";	  
			print_r($field);
		echo "<br>";	  
			print_r($id);
		echo "<br>";
			print_r($field2);
		echo "<br>";	  
			print_r($str2);
		echo "</pre>";
		exit();
		*/
		return isset($this->CI->db)
                #? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
                ? ($this->CI->db->limit(1)->query('SELECT ' . $field . ', ' . $field2 . ' FROM ' . $table . ' WHERE '
                        . 'id' . $table . ' != "' . $id . '" AND ' . $field . ' = "' . $str . '" AND ' . $field2 . ' = "' . $str2 . '"')->num_rows() === 0) : FALSE;
    
	}	
       
	/**
	 * Unique
	 *
	 * Verifica se o valor já está cadastrado no banco
	 * unique[users.login] retorna FALSE se o valor postado já estiver no campo login da tabela users
	 * unique[users.login.10] retorna FALSE se o valor postado já estiver no campo login da tabela users, desde que o id seja diferente de 10.
	 * 						isso é útil quando for atualizar os dados
	 * unique[users.city.10:id_cidade] retorna FALSE se o valor postado já estiver no campo city da tabela users, desde que o id_cidade seja diferente de 10.
	 						se não for passado o valor após o : será usado o id.
	 * @access	public
	 * @param	string - dados que será buscado
	 * @param	string - campo, tabela e id
	 *
	 * @return	bool
	 */
	public function is_unique_duplo($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_duplo', '<b>%s</b> já cadastrado.');

        sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field1, $field2, $str2);

        if ($field1 == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');

		/*
		echo "<pre>";
			print_r($field);
		echo "<br>";
			print_r($table);
		echo "<br>";	  
			print_r($field1);
		echo "<br>";
			print_r($str);
		echo "<br>";
			print_r($field2);
		echo "<br>";	  
			print_r($str2);
		echo "</pre>";
		exit();
		*/
        return isset($this->CI->db) ? ($this->CI->db->limit(1)->query('SELECT ' . $field1 . ', ' . $field2 . ' FROM ' . $table . ' WHERE '
                        . $field1 . ' = "' . $str . '" AND ' . $field2 . ' = "' . $str2 . '"')->num_rows() === 0) : FALSE;

    }
	
	public function is_unique_emp($str = '', $field = '')	{
		$CI =& get_instance();
		
		$res = explode('.', $field, 3);
		
		$table	= $res[0];
		$column	= $res[1];
		$CI->form_validation->set_message('is_unique_emp', 'O %s já está cadastrado nesta EMPRESA.');
		
		
		$CI->db->select('COUNT(*) as total');
		$CI->db->where($column, $str);
		
		if( isset($res[2]) )
		{
			$res2 = explode(':', $res[2], 2);
			$ignore_value = $res2[0];
			
			if( isset($res2[1]) )
				$ignore_field = $res2[1];
			else
				$ignore_field = 'id';
			
			$CI->db->where($ignore_field . ' !=', $ignore_value);
		}
		$total = $CI->db->get($table)->row()->total;
		return ($total > 0) ? FALSE : TRUE;
	}
	
	    /**
     * valid_phone
     *
     * validação simples de telefone
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_phone($fone){
        $CI =& get_instance();
        $CI->form_validation->set_message('valid_fone', 'O campo %s não contém um Telefone válido.');
        $fone = preg_replace('/[^0-9]/','',$fone);
        $fone = (string) $fone;
        if( strlen($fone) >= 10)
            return TRUE;
        else
            return FALSE;
    }
	
    function file_allowed_type($file, $type) {

        //is type of format a,b,c,d? -> convert to array
        $exts = explode(',', $type);

        //is $type array? run self recursively
        if (count($exts) > 1) {
            foreach ($exts as $v) {
                $rc = $this->file_allowed_type($file, $v);
                if ($rc === TRUE) {
                    return TRUE;
                }
            }
        }

        //is type a group type? image, application, word_document, code, zip .... -> load proper array
        $ext_groups = array();
        $ext_groups['image'] = array('jpg', 'jpeg', 'gif', 'png');
        $ext_groups['image_icon'] = array('jpg', 'jpeg', 'gif', 'png', 'ico', 'image/x-icon');
        $ext_groups['application'] = array('exe', 'dll', 'so', 'cgi');
        $ext_groups['php_code'] = array('php', 'php4', 'php5', 'inc', 'phtml');
        $ext_groups['word_document'] = array('rtf', 'doc', 'docx');
        $ext_groups['compressed'] = array('zip', 'gzip', 'tar', 'gz');
        $ext_groups['document'] = array('txt', 'text', 'doc', 'docx', 'dot', 'dotx', 'word', 'rtf', 'rtx');

        //if there is a group type in the $type var and not a ext alone, we get it
        if (array_key_exists($exts[0], $ext_groups)) {
            $exts = $ext_groups[$exts[0]];
        }

        $this->load_mimes();


        $exts_types = array_flip($exts);
        $intersection = array_intersect_key(array($this->mime_types), $exts_types);

        //if we can use the finfo function to check the mime AND the mime
        //exists in the mime file of codeigniter...
        if (function_exists('finfo_open') and ! empty($intersection)) {
            $exts = array();

            foreach ($intersection as $in) {
                if (is_array($in)) {
                    $exts = array_merge($exts, $in);
                }
                else {
                    $exts[] = $in;
                }
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $file['tmp_name']);
        }
        else {
            //get file ext
            $file_type = strtolower(strrchr($file['name'], '.'));
            $file_type = substr($file_type, 1);
        }

        if (!in_array($file_type, $exts)) {
            return FALSE;
        }
        else {
            return TRUE;
        }

    }

    function file_required($file) {
        if ($file['size'] === 0) {
            return FALSE;
        }

        return TRUE;

    }

    // --------------------------------------------------------------------

    /**
     * Returns FALSE if the file is bigger than the given size
     *
     * @access	public
     * @param	mixed $file
     * @param	string
     * @return	bool
     */
    function file_size_max($file, $max_size) {
        $max_size_bit = $this->let_to_bit($max_size);
        if ($file['size'] > $max_size_bit) {
            return FALSE;
        }
        return TRUE;

    }

    function let_to_bit($sValue) {
        // Split value from name
        if (!preg_match('/([0-9]+)([ptgmkb]{1,2}|)/ui', $sValue, $aMatches)) { // Invalid input
            return FALSE;
        }

        if (empty($aMatches[2])) { // No name -> Enter default value
            $aMatches[2] = 'KB';
        }

        if (strlen($aMatches[2]) == 1) { // Shorted name -> full name
            $aMatches[2] .= 'B';
        }

        $iBit = (substr($aMatches[2], -1) == 'B') ? 1024 : 1000;
        // Calculate bits:

        switch (strtoupper(substr($aMatches[2], 0, 1))) {
            case 'P':
                $aMatches[1] *= $iBit;
            case 'T':
                $aMatches[1] *= $iBit;
            case 'G':
                $aMatches[1] *= $iBit;
            case 'M':
                $aMatches[1] *= $iBit;
            case 'K':
                $aMatches[1] *= $iBit;
                break;
        }

        // Return the value in bits
        return $aMatches[1];

    }
	
    function file_upload_error_message($field, $error_code) {
        switch ($error_code) {
            case UPLOAD_ERR_INI_SIZE:
                return $this->CI->lang->line('error_max_filesize_phpini');
            case UPLOAD_ERR_FORM_SIZE:
                return $this->CI->lang->line('error_max_filesize_form');
            case UPLOAD_ERR_PARTIAL:
                return $this->CI->lang->line('error_partial_upload');
            case UPLOAD_ERR_NO_FILE:
			$line = $this->CI->lang->line('file_required');
                return sprintf($line, $this->_translate_fieldname($field));
            case UPLOAD_ERR_NO_TMP_DIR:
                return $this->CI->lang->line('error_temp_dir');
            case UPLOAD_ERR_CANT_WRITE:
                return $this->CI->lang->line('error_disk_write');
            case UPLOAD_ERR_EXTENSION:
                return $this->CI->lang->line('error_stopped');
            default:
                return $this->CI->lang->line('error_unexpected') . $error_code;
        }

    }	
	
}
