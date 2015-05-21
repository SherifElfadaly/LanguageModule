<script type="text/javascript">
	$(document).ready(function () {
		mediaLibrary.init(function(checkedValues)
		{
			url = '{{ url("admin/language/languagecontents/languagecontentgalleries") }}';
			console.log(url);
			$.ajax({
				url         : url,
				type        : 'GET',
				data        : {'ids': checkedValues},
				success     : function(data)
				{
					if(data[0].type === 'photo')
						img = '<img alt="' + data[0].caption + '" src="' + data[0].path + '"/>';
					else
						img = '<iframe src="' + data[0].path + '" frameborder="0" allowfullscreen></iframe>';

					tinyMCE.execCommand('mceInsertContent', false, img);
				}
			});
		});
	});
</script>
