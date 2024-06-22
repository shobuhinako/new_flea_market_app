$(document).ready(function() {
    $('#form-image').on('change', function(event) {
        const input = event.target;
        const fileNameDisplay = $('#file-name');

        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            fileNameDisplay.text(fileName);

            const reader = new FileReader();
            reader.onload = function(e) {
                $('.item__image').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            fileNameDisplay.text('');
        }
    });
});