/**
 *  Yahho Calendar - Japanized Popup Calendar
 *  @see       http://0-oo.net/sbox/javascript/yahho-calendar
 *  @version   0.4.0 beta 2
 *  @copyright 2008-2009 dgbadmin@gmail.com
 *  @license   http://0-oo.net/pryn/MIT_license.txt (The MIT license)
 *
 *  See also
 *  @see http://developer.yahoo.com/yui/calendar/
 *  @see http://developer.yahoo.com/yui/docs/YAHOO.widget.Calendar.html
 */

var YahhoCal = {
    /**
     *  loadYUI()���ɤ߹���YUI��URL
     *  @see http://developer.yahoo.com/yui/articles/hosting/
     *  @see http://code.google.com/intl/ja/apis/ajaxlibs/documentation/#yui
     */
    YUI_URL: {
        SERVER: location.protocol + "//ajax.googleapis.com/ajax/libs/yui/",
        VERSION: "2.7.0",
        DIR: "/build/"
    },
    
    /** ���������θ����ܤ����� */
    CAL_STYLE: {
        //����IE6�ǽ̤ޤ�Τ��ɤ���
        "": "width: 13em",
        //������
        "td.wd0 a.selector": "background-color: #fcf",
        //������
        "td.wd6 a.selector": "background-color: #cff",
        //�������� GCalHolidays��
        "td.holiday a.selector": "background-color: #f9f",
        //����
        "td.today a.selector": "",
        //���򤵤줿��
        "td.selected a.selector": "background-color: #0f0",
        //�����ǽ�����դ��ϰϳ������ʺ����������ʤ�Τ��ɤ���
        "td.previous": "background-color: #fff"
    },
    
    /** �ϰ��YUI_CAL_CONFIG�Τɤ��Ȥ����λ���� */
    locale: "ja",

    /** YUI������������ */
    YUI_CAL_CONFIG: {
        //�Ѹ�
        en: {},
        //���ܸ�
        ja: {
            my_label_year_position: 1,
            my_label_year_suffix: "ǯ ",
            my_label_month_suffix: "��",
            months_long: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            weekdays_short: ["��", "��", "��", "��", "��", "��", "��"]
        },
        //�ڹ��
        ko: {
            my_label_year_position: 1,
            my_label_year_suffix: "&#xb144; ",
            my_label_month_suffix: "&#xc6d4;",
            months_long: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            weekdays_short: [
                "&#xc77c;", "&#xc6d4;", "&#xd654;", "&#xc218;", "&#xbaa9;",
                "&#xae08;", "&#xd1a0;"
            ]
        },
        //����
        zh: {
            my_label_year_position: 1,
            my_label_year_suffix: "ǯ ",
            my_label_month_suffix: "��",
            months_long: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            weekdays_short: ["��", "��", "��", "��", "��", "��", "ϻ"]
        },
        //���ڥ����
        es: {
            months_long: [
                "enero", "febrero", "marzo", "abril", "mayo", "junio",
                "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
            ],
            weekdays_short: ["do", "lu", "ma", "mi", "ju", "vi", "sa"]
        },
        //�ݥ�ȥ����
        pt: {
            months_long: [
                "Janeiro", "Fevereiro", "Mar���o", "Abril", "Maio", "Junho",
                "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
            ],
            weekdays_short: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sa"]
        }
    },
    
    //�������Ǥ��åפ��륢���ץ�
    adapters: {}
};
/**
 *  ����������ɽ������
 *  @param  String  inputId �������Ǥ�id or ǯ���������Ǥ�id
 *  @param  String  monthId (optional) ����������Ǥ�id
 *  @param  String  dateId  (optional) �����������Ǥ�id
 *  @return Boolean ����������ɽ�����Ǥ������ɤ���
 */
