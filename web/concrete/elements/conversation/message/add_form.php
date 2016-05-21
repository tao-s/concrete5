<?
defined('C5_EXECUTE') or die("Access Denied.");
$form = Core::make('helper/form');
$val = Core::make('token');
$u = new User();
?>

<? if ($displayForm && $displayPostingForm == $position) { ?>

	<? if ($addMessageLabel) { ?>
		<h4><?=$addMessageLabel?></h4>
	<? } ?>

	<? if ($enablePosting == Conversation::POSTING_ENABLED) { ?>
		<div class="ccm-conversation-add-new-message" rel="main-reply-form">
			<form method="post" class="main-reply-form">
				<? Loader::element('conversation/message/author');?>
				<div class="ccm-conversation-message-form">
					<div class="ccm-conversation-errors alert alert-danger"></div>
					<? $editor->outputConversationEditorAddMessageForm(); ?>
					<?php echo $form->hidden('blockAreaHandle', $blockAreaHandle) ?>
					<?php echo $form->hidden('cID', $cID) ?>
					<?php echo $form->hidden('bID', $bID) ?>
					<button type="button" data-post-parent-id="0" data-submit="conversation-message" class="pull-right btn btn-submit btn-primary"><?=t('Submit')?></button>
					<?php if ($attachmentsEnabled) { ?>
						<button type="button" class="pull-right btn btn-default ccm-conversation-attachment-toggle" href="#" title="<?php echo t('Attach Files'); ?>"><i class="fa fa-image"></i></button>
					<?php } ?>
					<? if ($conversation->getConversationSubscriptionEnabled() && $u->isRegistered()) { ?>
						<a href="<?=URL::to('/ccm/system/dialogs/conversation/subscribe', $conversation->getConversationID())?>" data-conversation-subscribe="unsubscribe" <? if (!$conversation->isUserSubscribed($u)) { ?>style="display: none"<? } ?> class="btn pull-right btn-default"><?=t('Un-Subscribe')?></a>
						<a href="<?=URL::to('/ccm/system/dialogs/conversation/subscribe', $conversation->getConversationID())?>" data-conversation-subscribe="subscribe" <? if ($conversation->isUserSubscribed($u)) { ?>style="display: none"<? } ?> class="btn pull-right btn-default"><?=t('Subscribe to Conversation')?></a>
					<? } ?>
				</div>
			</form>
			<?php if($attachmentsEnabled) { ?>
				<div class="ccm-conversation-attachment-container">
					<form action="<?php echo Loader::helper('concrete/urls')->getToolsURL('conversations/add_file');?>" class="dropzone" id="file-upload">
						<div class="ccm-conversation-errors alert alert-danger"></div>
						<?php $val->output('add_conversations_file'); ?>
						<?php echo $form->hidden('blockAreaHandle', $blockAreaHandle) ?>
						<?php echo $form->hidden('cID', $cID) ?>
						<?php echo $form->hidden('bID', $bID) ?>
					</form>
				</div>
			<?php } ?>
		</div>

		<div class="ccm-conversation-add-reply">
			<form method="post" class="aux-reply-form">
				<? Loader::element('conversation/message/author');?>
				<div class="ccm-conversation-message-form">
					<div class="ccm-conversation-errors alert alert-danger"></div>
					<? $editor->outputConversationEditorReplyMessageForm(); ?>
					<?php echo $form->hidden('blockAreaHandle', $blockAreaHandle) ?>
					<?php echo $form->hidden('cID', $cID) ?>
					<?php echo $form->hidden('bID', $bID) ?>
					<button type="btn btn-primary" data-submit="conversation-message" class="pull-right btn btn-primary"><?=t('Reply')?> </button>
					<?php if ($attachmentsEnabled) { ?>
						<button type="button" class="pull-right btn btn-default ccm-conversation-attachment-toggle" href="#" title="<?php echo t('Attach Files'); ?>"><i class="fa fa-image"></i></button>
					<?php } ?>
				</div>
			</form>
			<?php if($attachmentsEnabled) { ?>
				<div class="ccm-conversation-attachment-container">
					<form action="<?php echo Loader::helper('concrete/urls')->getToolsURL('conversations/add_file');?>" class="dropzone" id="file-upload-reply">
						<div class="ccm-conversation-errors alert alert-danger"></div>
						<?php $val->output('add_conversations_file'); ?>
						<?php echo $form->hidden('blockAreaHandle', $blockAreaHandle) ?>
						<?php echo $form->hidden('cID', $cID) ?>
						<?php echo $form->hidden('bID', $bID) ?>
					</form>
				</div>
			<?php } ?>
		</div>
	<? } else { ?>
		<? switch($enablePosting) {
			case Conversation::POSTING_DISABLED_MANUALLY:
				print '<p>' . t('Adding new posts is disabled for this conversation.') . '</p>';
				break;
			case Conversation::POSTING_DISABLED_PERMISSIONS:
				print '<p>';
				print ' ';
				if (!$u->isRegistered()) {
					print t('You must <a href="%s">sign in</a> to post to this conversation.', URL::to('/login'));
				} else {
					print t('You do not have permission to post this to conversation.');
				}
				print '</p>';
				break;
		} ?>
	<? } ?>

<? } ?>