<template>
    <div class="mt-5">
        <validation-observer
            ref="observer"
            v-slot="{ invalid }"
        >
            <form @submit.prevent="submit">
                <v-container>
                    <h1 class="mb-5">Добавить карточку</h1>
                    <v-row>
                        <v-col cols="7">
                            <v-row>
                                <v-col>
                                    <validation-provider
                                        v-slot="{ errors }"
                                        name="Name"
                                        rules="required"
                                    >
                                        <v-text-field
                                            v-model="cardObj.animal_name"
                                            :error-messages="errors"
                                            label="Кличка животного"
                                            outlined
                                        ></v-text-field>
                                    </validation-provider>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <validation-provider
                                        v-slot="{ errors }"
                                        name="genderSelect"
                                        rules="required"
                                    >
                                        <v-select
                                            v-model="cardObj.gender"
                                            :items="genders"
                                            :error-messages="errors"
                                            label="Пол"
                                            outlined
                                            data-vv-name="genderSelect"
                                            required
                                        ></v-select>
                                    </validation-provider>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col>
                                    <validation-provider
                                        v-slot="{ errors }"
                                        name="statusSelect"
                                        rules="required"
                                    >
                                        <v-select
                                            v-model="cardObj.current_status"
                                            :items="statuses"
                                            :error-messages="errors"
                                            label="Статус"
                                            data-vv-name="statusSelect"
                                            outlined
                                            required
                                        ></v-select>
                                    </validation-provider>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <validation-provider
                                        v-slot="{ errors }"
                                        name="specialTraits"
                                        rules="required"
                                    >
                                        <v-text-field
                                            v-model="cardObj.animal_signs"
                                            :error-messages="errors"
                                            label="Особые приметы"
                                            outlined
                                        ></v-text-field>
                                    </validation-provider>
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="5" xl="4" offset-xl="1">
                            <div style="border: 1px solid rgba(0,0,0,.38); border-radius: 3px; padding: 9px;">
                                <v-row>
                                    <v-col>
                                        <v-img
                                            lazy-src="https://picsum.photos/id/11/10/6"
                                            height="300"
                                            width="300"
                                            class="mx-auto"
                                            :src="setAvatarImage"
                                        ></v-img>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col>
                                        <div class="mx-auto" style="max-width: 95%">
                                            <v-file-input
                                                label="Изображение"
                                                v-model="pictureFile"
                                                @change="convertImageToBase64String()"
                                                outlined
                                            ></v-file-input>
                                        </div>
                                    </v-col>
                                </v-row>
                            </div>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="4">

                                <v-dialog
                                    ref="birthdayDialog"
                                    v-model="birthdayModal"
                                    :return-value.sync="cardObj.date_birth"
                                    persistent
                                    width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <validation-provider
                                            v-slot="{ errors }"
                                            name="birthday"
                                            rules="required"
                                        >
                                            <v-text-field
                                                v-model="cardObj.date_birth"
                                                label="Дата рождения"
                                                prepend-icon=""
                                                outlined
                                                readonly
                                                :error-messages="errors"
                                                v-bind="attrs"
                                                v-on="on"
                                            ></v-text-field>
                                        </validation-provider>
                                    </template>
                                    <v-date-picker
                                        v-model="cardObj.date_birth"
                                        scrollable
                                        :max="getNowDate()"
                                        locale="ru"
                                    >
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="birthdayModal = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="$refs.birthdayDialog.save(cardObj.date_birth)"
                                        >
                                            OK
                                        </v-btn>
                                    </v-date-picker>
                                </v-dialog>
                        </v-col>
                        <v-col cols="4">
                                <v-dialog
                                    ref="sterilizationDateDialog"
                                    v-model="sterilizationDateModal"
                                    :return-value.sync="cardObj.sterilisation_date"
                                    persistent
                                    width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <validation-provider
                                            v-slot="{ errors }"
                                            name="sterilizationDate"
                                            :rules="{required: true, min_date: cardObj.date_birth}"
                                        >
                                            <v-text-field
                                                v-model="cardObj.sterilisation_date"
                                                label="Дата стерилизации"
                                                prepend-icon=""
                                                readonly
                                                outlined
                                                :error-messages="errors"
                                                v-bind="attrs"
                                                v-on="on"
                                            ></v-text-field>
                                        </validation-provider>
                                    </template>
                                    <v-date-picker
                                        v-model="cardObj.sterilisation_date"
                                        scrollable
                                        :max="getNowDate()"
                                        :min="cardObj.date_birth"
                                        locale="ru"
                                    >
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="sterilizationDateModal = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="$refs.sterilizationDateDialog.save(cardObj.sterilisation_date)"
                                        >
                                            OK
                                        </v-btn>
                                    </v-date-picker>
                                </v-dialog>
                        </v-col>
                        <v-col cols="4">
                                <v-dialog
                                    ref="vaccinationDateDialog"
                                    v-model="vaccinationDateModal"
                                    :return-value.sync="cardObj.vaccination_date"
                                    persistent
                                    width="290px"
                                >
                                    <template v-slot:activator="{ on, attrs}">
                                        <validation-provider
                                            v-slot="{ errors }"
                                            name="vaccinationDate"
                                            :rules="{required: true, min_date: cardObj.date_birth}"
                                        >
                                        <v-text-field
                                            v-model="cardObj.vaccination_date"
                                            label="Дата вакцинации"
                                            prepend-icon=""
                                            outlined
                                            readonly
                                            :error-messages="errors"
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                        </validation-provider>
                                    </template>
                                    <v-date-picker
                                        v-model="cardObj.vaccination_date"
                                        scrollable
                                        :max="getNowDate()"
                                        :min="cardObj.date_birth"
                                        locale="ru"
                                    >
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="vaccinationDateModal = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="$refs.vaccinationDateDialog.save(cardObj.vaccination_date)"
                                        >
                                            OK
                                        </v-btn>
                                    </v-date-picker>
                                </v-dialog>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-combobox
                                v-model="ownerTraitsSelect"
                                :items="ownerTraits"
                                label="Черты владельца"
                                placeholder="Нет черт"
                                clearable
                                multiple
                                outlined
                            ></v-combobox>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="3">
                            <validation-provider
                                v-slot="{ errors }"
                                name="categorySelect"
                                rules="required"
                            >
                                <v-select
                                    v-model="cardObj.animal_traits.category"
                                    :items="categories"
                                    :error-messages="errors"
                                    label="Вид"
                                    outlined
                                    data-vv-name="categorySelect"
                                    required
                                ></v-select>
                            </validation-provider>
                        </v-col>
                        <v-col cols="3">
                            <validation-provider
                                v-slot="{ errors }"
                                name="sizeSelect"
                                rules="required"
                            >
                                <v-select
                                    v-model="cardObj.animal_traits.size"
                                    :items="sizes"
                                    :error-messages="errors"
                                    label="Размер"
                                    outlined
                                    data-vv-name="sizeSelect"
                                    required
                                ></v-select>
                            </validation-provider>
                        </v-col>
                        <v-col cols="6">
                            <validation-provider
                                v-slot="{ errors }"
                                name="woolSelect"
                                rules="required"
                            >
                                <v-select
                                    v-model="cardObj.animal_traits.wool"
                                    :items="wools"
                                    :error-messages="errors"
                                    label="Шерсть"
                                    outlined
                                    data-vv-name="woolSelect"
                                    required
                                ></v-select>
                            </validation-provider>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col col="6">
                            <validation-provider
                                v-slot="{ errors }"
                                name="municipal"
                                rules="required"
                            >
                                <v-text-field
                                    v-model="cardObj.municipality"
                                    :error-messages="errors"
                                    label="Муниципальное образование"
                                    outlined
                                ></v-text-field>
                            </validation-provider>
                        </v-col>
                        <v-col col="6">
                            <validation-provider
                                v-slot="{ errors }"
                                name="municipalAddress"
                                rules="required"
                            >
                                <v-text-field
                                    v-model="cardObj.place"
                                    :error-messages="errors"
                                    label="Адрес образования"
                                    outlined
                                ></v-text-field>
                            </validation-provider>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <validation-provider
                                v-slot="{ errors }"
                                name="chipId"
                                rules="required|min_value:1"
                            >
                                <v-text-field
                                    v-model="cardObj.chip_number"
                                    :error-messages="errors"
                                    label="ID Чипа"
                                    type="number"
                                    outlined
                                ></v-text-field>
                            </validation-provider>
                        </v-col>
                        <v-col cols="6">
                            <validation-provider
                                v-slot="{ errors }"
                                name="markId"
                                rules="required|min_value:1"
                            >
                                <v-text-field
                                    v-model="cardObj.identify_mark"
                                    :error-messages="errors"
                                    label="ID Метки"
                                    type="number"
                                    outlined
                                ></v-text-field>
                            </validation-provider>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-file-input
                                label="Акт возврата животного без владельцев в прежнее место обитания"
                                v-model="scan_frame_file"
                                @change="convertDocToBase64String()"
                                outlined
                            ></v-file-input>
                        </v-col>
                    </v-row>
                    <v-btn
                        class="mr-4"
                        @click="backToRegister()"
                    >
                        Вернуться к реестру
                    </v-btn>
                    <v-btn
                        type="submit"
                    >
                        Сохранить изменения
                    </v-btn>
                </v-container>
            </form>
        </validation-observer>
    </div>
