<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Workstations.</title>
        <link rel='stylesheet' href='<?php echo Yii::app()->baseUrl; ?>/bootstrap/css/bootstrap.min.css' />
        <style>
            body{
                background-color: #E9EAED;
            }
        </style>
        <script type='text/javascript' src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
        <script type='text/javascript' src='<?php echo Yii::app()->baseUrl; ?>/bootstrap/js/bootstrap.min.js'></script>
    </head>
    <body>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo Yii::app()->homeUrl; ?>">Workstations.</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li id='registration' class="active">
                            <?php if(Yii::app()->user->isGuest): ?>
                                <a href="index.php">Registration</a>
                            <?php else: ?>
                                <a href="index.php">Manage Member</a>
                            <?php endif; ?>
                        </li>
                            <?php if(!Yii::app()->user->isGuest): ?>
                                <li id='checklist'>
                                    <a href="index.php?r=checklist/checklistmanagement">Check List</a>
                                </li>
                            <?php endif; ?>
                        <li id='about'>
                            <a href="index.php?r=site/page&amp;view=about">About</a>
                        </li>
                        <li id='contact'>
                            <a href="index.php?r=site/contact">Contact</a>
                        </li>
                        <!-- <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                Dropdown <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li role="separator" class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li> -->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <?php if(Yii::app()->user->isGuest): ?>

                        <form action='index.php?r=site/login' method='post' class="navbar-form navbar-left">
                            <div class="form-group">
                                <input name='username-login' type="text" class="form-control" placeholder="Username">
                            </div>
                            <div class='form-group'>
                                <input name='password-login' type='password' class='form-control' placeholder='Password'>
                            </div>
                            <button type="submit" class="btn btn-default">Login</button>
                        </form>

                        <?php else: ?>

                        <form action='index.php?r=logout' method='post' class='navbar-form navbar-left'>
                            <button type="submit" class="btn btn-default">Logout</button>
                        </form>

                        <?php endif; ?>

                        <!-- <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li> -->
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div>
        <?php echo $content; ?>
    </div>
    </body>

</html>
