$(document).ready(function(){
	// 找到todo-list-item-template的html內容
	// 用handlebars的套件comile後 值放入template
	var source = $('#todo-list-item-template').html();
	var todotemplate = Handlebars.compile(source);

	
	var todolistUI = '';
	// prepare all todo list items
	$.each(todos, function(index, todo) {
		todolistUI = todolistUI + todotemplate(todo); // 字串相接
	});
	$('#todo-list').find('li.new').before(todolistUI);	


	//enter editor mode
	$('#todo-list')
		.on('dblclick', '.content', function(e){
			$(this).prop('contenteditable', true).focus(); // 將文字編輯值為true
		})
		.on('blur', '.content', function(e){
			var isNew = $(e.currentTarget).closest('li').is('.new');
			// create
			if(isNew){
				var todo = $(e.currentTarget).text(); //this = e.currentTarget 
				todo = todo.trim(); //trim可以去掉頭尾的空格
				// 輸入資料長度去掉空格大於0 才做新增
				if (todo.length>0) {
					var order = $('#todo-list').find('li:not(.new)').length +1;

					//AJAX: create API
					$.post('todo/create.php', {content: todo, order: order}, function(data, textStatus, xhr){
						todo = {
							id: data.id,
							is_complete: false,
							content: todo,
						};
						var li = todotemplate(todo);
						$(e.currentTarget).closest('li').before(li);
					});
				}
					$(e.currentTarget).empty();
			}
			// update
			else{
				// AJAX call
				var id = $(this).closest('li').data('id');
				var content = $(this).text();
				$.post('todo/update.php', { id: id, content: content });
				$(this).prop('contenteditable', false);
			}
		})
		// delete
		.on('click', '.delete', function(e){
			var result = confirm('Do you want to delete?');
			if(result){
				//AJAX call
				var id = $(this).closest('li').data('id');
				$.post('todo/delete.php', { id: id}, function(data, textStatus, xhr){
				$(e.currentTarget).closest('li').remove();	
				});
			}
		})
		//complete
		.on('click', '.checkbox', function(e){
			//AJAX call
			var id = $(this).closest('li').data('id');
			$.post('todo/complete.php', { id: id}, function(data, textStatus, xhr){
			   $(e.currentTarget).closest('li').toggleClass('complete');// toggle是開關
			});
		});
	//enter editor mode

	//sort by JQuery UI套件
	//AJAX call
	
	$('#todo-list').find('ul').sortable({
		items: 'li:not(.new)',
		stop: function(){
			var orderpair = [];
	      $('#todo-list').find('li:not(.new)').each(function(index, li){
			orderpair.push({
				id: $(li).data('id'),
				order: index +1,
			});
		  });
		  $.post('todo/sort.php', { orderpair: orderpair});
		},
	});
});