<?php

	//file for basic functions
	
	//encodes string for html
	 function html_encode($string){
		return htmlspecialchars($string);
	}
	
	//encodes URLs
	 function url_encode($string){
		return rawurlencode($string);
	}
	
	//accepts a URL and redirect user to it
	//requires output buffer to be ON
	//or call it in the first line of file before any html code
	function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}
	
	//prepares queries before sending it to database
	function mysql_prep( $value ) {
		global $connection;
		return mysqli_real_escape_string($connection, $value );
	}

	//check if the query went well
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed");
		}
	}
		
		//fetching posts from database
		function posts(){
			global $connection;
			$query = $connection->prepare("SELECT * FROM `post`,`user` WHERE user_id = user_id ORDER BY `post_id` DESC");
			$query->execute();
			return $query->fetchAll();
		}
		//add new post if user post 
		function add_post($user_id,$post,$file_path){
			global $connection; 
			if(empty($file_path)){
				$file_path = 'NULL';
			}
			$query = $connection->prepare('INSERT INTO `post` (`post_id`, `user_id`, `post`, `time`, `post_image`) VALUES (NULL, ?, ?,  CURRENT_TIMESTAMP, ?)');
			$query->bindValue(1,$user_id);
			$query->bindValue(2,$post);
			$query->bindValue(3,$file_path);
			$query->execute();
		}
		//timeAgo Function
		function timeAgo($time_ago){

			$time_ago = strtotime($time_ago);
			$cur_time   = time();
			$time_elapsed   = $cur_time - $time_ago;
			$seconds    = $time_elapsed ;
			$minutes    = round($time_elapsed / 60 );
			$hours      = round($time_elapsed / 3600);
			$days       = round($time_elapsed / 86400 );
			$weeks      = round($time_elapsed / 604800);
			$months     = round($time_elapsed / 2600640 );
			$years      = round($time_elapsed / 31207680 );
			// Seconds
			if($seconds <= 60){
			    return "just now";
			}
			//Minutes
			else if($minutes <=60){
			    if($minutes==1){
			        return "one minute ago";
			    }
			    else{
			        return "$minutes minutes ago";
			    }
			}
			//Hours
			else if($hours <=24){
			    if($hours==1){
			        return "an hour ago";
			    }else{
			        return "$hours hrs ago";
			    }
			}
			//Days
			else if($days <= 7){
			    if($days==1){
			        return "yesterday";
			    }else{
			        return "$days days ago";
			    }
			}
			//Weeks
			else if($weeks <= 4.3){
			    if($weeks==1){
			        return "a week ago";
			    }else{
			        return "$weeks weeks ago";
			    }
			}
			//Months
			else if($months <=12){
			    if($months==1){
			        return "a month ago";
			    }else{
			        return "$months months ago";
			    }
			}
			//Years
			else{
			    if($years==1){
			        return "one year ago";
			    }else{
			        return "$years years ago";
			    }
			}
		}
?>