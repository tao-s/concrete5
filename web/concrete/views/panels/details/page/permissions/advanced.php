<?
defined('C5_EXECUTE') or die("Access Denied.");
?>
<section class="ccm-ui">
	<header><?=t('Page Permissions')?></header>

	<?
	  $cpc = $c->getPermissionsCollectionObject();
	if ($c->getCollectionInheritance() == "PARENT") { ?>
		<div class="alert alert-info"><?=t('This page inherits its permissions from:');?> <a target="_blank" href="<?=URL::to($cpc)?>"><?=$cpc->getCollectionName()?></a></div>
	<? } ?>		


	<div>
		<div class="form-group">
			<label for="ccm-page-permissions-inherit"><?=t('Assign Permissions')?></label>
			<select id="ccm-page-permissions-inherit" class="form-control">
			<? if ($c->getCollectionID() > 1) { ?><option value="PARENT" <? if ($c->getCollectionInheritance() == "PARENT") { ?> selected<? } ?>><?=t('By Area of Site (Hierarchy)')?></option><? } ?>
			<? if ($c->getMasterCollectionID() > 1) { ?><option value="TEMPLATE"  <? if ($c->getCollectionInheritance() == "TEMPLATE") { ?> selected<? } ?>><?=t('From Page Type Defaults')?></option><? } ?>
			<option value="OVERRIDE" <? if ($c->getCollectionInheritance() == "OVERRIDE") { ?> selected<? } ?>><?=t('Manually')?></option>
			</select>
		</div>
	<? if (!$c->isMasterCollection()) { ?>
		<div class="form-group">
			<label for="ccm-page-permissions-subpages-override-template-permissions"><?=t('Subpage Permissions')?></label>
			<select id="ccm-page-permissions-subpages-override-template-permissions" class="form-control">
				<option value="0"<? if (!$c->overrideTemplatePermissions()) { ?>selected<? } ?>><?=t('Inherit page type default permissions.')?></option>
				<option value="1"<? if ($c->overrideTemplatePermissions()) { ?>selected<? } ?>><?=t('Inherit the permissions of this page.')?></option>
			</select>
		</div>
	<? } ?>
	</div>

	<hr/>
	
	<p class="lead"><?=t('Current Permission Set')?></p>

    <? $cat = PermissionKeyCategory::getByHandle('page');?>
	<form method="post" id="ccm-permission-list-form" data-dialog-form="permissions" data-panel-detail-form="permissions" action="<?=$cat->getToolsURL("save_permission_assignments")?>&cID=<?=$c->getCollectionID()?>">
        <? Loader::element('permission/lists/page', array(
            'page' => $c, 'editPermissions' => $editPermissions
        ))?>
    </form>
</section>

<div id="ccm-page-permissions-confirm-dialog" style="display: none">
    <?=t('Changing this setting will affect this page immediately. Are you sure?')?>
    <div id="dialog-buttons-start">
        <input type="button" class="btn btn-default pull-left" value="Cancel" onclick="jQuery.fn.dialog.closeTop()" />
        <input type="button" class="btn btn-primary pull-right" value="Ok" onclick="ccm_pagePermissionsConfirmInheritanceChange()" />
    </div>
</div>

<? if ($editPermissions) { ?>
    <div class="ccm-panel-detail-form-actions dialog-buttons">
        <button class="pull-left btn btn-default" type="button" data-dialog-action="cancel" data-panel-detail-action="cancel"><?=t('Cancel')?></button>
        <button class="pull-right btn btn-success" type="button" data-dialog-action="submit" data-panel-detail-action="submit"><?=t('Save Changes')?></button>
    </div>
<? } ?>


<script type="text/javascript">
var inheritanceVal = '';

ccm_pagePermissionsCancelInheritance = function() {
	$('#ccm-page-permissions-inherit').val(inheritanceVal);
}

ccm_pagePermissionsConfirmInheritanceChange = function() { 
	jQuery.fn.dialog.showLoader();
	$.getJSON('<?=$cat->getToolsURL("change_permission_inheritance")?>&cID=<?=$c->getCollectionID()?>&mode=' + $('#ccm-page-permissions-inherit').val(), function(r) {
		if (r.deferred) {
			jQuery.fn.dialog.closeAll();
			jQuery.fn.dialog.hideLoader();
			ConcreteAlert.notify({
			'message': ccmi18n.setPermissionsDeferredMsg,
			'title': ccmi18n.setPagePermissions
			});
		} else {
			jQuery.fn.dialog.closeTop();
			ccm_refreshPagePermissions();
		}
	});
}


$(function() {
	$('#ccm-permission-list-form').ajaxForm({
		dataType: 'json',
		
		beforeSubmit: function() {
			jQuery.fn.dialog.showLoader();
		},
		
		success: function(r) {
			jQuery.fn.dialog.hideLoader();
			jQuery.fn.dialog.closeTop();
			if (!r.deferred) {
				ConcreteAlert.notify({
				'message': ccmi18n.setPermissionsMsg,
				'title': ccmi18n.setPagePermissions
				});			
			} else {
				jQuery.fn.dialog.closeTop();
				ConcreteAlert.notify({
				'message': ccmi18n.setPermissionsDeferredMsg,
				'title': ccmi18n.setPagePermissions
				});				
			}

		}		
	});
	
	inheritanceVal = $('#ccm-page-permissions-inherit').val();
	$('#ccm-page-permissions-inherit').change(function() {
		$('#dialog-buttons-start').addClass('dialog-buttons');
		jQuery.fn.dialog.open({
			element: '#ccm-page-permissions-confirm-dialog',
			title: '<?=t("Confirm Change")?>',
			width: 280,
			height: 160,
			onClose: function() {
				ccm_pagePermissionsCancelInheritance();
			}
		});
	});
	
	$('#ccm-page-permissions-subpages-override-template-permissions').change(function() {
		jQuery.fn.dialog.showLoader();
		$.getJSON('<?=$cat->getToolsURL("change_subpage_defaults_inheritance")?>&cID=<?=$c->getCollectionID()?>&inherit=' + $(this).val(), function(r) {
			if (r.deferred) {
				ConcretePanelManager.exitPanelMode();
				jQuery.fn.dialog.hideLoader();
				ConcreteAlert.notify({
				'message': ccmi18n.setPermissionsDeferredMsg,
				'title': ccmi18n.setPagePermissions
				});				
			} else {
				ccm_refreshPagePermissions();
			}
		});
	});
	
});

ccm_refreshPagePermissions = function() {
	var panel = ConcretePanelManager.getByIdentifier('page');
    if (panel) {
        panel.openPanelDetail({
            'identifier': 'page-permissions',
            'url': '<?=URL::to("/ccm/system/panels/details/page/permissions")?>',
            target: null
        });
    } else {
		jQuery.fn.dialog.showLoader();
		$.get('<?=URL::to('/ccm/system/panels/details/page/permissions?cID=' . $c->getCollectionID())?>', function(r) {
			jQuery.fn.dialog.replaceTop(r);
			jQuery.fn.dialog.hideLoader();
		});
    }
}

</script>