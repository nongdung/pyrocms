<?php echo form_open("comments/create/{$module}", 'id="create-comment"') ?>

	<noscript><?php echo form_input('d0ntf1llth1s1n', '', 'style="display:none"') ?></noscript>
<div class="container" style="margin-bottom: 20px;">
	<h4><?php echo lang('comments:your_comment') ?></h4>
	
	<div class="row">
		<div id="commentPost" class=" col-md-10 col-md-offset-1">

	<?php echo form_hidden('entry', $entry_hash) ?>

	<?php if ( ! is_logged_in()): ?>

	<div class="form_name">
		<!-- <label for="name"><?php echo lang('comments:name_label') ?><span class="required">*</span>:</label> -->
		<input type="text" name="name" id="name" maxlength="40" placeholder="<?php echo lang('comments:name_label') ?> *" value="<?php echo $comment['name'] ?>" />
	</div>

	<div class="form_email">
		<!-- <label for="email"><?php echo lang('global:email') ?><span class="required">*</span>:</label> -->
		<input type="text" name="email" maxlength="40" placeholder="<?php echo lang('global:email') ?> *" value="<?php echo $comment['email'] ?>" />
	</div>

	<div class="form_url">
		<!-- <label for="website"><?php echo lang('comments:website_label') ?>:</label> -->
		<input type="text" name="website" maxlength="40" placeholder="<?php  echo lang('comments:website_label')  ?>" value="<?php echo $comment['website'] ?>" />
	</div>

	<?php endif ?>

	<div class="form_textarea">
		<!-- <label for="comment"><?php echo lang('comments:message_label') ?><span class="required">*</span>: </label><br> -->
		<textarea name="comment" id="comment" rows="5" placeholder="<?php  echo lang('comments:message_label')  ?> *" cols="30" class="width-full"><?php echo $comment['comment'] ?></textarea>
	</div>

	<div class="form_submit">
		<?php echo form_submit('submit', lang('comments:send_label'), 'class = "btn btn-default"') ?>
	</div>
	
	</div>
	</div>


<?php echo form_close() ?>

	</div>