<?php 
	//check if user logged in
	//if not redirect to login page
require_once("../../includes/session.php"); 
confirm_logged_in(); 
?>

<?php
	if(admin_check()){ //user is admin
		include("../../includes/header_admin.php");
		include("../../includes/sidebar_admin.php");
	}else{ //normal user
		include("../../includes/header.php");
		include("../../includes/sidebar.php");
	}
	?>

	<?php
	//if user tries to enter admin area
	//user will be redirected here
	//with permission denied message
	if (isset($_GET['permission']) && $_GET['permission'] == 1) {
		$message = "Permission Denied!.";
		if (!empty($message)) {
			echo "<p class=\"message\">" . $message . "</p>";
		}
	}
	?>
	<?php
	//get page number from query string to show post 10 posts per page
	//page numbers starts from zero for first page
	if (isset($_GET['page']) ) {
		$page_number = $_GET['page'];
	}else{
		$page_number = 0; //first page
	}
	?>


	<!-- Page Content -->



	<div class="table">
		<div class="container">

			<div class="posts">
				<div class="create-posts">
					<form action="" id="post-form" method="post" enctype="multipart/form-data">
						<div class="c-header">
							<div class="c-h-inner">
								<ul>	
									<li style="border-right:none;"><img src="../../img/icon3.png"></img><a href="#">Update Status</a></li>
									<li><input type="file"  onchange="readURL(this);" style="display:none;" name="post_image" id="uploadFile"></li>
									<li><img src="../../img/icon1.png"></img><a href="#" id="uploadTrigger" name="post_image">Add Photos/Video</a></li>
									<li style="border: none;"><img src="../../img/icon2.png"></img><a href="#">Create Photo Album</a></li>
								</ul>
							</div>
						</div>
						<div class="c-body">
							<div class="body-left">
								<div class="img-box">
									<img src="img/fw.png"></img>
									
								</div>
							</div>
							<div class="body-right">
								<textarea class="text-type" id="post-text" name="status" placeholder="What's on your mind?"></textarea>
							</div>
							<div id="body-bottom">
								<img src="#"  id="preview"/>
							</div>
						</div>
						<div class="c-footer">
							<div class="right-box">
								<ul>
									<li><button class="btn1"><img class="iconw-margin" src="../../img/iconw.png"></img>Public<img class="iconp-margin" src="../../img/iconp.png"></img></button></li>
									<button class="btn2" id="post-btn">Post</button>
								</ul>
							</div>

						</div>
					</div>
				</div>
				<script type="text/javascript">
						 //Image Preview Function
						 $("#uploadTrigger").click(function(){
						 	$("#uploadFile").click();
						 });
						 function readURL(input) {
						 	if (input.files && input.files[0]) {
						 		var reader = new FileReader();

						 		reader.onload = function (e) {
						 			$('#body-bottom').show();
						 			$('#preview').attr('src', e.target.result);
						 		}

						 		reader.readAsDataURL(input.files[0]);
						 	}
						 }

						</script>

						<?php
	//get post from db
						require_once("../../includes/social_functions.php"); 

						$post = get_all_posts($page_number);

						while( $post_row = mysqli_fetch_assoc($post)) {
		//get post owner data
							$post_user = get_user_data($post_row["user_id"]);
							$post_user_row = mysqli_fetch_assoc($post_user);
		//	echo htmlentities($post_user_row["username"]);
		//	echo htmlentities($post_user_row["first_name"]);
		//	echo htmlentities($post_user_row["middle_name"]);
		//	echo htmlentities($post_user_row["last_name"]);
		//	echo htmlentities($post_user_row["college_role"]);	
		 //}
//fetching all posts
							echo '
							<div class="post-show">
								<div class="post-show-inner">
									<div class="post-header">
										<div class="post-left-box">
											<div class="id-img-box"><img src="'.$post_user_row['profile_image'].'"></img></div>
											<div class="id-name">
												<ul>
													<li><a href="#">'.$post_user_row['username'].'</a></li>
													<li><small>'.$post_row['time'].'</small></li>
												</ul>
											</div>
										</div>
										<div class="post-right-box"></div>
									</div>
									
									<div class="post-body">
										<div class="post-header-text">
											'.$post_row['post'].'
										</div>'.( ($post_row['post_image'] != 'NULL') ? '<div class="post-img">
											<img src="'.$post_row['post_image'].'"></img></div>' : '').'
										<div class="post-footer">
											<div class="post-footer-inner">
												<ul>
													<li><a href="#">Like</a></li>
													<li><a href="#">Comment</a></li>
													<li><a href="#">Share</a></li>
												</ul>	
											</div>
										</div>
									</div>
								</div>
							</div><br> ';	
							if(isset($_POST['submit'])){
								$post  = $_POST['post'];
		//checking image if isset
								if (isset($_FILES['post_image'])===true) {
			//if image is not empty 
									if (empty($_FILES['post_image']['name']) ===true) {
										if(!empty($post)===true){
											$send->add_post($user_id,$post);
										}
									}else {
			 	 //checking image format                                                                                                       
										$allowed = array('jpg','jpeg','gif','png'); 
										$file_name = $_FILES['post_image']['name']; 
										$file_extn = strtolower(end(explode('.', $file_name)));
										$file_temp = $_FILES['post_image']['tmp_name'];

										if (in_array($file_extn, $allowed)===true) {
											$file_path = '../../uploads/posts/' . substr(md5(time()), 0, 10).'.'.$file_extn;
											move_uploaded_file($file_temp, $file_path);
											$send->add_post($user_id,$post,$file_path);

										}else{
											echo 'incorrect File only Allowed with less then 1mb ';
											echo implode(', ', $allowed);
										}
									}

								}

							}



		/* //post payload
		echo htmlentities($post_row["time"]);
		echo htmlentities($post_row["user_id"]);
		echo htmlentities($post_row["post"]);
		echo htmlentities($post_row["post_id"]);
		$post_id = $post_row["post_id"];
		//get post tags
		$post_tags = get_post_tags($post_id);
		while( $post_tag_row = mysqli_fetch_assoc($post_tags)) {
			echo htmlentities($post_tag_row["tag"]);
		}
		
		//get post comments
		$post_comment = get_post_comments($post_row["post_id"]);
		 while( $post_comment_row = mysqli_fetch_assoc($post_comment)) {
			 //get comment owner data
			$comment_user = get_user_data($post_comment_row["user_id"]);
			 if( $comment_user_row = mysqli_fetch_assoc($comment_user)) {
				echo htmlentities($comment_user_row["username"]);
				echo htmlentities($post_user_row["first_name"]);
				echo htmlentities($post_user_row["middle_name"]);
				echo htmlentities($post_user_row["last_name"]);
				echo htmlentities($post_user_row["college_role"]);
			 }
			 //get comment time and payload
			echo htmlentities($post_comment_row["comment"]);
			echo htmlentities($post_comment_row["time"]);
		}*/
	}?>
