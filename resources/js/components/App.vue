<template>
    <div>
        <slot>

        </slot>
    </div>
</template>

<script>
import User from "../apis/User";
import { mapState } from "vuex";

export default {
    name: "App",

    computed: {
        ...mapState({
            user: state => state.auth.user
        })
    },

    mounted() {
        User.auth().then((response) => {
            this.$store.commit('AUTH_USER', response.data);
            this.$store.commit('LOGIN', true);
        });
    }
}
</script>

<style scoped>

</style>
