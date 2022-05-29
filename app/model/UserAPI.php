<?php


/**
 * @throws AuthError
 */

namespace app\app\model;
include_once '../core/Application.php' ;
use app\core\Application;
use app\core\Session;

class UserAPI
{
    private Session $session;

    public function __construct()
    {
        $this->session = Application::$app->getSession ();
    }
    private function UserExist($email)
    {
        $sql="SELECT * FROM users WHERE email=:email" ;
        $db = Application::$app->db;
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();
        if($user && in_array($email,$user))
        {
            return $user;
        }
        else
        {
            return false;
        }
    }

    public function CreateUser($email, $password)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $disabled=0;
        $active=1;
        $authenticated=0;
        $newId='uid'.rand(1,99999);
        $db = Application::$app->db;
        $GetID = $db->prepare("SELECT id FROM users");
        $GetID->execute();
        $id = $GetID->fetchAll();
        if(in_array($newId,$id)){
            $newId='uid'.rand(1,99999);
        }
        $StmtUserExist=$db->prepare("SELECT email FROM users WHERE email=:email");
        $StmtUserExist->bindParam(':email',$email);
        $StmtUserExist->execute();
        $UserExist=$StmtUserExist->fetch();
        if($UserExist && in_array($email,$UserExist))
        {
            return ['error'=>'User already exist'];
        }
        else {
            $sql = "INSERT INTO users (id,email,password,authenticated,disabled,active) VALUES (:id,:email,:password,:authenticated,:disabled,:active)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $newId);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':authenticated', $authenticated);
            $stmt->bindParam(':disabled', $disabled);
            $stmt->bindParam(':active', $active);
            $result = $stmt->execute();
            if ($result) {
                return [
                    'CurrentUser'=>[
                        'uid' => $newId,
                        'disabled' => $disabled ? 'true' : 'false',
                        'active' => $active ? 'true' : 'false',
                        'authenticated'=>$authenticated ? 'true' : 'false'
                        ],
                ];
            } else {
                return ['CurrentUser'=>[],'error'=>'Error while creating user'];
            }
        }
    }

    public function GetCurrentUser()
    {
        if($this->session->get('CurrentUser'))
        {
            return ['CurrentUser'=>$this->session->get('CurrentUser')];
        }
        else
        {
            return ['CurrentUser'=>[]];
        }
    }

    public function SignUserEP($email,$password)
    {
        if(!$this->session->get ('CurrentUser')) {
            $sql = "SELECT * FROM users WHERE email=:email";
            $db = Application::$app->db;
            $stmt = $db -> prepare ( $sql );
            $stmt -> bindParam ( ':email' , $email );
            $stmt -> execute ();
            $user = $stmt -> fetch ();
            if ($user && in_array ( $email , $user )) {
                if (password_verify ( $password , $user[ 'password' ] )) {
                    $active = 1;
                    $StmtUpdateUser = $db -> prepare ( "UPDATE users SET active=:active WHERE email=:email" );
                    $StmtUpdateUser -> bindParam ( ':email' , $email );
                    $StmtUpdateUser -> bindParam ( ':active' , $active );
                    $StmtUpdateUser -> execute ();
                    $this -> session -> set ( 'CurrentUser' , [
                        'uid' => $user[ 'id' ],
                        'disabled' => $user[ 'disabled' ] ? 'true' : 'false',
                        'active' => $user[ 'active' ] ? 'true' : 'false',
                        'authenticated' => $user[ 'authenticated' ] ? 'true' : 'false'
                    ] );
                    return [
                        'CurrentUser' => [
                            'uid' => $user[ 'id' ] ,
                            'authenticated' => $user[ 'authenticated' ] ? 'true' : 'false'
                        ] ,
                    ];
                } else {
                    throw new AuthError( 'Wrong password' );
                }
            } else {
                throw new AuthError( 'User not found' );
            }
        }
        else{
            throw new AuthError( 'User already Signed!' );
        }
    }

    public function SignOut()
    {
        if($this->session->get('CurrentUser')) {
            $this->session->remove('CurrentUser');
            $sql="UPDATE users SET active=0 WHERE id=:id";
            $db = Application::$app->db;
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $this->session->get('CurrentUser')['uid']);
            $stmt->execute();
            return ['CurrentUser'=>[]];
        }
        else{
            throw new AuthError( 'User not Signed!' );
        }
    }

    public function ChangePassword($email , $curPassword, $newPassword): array
    {
        $db=Application::$app->db;
        if($curPassword==$newPassword)
        {
            throw new AuthError('New password must be different from current password');
        }
        $user=$this->UserExist($email);
        if($user)
        {
            if( $user['disabled']==1)
            {
                throw new AuthError('User is disabled');
            }
            if(password_verify ($curPassword,$user['password']))
            {
                if(strlen($newPassword)<6)
                {
                    throw new AuthError('Password must be at least 6 characters');
                }
                if(!preg_match('/[A-Z]/',$newPassword))
                {
                    throw new AuthError('Password must contain at least one uppercase letter');
                }
                if(!preg_match('/[a-z]/',$newPassword))
                {
                    throw new AuthError('Password must contain at least one lowercase letter');
                }
                if(!preg_match('/[0-9]/',$newPassword))
                {
                    throw new AuthError('Password must contain at least one number');
                }

                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $StmtUpdateUser=$db->prepare("UPDATE users SET password=:password WHERE email=:email");
                $StmtUpdateUser->bindParam(':email',$email);
                $StmtUpdateUser->bindParam(':password',$hashed_password);
                $StmtUpdateUser->execute();
                if($StmtUpdateUser)
                {
                    return [
                        'CurrentUser'=>[
                            'uid' => $user['id'],
                            'authenticated'=>$user['authenticated'] ? 'true' : 'false'
                        ],
                    ];
                }
                else
                {
                    throw new AuthError('Error updating password');
                }
            }
            else
            {
                throw new AuthError('Wrong password');
            }
        }
        else
        {
            throw new AuthError('User not found');
        }

    }



}