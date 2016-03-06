<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

updateCaches();

function updateCaches()
{
    updateCacheTags();
}

function updateCacheTags()
{
    // This is for updating caches
    require 'db.php';
    openDB();

    // generate new list of tags
    $result = mysql_query('SELECT Tags FROM Station');
    if (!$result) {
        echo str(mysql_error());
        exit;
    }

    $tags_new = array();
    while ($row = mysql_fetch_assoc($result)) {
        $tag_string = $row['Tags'];
        // $tag_string = str_replace(',', ' ', $tag_string);
        // $tag_string = str_replace(';', ' ', $tag_string);

        $tag_array = explode(',', $tag_string);
        foreach ($tag_array as $tag) {
            $tag_clean = strtolower(trim($tag));
            if ($tag_clean !== '') {
                if (!array_key_exists($tag_clean, $tags_new)) {
                    $tags_new[$tag_clean] = 1;
                } else {
                    $tags_new[$tag_clean] = $tags_new[$tag_clean] + 1;
                }
            }
        }
    }
    // generate old list of tags
    $result = mysql_query('SELECT TagName FROM TagCache');
    if (!$result) {
        echo str(mysql_error());
        exit;
    }

    $tags_old = array();
    while ($row = mysql_fetch_row($result)) {
        $tags_old[$row['TagName']] = $row['StationCount'];
    }

    // compare the arrays and update TagCache
    // remove unused tags
    foreach ($tags_old as $tag => $count) {
        if (!array_key_exists($tag, $tags_new)) {
            echo 'removed old:'.$tag.'<br/>';
            mysql_query("DELETE FROM TagCache WHERE TagName='".escape_string($tag)."'");
        }
    }
    // add new tags
    foreach ($tags_new as $tag => $count) {
        if (!array_key_exists($tag, $tags_old)) {
            echo 'added new:'.$tag.'<br/>';
            mysql_query("INSERT INTO TagCache (TagName,StationCount) VALUES ('".escape_string($tag)."',".$count.')');
        } else {
            if ($count !== $tags_old[$key]) {
                echo 'updated:'.$tag.' from '.$tags_old[$tag].' to '.$count.'<br/>';
                mysql_query('UPDATE TagCache SET StationCount='.$count." WHERE TagName='".escape_string($tag)."'");
            }
        }
    }
}
