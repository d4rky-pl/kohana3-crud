<table>
	<thead>
		<tr>
			<?php foreach($fields as $field): ?>
				<th><?php echo I18n::get($field) ?></th>
			<?php endforeach; ?>
			<th><?php echo I18n::get('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($elements as $element): ?>
			<tr>
				<?php foreach($fields as $field): ?>
					<td><?php echo html::chars($element->$field) ?></td>
				<?php endforeach; ?>
				<td>
					<a href="<?php echo Route::url($route, array('controller'=> Inflector::plural($name), 'action'=>'update')).'?id='.$element->id ?>">
						<?php echo I18n::get('Edit') ?>
					</a>
					<a href="<?php echo Route::url($route, array('controller'=> Inflector::plural($name), 'action'=>'delete')).'?id='.$element->id ?>">
						<?php echo I18n::get('Delete') ?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<a href="<?php echo Route::url($route, array('controller'=> Inflector::plural($name), 'action'=>'create')) ?>">
	<?php echo I18n::get("Create") ?>
</a>
