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

JHTML::_('behavior.modal');
jimport('joomla.installer.installer');
jimport('joomla.installer.helper');

/**
 * Script File of Membersmanager Component
 */
class com_membersmanagerInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent)
	{

	}

	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent)
	{
		// Get Application object
		$app = JFactory::getApplication();

		// Get The Database object
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Member alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_membersmanager.member') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$member_found = $db->getNumRows();
		// Now check if there were any rows
		if ($member_found)
		{
			// Since there are load the needed  member type ids
			$member_ids = $db->loadColumn();
			// Remove Member from the content type table
			$member_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_membersmanager.member') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($member_condition);
			$db->setQuery($query);
			// Execute the query to remove Member items
			$member_done = $db->execute();
			if ($member_done);
			{
				// If succesfully remove Member add queued success message.
				$app->enqueueMessage(JText::_('The (com_membersmanager.member) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Member items from the contentitem tag map table
			$member_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_membersmanager.member') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($member_condition);
			$db->setQuery($query);
			// Execute the query to remove Member items
			$member_done = $db->execute();
			if ($member_done);
			{
				// If succesfully remove Member add queued success message.
				$app->enqueueMessage(JText::_('The (com_membersmanager.member) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Member items from the ucm content table
			$member_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_membersmanager.member') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($member_condition);
			$db->setQuery($query);
			// Execute the query to remove Member items
			$member_done = $db->execute();
			if ($member_done);
			{
				// If succesfully remove Member add queued success message.
				$app->enqueueMessage(JText::_('The (com_membersmanager.member) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Member items are cleared from DB
			foreach ($member_ids as $member_id)
			{
				// Remove Member items from the ucm base table
				$member_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $member_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($member_condition);
				$db->setQuery($query);
				// Execute the query to remove Member items
				$db->execute();

				// Remove Member items from the ucm history table
				$member_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $member_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($member_condition);
				$db->setQuery($query);
				// Execute the query to remove Member items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Type alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_membersmanager.type') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$type_found = $db->getNumRows();
		// Now check if there were any rows
		if ($type_found)
		{
			// Since there are load the needed  type type ids
			$type_ids = $db->loadColumn();
			// Remove Type from the content type table
			$type_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_membersmanager.type') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($type_condition);
			$db->setQuery($query);
			// Execute the query to remove Type items
			$type_done = $db->execute();
			if ($type_done);
			{
				// If succesfully remove Type add queued success message.
				$app->enqueueMessage(JText::_('The (com_membersmanager.type) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Type items from the contentitem tag map table
			$type_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_membersmanager.type') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($type_condition);
			$db->setQuery($query);
			// Execute the query to remove Type items
			$type_done = $db->execute();
			if ($type_done);
			{
				// If succesfully remove Type add queued success message.
				$app->enqueueMessage(JText::_('The (com_membersmanager.type) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Type items from the ucm content table
			$type_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_membersmanager.type') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($type_condition);
			$db->setQuery($query);
			// Execute the query to remove Type items
			$type_done = $db->execute();
			if ($type_done);
			{
				// If succesfully remove Type add queued success message.
				$app->enqueueMessage(JText::_('The (com_membersmanager.type) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Type items are cleared from DB
			foreach ($type_ids as $type_id)
			{
				// Remove Type items from the ucm base table
				$type_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $type_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($type_condition);
				$db->setQuery($query);
				// Execute the query to remove Type items
				$db->execute();

				// Remove Type items from the ucm history table
				$type_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $type_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($type_condition);
				$db->setQuery($query);
				// Execute the query to remove Type items
				$db->execute();
			}
		}

		// If All related items was removed queued success message.
		$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_base</b> table'));
		$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_history</b> table'));

		// Remove membersmanager assets from the assets table
		$membersmanager_condition = array( $db->quoteName('name') . ' LIKE ' . $db->quote('com_membersmanager%') );

		// Create a new query object.
		$query = $db->getQuery(true);
		$query->delete($db->quoteName('#__assets'));
		$query->where($membersmanager_condition);
		$db->setQuery($query);
		$type_done = $db->execute();
		if ($type_done);
		{
			// If succesfully remove membersmanager add queued success message.
			$app->enqueueMessage(JText::_('All related items was removed from the <b>#__assets</b> table'));
		}

		// little notice as after service, in case of bad experience with component.
		echo '<h2>Did something go wrong? Are you disappointed?</h2>
		<p>Please let me know at <a href="mailto:llewellyn@joomlacomponentbuilder.com">llewellyn@joomlacomponentbuilder.com</a>.
		<br />We at Joomla Component Builder are committed to building extensions that performs proficiently! You can help us, really!
		<br />Send me your thoughts on improvements that is needed, trust me, I will be very grateful!
		<br />Visit us at <a href="https://www.joomlacomponentbuilder.com/" target="_blank">https://www.joomlacomponentbuilder.com/</a> today!</p>';
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent)
	{
		
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent)
	{
		// get application
		$app = JFactory::getApplication();
		// is redundant ...hmmm
		if ($type == 'uninstall')
		{
			return true;
		}
		// the default for both install and update
		$jversion = new JVersion();
		if (!$jversion->isCompatible('3.6.0'))
		{
			$app->enqueueMessage('Please upgrade to at least Joomla! 3.6.0 before continuing!', 'error');
			return false;
		}
		// do any updates needed
		if ($type == 'update')
		{
		}
		// do any install needed
		if ($type == 'install')
		{
		}
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent)
	{
		// get application
		$app = JFactory::getApplication();
		// set the default component settings
		if ($type == 'install')
		{

			// Get The Database object
			$db = JFactory::getDbo();

			// Create the member content type object.
			$member = new stdClass();
			$member->type_title = 'Membersmanager Member';
			$member->type_alias = 'com_membersmanager.member';
			$member->table = '{"special": {"dbtable": "#__membersmanager_member","key": "id","type": "Member","prefix": "membersmanagerTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$member->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "user","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"user":"user","landline_phone":"landline_phone","type":"type","account":"account","token":"token","country":"country","postalcode":"postalcode","city":"city","region":"region","street":"street","postal":"postal","mobile_phone":"mobile_phone","name":"name","website":"website","profile_image":"profile_image","not_required":"not_required","email":"email","main_member":"main_member"}}';
			$member->router = 'MembersmanagerHelperRoute::getMemberRoute';
			$member->content_history_options = '{"formFile": "administrator/components/com_membersmanager/models/forms/member.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","profile_image","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","user","type","account","country","region","main_member"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "user","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "type","targetTable": "#__membersmanager_type","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "country","targetTable": "#__membersmanager_country","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "region","targetTable": "#__membersmanager_region","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_member","targetTable": "#__membersmanager_member","targetColumn": "id","displayColumn": "user"}]}';

			// Set the object into the content types table.
			$member_Inserted = $db->insertObject('#__content_types', $member);

			// Create the type content type object.
			$type = new stdClass();
			$type->type_title = 'Membersmanager Type';
			$type->type_alias = 'com_membersmanager.type';
			$type->table = '{"special": {"dbtable": "#__membersmanager_type","key": "id","type": "Type","prefix": "membersmanagerTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$type->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description","alias":"alias"}}';
			$type->router = 'MembersmanagerHelperRoute::getTypeRoute';
			$type->content_history_options = '{"formFile": "administrator/components/com_membersmanager/models/forms/type.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$type_Inserted = $db->insertObject('#__content_types', $type);


			// Install the global extenstion params.
			$query = $db->getQuery(true);
			// Field to update.
			$fields = array(
				$db->quoteName('params') . ' = ' . $db->quote('{"autorName":"Llewellyn van der Merwe","autorEmail":"llewellyn@joomlacomponentbuilder.com","crop_profile":"1","profile_height":"300","profile_width":"200","check_in":"-1 day","save_history":"1","history_limit":"10","memberuser":["2"],"uikit_version":"2","uikit_load":"1","uikit_min":"","uikit_style":""}'),
			);
			// Condition.
			$conditions = array(
				$db->quoteName('element') . ' = ' . $db->quote('com_membersmanager')
			);
			$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$allDone = $db->execute();

			echo '<a target="_blank" href="https://www.joomlacomponentbuilder.com/" title="Members Manager">
				<img src="components/com_membersmanager/assets/images/vdm-component.jpg"/>
				</a>';
		}
		// do any updates needed
		if ($type == 'update')
		{

			// Get The Database object
			$db = JFactory::getDbo();

			// Create the member content type object.
			$member = new stdClass();
			$member->type_title = 'Membersmanager Member';
			$member->type_alias = 'com_membersmanager.member';
			$member->table = '{"special": {"dbtable": "#__membersmanager_member","key": "id","type": "Member","prefix": "membersmanagerTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$member->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "user","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"user":"user","landline_phone":"landline_phone","type":"type","account":"account","token":"token","country":"country","postalcode":"postalcode","city":"city","region":"region","street":"street","postal":"postal","mobile_phone":"mobile_phone","name":"name","website":"website","profile_image":"profile_image","not_required":"not_required","email":"email","main_member":"main_member"}}';
			$member->router = 'MembersmanagerHelperRoute::getMemberRoute';
			$member->content_history_options = '{"formFile": "administrator/components/com_membersmanager/models/forms/member.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","profile_image","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","user","type","account","country","region","main_member"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "user","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "type","targetTable": "#__membersmanager_type","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "country","targetTable": "#__membersmanager_country","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "region","targetTable": "#__membersmanager_region","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_member","targetTable": "#__membersmanager_member","targetColumn": "id","displayColumn": "user"}]}';

			// Check if member type is already in content_type DB.
			$member_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($member->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$member->type_id = $db->loadResult();
				$member_Updated = $db->updateObject('#__content_types', $member, 'type_id');
			}
			else
			{
				$member_Inserted = $db->insertObject('#__content_types', $member);
			}

			// Create the type content type object.
			$type = new stdClass();
			$type->type_title = 'Membersmanager Type';
			$type->type_alias = 'com_membersmanager.type';
			$type->table = '{"special": {"dbtable": "#__membersmanager_type","key": "id","type": "Type","prefix": "membersmanagerTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$type->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description","alias":"alias"}}';
			$type->router = 'MembersmanagerHelperRoute::getTypeRoute';
			$type->content_history_options = '{"formFile": "administrator/components/com_membersmanager/models/forms/type.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Check if type type is already in content_type DB.
			$type_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($type->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$type->type_id = $db->loadResult();
				$type_Updated = $db->updateObject('#__content_types', $type, 'type_id');
			}
			else
			{
				$type_Inserted = $db->insertObject('#__content_types', $type);
			}


			echo '<a target="_blank" href="https://www.joomlacomponentbuilder.com/" title="Members Manager">
				<img src="components/com_membersmanager/assets/images/vdm-component.jpg"/>
				</a>
				<h3>Upgrade to Version 1.0.7 Was Successful! Let us know if anything is not working as expected.</h3>';
		}
	}
}
