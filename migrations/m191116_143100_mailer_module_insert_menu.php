<?php
/**
 * m191116_143100_mailer_module_insert_menu
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.id)
 * @created date 16 November 2019, 14:31 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use app\models\Menu;
use mdm\admin\components\Configs;

class m191116_143100_mailer_module_insert_menu extends \yii\db\Migration
{
	public function up()
	{
        $menuTable = Configs::instance()->menuTable;
		$tableName = Yii::$app->db->tablePrefix . $menuTable;
        if (Yii::$app->db->getTableSchema($tableName, true)) {
			$this->batchInsert($tableName, ['name', 'module', 'icon', 'parent', 'route', 'order', 'data'], [
				['Mailer Settings', 'mailer', null, Menu::getParentId('Settings#rbac'), '/mailer/setting/index', null, null],
				['Mail Template', 'mailer', null, Menu::getParentId('Development Tools#rbac'), '/mailer/template/admin/index', null, null],
			]);
		}
	}
}
