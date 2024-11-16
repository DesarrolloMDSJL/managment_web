import actions from "./percentage.actions"
import getters from "./percentage.getters"
import mutations from "./percentage.mutations"
const state = () => {
    return {
        loading : true,
        error : false,
        message : "hola prueba",
    }
}
export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
}