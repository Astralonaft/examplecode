/*
*      TODO ХУКИ created, mounted, updated и destroyed
*
* */
var objApp = {
    title: ""
    , dataToTable: [0]

};

new Vue({
    el: '#app'
    , data: objApp
    , mounted: function (){
        //  Забираем данные
        //this.getStaffList();

    }
    , methods: {
        getStaffList()
        {
            $.get({
                url: 'http://web.aanda.ru/reports/?mode=StaffList'
                , dataType: 'json'
                , async: false
                , success: function (res) {

                    console.log(res);

                    var resData = res.data;
                    objApp.title = res.header.title;
                    objApp.dataToTable = resData;

                    $('#StaffList').bootstrapTable({data:objApp.dataToTable});
                }
            });
        }
    }
});