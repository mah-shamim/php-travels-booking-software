
// ============================= TOAST =============================

(() => {
    const toastPosition = {
        TopLeft: "top-left",
        TopCenter: "top-center",
        TopRight: "top-right",
        BottomLeft: "bottom-left",
        BottomCenter: "bottom-center",
        BottomRight: "bottom-right"
    }

    const toastPositionIndex = [
        [toastPosition.TopLeft, toastPosition.TopCenter, toastPosition.TopRight],
        [toastPosition.BottomLeft, toastPosition.BottomCenter, toastPosition.BottomRight]
    ]

    const svgs = {
        success: '<svg viewBox="0 0 426.667 426.667" width="20" height="20"><path d="M213.333 0C95.518 0 0 95.514 0 213.333s95.518 213.333 213.333 213.333c117.828 0 213.333-95.514 213.333-213.333S331.157 0 213.333 0zm-39.134 322.918l-93.935-93.931 31.309-31.309 62.626 62.622 140.894-140.898 31.309 31.309-172.203 172.207z" fill="#6ac259"></path></svg>',
        warn: '<svg viewBox="0 0 310.285 310.285" width=20 height=20> <path d="M264.845 45.441C235.542 16.139 196.583 0 155.142 0 113.702 0 74.743 16.139 45.44 45.441 16.138 74.743 0 113.703 0 155.144c0 41.439 16.138 80.399 45.44 109.701 29.303 29.303 68.262 45.44 109.702 45.44s80.399-16.138 109.702-45.44c29.303-29.302 45.44-68.262 45.44-109.701.001-41.441-16.137-80.401-45.439-109.703zm-132.673 3.895a12.587 12.587 0 0 1 9.119-3.873h28.04c3.482 0 6.72 1.403 9.114 3.888 2.395 2.485 3.643 5.804 3.514 9.284l-4.634 104.895c-.263 7.102-6.26 12.933-13.368 12.933H146.33c-7.112 0-13.099-5.839-13.345-12.945L128.64 58.594c-.121-3.48 1.133-6.773 3.532-9.258zm23.306 219.444c-16.266 0-28.532-12.844-28.532-29.876 0-17.223 12.122-30.211 28.196-30.211 16.602 0 28.196 12.423 28.196 30.211.001 17.591-11.456 29.876-27.86 29.876z" fill="#FFDA44" /> </svg>',
        info: '<svg viewBox="0 0 23.625 23.625" width=20 height=20> <path d="M11.812 0C5.289 0 0 5.289 0 11.812s5.289 11.813 11.812 11.813 11.813-5.29 11.813-11.813S18.335 0 11.812 0zm2.459 18.307c-.608.24-1.092.422-1.455.548a3.838 3.838 0 0 1-1.262.189c-.736 0-1.309-.18-1.717-.539s-.611-.814-.611-1.367c0-.215.015-.435.045-.659a8.23 8.23 0 0 1 .147-.759l.761-2.688c.067-.258.125-.503.171-.731.046-.23.068-.441.068-.633 0-.342-.071-.582-.212-.717-.143-.135-.412-.201-.813-.201-.196 0-.398.029-.605.09-.205.063-.383.12-.529.176l.201-.828c.498-.203.975-.377 1.43-.521a4.225 4.225 0 0 1 1.29-.218c.731 0 1.295.178 1.692.53.395.353.594.812.594 1.376 0 .117-.014.323-.041.617a4.129 4.129 0 0 1-.152.811l-.757 2.68a7.582 7.582 0 0 0-.167.736 3.892 3.892 0 0 0-.073.626c0 .356.079.599.239.728.158.129.435.194.827.194.185 0 .392-.033.626-.097.232-.064.4-.121.506-.17l-.203.827zm-.134-10.878a1.807 1.807 0 0 1-1.275.492c-.496 0-.924-.164-1.28-.492a1.57 1.57 0 0 1-.533-1.193c0-.465.18-.865.533-1.196a1.812 1.812 0 0 1 1.28-.497c.497 0 .923.165 1.275.497.353.331.53.731.53 1.196 0 .467-.177.865-.53 1.193z" fill="#006DF0" /> </svg>',
        error: '<svg viewBox="0 0 51.976 51.976" width=20 height=20> <path d="M44.373 7.603c-10.137-10.137-26.632-10.138-36.77 0-10.138 10.138-10.137 26.632 0 36.77s26.632 10.138 36.77 0c10.137-10.138 10.137-26.633 0-36.77zm-8.132 28.638a2 2 0 0 1-2.828 0l-7.425-7.425-7.778 7.778a2 2 0 1 1-2.828-2.828l7.778-7.778-7.425-7.425a2 2 0 1 1 2.828-2.828l7.425 7.425 7.071-7.071a2 2 0 1 1 2.828 2.828l-7.071 7.071 7.425 7.425a2 2 0 0 1 0 2.828z" fill="#D80027" /> </svg>'
    }

    const styles = `
        .vt-container {
            position: fixed;
            width: 100%;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            pointer-events: none;
        }
        .vt-row {
            display: flex;
            justify-content: space-between;
        }
        .vt-col {
            flex: 1;
            margin: 10px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .vt-col.top-left,
        .vt-col.bottom-left {
            align-items: flex-start;
        }
        .vt-col.top-right,
        .vt-col.bottom-right {
            align-items: flex-end;
        }
        .vt-card {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 12px 20px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            color: #000;
            border-radius: 4px;
            margin: 0px;
            transition: 0.3s all ease-in-out;
            pointer-events: all;
            border-left: 3px solid #8b8b8b;
            cursor: pointer;
        }
        .vt-card.success {
            border-left: 3px solid #6ec05f;
        }
        .vt-card.warn {
            border-left: 3px solid #fed953;
        }
        .vt-card.info {
            border-left: 3px solid #1271ec;
        }
        .vt-card.error {
            border-left: 3px solid #d60a2e;
        }
        .vt-card .text-group {
            margin-left: 15px;
        }
        .vt-card h4 {
            margin: 0;
            margin-bottom: 0px;
            font-size: 16px;
            font-weight: 900;
        }
        .vt-card p {
            margin: 0;
            font-size: 14px;
        }

        @media(max-width: 768px){
            .vt-col { flex: unset; }
        }
    `
    const styleSheet = document.createElement("style")
    styleSheet.innerText = styles.replace((/  |\r\n|\n|\r/gm), "")
    document.head.appendChild(styleSheet)

    const vtContainer = document.createElement("div")
    vtContainer.className = "vt-container"

    for (const ri of [0, 1]) {
        const row = document.createElement("div")
        row.className = "vt-row"

        for (const ci of [0, 1, 2]) {
            const col = document.createElement("div")
            col.className = `vt-col ${toastPositionIndex[ri][ci]}`

            row.appendChild(col)
        }

        vtContainer.appendChild(row)
    }

    document.body.appendChild(vtContainer)

    window.vt = {
        options: {
            title: undefined,
            position: toastPosition.TopCenter,
            duration: 5000,
            closable: true,
            focusable: true,
            callback: undefined
        },
        success(message, options) {
            show(message, options, "success")
        },
        info(message, options) {
            show(message, options, "info")
        },
        warn(message, options) {
            show(message, options, "warn")
        },
        error(message, options) {
            show(message, options, "error")
        }
    }

    function show(message = "My name is Toast, Vanilla Toast.", options, type) {
        options = { ...window.vt.options, ...options }

        const col = document.getElementsByClassName(options.position)[0]

        const vtCard = document.createElement("div")
        vtCard.className = `vt-card ${type}`
        vtCard.innerHTML += svgs[type]
        vtCard.options = {
            ...options, ...{
                message,
                type: type,
                yPos: options.position.indexOf("top") > -1 ? "top" : "bottom",
                isFocus: false
            }
        }

        setVTCardContent(vtCard)
        setVTCardIntroAnim(vtCard)
        setVTCardBindEvents(vtCard)
        autoDestroy(vtCard)

        col.appendChild(vtCard)
    }

    function setVTCardContent(vtCard) {
        const textGroupDiv = document.createElement("div")

        textGroupDiv.className = "text-group"

        if (vtCard.options.title) {
            textGroupDiv.innerHTML = `<h4>${vtCard.options.title}</h4>`
        }

        textGroupDiv.innerHTML += `<p>${vtCard.options.message}</p>`

        vtCard.appendChild(textGroupDiv)
    }

    function setVTCardIntroAnim(vtCard) {
        vtCard.style.setProperty(`margin-${vtCard.options.yPos}`, "-15px")
        vtCard.style.setProperty("opacity", "0")

        setTimeout(() => {
            vtCard.style.setProperty(`margin-${vtCard.options.yPos}`, "15px")
            vtCard.style.setProperty("opacity", "1")
        }, 50)
    }

    function setVTCardBindEvents(vtCard) {
        vtCard.addEventListener("click", (e) => {
            e.stopPropagation();
            if (vtCard.options.closable) {
                destroy(vtCard)
            }
        })

        vtCard.addEventListener("mouseover", () => {
            vtCard.options.isFocus = vtCard.options.focusable
        })

        vtCard.addEventListener("mouseout", () => {
            vtCard.options.isFocus = false
            autoDestroy(vtCard, vtCard.options.duration)
        })
    }

    function destroy(vtCard) {
        vtCard.style.setProperty(`margin-${vtCard.options.yPos}`, `-${vtCard.offsetHeight}px`)
        vtCard.style.setProperty("opacity", "0")

        setTimeout(() => {
            vtCard.remove()

            if (typeof vtCard.options.callback === "function") {
                vtCard.options.callback()
            }
        }, 500)
    }

    function autoDestroy(vtCard) {
        if (vtCard.options.duration !== 0) {
            setTimeout(() => {
                if (!vtCard.options.isFocus) {
                    destroy(vtCard)
                }
            }, vtCard.options.duration)
        }
    }
})();

