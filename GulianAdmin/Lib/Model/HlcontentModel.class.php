<?php

class HlcontentModel extends RelationModel {


	protected $_link = array(

		'hotel_line'=>array(

			'mapping_type'    =>BELONGS_TO,

			'class_name'=>'hotel_line',

			'foreign_key'=>'hl_id',

		),
		
		'house'=>array(

			'mapping_type'    =>BELONGS_TO,

			'class_name'=>'house',

			'foreign_key'=>'hl_id',

		),
		
		'hotel'=>array(

			'mapping_type'    =>BELONGS_TO,

			'class_name'=>'hotel',

			'foreign_key'=>'h_id',

		),
		

	);


}
?>