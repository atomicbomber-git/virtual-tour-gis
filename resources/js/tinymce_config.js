module.exports = {
    selector: '#content',
    body_class: 'tinymce-editor',
    plugins: 'lists,image,imagetools',
    image_caption: true,
    file_picker_callback: require('./tinymce_file_picker_callback'),
    height: 400,
    toolbar: [
        'undo redo | styleselect | bold italic | numlist bullist | alignleft aligncenter alignright | image'
    ],
}
