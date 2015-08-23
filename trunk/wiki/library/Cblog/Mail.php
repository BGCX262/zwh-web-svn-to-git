<?php
class Cblog_Mail{
	
		private $_sender;
		private $_email;
		private $_password;
		private $_subject;
		private $_message;
		private $_username;
		private $_config;
		private $_server; 
		private $_transport='smtp';//默认的是smtp
		private $_toEmail;
		private $_attachment;//这里附件的传值是一个Zend_Form_Element
		private $_htmlMessage; 
		private $_ssl=null;
		private $_port=null;
		public function __construct($sender,$email,$password,$subject,$message,$attachment=null){
				$this->_sender=$sender;
				$this->_email=$email;
				$this->_password=$password;
				$this->_subject=$subject;
				$this->_message=$message;
				$this->_attachment=$attachment;
		}
		
		private  function initServerType(){
				if('' !== $this->_email && ''!==$this->_transport){
						$arr = explode("@", $this->_email);
						$this->_server=$this->_transport.".".$arr[1];
						
				}
		}
		private function initUsername(){
				if('' !== $this->_email){
						$arr = explode("@", $this->_email);
						echo $this->_username;
						$this->_username=$arr[0];
				}
		}
					
		private function iniConfig(){
				if(!empty($this->_config)){
						return;	
				}else{
					$this->_config = array(
						'auth' => 'login',
						'username' =>$this->_email,
						'password' =>$this->_password,
						'ssl'=>$this->_ssl,//这里默认采取加密传输
						'port'=>$this->_port
					);
				}
		}
	   private function initHtmlMessage(){
$mailHeader =<<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
EOD;
   	
$mailFooter =<<<EOD
</body>
</html>
EOD;
			$this->_htmlMessage =$mailHeader.$this->_message.$mailFooter;
		}
		public function setConfig($config=array()){
			if(!empty($config)){
				$this->_config=$config;
			}
		}
		public function setHtmlMessage($htmlMessage){
			if(''!==$htmlMessage){
				$this->_htmlMessage=$htmlMessage;
			}
		}
		public function setTransportSLL($ssl='ssl'){
				$this->_ssl = $ssl;
		}
		public function setTransportPORT($port=465){
				$this->_port = $port;
		}
		/*
		 * 这里默认为smtp协议传输邮件
		 */
		public function setTransport($Transport='smtp'){
				if(''!==$Transport){
					$this->_transport = $Transport;
				}
		}
		public function setToMail($ToEmail){
			if(''!==$ToEmail){
				$this->_toEmail = $ToEmail;
			}
		}
		
		public function sendMail(){
			
			$this->initServerType();
			$this->initUsername();
			$this->initHtmlMessage();
			$this->iniConfig();
			
			$mail = new Zend_Mail('utf-8');
			if(''!==$this->_server){
				$transport= new Zend_Mail_Transport_Smtp($this->_server,$this->_config);
			}
			
			if(''!==$this->_subject){
				$mail->setSubject($this->_subject);
			}
			
			if(''!==$this->_email && ''!==$this->_sender){
				$mail->setFrom($this->_email,$this->_sender);
			}
			if(''!==$this->_toEmail){
				$arr = explode('@', $this->_toEmail);
				$mail->addTo($this->_toEmail,$arr[0]);
			}
			if(null!==$this->_attachment){
				if($this->_attachment->isUploaded()){
					$attachmentName = $this->_attachment->getFileName();
					$fileStream = file_get_contents($attachmentName);
					$attachment = $mail->createAttachment($fileStream);
					$attachment->filename = basename($attachmentName);
				}
			}
			$mail->setBodyHtml($this->_htmlMessage,'utf-8','utf-8'); 
	        $mail->setBodyText($this->_message,'utf-8','utf-8'); 
	        $result = $mail->send($transport); 
			return $result;
		}	
}