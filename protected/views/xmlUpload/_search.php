<?php
/* @var $this XmlUploadController */
/* @var $model XmlUpload */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'xmlFile'); ?>
		<?php echo $form->textArea($model,'xmlFile',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fastName'); ?>
		<?php echo $form->textField($model,'fastName',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'firstName'); ?>
		<?php echo $form->textField($model,'firstName',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mi'); ?>
		<?php echo $form->textField($model,'mi',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'birthDate'); ?>
		<?php echo $form->textField($model,'birthDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'chartID'); ?>
		<?php echo $form->textField($model,'chartID',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ethnicity'); ?>
		<?php echo $form->textField($model,'ethnicity',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'thisUser'); ?>
		<?php echo $form->textField($model,'thisUser',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'thisPwd'); ?>
		<?php echo $form->textField($model,'thisPwd',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'technician'); ?>
		<?php echo $form->textField($model,'technician'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'surgeon'); ?>
		<?php echo $form->textField($model,'surgeon'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dbowner'); ?>
		<?php echo $form->textField($model,'dbowner'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'office'); ?>
		<?php echo $form->textField($model,'office'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'preop'); ?>
		<?php echo $form->textArea($model,'preop',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'postop'); ?>
		<?php echo $form->textArea($model,'postop',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->