<?php
/* @var $this XmlUploadController */
/* @var $model XmlUpload */

$this->breadcrumbs=array(
	'Xml Uploads'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List XmlUpload', 'url'=>array('index')),
	array('label'=>'Create XmlUpload', 'url'=>array('create')),
	array('label'=>'Update XmlUpload', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete XmlUpload', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage XmlUpload', 'url'=>array('admin')),
);
?>

<h1>View XmlUpload #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'xmlFile',
		'created_at',
		'updated_at',
		'fastName',
		'firstName',
		'mi',
		'birthDate',
		'chartID',
		'ethnicity',
		'thisUser',
		'thisPwd',
		'technician',
		'surgeon',
		'dbowner',
		'office',
		'preop',
		'postop',
		'user_id',
	),
)); ?>
