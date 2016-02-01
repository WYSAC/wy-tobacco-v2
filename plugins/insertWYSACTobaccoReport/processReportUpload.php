<?php 

function gps($thing) // Gets either the GET or POST from the form and retuns the value. Returns empty string if both not set
{
    $out = '';
    // if $thing is a GET, make $out the value
    if (isset($_GET[$thing])) {
        $out = $_GET[$thing];
    // else if $thing is a POST variable, make $out the value
    } else if (isset($_POST[$thing])) {
        $out = $_POST[$thing];
    }
    return $out;
}

// Connect to the SQLServ DB
function sqlsrvConnect() {
    // Functionalized it for later OOB
    $serverName         = "qserv\sql2008"; //serverName\instanceName
    $connectionInfo     = array( "Database"=>"WYSAC_Website", "UID"=>"wysacweb_app", "PWD"=>"1p7kS5kiRp(dj33q");

    return sqlsrv_connect( $serverName, $connectionInfo);
}

// Call to the SP
function callStoredProcedure($conn, $spName,$spParams) {

    // Count total array parameters
    $ttlParams = count($spParams);

    // define string
    $spData = '';

    // Build string Component
    for ($i = 0; $i <= $ttlParams-1; $i++) {
        // if string value is not null, add a placeholder as [?]
        if($spParams[$i][0] != 'null') {
            $spData[$i] = '?';
        } else if($spParams[$i][0] == 'null') {
            // insert blank array space holder
            $spData[$i] = '';
            // delete the array entry from the spParams
            unset($spParams[$i]);
        }
    }

    // Turn array into comma delimited string
    $spComponent = implode(', ',$spData);

    // Build Stored Procedure Call
    $sp = "{ call $spName($spComponent) }";

    // Call the Stored Procedure
    $result = sqlsrv_query( $conn, $sp, $spParams);

    // if there is a result, Makes the next result of the specified statement active
	// @TODO Probably should move this to a different function as this is specialized for WYTOBACCO
    if($next_result = sqlsrv_next_result($result)) {
        while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)){

            // Get the ID and Report Name.
			$result = array(
				"success" => TRUE,
				"report_name" => $row['report_name'],
				"report_id" => $row['report_id']
			);
            return $result;
        }
    } elseif( is_null($next_result)) {
        // no result return to script
        return;
    } else {
        // Return whatever sql serv error there was
			$result = array(
				"success" => FALSE,
				"errors"  => sqlsrv_errors()
			);
            return $result;

    }
}

