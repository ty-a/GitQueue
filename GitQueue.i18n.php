 <?php
/**
 * Internationalisation for GitQueue
 *
 * @file
 * @ingroup Extensions
 */
$messages = array();
 
/** English
 * @author TyA
 */
$messages[ 'en' ] = array(
	'gitqueue' => "Git Queue", // Important! This is the string that appears on Special:SpecialPages
	'gitqueuerequest' => "Request a Git Repo",
	'gitqueuerequest-legend' => "Request a Git Repo",
	'gitqueue-description' => "Provides a queue to request new Git Repos",
	'gitqueue-no-gerrit' => "Please provide your gerrit username",
	'gitqueue-no-project' => "Please provide a project name",
	'gitqueue-no-workflow' => "Please provide a workflow type",
	'gitqueue-has-not-read' => "Please confirm you have read the required information",
	'gitqueue-no-admin-selection' => "You haven't marked this request as Done, Not Done, or On Hold",
	'gitqueue-gerrit-username' => 'Gerrit Username:',
	'gitqueue-project-name' => 'Project name:',
	'gitqueue-workflow-label' => 'Workflow',
	'gitqueue-comments-label' => 'Additional Comments',
	'gitqueue-has-read-label' => 'I have read the necessary pages',
	'action-GitQueueRequest' => 'request a Git repo',
	'log-name-gitqueue' => 'Git Queue log',	
	'log-description-gitqueue' => 'This log tracks the various actions performed in the Git Queue extension.',
	'logentry-gitqueue-add' => '$1 requested a new Git Repo.',
	'gitqueue-request-success' => 'Success',
	'gitqueue-request-success-test' => 'You have successfully request a Git Repo.'
);