<?
defined('C5_EXECUTE') or die("Access Denied.");
?>

<?
$pk = PermissionKey::getByID($_REQUEST['pkID']);
$pk->setPermissionObject($node);
	
?>

<? Loader::element("permission/detail", array('permissionKey' => $pk)); ?>

<script type="text/javascript">
var ccm_permissionDialogURL = '<?=Loader::helper('concrete/urls')->getToolsURL('permissions/dialogs/tree/node')?>?treeNodeID=<?=$node->getTreeNodeID()?>';
</script>