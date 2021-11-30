require('./bootstrap');

function siteStatusCheck() {
    let table = $(".sitesTable");
    if(table.length){
        let inProcess = false;
        $(table).find("kbd").each(function (i,e) {
            if($(e).hasClass("bg-info")){
                inProcess = true;
            }
        })
        if(inProcess === true){
            $.get("/home",function (callback) {
                $(table).html($(callback).find(".sitesTable"));
                setTimeout(siteStatusCheck,500);
            })
        }
    }
}

$("document").ready(function () {
    siteStatusCheck();
})
