<?php

class HouseModel extends RelationModel {


	protected $_link = array(

		'hotel'=>array(

			'mapping_type'    =>BELONGS_TO,

			'class_name'=>'hotel',

			'foreign_key'=>'pid',

		),

	);


}
?>