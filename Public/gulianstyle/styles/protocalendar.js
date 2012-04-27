/*  protocalendar.js
 *  (c) 2007 Spookies
 * 
 *  License : MIT-style license.
 *  Web site: http://labs.spookies.co.jp
 *
 *  protocalendar.js - depends on prototype.js
 *  http://www.prototypejs.org/
 *
/*--------------------------------------------------------------------------*/

var ProtoCalendar = Class.create();
ProtoCalendar.Version = "1.0";

ProtoCalendar.LangFile = new Object();
ProtoCalendar.LangFile['en'] = {
  DEFAULT_FORMAT: 'mm/dd/yyyy',
  LABEL_FORMAT: 'ddd mm/dd/yyyy',
  MONTH_ABBRS: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
  MONTH_NAMES: ['January','February','March','April','May','June','July','August','September','October','November','December'],
  YEAR_LABEL: ' ',
  MONTH_LABEL: ' ',
  WEEKDAY_ABBRS: ['Sun','Mon','Tue','Wed','Thr','Fri','Sat'],
  WEEKDAY_NAMES: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
  YEAR_AND_MONTH: false
};

ProtoCalendar.LangFile.defaultLang = 'en';
ProtoCalendar.LangFile.defaultLangFile = function() { return ProtoCalendar.LangFile[defaultLang]; };

Object.extend(ProtoCalendar, {
                JAN: 0,
                FEB: 1,
                MAR: 2,
                APR: 3,
                MAY: 4,
                JUNE: 5,
                JULY: 6,
                AUG: 7,
                SEPT: 8,
                OCT: 9,
                NOV: 10,
                DEC: 11,

                SUNDAY: 0,
                MONDAY: 1,
                TUESDAY: 2,
                WEDNESDAY: 3,
                THURSDAY: 4,
                FRIDAY: 5,
                SATURDAY: 6,

                getNumDayOfMonth: function(year, month){
                  return 32 - new Date(year, month, 32).getDate();
                },

                getDayOfWeek: function(year, month, day) {
                  return new Date(year, month, day).getDay();
                }
              });

ProtoCalendar.prototype = {
  initialize: function(options) {
    var date = new Date();
    this.options = Object.extend({
                                   month: date.getMonth(),
                                   year: date.getFullYear(),
                                   lang: ProtoCalendar.LangFile.defaultLang
                                 }, options || { });
    var getHolidays = ProtoCalendar.LangFile[this.options.lang]['getHolidays'];
    if (getHolidays) {
      this.initializeHolidays = getHolidays.bind(top, this);
    } else {
      this.initializeHolidays = function() { this.holidays = []; };
    }
    this.date = new Date(this.options.year, this.options.month, 1);
  },

  getMonth: function() {
    return this.date.getMonth();
  },

  getYear: function() {
    return this.date.getFullYear();
  },

  invalidate: function() {
    this.holidays = undefined;
  },

  setMonth: function(month) {
    if (month != this.getMonth()) {
      this.invalidate();
    }
    return this.date.setMonth(month);
  },

  setYear: function(year) {
    if (year != this.getYear()) {
      this.invalidate();
    }
    return this.date.setFullYear(year);
  },

  getDate: function() {
    return this.date;
  },

  setDate: function(date) {
    this.invalidate();
    this.date = date;
  },

  setYearByOffset: function(offset) {
    if (offset != 0) {
      this.invalidate();
    }
    this.date.setFullYear(this.date.getFullYear() + offset);
  },

  setMonthByOffset: function(offset) {
    if (offset != 0) {
      this.invalidate();
    }
    this.date.setMonth(this.date.getMonth() + offset);
  },

  getNumDayOfMonth: function() {
    return ProtoCalendar.getNumDayOfMonth(this.getYear(), this.getMonth());
  },

  getDayOfWeek: function(day) {
    return ProtoCalendar.getDayOfWeek(this.getYear(), this.getMonth(), day);
  },

  clone: function() {
    return new ProtoCalendar({year: this.getYear(), month: this.getMonth()});
  },

  getHoliday: function(day) {
    if(!this.holidays) { this.initializeHolidays();}
    var holiday = this.holidays[day];
    return holiday? holiday : false;
  },

  initializeHolidays: function() {
  }
};

