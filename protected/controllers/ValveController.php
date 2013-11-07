<?php
/**
 * @method bool isPost()
 * @method bool isPut()
 * @method bool isDelete()
 * @method string renderRest(string $view, array $data = null, bool $return = false, array $fields = array())
 * @method void redirectRest(string $url, bool $terminate = true, int $statusCode = 302)
 * @method bool isRestService()
 * @method \rest\Service getRestService()
 */
class ValveController extends Controller
{
 /**
     * @return array
     */
    public function behaviors()
    {
        return array(
            'restAPI' => array('class' => '\rest\controller\Behavior')
        );
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewBySiteID($siteid)
	{
		$model = Valve::model()->findAll('site_id=:site_id', array(':site_id'=>$siteid));
		$this->render('view',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewWaterUsage($siteid)
	{
		$sql ="SELECT  site_id,SUM(amount) AS rows, Week(date) as NumberOfWeek,DATE_ADD(date, INTERVAL (MOD(DAYOFWEEK(date)-1, 7)*-1) DAY) AS week_start, 
		DATE_ADD(date, INTERVAL ((MOD(DAYOFWEEK(date)-1, 7)*-1)+6) DAY) AS week_end FROM waterusage WHERE YEARWEEK(date) = YEARWEEK(CURRENT_DATE)  or YEARWEEK(date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY) and site_id = :siteid GROUP BY YEARWEEK(date)";
		$req = Yii::app()->db->createCommand($sql);
		$req->bindParam(":siteid", $siteid, PDO::PARAM_STR);
		$this->render('view',array(
			'data'=>$req->queryAll(),
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Valve;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Valve']))
		{
			$model->attributes=$_POST['Valve'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->valve_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Valve']))
		{
			$model->attributes=$_POST['Valve'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->valve_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = Valve::model()->findAll();
        $this->render('empty', array('model' => $model));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Valve the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Valve::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	 /**
     * Renders a view with a layout.
     *
     * @param string $view name of the view to be rendered. See {@link getViewFile} for details
     * about how the view script is resolved.
     * @param array $data data to be extracted into PHP variables and made available to the view script
     * @param boolean $return whether the rendering result should be returned instead of being displayed to end users.
     * @param array $fields allowed fields to REST render
     * @return string the rendering result. Null if the rendering result is not required.
     * @see renderPartial
     * @see getLayoutFile
     */
    public function render($view, $data = null, $return = false, array $fields = array('count', 'model', 'data'))
    {
        if (($behavior = $this->asa('restAPI')) && $behavior->getEnabled()) {
            if (isset($data['model']) && $this->isRestService() &&
                count(array_intersect(array_keys($data), $fields)) == 1) {
                $data = $data['model'];
                $fields = null;
            }
            return $this->renderRest($view, $data, $return, $fields);
        } else {
            return parent::render($view, $data, $return);
        }
    }

    /**
     * Redirects the browser to the specified URL or route (controller/action).
     * @param mixed $url the URL to be redirected to. If the parameter is an array,
     * the first element must be a route to a controller action and the rest
     * are GET parameters in name-value pairs.
     * @param boolean|integer $terminate whether to terminate OR REST response status code !!!
     * @param integer $statusCode the HTTP status code. Defaults to 302. See {@link http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html}
     * for details about HTTP status code.
     */
    public function redirect($url, $terminate = true, $statusCode = 302)
    {
        if (($behavior = $this->asa('restAPI')) && $behavior->getEnabled()) {
            $this->redirectRest($url, $terminate, $statusCode);
        } else {
            parent::redirect($url, $terminate, $statusCode);
        }
    }
}
