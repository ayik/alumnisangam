<?php include_component('home', 'leftmenu'); ?>

<div class="page">
	<h3>
		<?php echo image_tag('/images/icons/cancel48.png', array('alt' => 'page not found', 'class' => 'sfTMessageIcon', 'size' => '14x14')) ?>
		&nbsp;Oops! Page Not Found
	</h3>
	<?php use_stylesheet('/css/screen.css', 'last') ?>
	<div id="error404">
	<!--
		<div class="sfTMessageContainer sfTAlert"> 
		  <?php echo image_tag('/images/icons/cancel48.png', array('alt' => 'page not found', 'class' => 'sfTMessageIcon', 'size' => '48x48')) ?>
		  <div class="sfTMessageWrap">
		    <h1>Oops! Page Not Found</h1>
		    <h5>The server returned a 404 response.</h5>
		  </div>
		</div>
	-->
	<dl class="sfTMessageInfo">
	  <dt>Did you type the URL?</dt>
	  <dd>You may have typed the address (URL) incorrectly. Check it to make sure you've got the exact right spelling, capitalization, etc.</dd>
	
	  <dt>Did you follow a link from somewhere else at this site?</dt>
	  <dd>If you reached this page from another part of this site, please email us at <?php echo mail_to('[email]') ?> so we can correct our mistake.</dd>
	
	  <dt>Did you follow a link from another site?</dt>
	  <dd>Links from other sites can sometimes be outdated or misspelled. Email us at <?php echo mail_to('[email]') ?> where you came from and we can try to contact the other site in order to fix the problem.</dd>
	
	  <dt>What's next</dt>
	  <dd>
	    <ul class="sfTIconList">
	      <li class="sfTLinkMessage"><a href="javascript:history.go(-1)">Back to previous page</a></li>
	      <li class="sfTLinkMessage"><?php echo link_to('Go to Homepage', '@homepage') ?></li>
	    </ul>
	  </dd>
	</dl>
	</div>
</div>