var ComponentSelect = Vue.component('component-select', {
    template: `
        <select 
            id=""
            class="" 
            :id="customId"
            :class="customClass"
            :name="customName" 
            @input="$emit('input', $event.target.value)" 
            v-model="currentOption"
            @change="onSelectedEvent(currentOption)"
        >
            <option 
                v-for="item in optionItems" 
                :value="item.id" 
                :key="item.id" 
                :selected="defaultSelectedValue == item.id"
            >
            {{ item.text }}
            </option>
        </select>
	`
    ,props: {
        customId: String,
        customClass: String,
        customName: String,
        optionItems: Array,
        disableLabelText: Number,
        defaultLabelText: String,
        onSelectedEvent: Function,
        defaultSelectedValue: String
    }
    ,data(){
        return{
            currentOption: ""
        }
    }
    ,watch: {
        value: function(newValue){
            this.currentOption = newValue;
        }
    }
    ,mounted(){
        this.currentOption = this.defaultSelectedValue;
    }
});