<?php
$data['title']=$title;
$this->load->view('plantillas/header',$data);
$this->load->view($mainContent);
$this->load->view('plantillas/footer');
?>
