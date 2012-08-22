<html>
<head>
      <link rel="stylesheet" href="<?php echo APP_URL ?>/css/main.css" type="text/css" media="screen" charset="utf-8" />
</head>
<body>
<div id="main">
    <div id="menu">
        <ul>
            <li><a href="<?php echo APP_URL ?>">home</a></li>
            <li><a href="<?php echo APP_URL . '/forward' ?>">forward exemple</a></li>
            <li><a href="<?php echo APP_URL . '/en/index' ?>">language changing</a></li>
            <li><a href="<?php echo APP_URL . '/match/' ?>">match</a></li>
			<li><a href="<?php echo APP_URL . '/mymodule/' ?>">another module</a></li>
            <li><a href="<?php echo APP_URL . '/mymodule/exemple/valueofthefirstparam/123anothervalue' ?>">passing params exemple</a></li>
        </ul>
    </div>
    <div id="left">
lang : <?php echo $this->front->lang ?>
<h2><?php echo $this->title ?> main tpl!</h2>
<?php echo $this->content ?>
    </div>
    <div id="right">
        <p><?php $this->request(array('lang'=>$this->front->lang, 'module'=>'index', 'controller'=>'index', 'action'=>'requestfromtemplate' )); ?></p>
    </div>
    <div id="footer">
    <ul>
        <li><a href="<?php echo APP_URL . '/admin' ?>">admin</a></li>
        <li><a href="<?php echo APP_URL . '/mymodule/paginated/' ?>">paginated exemple</a></li>
    </ul>
    </div>
</div>
</body>
</html>
