<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 5                                                  |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2019                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2019
 */

/**
 * This class generates form components for Search Parameters
 *
 */
class CRM_Admin_Form_Setting_Search extends CRM_Admin_Form_Setting {

  protected $_settings = [
    'includeWildCardInName' => CRM_Core_BAO_Setting::SEARCH_PREFERENCES_NAME,
    'includeEmailInName' => CRM_Core_BAO_Setting::SEARCH_PREFERENCES_NAME,
    'searchPrimaryDetailsOnly' => CRM_Core_BAO_Setting::SEARCH_PREFERENCES_NAME,
    'includeNickNameInName' => CRM_Core_BAO_Setting::SEARCH_PREFERENCES_NAME,
    'includeAlphabeticalPager' => CRM_Core_BAO_Setting::SEARCH_PREFERENCES_NAME,
    'includeOrderByClause' => CRM_Core_BAO_Setting::SEARCH_PREFERENCES_NAME,
    'defaultSearchProfileID' => CRM_Core_BAO_Setting::SEARCH_PREFERENCES_NAME,
    'smartGroupCacheTimeout' => CRM_Core_BAO_Setting::SEARCH_PREFERENCES_NAME,
    'quicksearch_options' => CRM_Core_BAO_Setting::SEARCH_PREFERENCES_NAME,
    'contact_autocomplete_options' => CRM_Core_BAO_Setting::SYSTEM_PREFERENCES_NAME,
    'contact_reference_options' => CRM_Core_BAO_Setting::SYSTEM_PREFERENCES_NAME,
    'search_autocomplete_count' => CRM_Core_BAO_Setting::SEARCH_PREFERENCES_NAME,
    'enable_innodb_fts' => CRM_Core_BAO_Setting::SEARCH_PREFERENCES_NAME,
  ];

  /**
   * Build the form object.
   */
  public function buildQuickForm() {
    CRM_Utils_System::setTitle(ts('Settings - Search Preferences'));

    parent::buildQuickForm();

    // Option 1 can't be unchecked. @see self::enableOptionOne
    $element = $this->getElement('contact_autocomplete_options');
    $element->_elements[0]->setAttribute('disabled', 'disabled');

    // Option 1 can't be unchecked. @see self::enableOptionOne
    $element = $this->getElement('contact_reference_options');
    $element->_elements[0]->setAttribute('disabled', 'disabled');
  }

  /**
   * @return array
   */
  public static function getContactAutocompleteOptions() {
    return [1 => ts('Contact Name')] + CRM_Core_OptionGroup::values('contact_autocomplete_options', FALSE, FALSE, TRUE);
  }

  /**
   * @return array
   */
  public static function getAvailableProfiles() {
    return ['' => ts('- none -')] + CRM_Core_BAO_UFGroup::getProfiles([
      'Contact',
      'Individual',
      'Organization',
      'Household',
    ]);
  }

  /**
   * @return array
   */
  public static function getContactReferenceOptions() {
    return [1 => ts('Contact Name')] + CRM_Core_OptionGroup::values('contact_reference_options', FALSE, FALSE, TRUE);
  }

  /**
   * Presave callback for contact_reference_options and contact_autocomplete_options.
   *
   * Ensures "1" is always contained in the array.
   *
   * @param $value
   * @return bool
   */
  public static function enableOptionOne(&$value) {
    $values = (array) CRM_Utils_Array::explodePadded($value);
    if (!in_array(1, $values)) {
      $value = CRM_Utils_Array::implodePadded(array_merge([1], $values));
    }
    return TRUE;
  }

}
