<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Form validation extended rules for CodeIgniter
 *
 * A list of useful rules for your form validating process.
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Joseba Juaniz <patroklo@gmail.com>
 * @author			Jeroen van Meerendonk <hola@jeroen.bz>
 * @author			devbro <devbro@devbro.com> (until v2.1)
 * @license			GNU General Public License (GPL)
 * @link			https://github.com/jeroen/codeigniter-extended-rules
 * @version 		3.0
 *
 *
 * Rules supported
 * ---------------------------------------------------------------------------------------------
 * file_required Checks if the a required file is uploaded.
 * file_size_max[size]			Returns FALSE if the file is bigger than the given size.
 * file_size_min[size]			Returns FALSE if the file is smaller than the given size.
 * file_allowed_type[type]		Tests the file extension for valid file types. You can put a group too (image,
 *								application, word_document, code, zip).
 * file_disallowed_type[type]	Tests the file extension for no-valid file types
 * file_image_maxdim[x,y]		Returns FALSE if the image is smaller than given dimension.
 * file_image_mindim[x,y]		Returns FALSE if the image is bigger than given dimension.
 * file_image_exactdim[x,y]		Returns FALSE if the image is not the given dimension.
 * is_exactly[list]				Check if the field's value is in the list (separated by comas).
 * is_not[list]					Check if the field's value is not permitted (separated by comas).
 * valid_hour[hour]				Check if the field's value is a valid 24 hour. [24H or 12H]
 * valid_date[format]				Check if the field's value has a valid date format.
 * valid_range_date[format]			Check if the field's value has a valid range of two date
 *
 *
 * Info
 * ---------------------------------------------------------------------------------------------
 * Size can be in format of 20KB (kilo Byte) or 20Kb(kilo bit) or 20MB or 20GB or ....
 * Size with no unit is assume as KB
 * Type is evaluated based on the file extention.
 * Type can be given as several types seperated by comma
 * Type can be one of the groups of: image, application, php_code, word_document, compressed
 *
 *
 * Change Log
 * ---------------------------------------------------------------------------------------------
 * 4.1:
 *  Now the error field message shows all the error messages that it has and not only the first one.
 * 4.0:
 *  Where there is a file upload, now file_required and required force the user to upload a file.
 *  Added image icon mimes.
 *  Added valid_date method that checks if a field has a valid date format.
 *  Added valid_range_date method that checks if a field has a valid range of two dates.
 * 3.2:
 *  Bug fixes
 * 3.1:
 *  Added 'valid_hour'
 * 3.0:
 * 	Working with CI 2.1.
 * 	Separated the error messages from the library
 * 	Added 'is_exactly' and 'is_not'
 * 2.1:
 * 	fixed the issue: http://codeigniter.com/forums/viewthread/123816/P30/#629711
 *
 */

