<?php
	class SpecialGitQueueRequest extends FormSpecialPage {
	
		function __construct() {
			parent::__construct( 'GitQueueRequest', 'GitQueueRequest' );
		}
		
		protected function getFormFields() {
			$a = array(
				'GerritUsername' => array(
					'type' => 'text',
					'label-message' => 'gitqueue-gerrit-username',
					'tabindex' => '1',
					'size' => '45',
					'autofocus' => true,
					'required' => true
				),
				'ProjectName' => array(
					'type' => 'text',
					'label-message' => 'gitqueue-project-name',
					'tabindex' => '2',
					'size' => '45',
					'required' => true
				),
				'WorkFlowType' => array(
					'type' => 'radio',
					'label-message' => 'gitqueue-workflow-label',
					'options' => array(
						#display => value
						'Open Merge' => 'open',
						'Merge Review' => 'merge'
					),
					'required' => true
				),
				'Comments' => array(
					'type' => 'textarea',
					'label-message' => 'gitqueue-comments-label',
					'tabindex' => '4',
				),
				'HasRead' => array(
					'type' => 'check',
					'label-message' => 'gitqueue-has-read-label',
				)
			);
			
			return $a;
		}
		
		function onSubmit( array $data ) {
			global $wgOut, $wgUser, $wgTitle;
			
			if($data["HasRead"] == false) {
				$wgOut->addWikiText("'''ERROR: Please confirm you have read the information.");
				return;
			}
			
			$dbw = wfGetDB( DB_MASTER );
			
			$result = $dbw->insert(
				"gitqueue",
				array(
					#field name => value
					"gq_requester" => $wgUser->getName(),
					"gq_gerritname" => $data["GerritUsername"],
					"gq_projectname" => $data["ProjectName"],
					"gq_status" => "new",
					"gq_workflow" => $data["WorkFlowType"],
					"gq_comment" => $data["Comments"],
					"gq_submittime" => wfTimestamp( TS_UNIX ),
					"gq_isdeleted" => false
				),
				__METHOD__
			);
			
			if( $result == true ) {
				$logEntry = new ManualLogEntry( 'gitqueue', 'add' );
				$logEntry->setPerformer( $wgUser );
				//FIXME: Make target the newly made repo
				$logEntry->setTarget( $wgTitle );
				
				$logid = $logEntry->insert();
				$logEntry->publish( $logid);
				//FIXME: This shouldn't have to be called, but in the execute method
				//       $form->show() isn't returning true for some reason
				$wgOut->addWikiText(wfTimestamp( TS_UNIX ) );
				$this->onSuccess();
			}
		}
		
		public function execute( $par ) {
			$this->setParameter( $par );
			$this->setHeaders();

			// This will throw exceptions if there's a problem
			$this->checkExecutePermissions( $this->getUser() );

			$form = $this->getForm();
			if ( $form->show() ) {
				$this->onSuccess();
			}
		}
		
		function onSuccess() {
			$out = $this->getOutput();
			$out->addWikiText( 'Successfully requested your Repo!' );
			$out->setPageTitle( $this->msg( 'gitqueue-request-success' ) );
			#$out->addWikiMsg( 'gitqueue-request-success-text', wfEscapeWikiText( $this->target ) );
		}
	}