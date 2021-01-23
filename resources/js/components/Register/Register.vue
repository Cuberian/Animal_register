<template>
    <div>
    <v-btn
        rounded
        color="success"
        class="mt-4 ml-2"
        @click="createCard()"
    >
        Создать карту
    </v-btn>
    <div v-if="cards.length > 0" class="grid-container justify-content-center mt-3">
        <v-card
            class="animal-card"
            outlined
            v-for="card in cards" :key="card.card_id"
        >
            <v-list-item three-line>
                <v-list-item-content>
                    <div class="overline mb-4">
                        {{ card.animal_traits.category === 'cat' ? 'кошка' : 'собака' }}
                    </div>
                    <v-list-item-title class="headline mb-1">
                        {{ card.animal_name }}
                    </v-list-item-title>
                    <v-list-item-subtitle>Пол: {{ !!card.gender ? 'женский' : 'мужской' }}</v-list-item-subtitle>
                    <v-list-item-subtitle>Статус: <span :class="{'green-text': card.current_status, 'red-text': !card.current_status }">
                        {{ card.current_status ? 'в приюте' : 'выбыл' }}</span>
                    </v-list-item-subtitle>
                    <v-list-item-subtitle>Описание: {{ getDescription(card.animal_traits) }}</v-list-item-subtitle>
                </v-list-item-content>

                <v-list-item-avatar
                    tile
                    size="80"
                    color="grey"
                >
                    <v-img :src="setAvatarImage(card.picture, card.animal_traits.category)"></v-img>
                </v-list-item-avatar>
            </v-list-item>

            <v-card-actions>
                <v-btn
                    rounded
                    color="success"
                    @click="openCard(card.card_id)"
                >
                    открыть
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
    </div>
</template>

<script>
import usages from "../../mixins/usages";
export default {
    name: "Register",
    mixins: [usages],
    props: {
        cards: {
            type: Array,
            required: true
        },
    },
    data() {
        return {
            reveal: false
        }
    },
    mounted() {
        console.log(this.cards)
        console.log(this.cards[0].animalTraits)
    },

    methods: {
        openCard(id) {
            window.location.href = '/register/card/show/'+id;
        },
        createCard() {
            window.location.href = '/register/card/create';
        },
        setAvatarImage(imageString, category) {
            console.log(imageString)
            if(imageString !== null) {
               return category === 'cat' ? '/img/cat-default-avatar.jpg' : '/img/dog-default-avatar.jpg';
            }
            else
                return imageString;
        }
    }
}
</script>

<style scoped>

.grid-container {
    max-width: 100%;
    padding: 0 10px 0 10px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    grid-column-gap: 20px;
    grid-row-gap: 20px;
}
.green-text {
    color: #2fa360;
}
.red-text {
    color: #ae1c17;
}
</style>
