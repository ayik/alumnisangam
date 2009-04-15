<?php

/**
 * home actions.
 *
 * @package    shopper
 * @subpackage home
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class homeActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 */

	public function executeFindme()
	{
		$c = new Criteria();
		$branches = BranchPeer::doSelect($c);
		$options = array();
		/*$options[] = 'Select Branch';*/
		foreach($branches as $branch)
		{
			$options[$branch->getId()] = $branch->getName();
		}
		$this->broptions = $options;
		
		$c = new Criteria();
		$degrees = DegreePeer::doSelect($c);
		$options = array();
		/*$options[] = 'Select Degree';*/
		foreach($degrees as $degree)
		{
			$options[$degree->getId()] = $degree->getName();
		}
		$this->dgoptions = $options;
	}
	
	public function executeError404()
	{

	}
	public function executeSecure()
	{

	}

	public function executeLogin()
	{
		$username=$this->getRequestParameter('username');
		$password=$this->getRequestParameter('password');
		if($username){
				$c = new Criteria();
				$c->add(UserPeer::USERNAME, $username);
				$user = UserPeer::doSelectOne($c);
				if($user)
				{
					$islocked=$user->getIslocked();
					if($islocked=="0")
					{
						$salt = md5("I am Indian.");
						if(sha1($salt.$password) == $user->getPassword())
						{
							$c = new Criteria();
							$c->addJoin(UserPeer::ID, UserrolePeer::USER_ID);
							$c->addJoin(UserrolePeer::ROLE_ID, RolePeer::ID);
							$c->add(UserPeer::USERNAME, $username);
							
							$roles = RolePeer::doSelect($c);
							foreach($roles as $role)
							{
								$this->getUser()->addCredential($role->getName());
							}
							$this->getUser()->setAuthenticated(true);
							$this->getUser()->setAttribute('username',$user->getUsername());
							
							$this->getUser()->setAttribute('userid', $user->getId());
							
							date_default_timezone_set('Asia/Kolkata');
							$user->setLastlogin(time());
							$user->save();
							//initiate phpBB session
							$ch = curl_init();
							$timeout = 20;
							curl_setopt($ch, CURLOPT_URL, "http://localhost:80/phpBB3/init_session.php");
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL,1);
							if(sfConfig::get('app_proxy_hasproxy')){
								curl_setopt($ch, CURLOPT_PROXY, sfConfig::get('app_proxy_proxyhost').':'.sfConfig::get('app_proxy_proxyport'));
							}
							curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
							curl_setopt($ch, CURLOPT_POST, 1);
							$sid = trim(curl_exec($ch));
							curl_close($ch);
							$this->getUser()->setAttribute('bbsid', trim($sid));
		/*					
							//phpBB sign in
							$c = new Criteria();
							$c->add(PersonalPeer::USER_ID, $user->getId());
							$personal = PersonalPeer::doSelectOne($c);	
							$email = $personal->getEmail();
		
							$browserdetail = $_SERVER['HTTP_USER_AGENT'];
							$con = sfContext::getInstance()->getDatabaseConnection('v2bb');
							$mapQr = "select user_id as id from phpbb_users where user_email = '".$email."'";
							$mapRslt = $con->executeQuery($mapQr);
							$bbuid = "";
							while($mapRslt->next()){
								$bbuid = $mapRslt->getString('id');
							}
							if($bbuid){
								$upQr = "update phpbb_sessions set session_user_id = '".$bbuid."', session_browser='".$browserdetail."', session_admin='1' where session_id = '".$sid."'";
								$upRslt = $con->executeQuery($upQr);
							}else{
								$insQr = "insert into phpbb_users(user_type, user_email, username, username_clean, user_regdate, group_id, user_ip, user_lang, user_dateformat, user_topic_sortby_type, user_topic_sortby_dir, user_post_sortby_type, user_post_sortby_dir) values('0', '".$email."', '".$user->getUsername()."', '".$user->getUsername()."', '".time()."', '2', '::1', 'en', 'D M d, Y g:i a', 't', 'd', 't', 'a')";
								$con->executeQuery($insQr);
								$bbuid = mysql_insert_id();
								$upQr = "update phpbb_sessions set session_user_id = '".$bbuid."', session_browser='assssdddd', session_admin='1' where session_id = '".$sid."'";
								$rslt = $con->executeQuery($upQr);
							}*/
							
							return $this->redirect('user/welcome');
						}
						else
						{
							$this->setFlash('login', 'Invalid username / password.');
							return $this->redirect('/');
						}
					}
					else
					{
						$this->setFlash('login', 'Username is not Enabled.');
						return $this->redirect('/');
					}
				}
				else
				{
					$this->setFlash('login', 'Username doesn\'t Exist.');
					return $this->redirect('/');
				}
		}
	}
	public function executeLogout()
	{
		$this->getUser()->setAuthenticated();
		$this->getUser()->clearCredentials();
		$this->getUser()->getAttributeHolder()->remove('username');
		$this->getUser()->getAttributeHolder()->remove('userid');
		
		$sid = trim($this->getUser()->getAttribute('bbsid'));
		$con = sfContext::getInstance()->getDatabaseConnection('v2bb');
		$qr = "delete from phpbb_sessions where session_id = '".$sid."'";
		$rslt = $con->executeQuery($qr);

		$this->redirect('/');
	}
	public function executeAccessdenied()
	{


	}
	
	public function executeRecords()
	{
		$year = $this->getRequestParameter('year');
		$branch = $this->getRequestParameter('branch');
		$degree = $this->getRequestParameter('degree');
		
		$c = new Criteria();
		if($year)
		{
			$c->add(UserPeer::GRADUATIONYEAR, $year);
		}
		if($branch)
		{
			$c->addJoin(UserPeer::BRANCH_ID, BranchPeer::ID);
			$c->add(BranchPeer::ID, $branch);
		}
		if($degree){
			$c->addJoin(UserPeer::DEGREE_ID, DegreePeer::ID);
			$c->add(DegreePeer::ID, $degree);
		}
		$this->regusers = UserPeer::doSelect($c);
		$this->year = $year;
		$this->branchname = BranchPeer::retrieveByPK($branch)->getName();
		$this->degreename = DegreePeer::retrieveByPK($degree)->getName();
		$this->getUser()->setAttribute('yr', $year);
		$this->getUser()->setAttribute('br', $branch);
		$this->getUser()->setAttribute('dr', $degree);
	}

	public function executeGetmyaccount()
	{
		$userid = $this->getRequestParameter('id');
		//$newuser = $this->getRequestParameter('newuser');

		if(!$userid){
			$userid = $this->getUser()->getAttribute('claimerid');
			$this->getUser()->getAttributeHolder()->remove('claimerid');
		}
		if($userid){
			$this->user = UserPeer::retrieveByPK($userid);
		}else{
			$this->year = $this->getUser()->getAttribute('yr');
			$this->branchid = $this->getUser()->getAttribute('br');
			$this->degreeid = $this->getUser()->getAttribute('dr');
			$this->branchcode = BranchPeer::retrieveByPK($this->branchid)->getCode();
			$this->degreename = DegreePeer::retrieveByPK($this->degreeid)->getName();
		}
	}
	
	public function executeCheckuser(){
		$username = $this->getRequestParameter('username');
		$c = new Criteria();
		$c->add(UserPeer::USERNAME, $username);
		$this->user = UserPeer::doSelectOne($c);
		$this->un = $username;
	}
	
	public function executeRegistration()
	{
		$userid = $this->getRequestParameter('userid');
		$this->getUser()->getAttributeHolder()->remove('claimerid');
		$roll = $this->getRequestParameter('roll');
		$hawa = $this->getRequestParameter('hawa');
		$city = $this->getRequestParameter('city');
		$hod = $this->getRequestParameter('hod');
		$director = $this->getRequestParameter('director');
		$teacher = $this->getRequestParameter('favteacher');
		$lanka = $this->getRequestParameter('favlankashop');
		$email = $this->getRequestParameter('email');
		$other = $this->getRequestParameter('otherinfo');
		$dusername = $this->getRequestParameter('dusername');
		
		if(!$userid){
			$fname = $this->getRequestParameter('fname');
			$mname = $this->getRequestParameter('mname');
			$lname = $this->getRequestParameter('lname');
			$year = $this->getRequestParameter('year');
			$dusername = $this->getRequestParameter('dusername');
			$formerrors1 = array();
			if(!$fname){
				$formerrors1[] = 'Please enter first name';
			}
			if(!$lname){
				$formerrors1[] = 'Please enter last name';
			}
			if(!$dusername){
				$formerrors1[] = 'Please enter username';
			}
			if($formerrors1){
				$this->getRequest()->setErrors($formerrors1);
				$this->forward('home', 'getmyaccount');
			}
			$branchn = BranchPeer::retrieveByPK($this->getRequestParameter('branchid'));
			$degreen = DegreePeer::retrieveByPK($this->getRequestParameter('degreeid'));
			//$newusername = $fname.".".$lname."@".$branchn->getCode().substr($year, -2);
			
			$currentyear = date('Y');
			if($currentyear <= $year){
				$usertype = '0';
			}else{
				$usertype = '1';
			}
			
			$user = new User();
			$user->setUsername($newusername);
			$user->setRoll($roll);
			$user->setGraduationyear($year);
			$user->setBranchId($branchn->getId());
			$user->setDegreeId($degreen->getId());
			$user->setUsertype($usertype);
			$user->setTempemail($email);
			$user->setIslocked(sfConfig::get('app_islocked_newreg'));
			$user->save();
			
			$personal = new Personal();
			$personal->setUserId($user->getId());
			$personal->setFirstname($fname);
			$personal->setMiddlename($mname);
			$personal->setLastname($lname);
			$personal->setEmail($email);
			$personal->save();
			
			$userid = $user->getId();
		}else{
			$user = UserPeer::retrieveByPK($userid);
			$user->setIslocked(sfConfig::get('app_islocked_claimed'));
			$user->save();
		}
		
		$c = new Criteria();
		$c->add(ClaiminfoPeer::USER_ID, $userid);
		$claiminfo = ClaiminfoPeer::doSelectOne($c);
		if($claiminfo){
			$this->user = $claiminfo->getUser();
			$this->claiminfo = $claiminfo;
		}else{
			$claiminfo = new Claiminfo();
			$claiminfo->setUserId($userid);
			$claiminfo->setRoll($roll);
			$claiminfo->setHawa($hawa);
			$claiminfo->setCity($city);
			$claiminfo->setHod($hod);
			$claiminfo->setDirector($director);
			$claiminfo->setTeacher($teacher);
			$claiminfo->setLankashop($lanka);
			$claiminfo->setOther($other);
			$claiminfo->setDusername($dusername);
			$claiminfo->save(); 
			
			$this->claiminfo = $claiminfo;
			$this->user = $user;
			if($user)
			{
				$username = $user->getUsername();
				$personal = $user->getPersonal();
				$personal->setEmail($email);
				$personal->save();
				
				$sendermail = sfConfig::get('app_from_mail');
				$sendername = sfConfig::get('app_from_name');
				$to = sfConfig::get('app_to_adminmail');
				$subject = "Registration request for ITBHU Global Org";
				$body='
	  Hi,
	 
	  I want to connect to ITBHU Global. My verification information is: 
	
	';
			$body=$body.'Roll Number           : '.$roll.'
	';
			$body=$body.'HAWA                  :  '.$hawa.'
	';
			$body=$body.'City                  :  '.$city.'
	';
			$body=$body.'HoD                   :  '.$hod.'
	';
			$body=$body.'Director              :  '.$director.'
	';
			$body=$body.'Favourite Teacher     :  '.$teacher.'
	';
			$body=$body.'Favuorite Lanka Shop  :  '.$lanka.'
	';
			$body=$body.'My Email              :  '.$email.'
	';		
			$body=$body.'Username I am claiming: '.$username.'
	';
			$body=$body.'Desired Username      : '.$dusername.'
	';
			$body=$body.'Thanks,';
			$body=$body.'
	'.$user->getFullname();
				//send mail to admin
				$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
				//send mail to class authorizer
				$ca = new Criteria();
				$ca->add(UserPeer::GRADUATIONYEAR, $user->getGraduationyear());
				$ca->add(UserPeer::BRANCH_ID, $user->getBranchId());
				$ca->addJoin(UserPeer::ID, UserrolePeer::USER_ID);
				$ca->add(UserrolePeer::ROLE_ID, sfConfig::get('app_role_auth'));
				$authusers = UserPeer::doSelect($ca);
				
				//if class authorizers are available.
				if($authusers){
					foreach ($authusers as $authuser){
						$toauth = $authuser->getEmail(); 
						$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $toauth, $subject, $body);
					}
					$user->setAuthcode(sfConfig::get('app_authcode_classauth'));
					$user->save();
				}else{
					//get other authorizers
					$ugyear = $user->getGraduationyear() - 2;
					$lgyear = $user->getGraduationyear() + 2;
					$oa = new Criteria();
					$oa->add(UserPeer::GRADUATIONYEAR, $ugyear, Criteria::GREATER_EQUAL);
					$oa->add(UserPeer::GRADUATIONYEAR, $lgyear, Criteria::LESS_EQUAL);
					$oa->add(UserPeer::BRANCH_ID, $user->getBranchId());
					$oa->addJoin(UserPeer::ID, UserrolePeer::USER_ID);
					$oa->add(UserrolePeer::ROLE_ID, sfConfig::get('app_role_auth'));
					$authuserspm = UserPeer::doSelect($oa);
					//if other authorizers are available
					if($authuserspm){
						foreach ($authuserspm as $authuserpm){
							$toauth = $authuserpm->getEmail();
							$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $toauth, $subject, $body);
							$user->setAuthcode(sfConfig::get('app_authcode_otherauth'));
							$user->save();
						}
					}else{
						// no authorizers were available, send to master list of authorizers
						$ma = new Criteria();
						$ma->addJoin(UserPeer::ID, UserrolePeer::USER_ID);
						$ma->add(UserrolePeer::ROLE_ID, sfConfig::get('app_role_masterauth'));
						$mauths = UserPeer::doSelect($ma);
						if($mauths){
							foreach ($mauths as $mauth){
								$toauth = $mauth->getEmail();
								$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $toauth, $subject, $body);
								$user->setAuthcode(sfConfig::get('app_authcode_masterauth'));
								$user->save();
							}
						}else{
							$user->setAuthcode(sfConfig::get('app_authcode_none'));
							$user->save();
						}
					}
					
				}
				
				$sendermail = sfConfig::get('app_from_mail');
				$sendername = sfConfig::get('app_from_name');
				$to = $email;
				$subject = "Registration request for ITBHU Global Org";
				$body ='
				Dear '.$user->getFullname().',
				
				Thank you for your connect request. We\'ll get back to you shortly.	
				
				
				Admin,
				ITBHU Global
				';
				$mail = myUtility::sendmail($sendermail, $sendername, $sendermail, $sendername, $sendermail, $to, $subject, $body);
			}
		}
	}

	public function handleErrorRegistration(){
		$userid = $this->getRequestParameter('userid');
		if($userid){
			$this->getUser()->setAttribute('claimerid', $userid);
		}else{
			$this->getUser()->getAttributeHolder()->remove('claimerid');
			$formerrors = array();
			if(!($this->getRequestParameter('fname'))){
				$formerrors[] = 'Please enter first name';
			}
			if(!($this->getRequestParameter('lname'))){
				$formerrors[] = 'Please enter last name';
			}
			if(!($this->getRequestParameter('dusername'))){
				$formerrors[] = 'Please enter username';
			}
			if($formerrors){
				$this->getRequest()->setErrors($formerrors);
			}
		}
		$this->forward('home', 'getmyaccount');
	}
	
	public function executeBulkuploadform()
	{
		
	}

	public function executeBulkupload()
	{
		if($this->getRequest()->getFileName('csvfile'))
		{
	    	$fileName = md5($this->getRequest()->getFileName('csvfile').time().rand(0, 99999));
		 	$ext = $this->getRequest()->getFileExtension('csvfile');
		 	$this->getRequest()->moveFile('csvfile', sfConfig::get('sf_upload_dir')."//csvfiles//".$fileName.".csv");
		 	$fullname = $fileName.".csv";
		 	//$fullpath = '/uploads/csvfiles/'.$fullname;
		 	$fp = sfConfig::get('sf_upload_dir')."//csvfiles//".$fileName.".csv";
			$reader = new sfCsvReader($fp, ',', '"');
			$reader->open();
		
			$i=1;
			$exist[] = array();
			$ignore[] = array();
			$ignoreflag = 0;
			$success = 0;
		    while ($data = $reader->read())
		    {
		    	$name[] = array();
		    	$name = explode(' ', $data[0]);
		    	$roll = $data[1];
		    	$enrol = $data[2];
		    	$branch = $data[3];
		    	$degree = $data[4];
		    	$year = $data[5];
		    	
		    	$c = new Criteria();
		    	$c->add(UserPeer::ENROLMENT, $enrol);
		    	$user = UserPeer::doSelectOne($c);
		    	if(!$user){
			    	$c = new Criteria();
			    	$c->add(BranchPeer::NAME, $branch);
			    	$br = BranchPeer::doSelectOne($c);
			    	if(!$br)
			    	{
			    		$br = new Branch();
			    		$br->setName($branch);
			    		$br->save();
			    	}
			    	
			    	$c = new Criteria();
			    	$c->add(DegreePeer::NAME, $degree);
			    	$dg = DegreePeer::doSelectOne($c);
			    	if(!$dg)
			    	{
			    		$dg = new Degree();
			    		$dg->setName($degree);
			    		$dg->save();
			    	}
			    	
			    	$user = new User();
			    	if($roll){
			    		$user->setRoll($roll);
			    		$user->setRollflag('1');
			    	}
			    	if($enrol){
			    		$user->setEnrolment($enrol);
			    		$user->setEnrolflag('1');
			    	}else{
			    		$ignoreflag = 1;
			    	}
			    	if($year){
			    		$user->setGraduationyear($year);
			    		$user->setGraduationyearflag('1');
			    	}
			    	$user->setBranchId($br->getId());
			    	$user->setBranchflag('1');
			    	$user->setDegreeId($dg->getId());
			    	$user->setDegreeflag('1');
			    	$user->setIslocked('1');
			    	
			    	$lastname = '';
			    	
			    	$personal = new Personal();
			    	$name[0] = str_replace('.', '', $name[0]);
			    	$personal->setFirstname($name[0]);
			    	if($name[3]){
			    		$name[1] = str_replace('.', '', $name[1]);
			    		$name[2] = str_replace('.', '', $name[2]);
			    		$name[3] = str_replace('.', '', $name[3]);
			    		$midname = $name[1]." ".$name[2];
			    		$personal->setMiddlename($midname);
			    		$personal->setLastname($name[3]);
			    		$lastname = $name[3];
			    	}elseif($name[2]){
			    		$name[1] = str_replace('.', '', $name[1]);
			    		$name[2] = str_replace('.', '', $name[2]);
			    		$personal->setMiddlename($name[1]);
			    		$personal->setLastname($name[2]);
			    		$lastname = $name[2];
			    	}
			    	elseif($name[1]){
			    		$name[1] = str_replace('.', '', $name[1]);
			    		$personal->setLastname($name[1]);
			    		$lastname = $name[1];
			    	}
		    		
			    	if($lastname){
			    		$username = $name[0].'.'.$lastname.'@'.$branch.substr($year,-2);
			    	}else{
			    		$username = $name[0].'@'.$branch.substr($year,-2);
			    	}
			    	$temp = 1;
			    	$tempusername = $username;
			    	while($this->uniqueuser($tempusername)){
			    		$tempusername = $username.$temp;
			    	}
			    	
			    	$user->setUsername($tempusername);
			    	if($ignoreflag == 0){
			    		$user->save();
			    		$personal->setUserId($user->getId());
			    		$personal->save();
			    		$success++;
			    	}else{
			    		$ignore[] = $i;
			    		$ignoreflag = 0;
			    	}
			    	
		    	}else{
		    		$exist[] = $i;
		    	}
			    
		    	$i++;
		    } // while ($data = $reader->read()) ends here
		    $reader->close();
		    
			$this->sc = $success;
			$this->ig = $ignore;
			$this->ex = $exist;
		}
	}
	
	public function handleErrorBulkupload()
	{
		$this->forward('home', 'bulkuploadform');
	}
	
	protected function uniqueuser($username){
		$c = new Criteria();
		$c->add(UserPeer::USERNAME, $username);
		$user = UserPeer::doSelectOne($c);
		if($user){
			return true;
		}else{
			return false;
		}
	}

	
	public function executeSearchform()
	{
		$c = new Criteria();
		$branches = BranchPeer::doSelect($c);
		$options = array();
		$options[] = 'Select Department';
		foreach($branches as $branch)
		{
			$options[$branch->getId()] = $branch->getName();
		}
		$this->broptions = $options;	
		
		$c = new Criteria();
		$chapters = ChapterPeer::doSelect($c);
		$options = array();
		$options[] = 'Select Chapter';
		foreach($chapters as $chapter)
		{
			$options[$chapter->getId()] = $chapter->getName();
		}
		$this->choptions = $options;
		
		$degrees = DegreePeer::doSelect(new Criteria());
		$options = array();
		$options[] = 'Select Degree';
		foreach($degrees as $degree)
		{
			$options[$degree->getId()] = $degree->getName();
		}
		$this->dgoptions = $options;
		
		$options = array();
		$options[] = 'Select Year';
		for($i=1923; $i<=2013; $i++)
		{
			$options[$i] = $i;
		}
		$this->yroptions = $options; 
		
		$this->mdl = $this->getRequestParameter('m');
		$this->fnc = $this->getRequestParameter('f');
		$this->hdr = $this->getRequestParameter('h');
		$this->option = $this->getRequestParameter('o');
	}
	
	public function executeSearch()
	{
		$this->mdl = $this->getRequestParameter('mdl');
		$this->fnc = $this->getRequestParameter('fnc');
		$this->option = $this->getRequestParameter('o');
		$branchid = $this->getRequestParameter('branch');
		$chapterid = $this->getRequestParameter('chapter');
		$year = $this->getRequestParameter('year');
		$degreeid = $this->getRequestParameter('degree');
		$currentlyat = $this->getRequestParameter('currentlyat');
		
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
			return $this->redirect('home/searchform');
		}
		$this->chapterid = $chapterid;
	}
	
}