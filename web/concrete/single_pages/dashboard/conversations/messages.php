<?
defined('C5_EXECUTE') or die("Access Denied.");
$valt = Loader::helper('validation/token');
$th = Loader::helper('text');
$ip = Loader::helper('validation/ip'); ?>
<div class="ccm-dashboard-content-full">

    <div data-search-element="wrapper">
        <form role="form" data-search-form="logs" action="<?=$controller->action('view')?>" class="form-inline ccm-search-fields">
            <div class="ccm-search-fields-row">
                <div class="form-group">
                    <?=$form->label('keywords', t('Search'))?>
                    <div class="ccm-search-field-content">
                        <div class="ccm-search-main-lookup-field">
                            <i class="fa fa-search"></i>
                            <?=$form->search('cmpMessageKeywords', array('placeholder' => t('Keywords')))?>
                            <button type="submit" class="ccm-search-field-hidden-submit" tabindex="-1"><?=t('Search')?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ccm-search-fields-row">
                <div class="form-group">
                    <?=$form->label('cmpMessageFilter', t('Filter By'))?>
                    <div class="ccm-search-field-content">
                        <?=$form->select('cmpMessageFilter', $cmpFilterTypes, $cmpMessageFilter) ?>
                    </div>
                </div>
            </div>
            <div class="ccm-search-fields-row">
                <div class="form-group form-group-full">
                    <?=$form->label('cmpMessageSort', t('Sort By'))?>
                    <div class="ccm-search-field-content">
                        <?=$form->select('cmpMessageSort', $cmpSortTypes)?>
                    </div>
                </div>
            </div>

            <div class="ccm-search-fields-submit">
            <button type="submit" class="btn btn-primary pull-right"><?=t('Search')?></button>
            </div>

        </form>

    </div>

    <div data-search-element="results">
        <div class="table-responsive">
            <table id="ccm-conversation-messages" class="ccm-search-results-table">
                <thead>
                <tr>
                    <th class="<?=$list->getSearchResultsClass('cnvMessageDateCreated')?>"><a href="<?=$list->getSortByURL('cnvMessageDateCreated', 'desc')?>"><?=t('Posted')?></a></th>
                    <th><span><?=t('Author')?></span></th>
                    <th><span><?=t('Message')?></span></th>
                    <th style="text-align: center"><span><?=t('Status')?></span></th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($messages) > 0) {
                    $dh = Core::make('date');
                    foreach($messages as $msg) {
                        $cnv = $msg->getConversationObject();
                        if(is_object($cnv)) {
                            $page = $cnv->getConversationPageObject();
                        }
                        $msgID = $msg->getConversationMessageID();
                        $cnvID = $cnv->getConversationID();
                        $p = new Permissions($cnv);
                        $author = $msg->getConversationMessageAuthorObject();
                        $formatter = $author->getFormatter();

                        $displayUnflagOption = $p->canFlagConversationMessage() && $msg->isConversationMessageFlagged();
                        $displayUndeleteOption = $p->canDeleteConversationMessage() && $msg->isConversationMessageDeleted();

                        $displayApproveOption = $p->canApproveConversationMessage() && (!$msg->isConversationMessageDeleted() && !$msg->isConversationMessageApproved() && !$msg->isConversationMessageFlagged());
                        if (!$displayUnflagOption) {
                            $displayFlagOption = $p->canFlagConversationMessage() && !$msg->isConversationMessageDeleted();
                        }
                        $displayDeleteOption = $p->canDeleteConversationMessage() && !$msg->isConversationMessageDeleted();
                        ?>
                        <tr>
                            <!-- <td><?=$form->checkbox('cnvMessageID[]', $msg->getConversationMessageID())?></td> -->
                            <td>
                                <?=$dh->formatDateTime(strtotime($msg->getConversationMessageDateTime()))?>
                            </td>
                            <td>

                                <div class="ccm-popover ccm-conversation-message-popover popover fade" data-menu="<?=$msg->getConversationMessageID()?>">
                                    <div class="arrow"></div><div class="popover-inner">
                                        <ul class="dropdown-menu">
                                            <? if (is_object($page)) { ?>
                                                <li><a href="<?=$page->getCollectionLink()?>#cnv<?=$cnv->getConversationID()?>Message<?=$msg->getConversationMessageID()?>"><?=t('View Conversation')?></a></li>
                                                <? if ($displayFlagOption || $displayApproveOption || $displayDeleteOption || $displayUnflagOption || $displayUndeleteOption) { ?>
                                                    <li class="divider"></li>
                                                <? } ?>
                                            <? } ?>
                                            <?
                                            if ($displayApproveOption) { ?>
                                                <li><a href="#" data-message-action="approve" data-message-id="<?=$msg->getConversationMessageID()?>"><?=t('Approve')?></a></li>
                                            <? } ?>
                                            <?
                                            if ($displayFlagOption) { ?>
                                                <li><a href="#" data-message-action="flag" data-message-id="<?=$msg->getConversationMessageID()?>"><?=t('Flag as Spam')?></a></li>
                                            <? } ?>
                                            <?
                                            if ($displayDeleteOption) { ?>
                                                <li><a href="#" data-message-action="delete" data-message-id="<?=$msg->getConversationMessageID()?>"><?=t('Delete')?></a></li>
                                            <? } ?>
                                            <?
                                            if ($displayUnflagOption) { ?>
                                                <li><a href="#" data-message-action="unflag" data-message-id="<?=$msg->getConversationMessageID()?>"><?=t('Un-Flag As Spam')?></a></li>
                                            <? } ?>
                                            <?
                                            if ($displayUndeleteOption) { ?>
                                                <li><a href="#" data-message-action="undelete" data-message-id="<?=$msg->getConversationMessageID()?>"><?=t('Un-Delete Message')?></a></li>
                                            <? } ?>
                                        </ul>
                                    </div>
                                </div>

                                <p><span class="ccm-conversation-display-author-name"><?
                                    echo tc(/*i18n: %s is the name of the author */ 'Authored', 'By %s', $formatter->getLinkedAdministrativeDisplayName());
                                    ?></span></p>
                                <?

                                if (is_object($page)) { ?>
                                    <div><?=$page->getCollectionPath()?></div>
                                <? } ?>
                            </td>
                            <td class="message-cell" style="width: 33%">
                                <div class="ccm-conversation-message-summary">
                                    <div class="message-output">
                                        <?=$msg->getConversationMessageBodyOutput(true)?>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center">
                                <?
                                if (!$msg->isConversationMessageApproved() && !$msg->isConversationMessageDeleted()) { ?>
                                    <i class="fa fa-warning text-warning launch-tooltip" title="<?php echo t('Message has not been approved.')?>"></i>
                                <? }

                                if ($msg->isConversationMessageDeleted()) { ?>
                                    <i class="fa fa-trash launch-tooltip" title="<?php echo t('Message is deleted.')?>"></i>
                                <? }

                                if($msg->isConversationMessageFlagged()) { ?>
                                    <i class="fa fa-flag text-danger launch-tooltip" title="<?php echo t('Message is flagged as spam.')?>"></i>
                                <? }

                                if ($msg->isConversationMessageApproved() && !$msg->isConversationMessageDeleted()) { ?>
                                    <i class="fa fa-thumbs-up launch-tooltip" title="<?php echo t('Message is approved.')?>"></i>
                                <? } ?>
                            </td>
                            <? /*
                            <td class="hidden-actions">
                                <div class="message-actions message-actions<?php echo $msgID ?>" data-id="<?php echo $msgID ?>">
                                    <ul>
                                        <li>
                                            <?php if($msg->isConversationMessageApproved()) { ?>
                                                <a class = "unapprove-message" data-rel-message-id="<?php echo $msgID ?>" href="#"><?php echo t('Unapprove') ?></a>
                                            <?php } else {  ?>
                                                <a class = "approve-message" data-rel-message-id="<?php echo $msgID ?>" href="#"><?php echo t('Approve') ?></a>
                                            <?php } ?>
                                        </li>
                                        <li>
                                            <?php if($msg->isConversationMessageDeleted()){ ?>
                                                <a class = "restore-message" data-rel-message-id="<?php echo $msgID ?>" href="#"><?php echo t('Restore') ?></a>
                                            <?php } else { ?>
                                                <a class = "delete-message" data-rel-message-id="<?php echo $msgID ?>" href="#"><?php echo t('Delete') ?></a>
                                            <?php } ?>
                                        </li>
                                        <li><?php if($msg->isConversationMessageFlagged()) { ?>
                                                <a class = "unmark-spam" data-rel-message-id="<?php echo $msgID ?>" href="#"><?php echo t('Unmark as spam') ?></a>
                                            <?php } else { ?>
                                                <a class = "mark-spam" data-rel-message-id="<?php echo $msgID ?>" href="#"><?php echo t('Mark as spam') ?></a>
                                            <?php } ?>
                                        </li>
                                        <li>
                                            <a class = "mark-user" data-rel-message-id="<?php echo $msgID ?>" href="#"><?php echo t('Mark all user posts as spam') ?></a>
                                        </li>
                                        <? /*
                                        <li>
                                            <?php if(is_object($ui) && $ui->isActive()) { ?>
                                                <a class = "deactivate-user" data-rel-message-id="<?php echo $msgID ?>" href="#"><?php echo t('Deactivate User') ?></a>
                                            <?php } else { ?>
                                                <span class="inactive"><?php echo t('User deactivated'); ?></span>
                                            <?php }?>
                                        </li>
                                        <li>
                                            <?php if(!$ip->isBanned($msg->getConversationMessageSubmitIP())) { ?>
                                                <a class = "block-ip" data-rel-message-id="<?php echo $msgID ?>" href="#"><?php echo t('Block user IP Address') ?></a>
                                            <?php } else { ?>
                                                <span class="inactive"><?php echo t('IP Banned') ?></span>
                                            <?php } ?>
                                        </li>
                                    </ul>
                                </div>
                            </td>*/ ?>

                        </tr>
                    <? }
                }?>
                </tbody>
            </table>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#ccm-conversation-messages tbody tr').each(function() {
                $(this).concreteMenu({
                    menu: $(this).find('div[data-menu]')
                });
            });

            $('a[data-message-action=flag]').on('click', function(e) {
                e.preventDefault();
                $.concreteAjax({
                    url: '<?=REL_DIR_FILES_TOOLS_REQUIRED?>/conversations/flag_message',
                    data: {
                        'cnvMessageID': $(this).attr('data-message-id')
                    },
                    success: function(r) {
                        window.location.reload();
                    }
                });
            });

            $('a[data-message-action=delete]').on('click', function(e) {
                e.preventDefault();
                $.concreteAjax({
                    url: '<?=REL_DIR_FILES_TOOLS_REQUIRED?>/conversations/delete_message',
                    data: {
                        'cnvMessageID': $(this).attr('data-message-id')
                    },
                    success: function(r) {
                        window.location.reload();
                    }
                });
            });

            $('a[data-message-action=approve]').on('click', function(e) {
                e.preventDefault();
                $.concreteAjax({
                    url: '<?=$controller->action('approve_message')?>',
                    data: {
                        'cnvMessageID': $(this).attr('data-message-id')
                    },
                    success: function(r) {
                       window.location.reload();
                    }
                });
            });

            $('a[data-message-action=unflag]').on('click', function(e) {
                e.preventDefault();
                $.concreteAjax({
                    url: '<?=$controller->action('unflag_message')?>',
                    data: {
                        'cnvMessageID': $(this).attr('data-message-id')
                    },
                    success: function(r) {
                        window.location.reload();
                    }
                });
            });

            $('a[data-message-action=undelete]').on('click', function(e) {
                e.preventDefault();
                $.concreteAjax({
                    url: '<?=$controller->action('undelete_message')?>',
                    data: {
                        'cnvMessageID': $(this).attr('data-message-id')
                    },
                    success: function(r) {
                        window.location.reload();
                    }
                });
            });

        });
    </script>
    <style>
        span.ccm-conversation-display-author-name, #ccm-conversation-messages i.fa {
            position: relative;
            z-index: 800;
        }

        div.ccm-popover.ccm-conversation-message-popover {
            z-index: 801;
        }
    </style>
    <!-- END Body Pane -->
    <?=$list->displayPagingV2()?>

</div>
