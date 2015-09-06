<?php
OCP\User::checkAdminUser ();

OCP\Util::addScript ( "piwik", "settings-admin" );

$tmpl = new OCP\Template ( 'piwik', 'settings-admin' );

return $tmpl->fetchPage ();
?>