/*! =========================================================
 * bootstrap datepicker
 * ========================================================= */
!function($){var Datepicker=function(element,options){this.element=$(element);this.format=DPGlobal.parseFormat(options.format||this.element.data('date-format')||'mm/dd/yyyy');this.picker=$(DPGlobal.template).appendTo('body').on({click:$.proxy(this.click,this)});this.isInput=this.element.is('input');this.component=this.element.is('.date')?this.element.find('.add-on'):!1;if(this.isInput){this.element.on({focus:$.proxy(this.show,this),keyup:$.proxy(this.update,this)})}else{if(this.component){this.component.on('click',$.proxy(this.show,this))}else{this.element.on('click',$.proxy(this.show,this))}}
this.minViewMode=options.minViewMode||this.element.data('date-minviewmode')||0;if(typeof this.minViewMode==='string'){switch(this.minViewMode){case 'months':this.minViewMode=1;break;case 'years':this.minViewMode=2;break;default:this.minViewMode=0;break}}
this.viewMode=options.viewMode||this.element.data('date-viewmode')||0;if(typeof this.viewMode==='string'){switch(this.viewMode){case 'months':this.viewMode=1;break;case 'years':this.viewMode=2;break;default:this.viewMode=0;break}}
this.startViewMode=this.viewMode;this.weekStart=options.weekStart||this.element.data('date-weekstart')||0;this.weekEnd=this.weekStart===0?6:this.weekStart-1;this.onRender=options.onRender;this.fillDow();this.fillMonths();this.update();this.showMode()};Datepicker.prototype={constructor:Datepicker,show:function(e){this.picker.show();this.height=this.component?this.component.outerHeight():this.element.outerHeight();this.place();$(window).on('resize',$.proxy(this.place,this));if(e){e.stopPropagation();e.preventDefault()}
if(!this.isInput){}
var that=this;$(document).on('mousedown',function(ev){if($(ev.target).closest('.datepicker').length==0){that.hide()}});this.element.trigger({type:'show',date:this.date})},hide:function(){this.picker.hide();$(window).off('resize',this.place);this.viewMode=this.startViewMode;this.showMode();if(!this.isInput){$(document).off('mousedown',this.hide)}
this.element.trigger({type:'hide',date:this.date})},set:function(){var formated=DPGlobal.formatDate(this.date,this.format);if(!this.isInput){if(this.component){this.element.find('input').prop('value',formated)}
this.element.data('date',formated)}else{this.element.prop('value',formated)}},setValue:function(newDate){if(typeof newDate==='string'){this.date=DPGlobal.parseDate(newDate,this.format)}else{this.date=new Date(newDate)}
this.set();this.viewDate=new Date(this.date.getFullYear(),this.date.getMonth(),1,0,0,0,0);this.fill()},place:function(){var offset=this.component?this.component.offset():this.element.offset();this.picker.css({top:offset.top+this.height,left:offset.left})},update:function(newDate){this.date=DPGlobal.parseDate(typeof newDate==='string'?newDate:(this.isInput?this.element.prop('value'):this.element.data('date')),this.format);this.viewDate=new Date(this.date.getFullYear(),this.date.getMonth(),1,0,0,0,0);this.fill()},fillDow:function(){var dowCnt=this.weekStart;var html='<tr>';while(dowCnt<this.weekStart+7){html+='<th class="dow">'+DPGlobal.dates.daysMin[(dowCnt++)%7]+'</th>'}
html+='</tr>';this.picker.find('.datepicker-days thead').append(html)},fillMonths:function(){var html='';var i=0
while(i<12){html+='<span class="month">'+DPGlobal.dates.monthsShort[i++]+'</span>'}
this.picker.find('.datepicker-months td').append(html)},fill:function(){var d=new Date(this.viewDate),year=d.getFullYear(),month=d.getMonth(),currentDate=this.date.valueOf();this.picker.find('.datepicker-days th:eq(1)').text(DPGlobal.dates.months[month]+' '+year);var prevMonth=new Date(year,month-1,28,0,0,0,0),day=DPGlobal.getDaysInMonth(prevMonth.getFullYear(),prevMonth.getMonth());prevMonth.setDate(day);prevMonth.setDate(day-(prevMonth.getDay()-this.weekStart+7)%7);var nextMonth=new Date(prevMonth);nextMonth.setDate(nextMonth.getDate()+42);nextMonth=nextMonth.valueOf();var html=[];var clsName,prevY,prevM;while(prevMonth.valueOf()<nextMonth){if(prevMonth.getDay()===this.weekStart){html.push('<tr>')}
clsName=this.onRender(prevMonth);prevY=prevMonth.getFullYear();prevM=prevMonth.getMonth();if((prevM<month&&prevY===year)||prevY<year){clsName+=' old'}else if((prevM>month&&prevY===year)||prevY>year){clsName+=' new'}
if(prevMonth.valueOf()===currentDate){clsName+=' active'}
html.push('<td class="day '+clsName+'">'+prevMonth.getDate()+'</td>');if(prevMonth.getDay()===this.weekEnd){html.push('</tr>')}
prevMonth.setDate(prevMonth.getDate()+1)}
this.picker.find('.datepicker-days tbody').empty().append(html.join(''));var currentYear=this.date.getFullYear();var months=this.picker.find('.datepicker-months').find('th:eq(1)').text(year).end().find('span').removeClass('active');if(currentYear===year){months.eq(this.date.getMonth()).addClass('active')}
html='';year=parseInt(year/10,10)*10;var yearCont=this.picker.find('.datepicker-years').find('th:eq(1)').text(year+'-'+(year+9)).end().find('td');year-=1;for(var i=-1;i<11;i++){html+='<span class="year'+(i===-1||i===10?' old':'')+(currentYear===year?' active':'')+'">'+year+'</span>';year+=1}
yearCont.html(html)},click:function(e){e.stopPropagation();e.preventDefault();var target=$(e.target).closest('span, td, th');if(target.length===1){switch(target[0].nodeName.toLowerCase()){case 'th':switch(target[0].className){case 'switch':this.showMode(1);break;case 'prev':case 'next':this.viewDate['set'+DPGlobal.modes[this.viewMode].navFnc].call(this.viewDate,this.viewDate['get'+DPGlobal.modes[this.viewMode].navFnc].call(this.viewDate)+DPGlobal.modes[this.viewMode].navStep*(target[0].className==='prev'?-1:1));this.fill();this.set();break}
break;case 'span':if(target.is('.month')){var month=target.parent().find('span').index(target);this.viewDate.setMonth(month)}else{var year=parseInt(target.text(),10)||0;this.viewDate.setFullYear(year)}
if(this.viewMode!==0){this.date=new Date(this.viewDate);this.element.trigger({type:'changeDate',date:this.date,viewMode:DPGlobal.modes[this.viewMode].clsName})}
this.showMode(-1);this.fill();this.set();break;case 'td':if(target.is('.day')&&!target.is('.disabled')){var day=parseInt(target.text(),10)||1;var month=this.viewDate.getMonth();if(target.is('.old')){month-=1}else if(target.is('.new')){month+=1}
var year=this.viewDate.getFullYear();this.date=new Date(year,month,day,0,0,0,0);this.viewDate=new Date(year,month,Math.min(28,day),0,0,0,0);this.fill();this.set();this.element.trigger({type:'changeDate',date:this.date,viewMode:DPGlobal.modes[this.viewMode].clsName})}
break}}},mousedown:function(e){e.stopPropagation();e.preventDefault()},showMode:function(dir){if(dir){this.viewMode=Math.max(this.minViewMode,Math.min(2,this.viewMode+dir))}
this.picker.find('>div').hide().filter('.datepicker-'+DPGlobal.modes[this.viewMode].clsName).show()}};$.fn.datepicker=function(option,val){return this.each(function(){var $this=$(this),data=$this.data('datepicker'),options=typeof option==='object'&&option;if(!data){$this.data('datepicker',(data=new Datepicker(this,$.extend({},$.fn.datepicker.defaults,options))))}
if(typeof option==='string')data[option](val)})};$.fn.datepicker.defaults={onRender:function(date){return ''}};$.fn.datepicker.Constructor=Datepicker;var DPGlobal={modes:[{clsName:'days',navFnc:'Month',navStep:1},{clsName:'months',navFnc:'FullYear',navStep:1},{clsName:'years',navFnc:'FullYear',navStep:10}],dates:{days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat","Sun"],daysMin:["Su","Mo","Tu","We","Th","Fr","Sa","Su"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]},isLeapYear:function(year){return(((year%4===0)&&(year%100!==0))||(year%400===0))},getDaysInMonth:function(year,month){return[31,(DPGlobal.isLeapYear(year)?29:28),31,30,31,30,31,31,30,31,30,31][month]},parseFormat:function(format){var separator=format.match(/[.\/\-\s].*?/),parts=format.split(/\W+/);if(!separator||!parts||parts.length===0){throw new Error("Invalid date format.")}
return{separator:separator,parts:parts}},parseDate:function(date,format){var parts=date.split(format.separator),date=new Date(),val;date.setHours(0);date.setMinutes(0);date.setSeconds(0);date.setMilliseconds(0);if(parts.length===format.parts.length){var year=date.getFullYear(),day=date.getDate(),month=date.getMonth();for(var i=0,cnt=format.parts.length;i<cnt;i++){val=parseInt(parts[i],10)||1;switch(format.parts[i]){case 'dd':case 'd':day=val;date.setDate(val);break;case 'mm':case 'm':month=val-1;date.setMonth(val-1);break;case 'yy':year=2000+val;date.setFullYear(2000+val);break;case 'yyyy':year=val;date.setFullYear(val);break}}
date=new Date(year,month,day,0,0,0)}
return date},formatDate:function(date,format){var val={d:date.getDate(),m:date.getMonth()+1,yy:date.getFullYear().toString().substring(2),yyyy:date.getFullYear()};val.dd=(val.d<10?'0':'')+val.d;val.mm=(val.m<10?'0':'')+val.m;var date=[];for(var i=0,cnt=format.parts.length;i<cnt;i++){date.push(val[format.parts[i]])}
return date.join(format.separator)},headTemplate:'<thead>'+'<tr>'+'<th class="prev"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg></th>'+'<th colspan="5" class="switch"></th>'+'<th class="next"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></th>'+'</tr>'+'</thead>',contTemplate:'<tbody><tr><td colspan="7"></td></tr></tbody>'};DPGlobal.template='<div class="datepicker dropdown-menu">'+'<div class="datepicker-days">'+'<table class=" table-condensed">'+DPGlobal.headTemplate+'<tbody></tbody>'+'</table>'+'</div>'+'<div class="datepicker-months">'+'<table class="table-condensed">'+DPGlobal.headTemplate+DPGlobal.contTemplate+'</table>'+'</div>'+'<div class="datepicker-years">'+'<table class="table-condensed">'+DPGlobal.headTemplate+DPGlobal.contTemplate+'</table>'+'</div>'+'</div>'}(window.jQuery);