var AbstractProtoCalendarRender = Class.create();
Object.extend(AbstractProtoCalendarRender, {
                id: 1,
                WEEK_DAYS_SUNDAY: [ 0, 1, 2, 3, 4, 5, 6 ],
                WEEK_DAYS_MONDAY: [ 1, 2, 3, 4, 5, 6, 0 ],
                WEEK_DAYS_INDEX_SUNDAY: [ 0, 1, 2, 3, 4, 5, 6 ],
                WEEK_DAYS_INDEX_MONDAY: [ 6, 0, 1, 2, 3, 4, 5 ],

                getId: function() {
                  var id = AbstractProtoCalendarRender.id;
                  AbstractProtoCalendarRender.id += 1;
                  return id;
                }
               });

AbstractProtoCalendarRender.prototype = {
  initialize: function(options) {
    this.id = AbstractProtoCalendarRender.getId();
    this.options = Object.extend({
                                   weekFirstDay : ProtoCalendar.MONDAY,
                                   yearSpan: 10,
                                   containerClass: 'cal-container',
                                   tableClass: 'cal-table',
                                   headerClass: 'cal-header',
                                   bodyClass: 'cal-body',
                                   footerClass: 'cal-footer',
                                   selectYearClass: 'cal-select-year',
                                   selectYearId: this.getIdPrefix() + "-select-year",
                                   selectMonthClass: 'cal-select-month',
                                   selectMonthId: this.getIdPrefix() + "-select-month",
                                   labelRowClass: 'cal-label-row',
                                   labelCellClass: 'cal-label-cell',
                                   nextButtonClass: 'cal-next-btn',
                                   prevButtonClass: 'cal-prev-btn',
                                   dayCellClass: 'cal-day-cell',
                                   dayClass: 'cal-day',
                                   weekdayClass: 'cal-weekday',
                                   sundayClass: 'cal-sunday',
                                   saturdayClass: 'cal-saturday',
                                   holidayClass: 'cal-holiday',
                                   otherdayClass: 'cal-otherday',
                                   selectedDayClass: 'cal-selected',
                                   nextBtnId: this.getIdPrefix() + "-next-btn",
                                   prevBtnId: this.getIdPrefix() + "-prev-btn",
                                   lang: ProtoCalendar.LangFile.defaultLang
                                 }, options || {});
    this.langFile = ProtoCalendar.LangFile[this.options.lang];
    this.weekFirstDay = this.options.weekFirstDay;
    this.initWeekData();
    this.container = this.createContainer();
    this.alignTo = $(this.options.alignTo);
    if (navigator.appVersion.match(/\bMSIE\b/)) {
      this.iframe = this.createIframe();
    }
  },

  createContainer: function() {
    var container = $(document.createElement('div'));
    container.addClassName(this.options.containerClass);
    container.setStyle({position:'absolute',
                        top: "0px",
                        left: "0px",
                        zindex:1,
                        display: 'none'});
    container.hide();
    document.body.appendChild(container);
    return container;
  },

  createIframe: function() {
    var iframe = document.createElement("iframe");
    iframe.setAttribute("src", "javascript:false;");
    iframe.setAttribute("frameBorder", "0");
    iframe.setAttribute("scrolling", "no");
    Element.setStyle(iframe, { position:'absolute',
                               top: "0px",
                               left: "0px",
                               zindex:10,
                               display: 'none',
                               overflow: 'hidden',
                               filter: 'progid:DXImageTransform.Microsoft.Alpha(opacity=0)'
                             });
    document.body.appendChild(iframe);
    return $(iframe);
  },

  getWeekdayLabel: function(weekday) {
    return this.langFile.WEEKDAY_ABBRS[weekday];
  },

  getWeekdays: function() {
    return this.weekdays;
  },

  initWeekData: function() {
    if (this.weekFirstDay == ProtoCalendar.SUNDAY) {
      this.weekLastDay = ProtoCalendar.SATURDAY;
      this.weekdays = AbstractProtoCalendarRender.WEEK_DAYS_SUNDAY;
      this.weekdaysIndex = AbstractProtoCalendarRender.WEEK_DAYS_INDEX_SUNDAY;
    } else {
      this.weekFirstDay == ProtoCalendar.MONDAY
      this.weekLastDay = ProtoCalendar.SUNDAY;
      this.weekdays = AbstractProtoCalendarRender.WEEK_DAYS_MONDAY;
      this.weekdaysIndex = AbstractProtoCalendarRender.WEEK_DAYS_INDEX_MONDAY;
    }
  },

  getProtoCalendarBeginDay: function(calendar) {
    var offset = this.getDayIndexOfWeek(calendar, 1);
    var date = new Date(calendar.getYear(), calendar.getMonth(), 1 - offset);
    return date;
  },

  getProtoCalendarEndDay: function(calendar) {
    var lastDayOfMonth = calendar.getNumDayOfMonth();
    var offset = 6 - this.getDayIndexOfWeek(calendar, lastDayOfMonth);
    var date = new Date(calendar.getYear(), calendar.getMonth(), lastDayOfMonth + offset + 1);
    return date;
  },

  getDayIndexOfWeek: function(calendar, day) {
    return this.weekdaysIndex[ calendar.getDayOfWeek(day) ];
  },

  getIdPrefix: function() {
    return 'cal' + this.id;
  },

  getDayDivId: function(date) {
    return this.getIdPrefix() + '-month' + date.getMonth() + '-day' + date.getDate();
  },

  setPosition: function() {
    if (!this.alignTo) return;
    setAlignment(this.alignTo, this.container);
    if (this.iframe) {
      var dimensions = Element.getDimensions(this.container);
      this.iframe.setAttribute("width", dimensions.width);
      this.iframe.setAttribute("height", dimensions.height);
      setAlignment(this.alignTo, this.iframe);
    }
  },

  show: function() {
   this.setPosition();
    if (typeof Effect != 'undefined') {
      new Effect.Appear(this.container, {duration: 0.5});
    } else {
      this.container.show();
    }
    if (this.iframe) this.iframe.show();
  },

  hide: function() {
    this.container.hide();
    if (this.iframe) this.iframe.hide();
  },

  toggle: function(element) {
    this.container.visible() ? this.hide() : this.show();
  },

  render: function(calendar) { },

  getContainer: function() {
    return this.container;
  },

  getPrevButton: function() {
    return $(this.options.prevBtnId);
  },

  getNextButton: function() {
    return $(this.options.nextBtnId);
  },

  getSelectYear: function() {
    return $(this.options.selectYearId);
  },

  getSelectMonth: function() {
    return $(this.options.selectMonthId);
  },

  getDayDivs: function() {
    return this.container.getElementsBySelector("a." + this.options.dayClass);
  }

};