</template>

<script>
import usages from "../../mixins/usages";
import { mapGetters } from "vuex";
import Swal from 'sweetalert2'
import LoginActions from "../../apis/LoginActions";

export default {
    name: "AddCard.vue",
    mixins: [usages],
    data() {
        return {
            cardObj: {
                animal_name: '',
                animal_signs: '',
                date_birth: null,
                sterilisation_date: null,
                vaccination_date: null,
                municipality:'',
                place: '',
                chip_number: null,
                identify_mark: null,
                gender: null,
                current_status: null,
                animal_traits: {
                    wool: 'short_wool',
                    category: 'cat',
                    size: 'medium',
                },
                publicity_status: false
            },
            isDefaultAvatar: false,
            pictureFile: null,
            picture: null,
            scan_frame_name:null,
            scan_frame_file: null,
            scan_frame: null,
            ownerTraitsSelect: null,
            birthdayModal: false,
            sterilizationDateModal: false,
            vaccinationDateModal: false,
            categories: [
                {
                    value: 'cat',
                    text: 'Кошка'
                },
                {
                    value: 'dog',
                    text: 'Собака'
                }
            ],
            sizes: [
                {
                    value: 'small',
                    text: 'Маленький'
                },
                {
                    value: 'medium',
                    text: 'Средний'
                },
                {
                    value: 'big',
                    text: 'Большой'
                }
            ],
            wools: [
                {
                    value: 'short_wool',
                    text: 'Короткая шерсть'
                },
                {
                    value: 'long_wool',
                    text: 'Длинная шерсть'
                },
                {
                    value: 'hard_wool',
                    text: 'Жесткая шерсть'
                },
                {
                    value: 'curly_wool',
                    text: 'Кудрявая шерсть'
                }
            ],
            ownerTraits: [
                {
                    value: 'ошейник',
                    text: 'Ошейник'
                },
                {
                    value: 'шлейка',
                    text: 'Шлейка'
                },
                {
                    value: 'одежда',
                    text: 'Одежда'
                },
                {
                    value: 'чип',
                    text: 'Чип'
                }
            ],
            genders: [
                {
                    value: true,
                    text: 'Женский'
                },
                {
                    value: false,
                    text: 'Мужской'
                }
            ],
            statuses: [
                {
                    value: true,
                    text: 'В приюте'
                },
                {
                    value: false,
                    text: 'Выбыл'
                }
            ]
        }
    },
    computed: {
        ...mapGetters(['isLoggedIn', 'getRole']),
        setAvatarImage() {
            if(this.picture !== null && this.picture.trim() !== '')
            {
                this.isDefaultAvatar = false;
                return 'data:image/png;base64, ' + this.picture;
            }
            else {
                this.isDefaultAvatar =  true;
                return this.cardObj.animal_traits.category === 'cat' ? '/img/cat-default-avatar.jpg' : '/img/dog-default-avatar.jpg'
            }
        }
    },
    methods: {
        convertImageToBase64String() {
            // get a reference to the file
            const file = this.pictureFile;
            if(!file)
            {
                this.picture = null;
            }
            else {
                // encode the file using the FileReader API
                const reader = new FileReader();
                reader.onloadend = () => {

                    // use a regex to remove data url part
                    const base64String = reader.result
                        .replace('data:', '')
                        .replace(/^.+,/, '');

                    // log to console
                    // logs wL2dvYWwgbW9yZ...
                    this.picture = base64String;
                    console.log(base64String);
                };
                reader.readAsDataURL(file);
            }
        },

        convertDocToBase64String() {
            // get a reference to the file
            console.log(this.scan_frame_file)
            const doc = this.scan_frame_file;
            if(!doc)
            {
                this.scan_frame = null;
                this.scan_frame_name = null;
            }
            else {

                this.scan_frame_name = doc.name;
                // encode the file using the FileReader API
                const reader = new FileReader();
                reader.onloadend = () => {

                    // use a regex to remove data url part
                    const base64String = reader.result
                        .replace('data:', '')
                        .replace(/^.+,/, '');

                    // log to console
                    // logs wL2dvYWwgbW9yZ...
                    this.scan_frame = base64String;
                    console.log(base64String);
                };
                reader.readAsDataURL(doc);
            }
        },

        submit () {
            console.log(this.$refs.observer.validate())
            this.$refs.observer.validate().then((result) => {
                if(result) {
                    if( this.ownerTraitsSelect !== null && this.ownerTraitsSelect.length > 0)
                        this.cardObj.owner_signs = this.ownerTraitsSelect.map((el) => el.value).join(", ");
                    else
                        this.card.owner_signs = 'Нет черт';

                    if(this.picture !== null && !this.isDefaultAvatar)
                        this.cardObj.picture = this.picture;

                    if(this.scan_frame !== null) {
                        this.cardObj.scan_frame = this.scan_frame
                        this.cardObj.scan_frame_name = this.scan_frame_name
                    }


                    this.cardObj.change_status_date = this.getNowDate();


                    Swal.fire({
                        title: 'Вы уверены?',
                        text: "Будет соэдана новая карта животного",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Да',
                        cancelButtonText: 'Нет'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let resObj = null

                            Swal.fire({
                                title: 'Проверяем лапки',
                                html: `<img src="/img/346.gif"/>`,
                                showConfirmButton: false,
                                didOpen: () => {
                                    LoginActions.storeCard(this.cardObj)
                                        .then((response) => {
                                            if (response.status === 200) {
                                                resObj = response.data;
                                                Swal.close();
                                            }
                                        })
                                        .catch(error => {
                                            Swal.showValidationMessage(
                                                `Ошибка добавления: ${error}`
                                            )
                                        })
                                },
                                allowOutsideClick: false
                            }).then(function () {
                                Swal.fire({
                                    title: 'Создано!',
                                    text: 'Создана новая карта',
                                    icon: 'success',
                                    allowOutsideClick: false
                                }).then(() => {
                                    window.location.href = '/register/card/show/'+resObj.id;
                                })
                            })


                        }
                    })
                }
            });
        }
    },
}
</script>

<style scoped>
.swal2-popup {
    font-family: sans-serif;
}
</style>