// hotels datepicker
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var checkin = $('.checkin').datepicker({
format: 'dd-mm-yyyy',
onRender: function(date) {
return date.valueOf() < now.valueOf() ? 'disabled' : ''; }
}).on('changeDate', function(ev) {
var newDate = new Date(ev.date);
newDate.setDate(newDate.getDate() + 1);
checkout.setValue(newDate);
checkin.hide();

$('.checkout')[0].focus();
}).data('datepicker');
var checkout = $('.checkout').datepicker({
format: 'dd-mm-yyyy',
onRender: function(date) {
return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : ''; }
}).on('changeDate', function(ev) {
var newDate = new Date(ev.date);
checkout.hide();
}).data('datepicker');

// cars date picker
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var carfrom = $('.carfrom').datepicker({
format: 'dd-mm-yyyy',
onRender: function(date) {
return date.valueOf() < now.valueOf() ? 'disabled' : ''; }
}).on('changeDate', function(ev) {
var newDates = new Date(ev.date);
newDates.setDate(newDates.getDate() + 1);
carto.setValue(newDates);
carfrom.hide();

$('.carto')[0].focus();
}).data('datepicker');
var carto = $('.carto').datepicker({
format: 'dd-mm-yyyy',
onRender: function(date) {
return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : ''; }
}).on('changeDate', function(ev) {
var newDates = new Date(ev.date);
carto.hide();
}).data('datepicker');

