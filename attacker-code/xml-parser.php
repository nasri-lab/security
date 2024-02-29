<?php 

	$xml_content = $_POST['xml_textarea_content'];
	
	$dom = new DOMDocument();
	$dom->loadXML($xml_content, LIBXML_NOENT);
	$user = simplexml_import_dom($dom);

	// Use the content of the XML
	$name = $user->name;
	echo "Hello, " . $name;



?>

