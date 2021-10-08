<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Globals {
	
	public static function bulan($key='') {
		$bulan_array = [
			['id' => '01', 'nama' => 'Januari'],
			['id' => '02', 'nama' => 'Februari'],
			['id' => '03', 'nama' => 'Maret'],
			['id' => '04', 'nama' => 'April'],
			['id' => '05', 'nama' => 'Mei'],
			['id' => '06', 'nama' => 'Juni'],
			['id' => '07', 'nama' => 'Juli'],
			['id' => '08', 'nama' => 'Agustus'],
			['id' => '09', 'nama' => 'September'],
			['id' => '10', 'nama' => 'Oktober'],
			['id' => '11', 'nama' => 'November'],
			['id' => '12', 'nama' => 'Desember'],
		];
		
		if( $key ) {
			foreach($bulan_array as $bulan) {
				if($key == $bulan['id'] || $key == $bulan['nama'])
				return $bulan;
			}
			return [];
		} else {
			return $bulan_array;
		}
	}
	
	public static function apikey() {
		return 'secretkey';
	}
	
	public static function restServer() {
		return 'http://localhost/request-server/';
	}
	
	public static function emailSender() {
		return 'request@data.hrwconsulting.id';
	}
	
	public static function passSender() {
		return 'KGV7Re8HPPmE';
	}
	
	// private static $authenticatedMemberId = null;
	// private static $initialized = false;
	
	// private static function initialize() {
	// 	if (self::$initialized)
	// 		return;
	// 	self::$authenticatedMemberId = null;
	// 	self::$initialized = true;
	// }
	
	// public static function setAuthenticatedMemeberId($memberId) {
	// 	self::initialize();
	// 	self::$authenticatedMemberId = $memberId;
	// }
	
	// public static function authenticatedMemeberId() {
	// 	self::initialize();
	// 	return self::$authenticatedMemberId;
	// }
}