var ProtoCalendarRender = Class.create();
Object.extend(ProtoCalendarRender.prototype, AbstractProtoCalendarRender.prototype);

Object.extend(
  ProtoCalendarRender.prototype,
  {
    render: function(calendar) {
      var html = '';
      html += this.renderHeader(calendar);
      html += '<div class="#{bodyClass}"><table class="#{tableClass}" cellspacing="0">';
      html += this.renderBody(calendar);
      html += '</table></div>';
      html += this.renderFooter(calendar);
      var template = new Template(html);
      this.container.innerHTML = template.evaluate(this.options);
      this.getSelectMonth().selectedIndex = calendar.getMonth();
    },

    renderHeader: function(calendar) {
      var html = '';
      // required 'href'
      html += '<div class="#{headerClass}">' +
        '<a href="javascript:void(0);" id="#{prevBtnId}" class="#{prevButtonClass}">&lt;&lt;</a>' +
        this.createSelect(calendar.getYear(), calendar.getMonth()) +
        '<a href="javascript:void(0);" id="#{nextBtnId}" class="#{nextButtonClass}">&gt;&gt;</a>' +
        '</div>';
      return html;
    },

    renderFooter: function(calendar) {
      return '<div class="#{footerClass}"></div>';
    },

    createSelect: function(year, month) {
      var yearPart = this.createYearSelect(year) + this.langFile.YEAR_LABEL;
      var monthPart = this.createMonthSelect(month) + this.langFile.MONTH_LABEL;
      if (this.langFile.YEAR_AND_MONTH) {
        return  yearPart + monthPart;
      } else {
        return monthPart + yearPart;
      }
    },

    createYearSelect: function(year) {
      var html = '';
      html += '<select id="#{selectYearId}" class="#{selectYearClass}">';
      var span = this.options.yearSpan;
      for (var y = year - span, i = 0; y <= year + span; y += 1, i += 1) {
        html += '<option value="' + y + '"' + (y == year ? ' selected' : '') + '>' + y + '</option>';
      }
      html += '</select>';
      return html;
    },

    createMonthSelect: function(month) {
      if (!this.monthSelectHtml) {
        var html = '';
        html += '<select id="#{selectMonthId}" class="#{selectMonthClass}">';
        for (var m = ProtoCalendar.JAN; m <= ProtoCalendar.DEC; m += 1) {
          html += '<option value="' + m + '"' + (m == month ? ' selected' : '') + '>' + this.langFile['MONTH_ABBRS'][m] + '</option>';
        }
        html += '</select>';
        this.monthSelectHtml = html;
      }
      return this.monthSelectHtml;
    },

    renderBody: function(calendar) {
      var html = '';
      html += '<tr class="#{labelRowClass}">';
      var othis = this;
      if (!this.headHtml) {
        this.headHtml = '';
        $A(this.getWeekdays()).each(function(weekday) {
                                      var exClassName = '';
                                      if (weekday == ProtoCalendar.SUNDAY) { exClassName = ' #{sundayClass}'; }
                                      if (weekday == ProtoCalendar.SATURDAY) { exClassName = ' #{saturdayClass}'; }
                                      othis.headHtml += '<th class="#{labelCellClass}' + exClassName + '">' +
                                        othis.getWeekdayLabel(weekday) +
                                        '</th>';
                                    });
      }
      html += this.headHtml;
      var curDay = this.getProtoCalendarBeginDay(calendar);
      var calEndDay = this.getProtoCalendarEndDay(calendar);
      html += '<tbody>';
      var dayNum = Math.round((calEndDay - curDay) / 1000 / 60 / 60 / 24);
      for(var i = 0; i < dayNum; i += 1, curDay.setDate(curDay.getDate() + 1)) {
        var divClassName;
        var holiday = calendar.getHoliday(curDay.getDate());
        if(curDay.getMonth() != calendar.getMonth()) {
          divClassName = this.options.otherdayClass;
        } else if (holiday) {
          divClassName = this.options.holidayClass;
        } else if (curDay.getDay() == ProtoCalendar.SUNDAY) {
          divClassName = this.options.sundayClass;
        } else if (curDay.getDay() == ProtoCalendar.SATURDAY) {
          divClassName = this.options.saturdayClass;
        } else {
          divClassName = this.options.weekdayClass;
        }

        if (curDay.getDay() == this.weekFirstDay) { html += '<tr>'; }
        html += '<td class="' + divClassName + ' #{dayCellClass}">' +
          '<a class="#{dayClass}" href="javascript:void(0)" id="' + this.getDayDivId(curDay) +
          (holiday ? '" title="' + holiday : '') +
          '" year="' + curDay.getFullYear() +
          '" month="' + curDay.getMonth() +
          '" day="' + curDay.getDate() +
          '">' + curDay.getDate() + '</a>';

        if (curDay.getDay() == this.weekLastDay) { html += '</tr>'; }
      }
      html += '</tbody>';
      return html;
    },

    getDayDivs: function() {
      return this.container.getElementsBySelector("a." + this.options.dayClass);
    }
  });


