<?
defined('C5_EXECUTE') or die("Access Denied.");
use \Concrete\Core\Workflow\Progress\PageProgress as PageWorkflowProgress;
use \Concrete\Core\Block\View\BlockView;
if ($controller->getTask() == 'view_details') {

    $cpc = new Permissions($stack);
    $showApprovalButton = false;
    $hasPendingPageApproval = false;
    $workflowList = PageWorkflowProgress::getList($stack);
    foreach($workflowList as $wl) {
        $wr = $wl->getWorkflowRequestObject();
        $wrk = $wr->getWorkflowRequestPermissionKeyObject();
        if ($wrk->getPermissionKeyHandle() == 'approve_page_versions') {
            $hasPendingPageApproval = true;
            break;
        }
    }

    if (!$hasPendingPageApproval) {
        $vo = $stack->getVersionObject();
        if ($cpc->canApprovePageVersions()) {
            $publishTitle = t('Approve Changes');
            $pk = PermissionKey::getByHandle('approve_page_versions');
            $pk->setPermissionObject($stack);
            $pa = $pk->getPermissionAccessObject();

            $workflows = array();
            $canApproveWorkflow = true;
            if (is_object($pa)) {
                $workflows = $pa->getWorkflows();
            }
            foreach($workflows as $wf) {
                if (!$wf->canApproveWorkflow()) {
                    $canApproveWorkflow = false;
                }
            }

    		if (count($workflows > 0) && !$canApproveWorkflow) {
                $publishTitle = t('Submit to Workflow');
            }
            $showApprovalButton = true;
        }
    }

    $isGlobalArea = false;
    if ($stack->getStackType() == Stack::ST_TYPE_GLOBAL_AREA) {
        $isGlobalArea = true;
    }

    ?>

    <div class="ccm-dashboard-header-buttons">
        <?php if ($isGlobalArea) { ?>
        <a href="<?=URL::to('/dashboard/blocks/stacks/view_global_areas')?>" data-dialog="add-stack" class="btn btn-default"><i class="fa fa-angle-double-left"></i> <?=t("Back to Global Areas")?></a>
        <?php } else { ?>
        <a href="<?=URL::to('/dashboard/blocks/stacks')?>" data-dialog="add-stack" class="btn btn-default"><i class="fa fa-angle-double-left"></i> <?=t("Back to Stacks")?></a>
        <?php } ?>
    </div>

    <p class="lead"><?php echo $stack->getCollectionName()?></p>

    <nav class="navbar navbar-default">
    <div class="container-fluid">
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?=t('Add Block')?></i></a>
            <ul class="dropdown-menu">
                <li><a class="dialog-launch" dialog-modal="false" dialog-width="550" dialog-height="380" dialog-title="<?=t('Add Block')?>" href="<?=URL::to('/ccm/system/dialogs/page/add_block_list')?>?cID=<?=$stack->getCollectionID()?>&arHandle=<?=STACKS_AREA_NAME?>"><?=t('Add Block')?></a></li>
                <li><a class="dialog-launch" dialog-modal="false" dialog-width="550" dialog-height="380" dialog-title="<?=t('Paste From Clipboard')?>" href="<?=URL::to('/ccm/system/dialogs/page/clipboard')?>?cID=<?=$stack->getCollectionID()?>&arHandle=<?=STACKS_AREA_NAME?>"><?=t('Paste From Clipboard')?></a></li>
            </ul>
        </li>

        <li><a dialog-width="640" dialog-height="340" class="dialog-launch" id="stackVersions" dialog-title="<?=t('Version History')?>" href="<?=URL::to('/ccm/system/panels/page/versions')?>?cID=<?=$stack->getCollectionID()?>"><?=t('Version History')?></a></li>
        <? if ($cpc->canEditPageProperties() && $stack->getStackType() != \Concrete\Core\Page\Stack\Stack::ST_TYPE_GLOBAL_AREA) { ?>
            <li><a href="<?=$view->action('rename', $stack->getCollectionID())?>"><?=t('Rename')?></a></li>
        <? } ?>
        <? if ($cpc->canEditPagePermissions() && Config::get('concrete.permissions.model') == 'advanced') { ?>
            <li><a dialog-width="580" class="dialog-launch" dialog-append-buttons="true" dialog-height="420" dialog-title="<?=t('Stack Permissions')?>" id="stackPermissions" href="<?=REL_DIR_FILES_TOOLS_REQUIRED?>/edit_area_popup?cID=<?=$stack->getCollectionID()?>&arHandle=<?=STACKS_AREA_NAME?>&atask=groups"><?=t('Permissions')?></a></li>
        <? } ?>

        <? if ($cpc->canMoveOrCopyPage() && $stack->getStackType() != \Concrete\Core\Page\Stack\Stack::ST_TYPE_GLOBAL_AREA) { ?>
            <li><a href="<?=$view->action('duplicate', $stack->getCollectionID())?>" style="margin-right: 4px;"><?=t('Duplicate Stack')?></a></li>
        <? } ?>
        <? if ($cpc->canDeletePage()) { ?>
            <? if ($stack->getStackType() == \Concrete\Core\Page\Stack\Stack::ST_TYPE_GLOBAL_AREA) { ?>
                <li><a href="javascript:void(0)" data-dialog="delete-stack"><span class="text-danger"><?=t('Clear Global Area')?></span></a></li>
            <? } else { ?>
                <li><a href="javascript:void(0)" data-dialog="delete-stack"><span class="text-danger"><?=t('Delete Stack')?></span></a></li>
            <? } ?>
        <? } ?>
    </ul>
    <? if ($showApprovalButton) { ?>
    <ul class="nav navbar-nav navbar-right">
        <li id="ccm-stack-list-approve-button" class="navbar-form" <? if ($vo->isApproved()) { ?> style="display: none;" <? } ?>>
            <button class="btn btn-success" onclick="window.location.href='<?=URL::to('/dashboard/blocks/stacks', 'approve_stack', $stack->getCollectionID(), $token->generate('approve_stack'))?>'"><?=$publishTitle?></button>
        </li>
    </ul>
    <? } ?>
    </div>
    </nav>

    <div id="ccm-stack-container">

    <?
    $a = Area::get($stack, STACKS_AREA_NAME);
    $a->forceControlsToDisplay();
    Loader::element('block_area_header', array('a' => $a));

    foreach($blocks as $b) {
        $bv = new BlockView($b);
        $bv->setAreaObject($a);
        $p = new Permissions($b);
        if ($p->canViewBlock()) {
            $bv->render('view');
        }
    }
    ?>

    </div>
    </div>
    </div>

    <div style="display: none">
        <div id="ccm-dialog-delete-stack" class="ccm-ui">
            <form method="post" class="form-stacked" style="padding-left: 0px" action="<?=$view->action('delete_stack')?>">
                <?=Loader::helper("validation/token")->output('delete_stack')?>
                <input type="hidden" name="stackID" value="<?=$stack->getCollectionID()?>" />
                <p><?=t('Are you sure? This action cannot be undone.')?></p>
            </form>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
                <button class="btn btn-danger pull-right" onclick="$('#ccm-dialog-delete-stack form').submit()"><?=t('Delete Stack')?></button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var showApprovalButton = function() {
            $('#ccm-stack-list-approve-button').show().addClass("animated fadeIn");
        };

        $(function() {
            var editor = new Concrete.EditMode({notify: false}), ConcreteEvent = Concrete.event;


            ConcreteEvent.on('ClipboardAddBlock', function(event, data) {
                var area = editor.getAreaByID(<?=$a->getAreaID()?>);
                block = new Concrete.DuplicateBlock(data.$launcher, editor);
                block.addToDragArea(_.last(area.getDragAreas()));
                return false;
            });

            ConcreteEvent.on('AddBlockListAddBlock', function(event, data) {
                var area = editor.getAreaByID(<?=$a->getAreaID()?>);
                blockType = new Concrete.BlockType(data.$launcher, editor);
                blockType.addToDragArea(_.last(area.getDragAreas()));
                return false;
            });

            ConcreteEvent.on('EditModeAddClipboardComplete', function(event, data) {
                showApprovalButton();
                Concrete.getEditMode().scanBlocks();
            });

            ConcreteEvent.on('EditModeAddBlockComplete', function(event, data) {
                showApprovalButton();
                Concrete.getEditMode().scanBlocks();
            });

            ConcreteEvent.on('EditModeUpdateBlockComplete', function(event, data) {
                showApprovalButton();
                Concrete.getEditMode().scanBlocks();
            });

            ConcreteEvent.on('EditModeBlockDelete', function(event, data) {
                showApprovalButton();
                _.defer(function() {
                    Concrete.getEditMode().scanBlocks();
                });
            });

            ConcreteEvent.on('EditModeBlockMove', function(event, data) {
                showApprovalButton();
                Concrete.getEditMode().scanBlocks();
            });

            $('a[data-dialog=delete-stack]').on('click', function() {
                jQuery.fn.dialog.open({
                    element: '#ccm-dialog-delete-stack',
                    modal: true,
                    width: 320,
                    title: '<?=t("Delete Stack")?>',
                    height: 'auto'
                });
            });
        });
    </script>

<? } else if ($this->controller->getTask() == 'duplicate') {
    $sv = CollectionVersion::get($stack, 'ACTIVE');
    ?>

    <form name="duplicate_form" action="<?=$view->action('duplicate', $stack->getCollectionID())?>" method="POST">
        <?=Loader::helper("validation/token")->output('duplicate_stack')?>
        <legend><?=t('Duplicate Stack')?></legend>
        <div class="form-group">
            <?=$form->label('stackName', t("Name"))?>
            <?=$form->text('stackName', $stack->getStackName())?>
        </div>
        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?=$view->action('view_details', $stack->getCollectionID())?>" class="btn btn-default"><?=t('Cancel')?></a>
                <button type="submit" class="btn pull-right btn-primary"><?=t('Duplicate')?></button>
            </div>
        </div>
    </form>

<? } else if ($this->controller->getTask() == 'rename') {

    $sv = CollectionVersion::get($stack, 'ACTIVE');
    ?>

    <form action="<?=$view->action('rename', $stack->getCollectionID())?>" method="POST">
        <legend><?=t('Rename Stack')?></legend>
        <?=Loader::helper("validation/token")->output('rename_stack')?>
        <div class="form-group">
            <?=$form->label('stackName', t("Name"))?>
            <?=$form->text('stackName', $stack->getStackName())?>
        </div>
        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?=$view->action('view_details', $stack->getCollectionID())?>" class="btn btn-default"><?=t('Cancel')?></a>
                <button type="submit" class="btn pull-right btn-primary"><?=t('Rename')?></button>
            </div>
        </div>
    </form>

<? } else { ?>

    <? if (count($stacks) > 0) { ?>
        <ul class="item-select-list" id="ccm-stack-list">
        <? foreach($stacks as $st) {
            $sv = CollectionVersion::get($st, 'ACTIVE');
            ?>

            <li id="stID_<?=$st->getCollectionID()?>">
                <? if ($canMoveStacks) { ?><i class="ccm-item-select-list-sort"></i><? } ?>
                <a href="<?=$view->url('/dashboard/blocks/stacks', 'view_details', $st->getCollectionID())?>">
                    <i class="fa fa-bars"></i> <?=$sv->getVersionName()?>
                </a>
            </li>
        <? } ?>
        </ul>
        <?
    } else {
        print '<p>';
        if ($controller->getTask() == 'view_global_areas') {
            print t('No global areas have been added.');
        } else {
            print t('No stacks have been added.');
        }
        print '</p>';
    }
    ?>


    <div class="ccm-dashboard-header-buttons">
        <? if (\Core::make('multilingual/detector')->isEnabled() && $defaultLanguage) {
            $ch = Core::make('multilingual/interface/flag');
            ?>
        <span class="dropdown">
        <button type="button" class="btn btn-default" data-toggle="dropdown">
            <?=$ch->getSectionFlagIcon($defaultLanguage)?> <?php echo $defaultLanguage->getLanguageText()?> <span class="text-muted"><?php echo $defaultLanguage->getLocale();?></span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <? foreach($multilingualSections as $section) { ?>
                <li><a href="<?=$view->action('set_default_language', $section->getCollectionID(), $controller->getTask())?>"><?=$ch->getSectionFlagIcon($section)?> <?php echo $section->getLanguageText()?> <span class="text-muted"><?php echo $section->getLocale();?></span></a></li>
            <? } ?>
        </ul>
        <? } ?>
        </span>
        <span class="dropdown">
        <button type="button" class="btn btn-default" data-toggle="dropdown">
            <? if ($controller->getTask() == 'view_global_areas') { ?>
                <?=t('View Global Areas')?>
            <? } else { ?>
                <?=t('View Stacks')?>
            <? } ?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="<?=$controller->action('view')?>"><?=t('View Stacks')?></a></li>
            <li><a href="<?=$controller->action('view_global_areas')?>"><?=t('View Global Areas')?></a></li>
        </ul>
        </span>
        <? if ($controller->getTask() != 'view_global_areas') { ?>
            <a href="javascript:void(0)" data-dialog="add-stack" class="btn btn-primary"><?=t("Add Stack")?></a>
        <? } ?>
    </div>

    <div style="display: none">
        <div id="ccm-dialog-add-stack" class="ccm-ui">
            <form method="post" class="form-stacked" style="padding-left: 0px" action="<?=$view->action('add_stack')?>">
                <?=Loader::helper("validation/token")->output('add_stack')?>
                <div class="form-group">
                    <?=Loader::helper("form")->label('stackName', t('Stack Name'))?>
                    <?=Loader::helper('form')->text('stackName')?>
                </div>
            </form>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
                <button class="btn btn-primary pull-right" onclick="$('#ccm-dialog-add-stack form').submit()"><?=t('Add Stack')?></button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $(function() {

        $('a[data-dialog=add-stack]').on('click', function() {
            jQuery.fn.dialog.open({
                element: '#ccm-dialog-add-stack',
                modal: true,
                width: 320,
                title: '<?=t("Add Stack")?>',
                height: 'auto'
            });
        });
        <? if ($canMoveStacks) { ?>
        $("ul#ccm-stack-list").sortable({
            handle: "i.ccm-item-select-list-sort",
            cursor: "move",
            axis: "y",
            opacity: 0.5,
            stop: function() {
                var pagelist = $(this).sortable("serialize");
                $.ajax({
                    dataType: "json",
                    type: "post",
                    url: "<?=$sortURL?>",
                    data: pagelist,
                    success: function(r) {

                    }
                });
            }
        });
        <? } ?>

    });
    </script>

<? } ?>
