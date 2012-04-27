<?php

class Hotel_lineModel extends RelationModel {


	protected $_link = array(

		'hotel'=>array(

			'mapping_type'    =>BELONGS_TO,

			'class_name'=>'hotel',

			'foreign_key'=>'hotel_id',

		),
		
		'house'=>array(

			'mapping_type'    =>BELONGS_TO,

			'class_name'=>'house',

			'foreign_key'=>'house_id',

		),

	);


}
?>