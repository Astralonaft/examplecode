Vue.directive('input-validate', {

    bind: function (el, binding, vnode)
    {
        console.log('Directive: ' + binding.name + ' tag: ' + vnode.tag + ' attr.name: ' + el.getAttribute('name'));
        el.addEventListener("keyup", function (e) {
            model = e.target.name;
            placeholder = e.target.placeholder;
            required = e.target.required;
            value = e.target.value;
            if (required)
            {

                // Типы модели
                switch (model) {
                    //--------------------------------------------------------------
                    case "email":

                        re_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                        if (!re_email.test(value))
                        {
                            if (!objApp.validation[model]['errors'].length)
                                objApp.validation[model]['errors'].push('Не корректная эл.почта!');
                                e.target.classList.add('is-invalid');
                        }
                        else
                        {
                            objApp.validation[model]['errors'] = [];
                            e.target.classList.remove('is-invalid');
                        }
                        break;
                    //--------------------------------------------------------------
                    case "phone":

                        reg = /^(8|\+7)\(\d{3}\)\d{3}[\- ]\d{2}[\- ]\d{2}$/; // 0(000)000-00-00
                        if (!reg.test(value))
                        {
                            if (!objApp.validation[model]['errors'].length)
                                objApp.validation[model]['errors'].push('Формат 8|+7(000)000-00-00');
                                e.target.classList.add('is-invalid');
                        }
                        else
                        {
                            objApp.validation[model]['errors'] = [];
                            e.target.classList.remove('is-invalid');
                        }
                        break;
                    //--------------------------------------------------------------
                    case "phone_mobile":

                        reg = /^(8|\+7)\(\d{3}\)\d{3}[\- ]\d{2}[\- ]\d{2}$/; // 0(000)000-00-00
                        if (!reg.test(value))
                        {
                            if (!objApp.validation[model]['errors'].length)
                                objApp.validation[model]['errors'].push('Формат 8|+7(000)000-00-00');
                                e.target.classList.add('is-invalid');
                        }
                        else
                        {
                            objApp.validation[model]['errors'] = [];
                            e.target.classList.remove('is-invalid');
                        }
                        break;
                    //--------------------------------------------------------------
                    default:

                        if (!value.length)
                        {
                            if (!objApp.validation[model]['errors'].length)
                                objApp.validation[model]['errors'].push('Требуется указать ' + placeholder);
                                e.target.classList.add('is-invalid');
                                Vue.prototype.$toastr.warning('Требуется указать ' + placeholder, 'Внимание!');
                        }
                        else
                        {
                            objApp.validation[model]['errors'] = [];
                            e.target.classList.remove('is-invalid');
                        }
                }
            }

        });
    }

});