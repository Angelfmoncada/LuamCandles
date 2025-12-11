console.log('Luam Candles Loaded');

setTimeout(function(){
    let flash = document.getElementById('msg-flash');
    if(flash){
        flash.remove();
    }
}, 3000);
