<?php
/*
** Zabbix
** Copyright (C) 2001-2022 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/

require_once dirname(__FILE__).'/testDataCollection.php';
require_once dirname(__FILE__).'/testDiagnosticDataTask.php';
require_once dirname(__FILE__).'/testLowLevelDiscovery.php';
require_once dirname(__FILE__).'/testGoAgentDataCollection.php';
require_once dirname(__FILE__).'/testItemState.php';
require_once dirname(__FILE__).'/testValuemaps.php';
require_once dirname(__FILE__).'/testTriggerLinking.php';
require_once dirname(__FILE__).'/testGraphLinking.php';
require_once dirname(__FILE__).'/testEscalations.php';
require_once dirname(__FILE__).'/testComplexServiceStatus.php';
require_once dirname(__FILE__).'/testServiceRoles.php';
require_once dirname(__FILE__).'/testExpressionMacros.php';
require_once dirname(__FILE__).'/testExpressionTriggerMacros.php';
require_once dirname(__FILE__).'/testAgentItems.php';
require_once dirname(__FILE__).'/testItemRate.php';
require_once dirname(__FILE__).'/testHistoryValueDuplicates.php';
require_once dirname(__FILE__).'/testUserParametersReload.php';
require_once dirname(__FILE__).'/testTriggerState.php';

use PHPUnit\Framework\TestSuite;

class IntegrationTests {
	public static function suite() {
		$suite = new TestSuite('Integration');
		$suite->addTestSuite('testDataCollection');
		$suite->addTestSuite('testDiagnosticDataTask');
		$suite->addTestSuite('testLowLevelDiscovery');
		$suite->addTestSuite('testGoAgentDataCollection');
		$suite->addTestSuite('testItemState');
		$suite->addTestSuite('testValuemaps');
		$suite->addTestSuite('testTriggerLinking');
		$suite->addTestSuite('testGraphLinking');
		$suite->addTestSuite('testEscalations');
		$suite->addTestSuite('testComplexServiceStatus');
		$suite->addTestSuite('testServiceRoles');
		$suite->addTestSuite('testExpressionMacros');
		$suite->addTestSuite('testExpressionTriggerMacros');
		$suite->addTestSuite('testAgentItems');
		$suite->addTestSuite('testItemRate');
		$suite->addTestSuite('testHistoryValueDuplicates');
		$suite->addTestSuite('testUserParametersReload');
		$suite->addTestSuite('testTriggerState');

		return $suite;
	}
}
