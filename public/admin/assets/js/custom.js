

$(document).ajaxStart(function () {
    $("#loading-animation").css("display", "block");
});

$(document).ajaxStop(function () {
    $("#loading-animation").css("display", "none");
});

function checkbox(event){
    var element = event.target;
    if(element.checked){
        element.value = 1;
    }else{
        element.value = 0;
    }
}

function checkFilter(e, string, input) {
    let inputFilters = ['query_string', 'referrer'];
    
    if(e.target.checked == false){
        $('.' + input).val('').trigger('change')
    }else{
        $('input[type="checkbox"]').each(function () {
            if ($(this).attr('id') !== $(e.target).attr('id')) {
                $(this).prop('checked', false);
            }
        });
        inputFilters.forEach(function (inputFilter) {
            if (inputFilter !== input) {
                $('.' + inputFilter).val('');
            }else{
                 $(`.${input}`).val(string);
            }
        });
       

        inputFilters.forEach((inputFilter) => {
            $(`.${inputFilter}`).trigger('change')
        })
    }
}

function groupBy(){
    let groupBy = document.getElementById('group').value;
    const encodedGroupBy = encodeURIComponent(groupBy);
    window.location.pathname = `/${admin_url}/group-log-reels?group_by=${encodedGroupBy}`;
}

checkMobile()
function checkMobile(){
    var isMobile = window.innerWidth < 767;
    document.querySelectorAll('.search_div').forEach(function(element) {
        element.classList.toggle('col-6', isMobile);
    });
}
checkMobile()
window.addEventListener('resize', function() {
    checkMobile()
});
async function Comment(model_id, model){
                
    let comment = document.getElementById(`textarea-${model_id}`).value;
    
    document.getElementById(`textarea-${model_id}`).value = ""
   
    const url = `/${admin_url}/comment`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const headers = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken
    };
    const data = {
    data: {
        model_id,
        model,
        comment,
    }
    
    };
    try {
    const response = await fetch(url, {
        method: 'POST',
        headers,
        body: JSON.stringify(data),
    });
    
        const responseData = await response.json();
        const datatableComment = $('#datatable_comment').DataTable();
        datatableComment.ajax.reload();
    } catch (error) {
        console.error(error);
    }
}

function createModal(data, model){
    return `
                <button type="button" style="height:60%; margin-left:5px;" class="btn btn-primary btn-open-modal" data-toggle="modal" data-target="#comment_${data}">
                    Comment
                </button>
                <div class="modal fade" id="comment_${data}" tabindex="-1" role="dialog" aria-labelledby="commentLabel_${data}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="commentLabel_${data}">Comment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                              
                                <textarea  id="textarea-${data}" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                
                                <button type="button" class="btn btn-primary btn-save-comment" data-dismiss="modal" data-id="${data}" onclick="Comment(${data},'${model}')">
                                    Comment
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `

}


function createCommentTable(model, model_id, isAdmin){

    var columns = [
        { 
            title: 'ID',
            data: 'id', render: function(data, type, row)
            {
                return data ? data : "";
            } 
        },     
        {
            title: 'Role',
            data: 'user_roles',
            render: function(data, type, row){
                return data ? data : "";
            }
        },
        {
            title: 'User Name',
            data: 'user.name',
            render: function(data, type, row){
                return data ? data : "";
   
            } 
        },
        {
            title: 'Comment',
            data: 'comment',
            render: function(data, type, row){
                return data ? data : "";
   
            } 
        },

    ]
    if(isAdmin){
        columns.push({
        title: 'IP Address',
        data: 'ip',
        render: function(data, type, row) {
            return data ? data : "";
        }
    });

    columns.push({
    title: 'Created At',
    data: 'created_at',
    render: function(data, type, row){
        return moment(data).format('YYYY-MM-DD HH:mm');

        } 
    });
    
    }


       DataTableHelper.initDatatable('#datatable_comment', [0, 'desc'], 'POST', `/${admin_url}/comment/list/${model}/${model_id}`,
       columns,
       false,
       [
        {
            width:20,
            searchable:
            false, targets: [0]
        }
    ]);


    
}
   


let User = {
    url : `/${admin_url}/api/roles/role_id/permissions`,
    config : {
        parentSelector : '.permissions_group',
        rolesSelector : '#kt_select2_1',
    },
    // Public functions
    checkPermissionsByRole : function (){
        let role_id = User.config.selectedRoleId;
        $(User.config.parentSelector+' '+'.checkbox input').prop('checked', false);

        let APIurl = User.url.replace('role_id', role_id);
        if(role_id.length != 0){
            
            $.get(APIurl, {}, function (data){

                let rolePermissions = JSON.parse(data);

                rolePermissions.forEach(item => {
                    $(User.config.parentSelector+' '+'.checkbox input[value="'+item+'"]').prop('checked', true);
                });
            });

        }
    }
};



var category_values = category_values ? category_values : '{}'



var toParseHtmlElement = document.createElement("div");

function parseHtmlTags(text){
    
    toParseHtmlElement.innerHTML = text;
    let result = toParseHtmlElement.textContent || toParseHtmlElement.innerText || "";
    toParseHtmlElement.innerHTML = ''
    return result;
}