var ProtoCalendarController = Class.create();

//Object.extend(ProtoCalendarController, { });

ProtoCalendarController.prototype = {
  initialize: function(calendarRender, options) {
    var today = new Date();
    this.options = Object.extend({ year : today.getFullYear(),
                                   month : today.getMonth(),
                                   day : today.getDate()
                                 }, options || {});
    this.calendarRender = calendarRender;
    this.calendar = new ProtoCalendar(options);
    this.calendarRender.render(this.calendar);
    this.selectDate(new Date(this.options.year, this.options.month, this.options.day));
    this.observeEvents();
    this.onChangeHandlers = [];
  },

  observeEvents: function() {
    var calrndr = this.calendarRender;
    calrndr.getPrevButton().observe('click', this.showPrevMonth.bindAsEventListener(this));
    calrndr.getNextButton().observe('click', this.showNextMonth.bindAsEventListener(this));
    var othis = this;
    var selectYear = calrndr.getSelectYear();
    var selectMonth = calrndr.getSelectMonth();
    var year = this.calendar.getYear();
    var month = this.calendar.getMonth();
    selectYear.observe('change', function() {
                         othis.setMonth(parseInt(selectYear[selectYear.selectedIndex].value), month);
                       });
    selectMonth.observe('change', function() {
                          othis.setMonth(year, parseInt(selectMonth[selectMonth.selectedIndex].value));
                       });
    var handler = this.onClickHandler;
    calrndr.getDayDivs().each(function(el) {
                                            el.observe('click', handler.bindAsEventListener(othis));
                                          });
  },

  onClickHandler: function(event) {
    this.selectDate(this.__getDateFromEl(Event.element(event)));
    this.onChangeHandler();
    this.hideProtoCalendar();
  },

  selectDate: function(date) {
    if (this.selectedDate) {
      var dateEl = $(this.calendarRender.getDayDivId(this.selectedDate));
      if (dateEl) dateEl.removeClassName(this.calendarRender.options.selectedDayClass);
    }
    this.selectedDate = date;
    if (!date) return;
//     if (date.getFullYear() != this.calendar.getYear() || date.getMonth() != this.calendar.getMonth()) {
//       this.setMonth(date.getFullYear(), date.getMonth());
//     }
    var dayEl = $(this.calendarRender.getDayDivId(date));
    if (dayEl) dayEl.addClassName(this.calendarRender.options.selectedDayClass);
  },

  __getDateFromEl: function(el) {
    var element = $(el);
    return new Date(element.readAttribute('year'), element.readAttribute('month'), element.readAttribute('day'));
  },

  getSelectedDate: function() {
    return this.selectedDate;
  },

  addChangeHandler: function(func) {
    this.onChangeHandlers.push(func);
  },

  onChangeHandler: function() {
    this.onChangeHandlers.each(function(f) { f(); });
  },

  showProtoCalendar: function() {
    this.calendarRender.show();
  },

  hideProtoCalendar: function() {
    this.calendarRender.hide();
  },

  toggleProtoCalendar: function() {
    this.calendarRender.toggle();
  },

  showPrevMonth: function(event) {
    this.shiftMonthByOffset(-1);
    if (event) Event.stop(event);
  },

  showNextMonth: function(event) {
    this.shiftMonthByOffset(1);
    if (event) Event.stop(event);
  },

  shiftMonthByOffset: function(offset) {
    this.calendar.setMonthByOffset(offset);
    this.afterSet();
  },

  setMonth: function(year, month) {
    this.calendar.setYear(year);
    this.calendar.setMonth(month);
    this.afterSet();
  },

  afterSet: function() {
    this.calendarRender.render(this.calendar);
    this.selectDate(this.selectedDate);
    this.observeEvents();
  },

  getContainer: function() {
    return this.calendarRender.getContainer();
  }
};

