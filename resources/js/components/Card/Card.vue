<template>
    <div class="grid-container mt-10  mx-auto">
        <div>
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
            <hr>
            <div>
                <v-list-item two-line>
                    <v-list-item-content>
                        <v-list-item-title>Пол</v-list-item-title>
                        <v-list-item-subtitle>Мужской</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item two-line>
                    <v-list-item-content>
                        <v-list-item-title>Дата рождения</v-list-item-title>
                        <v-list-item-subtitle>17.10.2000</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </div>
        </div>
        <div>
            <div>
                <h3 class="mb-0">Pusheen</h3>
                <p class="text--subtitle">Кошка</p>
                <v-chip
                    class="mt-5"
                    color="green"
                    text-color="white"
                    label
                    large
                >
                    В приюте
                </v-chip>
            </div>
            <div></div>
        </div>
    </div>

</template>

<script>
export default {
    name: "Card",
    props: {
        card: {
            type: Object,
            required: true
        }
    }
}
</script>

<style scoped>
.grid-container {
    max-width: 85%;
    padding: 0 10px 0 10px;
    display: grid;
    grid-template-columns: 25% 60%;
    grid-column-gap: 20px;
}
</style>
