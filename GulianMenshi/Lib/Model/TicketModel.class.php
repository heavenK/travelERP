<?php

class TicketModel extends RelationModel {

	protected $_link = array(

		'price'=>array(

			'mapping_type'    =>HAS_ONE,

			'class_name'=>'ticket_price',

			'foreign_key'=>'pid',

		),
	);


}
?>