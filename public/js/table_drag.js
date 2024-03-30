;(function($){

    let dragging_id = null, 
    floating_window_initialized = false,
    dragging_tr = false,
    temporary_full_html;
    
    window.table_drag = {};
    
    table_drag.drag = function(table_selector, data_id_name, url_for_reorder, success_callback = null){
    
        let tbl = table_selector,
        normal_tr = 'tr:not(.placeholder-tr)';
    
        if(!floating_window_initialized){
            floating_window_initialized = true;
            $('body').append(`<div id="floating-window" style="">
            <div id="container" style="display: block;
                position: absolute;
                top: 0;
                z-index:9999999999">
                <div id="renderer" class="content_body" style="display: flex;
                position: initial;
                flex-direction: initial;
                flex: 1;"></div>
            </div>
            </div>`);
            
        }
    
    
        $(document).on('mousedown', `${tbl} ${normal_tr} > td:first-child`, function(){
            if(dragging_tr) return;
            let tr = $(this).closest('tr');
            let tds = tr.find('td');
            dragging_tr = true;
            dragging_id = tr.data(data_id_name);
    
            temporary_full_html = $('<div>').append(tr.clone()).html();
            let el = '', td_cnt = 0, placeholder_tds = '';
            
            tds.each(function(){
                let padding = ($(this).innerWidth() - $(this).width())/2;
    
                el += `<div style="background:white;display:inline-flex;padding:${padding}px;width:${$(this).outerWidth()}px;height:${$(this).outerHeight()}px">${$(this).html()}</div>`;
                td_cnt++;
            });
            for(let i = 0; i < td_cnt; i++){
                placeholder_tds += `<td style=""><div style="background: #ccc;width: 100%;height: 20px;"></div></td>`;
            }
            tr.after(`<tr class="placeholder-tr" style="width: 100%;user-select:none;">${placeholder_tds}</tr>`);
            tr.addClass('dragging_hidden');
            tr.hide();
            $('#floating-window #renderer').html(el);
        });
    
        $(document).on('mouseup', '.placeholder-tr', function(){
            if(dragging_tr){
                $('.placeholder-tr').remove();
                $('.dragging_hidden').show();
                $('#floating-window #renderer').empty();
                dragging_tr = false;
            }
        });
        $(document).on('mouseup', `${tbl} ${normal_tr}`, function(e){
    
            let sectionHeight = $(this).height();
            let vertical = e.offsetY;
            let type = vertical > (sectionHeight/2) ? 'bottom' : 'top';
        
            if(dragging_tr){
                let unit_id = $(this).data(data_id_name);
                $('.placeholder-tr').remove();
                $('.dragging_hidden').remove();
                
                if(type === 'top'){
                    $(this).before(temporary_full_html);
                }else{
                    $(this).after(temporary_full_html);
                }
                $('#floating-window #renderer').empty();
                dragging_tr = false;

                $.ajax({
                    method: "POST",
                    url: `${url_for_reorder}/${dragging_id}`,
                    data: {target_id: unit_id, type: type},
                    dataType: 'json',
                    cache: false,
                    success: function(res){
                      if(success_callback){
                        success_callback(res);
                      }
                    }
                });
            }
    
        });
    
        $(document).on('mousemove', `${tbl} ${normal_tr}`, function(e){
            if(dragging_tr){
                let sectionHeight = $(this).height();
                let vertical = e.offsetY;
                $('.drag_here').css({'border-bottom': 'none','border-top': 'none' });
                $('drag_here').removeClass('drag_here');
                $(this).addClass('drag_here');
    
                if(vertical > (sectionHeight/2)) {      
                    $(this).css({'border-bottom': '2px solid dodgerblue'});
                } else{
                    $(this).css({'border-top': '2px solid dodgerblue'});
                }
            }
        }); 
    
    
        $(document).mousemove(function(e){
            if(dragging_tr){
                $('#floating-window #container').css({'left': e.pageX + 4, 'top': e.pageY});
            }
        }); 
    
    }
    
})(jQuery);
    