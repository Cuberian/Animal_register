<template>
    <div class="mt-10">
    <validation-observer
        ref="observer"
        v-slot="{ invalid }"
    >
        <form @submit.prevent="submit">
            <v-container>
                <h1 class="mb-10">Редактирование карточки №1</h1>
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
                                    v-model="name"
                                    :error-messages="errors"
                                    label="Кличка животного"
                                    outlined
                                    required
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
                                    v-model="genderSelect"
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
                                    v-model="statusSelect"
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
                                rules="required|email"
                            >
                                <v-text-field
                                    v-model="specialTraits"
                                    :error-messages="errors"
                                    label="Особые приметы"
                                    outlined
                                    required
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
                                max-height="95%"
                                max-width="95%"
                                class="mx-auto"
                                src="https://picsum.photos/id/11/500/300"
                            ></v-img>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <div class="mx-auto" style="max-width: 95%">
                            <v-file-input
                                label="Изображение"
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
                    <validation-provider
                        v-slot="{ errors }"
                        name="birthday"
                        rules="required"
                    >
                        <v-dialog
                            ref="birthdayDialog"
                            v-model="birthdayModal"
                            :return-value.sync="birthday"
                            persistent
                            width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="birthday"
                                    label="Дата рождения"
                                    prepend-icon=""
                                    outlined
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="birthday"
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
                                    @click="$refs.birthdayDialog.save(birthday)"
                                >
                                    OK
                                </v-btn>
                            </v-date-picker>
                        </v-dialog>
                    </validation-provider>
                </v-col>
                <v-col cols="4">
                    <validation-provider
                        v-slot="{ errors }"
                        name="sterilizationDate"
                        rules="required"
                    >
                        <v-dialog
                            ref="sterilizationDateDialog"
                            v-model="sterilizationDateModal"
                            :return-value.sync="sterilizationDate"
                            persistent
                            width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="sterilizationDate"
                                    label="Дата стерилизации"
                                    prepend-icon=""
                                    readonly
                                    outlined
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="sterilizationDate"
                                scrollable
                                :max="getNowDate()"
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
                                    @click="$refs.sterilizationDateDialog.save(sterilizationDate)"
                                >
                                    OK
                                </v-btn>
                            </v-date-picker>
                        </v-dialog>
                    </validation-provider>
                </v-col>
                <v-col cols="4">
                    <validation-provider
                        v-slot="{ errors }"
                        name="vaccinationDate"
                        rules="required"
                    >
                        <v-dialog
                            ref="vaccinationDateDialog"
                            v-model="vaccinationDateModal"
                            :return-value.sync="vaccinationDate"
                            persistent
                            width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="vaccinationDate"
                                    label="Дата вакцинации"
                                    prepend-icon=""
                                    outlined
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="vaccinationDate"
                                scrollable
                                :max="getNowDate()"
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
                                    @click="$refs.vaccinationDateDialog.save(vaccinationDate)"
                                >
                                    OK
                                </v-btn>
                            </v-date-picker>
                        </v-dialog>
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
                                v-model="municipal"
                                :error-messages="errors"
                                label="Муниципальное образование"
                                outlined
                                required
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
                                v-model="municipalAddress"
                                :error-messages="errors"
                                label="Адрес образования"
                                outlined
                                required
                            ></v-text-field>
                        </validation-provider>
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
                    <v-col cols="6">
                        <validation-provider
                            v-slot="{ errors }"
                            name="chipId"
                            rules="required|min_value:1"
                        >
                            <v-text-field
                                v-model="chipId"
                                :error-messages="errors"
                                label="ID Чипа"
                                type="number"
                                outlined
                                required
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
                                v-model="markId"
                                :error-messages="errors"
                                label="ID Метки"
                                type="number"
                                outlined
                                required
                            ></v-text-field>
                        </validation-provider>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-file-input
                            label="Акт возврата животного без владельцев в прежнее место обитания"
                            outlined
                        ></v-file-input>
                    </v-col>
                </v-row>
            <v-btn
                class="mr-4"
                type="submit"
                :disabled="invalid"
            >
                Сохранить изменения
            </v-btn>
            <v-btn @click="clear">
                Очистить форму
            </v-btn>
            </v-container>
        </form>
    </validation-observer>
    </div>
</template>

<script>

import { required, digits, email, max, regex, min_value } from 'vee-validate/dist/rules'
import { extend, setInteractionMode } from 'vee-validate'
import usages from "../../mixins/usages";

setInteractionMode('eager')

extend('digits', {
    ...digits,
    message: '{_field_} needs to be {length} digits. ({_value_})',
})

extend('required', {
    ...required,
    message: 'Данное поле должно быть заполнено',
})

extend('max', {
    ...max,
    message: '{_field_} may not be greater than {length} characters',
})

extend('regex', {
    ...regex,
    message: '{_field_} {_value_} does not match {regex}',
})

extend('email', {
    ...email,
    message: 'Email must be valid',
})

extend('min_value', {
    ...min_value,
    message: 'Значение поле не может быть меньше чем {min}',
})

export default {
    name: "EditCard.vue",
    mixins: [usages],
    props: {
        card: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            name: '',
            specialTraits: '',
            birthday: null,
            sterilizationDate: null,
            vaccinationDate: null,
            municipal:'',
            municipalAddress: '',
            chipId: null,
            markId: null,
            birthdayModal: false,
            sterilizationDateModal: false,
            vaccinationDateModal: false,
            genderSelect: null,
            statusSelect: null,
            ownerTraitsSelect: ['Ошейник', 'Шлейка'],
            ownerTraits: [
                'Ошейник',
                'Шлейка',
                'Одежда',
                'Чип',
            ],
            genders: [
                'Мужской',
                'Женский',
            ],
            statuses: [
                'В приюте',
                'Выбыл',
            ]
        }
    },
    methods: {
        submit () {
            this.$refs.observer.validate()
        },
        clear () {
            this.name = '';
            this.specialTraits = '';
            this.birthday= null;
            this.sterilizationDate = null;
            this.vaccinationDate = null;
            this.municipal = '';
            this.municipalAddress =  '';
            this.chipId = null;
            this.markId = null;
            this.genderSelect = null;
            this.statusSelect = null;
            this.ownerTraitsSelect = [];
            this.$refs.observer.reset()
        },
    },
}
</script>

<style scoped>
.card-form {
    height: 80%;
    width: 80%;
    margin-top: 20px;
}
</style>
