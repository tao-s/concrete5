
<? 
//Used on both page and file attributes
$c = Page::getCurrentPage();

$sets = array();
if (is_object($category) && $category->allowAttributeSets()) {
	$sets = $category->getAttributeSets();
}
?>


<div class="ccm-dashboard-header-buttons">
	<? if (count($sets) > 0) { ?>
		<button type="button" class="btn btn-default" data-toggle="dropdown">
		<?=t('View')?> <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
		<li><a href="<?=Loader::helper('navigation')->getLinkToCollection($c)?>?asGroupAttributes=1"><?=t('Grouped by Set')?></a></li>
		<li><a href="<?=Loader::helper('navigation')->getLinkToCollection($c)?>?asGroupAttributes=0"><?=t('In One List')?></a></li>
		</ul>
	<? } ?>
	<a href="<?=URL::to('/dashboard/system/attributes/sets', 'category', $category->getAttributeKeyCategoryID())?>" class="btn btn-default"><?=t('Manage Sets')?></a>
</div>

<?
if (count($attribs) > 0) { ?>


	<?
	$ih = Loader::helper('concrete/ui');

	
	if (count($sets) > 0 && ($_REQUEST['asGroupAttributes'] !== '0')) {

        foreach($sets as $as) { ?>

		<fieldset>
			<legend><?=$as->getAttributeSetDisplayName()?></legend>
	
		<?
		
		$setattribs = $as->getAttributeKeys();
		if (count($setattribs) == 0) { ?>
		
			<div class="ccm-attribute-list-wrapper"><?=t('No attributes defined.')?></div>
		
		<? } else { ?>
            <ul class="item-select-list ccm-sortable-attribute-set-list-wrapper" attribute-set-id="<?=$as->getAttributeSetID()?>" id="asID_<?=$as->getAttributeSetID()?>">
			<?
			foreach($setattribs as $ak) { ?>
                <li class="ccm-attribute" id="akID_<?=$ak->getAttributeKeyID()?>">
                    <a href="<?=URL::to($editURL, 'edit', $ak->getAttributeKeyID())?>" title="<?php echo t('Handle')?>: <?php echo $ak->getAttributeKeyHandle(); ?>">
                        <img class="ccm-attribute-icon" src="<?=$ak->getAttributeKeyIconSRC()?>" width="16" height="16" />
                        <?=$ak->getAttributeKeyDisplayName()?>
                    </a>
                    <i class="ccm-item-select-list-sort"></i>
                </li>
			<? } ?>
			</ul>
			
		<? } ?>
			
		</fieldset>

		<? } 
		
		$unsetattribs = $category->getUnassignedAttributeKeys();
		if (count($unsetattribs) > 0) { ?>
		
			<fieldset>
				<legend><?=t('Other')?></legend>
				<ul class="ccm-attribute-list-wrapper item-select-list">
				<?
				foreach($unsetattribs as $ak) { ?>
                    <li class="ccm-attribute">
                        <a href="<?=URL::to($editURL, 'edit', $ak->getAttributeKeyID())?>" title="<?php echo t('Handle')?>: <?php echo $ak->getAttributeKeyHandle(); ?>">
                            <img class="ccm-attribute-icon" src="<?=$ak->getAttributeKeyIconSRC()?>" width="16" height="16" />
                            <?=$ak->getAttributeKeyDisplayName()?>
                        </a>
                    </li>
	            <? } ?>
                </ul>
			</fieldset>
		
		<?
		
		}
	
	} else { ?>
		<ul class="item-select-list <?=($sortable?'ccm-sortable-attribute-list-wrapper':'ccm-attribute-list-wrapper');?>">
		<?
        foreach($attribs as $ak) { ?>
            <li class="ccm-attribute" id="akID_<?=$ak->getAttributeKeyID()?>">
			    <a href="<?=URL::to($editURL, 'edit', $ak->getAttributeKeyID())?>" title="<?php echo t('Handle')?>: <?php echo $ak->getAttributeKeyHandle(); ?>"><img class="ccm-attribute-icon" src="<?=$ak->getAttributeKeyIconSRC()?>" width="16" height="16" /> <?=$ak->getAttributeKeyDisplayName()?></a>
                <? if($sortable) { ?><i class="ccm-item-select-list-sort"></i><? } ?>
		    </li>
		
		<? } ?>
		</ul>
	
	<? } ?>
	
<? } else { ?>
	
	<p>
		<?
	 echo t('No attributes defined.');
		?>
	</p>
	
<? } ?>

<script type="text/javascript">
$(function() {
    $("ul.ccm-sortable-attribute-set-list-wrapper").sortable({
		handle: 'i.ccm-item-select-list-sort',
		cursor: 'move',
		opacity: 0.5,
		stop: function() {
			var ualist = $(this).sortable('serialize');
			ualist += '&cID=<?=$c->getCollectionID()?>';
			ualist += '&asID=' + $(this).attr('attribute-set-id');
            ualist += '&ccm_token=' + '<?=Loader::helper('validation/token')->generate('attribute_sort')?>';
			$.post('<?=URL::to('/ccm/system/attribute/attribute_sort/set')?>', ualist, function(r) {});
		}
	});
});
</script>


<? $form = Loader::helper('form'); ?>
<? if (isset($types) && is_array($types) && count($types) > 0) { ?>
<form method="get" action="<?=$view->action('select_type')?>" id="ccm-attribute-type-form">
	<label for="atID"><?=t('Add Attribute')?></label>
	<div class="form-inline">
	<div class="form-group">
		<?=$form->select('atID', $types)?>
	</div>
	<button type="submit" class="btn btn-default"><?=t('Go')?></button>
	</div>
</form>
<? } ?>
