/*
*      TODO ХУКИ created, mounted, updated и destroyed
*
* */
var objApp = {
    a: 1
    , boxExample: false
    , foo: '-'
    , posts: {}
    , title: ""
    , dataToTable: [0]
    , interval: null
    , count: 0
    , qurentCount: 0
    , intervalTime: 5000
    , remoteHost: 'http://web.aanda.ru/'
    , formattedDate: '00-00-0000'
    , formattedTime: '00:00:00'
};

new Vue({
    el: '#app'
    , data: objApp
    , created: function (){
        //  console.log('После создния экземпляра запускаем опрос разнесения');
        //  TODO запустили забор данных по интервалу
        this.interval = setInterval(() => {

            if (this.dataToTable.length) {
                //  Забираем данные
                $.get({
                    url: 'http://web.aanda.ru/reports/?mode=OrdersPlaced'
                    , dataType: 'json'
                    , async: false
                    , success: function (res) {
                        var resData = res.data;

                        for (var i in resData)
                        {
                            if (resData[i]['hotel_id'])
                            {
                                resData[i]['hotel_name'] = '<a href="/frame_h_info.htm?id=' + resData[i]['hotel_id'] + '" target="_blank">' + resData[i]['hotel_name'] + '</a>';
                                resData[i]['order_id'] = '<a href="/order.htm?id=' + resData[i]['order_id'] + '" target="_blank">' + resData[i]['order_id'] + '</a>';
                            }
                        }

                        objApp.title = res.header.title;
                        objApp.dataToTable = resData;
                        objApp.qurentCount = res.data.length;

                        $('#ReportTable').bootstrapTable('load', res.data);
                        /** начнёт работу тогда, когда будет готов DOM, за исключением картинок **/
                        $('[data-toggle="table"]').attr('class', '');
                        $('[data-toggle="table"]').attr('class','sort table table-responsive table-hover mt-3 mb-4 w-100 d-block d-md-table');
                    }
                });

                var myDate = new Date();
                var month = ('0' + (myDate.getMonth() + 1)).slice(-2);
                var date = ('0' + myDate.getDate()).slice(-2);
                var year = myDate.getFullYear();
                var hours = myDate.getHours();
                var min = myDate.getMinutes();
                var sec = ("0" + myDate.getSeconds()).slice(-2);
                var milisec = myDate.getMilliseconds();

                //  Обновим время обновления записей
                if (objApp.count != objApp.qurentCount)
                {
                    objApp.count = objApp.qurentCount;
                    this.formattedTime = hours + ':' + min + ':' + sec;
                }

            }
            else
            {
                clearInterval(this.interval);
            }
        }, this.intervalTime);
    }
    , methods: {
        showHide()
        {
            if (objApp.boxExample == false)
            {
                objApp.boxExample = true;
            }
            else
            {
                objApp.boxExample = false;
            }
        }
        ,timerDateStop()
        {
            this.interval = false;
        }
        ,timerDateStart()
        {
            this.interval = true;
        }
    }

});