function escapeHtml(text) {
    if(text){
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
}

window.getCookie = function(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
        c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
        }
    }
    return "";
}
  
  
window.setCookie = function(cname, cvalue, exdays = 7){
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

window.deleteCookie = function(name) {
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}


function closeAllSummernotes(){


    let element = $('.document-section-component');
    let current_hidden_summernote = element.find('.hidden-summernote');
    current_hidden_summernote.toggleClass('show-summernote');

    element.addClass('edit-mode-false').removeClass('edit-mode-true');
    element.find('.button-panel').hide();
    element.find('.note-resizebar').hide();
    element.find('.note-statusbar').hide();
        element.find('.note-frame').attr("class","note-editor note-frame card border-0");
        element.find('.crd-hdr-border').css('border-bottom','none');
    //document.querySelector(".note-resizebar").style.display = "none";
    //document.querySelector(".note-statusbar").style.display = "none";
    current_hidden_summernote.next().find('.note-toolbar.card-header').hide();
    // current_hidden_summernote.next().find('.note-editable.card-block').attr('class', 'false');


    element.find('.section-input').attr('contenteditable', false);
    element.find('.note-editable').attr('contenteditable', false);
}


function toFormData(obj){
    let result = new FormData();
    for(let key in obj){
        if(obj.hasOwnProperty(key)){  
            result.append(key, obj[key]);
        }
    }
    return result;
}

// url, methodType = 'POST', callback = null
function customAjax(settings){
    let data = settings.data && typeof settings.data === 'object' &&  settings.data !== null ? toFormData(settings.data) : null;
    
    // if(data instanceof FormData){
    //     data.append('_token', _token);
    // }else{
    //     data['_token'] = _token;
    // }
    
    var xhr = new XMLHttpRequest();
    xhr.open(settings.type, settings.url, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', _token);
    xhr.send(data);
    xhr.onreadystatechange = function(){
        if (xhr.readyState === 4 && xhr.status === 200){
            if (typeof settings.callback === "function") {
                settings.callback(xhr.responseText);
            }
        }
    }
}

$(document).ready(function(){

    

    window.addEventListener('click', function(e){
    
        let editableMode = typeof editMode !== 'undefined' ? editMode : false;
        let target = $(e.target);
        
    
    
        if(!target.closest('.document-section-component').length && editableMode){
            
            closeAllSummernotes();
        }
        
    
    })



    $(User.config.parentSelector+" "+User.config.rolesSelector).change(function(ev){
        User.config.selectedRoleId = $(this).val();
        User.checkPermissionsByRole();
    });




    if($('#global-kt-tree').length){

        
        $('#global-kt-tree').on('move_node.jstree', function(e, data){
           
            // $.ajax({
            //     url: '/api/categories/UpdateParentAndPosition',
            //     type: 'PUT',
            //     data: {
            //         'data': data,
            //     },
            //     success: function(response) {
            //       
            //     },
            //     error: function(response) {
            //        

            //     },
            // });
            let target = $(this).data('target'); // categories, taxonomies, threats, vulnerabilities

            customAjax({
                url: '/api/'+target+'/UpdateParentAndPosition',
                type: 'POST',
                data: {
                    id: data.node.id.split('-')[1],
                    old_position: data.old_position,
                    position: data.position,
                    old_parent: data.old_parent.split('-')[1],
                    parent: data.parent.split('-')[1],
                },
                callback: function(response){
                   
                }
            });
            // var xhr = new XMLHttpRequest();
            // xhr.open('PUT', '/api/categories/UpdateParentAndPosition', true);
            // xhr.send();
            // xhr.onreadystatechange = function(){
            //     if (xhr.readyState === 4 && xhr.status === 200){
            //     }
            // }
            

        })
        // .on('selecat_node.jstree', function (e, data) { 
        //         let host_url = window.location.origin;
        //         let id = data.node.id.split('-')[1];
        //         document.location.href = host_url+"/categories/"+id;

                
        // })
        .jstree({
            "core": {
                "themes": {
                    "responsive": false,
                    "icons":false
                },
                // so that create works
                "check_callback": true,
                "data": window.mainJsonTree ?? null
            },
            "types": {
                "default": {
                    "icon": "fa fa-folder text-primary"
                },
                "file": {
                    "icon": "fa fa-file  text-primary"
                }
            },
            "state": {
                "key": "demo2"
            },
            "plugins": ["dnd",  "state", "types"]
        });
       
            $(document).on('click', '#global-kt-tree .jstree-anchor', function(e) {
                // let host_url = window.location.origin;
                let host_url = window.location.href;
                let id = $(this).closest('li').attr('id').split('-')[1];
               document.location.href = host_url+"/"+id;
        });

    }

    if($('#kt_tree_4').length){



        $('#kt_tree_4').jstree({
            "core": {
                "themes": {
                    "responsive": false,
                    "icons":false
                },
                // so that create works
                "check_callback": true,
                "data": window.leftMenuJsonTree
            },
            "types": {
                "default": {
                    "icon": "fa fa-folder text-primary"
                },
                "file": {
                    "icon": "fa fa-file  text-primary"
                }
            },
            "state": {
                "key": "demo2"
            },
            "plugins": ["state", "types"]
        });

        $(document).on('click', '#kt_tree_4 a.jstree-anchor', function(){
            let id = $(this).closest('li').attr('id');
            id = id.split('-')[1];

            
            if(id){
                $('html, body').animate({
                    scrollTop: $('div#section-content-'+id).offset().top - 200
                }, 1000);
            }
        });

        let timeOut, blurTimeout;


        // let published = window.published;
        $('.section-input').on('keyup', function(){
            
           
            if(published){
                return;
            }

            clearTimeout(timeOut);
            let that = this;
            timeOut = setTimeout(function(){
                let val = $(that).text().trim(); //$(that).val();
                let id = $(that).closest('.card').attr('id').split('-')[2];
                $.ajax({
                    url: '/api/sections/'+id+'/UpdateSectionName',
                    type: 'PUT',
                    data: {
                        'name': val,
                        'id': id,
                    },

                    success: function(response) {

                        if(typeof response.success !== "undefined"){
                            let data = response.data;
                            let target = $('#kt_tree_4 li#section-'+data.id).find('a.jstree-anchor');

                             let i_element = $('<div>').append(target.find('i').clone()).html();

                            target.text('');
                            target.append(i_element);
                            target.append(document.createTextNode(data.new))
                        }

                       
                    },
                    error: function(response) {
                        

                    },
                });

            },1500);
        });


        $('.section_log_comment').on('blur', function () {
           



            clearTimeout(timeOut);
            let that = this;
            timeOut = setTimeout(function(){
                let val = $(that).val().trim(); //$(that).val();
                let id = $(that).closest('tr').data('log-id');
               
                $.ajax({
                    url: '/api/sections/'+id+'/UpdateSectionLogComment',
                    type: 'PUT',
                    data: {
                        'comment': val,
                        'id': id,
                    },

                    success: function(response) {

                      
                    },
                    error: function(response) {
                       

                    },
                });

            },1500);



        });


        $('.section-input').on('blur', function(){
            if(!published){
                return;
            }

            clearTimeout(blurTimeout);
            let that = this;
            blurTimeout = setTimeout(function(){
                let val = $(that).text().trim(); //$(that).val();
                let id = $(that).closest('.card').attr('id').split('-')[2];
                
                $.ajax({
                    url: '/api/sections/'+id+'/UpdateSectionName',
                    type: 'PUT',
                    data: {
                        'name': val,
                        'id': id,
                        'published': published,
                        'document_id': window.documentID,
                    },

                    success: function(response) {

                        if(typeof response.success !== "undefined"){
                            let data = response.data;
                            let target = $('#kt_tree_4 li#section-'+data.id).find('a.jstree-anchor');

                             let i_element = $('<div>').append(target.find('i').clone()).html();

                            target.text('');
                            target.append(i_element);
                            target.append(document.createTextNode(data.new))
                        }

                       
                    },
                    error: function(response) {
                       

                    },
                });

            },1500);
        })

       

        
                  
        $('.section-textarea').summernote({
            callbacks: {
                onKeyup: function(e) {
                    if(published){
                        return;
                    }

                    clearTimeout(timeOut);
                    let that = this;
                    timeOut = setTimeout(function(){
                        
                        // let val = $(that).html(); 
                        let val = $(e.target).html();

                        let id = $(that).closest('.card').attr('id').split('-')[2];
                       
                        $.ajax({
                            url: '/api/sections/'+id+'/UpdateSectionText',
                            type: 'PUT',
                            data: {
                                'text': val,
                                'id': id,
                                'document_id': window.documentID,
                            },
        
                            success: function(response) {
        
                               
                            },
                            error: function(response) {
                                
        
                            },
                        });
        
                    },1500);
             
                },
                onBlur: function(e){
                    if(!published){
                        return;
                    }
                    

                    // return;
                    clearTimeout(blurTimeout);
                    let that = this;
                    blurTimeout = setTimeout(function(){
                        
                        // let val = $(that).html(); 
                        let val = $(e.target).html();
                        let id = $(that).closest('.card').attr('id').split('-')[2];
                        
                        $.ajax({
                            url: '/api/sections/'+id+'/UpdateSectionText',
                            type: 'PUT',
                            data: {
                                'text': val,
                                'id': id,
                                'published': published,
                                'document_id': window.documentID,
                            },
        
                            success: function(response) {
        
                            },
                            error: function(response) {

        
                            },
                        });
        
                    },1500);

                }
            }

        });

        


        $('.submit-add-subsection').on('click', function(){
            $('#skeleton-modal').modal('toggle');
            let parent_id = $(this).closest('.card').attr('id').split('-')[2];
            let str = '';

            if(window.controls && typeof window.controls === 'object'){
                window.controls.forEach(function (control) {
                    str += `<option value="${control['id']}">${control['name']}</option>`
                })
            }

            skeletonModal(
                `Add Subsection`,
                `<div>
                    <form id="add-subsection-form" action="/document-sections" method="POST">

                        <input type="hidden" name="document_id" value="${window.documentID}"></input>
                        <input type="hidden" name="parent_id" value="${parent_id}"></input>
                        <input type="hidden" name="_token" value="${window._token}"></input>

                        <select class="form-control mb-3" id="control_id" name="control_id">
                            <option value="" disabled selected hidden>Select control</option>
                            ${str}


                        </select>

                        <input name="name"   class="form-control" placeholder="Enter name" ></input>
                        <textarea class="summernote" name="text"></textarea>
                    </form>
                </div>
                `,
                '<button class="btn btn-default btn-success submit-subsection-add" onclick="$(\'#add-subsection-form\').submit()">Submit</button>'
            );

            $('.summernote').summernote();
        });






        $('#toggle-actions-modal').on('click', function(){
            $('#actions-modal').modal('toggle');
        })

        $(document).on('click', '.show-log-details', function(){
            $('#skeleton-modal').modal('toggle');

            let id = $(this).closest('tr').data('log-id');

            $.ajax({
                url: '/api/sections/'+id+'/details',
                type: 'GET',
                async: false,
                data: {
                },
                success: function(result) {

                    let inner_data = '';
                    if(typeof result.data !== "undefined"){

                        result.data.forEach(function(log){
                            inner_data += `<tr data-log-id="${log['id']}">
                            <th scope="row">${log['log_version']}</th>
                            <td>${log['user']['name']}</td>
                            <td>${log['name']}</td>
                            <td>${log['text']}</td>
                            <td>${log['comment'] ?? ''}</td>
                            <td>${log['created_at']}</td>
                            

                        </tr>`

                        })
                    }

                    skeletonModal(`Section Details`, `

                    <div class="row" style="margin-top: 30px">

                    <div class="col-md-12">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Document changes Log</h3>
                                </div>
                            </div>
                            <div class="card-body">
        
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Log Version</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Text</th>
                                            <th scope="col">Comment</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${inner_data}
                                    </tbody>
                                </table>
        
                            </div>
                        </div>
                    </div>
                </div>


                    `, ``, {size: 'xl'});
   
                }
            })

        })

        // $('.add-section').on('click', function(){
        //
        //     let parent_id = $(this).closest('.document-section-component').attr('id').split('-')[2];
        //
        //
        //     let data = {
        //         'default_add': true,
        //         'before_id': parent_id,
        //         '_token': window._token,
        //         'document_id': window.documentID,
        //     };
        //
        //     // $.ajax({
        //     //     url: '/document-sections',
        //     //     type: 'POST',
        //     //     async: false,
        //     //     data: data,
        //     // })
        //
        //     $.post('/document-sections', data, function() {
        //         // do call back
        //     });
        //
        // })

        $('.note-resizebar').hide();
        $('.note-statusbar').hide();


        $('#toggle-content-editable').on('click', function(){
            $(this).text(editMode ? 'Edit' : 'Disable Edit Mode');
            editMode = !editMode;

            if(!editMode){
                closeAllSummernotes();
                // $('.note-editable').attr('contenteditable', 'false');
            }

            setCookie('edit_mode', editMode);
            
        })

        $('.document-section-component').on('click', function(){
            if(!editMode){
                return;
            }
            
            
            // $('.hidden-summernote').toggleClass('show-summernote');

            let element = $(this);
            let current_hidden_summernote = element.find('.hidden-summernote');
            current_hidden_summernote.toggleClass('show-summernote');
            let is_editable = element.hasClass('edit-mode-true') ? true : false;

            
            if(is_editable){

                

            }else{

                closeAllSummernotes();
                
               
                element.addClass('edit-mode-true').removeClass('edit-mode-false');
                element.find('.button-panel').show();
                element.find('.note-resizebar').show();
                element.find('.note-statusbar').show();
                element.find('.note-frame').attr("class","note-editor note-frame card");
                //document.querySelector(".note-resizebar").style.display = "block";
                // document.querySelector(".note-statusbar").style.display = "block";
                element.find('.crd-hdr-border').css('border-bottom','1px solid #d3d3d3');
                current_hidden_summernote.next().find('.note-toolbar.card-header').show();
                current_hidden_summernote.next().find('.note-editable.card-block').attr('contenteditable', 'true');


                

                element.find('.section-input').attr('contenteditable', true);
                element.find('.note-editable').attr('contenteditable', true);

                

            }

            

            
        })




    }


    $('.global-summernote').summernote();
    $('.hidden-summernote').next().find('.note-toolbar.card-header').hide();
    $('.hidden-summernote').next().find('.note-editable.card-block').attr('contenteditable', 'false');
});






// edit section


$('.edit-subsection').on('click', function(){
    $('#skeleton-modal').modal('toggle');
    let parent_id = $(this).closest('.card').attr('id').split('-')[2];
    let section_name = $(this).closest('.card').find('.section-input').text().replace(/\s\s+/g, '');
    let section_description = $(this).closest('.card').find('.section-textarea').html();
    let section_id = $(this).closest('.card').find('.section_id').val();


    let control_id;
    let APIurl = `/api/sections/${section_id}/loadJsonData`;
    $.get(APIurl, {}, function (response){
        
        if(response.success){
            control_id = response.data.control_id ?? null;
           

            
            let str = '';

            if(window.controls && typeof window.controls === 'object'){
                window.controls.forEach(function (control) {
                    
                    let selected = control_id == control['id'] ? ' selected="selected"' : '';
                    str += `<option value="${control['id']}"${selected}>${control['name']}</option>`
                })
            }

            skeletonModal(
                `Edit Section`,
                `<div>
            <form id="edit-section-form" action="/document-sections/${section_id}" method="POST">
                <input type="hidden" name="_method" value="put" />

                <input type="hidden" name="document_id" value="${window.documentID}"></input>
                <input type="hidden" name="parent_id" value="${parent_id}"></input>
                <input type="hidden" name="_token" value="${window._token}"></input>


               <select class="form-control mb-3" id="control_id" name="control_id">
                    <option value="" disabled selected hidden>Select control</option>
                    ${str}
               </select>
            </form>
        </div>
        `,
                '<button class="btn btn-default btn-success submit-subsection-edit" onclick="$(\'#edit-section-form\').submit()">Submit</button>'
            );

            $('.summernote').summernote();

        }

    });


});


function skeletonModal(title = '', content = '', buttons = '', settings = {}){
    resetSkeletonModal();
    $('#skeleton-modal #skeleton-modal-label').text(title);
    $('#skeleton-modal #skeleton-modal-content').html(content);
    $('#skeleton-modal #skeleton-modal-footer').html(buttons);

    if(settings.size){
        $('#skeleton-modal .modal-dialog').toggleClass(settings.size === 'big' ? 'modal-lg' : settings.size === 'small' ? 'modal-sm' : settings.size === 'xl' ? 'modal-xl' : '');
    }
  }

  function resetSkeletonModal(){
    $('#skeleton-modal #skeleton-modal-label').text('');
    $('#skeleton-modal #skeleton-modal-content').html('');
    $('#skeleton-modal #skeleton-modal-footer').html('');
    $('#skeleton-modal .modal-dialog').removeClass('modal-lg modal-sm modal-xl');
  }





function getParentDetals() {


    let selected_id = $("#parent_id option").filter(":selected").val();


    let APIurl = '/api/controls/'+selected_id+'/details';
    $.get(APIurl, {}, function (data){


        let number = 1;
        let control_number = "";
        let result = JSON.parse(data);

        if (result.success) {
            number += result.data.children_count;
            control_number = result.data.number+"."+number;

            $('#control_number').val(control_number)
        }


    });
}

function getAssetDetails() {

    let selected_assets = $("#kt_select2_3").val();

    if (selected_assets.length == 0) {

        $('#confidentialities').val(0)
        $('#integrities').val(0)
        $('#availabilities').val(0)

    }
    let assets_string;

    let APIurl = '/api/assets/'+selected_assets+'/details';

    assets_string =  selected_assets.join(',');

    $.get(APIurl, {selected_assets: selected_assets}, function (data){


        let result = JSON.parse(data);

        if (result.success) {
            confidentiality_id = result.data.confidentiality_id
            integrity_id = result.data.integrity_id
            availability_id = result.data.availability_id

            $('#confidentialities').val(confidentiality_id)
            $('#integrities').val(integrity_id)
            $('#availabilities').val(availability_id)

        }


    });


}


function checkboxAlreadyExist(container, item_id) {

    let result = 0;

    $('#'+container+' input').each(function() {
        if (this.value == item_id) {
            result ++;
        }
    });

    if (result) {
        return true;
    } else {
        return false;
    }
}

function cardAlreadyExist(container, item_id) {

    let result = 0;

    $('#'+container+' .card  #card_element_id').each(function() {
        if (this.value == item_id) {
            result ++;
        }
    });

    if (result) {
        return true;
    } else {
        return false;
    }
}




function appendCheckbox(selector_name, element) {
    $('#'+selector_name+'_checkboxes').append(`
        <label class="checkbox">
            <input checked type="checkbox" onchange="removeCheckboxEvent(this)" value="`+element.id+`" name="`+selector_name+`[]" />
            <span> </span>&nbsp;
            `+element.name+`
        </label>
    `)
}



function appendCheckboxWithInput(selector_name, element) {
    

    $('#'+selector_name+'_checkboxes').append(`
    <div class="card mt-5 removeCard" data-unit-id="${element.id}">
        <input type="hidden" name="control_id_reduce[`+count_control_cards+`][id]" id="card_element_id" value="`+element.id+`">

        <div   class=" card-body pt-2 removeDiv ">

                <div class="pt-3" style="flex:1">
                    `+element.name+`
                </div>

                ${element.status_name ? `<div style="color:${element.status_color}" class="pt-3">
                    ${element.status_name}
                </div>` : ''}




        </div>
        <div class="pt-2" style="display:flex">
            <input class="form-control" placeholder="Comment" id="ci" type="text" name="control_id_reduce[`+count_control_cards+`][comment]" >

            <div class="controlButtons" style="flex:1">
                <div>
                    <button data-control-id="`+element.id+`" data-toggle="modal" data-target="#exampleModalLong" type="button" class="btn btn-light tasks_btn" style="width:80px"><span class="tasks_count_span_control_`+element.id+`">`+element.tasks_count+`</span> Tasks</button>
                </div>
                <div>
                    <div onclick="removeCheckboxWithInput(this)" class="btn"><i class="fa fa-trash"></i></div>
                </div>
            </div>

        </div>
    </div>
    `)

}

function removeCheckbox(checkbox) {
    checked = $(checkbox).prop('checked');
    if (checked == false) {
        checkbox.closest('.checkbox').remove();
    }
}
function removeCheckboxWithInput(trash) {

    trash.closest('.removeCard').remove();

    count_control_cards--;
    if (count_control_cards < 0 ) {
        count_control_cards = 0;
    }

  
}

function getAssetForRisks() {
    $("#threats_checkboxes").empty();
    $("#vulnerabilities_checkboxes").empty();
    let selected_id = $("#asset_id option").filter(":selected").val();

    let APIurl = '/api/risks/'+selected_id+'/details';
    $.get(APIurl, {}, function (data){

        let result = JSON.parse(data);

        if (result.success) {

            result.data.threats.forEach(element => {
                if (!checkboxAlreadyExist('threats_checkboxes',element.id)) {
                    appendCheckbox('threats',element);
                }
            });

            result.data.vulnerabilities.forEach(element => {
                if (!checkboxAlreadyExist('vulnerabilities_checkboxes',element.id)) {
                    appendCheckbox('vulnerabilities',element);
                }
            });
        }
    });

}



function AddThreatCheckbox() {

    let selected_id = $("#threat_id option").filter(":selected").val();
    let selected_text = $("#threat_id option").filter(":selected").text();

    let element = {
        id:selected_id,
        name: selected_text
    }


        if (selected_id && !checkboxAlreadyExist('threats_checkboxes',selected_id)) {
            appendCheckbox('threats', element);
        }

}

let task_count_by_control = 0;


function getTaskCountByControl(control_id = null, risk_id = null, is_risk_project = null) {
    console.log('@@@@@@@ function getTaskCountByControl(control_id = null, risk_id = null, is_risk_project = null) {');
    let response = null;

    console.log('control_id', control_id);
    console.log('risk_id', risk_id);
    console.log('is_risk_project', is_risk_project);

    let url = `/api/tasks/${control_id}/details`;
    $.ajax({
        url: url,
        type: 'GET',
        async: false,
        data: {
            'control_id': control_id,
            'risk_id': risk_id,
            'is_risk_project': is_risk_project
        },

        success: function(result) {
            parsed_result = JSON.parse(result)
            

            console.log('parsed_result', parsed_result);
            task_count_by_control = parsed_result.data.tasks_count

            response = parsed_result;

        },
        error: function(result) {

        },
    });
    return response;
}


function AddControlCheckbox(select_id = null) {

    let selected_id = select_id ? select_id : $(control_box+" option").filter(":selected").val();
    let current_risk_id = $("#risk_id").val();


    let response = getTaskCountByControl(selected_id,current_risk_id), data;

    console.log('response************',response);
    if(typeof response !== "undefined" && typeof response.success !== "undefined" && response.success === true && typeof response.data !== "undefined"){
        data = response.data;
        console.log('data************',data);

    }
    
    let tasks_count = response.tasks_count;


    if(data){
        // console.log('data#############', data);
        let element = {
            id: data.control_id,
            name: data.control?.name,
            status_name: data.control?.control_statuses?.name,
            status_color: data.control?.control_statuses?.color,
            tasks_count: data.tasks_count,
        }
    
        if (selected_id && !cardAlreadyExist('controls_checkboxes',selected_id)) {
            appendCheckboxWithInput('controls', element);
    
            count_control_cards ++;
        }
    }
    

}



function AddVulnerabilitiesCheckbox() {

    let selected_id = $("#vulnerability_id option").filter(":selected").val();
    let selected_text = $("#vulnerability_id option").filter(":selected").text();

    let element = {
        id:selected_id,
        name: selected_text
    }

        if (selected_id && !checkboxAlreadyExist('vulnerabilities_checkboxes',selected_id)) {
            appendCheckbox('vulnerabilities', element);
        }

}



function deleteRiskFromRiskProject(risk_id, asset_id) {


    // console.log(risk_id)
    let risk_project_id = $("#risk-project-id-hidden").val();
    // let risk_id = $(this).data('risk-id-del');

    let APIurl = '/api/risks/'+risk_id+'/'+risk_project_id+'/'+asset_id+'/delete';
    // $.get(APIurl, {}, function (data){

    //     let result = JSON.parse(data);

    //     if (result.success) {

    //     }
    // });

    $.ajax({
        url: APIurl,
        type: 'DELETE',
        data: {
            'risk_id': risk_id,
            'risk_project_id': risk_project_id,
            'asset_id': asset_id,

        },

        success: function(result) {

            result = JSON.parse(result)
            loadAllRisks(asset_id);


        },
        error: function(result) {


        },
    });

}
function controlSelectorColorize(e){
    

    let selectedColor = $(e).find(':selected').data('status-color')
    $(e).css('background-color', selectedColor);
 }

function UpdateControlStatus(control_id,e) {
   
    // controlSelectorColorize(e);
    let selected_id = document.getElementById('control_status_id_'+control_id).value;
    // let control_id = $("#control_status_id").closest('tr').data('control-id');
    
    

    let APIurl = '/api/controls/'+control_id+'/'+selected_id+'/UpdateControlStatus';




    $.ajax({
        url: '/api/controls/'+control_id+'/UpdateControlStatus',
        type: 'PUT',
        data: {
            'control_id': control_id,
            'selected_id': selected_id,

        },

        success: function(result) {

            parsed_result = JSON.parse(result)

        },
        error: function(result) {


        },
    });

}


function updateUser(table_name, column_id) {
   
    let selected_id = document.getElementById('column_id_'+column_id).value;
    let APIurl = '/api/'+table_name+'/'+column_id+'/'+selected_id+'/updateUser';


    $.ajax({
        url: APIurl,
        type: 'PUT',
        data: {
            'column_id': column_id,
            'selected_id': selected_id,
            'table_name': table_name,

        },

        success: function(result) {

            parsed_result = JSON.parse(result)

        },
        error: function(result) {
            console.log("error", result)

        },
    });

}



function getTasksWithControls(control_id, risk_id = null) {
    // let appendRiskId = risk_id !== null ? '/'+risk_id : '';
    let appendRiskId = risk_id ? '/'+risk_id : '';

    let APIurl = '/api/tasks/control/'+control_id + appendRiskId;
    $.get(APIurl, {}, function (data){


        let result = JSON.parse(data);

        if (result.success) {
            $('.tasks-tbody').empty();
            result.data.task_items.forEach(element => {

                appendTableTr('tasks-tbody', element);
                // $('#exampleModalLong').on('hidden.bs.modal', function () {
                //     location.reload();
                // }); //WARNING: THIS CAUSES MODAL TO RELOAD

            });

        }


    });
}

function getTasksWithRiskProjects(risk_project_id) {
    // let appendRiskId = risk_id !== null ? '/'+risk_id : '';

    let APIurl = '/api/tasks/risk-project/'+risk_project_id;
    $.get(APIurl, {}, function (data){


        let result = JSON.parse(data);

        if (result.success) {
            $('.tasks-tbody').empty();
            result.data.task_items.forEach(element => {

                appendTableTr('tasks-tbody', element);
                // $('#exampleModalLong').on('hidden.bs.modal', function () {
                //     location.reload();
                // }); //WARNING: THIS CAUSES MODAL TO RELOAD

            });

        }


    });
}




function appendTableTr(selector_name, element) {
    $('.'+selector_name).append(`
        <tr>
            <td>`+element.id+`</td>
            <td>`+element.name+`</td>
            <td>`+element.task_status.name+`</td>
            <td>
                <ul>`+
                $.map(element.responsible_persons, function(value) {

                  return value.name;
                })
                +`</ul>
            </td>
            <td>`+element.deadline+`</td>
            <td>`+element.standard+`</td>
            <td style="cursor:pointer;" onclick="deleteTask(`+element.id+`)">Delete</td>
        </tr>
    `);
    //<td style="cursor:pointer;" onclick="editTask(`+element.id+`)">Edit</td>
}

function deleteTask(task_id) {


    let APIurl = '/api/tasks/'+task_id+'/delete';


    $.ajax({
        url: APIurl,
        type: 'DELETE',
        data: {
            'task_id': task_id,
        },
        success: function(result) {
            parsed_result = JSON.parse(result)
        },
        error: function(result) {


        },
    });
}

function editTask(task_id) {

    let APIurl = '/api/tasks/'+task_id+'/loadFieldsForEdit';


    $.ajax({
        url: APIurl,
        type: 'PUT',
        data: {
            'task_id': task_id,
        },
        success: function(result) {
            parsed_result = JSON.parse(result)
            task = parsed_result.data.task[0];


            $('#name').val(task.name);
            $('#description').val(task.description);
            $('#priority_id').val(task.priority_id);
            $('.start_date').val(task.start_date);
            $('.deadline').val(task.deadline);
            $('.accountable_id').val(task.accountable_id);
            $('#standard').val(task.standard);
        },
        error: function(result) {


        },
    });
}


function deleteSweetAlert(e) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
        }).then((result) => {
        if (result.isConfirmed) {

            e.form.submit();
            swalWithBootstrapButtons.fire(

            'Deleted!',
            'Your file has been deleted.',
            'success'
            )
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your imaginary file is safe :)',
            'error'
            )
        }
        })
}






