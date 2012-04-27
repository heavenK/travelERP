<?php

class SignupModel extends RelationModel {


	protected $_link = array(

		'hotel_date'=>array(

			'mapping_type'    =>BELONGS_TO,

			'class_name'=>'hlcontent',

			'foreign_key'=>'pid',

		),

	);


}
?>