/* flights */
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var depart = $('.depart').datepicker({
format: 'dd-mm-yyyy',
onRender: function(date) {
return date.valueOf() < now.valueOf() ? 'disabled' : ''; }
}).on('changeDate', function(ev) {
var newDate = new Date(ev.date);
newDate.setDate(newDate.getDate() + 1);
returning.setValue(newDate);
depart.hide();

$('.returning')[0].focus();
}).data('datepicker');
var returning = $('.returning').datepicker({
format: 'dd-mm-yyyy',
onRender: function(date) {
return date.valueOf() <= depart.date.valueOf() ? 'disabled' : ''; }
}).on('changeDate', function(ev) {
var newDate = new Date(ev.date);
returning.hide();
}).data('datepicker');

/* bus */
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var busdepart = $('.busdepart').datepicker({
format: 'dd/mm/yyyy',
onRender: function(date) {
return date.valueOf() < now.valueOf() ? 'disabled' : ''; }
}).on('changeDate', function(ev) {
var newDate = new Date(ev.date);
newDate.setDate(newDate.getDate() + 1);
busreturning.setValue(newDate);
busdepart.hide();

$('.busreturning')[0].focus();
}).data('datepicker');
var busreturning = $('.busreturning').datepicker({
format: 'dd/mm/yyyy',
onRender: function(date) {
return date.valueOf() <= busdepart.date.valueOf() ? 'disabled' : ''; }
}).on('changeDate', function(ev) {
var newDate = new Date(ev.date);
busreturning.hide();
}).data('datepicker');

/* datepicker */
$('.dp').datepicker({
format: 'dd-mm-yyyy',
onRender: function(date) {
return date.valueOf() < now.valueOf() ? 'disabled' : ''; }
}).on('changeDate', function(ev){
   $(this).datepicker('hide');
});

/* date change for tour */
$('.dp_tour').datepicker({
format: 'dd-mm-yyyy',
onRender: function(date) {
return date.valueOf() < now.valueOf() ? 'disabled' : ''; }
}).on('changeDate', function(ev){
$(this).datepicker('hide');

//
// var date = $(".date_change").val();
// alert(date);
});



/*=================================================================== Quests quantity total number count =========*/

