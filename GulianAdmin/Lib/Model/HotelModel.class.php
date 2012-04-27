<?php

class HotelModel extends RelationModel {


	protected $_link = array(

		'liandong'=>array(

			'mapping_type'    =>BELONGS_TO,

			'class_name'=>'liandong',

			'foreign_key'=>'city',

		),

	);


}
?>