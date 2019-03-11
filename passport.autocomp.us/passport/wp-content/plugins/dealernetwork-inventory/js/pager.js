if(jQuery("#dn-inv-cars").length){
    var rpp=getCookie("dn-inv-rpp");
    if(rpp==null||rpp==""||rpp<=0){
        rpp=20
    }else{
        rpp=parseInt(rpp)}
        var device = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
        var paginate=new Pager("dn-inv-cars",rpp);
        if(device == false) {
             paginate=new Pager("dn-inv-cars",rpp);
        }else {
             paginate = new PagerMobile("dn-inv-cars", rpp);            
        }
        paginate.init();
        if(jQuery("#dn-inv-pages").length){
            paginate.showPageNav("paginate","dn-inv-pages")
        }
    paginate.showPage(1)
};