YahhoCal.render = function(inputId, monthId, dateId) {
    if (!window.YAHOO || !YAHOO.widget.Calendar) {  //YUI���ɤ߹���Ǥ��ʤ����
        return false;
    }
    
    var currentId = (this.currentId = dateId || inputId);   //�������Ǥ����ꤹ��ID

    //�����ץ������
    if (!this.adapters[currentId]) {
        this.adapters[currentId] = this.createAdapter(inputId, monthId, dateId);
    }
    var adapter = this.adapters[currentId];

    var cal = this.cal;
    if (cal) {  //��ɽ���ξ��
        cal.hide();
        YAHOO.util.Dom.insertAfter(this.place, currentId);
        cal.show();
    } else {    //����ɽ��������
        this.setStyle();
        cal = (this.cal = this.createCalendar(currentId));
    }

    //���ϺѤߤ����դ����
    var val = adapter.getDate();
    var y = val[0], m = val[1], d = val[2];
    var shown = new Date(y, m - 1, d);

    //ɽ������
    var pagedate = "", selected = "";
    if ((shown.getFullYear() == y && shown.getMonth() + 1 == m && shown.getDate() == d)) {
        //���դȤ������������
        pagedate = m + "/" + y;
        selected = m + "/" + d + "/" + y;
    } else {
        shown = new Date();
    }
    cal.cfg.setProperty("pagedate", pagedate);  //ɽ������ǯ��
    cal.cfg.setProperty("selected", selected);  //������֤�����

    cal.render();

    this.showHolidays(shown);
    
    //����������ɽ��������äƤ��饯��å����٥�Ȥ���ª��Ϥ��
    setTimeout(function() {
        YAHOO.util.Event.addListener(document, "click", YahhoCal.clickListener);
    }, 1);
    
    return true;
};
/**
 *  �������Ǥȥ��������ȤΥݥ��ե�����ʥ����ץ�����������
 */
YahhoCal.createAdapter = function(inputId, monthId, dateId) {
    var adapter = {};

    if (!monthId) {     //�ƥ����ȥܥå���1�Ĥξ���YYYY/M/D��
        var ymd = document.getElementById(inputId);
        adapter.getDate = function() { return ymd.value.split("/"); };
        adapter.setDate = function(y, m, d) { ymd.value = y + "/" + m + "/" + d; };
        return adapter;
    }
    
    //ǯ�������ʬ����Ƥ�����
    var ey = document.getElementById(inputId);
    var em = document.getElementById(monthId);
    var ed = document.getElementById(dateId);

    if (ey.tagName == "INPUT") {    //�ƥ����ȥܥå����ξ��
        adapter.getDate = function() { return [ey.value, em.value, ed.value]; };
        adapter.setDate = function(y, m, d) { ey.value = y; em.value = m; ed.value = d; };
        return adapter;
    }
    
    //����ꥹ�Ȥξ��
    var getNumber = function(opt) { return (opt.value || opt.text).replace(/^0+/, ""); };
    var get = function(sel) { return getNumber(sel.options[sel.selectedIndex]); };
    var set = function(sel, value) {
        for (var i = 0, len = sel.length; i < len; i++) {
            if (getNumber(sel.options[i]) == value) {
                sel.options[i].selected = true;
                return;
            }
        }
    };
    adapter.getDate = function() { return [get(ey), get(em), get(ed)]; };
    adapter.setDate = function(y, m, d) { set(ey, y); set(em, m); set(ed, d); };
    return adapter;
};
/**
 *  style�����ꤹ��
 */
YahhoCal.setStyle = function() {
    var css = "";
    for (var target in this.CAL_STYLE) {
        css += ".yui-skin-sam .yui-calcontainer .yui-calendar " + target;
        css += "{" + this.CAL_STYLE[target] + "}";
    }
    
    var tmp = document.createElement("div");
    tmp.innerHTML = 'dummy<style type="text/css">' + css + "</style>";

    document.getElementsByTagName("head")[0].appendChild(tmp.lastChild);
};
/**
 *  ������������������
 */
YahhoCal.createCalendar = function(insertId) {
    var yDom = YAHOO.util.Dom;
    
    //YUI skin��Ŭ��
    yDom.addClass(document.body, "yui-skin-sam");

    //���������ξ�����
    var place = (this.place = document.createElement("div"));
    yDom.setStyle(place, "position", "absolute");
    yDom.setStyle(place, "z-index", 1);
    yDom.insertAfter(place, insertId);

    //������������
    var config = this.YUI_CAL_CONFIG[this.locale];
    config.close = true;
    config.hide_blank_weeks = true;
    var cal = new YAHOO.widget.Calendar(place, config);

    //���դ����򤵤줿���Υ��٥��
    cal.selectEvent.subscribe(function(eventName, selectedDate) {
        var date = selectedDate[0][0];
        YahhoCal.adapters[YahhoCal.currentId].setDate(date[0], date[1], date[2]);
        cal.hide();
    });

    //����ư�������Υ��٥��
    cal.changePageEvent.subscribe(function() {
        YahhoCal.showHolidays(cal.cfg.getProperty("pagedate"));
    });

    //�Ĥ������Υ��٥��
    cal.hideEvent.subscribe(function() {
        YAHOO.util.Event.removeListener(document, "click", YahhoCal.clickListener);
    });
    
    return cal;
};
/**
 *  ������ɽ������
 */
