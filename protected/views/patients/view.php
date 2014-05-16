<?php
/* @var $this PatientsController */
/* @var $model Patients */

$this->breadcrumbs=array(
	'Patients'=>array('index'),
	$model->ID,
);

$this->menu=array(
	array('label'=>'List Patients', 'url'=>array('index')),
	array('label'=>'Create Patients', 'url'=>array('create')),
	array('label'=>'Update Patients', 'url'=>array('update', 'id'=>$model->ID)),
	array('label'=>'Delete Patients', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Patients', 'url'=>array('admin')),
);
?>

<h1>View Patients #<?php echo $model->ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ID',
		'ChartID',
		'LastName',
		'FirstName',
		'MI',
		'BirthDate',
		'Sex',
		'Ethnicity',
		'EntryDate',
		'Surgeon',
		'Office',
		'Phone',
		'Referral',
		'CalcRightEye',
		'CalcLeftEye',
		'dbowner',
	),
)); ?>
