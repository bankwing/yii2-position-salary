 <?php
use yii\helpers\Html;
use yii\grid\GridView;
//use yii\widgets\ActiveForm;

use andahrm\leave\models\LeaveType;
use andahrm\structure\models\FiscalYear;
use yii\bootstrap\ActiveForm;
use backend\widgets\WizardMenu;
use andahrm\positionSalary\models\Assign;
use kartik\widgets\Select2;

 
$modelTopic = $event->sender->read('topic')[0];
$modelSelect = $event->sender->read('person')[0];
//$modelSelect$modelSelect->leave_type_id;
//print_r($modelTopic->status);

//print_r(Assign::getRangeStep());

?>

<?php
 
 
        echo GridView::widget([
            'dataProvider' => Assign::getPerson($modelSelect),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'user_id',
                    //'format'=>'html',
                    //'value'=>'user.fullname',
                    'content'=> function($model) use ($form){
                        return $model->user->fullname
                        .$form->field($model,"user_id[{$model->user_id}]")->hiddenInput(['value'=>$model->user_id])->label(false);
                    },
                ],
                [
                    'attribute'=>'position_id',
                    'format'=>'html',
                    'content'=> function($model) use ($form){
                        return $model->position->title."<br/><small>".$model->position->code."</small>"
                        .$form->field($model,"position_id[{$model->user_id}]")->hiddenInput(['value'=>$model->position_id])->label(false);
                    },
                ],
                
                [
                    'attribute'=>'level',
                    'contentOptions'=>['class'=>'text-right'],
                    'content'=> function($model) use ($form){
                        return $model->level
                        .$form->field($model,"level[{$model->user_id}]")->hiddenInput(['value'=>$model->level])->label(false);
                    },
                ],
                [
                    'attribute'=>'new_level',
                    'format'=>'html',
                    'headerOptions'=>['width'=>80],
                    'content'=> function($model) use ($form){
                        return $form->field($model,"new_level[{$model->user_id}]")->textInput(['value'=>$model->new_level?$model->new_level:$model->level])->label(false);
                    },
                ],
                // [
                //     'attribute'=>'step',
                //     'contentOptions'=>['class'=>'text-right'],
                //     'content'=> function($model) use ($form){
                //         return $model->step
                //         .$form->field($model,"step[{$model->user_id}]")->hiddenInput(['value'=>$model->step])->label(false);
                //     },
                // ],
                [
                    'attribute'=>'step_adjust',
                    'headerOptions'=>['width'=>80],
                    'content'=> function($model) use ($form){
                        return $form->field($model,"step_adjust[{$model->user_id}]")->dropDownList(Assign::getRangeStep(),['prompt'=>Yii::t('andahrm','Select')])->label(false);
                    },
                ],
                // [
                //     'attribute'=>'new_step',
                //     'headerOptions'=>['width'=>80],
                //     'content'=> function($model) use ($form){
                //         return $form->field($model,"new_step[{$model->user_id}]")->textInput(['value'=>$model->new_step?$model->new_step:$model->step])->label(false);
                //     },
                // ],
                [
                    'attribute'=>'salary',
                    'contentOptions'=>['class'=>'text-right'],
                    'content'=> function($model) use ($form){
                        return $model->salary
                        .$form->field($model,"salary[{$model->user_id}]")->hiddenInput(['value'=>$model->salary])->label(false);
                    },
                ],
                [
                    'attribute'=>'new_salary',
                    'contentOptions'=>['class'=>'text-right'],
                    'content'=> function($model) use ($form){
                        return $form->field($model,"new_salary[{$model->user_id}]")->textInput(['value'=>$model->new_salary?$model->new_salary:$model->salary])->label(false);
                    },
                ],
                 
                //  [
                //     'attribute'=>'adjust_date',
                //     'content'=> function($model){
                //         return Yii::$app->formatter->asDate($model->adjust_date)
                //         .Html::hiddenInput("Assign[current_adjust_date][{$model->user_id}]",
                //             $model->adjust_date
                //             );
                //     },
                //     ],
                    
                  
                
                
                
                
               
            ]
        ]);
        ?>