(function ($) {
    "use strict";
    var $window = $(window);

    $window.on('load', function () {
        var $document = $(document);
        var $dom = $('html, body');
        var preloader = $('#preloader');
        var dropdownMenu = $('.main-menu-content .dropdown-menu-item');
        

        /* ======= Preloader ======= */
        preloader.delay('180').fadeOut(200);

        /*=========== Header top bar menu ============*/
        $document.on('click', '.down-button', function (event) {
            event.stopPropagation();
            $(this).toggleClass('active');
            $('.header-top-bar').slideToggle(200);
        });

        /*=========== Responsive Mobile menu ============*/
        $document.on('click', '.menu-toggler', function (event) {
            event.stopPropagation();
            $(this).toggleClass('active');
            $('.main-menu-content').slideToggle(200);
        });

        /*=========== Dropdown menu ============*/
        dropdownMenu.parent('li').children('a').append(function() {
            return '<button class="drop-menu-toggler" type="button"><i class="la la-angle-down"></i></button>';
        });

        /*=========== Dropdown menu ============*/
        $document.on('click', '.main-menu-content .drop-menu-toggler', function(event) {
            event.stopPropagation();
            var Self = $(this);
            Self.parent().parent().children('.dropdown-menu-item').toggle();
            return false;
        });

        /*=========== Sub menu ============*/
        $('.main-menu-content .dropdown-menu-item .sub-menu').parent('li').children('a').append(function() {
            return '<button class="sub-menu-toggler" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></button>';
        });

        /*=========== Dropdown menu ============*/
        $document.on('click', '.main-menu-content .dropdown-menu-item .sub-menu-toggler', function(event) {
            event.stopPropagation();
            var Self = $(this);
            Self.parent().parent().children('.sub-menu').toggle();
            return false;
        });

        /*=========== Canvas menu open ============*/
        $document.on('click', '.user-menu-open', function (event) {
            event.stopPropagation();
            $('.user-canvas-container').addClass('active');
        });

        /*=========== Canvas menu close ============*/
        $document.on('click', '.side-menu-close', function (event) {
            event.stopPropagation();
            $('.user-canvas-container, .sidebar-nav').removeClass('active');
        });

        /*=========== Dashboard menu ============*/
        $document.on('click', '.menu-toggler', function (event) {
            event.stopPropagation();
            $('.sidebar-nav').toggleClass('active');
        });


        /*===== Back to top button ======*/
        $document.on("click", "#back-to-top", function(event) {
            event.stopPropagation();
            $($dom).animate({
                scrollTop: 0
            }, 800);
            return false;
        });


        /*==== When you will click the add another flight btn then this action will be work =====*/
        $document.on('click', '.add-flight-btn', function (event) {
            event.stopPropagation();
            // event.preventDefault();
            if ( $('.multi-flight-field').length < 5 ) { 
            // $('.multi-flight-field:last').clone().insertAfter('.multi-flight-field:last');


                let addFlightClone = document.querySelector('#add--flight-temp').content.cloneNode(true);

                $(addFlightClone).insertAfter('.multi-flight-field:last');
                addSelect2();

            }
            

            // init date picker with every new clone
            $('.dp').datepicker({ format: 'dd-mm-yyyy', onRender: function(date) { return date.valueOf() < now.valueOf() ? 'disabled' : ''; } }).on('changeDate', function(ev){ $(this).datepicker('hide'); });

            // $('.autocomplete-airport').each(function(){var ac=$(this);ac.on('click',function(e){e.stopPropagation()}).on('focus keyup',search).on('keydown',onKeyDown);var wrap=$('<div>').addClass('autocomplete-wrapper').insertBefore(ac).append(ac);var list=$('<div>').addClass('autocomplete-results troll').on('click','.autocomplete-result',function(e){e.preventDefault();e.stopPropagation();selectIndex($(this).data('index'),ac)}).appendTo(wrap);var counter=0;counter++;$(".autocomplete-wrapper").addClass("_"+counter);$(".autocomplete-airport").focus(function(){$(ac).toggleClass("yes");$(".autocomplete-result").closest(".autocomplete-results").addClass("in")})});$(document).on('mouseover','.autocomplete-result',function(e){var index=parseInt($(this).data('index'),10);if(!isNaN(index)){$(this).attr('data-highlight',index)}}).on('click',clearResults);function clearResults(){results=[];numResults=0;$('.autocomplete-results').empty()}
            // $('.autocomplete-airport').each(function(){var ac=$(this);ac.on('click',function(e){e.stopPropagation()}).on('focus keyup',search).on('keydown',onKeyDown);var wrap=$('<div>').addClass('autocomplete-wrapper').insertBefore(ac).append(ac);var list=$('<div>').addClass('autocomplete-results troll').on('click','.autocomplete-result',function(e){e.stopPropagation();selectIndex($(this).data('index'),ac)}).appendTo(wrap);var counter=0;counter++;$(".autocomplete-wrapper").addClass("_"+counter);$(".autocomplete-airport").focus(function(){$(ac).toggleClass("yes");$(".autocomplete-result").closest(".autocomplete-results").addClass("in")})});$(document).on('mouseover','.autocomplete-result',function(e){var index=parseInt($(this).data('index'),10);if(!isNaN(index)){$(this).attr('data-highlight',index)}}).on('click',clearResults);function clearResults(){results=[];numResults=0;$('.autocomplete-results').empty()}
            $('.autocomplete-airport').each(function(){var ac=$(this);ac.on('click',function(e){e.stopPropagation()}).on('focus keyup',search).on('keydown',onKeyDown);var wrap=$('<div>').addClass('autocomplete-wrapper').insertBefore(ac).append(ac);var list=$('<div>').addClass('autocomplete-results troll').on('click','.autocomplete-result',function(e){e.stopPropagation();selectIndex($(this).data('index'),ac)}).appendTo(wrap);var counter=0;counter++;$(".autocomplete-wrapper").addClass("_"+counter);$(".autocomplete-airport").focus(function(){$(ac).toggleClass("yes");$(".autocomplete-result").closest(".autocomplete-results").addClass("in")})});$(document).on('mouseover','.autocomplete-result',function(e){var index=parseInt($(this).data('index'),10);if(!isNaN(index)){$(this).attr('data-highlight',index)}}).on('click',(e) => clearResults(e));function clearResults(e){e.stopPropagation(); results=[];numResults=0;$('.autocomplete-results').empty()}
            function selectIndex(index,autoinput){if(results.length>=index+1){autoinput.val(results[index].iata+" - "+results[index].name+" - "+results[index].city);clearResults()}}
            var results=[];var numResults=0;var selectedIndex=-1;function search(e){if(e.which===38||e.which===13||e.which===40){return}
            var ac=$(e.target);var list=ac.next();if(ac.val().length>0){results=_.take(fuse.search(ac.val()),7);numResults=results.length;var divs=results.map(function(r,i){return'<div class="autocomplete-result" data-index="'+i+'">'+'<div><i class="mdi mdi-flight-takeoff"></i><b>'+r.iata+'</b><strong> '+r.name+'</strong></div>'+'<div class="autocomplete-location">'+r.city+', '+r.country+'</div>'+'</div>'});selectedIndex=-1;list.html(divs.join('')).attr('data-highlight',selectedIndex)}else{numResults=0;list.empty()}}
            function onKeyDown(e){var ac=$(e.currentTarget);var list=ac.next();switch(e.which){case 38:selectedIndex--;if(selectedIndex<=-1){selectedIndex=-1}
            list.attr('data-highlight',selectedIndex);break;case 13:selectIndex(selectedIndex,ac);break;case 9:selectIndex(selectedIndex,ac);e.stopPropagation();return;case 40:selectedIndex++;if(selectedIndex>=numResults){selectedIndex=numResults-1}
            list.attr('data-highlight',selectedIndex);break;default:return}
            e.stopPropagation();e.preventDefault()}
            var counter=0;$(".autocomplete-wrapper").each(function(){counter++;var self=$(this);self.addClass("row_"+counter);var tdCounter=0;self.find('.autocomplete-results').each(function(index){$(".autocomplete-wrapper").find(".autocomplete-results").addClass("intro")})});$('.ro-select').filter(function(){var $this=$(this),$sel=$('<ul>',{'class':'ro-select-list'}),$wr=$('<div>',{'class':'ro-select-wrapper'}),$inp=$('<input>',{type:'hidden',name:$this.attr('name'),'class':'ro-select-input'}),$text=$('<div>',{'class':'ro-select-text ro-select-text-empty',text:$this.attr('placeholder')});$opts=$this.children('option');$text.click(function(event){ event.stopPropagation(); $sel.show()});$opts.filter(function(){var $opt=$(this);$sel.append($('<li>',{text:$opt.text(),'class':'ro-select-item'})).data('value',$opt.attr('value'))});$sel.on('click','li',function(event){event.stopPropagation(); $text.text($(this).text()).removeClass('ro-select-text-empty');$(this).parent().hide().children('li').removeClass('ro-select-item-active');$(this).addClass('ro-select-item-active');$inp.val($this.data('value'))});$wr.append($text);$wr.append($('<i>',{'class':'fa fa-caret-down ro-select-caret'}));$this.after($wr.append($inp,$sel));$this.remove()})
 
            $(this).closest('.multi-flight-wrap').find('.multi-flight-field:last').children('.multi-flight-delete-wrap').show();

        });


        /*=========== multi-flight-remove ============*/
        $document.on('click', '.multi-flight-remove', function(event) {
            // event.preventDefault();
            event.stopPropagation();
            console.log("removed");
            
            $('.multi-flight-remove').closest('.multi-flight-wrap').find('.multi-flight-field').not(':first').last().remove();
        });

        /*====  mobile dropdown menu  =====*/
        $document.on('click', '.toggle-menu > li .toggle-menu-icon', function (event) {
            // event.preventDefault();
            event.stopPropagation();
            $(this).closest('li').siblings().removeClass('active').find('.toggle-drop-menu, .dropdown-menu-item').slideUp(200);
            $(this).closest('li').toggleClass('active').find('.toggle-drop-menu, .dropdown-menu-item').slideToggle(200);
            return false;
        });

        /*====== Dropdown btn ======*/
        $('.dropdown-btn').on('click', function (event) {
            // event.preventDefault();
            event.stopPropagation();
            $(this).next('.dropdown-menu-wrap').slideToggle(300);
        });
        
        /*====== When you click on the out side of dropdown menu item then its will be hide ======*/
        $document.on('click', function(event){
            event.stopPropagation();
            // event.preventDefault();
            var $trigger = $('.dropdown-contain');
            if($trigger !== event.target && !$trigger.has(event.target).length){
                $('.dropdown-menu-wrap').slideUp(300);
            }
        });

        $('.progressbar-line').each(function(){
            $(this).find('.progressbar-line-item').animate({
                width:$(this).attr('data-percent')
            },6000);
        });


    });

})(jQuery);


