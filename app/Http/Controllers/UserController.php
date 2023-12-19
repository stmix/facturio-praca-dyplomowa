<?php

namespace App\Http\Controllers;
session_start();
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    public function signin() {
        if(!isset($_POST['login']) || !isset($_POST['password']) ) {
            return redirect()->route('gotologinform');
        }

        require_once "lib/mysql_connection.php";

        /*$connection = @new mysqli($host, $db_user, $db_password, $db_name);

        if($connection->connect_errno!=0)
        {
            echo "Error: ".$connection->connect_errno;
        }
        else
        {*/
            $login=$_POST['login'];
            $password=$_POST['password'];

            $login=htmlentities($login, ENT_QUOTES, "UTF-8");
            //$sql="SELECT * FROM USERS WHERE username='$login' and password='$password'";
            $res = DB::select("SELECT * FROM USERS WHERE name='$login'");
            $usercount = count($res);
            if($usercount > 0)
            {
                    $row = $res[0];
                    if(password_verify($password, $row->password)) {
                        $_SESSION['logged']=true;
                        $_SESSION['id']=$row->id;
                        $_SESSION['user'] = $row->name;

                        unset($_SESSION['signinerror']);
                        return view('page');
                        //return redirect()->route('gotomainpage');
                    } else {
                        $_SESSION['signinerror']='ERROR';
                        return redirect()->route('gotologinform');
                    }
            } else {
                $_SESSION['signinerror']="ERROR";
                return redirect()->route('gotologinform');
            }
    }

    public function signup() {
        $eok=true;
        $login=$_POST['loginr'];
        if(strlen($login)<3 || strlen($login)>20)
        {
            $eok=false;
            $_SESSION['e_login']='Login musi posiadać od 3 do 20 znaków';
        }
        if(ctype_alnum($login)==false)
        {
            $eok=false;
            $_SESSION['e_login']='Login może składać się tylko z liter i cyfr';
        }
        $email=$_POST['emailr'];
        $emailB=filter_var($email,FILTER_SANITIZE_EMAIL);

        if(filter_var($emailB,FILTER_SANITIZE_EMAIL)==false || ($emailB!=$email)) {
            $eok=false;
            $_SESSION['e_email'] = 'Podany adres e-mail jest nieprawidłowy';
        }
        
        $password1=$_POST['passwordr'];
        $password2=$_POST['password2r'];

        if(strlen($password1)<5)
        {
            $eok=false;
            $_SESSION['e_password']='Minimalna długość hasła wynosi 5 znaków';
        }

        if($password1!=$password2)
        {
            $eok=false;
            $_SESSION['e_password2']='Podane hasła nie są ze sobą zgodne';
        }

        $password_hash = password_hash($password1, PASSWORD_DEFAULT);
        // $10$fJDoNAg4kj.oAv6B1mh7UOlekeWtbNGeR/q.oY4MwdJHLuQBcMxEu

        if(!isset($_POST['rules']))
        {
            $eok=false;
            $_SESSION['e_rules']='Należy zaakceptować regulamin!';
        }

        try {
                $res = DB::select("SELECT * FROM USERS WHERE name='$login'");

                $num_logins=count($res);

                if($num_logins>0) {
                    $eok=false;
                    $_SESSION['e_login']="Wybrany login jest zajęty!";
                }

                //$res=$connection->query("SELECT id FROM users WHERE email='$email'");
                $res2 = DB::select("SELECT * FROM USERS WHERE email='$email'");

                $num_emails=count($res2);

                if($num_logins>0) {
                    $eok=false;
                    $_SESSION['e_email']="Podany email jest przypisany do innego konta.";
                }

                if($eok==true) {
                    if(DB::insert("insert into users values(NULL, '$login', '$email', NULL, '$password_hash', NULL, NULL, NULL)")) {
                        $_SESSION['reg_res']='Rejestracja przebiegła pomyślnie!';
                    }
                    else {
                        throw new Exception("Błąd");
                    }
                }
                return redirect()->route('gotologinform');
            
            if($eok==false) {
                $_SESSION['showreg']=true;
            }
        } catch(Exception $e) {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
            echo '<br/>Informacja developerska: '.$e;
        }

        //-----------
            // $login=$_POST['loginr'];
            // $email=$_POST['emailr'];
            // $password=$_POST['passwordr'];
            // $passwordd=$_POST['password2r'];

            // $sql = DB::select("SELECT * FROM USERS WHERE username='$login' or email='$email'");
                    
            // $usercount = count($sql);
            // if($usercount==0){
            //     header("Location: index.php");
            // } else {
            //     $_SESSION['signuperror']="ERROR";
            // }
            // header("Location: index.php");
    }

    public function logout() {
        session_unset();
        return redirect()->route('gotologinform');
    }
}