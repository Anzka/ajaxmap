<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$extensionKey = 'ajaxmap';
$extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extensionKey);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $extensionKey,
    'Map',
    'Map'
);

$pluginSignature = str_replace('_', '', $extensionKey) . '_' . 'map';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/flexform_map.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extensionKey, 'Configuration/TypoScript', 'Ajax Map');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_placegroup', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_category.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_placegroup');


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_place', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_place.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_place');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_map', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_map.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_map');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_region', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_region.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_region');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_ajaxmap_domain_model_locationtype', 'EXT:ajaxmap/Resources/Private/Language/locallang_csh_tx_ajaxmap_domain_model_locationtype.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_ajaxmap_domain_model_locationtype');

$TCA['tt_address']['columns'][$TCA['tt_address']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tt_address.tx_extbase_type.Tx_Ajaxmap_Address', 'Tx_Ajaxmap_Address');

$TCA['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] = $TCA['tt_address']['types']['1']['showitem'];
$TCA['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] .= ',--div--;LLL:EXT:ajaxmap/Resources/Private/Language/locallang_db.xml:tx_ajaxmap_domain_model_address,';
$TCA['tt_address']['types']['Tx_Ajaxmap_Address']['showitem'] .= '';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    'ajaxmap',
    'tx_ajaxmap_domain_model_place'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
    'ajaxmap',
    'tx_ajaxmap_domain_model_map'
);
