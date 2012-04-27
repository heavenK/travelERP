<?php

class ScenicspotModel extends RelationModel {


	protected $_link = array(

		'city'=>array(

			'mapping_type'    =>BELONGS_TO,

			'class_name'=>'Liandong',

			'foreign_key'=>'pid',

		),

	);


}
?>