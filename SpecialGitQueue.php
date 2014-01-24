<?php
	class SpecialGitQueue extends SpecialPage {
	
		function __construct() {
			parent::__construct( 'GitQueue', 'GitQueue' );
		}
		function execute( $par ) {
			$out = $this->getOutput();
			
			$this->setHeaders();
			
			if( !$this->userCanExecute( $this->getUser() )  ) {
				$this->displayRestrictionError();
				return;
			}
			
			$this->table = new GitQueueTablePager();
			
			$out->addHTML( 
				$this->table->getNavigationBar()  . '<ol>' .
				$this->table->getBody() . '</ol>' . 
				$this->table->getNavigationBar()				
			);
		}
	}
	
	class GitQueueTablePager extends TablePager {
	
		function isFieldSortable( $field ) {
			return '';
		}
		
		function formatValue( $field, $value) {
			switch( $field ) {
				case 'gq_projectname':
					return $value;
					break;
				case 'gq_requester':
					return $value;
					break;
				case 'gq_submittime':
					return htmlspecialchars( $this->getLanguage()->userTimeAndDate( $value, $this->getUser() ) );
					break;
			}
		}
		
		function getDefaultSort() {
			return 'gq_submittime';
		}
		
		function getIndexField() {
			return 'gq_submittime';
		}
		
		function getFieldNames() {
			return array(
				'gq_projectname' => 'Project',
				'gq_requester' => 'Requester',
				'gq_submittime' => 'Submitted'
			);
		}
		
		function getQueryInfo() {
			return array(
				'tables' => 'gitqueue',
				'fields' => array( 'gq_projectname', 'gq_requester', 'gq_submittime' ),
				'conds' => array( 'gq_isdeleted' => 'FALSE')
			);
		}
	
	}