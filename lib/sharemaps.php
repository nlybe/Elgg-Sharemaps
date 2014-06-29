<?php
/**
 * Elgg sharemaps helper functions
 *
 * @package ElggShareMaps
 */

/**
 * Prepare the upload/edit form variables
 *
 * @param SharemapsPluginMap $sharemaps
 * @return array
 */
function sharemaps_prepare_form_vars($sharemaps = null) {

	// input names => defaults
	$values = array(
            'title' => '',
            'description' => '',
            'access_id' => ACCESS_DEFAULT,
            'tags' => '',
            'container_guid' => elgg_get_page_owner_guid(),
            'guid' => null,
            'entity' => $sharemaps,
	);

	if ($sharemaps) {
		foreach (array_keys($values) as $field) {
			if (isset($sharemaps->$field)) {
				$values[$field] = $sharemaps->$field;
			}
		}
	}

	if (elgg_is_sticky_form('sharemaps')) {
		$sticky_values = elgg_get_sticky_values('sharemaps');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('sharemaps');

	return $values;
}

function sharemaps_prepare_form_vars_gmaplink($sharemaps = null) {

	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
                'gmaplink' => '',
		'entity' => $sharemaps,
	);

	if ($sharemaps) {
		foreach (array_keys($values) as $field) {
			if (isset($sharemaps->$field)) {
				$values[$field] = $sharemaps->$field;
			}
		}
	}

	if (elgg_is_sticky_form('sharemaps')) {
		$sticky_values = elgg_get_sticky_values('sharemaps');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('sharemaps');

	return $values;
}

/**
* Validate URL
*/
function is_valid_url($url)
{
    //print_r('xxxxxxxxxxxxxxxx'); 
    if (!($url = @parse_url($url)))
    {
        return false;
    }
 
    //$url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port']; // disable in order to include https
    $url['path'] = (!empty($url['path'])) ? $url['path'] : '/';
    $url['path'] .= (isset($url['query'])) ? "?$url[query]" : '';
 
    if (isset($url['host']) AND $url['host'] != @gethostbyname($url['host']))
    {
        if (PHP_VERSION >= 5)
        {
            $headers = @implode('', @get_headers("$url[scheme]://$url[host]:$url[port]$url[path]"));
        }
        else
        {
            if (!($fp = @fsockopen($url['host'], $url['port'], $errno, $errstr, 10)))
            {
                return false;
            }
            fputs($fp, "HEAD $url[path] HTTP/1.1\r\nHost: $url[host]\r\n\r\n");
            $headers = fread($fp, 4096);
            fclose($fp);
        }
        return (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);
    }
    
    return false;
}

/**
* Alternative simplest method for Validate URL
*/
function is_valid_url_2($url)
{
    return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}


// get file path with a given guid
function getFilePath($eid)
{
    $file_guid = $eid;

    // Get the file
    //$mapobject = new SharemapsPluginMap($eid);
    $mapobject = get_entity($file_guid);
    if (!$mapobject) {
            return false;
    }

    return $mapobject->getFilenameOnFilestore();
}