function loadAllRisks(asset_id = 0, withProject = true) {
    let url;
    let risk_project_id = $("#risk-project-id-hidden").val();

    console.log('CALLED loadAllRisks(asset_id = 0, withProject = true)');
    console.log('withProject', withProject);
    console.log('risk_project_id', risk_project_id);
    
    if(withProject){
        url = '/api/risk-projects/' + risk_project_id + '/assets/' + asset_id + '/risks';
    }else{
        url = '/api/risks/by-assets/'+asset_id;
    }
    
    console.log('url', url);

    $.ajax({
        url: url,
        type: 'GET',
        data: {
            'risk_project_id': risk_project_id,
            'asset_id': asset_id,
            '_token': ' {{ csrf_token() }} '
        },

        success: function(result) {

            parsed_result = JSON.parse(result)

            let risks = parsed_result.data.risks
            let assets = parsed_result.data.assets
            

            

            if (asset_id) {
                console.log('^^^^^^^^^^^^^^^^^^^^^generateAssets(assets)');
                generateAssets(assets)
            }

            console.log('withProject', withProject);
            if(withProject){

                console.log('CALLER OF generateProjectsRisks(risks)');
                generateProjectsRisks(risks)

                // let additional_table = $('.risks-tbody');
                // risks.forEach(element => {

                //     additional_table.append(`
                //         <tr>
                //             <td>`+element.name+`</td>
                //             <td>`+element.impact_name+`</td>
                //         </tr>
                //     `);
                // });
            }
            
        },
        error: function(result) {

            $('.show-alert').removeClass("alert alert-success");
            $('.show-alert').addClass("alert alert-danger");
            $('.show-alert').text('Error occurred')

        },
    });

}

