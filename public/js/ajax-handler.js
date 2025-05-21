function handleSaveChanges(formId, buttonId, url, id=null) {

     if (id === null) {
        id = $(buttonId).data('id');
    }
    var id = $(buttonId).data('id');
   if (id) {
        var formData = new FormData($(formId)[0]);
        formData.append('id', id);
    } else {
        var formData = new FormData($(formId)[0]);
    }
    var formData = new FormData($(formId)[0]);

    formData.append('id', id);
    $.ajax({
        url: url, 
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: `${response.message}`,
                showConfirmButton: false,
                timer: 2000
            });
            $('.btn-close').click();

            table.ajax.reload(null, false);
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Failed to save data: ' + error,
                showConfirmButton: false,
                timer: 2000
            });
            $('.btn-close').click();
        }
    });
}
