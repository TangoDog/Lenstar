<?php
/* @var $this XmlUploadController */
/* @var $model XmlUpload */

$this->breadcrumbs=array(
	'Xml Uploads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List XmlUpload', 'url'=>array('index')),
	array('label'=>'Manage XmlUpload', 'url'=>array('admin')),
);
?>

<h1>Create XmlUpload</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>