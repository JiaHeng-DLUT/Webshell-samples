/**
 * Created by A.J on 2018/5/26.
 */
!function(e){var r=/([^&=]+)=?([^&]*)/g,n=/\+/g,a=function(e){return decodeURIComponent(e.replace(n," "))};jQuery.parseParamsAddPage=function(e){var n,o={},t=location.href.split("?")[1]||"";for(o.page=parseInt(e);n=r.exec(t);)"page"!=a(n[1])&&(o[a(n[1])]=a(n[2]));return o}}();