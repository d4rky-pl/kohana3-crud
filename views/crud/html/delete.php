<p>
	<?php echo __("Are you sure you want to delete :element with ID :id ?", array(':element' => $name, ':id' =>$element->id)) ?>
</p>

<form method="post">
	<p>
		<input type="hidden" name="id" value="<?php echo $element->id ?>"/>
		<button type="submit"><?php echo __("Yes") ?></button>
		<a href="<?php Route::url($route, array('controller' => Request::current()->controller())) ?>"><?php echo __("No") ?></a>
	</p>
</form>
