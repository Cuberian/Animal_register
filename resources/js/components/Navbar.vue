<template>
        <v-app-bar
            fixed
            color="green"
            dark
        >
            <v-toolbar-title>Единый реестр животных</v-toolbar-title>

                <v-btn text class="ml-10 mt-1" @click="goToRegister()" v-if="isLoggedIn">
                    Реестр
                </v-btn>
            <v-btn text class="ml-10 mt-1" href="/register/public">
                Публичный реестр
            </v-btn>

            <v-spacer></v-spacer>
            <v-btn icon v-if="isLoggedIn">
                <v-avatar
                    tile
                    color="secondary"
                    size="40"
                >      <v-icon light>
                    mdi-face
                </v-icon></v-avatar>
            </v-btn>

            <v-btn text href="/auth/login" v-if="!isLoggedIn">
                Войти
            </v-btn>

            <v-btn text class="ml-2" href="/auth/register" v-if="!isLoggedIn">
                Зарегистрироваться
            </v-btn>
        </v-app-bar>
</template>

<script>
import User from "../apis/User";
import usages from "../mixins/usages";
import { mapGetters } from "vuex";
export default {
    name: "Navbar",
    mixins: [usages],
    computed: {
        ...mapGetters(['isLoggedIn'])
    },

    methods: {
        goToRegister() {
          if(this.isLoggedIn) {
              window.location.href = '/register' + this.getToken();
          }
        },
        logout() {
            User.logout().then(() => {
                localStorage.removeItem('token');
                this.$store.commit('LOGIN', false);
            })
        }
    }
}
</script>

<style scoped>

</style>
