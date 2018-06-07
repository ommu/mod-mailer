<?php
/**
 * DefaultController
 * @var $this yii\web\View
 *
 * Default controller for the `mailer` module
 * Reference start
 * TOC :
 *	Index
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 ECC UGM (ecc.ft.ugm.ac.id)
 * @created date 7 June 2018, 07:13 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

namespace ommu\mailer\controllers;

use app\components\Controller;

class DefaultController extends Controller
{
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex()
	{
		$this->view->title = 'mailers';
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('index');
	}
}
