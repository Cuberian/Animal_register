<template>
        <v-app-bar
            fixed
            color="green"
            dark
        >
            <v-toolbar-title>Единый реестр животных</v-toolbar-title>

                <v-btn text class="ml-10 mt-1" href="/register">
                    Реестр
                </v-btn>

            <v-spacer></v-spacer>
            <v-btn icon>
                <v-avatar
                    tile
                    color="secondary"
                    size="40"
                >      <v-icon light>
                    mdi-face
                </v-icon></v-avatar>
            </v-btn>
        </v-app-bar>
</template>

<script>
import User from "../apis/User";
import { mapState } from "vuex";
export default {
    name: "Navbar",
    computed: {
        ...mapState({
            user: state => state.auth.user
        })
    },

    mounted() {
        User.auth().then((response) => {
                this.$store.commit('AUTH_USER', response.data)
        });
    },

    methods: {
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
