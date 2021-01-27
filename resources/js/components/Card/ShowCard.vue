<template>
    <div>
        <v-container>
        <v-btn
            rounded
            color="success"
            class="mt-4 ml-2"
            @click="backToRegister()"
        >
            Вернуться к реестру
        </v-btn>
            <v-row class="mt-4">
                <v-col cols="3">
                    <div class="text-center" style="border: 1px solid #e0e0e0;padding:5px;border-radius: 5px;">
                        <v-avatar
                            class="profile"
                            color="grey"
                            size="100%"
                            max-height="250"
                            max-width="250"
                            tile
                        >
                            <v-img src="https://cdn.vuetifyjs.com/images/profiles/marcus.jpg"></v-img>
                        </v-avatar>
                    </div>
                </v-col>
                <v-col cols="9">
                    <v-row>
                        <v-col cols="8">
                            <h1 class="mb-0">{{ card.animal_name }}</h1>
                            <p class="text--subtitle">{{ card.animal_traits.category === 'cat' ? 'Кошка' : 'Собака' }} </p>
                        </v-col>
                        <v-col cols="2" class="text-end">
                            <v-btn
                                class="mx-2"
                                fab
                                dark
                                large
                                color="green"
                                @click="editCard(card.id)"
                            >
                                <v-icon dark>
                                    mdi-pencil
                                </v-icon>
                            </v-btn>
                        </v-col>
                        <v-col cols="2" class="text-start">
                            <v-btn
                                class="mx-2"
                                fab
                                dark
                                large
                                color="red"
                                @click="deleteCard(card.id)"
                            >
                                <v-icon dark>
                                    {{ mdiDelete }}
                                </v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="2">
                            <v-chip
                                class="text-center"
                                :color="!!card.current_status ? 'green' : 'red'"
                                text-color="white"
                                label
                                large
                            >
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title class="white--text">Статус</v-list-item-title>
                                        <v-list-item-subtitle class="white--text">
                                            {{ !!card.current_status ? 'В приюте' : 'Выбыл' }}
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-chip>
                        </v-col>
                        <v-col cols="4">
                            <v-chip
                                class="text-center"
                                color="grey"
                                text-color="white"
                                label
                                large
                            >
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title class="white--text">Дата изменения статуса</v-list-item-title>
                                        <v-list-item-subtitle class="white--text">{{ formatDate(card.change_status_date) }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-chip>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" class="mt-3">
                            <v-tabs
                                active-class="green--text"
                                show-arrows
                                v-model="tab">
                                <v-tabs-slider color="green"></v-tabs-slider>
                                <v-tab class="ml-0">Подробная информаия</v-tab>
                                <v-tab>Место содержания</v-tab>
                                <v-tab>Документы</v-tab>
                            </v-tabs>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="3">
                    <v-row>
                        <v-col cols="12">
                            <v-list-item two-line>
                                <v-list-item-content>
                                    <v-list-item-title>Пол</v-list-item-title>
                                    <v-list-item-subtitle>{{!!card.gender ? 'Женский' : 'Мужской'}}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-list-item two-line>
                                <v-list-item-content>
                                    <v-list-item-title>Дата рождения</v-list-item-title>
                                    <v-list-item-subtitle>{{ formatDate(card.date_birth) }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-list-item two-line>
                                <v-list-item-content>
                                    <v-list-item-title>Дата стерилизации</v-list-item-title>
                                    <v-list-item-subtitle>{{ formatDate(card.sterilisation_date) }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-list-item two-line>
                                <v-list-item-content>
                                    <v-list-item-title>Дата вакцинации</v-list-item-title>
                                    <v-list-item-subtitle>{{ formatDate(card.vaccination_date) }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="8">
                    <v-tabs-items v-model="tab">
                        <v-tab-item>
                            <v-card flat>
                                <v-row>
                                    <v-col cols="12">
                                        <v-list-item two-line>
                                            <v-list-item-content>
                                                <v-list-item-title>Черты владельца</v-list-item-title>
                                                <v-list-item-subtitle>{{ card.owner_signs }}</v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="4">
                                        <v-list-item two-line>
                                            <v-list-item-content>
                                                <v-list-item-title>Размер животного</v-list-item-title>
                                                <v-list-item-subtitle>
                                                    {{ size_type[card.animal_traits.size] ?
                                                    size_type[card.animal_traits.size] : card.animal_traits.size }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-col>

                                    <v-col cols="4">
                                        <v-list-item two-line>
                                            <v-list-item-content>
                                                <v-list-item-title>Тип шерсти</v-list-item-title>
                                                <v-list-item-subtitle>
                                                    {{ wool_type[card.animal_traits.wool] ?
                                                    wool_type[card.animal_traits.wool] : card.animal_traits.wool }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="4">
                                        <v-list-item two-line>
                                            <v-list-item-content>
                                                <v-list-item-title>ID Чипа</v-list-item-title>
                                                <v-list-item-subtitle>
                                                    {{ card.chip_number }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-col>

                                    <v-col cols="4">
                                        <v-list-item two-line>
                                            <v-list-item-content>
                                                <v-list-item-title>ID Метки</v-list-item-title>
                                                <v-list-item-subtitle>
                                                    {{ card.identify_mark }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card flat>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Адрес места содержания</v-list-item-title>
                                        <v-list-item-subtitle v->{{ card.place }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>

                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-list-item-title>Место содержания</v-list-item-title>
                                        <v-list-item-subtitle>{{ card.municipality }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card flat>
                                <v-card-text v-text="'тут доки'"></v-card-text>
                            </v-card>
                        </v-tab-item>
                    </v-tabs-items>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import {
    mdiDelete,
} from '@mdi/js'
import usages from '../../mixins/usages';
import localization from "../../mixins/localization";
import Swal from "sweetalert2";

export default {
    name: "Card",
    mixins: [usages, localization],
    props: {
        card: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            mdiDelete,
            tab: null
        }
    },
    mounted() {
        console.log(this.card);
    },
    methods: {
        editCard(id) {
            window.location.href = '/register/card/' + id + '/edit';
        },
        deleteCard(id) {

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
                    axios.delete('/register/card/' + id)
                        .then(function (response) {
                            if(response.status === 200) {

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
</script>

<style scoped>
.grid-container {
    max-width: 85%;
    height: 100%;
    padding: 0 10px 0 10px;
    display: grid;
    grid-template-columns: 25% 75%;
    grid-template-rows: 25% 75%;
    grid-column-gap: 20px;
    grid-row-gap: 20px;
}
.card-status__date {
    color: white !important;
}
.card-status {
    display: flex;
    width: 70%;
    flex-direction: row;
    justify-content: space-between;
}
</style>
