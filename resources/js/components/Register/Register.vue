<template>
    <div v-if="cards.length > 0" class="grid-container justify-content-center mt-3">
        <v-card
            class="animal-card"
            outlined
            v-for="card in cards" :key="card.card_id"
        >
            <v-list-item three-line>
                <v-list-item-content>
                    <div class="overline mb-4">
                        {{ card.animal_category === 'cat' ? 'кошка' : 'собака' }}
                    </div>
                    <v-list-item-title class="headline mb-1">
                        {{ card.animal_name }}
                    </v-list-item-title>
                    <v-list-item-subtitle>Дата рождения: {{ card.date_birth }}</v-list-item-subtitle>
                </v-list-item-content>

                <v-list-item-avatar
                    tile
                    size="80"
                    color="grey"
                >
                    <v-img :src="setAvatarImage(card.picture, card.animal_category)"></v-img>
                </v-list-item-avatar>
            </v-list-item>

            <v-card-actions>
                <v-btn
                    rounded
                    color="success"
                >
                    открыть
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
export default {
    name: "Register",
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
    },

    methods: {
        openCard(id) {
            axios.get('/register/card/' + id)
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

.animal-card {
}
</style>
