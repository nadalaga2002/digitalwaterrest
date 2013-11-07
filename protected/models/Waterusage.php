<?php

/**
 * This is the model class for table "waterusage".
 *
 * The followings are the available columns in table 'waterusage':
 * @property integer $id
 * @property string $valve_id
 * @property string $date
 * @property string $amount
 * @property string $valve_angle
 *
 * The followings are the available model relations:
 * @property Valve $valve
 */
class Waterusage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'waterusage';
	}
	
	public function __construct($scenario = null)
	{
		if ($scenario === null) {
            $scenario = Yii::app()->controller->getAction()->getId();
        }
        $this->scenario = $scenario;
        $this->attachBehaviors($this->behaviors());
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('valve_id', 'length', 'max'=>255),
			array('amount, valve_angle', 'length', 'max'=>10),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, valve_id, date, amount, valve_angle', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'valve' => array(self::BELONGS_TO, 'Valve', 'valve_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'valve_id' => 'Valve',
			'date' => 'Date',
			'amount' => 'Amount',
			'valve_angle' => 'Valve Angle',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('valve_id',$this->valve_id,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('valve_angle',$this->valve_angle,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Waterusage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
     * @return array
     */
    public function behaviors()
    {
        return array(
            'renderModel' => array('class' => '\rest\model\Behavior')
        );
    }

    /**
     * @return bool
     */
    public function save()
    {
        // does nothing
        return $this->validate();
    }
}
