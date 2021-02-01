<template>
    <div>
        <v-row class="mt-4 mb-4 ml-2">
            <v-btn
                v-if="isLoggedIn && getRole.change_access"
                rounded
                class="my-auto"
                color="success"
                @click="createCard()"
            >
                Создать карту
            </v-btn>
            <v-btn
                class="ml-3"
                fab
                dark
                small
                color="green"
                @click="updateRegister()"
            >
                <v-icon>mdi-cached</v-icon>
            </v-btn>
            <v-dialog
                v-model="sortDialog"
                persistent
                max-width="600px"
            >

                <template v-slot:activator="{ on: onDialog, attrs: attrsDialog }">
                    <v-btn
                        ref="sortButton"
                        class="ml-3"
                        fab
                        dark
                        small
                        v-bind="{...attrsDialog}"
                        v-on="{...onDialog}"
                        color="indigo"
                    >
                        <v-icon>mdi-call-split</v-icon>
                    </v-btn>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="headline">Отфильтровать записи</span>
                    </v-card-title>
                    <v-expansion-panels accordion>
                        <v-expansion-panel v-for="(sortParam, index) in sortParams" :key="`sort_param_${index}`">
                            <v-expansion-panel-header>{{ sortParam.name }}</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-radio-group v-model="sortParam.value">
                                    <v-radio
                                        :value="true"
                                        label="По возврастанию"
                                    ></v-radio>
                                    <v-radio
                                        :value="false"
                                        label="По убыванию"
                                    ></v-radio>
                                </v-radio-group>
                                <v-btn
                                    color="green darken-1"
                                    text
                                    @click="sortParam.value = null"
                                >
                                    Сбросить
                                </v-btn>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="sortDialog = false"
                        >
                            Закрыть
                        </v-btn>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="clearSortMenu()"
                        >
                            Сбросить выбор
                        </v-btn>
                        <v-btn
                            color="green darken-1"
                            text
                            :loading="sortLoading"
                            :disabled="sortLoading"
                            @click="sortRecords()"
                        >
                            Отсортировать
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog
                v-model="filterDialog"
                persistent
                max-width="600px"
            >

                <template v-slot:activator="{ on: onDialog, attrs: attrsDialog }">
                        <v-btn
                        class="ml-3"
                        fab
                        dark
                        small
                        v-bind="{...attrsDialog}"
                        v-on="{...onDialog}"
                        color="indigo"
                    >
                        <v-icon>mdi-dialpad</v-icon>
                    </v-btn>
                </template>
                <v-card>
                    <v-card-title>
                        <span class="headline">Отфильтровать записи</span>
                    </v-card-title>
                    <v-expansion-panels accordion>
                        <v-expansion-panel>
                            <v-expansion-panel-header>Пол</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-radio-group v-model="filterParams.gender">
                                    <v-radio
                                        :value="true"
                                        label="Женский"
                                    ></v-radio>
                                    <v-radio
                                        :value="false"
                                        label="Мужской"
                                    ></v-radio>
                                </v-radio-group>
                                <v-btn
                                    color="green darken-1"
                                    text
                                    @click="filterParams.gender = null"
                                >
                                    Сбросить
                                </v-btn>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-header>Характеристики животного</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                 <v-row>
                                     <v-col cols="4">
                                         <v-select
                                             :items="categories"
                                             v-model="filterParams.animal_traits.category"
                                             label="Категория"
                                             clearable
                                             outlined
                                         ></v-select>
                                     </v-col>
                                     <v-col cols="4">
                                         <v-select
                                             :items="sizes"
                                             v-model="filterParams.animal_traits.size"
                                             label="Размер"
                                             clearable
                                             outlined
                                         ></v-select>
                                     </v-col>
                                     <v-col cols="4">
                                         <v-select
                                             :items="wools"
                                             v-model="filterParams.animal_traits.wool"
                                             label="Шерсть"
                                             clearable
                                             outlined
                                         ></v-select>
                                     </v-col>
                                 </v-row>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-header>Черты владельца</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-combobox
                                    v-model="ownerTraitsSelect"
                                    :items="ownerTraits"
                                    @change="changeTraits()"
                                    label="Черты владельца"
                                    placeholder="Нет черт"
                                    clearable
                                    multiple
                                    outlined
                                ></v-combobox>
                                <v-checkbox
                                    v-model="checkNoTraits"
                                    label="Не фильтровать по параметру"
                                ></v-checkbox>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                        <v-expansion-panel>
                            <v-expansion-panel-header>Статус</v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-radio-group v-model="filterParams.current_status">
                                    <v-radio
                                        :value="true"
                                        label="В приюте"
                                    ></v-radio>
                                    <v-radio
                                        :value="false"
                                        label="Выбыл"
                                    ></v-radio>
                                </v-radio-group>
                                <v-btn
                                    color="green darken-1"
                                    text
                                    @click="filterParams.current_status = null"
                                >
                                    Сбросить
                                </v-btn>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="filterDialog = false"
                        >
                            Закрыть
                        </v-btn>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="clearFilterMenu()"
                            >
                            Сбросить фильтры
                        </v-btn>
                        <v-btn
                            color="green darken-1"
                            text
                            :loading="filterLoading"
                            :disabled="filterLoading"
                            @click="filteringRecords()"
                        >
                            Отфильтровать
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-btn
                class="ml-3"
                fab
                dark
                small
                color="green"
                @click="exportRegisterToExcel()"
            >
                    <v-img height="20px" width="20px" src="img/icons8-microsoft-excel.svg">

                    </v-img>
            </v-btn>
        </v-row>
    <div v-if="cardsArray.length > 0" class="grid-container justify-content-center mt-3">
        <v-card
            class="animal-card"
            outlined
            v-for="card in cardsArray" :key="card.id"
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
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                class="ml-2"
                                rounded
                                outlined
                                color="blue-grey lighten-3"
                                fab
                                small
                                v-bind="attrs"
                                v-on="on"
                                @click="publicCard(card.id)"
                            >
                                <v-icon>
                                    mdi-checkbox-marked-circle
                                </v-icon>
                            </v-btn>
                        </template>
                        <span>Опубликовать</span>
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
const FileDownload = require('js-file-download');
import usages from "../../mixins/usages";
import localization from "../../mixins/localization";
import selectTypes from "../../mixins/select-types";
import Swal from "sweetalert2";
import { mapGetters } from "vuex";
import LoginActions from "../../apis/LoginActions";


