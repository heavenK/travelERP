<?php

class Ticket_dateModel extends RelationModel {


	protected $_link = array(

		'ticket'=>array(

			'mapping_type'    =>BELONGS_TO,

			'class_name'=>'ticket',

			'foreign_key'=>'pid',
			
		),
	);


}
?>