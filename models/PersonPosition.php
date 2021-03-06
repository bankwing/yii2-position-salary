<?php
namespace andahrm\positionSalary\models;

use Yii;
use andahrm\leave\models\Leave; #mad
use andahrm\leave\models\LeavePermission; #mad
use andahrm\positionSalary\models\PersonPositionSalary; #mad
use andahrm\leave\models\LeaveRelatedPerson; #mad
use andahrm\leave\models\LeaveRelatedSection; #mad
use yii\helpers\ArrayHelper;

class PersonPosition extends \andahrm\person\models\Person
{
    
   /**
  *  Create by mad
  * เงินเดือนและตำแหน่ง
  */
   public function getPositionSalary()
    {
        return $this->hasOne(PersonPositionSalary::className(), ['user_id' => 'user_id'])->orderBy(['adjust_date'=>SORT_DESC]);
    }
  
  
  public function getPositionSalaries()
    {
        return $this->hasMany(PersonPositionSalary::className(), ['user_id' => 'user_id'])->orderBy(['adjust_date'=>SORT_DESC]);
    }
    
  
  /**
  *  Create by mad
  * ตำแหน่ง
  */
  public function getPosition()
    {
        return $this->positionSalary?$this->positionSalary->position:null;
    }
  
 
  
   public function getPositionTitle()
    {
        return $this->position?$this->position->title:null;
    }
    
     public function getSectionTitle()
    {
        return $this->positionSalary?$this->positionSalary->position->section->title:null;
    }
    
     public function getSection()
    {
        return $this->positionSalary?$this->positionSalary->position->section:null;
    }
    
    
    public static function getList(){
        return ArrayHelper::map(self::find()->all(),'user_id','fullname');
    }
    
  

   
}