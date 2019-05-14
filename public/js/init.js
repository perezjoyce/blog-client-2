(function($){
    $(function(){
        
        // MATERIALIZE
        M.AutoInit();
        $('textarea#synopsis').characterCounter();

        // TINYMCE   
          var dfreeBodyConfig = {
            selector: '.dfree-body',
            menubar: false,
            inline: true,
            plugins: [
              'autolink',
              'codesample',
              'link',
              'lists',
              'media',
              'table',
              'image',
              'quickbars',
              'lists'
            ],
            toolbar: false,
            quickbars_insert_toolbar: 'quicktable image',
            quickbars_selection_toolbar: 'bold italic | h2 h3 | blockquote quicklink',
            contextmenu: 'inserttable | cell row column deletetable'
          };
          
          tinymce.init(dfreeBodyConfig);
        }); 

  })(jQuery); // end of jQuery name space

  
  