var DataTableHelper = {

    baseElement : null,
    table : null,
    filters : [],
    values : {},

    initDatatable : function(element, order, type, url, columns, footerFunction, definitions = [], drawCallback, additionalRequestData = null, createdRowCallback = null){
        $(document).ready(function(){
            DataTableHelper.baseElement = element;
            if(typeof footerFunction === 'undefined'){ footerFunction = function(){}; }
            if(typeof drawCallback === 'undefined'){ drawCallback = function(){}; }
            if(typeof createdRowCallback === 'undefined'){ createdRowCallback = function(){}; }
            if(typeof additionalRequestData !== 'object' || !additionalRequestData){
                additionalRequestData = {};
            }

            DataTableHelper.table = $(DataTableHelper.baseElement).DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                order:[order],
                lengthMenu:[[5,10,20,50,100,-1],[5,10,20,50,100,"All"]],
                pageLength:20,
                ajax: {"url": url, "type": type, "headers": {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, "data": function(data){ return $.extend(data, DataTableHelper.values, additionalRequestData); }},
                columnDefs : definitions,
                columns: columns,
                oLanguage: {
                    info: "",
                    sZeroRecords:'recordsNotFound',
                    sEmptyTable: 'recordsAreEmpty',
                    sSearch: "<span>"+ 'search' +":</span> _INPUT_",
                    sLengthMenu: "<span>"+ 'records' +":</span> _MENU_",
                },
                footerCallback: footerFunction,
                drawCallback: drawCallback,
                createdRow: createdRowCallback,
            });
            $(DataTableHelper.baseElement + ' tbody').on('click', 'tr', function () {
                if($(this).hasClass('selected')){ $(this).removeClass('selected'); }
                else{ DataTableHelper.table.$('tr.selected').removeClass('selected'); $(this).addClass('selected'); }
            });
        });
    },

    deleteRecord : function (url){
        $(document).ready(function(){
            Swal.fire({
                title: 'Warning',
                text: 'Do you want to delete record?',
                // type: 'Warning',
                showCancelButton: true,
                confirmButtonColor: '#d32f2f',
                confirmButtonText: 'Yes',
                cancelButtonText:'No',
            }).then(function(result){
                if(result.hasOwnProperty('value')){
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function(result) {

                            if(result.status == 'success'){ AlertHelper.successNotice( '', result.message); DataTableHelper.table.ajax.reload(); }
                            else{  AlertHelper.errorAlert(result.message); }
                        }
                    });
                }
            });
        });
    },
    updateFilter : function(element, type){
        if(DataTableHelper.table !== null){
            var data = null;
            if(type == 'dateFrom'){ data = $(element).val().split('/')[2] + '-' + $(element).val().split('/')[1] + '-' + $(element).val().split('/')[0] + ' 00:00:00' }
            if(type == 'dateTo'){ data = $(element).val().split('/')[2] + '-' + $(element).val().split('/')[1] + '-' + $(element).val().split('/')[0] + ' 23:59:59' }
            if(type == 'integer'){ data = parseInt($(element).val()); }
            if(type == 'float'){ data = parseFloat($(element).val()); }
            if(type == 'string'){ data = $(element).val(); }
            DataTableHelper.filters[$(element).data().filter] = data;
            DataTableHelper.updateTable()
        }
    },

    resetFilters : function(){
        DataTableHelper.filters = [];
        DataTableHelper.values = {};
        DataTableHelper.updateTable();
        $(".datatable-filter").each(function(index, element) {
            $(element).val(0);
         });
    },
    updateTable : function(){
        for(var key in DataTableHelper.filters){ if(DataTableHelper.filters.hasOwnProperty(key)){ DataTableHelper.values[key] = DataTableHelper.filters[key]; } }
        DataTableHelper.table.ajax.reload();
    }
};
