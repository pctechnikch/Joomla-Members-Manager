<?php
/**
 * @package    Joomla.Members.Manager
 *
 * @created    6th September, 2015
 * @author     Llewellyn van der Merwe <https://www.joomlacomponentbuilder.com/>
 * @github     Joomla Members Manager <https://github.com/vdm-io/Joomla-Members-Manager>
 * @copyright  Copyright (C) 2015. All Rights Reserved
 * @license    GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Countries Controller
 */
class MembersmanagerControllerCountries extends JControllerAdmin
{
	protected $text_prefix = 'COM_MEMBERSMANAGER_COUNTRIES';
	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = 'Country', $prefix = 'MembersmanagerModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		
		return $model;
	}

	public function exportData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('country.export', 'com_membersmanager') && $user->authorise('core.export', 'com_membersmanager'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			JArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Countries');
			// get the data to export
			$data = $model->getExportData($pks);
			if (MembersmanagerHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				MembersmanagerHelper::xls($data,'Countries_'.$date->format('jS_F_Y'),'Countries exported ('.$date->format('jS F, Y').')','countries');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_MEMBERSMANAGER_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_membersmanager&view=countries', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('country.import', 'com_membersmanager') && $user->authorise('core.import', 'com_membersmanager'))
		{
			// Get the import model
			$model = $this->getModel('Countries');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (MembersmanagerHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('country_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'countries');
				$session->set('dataType_VDM_IMPORTINTO', 'country');
				// Redirect to import view.
				$message = JText::_('COM_MEMBERSMANAGER_IMPORT_SELECT_FILE_FOR_COUNTRIES');
				$this->setRedirect(JRoute::_('index.php?option=com_membersmanager&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_MEMBERSMANAGER_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_membersmanager&view=countries', false), $message, 'error');
		return;
	}  
}
