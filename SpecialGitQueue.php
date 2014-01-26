<?php
	class SpecialGitQueue extends FormSpecialPage {
		
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
			
			if(empty($par)) {
				$this->table = new GitQueueTablePager();
				
				$out->addWikiText("This is the Git Request Queue. You can request a Git Repo at [[Special:GitQueueRequest]].");
				$out->addHTML( 
					$this->table->getNavigationBar()  . '<ol>' .
					$this->table->getBody() . '</ol>' . 
					$this->table->getNavigationBar()				
				);
			} else {
				//load form
				$this->id = $par;
				$this->data = GitQueueShared::getInfoById( $par );
				
				$form = $this->getForm();
				if ( $form->show() ) {
					$this->onSuccess();
				}
			}
		}
		
		function onSubmit( array $data ) {
			global $wgUser;
			
			if( !$wgUser->isAllowed( 'GitQueueAdmin' ) ) {
				// FIXME: Make it so they don't have a submit button
				return;
			}
			
			$dbw = wfGetDB( DB_MASTER );
			
			$dbw->update(
				'gitqueue',
				array (
					#field name => new value
					'gq_status' => $data["Status"]
				),
				array( 'gq_id = ' . $this->id )
			);
			
		}
		
		protected function getFormFields() {
			global $wgUser;
			
			$a = array(
				'id' => array( 
					'type' => 'hidden',
					'required' => true,
					'default' => $this->id
				),
				'GerritUsername' => array(
					'type' => 'text',
					'label-message' => 'gitqueue-gerrit-username',
					'tabindex' => '1',
					'size' => '45',
					'autofocus' => true,
					'default' => $this->data["gerritname"],
					'disabled' => true
				),
				'ProjectName' => array(
					'type' => 'text',
					'label-message' => 'gitqueue-project-name',
					'tabindex' => '2',
					'size' => '45',
					'default' => $this->data["projectname"],
					'disabled' => true
				),
				'WorkFlowType' => array(
					'type' => 'radio',
					'label-message' => 'gitqueue-workflow-label',
					'options' => array(
						#display => value
						'Open Merge' => 'open',
						'Merge Review' => 'merge'
					),
					'default' => $this->data["workflow"],
					'disabled' => true
				),
				'Comments' => array(
					'type' => 'textarea',
					'label-message' => 'gitqueue-comments-label',
					'tabindex' => '4',
					'default' => $this->data["comment"],
					'disabled' => true
				),

			);
			
			if( $wgUser->isAllowed( 'GitQueueAdmin' ) ) {
				
				$a['Status'] = array(
					'type' => 'radio',
					'label-message' => 'gitqueue-admin-status-label',
					'tabindex' => '5',
					'default' => $this->data["status"],
					'options' => array(
						'Open' => 'open',
						'On Hold' => 'hold',
						'Complete' => 'done'
					)
				);
				
			} else {
				$a['Status'] = array(
					'type' => 'radio',
					'label-message' => 'gitqueue-admin-status-label',
					'tabindex' => '5',
					'default' => $this->data["status"],
					'options' => array(
						'Open' => 'open',
						'On Hold' => 'hold',
						'Complete' => 'done'
					),
					'disabled' => true
				);
			}

			return $a;
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
				'fields' => array( 'gq_projectname', 'gq_requester', 'gq_submittime', 'gq_id' ),
				'conds' => array( 'gq_isdeleted' => 'FALSE')
			);
		}
	
	}