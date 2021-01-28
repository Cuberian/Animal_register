<template>
    <v-container class="d-flex" style="height: 100%;">
        <v-card elevation="2" style="padding: 20px; width:60%;" class="justify-content-center align-self-center mx-auto">
            <validation-observer
                ref="observer"
                v-slot="{ invalid }"
            >
                <form @submit.prevent="submit">
                    <validation-provider
                        v-slot="{ errors }"
                        name="Name"
                        rules="required"
                    >
                        <v-text-field
                            v-model="userObj.name"
                            :error-messages="errors"
                            label="Никнейм"
                            outlined
                            required
                        ></v-text-field>
                    </validation-provider>
                    <validation-provider
                        v-slot="{ errors }"
                        name="email"
                        rules="required|email"
                    >
                        <v-text-field
                            v-model="userObj.email"
                            :error-messages="errors"
                            label="E-mail"
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
                            label="Пароль"
                            required
                        ></v-text-field>
                    </validation-provider>
                    <v-btn
                        class="mr-4"
                        type="submit"
                        :disabled="invalid"
                    >
                        Зарегистрироваться
                    </v-btn>
                </form>
            </validation-observer>
        </v-card>
    </v-container>
</template>

<script>
export default {
    name: "Register",
    data() {
        return {
            userObj: {
                name: null,
                email: null,
                password: null,
            }
        }
    },
    methods: {
        submit() {
            axios.post('/api/user/register', this.userObj).then((response) => {
                window.localStorage.setItem('token', response.data.access_token);
                Swal.fire({
                    title: 'Успешно!',
                    text: 'Вы авторизировались',
                    icon: 'success',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = '/register';
                })
            });
        }
    }
}
</script>

<style scoped>

</style>
