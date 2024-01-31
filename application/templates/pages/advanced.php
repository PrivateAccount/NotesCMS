<?php

$main_layout_content = '

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="keywords" content="'.$this->get_metadata('main_keywords').'" />
  <meta name="description" content="'.$this->get_metadata('main_description').'" />
  <meta name="author" content="'.$this->get_metadata('main_author').'" />
  <title>'.$this->get_metadata('main_title').'</title>
  <base href="'.$this->get_metadata('base_domain').'" target="_self" />
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <link href="css/landing-page.min.css" rel="stylesheet">
  <link href="css/default.css" rel="stylesheet">
  <link href="css/'.$this->get_layout().'.css" rel="stylesheet">
  <link href="gallery/logo/favicon.ico" rel="icon">
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="js/'.$this->get_layout().'.js"></script>

</head>

<body>

  <nav class="navbar navbar-light bg-grey static-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">'.$this->get_logo().' &nbsp; '.$this->get_metadata('company_name').'</a>'.$this->get_navbar().'
    </div>
  </nav>
  
  <section class="content bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          '.$this->get_content().'
        </div>
      </div>
    </div>
  </section>
  
  <footer class="footer bg-grey">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          '.$this->get_footer().'
        </div>
        <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
          '.$this->get_socials().'
        </div>
      </div>
    </div>
  </footer>

</body>

</html>

';

?>

