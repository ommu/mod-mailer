<?php
/**
 * mailer module definition class
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 7 June 2018, 07:13 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

namespace ommu\mailer;

use Yii;

class Module extends \app\components\Module
{
	public $layout = 'main';

	/**
	 * {@inheritdoc}
	 */
	public $controllerNamespace = 'ommu\mailer\controllers';

	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
        parent::init();
	}
}
