<?php
/* @var $this XmlUploadController */
/* @var $model XmlUpload */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'xml-upload-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'xmlFile'); ?>
		<?php echo $form->textArea($model,'xmlFile',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'xmlFile'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastName'); ?>
		<?php echo $form->textField($model,'lastName',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'lastName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'firstName'); ?>
		<?php echo $form->textField($model,'firstName',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'firstName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mi'); ?>
		<?php echo $form->textField($model,'mi',array('size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'mi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'birthDate'); ?>
		<?php echo $form->textField($model,'birthDate'); ?>
		<?php echo $form->error($model,'birthDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'chartID'); ?>
		<?php echo $form->textField($model,'chartID',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'chartID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ethnicity'); ?>
		<?php echo $form->textField($model,'ethnicity',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'ethnicity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'thisUser'); ?>
		<?php echo $form->textField($model,'thisUser',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'thisUser'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'thisPwd'); ?>
		<?php echo $form->textField($model,'thisPwd',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'thisPwd'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'technician'); ?>
		<?php echo $form->textField($model,'technician'); ?>
		<?php echo $form->error($model,'technician'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'surgeon'); ?>
		<?php echo $form->textField($model,'surgeon'); ?>
		<?php echo $form->error($model,'surgeon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dbowner'); ?>
		<?php echo $form->textField($model,'dbowner'); ?>
		<?php echo $form->error($model,'dbowner'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'office'); ?>
		<?php echo $form->textField($model,'office'); ?>
		<?php echo $form->error($model,'office'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'preop'); ?>
		<?php echo $form->textArea($model,'preop',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'preop'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'postop'); ?>
		<?php echo $form->textArea($model,'postop',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'postop'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->