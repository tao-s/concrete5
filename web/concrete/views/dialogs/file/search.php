<?
defined('C5_EXECUTE') or die("Access Denied.");
?>

<div data-search="files" class="ccm-ui">
<? Loader::element('files/search', array('controller' => $searchController))?>
</div>

<script type="text/javascript">
$(function() {
	$('div[data-search=files]').concreteFileManager({
		result: <?=$result?>,
		mode: 'choose',
		upload_token: '<?=Core::make('token')->generate()?>'
	});
});
</script>