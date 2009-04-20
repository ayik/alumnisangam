<?php
// auto-generated by sfPropelCrud
// date: 2009/02/10 08:14:41
?>
<?php

/**
 * user actions.
 *
 * @package    sf_sandbox
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 3335 2007-01-23 16:19:56Z fabien $
 */
class userActions extends sfActions
{
  public function executeIndex()
  {
    return $this->forward('user', 'pendinglist');
  }

  public function executeList()
  {
    $this->users = UserPeer::doSelect(new Criteria());
  }

  public function executeShow()
  {
    $this->user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->user);
  }

  public function executeCreate()
  {
    $this->user = new User();

    $this->setTemplate('edit');
  }

  public function executeEdit()
  {
    $this->user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
    $this->forward404Unless($this->user);
  }

  public function executeUpdate()
  {
    if (!$this->getRequestParameter('id'))
    {
      $user = new User();
    }
    else
    {
      $user = UserPeer::retrieveByPk($this->getRequestParameter('id'));
      $this->forward404Unless($user);
    }

    $user->setId($this->getRequestParameter('id'));
    $user->setUsername($this->getRequestParameter('username'));
    $user->setPassword($this->getRequestParameter('password'));
    $user->setEnrolment($this->getRequestParameter('enrolment'));
    $user->setEnrolflag($this->getRequestParameter('enrolflag'));
    $user->setRoll($this->getRequestParameter('roll'));
    $user->setRollflag($this->getRequestParameter('rollflag'));
    $user->setGraduationyear($this->getRequestParameter('graduationyear'));
    $user->setGraduationyearflag($this->getRequestParameter('graduationyearflag'));
    $user->setBranchId($this->getRequestParameter('branch_id') ? $this->getRequestParameter('branch_id') : null);
    $user->setBranchflag($this->getRequestParameter('branchflag'));
    $user->setDegreeId($this->getRequestParameter('degree_id') ? $this->getRequestParameter('degree_id') : null);
    $user->setDegreeflag($this->getRequestParameter('degreeflag'));
    $user->setSecretquestion($this->getRequestParameter('secretquestion'));
    $user->setSecretanswer($this->getRequestParameter('secretanswer'));
    $user->setIslocked($this->getRequestParameter('islocked', 0));

    $user->save();

    return $this->redirect('user/show?id='.$user->getId());
  }

  public function executeDelete()
  {
    $user = UserPeer::retrieveByPk($this->getRequestParameter('id'));

    $this->forward404Unless($user);

    $user->delete();

    return $this->redirect('user/list');
  }
  

  


  

  
  public function executeForgotpasswordform(){
  	
  }
  
  public function executeForgotpassword()
  {
  	$email = $this->getRequestParameter('forgotemail');
  	$c = new Criteria();
  	$c->add(PersonalPeer::EMAIL, $email);
  	$personal = PersonalPeer::doSelectOne($c);
  	if($personal)
  	{
	  	$user = $personal->getUser();
	  	$name = $user->getFullname();
		$newpassword = $this->generatePassword();
	  	$user->setPassword($newpassword);
	  	$user->save();
	  	
	  	$sendermail = sfConfig::get('app_from_mail');
		$sendername = sfConfig::get('app_from_name');
		$to = $email;
		$subject = "Password reset request for ITBHU Global Org";
		$body ='
		Dear '.$name.',
		
		As per your request, your password has been reset.
		
		Your Login Details are:
		
		Username: '.$user->getUsername().'
		Password: '.$newpassword.'
		
		Admin,
		ITBHU Global
		';
		
	  	$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
  	}
	//$this->setFlash('fp', 'If the Email provided by you is correct and registered, You\'ll recieve a mail soon.' );
  }
  
  public function handleErrorForgotpassword()
  {
		$this->forward('user','forgotpasswordform');
  }

  public function executeWelcome(){
  	$this->user = UserPeer::retrieveByPK($this->getUser()->getAttribute('userid')); 
  }

  public function executeSearch()
	{
		$this->mdl = $this->getRequestParameter('mdl');
		$this->fnc = $this->getRequestParameter('fnc');
		
		$branchid = $this->getRequestParameter('branchoption');
		$chapterid = $this->getRequestParameter('chapteroption');
		$year = $this->getRequestParameter('yearoption');
		$degreeid = $this->getRequestParameter('degreeoption');
		// $currentlyat = $this->getRequestParameter('currentlyat');
		
		$flag = 0;
		
		$c = new Criteria();
		if($branchid != 0)
		{
			$c->add(UserPeer::BRANCH_ID, $branchid);
			$flag = 1;
		}
		if($chapterid != 0)
		{
			$c->addJoin(UserPeer::ID, UserchapterregionPeer::USER_ID);
			$c->addJoin(UserchapterregionPeer::CHAPTERREGION_ID, ChapterregionPeer::ID);
			$c->add(ChapterregionPeer::CHAPTER_ID, $chapterid);
			$flag = 1;
		}
		if($year != 0)
		{
			$c->add(UserPeer::GRADUATIONYEAR, $year);
			$flag = 1;
		}
		if($degreeid != 0)
		{
			$c->add(UserPeer::DEGREE_ID, $degreeid);
			$flag = 1;
		}

		if($flag == 1)
		{
			$this->results = UserPeer::doSelect($c);
		}
		else
		{
			$this->flag = 1;
			$this->setFlash('searchnone', 'Select At least one field...');
			return $this->redirect('user/searchform');
		}
		$this->chapterid = $chapterid;
	}
  
  public function executeComposemail(){
	$this->toid =$this->getRequestParameter('id');
	$this->user = UserPeer::retrieveByPK($this->toid);
  }

  public function executeSendmail(){
		$subject = $this->getRequestParameter('subject');
		$body = $this->getRequestParameter('mailbody');
		
		$loggeduser = UserPeer::retrieveByPK($this->getUser()->getAttribute('userid'));
		$sendermail = $loggeduser->getEmail();
		$sendername = $loggeduser->getFullname();

		$user = UserPeer::retrieveByPK($this->getRequestParameter('toid'));
		$to = $user->getEmail();
		$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
		
		$this->setFlash('notice', '<font style="background-color: yellow">Mail sent to <b>'.$user->getFullname().'</b> successfully.</font>');
  		$this->redirect('search/result?page='.$this->getUser()->getAttribute('srpage'));
		/*$sendermail = sfConfig::get('app_from_mail');
		$sendername = sfConfig::get('app_from_name');*/
		/*$userids = $this->getUser()->getAttribute('uu');
		$this->getUser()->getAttributeHolder()->remove('uu');*/
/*		if($option == 'm'){
			echo count($userids);
			foreach ($userids as $uid){
				echo "hello";
				$ab = $uid;
				$user = UserPeer::retrieveByPK($uid);
				$to = $user->getEmail();
				$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
			}
		}
		else {
		echo count($userids);
			foreach ($userids as $uid){
				echo "hello";
				$ab = $uid;
				$user = UserPeer::retrieveByPK($uid);
				$to = $user->getEmail();
				$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
			}
		}*/
  }
  
  public function executeLor(){
  	$lorById = $this->getUser()->getAttribute('userid');
  	$lorByUser = UserPeer::retrieveByPK($lorById);
  	$lorForId = $this->getRequestParameter('lorfor');
  	$lorForUser = UserPeer::retrieveByPK($lorForId);
 	$newmail = $this->getRequestParameter('email');
    if($newmail){
  		$this->lorsave(sfConfig::get('app_lor_email'), $newmail, $lorForId);

  		if($lorForUser->getIslocked() == sfConfig::get('app_islocked_approved'))
  		{
  			$mail = new sfMail();
			$mail->initialize();
			$mail->addCc(sfConfig::get('app_to_adminmail'));
			$mail->addAddress($lorForUser->getEmail());
			
	  		$sendermail = sfConfig::get('app_from_mail');
			$sendername = sfConfig::get('app_from_name');
			$to = $newmail;
			$subject = "Alert: Did you changed your email";
			$body ='
			
Hi '.$lorForUser->getFullname().',
	
	'.$lorByUser->getFullname().' has told us that your email address is 
	actually '.$newmail.'. Is that so? If so, please update it by logging in. If you 
	are having trouble with that, let the admin know [CC\'d on this email].
	
	Admin,
	ITBHU Global
	';
				
		  	$mail = myUtility::newsendmail($mail,$sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
  		}elseif($lorForUser->getIslocked() == sfConfig::get('app_islocked_unclaimed')){
			$mail = new sfMail();
			$mail->initialize();
			$mail->addCc(sfConfig::get('app_to_adminmail'));
			$mail->addAddress($lorForUser->getEmail());
			
	  		$sendermail = sfConfig::get('app_from_mail');
			$sendername = sfConfig::get('app_from_name');
			$to = $newmail;
			$subject = "Alert: Connect with your friends at ".sfConfig::get('app_names_org');
			$body ='
			
Hi '.$lorForUser->getFullname().',
	
	'.$lorByUser->getFullname().' has told us that your email address is 
	actually '.$newmail.'.  If so, we strongly encourage you to claim it 
	at '.sfConfig::get('app_urls_claim').' so you can connect with your friends.
	
	Admin,
	ITBHU Global
	';
				
		  	$mail = myUtility::newsendmail($mail,$sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
  			
  		}
  	}
  	if($this->getRequestParameter('location')){
  		$this->lorsave(sfConfig::get('app_lor_location'), $this->getRequestParameter('location'), $lorForId);
  	}
    if($this->getRequestParameter('employer')){
  		$this->lorsave(sfConfig::get('app_lor_employer'), $this->getRequestParameter('employer'), $lorForId);
  	}
    if($this->getRequestParameter('position')){
  		$this->lorsave(sfConfig::get('app_lor_position'), $this->getRequestParameter('position'), $lorForId);
  	}  	
    if($this->getRequestParameter('linkedin')){
  		$this->lorsave(sfConfig::get('app_lor_linkedin'), $this->getRequestParameter('linkedin'), $lorForId);
  	}  	
    if($this->getRequestParameter('general')){
  		$this->lorsave(sfConfig::get('app_lor_general'), $this->getRequestParameter('general'), $lorForId);
  	}  	
  	
  	$this->setFlash('notice', '<font style="background-color: yellow">Comment for <b>'.$lorForUser->getFullname().'</b> saved successfully.</font>');
  	$this->redirect('search/result?page='.$this->getUser()->getAttribute('srpage'));
  }
  
  protected function lorsave($fieldid, $data, $lorForId){
  	$lorById = $this->getUser()->getAttribute('userid');

  	$lor = new Lorvalues();
  	$lor->setLorfieldsId($fieldid);
  	$lor->setData($data);
  	$lor->setUserId($lorById);
  	$lor->setCreatedAt(time());
  	$lor->save();

  	$loruser = new Loruser();
  	$loruser->setLorvaluesId($lor->getId());
  	$loruser->setUserId($lorForId);
	$loruser->save();
  }
	
  public function executeLorform(){
  	$this->lorForId = $this->getRequestParameter('id');
  	$user = UserPeer::retrieveByPK($this->lorForId);
  	$this->fullname = $user->getFullname();
  }
  
  public function executeInvite(){
	$userid =  $this->getUser()->getAttribute('userid');
	$user = UserPeer::retrieveByPK($userid);
    $this->fullname = $user->getFullname();
  }
  
  public function executeSendinvite(){
	   $this->emailid =$this->getRequestParameter('emailid');
	    
		$userid = $this->getRequestParameter('userid');
		$subject = $this->getRequestParameter('subject');
		$body = $this->getRequestParameter('message');
	  	$sendermail = sfConfig::get('app_from_mail');
		$sendername = sfConfig::get('app_from_name');
		$user = UserPeer::retrieveByPK($userid);
		$to = $this->emailid ;
		$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
  }

  public function handleErrorSendinvite()
	{
		$this->forward('user','sendinvite');
	}

}

  