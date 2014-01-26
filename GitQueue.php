<?php
	if ( !defined( 'MEDIAWIKI' ) ) {
		echo <<<EOT
To install my extension, please put the following line in LocalSettings.php:
require_once( "\$IP/extensions/GitQueue/GitQueue.php" );
EOT;
		exit( 1 );
	}
	
	$wgExtensionCredits[ 'specialpage' ][] = array(
		'path' => __FILE__,
		'name' => 'GitQueue',
		'author' => 'TyA',
		'url' => 'placeholder',
		'descriptionmsg' => 'gitqueue-description',
		'version' => '0.0',
	);
	
	$wgAutoloadClasses[ 'SpecialGitQueue' ] = __DIR__ . '/SpecialGitQueue.php';
	$wgAutoloadClasses[ 'SpecialGitQueueRequest' ] = __DIR__ . '/SpecialGitQueueRequest.php';
	$wgAutoloadClasses[ 'GitQueueShared' ] = __DIR__ . '/GitQueueShared.php';
	
	$wgExtensionMessagesFiles[ 'GitQueue' ] = __DIR__ . '/GitQueue.i18n.php';
	
	$wgSpecialPages[ 'GitQueue' ] = 'SpecialGitQueue';
	$wgSpecialPages[ 'GitQueueRequest' ] = 'SpecialGitQueueRequest';
	
	$wgSpecialPageGroups[ 'GitQueue' ] = 'other';
	$wgSpecialPageGroups[ 'GitQueueRequest' ] = 'other';
	
	$wgGroupPermissions[ '*' ][ 'GitQueueAdmin' ] = false;
	$wgGroupPermissions[ 'sysop' ][ 'GitQueueAdmin' ] = true;
	
	$wgGroupPermissions[ '*' ][ 'GitQueueRequest' ] = false;
	$wgGroupPermissions[ 'user' ][ 'GitQueueRequest' ] = true;
	
	$wgGroupPermissions[ '*' ]['GitQueue'] = true;
	
	# Schema updates for update.php
	$wgHooks['LoadExtensionSchemaUpdates'][] = 'fnAddTable';
	function fnAddTable( DatabaseUpdater $updater ) {
		$updater->addExtensionTable( 'gitqueue',
			dirname( __FILE__ ) . '/table.sql', true );
		return true;
	}
	
	$wgLogTypes[] = 'gitqueue';
	$wgLogActionsHandlers['gitqueue/add'] = 'LogFormatter';
	$wgLogActionsHandlers['gitqueue/delete'] = 'LogFormatter';
	$wgLogActionsHandlers['gitqueue/undelete'] = 'LogFormatter';
	$wgLogActionsHandlers['gitqueue/change'] = 'LogFormatter';