<?php

class Auth
{
    private $options = ['restrictin_msg' => "you aren not allowed to access this page"];

    private $session;

    public function __construct($session, $options = [])
    {
        /* brush up on array_merge  */
        $this->options = array_merge($this->options, $options);
        $this->session = $session;
    }

    public function hashPassword($passwd)
    {
        /* choosing b-crypt as the safest encryption method*/
        return password_hash($passwd, PASSWORD_BCRYPT);
    }
    /* Insert new user data into the data base*/
    public function register($db, $name, $forename, $login, $email, $passwd)
    {
        $password = $this->hashPassword($passwd);// encryped passwd before adding  to the database 
        $token = Str::random(52);

        $db->query("INSERT INTO user SET `name` = ?, forename = ?, `login` = ?, email = ?, passwd = ?, `check` = ?, mail_com = ?, `token`=? ",[
                    $name, $forename, $login, $email, $password, 0, 1, $token]);
        $user_id = $db->lastInsertId();

        $to      = $email;
        $subject = 'Confirmation of your Camagru Account';

        $message = "Hello! \n\n To validate your account, please click on the following link \n\n http://localhost:8080/camagru/confirm.php?id=$user_id&token=$token";
		$headers = 'From: emanana@student.wethinkcode.co.za' . "\r\n" .
		'Reply-To: emanana@student.wethinkcode.co.za' . "\r\n" .
		'G-Mail: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
        
    }

    public function modify($db, $login = '', $email = '',$passwd ='', $mail_com ='', $user_id) 
    {
        if ($login != null)
        {
            $db->query('UPDATE user SET `login` = ? WHERE id = ?', [$login, $user_id]);
        }
        if ($email != null)
        {
            $db->query('UPDATE user SET `email` = ? WHERE id = ?', [$email, $user_id]);
        }
        if ($passwd != null)
        {
            $password = password_hash($passwd);
            $db->query('UPDATE user SET `passwd`= ? WHERE id = ?', [$password, $user_id]);
        }
        if ($mail_com == null)
        {
            $db->query('UPDATE user SET `mail_com` = ? WHERE id = ?',[0, $user_id]);
        }
        else if ($mail_com == 1)
        {
            $db->query('UPDATE user SET `mail_com` = ? WHERE id = ?', [$mail_com, $user_id]);
        }
        $user = $db->query('SELECT * FROM user WHERE id = ?', [$user_id])->fetch();
        $this->session->write('auth',$user);
    }

    public function confirm($db, $user_id, $token)
    {
        $user = $db->query('SELECT * FROM user WHERE id = ?', [$user_id])->fetch();

        if ($user && $user->token == $token)
        {
            /* if user exist check is set to 1 and token is reset(set to null)*/
            $db->query('UPDATE user SET `token` = null, `check` = 1 WHERE id = ?', [$user_id]);
            $this->session->write('auth', $user);/* assign the authenticatin('auth')session the value $user*/
            return true;
        }
        else
        {
            return (false);
        }
    }

    /*if (user session was not created by the confirm function above), then (restrict user)*/
    /* then redirect user to login page*/
    public function restrict()
    {
        if (!$this->session->read('auth'))
        {
            $this->session->setFlash('Danger', $this->options['restriction_msg']);
            header('Location: login.php');/* must create a login page*/
            exit();
        }
    }

    public function user()
    {
        if (!$this->session->read('auth'))
        {
            return false;
        }
        return $this->session->read('auth');
    }

    public function connect($user)
    {
        $this->session->write('auth', $user);
    }

    public function connectFromCookie($db)
    {
        if (isset($_COOKIE['remember']) && !$this->user())
        {
            $remember_token = $_COOKIE['remember'];
            $parts = explode('==', $remember_token);
            $user_id = $parts[0];
            $user = $db->query('SELECT * FROM user WHERE id = ?', [$user_id])->fetch();

            if ($user)/* if the user exist or is valid*/
            {
                $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'securite_supp');
                if ($expected == $remember_token)
                {
                    /*set a session vaiable*/
                    $this->connect($user);
                    setcookie('remember', $remember_token, time() + 24 * 60 * 60 );
                }
                else
                {
                    /* delete the expired-cookie*/
                    setcookie('remember', null, -1);
                }
            }
            else
            {
                setcookie("remember", null, -1);
            }
        }
    }


    public function login($db, $login, $passwd, $remember = false)
    {
        $user = $db->query('SELECT * FROM user WHERE (`login` = :login OR `email` = :login) AND `check` = 1', ['login' => $login])->fetch();
        if ($user && password_verify($passwd, $user->passwd))/* selecting the hashed password from the database*/
        {
            $this->connect($user);
            if ($remember)
            {
                $this->remember($db, $user->id);
            }
            else if ($user == null || $login == null)
            {
                return false;
            }
        }
    }

    public function remember($db, $user_id)
    {
        $remember_token = Str::random(250);
        $db->query('UPDATE user SET remember_token = ? WHERE id = ?', [$remember_token, $user_id]);
        setcookie('remember', $user_id . '==' . $remember_token . sha1($user_id . 'anythingrandom'), time() + 60 * 60 * 24 * 7);
    }

    public function logout()
    {
        $this->cleanTmp();
        setcookie('remember', NULL, -1);/* delete cookie*/
        $this->session->delete('auth');/* unset sessin*/
    }

    public function resetPassword($db, $email)
    {
        /* fetch the row with this email*/
        $user = $db->query('SELECT * FROM user WHERE `email` = ? AND `check` = 1', [$email])->fetch();
        if ($user)
        {
            $reset_token = Str::random(42 + 18);
            $db->query('UPDATE user SET reset_token = ?, reset_at = NOW() WHERE id = ?', [$reset_token, $user->id]);

            /* send the reset mail*/
            $to      = $email;
            $subject = 'Reset your Camaguru password';
            $message = "Hello! \n \n To reset your password, please click on the following link \n \n
            http://127.0.0.1:80/Camagru/reset.php?id={$user->id}&token=$reset_token";
            $headers = 'From: emanana@student.wethink.co.za' . "\r\n" .
            'Reply-To: emanana@student.wethinkcode.co.za' . "\r\n" .
            'G-Mail: PHP/' . phpversion();
            mail($to, $subject, $message, $headers);
            return $user;
        }
        else
        {
            return false;
        }
    }


    public function checkResetToken()
    {
        return $db->query('SELECT * FROM user WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)', [$user_id, $token])->fetch();
    }

    public function cleanTmp()
    {
        $tmp = "db/tmp";
            if (is_dir($tmp))
             {
                $files = scandir($tmp);
                foreach ($files as $file) 
                {
                    if ($file != "." && $file != "..") 
                    {
                        if (strstr($file, "-".strval($_SESSION['auth']->id)) !== false)
                        {
                            unlink($tmp."/".$file);
                        }
                    }
                }
            }
            reset($files);
    }

}
