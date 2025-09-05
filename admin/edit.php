<?php
// Deprecated: this admin path has moved.
header('Location: /admin.indonesiapasstravel.com/edit.php'.(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : ''), true, 301);
exit;
