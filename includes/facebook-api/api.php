<?php 
class NJT_CUSTOMER_CHAT_API
{
  private $APP_ID;
  private  $sercet;
  private $ver = 'v2.11';
  function __construct()
  {
    $this->APP_ID='983715691729450';//get_option('njt_customer_chat_app_id');
    $this->sercet='320a2c9ab05dd575883e6acfbdf0cdd8';//get_option('njt_customer_chat_app_serect');
  }
    // Connect Facebook
  public function connet(){
    try{
      $fb = new Facebook\Facebook([
        'app_id' => $this->APP_ID,
        'app_secret' => $this->sercet,
        'default_graph_version' => $this->ver,
        ]);
    }catch(Facebook\Exceptions\FacebookResponseException $e) {
      return $e;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      return $e;
    }
    return $fb ;
  }
    // CHECK TOKEN
  public function checkToken($token){
    $fb = $this->connet();
    try{
      $extoken = $fb->getOAuth2Client();
      $ex_token = $extoken->debugToken($token);
      return $ex_token;
    }catch(Facebook\Exceptions\FacebookResponseException $e){
      return $e->getMessage();
    }
    catch (Facebook\Exceptions\FacebookSDKException $e) {
      return $e->getMessage();
    }
  }
    // Get link Login FB
  public function GetLinkLogin($link_callback,$permissions=''){
    if(empty($link_callback)){
      return array('status'=>false,'msg'=>'Link Callback not found!');
    }
    $fb = $this->connet();
    $helper = $fb->getRedirectLoginHelper();
    if(empty($permissions)){
      $permissions = ['email'];
    }
    $loginUrl = $helper->getLoginUrl($link_callback, $permissions);
    return $loginUrl;
  }
    // Information admin page
  public function Me($token){
    $fb = $this->connet();
    try {
          // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=id,name,accounts,picture{url}',$token);
    } 
    catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    $user = $response->getGraphUser();
    return $user;
  }
    // Get Value Token
  public function get_Token(){
    $fb = $this->connet();
    $helper = $fb->getRedirectLoginHelper();
    try {
     $accessToken = $helper->getAccessToken();
     return $accessToken;
   } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
    return $e;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    return $e;
  }
}
    // Get Time Live Token (can : 2 Month , 3 month or forever)
public function extoken($token){
  $fb = $this->connet();
  try{
    $extoken = $fb->getOAuth2Client();
    $ex_token = $extoken->getLongLivedAccessToken($token);
    return $ex_token->getValue();
  }catch(Facebook\Exceptions\FacebookResponseException $e){
    //return $e->getMessage();
    return "error";
  }
  catch (Facebook\Exceptions\FacebookSDKException $e) {
    //return $e->getMessage();
    return "error";
  }
}
       //Check live time token (result return 1: live , 0 : die)
public function check_token_live($token){
  $fb = $this->connet();
  try{
    $extoken = $fb->getOAuth2Client();
    $ex_token = $extoken->debugToken($token);
    return $ex_token->getIsValid();
  }catch(Facebook\Exceptions\FacebookResponseException $e){
    return $e->getMessage();
  }
  catch (Facebook\Exceptions\FacebookSDKException $e) {
    return $e->getMessage();
  }
}
// Get Page
public function Get_List_Page($token){
  $fb = $this->connet();
  try {
              $response = $fb->get('/me?fields=accounts.limit(9999){picture{url},name,id,access_token}',$token);   // only get picture, name, id , access_token
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              return $e;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              return $e;
            }
            $user = $response->getGraphObject()->asArray();
            return $user;
  }
