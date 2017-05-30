<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('common.css') ?>
		<?= $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
		<script
			src="https://code.jquery.com/jquery-3.2.1.min.js"
			integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
			crossorigin="anonymous"></script>
		<?= $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js') ?>
	<?= $this->Html->script('common.js') ?>
</head>
<body>
	<div class="navbar navbar-inverse">
	  <div class="container">
	    <div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav1">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="btn-group">
					<a class="navbar-brand" rel="home" href="#" title="Title">Events <span class="glyphicon glyphicon-fire"></span> beta v0.01</a>
				</div>
			</div>
	    <div class="collapse navbar-collapse" id="nav1">
				<ul class="nav navbar-nav navbar-right">
					<?php
					$loggedOut = empty($authUser) ? "style='display:none;'" : "";
					$loggedIn = !empty($authUser) ? "style='display:none;'" : "";
					?>
					<li class="authLoggedOut" <?= $loggedIn; ?>><a href="#" data-toggle="collapse" data-target="#nav2"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
					<!-- <li class="authLoggedIn navbar-text" <?= $loggedOut; ?>>Welcome, <span class="authUsername"><?= $authUser["username"];?></span> | </li> -->
					<li class="authLoggedIn" <?= $loggedOut; ?>><a href="#" class="ajaxLogout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		    </ul>
	    </div>
	    <div class="collapse text-center" id="nav2">
	      <form class="navbar-form form-inline" id="menuLoginForm">
					<input class="form-control typeahead" placeholder="Email: " name="username" id="username" type="text">
					<input class="form-control typeahead" placeholder="Password: " name="password" id="password" type="password">
					<button class="btn btn-default" type="submit">Log me in!</button>
				</form>	
	    </div>
	  </div>
	</div>
	<div class="container">
		<div class="collapse alert alert-info alert-dismissable text-center" id="js-alert">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong><span id="alert-title"></span></strong> <span id="alert-message"></span>
		</div>
	</div>
	<?= $this->Flash->render() ?>
	<?= $this->fetch('content') ?>
</body>
</html>
