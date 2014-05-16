<?php
/* @var $this PatientsController */
/* @var $model Patients */

$this->breadcrumbs=array(
	'Patients'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Patients', 'url'=>array('index')),
	array('label'=>'Manage Patients', 'url'=>array('admin')),
);
?>

<h1>Create Patients</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>