<?php

return [

	/**
	 * api key provided by ominware
	 */	
	'api_key' =>  '4ec29e40-71aa-4414-95b2-e9e1788790b4',//'f14e50fd-82f0-4ce0-bd4e-de924908d4fg',//'480e855e-7232-42d6-9ad7-4f5560b5f648', 

		/**
	 * request encryption key provided by ominware
	 */	
	'req_encryption_key' => '49f86320-e29f-11e8-a4f3-43a0cb11', //'49f86320-e29f-11e8-a4f3-43a0cb10',
			/**
	 * request decryption key provided by ominware
	 */	
	'res_decryption_key' => '49f86320-e29f-11e8-a4f3-43a0cb13',//'49f86320-e29f-11e8-a4f3-43a0cb12',
	/**
	 * salt value provided by ominware
	 */
	'salt' => 'f7d0872d0613f82fd38cb9c50b6cbdc7fb31c7c0',//'3f43kkk0689cb8446cbe6b9d99a418e051c3e321',//'d8dec6875271ca8050490ceb03f9e691a75cbd66',
	
	/**
	 *  omniware paymnet gateway return url
	 */
	'return_url' => '/response',

	/**
	 * api url for paymnetrequest
	 */
	'api_url' => 'https://uatpgbiz2.omniware.in/v2/paymentrequest',
	/**
	 * api url for paymnet refund
	 */
	"api_refund" => 'https://uatpgbiz2.omniware.in/v2/refundrequest',

	/**
	 * mode type , either TEST or LIVE
	 */
	
	'mode' => 'TEST',

	/**
	 * default value for payment parameters
	 */
	'default_parameters' => [
		/**
		 * currency value should refer from the API documnte 
		 */
		'currency'       => 'INR',
		/**
		 * default description field which is mendatory
		 */
		'description'    => 'Paymnet processed by ominiware',
		/**
		 * name field is mandatory
		 */
		'name'           => 'User Name',
		/**
		 * email field is mandatory
		 */
		'email'          => 'uaser@mail.com',
		/**
		 * phone field is mandatory
		 */
		'phone'          => '9650233010',
		/**
		 * address field 1
		 */
		'address_line_1' => '',
		/**
		 * address field 2
		 */
		'address_line_2' => '',
		/**
		 * city field is mandatory
		 */
		'city'           => 'Bihar',
		/**
		 * state field
		 */
		'state'          => '',
		/**
		 * country value should be equal to 'IND'
		 */
		'country'        => 'INR',
		/**
		 * zip code field is mandatory
		 */
		'zip_code'       => '842001',
		/**
		 * user defined fields
		 */
		'udf1'           => '',
		'udf2'           => '',
		'udf3'           => '',
		'udf4'           => '',
		'udf5'           => '',
	],
];