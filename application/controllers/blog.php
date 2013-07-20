<?php
class Blog extends CI_Controller {

 function __construct()
 {
  parent::__construct();
 }

 public function index()
 {
  echo 'Hello World！';
 }
 
 public function comments()
 {
  echo '看这里！';
 }
}
?>