</div>
</form>	

</div></div></div>


<script>
// Eidarous JS Edit start

			// Attach a click handler to the post button
			$( "#post-btn" ).click(function( event ) {

			  // disable post button
			  $( "#post-btn" ).prop('disabled', true);
			  // Stop button from default function to avoid duble click and post the same content twice.
			  event.preventDefault();

			  // Get value from post input.
			  var $form = $("#post-form"),
			  post = $form.find( "textarea[name='status']" ).val(); //find a textarea named status retrieves the textarea content and store it in a value named post. val() is a jquery function that returns the current value of the selected element.

			  // if post is empty string return
			  if(!post){
			  	// enable post button
			  	$( "#post-btn" ).prop('disabled', false);

			  	return; //return and don't do any other stuff because we have an empty post.
			  }

			  // AJAX POST call - Send the data using post
			  var posting = $.post( "../../api/post/send_post_api.php", { post: post} ); 						/*$.post means a call to jquery post method. it the returns a javascript object whic we stored     	in a variable named posting.																    The first argument to the method is the endpoint we are posting to. I.e the ApI URL.			 The second is the post payload we are sending. in this case we are sending only the post data retrieved on line 235, if for instance we intend to include other things in post payload say for instance post_tag, it'll look something like this {post: post, post_tag: post_tag}.				 The funny syntax with curly brackets {}, is how you represent javascript object.*/

			  // Put the results in a div
			  posting.done(function( data ) {/*means when if the done method of the posting javascript object returned when we made the post call to the server evaluates to true. When it evaluates to true the callback function gets called, what ever the server returns is passed in as data.*/
			  	var data = JSON.parse(data); //converts the JSON data returned by the server into a javascript object
			  	// Clear the text area
			  	$form.find( '#post-text' ).val('');
			    //var content = $( data ).find( "#content" );
			    $( ".create-posts" ).after( '<div class="post-show">\
			    	<div class="post-show-inner">\
			    		<div class="post-header">\
			    			<div class="post-left-box">\
			    				<div class="id-img-box"><img src="' + data.post_data.user_profile_image + '"></img></div>\
			    				<div class="id-name">\
			    					<ul>\
			    						<li><a href="#">' + data.post_data.user_name + '</a></li>\
			    						<li><small>' + data.post_data.time + '</small></li>\
			    					</ul>\
			    				</div>\
			    			</div>\
			    			<div class="post-right-box"></div>\
			    		</div>\
			    		<div class="post-body">\
			    			<div class="post-header-text">\
			    				'+ data.post_data.post + '\
			    			</div>\
			    			<div class="post-footer">\
			    				<div class="post-footer-inner">\
			    					<ul>\
			    						<li><a href="#">Like</a></li>\
			    						<li><a href="#">Comment</a></li>\
			    						<li><a href="#">Share</a></li>\
			    					</ul>	\
			    				</div>\
			    			</div>\
			    		</div>\
			    	</div>\
			    </div><br> ' );
			    // enable post button
			    $( "#post-btn" ).prop('disabled', false);
			});
			});

// Eidarous edit end
</script>

		<?php
	if(admin_check()){ //user is admin
		include("../../includes/footer_admin.php");
	}else{ //normal user
		include("../../includes/footer.php");
	}
	?>


