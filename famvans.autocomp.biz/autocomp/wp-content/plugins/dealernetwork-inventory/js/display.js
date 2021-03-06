function Pager(parentName,itemsPerPage){this.parentName=parentName;this.itemsPerPage=itemsPerPage;this.currentPage=1;this.pages=0;this.itemsCount=0;this.inited=false;this.showRecords=function(from,to){var items=document.getElementById(this.parentName).children;for(var i=0;i<this.itemsCount;i++){if(i<from||i>to){items[i].style.display="none"}else{items[i].style.display=""}}};this.showPage=function(pageNumber){if(!this.inited){alert("not inited");return}var pagerRecCount=document.getElementById("PRC");var oldPageAnchor=document.getElementById("pg"+this.currentPage);oldPageAnchor.className="pg-normal";this.currentPage=pageNumber;var newPageAnchor=document.getElementById("pg"+this.currentPage);newPageAnchor.className="pg-selected";var from=(pageNumber-1)*itemsPerPage;var to=from+itemsPerPage-1;to=Math.min(to,this.itemsCount-1);this.showRecords(from,to);pagerRecCount.innerHTML=(from+1)+" - "+(to+1)+" of "+this.itemsCount;window.scrollTo(0,0)};this.prev=function(){if(this.currentPage>1){this.showPage(this.currentPage-1)}};this.next=function(){if(this.currentPage<this.pages){this.showPage(this.currentPage+1)}};this.init=function(){var items=document.getElementById(this.parentName).children;this.itemsCount=(items.length);this.pages=Math.ceil(this.itemsCount/this.itemsPerPage);this.inited=true};this.showPageNav=function(pagerName,positionId){if(!this.inited){alert("not inited");return}var element=document.getElementById(positionId);var pagerHtml='<span class="left" id="PRC"></span>';pagerHtml+='<span onclick="'+pagerName+'.prev();" class="pg-normal"> &#171; Prev </span> ';for(var page=1;page<=this.pages;page++){pagerHtml+='<span id="pg'+page+'" class="pg-normal" onclick="'+pagerName+".showPage("+page+');">'+page+"</span> "}pagerHtml+='<span onclick="'+pagerName+'.next();" class="pg-normal"> Next &#187;</span>';element.innerHTML=pagerHtml}}jQuery.fn.preload=function(){this.each(function(){jQuery("<img/>")[0].src=this})};jQuery.fn.ezCollapse=function(options){var base=this;var settings=jQuery.extend({"collapsed-class":"collapsed","animation-duration":500,"sibbling-selector":"div"},options);function toggle($element){if($element.hasClass(settings["collapsed-class"])){$element.next(settings["sibbling-selector"]).slideDown(settings["animation-duration"])}else{$element.next(settings["sibbling-selector"]).slideUp(settings["animation-duration"])}}base.each(function(){if(jQuery(this).hasClass(settings["collapsed-class"])){jQuery(this).next(settings["sibbling-selector"]).slideUp(settings["animation-duration"])}});base.click(function(){toggle(jQuery(this));if(jQuery(this).hasClass(settings["collapsed-class"])){jQuery(this).removeClass(settings["collapsed-class"])}else{jQuery(this).addClass(settings["collapsed-class"])}})};jQuery.fn.hideTips=function(){return this.each(function(){var $elem=jQuery(this);var savealt=$elem.attr("alt");var savetitle=$elem.attr("title");$elem.hover(function(){$elem.removeAttr("title").removeAttr("alt")},function(){$elem.attr({title:savetitle,alt:savealt})})})};function htmlEncode(value){return jQuery("<div/>").text(value).html()}function htmlDecode(value){return jQuery("<div/>").html(value).text()}function FixCurrency(field){field.val(parseFloat(Math.round(DecimalsOnly(field.val())*100)/100).toFixed(2))}function DecimalsOnly(input){return input.replace(/[^0-9.]/g,"")}function NumbersOnly(input){return input.replace(/[^0-9]/g,"")}function getCookie(c_name){var c_value=document.cookie;var c_start=c_value.indexOf(" "+c_name+"=");if(c_start==-1){c_start=c_value.indexOf(c_name+"=")}if(c_start==-1){c_value=null}else{c_start=c_value.indexOf("=",c_start)+1;var c_end=c_value.indexOf(";",c_start);if(c_end==-1){c_end=c_value.length}c_value=unescape(c_value.substring(c_start,c_end))}return c_value}function setCookie(c_name,value,exdays){var exdate=new Date();exdate.setDate(exdate.getDate()+exdays);var c_value=escape(value)+((exdays==null)?"":"; expires="+exdate.toUTCString());document.cookie=c_name+"="+c_value}function getParameterByName(name){name=name.replace(/[\[]/,"\\[").replace(/[\]]/,"\\]");var regex=new RegExp("[\\?&]"+name+"=([^&#]*)"),results=regex.exec(location.search);return results==null?"":decodeURIComponent(results[1].replace(/\+/g," "))}
jQuery(document).ready(function(){

     if(jQuery(".mini-multi").length){
      var owl = jQuery('.mini-multi');
	owl.owlCarousel({
	    loop:true,
	    autoplay:true,
    	    autoplayTimeout:8000,
    	    autoplayHoverPause:true,
	    margin:10,
	    responsive:{
	        0:{
	            items:2
	        },
	        600:{
	            items:3
	        },            
	        960:{
	            items:5
	        },
	        1200:{
	            items:5
	        }
	    }
	});
	owl.on('mousewheel', '.owl-stage', function (e) {
	    if (e.deltaY>0) {
	        owl.trigger('next.owl');
	    } else {
	        owl.trigger('prev.owl');
	    }
	    e.preventDefault();
	});
     } 
  
      
      
    if(jQuery(".fullslide").length){
    jQuery(".fullslide").owlCarousel({
        autoplay:true,
        autoplayTimeout:800,
    	autoplayHoverPause:true,
        nimateOut: 'slideOutDown',
        animateIn: 'flipInX',
        items:1,
        margin:30,
        stagePadding:30,
        smartSpeed:450
    });  
    
    }

    if(jQuery("#thumbs").length){
        jQuery("#thumbs").galleriffic({
            imageContainerSel:"#slideshow",
            controlsContainerSel:"#controls",
            autoStart:true,
            delay:10000,
            enableKeyboardNavigation:true,
            defaultTransitionDuration:0,
            numThumbs:27,
            nextLinkText:"Next &rsaquo;",
            prevLinkText:"&lsaquo; Prev",
            enableKeyboardNavigation:false
            })
            }
     if(jQuery(".dn-inv-refine-more").length){
        jQuery(["images/collapse.png","images/expand.png"]).preload();
        jQuery(".dn-inv-refine-more").click(function(){
            var ul=jQuery(this).prev("ul");
            if(ul.length){
                if(ul.css("display")=="none"){
                    ul.slideDown(500);
                    jQuery(this).text(jQuery(this).text().replace("More","Less"))
                    }
                 else{ul.slideUp(500);
                 jQuery(this).text(jQuery(this).text().replace("Less","More"))}}})}
     if(jQuery(".collapsible").length){
            jQuery(".collapsible").ezCollapse()}
     if(jQuery(".tabs").length){
                jQuery(".tabs").tabs()}
     if(jQuery(".chosen").length){
                jQuery(".chosen").chosen()}
     if(jQuery("form.validate-me").length){
                jQuery("form.validate-me").each(function(){
                jQuery(this).validate({submitHandler:function(form){
                jQuery(form).find("input[type=submit]").val("Submitting ...");
                jQuery(form).find("input[type=submit]").attr("disabled","disabled");
                form.submit()}})})
                }
     if(jQuery("input[type=text].phone").length){
                    jQuery("input[type=text].phone").mask("(999) 999-9999? x99999")}
     if(jQuery("input[type=text].zipcode").length){
                    jQuery("input[type=text].zipcode").mask("99999")}
     if(jQuery("input[type=text].year").length){
                    jQuery("input[type=text].year").mask("9999")}
                    jQuery(".currency").each(function(){
                    FixCurrency(jQuery(this))});
                    jQuery(".currency").change(function(){
                    FixCurrency(jQuery(this))});
                    jQuery(".fancybox").fancybox()
   });