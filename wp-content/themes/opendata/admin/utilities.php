<?php

function directoryToArray($directory, $recursive) {
	$array_items = array();
	if ($handle = opendir($directory)) {
		while (false !== ($file = readdir($handle))) {
			$ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $file);			
			if ($file != "." && $file != ".." && $ext == "png") {
				if (is_dir($directory. "/" . $file)) {
					if($recursive) {
						$array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
					}
					$file = $file;
					$array_items[] = preg_replace("/\/\//si", "/", $file);
				} else {
					$file = $file;
					$array_items[] = preg_replace("/\/\//si", "/", $file);
				}
			}
		}
		closedir($handle);
	}
	return $array_items;
}

?>