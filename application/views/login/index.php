<?php
    /**
     * @var LoginController $this
     * @var CForm           $form
     */
    $this->pageTitle = Yii::t('application', 'Login');
    $this->breadcrumbs = array(
        $this->pageTitle,
    );
?>
<h1><?php echo $this->pageTitle; ?></h1>

<div class="form">
    <?php echo $form; ?>
</div>