// GET ID PAGE WITH NAME
public function Get_ID_Page($token,$name){
  $fb = $this->connet();
    try {
          // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get("/$name?fields=id",$token);
    } 
    catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    $object = $response->getGraphObject();
    return $object['id'];  
}
public function Get_Access_Token_Page($token,$id_page){
        $fb = $this->connet();
        try {
          $response = $fb->get("/$id_page?fields=access_token",$token); 
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          return $e;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          return $e;
        }
        $access_token = $response->getGraphObject()->asArray();
        return $access_token;
}
// SET DOMAIN
public function Set_Domain_APP($id_page,$domain,$page_access_token){
          $fb=$this->connet();
          $Data = [
          'setting_type' => 'domain_whitelisting',
          'whitelisted_domains' => $domain,
          'domain_action_type' => 'add'
          ];
          try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $fb->post("/$id_page/thread_settings", $Data, $page_access_token);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return $e->getMessage();
          }
          $graphNode = $response->getGraphNode();
          return $graphNode;//$graphNode['result'];
}
// Have Domain ??
public function List_Domain_APP($id_page,$page_access_token){
            $fb = $this->connet();
            try{
              //$page=$this->Me($token)['accounts'];
              $response = $fb->get("/$id_page/thread_settings?fields=whitelisted_domains",$page_access_token);
            }catch(Facebook\Exceptions\FacebookResponseException $e){
              return $e->getMessage();
            }
            catch (Facebook\Exceptions\FacebookSDKException $e) {
              return $e->getMessage();
            }
            $list_domain = $response->getGraphList()->asArray();
            return $list_domain;
}
// SUBSCRIBER WEBHOOK
// Register Page for Webhook
public function NJT_Page_SubScriber_Webhook_APP($page_access_token,$id_page){
      $fb = $this->connet();
      $data=array();
      try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $fb->post("/$id_page/subscribed_apps",array(),$page_access_token);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return $e->getMessage();
          }
      $graphNode = $response->getGraphNode();
      return $graphNode;
}
// Show List of Registered Page In WebHook
public function NJT_Check_Page_SubScriber_APP($id_page,$page_access_token){
      $fb = $this->connet();
      try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $fb->get("/$id_page/subscribed_apps", $page_access_token);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return $e->getMessage();
          }
        $list_page_sub = $response->getGraphList()->asArray();
        return $list_page_sub;
}
// SEND MESSENGER WITH TEXT
public function NJT_Send_message_text_user_ref($page_id,$page_token,$content_message,$user_ref){
      $fb = $this->connet();
      $Data = [
          "recipient" => array("user_ref"=>$user_ref),
          "message"   => array("text"=> $content_message) 
          ];
      try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $fb->post("/$page_id/messages", $Data, $page_token);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return $e->getMessage();
          }
          $graphNode = $response->getGraphNode();
          return $graphNode["recipient_id"];//$graphNode['result'];
}
// SEND MESSENGER WITH LIST TEMPLATE
public function NJT_Send_message_list_template_user_ref($page_id,$page_token,$user_ref,$array_product,$url_button_generic,$title_button_generic){
  $fb = $this->connet();
    $Data = [
            "recipient" => array("user_ref"=>$user_ref),
            "message"   => array(
                    "attachment"=> array(
                        "type"=> "template",
                        "payload" => array(
                          "template_type" => "list",
                          "top_element_style" => "large",
                          "elements" => $array_product,
                          "buttons" => array(
                            array(
                              "type" => "web_url",
                              "url" => $url_button_generic,
                              "title" => $title_button_generic
                            )
                          )
                        )
                    )
            ) 
    ];
  try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $fb->post("/$page_id/messages", $Data, $page_token);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return $e->getMessage();
          }
  $graphNode = $response->getGraphNode();
  return $graphNode;//$graphNode['result'];
}
// SEND MESSENGER WITH ONE PRODUCT
public function NJT_Send_message_one_product_user_ref($page_id,$page_token,$user_ref,$array_product){
  $fb = $this->connet();
    $Data = [
            "recipient" => array("user_ref"=>$user_ref),
            "message"   => array(
                    "attachment"=> array(
                        "type"=> "template",
                        "payload" => array(
                          "template_type" => "generic",
                          "elements" => $array_product,
                        )
                    )
            ) 
    ];
  try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $fb->post("/$page_id/messages", $Data, $page_token);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return $e->getMessage();
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return $e->getMessage();
          }
  $graphNode = $response->getGraphNode();
  return $graphNode;//$graphNode['result'];
}
// GET INFO USER
public function NJT_Get_Info_User_With_Recepit_ID($page_token,$recipient_id){
  $fb = $this->connet();
  try {
              $response = $fb->get("/$recipient_id?fields=first_name,last_name,profile_pic,locale,gender",$page_token);
      } catch(Facebook\Exceptions\FacebookResponseException $e) {
              return $e->getMessage();
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
              return $e->getMessage();
      }
      $user = $response->getGraphObject()->asArray();
      return $user;
}
// SEND MESSENGER WITH USER ADD TO CART
public function NJT_Send_message_user_add_cart($page_id,$page_token,$content_message,$recipient_id){
      $fb = $this->connet();
      $Data = [
          "recipient" => array("id"=>$recipient_id),
          "message"   => array("text"=> $content_message) 
          ];
      try {
          // Returns a `Facebook\FacebookResponse` object
          $response = $fb->post("/$page_id/messages", $Data, $page_token);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
            //return $response->getGraphNode();
            return $e->getMessage();
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
          //return $response->getGraphNode();
            return  $e->getMessage();
          }
          $graphNode = $response->getGraphNode();
          return $graphNode["recipient_id"];//$graphNode['result'];
}
}
?>