function loadProjectProcess(process_id){
    let project_hidden_id = $("#risk-project-id-hidden").val();

    let url = '/api/risk-projects/' + project_hidden_id + '/processes/' + process_id + '/risks';
    $.ajax({
        url: url,
        success: function(response){
            console.log(response);

            let parsed_result = JSON.parse(response), units = null;

            if(parsed_result && parsed_result.data && typeof parsed_result.data.assets !== "undefined"){
                unit = parsed_result.data.assets;
            }


            let asset_html = "";


            if(unit){
                asset_html += `
                        <tr>
                            <td>ID</td>
                            <td>` + unit.asset.id + ` </td>
                        </tr>
                        <tr>
                            <td colspan="2"> <span> Name: </span> <br>`  + unit.asset.name + ` </td>
                        </tr>
                        <tr>
                            <td colspan="2"> <span> Description: </span> <br>` + unit.asset.description + ` </td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>` + unit.asset_category_name + ` </td>
                        </tr>
                `;



                $('.asset-details-tbody').html(asset_html);
            }
            



        },
        error: function(response){
            console.log(response);

            $('.show-alert').removeClass("alert alert-success");
            $('.show-alert').addClass("alert alert-danger");
            $('.show-alert').text('Error occurred')
        }
    })

}




function generateProjectsRisks(risks) {
    console.log('CALLED generateProjectsRisks(risks)');
    console.log('risks', risks);
    let risks_html = "";

    $.each(risks, function(index, value) {
        let status_style;
        if (value.impact_name == "low") {
            status_style = "label-light-success";
        } else if (value.impact_name == "medium") {
            status_style = "label-light-primary";
        } else if (value.impact_name == "high") {
            status_style = "label-light-warning"
        } else if (value.impact_name == "critical") {
            status_style = "label-light-danger"
        }
        
        risks_html += `
                    <tr>
                        <td> ${value.name ? value.name : value.taxonomy_name ? value.asset_name + " - "+ value.taxonomy_name : value.asset_name} </td>
                        <td class="risk-description-row">` + value.description + ` </td>
                        <td >` + value.asset_name + ` </td>
                        <td>
                            <span class="label label-inline ` + status_style + ` font-weight-bold">
                                ` + value.impact_name + `
                            </span>
                        </td>
                        <td>
                            <button data-risk-id-del="` + value.id + `" value="` + value.id + `"
                                id="delete-risk" onclick="deleteRiskFromRiskProject(` + value.id + `, ${value.asset_id})" class="btn btn-danger delete-risk">Delete</button>
                        </td>
                    </tr>
            `;

    });

    // console.log('risks_html', risks_html);

    $('#risk_list_tbody').html(risks_html);

}




