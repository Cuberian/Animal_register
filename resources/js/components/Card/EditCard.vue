<template>
    <div class="mt-10">
    <validation-observer
        ref="observer"
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
                                    v-model="card.animal_name"
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
                                    v-model="card.gender"
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
                                    v-model="card.current_status"
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
                                    v-model="card.animal_signs"
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
                            :return-value.sync="card.date_birth"
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
                                        v-model="card.date_birth"
                                        label="Дата рождения"
                                        prepend-icon=""
                                        outlined
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </validation-provider>
                            </template>
                            <v-date-picker
                                v-model="card.date_birth"
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
                                    @click="$refs.birthdayDialog.save(card.date_birth)"
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
                            :return-value.sync="card.sterilisation_date"
                            persistent
                            width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">

                                <validation-provider
                                    v-slot="{ errors }"
                                    name="sterilizationDate"
                                    :rules="{required: true, min_date: card.date_birth}"
                                >
                                    <v-text-field
                                        v-model="card.sterilisation_date"
                                        label="Дата стерилизации"
                                        prepend-icon=""
                                        readonly
                                        :error-messages="errors"
                                        outlined
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </validation-provider>

                            </template>
                            <v-date-picker
                                v-model="card.sterilisation_date"
                                scrollable
                                :max="getNowDate()"
                                :min="card.date_birth"
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
                                    @click="$refs.sterilizationDateDialog.save(card.sterilisation_date)"
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
                            :return-value.sync="card.vaccination_date"
                            persistent
                            width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <validation-provider
                                    v-slot="{ errors }"
                                    name="vaccinationDate"
                                    :rules="{required: true, min_date: card.date_birth}"
                                >
                                    <v-text-field
                                        v-model="card.vaccination_date"
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
                                v-model="card.vaccination_date"
                                scrollable
                                :max="getNowDate()"
                                :min="card.date_birth"
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
                                    @click="$refs.vaccinationDateDialog.save(card.vaccination_date)"
                                >
                                    OK
                                </v-btn>
                            </v-date-picker>
                        </v-dialog>
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
                                v-model="card.municipality"
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
                                v-model="card.place"
                                :error-messages="errors"
                                label="Адрес образования"
                                outlined
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
                                v-model="card.chip_number"
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
                                v-model="card.identify_mark"
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
                    @click="backToCard(card.id)"
                >
                    Вернуться к карте
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
import LoginActions from "../../apis/LoginActions";
import Swal from 'sweetalert2'
import {mapGetters} from "vuex";

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
            isDefaultAvatar: true,
            picture: null,
            pictureFile: null,
            scan_frame_name:null,
            scan_frame_file: null,
            scan_frame: null,
            birthdayModal: false,
            sterilizationDateModal: false,
            vaccinationDateModal: false,
            ownerTraitsSelect: null,
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
                this.isDefaultAvatar = true;
                return this.card.animal_traits.category === 'cat' ? '/img/cat-default-avatar.jpg' : '/img/dog-default-avatar.jpg'
            }
        }
    },
    created() {
        console.log(this.card);
        if(this.card.picture !== null) {
            this.picture = this.card.picture
            let image = new Image();
            image.name = 'avatar.png'
            image.src = `data:image/png;base64, ${this.picture}`;
            this.pictureFile = image;
            this.isDefaultAvatar = false;
        }

        if(this.card.scan_frame !== null) {
            this.scan_frame_name = this.card.scan_frame_name;
            this.scan_frame = this.card.scan_frame;
            this.scan_frame_file = this.convertBase64toBlob(this.scan_frame, 'application/msword');

        }
        if(this.card.owner_signs !== 'Нет черт')
            this.ownerTraitsSelect = this.card.owner_signs.split(', ').map((el) => {
                return {
                    value: el,
                    text: this.ownerTraits.find((trait) => {
                        if(trait.value === el)
                            return trait
                    })['text']
                }
            });

    },
    methods: {
        convertBase64toBlob(content, contentType = 'application/msword') {
            contentType = contentType || '';
            let sliceSize = 512;
            let byteCharacters = window.atob(content); //method which converts base64 to binary
            let byteArrays = [
            ];
            for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                let slice = byteCharacters.slice(offset, offset + sliceSize);
                let byteNumbers = new Array(slice.length);
                for (let i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }
                let byteArray = new Uint8Array(byteNumbers);
                byteArrays.push(byteArray);
            }
            let blob = new File(byteArrays, this.card.scan_frame_name, {
                type: contentType
            }) //statement which creates the blob
            return blob;
        },

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
                if (result) {
                    if (this.ownerTraitsSelect.length > 0) {
                        this.card.owner_signs = this.ownerTraitsSelect.map((el) => {
                            return el.value
                        });
                        this.card.owner_signs = this.card.owner_signs.join(", ");
                    } else
                        this.card.owner_signs = 'Нет черт';

                    if(this.picture !== this.card.picture && !this.isDefaultAvatar)
                        this.card.picture = this.picture;
                    if(this.scan_frame !== this.card.scan_frame) {
                        this.card.scan_frame = this.scan_frame;
                        this.card.scan_frame_name = this.scan_frame_name;
                    }

                    Swal.fire({
                        title: 'Вы уверены?',
                        text: "Все внесенные изменения будут сохранены",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Да',
                        cancelButtonText: 'Нет'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let cardId = this.card.id

                            Swal.fire({
                                title: 'Проверяем лапки',
                                html: `<img src="/img/346.gif"/>`,
                                showConfirmButton: false,
                                didOpen: () => {
                                    LoginActions.editCard(cardId, this.card)
                                        .then((response) => {
                                            if (response.status === 200) {
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
                                    title: 'Обновлено!',
                                    text: 'Значения карты были изменены',
                                    icon: 'success',
                                    allowOutsideClick: false
                                }).then(() => {
                                    window.location.href = '/register/card/show/' + cardId;
                                })
                            })


                        }
                    })
                }
            });
        },
        backToCard(id) {
            window.location.href = '/register/card/show/'+id + this.getToken();
        }
    },
}
</script>

<style scoped>
.swal2-popup {
    font-family: sans-serif;
}
</style>
