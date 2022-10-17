var GCalHolidays = {
    userId: "japanese__ja@holiday.calendar.google.com",                      //Google������
    //userId: "japanese@holiday.calendar.google.com",                        //�⤦1�Ĥ�ID
    //userId: "outid3el0qkcrsuf89fltf7a4qbacgt9@import.calendar.google.com", //mozilla.org��
    visibility: "public",
    projection: "full-noattendees",
    maxResults: 30,
    holidays: {}
};
/**
 *  �������������
 *  @param  Function    callback    �ǡ����������˸ƤӽФ����function
 *  @param  Number      year        (optional) ǯ�ʻ��ꤷ�ʤ���к�ǯ��
 *  @param  Number      month       (optional) ���1��12 ���ꤷ�ʤ����1ǯ�����ơ�
 */
GCalHolidays.get = function(callback, year, month) {
    //�����ϰ�
    var padZero = function(value) { return ("0" + value).slice(-2); };
    var y = year || new Date().getFullYear();
    var start = [y, padZero(month || 1), "01"].join("-");
    var m = month || 12;
    var end = [y, padZero(m), padZero(new Date(y, m, 0).getDate())].join("-");
    
    //�����Ѥߤξ��Ϥ����Ȥ�
    var cache = this.holidays[start + ".." + end];
    if (cache) {
        callback(cache);
        return;
    }

    this.userCallback = callback;
    
    //URL����
    var url = location.protocol + "//www.google.com/calendar/feeds/";
    url += this.userId + "/" + this.visibility + "/" + this.projection;
    url += "?alt=json-in-script&callback=GCalHolidays.decode";
    url += "&max-results=" + this.maxResults + "&start-min=" + start + "&start-max=" + end;

    //script��������
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = url;
    script.charset = "UTF-8";
    document.body.appendChild(script);
};
/**
 *  JSONP�ˤ��Google Calendar API����ƤӽФ����function
 *  @param  Object  gdata   ���������ǡ���
 */
GCalHolidays.decode = function(gdata) {
    var entries = gdata.feed.entry;
    var days = [];
    
    if (entries) {
        //���ս�˥�����
        entries.sort(function(a, b) {
            return (a.gd$when[0].startTime > b.gd$when[0].startTime) ? 1 : -1;
        });
        
        //����ץ�ʴ�˰ܤ�
        for (var i in entries) {
            var arr = entries[i].gd$when[0].startTime.split("-");
            for (var j in arr) {
                arr[j] *= 1;    //���ͤˤ���
            }
            days[i] = {year: arr[0], month: arr[1], date: arr[2], title: entries[i].title.$t};
        }
    }
    
    //�����ϰϤ����
    var feedParts = gdata.feed.link[3].href.split("&");
    var start = "", end = "";
    for (i in feedParts) {
        var params = feedParts[i].split("=");
        switch (params[0]) {
            case "start-min": start = params[1]; break;
            case "start-max": end = params[1]; break;
        }
    }
    
    this.holidays[start + ".." + end] = days;    //����å��夹��
    
    this.userCallback(days);    //������Хå�
};
