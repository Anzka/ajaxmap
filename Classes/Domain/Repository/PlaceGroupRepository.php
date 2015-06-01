<?php

namespace Webfox\Ajaxmap\Domain\Repository;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Dirk Wenzel <wenzel@webfox01.de>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use Webfox\Ajaxmap\Domain\Model\Dto\DemandInterface;
/**
 *
 *
 * @package ajaxmap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PlaceGroupRepository extends AbstractDemandedRepository {
	/**
	 * Creates an array of query constraints from demand
	 *
	 * @param QueryInterface $query
	 * @param DemandInterface $demandInterface
	 * @return array
	 */
	public function createConstraintsFromDemand(QueryInterface $query, DemandInterface $demandInterface) {
		$constraints = array();
		// @todo add constraints
		return $constraints;
	}
}
