<?php
    $this->pageTitle = Yii::t('application', 'New Form Example');
    $this->breadcrumbs = array(
        $this->pageTitle,
    );
?>

<h1><?php echo CHtml::encode($this->pageTitle); ?></h1>

<?php
    /**
     * Quick Form
     * ==========
     * A quick way of dumping the form HTML whilst your working on other parts is "echo $form;" but it doesn't have any
     * stucture or styling.
     */
?>

<!-- Form. -->
<?php
    $form->attributes = array(
        'class' => 'form-horizontal',
    );
    echo $form->renderBegin();
    $widget = $form->activeFormWidget;
?>

    <fieldset>

        <legend><?php echo CHtml::encode($form->title); ?></legend>

        <div class="control-group">
            <?php echo $widget->labelEx($form, 'firstinput', array('class' => 'control-label')); ?>
            <div class="control">
                <?php echo $widget->input($form, 'firstinput'); ?>
                <p class="help-inline">
                    <?php echo $widget->error($form, 'firstinput') ?: $widget->hint($form, 'firstinput'); ?>
                </p>
            </div>
        </div>

        <div class="control-group">
            <?php echo $widget->labelEx($form, 'secondinput', array('class' => 'control-label')); ?>
            <div class="control">
                <?php echo $widget->input($form, 'secondinput'); ?>
                <p class="help-inline">
                    <?php echo $widget->error($form, 'secondinput') ?: $widget->hint($form, 'secondinput'); ?>
                </p>
            </div>
        </div>

        <div class="form-actions">
            <div class="btn-group">
                <?php echo $widget->button($form, 'submit', array('class' => 'btn btn-primary')); ?>
            </div>
        </div>

    </fieldset>

<?php echo $form->renderEnd(); ?>
