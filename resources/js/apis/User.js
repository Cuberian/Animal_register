import Api from "./Api";

export default {
    auth() {
        return Api().get('/api/get_user');
    },
    logout() {
        return Api().post('/api/logout');
    }
}
