<?php
/* @var $this XmlUploadController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Xml Uploads',
);

$this->menu=array(
	array('label'=>'Create XmlUpload', 'url'=>array('create')),
	array('label'=>'Manage XmlUpload', 'url'=>array('admin')),
);
?>

<h1>Xml Uploads</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