/*#######################################*/

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
	 * required_by_another_field
	 *
	 * @param	string
	 * @return	bool
	 */
    #public function required_by_another_field($str, $data) {
    public function regex_match_msg($str, $field) {

        $field = explode("###", $field);

        $CI = & get_instance();
        $CI->form_validation->set_message('regex_match_msg', $field[1]);

        return (!preg_match($field[0], $str)) ? FALSE : TRUE;

    }

    /**
	 * required_by_another_field
	 *
	 * @param	string
	 * @return	bool
	 */
    #public function required_by_another_field($str, $data) {
    public function requiredby($str, $field) {

        $CI = & get_instance();
        $CI->form_validation->set_message('requiredby', 'O campo <b>%s</b> é obrigatório.');

        return (!$field) ? FALSE : TRUE;

    }

    /**
	* Required if another field has a value (related fields)
	*
	* @access	public
	* @param	string
	* @return	bool
	*/

	function required_if($str, $field) {
		// The 0 allows radios with 0 value to be seen as 'empty'
		// This is a bit hacky but is the only easy way to allow radio repopulation with
		// a required if rule.
		if (!isset($_POST[$field]) || $_POST[$field] === '' || (bool)$_POST[$field] == 0)
			return TRUE; // the related form is blank

		// the related form is set proceed with normal required
		if ( ! is_array($str))
			return (trim($str) == '') ? FALSE : TRUE;
		else
			return ( ! empty($str));

	}

    /**
	 * Numeric
	 *
	 * @param	string
	 * @return	bool
	 */
	public function numeric($str)
	{
		return (bool) preg_match('/^[\-+]?[0-9]*\,?[0-9]+$/', $str);

	}

    /**
     * Alpha-numeric w/ spaces
     *
     * @param	string
     * @return	bool
     */
    public function alpha_numeric_spaces($str) {
        return preg_match('/^[\pL\pN_ -]+$/', $str) ? 'TRUE' : 'FALSE';
    }

    public function set_rules($field, $label = '', $rules = array(), $errors = array()) {
        if (count($_POST) === 0 AND count($_FILES) > 0) { //it will prevent the form_validation from working
            //add a dummy $_POST
            $_POST['DUMMY_ITEM'] = '';
            parent::set_rules($field, $label, $rules);
            unset($_POST['DUMMY_ITEM']);
        }
        else {
            //we are safe just run as is
            parent::set_rules($field, $label, $rules);
        }

    }

    function run($group = '') {
        $rc = FALSE;
        log_message('DEBUG', 'called MY_form_validation:run()');
        if (count($_POST) === 0 AND count($_FILES) > 0) {//does it have a file only form?
            //add a dummy $_POST
            $_POST['DUMMY_ITEM'] = '';
            $rc = parent::run($group);
            unset($_POST['DUMMY_ITEM']);
        }
        else {
            //we are safe just run as is
            $rc = parent::run($group);
        }

        return $rc;

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

    function _execute($row, $rules, $postdata = NULL, $cycles = 0) {

        log_message('DEBUG', 'called MY_form_validation::_execute ' . $row['field']);
        //changed based on
        //http://codeigniter.com/forums/viewthread/123816/P10/#619868
        if (isset($_FILES[$row['field']])) {// it is a file so process as a file
            log_message('DEBUG', 'processing as a file');
            $postdata = $_FILES[$row['field']];

            //required bug
            //if some stupid like me never remember that it's file_required and not required
            //this will save a lot of var_dumping time.
            if (in_array('required', $rules)) {
                $rules[array_search('required', $rules)] = 'file_required';
            }
            //before doing anything check for errors
            if ($postdata['error'] !== UPLOAD_ERR_OK) {
                //If the error it's 4 (ERR_NO_FILE) and the file required it's deactivated don't call an error
                if ($postdata['error'] != UPLOAD_ERR_NO_FILE) {
                    $this->_error_array[$row['field']] = $this->file_upload_error_message($row['label'], $postdata['error']);
                    return FALSE;
                }
                elseif ($postdata['error'] == UPLOAD_ERR_NO_FILE and in_array('file_required', $rules)) {
                    $this->_error_array[$row['field']] = $this->file_upload_error_message($row['label'], $postdata['error']);
                    return FALSE;
                }
            }

            $_in_array = FALSE;

            // If the field is blank, but NOT required, no further tests are necessary
            $callback = FALSE;
            if (!in_array('file_required', $rules) AND $postdata['size'] == 0) {
                // Before we bail out, does the rule contain a callback?
                if (preg_match("/(callback_\w+)/", implode(' ', $rules), $match)) {
                    $callback = TRUE;
                    $rules = (array('1' => $match[1]));
                }
                else {
                    return;
                }
            }

            foreach ($rules as $rule) {
                /// COPIED FROM the original class
                // Is the rule a callback?
                $callback = FALSE;
                if (substr($rule, 0, 9) == 'callback_') {
                    $rule = substr($rule, 9);
                    $callback = TRUE;
                }

                // Strip the parameter (if exists) from the rule
                // Rules can contain a parameter: max_length[5]
                $param = FALSE;
                if (preg_match("/(.*?)\[(.*?)\]/", $rule, $match)) {
                    $rule = $match[1];
                    $param = $match[2];
                }

                // Call the function that corresponds to the rule
                if ($callback === TRUE) {
                    if (!method_exists($this->CI, $rule)) {
                        continue;
                    }

                    // Run the function and grab the result
                    $result = $this->CI->$rule($postdata, $param);

                    // Re-assign the result to the master data array
                    if ($_in_array == TRUE) {
                        $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                    }
                    else {
                        $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                    }

                    // If the field isn't required and we just processed a callback we'll move on...
                    if (!in_array('file_required', $rules, TRUE) AND $result !== FALSE) {
                        return;
                    }
                }
                else {
                    if (!method_exists($this, $rule)) {
                        // If our own wrapper function doesn't exist we see if a native PHP function does.
                        // Users can use any native PHP function call that has one param.
                        if (function_exists($rule)) {
                            $result = $rule($postdata);

                            if ($_in_array == TRUE) {
                                $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                            }
                            else {
                                $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                            }
                        }

                        continue;
                    }

                    $result = $this->$rule($postdata, $param);

                    if ($_in_array == TRUE) {
                        $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                    }
                    else {
                        $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                    }
                }

                //this line needs testing !!!!!!!!!!!!! not sure if it will work
                //it basically puts back the tested values back into $_FILES
                //$_FILES[$row['field']] = $this->_field_data[$row['field']]['postdata'];
                // Did the rule test negatively?  If so, grab the error.
                if ($result === FALSE) {
                    if (!isset($this->_error_messages[$rule])) {
                        if (FALSE === ($line = $this->CI->lang->line($rule))) {
                            $line = 'Unable to access an error message corresponding to your field name.';
                        }
                    }
                    else {
                        $line = $this->_error_messages[$rule];
                    }

                    // Is the parameter we are inserting into the error message the name
                    // of another field?  If so we need to grab its "field label"
                    if (isset($this->_field_data[$param]) && isset($this->_field_data[$param]['label'])) {
                        $param = $this->_field_data[$param]['label'];
                    }

                    // Build the error message
                    $message = sprintf($line, $this->_translate_fieldname($row['label']), $param);

                    // Save the error message
                    $this->_field_data[$row['field']]['error'] = $message;

                    $this->_error_array[$row['field']][] = $message;


                    return;
                }
            }
        }
        else {
            log_message('DEBUG', 'Called parent _execute');
            parent::_execute($row, $rules, $postdata, $cycles);
        }

    }

    /**
     * Future function. To return error message of choice.
     * It will use $msg if it cannot find one in the lang files
     *
     * @param string $msg the error message
     */
    function set_error($msg) {
        $CI = & get_instance();
        $CI->lang->load('upload');
        return ($CI->lang->line($msg) == FALSE) ? $msg : $CI->lang->line($msg);

    }

    // --------------------------------------------------------------------

    /**
     * Checks if the a required file is uploaded
     *
     * @access	public
     * @param	mixed $file
     * @return	bool
     */
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

    // --------------------------------------------------------------------

    /**
     * Returns FALSE if the file is smaller than the given size
     *
     * @access	public
     * @param	mixed $file
     * @param	string
     * @return	bool
     */
    function file_size_min($file, $min_size) {
        $min_size_bit = $this->let_to_bit($min_size);
        if ($file['size'] < $min_size_bit) {
            return FALSE;
        }
        return TRUE;

    }

    // ----------------------

    function load_mimes() {
        // Get mime types for later
        if (defined('ENVIRONMENT') AND file_exists(APPPATH . 'config/' . ENVIRONMENT . '/mimes.php')) {
            include APPPATH . 'config/' . ENVIRONMENT . '/mimes.php';
        }
        else {
            include APPPATH . 'config/mimes.php';
        }

        #$this->mime_types = $mimes;
        $mimes = $this->mime_types;

    }

    // --------------------------------------------------------------------

    /**
     * Tests the file extension for valid file types
     *
     * @access	public
     * @param	mixed $file
     * @param	mixed
     * @return	bool
     */
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

    // --------------------------------------------------------------------

    /**
     * Tests the file extension for no-valid file types
     *
     * @access	public
     * @param	mixed $file
     * @param	mixed
     * @return	bool
     */
    function file_disallowed_type($file, $type) {
        if ($this->file_allowed_type($file, $type) == FALSE) {
            return TRUE;
        }

        return FALSE;

    }

    // --------------------------------------------------------------------

    /**
     * Given an string in format of ###AA converts to number of bits it is assignin
     *
     * @access	public
     * @param	string
     * @return	integer number of bits
     */
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

    // --------------------------------------------------------------------

    /**
     * Returns FALSE if the image is bigger than given dimension
     *
     * @access	public
     * @param	string
     * @param	array
     * @return	bool
     */
    function file_image_maxdim($file, $dim) {
        log_message('debug', 'MY_form_validation: file_image_maxdim ' . $dim);
        $dim = explode(',', $dim);

        if (count($dim) !== 2) {
            // Bad size given
            log_message('error', 'MY_Form_validation: invalid rule, expected similar to 150,300.');
            return FALSE;
        }

        log_message('debug', 'MY_form_validation: file_image_maxdim ' . $dim[0] . ' ' . $dim[1]);

        //get image size
        $d = $this->get_image_dimension($file['tmp_name']);

        log_message('debug', $d[0] . ' ' . $d[1]);

        if (!$d) {
            log_message('error', 'MY_Form_validation: dimensions not detected.');
            return FALSE;
        }

        if ($d[0] <= $dim[0] && $d[1] <= $dim[1]) {
            return TRUE;
        }

        return FALSE;

    }

    // --------------------------------------------------------------------

    /**
     * Returns FALSE if the image is smaller than given dimension
     *
     * @access	public
     * @param	mixed
     * @param	array
     * @return	bool
     */
    function file_image_mindim($file, $dim) {
        $dim = explode(',', $dim);

        if (count($dim) !== 2) {
            // Bad size given
            log_message('error', 'MY_Form_validation: invalid rule, expected similar to 150,300.');
            return FALSE;
        }

        //get image size
        $d = $this->get_image_dimension($file['tmp_name']);

        if (!$d) {
            log_message('error', 'MY_Form_validation: dimensions not detected.');
            return FALSE;
        }

        log_message('debug', $d[0] . ' ' . $d[1]);

        if ($d[0] >= $dim[0] && $d[1] >= $dim[1]) {
            return TRUE;
        }

        return FALSE;

    }

    // --------------------------------------------------------------------

    /**
     * Returns FALSE if the image is not the given dimension
     *
     * @access	public
     * @param	mixed
     * @param	array
     * @return	bool
     */
    function file_image_exactdim($file, $dim) {
        $dim = explode(',', $dim);

        if (count($dim) !== 2) {
            // Bad size given
            log_message('error', 'MY_Form_validation: invalid rule, expected similar to 150,300.');
            return FALSE;
        }

        //get image size
        $d = $this->get_image_dimension($file['tmp_name']);

        if (!$d) {
            log_message('error', 'MY_Form_validation: dimensions not detected.');
            return FALSE;
        }

        log_message('debug', $d[0] . ' ' . $d[1]);

        if ($d[0] == $dim[0] && $d[1] == $dim[1]) {
            return TRUE;
        }

        return FALSE;

    }

    // --------------------------------------------------------------------

    /**
     * Attempts to determine the image dimension
     *
     * @access	public
     * @param	mixed
     * @return	array
     */
    function get_image_dimension($file_name) {
        log_message('debug', $file_name);
        if (function_exists('getimagesize')) {
            $D = @getimagesize($file_name);

            return $D;
        }

        return FALSE;

    }

    /**
     * Error String
     *
     * Returns the error messages as a string, wrapped in the error delimiters
     *
     * @param   string
     * @param   string
     * @return  string
     */
    public function error_string($prefix = '', $suffix = '') {
        // No errors, validation passes!
        if (count($this->_error_array) === 0) {
            return '';
        }

        if ($prefix === '') {
            $prefix = $this->_error_prefix;
        }

        if ($suffix === '') {
            $suffix = $this->_error_suffix;
        }

        // Generate the error string
        $str = '';
        foreach ($this->_error_array as $val) {
            if ($val !== '') {
                //if field has more than one error, then all will be listed
                if (is_array($val)) {
                    foreach ($val as $v) {
                        $str .= $prefix . $v . $suffix . "\n";
                    }
                }
                else {
                    $str .= $prefix . $val . $suffix . "\n";
                }
            }
        }

        return $str;

    }

    public function wysiwyg_strip_tags($str) {
        return strip_tags($str, '<strong><b><p><ul><ol><li><a><span>');

    }

    // --------------------------------------------------------------------

    /**
     *
     * decimar_br
     *
     * Verifica se é decimal, mas com virgula (,) no lugar de ponto (.)
     * @access	public
     * @param	string
     * @return	bool
     */
    public function decimal_br($str) {
        $CI = & get_instance();
        $CI->form_validation->set_message('decimal_br', 'O campo <strong>%s</strong> não contém um valor decimal válido.');

        return (bool) preg_match('/^[\-+]?[0-9]+\,[0-9]+$/', $str);

    }

    /**
     * numeric_br
     *
     * Verifica se é numérico, mas com virgula (,) no lugar de ponto (.)
     * @access	public
     * @param	string
     * @return	bool
     */
    public function numeric_br($str) {
        $CI = & get_instance();
        $CI->form_validation->set_message('numeric_br', 'O campo <strong>%s</strong> não contém um valor inteiro ou decimal válido.');

        return (bool) preg_match('/^[\-+]?[0-9]*\,?[0-9]+$/', $str);

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
        }
        else {

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

        $padrao = explode('/', $data);

        #return checkdate($padrao[1], $padrao[0], $padrao[2]);
        return (preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](1[89][0-9][0-9]|2[0189][0-9][0-9])$/", $data) &&
                checkdate($padrao[1], $padrao[0], $padrao[2]));

    }

    /**
     * valid_hour
     *
     * valida hora no pradrao brasileiro
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    function valid_hour($data) {
        $CI = & get_instance();
        $CI->form_validation->set_message('valid_hour', '<b>%s</b> inválida. Use uma hora válida no formato HH:MM');

        $padrao = explode(':', $data);
//exit($data . '<>' . preg_match("/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](1[89][0-9][0-9]|2[0189][0-9][0-9])$/", $data) . ' <<>> ' . checkdate('1', '1', '2000'));
        #return checkdate($padrao[1], $padrao[0], $padrao[2]);
        #return (preg_match("/^(?:([01]?\d|2[0-3]):([0-5]?\d))?$/", $data));
        #return 0;
        return (preg_match("/^(?:([01]?\d|2[0-3]):([0-5]?\d))?$/", $data) == 0) ? FALSE : TRUE;

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

        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $gen);

        $gen = ($gen) ? 'cadastrada' : 'cadastrado';
        $CI->form_validation->set_message('is_unique', '<b>%s</b> já ' . $gen . '.');

        if ($field == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');

        return isset($this->CI->db) ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0) : FALSE;

    }

    #FUNÇÃO NÃO FUNCIONAL, NÃO RETORNA VALOR, USAR A SEGUINTE
    #NÃO BASTA APENAS O CPF, GERALMENTE É PRECISO CONFRONTÁ-LO COM UM ID

    public function is_unique_cpf($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_cpf', '<b>%s</b> já cadastrado.');

        $str = str_replace('.', '', str_replace('-', '', $str));
        #$str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');
        #exit();

        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($this->CI->db) ? ($this->CI->db->limit(1)->get_where($table, array($field => $str))->num_rows() === 0) : FALSE;

        #$this->CI->db->limit(1)->get_where($table, array($field => $str));
        #echo $this->CI->db->last_query();
        #exit();

    }

    public function is_unique_by_id($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_by_id', '<b>%s</b> já cadastrado.');

        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);

        if ($field == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');

        return isset($this->CI->db) ? ($this->CI->db->limit(1)->query('SELECT ' . $field . ' FROM ' . $table . ' WHERE '
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
	
    public function is_unique_duplo($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_duplo', '<b>%s</b> já cadastrado.');

        sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field1, $field2, $str2);

        if ($field1 == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');

        return isset($this->CI->db) ? ($this->CI->db->limit(1)->query('SELECT ' . $field1 . ' FROM ' . $table . ' WHERE '
                        . $field1 . ' = "' . $str . '" AND ' . $field2 . ' = "' . $str2 . '"')->num_rows() === 0) : FALSE;

    }

    public function is_unique_duplo_multiplos_eventos($str, $field) {
        $CI = & get_instance();
        $CI->form_validation->set_message('is_unique_duplo_multiplos_eventos', '<b>%s</b> já cadastrado.');

        sscanf($field, '%[^.].%[^.].%[^.].%[^.].%[^.]', $table, $field1, $field2, $str2, $eventos);
        $eventos = explode("#", $eventos);

        unset($queryor);
        for ($i=1; $i <= $eventos[0]; $i++) {
            #echo '<br />'.$eventos[$i].'<br />';
            $queryor .= 'idSisevento_Evento = ' . $eventos[$i] . ' OR ';
        }
        $queryor = substr($queryor, 0, -4);

        if ($field1 == "Cpf")
            $str = ltrim(preg_replace("/[^0-9]/", "", $str), '0');

        return isset($this->CI->db) ? ($this->CI->db->limit(1)->query('
            SELECT
                ' . $field1 . '
            FROM
                ' . $table . '
            WHERE '
                . $field1 . ' = "' . $str . '" AND ('
                . $queryor .
            ');
        ')->num_rows() === 0) : FALSE;



    }

    public function confirma_email($email, $confirmacao) {
        $CI = & get_instance();
        $CI->form_validation->set_message('confirma_email', '<b>O E-mail e a confirmação do e-mail não são iguais.</b>');

        return ($email != $confirmacao) ? FALSE : TRUE;

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
	
    function valid_diretorio($data) {
        $CI = & get_instance();

        $CI->form_validation->set_message('valid_diretorio', '<b>%s</b> inválido. Este Nome de Site já Existe.');
		
		$pasta = '../' .$data. '';
			
        if (!is_dir($pasta)) {
            return FALSE;
        }
        else {
            return TRUE;
        }		

    }	
	
}
