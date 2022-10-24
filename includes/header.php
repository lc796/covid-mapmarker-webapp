<?php
  // Start session if the session hasn't already been started by another PHP file
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- If $title is defined before header is included, then it will echo the $title, such as 'PRN | Home' -->
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="resources/style.css">
</head>
<body>
    <div class="head-container">
        <h2 class="header">COVID - 19 Contact Tracing</h2>
    </div>