YahhoCal.showHolidays = function(target) {
    if (!window.GCalHolidays) {     //GCalHolidays.js���ɤ߹���Ǥ��ʤ����
        return;
    }
    GCalHolidays.get(this.setHolidays, target.getFullYear(), target.getMonth() + 1);
};
/**
 *  ����ɽ�������ꤹ��
 */
YahhoCal.setHolidays = function(holidays) {
    if (holidays.length === 0) {
        return;
    }
    
    var yDom = YAHOO.util.Dom;
    
    //��������ǯ���ޤ�ɽ�����Ƥ��뤫�����å�
    var first = holidays[0];
    var table = yDom.getElementsByClassName("y" + first.year, "table", this.place)[0];
    var tbody = yDom.getElementsByClassName("m" + first.month, "tbody", table)[0];
    if (!table || !tbody) {
        return;
    }

    //��������
    for (var i in holidays) {
        var h = holidays[i];
        var td = yDom.getElementsByClassName("d" + h.date, "td", tbody)[0];
        yDom.addClass(td, "holiday");
        td.title = h.title;     //�ޥ��������С��ǽ���̾��ɽ��
    }
};
/**
 *  ���������γ��򥯥�å����줿�饫���������Ĥ���
 */
YahhoCal.clickListener = function(clickedPoint) {
    var xy = YAHOO.util.Event.getXY(clickedPoint);
    var x = xy[0], y = xy[1];
    var r = YAHOO.util.Dom.getRegion(YahhoCal.cal.containerId);
    if (x < r.left || x > r.right || y < r.top || y > r.bottom) {
        YahhoCal.cal.hide();
    }
};
/**
 *  ɬ�פ�YUI��JavaScript��CSS���ɤ߹���
 *  @param  String  yuiBase (optional) YUI�Υ١����Ȥʤ�URL
 */
YahhoCal.loadYUI = function(yuiBase) {
    if (!yuiBase) {
        yuiBase = this.YUI_URL.SERVER + this.YUI_URL.VERSION + this.YUI_URL.DIR;
    }

    //YUI Loader��load
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = yuiBase + "yuiloader-dom-event/yuiloader-dom-event.js";
    document.getElementsByTagName("head")[0].appendChild(script);
    
    //YUI Loader��load�����ޤ��Ԥ�
    var limit = 5000, interval = 50, time = 0;
    var loadedId = setInterval(function(){
        if (window.YAHOO) {
            clearInterval(loadedId);
            //YUI Calendar��load
            (new YAHOO.util.YUILoader({ base: yuiBase, require: ["calendar"] })).insert();
        } else if ((time += interval) > limit) {    //�����ॢ����
            clearInterval(loadedId);
        }
    }, interval);
};
/**
 *  ���ν���������ˤ���
 */
YahhoCal.setMondayAs1st = function() {
    this.YUI_CAL_CONFIG[this.locale].start_weekday = 1;
};
/**
 *  �����ǽ�ʺǽ��������ꤹ��
 *  @param  integer y   ����4��
 *  @param  integer m   1��12��
 *  @param  integer d
 */
YahhoCal.setMinDate = function(y, m, d) {
    var date = m + "/" + d + "/" + y;
    if (this.cal) {
        this.cal.configMinDate(null, [date]);
    } else {
        this.YUI_CAL_CONFIG[this.locale].mindate = date;
    }
};
/**
 *  �����ǽ�ʺǸ��������ꤹ��
 *  @param  integer y   ����4��
 *  @param  integer m   1��12��
 *  @param  integer d
 */
YahhoCal.setMaxDate = function(y, m, d) {
    var date = m + "/" + d + "/" + y;
    if (this.cal) {
        this.cal.configMaxDate(null, [date]);
    } else {
        this.YUI_CAL_CONFIG[this.locale].maxdate = date;
    }
};
