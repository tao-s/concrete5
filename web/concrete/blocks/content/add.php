<?
defined('C5_EXECUTE') or die("Access Denied.");
$fp = FilePermissions::getGlobal();
$tp = new TaskPermission();

?>

<div id="redactor-edit-content"></div>
<textarea style="display: none" id="redactor-content" name="content"></textarea>

<script type="text/javascript">

var CCM_EDITOR_SECURITY_TOKEN = "<?=Loader::helper('validation/token')->generate('editor')?>";

$(function() {
	$('#redactor-content').redactor({
        minHeight: '300',
        'concrete5': {
            filemanager: <?=$fp->canAccessFileManager()?>,
            sitemap: <?=$tp->canAccessSitemap()?>,
            lightbox: true
        },
		'plugins': [
            'fontcolor', 'concrete5inline', 'concrete5', 'underline'
		]
	});
});
</script>