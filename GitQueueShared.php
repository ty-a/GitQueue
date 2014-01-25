<?php
	
class GitQueueShared {

	public static function getInfoById( $id ) {
		$dbr = wfGetDB( DB_SLAVE );
		
		$data = $dbr->select(
			'gitqueue',
			array( 'gq_requester', 'gq_gerritname', 'gq_comment', 'gq_closer', 'gq_projectname', 'gq_workflow' ),
			'gq_id = ' . $id,
			__METHOD__
		);	
		
		foreach( $data as $row ) {
			$result = array(
				"title" =>$row->gq_projectname,
				"requester" => $row->gq_requester,
				"gerritname" => $row->gq_gerritname,
				"comment" => $row->gq_comment,
				"closer" => $row->gq_comment,
				"projectname" => $row->gq_projectname,
				"workflow" => $row->gq_workflow,
			);
		}
		return $result; 
	}
}