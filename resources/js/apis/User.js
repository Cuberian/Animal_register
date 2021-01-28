import Api from "./Api";

export default {
    auth() {
        return Api().get('/user');
    },
    logout() {

    }
}
