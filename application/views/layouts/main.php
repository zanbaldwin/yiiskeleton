<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->assetManager->publish(Yii::getPathOfAlias('themes') . '/classic/css/screen.css'); ?>" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->assetManager->publish(Yii::getPathOfAlias('themes') . '/classic/css/print.css'); ?>" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->assetManager->publish(Yii::getPathOfAlias('themes') . '/classic/css/ie.css'); ?>" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->assetManager->publish(Yii::getPathOfAlias('themes') . '/classic/css/main.css'); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->assetManager->publish(Yii::getPathOfAlias('themes') . '/classic/css/form.css'); ?>" />
    <style type="text/css">
        #mainmenu {
            background: #fff url("<?php echo Yii::app()->assetManager->publish(Yii::getPathOfAlias('themes') . '/classic/css/bg.gif'); ?>") repeat-x left top;
        }
    </style>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>Yii::t('application', 'Home'), 'url'=>Yii::app()->homeUrl),
				array('label'=>Yii::t('application', 'Login'), 'url'=>array('/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>Yii::t('application', 'Logout ({name})', array('{name}' => Yii::app()->user->displayName)), 'url'=>array('/logout'), 'visible'=>!Yii::app()->user->isGuest),
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
        <?php
            echo Yii::t(
                'application',
                'Copyright &copy; {year} by {company}.',
                array(
                    '{year}' => date('Y'),
                    '{company}' => Yii::app()->name,
                )
            );
        ?>
        <?php
            echo Yii::t('application', 'All rights reserved.');
        ?>
        <br />
        <?php
            $languages = array(
                'en' => 'English',
                'cy' => 'Cymraeg',
            );
            foreach($languages as $code => &$lang) {
                $lang = CHtml::link($lang, array('/language', 'lang' => $code));
            }
            echo implode(' &middot; ', $languages);
        ?>
        <br />
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
