<?php

class CapchaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
          $this->codeSession = new Zend_Session_Namespace('code'); //在默认构造函数里实例化
     
	      $captcha = new Zend_Captcha_Image(array('font'=>APPLICATION_PATH.'/../public/fonts/ShadowsAroundUs.ttf', //字体文件路径
	               'fontsize'=>24, //字号
	               'imgdir'=>'./images/', //验证码图片存放位置
	               'session'=>$this->codeSession, //验证码session值
	               'width'=>100, //图片宽
	               'height'=>50,   //图片高
	               'wordlen'=>5 ,'LineNoiseLevel'=>0,'DotNoiseLevel'=>20)); //字母数
	      $captcha->setExpiration(1);
	      $captcha->setGcFreq(3); //设置删除生成的旧的验证码图片的随机几率
	      $captcha->generate(); //生成图片
	      $this->view->ImgDir = $captcha->getImgDir();
	      $this->view->captchaId = $captcha->getId(); //获取文件名，md5编码
	      $this->codeSession->code=$captcha->getWord(); //获取当前生成的验证字符串
	     
	      $this->view->code = $this->codeSession->code;
    	
    }


}

