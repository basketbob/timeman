<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];

            if($model->validate())
            {
                $name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['supportEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact',Yii::t('contact_view','success'));
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

    public function actionSignup()
	{
        $model=new User;
        $model->scenario = 'registration';

		// collect user input data
		if(isset($_POST['User']))
		{
			$usr = $_POST['User'];
            $attr = array(
                'name_user'    => strstr($usr['email'], '@', true),
                'regdate'      => date('Y-m-d H:i:s'),
                'end_pay_day'  => date('Y-m-d H:i:s',mktime(23,59, 59, date("m")+1, date("d"),   date("Y"))),
                'spam'         => $usr['spam'],
                'confirm_code' => substr(md5(uniqid(rand(), true)), 16, 16),
            );
            $model->setAttributes($attr, false);
            $model->attributes=$usr;

            if($model->save()){
                Yii::app()->user->setFlash('registration', Yii::t('signup_view','success'));

                $email  = $usr['email'];
                $subj   = Yii::t('signup_view','mail_subject');
                $body   = '
                    <body style="margin: 0;">
                    <table style="width: 100%;background: #f2f2f2;font-family: Helvetica,Arial,sans-serif; color: #606060;">
                        <tr>
                            <td style="width: 10%;"></td>
                            <td style="width: 80%;text-align: center;">
                                <img src="http://timeman.org/images/logo_grey_75.png" alt="TIMEMAN" style="margin: 20px 0;" />
                                <table style="background-color: #fff; width: 100%; height: 200px;margin-bottom: 15px;border-radius: 6px;">
                                    <tr>
                                        <td><h1 style="font-size: 40px;font-weight: bold;letter-spacing: -1px;line-height: 115%;margin: 15px 0;">
                                                '. Yii::t('signup_view','mail_header') .'
                                            </h1></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0 20px;">
                                            <p style="margin: 0; padding: 0;font-size: 15px;line-height: 150%;">
                                                '. Yii::t('signup_view','mail_descr') .'
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 0;">
                                            <a href="'. Yii::app()->request->getBaseUrl(true) .'/site/confirm?code='. $attr['confirm_code'] .'" style="padding: 10px 16px;font-size: 18px;line-height: 1.33;border-radius: 6px;color: #fff;background-color: #5cb85c;text-decoration: none;display: inline-block;margin: 25px 0;">
                                                '. Yii::t('signup_view','mail_activate') .'
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                <p style="padding: 0;margin: 20px 0;">'. Yii::t('signup_view','mail_footer') .'</p>
                            </td>
                            <td style="width: 10%;"></td>
                        </tr>
                    </table></body>';
                $header = 'Content-type: text/html; charset=utf8' . "\r\n" .
                          'From: Timeman <noreply@timeman.org>' . "\r\n" .
                          'Reply-To: support@timeman.org' . "\r\n" .
                          'X-Mailer: PHP/' . phpversion();
                mail($email, $subj, $body, $header);

                Yii::app()->db->createCommand()->insert('user_project_group', array(
                    'id_user'    => $model->id,
                    'id_project' => 1,
                    'admin'      => 0,
                    'cost'       => 0,
                ));
            }
        }

		// display the login form
		$this->render('signup_view',array('model'=>$model));
	}

    public function actionConfirm()
    {
        $code = Yii::app()->request->getParam('code');

        if(!isset($code) || $code == ''){
            header('Location: /');
        }

        $code = substr(mysql_real_escape_string($code), 0, 16);

        $result = Yii::app()->db->createCommand()->update('user',
            array(
                'confirm' => '1',
                'active'  => '1'
            ),
            'confirm_code=:code',
            array(
                ':code' => $code,
            )
        );

        $this->render('confirm_view');
    }

    public function actionDeleteUser()
    {
        $id = Yii::app()->request->getParam('id');
        $code = Yii::app()->request->getParam('code');
        if(!$id || !$code){
            header('Location: /');
        }

        $id = (int) $id;
        $code = substr(mysql_real_escape_string($code), 0, 16);

        $result = Yii::app()->db->createCommand()->delete(
            'user',
            'id=:id AND confirm_code=:code',
            array(
                ':id' => $id,
                ':code' => $code
            )
        );

        if($result){
            $result = Yii::app()->db->createCommand()->delete(
                'user_project_group', 'id_user=:id', array(':id' => $id)
            );
        }


        $this->render('delete_user_view');
    }

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				$this->redirect('/timer');
            }
		}
		// display the login form
		$this->render('login_view',array('model'=>$model));
	}

    public function actionPricing()
    {
        $this->render('pricing_view');
    }

    public function actionCurrency()
    {
        $response = file_get_contents("https://www.google.com/finance/converter?a=1&from=USD&to=RUB");
        $response = explode("<span class=bld>",$response);
        $response = explode("</span>",$response[1]);

        print_r(floor(preg_replace("/[^0-9\.]/", null, $response[0])));
    }

    public function actionPrivacy()
    {

        $this->render('privacy_view');
    }

    public function actionTerms()
    {

        $this->render('terms_view');
    }

    public function actionAbout()
    {

        $this->render('about_view');
    }

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}