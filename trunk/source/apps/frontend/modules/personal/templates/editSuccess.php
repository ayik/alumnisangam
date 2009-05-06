<?php include_component('home','leftmenu'); ?>
<?php
// auto-generated by sfPropelCrud
// date: 2009/02/10 08:16:08
?>
<?php use_helper('Object') ?>
<?php echo form_tag('personal/update', 'multipart=true') ?>
<?php echo object_input_hidden_tag($personal, 'getId') ?>
<input type="hidden" name="user_id" value="<?php echo $personal->getUserId(); ?>">


<div class="page">
	<h3>Edit Profile</h3>
	<div class="vspacer20">&nbsp;</div>
	<div class="oddRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">Profile Image :</div></div>
		<div class="editrowdatamiddle"><?php echo input_file_tag('image', array('size'=>'30')); ?></div>
		<div class="editrowdataright"><span id="deletemsg">&nbsp;</span><img src="/images/delete.png" alt="Delete profile image" onclick="deleteimage('<?php echo $personal->getId() ?>')" style="cursor: pointer;"></div>
	</div>
	<div class="evenRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">Salutation :</div></div>
		<div class="editrowdatamiddle"><?php echo select_tag('salutation', options_for_select($salutations, $personal->getSalutation())); ?></div>
		<div class="editrowdataright">&nbsp;</div>
	</div>
	<div class="oddRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">First Name :</div></div>
		<div class="editrowdatamiddle"><?php echo object_input_tag($personal, 'getFirstname', array ( 'size' => 30)) ?></div>
		<div class="editrowdataright">&nbsp;</div>
	</div>
	<div class="evenRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">Middle Name :</div></div>
		<div class="editrowdatamiddle"><?php echo object_input_tag($personal, 'getMiddlename', array ( 'size' => 30)) ?></div>
		<div class="editrowdataright">&nbsp;</div>
	<div class="oddRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">Last Name :</div></div>
		<div class="editrowdatamiddle"><?php echo object_input_tag($personal, 'getLastname', array ( 'size' => 30)) ?></div>
		<div class="editrowdataright">&nbsp;</div>
	</div>
	<div class="evenRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">Maiden Name :</div></div>
		<div class="editrowdatamiddle"><?php echo object_input_tag($personal, 'getMaidenname', array ( 'size' => 30)) ?></div>
		<div class="editrowdataright">
			<img src="/images/privacy.png" alt="privacy"/>
			<?php echo select_tag('maidennameflag', options_for_select($privacyoptions, $personal->getMaidennameflag())) ?>
		</div>
	</div>
	<div class="oddRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">IT BHU Name :</div></div>
		<div class="editrowdatamiddle"><?php echo object_input_tag($personal, 'getItbhuname', array ( 'size' => 30)) ?></div>
		<div class="editrowdataright">
			<img src="/images/privacy.png" alt="privacy"/>
			<?php echo select_tag('itbhunameflag', options_for_select($privacyoptions, $personal->getItbhunameflag())) ?>
		</div>
	</div>
	<div class="evenRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">Gender :</div></div>
		<div class="editrowdatamiddle"><?php echo object_input_tag($personal, 'getGender', array ( 'size' => 30)) ?></div>
		<div class="editrowdataright">
			<img src="/images/privacy.png" alt="privacy"/>
			<?php echo select_tag('genderflag', options_for_select($privacyoptions, $personal->getGenderflag())) ?>
		</div>
	</div>
	<div class="oddRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">Date Of Birth :</div></div>
		<div class="editrowdatamiddle"><?php echo object_input_date_tag($personal, 'getDob', array ( 'rich' => true, 'withtime' => false, 'size' => 30, 'img'=>'/images/delete.png', 'readonly'=>'readonly' )) ?></div>
		<div class="editrowdataright">
			<img src="/images/privacy.png" alt="privacy"/>
			<?php echo select_tag('dobflag', options_for_select($privacyoptions, $personal->getDobflag())) ?>
		</div>
	</div>
	<div class="evenRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">Marital Status :</div></div>
		<div class="editrowdatamiddle"><?php echo object_input_tag($personal, 'getMaritalstatus', array ( 'size' => 30,)) ?></div>
		<div class="editrowdataright">
			<img src="/images/privacy.png" alt="privacy"/>
			<?php echo select_tag('maritalstatusflag', options_for_select($privacyoptions, $personal->getMaritalstatusflag())) ?>
		</div>
	</div>
	<div class="oddRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">Email :</div></div>
		<div class="editrowdatamiddle"><?php echo object_input_tag($personal, 'getEmail', array ( 'size' => 30)) ?></div>
		<div class="editrowdataright">&nbsp;</div>
	</div>
	<div class="evenRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">Website :</div></div>
		<div class="editrowdatamiddle"><?php echo object_input_tag($personal, 'getWebsite', array ( 'size' => 30)) ?></div>
		<div class="editrowdataright">
			<img src="/images/privacy.png" alt="privacy"/>
			<?php echo select_tag('websiteflag', options_for_select($privacyoptions, $personal->getWebsiteflag())) ?>
		</div>
	</div>
	<div class="oddRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">LinkedIn :</div></div>
		<div class="editrowdatamiddle"><?php echo object_input_tag($personal, 'getLinkedin', array ( 'size' => 30)) ?></div>
		<div class="editrowdataright">
			<img src="/images/privacy.png" alt="privacy"/>
			<?php echo select_tag('linkedinflag', options_for_select($privacyoptions, $personal->getLinkedinflag())) ?>
		</div>
	</div>
	<div class="evenRow">
		<div class="editrowdataleft"><div class="editrowdatalefttext">Current Location :</div></div>
		<div class="editrowdatamiddle"><?php $user = $personal->getUser(); echo object_input_tag($user, 'getCurrentlyat', array ( 'size' => 30)) ?></div>
		<div class="editrowdataright">
			<img src="/images/privacy.png" alt="privacy"/>
			<?php echo select_tag('currentlyatflag', options_for_select($privacyoptions, $user->getCurrentlyatflag())) ?>
		</div>
	</div>
	<div class="vspacer20">&nbsp;</div>
	<div class="formbuttons">
		<input type="image" src="/images/update.png" alt="Update" title="Save and Back to View">
		<a href="<?php echo '/personal/show/id/'.$personal->getId() ?>.html">
			<img src="/images/back.png" alt="Back" title="Back to View">
		</a>
	</div>
	<div class="vspacer20">&nbsp;</div>
</div>
</form>

<?php /*
   echo textarea_tag('itemname','',array(
	'rich' => 'fck',
	'height' => 295,
	'width'	=> 770,'class' => 'descclass'

   )); 
    $contenttext = $this->getRequestParameter('itemname');
  	if(strpos($contenttext,'<p>')>=0){

			$contenttext=str_replace('<p>','',$contenttext);
			$contenttext=str_replace('</p>','<br/>',$contenttext);
		}
    $personal->setLinkedin($contenttext);
*/ ?>
<script type="text/javascript">
function deleteimage(id)
{
	var conf = confirm("Are you sure !!");
	if(conf){
		var url="/personal/deleteimage.html";
		var userid = "id="+id;
		//var un = document.getElementById('dusername').value;200544734
		new Ajax.Updater('deletemsg', url, {method: 'get', parameters: userid,onComplete:function() {
			alert("Profile Image deleted Successfully");
			}});
	}
}
</script>