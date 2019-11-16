<?php
/**
 * m191116_143100_mailer_module_insert_menu
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 16 November 2019, 14:31 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use Yii;
use app\models\Menu;

class m191116_143100_mailer_module_insert_menu extends \yii\db\Migration
{
	public function up()
	{
		$tableName = Yii::$app->db->tablePrefix . 'ommu_core_menus';
		if(Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert('ommu_core_menus', ['name', 'module', 'icon', 'parent', 'route', 'order', 'data'], [
				['Mailer Settings', 'mailer', null, Menu::getParentId('Settings#rbac'), '/mailer/setting/index', null, null],
			]);
		}
	}
}