/*======== Quests quantity total number count =========*/
function qtySumary(){
    var qtyInputField = document.getElementsByClassName('qtyInput_hotels');
    var totalNumber=0;
    for(var i = 0; i < qtyInputField.length; i++){
        if(parseInt(qtyInputField[i].value))
            totalNumber += parseInt(qtyInputField[i].value);
    }

    var cardQty = document.querySelector(".guest_hotels");
    if (cardQty) { cardQty.innerHTML = totalNumber; }

    var qtyInputField = document.getElementsByClassName('qtyInput_tours');
    var totalNumber=0;
    for(var i = 0; i < qtyInputField.length; i++){
        if(parseInt(qtyInputField[i].value))
            totalNumber += parseInt(qtyInputField[i].value);
    }

    var cardQty = document.querySelector(".guest_tours");
    if (cardQty) { cardQty.innerHTML = totalNumber; }

    var qtyInputField = document.getElementsByClassName('qtyInput_cars');
    var totalNumber=0;
    for(var i = 0; i < qtyInputField.length; i++){
        if(parseInt(qtyInputField[i].value))
            totalNumber += parseInt(qtyInputField[i].value);
    }

    var cardQty = document.querySelector(".guest_cars");
    if (cardQty) { cardQty.innerHTML = totalNumber; }

    var qtyInputField = document.getElementsByClassName('qtyInput_flights');
    var totalNumber=0;
    for(var i = 0; i < qtyInputField.length; i++){
        if(parseInt(qtyInputField[i].value))


        // alert(1);

            totalNumber += parseInt(qtyInputField[i].value);
    }


    var cardQty = document.querySelector(".guest_flights");
    if (cardQty) { cardQty.innerHTML = totalNumber; }
}
qtySumary();

$(".qtyBtn input").before('<div class="qtyDec"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg></div>');
$(".qtyBtn input").after('<div class="qtyInc"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></div>');

$(".roomBtn input").before('<div class="roomDec"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg></div>');
$(".roomBtn input").after('<div class="roomInc"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></div>');

$(".qtyDec, .qtyInc").on("click", function(event) {
    event.stopPropagation();

    var $button = $(this);
    var oldValue = $button.parent().find("input").val();

    if ($button.hasClass('qtyInc')) {
        var newVal = parseFloat(oldValue) + 1;

        // alert( newVal );

        if (newVal == 13 ) {

        }

        if (newVal == 13 ) {
        // alert( "Sorry, the maximum number of guests allowed is 12." );
        // $button.parent().find("input").val(0);
        // qtySumary();
        return;
        }

        /*var adult_value  = $('.adult input' ).val() ++; // to get value of input
        var child_value  = $('.child input' ).val(); // to get value of input
        var infant_value = $('.infant input').val(); // to get value of input

        var adult  = parseFloat(adult_value ); // arrurate value
        var child  = parseFloat(child_value ); // arrurate value
        var infant = parseFloat(infant_value); // arrurate value

        console.log('adult value ' + adult_price + ' adult value ' + adult + ' cost ' + adult_price * adult )
        console.log('child value ' + child_price + ' child value ' + child + ' cost ' + child_price * child )
        console.log('infant value' + infant_price+ ' infant value' + infant+ ' cost ' + infant_price *infant)

        var adult_cost = adult_price * adult ;
        var child_cost = child_price * child ;
        var infant_cost = infant_price * infant ;

        var cost = adult_cost + child_cost + infant_cost;

        $(".total").html(cost);*/

    } else {

        if (oldValue > 0) {

            var newVal = parseFloat(oldValue) - 1;

        } else {

            newVal = 1;

        }
    }

    $button.parent().find("input").val(newVal);
    qtySumary();
});


// var adults = $("#adults").val();

// if (adults == 0 ) {

//     alert(adults);
//     $(".qtyDec,.roomDec").css("pointer-events","none");

// }

var AGES = {};
function show_values(id){
    // console.log($("#ages" + id).val());
    let value = $("#ages" + id).val();
    let index = 'age'+id;
    AGES[index] = value;
    console.log(AGES);
    $.ajax({
        url: root + '/child_ages',
        method: "POST",
        data: AGES,
        beforeSend: () => {
            console.log('Posting Ages...');
        },
        success: function (response) {
            console.log("Response --> " + response);
        }
    });
}

var counter_ages = 1;
$(".child_ages .qtyInc").click(function(event){
    event.stopPropagation();
    var element = `<li class="col px-2" id="child_ages"><div class="dropdown-item p-2" style="margin-top:-36px"> <p style="color:#000"><small> <strong class="px-2">` + child_age + `</strong></small></p> <div class="form-group"> <span class="la la-child select form-icon"></span> <div class="input-items"> <select onchange="show_values(` + counter_ages + `);" class="form-select" id="ages` + counter_ages +`" name="ages[` + counter_ages + `]"> <option value="0" selected disabled>0</option> <option value="1">1</option> <option value="2">2</option> <option value="3">3</option> <option value="4">4</option> <option value="5">5</option> <option value="6">6</option> <option value="7">7</option> <option value="8">8</option> <option value="9">9</option> <option value="10">10</option> <option value="11">11</option> <option value="12">12</option> <option value="13">13</option> <option value="14">14</option> <option value="15">15</option> <option value="16">16</option> </select> </div> </div> </div></li>`;
    $("#append").append(element);
    counter_ages = counter_ages + 1;

});

$(".child_ages .qtyDec").click(function(event){
    event.stopPropagation();
    $("#append #child_ages:last").remove();
});

/*======== Room quantity total number count =========*/
function roomSumary(){
    var qtyInputField_2 = document.getElementsByName('roomInput');
    var totalNumber_2=0;
    for(var i = 0; i < qtyInputField_2.length; i++){
        if(parseInt(qtyInputField_2[i].value))
            totalNumber_2 += parseInt(qtyInputField_2[i].value);
    }

    var roomQty = document.querySelector(".roomTotal");
    var roomQty_2 = document.querySelector(".roomTotal_2");
    var roomQty_3 = document.querySelector(".roomTotal_3");
    var roomQty_4 = document.querySelector(".roomTotal_4");
    if (roomQty) {
        roomQty.innerHTML = totalNumber_2;
    }
    if (roomQty_2) {
        roomQty_2.innerHTML = totalNumber_2;
    }
    if (roomQty_3) {
        roomQty_3.innerHTML = totalNumber_2;
    }
    if (roomQty_4) {
        roomQty_4.innerHTML = totalNumber_2;
    }
}
roomSumary();

