requirejs.config({
    baseUrl : 'js/app',
});


requirejs(['browser'],function(browser){
    console.log(browser);
})