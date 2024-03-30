
   <script>
       DataTableHelper.initDatatable('#datatable', [0, 'desc'], 'POST', '{{ adminUrl('modal-news/list') }}', [
                {
                    title: 'ID',
                    data: 'id',
                    render: function(data, type, row)
                    {
                        let html = `${data}`
                        return data ? html : "";
                    }
                },
                {
                    title: 'Title',
                    data: 'title',
                    render: function(data, type, row)
                    {
                        let html = `${data}`
                        return data ? html : "";
                    }
                },
                {
                    title: 'Description',
                    data: 'description',
                    render: function(data, type, row)
                    {
                        return data ? data : "";
                    }
                },
                {
                    title: 'From / To',
                    data: 'from',
                    render: function(data, type, row)
                    {
                        let from = data ? moment(data).format('YYYY-MM-DD') : "";
                        let to = row.to ? moment(row.to).format('YYYY-MM-DD') : "";
                        let html = `${from} / ${to}`
                        return data ? html : "";
                    }
                },
                {
                    title: 'Active',
                    data: 'active',
                    sWidth:1,
                    render: function(data, type, row)
                    {
                        let status = data ? "checked" : "";
                        let html = `<input onclick="modalNewStatus(${row.id}, ${row.active})" style="width:30px; height:30px;" type="checkbox" ${status}>`
                        return html;
                    }
                },
                {
                    title: 'Edit',
                    data: 'id',
                    sWidth:'1px',
                    orderable: false,
                    render: function(data, type, row)
                    {
                        let  html = '<a href="{{ adminUrl('modal-news') }}/'+ data +'/edit" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>';
                        return data ? html : "";
                    }
                },
                {
                    title: 'Del',
                    data: 'id',
                    sWidth:'1px',
                    orderable: false,
                    render: function(data, type, row)
                    {
                        let  html = '<button onclick="DataTableHelper.deleteRecord(\'{{ adminUrl('modal-news') }}/'+ data +'\')" class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-remove"></i></button>';
                        return data ? html : "";
                    }
                },
            ],
            false,
            [{width:20, searchable: false, targets: [0]}]);

            function modalNewStatus(id,active){
                $.ajax({
                    url: '/justadmin/modal-new-status',
                    type: 'POST',
                    data: {
                        id: id,
                        active:active
                    },
                    success: function(response) {
                        DataTableHelper.updateTable()
                    },
                    error: function(response) {
                        console.log('Error:', response);
                    }
            });
        }

    </script>