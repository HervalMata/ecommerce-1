$(function() {
    var notes_form = $('#notes_form');
    notes_form.submit(function() {
        $.ajax({
            url: 'ajax/notes.php',
            type: 'POST',
            dataType: 'text',
            data: {00
                page_id: page_id,
                notes: $('#notes').val()
            },
            success: function(response) {
                if (response === 'true') {
                    var notes_message = $('#notes_message');
                    if (notes_message.length !== 0) {
                        notes_message.html('Your notes have been saved again.');
                    } else {
                        notes_from.prepend('<p id="notes_message" class="alert alert-success">Your notes have been saved.</p>');
                    }
                } else {
                    // do something
                }
            } // success function
        }); // ajax
        return false;
    }); // end of submit() function
}) // main anonymous function