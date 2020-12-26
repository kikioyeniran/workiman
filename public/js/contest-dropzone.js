Dropzone.autoDiscover = false;

if ($("#contest-images-form").length) {
    Dropzone.options.contestImagesForm = {
        autoProcessQueue: false,
        addRemoveLinks: true,
        parallelUploads: 5,
        maxFiles: 5,
        dictRemoveFileConfirmation: 'Are you sure you want to remove this file',
        dictDefaultMessage: '<h1 class="icon-feather-upload-cloud" style="color: orange;"></h1><p>Drop files here to upload!</p>'
    }

    const contestImagesDropzone = new Dropzone("#contest-images-form")

    contestImagesDropzone.on('addedfile', (file) => {
        file.previewElement.addEventListener('click', () => {
            preview_image_modal.find('img').attr({
                src: file.dataURL
            })
            preview_image_modal.modal('show')
        })
    })

    contestImagesDropzone.on('totaluploadprogress', (progress) => {
        console.log('Progress: ', progress);
        // $('#upload-progress').attr({
        //     'aria-valuenow': progress
        // }).css({
        //     width: `${progress}%`
        // })
        // if(progress >= 100) {
        //     $('#upload-progress').removeClass('bg-warning').addClass('bg-success')
        // }
    })

    contestImagesDropzone.on('queuecomplete', () => {
        console.log("All files have been uploaded successfully");
        // contestImagesDropzone.reset()
        contestImagesDropzone.removeAllFiles()
        goToListingStep(4)
        create_listing_form_3_view.hide()
        create_listing_form_4_view.fadeIn()
    })

    contestImagesDropzone.on('error', (file, errorMessage, xhrError) => {
        console.log("Error occurred here: ", file, errorMessage, xhrError);
    })

    $('#add-listing-images-button').on('click', () => {
        // $('#upload-progress').attr({
        //     'aria-valuenow': 0
        // }).css({
        //     width: `0%`
        // }).removeClass('bg-warning').addClass('bg-success')
        contestImagesDropzone.processQueue()
    })
}

if ($("#contest-submissions-form").length) {
    Dropzone.options.contestSubmissionsForm = {
        autoProcessQueue: false,
        addRemoveLinks: true,
        parallelUploads: 5,
        uploadMultiple: true,
        paramName: 'files',
        acceptedFiles: 'image/*',
        maxFiles: 5,
        dictRemoveFileConfirmation: 'Are you sure you want to remove this file',
        dictDefaultMessage: '<h1 class="icon-feather-upload-cloud" style="color: orange;"></h1><p>Drop files here to upload!</p>'
    }
    const contestSubmissionsDropzone = new Dropzone("#contest-submissions-form")

    contestSubmissionsDropzone.on('addedfile', (file) => {
        file.previewElement.addEventListener('click', () => {
            preview_image_modal.find('img').attr({
                src: file.dataURL
            })
            preview_image_modal.modal('show')
        })
    })

    contestSubmissionsDropzone.on('totaluploadprogress', (progress) => {
        console.log('Progress: ', progress);
        // $('#upload-progress').attr({
        //     'aria-valuenow': progress
        // }).css({
        //     width: `${progress}%`
        // })
        // if(progress >= 100) {
        //     $('#upload-progress').removeClass('bg-warning').addClass('bg-success')
        // }
    })

    contestSubmissionsDropzone.on('queuecomplete', () => {
        console.log("All files have been uploaded successfully");
        // contestSubmissionsDropzone.reset()
        contestSubmissionsDropzone.removeAllFiles()
    })

    contestSubmissionsDropzone.on('error', (file, errorMessage, xhrError) => {
        console.log("Error occurred here: ", file, errorMessage, xhrError);
        Snackbar.show({
            text: errorMessage.message,
            pos: 'top-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 5000,
            textColor: '#fff',
            backgroundColor: '#721c24'
        });
        loading_container.hide()
    })

    contestSubmissionsDropzone.on('success', (file, successMessage, xhrError) => {
        console.log("Error occurred here: ", file, successMessage, xhrError);
        Snackbar.show({
            text: successMessage.message,
            pos: 'top-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 10000,
            textColor: '#fff',
            backgroundColor: '#28a745'
        });
        setTimeout(() => {
            window.location.reload()
        }, 5000);
    })

    $('#contest-submissions-button').on('click', () => {
        // $('#upload-progress').attr({
        //     'aria-valuenow': 0
        // }).css({
        //     width: `0%`
        // }).removeClass('bg-warning').addClass('bg-success')
        loading_container.show()
        contestSubmissionsDropzone.processQueue()
    })
}