function generateAssets(asset) {

    let asset_html = "";

    
        asset_html += `
                    <tr>
                        <td>ID</td>
                        <td>` + asset.asset.id + ` </td>
                    </tr>
                    <tr>
                        <td colspan="2"> <span> Name: </span> <br>`  + asset.asset.name + ` </td>
                    </tr>
                    <tr>
                        <td colspan="2"> <span> Description: </span> <br>` + asset.asset.description + ` </td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>` + asset.asset_category_name + ` </td>
                    </tr>
                    <tr>
                        <td>Personal data</td>
                        <td>` + asset.asset.personal_data + ` </td>
                    </tr>
            `;

    

    $('.asset-details-tbody').html(asset_html);

}


// add risks 
$('#add-risk-btn').on('click', function() {
    addRiskAjax();

});



function handleAjaxErrors(form, errors, button = null){
    if(typeof errors === "object" && errors !== null){
                
        for(let error in errors){
            if(errors.hasOwnProperty(error)){
                
                let danger_span = $(form+' input[name^="'+error+'"]').closest('.form-group').find('.text-danger').first();
                danger_span = danger_span.length ? danger_span : $(form+' select[name^="'+error+'"]').closest('.form-group').find('.text-danger').first()

                danger_span.append(`<span class="temporary-error">${errors[error][0]}</span>`);
                // console.log({
                //     'result.errors': result.errors,
                //     error: error,
                //     danger_span: danger_span,
                //     'danger_span.length': danger_span.length,
                // });
            }
        }

        if(button){ //#add_tasks_btn
            $(button).prop('disabled', true);
        }
            

        setTimeout(function(){

            if(button){ //#add_tasks_btn
                $(button).prop('disabled', false);
            }
            
            $('.temporary-error').remove();
        }, 5000)
    }
}




