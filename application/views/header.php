<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Timesheet</title>
    <meta name="description" content="Timesheet">
    <meta name="author" content="Bruno Santos">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php echo HTML::js(); ?>
    
    <!-- Le styles -->
    <?php echo HTML::css(); ?>
    <style type="text/css">
      body {
        padding-top: 60px;
      }
      
      .container > footer p {
        text-align: center; /* center align it with the container */
      }
      
      /* The white background content wrapper */
      .content {
        background-color: #fff;
        padding: 20px;
        margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
        -webkit-border-radius: 0 0 6px 6px;
           -moz-border-radius: 0 0 6px 6px;
                border-radius: 0 0 6px 6px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

      /* Page header tweaks */
      .page-header {
        background-color: #f5f5f5;
        padding: 20px 20px 10px;
        margin: -20px -20px 20px;
      }

      .topbar .btn {
        border: 0;
      }

    </style>

    <!-- Le fav and touch icons -->
    <!--link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png"-->
  </head>

  <body>
    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="<?=BASE_PATH?>">Timesheet</a>
          <?php if (Helper::is_logged_in()): ?>
            <?php require(ROOT . DS . 'application' . DS . 'views' . DS . '_menu_' . Session::get('type') . '.php'); ?>
          <?php endif ?>
        </div>
      </div>
    </div>

    <div class="container">