if(!getCookie('news')){
    setCookie('news', generateRandomString(10), 30)
}

let close = document.getElementById('closeNew');
let next;
let cookie = getCookie('news');
var newsModal = document.getElementById('newsModal');
var modal = new bootstrap.Modal(newsModal);

news();
        
function news(){
    $.ajax({
        url: '/get-news',
        type: 'POST',
        data: {
            external : external,
            cookie : cookie,
            _token: window.csrfToken
        },
        success: function(response){

            if(response?.news){
                
                let modal_body = document.getElementById('modal-body');
                let modal_title = document.getElementById('news-title');
                modal_body.innerHTML = response.news.description
                modal_title.innerHTML = response.news.title
                close.value = response.news.id
                modal.show();
            }
        
            if(response?.next){
                next = true;
                next_cookie = response?.next.cookie
            }

        },
        error: function(response){

        }
    })
}


function seenNew(){

    let news_id = close.value;

    $.ajax({
        url: '/seen-new',
        type: 'POST',
        data: {
            news_id : news_id,
            cookie : cookie,
            _token: window.csrfToken
        },
        success: function(response){

            if(next){
                setTimeout(news, parseInt(new_time) * 1000);
            }

            modal.hide();
            

        },
        error: function(response){

        }
    })
}

        
function getCookie(cname) {
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


function setCookie(cname, cvalue, exdays = 7){
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}



function generateRandomString(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let randomString = '';
  
    for (let i = 0; i < length; i++) {
      const randomIndex = Math.floor(Math.random() * characters.length);
      randomString += characters.charAt(randomIndex);
    }
  
    return randomString;
  }
