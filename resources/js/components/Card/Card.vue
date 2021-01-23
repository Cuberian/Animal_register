<template>
    <div class="grid-container mt-10  mx-auto">
            <div class="text-center">
                <v-avatar
                class="profile"
                color="grey"
                size="250"
                tile
            >
                <v-img src="https://cdn.vuetifyjs.com/images/profiles/marcus.jpg"></v-img>
            </v-avatar>
            </div>
        <div style="position: relative">
            <h1 class="mb-0">{{ card.animal_name }}</h1>
            <p class="text--subtitle">{{ card.animal_traits.category === 'cat' ? 'Кошка' : 'Собака' }} </p>
            <div style="display: flex;" class="card-status">
                <v-chip
                    class="mt-5  text-center"
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
                <v-chip
                    class="mt-5 text-center"
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
            </div>
            <v-tabs
                active-class="green--text"
                style="position: absolute; bottom: 0"
                v-model="tab"
                align-with-title>
                <v-tabs-slider color="green"></v-tabs-slider>
                <v-tab class="ml-0">Подробная информаия</v-tab>
                <v-tab>Место содержания</v-tab>
                <v-tab>Документы</v-tab>
            </v-tabs>
        </div>
            <div>
                <v-list-item two-line>
                    <v-list-item-content>
                        <v-list-item-title>Пол</v-list-item-title>
                        <v-list-item-subtitle>{{!!card.gender ? 'Женский' : 'Мужской'}}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item two-line>
                    <v-list-item-content>
                        <v-list-item-title>Дата рождения</v-list-item-title>
                        <v-list-item-subtitle>{{ formatDate(card.date_birth) }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item two-line>
                    <v-list-item-content>
                        <v-list-item-title>Дата стерилизации</v-list-item-title>
                        <v-list-item-subtitle>{{ formatDate(card.sterilisation_date) }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item two-line>
                    <v-list-item-content>
                        <v-list-item-title>Дата вакцинации</v-list-item-title>
                        <v-list-item-subtitle>{{ formatDate(card.vaccination_date) }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </div>
            <div>
                <v-tabs-items v-model="tab">
                    <v-tab-item>
                        <v-card flat>
                            <v-list-item two-line>
                                <v-list-item-content>
                                    <v-list-item-title>Черты владельца</v-list-item-title>
                                    <v-list-item-subtitle>{{ card.owner_signs }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-row>
                                <v-col cols="5">
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

                                <v-col cols="5">
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
                                <v-col cols="5">
                                    <v-list-item two-line>
                                        <v-list-item-content>
                                            <v-list-item-title>ID Чипа</v-list-item-title>
                                            <v-list-item-subtitle>
                                                {{ card.chip_number }}
                                            </v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-col>

                                <v-col cols="5">
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
            </div>
    </div>
</template>

<script>
import usages from '../../mixins/usages';
import localization from "../../mixins/localization";
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
            tab: null
        }
    },
    mounted() {
        console.log(this.card);
    },
    methods: {

    }
}
</script>

<style scoped>
.grid-container {
    max-width: 85%;
    height: 100%;
    padding: 0 10px 0 10px;
    display: grid;
    grid-template-columns: 250px 60%;
    grid-template-rows: 39% 61%;
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
