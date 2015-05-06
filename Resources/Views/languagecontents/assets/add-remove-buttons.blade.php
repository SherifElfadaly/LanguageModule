<script type="text/javascript">
	$('#add').on('click', function(e){
		$('.data').last().after($('<div>').append($('.data').last().clone()).html());
	});

	$('#remove').on('click', function(e){
		if($('.data').length > 1)
		{
			$('.data').last().remove();
		}
	});
</script>