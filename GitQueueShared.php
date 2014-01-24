<?php
	
class GitQueueShared {

	public static function getInfoById( $id ) {
		return array(
			"title" =>"Title",
			"requester" => "requester",
			"gerritname" => "gerritname",
			"comment" => "comments",
			"closer" => "closer",
			"projectname" => "projectname",
			"workflowtype" => "workflow type",
		);
	}

}