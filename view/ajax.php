<?php

/**
* @package     ajax
* @author      xiaocao
* @link        http://homeway.me/
* @copyright   Copyright(c) 2014
* @version     14.10.29
**/ 

?>

<center class="span10">

	<!-- 注意语言包的调用方式 -->

	<h1><?= $lang['head_title'];?></h1>

	<h2><?= $lang['body_info'];?></h2>

	<br><hr><br>

	<h3><?= $lang['body_get_title'];?></h3>

	<div class="form-group span3">
		<input class="form-control" name="get" placeholder="GET return">
	</div>

	<a id='btn_get' class="btn btn-success"><?= $lang['btn_get_click'];?></a>

	<h3><?= $lang['body_post_title'];?></h3>

	<div class="form-group span3">
		<input class="form-control" name="post" placeholder="POST return">
	</div>

	<a id='btn_post' class="btn btn-success"><?= $lang['btn_post_click'];?></a>

</center>

<script>
$(document).ready(function(){
	$('#btn_get').click(function(){
		$.get( '<?= __Base__;?>ajax/',{}, function( e ){
			console.log(e);
			$('input[name=get]').val( e['msg'] );
		},'json');
	});

	$('#btn_post').click(function(){
		$.post( '<?= __Base__;?>ajax/',{}, function( e ){
			console.log(e);
			$('input[name=post]').val( e['msg'] );
		},'json');
	});

	$('input').focus(function (e){	
		$(this).val('');
	});
});
</script>