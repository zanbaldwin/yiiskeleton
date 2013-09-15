<?php
    /**
     * @var Controller $this
     */
    $assetUrl = Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/assets');
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf8" />
        <!-- Blueprint CSS Framework. -->
        <link href="<?php echo $assetUrl; ?>/css/screen.css" rel="stylesheet" type="text/css" media="screen, projection" />
        <link href="<?php echo $assetUrl; ?>/css/print.css" rel="stylesheet" type="text/css" media="print" />
        <!--[if lt IE 8]>
            <link href="<?php echo $assetUrl; ?>/css/ie.css" rel="stylesheet" type="text/css" media="screen, projection" />
        <![endif]-->
        <link href="<?php echo $assetUrl; ?>/css/main.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo $assetUrl; ?>/css/form.css" rel="stylesheet" type="text/css" media="all" />
        <!-- Document Meta Title. -->
        <title>
            <?php
                if(is_string($this->pageTitle) && $this->pageTitle) {
                    echo CHtml::encode($this->pageTitle) . ' &#8212; ';
                }
                echo CHtml::encode(Yii::app()->name);
            ?>
        </title>
    </head>

    <body>
        <div class="container" id="page">

            <div id="header">
                <div id="logo">
                    <?php echo CHtml::encode(Yii::app()->name); ?>
                </div>
            </div>

            <div id="mainmenu">
                <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'items' => array(
                            array('label' => Yii::t('application', 'Home'), 'url' => Yii::app()->homeUrl),
                            array('label' => Yii::t('application', 'Login'), 'url' => array('/login'), 'visible' => Yii::app()->user->isGuest),
                            array(
                                'label' => Yii::t(
                                    'application',
                                    'Logout ({name})',
                                    array('{name}' => Yii::app()->user->displayName)
                                ),
                                'url' => array('/logout'),
                                'visible' => !Yii::app()->user->isGuest,
                            ),
                        ),
                    ));
                ?>
            </div>
            <!-- Breadcrumbs. -->
            <?php
                if(isset($this->breadcrumbs) && is_array($this->breadcrumbs) && !empty($this->breadcrumbs)) {
                    $this->widget('zii.widgets.CBreadcrumbs', array(
                        'links' => $this->breadcrumbs,
                    ));
                }
            ?>

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
            </div>

        </div>
    </body>

</html>
