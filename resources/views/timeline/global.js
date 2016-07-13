$('input#name-submit').on('click',function(){
	alert("working");
	var name=$('input#name').val();
	var uname=$('#action').val();
	
	if($.trim(name)!='')
	{
		$.post('ajax/name.php',{name:name,action:uname}, function(data){
			$('div#name-data').text(data);
		});
	}
});
