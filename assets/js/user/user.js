/*
*    beforeCreate - перед созданием
*   VueToastr2 - быстрые сообщения
* */
Vue.use(VueToastr2);

var URL = "/new/user";
var objApp = {
    action : 'update'
    ,request_url : URL
    ,responseData : {}
    ,user_id : 0
    ,data_user : {}
    ,office_id : 0
    ,select_office:{}
    ,select_position:{}
    ,select_departments:{}
    ,validation :
        {
            name            : {errors : []}
            ,surname        : {errors : []}
            ,patronymic     : {errors : []}
            ,email          : {errors : []}
            ,phone          : {errors : []}
            ,phone_mobile   : {errors : []}
        }

};

new Vue({
    el: '#app'
    , data: objApp
    //  Хук beforeCreate выполняется прямо во время инициализации компонента.
    //  Данные ещё не стали реактивными, а события не настроены.
    , beforeCreate: function ()
    {
        $.get({
            url: URL + '?action=getDataBeforeCreate'
            , method: "GET"
            , dataType: 'json'
            , async: false
            , success: function (res)
            {
                objApp.select_office        = res.data.select_office;
                objApp.select_position      = res.data.select_position;
                objApp.select_departments   = res.data.select_departments;

                Vue.prototype.$toastr.success(res.description, 'Внимание!');
            }
        });
    }
    //  В хуке created вы сможете получить доступ к реактивным данным и активным событиям.
    //  Шаблоны и виртуальный DOM ещё не встроены (mounted) и не отрисованы.
    , mounted: function (){}
    //  Методы исползуемые в экземпляре
    , methods: {

        getDataInterface(e) // Забираем даные
        {
            if (e.target.getAttribute('model_id'))
            {
                objApp.user_id = e.target.getAttribute('model_id');

                $.get({
                    url: this.request_url + '?action=view&user_id=' + this.user_id
                    , method: "GET"
                    , dataType: 'json'
                    , async: false
                    , success: function (res)
                    {
                        if (res.error)
                        {
                            Vue.prototype.$toastr.error(res.description, 'Ответ сервера!');
                        }
                        else
                        {
                            this.responseData       = res.data;

                            objApp.user_id          = this.responseData.user_id;
                            objApp.data_user        = this.responseData.user;
                            //objApp.data_user.image  = 'http://web.aanda.ru/img/users/' + this.responseData.user.user_id + 'a.png';
                            objApp.data_user.image  = this.responseData.user.image;
                            objApp.data_user.image_name  = '';

                        }
                    }
                });
            }
        }
        ,formSubmit(e)  // Отправим форму на обработку
        {
            this.setAction(this.data_user.user_id);

            $.get({
                url:        this.request_url + '?action=' + objApp.action
                , data:     this.data_user
                , dataType: 'json'
                , async:    false
                , success:  function (res)
                {
                    //console.log(res);

                    if (res.error)
                    {
                        Vue.prototype.$toastr.error(res.description, 'Ответ сервера!');
                    }
                    else
                    {
                        this.responseData       = res.data;

                        Vue.prototype.$toastr.success(JSON.stringify(this.responseData), 'Ответ!');
                    }
                }
            });
            e.preventDefault();
        }
        ,changeEvent(val)
        {
            Vue.prototype.$toastr.warning("Change selection event: You have selected => " + val, 'Внимание заглушка!');
        }
        ,getValue()
        {
            Vue.prototype.$toastr.warning("Current selected value is: " + this.currentItem, 'Внимание заглушка!');
        }
        ,viewFormNewUser()
        {
            objApp.data_user = {};
            objApp.action = 'create';
        }
        ,setAction(user_id)
        {
            if (user_id)
            {
                objApp.action = 'update';
            }
        }
    }
});
