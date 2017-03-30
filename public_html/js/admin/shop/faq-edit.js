
$(document).ready(function () {

    $('textarea.editable-textarea').summernote({
        toolbar: [
            ['style', ['style', 'bold', 'underline', 'clear']],
            ['font', ['fontname', 'fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});
