<?php
/**
 * Created by PhpStorm.
 * User: Mercy Babatunde
 * Date: 8/4/2019
 * Time: 9:39 PM
 */

namespace App\Lib;


use Carbon\Carbon;

class BackUp
{


	private $db_username;
	private $db_password;
	private $databases;
	private $filename;

	public function __construct()
	{
		$this->db_username = config('backup.mysql.username');
		$this->db_password = config('backup.mysql.password');
		$this->databases = implode(" ", config('backup.mysql.databases'));
		$this->filename = config('backup.mysql.filename_prefix') .
			Carbon::now()->format(config('backup.mysql.filename_pattern')) .
			config('backup.mysql.filename_suffix') .
			".sql";
	}


	public function getUsername()
	{
		return $this->db_username;
	}


	public function getPassword()
	{
		return $this->db_password;
	}


	public function getDatabases()
	{
		return '--databases ' .$this->databases;
	}


	public function getFilename()
	{
		return $this->filename;
	}

	public function filenameAndPath()
	{
		return $this->setDestination().$this->getFilename();
	}

	private function setDestination()
	{
		$backup_dir = storage_path(config('backup.mysql.destination_dir'));
		is_dir($backup_dir) ?: mkdir($backup_dir, true);
		return $backup_dir.'/';
	}



}