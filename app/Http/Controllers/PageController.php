<?php

namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
        return view('page');
    }

    // public function formvalidation() {
    //     if(isset($_SESSION['signinerror'])) {
    //         return view('loginform');
    //     }
    //     if(isset($_SESSION['logged']) && $_SESSION['logged']==true) {
    //         return view('page');
    //         //return redirect()->route('gotomainpage');
    //     }
    //     if(isset($_POST['loginr'])) {
    //         $eok=true;
    //         $login=$_POST['loginr'];
    //         if(strlen($login)<3 || strlen($login)>20)
    //         {
    //             $eok=false;
    //             $_SESSION['e_login']='Login musi posiadać od 3 do 20 znaków';
    //         }
    //         if(ctype_alnum($login)==false)
    //         {
    //             $eok=false;
    //             $_SESSION['e_login']='Login może składać się tylko z liter i cyfr';
    //         }
    //         $email=$_POST['emailr'];
    //         $emailB=filter_var($email,FILTER_SANITIZE_EMAIL);

    //         if(filter_var($emailB,FILTER_SANITIZE_EMAIL)==false || ($emailB!=$email)) {
    //             $eok=false;
    //             $_SESSION['e_email'] = 'Podany adres e-mail jest nieprawidłowy';
    //         }
            
    //         $password1=$_POST['passwordr'];
    //         $password2=$_POST['password2r'];

    //         if(strlen($password1)<5)
    //         {
    //             $eok=false;
    //             $_SESSION['e_password']='Minimalna długość hasła wynosi 5 znaków';
    //         }

    //         if($password1!=$password2)
    //         {
    //             $eok=false;
    //             $_SESSION['e_password2']='Podane hasła nie są ze sobą zgodne';
    //         }

    //         $password_hash = password_hash($password1, PASSWORD_DEFAULT);
    //         // $10$fJDoNAg4kj.oAv6B1mh7UOlekeWtbNGeR/q.oY4MwdJHLuQBcMxEu

    //         if(!isset($_POST['rules']))
    //         {
    //             $eok=false;
    //             $_SESSION['e_rules']='Należy zaakceptować regulamin!';
    //         }

    //         require_once 'mysql_connection.php';
    //         mysqli_report(MYSQLI_REPORT_STRICT);

    //         try {
    //             $connection = new mysqli($host, $db_user, $db_password, $db_name);
    //             if($connection->connect_errno!=0) {
    //                 throw new Exception(mysqli_connect_errno());
    //             } else {
    //                 $res=$connection->query("SELECT id FROM users WHERE username='$login'");
                    
    //                 if(!$res) throw new Exception($connection->error);

    //                 $num_logins=$res->num_rows;

    //                 if($num_logins>0) {
    //                     $eok=false;
    //                     $_SESSION['e_login']="Wybrany login jest zajęty!";
    //                 }

    //                 $res=$connection->query("SELECT id FROM users WHERE email='$email'");
                    
    //                 if(!$res) throw new Exception($connection->error);
                    
    //                 $num_emails=$res2->num_rows;

    //                 if($num_logins>0) {
    //                     $eok=false;
    //                     $_SESSION['e_email']="Podany email jest przypisany do innego konta.";
    //                 }

    //                 if($eok==true) {
    //                     if($connection->query("insert into users values(null, '$login','$email',null,'$password_hash',null,null,null)")) {
    //                         $_SESSION['Registration succeeded'];
    //                         header("Location: welcome.php");
    //                     }
    //                     else {
    //                         throw new Exception($connection->error);
    //                     }
                    
    //                 }
    //                 $connection->close();
    //             }
    //             if($eok==false) {
    //                 $_SESSION['showreg']=true;
    //             }
    //         } catch(Exception $e) {
    //             echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
    //             echo '<br/>Informacja developerska: '.$e;
    //         }
    //     }
    //     return view('loginform');
    // }

    public function history() {
        return view('invoices');
    }
}