function getReportData($report_id = NULL, $search_text = NULL){

    $conn = sqlsrvConnect();

    $spParams = array(
        array(NULL,1), // recordset.
        array(NULL,1), // debug
        array(NULL,1), // report_id
        array(NULL,1), // center_id
        array(NULL,1), // client_id
        array(NULL,1), // project_id
        array(NULL,1), // report_type_id
        array(NULL,1), // report_public
        array(NULL,1), // report_scope_id
        array(NULL,1), // report_keywords
        array(NULL,1), // start_date
        array(NULL,1), // end_date
        array($search_text,1), // search_text
        array(NULL,1)  // order_by
    );

    $sp = "{ call dbo.Report_WyomingTobaccoGet_SP(?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";

    $result = sqlsrv_query($conn, $sp, $spParams);

    if($result) {
        // get results of query
        $out = sqlsrv_fetch_array($result);
        if($out) {
            // place results in return array. We only need report name and the description
            $result = array(
                "report_name" 		=> $out['report_name'],
                "short_description" => $out['report_short_description'],
				"report_id"			=> $out['report_id']
            );
            return $result;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function processReportUpload() {
    // Build filepath
    $uploadfile = getcwd() . '/tmp/' . basename($_FILES['file']['name']);
    // If move from temp PHP directory == success, then true
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {


	// Check to see if this is a duplicate report
	$isDuplicate = getReportData(NULL, gps('report_name'));

	if($isDuplicate) {
		unlink($uploadfile);
		// Put result in a encoded JSON return	
    		$out = array(
    		    "result" => 'duplicate',
    		    "report_name" => $isDuplicate['report_name'],
    		    "description" => $isDuplicate['short_description'],
				"report_id"	  => $out['report_id']
    		);
    	return json_encode($out);
	}
    //// Start building query
        // Get the file as binary
        $report_data		= file_get_contents($uploadfile);
		// Report Name - Used to check for duplicates
		$report_name 		= gps('report_name');
		// Report Short Description
		$short_description	= gps('short_description');
        // New Report?
        $reportStatus 		= gps('reportNew');
        // Author ID
        $aud = gps('report_author_id');
            $report_owner_author_id = $aud;
            $report_the_user_id     = $aud;
        // Scope of Data
        $report_type_id         = gps('report_type_id');
        // Scope of Data
        $report_scope_id        = gps('report_scope_id');
        // Publication Number
        $pid                    = gps('report_number');
        // Filename 
        $report_file_name       = basename($_FILES['file']['name']);
        // Publication Date. Tenatively date of import.
        $report_publication_date = date("m-d-y"); // xx-xx-xxxx
        // report filesize
        $report_file_size       = filesize($uploadfile);
        
        // set report ID to null if it is a new report, otherwise, use $stored_report_id
        //$report_id = ($reportStatus == 0) ? NULL : $reportStatus;
                     
        // Build Parameters
        $spParams = array(
            array(NULL, 1), // @recordset BIT = NULL
            array(NULL, 1), // @report_id INT = NULL
            array($report_owner_author_id, 1), // @report_owner_author_id SMALLINT
            array($report_id, 1), // @report_project_id VARCHAR(100)
            array($report_name, 1), // @report_name UNIQUE VARCHAR(100)
            array($short_description, 1), // @short_description VARCHAR 250
            array($pid, 1), // @report_number VARCHAR(50)
            array($report_publication_date, 1), // @report_publication_date
            array(1, 1), // @report_type BIT
            array($report_type_id, 1), // @report_type_id TINYINT
            array('http://', 1), // @report_link @TODO VARCHAR(100)
            array(1, 1), // @report_file_type_id TINYINT
            array($report_file_size, 1), // @report_file_size VARCHAR(10)
            array($report_file_name, 1), // @report_file_name @TODO VARCHAR(100)
            array($report_file_name, 1), // @report_file_name_new @TODO VARCHAR(150)
            array('pdf', 1), // @report_file_type_extension VARCHAR(5)
            array('application/pdf', 1), // @report_mime_type VARCHAR(100) - assume PDF
            array(1, 1), // @report_data_change BIT
            array($report_data, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY)), // @report_data VARBINARY(MAX)
            array(1, 1), // @report_public BIT
            array($report_scope_id, 1), // @report_scope_id TINYINT
            array($report_the_user_id, 1) // @report_the_user_id TINYINT
        );
        
        // call the procedure
        $result = callStoredProcedure(sqlsrvConnect(), 'Report_WyomingTobaccoEdit_SP', $spParams);

        // if JSON result TRUE
    	if ($result['success']) {
    		unlink($uploadfile); // Delete uploaded file as its now in DB
			// prepare JSON data pairs in to array
    		$out = array(
    		    "result" => 'success',
    		    "post_ID" => gps('post_ID'),
    		    "description" => gps('short_description'),
    		    "category" => gps('category'),
    		    "scope" => gps('sod'),
    		    "publication_number" => gps('pid'),
				"report_id" => $result['report_id'],
				"report_name" => $result['report_name']
    		);
    		// return array as json
    		return json_encode($out);
    		
    	} else {
    	    $error = print_r($result, TRUE);
    	    // if anything else, return error
			$out = array(
				"result" => "error" . $error
			);
    	    return json_encode($out);
    	}
    }
}

if(gps('id') == 'upload') {
    echo processReportUpload();
}

?>