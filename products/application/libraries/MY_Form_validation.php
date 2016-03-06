<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * form_validation拡張
 */
class MY_Form_validation extends CI_Form_validation
{
	public function get_fields()
	{
		return !empty($this->_field_data) ? array_keys($this->_field_data) : [];
	}
}
