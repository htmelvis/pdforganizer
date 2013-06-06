<table>
	<tr valign="top">
		<th class="metabox_label_column">
			<label for="upload_pdf">Upload Catalog File</label>
		</th>
		<td>
			<label for="upload_pdf">
			<input id="upload_pdf"  type="text" size="36" name="upload_pdf" value="<?php echo @$filename; ?>" />
			<input id="upload_image_button" type="button" value="Upload Catalog File" />
			<br /> Enter a URL or upload a Catalog file for a Catalog
			</label>
		</td>
		
	</tr>
	<tr valign="top">
		<th class="metabox_label_column">
			<label for="meta_desc">Description</label>
		</th>
		<td>
			<textarea type="text" id="meta_desc" name="meta_desc" maxlength="105"><?php  echo @$description;  ?></textarea>
			<p><em>Must be under 105 characters(includes spaces)</em></p>

		</td>
		
	</tr>
</table>