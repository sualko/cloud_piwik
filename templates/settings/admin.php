<?php
script('piwik', 'settings/admin');
style('piwik', 'settings');
?>

<div id="piwikSettings" class="section">
	<h2>Piwik/Matomo Tracking</h2>
	<p class="settings-hint">If you have no Piwik/Matomo instance, go to <a href="https://matomo.org" target="_blank">matomo.org</a> for further instructions.</p>
	<p class="settings-hint">Please take into account that the old values are cached for 2 minutes in your browser.</p>

	<form>
		<table>
			<tr>
				<td><label for="piwikSiteId">Site ID </label></td>
				<td><input type="number" name="siteId" id="piwikSiteId" pattern="[0-9]+" value="<?php p($_['siteId']);?>" /></td>
			</tr>
			<tr>
				<td><label for="piwikUrl">Piwik/Matomo Url </label></td>
				<td><input type="url" name="url" id="piwikUrl" value="<?php p($_['url']);?>" /></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="checkbox" name="trackDir" id="piwikTrackDir" class="checkbox" <?php if ($_['trackDir']): ?> checked="checked"<?php endif; ?> />
					<label for="piwikTrackDir">Track file browsing </label>	
				</td>
			</tr>
		</table>
	</form>
</div>
