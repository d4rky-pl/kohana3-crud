<table>
	<thead>
		<tr>
			<?php foreach($fields as $field): ?>
				<th><?php echo (method_exists($orm = ORM::Factory($name), 'formo') ? Arr::path($orm->formo(), $field.'.label', __($field)) : __($field)); ?></th>
			<?php endforeach; ?>
			<th><?php echo __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($elements as $element): ?>
			<tr>
				<?php foreach($fields as $field): ?>
					<td><?php echo html::chars($element->$field) ?></td>
				<?php endforeach; ?>
				<td>
					<a href="<?php echo Route::url($route, array('controller'=> Request::current()->controller(), 'action'=>'update')).'?id='.$element->id ?>">
						<?php echo __('Edit') ?>
					</a>
					<a href="<?php echo Route::url($route, array('controller'=> Request::current()->controller(), 'action'=>'delete')).'?id='.$element->id ?>">
						<?php echo __('Delete') ?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<a href="<?php echo Route::url($route, array('controller'=> Request::current()->controller(), 'action'=>'create')) ?>">
	<?php echo __("Create") ?>
</a>
