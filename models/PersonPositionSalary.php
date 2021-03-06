<?php

namespace andahrm\positionSalary\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use andahrm\person\models\Person;
use andahrm\edoc\models\Edoc;
use andahrm\structure\models\Position;
use andahrm\datepicker\behaviors\DateBuddhistBehavior;
use andahrm\datepicker\behaviors\YearBuddhistBehavior;
use andahrm\datepicker\components\ThaiYearFormatter;

/**
 * This is the model class for table "person_position_salary".
 *
 * @property integer $user_id
 * @property integer $position_id
 * @property integer $edoc_id
 * @property string $adjust_date
 * @property string $title
 * @property integer $status
 * @property string $step
 * @property integer $level
 * @property string $salary
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Edoc $edoc
 * @property Person $user
 * @property Position $position
 */
class PersonPositionSalary extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'person_position_salary';
    }

    /**
     * @inheritdoc
     */
    function behaviors() {

        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
            'adjust_date' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'adjust_date',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //[['user_id', 'position_id', 'adjust_date', 'title', 'status', 'level', 'salary','person_type_id' ], 'required'],
            [['user_id', 'position_id', 'adjust_date', 'status', 'level', 'salary', 'person_type_id'], 'required'],
            [['user_id', 'position_id', 'position_type_id', 'position_level_id', 'edoc_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['adjust_date', 'status', 'select_status'], 'safe'],
            [['step_adjust', 'salary', 'step'], 'number'],
            //[['title'], 'string', 'max' => 255],
            [['level'], 'string', 'max' => 15],
            //[['step'], 'string', 'max' => 4],
            [['edoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edoc::className(), 'targetAttribute' => ['edoc_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['user_id' => 'user_id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['position_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => Yii::t('andahrm/position-salary', 'User ID'),
            'position_old_id' => Yii::t('andahrm/position-salary', 'Position Old ID'),
            'position_id' => Yii::t('andahrm/position-salary', 'Position ID'),
            'edoc_id' => Yii::t('andahrm/position-salary', 'Edoc ID'),
            'adjust_date' => Yii::t('andahrm/position-salary', 'Adjust Date'),
            'title' => Yii::t('andahrm/position-salary', 'Title'),
            'title-list' => Yii::t('andahrm/position-salary', 'Title List'),
            'select_status' => Yii::t('andahrm/position-salary', 'Status'),
            'status' => Yii::t('andahrm/position-salary', 'Status'),
            'step' => Yii::t('andahrm/position-salary', 'Step'),
            'step_adjust' => Yii::t('andahrm/position-salary', 'Step Adjust'),
            'level' => Yii::t('andahrm/position-salary', 'Level'),
            'salary' => Yii::t('andahrm/position-salary', 'Salary'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
            'person_type_id' => Yii::t('andahrm/structure', 'Person Type'),
            'new_step' => Yii::t('andahrm/position-salary', 'New Step'),
            'new_level' => Yii::t('andahrm/position-salary', 'New Level'),
            'new_salary' => Yii::t('andahrm/position-salary', 'New Salary'),
            'new_position_id' => Yii::t('andahrm/position-salary', 'New Position'),
            'start_date' => Yii::t('andahrm/position-salary', 'Start Date'),
            'end_date' => Yii::t('andahrm/position-salary', 'End Date'),
            'position_type_id' => Yii::t('andahrm/structure', 'Position Type'),
            'position_level_id' => Yii::t('andahrm/structure', 'Position Level'),
        ];
    }

    public $position_old_id;
    public $person_type_id;
    public $select_status;

    const SCENA_STATUS2 = 'status2';
    const SCENA_STATUS3 = 'status3';
    const SCENA_STATUS4 = 'status4';

    public function scenarios() {
        $scenarios = parent::scenarios();

        $scenarios['new-person'] = [
            //'user_id',
            'position_id', 'edoc_id', 'salary', 'user_id', 'level', 'status', 'adjust_date'
        ];

        $scenarios['insert'] = [
            'user_id', 'salary', 'position_id', 'level', 'status',
                //'new_level', 'new_salary', 'new_position_id'
        ];
        $scenarios['update'] = [
            'adjust_date', 'salary', 'position_id', 'level', 'status', 'edoc_id', 'step', 'salary', 'updated_at', 'updated_by'
        ];
        $scenarios[self::SCENA_STATUS2] = [
            'user_id', 'salary', 'position_id', 'level', 'status',
            'new_level', 'step_adjust', 'new_salary'
        ];
        $scenarios[self::SCENA_STATUS3] = [
            'user_id', 'salary', 'position_id', 'level', 'status',
            'new_position_id',
            'start_date', 'end_date'
        ];
        $scenarios[self::SCENA_STATUS4] = ['user_id', 'salary', 'position_id', 'level', 'status'];

        return $scenarios;
    }

    /**
     * @inheritdoc 
     * @return PersonContractQuery the active query used by this AR class. 
     */
    public static function find() {
        return new PersonPositionSalaryQuery(get_called_class());
    }

    const STATUS_FIRST_TIME = 1; #บรรจุแรกเข้า
    const STATUS_ADJUST = 2; #ปรับเงินเดือน
    const STATUS_MOVE = 3; #ย้ายสายงาน
    const STATUS_LEAVE = 4; #สินสุดการจ้าง
    const STATUS_TRANSFER = 5; #สินสุดการจ้าง

    public static function itemsAlias($key) {
        $items = [
            'status' => [
                self::STATUS_FIRST_TIME => Yii::t('andahrm/position-salary', 'First time'),
                self::STATUS_ADJUST => Yii::t('andahrm/position-salary', 'Adjust salary'),
                self::STATUS_MOVE => Yii::t('andahrm/position-salary', 'Move line'),
                self::STATUS_LEAVE => Yii::t('andahrm/position-salary', 'Leave'),
            ],
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getStatusLabel() {
        return ArrayHelper::getValue($this->getItemStatus(), $this->status);
    }

    public static function getItemStatus() {
        return self::itemsAlias('status');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdoc() {
        return $this->hasOne(Edoc::className(), ['id' => 'edoc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition() {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
    }

    public function getPersonPosition() {
        return $this->hasOne(PersonPosition::className(), ['user_id' => 'user_id']);
    }

    public function getAssessment() {
        return $this->hasOne(Assessment::className(), ['user_id' => 'user_id']);
    }

    public static function getRangeStep() {
        $range = range(0.5, 2, 0.5);
        return array_combine($range, $range);
    }

    public function getTitleStep() {
        return $this->title . ($this->step_adjust * 1 > 0 ?
                ' เลื่อน ' . $this->step_adjust . ' ขั้น' : '');
    }

    public function getPositionTitleCode() {
        return $this->position->titleCode;
    }

    #check exists record

    public function getExists() {
        return self::find()->where([
                    'user_id' => $this->user_id,
                    'position_id' => $this->position_id,
                    'edoc_id' => $this->edoc_id,
                ])->exists();
    }

    public function getPositionLevel() {
        return $this->hasOne(PositionLevel::className(), ['id' => 'position_level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonType() {
        return $this->hasOne(PersonType::className(), ['id' => 'person_type_id']);
    }

    public function getTitle() {
        $str = $this->position->title;
        switch ($this->status) {
            // case self::STATUS_FIRST_TIME:
            //      $str = $this->position->title;
            //     //exit();
            // break;
            // case self::STATUS_MOVE:
            //     $arr_str[] = $this->position->title;
            //     $arr_str[] = $this->edoc->title;
            //     $arr_str = array_filter($arr_str);
            //     $str = implode("<br/>",$arr_str);
            //     //exit();
            // break;
            // case self::STATUS_ADJUST:
            //   $arr_str[] = $this->position->title;
            //     $arr_str[] = $this->edoc->title;
            //     $arr_str = array_filter($arr_str);
            //     $str = implode("<br/>",$arr_str);
            // break;

            default:
                $arr_str[] = $this->position->title;
                $arr_str[] = $this->edoc->title;
                $arr_str = array_filter($arr_str);
                $str = implode("<br/>", $arr_str);
                break;
        }
        return $str;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
//        print_r($this->user_id);
//        exit();
        self::updatePostion($this->user_id);
    }

    public static function updatePostion($user_id) {
        $modelLast = self::find()->where(['user_id' => $user_id])->orderBy(['adjust_date' => SORT_DESC])->one();

        if ($modelLast) {
            $where = "position_id = {$modelLast->position_id} ";
            $modelOld = Person::updateAll(['position_id' => null], $where);

//                $where = "user_id = {$modelLast->user_id}";
//                $modelCurrent = Person::updateAll(['position_id' => $model->position_id], $where);
//                echo $where;
//                exit();
        }



        $model = Person::findOne($user_id);
        $model->scenario = Person::SCENARIO_UPDATE_POSITION;



        //$position = $model->positionLast;
        // $model->position_id = $position ? $position->id : null;
        $model->position_id = $modelLast ? $modelLast->position_id : null;

        if ($model->save()) {
            //echo "After<br/>";
            // print_r($model->attributes);
            //echo $model->birthday . "<br/>";
            // echo $model->position_id;
            //exit();
            return true;
        } else {
            echo "Error:afterSave<br/>";
            print_r($model->getErrors());
            exit();
        }
    }

}
