<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Timesheet</title>
    <meta name="description" content="">
    <meta name="author" content="">

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

      /* Styles you shouldn't keep as they are for displaying this base example only */
      /*.content .span10,
      .content .span4 {
        min-height: 500px;
      }*/
      /* Give a quick and non-cross-browser friendly divider */
      /*.content .span4 {
        margin-left: 0;
        padding-left: 19px;
        border-left: 1px solid #eee;
      }*/

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
            <ul class="nav">
              <li <?=$this->_controller == 'Clock' ? 'class="active"' : ''?>><a href="<?=BASE_PATH?>/clock">Clock In/Out</a></li>
              <li <?=$this->_controller == 'Timesheet' ? 'class="active"' : ''?>><a href="<?=BASE_PATH?>/timesheet">Timesheet</a></li>
              <li <?=$this->_controller == 'Reports' ? 'class="active"' : ''?>><a href="<?=BASE_PATH?>/reports">Reports</a></li>
            </ul>
            <ul class="nav secondary-nav">
              <li class="dropdown" data-dropdown="dropdown">
                <a href="javascript:;" class="dropdown-toggle"><?=Session::get('name')?></a>
                <ul class="dropdown-menu">
                  <li><a href="<?=BASE_PATH?>/settings">Settings</a></li>
                  <li class="divider"></li>
                  <li><a href="<?=BASE_PATH?>/pages/logout">Logout</a></li>
                </ul>
              </li>
            </ul>
          <?php endif ?>
        </div>
      </div>
    </div>

    <div class="container">