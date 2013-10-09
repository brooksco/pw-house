<?php
/* * ****************************************************************************
  #                         BookingWizz for WordPress v1.2
  #******************************************************************************
  #      Author:     Convergine (http://www.convergine.com)
  #      Website:    http://www.convergine.com
  #      Support:    http://support.convergine.com
  #      Version:     1.2
  #
  #      Copyright:   (c) 2009 - 2012  Convergine.com
  #
  #****************************************************************************** */
//Load the database file


$BWContinue = true;


//1. check that includes/ is writable
//2. if not - throw error, else show form.
//3. form will have 4 fields for database and 1 field for license key and 1 key for user to enter future username name for this license key.
//4. after form submitted we need to show success message and further instructions.


if (!is_writable($BW_dir . "/includes/")) {
    @chmod($BW_dir . "/includes/", 0777);
    if (!is_writable($BW_dir . "/includes/")) {
        @chmod($BW_dir . "/includes/", 777);
        if (!is_writable($BW_dir . "/includes/")) {
            //chmoding didn't help. throw error
            $BWContinue = false;
            $BWMessage .= "<div class=error><b>ERROR!</b> Please set chmod 755 or 777 for directory \"includes\"</div>";
        }
    }
}


if (!is_writable($BW_dir . "/uploads/")) {
    @chmod($BW_dir . "/uploads/", 0777);
    if (!is_writable($BW_dir . "/uploads/")) {
        @chmod($BW_dir . "/uploads/", 777);
        if (!is_writable($BW_dir . "/uploads/")) {
            //chmoding didn't help. throw error
            $BWContinue = false;
            $BWMessage .= "<div class=error><b>ERROR!</b> Please set chmod 755 or 777 for directory \"uploads\"</div>";
        }
    }
}

if (!is_writable($BW_dir . "/log/")) {
    @chmod($BW_dir . "/log/", 0777);
    if (!is_writable($BW_dir . "/log/")) {
        @chmod($BW_dir . "/log/", 777);
        if (!is_writable($BW_dir . "/log/")) {
            //chmoding didn't help. throw error
            $BWContinue = false;
            $BWMessage .= "<div class=error><b>Warning!</b> Please set chmod 755 or 777 for directory \"log\"</div>";
        }
    }
}


if ($BWContinue) {


    // LOGIN

    $dbn = DB_NAME;
    $dbp = DB_PASSWORD;
    $dbu = DB_USER;
    $dbh = DB_HOST;



    //check DB connection.
    if ($link = @mysql_connect($dbh, $dbu, $dbp)) {
        if (@mysql_select_db($dbn, $link)) {
            $BWContinue = true;
        } else {
            $BWContinue = false;
            $BWMessage .= "<div class=error><b>ERROR!</b> Database doesn't exist!<br /> Please create it and try again.</div>";
        }
    } else {
        $BWContinue = false;
        $BWMessage .= "<div class=error><b>ERROR!</b> Couldn't connect to database with provided information. <br />Please check your input and try again.</div>";
    }


    if (!is_writable($BW_dir . "/includes/dbconnect.php")) {
        @chmod($BW_dir . "/includes/dbconnect.php", 0777);
        if (!is_writable($BW_dir . "/includes/dbconnect.php")) {
            //chmoding didn't help. throw error
            $BWContinue = false;
            $BWMessage .= "<div class=error><b>ERROR!</b> Please set chmod 755 or 777 for file \"includes/dbconnect.php\"</div>";
        }
    }

    if ($BWContinue) {

        //create mysql.php file
        $ourFileName = $BW_dir . "/includes/dbconnect.php";
        $fh = fopen($ourFileName, 'w+');
        $bdir = "/".get_option('BW_install_path')."/";
        $stringData = '<?php
						error_reporting(E_ALL ^ E_NOTICE);
                                                
						//EDIT ONLY FOLLOWING 5 LINES
						$db_host = \'' . $dbh . '\'; //hostname
						$db_user = \'' . $dbu . '\'; // username
						$db_password = \'' . $dbp . '\'; // password
						$db_name = \'' . $dbn . '\'; //database name
						$baseDir = \'' . $bdir . '\'; // Don\'t change this variable if you will be using booking in the ROOT of the username. 
						// otherwise - change to $baseDir = "/directoryName/"; WITH TRAILING SLASH!
						
						$demo=false;
						
						if(!empty($db_host) && !empty($db_user) && !empty($db_password) && !empty($db_name)){
							$link = mysql_connect($db_host, $db_user, $db_password) or die("1. Open dbconnect.php and edit mysql variables. <br/> 2. Run install.php ");
							@mysql_select_db($db_name);
						 	mysql_query("SET NAMES utf8") or die("err: " . mysql_error());
						} else { echo "Application not installed! <a href=\'install.php\'>Click here</a> to proceed with installation."; exit(); }
					?>';

        fwrite($fh, $stringData);
        fclose($fh);

       
        require_once($BW_dir . "/includes/sql.php");
    }
}
?>
