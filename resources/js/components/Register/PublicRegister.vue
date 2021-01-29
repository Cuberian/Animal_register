<template>
    <div>
        <div v-if="cards.length > 0" class="grid-container justify-content-center mt-3">
            <v-card
                class="animal-card"
                outlined
                v-for="card in cards" :key="card.id"
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
                        @click="openCard(card.id)"
                    >
                        открыть
                    </v-btn>
                    <template v-if="isLoggedIn && getRole.change_access">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    class="ml-2"
                                    rounded
                                    outlined
                                    color="success"
                                    fab
                                    small
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="editCard(card.id)"
                                >
                                    <v-icon>
                                        mdi-pencil
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>Изменить данные</span>
                        </v-tooltip>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    class="ml-2"
                                    rounded
                                    outlined
                                    color="error"
                                    fab
                                    small
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="deleteCard(card.id)"
                                >
                                    <v-icon>
                                        {{ mdiDelete }}
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>Удалить</span>
                        </v-tooltip>
                    </template>
                </v-card-actions>
            </v-card>
        </div>
    </div>
</template>

<script>

import {
    mdiDelete,
} from '@mdi/js'

import usages from "../../mixins/usages";
import Swal from "sweetalert2";
import { mapGetters } from "vuex";
import LoginActions from "../../apis/LoginActions";


export default {
    name: "PublicRegister",
    mixins: [usages],
    props: {
        cards: {
            type: Array,
            required: true
        },
    },
    data() {
        return {
            mdiDelete,
            reveal: false
        }
    },

    computed: {
        ...mapGetters(['isLoggedIn','getRole'])
    },

    methods: {
        openCard(id) {
            window.location.href = '/register/card/show/' + id;
        },
        createCard() {
            window.location.href = '/register/card/create'+ this.getToken();
        },
        editCard(id) {
            window.location.href = '/register/card/' + id + '/edit'+ this.getToken();
        },
        setAvatarImage(imageString, category) {
            console.log(imageString)
            if(imageString === null || imageString === '' ) {
                return category === 'cat' ? '/img/cat-default-avatar.jpg' : '/img/dog-default-avatar.jpg';
            }
            else
                return imageString;
        },
        deleteCard(id) {
            if(this.isLoggedIn && this.getRole.change_access) {
                Swal.fire({
                    title: 'Вы уверены?',
                    text: "Текущая карта будет удалена",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                }).then((result) => {

                    if (result.isConfirmed) {
                        LoginActions.deleteCard(id)
                            .then(function (response) {
                                if (response.status === 200) {

                                    Swal.fire({
                                        title: 'Удалено!',
                                        text: 'Текущая карта удалена',
                                        icon: 'success',
                                        allowOutsideClick: false
                                    }).then(() => {
                                        window.location.href = '/register';
                                    })
                                }
                            })
                    }
                })
            }
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
