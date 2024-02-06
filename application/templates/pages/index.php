<?php

$main_layout_content = '

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="'.$this->get_metadata('main_keywords').'" />
  <meta name="description" content="'.$this->get_metadata('main_description').'" />
  <meta name="author" content="'.$this->get_metadata('main_author').'" />
  <title>'.$this->get_metadata('main_title').'</title>
  <base href="'.$this->get_metadata('base_domain').'" target="_self" />
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="css/default.css" rel="stylesheet">
  <link href="css/'.$this->get_layout().'.css" rel="stylesheet">
  <link href="gallery/logo/favicon.ico" rel="icon">
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="js/'.$this->get_layout().'.js"></script>

</head>

<body>

  <nav class="navbar">
    <div class="container">
      <a class="navbar-brand" href="index.php">'.$this->get_logo().'<div class="title">'.$this->get_metadata('company_name').'</div></a>'.$this->get_navbar().'
    </div>
  </nav>
  
  <section class="content">
    '.$this->get_content().'
  </section>
  
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col">
          '.$this->get_socials().'
        </div>
        <div class="col">
          '.$this->get_footer().'
        </div>
      </div>
    </div>
  </footer>

</body>

</html>

';

?>

