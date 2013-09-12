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

<?php
    // Define a couple of settings that should be passed when creating the CActiveForm widget.
    $form->activeForm['htmlOptions'] = array(
        'class' => 'form-horizontal',
    );
    echo $form->renderBegin();
    $widget = $form->activeFormWidget;
?>

    <fieldset>

        <legend><?php echo $form->title; ?></legend>

        <div class="form-group <?php if($widget->error($form->model, 'username')) echo 'has-error'; ?>">
            <?php echo $widget->labelEx($form->model, 'username', array('class' => 'control-label col-xs-12 col-sm-2')); ?>
            <div class="col-xs-12 col-sm-8 col-md-6">
                <?php echo $widget->input($form, 'username', array('class' => 'form-control')); ?>
                <span class="help-block">
                    <?php echo $widget->error($form->model, 'username') ?: $form->elements['username']->hint; ?>
                </span>
            </div>
        </div>

        <div class="form-group <?php if($widget->error($form->model, 'password')) echo 'has-error'; ?>">
            <?php echo $widget->labelEx($form->model, 'password', array('class' => 'control-label col-xs-12 col-sm-2')); ?>
            <div class="col-xs-12 col-sm-8 col-md-6">
                <?php echo $widget->input($form, 'password', array('class' => 'form-control')); ?>
                <span class="help-block">
                    <?php echo $widget->error($form->model, 'password') ?: $form->elements['password']->hint; ?>
                </span>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-2"></div>
            <div class="col-xs-12 col-sm-8 col-md-6">
                <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-primary')); ?>
            </div>
        </div>

    </fieldset>

<?php $form->renderEnd(); ?>
