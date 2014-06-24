<?php

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
 *  the Free Software Foundation; either version 2 of the License, or
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

/**
 * Test case for class Tx_Ajaxmap_Controller_MapController.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Ajax Map
 *
 * @author Dirk Wenzel <wenzel@webfox01.de>
 */
class Tx_Ajaxmap_Controller_MapControllerTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Ajaxmap_Controller_MapController
	 */
	protected $fixture;

	/**
	 * Map Repository
	 *
	 * @var Tx_Ajaxmap_Domain_Repository_MapRepository
	 */
	private $mapRepository;

	/**
	 * 
	 * @var Tx_Ajaxmap_Domain_Repository_PlaceRepository
	 */
	private $placeRepository;

	/**
	 *
	 * @var Tx_Ajaxmap_Domain_Repository_RegionRepository
	 */
	private $regionRepository;

	public function setUp() {
		$this->fixture = new Tx_Ajaxmap_Controller_MapController();
		$this->mapRepository = $this->getMock(
				'Tx_Ajaxmap_Domain_Repository_MapRepository', array(), array(), '', FALSE
		);
		$this->regionRepository = $this->getMock(
				'Tx_Ajaxmap_Domain_Repository_RegionRepository', array(), array(), '', FALSE
		);
		$this->placeRepository = $this->getMock(
				'Tx_Ajaxmap_Domain_Repository_PlaceRepository', array(), array(), '', FALSE
		);
		$this->fixture->injectMapRepository($this->mapRepository);
		$this->fixture->injectRegionRepository($this->regionRepository);
		$this->fixture->injectPlaceRepository($this->placeRepository);
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function showActionReturnsEmptyJsonWhenMapIsNotSet() {
		$settings = array();
		$configurationManager = $this->getMock(
				'TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface'
		);

		$fixture = $this->getAccessibleMock(
				'Tx_Ajaxmap_Controller_MapController',
				array('showAction'));
		//$fixture->injectConfigurationManager($configurationManager);
		$fixture->setView($this->getMock('Tx_Fluid_View_TemplateView', array(), array(), '', FALSE));

		$fixture->expects($this->once())->method('showAction')
			->will($this->returnValue('{}'));
		$fixture->showAction();
	}

}
?>
