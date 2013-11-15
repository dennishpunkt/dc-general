<?php
/**
 * PHP version 5
 * @package    generalDriver
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @copyright  The MetaModels team.
 * @license    LGPL.
 * @filesource
 */

namespace DcGeneral\Contao\Callback;

use DcGeneral\Contao\View\Contao2BackendView\Event\GetPasteButtonEvent;
use DcGeneral\Contao\View\Contao2BackendView\Event\GetPasteRootButtonEvent;
use DcGeneral\DC_General;

class ContainerPasteButtonCallbackListener extends AbstractReturningCallbackListener
{
	protected $dcGeneral;

	function __construct($callback, DC_General $dcGeneral)
	{
		parent::__construct($callback);
		$this->dcGeneral = $dcGeneral;
	}

	/**
	 * @param GetPasteButtonEvent|GetPasteRootButtonEvent $event
	 *
	 * @return array
	 */
	public function getArgs($event)
	{
		return array(
			$this->dcGeneral,
			$event->getModel()->getPropertiesAsArray(),
			$event->getEnvironment()->getDataDefinition()->getName(),
			$event->getCircularReference(),
			$event->getEnvironment()->getClipboard()->getContainedIds(),
			$event->getPrevious(),
			$event->getNext()
		);
	}

	/**
	 * @param GetPasteButtonEvent|GetPasteRootButtonEvent $event
	 *
	 * @return void
	 */
	public function update($event, $value)
	{
		if (is_null($value)) {
			return;
		}

		$event->setHtml($value);
		$event->stopPropagation();
	}
}