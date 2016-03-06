<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('set_success_message')) {
	/**
	 * 一時データに成功メッセージを保存
	 * @param string $message
	 */
	function set_success_message($message) {
		$CI =& get_instance();
		$CI->session->success_message = $message;
		$CI->session->mark_as_flash('success_message');
	}
}

if (!function_exists('get_success_message')) {
	/**
	 * 一時データに保存した成功メッセージを取得
	 * @return string
	 */
	function get_success_message()
	{
		$CI =& get_instance();
		return $CI->session->flashdata('success_message');
	}
}

if (!function_exists('set_danger_message')) {
	/**
	 * 一時データに失敗メッセージを保存
	 * @param string $message
	 */
	function set_danger_message($message) {
		$CI =& get_instance();
		$CI->session->danger_message = $message;
		$CI->session->mark_as_flash('danger_message');
	}
}
if (!function_exists('get_danger_message')) {
	/**
	 * 一時データに保存した失敗メッセージを取得
	 * @return string
	 */
	function get_danger_message()
	{
		$CI =& get_instance();
		return $CI->session->flashdata('danger_message');
	}
}

if (!function_exists('set_info_message')) {
	/**
	 * 一時データにその他メッセージを保存
	 * @param string $message
	 */
	function set_info_message($message) {
		$CI =& get_instance();
		$CI->session->info_message = $message;
		$CI->session->mark_as_flash('info_message');
	}
}

if (!function_exists('get_info_message')) {
	/**
	 * 一時データに保存したその他メッセージを取得
	 * @return string
	 */
	function get_info_message()
	{
		$CI =& get_instance();
		return $CI->session->flashdata('info_message');
	}
}