<?php
class Ticket
{
	public $title;
	public $description ;
	public $category;
	public $priority;
	public $status;
	public $resolution;
	public $startDate;
	public $endDate;

	public function __construct($input_array = array())
	{
		$this->title = isset($input_array['Title']) ? $input_array['Title'] : null ;
		$this->description = isset($input_array['Description']) ? $input_array['Description'] : null ;
		$this->category = isset($input_array['Category']) ? $input_array['Category'] : null ;
		$this->priority = isset($input_array['Priority']) ? $input_array['Priority'] : null ;
		$this->status = isset($input_array['Status']) ? $input_array['Status'] : null ;
		$this->resolution = isset($input_array['Resolution']) ? $input_array['Resolution'] : null ;
		$this->endDate = isset($input_array['EndDate']) ? $input_array['EndDate'] : null ;
	}





}
?>