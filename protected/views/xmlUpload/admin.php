<?php
/* @var $this XmlUploadController */
/* @var $model XmlUpload */

$this->breadcrumbs=array(
	'Xml Uploads'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List XmlUpload', 'url'=>array('index')),
	array('label'=>'Create XmlUpload', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#xml-upload-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Xml Uploads</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'xml-upload-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'xmlFile',
		'created_at',
		'updated_at',
		'fastName',
		'firstName',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
