/*
*      TODO ХУКИ created, mounted, updated и destroyed
*
* */
Vue.config.errorHandler = function(err, vm, info) {
    console.log(`Error: ${err.toString()}\nInfo: ${info}`);
}

Vue.directive('demo', function (el, binding) {
    console.log(binding.value.color) // => "white"
    console.log(binding.value.text)  // => "hello!"
})

///  <add-item></add-item>
Vue.component('add-item', {
    methods: {
        add()
        {

            //this.$emit('add', this.value);
            //this.value = '';
        }
    }
    , render(createElement) {
        var self = this;
        return createElement('div', [

            createElement('a', {
                attrs: {
                    class : "mr-2 text-info"
                    , 'data-toggle' : "modal"
                    , 'data-target' : "#UserEditModal"

                }

            }, "Open modal")
            ,createElement('button', {
                attrs: {
                    class : "mr-2 text-info"
                    , 'data-toggle' : "modal"
                    , 'data-target' : "#UserEditModal"

                }

            }, "Open modal")

        ])
    }
});


var objApp = {
    a: 1
    , boxExample: false
    , foo: '-'
    , posts: {}
    , title: ""
    , dataToTable: [0]
    , tableColumn: [0]
    , interval: null
    , count: 0
    , qurentCount: 0
    , intervalTime: 3500
    , remoteHost: 'http://web.aanda.ru/'
    , formattedDate: '00-00-0000'
    , formattedTime: '00:00:00'
    , columns: ""
    , select_user: 'А'
    , options_user: [
        { text: 'Один', value: 'А' },
        { text: 'Два', value: 'Б' },
        { text: 'Три', value: 'В' }
    ]
};

new Vue({
    el: '#app'
    , data: objApp
    , mounted: function () {
        //this.getUserList();

    }
    , created: function (){
        //  console.log('После создния экземпляра запускаем опрос разнесения');

    }
    , methods: {
        getUserList()
        {

        }
        ,showHide()
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

