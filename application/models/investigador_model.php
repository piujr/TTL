<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class investigador extends CI_Model{
	
  function __construct() {      
	parent::Model();
	$this->load->helper('url');				
  }
  
  function entry_insert(){
    $this->load->database();
	$data = array(
	          'title'=>$this->input->post('title'),
			  'author'=>$this->input->post('author'),
			  'publisher'=>$this->input->post('publisher'),
			  'year'=>$this->input->post('year'),
			  'available'=>$this->input->post('available'),
			  'summary'=>$this->input->post('summary'),
	        );
	$this->db->insert('books',$data);
  }
	
  function general(){
		
	$data['base']		= $this->config->item('base_url');
	$data['css']		= $this->config->item('css');			
	$data['webtitle']	= 'Book Collection';
	$data['websubtitle']= 'We collect all title of 
		                   books on the world';
	$data['webfooter']	= '© copyright by step 
		                   by step php tutorial';
						   
	$data['title']	 	= 'Title';
	$data['author']	 	= 'Author';
	$data['publisher']	= 'Publisher';				
	$data['year']	 	= 'Year';
	$data['years']	 	= array('2007'=>'2007',
	                            '2008'=>'2008',
								'2009'=>'2009');	
	$data['available']	= 'Available';	
	$data['summary']	= 'Summary';
	$data['forminput']	= 'Form Input';
	
	$data['ftitle']		= array('name'=>'title',
	                            'size'=>30
						  );
	$data['fauthor']	= array('name'=>'author',
	                            'size'=>30
						  );
	$data['fpublisher']	= array('name'=>'publisher',
	                            'size'=>30
						  );
    $data['favailable']	= array('name'=>'available',
	                            'value'=>'yes',
								'checked'=>TRUE
						  );
	$data['fsummary']	= array('name'=>'summary',
	                            'rows'=>5,
								'cols'=>30
						  );			
	return $data;	
  }
}
?>
