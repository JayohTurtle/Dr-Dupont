tinymce.init({
  selector: 'textarea.tinymce-editor',
  plugins: 'autolink lists advlist wordcount',
  menubar: false,
  toolbar: 'undo redo | bold italic underline strikethrough | blocks | alignleft aligncenter alignright alignjustify | numlist bullist | forecolor backcolor removeformat',
  toolbar_sticky: false,
  height: 300,
  content_css: false,
  branding: false,
  contextmenu: false
})
