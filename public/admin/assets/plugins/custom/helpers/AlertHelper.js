var AlertHelper = {

    alert : {
        options : {
            width: 400,
            heightAuto: false,
            padding: '2.5rem',
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-success',
            confirmButtonColor: null,
            confirmButtonText: 'OK',
            cancelButtonClass: 'btn btn-secondary',
            cancelButtonColor: null
        }
    },

    notice : {
        options : {
            closeButton: true,
            debug: false,
            positionClass: "toast-bottom-right",
            onclick: null,
            progressBar: true,
            showDuration: 1000,
            hideDuration: 1000,
            timeOut: 5000,
            extendedTimeOut: 1000,
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        }
    },

    successAlert : function(text, callback = null){
        AlertHelper.alert.options.title = 'Success';
        AlertHelper.alert.options.text = text;
        AlertHelper.alert.options.type = 'success';
        Swal.fire(AlertHelper.alert.options).then(callback);
    },

    errorAlert : function(text, callback){
        AlertHelper.alert.options.title = 'Error';
        AlertHelper.alert.options.text = text;
        AlertHelper.alert.options.type = 'error';
        Swal.fire(AlertHelper.alert.options).then(callback);
    },

    successNotice : function(title, text){
        toastr.success(text, title, AlertHelper.notice.options);
    },

    errorNotice : function(title, text){
        toastr.error(text, title, AlertHelper.notice.options);
    },

    warningNotice : function(title, text){
        toastr.warning(text, title, AlertHelper.notice.options);
    },

    infoNotice : function(title, text){
        toastr.info(text, title, AlertHelper.notice.options);
    },

    showLoading : function(){
        $.Toast.showToast({
            title: LanguageManager.translate('processing'),
            duration: 30000,
            icon:"loading",
            image: ''
        });
    },

    hideLoading : function(){
        $.Toast.hideToast();
    }
};
