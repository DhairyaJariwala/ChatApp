$(document).ready(function(){
    $('.btn').on('click',function(event){

      if($('#first_name').val() == '' || $('#last_name').val() == '' || $('#username').val() == '' || $('#email').val() == '' || $('#password').val() == '' || $('#c_password').val() == ''){
          alert('Please Fill All the Values');
          event.preventDefault();
      }
    })

})