/*======== Room quantity increment decrement =========*/
$(".roomInc, .roomDec").on("click", function(event) {
    event.stopPropagation();

    var $button = $(this);
    var oldValue = $button.parent().find("input").val();

    if ($button.hasClass('roomInc')) {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        // don't allow decrementing below zero
        if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 0;
        }
    }

    $button.parent().find("input").val(newVal);
    roomSumary();

});


/*! Waves v0.7.6  */
(function(window,factory){'use strict';if(typeof define==='function'&&define.amd){define([],function(){window.Waves=factory.call(window);return window.Waves})}else if(typeof exports==='object'){module.exports=factory.call(window)}else{window.Waves=factory.call(window)}})(typeof global==='object'?global:this,function(){'use strict';var Waves=Waves||{};var $$=document.querySelectorAll.bind(document);var toString=Object.prototype.toString;var isTouchAvailable='ontouchstart' in window;function isWindow(obj){return obj!==null&&obj===obj.window}
function getWindow(elem){return isWindow(elem)?elem:elem.nodeType===9&&elem.defaultView}
function isObject(value){var type=typeof value;return type==='function'||type==='object'&&!!value}
function isDOMNode(obj){return isObject(obj)&&obj.nodeType>0}
function getWavesElements(nodes){var stringRepr=toString.call(nodes);if(stringRepr==='[object String]'){return $$(nodes)}else if(isObject(nodes)&&/^\[object (Array|HTMLCollection|NodeList|Object)\]$/.test(stringRepr)&&nodes.hasOwnProperty('length')){return nodes}else if(isDOMNode(nodes)){return[nodes]}
return[]}
function offset(elem){var docElem,win,box={top:0,left:0},doc=elem&&elem.ownerDocument;docElem=doc.documentElement;if(typeof elem.getBoundingClientRect!==typeof undefined){box=elem.getBoundingClientRect()}
win=getWindow(doc);return{top:box.top+win.pageYOffset-docElem.clientTop,left:box.left+win.pageXOffset-docElem.clientLeft}}
function convertStyle(styleObj){var style='';for(var prop in styleObj){if(styleObj.hasOwnProperty(prop)){style+=(prop+':'+styleObj[prop]+';')}}
return style}
var Effect={duration:750,delay:200,show:function(e,element,velocity){if(e.button===2){return!1}
element=element||this;var ripple=document.createElement('div');ripple.className='waves-ripple waves-rippling';element.appendChild(ripple);var pos=offset(element);var relativeY=0;var relativeX=0;if('touches' in e&&e.touches.length){relativeY=(e.touches[0].pageY-pos.top);relativeX=(e.touches[0].pageX-pos.left)}else{relativeY=(e.pageY-pos.top);relativeX=(e.pageX-pos.left)}
relativeX=relativeX>=0?relativeX:0;relativeY=relativeY>=0?relativeY:0;var scale='scale('+((element.clientWidth/100)*3)+')';var translate='translate(0,0)';if(velocity){translate='translate('+(velocity.x)+'px, '+(velocity.y)+'px)'}
ripple.setAttribute('data-hold',Date.now());ripple.setAttribute('data-x',relativeX);ripple.setAttribute('data-y',relativeY);ripple.setAttribute('data-scale',scale);ripple.setAttribute('data-translate',translate);var rippleStyle={top:relativeY+'px',left:relativeX+'px'};ripple.classList.add('waves-notransition');ripple.setAttribute('style',convertStyle(rippleStyle));ripple.classList.remove('waves-notransition');rippleStyle['-webkit-transform']=scale+' '+translate;rippleStyle['-moz-transform']=scale+' '+translate;rippleStyle['-ms-transform']=scale+' '+translate;rippleStyle['-o-transform']=scale+' '+translate;rippleStyle.transform=scale+' '+translate;rippleStyle.opacity='1';var duration=e.type==='mousemove'?2500:Effect.duration;rippleStyle['-webkit-transition-duration']=duration+'ms';rippleStyle['-moz-transition-duration']=duration+'ms';rippleStyle['-o-transition-duration']=duration+'ms';rippleStyle['transition-duration']=duration+'ms';ripple.setAttribute('style',convertStyle(rippleStyle))},hide:function(e,element){element=element||this;var ripples=element.getElementsByClassName('waves-rippling');for(var i=0,len=ripples.length;i<len;i++){removeRipple(e,element,ripples[i])}
if(isTouchAvailable){element.removeEventListener('touchend',Effect.hide);element.removeEventListener('touchcancel',Effect.hide)}
element.removeEventListener('mouseup',Effect.hide);element.removeEventListener('mouseleave',Effect.hide)}};var TagWrapper={input:function(element){var parent=element.parentNode;if(parent.tagName.toLowerCase()==='i'&&parent.classList.contains('waves-effect')){return}
var wrapper=document.createElement('i');wrapper.className=element.className+' waves-input-wrapper';element.className='waves-button-input';parent.replaceChild(wrapper,element);wrapper.appendChild(element);var elementStyle=window.getComputedStyle(element,null);var color=elementStyle.color;var backgroundColor=elementStyle.backgroundColor;wrapper.setAttribute('style','color:'+color+';background:'+backgroundColor);element.setAttribute('style','background-color:rgba(0,0,0,0);')},img:function(element){var parent=element.parentNode;if(parent.tagName.toLowerCase()==='i'&&parent.classList.contains('waves-effect')){return}
var wrapper=document.createElement('i');parent.replaceChild(wrapper,element);wrapper.appendChild(element)}};function removeRipple(e,el,ripple){if(!ripple){return}
ripple.classList.remove('waves-rippling');var relativeX=ripple.getAttribute('data-x');var relativeY=ripple.getAttribute('data-y');var scale=ripple.getAttribute('data-scale');var translate=ripple.getAttribute('data-translate');var diff=Date.now()-Number(ripple.getAttribute('data-hold'));var delay=350-diff;if(delay<0){delay=0}
if(e.type==='mousemove'){delay=150}
var duration=e.type==='mousemove'?2500:Effect.duration;setTimeout(function(){var style={top:relativeY+'px',left:relativeX+'px',opacity:'0','-webkit-transition-duration':duration+'ms','-moz-transition-duration':duration+'ms','-o-transition-duration':duration+'ms','transition-duration':duration+'ms','-webkit-transform':scale+' '+translate,'-moz-transform':scale+' '+translate,'-ms-transform':scale+' '+translate,'-o-transform':scale+' '+translate,'transform':scale+' '+translate};ripple.setAttribute('style',convertStyle(style));setTimeout(function(){try{el.removeChild(ripple)}catch(e){return!1}},duration)},delay)}
var TouchHandler={touches:0,allowEvent:function(e){var allow=!0;if(/^(mousedown|mousemove)$/.test(e.type)&&TouchHandler.touches){allow=!1}
return allow},registerEvent:function(e){var eType=e.type;if(eType==='touchstart'){TouchHandler.touches+=1}else if(/^(touchend|touchcancel)$/.test(eType)){setTimeout(function(){if(TouchHandler.touches){TouchHandler.touches-=1}},500)}}};function getWavesEffectElement(e){if(TouchHandler.allowEvent(e)===!1){return null}
var element=null;var target=e.target||e.srcElement;while(target.parentElement){if((!(target instanceof SVGElement))&&target.classList.contains('waves-effect')){element=target;break}
target=target.parentElement}
return element}
function showEffect(e){var element=getWavesEffectElement(e);if(element!==null){if(element.disabled||element.getAttribute('disabled')||element.classList.contains('disabled')){return}
TouchHandler.registerEvent(e);if(e.type==='touchstart'&&Effect.delay){var hidden=!1;var timer=setTimeout(function(){timer=null;Effect.show(e,element)},Effect.delay);var hideEffect=function(hideEvent){if(timer){clearTimeout(timer);timer=null;Effect.show(e,element)}
if(!hidden){hidden=!0;Effect.hide(hideEvent,element)}
removeListeners()};var touchMove=function(moveEvent){if(timer){clearTimeout(timer);timer=null}
hideEffect(moveEvent);removeListeners()};element.addEventListener('touchmove',touchMove,!1);element.addEventListener('touchend',hideEffect,!1);element.addEventListener('touchcancel',hideEffect,!1);var removeListeners=function(){element.removeEventListener('touchmove',touchMove);element.removeEventListener('touchend',hideEffect);element.removeEventListener('touchcancel',hideEffect)}}else{Effect.show(e,element);if(isTouchAvailable){element.addEventListener('touchend',Effect.hide,!1);element.addEventListener('touchcancel',Effect.hide,!1)}
element.addEventListener('mouseup',Effect.hide,!1);element.addEventListener('mouseleave',Effect.hide,!1)}}}
Waves.init=function(options){var body=document.body;options=options||{};if('duration' in options){Effect.duration=options.duration}
if('delay' in options){Effect.delay=options.delay}
if(isTouchAvailable){body.addEventListener('touchstart',showEffect,!1);body.addEventListener('touchcancel',TouchHandler.registerEvent,!1);body.addEventListener('touchend',TouchHandler.registerEvent,!1)}
body.addEventListener('mousedown',showEffect,!1)};Waves.attach=function(elements,classes){elements=getWavesElements(elements);if(toString.call(classes)==='[object Array]'){classes=classes.join(' ')}
classes=classes?' '+classes:'';var element,tagName;for(var i=0,len=elements.length;i<len;i++){element=elements[i];tagName=element.tagName.toLowerCase();if(['input','img'].indexOf(tagName)!==-1){TagWrapper[tagName](element);element=element.parentElement}
if(element.className.indexOf('waves-effect')===-1){element.className+=' waves-effect'+classes}}};Waves.ripple=function(elements,options){elements=getWavesElements(elements);var elementsLen=elements.length;options=options||{};options.wait=options.wait||0;options.position=options.position||null;if(elementsLen){var element,pos,off,centre={},i=0;var mousedown={type:'mousedown',button:1};var hideRipple=function(mouseup,element){return function(){Effect.hide(mouseup,element)}};for(;i<elementsLen;i++){element=elements[i];pos=options.position||{x:element.clientWidth/2,y:element.clientHeight/2};off=offset(element);centre.x=off.left+pos.x;centre.y=off.top+pos.y;mousedown.pageX=centre.x;mousedown.pageY=centre.y;Effect.show(mousedown,element);if(options.wait>=0&&options.wait!==null){var mouseup={type:'mouseup',button:1};setTimeout(hideRipple(mouseup,element),options.wait)}}}};Waves.calm=function(elements){elements=getWavesElements(elements);var mouseup={type:'mouseup',button:1};for(var i=0,len=elements.length;i<len;i++){Effect.hide(mouseup,elements[i])}};Waves.displayEffect=function(options){console.error('Waves.displayEffect() has been deprecated and will be removed in future version. Please use Waves.init() to initialize Waves effect');Waves.init(options)};return Waves})

