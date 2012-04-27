<?php

class Ticket_signupModel extends RelationModel {


	protected $_link = array(

		'ticket_date'=>array(

			'mapping_type'    =>BELONGS_TO,

			'class_name'=>'ticket_date',

			'foreign_key'=>'pid',

		),

	);


}
?>