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
        <!-- Document Meta Title. -->
        <title>
            <?php
                if(is_string($this->pageTitle) && $this->pageTitle) {
                    echo CHtml::encode($this->pageTitle) . ' &#8212; ';
                }
                echo CHtml::encode(Yii::app()->name);
            ?>
        </title>
        <!-- Bootstrap3 CSS Framework. -->
        <link href="<?php echo $assetUrl; ?>/css/bootstrap.css" rel="stylesheet" type="text/css" media="screen, projection" />
        <link href="<?php echo $assetUrl; ?>/css/main.css" rel="stylesheet" type="text/css" media="screen, projection" />
        <!-- Asynchronous Javascript Loader. -->
        <script type="text/javascript" src="<?php echo $assetUrl; ?>/js/head.load.js"></script>
    </head>

    <body>

        <?php if(Yii::app()->user->isGuest): ?>
            <!-- A placeholder for the AJAX login modal. -->
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
        <?php endif; ?>

        <div id="wrapper">

            <!-- Primary Navigation. -->
            <nav class="navbar navbar-default" role="navigation">
                <div class="container">
                    <!-- Branding, and collapse toggle (for better mobile display). -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only"><?php echo Yii::t('application', 'Toggle Navigation'); ?></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->name), Yii::app()->homeUrl, array('class' => 'navbar-brand')); ?>
                    </div>

                    <!-- Collect the nav links, forms, and other content so that they can be collapsable. -->
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <!-- Navigational Links. -->
                        <?php
                            $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array('label' => Yii::t('application', 'Home'), 'url' => Yii::app()->homeUrl),
                                ),
                                'activateItems' => true,
                                'activateParents' => true,
                                'activeCssClass' => 'active',
                                'encodeLabel' => false,
                                'htmlOptions' => array('class' => 'nav navbar-nav'),
                                'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
                            ));
                            if(Yii::app()->user->isGuest) {
                                // Detect if we're on the login page.
                                $loginPage = $this->id === 'login' && $this->action->id === 'index';
                                echo CHtml::link(
                                    Yii::t('application', 'Login'),
                                    // If we're on the login page, omit the URL so that clicking the login button doesn't
                                    // refresh the page.
                                    $loginPage ? null : Yii::app()->user->loginUrl,
                                    array(
                                        'class' => 'btn btn-default navbar-btn pull-right auth-action',
                                        // If we're on the login page, prevent the login modal from loading as we are
                                        // already displaying the login form.
                                        'data-toggle' => $loginPage ? false : 'modal',
                                        'data-target' => '#loginModal',
                                    )
                                );
                            }
                            else {
                                echo CHtml::link(
                                    Yii::t('application', 'Logout'),
                                    array('/logout'),
                                    array('class' => 'btn btn-default navbar-btn pull-right auth-action')
                                );
                                echo CHtml::tag(
                                    'p',
                                    array('class' => 'navbar-text pull-right'),
                                    Yii::t(
                                        'application',
                                        'Signed in as {displayname}',
                                        array(
                                            '{displayname}' => CHtml::link(
                                                Yii::app()->user->displayName,
                                                array('/profile'),
                                                array ('class' => 'navbar-link')
                                            ),
                                        )
                                    )
                                );
                            }
                        ?>
                    </div>
                </div>
            </nav>


            <div class="container" id="page">

                <!-- Breadcrumbs. -->
                <?php
                    if(isset($this->breadcrumbs) && is_array($this->breadcrumbs) && !empty($this->breadcrumbs)) {
                        $this->widget('zii.widgets.CBreadcrumbs', array(
                            'activeLinkTemplate' => CHtml::tag('li', array(), CHtml::link('{label}', '{url}')),
                            'links' => $this->breadcrumbs,
                            'encodeLabel' => false,
                            'homeLink' => CHtml::tag('li', array(), CHtml::link(Yii::t('zii', 'Home'), Yii::app()->homeUrl)),
                            'htmlOptions' => array('class' => 'breadcrumb'),
                            'inactiveLinkTemplate' => CHtml::tag('li', array('class' => 'active'), '{label}'),
                            'separator' => '',
                            'tagName' => 'ol',
                        ));
                    }
                ?>

                <?php echo $content; ?>

            </div>

            <div id="sticky-footer-push"></div>

        </div>

        <div id="footer">
            <div class="container">
                <p>
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
                </p>
                <p>
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
                </p>
                <p>
                    <?php echo Yii::powered(); ?>
                </p>
            </div>
        </div>

        <!-- Asynchronously load our interactive scripts right at the end of the page. -->
        <script type="text/javascript">
            //<![CDATA[
                // Load Application Scripts.
                head.js(
                    '<?php echo $assetUrl; ?>/js/jquery.js',
                    '<?php echo $assetUrl; ?>/js/bootstrap.js',
                    '<?php echo $assetUrl; ?>/js/jsx.js',
                    '<?php echo $assetUrl; ?>/js/react.js',
                    '<?php echo $assetUrl; ?>/js/main.js'
                );
                // Load the Google Analytics interactive scripts.
                (function(i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=
                    1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;
                    m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
                // Register the current website with Google Analytics.
                ga('create', 'UA-00000-X', 'darsyn.co.uk');
                // Send pageview statistics.
                ga('send', 'pageview');
            //]]>
        </script>

    </body>

</html>
