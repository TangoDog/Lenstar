<?php
/* @var $this PatientsController */
/* @var $model Patients */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'patients-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ChartID'); ?>
		<?php echo $form->textField($model,'ChartID',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'ChartID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'LastName'); ?>
		<?php echo $form->textField($model,'LastName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'LastName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'FirstName'); ?>
		<?php echo $form->textField($model,'FirstName',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'FirstName'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'MI'); ?>
		<?php echo $form->textField($model,'MI',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'MI'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'BirthDate'); ?>
		<?php echo $form->textField($model,'BirthDate'); ?>
		<?php echo $form->error($model,'BirthDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Sex'); ?>
		<?php echo $form->textField($model,'Sex',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'Sex'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Ethnicity'); ?>
		<?php echo $form->textField($model,'Ethnicity',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'Ethnicity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'EntryDate'); ?>
		<?php echo $form->textField($model,'EntryDate'); ?>
		<?php echo $form->error($model,'EntryDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Surgeon'); ?>
		<?php echo $form->textField($model,'Surgeon'); ?>
		<?php echo $form->error($model,'Surgeon'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Office'); ?>
		<?php echo $form->textField($model,'Office'); ?>
		<?php echo $form->error($model,'Office'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Phone'); ?>
		<?php echo $form->textField($model,'Phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Referral'); ?>
		<?php echo $form->textField($model,'Referral'); ?>
		<?php echo $form->error($model,'Referral'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CalcRightEye'); ?>
		<?php echo $form->textField($model,'CalcRightEye'); ?>
		<?php echo $form->error($model,'CalcRightEye'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CalcLeftEye'); ?>
		<?php echo $form->textField($model,'CalcLeftEye'); ?>
		<?php echo $form->error($model,'CalcLeftEye'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dbowner'); ?>
		<?php echo $form->textField($model,'dbowner'); ?>
		<?php echo $form->error($model,'dbowner'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->