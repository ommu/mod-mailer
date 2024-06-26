<?php
/**
 * SettingController
 * @var $this ommu\mailer\controllers\SettingController
 * @var $model ommu\mailer\models\MailerSetting
 *
 * SettingController implements the CRUD actions for MailerSetting model.
 * Reference start
 * TOC :
 *	Index
 *	Update
 *	Delete
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 6 May 2018, 16:46 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

namespace ommu\mailer\controllers;

use Yii;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use yii\filters\VerbFilter;
use ommu\mailer\models\MailerSetting;

class SettingController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
        return [
            'access' => [
                'class' => AccessControl::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
	}

	/**
	 * Lists all MailerSetting models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->redirect(['update']);
	}

	/**
	 * Updates an existing MailerSetting model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate()
	{
		$model = MailerSetting::findOne(1);
        if ($model === null) {
            $model = new MailerSetting(['id' => 1]);
        }
			
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            // $postData = Yii::$app->request->post();
            // $model->load($postData);
            // $model->order = $postData['order'] ? $postData['order'] : 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Mailer setting success updated.'));
                return $this->redirect(['update']);

            } else {
                if (Yii::$app->request->isAjax) {
                    return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
                }
            }
        }

		$this->view->title = Yii::t('app', 'Mailer Settings');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing MailerSetting model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete()
	{
		$model = $this->findModel(1);
		$model->delete();

		Yii::$app->session->setFlash('success', Yii::t('app', 'Mailer setting success reset.'));
		return $this->redirect(Yii::$app->request->referrer ?: ['index']);
	}

	/**
	 * Finds the MailerSetting model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return MailerSetting the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
        if (($model = MailerSetting::findOne($id)) !== null) {
            return $model;
        }

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