function addRiskAjax(return_risk = false){
    let form_inputs = $('#add-risk-form').serialize();
    let risk_project_id = $('#risk_project_id').val();

    let risk_item = null;

    $.ajax({
        url: '/risks',
        type: 'POST',
        data: form_inputs  + '&risk_project_id=' +  risk_project_id,        

        success: function(result) {
            // $('.close').click();
            // $(".modal").on("hidden.bs.modal", function(){
            //    $(this).find("input,textarea").val('').end();
            //    $('#add-risk-form').reset();
            //     $('.scale_color').attr('aria-pressed', 'false');
            //     $('.scale_color').css("background-color", "#ccc");

            // $('#selected_asset_id').val(asset_id);
            console.log('typeof redirectToProjectPage !== "undefined"');
            console.log(typeof redirectToProjectPage !== "undefined");
            if(typeof redirectToProjectPage !== "undefined" && redirectToProjectPage){

                if(return_risk){
                    console.log('result', result);
                    console.log('result.item', result.item);
                    risk_item = result.item ?? null;


                    return_risk[0].insert_id = risk_item.id;
                    return_risk[0].error = false;
                    return_risk[0].finished = true;
                    $('#risk_id[name="risk_id"]').val(risk_item.id)
                    console.log('risk_item in success:', risk_item);
                }

                if(typeof riskOnProjectFormFinished !== "undefined" && riskOnProjectFormFinished){
                    window.location.href = redirectToProjectPage;
                }
            }else{
                window.location.reload();
            }

            
            // });
        },

        error: function(result) {

            if(return_risk){
                return_risk[0].error = true;
                return_risk[0].finished = false;
            }
            
            result = result.responseJSON ?? result;

            
            if(typeof result.errors === "object" && result.errors !== null){
                
                for(let error in result.errors){
                    if(result.errors.hasOwnProperty(error)){
                        
                        let danger_span = $('input[name="'+error+'"]').closest('.form-group').find('.text-danger').first();
                        danger_span = danger_span.length ? danger_span : $('select[name="'+error+'"]').closest('.form-group').find('.text-danger').first()

                        danger_span.append(`<span class="temporary-error">${result.errors[error][0]}</span>`);
                        
                    }
                }

                $('#add-risk-btn').prop('disabled', true);
                setTimeout(function(){
                    $('#add-risk-btn').prop('disabled', false);
                    $('.temporary-error').remove();
                }, 5000)
            }
        },

    });

    

}


