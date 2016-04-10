<?php
require 'db.php';

if (isset($_REQUEST['action'])) {
    // open database
    $db = openDB();
    // check parameters, set default values
    $format = isset($_GET['format']) ? $_GET['format'] : 'xml';
    $term = isset($_GET['term']) ? $_GET['term'] : '';
    $country = isset($_GET['country']) ? $_GET['country'] : '';
    $limit = isset($_GET['limit']) ? $_GET['limit'] : '10';
    $stationid = isset($_GET['stationid']) ? $_GET['stationid'] : '10';

    if ($_REQUEST['action'] == 'tags') {
        print_tags($db, $format, $term);
    }elseif ($_REQUEST['action'] == 'countries') {
        print_1_n($db, $format, 'Country', 'country', $term);
    }elseif ($_REQUEST['action'] == 'states') {
        print_states($db, $format, $term, $country);
    }elseif ($_REQUEST['action'] == 'languages') {
        print_1_n($db, $format, 'Language', 'language', $term);
    }elseif ($_REQUEST['action'] == 'stats') {
        print_stats($db, $format);
    }elseif ($_REQUEST['action'] == 'data_search_topvote') {
        print_stations_top_vote_data($db, $format, $limit);
    }elseif ($_REQUEST['action'] == 'data_search_topclick') {
        print_stations_top_click_data($db, $format, $limit);
    }elseif ($_REQUEST['action'] == 'data_search_lastclick') {
        print_stations_last_click_data($db, $format, $limit);
    }elseif ($_REQUEST['action'] == 'data_search_lastchange') {
        print_stations_last_change_data($db, $format, $limit);
    }elseif ($_REQUEST['action'] == 'data_search') {
        print_stations_list_data($db, $format, 'Name', $term);
    }elseif ($_REQUEST['action'] == 'data_search_name') {
        print_stations_list_data($db, $format, 'Name', $term);
    }elseif ($_REQUEST['action'] == 'data_search_name_exact') {
        print_stations_list_data_exact($db, $format, 'Name', $term, false);
    }elseif ($_REQUEST['action'] == 'data_search_bycountry') {
        print_stations_list_data($db, $format, 'Country', $term);
    }elseif ($_REQUEST['action'] == 'data_search_bycountry_exact') {
        print_stations_list_data_exact($db, $format, 'Country', $term, false);
    }elseif ($_REQUEST['action'] == 'data_search_bystate') {
        print_stations_list_data($db, $format, 'Subcountry', $term);
    }elseif ($_REQUEST['action'] == 'data_search_bystate_exact') {
        print_stations_list_data_exact($db, $format, 'Subcountry', $term, false);
    }elseif ($_REQUEST['action'] == 'data_search_bylanguage') {
        print_stations_list_data($db, $format, 'Language', $term);
    }elseif ($_REQUEST['action'] == 'data_search_bylanguage_exact') {
        print_stations_list_data_exact($db, $format, 'Language', $term, false);
    }elseif ($_REQUEST['action'] == 'data_search_bytag') {
        print_stations_list_data($db, $format, 'Tags', $term);
    }elseif ($_REQUEST['action'] == 'data_search_bytag_exact') {
        print_stations_list_data_exact($db, $format, 'Tags', $term, true);
    }elseif ($_REQUEST['action'] == 'data_search_byid') {
        print_stations_list_data_exact($db, $format, 'StationID', $term, false);
    }elseif ($_REQUEST['action'] == 'add') {
        addStation($db, $_REQUEST['name'], $_REQUEST['url'], $_REQUEST['homepage'], $_REQUEST['favicon'], $_REQUEST['country'], $_REQUEST['language'], $_REQUEST['tags'], $_REQUEST['state']);
    }elseif ($_REQUEST['action'] == 'edit') {
        editStation($db, $_REQUEST['stationid'], $_REQUEST['name'], $_REQUEST['url'], $_REQUEST['homepage'], $_REQUEST['favicon'], $_REQUEST['country'], $_REQUEST['language'], $_REQUEST['tags'], $_REQUEST['state']);
    }elseif ($_REQUEST['action'] == 'delete') {
        echo 'delete:'.$_REQUEST['stationid'];
        deleteStation($db, $stationid);
    }elseif ($_REQUEST['action'] == 'vote') {
        voteForStation($db, $format, $stationid);
    }elseif ($_REQUEST['action'] == 'negativevote') {
        negativeVoteForStation($db, $format, $stationid);
    }
} else {
    ?>
<!doctype html>
<html>
	<head>
		<meta http-equiv="refresh" content="0; URL=http://www.radio-browser.info/gui/">
		<meta charset="utf-8">
		<title>Community Radio Station Board</title>
	</head>
	<body>
	</body>
</html>
<?php

}
?>
