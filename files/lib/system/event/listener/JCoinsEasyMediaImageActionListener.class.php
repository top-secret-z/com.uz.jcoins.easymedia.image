<?php
namespace easymedia\system\event\listener;
use wcf\system\event\listener\IParameterizedEventListener;
use wcf\system\user\jcoins\UserJCoinsStatementHandler;

/**
 * JCoins listener for EasyMedia images.
 *
 * @author		2017-2022 Zaydowicz
 * @license		GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package		com.uz.jcoins.easymedia.image
 */
class JCoinsEasyMediaImageActionListener implements IParameterizedEventListener {
	/**
	 * @inheritdoc
	 */
	public function execute($eventObj, $className, $eventName, array &$parameters) {
		if (!MODULE_JCOINS) return;
		
		$action = $eventObj->getActionName();
		if ($action == 'triggerPublication') {
			foreach ($eventObj->getObjects() as $image) {
				if ($image->isPublished && !$image->isDisabled && $image->userID) {
					UserJCoinsStatementHandler::getInstance()->create('com.uz.jcoins.easymedia.image', $image->getDecoratedObject());
				}
			}
		}
		
		if ($action == 'restore') {
			foreach ($eventObj->getObjects() as $image) {
				if ($image->isPublished && !$image->isDisabled && $image->userID) {
					UserJCoinsStatementHandler::getInstance()->create('com.uz.jcoins.easymedia.image', $image->getDecoratedObject());
				}
			}
		}
		
		if ($action == 'disable' || $action == 'trash') {
			foreach ($eventObj->getObjects() as $image) {
				if ($image->isPublished && !$image->isDisabled && !$image->isDeleted && $image->userID) {
					UserJCoinsStatementHandler::getInstance()->revoke('com.uz.jcoins.easymedia.image', $image->getDecoratedObject());
				}
			}
		}
	}
}