// format yyyy-mm-dd to mm/dd/yyyy
function customFormatDate(inputDate) {
    var date = new Date(inputDate);
    if (!isNaN(date.getTime())) {
        // Months use 0 index.
        return date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
    }
}



$(document).on('mouseover', '.has-tooltip', function(e) {
    // console.log('$(this)[0].scrollWidth', $(this)[0].scrollWidth);
	// console.log('$(this).innerWidth()', $(this).innerWidth());
    if ($(this).hasClass('tooltip-on-overflow')) {
        let el = $(this)[0];
        if(!(el.clientWidth < el.scrollWidth || el.clientHeight < el.scrollHeight)){
            return false;
        }
        
    }
      let text = $(this).attr('aria-label');
      let offset = $(this).offset();
      let width = $(this).outerWidth();
      let height = $(this).height();
  
      let tooltip = $('#custom_tooltip');
  
      tooltip.show();
      tooltip.find('.custom_tooltip-text').text(text);
      let span = tooltip.find('.custom_tooltip-text');
      let renderer = tooltip.find('.custom_tooltip_wrapper');
  
      if($(this).hasClass('tooltip-warning')){
        span.addClass('custom_tooltip-warning');
      }
      if($(this).hasClass('tooltip-light')){
        span.addClass('custom_tooltip-light');
      }
  
      let shift_left = 0;
      let distance = 7;
      if(renderer.outerWidth() > width){
        shift_left = (renderer.outerWidth() - width)/2;
      }else if(renderer.outerWidth() < width){
        shift_left = -((width - renderer.outerWidth())/2);
      }
      let left = offset.left - shift_left;
      let top = offset.top - renderer.outerHeight() - distance;
      tooltip.css({'left': left+'px', top:  top+'px'});
      
      let tooltipRect = tooltip[0].getBoundingClientRect();
      if(tooltipRect.top <= 0){
        // top += (height*2 + distance*2);
        top += (height + renderer.outerHeight() + distance*2);
        tooltip.css({top:  top+'px'});
      }
  
      if(Math.ceil(tooltipRect.left) + Math.ceil(renderer.outerWidth()) + 10 >= window.innerWidth){
        tooltip.css({left:  'auto', 'right': '0px'});
      }
  
      
      
  });
  $(document).on('mouseout', '.has-tooltip', function(e) {
      let tooltip = $('#custom_tooltip');
      tooltip.find('.custom_tooltip-text').text('');
      tooltip.find('.custom_tooltip-text').removeClass('custom_tooltip-warning').removeClass('custom_tooltip-light');
      tooltip.hide();
  });

  function repl(string) {
    string = string.replace(/[,./"!]/g, '');
    string = string.replace(/ {1,3}/g, '-');
    return string
}

  function copyReel(title, id) {
    let link = `https://wisdom.ge/${id}/${title}`
    var t = document.createElement("textarea");
    t.value = link;
    document.body.appendChild(t);
    t.select();
    navigator.clipboard.writeText(t.value).then(function() {
        document.body.removeChild(t);
        console.log("Text copied to clipboard");
    }).catch(function(error) {
        console.error("Unable to copy text to clipboard: ", error);
    });
}