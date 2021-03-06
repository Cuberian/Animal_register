import Api from "./Api";

export default {
    storeCard(card) {
        return Api().post('/register/card/store',card)
    },
    editCard(cardId, newData) {
        return Api().put('/register/card/' + cardId, newData);
    },
    deleteCard(cardId) {
        return Api().delete('/register/card/' + cardId)
    },
    publicCard(cardId) {
        return Api().post('/register/card/public/' + cardId);
    },
    nonpublicCard(cardId) {
        return Api().post('/register/card/nonpublic/' + cardId);
    }
}
