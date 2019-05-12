$(document).ready(function(){
    // BTNS
    $('#deleteBlogTrigger').on('click', function(e){
        e.preventDefault;
        e.stopPropagation;

        const blogId = $(this).data('id');
        const blogTitle = $(this).data('title');
        $('#deleteBlogId').val(blogId);
        $('#deleteBlogTitle').val(blogTitle);
      })

    $('.saveEditsBtn').on('click', function(){
      $('#saveBlogPostEditsForm').submit();
      $('.modal').modal('close');
    })

    $('.cancelEditsBtn').on('click', function(){
      $('.modal').modal('close');
    })
})