var InputCalendar = Class.create();
InputCalendar.prototype = {
  initialize: function(input, options) {
    this.input = $(input);
    if (!options) options = {};
    this.options = Object.extend({
                                   format: ProtoCalendar.LangFile[options.lang || ProtoCalendar.LangFile.defaultLang]['DEFAULT_FORMAT'],
                                   lang: ProtoCalendar.LangFile.defaultLang,
                                   inputReadOnly: false,
                                   alignTo: input,
                                   labelFormat: undefined,
                                   labelEl: undefined
                                 }, options || { });
    this.calendarController = new ProtoCalendarController(new ProtoCalendarRender(this.options), this.options);
    this.dateFormat = new DateFormat(this.options.format);
    this.langFile = ProtoCalendar.LangFile[this.options.lang] || ProtoCalendar.LangFile.defaultLangFile();
    if (this.input.value && this.dateFormat.parse(this.input.value)) {
      this.onInputChange();
    } else {
      //this.onProtoCalendarChange();
    }
    if (this.options.inputReadOnly) this.input.setAttribute('readOnly', this.options.inputReadOnly);
    this.observeEvents();
    this.triggers = [];
    this.labelFormat = new DateFormat(this.options.labelFormat || this.langFile['LABEL_FORMAT']);
    var labelElm = $(this.options.labelEl);
    if ((! labelElm) && this.options.labelFormat) {
      var labelId = this.input.id + '_label';
      new Insertion.After(this.input, "<div id='" + labelId + "'></div>");
      labelElm = $(labelId);
    }
    this.labelEl = labelElm;
    this.changeLabel();
  },

  addTrigger: function(el) {
    this.triggers.push($(el));
    $(el).setStyle({'cursor': 'pointer'});
  },

  observeEvents: function() {
    this.input.observe('change', this.onInputChange.bind(this));
    this.input.observe('focus', this.calendarController.showProtoCalendar.bind(this.calendarController));
    Event.observe(document, 'click', this.windowClickHandler.bindAsEventListener(this));
    this.calendarController.addChangeHandler(this.onProtoCalendarChange.bind(this));
  },

  windowClickHandler: function(event) {
    var target = $(Event.element(event));
    if (this.triggers.include(target)) {
      this.calendarController.toggleProtoCalendar();
    } else if (target != this.input && !Element.descendantOf(target, this.calendarController.getContainer())) {
      this.calendarController.hideProtoCalendar();
    }
  },

  onInputChange: function() {
    var date = this.dateFormat.parse(this.input.value);
    if (date) {
      this.calendarController.selectDate(date);
    } else {
      var inputValue = this.input.value.toLowerCase();
      var date;
      if (this.langFile['today'] && this.langFile['today'] == inputValue || inputValue == 'today') {
        date = new Date();
      } else if (this.langFile['tomorrow'] && this.langFile['tomorrow'] == inputValue || inputValue == 'tomorrow') {
        date = new Date();
        date.setDate(date.getDate() + 1);
      } else if (this.langFile['yesterday'] && this.langFile['yesterday'] == inputValue || inputValue == 'yesterday') {
        date = new Date();
        date.setDate(date.getDate() - 1);
      } else if (this.langFile.parseDate && (date = this.langFile.parseDate(inputValue))) {
        //done is parseDate
      } else {
        date = undefined;
      }
      this.calendarController.selectDate(date);
      this.onProtoCalendarChange();
    }
    this.changeLabel();
  },

  onProtoCalendarChange: function() {
    this.input.value = this.dateFormat.format(this.calendarController.getSelectedDate(), this.options.lang);
    this.changeLabel();
  },

  changeLabel: function() {
    if (!this.labelEl) return;
    if (!this.calendarController.getSelectedDate()) {
      this.labelEl.innerHTML = this.labelFormat.dateFormat;
    } else {
      this.labelEl.innerHTML = this.labelFormat.format(this.calendarController.getSelectedDate(), this.options.lang);
    }
  }
};

