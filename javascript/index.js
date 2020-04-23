$(document).ready(function(){

  // Getting Values which are Stored In web sessionStorage
  if(sessionStorage.getItem("chat-with")){
		$(".chat-with").text(sessionStorage.getItem('chat-with'));
		$('.chat-num-messages').text(sessionStorage.getItem('chat-num-messages'));
		updateMessages();
	}

  //Clearing Web sessionStorage when Logging out
  $(".logout").on('click',function(){
    sessionStorage.clear();
  })

  // Updating Certain Part of Page without refreshing whole page and Attach event Handler To It.
  var friendsList = setInterval(function(){
    $("#friend").load("index.php #friendsList",function(){
      $('ul.list div.name').on('click',function(){
          $(".chat-with").text($(this).text());
          $(".chat-with").attr("data-userid",$(this).attr('data-userid'));
          $('.chat-num-messages').text($(this).siblings('.status').text());
          $('#message-to-send').prop('readonly',false);

          updateMessages();
          $("i.person_add").addClass("person_block");
          $("i.fa-check").addClass("check");

      });
    });
  },5000);

  // Materialize
  $('.tooltipped').tooltip();
  $('.dropdown-trigger').dropdown({
    coverTrigger: false,
    alignment: 'right',
    constrainWidth: false,
  });
  var auto = $('input.autocomplete').autocomplete();
  $('.fixed-action-btn').floatingActionButton({
    hoverEnabled: false,
  });

  function updateMessages(scrollHeight = null){
    var receiver1 = $('.chat-with').text();
    var sender1 = $('#username').text();
    // var tempScrollTop = $("#chat-history").scrollTop(); // Get The Current Scroll Amount And Save it for Later

    if($('.chat-with').text() != ' - '){
      $("#chat-history").load("index.php #chatMessageArea",function(){
        $.ajax({
          url: "loadChatHistory.php",
          type: "POST",
          data:{
            sender: sender1,
            receiver: receiver1,
          },
          success: function(data){
            $('#chatMessageArea').html(data);
            if(scrollHeight == null){
                $("#chat-history").scrollTop($('.chat-history').prop('scrollHeight')); // Set the Previous Scroll Position
            }else{
                $("#chat-history").scrollTop(scrollHeight); // Set the Previous Scroll Position
            }
          }
        })
      });
    }
  }

  //OnClick Of Friends List
  $('ul.list div.name').on('click',function(){
      $(".chat-with").text($(this).text());
      $('.chat-num-messages').text($(this).siblings('.status').text());
      sessionStorage.setItem("chat-with",$(".chat-with").text());
      sessionStorage.setItem("chat-num-messages",$(".chat-num-messages").text());

      $(".chat-with").attr("data-userid",$(this).attr('data-userid'));

      $('#message-to-send').prop('readonly',false);

      updateMessages();
      $("i.person_add").addClass("person_block");
      $("i.fa-check").addClass("check");

  });

  // For Loading New Chat Message
  var stopMessages = setInterval(function(){
    updateMessages($("#chat-history").scrollTop());
  },5000);


  // Makeing TextArea Disabled When Receiver Header is NULL
  if($('.chat-with').text() == ' - '){
    $('#message-to-send').prop('readonly',true);
  }

  //Search AutoComplete
  $("#search").keyup(function(){
    $.ajax({
      url: "search.php",
      type: "POST",
      data:{
        term: $(this).val(),
      },
      success: function(data){
        $("#suggesstion-box").show();
        $("#suggesstion-box").html(data);
      }
    });

  });


  //Search Item Click Event with Check if Request is Sent or not to the user
  $(document).on('click','.search-item',function(){
    $(".chat-with").text($(this).text());
    $(".chat-with").attr('data-userid',$(this).attr('data-userid'));
    $('.chat-num-messages').text("");
    $("i.fa-check").addClass("check");
    $.ajax({
      url: 'friendRequests.php',
      type: 'POST',
      async: false,
      data:{
        receiverId : $('.chat-with').attr('data-userid'),
      },
      dataType: 'json',
      success: function(data){
        if(data.result === 'true'){
          $("i.fa-check").removeClass("check");
        }else{
          $("i.person_add").removeClass("person_block");
        }
      }
    });

    $('#message-to-send').prop('readonly',true);
    $("#chatMessageArea").html('<li class="noMessage">No Messages Yet</li>');
    // clearInterval(stopMessages);
    // stopMessages = null;
  });

  // Adding Friend Logic
  $('i.person_add').on('click',function(){
    $(this).addClass("person_block");
    $("i.fa-check").removeClass("check");

    $.ajax({
      url: 'friendRequests.php',
      type: 'POST',
      data:{
        receiverId : $('.chat-with').attr('data-userid'),
        receiver : $('.chat-with').text(),
      },
      success: function(data){

      },
    })
  });

  $(".button_add").on("click",function(){
    $.ajax({
      url: 'updateFriends.php',
      type: 'POST',
      data:{
        friendId: $(this).parent('.requestedUser').attr('data-userid'),
        friendName: $(this).siblings('.requestedUsername').text(),
      },
      success: function(data){
        $(this).parent('.requestedUser').remove();
        window.location.reload();
      }
    })
  });

  $(".readbutton").on("click",function(){
    $.ajax({
      url: 'notificationRead.php',
      type: 'POST',
      data:{
        notificationId : $(this).parent('.notification').attr('notification-id'),
      },
      success: function(data){
        $(this).parent('.notification').remove();
        window.location.reload();
      }
    })
  })

});
