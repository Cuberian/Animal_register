import Api from "./Api";

export default {
    storeCard(card) {
        return Api().post('/register/card/store',card)
    },
    editCard(cardId, newData) {
        return Api().post('/register/card/' + cardId, newData);
    },
    deleteCard(cardId) {
        return Api().delete('/register/card/' + cardId)
    }
}
