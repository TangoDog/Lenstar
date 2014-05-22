<?php
/* @var $this XmlUploadController */
/* @var $model XmlUpload */

$this->breadcrumbs=array(
	'Xml Uploads'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List XmlUpload', 'url'=>array('index')),
	array('label'=>'Create XmlUpload', 'url'=>array('create')),
	array('label'=>'View XmlUpload', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage XmlUpload', 'url'=>array('admin')),
);
?>

<h1>Update XmlUpload <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>