export default {
    name: "Register",
    mixins: [usages, selectTypes, localization],
    props: {
        cards: {
            type: Array,
            required: true
        },
    },
    data() {
        return {
            mdiDelete,
            cardsArray: null,
            ownerTraitsSelect: null,
            filterParams: {
              gender: null,
              animal_traits: {
                  category: null,
                  wool: null,
                  size: null,
              },
              owner_signs: null,
              current_status: null,
            },
            checkNoTraits: true,
            sortParams: {
              animal_name: {
                  value: null,
                  type: 'text',
                  name: 'Имя'
              },
              current_status: {
                  value: null,
                  type: 'bool',
                  name: 'Текущий статус'
              },
              chip_number: {
                  value: null,
                  type: 'number',
                  name: 'Номер чипа'
              },
              identify_mark: {
                  value: null,
                  type: 'number',
                  name: 'ID Марки'
              },
              sterilisation_date: {
                  value: null,
                  type: 'date',
                  name: 'Дата стерилизации'
              },
              vaccination_date: {
                  value: null,
                  type: 'date',
                  name: 'Дата вакцинации'
              },
              publicity_status: {
                  value: null,
                  type: 'bool',
                  name: 'Статус публикации'
              },
            },
            filterLoading: false,
            sortLoading: false,
            fab: false,
            sortDialog: false,
            filterDialog: false,
            reveal: false
        }
    },

    computed: {
        ...mapGetters(['isLoggedIn', 'getRole'])
    },

    created() {
        this.cardsArray = this.cards;
    },

    watch: {
        checkNoWatch(val) {
            if(val === true)
            {
                this.ownerTraitsSelect = [];
            }
        }
    },

    methods: {
        publicCard(id) {
            Swal.fire({
                title: 'Вы уверены?',
                text: "Текущая карта будет опубликована",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Да',
                cancelButtonText: 'Нет'
            }).then((result) => {
                if (result.isConfirmed) {
                    let update = () => this.updateRegister();

                    Swal.fire({
                        title: 'Проверяем лапки',
                        html: `<img src="/img/346.gif"/>`,
                        showConfirmButton: false,
                        didOpen: () => {
                            LoginActions.publicCard(id)
                                .then((response) => {
                                    if(response.status === 200)
                                    {
                                        Swal.close();
                                    }
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(
                                        `Ошибка редактирования: ${error}`
                                    )
                                })
                        },
                        allowOutsideClick: false
                    }).then(function () {
                        Swal.fire({
                            title: 'Опубликовано!',
                            text: 'Карта была опубликована',
                            icon: 'success',
                            allowOutsideClick: false
                        }).then(() => {
                            update();
                        })
                    })


                }
            })
        },

        changeTraits() {
            if(this.ownerTraitsSelect.count !== 0)
            {
                this.checkNoTraits = false;
            }
        },

        sortRecords() {
            axios.post('/register/sort', this.sortParams).then((response) => {
                this.sortLoading = false;
                if(response.status === 200)
                {
                    this.cardsArray = Object.values(response.data.cards);
                }

                this.sortDialog = false;
                this.clearSortMenu();
            })
        },

        filteringRecords() {
            this.filterLoading = true;
            if (this.ownerTraitsSelect != null && this.ownerTraitsSelect.length > 0) {
                this.filterParams.owner_signs = this.ownerTraitsSelect.map((el) => {
                    return el.value
                });
                this.filterParams.owner_signs = this.filterParams.owner_signs.join(", ");
            }
            else if(this.ownerTraitsSelect != null && this.ownerTraitsSelect.length === 0 && this.checkNoTraits === false)
                this.filterParams.owner_signs = 'Нет черт';
            else
                this.filterParams.owner_signs = null;


            axios.post('/register/filter', this.filterParams).then((response) =>
            {
                this.filterLoading = false;
                if(response.status === 200)
                {
                    this.cardsArray = response.data.cards;
                }

                this.filterDialog = false;
                this.clearFilterMenu();
            })
        },

        clearSortMenu() {
            for(let sortParam in this.sortParams) {
                this.sortParams[sortParam].value = null;
            }
        },

        clearFilterMenu() {
            this.filterParams = {
                gender: null,
                animal_traits: {
                    category: null,
                    wool: null,
                    size: null,
                },
                owner_signs: null,
                current_status: null,
            };
            this.ownerTraitsSelect = [];
            this.checkNoTraits = true;
        },

        updateRegister() {
            this.clearFilterMenu();
            axios.get('/register/update' + this.getToken()).then((response) => {
                if(response.status === 200)
                {
                    this.cardsArray = response.data.cards;
                }
            })
        },

        exportRegisterToExcel() {
            let registerArray = []
            let categoryDict = this.category;
            for(let card in this.cardsArray)
            {
                let genderString = this.cardsArray[card].gender ? 'женский' : 'мужской';
                registerArray.push(
                    [
                        this.cardsArray[card].animal_name,
                        categoryDict[this.cardsArray[card].animal_traits.category],
                        genderString,
                        this.cardsArray[card].date_birth,
                        this.cardsArray[card].vaccination_date,
                        this.cardsArray[card].sterilisation_date,
                        this.cardsArray[card].animal_signs,
                        this.cardsArray[card].owner_signs,
                        this.cardsArray[card].municipality,
                        this.cardsArray[card].place,
                        this.cardsArray[card].chip_number,
                        this.cardsArray[card].identify_mark
                    ]);
            }


            axios.post('https://localhost:44354/api/export/export_to_excel', registerArray,
                {
                    headers: {
                        'Access-Control-Allow-Headers': 'Accepts, Content-Type, Origin, X-My-Header',
                        'Access-Control-Allow-Methods': 'GET, PUT, POST, DELETE',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*',
                        'Access-Control-Allow-Credentials': 'false',
                        'Referrer-Policy': 'strict-origin-when-cross-origin'
                    },
                    responseType: 'blob'
                }).then((response) => {
                    FileDownload(response.data, 'register.xlsx');
            })
        },

        openCard(id) {
            window.location.href = '/register/card/show/' + id + this.getToken();
        },
        createCard() {
            window.location.href = '/register/card/create' + this.getToken();
        },
        editCard(id) {
            window.location.href = '/register/card/' + id + '/edit'+ this.getToken();
        },
        setAvatarImage(imageString, category) {
            if(imageString === null || imageString === '' ) {
               return category === 'cat' ? '/img/cat-default-avatar.jpg' : '/img/dog-default-avatar.jpg';
            }
            else
                return 'data:image/png;base64, ' + imageString;
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
                    let token = this.getToken();
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
                                        window.location.href = '/register' + token;
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
