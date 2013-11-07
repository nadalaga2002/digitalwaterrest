<?php

/**
 * This is the model class for table "valve".
 *
 * The followings are the available columns in table 'valve':
 * @property string $valve_id
 * @property string $site_id
 * @property string $name
 * @method array getRenderAttributes(bool $recursive = true)
 * @method string getObjectId()
 *
 * The followings are the available model relations:
 * @property Site $site
 * @property Waterusage[] $waterusages
 */
class Valve extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'valve';
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
			array('valve_id, site_id', 'length', 'max'=>255),
			array('name', 'length', 'max'=>2000),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('valve_id, site_id, name', 'safe', 'on'=>'render'),
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
			'site' => array(self::BELONGS_TO, 'Site', 'site_id'),
			'waterusages' => array(self::HAS_MANY, 'Waterusage', 'valve_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'valve_id' => 'Valve',
			'site_id' => 'Site',
			'name' => 'Name',
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

		$criteria->compare('valve_id',$this->valve_id,true);
		$criteria->compare('site_id',$this->site_id,true);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Valve the static model class
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
