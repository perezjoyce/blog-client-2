$(document).ready(function(){
  
    // BTNS
    $(document).on('click', '.deleteBlogTrigger', function(e){
        // e.preventDefault;
        // e.stopPropagation;

        const blogId = $(this).data('id');
        const blogTitle = $(this).data('title');
        const blogAuthor = $(this).data('author');
        const blogCreation = $(this).data('createdat')
        $('#deleteBlogId').val(blogId);
        $('#blogTitleToDelete').text(blogTitle);
        $('#blogAuthorToDelete').text(blogAuthor);
        $('#blogCreatedAtToDelete').text(blogCreation);
        $('#deleteBlogTitle').val(blogTitle);
      })

    $('.cancelEditsBtn').on('click', function(){
      $('.modal').modal('close');
    })

    $(document).on('click', '.saveEditsBtn', function(){
      const postBody = tinymce.activeEditor.getContent();
      $('#postBody').val(postBody);
      
      $('#save-form').submit();
      $('.modal').modal('close');
    })

    $(document).on('click','#submitHandler', function() {
      const postBody = tinymce.activeEditor.getContent();
      $('#postBody').val(postBody);

      // submit the form
      $('#post-form').submit();
    });

    $(document).on('click', '#editUserTrigger', function() {
      const userId = $(this).data('id');
      const userName = $(this).data('name');
      const userRole = $(this).data('role'); //isAdmin: true or false
      const userPlan = $(this).data('plan');

      $('#edit_name').val(userName);
      $('#userId').val(userId);

      var options = $('#edit_plan').find('option');

      if(options.length == 0) {
        // create new option element
        var opt = document.createElement('option');
        // create text node to add to option element (opt)
        opt.appendChild( document.createTextNode(userPlan) );
        // set value property of opt
        opt.value = userPlan;
        opt.selected = true;
        $('#edit_plan')[0].add(opt);

        var opt2 = document.createElement('option');
        // create text node to add to option element (opt)

        var userPlan2 = userPlan == 'premium' ? 'Free' : 'Premium';
        opt2.value = userPlan == 'premium' ? 'free' : 'premium';
        opt2.appendChild( document.createTextNode(userPlan2) );
        
        $('#edit_plan')[0].add(opt2);
      } else {
        $('#edit_plan').val(userPlan);
      }



      var options2 = $('#edit_role').find('option');

      if(options2.length == 0) {
        // create new option element
        var opt3 = document.createElement('option');
        // create text node to add to option element (opt)
        var userRoleText = userRole ? 'Admin' : 'User';
        opt3.appendChild( document.createTextNode(userRoleText) );
        // set value property of opt
        opt3.value = userRole ? 'true' : 'false';
        opt3.selected = true;
        $('#edit_role')[0].add(opt3);

        var opt4 = document.createElement('option');
        // create text node to add to option element (opt)

        var userRole2 = userRole === '' ? 'Admin' : 'User';
        opt4.value = userRole2 == 'Admin' ? true : false;
        opt4.appendChild( document.createTextNode(userRole2) );
        
        $('#edit_role')[0].add(opt4);
      } else {
        var selectedValue = userRole == true ? 'true' : 'false';
        $('#edit_role').val(selectedValue);
      }
    })

    $('#stripeForm').on('shown.bs.modal', function () {

      alert('test');
    })

    // Code below worked when put outside doc.ready

    var stripe = Stripe('pk_test_9E7pw13w0KyKbxHiDhAYGT57');
    var elements = stripe.elements();

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
      base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
          color: '#aab7c4'
        }
      },
      invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
      }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
      var displayError = document.getElementById('card-errors');
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = '';
      }
    });

    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
      event.preventDefault();

      stripe.createToken(card).then(function(result) {
        if (result.error) {
          // Inform the user if there was an error.
          var errorElement = document.getElementById('card-errors');
          errorElement.textContent = result.error.message;
        } else {
          // Send the token to your server.
          stripeTokenHandler(result.token);
        }
      });
    });

    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
      // Insert the token ID into the form so it gets submitted to the server
      var form = document.getElementById('payment-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('value', token.id);
      form.appendChild(hiddenInput);

      // Submit the form
      form.submit();
    }
})

