<?php

namespace Tashi\LoginBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\LoginBundle\Helper\LoginConstant;
use Tashi\UserBundle\Helper\UserConstant;
use Tashi\DashboardBundle\Helper\DashboardConstant;
use Symfony\Component\HttpFoundation\RedirectResponse;
class LoginController extends Controller
{
    private $msg="";
    private $uid="";
    /**
     *@Route ("/", name="_login")
     */
    public function indexAction()
    {
        $secure = $this->get('tashi.secure.service');
		/**
		* Generates a CSRF token for a page of your application.
		* @param string $intention Some value that identifies the action intention
		* (i.e. "authenticate"). 
		*/
        $intention = $secure->getIntention();
        $token = $this->get('form.csrf_provider')->generateCsrfToken($intention);       
        $salt = $secure->createSalt();
       // $session = $this->getRequest()->getSession();
       // $session->set('captcha','captcha');
        return $this->render(LoginConstant::TWIG_LOGIN, array('salt'=>$salt,'msg'=>$this->msg,'uid'=>$this->uid,'csrf_token' =>$token));
    }
    /**
     * @Route ("/dashboard", name="_dashboard")
     */
    public function dashboardAction()
    {
        $session = $this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $em=$this->getDoctrine()->getManager();
        $account=$em->getRepository(CommonConstant::ENT_USER_TABLE)->find($session->get('UPKID'));
        return $this->render(DashboardConstant::TWIG_DASHBOARD,array('account'=>$account));
    }
    /**
     * @Route ("/connect", name="_connect")
     */
    public function ConnectToAccessAction(Request $request)
    {
       // $conn = new \COM ("ADODB.Connection") or die("Cannot start ADO");
        //$count =0;
        $db_path = $request->files->get('db');
        //$constr = "Provider=Microsoft.Jet.OLEDB.4.0; DBQ=" . $db_path . "; ''; 'sss';";
        //$odbc_con = new \COM("ADODB.Connection");
        //$odbc_con -> open($constr);
        //$connection=odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$db_path", '', 'sss');
        //include __DIR__.'\\adodb5\\adodb.inc.php';
        $db = new \PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$db_path; Uid=; Pwd=sss;");
        //$dsn = "Driver={Microsoft Access Driver (*.mdb)};Dbq=$db_path;Uid='';Pwd=sss;";
        $db->beginTransaction();
        
        return $this->render('TashiLoginBundle:Login:connected.html.twig',array('msg'=>'asdfsadf'));
    }
    /**
     * @Route ("/activateaccount", name="_gotoactivate")
     */
    public function GotoActivateAccountAction()
    {
        $session = $this->getRequest()->getSession();
        $em=$this->getDoctrine()->getManager();
        $account=$em->getRepository(CommonConstant::ENT_USER_TABLE)->find($session->get('UPKID'));
        return $this->render(UserConstant::TWIG_ACTIVATE_ACCOUNT,array('account'=>$account,'pass'=>$session->get('PASS')));
    }
    /**
     * @Route ("/Auth", name="_auth")
     */
    public function authAction(Request $request)
    {
        $secure = $this->get('tashi.secure.service');
        $login = $this->get(LoginConstant::SERVICE_LOGIN);
        $session = $this->getRequest()->getSession();
        $intention = $session->get('intention');
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $token = $request->request->get('token');
        if ($this->get('form.csrf_provider')->isCsrfTokenValid($intention, $token)) {
            if ($login->authenticateUser($username, $password )) {
                //CHECK ACCOUNT ACTIVATION
                echo $session->get('ACTIVATE').'abc';
                if($session->get('ACTIVATE')==0){                    
                    return $this->redirect($this->generateUrl('_gotoactivate'));
                }
                $intention = $secure->getIntention();
                $token = $this->get('form.csrf_provider')->generateCsrfToken($intention);
                return $this->redirect($this->generateUrl('_dashboard'));
            } 
            else{
                $intention = $secure->getIntention();
                $token = $this->get('form.csrf_provider')->generateCsrfToken($intention);
                $salt = $secure->createSalt();
                $this->msg = "Invalid User Name or Password !";
                return $this->render(LoginConstant::TWIG_LOGIN, array('salt' => $salt, 'msg' => $this->msg, 'uid' => $username, 'csrf_token' => $token));
            }
        }
        else{
            $intention = $secure->getIntention();
            $token = $this->get('form.csrf_provider')->generateCsrfToken($intention);
            $salt = $secure->createSalt();
            $this->msg = "Invalid CSRF Token...!";
            return $this->render(LoginConstant::TWIG_LOGIN, array('salt' => $salt, 'msg' => $this->msg, 'uid' => $username, 'csrf_token' => $token));
        }
    }
    /**
     * @Route ("/logout", name="_logout")
     */
    public function LogoutAction(){
        $result=$this->get(LoginConstant::SERVICE_LOGIN)->Logout();
        if($result['code']==1){
            return $this->redirect($this->generateUrl("_login"));        
        }else{
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage($result['msg']);
            $serializer = $this->get(CommxonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        }
    }
    
    
}
