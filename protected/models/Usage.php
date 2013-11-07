<?php
/**
 * Yii RESTful API
 *
 * @link      https://github.com/paysio/yii-rest-api
 * @copyright Copyright (c) 2012 Pays I/O Ltd. (http://pays.io)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT license
 * @package   REST_Service_Demo
 */

/**
 * @method array getRenderAttributes(bool $recursive = true)
 * @method string getObjectId()
 */
class Usage extends CModel
{
    public $siteid;

    public $week;

    public $amount;

    

    public function __construct($scenario = null)
	{
		if ($scenario === null) {
            $scenario = Yii::app()->controller->getAction()->getId();
        }
        $this->scenario = $scenario;
        $this->attachBehaviors($this->behaviors());
	}

    /**
     * @return array
     */
    public function attributeNames()
    {
        return array('siteid', 'week', 'amount');
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array(
            array('site, week, amount', 'safe', 'on' => 'render'),
        );
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