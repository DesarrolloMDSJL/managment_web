import Vue from 'vue';
import Vuex from 'vuex';
import Percentage from './modules/percentage/';
Vue.use(Vuex);
export default new Vuex.Store({
    modules :{
        Percentage
    }
});