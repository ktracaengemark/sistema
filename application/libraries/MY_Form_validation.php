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
        $CI->form_validation->set_message('valid_periodo_hora', '<b>%s</b> inválida. A data final deve ser maior que a inicial.');

        $CI->load->library('basico');

        return $CI->basico->check_periodo_hora($horafim, $horainicio);
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

        return isset($this->CI->db)
                #? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
                ? ($this->CI->db->limit(1)->query('SELECT ' . $field . ' FROM ' . $table . ' WHERE '
                        . 'id' . $table . ' != "' . $id . '" AND ' . $field . ' = "' . $str . '"')->num_rows() === 0) : FALSE;
    }

}
