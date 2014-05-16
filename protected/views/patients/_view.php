<?php
/* @var $this PatientsController */
/* @var $data Patients */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('ID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->ID), array('view', 'id'=>$data->ID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ChartID')); ?>:</b>
	<?php echo CHtml::encode($data->ChartID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('LastName')); ?>:</b>
	<?php echo CHtml::encode($data->LastName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('FirstName')); ?>:</b>
	<?php echo CHtml::encode($data->FirstName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MI')); ?>:</b>
	<?php echo CHtml::encode($data->MI); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('BirthDate')); ?>:</b>
	<?php echo CHtml::encode($data->BirthDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sex')); ?>:</b>
	<?php echo CHtml::encode($data->Sex); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Ethnicity')); ?>:</b>
	<?php echo CHtml::encode($data->Ethnicity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('EntryDate')); ?>:</b>
	<?php echo CHtml::encode($data->EntryDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Surgeon')); ?>:</b>
	<?php echo CHtml::encode($data->Surgeon); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Office')); ?>:</b>
	<?php echo CHtml::encode($data->Office); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Phone')); ?>:</b>
	<?php echo CHtml::encode($data->Phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Referral')); ?>:</b>
	<?php echo CHtml::encode($data->Referral); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CalcRightEye')); ?>:</b>
	<?php echo CHtml::encode($data->CalcRightEye); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CalcLeftEye')); ?>:</b>
	<?php echo CHtml::encode($data->CalcLeftEye); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dbowner')); ?>:</b>
	<?php echo CHtml::encode($data->dbowner); ?>
	<br />

	*/ ?>

</div>