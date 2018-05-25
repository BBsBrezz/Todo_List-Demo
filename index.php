<?php include 'header.php'; ?>
<?php include 'data.php'; ?>

<div id="panel">
	<h1>Todo List</h1>
	<div id="todo-list">
		<ul>
			<li class = "new">
				<div class="checkbox"></div>
				<div class="content" contenteditable="true"></div>
				</div>
			</li>
		</ul>
	</div>
</div>


<!-- 利用handlebars隱藏並協助撰寫新增事項  -->
<script id="todo-list-item-template" type="text/x-handlebars-template">
	<li data-id="{{id}}" class="{{#if is_complete}}complete{{/if}}"> 
		<!-- 如果是的話就印complete 若不是就不印 -->
		<div class="checkbox"></div>
		<div class="content">{{content}}</div>
		<div class="actions">
			<div class="delete">x</div>
		</div>
	</li>
</script>

<?php include 'footer.php'; ?>