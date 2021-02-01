<template>
    <v-container class="d-flex" style="height: 100%;">
        <v-card elevation="2" style="padding: 20px; width:60%;" class="justify-content-center align-self-center mx-auto">
            <h1 class="text-center mb-4">Вход</h1>
            <validation-observer
                ref="observer"
                v-slot="{ invalid }"
            >
                <form @submit.prevent="submit">
                    <validation-provider
                        v-slot="{ errors }"
                        name="email"
                        rules="required|email"
                    >
                        <v-text-field
                            v-model="userObj.email"
                            :error-messages="errors"
                            label="E-mail"
                            outlined
                            required
                        ></v-text-field>
                    </validation-provider>
                    <validation-provider
                        v-slot="{ errors }"
                        name="password"
                        rules="required"
                    >
                        <v-text-field
                            v-model="userObj.password"
                            :error-messages="errors"
                            outlined
                            label="Пароль"
                            required
                        ></v-text-field>
                    </validation-provider>
                    <v-btn
                        class="mr-4"
                        type="submit"
                        :disabled="invalid"
                    >
                       Войти
                    </v-btn>
                </form>
            </validation-observer>
        </v-card>
    </v-container>
</template>

<script>
import Swal from "sweetalert2";

export default {
    name: "Login",
    data() {
        return {
            userObj: {
                email: null,
                password: null,
            }
        }
    },
    methods: {
        submit() {
            Swal.fire({
                title: 'Проверяем лапки',
                html: `<img src="/img/346.gif"/>`,
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    console.log( this.userObj);
                    return axios.post('/api/user/login', this.userObj)
                        .then((response) => {
                            window.localStorage.setItem('token', response.data);
                            document.cookie=`access_token=[${response.data}]`;
                            this.$store.commit('LOGIN', true);
                            Swal.close();
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Ошибка авторизации: ${error}`
                            )
                        })
                },
            }).then(() => {
                Swal.fire({
                    title: 'Успешно!',
                    text: 'Вы авторизировались',
                    icon: 'success',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = '/register';
                })
            })
        }
    }
}
</script>

<style scoped>

</style>
