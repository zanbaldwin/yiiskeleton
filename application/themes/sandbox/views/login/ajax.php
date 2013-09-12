<?php
    /**
     * @var LoginController $this
     * @var CForm $form
     */
?>
<div class="modal-dialog">
    <div class="modal-content">

        <?php
            // Define a couple of settings that should be passed when creating the CActiveForm widget.
            $form->activeForm['htmlOptions'] = array(
                'class' => 'form-horizontal',
            );
            echo $form->renderBegin();
            $widget = $form->activeFormWidget;
        ?>

            <!-- Modal Header. -->
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                <h4 class="modal-title"><?php echo $form->title; ?></h4>
            </div>

            <!-- Modal Body. -->
            <div class="modal-body">

                <div class="form-group <?php if($widget->error($form->model, 'username')) echo 'has-error'; ?>">
                    <?php echo $widget->labelEx($form->model, 'username', array('class' => 'control-label col-xs-12 col-sm-3')); ?>
                    <div class="col-xs-12 col-sm-9">
                        <?php echo $widget->textField($form->model, 'username', array('class' => 'form-control')); ?>
                        <span class="help-block"><?php echo $form->elements['username']->hint; ?></span>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo $widget->labelEx($form->model, 'password', array('class' => 'control-label col-xs-12 col-sm-3')); ?>
                    <div class="col-xs-12 col-sm-9">
                        <?php echo $widget->passwordField($form->model, 'password', array('class' => 'form-control')); ?>
                        <span class="help-block"><?php echo $form->elements['password']->hint; ?></span>
                    </div>
                </div>

            </div>

            <!-- Modal Footer. -->
            <div class="modal-footer">
                <a class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('application', 'Close'); ?></a>
                <?php echo CHtml::submitButton(Yii::t('application', 'Login'), array('class' => 'btn btn-primary', 'name' => 'submit')); ?>
            </div>

        <?php $form->renderEnd(); ?>

    </div>
</div>
