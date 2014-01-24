<?php
	class SpecialGitQueue extends SpecialPage {
	
		function __construct() {
			parent::__construct( 'GitQueue', 'GitQueue' );
		}
		#@TODO: Implement
		function execute( $par ) {
			global $wgOut;
			$this->setHeaders();
			$wgOut->addWikiText('add queue here');
		}
	}