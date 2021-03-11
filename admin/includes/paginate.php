<?php 



class Paginate
{

	public $current_page;
	public $items_per_page;
	public $items_total_count;


	public function __construct($page=1, $items_per_page=4, $items_total_count=0){

		$this->current_page = (int)$page;
		$this->items_per_page = (int)$items_per_page;
		$this->items_total_count = (int)$items_total_count;

	}  // End of Construct Method



	public function next() {

		return $this->current_page + 1; 

	} // End of Next Method


	public function previous() {
		
		return $this->current_page - 1;

	} // End of Previous Method



	public function page_total(){

		return ceil($this->items_total_count/$this->items_per_page); // Delimo ukupan broj itemsa sa brojem itemsa po stranic da 																	bi dobili ukupan broj stanica
															   // ceil() funkcija zaokruzuje broj kako bismo dobili ceo broj


	} // End of Page_totola Method



	public function has_previous(){

		return $this->previous() >= 1 ? true : false;  // ako je previous() metoda veca ili jednaka 1 onda je true(ima prethodna)


	} // End of Has_previous Method


	public function has_next(){

		return $this->next() <= $this->page_total() ? true : false;  // ako je next() metoda manja ili jednaka od page_totoal()																 onda je true(ima sledeca stranica)


	} // End of Has_next Method


	public function offset() {

		return ($this->current_page - 1) * $this->items_per_page;

	} // End of Offset Method















} // End of Paginate Class







 ?>