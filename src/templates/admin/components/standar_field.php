<label for="<?php echo $field_name; ?>"><?php echo $field_title; ?></label>
<select name="<?php echo $field_name; ?>" id="<?php echo $field_id; ?>" class="postbox" >
    <?php foreach ($field_options as $opkey => $option): ?>
		
		<option value="<?php  echo $option['val'] ?>" <?php echo ($default_value==$option['val'])?'selected':''; ?> ><?php  echo $option['text'] ?></option>

	<?php endforeach; ?>
</select>