function setAlignment(alignTo, element) {
  var offsets = Position.cumulativeOffset(alignTo);
  element.setStyle({left: offsets[0] + "px", top: (offsets[1] + alignTo.offsetHeight) + "px"});
}


var DateFormat = Class.create();

Object.extend(DateFormat,
              {
                MONTH_ABBRS: ProtoCalendar.LangFile.en.MONTH_ABBRS,
                MONTH_NAMES: ProtoCalendar.LangFile.en.MONTH_NAMES,
                WEEKDAY_ABBRS: ProtoCalendar.LangFile.en.WEEKDAY_ABBRS,
                WEEKDAY_NAMES: ProtoCalendar.LangFile.en.WEEKDAY_NAMES,
                formatRegexp: /\b(?:d{1,4}|d{3,4}i|m{1,4}|yy(?:yy)?|([hHMs])\1?|TT|tt|[lL])\b|.+?/g,
                zeroize: function (value, length) {
                  if (!length) length = 2;
                  value = String(value);
                  for (var i = 0, zeros = ''; i < (length - value.length); i++) {
                    zeros += '0';
                  }
                  return zeros + value;
                }
              });

DateFormat.prototype =  {
  initialize: function(format) {
    this.dateFormat = format;
    this.parserInited = false;
    this.formatterInited = false;
  },

  format: function(date, lang) {
    if (!this.formatterInited) this.initFormatter();
    if (!date) return '';
    var langFile = ProtoCalendar.LangFile[lang || ProtoCalendar.LangFile.defaultLang];
    var str = '';
    this.formatHandlers.each(function(f) {
                               str += f(date, langFile);
                             });
    return str;
  },

  initFormatter: function() {
    var handlers = [];
    var matches = this.dateFormat.match(DateFormat.formatRegexp);
    for (var i = 0, n = matches.length; i < n; i++) {
      switch(matches[i]) {
      case 'd':       handlers.push(function(date, lf) { return date.getDate(); }); break;
      case 'dd':      handlers.push(function(date, lf) { return DateFormat.zeroize(date.getDate()) }); break;
      case 'ddd':     handlers.push(function(date, lf) { return DateFormat.WEEKDAY_ABBRS[date.getDay()]; }); break;
      case 'dddd':    handlers.push(function(date, lf) { return DateFormat.WEEKDAY_NAMES[date.getDay()]; }); break;
      case 'dddi':    handlers.push(function(date, lf) { return lf.WEEKDAY_ABBRS[date.getDay()]; }); break;
      case 'ddddi':   handlers.push(function(date, lf) { return lf.WEEKDAY_NAMES[date.getDay()]; }); break;
      case 'm':       handlers.push(function(date, lf) { return date.getMonth() + 1; }); break;
      case 'mm':      handlers.push(function(date, lf) { return DateFormat.zeroize(date.getMonth() + 1); }); break;
      case 'mmm':     handlers.push(function(date, lf) { return lf.MONTH_ABBRS[date.getMonth()]; }); break;
      case 'mmmm':    handlers.push(function(date, lf) { return (lf.MONTH_NAMES || DateFormat)[date.getMonth()]; }); break;
      case 'yy':      handlers.push(function(date, lf) { return String(date.getFullYear()).substr(2); }); break;
      case 'yyyy':    handlers.push(function(date, lf) { return date.getFullYear(); }); break;
      case 'h':       handlers.push(function(date, lf) { return date.getHours() % 12 || 12; }); break;
      case 'hh':      handlers.push(function(date, lf) { return DateFormat.zeroize(date.getHours() % 12 || 12); }); break;
      case 'H':       handlers.push(function(date, lf) { return date.getHours(); }); break;
      case 'HH':      handlers.push(function(date, lf) { return DateFormat.zeroize(date.getHours()); }); break;
      case 'M':       handlers.push(function(date, lf) { return date.getMinutes(); }); break;
      case 'MM':      handlers.push(function(date, lf) { return DateFormat.zeroize(date.getMinutes()); }); break;
      case 's':       handlers.push(function(date, lf) { return date.getSeconds(); }); break;
      case 'ss':      handlers.push(function(date, lf) { return DateFormat.zeroize(date.getSeconds()); }); break;
      case 'l':       handlers.push(function(date, lf) { return DateFormat.zeroize(date.getMilliseconds(), 3); }); break;
      case 'tt':      handlers.push(function(date, lf) { return date.getHours() < 12 ? 'am' : 'pm'; }); break;
      case 'TT':      handlers.push(function(date, lf) { return date.getHours() < 12 ? 'AM' : 'PM'; }); break;
      default:        handlers.push(createIdentity(matches[i]));
      }
    };
    this.formatHandlers = handlers;
    this.formatterInited = true;
  },

  parse: function(str) {
    if (!this.parserInited) this.initParser();
    if (!str) return undefined;
    var results = str.match(this.parserRegexp);
    if (!results) return undefined;
    var date = new Date();
    var handler;
    for (var i = 0, n = this.parseHandlers.length; i < n; i++) {
      if (this.parseHandlers[i] != undefined) {
        (this.parseHandlers[i])(date, results[i+1]);
      }
    }
    this.parseCallback(date);
    return date;
  },

  initParser: function() {
    var handlers = [];
    var regstr = '';
    var matches = this.dateFormat.match(DateFormat.formatRegexp);
    var hour, ampm;

    for (var i = 0, n = matches.length; i < n; i++) {
      regstr += '(';
      switch(matches[i]) {
      case 'd':
      case 'dd':      regstr += '\\d{1,2}';
                      handlers.push(function(date, value) { date.setDate(value); });
                      break;
      case 'm':
      case 'mm':      regstr += '\\d{1,2}';
                      handlers.push(function(date, value) { date.setMonth(parseInt(value) - 1);});
                      break;
//       case 'mmm':     regstr += DateFormat.MONTH_ABBRS.join('|');
//                       handlers.push(function(date, value) {
//                                       date.setMonth(DateFormat.MONTH_ABBRS.indexOf(value)); });
//                       break;
//       case 'mmmm':    regstr += DateFormat.MONTH_NAMES.join('|');
//                       handlers.push(function(date, value) {
//                                       date.setMonth(DateFormat.MONTH_NAMES.indexOf(value)); });
//                       break;
      case 'yy':      regstr += '\\d{2}';
                      handlers.push(function(date, value) {
                                      var year = parseInt(value);
                                      year = year < 70 ? 2000 + year : 1900 + year;
                                      date.setFullYear(year); });
                      break;
      case 'yyyy':    regstr += '\\d{4}';
                      handlers.push(function(date, value) { date.setFullYear(value); });
                      break;
      case 'h':
      case 'hh':      hour = true;
                      regstr += '\\d{1,2}';
                      handlers.push(function(date, value) {
                                      value = value % 12 || 0;
                                      date.setHours(value);
                                      });
                      break;
      case 'H':
      case 'HH':      regstr += '\\d{1,2}';
                      handlers.push(function(date, value) { date.setHours(value); });
                      break;
      case 'M':
      case 'MM':      regstr += '\\d{1,2}';
                      handlers.push(function(date, value) { date.setMinutes(value); });
                      break;
      case 's':
      case 'ss':      regstr += '\\d{1,2}';
                      handlers.push(function(date, value) { date.setSeconds(value); });
                      break;
      case 'l':       regstr += '\\d{1,3}';
                      handlers.push(function(date, value) { date.setMilliSeconds(value); });
                      break;
      case 'tt':      regstr += 'am|pm';
                      handlers.push(function(date, value) { ampm = value; });
                      break;
      case 'TT':      regstr += 'AM|PM';
                      handlers.push(function(date, value) { ampm = value.toLowerCase(); });
                      break;
      case 'mmm':
      case 'mmmm':
      case 'ddd':
      case 'dddd':
      case 'dddi':
      case 'ddddi':   regstr += '.+?';
                      handlers.push(undefined);
                      break;

      default:        regstr += matches[i];
                      handlers.push(undefined);
      }
      regstr += ')';
    }
    this.parserRegexp = new RegExp(regstr);
    this.parseHandlers = handlers;

    if (ampm == 'pm' && hour) {
      this.parseCallback = this.normalizeHour.bind(this);
    } else {
      this.parseCallback = function() {};
    }
    this.parserInited = true;
  },

  normalizeHour: function(date) {
    var hour = date.getHours();
    hour = hour == 12 ? 0 : hour + 12;
    date.setHours(hour);
  }
};

function createIdentity(v) {
  return function() { return v; }
}
