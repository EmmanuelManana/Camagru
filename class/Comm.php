<?php

class Comm{
	public function sendComment($db, $up_id, $us_id, $login, $comm){
		$req = $db->query("INSERT INTO `comm` SET `up_id` = ?, `us_id` = ?, `comm_date` = NOW(), `login_us` = ?, `comm_val` = ?", [
			$up_id,
			$us_id,
			$login,
			$comm,
			]);
		if ($req == true){
			return true;
		}
	}

	public function getComment($db, $up_id){
		return $db->query("SELECT * FROM `comm` WHERE `up_id`= ? ORDER BY `comm_date` DESC", [$up_id])->fetchall();
	}

	public function sendMailcomm($db, $up_id, $com, $name){
//		$user = $db->query("SELECT `up_usid` FROM `img` WHERE `up_id` = ?", [$up_id])->fetch();
//		$email = $db->query("SELECT `email` FROM `user` WHERE `id` = ?", [(int)$user->up_usid])->fetch();
//		$pref =  $db->query("SELECT `mail_com` FROM `user` WHERE `id` = ?", [(int)$user->up_usid])->fetch();

		$imageAuthor = $db->query("SELECT img.up_id, user.email, user.mail_com FROM img INNER JOIN user ON img.up_usid = user.id")->fetch();

        if ((int)$imageAuthor->mail_com == 1){
            $to = $imageAuthor->email;
            $subject = 'Comment';
            $message = " Hello !\n\n$name commented on one of your Camagru photos! \n\n\"$com\"";
            $headers = 'From: emanana@student.wethinkcode.co.za' . "\r\n" .
                'Reply-To: emanana@student.wethinkcode.co.za' . "\r\n" .
                'G_MAIL: PHP/' . phpversion();
            mail($to, $subject, $message, $headers);
        }
	}
}

?>