// This is ok.
Waves.init();
// Waves.attach('', ['waves-button', 'waves-float']);
Waves.attach('a');
Waves.attach('.brand');
Waves.attach('button');
Waves.attach('.theme-search-results-item-rounded');
Waves.attach('.deal-card');
Waves.attach('.ripple,.swap-places');
Waves.attach('.select2-results__option');

setTimeout(function() {
    $('.bodyload').fadeOut();
}, 100);

// BODY FADEOUT
$(".fadeout,.paginate a").click(function(event) {
    event.stopPropagation();
    // $("html, body").fadeOut(250);
    $('.bodyload').fadeIn();
})

// vt.success('Infromation has been updated successfully',{
//     title:"Information Updated",
//     position: "bottom-center",
//     callback: function (){
// } }) 

// ============================= TOAST =============================

var alert_msg = sessionStorage.getItem("alert_msg");

if (alert_msg == ""){} else {
    
    // =====================================================-----> account exist
    if (alert_msg == "account_exist"){ 
        vt.error('Please use different email',{
            title:"Account already exist",
            position: "bottom-center",
            callback: function (){
        } }) 
        sessionStorage.setItem("alert_msg", "");
    }

    // =====================================================-----> Infromation Updated 
    if (alert_msg == "updated"){ 
    vt.success('Infromation has been updated successfully',{
        title:"Information Updated",
        position: "bottom-center",
        callback: function (){
    } }) 
    sessionStorage.setItem("alert_msg", "");
    }

    // =====================================================-----> Logout 
    if (alert_msg == "logout"){ 
        vt.success('You have been logout successfully',{
            title:"Logout Successful",
            position: "bottom-center",
            callback: function (){
        } }) 
        sessionStorage.setItem("alert_msg", "");
    }

    // =====================================================-----> invalid login 
    if (alert_msg == "invalid_login"){ 
        vt.error('Please check your emal and password',{
            title:"Invalid Login",
            position: "bottom-center",
            callback: function (){
        } }) 
        sessionStorage.setItem("alert_msg", "");
    }

    // =====================================================-----> not active
    if (alert_msg == "not_active"){ 
        vt.error('Please contact admin to activate your account',{
            title:"Account not active",
            position: "bottom-center",
            callback: function (){
        } }) 
        sessionStorage.setItem("alert_msg", "");
    }

    // =====================================================-----> reset password 
    if (alert_msg == "reset_password"){ 
        vt.success('New pasword has been sent to your mail',{
            title:"Reset Password",
            position: "bottom-center",
            callback: function (){
        } }) 
        sessionStorage.setItem("alert_msg", "");
    }

    // =====================================================-----> wrong email
    if (alert_msg == "wrong_email"){ 
        vt.error('No account found with this email',{
            title:"Invalid Email Address",
            position: "bottom-center",
            callback: function (){
        } }) 
        sessionStorage.setItem("alert_msg", "");
    }

    // =====================================================-----> admin login
    if (alert_msg == "admin_logged"){ 
        vt.warn('You are using admin account',{
            title:"Admin Logged",
            position: "bottom-center",
            callback: function (){
        } }) 
        sessionStorage.setItem("alert_msg", "");
    }

}

