<?php
/* @var $this XmlUploadController */
/* @var $data XmlUpload */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('xmlFile')); ?>:</b>
	<?php echo CHtml::encode($data->xmlFile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fastName')); ?>:</b>
	<?php echo CHtml::encode($data->fastName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firstName')); ?>:</b>
	<?php echo CHtml::encode($data->firstName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mi')); ?>:</b>
	<?php echo CHtml::encode($data->mi); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('birthDate')); ?>:</b>
	<?php echo CHtml::encode($data->birthDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chartID')); ?>:</b>
	<?php echo CHtml::encode($data->chartID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ethnicity')); ?>:</b>
	<?php echo CHtml::encode($data->ethnicity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('thisUser')); ?>:</b>
	<?php echo CHtml::encode($data->thisUser); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('thisPwd')); ?>:</b>
	<?php echo CHtml::encode($data->thisPwd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('technician')); ?>:</b>
	<?php echo CHtml::encode($data->technician); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('surgeon')); ?>:</b>
	<?php echo CHtml::encode($data->surgeon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dbowner')); ?>:</b>
	<?php echo CHtml::encode($data->dbowner); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('office')); ?>:</b>
	<?php echo CHtml::encode($data->office); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('preop')); ?>:</b>
	<?php echo CHtml::encode($data->preop); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('postop')); ?>:</b>
	<?php echo CHtml::encode($data->postop); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	*/ ?>

</div>