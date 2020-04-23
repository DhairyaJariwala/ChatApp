<?php include 'inc/header.php'; ?>
<!-- <link rel="stylesheet" href="css/main.css"> -->
<link rel="stylesheet" href="css/main.css" type="text/css">
</head>
<body>
	<?php displayMessage() ?>
	<div class="container clearfix">
		<div class="row profile">
			<div class="col s12">
				<div class="row">
					<h5 class="col s8 offset-s1" id="username" style="color:white;"><i class="fa fa-circle online" style="font-size:15px;"></i><?php echo $_SESSION['user']->account_name; ?></h5>
					<div class="col s3">
						<?php if($friendRequests === NULL){ ?>
							<i class="fa fa-users tooltipped fa-2x" aria-hidden="true" data-position="bottom" data-tooltip="Friend Requests"></i>
						<?php }else{ ?>
							<i class="fa fa-users tooltipped fa-2x dropdown-trigger badge1" data-badge="<?php echo count($friendRequests); ?>" data-target="dropdownRequestedUsers" aria-hidden="true" data-position="bottom" data-tooltip="Friend Requests"></i>
						<?php } ?>
						<?php if(count($notifications) == 0){ ?>
							<i class="fa fa-bell fa-2x tooltipped" data-position="bottom" data-tooltip="Notifications" style="margin-right:40px;cursor:pointer;"></i>
						<?php }else{ ?>
							<i class="fa fa-bell fa-2x tooltipped dropdown-trigger badge1" data-badge="<?php echo count($notifications); ?>" data-target="dropdownNotifications" data-position="bottom" data-tooltip="Notifications" style="margin-right:40px;cursor:pointer;"></i>
						<?php } ?>
						<a  class="logout" href="logout.php"><i class="fa fa-sign-out fa-2x exit_app tooltipped" data-position="bottom" data-tooltip="Logout"></i></a>
					</div>
				</div>
			</div>
		</div>
		<ul class="dropdown-content" id="dropdownRequestedUsers">
			<?php foreach ($allRequestedUsers as $users) {
					foreach ($users as $user) { ?>
						<li class="requestedUser" data-userid="<?php echo $user['account_id']; ?>"><div class="requestedUsername col s5"><?php echo $user['account_name']; ?></div><button class="btn-small blue button_add col s3">Add</button><button class="btn-small button_delete red col s4 ">Delete</button></li>
			<?php		}
			}
			?>
		</ul>
		<ul class="dropdown-content" id="dropdownNotifications">
			<?php foreach ($notifications as $notification) { ?>
					<li class="notification" notification-id = "<?php echo $notification['id']; ?>"><?php echo $notification['message']; ?> <button class="btn-small green readbutton">Mark As Read</button> </li>
				<?php
			} ?>
		</ul>
		<hr class="hrmargin">
    <div class="people-list" id="people-list">
		      <div class="row">
						<div class="col s12">
							<div class="row">
								<div class="search input-field col s12">
				          <input type="text" id="search" autocomplete="off">
									<label for="search">Search New Friends</label>
									<div id="suggesstion-box"></div>
				        </div>

							</div>
						</div>

  		 		</div>
					<h5>Friends List</h5>
					<hr>
				<div id="friend">
      <ul class="list" id="friendsList">
						<?php foreach ($friends as $friendName) {
						  foreach ($friendName as $fname) {
						      ?>
						      <li class="clearfix">
						        <a class="a-list">
						        <div class="about">
						          <div class="name" data-userid="<?php echo $fname['account_id']; ?>"><?php echo $fname['account_name']; ?></div>
						          <?php if ($fname['status'] == 1) { ?>
						          <div class="status"> <i class="fa fa-circle online"></i> Online
						          <?php }else{ ?>
						            <div class="status"> <i class="fa fa-circle offline"></i> Offline
						            <?php } ?>
						          </div>
						        </div>
						      </a>
						      </li>
						<?php

						  }
						} ?>
      </ul>
		</div>
    </div>

    <div class="chat">
      <div class="chat-header clearfix">

        <div class="chat-about">
          <div class="chat-with"> - </div>
          <div class="chat-num-messages"> - </div>
        </div>
				<i class="material-icons dropdown-trigger" data-target="dropdownMoreVert">more_vert</i>
				<ul class="dropdown-content" id="dropdownMoreVert">
					<li>One</li>
					<li>One</li>
				</ul>
				<i class="fa fa-user-plus fa-lg person_block person_add tooltipped" data-position="bottom" data-tooltip="Add To Friends"></i>
				<i class="fa fa-check check fa-lg tooltipped" data-position="bottom" data-tooltip="Friend Request Sent"></i>
      </div> <!-- end chat-header -->

      <div class="chat-history" id="chat-history">
        <ul id="chatMessageArea">


        </ul>

      </div> <!-- end chat-history -->

      <div class="chat-message clearfix">


							<i class="material-icons smily btn-floating btn-small yellow">sentiment_very_satisfied</i>
							<textarea name="message-to-send" id="message-to-send" placeholder ="Type your message" rows="3"></textarea>

							<i class="material-icons file btn-floating btn-small">attach_file</i> &nbsp;&nbsp;&nbsp;
			        <i class="material-icons btn waves-effect waves-light" id="send-btn">send</i>

      </div> <!-- end chat-message -->

    </div> <!-- end chat -->

  </div> <!-- end container -->

<script type="text/javascript">


	// Sending Message on the Click of Send Button
	$('#send-btn').on('click',function(){
			var msg = $('#message-to-send').val();
			var receiver1 = $('.chat-with').text();
			var sender1 = $('#username').text();
			var count = 0;
			<?php $time = new DateTime('now',new DateTimeZone('Asia/Kolkata'));
					$time = $time->format('g:i a,d/m/y'); ?>
			if($(".noMessage").length){
				$(".noMessage").remove();
			}
			if(msg != ''){
				var template = [
					'<li class="clearfix">',
						'<div class="message-data align-right">',
						'<span class="message-data-time"><?php echo $time ?></span>',
							'<span class="message-data-name"> <?php echo $_SESSION['user']->account_name ; ?></span>',
						'</div>',
						'<div class="message other-message float-right">' + msg + '</div>',
					'</li>'
				].join('\n');
				$('.chat-history > ul').append(template);
				$('#message-to-send').val('');
				$("#chat-history").scrollTop($('#chat-history').prop('scrollHeight'));
				$.ajax({
					url: 'message.php',
					type: "POST",
					data: {
						message: msg,
						sender: sender1,
						receiver: receiver1,
					},
					success: function(data,error){
						count = data;
					},
					async: false,
				});

				$.ajax({
				url: 'storeMessage.php',
				type: "POST",
				data:{
					message: msg,
					sender: sender1,
					receiver: receiver1,
					msgCount: count,
				},
				success: function(data){

				},
				async: false,
			});
			}
			else{
				var toastHTML = '<span>Cannot Send Empty Message</span>';
				M.toast({html: toastHTML});
			}
	});


</script>

<?php include 'inc/footer.php'; ?>
