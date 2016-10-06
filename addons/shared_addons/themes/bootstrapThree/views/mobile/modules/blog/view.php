

<section class="clearfix">
	<!-- Post heading -->
	
	
	

{{ post }}

<div class="post">

		<div align="right" class="date" style="margin-top: 5%">
			{{ helper:lang line="blog:posted_label" }}
			<span>{{ helper:date timestamp=created_on }}</span>
		</div>


	<h2>{{ title }}</h2>


	<div class="meta">



		<div class="author">
			<h4>{{ helper:lang line="blog:written_by_label" }}
			<span><a href="{{ url:site }}user/{{ created_by:user_id }}">{{ created_by:display_name }}</a></span></h4>
		</div>

		{{ if category }}
		<div class="category">
			{{ helper:lang line="blog:category_label" }}
			<span><a href="{{ url:site }}blog/category/{{ category:slug }}">{{ category:title }}</a></span>
		</div>
		{{ endif }}

		{{ if keywords }}
		<div class="keywords">
			{{ keywords }}
				<span><a href="{{ url:site }}blog/tagged/{{ keyword }}">{{ keyword }}</a></span>
			{{ /keywords }}
		</div>
		{{ endif }}

	</div>

	<div class="body">
		</br>
		{{ body }}
	</div>

</div>

{{ /post }}

<?php if (Settings::get('enable_comments')): ?>

<div id="comments" class="panel panel-info" style="margin-top: 5%">

	<div class="panel-heading">
		<h4><?php echo lang('comments:title') ?></h4>
	</div>
		<div id="existing-comments" class="panel-body">
		<?php echo $this->comments->display() ?>
	
	</div>

	<?php if ($form_display): ?>
		<?php echo $this->comments->form() ?>
	<?php else: ?>
	<?php echo sprintf(lang('blog:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post[0]['comments_enabled'])))) ?>
	<?php endif ?>
</div>

<?php endif ?>
