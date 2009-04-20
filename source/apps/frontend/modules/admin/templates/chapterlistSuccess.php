<?php include_component('home','leftmenu');
	include_component('home', 'messages');
?>
<?php
// auto-generated by sfPropelCrud
// date: 2009/02/10 08:17:52
?>
<div class="page">
	<h3>Chapters</h3>
	<div class="vspacer20">&nbsp;</div>
	<div class="oddRow">
		<div class="listleft"><b>Chapter</b></div>
		<div class="listright"><b>Region</b></div>
	</div>
	<?php $i = 1; 
		foreach ($chapters as $chapter): 
		$i++;
	?>
	<div class="<?php if($i%2==0): echo 'evenRow'; else: echo 'oddRow'; endif; ?>">
	      <div class="listleft"><?php echo $chapter->getName() ?></div>
	      <div class="listright"><?php echo $chapter->getRegion()->getName() ?></div>
	</div>
	<?php endforeach; ?>
	
	<div class="addchapter" id="addchapter">
		<form action="/admin/addchapter.html" name="addchapter" method="post" onsubmit="return validate()">
			<div class="vspacer10">&nbsp;</div>
				<div class="addRow">
				<div class="rowData">
				Chapter :&nbsp;&nbsp;<input type="text" name="chapter" id="addname">&nbsp;&nbsp;&nbsp;&nbsp;Region :&nbsp;&nbsp;<?php echo select_tag('region', options_for_select($regionOptions) ) ?>
				&nbsp;&nbsp;
				</div>
				<div class="rowImage">
					<input type="image" src="/images/add.png" alt="add">&nbsp;&nbsp;
					<img src="/images/cancel.png" alt="cancel" onclick="javascript:document.getElementById('addchapter').style.display='none'" style="cursor: pointer;"></div>
				</div>
			<div class="vspacer10">&nbsp;</div>
		</form>
	</div>
	
	<div class="vspacer20">&nbsp;</div>
	<div class="formbuttons"><input type="image" src="/images/addchapter.png" alt="Add Chapter" onclick="javascript:document.getElementById('addchapter').style.display='block'"></div>
	<div class="vspacer20">&nbsp;</div>
</div>

<script type="text/javascript">
	function validate(){
		if(document.getElementById('addname').value == ''){
			alert("Please Enter a name");
			return false;
		}
	}

</script>