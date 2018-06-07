<?php
/**
 * @var $this yii\web\View
 * @var $this ommu\mailer\controllers\DefaultController
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 ECC UGM (ecc.ft.ugm.ac.id)
 * @created date 7 June 2018, 07:13 WIB
 * @link https://github.com/ommu/mod-mailer
 *
 */

use Yii;
use yii\helpers\Html;
?>

<p>
	This is the view content for action "<?php echo $this->context->action->id ?>".
	The action belongs to the controller "<?php echo get_class($this->context) ?>"
	in the "<?php echo $this->context->module->id ?>" module.
</p>
<p>
	You may customize this page by editing the following file:<br>
	<code><?php echo __FILE__ ?></code>
</p>

<div class="mailer-default-index"></div>