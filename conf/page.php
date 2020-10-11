<?php
if(isset($_GET['page'])){
  $page = $_GET['page'];
switch ($page) {
  case 'user':
    include 'pages/user.php';
    break;
  case 'employee':
    include 'pages/employee.php';
    break;
  case 'company':
    include 'pages/company.php';
    break;
  case 'menu':
    include 'pages/menu.php';
    break; 
  case 'role':
    include 'pages/role.php';
    break;
  case 'menu_access':
    include 'pages/menu_access.php';
    break;
  case 'unit':
    include 'pages/unit.php';
    break;
   case 'souvenir':
    include 'pages/souvenir.php';
    break;
  case 'product':
    include 'pages/product.php';
    break;
  }
}else{
    include "pages/beranda.php";
  }
?>