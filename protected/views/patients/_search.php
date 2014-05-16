<?php
/* @var $this PatientsController */
/* @var $model Patients */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'ID'); ?>
		<?php echo $form->textField($model,'ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ChartID'); ?>
		<?php echo $form->textField($model,'ChartID',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'LastName'); ?>
		<?php echo $form->textField($model,'LastName',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FirstName'); ?>
		<?php echo $form->textField($model,'FirstName',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MI'); ?>
		<?php echo $form->textField($model,'MI',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'BirthDate'); ?>
		<?php echo $form->textField($model,'BirthDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Sex'); ?>
		<?php echo $form->textField($model,'Sex',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Ethnicity'); ?>
		<?php echo $form->textField($model,'Ethnicity',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'EntryDate'); ?>
		<?php echo $form->textField($model,'EntryDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Surgeon'); ?>
		<?php echo $form->textField($model,'Surgeon'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Office'); ?>
		<?php echo $form->textField($model,'Office'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Phone'); ?>
		<?php echo $form->textField($model,'Phone',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Referral'); ?>
		<?php echo $form->textField($model,'Referral'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CalcRightEye'); ?>
		<?php echo $form->textField($model,'CalcRightEye'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CalcLeftEye'); ?>
		<?php echo $form->textField($model,'CalcLeftEye'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dbowner'); ?>
		<?php echo $form->textField($model,'dbowner'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->