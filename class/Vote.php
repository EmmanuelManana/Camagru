<?php

class Vote {
	private function likeCheck($db, $us_id, $up_id){
		$req = $db->query("SELECT * FROM `likes` WHERE `up_id`=? AND `us_id` = ?", [$up_id,$us_id,])->fetch();
		return $req;
	}

	private function addLike($db, $up_id, $us_id, $val)
	{
        echo "User ID: " . $us_id . " Val: " . $val . "up_id: " . $up_id;
        $db->query("INSERT INTO `likes` SET `tab` = 'img', `up_id` = ?, `us_id` = ?, `like_val` = ?", [$up_id, $us_id, $val,]);
		if ($val > 0)
		{
		    $db->query("UPDATE `img` SET `up_likes` = `up_likes` + ? WHERE `up_id` = ?", [$val, $up_id, ]);
            $imageAuthor = $db->query("SELECT img.up_id, user.login, user.email, user.mail_com FROM img INNER JOIN user ON img.up_usid = user.id")->fetch();
            if ((int)$imageAuthor->mail_com == 1){
                $liker = $_SESSION['auth']->login;
                $to = $imageAuthor->email;
                $subject = 'Like';
                $message = " Hello !\n\n$liker liked one of your Camagru photos! \n\n\"\"";
                $headers = 'From: emanana@student.wethinkcode.co.za' . "\r\n" .
                    'Reply-To: emanana@student.wethinkcode.co.za' . "\r\n" .
                    'G_MAIL: PHP/' . phpversion();
                mail($to, $subject, $message, $headers);
            }
		}
		else
		{
			$db->query("UPDATE `img` SET `up_dislikes` = `up_dislikes` - ? WHERE `up_id` = ?", [$val, $up_id, ]);				
		}
	}

	private function updateLike($db, $up_id, $us_id, $val){
			$db->query("UPDATE `img` SET `up_likes` = `up_likes` + ?, `up_dislikes` = `up_dislikes` - ? WHERE `up_id` = ?", [
				$val,
				$val,
				$up_id,
				]);
			}

	private function cancelLike($db, $up_id, $us_id, $val){
		$db->query("UPDATE `likes` SET `like_val` = ?", [
			$val,
		]);
	}
		
	public function like($db, $tab, $up_id, $us_id, $val){
		$req = $db->query("SELECT * FROM $tab WHERE `up_id` = ?", [
			$up_id,
			]);
		if ($req->rowCount() > 0){
            $like_check = self::likeCheck($db, $us_id, $up_id);
			if ($like_check == false){
                self::addLike($db, $up_id, $us_id, $val);
				return true;
			}else if ($like_check->like_val != $val){
				self::cancelLike($db, $up_id, $us_id, $val);
				self::updateLike($db, $up_id, $us_id, $val);
				}
		}else {
			throw new Exception('Can not vote for a record that does not exist');
		}
	}

}