<?php


return [


	'mysql' => [

		'databases' => [

			'homestead',
		],

		'username' => env('DB_USERNAME'),

		'password' => env('DB_PASSWORD'),

		'filename_pattern' => 'Y_m_d__H_i_s',

		'filename_prefix' => 'backup_',

		'filename_suffix' => '_dump',


		/*
	    |--------------------------------------------------------------------------
	    | Destination Directory
	    |--------------------------------------------------------------------------
	    |
	    | This is the directory where the backup file is saved.
		| This is naturally the storage folder.
	    |
	    */
		'destination_dir' => 'backups'


	]
];