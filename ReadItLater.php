<?php

class ReadItLater{
			
		var $url = "https://readitlaterlist.com/v2/";	
		// get ur key from http://readitlaterlist.com/api/signup/
		var $api_key = "";
		
		var $username = '';
		var $password = '';
		
		public function ReadItLater($username,$password){
			try{
					if($username && $password){
						$this->username = $username;
						$this->password  = $password;				
					}else{
						throw new Exception("Please pass username and password");
					}
					
					$value = $this->authenticate();
				}catch(Exception $e){
					echo $e->getMessage();
			}
		}
		
		public function authenticate(){
			$data = "username=".$this->username.
							 "&password=".$this->password.
							 "&apikey=".$this->api_key;
			$this->serverCall('auth',$data);				 
		}
		
		public function register(){
			$data = "username=".$this->username.
							 "&password=".$this->password.
							 "&apikey=".$this->api_key;
			$this->serverCall('signup',$data);				 
		}

		public function addSingle($url,$title='',$ref_id=''){
			$data = "username=".$this->username.
							 "&password=".$this->password.
							 "&apikey=".$this->api_key.
							 "&url=".$url.
							 "&title=".$title.
							 "&ref_id=".$ref_id;				
			$this->serverCall('add',$data);			
		}
		
		public  function retreiveUsersList($since="",$page="",$state="",$count="",$tags="0",$myAppOnly="0",$format='json'){
			$data = "username=".$this->username.
							 "&password=".$this->password.
							 "&apikey=".$this->api_key.
							 "&format=".$format.
							 "&state=".$state.
							 "&myAppOnly=".$myAppOnly.
							 "&since=".$since.
							 "&count=".$count.
							 "&page=".$page.
							 "&tags=".$tags;
			$this->serverCall('get',$data);			
		}
		
		
		public function sendChanges($new,$read,$updateTitle,$updateTag){
			$data = "username=".$this->username.
							 "&password=".$this->password.
							 "&apikey=".$this->api_key.
							 "&new=". json_encode($new).
							 "&read=". json_encode($read).
							 "&update_title=". json_encode($updateTitle).
							 "&update_tags=". json_encode($updateTag);
			$this->serverCall('send',$data);				 
		}
		
		
		private function serverCall($method,$data){
			try{
				$link = $this->url . $method;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $link);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch, CURLOPT_FAILONERROR, true);
				// the below check need to be there for production .to make sure we are point to correct atom server !!!
				curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);			
				curl_setopt($ch, CURLOPT_HEADER, 0);
				$response = curl_exec($ch);
				$err = curl_error($ch);
				curl_close($ch);		
				if($err){
					switch( $err){
						case  'The requested URL returned error: 400 ':
									throw new Exception(" Invalid request, please make sure you follow the documentation for proper syntax:  ");	
									break;
						case  'The requested URL returned error: 401':
									throw new Exception(" Username and/or password is incorrect:  ");	
									break;
						case  'The requested URL returned error: 403':
									throw new Exception("  Rate limit exceeded, please wait a little bit before resubmitting:  ");	
									break;
						case  'The requested URL returned error: 503':
									throw new Exception("  Read It Later's sync server is down for scheduled maintenance:  ");	
									break;
						default:
									throw new Exception($err);	
					}
				}else{
					return $response;
				}
			}catch(Exception $e){
				echo $e->getMessage();
				exit;
			}			
		}


}
?>